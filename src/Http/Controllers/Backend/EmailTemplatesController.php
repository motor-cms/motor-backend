<?php

namespace Motor\Backend\Http\Controllers\Backend;

use Kris\LaravelFormBuilder\FormBuilderTrait;
use Motor\Backend\Forms\Backend\EmailTemplateForm;
use Motor\Backend\Grids\EmailTemplateGrid;
use Motor\Backend\Http\Controllers\Controller;
use Motor\Backend\Http\Requests\Backend\EmailTemplateRequest;
use Motor\Backend\Models\EmailTemplate;
use Motor\Backend\Services\EmailTemplateService;

/**
 * Class EmailTemplatesController
 */
class EmailTemplatesController extends Controller
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
        $grid = new EmailTemplateGrid(EmailTemplate::class);

        $service = EmailTemplateService::collection($grid);
        $grid->setFilter($service->getFilter());
        $paginator = $service->getPaginator();

        return view('motor-backend::backend.email_templates.index', compact('paginator', 'grid'));
    }

    /**
     * @param  EmailTemplate  $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function duplicate(EmailTemplate $record)
    {
        $newRecord = $record->replicate();

        return $this->create($newRecord);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  EmailTemplate  $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(EmailTemplate $record)
    {
        $form = $this->form(EmailTemplateForm::class, [
            'method' => 'POST',
            'route'  => 'backend.email_templates.store',
            'model'  => $record,
        ]);

        return view('motor-backend::backend.email_templates.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  EmailTemplateRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(EmailTemplateRequest $request)
    {
        $form = $this->form(EmailTemplateForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        EmailTemplateService::createWithForm($request, $form);

        flash()->success(trans('motor-backend::backend/email_templates.created'));

        return redirect('backend/email_templates');
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
     * @param  EmailTemplate  $record
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(EmailTemplate $record)
    {
        $form = $this->form(EmailTemplateForm::class, [
            'method' => 'PATCH',
            'url'    => route('backend.email_templates.update', [$record->id]),
            'model'  => $record,
        ]);

        return view('motor-backend::backend.email_templates.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  EmailTemplateRequest  $request
     * @param  EmailTemplate  $record
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(EmailTemplateRequest $request, EmailTemplate $record)
    {
        $form = $this->form(EmailTemplateForm::class);

        // It will automatically use current request, get the rules, and do the validation
        if (! $form->isValid()) {
            return redirect()
                ->back()
                ->withErrors($form->getErrors())
                ->withInput();
        }

        EmailTemplateService::updateWithForm($record, $request, $form);

        flash()->success(trans('motor-backend::backend/email_templates.updated'));

        return redirect('backend/email_templates');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  EmailTemplate  $record
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(EmailTemplate $record)
    {
        EmailTemplateService::delete($record);

        flash()->success(trans('motor-backend::backend/email_templates.deleted'));

        return redirect('backend/email_templates');
    }
}
