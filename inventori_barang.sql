-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Des 2019 pada 13.19
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventori_barang`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT '0',
  `satuan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_beli` int(11) DEFAULT NULL,
  `harga_jual` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id`, `nama_barang`, `jumlah`, `satuan`, `harga_beli`, `harga_jual`, `created_at`, `updated_at`) VALUES
(1, 'Kursi Kantor Hidrolik', 0, 'pcs', NULL, 390000, '2019-12-08 22:36:32', '2019-12-12 00:39:31'),
(2, 'Meja Kerja', 0, 'pcs', NULL, 350000, '2019-12-08 22:36:32', '2019-12-12 00:39:56'),
(3, 'Sofa ERGOSIT Grande 1 Seater', 0, 'pcs', NULL, 4800000, '2019-12-08 22:36:32', '2019-12-11 17:29:55'),
(5, 'Lemari Pakaian', 0, 'pcs', 870000, 999000, '2019-12-11 15:36:01', '2019-12-11 17:31:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_barang_keluar`
--

CREATE TABLE `detail_barang_keluar` (
  `id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `jml` int(11) NOT NULL,
  `harga_jual` double(11,0) NOT NULL,
  `total_harga` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_barang_keluar`
--

INSERT INTO `detail_barang_keluar` (`id`, `transaksi_id`, `barang_id`, `jml`, `harga_jual`, `total_harga`, `created_at`, `updated_at`) VALUES
(11, 7, 2, 2, 32000, 64000, '2019-12-11 17:14:23', '2019-12-11 17:14:23'),
(12, 7, 4, 1, 245000, 245000, '2019-12-11 17:14:31', '2019-12-11 17:14:31'),
(13, 7, 5, 2, 3000000, 6000000, '2019-12-11 17:14:39', '2019-12-11 17:14:39'),
(14, 7, 1, 3, 12000, 36000, '2019-12-11 17:14:51', '2019-12-11 17:14:51'),
(15, 8, 5, 1, 3000000, 3000000, '2019-12-11 17:25:24', '2019-12-11 17:25:24'),
(16, 8, 5, 1, 3000000, 3000000, '2019-12-11 17:25:26', '2019-12-11 17:25:26'),
(19, 11, 1, 1, 390000, 390000, '2019-12-11 17:39:31', '2019-12-11 17:39:31'),
(20, 11, 2, 1, 350000, 350000, '2019-12-11 17:39:56', '2019-12-11 17:39:56');

--
-- Trigger `detail_barang_keluar`
--
DELIMITER $$
CREATE TRIGGER `after_add_total_harga_tr` AFTER INSERT ON `detail_barang_keluar` FOR EACH ROW BEGIN
update transaksi_barang_keluar set total_barang = total_barang + NEW.jml , total_harga = total_harga + NEW.total_harga where id = NEW.transaksi_id;
update barang set jumlah = jumlah - NEW.jml where barang.id = NEW.barang_id ;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_save_add_harga_jual` BEFORE INSERT ON `detail_barang_keluar` FOR EACH ROW BEGIN

DECLARE harga int;
SELECT harga_jual INTO @harga from barang where barang.id = NEW.barang_id;

SET NEW.harga_jual = @harga;
SET NEW.total_harga = @harga * NEW.jml;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_tr` AFTER DELETE ON `detail_barang_keluar` FOR EACH ROW update barang set jumlah = jumlah + OLD.jml where barang.id = OLD.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_barang_masuk`
--

CREATE TABLE `detail_barang_masuk` (
  `id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `jml` int(11) NOT NULL,
  `harga_beli` double(11,0) NOT NULL,
  `total_harga` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `detail_barang_masuk`
--

INSERT INTO `detail_barang_masuk` (`id`, `transaksi_id`, `barang_id`, `jml`, `harga_beli`, `total_harga`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 999000, 999000, '2019-12-11 17:38:21', '2019-12-11 17:38:21'),
(2, 1, 2, 1, 240000, 240000, '2019-12-11 17:38:38', '2019-12-11 17:38:38');

--
-- Trigger `detail_barang_masuk`
--
DELIMITER $$
CREATE TRIGGER `add_total_barang_harga` AFTER INSERT ON `detail_barang_masuk` FOR EACH ROW BEGIN
update transaksi_barang_masuk set total_barang = total_barang + NEW.jml , total_harga = total_harga + NEW.total_harga where id = NEW.transaksi_id;
update barang set jumlah = jumlah + NEW.jml where barang.id = NEW.barang_id ;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `add_total_harga` BEFORE INSERT ON `detail_barang_masuk` FOR EACH ROW SET NEW.total_harga = NEW.jml * NEW.harga_beli
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `delete_stock` AFTER DELETE ON `detail_barang_masuk` FOR EACH ROW update barang set jumlah = jumlah - OLD.jml where barang.id = OLD.barang_id
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemasukan_barang`
--

CREATE TABLE `pemasukan_barang` (
  `id` int(255) NOT NULL,
  `no_pemasukan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_barang` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_masuk` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pemasukan_barang`
--

INSERT INTO `pemasukan_barang` (`id`, `no_pemasukan`, `id_barang`, `jumlah`, `tgl_masuk`, `created_at`, `updated_at`) VALUES
(1, 'PEM201909241212', 1, 10, '2019-09-25 20:33:11', '2019-12-08 22:37:38', '2019-12-08 22:37:38'),
(3, 'PEM201909250002', 2, 15, '2019-09-25 20:51:50', '2019-12-08 22:37:38', '2019-12-08 22:37:38'),
(4, 'PEM201909250003', 2, 5, '2019-09-25 20:53:52', '2019-12-08 22:37:38', '2019-12-08 22:37:38');

--
-- Trigger `pemasukan_barang`
--
DELIMITER $$
CREATE TRIGGER `AFTER_INSERT_PEMASUKAN` AFTER INSERT ON `pemasukan_barang` FOR EACH ROW update barang set jumlah = jumlah+NEW.jumlah where id_barang = NEW.id_barang
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `AFTER_UPDATE_PEMASUKAN` AFTER UPDATE ON `pemasukan_barang` FOR EACH ROW BEGIN
DECLARE jumlah_baru integer;
DECLARE jumlah_lama integer;
DECLARE jumlah_new integer;

set @jumlah_baru = NEW.jumlah;
set @jumlah_lama = OLD.jumlah;

IF @jumlah_baru > @jumlah_lama THEN
 SET @jumlah_new = @jumlah_baru - @jumlah_lama;
else
 SET @jumlah_new = @jumlah_baru - @jumlah_lama;
end if;

if NEW.id_barang <> OLD.id_barang THEN
update barang set jumlah = jumlah+NEW.jumlah where id_barang = NEW.id_barang;
update barang set jumlah = jumlah-OLD.jumlah where id_barang = OLD.id_barang;
ELSE
update barang set jumlah = jumlah+@jumlah_new where id_barang = NEW.id_barang;
END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran_barang`
--

CREATE TABLE `pengeluaran_barang` (
  `id` int(255) NOT NULL,
  `no_pengeluaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_pengeluaran` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengeluaran_barang`
--

INSERT INTO `pengeluaran_barang` (`id`, `no_pengeluaran`, `id_barang`, `jumlah`, `tgl_pengeluaran`, `created_at`, `updated_at`) VALUES
(1, 'PEL201909250001', '1', 2, '2019-09-25 21:51:11', '2019-12-08 22:38:18', '2019-12-08 22:38:18'),
(2, 'PEL201909250002', '2', 2, '2019-09-25 21:53:52', '2019-12-08 22:38:18', '2019-12-08 22:38:18');

--
-- Trigger `pengeluaran_barang`
--
DELIMITER $$
CREATE TRIGGER `AFTER_INSERT_PENGELUARAN` AFTER INSERT ON `pengeluaran_barang` FOR EACH ROW update barang set jumlah = jumlah-NEW.jumlah where id_barang = NEW.id_barang
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `AFTER_UPDATE_PENGELUARAN` AFTER UPDATE ON `pengeluaran_barang` FOR EACH ROW BEGIN
DECLARE jumlah_baru integer;
DECLARE jumlah_lama integer;
DECLARE jumlah_new integer;

set @jumlah_baru = NEW.jumlah;
set @jumlah_lama = OLD.jumlah;

IF @jumlah_lama > @jumlah_baru THEN
 SET @jumlah_new = @jumlah_baru - @jumlah_lama;
else
 SET @jumlah_new = @jumlah_baru - @jumlah_lama;
end if;

if NEW.id_barang <> OLD.id_barang THEN
update barang set jumlah = jumlah-NEW.jumlah where id_barang = NEW.id_barang;
update barang set jumlah = jumlah+OLD.jumlah where id_barang = OLD.id_barang;
ELSE
update barang set jumlah = jumlah-@jumlah_new where id_barang = NEW.id_barang;
END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `no_hp` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_barang_keluar`
--

CREATE TABLE `transaksi_barang_keluar` (
  `id` int(11) NOT NULL,
  `tgl_transaksi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_barang` int(11) NOT NULL,
  `total_harga` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_transaksi` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaksi_barang_keluar`
--

INSERT INTO `transaksi_barang_keluar` (`id`, `tgl_transaksi`, `total_barang`, `total_harga`, `user_id`, `status_transaksi`, `created_at`, `updated_at`) VALUES
(11, '2019-12-12 00:39:15', 2, 740000, 1, 0, '2019-12-12 00:40:01', '2019-12-11 17:40:01');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_barang_masuk`
--

CREATE TABLE `transaksi_barang_masuk` (
  `id` int(11) NOT NULL,
  `tgl_transaksi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total_barang` int(11) NOT NULL,
  `total_harga` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_transaksi` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaksi_barang_masuk`
--

INSERT INTO `transaksi_barang_masuk` (`id`, `tgl_transaksi`, `total_barang`, `total_harga`, `user_id`, `status_transaksi`, `created_at`, `updated_at`) VALUES
(1, '2019-12-12 00:37:54', 2, 1239000, 1, 0, '2019-12-12 00:38:41', '2019-12-11 17:38:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'rifki mubarok', 'rifki@admin.com', NULL, '$2y$10$f62fsHAppjGoHoqrV9IB5OET6NEiaPheqA8yRxnvv3nsUJH6M09U6', 'rqGbJrwRccBJF267oeXHMxgpFHgU05xXEYaVrXF0dJLAHWIaIcZNw2NEq7mW', '2019-12-09 01:52:31', '2019-12-09 01:52:31');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_barang_keluar`
--
ALTER TABLE `detail_barang_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `detail_barang_masuk`
--
ALTER TABLE `detail_barang_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `pemasukan_barang`
--
ALTER TABLE `pemasukan_barang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkBarang` (`id_barang`);

--
-- Indeks untuk tabel `pengeluaran_barang`
--
ALTER TABLE `pengeluaran_barang`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi_barang_keluar`
--
ALTER TABLE `transaksi_barang_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi_barang_masuk`
--
ALTER TABLE `transaksi_barang_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `detail_barang_keluar`
--
ALTER TABLE `detail_barang_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `detail_barang_masuk`
--
ALTER TABLE `detail_barang_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pemasukan_barang`
--
ALTER TABLE `pemasukan_barang`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran_barang`
--
ALTER TABLE `pengeluaran_barang`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `transaksi_barang_keluar`
--
ALTER TABLE `transaksi_barang_keluar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `transaksi_barang_masuk`
--
ALTER TABLE `transaksi_barang_masuk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
