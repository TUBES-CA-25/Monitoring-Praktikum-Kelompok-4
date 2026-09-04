# LAPORAN RESMI AUDIT KELAYAKAN PRODUKSI & REKOMENDASI PERBAIKAN TEKNIS
**SISTEM MONITORING PRAKTIKUM LABORATORIUM KOMPUTER TERPADU (ICLabs)**  
**FAKULTAS ILMU KOMPUTER — UNIVERSITAS MUSLIM INDONESIA**

---

| Dokumen Kontrol | Keterangan |
|---|---|
| **Nomor Dokumen** | RPT-SEC-PRD-2026-004 |
| **Tanggal Audit** | 04 September 2026 |
| **Klasifikasi** | RAHASIA / INTERNAL DEVELOPER TEAM |
| **Auditor / Penilai** | Senior Bug Hunter & Application Security Auditor |
| **Target Codebase** | `C:\xampp\htdocs\monitoring-praktikum` |
| **Versi Aplikasi** | 1.0.0 (Pre-Production) |
| **Keputusan Akhir (Verdict)** | 🔴 **BLOCK DEPLOYMENT (DILARANG DEPLOY KE PRODUCTION)** |

---

## DAFTAR ISI
1. [Ringkasan Eksekutif (Executive Summary)](#1-ringkasan-eksekutif)
2. [Matriks Skor Kesiapan Produksi (Production Readiness Scorecard)](#2-matriks-skor-kesiapan-produksi)
3. [Daftar Temuan Masalah Berdasarkan Prioritas](#3-daftar-temuan-masalah-berdasarkan-prioritas)
4. [Panduan Langkah Perbaikan Teknis untuk Developer](#4-panduan-langkah-perbaikan-teknis-untuk-developer)
   - [Prioritas P0 — Perbaikan Kritis (Hari 1-2)](#prioritas-p0--perbaikan-kritis-blocker-mutlak)
   - [Prioritas P1 — Wajib Sebelum Deploy (Hari 3-5)](#prioritas-p1--wajib-sebelum-deploy-ke-server-publik)
   - [Prioritas P2 — Penguatan Sistem & Stabilitas (Hari 6-8)](#prioritas-p2--penguatan-keamanan--stabilitas-data)
   - [Prioritas P3 — Pemeliharaan & Standardisasi Infrastruktur](#prioritas-p3--pembersihan-technical-debt--infrastruktur)
5. [Contoh Implementasi Kode (Before vs After)](#5-contoh-implementasi-kode-before-vs-after)
6. [Checklist Verifikasi Pengujian (QA & Verification Sheet)](#6-checklist-verifikasi-pengujian)
7. [Lembar Tanda Tangan & Persetujuan](#7-lembar-tanda-tangan--persetujuan)

---

## 1. RINGKASAN EKSEKUTIF

Berdasarkan audit menyeluruh terhadap arsitektur, basis kode PHP, skema basis data MariaDB/MySQL, konfigurasi keamanan server web Apache, serta alur otentikasi dan otorisasi pada repositori sistem **Monitoring Praktikum**, ditemukan **sejumlah kerentanan keamanan berisiko tinggi (High & Critical Severity)** dan **kelemahan logika data (Logic Bugs)** yang secara fundamental menggagalkan status kelayakan sistem untuk dirilis ke lingkungan *Production*.

### Temuan Utama:
1. **Bypass Otentikasi Total pada Kontrol Akses Administrator**: Fungsi pembatas hak akses `isAdmin()` pada kelas dasar controller memiliki cacat logika pengkondisian sehingga **setiap pengunjung tanpa login dapat membuat akun Administrator baru** secara langsung.
2. **Pengambilalihan Akun Sepihak (Account Takeover / IDOR)**: Endpoint pembaruan profil user tidak memverifikasi sesi aktif dan mempercayai parameter ID dari form, memungkinkan siapa saja mengganti nama dan password akun Administrator utama tanpa sandi lama.
3. **Kebocoran Data Kredensial Penuh (Full Data Disclosure)**: File backup basis data (`db_monitoring_praktikum.sql` dan `temp.sql`) terletak langsung pada *web root* yang dapat diunduh bebas oleh publik melalui peramban web.
4. **Cacat Integritas Data (Data Loss on Delete)**: Operasi penghapusan data berelasi dilakukan bertahap tanpa mekanisme *Database Transaction* (ACID), berisiko memicu korupsi data historis presensi jika terjadi kegagalan query di tengah proses.
5. **Ketiadaan Proteksi Cross-Site Request Forgery (CSRF)**: Seluruh aksi modifikasi dan penghapusan data dapat dipicu secara sepihak melalui manipulasi tautan atau request pihak ketiga.

**Kesimpulan Evaluasi**: Sistem memiliki dasar antarmuka dan pemodelan data yang baik, namun **memiliki celah keamanan fatal pada pintu masuk otentikasi dan integritas data**. Deployment ke production **HARUS DITUNDA (BLOCKED)** hingga seluruh perbaikan pada tingkat P0 dan P1 selesai diterapkan dan diverifikasi ulang.

---

## 2. MATRIKS SKOR KESIAPAN PRODUKSI

| Kategori Evaluasi | Skor Bobot | Evaluasi Kualitatif | Catatan Auditor |
|---|:---:|:---:|---|
| **Code Structure & Architecture** | 6.0 / 10 | 🟡 Cukup | Pola MVC native rapi, namun pemisahan concern tipis |
| **Security & Hardening** | 1.0 / 10 | 🔴 Sangat Bahaya | Celah bypass otentikasi & file database terbuka |
| **Authentication System** | 2.0 / 10 | 🔴 Kritis | Remember-me rusak, rate limit dapat di-bypass via cookie |
| **Authorization & RBAC** | 1.0 / 10 | 🔴 Kritis | IDOR pada profil, controller Mentoring/Restore tanpa auth |
| **API & Endpoint Defense** | 2.5 / 10 | 🔴 Rentan | Tanpa CSRF token, HTTP method tidak divalidasi |
| **Database Reliability & ACID** | 4.0 / 10 | 🟠 Berisiko | Multi-delete tanpa transaksi, persistent connection aktif |
| **Performance & Efficiency** | 5.0 / 10 | 🟡 Cukup | N+1 scalar subquery pada laporan, koneksi ganda |
| **Deployment & Environment** | 1.5 / 10 | 🔴 Tidak Siap | Kredensial hardcoded, web root tidak terisolasi |
| **Error Handling & Observability**| 2.0 / 10 | 🔴 Rentan | Terdapat perintah `die()` dan `print_r($_POST)` di model |
| **Disaster Recovery** | 3.0 / 10 | 🟠 Cacat | Fitur Restore gagal untuk tahun ajaran dan frekuensi |

### **TOTAL PRODUCTION READINESS SCORE: 28 / 100**
### **STATUS: 🔴 PRODUCTION DEPLOYMENT MUST BE BLOCKED**

---

## 3. DAFTAR TEMUAN MASALAH BERDASARKAN PRIORITAS

Berikut adalah tabel rekapitulasi temuan masalah yang wajib dijadikan acuan kerja oleh tim developer:

| Kode Temuan | Tingkat Bahaya | Komponen Terdampak | Deskripsi Singkat Masalah | Dampak Nyata di Production |
|---|:---:|---|---|---|
| **SEC-01** | **CRITICAL** | `app/core/Controller.php` | Logika `isAdmin()` meloloskan request dari user yang belum login | Penyerang luar dapat membuat akun Admin baru tanpa otentikasi |
| **SEC-02** | **CRITICAL** | `app/controllers/User.php` | `updateProfil()` tidak memiliki proteksi login & terdapat IDOR | Pengambilalihan akun Administrator utama secara sepihak |
| **SEC-03** | **CRITICAL** | Web Root / `.htaccess` | File `db_monitoring_praktikum.sql` & `temp.sql` ada di root web | Kebocoran data seluruh dosen, asisten, dan hash sandi |
| **SEC-04** | **CRITICAL** | `Mentoring.php` & `Restore.php` | Seluruh method aksi tidak memverifikasi hak akses/sesi login | Pihak luar dapat menghapus dan memodifikasi presensi praktikum |
| **SEC-05** | **HIGH** | Seluruh Form & Link | Tidak ada token Anti-CSRF; Aksi hapus data memakai HTTP GET | Penghapusan data via malicious link / one-click attack |
| **SEC-06** | **HIGH** | Web Root | File `debug_tambah_asisten.php` & `test_upload.php` aktif | Kebocoran path direktori server, user proses, dan pengujian liar |
| **SEC-07** | **HIGH** | `app/config/config.php` | Nilai `BASEURL` bergantung pada header `HTTP_HOST` tanpa filter | Host Header Injection, Poisoning aset, dan Reflected XSS |
| **DAT-01** | **HIGH** | `Asisten_model`, `Jurusan_model` | Multi-table cascade delete dijalankan tanpa DB Transaction | Korupsi data dan rusaknya data historis praktikum jika query terputus |
| **DAT-02** | **HIGH** | `app/models/Restore_model.php` | Switch-case kehilangan handler untuk tabel tahun ajaran & frekuensi | Data tahun ajaran dan jadwal yang dihapus tidak pernah bisa dipulihkan |
| **SEC-08** | **HIGH** | `Asisten_model.php` & `Database.php` | Debugging error langsung mengeksekusi `print_r($_POST)` dan `die()` | Stack trace dan skema internal basis data bocor ke publik |
| **SEC-09** | **HIGH** | `Login.php` & `Controller.php` | Rate limit berbasis session cookie; Algoritma remember-me tidak sinkron | Serangan brute-force kamus sandi leluasa tanpa batas penguncian |
| **SEC-10** | **MEDIUM** | `User.php` & `Controller.php` | Parameter `$id_user` tidak divalidasi numerik saat menyusun nama WebP | Potensi manipulasi nama berkas dan path traversal di upload |
| **SEC-11** | **MEDIUM** | `public/js/script.js` | Response AJAX disuntikkan via `innerHTML` tanpa escaping | DOM Stored XSS saat menampilkan jadwal praktikum |
| **LOG-01** | **MEDIUM** | `app/models/Matakuliah_model.php`| Query memakai `INNER JOIN` ke jurusan | Matakuliah umum tanpa jurusan tidak muncul di antarmuka admin |
| **INF-01** | **MEDIUM** | `app/config/config.php` | Terdapat eksekusi ganda `mysqli_connect` bersamaan dengan PDO | Beban ganda koneksi database pada setiap request web |

---

## 4. PANDUAN LANGKAH PERBAIKAN TEKNIS UNTUK DEVELOPER

### PRIORITAS P0 — PERBAIKAN KRITIS (BLOCKER MUTLAK)
*Batas Waktu: 1x24 Jam — Sistem tidak boleh terkoneksi ke jaringan publik sebelum fase ini tuntas.*

#### 1. Memperbaiki Kontrol Akses pada `app/core/Controller.php`
- **Tindakan**:
  - Hapus logika pemeriksaan longgar pada metode `isAdmin()` dan `isAsisten()`.
  - Pastikan setiap metode memeriksa eksistensi `$_SESSION['id_user']` dan mencocokkan string role secara ketat (`===`).
  - Lakukan pengalihan (`header('Location: ' . BASEURL . '/login')`) dan panggil perintah `exit;` secara mutlak.

#### 2. Mengamankan Endpoint Profil & User pada `app/controllers/User.php`
- **Tindakan**:
  - Pada metode `updateProfil()`, tambahkan pemanggilan `$this->isLogin();`.
  - **Larangan Keras**: Jangan mengambil ID user yang diedit dari `$_POST['id_user']`. Ambil ID secara mutlak dari sesi login: `$id_user = $_SESSION['id_user'];`.
  - Wajibkan verifikasi kata sandi lama sebelum mengizinkan pembaruan kata sandi baru.
  - Tambahkan proteksi `$this->isAdmin();` pada metode `prosesUbah()` dan `ubahModal()`.

#### 3. Karantina dan Pembersihan Berkas Sensitif dari Web Root
- **Tindakan**:
  - Hapus berkas `db_monitoring_praktikum.sql` dan `temp.sql` dari direktori `C:\xampp\htdocs\monitoring-praktikum`.
  - Pindahkan file skema SQL ke folder terisolasi di luar web root (misalnya folder `database/migrations/`).
  - Daftarkan `*.sql`, `*.log`, dan `.env` ke dalam berkas `.gitignore`.
  - Hapus berkas pengujian `debug_tambah_asisten.php` dan `test_upload.php`.
  - Tambahkan aturan proteksi pada `.htaccess` untuk memblokir unduhan file berkas konfigurasi/database secara langsung.

#### 4. Mengunci Akses pada `Mentoring.php` dan `Restore.php`
- **Tindakan**:
  - Pasang validasi `$this->isLogin();` pada konstruktor atau setiap metode di `app/controllers/Mentoring.php`.
  - Pasang validasi `$this->isAdmin();` pada seluruh metode di `app/controllers/Restore.php` (`index`, `kembalikan`, `hapusPermanen`). Pengguna non-admin sama sekali tidak boleh melihat atau memicu pemulihan data.

---

### PRIORITAS P1 — WAJIB SEBELUM DEPLOY KE SERVER PUBLIK
*Batas Waktu: Hari ke-2 s.d. Hari ke-4.*

#### 1. Implementasi Proteksi Anti-CSRF & Pembatasan Metode HTTP
- **Tindakan**:
  - Buat fungsi pembangkit token CSRF pada session (`$_SESSION['csrf_token'] = bin2hex(random_bytes(32));`).
  - Sisipkan `<input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">` pada setiap formulir `<form>`.
  - Buat helper validasi `SecurityHelper::verifyCsrfToken($_POST['csrf_token'] ?? '')`.
  - **Ubah seluruh tautan aksi penghapusan**: Larang penggunaan `<a href=".../hapus/id">`. Ganti dengan form tersembunyi bermetode `POST` yang dilengkapi token CSRF.

#### 2. Penerapan Transaksi Database (ACID) pada Penghapusan Berelasi
- **Tindakan**:
  - Gunakan `$this->db->beginTransaction()`, `$this->db->commit()`, dan `$this->db->rollBack()` pada metode `prosesHapus()` di `Asisten_model`, `Jurusan_model`, `Dosen_model`, `Kelas_model`, `Matakuliah_model`, `Ajaran_model`, dan `Ruangan_model`.
  - Jangan biarkan eksekusi delete berjalan parsial tanpa rollback saat terjadi kendala foreign key.

#### 3. Sanitasi Output & Pencegahan Host Header Injection
- **Tindakan**:
  - Pada `app/config/config.php`, jangan membentuk `BASEURL` murni dari `$_SERVER['HTTP_HOST']`. Tentukan domain resmi server di konfigurasi lingkungan (environment variable).
  - Tinjau fungsi `updateFrekuensiTable()` pada `public/js/script.js`. Gunakan fungsi `textContent` atau sanitasi string HTML sebelum menambahkan baris ke tabel untuk mencegah eksploitasi XSS.
  - Pada `app/core/Flasher.php`, bungkus nilai `pesan` dan `aksi` menggunakan fungsi `e()` atau `htmlspecialchars()`.

#### 4. Standardisasi Error Handling (Pembersihan Debugging Code)
- **Tindakan**:
  - Hapus kode `print_r($data); die;` pada `Asisten_model.php`.
  - Hapus kode `die($e->getMessage());` pada `Database.php`.
  - Pastikan jika koneksi basis data gagal, aplikasi mencatatnya ke error log server (`error_log($e->getMessage())`) dan mengalihkan pengguna ke halaman kesalahan `500.php` yang informatif tanpa membeberkan kredensial.

---

### PRIORITAS P2 — PENGUATAN KEAMANAN & STABILITAS DATA
*Batas Waktu: Hari ke-5 s.d. Hari ke-7.*

#### 1. Perbaikan Fitur Disaster Recovery pada `app/models/Restore_model.php`
- **Tindakan**:
  - Tambahkan blok case untuk entitas `'mst_tahun_ajaran'` dan `'trs_frekuensi'` pada metode `restoreData()` agar data yang dihapus dapat dikembalikan dengan benar.
  - Pastikan kolom referensi foreign key diperiksa sebelum melakukan insert kembali.

#### 2. Perbaikan Mekanisme Remember-Me & Rate Limiting Login
- **Tindakan**:
  - Selaraskan pencocokan cookie login: Simpan token acak (hash token) di tabel database pengguna, bukan membuat hash dari username dan password database.
  - Tambahkan atribut cookie `HttpOnly`, `Secure`, dan `SameSite=Lax` pada saat memanggil fungsi `setcookie()`.
  - Catat kegagalan login berdasarkan kombinasi `IP Address + Username` pada tabel khusus di database agar proteksi penguncian 15 menit tidak dapat dihindari hanya dengan menghapus cookie sesi.

#### 3. Pengamanan Alur Upload Berkas
- **Tindakan**:
  - Pada `Controller::prosesUpload()`, buat nama berkas acak yang murni menggunakan `bin2hex(random_bytes(16)) . '.webp'` untuk menghindari tabrakan nama berkas antar asisten serta menutup celah manipulasi path.
  - Validasi dimensi gambar maksimum (`getimagesize()`) sebelum memproses konversi WebP via pustaka GD guna mencegah serangan *Image Decompression Bomb*.

#### 4. Perbaikan Query Master Mata Kuliah
- **Tindakan**:
  - Pada `app/models/Matakuliah_model.php`, ubah `JOIN mst_jurusan` menjadi `LEFT JOIN mst_jurusan` agar mata kuliah umum yang tidak terikat jurusan tertentu tetap tampil di antarmuka pengguna.

---

### PRIORITAS P3 — PEMBERSIHAN TECHNICAL DEBT & INFRASTRUKTUR
*Batas Waktu: Pasca-stabilisasi.*

1. **Hapus Koneksi Ganda di `app/config/config.php`**:
   - Hapus pemanggilan variabel `$connect = mysqli_connect(...)`. Seluruh aplikasi telah menggunakan kelas `Database` berbasis PDO.
2. **Standardisasi Struktur Web Root**:
   - Konfigurasikan Apache VirtualHost agar DocumentRoot mengarah langsung ke subfolder `public/`, sehingga folder `app/`, `docs/`, dan file internal lainnya berada di luar jangkauan HTTP server.
3. **Penyusunan Kontainerisasi (Docker)**:
   - Buat `Dockerfile` berbasis `php:8.2-apache` dan `docker-compose.yml` untuk menyelaraskan konfigurasi lokal developer dengan server production.
4. **Dependensi Vendor Lokal**:
   - Simpan pustaka JavaScript (jQuery, Bootstrap, DataTables, FullCalendar) di folder lokal `public/template/plugins/` daripada mengandalkan CDN publik eksternal yang rentan gangguan konektivitas jaringan kampus.

---

## 5. CONTOH IMPLEMENTASI KODE (BEFORE VS AFTER)

Berikut adalah panduan transformasi kode spesifik yang harus diterapkan developer:

### Perbaikan 1: Logika Pemeriksaan Akses Administrator (`app/core/Controller.php`)

**❌ KODE SEBELUMNYA (RENTAN BYPASS):**
```php
public function isAdmin() {
    if (isset($_SESSION['role']) && $_SESSION['role'] != 'Admin') {  
        if ($_SESSION['role'] == 'Asisten') {
            header('Location:' . BASEURL);
        } else {
        }
        exit;
    }
}
```

**✅ KODE PERBAIKAN (AMAN):**
```php
public function isAdmin() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Wajib ada sesi login DAN role harus tepat bernilai 'Admin'
    if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
        header('Location: ' . BASEURL . '/login');
        exit;
    }
}

public function isAsisten() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Wajib ada sesi login DAN role harus tepat bernilai 'Asisten'
    if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'Asisten') {
        header('Location: ' . BASEURL . '/login');
        exit;
    }
}
```

---

### Perbaikan 2: Pembaruan Profil & Pencegahan IDOR (`app/controllers/User.php`)

**❌ KODE SEBELUMNYA (RENTAN ACCOUNT TAKEOVER):**
```php
public function updateProfil() {
    $id_user = $_POST['id_user']; // Mengambil ID dari form publik
    $passwordBaru = $_POST['password'];
    
    $userLama = $this->model('User_model')->getUserById($id_user);
    // ... langsung melakukan update data tanpa cek sesi login!
```

**✅ KODE PERBAIKAN (AMAN):**
```php
public function updateProfil() {
    $this->isLogin(); // Pastikan user telah terotentikasi

    // ID diambil secara mutlak dari sesi, abaikan input $_POST['id_user']
    $id_user = (int)$_SESSION['id_user'];
    $passwordLama = $_POST['password_lama'] ?? '';
    $passwordBaru = $_POST['password_baru'] ?? '';
    
    $userLama = $this->model('User_model')->getUserById($id_user);
    if (!$userLama) {
        Flasher::setFlash('Gagal', 'Pengguna tidak ditemukan', 'danger');
        header('Location: ' . BASEURL . '/login');
        exit;
    }

    // Jika ingin mengganti password, verifikasi password lama terlebih dahulu
    $passwordFinal = $userLama['password'];
    if (!empty($passwordBaru)) {
        if (empty($passwordLama) || !password_verify($passwordLama, $userLama['password'])) {
            Flasher::setFlash('Gagal', 'Kata sandi lama salah atau tidak diisi!', 'danger');
            header('Location: ' . BASEURL . '/user/profil');
            exit;
        }
        $passwordFinal = password_hash($passwordBaru, PASSWORD_DEFAULT);
    }

    $dataUpdate = [
        'id_user'   => $id_user,
        'username'  => filter_var(trim($_POST['username']), FILTER_SANITIZE_EMAIL),
        'nama_user' => htmlspecialchars(trim($_POST['nama_user']), ENT_QUOTES, 'UTF-8'),
        'password'  => $passwordFinal,
        'role'      => $userLama['role'] // Cegah manipulasi role sendiri
    ];

    if ($this->model('User_model')->ubahDataUserLengkap($dataUpdate) >= 0) {
        $_SESSION['nama_user'] = $dataUpdate['nama_user'];
        $_SESSION['username'] = $dataUpdate['username'];
        Flasher::setFlash('Berhasil', 'Profil Anda telah berhasil diperbarui', 'success');
    } else {
        Flasher::setFlash('Gagal', 'Gagal menyimpan perubahan profil', 'danger');
    }

    header('Location: ' . BASEURL . '/user/profil');
    exit;
}
```

---

### Perbaikan 3: Database Transaction pada Penghapusan Data (`app/models/Jurusan_model.php`)

**❌ KODE SEBELUMNYA (POTENSI DATA CORRUPTION):**
```php
public function prosesHapus($id){
    try {
        $jurusan = $this->ubah($id);
        // eksekusi delete 1
        $this->db->query("DELETE FROM trs_mentoring WHERE ...");
        $this->db->execute();
        // eksekusi delete 2
        $this->db->query("DELETE FROM trs_frekuensi WHERE ...");
        $this->db->execute();
        // eksekusi delete 3 (gagal karena foreign key kelas & matkul, tapi delete 1 & 2 terlanjur hilang!)
        $this->db->query("DELETE FROM mst_jurusan WHERE ...");
        $this->db->execute();
        return $this->db->rowCount();
    } catch (PDOException $e) {
        return 0;
    }
}
```

**✅ KODE PERBAIKAN (AMAN & ACID COMPLIANT):**
```php
public function prosesHapus($id){
    $jurusan = $this->ubah($id);
    if (!$jurusan) {
        return 0;
    }

    // Mulai Database Transaction
    $this->db->beginTransaction();
    try {
        $deletedBy = $_SESSION['id_user'] ?? 0;
        $restoreModel = new Restore_model();
        $restoreModel->saveToRestore('mst_jurusan', $jurusan, $deletedBy);

        // 1. Hapus Mentoring terkait frekuensi di jurusan ini
        $this->db->query("DELETE FROM trs_mentoring WHERE id_frekuensi IN 
                         (SELECT id_frekuensi FROM trs_frekuensi WHERE id_jurusan = :id)");
        $this->db->bind(':id', $id);
        $this->db->execute();

        // 2. Hapus Frekuensi di jurusan ini
        $this->db->query("DELETE FROM trs_frekuensi WHERE id_jurusan = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();

        // 3. Hapus Kelas di jurusan ini
        $this->db->query("DELETE FROM mst_kelas WHERE id_jurusan = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();

        // 4. Hapus Matakuliah di jurusan ini
        $this->db->query("DELETE FROM mst_matakuliah WHERE id_jurusan = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();

        // 5. Hapus Jurusan
        $this->db->query("DELETE FROM mst_jurusan WHERE id_jurusan = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();

        // Commit transaksi jika semua kueri berhasil
        $this->db->commit();
        return 1;

    } catch (Exception $e) {
        // Batalkan seluruh penghapusan jika terjadi satu saja kegagalan
        $this->db->rollBack();
        error_log("Gagal menghapus jurusan ID $id: " . $e->getMessage());
        return 0;
    }
}
```

---

### Perbaikan 4: Pengamanan Web Server (`.htaccess` Web Root)

**✅ KODE ATURAN `.htaccess` TERBARU:**
```apache
Options -Multiviews -Indexes
RewriteEngine On

# 1. Blokir akses langsung ke file sensitif, file konfigurasi, dan dump database
<FilesMatch "\.(sql|log|env|git|ini|sh|bak|md)$">
    Require all denied
</FilesMatch>

# 2. Blokir akses langsung ke folder internal aplikasi
RewriteRule ^app/ - [F,L]
RewriteRule ^docs/ - [F,L]

# 3. Teruskan request aset publik jika file fisik ada
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d

# 4. Arahkan seluruh rute ke index.php
RewriteRule ^(.*)$ index.php?url=$1 [L,QSA]
```

---

## 6. CHECKLIST VERIFIKASI PENGUJIAN

Tim pengembang wajib mengisi dan memastikan seluruh checklist berikut bernilai **PASS** sebelum mengajukan audit ulang:

| ID | Item Pengujian | Metode Pengujian | Hasil yang Diharapkan | Status (Pass/Fail) |
|---|---|---|---|:---:|
| **QA-01** | Akses Controller Admin Tanpa Login | Kirim request POST ke `/User/tambah` dalam mode penyamaran (Incognito) | Sistem menolak dan me-redirect ke `/login` tanpa membuat data | [ ] |
| **QA-02** | Akses Form Ubah Profil Pengguna Lain | Kirim parameter `id_user=1` dari akun Asisten ke `/User/updateProfil` | Sistem mengabaikan input form dan hanya memproses user aktif di sesi | [ ] |
| **QA-03** | Pengunduhan File Database Dump | Buka URL `http://localhost/monitoring-praktikum/db_monitoring_praktikum.sql` | Server mengembalikan status `403 Forbidden` atau `404 Not Found` | [ ] |
| **QA-04** | Akses Operasi Mentoring & Restore Tanpa Sesi | Akses URL `/Mentoring/hapus/1` dan `/Restore/hapusPermanen/1` tanpa login | Server menolak dan me-redirect ke halaman login | [ ] |
| **QA-05** | Pengujian Integritas Database Rollback | Simulasikan error koneksi di tengah proses penghapusan jurusan | Data presensi dan frekuensi tidak hilang sebagian (Rollback aktif) | [ ] |
| **QA-06** | Pengujian Pemulihan Data (Restore) | Hapus 1 Tahun Ajaran, lalu klik tombol "Kembalikan" di menu Restore | Tahun Ajaran sukses kembali ke tabel asal tanpa error SQL | [ ] |
| **QA-07** | Pengujian Cross-Site Request Forgery | Panggil URL penghapusan data via browser tab lain tanpa token CSRF | Permintaan ditolak dengan pesan `403 Invalid CSRF Token` | [ ] |
| **QA-08** | Pengujian Tampilan Error Database | Masukkan data duplikat pada nama jurusan atau stambuk | Aplikasi memunculkan flash message ramah pengguna, tanpa `print_r` / `die` | [ ] |
| **QA-09** | Pengujian Upload Berkas WebP | Unggah foto profil JPG dan PNG dengan nama file berkarakter khusus | Berkas tersimpan dengan format WebP dan nama acak unik yang aman | [ ] |

---

## 7. LEMBAR TANDA TANGAN & PERSETUJUAN

Laporan ini disusun secara resmi untuk menjadi acuan kerja tim teknis pengembang perangkat lunak Sistem Monitoring Praktikum ICLabs FIKOM UMI.

Makassar, 04 September 2026

**Mengetahui & Menyetujui,**

| Auditor Keamanan Aplikasi | Lead Developer / Penanggung Jawab Teknis |
|:---:|:---:|
| <br><br><br>**( Senior Bug Hunter & Security Auditor )**<br>*Security & Production Readiness Division* | <br><br><br>**( Lead Software Engineer )**<br>*Development Team Kelompok 4* |

---
*Catatan Dokumen: Dokumen ini mengikat secara teknis. Segala bentuk bypass terhadap blocker prioritas P0 tanpa persetujuan tertulis dari auditor keamanan merupakan pelanggaran protokol rilis sistem informasi.*
