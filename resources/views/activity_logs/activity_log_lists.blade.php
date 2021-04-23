<div class="section-body">
    <div class="row justify-content-center">
        <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-6">
            <div class="activity-div">
                <div class="activities">
                    @forelse($activityLogs as $activityLog)
                        <div class="activity position-relative">
                            <div class="activity-icon bg-white text-white">
                                <i class="activity-icon-size {{activityLogIcon($activityLog->subject_type)}}"></i>
                            </div>
                            <div class="activity-detail">
                                <div class="mb-2 d-flex">
                                    <span class="text-job text-primary">{{ $activityLog->created_at->diffForHumans() }}</span>
                                    <span class="ml-auto position-relative">{{ html_entity_decode($activityLog->createdBy->full_name) }}</span>
                                </div>
                                <span class="post-id text-dark">{{ html_entity_decode(strip_tags($activityLog->description)) }}</span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state" data-height="400">
                            <div class="empty-state-icon">
                                <i class="fas fa-question"></i>
                            </div>
                            <h2>{{ __('messages.activity_log.we_could_find_any_data') }}</h2>
                            <p class="lead">
                                {{ __('messages.activity_log.sorry_we_not_find_any_data').'.' }}
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="load-more-logs text-center display-none">
                <p class="font-size-20px"><i
                            class="fas fa-spinner fa-spin"></i>&nbsp;&nbsp; {{__('messages.activity_log.loading_more_date')}}
                </p>
            </div>
            <div class="no-found-more-logs"><span class="text-center"></span></div>
        </div>
    </div>
</div>
