# Web Manajemen Stok dan Penjualan

Prototipe aplikasi web untuk melihat persediaan barang, menambah stok pembelian, mencatat penjualan, dan menampilkan ringkasan penjualan. Proyek menggunakan PHP, MySQL melalui ekstensi MySQLi, CSS, dan Chart.js.

**Status:** kode pembelajaran/prototipe. Repositori belum menyediakan ekspor skema SQL atau proses instalasi database yang dapat direproduksi. Aplikasi belum siap dijalankan dari clone baru tanpa melengkapi database dan memperbaiki beberapa jalur halaman.

## Fitur yang ada dalam kode

| Area | Implementasi |
| --- | --- |
| Login | Form username, password, dan pilihan peran; pemeriksaan akun serta penyimpanan sesi. |
| Dashboard | Daftar stok rendah, grafik jumlah barang terjual per tanggal, dan daftar barang populer berdasarkan jumlah transaksi. |
| Cek stok | Daftar barang dengan status `Out of Stock`, `Low Stock`, atau `Normal`. |
| Pembelian | Menambah stok barang yang dipilih. Pencatatan riwayat pembelian belum diimplementasikan pada halaman ini. |
| Penjualan | Memeriksa kecukupan stok, mengurangi stok, dan mencatat jumlah penjualan. |
| Rekap | Kode rekap jumlah terjual dan jumlah transaksi per barang dengan filter rentang tanggal. |

Kolom `amount` pada alur penjualan digunakan sebagai **jumlah barang**, sehingga grafik dashboard bukan laporan omzet atau laba. Input bertuliskan “Scan Barcode” hanya mencocokkan teks dengan label pilihan barang; belum ada pemindai kamera atau integrasi perangkat barcode khusus.

## Teknologi

- PHP dengan ekstensi `mysqli` dan dukungan sesi.
- MySQL untuk penyimpanan data.
- HTML dan CSS untuk halaman aplikasi.
- Chart.js dari CDN untuk grafik dashboard; pemuatan grafik memerlukan akses internet.

Tidak ada dependensi Composer, npm, framework PHP, atau proses build yang disertakan.

## Struktur proyek

```text
web-manajemen-stok/
├── assets/
│   ├── css/style.css       # Gaya halaman
│   └── login.php           # Form login yang tersedia saat ini
├── auth.php                # Pemeriksaan login dan sesi
├── config.php              # Konfigurasi koneksi MySQLi
├── dashboard.php           # Stok rendah dan ringkasan penjualan
├── cek_stok.php             # Daftar dan status persediaan
├── pembelian.php            # Penambahan stok
├── penjualan.php            # Pengurangan stok dan pencatatan penjualan
├── rekap_penjualan          # Kode PHP rekap; nama file belum berekstensi .php
└── manajemen_stok/          # Berkas fisik database lama, bukan dump SQL
```

## Persiapan lingkungan lokal

1. Clone repositori:

   ```sh
   git clone https://github.com/samsuldwicahyo/web-manajemen-stok.git
   cd web-manajemen-stok
   ```

2. Siapkan lingkungan pengembangan dengan PHP, ekstensi MySQLi, server web yang dapat menjalankan PHP, dan MySQL. Versi runtime yang kompatibel belum diuji dan belum dikunci dalam repositori.

3. Lengkapi skema SQL dan data contoh sebelum mencoba alur aplikasi. Kode mengacu pada tabel `users`, `products`, dan `sales`; folder database juga menyimpan berkas bernama `purchases` dan `roles`. Definisi kolom, tipe, indeks, relasi, dan nilai default yang lengkap belum tersedia sebagai SQL yang dapat diimpor.

   Berkas `.frm` dan `.ibd` di `manajemen_stok/` bukan pengganti ekspor `.sql`. Repositori ini belum memiliki prosedur pemulihan berkas fisik tersebut yang sudah diverifikasi.

4. Sesuaikan variabel koneksi di [config.php](config.php) dengan database lokal milikmu:

   | Variabel | Isi yang perlu disiapkan |
   | --- | --- |
   | `$servername` | Host MySQL lokal |
   | `$username` | Nama akun database untuk pengembangan |
   | `$password` | Password akun database lokal |
   | `$dbname` | Nama database yang skemanya sudah disiapkan |

   Gunakan nilai lokal sendiri. Jangan memasukkan kredensial produksi ke repositori.

5. Perbaiki jalur login sebelum menjalankan alur masuk. Form tersedia di `assets/login.php`, tetapi form mengirim ke `auth.php` relatif terhadap folder `assets/`, sedangkan handler berada di root. Halaman lain mengarahkan pengguna ke `login.php` di root yang belum tersedia. Jalur stylesheet form login juga perlu diselaraskan.

6. Perbaiki penamaan/routing `rekap_penjualan` agar diproses sebagai PHP. Belum ada konfigurasi server untuk file tanpa ekstensi tersebut.

Langkah di atas menjelaskan prasyarat berdasarkan kode yang ada, bukan klaim bahwa instalasi baru sudah berhasil diuji. Belum ada akun demo, seed, atau skrip migrasi yang dapat digunakan langsung.

## Batasan prototipe

- Pilihan peran pada login belum disertai pembatasan akses per halaman; halaman yang tersedia hanya memeriksa keberadaan sesi username.
- Login membandingkan password secara langsung dan query memasukkan input pengguna ke SQL tanpa prepared statement. Validasi input, perlindungan CSRF, serta escaping keluaran juga perlu ditambahkan sebelum penggunaan dengan data nyata.
- Pembaruan stok dan penyimpanan transaksi penjualan belum memakai transaksi database; konsistensi saat proses gagal atau transaksi bersamaan perlu ditangani.
- Validasi jumlah positif belum tersedia di server. Query “barang populer” pada dashboard juga perlu ditinjau agar konsisten dengan struktur tabel dan mode SQL yang dipakai.
- Belum ada suite pengujian otomatis, hasil pengujian runtime, screenshot aplikasi, atau konfigurasi deployment yang terdokumentasi.

## Usulan pemeriksaan QA manual

Daftar ini adalah **rencana pengujian yang belum dijalankan**. Gunakan database lokal dengan data contoh setelah prasyarat instalasi dilengkapi.

- [ ] Login valid dan tidak valid memberikan hasil yang sesuai; akses tanpa sesi diarahkan ke halaman login yang tersedia.
- [ ] Status stok benar pada kondisi stok nol, di bawah batas minimum, sama dengan batas minimum, dan di atas batas minimum.
- [ ] Penambahan stok dengan jumlah valid mengubah stok sesuai nilai yang dimasukkan.
- [ ] Penjualan di bawah, sama dengan, dan melebihi stok menghasilkan perhitungan yang benar; penjualan yang ditolak tidak mengubah data.
- [ ] Input kosong, nol, negatif, bukan angka, serta ID barang yang tidak tersedia ditangani oleh server.
- [ ] Filter tanggal rekap, kondisi tanpa transaksi, dan total pada dashboard sesuai dengan data contoh.
- [ ] Kegagalan pencatatan penjualan dan dua penjualan bersamaan tidak menghasilkan stok atau riwayat yang tidak konsisten.
- [ ] Hak akses setiap peran sesuai kebutuhan yang telah ditentukan.

## Pengembang

[Samsul Dwi Cahyo](https://github.com/samsuldwicahyo)
