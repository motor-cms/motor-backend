<?php

namespace Motor\Backend\Http\Controllers;

use Motor\Backend\Forms\Fields\DatepickerType;
use Motor\Backend\Forms\Fields\DatetimepickerType;
use Motor\Backend\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\Fields\CheckableType;
use Kris\LaravelFormBuilder\Fields\SelectType;
use Kris\LaravelFormBuilder\Form;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function __construct()
    {
        \Locale::setDefault(config('app.locale'));
    }


    /**
     * @param Form  $form
     * @param array $data
     *
     * @return array
     */
    protected function handleInputValues(Form $form, array $data)
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

                if ($data[$field->getRealName().'_picker'] == '') {
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


    /**
     * @param Request $request
     * @param Model   $model
     */
    protected function handleFileupload(Request $request, HasMedia $record, $identifier = 'image', $collection = null)
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
