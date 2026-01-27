    function ubahdata(x){
        $('.modal-title').html('Ubah Data');
        let url = '<?= BASEURL?>/Asisten/ubahModal';
        $.post(url, {
          id : x
        }, function(data, success){
          $('.modal-body').html(data);
        });
        $('.tombol').html('<a href="<?= BASEURL?>/Asisten/prosesUbah/'+ x +'" class="btn btn-primary" style="background: #06253A; color= #FFFFFF;">Ubah Data</a>');
    }
    function hapus(a){
      $('.modal-title').html('Hapus Data');
      $('.modal-body').html('<img src="<?= BASEURL?>/assets/img/Icon Delete.png" alt="Konfirmasi Hapus">');       
      $('.tombol').html('<a href="<?= BASEURL?>/Asisten/hapus/'+ a +'" class="btn btn-primary" style="background: #06253A; color= #FFFFFF;">Hapus</a>');
      $('#close').html('Batal');

    }
   

// BAGIAN SIDEBAR
$(".sidebar ul li").on('click', function () {
    $(".sidebar ul li.active").removeClass('active');
    $(this).addClass('active');
});

$('.open-btn').on('click', function () {
    $('.sidebar').addClass('active');

});

$('.close-btn').on('click', function () {
    $('.sidebar').removeClass('active');

})

document.addEventListener('DOMContentLoaded', function() {
    const tahunFilter = document.getElementById('tahunAjaranFilter');
    if (tahunFilter) {
        tahunFilter.addEventListener('change', function() {
            const tahunId = this.value;
            fetch(BASEURL + '/Frekuensi/filterAjax', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ id_tahun: tahunId })
            })
            .then(response => response.json())
            .then(data => {
                updateFrekuensiTable(data);
            })
            .catch(error => {
                alert('Gagal mengambil data!');
            });
        });
    }

    function updateFrekuensiTable(data) {
        const tbody = document.querySelector('#myTable tbody');
        if (!tbody) return;
        tbody.innerHTML = '';
        let no = 1;
        data.forEach(frekuensi => {
            const aksi = `
                <a class="btn btn-primary btn-sm button-style text-center" onclick="change('Frekuensi', '${frekuensi.id_frekuensi}')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-edit"></i></a>
                <a class="btn btn-danger btn-sm button-style text-center" onclick="deleteData('Frekuensi', '${frekuensi.id_frekuensi}')" role="button" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fa fa-trash"></i></a>
                <a class="btn btn-primary btn-sm button-style text-center" href="${BASEURL}/frekuensi/detail/${frekuensi.id_frekuensi}" role="button"><i class="fa fa-list"></i></a>
            `;
            const row = `<tr>
                <td class="text-center">${no++}</td>
                <td class="text-center">${frekuensi.frekuensi}</td>
                <td class="text-center">${frekuensi.kode_matkul}</td>
                <td>${frekuensi.nama_matkul}</td>
                <td class="text-center">${frekuensi.tahun_ajaran}</td>
                <td class="text-center">${frekuensi.kelas}</td>
                <td>${frekuensi.hari}/${frekuensi.jam_mulai}-${frekuensi.jam_selesai}</td>
                <td>${frekuensi.nama_ruangan}</td>
                <td>${frekuensi.nama_dosen}</td>
                <td>${frekuensi.asisten_1}</td>
                <td>${frekuensi.asisten_2}</td>
                <td align="center">${aksi}</td>
            </tr>`;
            tbody.insertAdjacentHTML('beforeend', row);
        });
    }
});

    $(document).ready(function() {
        // --- 1. INISIALISASI DATATABLES ---
        if ($('#example2').length) {
            $('#example2').DataTable();
        }

        if ($('#myTable').length) {
            $('#myTable').DataTable();
        }

        if ($('#example').length) {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 
                    {
                        extend: 'pdfHtml5',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        text: 'PDF',
                        titleAttr: 'Export PDF',
                        customize: function (doc) {
                            let objLayout = {
                                hLineWidth: (i) => .5,
                                vLineWidth: (i) => .5,
                                hLineColor: (i) => '#000000',
                                vLineColor: (i) => '#000000',
                                paddingLeft: (i) => 4,
                                paddingRight: (i) => 4,
                                paddingTop: (i) => 4,
                                paddingBottom: (i) => 4,
                                fillColor: (i) => null
                            };
                            doc.content[1].layout = objLayout;
                        }
                    }, 
                    'print'
                ]
            });
        }

        // --- 2. LOGOUT HANDLER (Event Delegation) ---
        $(document).on('click', '#logoutLink', function(e) {
            e.preventDefault(); 
            $('.modal-title').html('Konfirmasi Keluar');
            $('.modal-body').html(`
                <div class="text-center mb-3">Apakah anda yakin ingin keluar?</div>
                <div class="text-center">
                    <a href="${BASEURL}/Login/logout" class="btn btn-primary">Keluar</a>
                    <button type="button" class="btn btn-secondary ml-2" data-bs-dismiss="modal">Batal</button>
                </div>
            `);
            $('#myModal').modal('show');
        });

        // --- 3. DARK MODE TOGGLE ---
        const toggleButton = $('#dark-mode-toggle');
        const body = $('body');
        const icon = toggleButton.find('i');

        // Cek tema saat load
        if (localStorage.getItem('theme') === 'dark') {
            body.addClass('dark-mode');
            icon.removeClass('fa-moon').addClass('fa-sun');
            $('.main-header').addClass('navbar-dark').removeClass('navbar-white navbar-light');
        }

        toggleButton.on('click', function(e) {
            e.preventDefault();
            body.toggleClass('dark-mode');
            
            const isDark = body.hasClass('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            
            // Update Ikon & Navbar
            icon.toggleClass('fa-moon fa-sun');
            if (isDark) {
                $('.main-header').addClass('navbar-dark').removeClass('navbar-white navbar-light');
            } else {
                $('.main-header').addClass('navbar-white navbar-light').removeClass('navbar-dark');
            }
        });

        // --- 4. FULL CALENDAR ---
        // --- 4. FULL CALENDAR ---
        const calendarEl = document.getElementById('calendar-monitoring');
        if (calendarEl) {
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'id',
                height: 420,
                firstDay: 1,
                events: `${BASEURL}/dashboard/calendarAsisten`,
                eventDidMount: function(info) {
                    info.el.setAttribute(
                        'title',
                        `${info.event.title} | ${info.event.extendedProps.ruangan}`
                    );
                },
                eventClick: function(info) {
                    if (!info.event.extendedProps.clickable) {
                        return;
                    }

                    document.getElementById('md-matkul').innerText = info.event.title;
                    document.getElementById('md-ruangan').innerText = info.event.extendedProps.ruangan;
                    document.getElementById('md-status').innerText = info.event.extendedProps.status;
                    document.getElementById('md-tanggal').innerText =
                        info.event.start.toLocaleDateString('id-ID');

                    document.getElementById('md-link').href =
                        `${BASEURL}/frekuensi/detail/${info.event.extendedProps.id_frekuensi}`;

                    $('#eventDetailModal').modal('show');
                }
            });
            calendar.render();
        }
    });

