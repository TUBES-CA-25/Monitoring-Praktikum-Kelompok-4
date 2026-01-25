# Sistem Monitoring Praktikum Laboratorium FIKOM UMI

#### Kelompok 4
#### - Zaki Falihin Ayyubi
#### - Muhammad Rafli
#### - Rizqi Ananda Jalil

## Deskripsi Aplikasi
Aplikasi berbasis web untuk memonitoring kegiatan praktikum, pengelolaan asisten, dosen, serta jadwal mentoring di laboratorium. Dibangun menggunakan **PHP Native** dengan konsep **MVC (Model-View-Controller)**.

## Fitur Website
ADMIN:
Profil : Edit
Dashboard : Read
Monitoring : CRUD
Laporan : Read
Data Dosen : CRUD
Data Asisten : CRUD
Data User : CRUD (Terhubung ke Data Asisten dan Dosen)
Data Matakuliah : CRUD
Data Laboratorium : CRUD
Data Kelas : CRUD
Data Jurusan : CRUD
Data Tahun Ajaran : CRUD

ASISTEN
Profil : Edit
Dashboard : Read
Monitoring : CRUD

## Struktur Folder (MVC)
monitoring-praktikum/
├── app/
│   ├── config/
│   │   └── config.php
│   ├── controllers/
│   │   ├── Ajaran.php
│   │   ├── Asisten.php
│   │   ├── Dosen.php
│   │   ├── Frekuensi.php
│   │   ├── Home.php
│   │   ├── Jurusan.php
│   │   ├── Kelas.php
│   │   ├── Laporan.php
│   │   ├── Login.php
│   │   ├── Matakuliah.php
│   │   ├── Mentoring.php
│   │   ├── Ruangan.php
│   │   └── User.php
│   ├── core/
│   │   ├── App.php
│   │   ├── Controller.php
│   │   ├── Database.php
│   │   ├── Flasher.php
│   │   └── IIController.php
│   ├── models/
│   │   ├── Ajaran_model.php
│   │   ├── Asisten_model.php
│   │   ├── Dosen_model.php
│   │   ├── Frekuensi_model.php
│   │   ├── Jadwal_model.php
│   │   ├── Jurusan_model.php
│   │   ├── Kelas_model.php
│   │   ├── Laporan_model.php
│   │   ├── Login_model.php
│   │   ├── Matakuliah_model.php
│   │   ├── Mentoring_model.php
│   │   ├── Ruangan_model.php
│   │   └── User_model.php
│   └── views/
│       ├── Ajaran/
│       │   ├── index.php
│       │   ├── tambah_ajaran.php
│       │   └── ubah_ajaran.php
│       ├── asisten/
│       │   ├── index.php
│       │   ├── tambah_asisten.php
│       │   └── ubah_asisten.php
│       ├── dosen/
│       │   ├── index.php
│       │   ├── tambah_dosen.php
│       │   └── ubah_dosen.php
│       ├── frekuensi/
│       │   ├── index.php
│       │   ├── tambah_frekuensi.php
│       │   └── ubah_frekuensi.php
│       ├── home/
│       │   ├── index.php
│       ├── jurusan/
│       │   ├── index.php
│       │   ├── tambah_jurusan.php
│       │   └── ubah_jurusan.php
│       ├── kelas/
│       │   ├── index.php
│       │   ├── tambah_kelas.php
│       │   └── ubah_kelas.php
│       ├── laporan/
│       │   ├── export_excel_action.php
│       │   └── index.php
│       ├── login/
│       │   ├── index.php
│       │   └── index1.php
│       ├── matakuliah/
│       │   ├── index.php
│       │   ├── tambah_matakuliah.php
│       │   └── ubah_matakuliah.php
│       ├── mentoring/
│       │   ├── detail.php
│       │   ├── index.php
│       │   ├── tambah_mentoring.php
│       │   └── ubah_mentoring.php
│       ├── ruangan/
│       │   ├── index.php
│       │   ├── tambah_ruangan.php
│       │   └── ubah_ruangan.php
│       ├── templates/
│       │   ├── footer.php
│       │   ├── header.php
│       │   ├── sidebar.php
│       │   └── topbar.php
│       └── user/
│       │   ├── index.php
│       │   ├── tambah_user.php
│       │   ├── ubah_user.php
├── public/
│   ├── css/
│   ├── img/
│   ├── js/
│   └── template/
├── .gitinitcore
├── .htaccess
├── db_monitoring_praktikum-new.sql
├── index.php
├── monitoring_praktikum.sql
├── README.md
└── temp.sql

## Penjelasan Mengenai MVC
<img width="3999" height="1999" alt="image" src="https://github.com/user-attachments/assets/5f539f9e-14ff-4b3b-aac2-4e770fb1e54b" />

### 1. Model (Data)
- Definisi: Komponen yang berhubungan langsung dengan database.
- Peran Utama: Mengelola data (CRUD: Create, Read, Update, Delete). Model tidak peduli bagaimana data ditampilkan, ia hanya tahu cara mengambil, menyimpan, dan memproses data berdasarkan kueri SQL.
  
### 2. View (Tampilan)
- Definisi: Komponen yang berisi apa yang dilihat oleh pengguna (User Interface).
- Peran Utama: Menampilkan data yang dikirim oleh Model melalui Controller ke dalam format HTML/CSS. View tidak boleh memiliki logika yang berat; tugasnya hanya mencetak variabel data.
  
### 3. Controller (Otak)
- Definisi: Jembatan atau penghubung antara Model dan View.
- Peran Utama: Menerima permintaan (request) dari pengguna (misal: klik tombol Filter), meminta data ke Model, lalu mengirimkan hasilnya ke View untuk ditampilkan. Controller mengatur "lalu lintas" logika aplikasi.


##  Role & Akses Login

Aplikasi ini memiliki 2 jenis user dengan hak akses berbeda:

| Role | Akses |
|------|-------|
| Admin | Full access (kelola semua data) |
| Asisten | Edit Profil & Input, Edit kegiatan monitoring |

**LINK WIREFRAME, UI/UX** : https://www.figma.com/design/4NRVbxZMbC3GH0vDGgKXw1/Tubes-Monitoring-Praktikum?node-id=0-1&p=f&t=wp3gnwP24i3hwVg0-0

**LINK FLOWCHART, USE CASE, ACTIVITY DIAGRAM, ERD** : https://app.diagrams.net/?src=about#G1STQ8m5rozE-dUxZWm64ATBabYVF9YJAM#%7B%22pageId%22%3A%22Sj3gRpXGsk_He88CJsHY%22%7D






