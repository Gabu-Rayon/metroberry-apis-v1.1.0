  

  <?php $__env->startSection('title', 'Profile | Customer'); ?>
  <?php $__env->startSection('content'); ?>

      <!--Loading Container Start-->
      <div id="load" class="loading-overlay display-flex flex-column justify-content-center align-items-center">
          <div class="primary-color font-28 fas fa-spinner fa-spin"></div>
      </div>
      <!--Loading Container End-->

      <div class="row h-100">
          <div class="col-xs-12 col-sm-12">

              <!--Page Title & Icons Start-->
              <div class="header-icons-container text-center">
                  <a href="<?php echo e(route('customer.index.page')); ?>">
                      <span class="float-left">
                          <img src="<?php echo e(asset('mobile-app-assets/icons/back.svg')); ?>" alt="Back Icon">
                      </span>
                  </a>
                  <span>Profile</span>
                  <a href="#">
                      <span class="float-right menu-open closed">
                          <img src="<?php echo e(asset('mobile-app-assets/icons/menu.svg')); ?>" alt="Menu Hamburger Icon">
                      </span>
                  </a>
              </div>
              <!--Page Title & Icons End-->

              <div class="rest-container">

                <!--Profile Information Container Start-->
                <div class="text-center header-icon-logo-margin">
                    <form id="customer-profile-picture-form" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="profile-picture-container">
                            <img id="profile-picture"
                                src="<?php echo e($customer->user->avatar ? asset('storage/' . $customer->user->avatar) : asset('mobile-app-assets/images/avatar.svg')); ?>"
                                alt="Profile Picture"   class="rounded-profile-picture"/>
                            <span class="fas fa-camera">
                                <input class="file-prompt" type="file" accept="image/*" id="customer-profile-picture-input"
                                    name="profile_picture" />
                            </span>
                        </div>
                        <div class="display-flex flex-column">
                            <span class="profile-name"><?php echo e($customer->user->name); ?></span>
                            <span class="profile-email font-weight-light"><?php echo e($customer->user->email); ?></span>
                        </div>
                    </form>
                </div>
                <!--Profile Information Container End-->

                  <!--Profile Information Fields Container Start-->
                  <div class="sign-up-form-container text-center">
                      <form class="width-100" method="POST" action="<?php echo e(route('customer.profile.update', $customer->id)); ?>"
                          enctype="multipart/form-data">
                          <?php echo csrf_field(); ?>
                          <?php echo method_field('PUT'); ?>

                          <!--Profile Field Container Start-->
                          <div class="form-group">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span><img src="<?php echo e(asset('mobile-app-assets/icons/phone.svg')); ?>"
                                              alt="Phone Number"></span>
                                  </div>
                                  <input class="form-control" type="tel" name="phone"
                                      value="<?php echo e($customer->user->phone); ?>" placeholder="Mobile Phone Number">
                              </div>
                          </div>
                          <!--Profile Field Container End-->

                          <!--Profile Field Container Start-->
                          <div class="form-group">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span>
                                          <img src="<?php echo e(asset('mobile-app-assets/icons/avatar-light.svg')); ?>"
                                              alt="Avatar Icon">
                                      </span>
                                  </div>
                                  <input class="form-control" type="text" autocomplete="off"
                                      value="<?php echo e($customer->user->name); ?>" name="full-name" placeholder="Full Name">
                              </div>
                          </div>
                          <!--Profile Field Container End-->

                          <!--Profile Field Container Start-->
                          <div class="form-group">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span>
                                          <img src="<?php echo e(asset('mobile-app-assets/icons/envelope.svg')); ?>"
                                              alt="Envelope Icon">
                                      </span>
                                  </div>
                                  <input class="form-control" type="email" name="email"
                                      value="<?php echo e($customer->user->email); ?>" placeholder="Email">
                              </div>
                          </div>
                          <!--Profile Field Container End-->

                          <!--Profile Field Container Start-->
                          <div class="form-group">
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <span>
                                          <img src="<?php echo e(asset('mobile-app-assets/icons/marker.svg')); ?>" alt="Marker Icon">
                                      </span>
                                  </div>
                                  <input class="form-control" type="text" autocomplete="off"
                                      value="<?php echo e($customer->user->address); ?>" name="address" placeholder="Address">
                              </div>
                          </div>
                          <!--Profile Field Container End-->

                          <!--Pickup organisations Field Start-->
                          <div class="form-group">
                              <label class="width-100">
                                  <div class="input-group-prepend">
                                      <span>
                                          <span class="label-title">Select Organisation</span>
                                      </span>
                                  </div>
                                  <span class="car-info-wrap display-block">
                                      <select name="organisation" class="custom-select font-weight-light car-info"
                                          id="organisation" required>
                                          <option value="" readonly>Select Organisation</option>
                                          <?php $__currentLoopData = $organisations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organisation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <option value="<?php echo e($organisation->id); ?>"
                                                  <?php echo e($customer->organisation_id == $organisation->id ? 'selected' : ''); ?>>
                                                  <?php echo e($organisation->user->name); ?></option>
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      </select>
                                  </span>
                              </label>
                          </div>
                          <!--Pickup organisations Field End-->

                          <!-- Upload Front national ID -->
                          <div class="form-group">
                              <label class="width-100">
                                  <div class="display-flex justify-content-between">
                                      <span class="position-relative upload-btn">
                                          <img src="<?php echo e(asset('mobile-app-assets/icons/upload.svg')); ?>" alt="Upload Icon" />
                                          <input class="scan-prompt" type="file" accept="image/*"
                                              name="national_id_front_avatar" id="national-id-front-input" />
                                      </span>
                                      <span class="text-uppercase">National ID FRONT</span>
                                      <span class="delete-btn" id="national-id-front-delete">
                                          <img src="<?php echo e(asset('mobile-app-assets/icons/delete.svg')); ?>"
                                              alt="Delete Icon" />
                                      </span>
                                  </div>
                                  <div class="scan-your-card-prompt margin-top-5">
                                      <div class="position-relative">
                                          <div class="upload-picture-container">
                                              <div class="upload-camera-container text-center">
                                                  <span class="camera">
                                                      <img id="national-id-front-preview"
                                                          src="<?php echo e($customer->national_id_front_avatar
                                                              ? asset($customer->national_id_front_avatar)
                                                              : asset('mobile-app-assets/icons/photocamera.svg')); ?>"
                                                          alt="National ID Front" />
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </label>
                          </div>

                          <!-- Upload behind national ID -->
                          <div class="form-group">
                              <label class="width-100">
                                  <div class="display-flex justify-content-between">
                                      <span class="position-relative upload-btn">
                                          <img src="<?php echo e(asset('mobile-app-assets/icons/upload.svg')); ?>"
                                              alt="Upload Icon" />
                                          <input class="scan-prompt" type="file" accept="image/*"
                                              name="national_id_behind_avatar" id="national-id-back-input" />
                                      </span>
                                      <span class="text-uppercase">National ID BACK</span>
                                      <span class="delete-btn" id="national-id-back-delete">
                                          <img src="<?php echo e(asset('mobile-app-assets/icons/delete.svg')); ?>"
                                              alt="Delete Icon" />
                                      </span>
                                  </div>
                                  <div class="scan-your-card-prompt margin-top-5">
                                      <div class="position-relative">
                                          <div class="upload-picture-container">
                                              <div class="upload-camera-container text-center">
                                                  <span class="camera">
                                                      <img id="national-id-back-preview"
                                                          src="<?php echo e($customer->national_id_behind_avatar
                                                              ? asset($customer->national_id_behind_avatar)
                                                              : asset('mobile-app-assets/icons/photocamera.svg')); ?>"
                                                          alt="National ID Back" />
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </label>
                          </div>

                          <div class="form-submit-button">
                              <button type="submit" class="btn btn-dark text-uppercase">Save <span
                                      class="far fa-save margin-left-10"></span></button>
                          </div>
                      </form>
                  </div>
                  <!--Profile Information Fields Container End-->
              </div>
          </div>

          <!--Main Menu Start-->
          <?php echo $__env->make('components.customer-mobile-app.main-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <!--Main Menu End-->

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
       <?php $__env->startPush('scripts'); ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#customer-profile-picture-input').change(function() {
                    var formData = new FormData($('#customer-profile-picture-form')[0]);
                    $.ajax({
                        url: "<?php echo e(route('customer.updateProfilePicture')); ?>",
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#profile-picture').attr('src', response.newProfilePictureUrl);
                            alert('Profile picture updated successfully');
                        },
                        error: function(xhr) {
                            alert('Failed to update profile picture');
                        }
                    });
                });
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mobile-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/customer-app/profile.blade.php ENDPATH**/ ?>