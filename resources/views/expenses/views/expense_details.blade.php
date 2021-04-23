@extends('expenses.show')
@section('section')
    @if(isset($expense) && $expense->billable == 1)
    <div class="row">
        <div class="form-group col-6 col-sm-4">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input"
                       id="customCheck1"
                       name="billable" value="1"
                       {{ (isset($expense) && $expense->billable == 1) ? 'checked' : '' }} disabled>
                <label class="custom-control-label"
                       for="customCheck1">{{__('messages.task.billable')}}</label>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('name', __('messages.expense.name').':') }}
                <p>{{ (isset($expense->name)) ? html_entity_decode($expense->name) : __('messages.common.n/a') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('expense_category_id', __('messages.expense.expense_category').':') }}
                <p>{{ html_entity_decode($expense->expenseCategory->name) }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('expense_date', __('messages.expense.expense_date').':') }}
                <p>{{ date('jS M, Y H:i A', strtotime($expense->expense_date)) }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('amount', __('messages.expense.amount').':') }}
                <p><i class="{{getCurrencyClass()}}"></i> {{ number_format($expense->amount, 2) }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('amount', __('messages.expense.amount_with_tax').':') }}
                <p>
                    @if($expense->tax_rate != 0)
                        <i class="{{getCurrencyClass()}}"></i>
                        {{ number_format($expense->tax_rate, 2) }}
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('customer_id', __('messages.expense.customer').':') }}
                <p>
                    @if(isset($expense->customer))
                        <a href="{{ url('admin/customers',$expense->customer->id) }}"
                           class="anchor-underline">{{ html_entity_decode($expense->customer->company_name) }}</a>
                    @else
                        {{ __('messages.common.n/a') }}
                    @endif
                </p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('receipt_attachment', __('messages.expense.attachment').':') }}
                <br>
                @if(isset($expense->media[0]))
                    <a href="{{ url('admin/expense-download-media',$expense->media[0]) }}"
                       class="text-decoration-none">{{ __('messages.common.download') }}
                    </a>
                @else
                    <p>{{ __('messages.common.n/a') }}</p>
                @endif
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('currency', __('messages.expense.currency').':') }}
                <p>{{ \App\Models\Expense::CURRENCIES[$expense->currency] }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('tax_1', __('messages.expense.tax_1').':') }}
                <p>{{ (isset($expense->tax_1_id)) ? $expense->tax1Rate->tax_rate : __('messages.common.n/a') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('tax_2', __('messages.expense.tax_2').':') }}
                <p>{{ (isset($expense->tax_2_id)) ? $expense->tax2Rate->tax_rate : __('messages.common.n/a') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('tax_applied', __('messages.expense.tax_applied').':') }}
                <p>{{ ($expense->tax_applied == 1) ? __('messages.common.yes') : __('messages.common.no') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('payment_mode_id', __('messages.expense.payment_mode').':') }}
                <p>{{ (isset($expense->paymentMode->name)) ? html_entity_decode($expense->paymentMode->name) : __('messages.common.n/a') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('reference', __('messages.expense.reference').':') }}
                <p>{{ (isset($expense->reference)) ? html_entity_decode($expense->reference) : __('messages.common.n/a') }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('created_at', __('messages.common.created_on').':') }}<br>
                <span data-toggle="tooltip" data-placement="right"
                      title="{{ date('jS M, Y', strtotime($expense->created_at)) }}">{{ $expense->created_at->diffForHumans() }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('updated_at', __('messages.common.last_updated').':') }}<br>
                <span data-toggle="tooltip" data-placement="right"
                      title="{{ date('jS M, Y', strtotime($expense->updated_at)) }}">{{ $expense->updated_at->diffForHumans() }}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('note', __('messages.expense.note').':') }}
                <br>{!! (isset($expense->note)) ? html_entity_decode($expense->note) : __('messages.common.n/a') !!}
            </div>
        </div>
    </div>
@endsection
