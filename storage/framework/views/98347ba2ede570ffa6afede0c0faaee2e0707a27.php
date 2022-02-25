<?php $__env->startSection('content'); ?>

    <div id="layoutSidenav_content">

            <div class="container-fluid px-4">

        <a href="<?php echo e(route('doctor.create')); ?>" id="btn-design"> <button>Add Doctors</button></a> <br>
                <?php echo $__env->make('doctors.table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


            </div>


    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Projects\HospitalManagement\resources\views/doctors/index.blade.php ENDPATH**/ ?>