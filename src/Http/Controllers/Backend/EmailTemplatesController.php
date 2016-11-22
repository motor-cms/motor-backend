<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Motor\Backend\Forms\Backend\EmailTemplateForm;
use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Models\EmailTemplate;
use Motor\Backend\Http\Requests\Backend\EmailTemplateRequest;
use Motor\Backend\Grids\EmailTemplateGrid;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Services\EmailTemplateService;

class EmailTemplatesController extends Controller
{

    use FormBuilderTrait;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grid = new EmailTemplateGrid(EmailTemplate::class);

        $service      = EmailTemplateService::collection($grid);
        $grid->filter = $service->getFilter();
        $paginator    = $service->getPaginator();

        return view('motor-backend::backend.email_templates.index', compact('paginator', 'grid'));
    }


    /**
     * @param EmailTemplate $record
     */
    public function duplicate(EmailTemplate $record)
    {
        $newRecord = $record->replicate();

        return $this->create($newRecord);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(EmailTemplate $record)
    {

        $form = $this->form(EmailTemplateForm::class, [
            'method' => 'POST',
            'route'  => 'backend.email_templates.store',
            'model'  => $record
        ]);

        return view('motor-backend::backend.email_templates.create', compact('form'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(EmailTemplateRequest $request)
    {
        $form = $this->form(EmailTemplateForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        EmailTemplateService::createWithForm($request, $form);

        flash()->success(trans('motor-backend::backend/email_templates.created'));

        return redirect('backend/email_templates');
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
    public function edit(EmailTemplate $record)
    {
        $form = $this->form(EmailTemplateForm::class, [
            'method' => 'PATCH',
            'url'    => route('backend.email_templates.update', [ $record->id ]),
            'model'  => $record
        ]);

        return view('motor-backend::backend.email_templates.edit', compact('form'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(EmailTemplateRequest $request, EmailTemplate $record)
    {
        $form = $this->form(EmailTemplateForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if ( ! $form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        EmailTemplateService::updateWithForm($record, $request, $form);

        flash()->success(trans('motor-backend::backend/email_templates.updated'));

        return redirect('backend/email_templates');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplate $record)
    {
        EmailTemplateService::delete($record);

        flash()->success(trans('motor-backend::backend/email_templates.deleted'));

        return redirect('backend/email_templates');
    }
}
