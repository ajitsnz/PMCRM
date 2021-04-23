<input type="hidden" id="hdnProposalId" value="{{$proposal->id}}">
<div class="card-body">
    <div class="alert alert-danger d-none" id="validationErrorsBox"></div>
    <div class="row">
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('title', __('messages.proposal.title').':') }}<span class="required">*</span>
            {{ Form::text('title', isset($proposal->title) ? $proposal->title : null, ['class' => 'form-control', 'required','autocomplete' => 'off','autofocus']) }}
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('proposal_number',__('messages.proposal.proposal_number') .':') }}<span
                    class="required">*</span>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        {{ __('messages.proposal.proposal_prefix') }}
                    </div>
                </div>
                {{ Form::text('proposal_number',isset($proposal->proposal_number) ? $proposal->proposal_number : generateUniqueProposalNumber() ,
                   ['class' => 'form-control', 'readonly' => 'true']) }}
            </div>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('date', __('messages.proposal.date').':') }} <span class="required">*</span>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                {{ Form::text('date', isset($proposal->date) ? date('Y-m-d H:i:s', strtotime($proposal->date)) : null, ['class' => 'form-control datepicker', 'required', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('open_till', __('messages.proposal.open_till').':') }}
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                {{ Form::text('open_till', isset($proposal->open_till) ? date('Y-m-d H:i:s', strtotime($proposal->open_till)) : null, ['class' => 'form-control due-datepicker', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('assigned', __('messages.proposal.member').':') }}<span class="required">*</span>
            {{ Form::select('assigned_user_id', $data['users'], $proposal->assigned_user_id, ['class' => 'form-control assigned-select-box', 'autocomplete' => 'off', 'placeholder' => 'Select option', 'required']) }}
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('currency', __('messages.customer.currency').':') }}<span class="required">*</span>
            <select id="proposalCurrencyId" data-show-content="true" class="form-control currency-select-box" name="currency" required>
                <option value="0" disabled="true" {{ isset($proposal->currency) ? '' : 'selected' }}>Select Currency
                </option>
                @foreach($data['currencies'] as $key => $currency)
                    <option value="{{$key}}" {{ (isset($proposal->currency) ? $proposal->currency : null) == $key ? 'selected' : ''}}>
                        &#{{getCurrencyIcon($key)}}&nbsp;&nbsp;&nbsp; {{$currency}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('discount_type', __('messages.invoice.discount_type').':') }}<span
                    class="required">*</span>
            {{ Form::select('discount_type', $data['discountType'], isset($proposal->discount_type) ? $proposal->discount_type : null, ['class' => 'form-control','required', 'id' => 'discountTypeSelect', 'placeholder' => 'Select discount type']) }}
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('tag', __('messages.tags').':') }}
            {{ Form::select('tags[]', $data['tags'], $proposal->tags->pluck('id'), ['class' => 'form-control tags-select-box', 'autocomplete' => 'off', 'multiple' => 'multiple']) }}
        </div>
        <div class="form-group col-sm-4">
            <a href="#" data-toggle="modal" data-target="#addModal" class="mr-3 addressModalIcon"><i
                        class="fa fa-edit"></i></a>
            {{ Form::label('address', __('messages.customer.address').':') }}
            <div id="address_to" class="ml-5">
                _ _ _ _ _ _
            </div>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('phone', __('messages.member.phone').(':')) }}<br>
            {{ Form::tel('phone', isset($proposal->phone) ? $proposal->phone : null, ['class' => 'form-control phone','id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")']) }}
            {{ Form::hidden('prefix_code',old('prefix_code'),['id'=>'prefix_code']) }}
            <span id="valid-msg" class="hide">✓ &nbsp; Valid</span>
            <span id="error-msg" class="hide"></span>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('related', __('messages.proposal.related').':') }}<span class="required">*</span>
            {{ Form::select('related_to',$data['related'] , isset($proposal->related_to) ? $proposal->related_to : null, ['class' => 'form-control related-select-box', 'required','placeholder' => 'Select Member']) }}
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12 related-to-field1">
            {{ Form::label('ownerId', __('messages.proposal.lead').':') }}<span class="required">*</span>
            {{ Form::select('owner_id', $data['leads'], isset($proposal->owner_id) ? $proposal->owner_id : null, ['id' => 'leadOwnerId','class' => 'form-control ownerid-select-box','required', 'placeholder' => 'Select Lead']) }}
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12 related-to-field2">
            {{ Form::label('ownerId', __('messages.invoice.customer').':') }}<span class="required">*</span>
            {{ Form::select('owner_id', $data['customers'], isset($proposal->owner_id) ? $proposal->owner_id : null, ['id' => 'customerSelectBox','class' => 'form-control ownerid-select-box', 'required', 'placeholder' => 'Select Customer']) }}
        </div>
    </div>
    <hr/>
    <br/>
    <div class="row">
        <div class="form-group col-lg-6 col-md-12 col-sm-12">
            <div class="input-group">
                {{ Form::select('item', $data['items'], null, ['class' => 'form-control', 'id' => 'addItemSelectBox', 'placeholder' => 'Select Product']) }}
            </div>
        </div>
        <div class="form-group col-lg-6 col-md-12 col-sm-12 showQuantityAs d-flex align-items-center justify-content-end">
            <span class="font-weight-bold mr-2">{{ __('messages.invoice.show_quantity_as').':' }}</span>
            <div class="float-right showQuantityAs">
                <div class="custom-control custom-radio mr-3 d-inline-block">
                    <input type="radio" id="qty" name="unit" required value="1" class="custom-control-input" data-quantity-for="qty"
                            {{$proposal->unit == 1 ? 'checked' : ''}}>
                    <label class="custom-control-label" for="qty">{{ __('messages.invoice.qty') }}</label>
                </div>
                <div class="custom-control custom-radio mr-3 d-inline-block">
                    <input type="radio" id="hours" name="unit" required value="2" class="custom-control-input" data-quantity-for="hours"
                            {{$proposal->unit == 2 ? 'checked' : ''}}>
                    <label class="custom-control-label" for="hours">{{ __('messages.invoice.hours') }}</label>
                </div>
                <div class="custom-control custom-radio d-inline-block">
                    <input type="radio" id="qtyHours" name="unit" required value="3" class="custom-control-input" data-quantity-for="qtyHours"
                            {{$proposal->unit == 3 ? 'checked' : ''}}>
                    <label class="custom-control-label"
                           for="qtyHours">{{ __('messages.invoice.qty_hours') }}</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-12 col-md-12 col-sm-12 overflow-section">
            <table class="table table-responsive-sm table-responsive-md table-striped table-bordered">
                <thead>
                <tr>
                    <th>{{ __('messages.proposal.item') }}<span class="required">*</span></th>
                    <th>{{ __('messages.common.description') }}</th>
                    <th class="small-column"><span class="qtyHeader">{{ __('messages.proposal.qty') }}</span><span class="required">*</span></th>
                    <th class="small-column">{{ __('messages.item.rate') }}(<i data-set-currency-class="true"></i>)<span class="required">*</span>
                    </th>
                    <th class="medium-column">{{ __('messages.item.tax') }}(<i class="fas fa-percentage"></i>)</th>
                    <th class="small-column">{{ __('messages.proposal.amount') }}<span class="required">*</span></th>
                    <th class="button-column"><a href="#" id="itemAddBtn"><i class="fas fa-plus"></i></a></th>
                </tr>
                </thead>
                <tbody class="items-container">
                @foreach($proposal->salesItems as $item)
                    <tr>
                        <th><input type="text" name="item[]" class="form-control item-name" required
                                   value="{{ html_entity_decode($item->item) }}"></th>
                        <td><textarea name="description[]" class="form-control item-description"
                            >{!! nl2br(e($item->description))!!}</textarea></td>
                        <td><input type="text" name="quantity[]" class="form-control qty" required min="0"
                                   value="{{$item->quantity}}"></td>
                        <td><input type="text" name="rate[]" class="form-control rate" required value="{{$item->rate}}">
                        </td>
                        <td class="">
                            {{ Form::select('tax[]', $data['taxesArr'], $item->taxes->pluck('id'), ['class' => 'form-control tax-rates', 'multiple']) }}
                        </td>
                        <td><i data-set-currency-class="true"></i> <span
                                    class="item-amount">{{number_format($item->total)}}</span></td>
                        <td><a href="#" class="remove-invoice-item text-danger"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-2 col-md-6 col-sm-12">
            {{ Form::label('sub_total', __('messages.proposal.sub_total').':') }}
            <p><i data-set-currency-class="true"></i> <span id="subTotal">{{$proposal->sub_total}}</span></p>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="fDiscount form-group">
                {{ Form::label('discount', __('messages.proposal.discount').':') }}
                (<i data-set-currency-class="true"></i> <span
                        class="footer-discount-numbers">{{ formatNumber($proposal->discount)}}</span>)
                <div class="input-group">
                    {{ Form::text('final_discount', $proposal->discount, ['class' => 'form-control footer-discount-input']) }}
                    <div class="input-group-append">
                        @if(isset($proposal->discount_type) && $proposal->discount_type === 0)
                            <input type="hidden" name="discount_symbol" value="0">
                        @endif
                        <select class="input-group-text dropdown" id="footerDiscount" name="discount_symbol">
                            <div class="dropdown-menu">
                                <option value="1"
                                        class="dropdown-item" {{ isset($proposal->discount_symbol) && $proposal->discount_symbol == 1 ?  'selected':'' }}>
                                    %
                                </option>
                                <option value="2"
                                        class="dropdown-item" {{ isset($proposal->discount_symbol) && $proposal->discount_symbol == 2 ?  'selected':'' }}>{{ __('messages.invoice.fixed') }}</option>
                            </div>
                        </select>
                    </div>
                </div>
            </div>
            <table id="taxesListTable" class="w-100">
                @foreach($proposal->salesTaxes as $tax)
                    <tr>
                        <td colspan="2" class="font-weight-bold tax-value">{{$tax->tax}}%</td>
                        <td class="footer-numbers footer-tax-numbers">{{$tax->amount}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="form-group col-lg-3 col-md-6 col-sm-12">
            {{ Form::label('adjustment', __('messages.proposal.adjustment').':') }}
            (<i data-set-currency-class="true"></i> <span
                    class="adjustment-numbers">{{number_format($proposal->adjustment)}}</span>)
            {{ Form::number('adjustment', $proposal->adjustment, ['class' => 'form-control', 'id' => 'adjustment']) }}
        </div>
        <div class="form-group col-lg-3 col-md-6 col-sm-12">
            {{ Form::label('total', __('messages.proposal.total').':') }}
            <p><i data-set-currency-class="true"></i> <span
                        class="total-numbers">{{number_format($proposal->total_amount)}}</span></p>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-sm-12">
            <div class="btn-group dropup open">
                {{ Form::button('Save', ['class' => 'btn btn-primary']) }}
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="true">
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-left width200">
                    <li>
                        <a href="#" class="dropdown-item" id="editSaveSend"
                           data-status="2">{{ __('messages.proposal.save_and_send') }}</a>
                    </li>
                </ul>
            </div>
            <a href="{{ url()->previous() }}"
               class="btn btn-secondary text-dark ml-2">{{ __('messages.common.cancel') }}</a>
        </div>
    </div>
</div>
