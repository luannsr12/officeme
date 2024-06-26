  <!-- -------- START FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <footer class="footer mt-3 ">
      <div class="row">
        <div class="col-8 mx-auto text-center mt-1">
          <p class="mb-0 text-secondary">
            Copyright © <script>
              document.write(new Date().getFullYear())
            </script> <?= APP_NAME; ?> - Version 1.0.0
          </p>
        </div>
      </div>
    </div>
  </footer>
  <!-- -------- END FOOTER 3 w/ COMPANY DESCRIPTION WITH LINKS & SOCIAL ICONS & COPYRIGHT ------- -->
  <!--   Core JS Files   -->
  <script src="<?= APP_URL; ?>/public/assets/js/plugins/jquery.min.js"></script>
  <script src="<?= APP_URL; ?>/public/assets/js/core/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="<?= APP_URL; ?>/public/assets/js/core/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.7/build/js/intlTelInput.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.js"></script>
  <script src="<?= APP_URL; ?>/public/assets/js/plugins/emoji-picker-text-fields/lib/js/config.min.js" ></script>
  <script src="<?= APP_URL; ?>/public/assets/js/plugins/emoji-picker-text-fields/lib/js/util.min.js" ></script>
  <script src="<?= APP_URL; ?>/public/assets/js/plugins/emoji-picker-text-fields/lib/js/jquery.emojiarea.min.js" ></script>
  <script src="<?= APP_URL; ?>/public/assets/js/plugins/emoji-picker-text-fields/lib/js/emoji-picker.min.js" ></script>
  <script src="<?= APP_URL; ?>/public/assets/js/plugins/chartjs.min.js"></script>
  <script src="<?= APP_URL; ?>/public/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="<?= APP_URL; ?>/public/assets/js/plugins/smooth-scrollbar.min.js"></script>

  <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
  

  <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>

  
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="<?= APP_URL; ?>/public/assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
  <script src="<?= APP_URL; ?>/public/assets/js/app.js?v=<?= filemtime(BASEDIR . '/public/assets/js/app.js'); ?>"></script>
  <script src="<?= APP_URL; ?>/public/assets/js/charts-dashboard.js"></script>
