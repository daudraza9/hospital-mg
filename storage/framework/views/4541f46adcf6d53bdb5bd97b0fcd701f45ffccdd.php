<?php $__env->startSection('content'); ?>

    <div id="layoutSidenav_content">

        <div class="container-fluid px-4">

         <a href="<?php echo e(route('department.create')); ?>" class="btn-design mt-3"> <button class="float-right btn-style">Add Department</button></a>


            <?php echo $__env->make('department.table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>


    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Projects\HospitalManagement\resources\views/department/index.blade.php ENDPATH**/ ?>