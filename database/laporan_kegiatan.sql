-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Jul 2026 pada 13.58
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laporan_kegiatan`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `file_laporan`
--

CREATE TABLE `file_laporan` (
  `id` int(11) NOT NULL,
  `laporan_id` int(11) NOT NULL,
  `nama_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `file_laporan`
--

INSERT INTO `file_laporan` (`id`, `laporan_id`, `nama_file`) VALUES
(4, 10, '1779164472_0_images.jpg'),
(5, 12, '1780039428_0_download.png'),
(11, 14, '1780655254_0_flowchart-sistem-tamu.png'),
(12, 14, '1780655254_1_LAPORAN_PROGRES_HARIAN_2.docx'),
(13, 14, '1780655254_2_Buku_Company_Profile_PTMGS_F4.pdf'),
(15, 15, '1781668954_0_WhatsApp_Video_2026-06-09_at_19.49.15.mp4'),
(28, 19, '1782292428_0_Flowchart_Algoritma_Sistem_-_Kelola_Laporan.png'),
(29, 19, '1782292428_1_WhatsApp_Video_2026-06-09_at_19.49.15.mp4'),
(30, 19, '1782466848_0_dfd_level_0.drawio.png'),
(31, 19, '1782466848_1_diagram-export-12-5-2026-08.45.56.png'),
(32, 19, '1782467554_0_diagram-export-12-5-2026-08.54.17.png'),
(33, 20, '1782550125_0_download.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `tempat` varchar(100) NOT NULL,
  `jam` varchar(20) NOT NULL,
  `dokumen` varchar(255) DEFAULT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `deskripsi_kegiatan` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'menunggu',
  `catatan_verifikator` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id`, `tanggal`, `tempat`, `jam`, `dokumen`, `nama_kegiatan`, `deskripsi_kegiatan`, `status`, `catatan_verifikator`) VALUES
(10, '2026-08-17', 'halaman kantor kecamatan bungah', '07:00', '', 'upacara memperingati hari kemerdekaan', NULL, 'disetujui', NULL),
(12, '2026-05-29', 'aula kecamatan bungah', '08:00', '1780039428_0_download.png', 'pelatihan koprsi merah puti', NULL, 'disetujui', NULL),
(14, '2026-06-05', 'bungah', '17:03', '1780655254_0_flowchart-sistem-tamu.png', 'kegiatan 1', NULL, 'menunggu', NULL),
(15, '2026-06-17', 'kecamatan bungah aula', '11:02', '1781668954_0_WhatsApp_Video_2026-06-09_at_19.49.15.mp4', 'Evaluasi dan Fisasi Anggaran Publik', NULL, 'disetujui', NULL),
(19, '2026-06-24', 'aula kecamatan bungah', '16:05', '[{}]', 'kegiatan 24 juni 2026', NULL, 'disetujui', NULL),
(20, '2026-06-27', 'dukun', '15:48', '1782550125_0_download.png', 'kegiatan', NULL, 'disetujui', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_05_24_000001_create_laporan_tables', 1),
(6, '2026_05_29_000002_make_laporan_dokumen_nullable', 2),
(7, '2026_06_02_000003_rename_revisi_status_to_tidak_disetujui', 3),
(8, '2026_06_02_000004_drop_riwayat_aktivitas_table', 4),
(9, '2026_06_03_000005_add_catatan_verifikator_to_laporan_table', 5),
(10, '2026_06_03_000006_add_deskripsi_kegiatan_to_laporan_table', 6),
(11, '2026_06_05_000001_rename_tidak_disetujui_status_to_revisi', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '$2y$10$ZBF/H1WG74h7ucVDUPkMSOIIMH50wr9ohKLtybc6vp8PI7Qs86kq6', 'admin'),
(2, 'verifikator1', '$2y$10$3N.gXjXIoeB2kGPDWiiKZ.sUg5R3HMksr2nYEmGUpyrnAB6iNak6O', 'verifikator');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `file_laporan`
--
ALTER TABLE `file_laporan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `laporan_id` (`laporan_id`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
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
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
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
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `file_laporan`
--
ALTER TABLE `file_laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `file_laporan`
--
ALTER TABLE `file_laporan`
  ADD CONSTRAINT `file_laporan_ibfk_1` FOREIGN KEY (`laporan_id`) REFERENCES `laporan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
