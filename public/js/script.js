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
    $('#logout').on('click', function() {
      let keluar = '<a href="<?= BASEURL?>/LogIn/logout">Keluar</a>';
      var confirmation = window.confirm('Anda Yakin Akan Keluar');
      if (confirmation) {
          window.alert('Keluar');
          keluar;
      } else {
          window.alert('Batal');
      }
    });
    $('#logoutLink').on('click', function() {
    var confirmation = window.confirm('Anda Yakin Akan Keluar');

    if (confirmation) {
        // Proses logout dengan AJAX
        $.ajax({
            url: '<?= BASEURL ?>/LogIn/logout',
            type: 'GET',
            success: function(response) {
                window.alert('Keluar');
                window.location.href = response.redirect;
            },
            error: function() {
                window.alert('Gagal Keluar');
            }
        });
    } else {
        window.alert('Batal');
    }
  });

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

// ...existing code...

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