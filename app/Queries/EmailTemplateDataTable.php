<?php

namespace App\Queries;

use App\Models\EmailTemplate;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class EmailTemplateDataTable
 */
class EmailTemplateDataTable
{
    /**
     * @param  array  $input
     *
     * @return EmailTemplate
     */
    public function get($input = [])
    {
        /** @var EmailTemplate $query */
        $query = EmailTemplate::query()->select('email_templates.*');

        $query->when(isset($input['template_type']), function (Builder $q) use ($input) {
            $q->where('template_type', '=', $input['template_type']);
        });

        $query->when(isset($input['disabled']) && $input['disabled'] != EmailTemplate::DISABLED_TEMPLATE_ARR,
            function (Builder $q) use ($input) {
                $q->where('disabled', '=', $input['disabled']);
            });

        return $query;
    }
}
