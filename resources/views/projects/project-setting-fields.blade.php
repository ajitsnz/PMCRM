<div class="col-lg-12">
    <div class="row">
        <div class="form-group col-sm-12">
            {{ Form::label('visible_tables', __('messages.project.visible_tables').':') }}
            {{ Form::select('visible_tables', [], null, ['class' => 'form-control', 'id' => 'tablesSelectBox']) }}
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="view_tasks" id="viewTasks">
                <label class="custom-control-label" for="viewTasks">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.view_tasks') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="create_tasks" id="createTasks">
                <label class="custom-control-label" for="createTasks">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.create_tasks') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="edit_tasks" id="editTasks">
                <label class="custom-control-label" for="editTasks">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.edit_tasks') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="comment_on_task" id="commentOnTask">
                <label class="custom-control-label" for="commentOnTask">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.comment_on_project_tasks') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="view_comments" id="viewComments">
                <label class="custom-control-label" for="viewComments">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.view_task_comments') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="view_attachments" id="viewAttachments">
                <label class="custom-control-label" for="viewAttachments">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.view_task_attachments') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="upload_attachments" id="uploadAttachements">
                <label class="custom-control-label" for="uploadAttachements">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.upload_attachments_on_tasks') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="view_logged_time" id="viewTaskLoggedTime">
                <label class="custom-control-label" for="viewTaskLoggedTime">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.view_task_total_logged_time') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="view_finance_overview" id="viewFinanceOverview">
                <label class="custom-control-label" for="viewFinanceOverview">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.view_finance_overview') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="upload_files" id="uploadFiles">
                <label class="custom-control-label" for="uploadFiles">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.upload_files') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="open_discussions" id="openDiscussions">
                <label class="custom-control-label" for="openDiscussions">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.upload_files') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="view_milestones" id="viewMilestones">
                <label class="custom-control-label" for="viewMilestones">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.view_milestones') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="view_gantt" id="viewGantt">
                <label class="custom-control-label" for="viewGantt">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.view_gantt') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="view_timesheets" id="viewTimesheets">
                <label class="custom-control-label" for="viewTimesheets">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.view_timesheets') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="view_activity_log" id="viewActivityLog">
                <label class="custom-control-label" for="viewActivityLog">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.view_activity_log') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="view_team_members" id="viewTeamMembers">
                <label class="custom-control-label" for="viewTeamMembers">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.view_team_members') }}
                </label>
            </div>
        </div>
        <div class="form-group col-12">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" name="hide_tasks_on_table" id="hideTasksOnTable">
                <label class="custom-control-label" for="hideTasksOnTable">
                    {{ __('messages.project.allow_customer_to') }} {{ __('messages.project.hide_project_tasks_on_main_tasks_table') }} ({{ __('messages.project.admin_area') }})
                </label>
            </div>
        </div>
    </div>
</div>
