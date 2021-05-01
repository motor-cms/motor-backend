<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Forms\Backend\PermissionForm;
use Motor\Backend\Grids\PermissionGrid;
use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\PermissionRequest;
use Motor\Backend\Models\Permission;
use Motor\Backend\Services\PermissionService;

/**
 * Class PermissionsController
 *
 * @package Motor\Backend\Http\Controllers\Backend
 */
class PermissionsController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \ReflectionException
     */
    public function index()
    {
        $grid = new PermissionGrid(Permission::class);

        $service = PermissionService::collection($grid);
        $grid->setFilter($service->getFilter());
        $paginator = $service->getPaginator();

        return view('motor-backend::backend.permissions.index', compact('paginator', 'grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(PermissionForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.permissions.store',
            'enctype' => 'multipart/form-data',
        ]);

        return view('motor-backend::backend.permissions.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PermissionRequest $request)
    {
        $form = $this->form(PermissionForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        PermissionService::createWithForm($request, $form);

        flash()->success(trans('motor-backend::backend/permissions.created'));

        return redirect('backend/permissions');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Permission $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Permission $record)
    {
        $form = $this->form(PermissionForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.permissions.update', [$record->id]),
            'enctype' => 'multipart/form-data',
            'model'   => $record,
        ]);

        return view('motor-backend::backend.permissions.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionRequest $request
     * @param Permission $record
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PermissionRequest $request, Permission $record)
    {
        $form = $this->form(PermissionForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        PermissionService::updateWithForm($record, $request, $form);

        flash()->success(trans('motor-backend::backend/permissions.updated'));

        return redirect('backend/permissions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $record
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Permission $record)
    {
        PermissionService::delete($record);

        flash()->success(trans('motor-backend::backend/permissions.deleted'));

        return redirect('backend/permissions');
    }
}
