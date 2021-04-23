<div class="card-body">
    <div class="alert alert-danger d-none" id="validationErrorsBox"></div>
    <div class="row">
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('title', __('messages.proposal.title').':') }}<span class="required">*</span>
            {{ Form::text('title', isset($proposal->title) ?  $proposal->title : null, ['class' => 'form-control', 'required','autocomplete' => 'off','autofocus']) }}
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
                {{ Form::text('date', isset($proposal->date) ? $proposal->date : null, ['class' => 'form-control datepicker', 'required', 'autocomplete' => 'off']) }}
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
                {{ Form::text('open_till', isset($proposal->open_till) ? $proposal->open_till : null, ['class' => 'form-control due-datepicker', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('assigned', __('messages.proposal.member').':') }}<span class="required">*</span>
            {{ Form::select('assigned_user_id', $data['users'], null, ['class' => 'form-control assigned-select-box', 'autocomplete' => 'off', 'placeholder' => 'Select option', 'required']) }}
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('currency', __('messages.customer.currency').':') }}<span class="required">*</span>
            <select id="proposalCurrencyId" data-show-content="true" class="form-control currency-select-box"
                    name="currency" required>
                <option value="0" disabled="true" selected="true">Select Currency</option>
                @foreach($data['currencies'] as $key => $currency)
                    <option value="{{$key}}" {{ ($key == getCurrentCurrencyIndex(getCurrentCurrency())) ? 'selected' : '' }}>
                        &#{{getCurrencyIcon($key)}}&nbsp;&nbsp;&nbsp; {{$currency}}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('discount_type', __('messages.invoice.discount_type').':') }}<span
                    class="required">*</span>
            {{ Form::select('discount_type', $data['discountType'], isset($invoice->discount_type) ? $invoice->discount_type : null, ['class' => 'form-control','required', 'id' => 'discountTypeSelect', 'placeholder' => 'Select Discount Type']) }}
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('tag', __('messages.tags').':') }}
            {{ Form::select('tags[]', $data['tags'], null, ['class' => 'form-control tags-select-box', 'autocomplete' => 'off', 'multiple' => 'multiple']) }}
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-4">
            <a href="#" data-toggle="modal" data-target="#addModal" class="mr-3 addressModalIcon"><i
                        class="fa fa-edit"></i></a>
            {{ Form::label('address', __('messages.customer.address').':') }}
            <div id="address_to" class="ml-5">
                _ _ _ _ _ _
            </div>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('phone', __('messages.member.phone').(':')) }}<br>
            {{ Form::tel('phone', isset($proposal->phone) ? $proposal->phone : null, ['class' => 'form-control phone','id' => 'phoneNumber', 'onkeyup' => 'if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,"")','autocomplete' => 'off']) }}
            {{ Form::hidden('prefix_code',old('prefix_code'),['id'=>'prefix_code']) }}
            <span id="valid-msg" class="hide">✓ &nbsp; Valid</span>
            <span id="error-msg" class="hide"></span>
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12">
            {{ Form::label('related', __('messages.proposal.related').':') }}<span class="required">*</span>
            {{ Form::select('related_to', $data['related'], isset($relatedTo) ? array_search($relatedTo, $data['related']) : null, ['id' => 'relatedToId', 'class' => 'form-control related-select-box','required', 'placeholder' => 'Select Option']) }}
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12 related-to-field1">
            {{ Form::label('ownerId', __('messages.proposal.lead').':') }}<span class="required">*</span>
            {{ Form::select('owner_id', $data['leads'], isset($proposal->owner_id) ? $proposal->owner_id : null, ['id' => 'leadOwnerId', 'class' => 'form-control ownerid-select-box', 'required', 'placeholder' => 'Select Lead']) }}
        </div>
        <div class="form-group col-lg-4 col-md-4 col-sm-12 related-to-field2">
            {{ Form::label('ownerId', __('messages.invoice.customer').':') }}<span class="required">*</span>
            {{ Form::select('owner_id', $data['customers'], isset($proposal->owner_id) ? $proposal->owner_id : null, ['id'=>'customerSelectBox','class' => 'form-control ownerid-select-box','required', 'placeholder' => 'Select Customer']) }}
        </div>
    </div>
    <hr>
    <br>
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
                           checked>
                    <label class="custom-control-label" for="qty">{{ __('messages.invoice.qty') }}</label>
                </div>
                <div class="custom-control custom-radio mr-3 d-inline-block">
                    <input type="radio" id="hours" name="unit" required value="2" class="custom-control-input" data-quantity-for="hours">
                    <label class="custom-control-label" for="hours">{{ __('messages.invoice.hours') }}</label>
                </div>
                <div class="custom-control custom-radio d-inline-block">
                    <input type="radio" id="qtyHours" name="unit" required value="3"
                           class="custom-control-input" data-quantity-for="qtyHours">
                    <label class="custom-control-label"
                           for="qtyHours">{{ __('messages.invoice.qty/hours') }}</label>
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
                <tr>
                    <th><input type="text" name="item[]" class="form-control item-name" required></th>
                    <td><textarea name="description[]" class="form-control item-description"></textarea></td>
                    <td><input type="text" name="quantity[]" class="form-control qty" required min="0"></td>
                    <td><input type="text" name="rate[]" class="form-control rate" required></td>
                    <td class="">
                        <select name="" class="form-control tax-rates" multiple>
                        </select>
                    </td>
                    <td><i data-set-currency-class="true"></i> <span class="item-amount">0</span></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-lg-2 col-md-6 col-sm-12">
            {{ Form::label('sub_total', __('messages.proposal.sub_total').':') }}
            <p><i data-set-currency-class="true"></i> <span id="subTotal">0</span></p>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="fDiscount form-group">
                {{ Form::label('discount', __('messages.invoice.discount').':') }}
                (<i data-set-currency-class="true"></i> <span class="footer-discount-numbers">0</span>)
                <div class="input-group">
                    {{ Form::text('final_discount', 0, ['class' => 'form-control footer-discount-input']) }}
                    <div class="input-group-append">
                        <select class="input-group-text dropdown" id="footerDiscount" name="discount_symbol">
                            <div class="dropdown-menu">
                                <option value="1" class="dropdown-item">%</option>
                                <option value="2"
                                        class="dropdown-item">{{ __('messages.invoice.fixed') }}</option>
                            </div>
                        </select>
                    </div>
                </div>
            </div>
            <table id="taxesListTable" class="w-100">
            </table>
        </div>
        <div class="form-group col-lg-3 col-md-6 col-sm-12">
            {{ Form::label('adjustment', __('messages.invoice.adjustment').':') }}
            (<i data-set-currency-class="true"></i> <span class="adjustment-numbers">0</span>)
            {{ Form::number('adjustment', 0, ['class' => 'form-control', 'id' => 'adjustment']) }}
        </div>
        <div class="form-group col-lg-3 col-md-6 col-sm-12">
            {{ Form::label('total', __('messages.invoice.total').':') }}
            <p><i data-set-currency-class="true"></i> <span class="total-numbers">0</span></p>
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
                        <a href="#" class="dropdown-item" id="saveAsDraft"
                           data-status="1">{{ __('messages.proposal.save_as_draft') }}</a>
                    </li>
                    <li>
                        <a href="#" class="dropdown-item" id="saveAndSend"
                           data-status="2">{{ __('messages.proposal.save_and_send') }}</a>
                    </li>
                </ul>
            </div>
            <a href="{{ url()->previous() }}"
               class="btn btn-secondary text-dark ml-2">{{ __('messages.common.cancel') }}</a>
        </div>
    </div>
</div>
