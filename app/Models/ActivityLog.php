<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Models\Activity as ActivityModel;

class ActivityLog extends ActivityModel
{
    protected $table = 'activity_log';

    /**
     *
     *
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
