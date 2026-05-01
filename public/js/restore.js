// Restore View Scripts
// BASEURL is defined in restore/index.php

function confirmRestore(id) {
    if (confirm('Apakah Anda yakin ingin me-restore data ini? Data akan dikembalikan ke tabel asalnya.')) {
        window.location.href = BASEURL + '/restore/restore/' + id;
    }
}

function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus permanen data ini? Tindakan ini tidak dapat dibatalkan.')) {
        window.location.href = BASEURL + '/restore/deletePermanent/' + id;
    }
}
