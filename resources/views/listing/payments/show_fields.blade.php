<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('payment_mode', __('messages.payment.payment_mode').':') }}
            <p>{{ $payment->paymentMode->name }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('transaction_id', __('messages.payment.transaction_id').':') }}
            <p>{{ (isset($payment->transaction_id)) ? $payment->transaction_id : __('messages.common.n/a') }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('payment_date', __('messages.payment.payment_date').':') }}
            <p>{{ date('jS M, Y g:i A', strtotime($payment->payment_date)) }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('amount_received', __('messages.payment.amount_received').':') }}
            <p><i class="{{ getCurrencyClass() }}"></i> {{ number_format($payment->amount_received) }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            {{ Form::label('send_mail_to_customer_contacts', __('messages.payment.send_mail_to_customer_contacts').':') }}
            <p>{{ ($payment->send_mail_to_customer_contacts == 1) ? __('messages.common.yes') : __('messages.common.no') }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('created_at', __('messages.common.created_on').':') }}<br>
            <span data-toggle="tooltip" data-placement="right"
                  title="{{ date('jS M, Y', strtotime($payment->created_at)) }}">{{ $payment->created_at->diffForHumans() }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('updated_at', __('messages.common.last_updated').':') }}
            <br>
            <span data-toggle="tooltip" data-placement="right"
                  title="{{ date('jS M, Y', strtotime($payment->updated_at)) }}">{{ $payment->updated_at->diffForHumans() }}</span>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('note', __('messages.payment.note').':') }}
            <p>{!! !empty($payment->note) ? nl2br(e($payment->note)) : __('messages.common.n/a')!!}</p>
        </div>
    </div>
</div>
