<input type="hidden" id="estimateId" value="{{$estimate->id}}">
<div class="card-body">
    <div class="alert alert-danger d-none" id="validationErrorsBox"></div>

    <div class="row">
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('title', __('messages.estimate.title').':') }}<span class="required">*</span>
            {{ Form::text('title', isset($estimate->title) ? $estimate->title : null, ['class' => 'form-control', 'required','autocomplete' => 'off','autofocus']) }}
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('estimate_number', __('messages.estimate.estimate_number').':') }}<span
                    class="required">*</span>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        {{ __('messages.estimate.estimate_prefix') }}
                    </div>
                </div>
                {{ Form::text('estimate_number', isset($estimate->estimate_number) ? $estimate->estimate_number : generateUniqueEstimateNumber(), ['class' => 'form-control', 'required', 'id' => 'estimateNumber']) }}
            </div>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('customer', __('messages.invoice.customer').':') }}<span class="required">*</span>
            {{ Form::select('customer_id', $data['customers'], isset($estimate->customer_id) ? $estimate->customer_id : null, ['class' => 'form-control', 'required', 'id' => 'customerSelectBox', 'placeholder' => 'Select Customer']) }}
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('estimate_date', __('messages.estimate.estimate_date').':') }} <span
                    class="required">*</span>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                {{ Form::text('estimate_date', isset($estimate->estimate_date) ? date('Y-m-d H:i:s', strtotime($estimate->estimate_date))  : null, ['class' => 'form-control datepicker', 'required', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('expiry_date', __('messages.estimate.expiry_date').':') }}
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                {{ Form::text('estimate_expiry_date', isset($estimate->estimate_expiry_date) ? date('Y-m-d H:i:s', strtotime($estimate->estimate_expiry_date)) : null, ['class' => 'form-control due-datepicker', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('tag', __('messages.tags').':') }}
            {{ Form::select('tags[]', $data['tags'], isset($estimate->tags) ? $estimate->tags : null, ['class' => 'form-control tags-select-box', 'autocomplete' => 'off', 'multiple' => 'multiple']) }}
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('currency', __('messages.customer.currency').':') }}<span class="required">*</span>
            <select id="estimateCurrencyId" data-show-content="true" class="form-control currency-select-box"
                    name="currency" required>
                <option value="0" disabled="true" {{ isset($estimate->currency) ? '' : 'selected' }}>Select Currency
                </option>
                @foreach($data['currencies'] as $key => $currency)
                    <option value="{{$key}}" {{ (isset($estimate->currency) ? $estimate->currency : null) == $key ? 'selected' : ''}}>
                        &#{{getCurrencyIcon($key)}}&nbsp;&nbsp;&nbsp; {{$currency}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('reference', __('messages.credit_note.reference').':') }}
            {{ Form::text('reference', isset($estimate->reference) ? $estimate->reference : null, ['class' => 'form-control','autocomplete' => 'off']) }}
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('sale_agent', __('messages.invoice.sale_agent').':') }}
            {{ Form::select('sales_agent_id', $data['saleAgents'], isset($estimate->sales_agent_id) ? $estimate->sales_agent_id : null, ['class' => 'form-control sale-agent-select-box','id' => 'saleAgentId', 'placeholder' => 'Select Sale Agent']) }}
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('discount_type', __('messages.invoice.discount_type').':') }}<span
                    class="required">*</span>
            {{ Form::select('discount_type', $data['discountType'], isset($estimate->discount_type) ? $estimate->discount_type : null, ['class' => 'form-control', 'id' => 'discountTypeSelect', 'required', 'placeholder' => 'Select Discount Type']) }}
        </div>
        <div class="form-group col-lg-2 col-md-4 col-sm-12">
            <a href="#" data-toggle="modal" data-target="#addModal" class="mr-3 addressModalIcon"><i
                        class="fa fa-edit"></i></a>
            {{ Form::label('bill_to', __('messages.invoice.bill_to').':') }}
            <div id="bill_to" class="ml-5">
                _ _ _ _ _ _
            </div>
        </div>
        <div class="form-group col-lg-2 col-md-4 col-sm-12">
            {{ Form::label('ship_to', __('messages.invoice.ship_to').':') }}
            <div id="ship_to">
                _ _ _ _ _ _
            </div>
        </div>
        <div class="form-group col-lg-12 col-md-12 col-sm-12">
            {{ Form::label('admin_note', __('messages.invoice.admin_note').':') }}
            {{ Form::textarea('admin_note', isset($estimate->admin_note) ? nl2br(e($estimate->admin_note)) : null, ['class' => 'form-control summernote-simple', 'id' => 'editAdminNote']) }}
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
                            {{$estimate->unit == 1 ? 'checked' : ''}}>
                    <label class="custom-control-label" for="qty">{{ __('messages.invoice.qty') }}</label>
                </div>
                <div class="custom-control custom-radio mr-3 d-inline-block">
                    <input type="radio" id="hours" name="unit" required value="2" class="custom-control-input" data-quantity-for="hours"
                            {{$estimate->unit == 2 ? 'checked' : ''}}>
                    <label class="custom-control-label" for="hours">{{ __('messages.invoice.hours') }}</label>
                </div>
                <div class="custom-control custom-radio d-inline-block">
                    <input type="radio" id="qtyHours" name="unit" required value="3" class="custom-control-input" data-quantity-for="qtyHours"
                            {{$estimate->unit == 3 ? 'checked' : ''}}>
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
                    <th>{{ __('messages.estimate.item') }}<span class="required">*</span></th>
                    <th>{{ __('messages.common.description') }}</th>
                    <th class="small-column"><span class="qtyHeader">{{ __('messages.estimate.qty') }}</span><span class="required">*</span></th>
                    <th class="small-column">{{ __('messages.estimate.rate') }}(<i data-set-currency-class="true"></i>)<span
                                class="required">*</span></th>
                    <th class="medium-column">{{ __('messages.estimate.taxes') }}(<i class="fas fa-percentage"></i>)
                    </th>
                    <th class="small-column">{{ __('messages.estimate.amount') }}<span class="required">*</span></th>
                    <th class="button-column"><a href="#" id="itemAddBtn"><i class="fas fa-plus"></i></a></th>
                </tr>
                </thead>
                <tbody class="items-container">
                @foreach($estimate->salesItems as $item)
                    <tr>
                        <td>
                            {{ Form::text('item[]',$item->item,['class' => 'form-control item-name','required']) }}
                        </td>
                        <td><textarea name="description[]" class="form-control item-description"
                            >{!! nl2br(e($item->description))!!}</textarea></td>
                        <td>
                            {{ Form::text('quantity[]',$item->quantity,['class' => 'form-control qty','required','min' => '0']) }}
                        </td>
                        <td>
                            {{ Form::text('rate[]',$item->rate,['class' => 'form-control rate','required']) }}
                        </td>
                        <td class="">
                            {{ Form::select('tax[]', $data['taxesArr'], $item->taxes->pluck('id'), ['class' => 'form-control tax-rates', 'multiple']) }}
                        </td>
                        <td class="item-amount-width"><i data-set-currency-class="true"></i> <span
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
            {{ Form::label('sub_total', __('messages.invoice.sub_total').':') }}
            <p><i data-set-currency-class="true"></i> <span id="subTotal">{{$estimate->sub_total}}</span></p>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="fDiscount form-group">
                {{ Form::label('discount', __('messages.invoice.discount').':') }}
                (<i data-set-currency-class="true"></i> <span
                        class="footer-discount-numbers">{{ formatNumber($estimate->discount)}}</span>)
                <div class="input-group">
                    {{ Form::text('final_discount', $estimate->discount, ['class' => 'form-control footer-discount-input']) }}
                    <div class="input-group-append">
                        @if(isset($estimate->discount_type) && $estimate->discount_type === 0)
                            <input type="hidden" name="discount_symbol" value="0">
                        @endif
                        <select class="input-group-text dropdown" id="footerDiscount" name="discount_symbol">
                            <div class="dropdown-menu">
                                <option value="1"
                                        class="dropdown-item" {{ isset($estimate->discount_symbol) && $estimate->discount_symbol == 1 ?  'selected':'' }}>
                                    %
                                </option>
                                <option value="2"
                                        class="dropdown-item" {{ isset($estimate->discount_symbol) && $estimate->discount_symbol == 2 ?  'selected':'' }}>{{ __('messages.invoice.fixed') }}</option>
                            </div>
                        </select>
                    </div>
                </div>
            </div>
            <table id="taxesListTable" class="w-100">
                @foreach($estimate->salesTaxes as $tax)
                    <tr>
                        <td colspan="2" class="font-weight-bold tax-value">{{$tax->tax}}%</td>
                        <td class="footer-numbers footer-tax-numbers">{{$tax->amount}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="form-group col-lg-3 col-md-6 col-sm-12">
            {{ Form::label('adjustment', __('messages.estimate.adjustment').':') }}
            (<i data-set-currency-class="true"></i> <span
                    class="adjustment-numbers">{{number_format($estimate->adjustment)}}</span>)
            {{ Form::number('adjustment', $estimate->adjustment, ['class' => 'form-control', 'id' => 'adjustment']) }}
        </div>
        <div class="form-group col-lg-3 col-md-6 col-sm-12">
            {{ Form::label('total', __('messages.invoice.total').':') }}
            <p><i data-set-currency-class="true"></i> <span
                        class="total-numbers">{{number_format($estimate->total_amount)}}</span></p>
        </div>
    </div>

    <div class="row">
        <div class="form-group col-lg-12 col-md-12 col-sm-12">
            {{ Form::label('client_note', __('messages.invoice.client_note').':') }}
            {{ Form::textarea('client_note', isset($estimate->client_note) ? nl2br(e($estimate->client_note)) : null, ['class' => 'form-control summernote-simple', 'id' => 'editClientNote']) }}
        </div>
        <div class="form-group col-lg-12 col-md-12 col-sm-12">
            {{ Form::label('terms_conditions', __('messages.invoice.terms_conditions').':') }}
            {{ Form::textarea('term_conditions', isset($estimate->term_conditions) ? nl2br(e($estimate->term_conditions)) : null, ['class' => 'form-control summernote-simple', 'id' => 'editTermAndConditions']) }}
        </div>
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
                           data-status="1">{{ __('messages.estimate.save_and_send') }}</a>
                    </li>
                </ul>
            </div>
            <a href="{{ url()->previous() }}"
               class="btn btn-secondary text-dark ml-3">{{ __('messages.common.cancel') }}</a>
        </div>
    </div>
</div>
