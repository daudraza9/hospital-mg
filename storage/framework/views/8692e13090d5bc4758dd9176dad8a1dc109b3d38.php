<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="<?php echo e(route('index')); ?>">H M S</a>
    <!-- Sidebar Toggle-->
    <button class="navbar-toggle collapsed btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" data-toggle="collapse"
            data-target="#navbar" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

    </form>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-sm-12 col-12 main-section">
                <div class="dropdown">
                    <button type="button" class="btn btn-info" data-toggle="dropdown">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Cart <span
                            class="badge badge-pill badge-danger"><?php echo e(count((array) session('cart'))); ?></span>
                    </button>
                    <div class="dropdown-menu">
                        <div class="row total-header-section">
                            <div class="col-lg-6 col-sm-6 col-6">
                                <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span
                                    class="badge badge-pill badge-danger"><?php echo e(count((array) session('cart'))); ?></span>
                            </div>
                            <?php $total = 0 ?>
                            <?php $__currentLoopData = (array) session('cart'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <?php $total += (float)$details["price"] * (float)$details["quantity"] ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-6 col-sm-6 col-6 total-section text-right">
                                <p>Total: <span class="text-info">$ <?php echo e((float)$total); ?></span></p>
                            </div>
                        </div>
                        <?php if(session('cart')): ?>
                            <?php $__currentLoopData = session('cart'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row cart-detail">
                                    <div class="col-lg-4 col-sm-4 col-4 cart-detail-img">
                                        <img src="<?php echo e($details['image']); ?>"/>
                                    </div>
                                    <div class="col-lg-8 col-sm-8 col-8 cart-detail-product">
                                      <p class="font-weight-bold"><?php echo e($details['name']); ?></p>
                                        <span class="price text-info"> $<?php echo e($details['price']); ?></span> <span
                                            class="count"> Quantity:<?php echo e($details['quantity']); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12 text-center checkout">
                                <a href="<?php echo e(route('product.cart')); ?>" class="btn btn-primary btn-block">View all</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Navbar-->
    <ul class="nav navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle mr-5" data-toggle="dropdown"><i
                    class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right dp-class">

                <span class="dropdown-item"> <img src="<?php echo e(Auth::user()->getFirstMediaUrl('avatar', 'thumb')); ?>" alt="profile"> <?php echo e(Auth::user()->name); ?></span>
                <div class="dropdown-divider"></div>
                <a href="<?php echo e(route('user.edit',['id'=>Auth::user()->id])); ?>"> <span class="dropdown-item updae"><i
                            class="fas fa-user-edit"></i> Update User</span></a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" onclick="logout()"><i class="fa fa-sign-out" aria-hidden="true"></i>
                    Logout</a>
                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo csrf_field(); ?>
                </form>
            </div>
        </li>
    </ul>
</nav>

<script>
    function logout() {
        document.getElementById('logout-form').submit();
    }
</script>
<?php /**PATH F:\Projects\HospitalManagement\resources\views/layouts/top-nav.blade.php ENDPATH**/ ?>