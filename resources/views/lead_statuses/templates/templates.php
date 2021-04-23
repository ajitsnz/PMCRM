<script id="leadStatusActionTemplate" type="text/x-jsrender">
   <a title="<?php echo __('messages.common.edit') ?>" class="btn  btn-warning  action-btn btn has-icon edit-btn" data-id="{{:id}}" href="#">
            <i class="fa fa-edit"></i>
   </a>
   <a title="<?php echo __('messages.common.delete') ?>" class="btn btn-danger action-btn has-icon delete-btn" data-id="{{:id}}" href="#">
            <i class="fa fa-trash"></i>
   </a>




</script>

<script id="leadStatusColorBox" type="text/x-jsrender">
    <div class="colorBox" {{:colorStyle}}="background: {{:color}}; border: 1px solid #6777ef;"></div>




</script>
