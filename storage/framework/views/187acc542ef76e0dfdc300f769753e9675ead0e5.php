<!DOCTYPE html>
<html lang="en">
<?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div id="preloaders" class="preloader"></div>
<body class="sb-nav-fixed">

<div id="layoutSidenav">

    <?php echo $__env->make('layouts.top-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>




<?php echo $__env->yieldContent('content'); ?>

    <?php echo $__env->make('layouts.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</div>


</body>
</html>

<?php /**PATH D:\Projects\HospitalManagement\resources\views/layouts/master.blade.php ENDPATH**/ ?>