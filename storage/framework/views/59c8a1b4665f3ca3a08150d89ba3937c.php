  <br>
  <!--Terms And Conditions Agreement Container Start-->
  
  <!--Terms And Conditions Agreement Container End--><!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="<?php echo e(asset('mobile-app-assets/js/jquery-3.4.1.js')); ?>"></script>
  <script src="<?php echo e(asset('mobile-app-assets/js/popper.min.js')); ?>"></script>
  <script src="<?php echo e(asset('mobile-app-assets/js/bootstrap.min.js')); ?>"></script>
  <script src="<?php echo e(asset('mobile-app-assets/js/main.js')); ?>"></script>
  <script src="<?php echo e(asset('mobile-app-assets/js/owl.carousel.js')); ?>"></script>
  <script src="<?php echo e(asset('mobile-app-assets/js/history.js')); ?>"></script>
  <!--International Telephone input JS-->
  <script src=" <?php echo e(asset('mobile-app-assets/js/intlTelInput.min.js')); ?>"></script>
  <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBjAxAszIxcGy7sHQxpFh0c1EDs-3AO76Q&libraries=places&callback=initMap">
  </script>
  <!-- Push scripts to the footer -->
  <?php echo $__env->yieldPushContent('scripts'); ?>

  <script>
      $(document).ready(function() {
          function readURL(input, previewElement) {
              if (input.files && input.files[0]) {
                  var reader = new FileReader();

                  reader.onload = function(e) {
                      $(previewElement).attr('src', e.target.result);
                  }

                  reader.readAsDataURL(input.files[0]);
              }
          }

          $('#profile-picture-input').change(function() {
              readURL(this, '#profile-picture-preview');
          });

          $('#national-id-front-input').change(function() {
              readURL(this, '#national-id-front-preview');
          });

          $('#national-id-back-input').change(function() {
              readURL(this, '#national-id-back-preview');
          });

          $('#national-id-front-delete').click(function() {
              $('#national-id-front-input').val('');
              $('#national-id-front-preview').attr('src',
                  '<?php echo e(asset('mobile-app-assets/icons/photocamera.svg')); ?>');
          });

          $('#national-id-back-delete').click(function() {
              $('#national-id-back-input').val('');
              $('#national-id-back-preview').attr('src',
                  '<?php echo e(asset('mobile-app-assets/icons/photocamera.svg')); ?>');
          });
      });
  </script>
  <script>
      $(document).ready(function() {
          // Show success message and fade out after 2 seconds
          if ($('#success-message').length) {
              $('#success-message').fadeIn().delay(10000).fadeOut();
          }

          // Show error message and fade out after 2 seconds
          if ($('#error-message').length) {
              $('#error-message').fadeIn().delay(10000).fadeOut();
          }
      });
  </script>


  <script>
    // Function to hide messages after a delay
    function hideMessageAfterDelay(elementId, delay) {
        const messageElement = document.getElementById(elementId);
        if (messageElement) {
            setTimeout(() => {
                messageElement.style.display = 'none';
            }, delay);
        }
    }

    // Call the function for each message with a delay of 60 seconds (60000 milliseconds)
    hideMessageAfterDelay('verified-message', 60000); // 1 minute
    hideMessageAfterDelay('verified-message', 60000); // 1 minute
</script>
  </body>

  </html>
<?php /**PATH C:\xampp\htdocs\metroberry-apis-v1.1.0\resources\views/components/mobile-app/footer.blade.php ENDPATH**/ ?>