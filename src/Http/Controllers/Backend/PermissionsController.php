<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Models\Permission;
use Motor\Backend\Http\Requests\Backend\PermissionRequest;
use Motor\Backend\Grids\PermissionGrid;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Forms\Backend\PermissionForm;

class PermissionsController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid      = new PermissionGrid(Permission::class);
        $paginator = $grid->getPaginator();

        return view('backend.permissions.index', compact('paginator', 'grid'));
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
            'enctype' => 'multipart/form-data'
        ]);

        return view('backend.permissions.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $form = $this->form(PermissionForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $record = new Permission($this->handleInputValues($form, $request->all()));
        $record->save();

        flash()->success(trans('backend/permissions.created'));

        return redirect('backend/permissions');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $record)
    {
        $form = $this->form(PermissionForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.permissions.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('backend.permissions.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, Permission $record)
    {
        $form = $this->form(PermissionForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $record->update($this->handleInputValues($form, $request->all()));

        flash()->success(trans('backend/permissions.updated'));

        return redirect('backend/permissions');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $record)
    {
        $record->delete();

        flash()->success(trans('backend/permissions.deleted'));

        return redirect('backend/permissions');
    }
}
