{{-- Admin And Client Notes --}}
<div class="row">
    <input type="hidden" name="group" value="{{\App\Models\Setting::NOTE}}">
    <div class="form-group col-sm-12 col-md-12 col-lg-12">
        {{ Form::label('admin_note', __('messages.common.admin_note').':') }}
        {{ Form::textarea('admin_note', $settings['admin_note'], ['class' => 'form-control summernote-simple']) }}
    </div>
    <div class="form-group col-sm-12 col-md-12 col-lg-12">
        {{ Form::label('client_note', __('messages.common.client_note').':') }}
        {{ Form::textarea('client_note', $settings['client_note'], ['class' => 'form-control summernote-simple']) }}
    </div>
</div>
<div class="row">
    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {{ Form::submit(__('messages.common.save'), ['class' => 'btn btn-primary']) }}
    </div>
</div>
