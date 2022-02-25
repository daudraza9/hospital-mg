<?php $__env->startSection('title','hospital'); ?>
<?php $__env->startSection('content'); ?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">

                <a href="<?php echo e(route('exportCsv')); ?>"><button>Export CSV</button></a>
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white mb-4">
                            <div class="card-body">Total Doctors = <?php echo e($count); ?></div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="<?php echo e(route('doctor.index')); ?>">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4">
                            <div class="card-body">Total Nurses = <?php echo e($nursecount); ?></div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="<?php echo e(route('nurse.index')); ?>">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-success text-white mb-4">
                            <div class="card-body">Total Patient = <?php echo e($patientCount); ?></div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="<?php echo e(route('patient.index')); ?>">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white mb-4">
                            <div class="card-body">Total Staff = <?php echo e($staffCount); ?></div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="<?php echo e(route('staff.index')); ?>">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt-0">
                        <div class="card bg-secondary text-white">
                            <div class="card-body">Total Departments = <?php echo e($departmentCount); ?></div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white" href="<?php echo e(route('department.index')); ?>">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mt-0">
                        <div class="card bg-info text-white">
                            <div class="card-body">Check Appointments = <?php echo e($appointmentCount); ?></div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white" href="<?php echo e(route('appointment.index')); ?>">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>

</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Projects\HospitalManagement\resources\views/index.blade.php ENDPATH**/ ?>