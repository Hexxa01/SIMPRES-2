# Penyesuaian program terhadap Laporan Pengembangan Proyek (Kelompok 4)

## Cara menerapkan
1. Salin isi zip ini ke folder proyek Anda (folder `vendor/` tidak ikut; pakai punya Anda).
2. `php artisan migrate`   (3 migrasi baru, tidak menghapus data lama)
3. `php artisan db:seed --class=UserSeeder`   (menambah baris `admins` untuk akun admin01)
4. `php artisan test`

## Perbaikan bug
| Masalah | Perbaikan |
|---|---|
| Setiap halaman error `Table 'simpres.sessions' doesn't exist` (ada di laravel.log) | Migrasi `create_sessions_table` |
| `DatabaseSeeder` & `UserFactory` memakai kolom `name` yang tidak ada | Disesuaikan dengan skema `users` |
| Semua controller mengembalikan JSON; menu di layout membuka JSON mentah | Diganti halaman Blade + Bootstrap |
| `/` tidak punya route | Diarahkan ke login / dashboard sesuai role |

## Kesenjangan kode vs laporan yang ditutup
| Laporan | Sebelumnya | Sekarang |
|---|---|---|
| F-04, F-27, F-30: *hasil/perolehan* (juara/partisipasi) | Tidak ada | Kolom `perolehan`, form, filter, rekap |
| ERD: atribut `deskripsi`; "informasi pendukung" | Tidak ada | Kolom `deskripsi` |
| ERD: relasi Admin *diverifikasi* Prestasi | Tidak ada | `id_admin`, `diverifikasi_pada` |
| F-42 / Activity 2.3 & 2.5: notifikasi status | Tidak ada | Tabel `notifikasi`, badge navbar, halaman Notifikasi, otomatis dibuat saat Admin verifikasi, ditandai dibaca saat detail dibuka |
| Dokumentasi bersifat opsional (Activity 2.2, ERD 0..*) | Wajib min. 1 | Opsional (maks. 10) |
| F-26/F-27: filter nama, NIM, prodi, tingkat, kategori, tahun, perolehan, skor | Tanpa perolehan & skor | Lengkap (skor min/maks) |
| F-29/F-30, Activity 2.8: rekap dipilih per kriteria, pesan data kosong | Pengelompokan tetap | Pilih kategori/tingkat/tahun/prodi/perolehan/skor |
| F-02, F-16: profil | Tidak ada | Halaman Profil + ubah password |
| F-13, Activity 2.4: perbaikan & ajukan ulang | API saja | Form perbaikan; dokumentasi lama bisa dipilih untuk dihapus (sebelumnya semua diganti); catatan Admin tetap terlihat |
| F-31 & deliverable "Manajemen Data Mahasiswa" | Tidak ada | Admin: daftar/tambah/ubah mahasiswa + riwayat prestasi per mahasiswa |
| NF-14: berkas disimpan dengan memperhatikan hak akses | Disk publik (siapa pun dengan URL bisa buka) | Disk privat, dibuka lewat route berkas dengan pengecekan Policy |
| NF-08: autentikasi | Tanpa pembatasan percobaan | `throttle:10,1` pada login |
| Mahasiswa melihat pesan "riwayat kosong" (Activity 2.5) | - | Ada |

## Asumsi yang perlu dikonfirmasi ke pihak Fakultas
- **Aturan skor**: laporan hanya menyebut "ketentuan yang berlaku di Fakultas". Skor saat ini angka 0-100 bebas; rentang rekap (90-100, 80-89, 70-79, <70) adalah usulan.
- **Pilihan perolehan**: Juara 1/2/3, Harapan, Finalis, Partisipasi, Lainnya. **Tingkat**: Lokal/Nasional/Internasional.
- **Rekap bawaan** hanya menghitung data berstatus Terverifikasi (bisa diubah di filter "Status data").
- **Registrasi mandiri** (disebut di DFD Level 0/1) belum dibuat karena tidak ada di daftar kebutuhan fungsional F-01..F-42; akun dibuat Admin.
- Backup data (NF-26) adalah urusan server/hosting, bukan kode aplikasi.
