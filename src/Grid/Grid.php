<?php

namespace Motor\Backend\Grid;

use Illuminate\Support\Collection;
use Motor\Core\Filter\Filter;
use Motor\Core\Filter\Renderers\PerPageRenderer;
use Auth;

/**
 * Class Grid
 * @package Motor\Backend\Grid
 */
class Grid extends Base
{

    protected $model;

    protected $searchTerm = '';

    protected $clientFilter = false;

    protected $columns = [];

    protected $rows = [];

    protected $rowClosures = [];

    protected $sortableFields = [];

    protected $sorting = [ 'id', 'ASC' ];

    protected $actions = [];

    protected $specialRows = [];

    protected $filter;

    protected $paginator = null;


    /**
     * Grid constructor.
     *
     * @param $model
     */
    public function __construct($model)
    {
        $this->model        = $model;
        $this->searchTerm   = request('search');
        $this->clientFilter = request('client_id');

        if (request('sortable_field') && request('sortable_direction')) {
            $this->setSorting(request('sortable_field'), request('sortable_direction'));
        }

        $this->filter = new Filter($this);

        $this->setup();
    }


    /**
     * Stub method. Implemented in the child classes
     */
    protected function setup()
    {
    }


    /**
     * @return Filter
     */
    public function getFilter()
    {
        return $this->filter;
    }


    /**
     * @param $filter
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }


    /**
     * @param      $name
     * @param null $label
     * @param bool $sortable
     *
     * @return Column
     */
    public function addColumn($name, $label = null, $sortable = false, $sortableField = null)
    {
        $column                            = new Column($name, $label, $sortable, $sortableField);
        $this->columns[$column->getName()] = $column;

        if ($sortable) {
            $this->sortableFields[] = $column->getSortableField();
        }

        return $column;
    }


    /**
     * @param $view
     * @return SpecialRow
     */
    public function addSpecialRow($view)
    {
        $specialRow          = new SpecialRow($view);
        $this->specialRows[] = $specialRow;

        return $specialRow;
    }


    /**
     * @return array
     */
    public function getSpecialRows()
    {
        return $this->specialRows;
    }


    /**
     * @param       $label
     * @param       $link
     * @param       $action
     * @param array $parameters
     * @return Action
     */
    public function addFormAction($label, $link, $action, $parameters = [])
    {
        return $this->addAction($label, $link, array_merge($parameters, [ 'type' => 'form', 'action' => $action ]));
    }


    /**
     * @param       $label
     * @param       $link
     * @param array $parameters
     * @return Action
     */
    public function addEditAction($label, $link, $parameters = [])
    {
        return $this->addAction($label, $link, array_merge($parameters, [ 'type' => 'edit' ]));
    }


    /**
     * @param       $label
     * @param       $link
     * @param array $parameters
     * @return Action
     */
    public function addDuplicateAction($label, $link, $parameters = [])
    {
        return $this->addAction($label, $link, array_merge($parameters, [ 'type' => 'duplicate' ]));
    }


    /**
     * @param       $label
     * @param       $link
     * @param array $parameters
     * @return Action
     */
    public function addDeleteAction($label, $link, $parameters = [])
    {
        return $this->addAction($label, $link, array_merge($parameters, [ 'type' => 'delete' ]));
    }


    /**
     * @param       $label
     * @param       $link
     * @param array $parameters
     * @return Action
     */
    public function addAction($label, $link, $parameters = [])
    {
        $action          = new Action($label, $link, $parameters);
        $this->actions[] = $action;

        // Once the first action is added, we need to add the action column
        $this->addColumn('special:actions', trans('motor-backend::backend/global.actions'))->style('text-align: right');

        return $action;
    }


    /**
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }


    /**
     * Get all columns
     *
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }


    /**
     * Query database and parse all rows and cells
     *
     * @return array
     */
    public function getRows()
    {
        foreach ($this->getPaginator() as $record) {

            $row = new Row($record);

            foreach ($this->getColumns() as $column) {

                $cell     = new Cell($column->getName(), $column->getRenderer(), $column->getRenderOptions());
                $sanitize = ( count($column->getFilters()) || $column->hasCellClosure() ) ? false : true;
                $value    = $this->getCellValue($cell, $column, $record, $sanitize);
                $cell->setValue($value);
                $cell->setRecord($record); // we might need it for some renderers
                $cell->setColumn($column); // we might need it for some renderers
                $cell->parseFilters($column->getFilters());
                if ($column->hasCellClosure()) {
                    $closure = $column->getCellClosure();
                    $cell->setValue($closure($cell->getValue(), $record));
                }
                $row->addCell($cell);
            }

            if ($this->hasRowClosures()) {
                foreach ($this->getRowClosures() as $closure) {
                    $closure($row);
                }
            }
            $this->rows[] = $row;
        }

        return $this->rows;
    }


    /**
     * Check if row closures are set
     *
     * @return bool
     */
    public function hasRowClosures()
    {
        if (count($this->rowClosures) > 0) {
            return true;
        }

        return false;
    }


    /**
     * Get row closures
     *
     * @return array
     */
    public function getRowClosures()
    {
        return $this->rowClosures;
    }


    /**
     * Set row closure
     *
     * @param \Closure $closure
     *
     * @return $this
     */
    public function row(\Closure $closure)
    {
        $this->rowClosures[] = $closure;

        return $this;
    }


