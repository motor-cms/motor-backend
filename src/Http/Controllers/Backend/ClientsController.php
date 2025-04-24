<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Forms\Backend\ClientForm;
use Motor\Backend\Grids\ClientGrid;
use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\ClientRequest;
use Motor\Backend\Models\Client;
use Motor\Backend\Services\ClientService;

/**
 * Class ClientsController
 */
class ClientsController extends Controller
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
        $grid = new ClientGrid(Client::class);

        $service = ClientService::collection($grid);
        $grid->setFilter($service->getFilter());
        $paginator = $service->getPaginator();

        return view('motor-backend::backend.clients.index', compact('paginator', 'grid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $form = $this->form(ClientForm::class, [
            'method' => 'POST',
            'route' => 'backend.clients.store',
            'enctype' => 'multipart/form-data',
        ]);

        return view('motor-backend::backend.clients.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(ClientRequest $request)
    {
        $form = $this->form(ClientForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        ClientService::createWithForm($request, $form);

        flash()->success(trans('motor-backend::backend/clients.created'));

        return redirect('backend/clients');
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
    public function edit(Client $record)
    {
        $form = $this->form(ClientForm::class, [
            'method' => 'PATCH',
            'url' => route('backend.clients.update', [$record->id]),
            'enctype' => 'multipart/form-data',
            'model' => $record,
        ]);

        return view('motor-backend::backend.clients.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ClientRequest $request, Client $record)
    {
        $form = $this->form(ClientForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        ClientService::updateWithForm($record, $request, $form);

        flash()->success(trans('motor-backend::backend/clients.updated'));

        return redirect('backend/clients');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Client $record)
    {
        ClientService::delete($record);

        flash()->success(trans('motor-backend::backend/clients.deleted'));

        return redirect('backend/clients');
    }
}
