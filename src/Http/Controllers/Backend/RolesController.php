<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Models\Role;
use Motor\Backend\Http\Requests\Backend\RoleRequest;
use Motor\Backend\Grids\RoleGrid;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Forms\Backend\RoleForm;
use Motor\Backend\Services\RoleService;

/**
 * Class RolesController
 * @package Motor\Backend\Http\Controllers\Backend
 */
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
        $grid = new RoleGrid(Role::class);

        $service = RoleService::collection($grid);
        $grid->setFilter($service->getFilter());
        $paginator = $service->getPaginator();

        return view('motor-backend::backend.roles.index', compact('paginator', 'grid'));
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

        return view('motor-backend::backend.roles.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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

        RoleService::createWithForm($request, $form);

        flash()->success(trans('motor-backend::backend/roles.created'));

        return redirect('backend/roles');
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
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
     * @param int $id
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

        return view('motor-backend::backend.roles.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
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

        RoleService::updateWithForm($record, $request, $form);

        flash()->success(trans('motor-backend::backend/roles.updated'));

        return redirect('backend/roles');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $record)
    {
        RoleService::delete($record);

        flash()->success(trans('motor-backend::backend/roles.deleted'));

        return redirect('backend/roles');
    }
}
