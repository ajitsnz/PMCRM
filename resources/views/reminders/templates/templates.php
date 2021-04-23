<script id="reminderActionTemplate" type="text/x-jsrender">
   <a title="<?php echo __('messages.common.edit') ?>" class="btn btn-warning action-btn has-icon edit-reminder-btn" data-id="{{:id}}" href="javascript:void(0)">
            <i class="fa fa-edit"></i>
   </a>
   <a title="<?php echo __('messages.common.delete') ?>" class="btn btn-danger action-btn has-icon delete-reminder-btn" data-id="{{:id}}" href="javascript:void(0)">
            <i class="fa fa-trash"></i>
   </a>  



</script>
<script id="showNotified" type="text/x-jsrender">
   <label class="custom-switch pl-0">
        <input type="checkbox" name="is_notified" class="custom-switch-input isNotified" data-id="{{:id}}" {{:checked}}>
        <span class="custom-switch-indicator"></span>
    </label>


</script>

<script id="reminderStatus" type="text/x-jsrender">
   <label class="custom-switch pl-0">
        <input type="checkbox" name="status" class="custom-switch-input reminderStatus" data-id="{{:id}}" {{:checked}}>
        <span class="custom-switch-indicator"></span>
    </label>


</script>
