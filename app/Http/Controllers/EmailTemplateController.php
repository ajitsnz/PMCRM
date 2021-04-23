<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEmailTemplateRequest;
use App\Models\EmailTemplate;
use App\Queries\EmailTemplateDataTable;
use App\Repositories\EmailTemplateRepository;
use Exception;
use Flash;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class EmailTemplateController extends AppBaseController
{
    /** @var  EmailTemplateRepository */
    private $emailTemplateRepository;

    public function __construct(EmailTemplateRepository $emailTemplateRepo)
    {
        $this->emailTemplateRepository = $emailTemplateRepo;
    }

    /**
     * Display a listing of the EmailTemplate.
     *
     * @param  Request  $request
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of((new EmailTemplateDataTable())->get($request->only([
                'template_type', 'disabled',
            ])))->make(true);
        }

        $templateTypeArr = EmailTemplate::TEMPLATE_TYPES;
        $disabledEmailTemplate = EmailTemplate::DISABLED_TEMPLATE_ARR;

        return view('email_templates.index', compact('templateTypeArr', 'disabledEmailTemplate'));
    }

    /**
     * Show the form for editing the specified EmailTemplate.
     *
     * @param  EmailTemplate  $emailTemplate
     *
     * @return Factory|View
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        $mergeFields = EmailTemplate::MERGE_FIELDS;

        return view('email_templates.edit', compact('emailTemplate', 'mergeFields'));
    }

    /**
     * Update the specified EmailTemplate in storage.
     *
     * @param  EmailTemplate  $emailTemplate
     *
     * @param  UpdateEmailTemplateRequest  $request
     *
     * @return RedirectResponse|Redirector
     */
    public function update(EmailTemplate $emailTemplate, UpdateEmailTemplateRequest $request)
    {
        $input = $request->all();
        $input['disabled'] = isset($input['disabled']) ? 0 : 1;
        $input['send_plain_text'] = isset($input['send_plain_text']) ? 1 : 0;
        $this->emailTemplateRepository->update($input, $emailTemplate->id);

        Flash::success('Email Template updated successfully.');

        return redirect(route('email-templates.index'));
    }

    /**
     * @param  EmailTemplate  $emailTemplate
     *
     * @return JsonResponse
     */
    public function enableDisableTemplate(EmailTemplate $emailTemplate)
    {
        $emailTemplate->update(['disabled' => ! $emailTemplate->disabled]);

        return $this->sendSuccess('Email Template updated successfully.');
    }
}
