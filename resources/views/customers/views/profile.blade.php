@extends('customers.show')
@section('section')
    <ul class="nav nav-tabs mb-3" id="customer" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="customerDetails" data-toggle="tab" href="#cDetails" role="tab"
                   aria-controls="home" aria-selected="true">{{ __('messages.customer.customer_details') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="#addressDetails" data-toggle="tab" href="#aDetails" role="tab"
                   aria-controls="profile"
                   aria-selected="false">{{ __('messages.customer.address_details') }}</a>
            </li>
    </ul>
    <div class="tab-content" id="myTabContent2">
        <div class="tab-pane fade show active" id="cDetails" role="tabpanel" aria-labelledby="customerDetails">
            <div class="row">
                <div class="form-group col-sm-6">
                    {{ Form::label('company_name', __('messages.customer.company_name').':') }}
                    <p>{{ html_entity_decode($customer->company_name) }}</p>
                </div>
                <div class="form-group col-sm-6">
                    {{ Form::label('vat_number', __('messages.customer.vat_number').':') }}
                    <p>{{ !empty($customer->vat_number)?$customer->vat_number : __('messages.common.n/a') }}</p>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    {{ Form::label('phone', __('messages.customer.phone').':') }}
                    <p>{{ isset($customer->phone)?$customer->phone: __('messages.common.n/a') }}</p>
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('website', __('messages.customer.website').':') }}
                        <p>
                            @if(!empty($customer->website))
                                <a href="{{ $customer->website }}" class="anchor-underline">{{ $customer->website }}</a>
                            @else
                                {{ __('messages.common.n/a') }}
                            @endif
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6">
                        {{ Form::label('currency', __('messages.customer.currency').':') }}
                        <p>{{ isset($customer->currency)?$customer->currency: __('messages.common.n/a') }}</p>
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('default_language', __('messages.customer.default_language').':') }}
                        <p>{{ isset($customer->default_language)?$customer->default_language: __('messages.common.n/a') }}</p>
                    </div>
                </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    {{ Form::label('country', __('messages.customer.country').':') }}
                    <p>{{ !empty($customer->country) ? $customer->country : __('messages.common.n/a') }}</p>
                </div>
                <div class="form-group col-sm-6">
                    {{ Form::label('groups', __('messages.customer.groups').':') }}
                    <p>
                        @forelse($customerGroups as $customerGroup)
                            <span class="badge border border-secondary">{{ html_entity_decode($customerGroup) }}</span>
                        @empty
                            {{ __('messages.common.n/a') }}
                        @endforelse
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    {{ Form::label('created_at', __('messages.common.created_on').':') }}
                    <p><span data-toggle="tooltip" data-placement="right"
                                 title="{{ date('jS M, Y', strtotime($customer->created_at)) }}">{{ $customer->created_at->diffForHumans() }}</span>
                        </p>
                    </div>
                    <div class="form-group col-sm-6">
                        {{ Form::label('updated_at', __('messages.common.last_updated').':') }}
                        <p><span data-toggle="tooltip" data-placement="right"
                                 title="{{ date('jS M, Y', strtotime($customer->updated_at)) }}">{{ $customer->updated_at->diffForHumans() }}</span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="aDetails" role="tabpanel" aria-labelledby="addressDetails">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="card my-0">
                            <div class="card-header pl-2">
                                <h4 class="text-black-50 font-weight-bold">{{ __('messages.customer.billing_address') }}</h4>
                                @if( empty($billingAddress->street))
                                <a href="#" data-toggle="modal" data-target="#addModal" class="mr-3 addressModalIcon"><i
                                            class="fa fa-edit"></i></a>
                                @endif
                            </div>
                        </div>
                        @if(!empty($billingAddress))
                            <div class="form-group col-sm-12">
                                {{ Form::label('street', __('messages.customer.street').':') }}
                                <p>{{ !empty($billingAddress->street)?$billingAddress->street: __('messages.common.n/a') }}</p>
                            </div>
                            <div class="form-group col-sm-12">
                                {{ Form::label('city', __('messages.customer.city').':') }}
                                <p>{{ !empty($billingAddress->city)?$billingAddress->city: __('messages.common.n/a') }}</p>
                            </div>
                            <div class="form-group col-sm-12">
                                {{ Form::label('zip', __('messages.customer.zip_code').':') }}
                                <p>{{ !empty($billingAddress->zip)?$billingAddress->zip: __('messages.common.n/a') }}</p>
                            </div>
                            <div class="form-group col-sm-12">
                                {{ Form::label('state', __('messages.customer.state').':') }}
                                <p>{{ !empty($billingAddress->state)?$billingAddress->state: __('messages.common.n/a') }}</p>
                            </div>
                            <div class="form-group col-sm-12">
                                {{ Form::label('country', __('messages.customer.country').':') }}
                                <p>{{ isset($billingAddress->country)?$billingAddress->country: __('messages.common.n/a') }}</p>
                            </div>
                        @else
                            <div class="address-control col-sm-12 text-center">
                                <p class="font-weight-bold">{{ __('messages.customer.billing_address_details_not_available') }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="card my-0">
                            <div class="card-header pl-2">
                                <h4 class="text-black-50 font-weight-bold">{{ __('messages.customer.shipping_address') }}</h4>
                            </div>
                        </div>
                        @if(!empty($shippingAddress))
                            <div class="form-group col-sm-12">
                                {{ Form::label('street', __('messages.customer.street').':') }}
                                <p>{{ !empty($shippingAddress->street)?$shippingAddress->street: __('messages.common.n/a') }}</p>
                            </div>
                            <div class="form-group col-sm-12">
                                {{ Form::label('city', __('messages.customer.city').':') }}
                                <p>{{ !empty($shippingAddress->city)?$shippingAddress->city: __('messages.common.n/a') }}</p>
                            </div>
                            <div class="form-group col-sm-12">
                                {{ Form::label('zip', __('messages.customer.zip_code').':') }}
                                <p>{{ !empty($shippingAddress->zip)?$shippingAddress->zip: __('messages.common.n/a') }}</p>
                            </div>
                            <div class="form-group col-sm-12">
                                {{ Form::label('state', __('messages.customer.state').':') }}
                                <p>{{ !empty($shippingAddress->state)?$shippingAddress->state: __('messages.common.n/a') }}</p>
                            </div>
                            <div class="form-group col-sm-12">
                                {{ Form::label('country', __('messages.customer.country').':') }}
                                <p>{{ isset($shippingAddress->country)?$shippingAddress->country: __('messages.common.n/a') }}</p>
                            </div>
                        @else
                            <div class="address-control col-sm-12 text-center">
                                <p class="font-weight-bold">{{ __('messages.customer.shipping_address_details_not_available') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @include('customers.address-modal')
@endsection