    /**
     * Cell renderer, should maybe be outsourced in a 'render' class as we'll have separate renderers later (probably
     * ;))
     *
     * @param      $column
     * @param      $record
     * @param bool $sanitize
     *
     * @return mixed|string
     */
    protected function getCellValue(Cell $cell, Column $column, $record, $sanitize = true)
    {
        // Eloquent relation with dot notation
        if (preg_match('#^[a-z0-9_-]+(?:\.[a-z0-9_-]+)+$#i', $column->getName(), $matches) && is_object($record)) {
            $temporaryRecord = $record;
            $value           = '';
            $segments        = explode('.', $column->getName());
            foreach ($segments as $key => $segment) {
                try {
                    if ( ! is_null($temporaryRecord->{$segment})) {
                        if ($key == count($segments) - 1) {
                            $value = $temporaryRecord->{$segment};
                        }
                    }
                    $temporaryRecord = $temporaryRecord->{$segment};
                    //if (isset($temporaryRecord->{$segment})) {
                    //}
                } catch (\Exception $exception) {
                }
            }
        } elseif ($record->{$column->getName()} instanceof Collection) {
            $value = $record->{$column->getName()}->toArray();
        } elseif (is_object($record)) {
            // Eloquent fieldname
            if (isset($record->{$column->getName()})) {
                $value = $record->{$column->getName()};

                if ($sanitize) {
                    $value = $this->sanitize($value);
                }
            } else {
                $value = 'COLUMN NOT FOUND';
            }

        } elseif (is_array($record) && isset($record[$column->getName()])) {
            // Array value
            $value = $record[$column->getName()];
        } else {
            // Fallback, just return the value
            $value = $column->getName();
        }
        $cell->style($column->getStyle());

        if ($column->getName() == 'special:actions') {
            $value = '';
            foreach ($this->getActions() as $action) {
                $value .= $action->render($record);
            }
        }

        return $value;
    }


    /**
     * Set default sorting, if nothing is in the URL or the session
     *
     * @param        $field
     * @param string $direction
     *
     * @return $this
     */
    public function setDefaultSorting($field, $direction = 'ASC')
    {
        $this->sorting = [ $field, $direction ];

        return $this;
    }


    /**
     * Check if the field and direction is current
     *
     * @param        $field
     * @param string $direction
     *
     * @return bool
     */
    public function checkSortable($field, $direction)
    {
        [ $sortableField, $sortableDirection ] = $this->getSorting();

        if ($sortableField == $field && $sortableDirection == $direction) {
            return true;
        }

        return false;
    }


    /**
     * @return string
     * @throws \ReflectionException
     */
    /**
     * @return string
     * @throws \ReflectionException
     */
    protected function getClass()
    {
        $reflect = new \ReflectionClass($this);

        return $reflect->getName();
    }


    /**
     * @return array
     */
    /**
     * @return array
     * @throws \ReflectionException
     */
    public function getSorting()
    {
        // Check in the URL
        $sortableField     = \Request::get($this->getClass() . '_sortable_field');
        $sortableDirection = \Request::get($this->getClass() . '_sortable_direction');

        // Check session
        if (is_null($sortableField)) {
            $sortableField     = \Session::get($this->getClass() . '_sortable_field');
            $sortableDirection = \Session::get($this->getClass() . '_sortable_direction');
        }

        // Check default
        if (is_null($sortableField)) {
            $sortableField     = $this->sorting[0];
            $sortableDirection = $this->sorting[1];
        }

        return [ $sortableField, $sortableDirection ];
    }


    /**
     * @param $field
     * @param $direction
     */
    /**
     * @param $field
     * @param $direction
     * @throws \ReflectionException
     */
    public function setSorting($field, $direction)
    {
        \Session::put($this->getClass() . '_sortable_field', $field);
        \Session::put($this->getClass() . '_sortable_direction', $direction);
    }


    /**
     * @return mixed
     */
    /**
     * @return mixed
     */
    public function getSortableColumn()
    {
        $sorting = $this->getSorting();

        return $sorting[0];
    }


    /**
     * @return mixed
     */
    /**
     * @return mixed
     */
    public function getSortableDirection()
    {
        $sorting = $this->getSorting();

        return $sorting[1];
    }


    /**
     * @param $field
     * @param $direction
     * @return string
     */
    /**
     * @param $field
     * @param $direction
     * @return string
     */
    public function getSortableLink($field, $direction)
    {
        return '?sortable_field=' . $field . '&sortable_direction=' . $direction;
    }


    /**
     * @param int $limit
     * @return |null
     */
    /**
     * @param int $limit
     * @return |null
     */
    public function getPaginator($limit = 20)
    {

        if ( ! is_null($this->paginator)) {
            return $this->paginator;
        }

        $query = ( $this->model )::filteredByMultiple($this->filter);

        if ( ! $this->filter->get('per_page')) {
            $this->filter->add(new PerPageRenderer('per_page'))->setup();
        }

        $perPage = $this->filter->get('per_page');
        if ( ! is_null($perPage) && ! is_null($perPage->getValue())) {
            $limit = $perPage->getValue();
        }

        [ $sortableField, $sortableDirection ] = $this->getSorting();

        // FIXME: we can't assume that the sorting will always be on the base model!?
        if ( ! is_null($sortableField)) {
            $this->paginator = $query->orderBy($query->getModel()->getTable() . '.' . $sortableField,
                $sortableDirection)->paginate($limit);

            return $this->paginator;
        }

        $this->paginator = $query->paginate($limit);

        return $this->paginator;
    }


    /**
     * @return array|\Illuminate\Http\Request|string
     */
    /**
     * @return array|\Illuminate\Http\Request|string
     */
    public function getSearchTerm()
    {
        return $this->searchTerm;
    }


    /**
     * @return array|bool|\Illuminate\Http\Request|string
     */
    /**
     * @return array|bool|\Illuminate\Http\Request|string
     */
    public function getClientFilter()
    {
        return $this->clientFilter;
    }
}
