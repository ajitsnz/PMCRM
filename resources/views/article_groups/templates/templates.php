<script id="articleGroupActionTemplate" type="text/x-jsrender">
   <a title="<?php echo __('messages.common.edit') ?>" class="btn btn-warning  action-btn btn has-icon edit-btn" data-id="{{:id}}">
        <i class="fas fa-edit text-white"></i>
   </a>
   <a title="<?php echo __('messages.common.delete') ?>" class="btn btn-danger action-btn has-icon delete-btn" data-id="{{:id}}">
        <i class="fas fa-trash text-white"></i>
   </a>



</script>

<script id="articleGroupColorBox" type="text/x-jsrender">
    <div class="colorBox" {{:colorStyle}}="background: {{:color}}; border: 1px solid #6777ef;"></div>



</script>
