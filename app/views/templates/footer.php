<!-- Modal -->
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
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

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

<!-- LINK SCRIPT -->
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.7.0.js"></script>

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?= BASEURL?>/public/js/jquery.min.js"></script>
<script src="<?= BASEURL?>/public/template/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?= BASEURL?>/public/template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= BASEURL?>/public/template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= BASEURL?>/public/template/dist/js/adminlte.js"></script>

<script> const BASEURL = "<?= BASEURL ?>"; </script>
<script src="<?= BASEURL?>/public/js/script.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?= BASEURL?>/public/template/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?= BASEURL?>/public/template/plugins/raphael/raphael.min.js"></script>
<script src="<?= BASEURL?>/public/template/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?= BASEURL?>/public/template/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="<?= BASEURL?>/public/template/plugins/chart.js/Chart.min.js"></script>

<!-- AdminLTE for demo purposes -->
<!-- <script src="<?= BASEURL?>/public/template/dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= BASEURL?>/public/template/dist/js/pages/dashboard2.js"></script>
<script src="//cdn.datatables.net/2.1.2/js/dataTables.min.js"></script>


<!-- Untuk eksport PDF -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.0/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.0/js/buttons.print.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
    $(document).ready(function() {
      $('#example2').DataTable();
    });
    
    new DataTable('#example', {
    dom: 'Bfrtip', // Aktifkan tombol
    buttons: [
        'copy', 
        'csv', 
        'excel', 
        {
            extend: 'pdfHtml5',
            orientation: 'landscape', // Mengatur orientasi menjadi landscape
            pageSize: 'A4', // Mengatur ukuran halaman
            text: 'PDF', // Mengatur teks tombol
            titleAttr: 'PDF', // Menambahkan judul untuk tooltip
            customize: function (doc) {
                // Menghapus warna abu-abu pada field
                var objLayout = {};
                objLayout['hLineWidth'] = function (i) { return .5; };
                objLayout['vLineWidth'] = function (i) { return .5; };
                objLayout['hLineColor'] = function (i) { return '#000000'; };
                objLayout['vLineColor'] = function (i) { return '#000000'; };
                objLayout['paddingLeft'] = function (i) { return 4; };
                objLayout['paddingRight'] = function (i) { return 4; };
                objLayout['paddingTop'] = function (i) { return 4; };
                objLayout['paddingBottom'] = function (i) { return 4; };
                objLayout['fillColor'] = function (i) { return null; };
                doc.content[1].layout = objLayout;
            }
        }, 
        'print'
    ]
});


    // new DataTable('#example', {
    //   layout: {
    //       topStart: {
    //         orientation: 'landscape',
    //           buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
    //       }
    //   }
    // });

    // new DataTable('#example', {
    // dom: 'Bfrtip',
    // buttons: [
    //     {
    //         extend: 'pdfHtml5',
    //         orientation: 'landscape',
    //         // pageSize: 'A4',
    //         // text: 'PDF',
    //         // titleAttr: 'Export to PDF',
    //     },
    //     'copy', 'csv', 'excel', 'print'
    //     ]
    // });

    let table = new DataTable('#myTable')
    function add(jenis, id = null) {
        console.log("Function add called with type:", jenis, "and id:", id);
        $('.modal-title').html('Tambah Data');
        
        let url = '<?= BASEURL ?>/' + jenis + '/modalTambah';
        if (id) {
            url += '/' + id;  // Tambahkan id jika tersedia
        }

        $.get(url, function(data, success) {
            console.log("Data loaded successfully");
            $('.modal-body').html(data);

            let formID = '#formTambahData' + jenis;
            let tombolHTML = `
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <button type="button" class="btn btn-secondary ml-2" data-bs-dismiss="modal">Batal</button>
                </div>
            `;
            $(formID).append(tombolHTML);
        }).fail(function() {
            console.log("Error loading data");
        });
    }

    // Change
    function change(jenis, id) {
        $('.modal-title').html('Ubah Data');
        let url = '<?= BASEURL?>/' + jenis + '/ubahModal';
        $.post(url, {
            id: id
        }, function(data, success) {
            $('.modal-body').html(data);
        });
    }
    // Delete
    function deleteData(jenis, id) {
    $('.modal-title').html('Hapus Data');
    $('.modal-body').html(`
      <div class="text-center mb-3">
        Hapus Data?
      </div>
      <div class="text-center">
        <a href="<?= BASEURL ?>/${jenis}/hapus/${id}" class="btn btn-danger">Hapus</a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    `);
  }
  $('#logoutLink').on('click', function(event) {
    event.preventDefault(); 
    
    $('.modal-title').html('Konfirmasi Keluar');
    $('.modal-body').html(`
        <div class="text-center mb-3">
            Anda yakin akan keluar?
        </div>
        <div class="text-center">
            <a href="<?= BASEURL ?>/Login/logout" class="btn btn-primary">Keluar</a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
    `);
    $('#myModal').modal('show');
});

function hapusMentoring(idMentoring, idFrekuensi) {
        $('.modal-title').html('Hapus Data Mentoring');
        $('.modal-body').html(`
            <div class="text-center mb-3">
                <p>Apakah Anda yakin ingin menghapus data mentoring ini?</p>
            </div>
            <div class="text-center">
                <a href="<?= BASEURL ?>/Mentoring/prosesHapus/${idMentoring}/${idFrekuensi}" class="btn btn-danger">Hapus</a>
                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        `);
    }

    document.addEventListener('DOMContentLoaded', function () {

      const calendarEl = document.getElementById('calendar-monitoring');
      if (!calendarEl) return;

      const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        height: 420,
        firstDay: 1,

        events: "<?= BASEURL ?>/dashboard/calendarAsisten",

      eventDidMount: function(info) {
        info.el.setAttribute(
        'title',
          info.event.title + ' | ' + info.event.extendedProps.ruangan
          );
        },

      eventClick: function(info) {
          const idFrekuensi = info.event.extendedProps.id_frekuensi;
            window.location.href =
          "<?= BASEURL ?>/monitoring/isi/" + idFrekuensi;
        }
      });

      calendar.render();
    });

  $(document).ready(function() {
    const toggleButton = $('#dark-mode-toggle');
    const body = $('body');
    const icon = toggleButton.find('i');

    // 1. Cek status Dark Mode di penyimpanan browser saat halaman dimuat
    if (localStorage.getItem('theme') === 'dark') {
      body.addClass('dark-mode');
      icon.removeClass('fa-moon').addClass('fa-sun');
      // Opsional: Jika navbar/sidebar butuh penyesuaian warna spesifik
      $('.main-header').addClass('navbar-dark').removeClass('navbar-white navbar-light');
    }

    // 2. Fungsi saat tombol diklik
    toggleButton.on('click', function(e) {
      e.preventDefault();
      body.toggleClass('dark-mode');
      
      if (body.hasClass('dark-mode')) {
        // Mode Gelap Aktif
        localStorage.setItem('theme', 'dark');
        icon.removeClass('fa-moon').addClass('fa-sun');
        $('.main-header').addClass('navbar-dark').removeClass('navbar-white navbar-light');
      } else {
        // Mode Terang Aktif
        localStorage.setItem('theme', 'light');
        icon.removeClass('fa-sun').addClass('fa-moon');
        $('.main-header').addClass('navbar-white navbar-light').removeClass('navbar-dark');
      }
    });
  });
</script>
</body>
</html>