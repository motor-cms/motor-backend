<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Motor\Backend\Forms\Backend\UserForm;
use Motor\Backend\Grids\UsersGrid;
use Motor\Backend\Http\Requests\Backend\UserRequest;
use Motor\Backend\Models\Role;
use Motor\Backend\Models\User;
use Motor\Backend\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Services\UserService;

class UsersController extends Controller
{

    use FormBuilderTrait;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = new UsersGrid(User::class);

        $service = UserService::collection($grid);
        $grid->filter = $service->getFilter();
        $paginator    = $service->getPaginator();

        return view('motor-backend::backend.users.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(UserForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.users.store',
            'enctype' => 'multipart/form-data'
        ]);

        return view('motor-backend::backend.users.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $form = $this->form(UserForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        UserService::createWithForm($request, $form);

        flash()->success(trans('motor-backend::backend/users.created'));

        return redirect('backend/users');
    }


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(User $record)
    {
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $form = $this->form(UserForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.users.update', [ $user->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $user
        ]);

        return view('motor-backend::backend.users.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $record)
    {
        $form = $this->form(UserForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        UserService::updateWithForm($record, $request, $form);

        flash()->success(trans('motor-backend::backend/users.updated'));

        return redirect('backend/users');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $record)
    {
        UserService::delete($record);

        flash()->success(trans('motor-backend::backend/users.deleted'));

        return redirect('backend/users');
    }
}
