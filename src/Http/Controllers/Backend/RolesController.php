<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Models\Permission;
use Motor\Backend\Models\Role;
use Motor\Backend\Http\Requests\Backend\RoleRequest;
use Motor\Backend\Grids\RoleGrid;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Forms\Backend\RoleForm;

class RolesController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid      = new RoleGrid(Role::class);
        $paginator = $grid->getPaginator();

        return view('backend.roles.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(RoleForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.roles.store',
            'enctype' => 'multipart/form-data'
        ]);

        return view('backend.roles.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $form = $this->form(RoleForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $inputData = $this->handleInputValues($form, $request->all());

        $record = new Role($inputData);
        $record->save();

        if (isset($inputData['permissions']) && is_array($inputData['permissions'])) {
            foreach ($inputData['permissions'] as $permission => $value) {
                $record->givePermissionTo($permission);
            }
        }

        flash()->success(trans('backend/roles.created'));

        return redirect('backend/roles');
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
    public function edit(Role $record)
    {
        $form = $this->form(RoleForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.roles.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('backend.roles.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $record)
    {
        $form = $this->form(RoleForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $inputData = $this->handleInputValues($form, $request->all());

        $record->update($inputData);

        foreach (Permission::all() as $permission) {
            $record->revokePermissionTo($permission);
        }

        if (isset($inputData['permissions']) && is_array($inputData['permissions'])) {
            foreach ($inputData['permissions'] as $permission => $value) {
                $record->givePermissionTo($permission);
            }
        }

        flash()->success(trans('backend/roles.updated'));

        return redirect('backend/roles');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $record)
    {
        $record->delete();

        flash()->success(trans('backend/roles.deleted'));

        return redirect('backend/roles');
    }
}
