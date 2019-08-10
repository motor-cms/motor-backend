<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Motor\Backend\Forms\Backend\LanguageForm;
use Motor\Backend\Grids\LanguageGrid;
use Motor\Backend\Http\Requests\Backend\LanguageRequest;
use Motor\Backend\Models\Language;
use Motor\Backend\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Services\LanguageService;

/**
 * Class LanguagesController
 * @package Motor\Backend\Http\Controllers\Backend
 */
class LanguagesController extends Controller
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
        $grid = new LanguageGrid(Language::class);

        $service = LanguageService::collection($grid);
        $grid->setFilter($service->getFilter());
        $paginator = $service->getPaginator();

        return view('motor-backend::backend.languages.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $form = $this->form(LanguageForm::class, [
            'method' => 'POST',
            'route'  => 'backend.languages.store'
        ]);

        return view('motor-backend::backend.languages.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param LanguageRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(LanguageRequest $request)
    {
        $form = $this->form(LanguageForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        LanguageService::createWithForm($request, $form);

        flash()->success(trans('motor-backend::backend/languages.created'));

        return redirect('backend/languages');
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
     * @param Language $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Language $record)
    {
        $form = $this->form(LanguageForm::class, [
            'method' => 'PATCH',
            'url'    => route('backend.languages.update', [ $record->id ]),
            'model'  => $record
        ]);

        return view('motor-backend::backend.languages.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param LanguageRequest $request
     * @param Language        $record
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(LanguageRequest $request, Language $record)
    {
        $form = $this->form(LanguageForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        LanguageService::updateWithForm($record, $request, $form);

        flash()->success(trans('motor-backend::backend/languages.updated'));

        return redirect('backend/languages');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Language $record
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Language $record)
    {
        LanguageService::delete($record);

        flash()->success(trans('motor-backend::backend/languages.deleted'));

        return redirect('backend/languages');
    }
}
