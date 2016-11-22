<?php

namespace Motor\Backend\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\Fields\CheckableType;
use Kris\LaravelFormBuilder\Fields\SelectType;
use Kris\LaravelFormBuilder\Form;
use Motor\Backend\Forms\Fields\DatepickerType;
use Motor\Backend\Forms\Fields\DatetimepickerType;
use Motor\Core\Filter\Filter;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class BaseService
{

    protected $filter;

    protected $model;


    public function __construct($name = '')
    {
        $this->filter = new Filter($name);
        $this->filters();
    }


    public function filters()
    {

    }


    public function getFilter()
    {
        return $this->filter;
    }


    public function getPaginatorFor($class)
    {
        return $class::filteredByMultiple($this->getFilter())->paginate($this->getFilter()->get('per_page')->getValue());
    }


    public function getPaginator()
    {
        return $this->getPaginatorFor($this->model);
    }


    public function show(Model $record)
    {
        return $record;
    }


    public function store($data, $form = null)
    {
        if ( ! is_null($form)) {
            $data = $this->handleFormValues($form, $data);
        }
        $record = new $this->model($data);
        $record->save();

        return $record;
    }


    public function update(Model $record, $data, $form = null)
    {
        if ( ! is_null($form)) {
            $data = $this->handleFormValues($form, $data);
        }
        $record->update($data);

        return $record;
    }


    public function destroy(Model $record)
    {
        if ($record->exists) {
            $record->delete();

            return true;
        }

        return false;
    }


    public function handleFormValues(Form $form, array $data)
    {
        foreach ($form->getFields() as $name => $field) {

            // Handle empty checkbox values
            if ($field instanceof CheckableType) {
                if ( ! isset( $data[$field->getRealName()] )) {
                    $data[$field->getRealName()] = false;
                }
            }

            // Handle empty date values
            if ($field instanceof DatepickerType || $field instanceof DatetimepickerType) {

                if ($data[$field->getRealName() . '_picker'] == '') {
                    $data[$field->getRealName()] = '';
                }
                if ( ! isset( $data[$field->getRealName()] ) || ( isset( $data[$field->getRealName()] ) && $data[$field->getRealName()] == '' || $data[$field->getRealName()] == '0000-00-00 00:00:00' || $data[$field->getRealName()] == '0000-00-00' )) {
                    $data[$field->getRealName()] = null;
                }
            }

            // Handle empty select values
            if ($field instanceof SelectType && isset( $data[$field->getRealName()] ) && $data[$field->getRealName()] == '') {
                $data[$field->getRealName()] = null;
            }
        }

        return $data;
    }


    public function handleFileupload(Request $request, HasMedia $record, $identifier = 'image', $collection = null)
    {
        $collection = ( ! is_null($collection) ? $collection : $identifier );

        if ( ! is_null($request->file($identifier)) || $request->get(Str::slug($identifier) . '_delete') == 1) {
            $record->clearMediaCollection($identifier);
            $record->clearMediaCollection($collection);
        }

        if ($request->file($identifier) && $request->file($identifier)->isValid()) {
            $record->addMedia($request->file($identifier))->toCollection($collection);
        }
    }
}