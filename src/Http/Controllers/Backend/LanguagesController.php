<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Motor\Backend\Forms\Backend\LanguageForm;
use Motor\Backend\Grids\LanguageGrid;
use Motor\Backend\Http\Requests\Backend\LanguageRequest;
use Motor\Backend\Models\Language;
use Motor\Backend\Http\Controllers\Controller;
use Kris\LaravelFormBuilder\FormBuilderTrait;

class LanguagesController extends Controller
{
    use FormBuilderTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid      = new LanguageGrid(Language::class);
        $paginator = $grid->getPaginator();

        return view('backend.languages.index', compact('paginator', 'grid'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = $this->form(LanguageForm::class, [
            'method' => 'POST',
            'route'  => 'backend.languages.store'
        ]);

        return view('backend.languages.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(LanguageRequest $request)
    {
        $form = $this->form(LanguageForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $record = new Language($request->all());
        $record->save();

        flash()->success(trans('backend/languages.created'));

        return redirect('backend/languages');
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
    public function edit(Language $record)
    {
        $form = $this->form(LanguageForm::class, [
            'method' => 'PATCH',
            'url'    => route('backend.languages.update', [ $record->id ]),
            'model'  => $record
        ]);

        return view('backend.languages.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(LanguageRequest $request, Language $record)
    {
        $form = $this->form(LanguageForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $record->update($request->all());

        flash()->success(trans('backend/languages.updated'));

        return redirect('backend/languages');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Language $record)
    {
        $record->delete();

        flash()->success(trans('backend/languages.deleted'));

        return redirect('backend/languages');
    }
}