// --- 5. FUNGSI GLOBAL (Bisa dipanggil dari atribut onclick di HTML) ---

    function add(jenis, id = null) {
        $('.modal-title').html('Tambah Data');
        let url = `${BASEURL}/${jenis}/modalTambah${id ? '/' + id : ''}`;

        $.get(url, function(data) {
            $('.modal-body').html(data);
            const formID = `#formTambahData${jenis}`;
            $(formID).append(`
                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <button type="button" class="btn btn-secondary ml-2" data-bs-dismiss="modal">Batal</button>
                </div>
            `);
        }).fail(() => console.error("Gagal memuat modal tambah"));
    }

    function change(jenis, id) {
        $('.modal-title').html('Ubah Data');
        $.post(`${BASEURL}/${jenis}/ubahModal`, { id: id }, function(data) {
            $('.modal-body').html(data);
        }).fail(() => console.error("Gagal memuat modal ubah"));
    }

    function deleteData(jenis, id) {
        $('.modal-title').html('Hapus Data');
        $('.modal-body').html(`
        <div class="text-center mb-3">Hapus Data?</div>
        <div class="text-center">
            <a href="${BASEURL}/${jenis}/hapus/${id}" class="btn btn-danger">Hapus</a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
        `);
    }

    function hapusMentoring(idMentoring, idFrekuensi) {
        $('.modal-title').html('Hapus Data Mentoring');
        $('.modal-body').html(`
            <div class="text-center mb-3"><p>Hapus data mentoring ini?</p></div>
            <div class="text-center">
                <a href="${BASEURL}/Mentoring/prosesHapus/${idMentoring}/${idFrekuensi}" class="btn btn-danger">Hapus</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        `);
    }
