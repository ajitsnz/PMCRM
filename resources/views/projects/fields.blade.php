<div class="col-lg-12">
    <div class="row">
        <div class="form-group col-sm-6">
            {{ Form::label('project_name', __('messages.project.project_name').':') }}<span class="required">*</span>
            {{ Form::text('project_name', isset($project->project_name) ? $project->project_name : null, ['class' => 'form-control', 'required','autocomplete' => 'off']) }}
        </div>
        <div class="form-group col-sm-6">
            {{ Form::label('customer_id', __('messages.project.customer').':') }}<span class="required">*</span>
            {{ Form::select('customer_id', $data['customers'], isset($project->customer_id) ? $project->customer_id : $customerId, ['class' => 'form-control', 'id' => 'customersSelectBox', 'autocomplete' => 'off', 'required', 'placeholder' => 'Select Customer']) }}
        </div>
        <div class="form-group col-sm-6">
            {{ Form::label('contacts', __('messages.contacts').':') }}<span class="required">*</span>
            {{ Form::select('contacts[]', [], null, ['class' => 'form-control', 'id' => 'contactsSelectBox','required', 'multiple' => true]) }}
        </div>
        <div class="form-group col-sm-6">
            {{ Form::label('members', __('messages.members').':') }}<span class="required">*</span>
            {{ Form::select('members[]', $data['members'], isset($project->members) ? $project->members->pluck('user_id') : null, ['class' => 'form-control', 'id' => 'membersSelectBox','required', 'autocomplete' => 'off', 'multiple' => 'multiple']) }}
        </div>
        <div class="form-group col-sm-6">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="calculate_progress_through_tasks"
                       {{isset($project->calculate_progress_through_tasks) ? $project->calculate_progress_through_tasks == 1 ? 'checked' : '' : ''}} id="calculateProgressThroughTasks">
                <label class="custom-control-label"
                       for="calculateProgressThroughTasks">{{ __('messages.project.calculate_progress_through_tasks') }}</label>
            </div>
        </div>
        <div class="form-group col-sm-11">
            {{ Form::label('progress', __('messages.project.progress').':') }}
            {{ Form::range('progress', isset($project->progress) ? $project->progress : 0, ['class' => 'form-control-range',' min' => '0', 'max' => '100', 'id' => 'projectProgress']) }}
        </div>
        <div class="form-group col-sm-1 d-flex align-items-center">
            <span class="projectProgressPercentage mt-4" id="percentageId">{{ isset($project->progress) ? $project->progress : 0 }}%</span>
        </div>
        <div class="form-group col-lg-6 col-sm-12">
            {{ Form::label('billing_type', __('messages.project.billing_type').':') }}<span class="required">*</span>
            {{ Form::select('billing_type', $data['billingTypes'], isset($project->billing_type) ? $project->billing_type : null, ['class' => 'form-control', 'id' => 'billingTypeSelectBox','required','placeholder' => 'Select Billing Type']) }}
        </div>
        <div class="form-group col-lg-6 col-sm-12">
            {{ Form::label('status', __('messages.project.status').':') }}<span class="required">*</span>
            {{ Form::select('status', $data['status'], isset($project->status) ? $project->status : null, ['class' => 'form-control', 'id' => 'statusSelectBox','required','placeholder' => 'Select Status']) }}
        </div>
        <div class="form-group col-sm-6">
            {{ Form::label('estimated_hours', __('messages.project.estimated_hours').':') }}
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-clock"></i>
                    </div>
                </div>
                {{ Form::text('estimated_hours', isset($project->estimated_hours) ? $project->estimated_hours : null, ['class' => 'form-control', 'id' => 'estimatedHours', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="form-group col-sm-6">
            {{ Form::label('start_date', __('messages.project.start_date').':') }}<span class="required">*</span>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                {{ Form::text('start_date', isset($project->start_date) ? date('Y-m-d H:i:s', strtotime($project->start_date)) : null, ['class' => 'form-control', 'id' => 'startDate', 'autocomplete' => 'off', 'required']) }}
            </div>
        </div>
        <div class="form-group col-sm-6">
            {{ Form::label('deadline', __('messages.project.deadline').':') }}<span class="required">*</span>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                </div>
                {{ Form::text('deadline',  isset($project->deadline) ? date('Y-m-d H:i:s', strtotime($project->deadline)) : null, ['class' => 'form-control', 'id' => 'deadline', 'autocomplete' => 'off', 'required']) }}
            </div>
        </div>
        <div class="form-group col-sm-6">
            {{ Form::label('tags', __('messages.tags').':') }}
            {{ Form::select('tags[]', $data['tags'], isset($project->tags) ? $project->tags->pluck('id') : null, ['class' => 'form-control', 'id' => 'tagsSelectBox', 'multiple' => 'multiple']) }}
        </div>
        <div class="form-group col-sm-12 mb-0">
            {{ Form::label('description', __('messages.common.description').':') }}
            {{ Form::textarea('description', isset($project->description) ? $project->description : null, ['class' => 'form-control summernote-simple', 'id' => 'projectDescription']) }}
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input"
                       {{ isset($project->send_email) ? $project->send_email == 1 ?'checked' : '' : '' }} name="send_email"
                       id="sendEmail">
                <label class="custom-control-label"
                       for="sendEmail">{{ __('messages.project.send_project_created_email') }}</label>
            </div>
        </div>
        <div class="col-sm-12">
            {{ Form::button(__('messages.common.save'), ['type'=>'submit','class' => 'btn btn-primary', 'id' => 'btnSave','data-loading-text'=>"<span class='spinner-border spinner-border-sm'></span> Processing..."]) }}
            <a href="{{ url()->previous() }}"
               class="btn btn-secondary text-dark">{{ __('messages.common.cancel') }}</a>
        </div>
    </div>
</div>
