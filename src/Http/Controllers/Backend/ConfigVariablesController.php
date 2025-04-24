<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Forms\Backend\ConfigVariableForm;
use Motor\Backend\Grids\ConfigVariableGrid;
use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\ConfigVariableRequest;
use Motor\Backend\Models\ConfigVariable;
use Motor\Backend\Services\ConfigVariableService;

/**
 * Class ConfigVariablesController
 */
class ConfigVariablesController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \ReflectionException
     */
    public function index()
    {
        $grid = new ConfigVariableGrid(ConfigVariable::class);

        $service = ConfigVariableService::collection($grid);
        $grid->setFilter($service->getFilter());
        $paginator = $service->getPaginator();

        return view('motor-backend::backend.config_variables.index', compact('paginator', 'grid'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function duplicate(ConfigVariable $record)
    {
        $newRecord = $record->replicate();
        $newRecord->name = 'duplicate-of-'.$newRecord->name;

        return $this->create($newRecord);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(ConfigVariable $record)
    {
        $form = $this->form(ConfigVariableForm::class, [
            'method' => 'POST',
            'route' => 'backend.config_variables.store',
            'enctype' => 'multipart/form-data',
            'model' => $record,
        ]);

        return view('motor-backend::backend.config_variables.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ConfigVariableRequest $request)
    {
        $form = $this->form(ConfigVariableForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        ConfigVariableService::createWithForm($request, $form);

        flash()->success(trans('motor-backend::backend/config_variables.created'));

        return redirect('backend/config_variables');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(ConfigVariable $record)
    {
        $form = $this->form(ConfigVariableForm::class, [
            'method' => 'PATCH',
            'url' => route('backend.config_variables.update', [$record->id]),
            'enctype' => 'multipart/form-data',
            'model' => $record,
        ]);

        return view('motor-backend::backend.config_variables.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ConfigVariableRequest $request, ConfigVariable $record)
    {
        $form = $this->form(ConfigVariableForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        ConfigVariableService::updateWithForm($record, $request, $form);

        flash()->success(trans('motor-backend::backend/config_variables.updated'));

        return redirect('backend/config_variables');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(ConfigVariable $record)
    {
        ConfigVariableService::delete($record);

        flash()->success(trans('motor-backend::backend/config_variables.deleted'));

        return redirect('backend/config_variables');
    }
}
