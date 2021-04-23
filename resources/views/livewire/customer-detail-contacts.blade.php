<div class="row">
    <div class="mt-0 mb-3 col-12 d-flex justify-content-end contact-search">
        <div class="justify-content-end mr-2">
            {{ Form::select('is_enable',App\Models\Contact::STATUS,$contactStatusValue,['class' => 'form-control','id' => 'isEnableId','placeholder' => 'Select Status']) }}
        </div>
        <div class="justify-content-end">
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

    @forelse($contacts as $contact)
        <div class="col-xl-2 col-lg-4 col-sm-6 col-md-6 customer-detail mb-5 contact-card-width">
            <div class="livewire-card card {{ $loop->odd ? 'card-primary' : 'card-dark'}} profile-card card-primary shadow rounded p-0">
                @if($contact->primary_contact)
                    <div>
                <span class="primary-contact" data-toggle="tooltip" data-placement="top" title=""
                      data-original-title="Primary Contact"><i class="fas fa-user-check h3"></i></span>
                    </div>
                @endif
                <div class="edit-profile action-dropdown user-text mt-2 d-none">
                    <a title="{{__('messages.common.edit')}}" href="{{ route('contacts.edit',$contact->id) }}"><i
                                class="fa fa-edit text-warning mr-1"></i>
                    </a>
                    <a title="{{__('messages.common.delete')}}" class="text-danger action-btn delete-btn contact-delete"
                       data-id="{{ $contact->id }}" href="#"><i class="fa fa-trash"></i>
                    </a>
                </div>
                <img alt="Client" class="rounded-circle img-thumbnail contact-profile"
                     src="{{ $contact->user->image_url }}">
                <h6 class="h5 mb-0 mt-2 contact-full-name">
                    <a class="text-decoration-none" href="{{ route('contacts.show',$contact->id) }}">
                        {{ Str::limit(html_entity_decode($contact->user->full_name), 10, '...') }}
                    </a>
                </h6>
                    <h6 class="office-time mb-0 mt-3 text-dark">{{ $contact->user->email }}</h6>
                    <div class="w-100 justify-content-between">
                        <div class="ml-2 mt-2 contact-card-toggle">
                            <label class="custom-switch pl-0" data-placement="bottom"
                                   title="{{ $contact->user->is_enable ? __('messages.common.active') : __('messages.common.deactive') }}">
                            <input type="checkbox" name="is_enable" class="custom-switch-input isActive"
                                   data-id="{{ $contact->user->id }}" value="1"
                                   data-class="is_enable" {{ $contact->user->is_enable ? 'checked' : '' }}>
                            <span class="custom-switch-indicator"></span>
                        </label>
                    </div>
                    <span class="total-permission-count">
                        <big class="font-weight-bold">{{$contact->permission_count}} </big>
                        {{ __('messages.contact.permissions') }}
                    </span>
                </div>
            </div>
        </div>
    @empty
        <div class="col-md-12 d-flex justify-content-center mt-3">
            @if(empty($search))
                <p class="text-dark">{{ __('messages.contact.no_contact_available') }}</p>
            @else
                <p class="text-dark">{{ __('messages.contact.contact_not_found') }}</p>
            @endif
        </div>
    @endforelse
    <div class="mt-0 mb-5 col-12">
        <div class="row paginatorRow">
            <div class="col-lg-2 col-md-6 col-sm-12 pt-2">
                <span class="d-inline-flex">
                    {{ __('messages.common.showing') }}
                    <span class="font-weight-bold ml-1 mr-1">{{ $contacts->firstItem() }}</span> - 
                    <span class="font-weight-bold ml-1 mr-1">{{ $contacts->lastItem() }}</span> {{ __('messages.common.of') }} 
                    <span class="font-weight-bold ml-1">{{ $contacts->total() }}</span>
                </span>
            </div>
            <div class="col-lg-10 col-md-6 col-sm-12 d-flex justify-content-end">
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
</div>
