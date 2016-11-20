<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Motor\Backend\Forms\Backend\ClientForm;
use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\ClientRequest;
use Motor\Backend\Grids\ClientGrid;
use Motor\Backend\Models\Client;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class ClientsController extends Controller
{

    use FormBuilderTrait;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid      = new ClientGrid(Client::class);
        $paginator = $grid->getPaginator();

        return view('motor-backend::backend.clients.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(ClientForm::class, [
            'method'  => 'POST',
            'route'   => 'backend.clients.store',
            'enctype' => 'multipart/form-data'
        ]);

        return view('motor-backend::backend.clients.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $form = $this->form(ClientForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $record = new Client($this->handleInputValues($form, $request->all()));
        $record->save();

        flash()->success(trans('motor-backend::backend/clients.created'));

        return redirect('backend/clients');
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
    public function edit(Client $record)
    {
        $form = $this->form(ClientForm::class, [
            'method'  => 'PATCH',
            'url'     => route('backend.clients.update', [ $record->id ]),
            'enctype' => 'multipart/form-data',
            'model'   => $record
        ]);

        return view('motor-backend::backend.clients.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ClientRequest $request, Client $record)
    {
        $form = $this->form(ClientForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $data = $this->handleInputValues($form, $request->all());
        $record->update($data);

        flash()->success(trans('motor-backend::backend/clients.updated'));

        return redirect('backend/clients');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $record)
    {
        $record->delete();

        flash()->success(trans('motor-backend::backend/clients.deleted'));

        return redirect('backend/clients');
    }
}
