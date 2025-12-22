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
