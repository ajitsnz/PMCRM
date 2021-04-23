<?php

namespace App\Queries;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ContactDataTable
 */
class ContactDataTable
{
    /**
     * @param  array  $input
     *
     * @return Contact|Builder
     */
    public function get($input = [])
    {
        /** @var Contact $query */
        $query = Contact::with('customer', 'user')->whereCustomerId($input['customer_id'])->select('contacts.*');

        $query->when(isset($input['is_enable']), function (Builder $q) use ($input) {
            $q->whereHas('user', function (Builder $q) use ($input) {
                $q->where('is_enable', '=', $input['is_enable']);
            });
        });

        return $query;
    }
}
