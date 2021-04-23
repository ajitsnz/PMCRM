<div class="row">
    <div class="form-group col-sm-4">
        {{ Form::label('first_name', __('messages.contact.first_name').':') }}
        <p>{{ html_entity_decode($contact->user->first_name) }}</p>
    </div>
    <div class="form-group col-sm-4">
        {{ Form::label('last_name', __('messages.contact.last_name').':') }}
        <p>{{ isset($contact->user->last_name) ? html_entity_decode($contact->user->last_name) : __('messages.common.n/a') }}</p>
    </div>
    <div class="form-group col-sm-4">
        {{ Form::label('customer_name', __('messages.contact.customer_name').':') }}
        <p><a href="{{ url('admin/customers',$contact->customer->id) }}"
              class="anchor-underline">{{ html_entity_decode($contact->customer->company_name) }}</a></p>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-4">
        {{ Form::label('email', __('messages.common.email').':') }}
        <p>{{ $contact->user->email }}</p>
    </div>
    <div class="form-group col-sm-4">
        {{ Form::label('phone', __('messages.customer.phone').':') }}
        <p>{{ isset($contact->user->phone) ? $contact->user->phone : __('messages.common.n/a') }}</p>
    </div>
    <div class="form-group col-sm-4">
        {{ Form::label('position', __('messages.contact.position').':') }}
        <p>{{ isset($contact->position)? html_entity_decode($contact->position) : __('messages.common.n/a') }}</p>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-4">
        {{ Form::label('is_active', __('messages.common.status').':') }}
        <p>{{ isset($contact->user->is_enable) && $contact->user->is_enable ? __('messages.contact.active') : __('messages.contact.deactive') }}</p>
    </div>
    <div class="form-group col-sm-4">
        {{ Form::label('created_at', __('messages.common.created_on').':') }}
        <p><span data-toggle="tooltip" data-placement="right"
                 title="{{ date('jS M, Y', strtotime($contact->created_at)) }}">{{ $contact->created_at->diffForHumans() }}</span>
        </p>
    </div>
    <div class="form-group col-sm-4">
        {{ Form::label('updated_at', __('messages.common.last_updated').':') }}
        <p><span data-toggle="tooltip" data-placement="right"
                 title="{{ date('jS M, Y', strtotime($contact->updated_at)) }}">{{ $contact->updated_at->diffForHumans() }}</span>
        </p>
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-4">
            <i class="font-size-medium {{$contact->primary_contact == 1? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-danger'}}"></i> &nbsp{{__('messages.contact.primary_contact') }}
    </div>
    <div class="form-group col-sm-4">
        <i class="font-size-medium {{$contact->send_welcome_email == 1? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-danger'}}"></i> &nbsp{{__('messages.contact.send_welcome_email') }}
    </div>
    <div class="form-group col-sm-4">
        <i class="font-size-medium {{$contact->send_password_email == 1? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-danger'}}"></i> &nbsp{{__('messages.contact.send_password_email') }}
    </div>
</div>
<div class="row">
    <div class="form-group col-sm-12">
        {{ Form::label('permissions', __('messages.contact.permissions').':',['class' => 'section-title']) }}
    </div>
</div>
<div class="row">
    @foreach($permissions as $id => $name)
        <div class="form-group col-sm-4">
            <i class="font-size-medium {{in_array($id, $contactPermissions) ? 'fas fa-check-circle text-success' : 'fas fa-times-circle text-danger'}}"></i> &nbsp{{ Illuminate\Support\Str::title(str_replace('_',' ',$name)) }}
        </div>
    @endforeach
</div>

