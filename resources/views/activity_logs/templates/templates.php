<script id="activityLogsTemplate" type="text/x-jsrender">
    <div class="activity position-relative">
        <div class="activity-icon bg-white text-white">
            <i class="activity-icon-size {{:subject_type}}"></i>
        </div>
        <div class="activity-detail">
            <div class="mb-2 d-flex">
                <span class="text-job text-primary">{{:created_at}}</span>
                <span class="ml-auto position-relative">{{:created_by}}</span>
            </div>
            <span class="post-id text-dark">{{:description}}</span>
        </div>
    </div>




</script>
