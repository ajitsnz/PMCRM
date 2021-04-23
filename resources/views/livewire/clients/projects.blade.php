<div class="row">
    <div class="mt-0 mb-3 col-12 d-flex justify-content-end">
        <div class="p-2">
            <input wire:model.debounce.100ms="search" type="search" class="form-control" placeholder="Search"
                   id="search">
        </div>
    </div>
    <div class="col-md-12">
        <div wire:loading id="live-wire-screen-lock">
            <div class="live-wire-infy-loader">
                @include('loader')
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="row justify-content-md-center text-center mb-4">
            <div class="owl-carousel owl-theme">
                <div class="item">
                    <div class="ticket-statistics mx-auto bg-danger">
                        <p>{{ $statusCount['not_started'] }}</p>
                    </div>
                    <h5 class="my-0 mt-1 ticket-statistics-size">{{ __('messages.status.not_started') }}</h5>
                </div>
                <div class="item">
                    <div class="ticket-statistics mx-auto bg-primary">
                        <p>{{ $statusCount['in_progress'] }}</p>
                    </div>
                    <h5 class="my-0 mt-1 ticket-statistics-size">{{ __('messages.status.in_progress') }}</h5>
                </div>
                <div class="item">
                    <div class="ticket-statistics mx-auto bg-warning">
                        <p>{{ $statusCount['on_hold'] }}</p>
                    </div>
                    <h5 class="my-0 mt-1 ticket-statistics-size">{{ __('messages.status.on_hold') }}</h5>
                </div>
                <div class="item">
                    <div class="ticket-statistics mx-auto bg-info">
                        <p>{{ $statusCount['cancelled'] }}</p>
                    </div>
                    <h5 class="my-0 mt-1 ticket-statistics-size">{{ __('messages.status.cancelled') }}</h5>
                </div>
                <div class="item">
                    <div class="ticket-statistics mx-auto bg-success">
                        <p>{{ $statusCount['finished'] }}</p>
                    </div>
                    <h5 class="my-0 mt-1 ticket-statistics-size">{{ __('messages.status.finished') }}</h5>
                </div>
            </div>
        </div>
    </div>

    @forelse($projects as $project)
        <div class="col-12 col-md-6 col-lg-6 col-xl-4">
            <div class="livewire-card card card-{{ \App\Models\Project::CARD_COLOR[$project->status] }} shadow mb-5 rounded project-card-height">
                <div class="card-header d-flex justify-content-between align-items-center pr-3 pl-3">
                    <div class="d-flex">
                        <a href="{{ route('clients.projects.show',[$project->id, '']) }}" class="text-decoration-none">
                            <h4 class="text-primary card-report-name">{{ \Illuminate\Support\Str::limit(html_entity_decode($project->project_name), 20, '...') }}</h4>
                        </a>
                    </div>
                </div>
                <div class="card-body pt-0 pl-3">
                    <div class="float-left mt-2">
                        <span class="float-left projectStatistics">
                            <b>{{ __('messages.project.billing_type') }}: </b> 
                            <span> {{ \App\Models\Project::BILLING_TYPES[$project->billing_type] }} </span>
                        </span>
                    </div>
                    <div class="float-right project-card-status mt-1">
                        <span class="badge {{\App\Models\Project::STATUS_BADGE[$project->status] }} text-uppercase projectStatus">{{ \App\Models\Project::STATUS[$project->status] }}</span>
                    </div>
                    <div class="float-left mt-1">
                        <span class="mr-1"><b>{{ __('messages.project.customer') }}:</b> 
                            {{ html_entity_decode($project->customer->company_name) }}
                        </span>
                    </div>
                    <div class="float-left project-deadline">
                        <span class="{{(now() > \Carbon\Carbon::parse($project->deadline)->toDate())?'text-danger':'' }}" title="{{ __('messages.project.deadline') }}">{{ Carbon\Carbon::parse($project->deadline)->format('jS M, Y ') }}</span>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="mt-0 mb-5 col-12 d-flex justify-content-center mb-5 rounded">
            <div class="p-2">
                @if(empty($search))
                    <p class="text-dark">{{ __('messages.project.no_project_available').'.' }}</p>
                @else
                    <p class="text-dark">{{ __('messages.project.no_project_found').'.' }}</p>
                @endif
            </div>
        </div>
    @endforelse

    <div class="mt-0 mb-5 col-12">
        <div class="row paginatorRow">
            <div class="col-lg-2 col-md-6 col-sm-12 pt-2">
                <span class="d-inline-flex">
                    {{ __('messages.common.showing') }}  
                    <span class="font-weight-bold ml-1 mr-1">{{ $projects->firstItem() }}</span> - 
                    <span class="font-weight-bold ml-1 mr-1">{{ $projects->lastItem() }}</span> {{ __('messages.common.of') }}
                    <span class="font-weight-bold ml-1">{{ $projects->total() }}</span>
                </span>
            </div>
            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</div>
