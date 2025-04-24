<?php

namespace Motor\Backend\Grid;

use Exception;

/**
 * Class Cell
 */
class Cell extends Base
{
    protected $name = '';

    protected $value = '';

    protected $record;

    protected $column;

    protected $renderer;

    protected $renderOptions = [];

    /**
     * Cell constructor.
     */
    public function __construct(string $name, $renderer, array $renderOptions = [])
    {
        $this->name = $name;
        $this->renderer = $renderer;
        $this->renderOptions = $renderOptions;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function setRecord($record)
    {
        $this->record = $record;
    }

    public function setColumn($column)
    {
        $this->column = $column;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        // Get renderer
        $renderer = new $this->renderer($this->value, $this->renderOptions, $this->record);

        if (! $this->column->checkCondition($this->record)) {
            return '';
        }

        return $renderer->render();
    }

    /**
     * Parse filters assigned by column
     *
     * @return bool
     */
    public function parseFilters(array $filters)
    {
        foreach ($filters as $filter) {
            $params = [];
            if (preg_match('/([^\[]*+)\[(.+)\]/', $filter, $match)) {
                $filter = $match[1];
                $params = explode(',', $match[2]);
            }

            if (function_exists($filter)) {
                if ($filter == 'date') {
                    array_push($params, $this->value);
                } else {
                    array_unshift($params, $this->value);
                }

                try {
                    $this->value = call_user_func_array($filter, $params);
                } catch (Exception $exception) {
                    return false;
                }
            }
        }
    }
}
