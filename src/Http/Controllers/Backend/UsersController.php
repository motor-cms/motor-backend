<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Motor\Backend\Forms\Backend\UserForm;
use Motor\Backend\Grids\UsersGrid;
use Motor\Backend\Http\Requests\Backend\UserRequest;
use Motor\Backend\Models\Role;
use Motor\Backend\Models\User;
use Motor\Backend\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\FormBuilderTrait;

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
        $grid      = new UsersGrid(User::class);
        $paginator = $grid->getPaginator();

        return view('backend.users.index', compact('paginator', 'grid'));
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

        return view('backend.users.create', compact('form'));
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

        $data              = $this->handleInputValues($form, $request->all());
        $data['password']  = bcrypt($data['password']);
        $data['api_token'] = str_random(60);

        $user = new User($data);
        $user->save();

        $this->handleFileupload($request, $user, 'avatar', 'avatar');

        if (isset( $data['roles'] ) && is_array($data['roles'])) {
            foreach ($data['roles'] as $role => $value) {
                $user->assignRole($role);
            }
        }

        flash()->success(trans('backend/users.created'));

        return redirect('backend/users');
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
    public function edit(User $user)
    {
        $form = $this->form(UserForm::class, [
            'method'  => 'PATCH',
            'url' => route('backend.users.update', [$user->id]),
            'enctype' => 'multipart/form-data',
            'model'   => $user
        ]);

        return view('backend.users.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $form = $this->form(UserForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $this->handleInputValues($form, $request->all());

        if ($data['password'] == '') {
            unset( $data['password'] );
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        $this->handleFileupload($request, $user, 'avatar', 'avatar');

        foreach (Role::all() as $role) {
            $user->removeRole($role);
        }

        if (isset( $data['roles'] ) && is_array($data['roles'])) {
            foreach ($data['roles'] as $role => $value) {
                $user->assignRole($role);
            }
        }

        flash()->success(trans('backend/users.updated'));

        return redirect('backend/users');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        flash()->success(trans('backend/users.deleted'));

        return redirect('backend/users');
    }
}
