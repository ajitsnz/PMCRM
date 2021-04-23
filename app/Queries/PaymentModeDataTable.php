<?php

namespace App\Queries;

use App\Models\PaymentMode;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TagDataTable
 * @package App\Queries
 */
class PaymentModeDataTable
{
    /**
     * @param  array  $input
     *
     * @return PaymentMode
     */
    public function get($input = [])
    {
        /** @var PaymentMode $query */
        $query = PaymentMode::query()->select('payment_modes.*');

        $query->when(isset($input['active']) && $input['active'] != PaymentMode::ACTIVE,
            function (Builder $q) use ($input) {
                $q->where('active', '=', $input['active']);
            });

        return $query;
    }
}
