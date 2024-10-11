     <div class="main-menu hidden-soft">
         <div class="mini-profile-info">
             <div class="menu-close">
                 <span class="float-right">
                     <img src="<?php echo e(asset('mobile-app-assets/icons/close.svg')); ?>" alt="Close Icon">
                 </span>
             </div>
             <div class="profile-picture text-center">
                 <?php if(Auth::user()->avatar): ?>
                     <img src="<?php echo e(asset('storage/' . Auth::user()->avatar)); ?>" alt="Profile Picture"
                         class="rounded-profile-picture" />
                 <?php else: ?>
                     <img src="<?php echo e(asset('mobile-app-assets/images/anonymous.jpeg')); ?>" alt="Profile Picture"
                         class="rounded-profile-picture" />
                 <?php endif; ?>
             </div>
             <div class="profile-info">
                 <div class="profile-name text-center"><?php echo e(Auth::user()->name); ?></div>
                 <div class="profile-email text-center"><?php echo e(Auth::user()->email); ?></div>
             </div>
         </div>
         <div class="menu-items">
             <div class="all-menu-items">
                 <a class="menu-item" href="<?php echo e(route('customer.index.page')); ?>">
                     <div>
                         <span class="menu-item-icon menu-dark">
                             <img src="<?php echo e(asset('mobile-app-assets/icons/home.svg')); ?> " alt="Home Icon">
                         </span>
                         <span class="menu-item-icon menu-light">
                             <img src="<?php echo e(asset('mobile-app-assets/icons/home-light.svg')); ?>" alt="Home Lighter Icon">
                         </span>
                         <span class="menu-item-title">Home</span>
                         <span class="menu-item-click fas fa-arrow-right"></span>
                     </div>
                 </a>
                 <a class="menu-item" href="<?php echo e(route('customer.profile')); ?>">
                     <span class="menu-item-icon menu-dark profile">
                         <img src="<?php echo e(asset('mobile-app-assets/icons/avatar-dark.svg')); ?> " alt="Avatar Darker Icon">
                     </span>
                     <span class="menu-item-icon menu-light profile">
                         <img src="<?php echo e(asset('mobile-app-assets/icons/avatar.svg')); ?> " alt="Avatar Darker Icon">
                     </span>
                     <span class="menu-item-title profile">Profile</span>
                     <span class="menu-item-click fas fa-arrow-right"></span>
                 </a>
                 
                 <a class="menu-item" href="<?php echo e(route('customer.trip.history')); ?>">
                     <span class="menu-item-icon menu-light">
                         <img src="<?php echo e(asset('mobile-app-assets/icons/history-light.svg')); ?> " alt="History Icon">
                     </span>
                     <span class="menu-item-icon menu-dark">
                         <img src="<?php echo e(asset('mobile-app-assets/icons/history.svg')); ?> " alt="History Icon">
                     </span>
                     <span class="menu-item-title">Trips History</span>
                     <span class="menu-item-click fas fa-arrow-right"></span>
                 </a>
                 
                 
                 

                 <form method="POST" action="<?php echo e(route('logout')); ?>" class="menu-item margin-top-auto">
                     <?php echo csrf_field(); ?>
                     <span class="menu-item-icon menu-dark logout">
                         <img src="<?php echo e(asset('mobile-app-assets/icons/logout.svg')); ?> " alt="Logout Icon">
                     </span>
                     <span class="menu-item-icon menu-light logout">
                         <img src="<?php echo e(asset('mobile-app-assets/icons/logout-light.svg')); ?> " alt="Logout Icon">
                     </span>

                     <button><span type="submit" class="menu-item-title logout">Log out</span></button>
                     <span class="menu-item-click fas fa-arrow-right"></span>
                 </form>
             </div>
         </div>
     </div>
<?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/components/customer-mobile-app/main-menu.blade.php ENDPATH**/ ?>