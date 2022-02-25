<?php $__env->startSection('content'); ?>

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">

                    <a href="<?php echo e(route('product.addProduct')); ?>"> <button class="float-right">Add Product</button></a>
                    <a href="<?php echo e(route('payment.ecommerceIndex')); ?>"><button>Ecommerce</button></a>
                    <?php echo $__env->make('payment.table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </main>

    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Projects\HospitalManagement\resources\views/payment/index.blade.php ENDPATH**/ ?>