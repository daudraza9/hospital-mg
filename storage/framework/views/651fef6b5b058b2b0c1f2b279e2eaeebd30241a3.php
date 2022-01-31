<?php echo $__env->make('layouts.top-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div id="layoutSidenav_nav" >
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <a class="nav-link" href="<?php echo e(route('index')); ?>">
                    <div class="sb-nav-link-icon"><i class="fal fa-home"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="<?php echo e(route('department.index')); ?>">
                    <div class="sb-nav-link-icon"><i class="fal fa-stream"></i></div>
                    Departments
                </a>
                <a class="nav-link" href="<?php echo e(route('doctor.index')); ?>">
                    <div class="sb-nav-link-icon"><i class="fal fa-user-md"></i></div>
                    Manage Doctors
                </a>
                <a class="nav-link" href="<?php echo e(route('patient.index')); ?>">
                    <div class="sb-nav-link-icon"><i class="fal fa-user"></i></div>
                    Manage Patients
                </a>
                <a class="nav-link" href="<?php echo e(route('nurse.index')); ?>">
                    <div class="sb-nav-link-icon"><i class="fal fa-user-nurse"></i></div>
                    Manage Nurses
                </a>
                <a class="nav-link" href="<?php echo e(route('staff.index')); ?>">
                    <div class="sb-nav-link-icon"><i class="fal fa-user-friends"></i></div>
                  Manage Staff
                </a>
                <a class="nav-link" href="<?php echo e(route('room.index')); ?>">
                    <div class="sb-nav-link-icon"><i class="fal fa-bed"></i></div>
                   Manage Rooms
                </a>
                <a class="nav-link" href="<?php echo e(route('appointment.index')); ?>">
                    <div class="sb-nav-link-icon"><i class="fal fa-calendar"></i></div>
                    Manage Appointment                </a>

                <a class="nav-link" href="<?php echo e(route('role.index')); ?>">
                    <div class="sb-nav-link-icon"><i class="fal fa-tasks"></i></div>
                    Manage Roles  </a>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(permissions['addUser'])): ?>
                <a class="nav-link" href="<?php echo e(route('user.add')); ?>">
                    <div class="sb-nav-link-icon"><i class="fal fa-user"></i></div>
                    Add User
                </a>
                <?php endif; ?>
                <a class="nav-link" href="<?php echo e(route('pdf.index')); ?>">
                    <div class="sb-nav-link-icon"><i class="fal fa-tasks"></i></div>
                    Manage Pdf  </a>
                <a class="nav-link" href="<?php echo e(route('product.indexs')); ?>">
                    <div class="sb-nav-link-icon"><i class="fal fa-tasks"></i></div>
                    Manage Product  </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as: <?php echo e(Auth::user()->name); ?></div>
        </div>
    </nav>
</div>
<?php /**PATH D:\Projects\HospitalManagement\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>