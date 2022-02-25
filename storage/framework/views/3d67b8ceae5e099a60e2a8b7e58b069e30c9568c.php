<div class="modal" id="view-file-Modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-x-blue bg-darken-2">
                <h4 id="add-edit-department-modal-heading" class="modal-title">File is</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <?php echo $__env->make('partials.js-validation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>


<?php $__env->startPush('scripts'); ?>
    <script>
        function viewfile(id)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'<?php echo e(route('file.display')); ?>',
                type:'POST',
                data:id,
                success:function(data){
                    console.log(data);
                },
                error: function (data) {
                    console.log(data);
                }
            });

        }

    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH F:\Projects\HospitalManagement\resources\views/file/view-file.blade.php ENDPATH**/ ?>