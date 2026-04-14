<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div id="modal-size" class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header"> 
        <h5 class="modal-title fs-5"></h5>
        <div data-bs-theme="dark">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <span class="tombol"></span>
        <span class="batal"></span>
      </div>
    </div>
  </div>
</div>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark"></aside>

<!-- Main Footer -->
<footer class="main-footer">
    <strong>Copyright &copy; 2024</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>ICLabs</b> Integrated Computer Laboratories
    </div>
</footer>

</div>
<!-- ./wrapper -->

<!-- 1. jQuery (LOAD ONCE) -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- 2. Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>

<!-- 3. Bootstrap Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- 4. AdminLTE Core Plugins -->
<script src="<?= BASEURL?>/public/template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?= BASEURL?>/public/template/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?= BASEURL?>/public/template/plugins/raphael/raphael.min.js"></script>
<script src="<?= BASEURL?>/public/template/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?= BASEURL?>/public/template/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<script src="<?= BASEURL?>/public/template/plugins/chart.js/Chart.min.js"></script>

<!-- 5. AdminLTE Core -->
<script src="<?= BASEURL?>/public/template/dist/js/adminlte.js"></script>

<!-- 6. DataTables (must be AFTER jQuery) -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<!-- 7. DataTables Export Buttons (for PDF & Excel) -->
<script src="https://cdn.datatables.net/buttons/3.1.0/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.print.min.js"></script>

<!-- 8. Calendar -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<!-- 9. Page-specific scripts -->
<script src="<?= BASEURL?>/public/template/dist/js/pages/dashboard2.js"></script>

<!-- 10. Custom Global Scripts -->
<script>const BASEURL = "<?= BASEURL ?>";</script>
<script src="<?= BASEURL?>/public/js/script.js"></script>

</body>
</html>