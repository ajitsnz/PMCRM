<?php

namespace App\Queries;

use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ServiceDataTable
 * @package App\Queries
 */
class ServiceDataTable
{
    /**
     * @return Service|Builder
     */
    public function get()
    {
        /** @var Service $query */
        $query = Service::query()->select('services.*');

        return $query;
    }
}
