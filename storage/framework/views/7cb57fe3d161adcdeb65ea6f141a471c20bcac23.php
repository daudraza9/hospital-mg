<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<?php echo $__env->make('auth.layouts.auth-header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body>

<?php echo $__env->yieldContent('content'); ?>


<?php echo $__env->make('layouts.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH F:\Projects\HospitalManagement\resources\views/auth/layouts/auth-master.blade.php ENDPATH**/ ?>