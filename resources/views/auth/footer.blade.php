<footer id="footer" class="footer">
  <div class="copyright">
    &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
  </div>
  <div class="credits">
    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
  </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- jQuery (diperlukan oleh Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<!-- TinyMCE JS -->

<!-- Vendor JS Files -->
<script src="../../NiceAdmin/assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="../../NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../NiceAdmin/assets/vendor/chart.js/chart.umd.js"></script>
<script src="../../NiceAdmin/assets/vendor/echarts/echarts.min.js"></script>
<script src="../../NiceAdmin/assets/vendor/quill/quill.js"></script>
<script src="../../NiceAdmin/assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="../../NiceAdmin/assets/vendor/tinymce/tinymce.min.js"></script>
<script src="../../NiceAdmin/assets/vendor/php-email-form/validate.js"></script>
<script src="../../NiceAdmin/assets/js/main.js"></script>
<script src="../../input.js"></script>

<!-- React dan React Select -->
<script src="https://unpkg.com/react@17/umd/react.development.js"></script>
<script src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>
<script src="https://unpkg.com/react-select/dist/react-select.min.js"></script>

<script>
    // Inisialisasi TinyMCE
    tinymce.init({
      selector: '#myTextarea',
      setup: function (editor) {
        editor.on('init', function () {
          editor.setMode('readonly'); // Mengatur editor menjadi readonly setelah inisialisasi
        });
      }
    });
  </script>

