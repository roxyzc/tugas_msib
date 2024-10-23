-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 12:56 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `newsportal`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `datePublished` datetime DEFAULT NULL,
  `body` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `link`, `img`, `datePublished`, `body`) VALUES
(1, 'Mw Ditemukan Kakak Kandungnya  Meninggal Di pondok Perkebunan Kelapa Sawit , Seutas Kabel', 'https://www.newsportal.id/2024/10/mw-ditemukan-kakak-kandungnya-meninggal.html', 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgwGXr7x0uh04kW_eHKhMGF9CUL0PhGwLjKbx0_NH_OFvvR7hyphenhyphenDDMi-lOEADti4xMNcwNV9LZHRY1h7y1FEku_FzHl0WhUq-xG4M9PwR3T0rgyGeipEyvQSBDWfSvpSdytGKZH0_l72Iull6Z7CDgOuin9MiwSlBXUlZ3xQT9n7zyVn7NGA840xW8az', '2024-10-22 20:18:00', 'NEWSPORTAL.ID almarhum MW 25 tahun warga dusun karya bakti rt/rw 02/04 kelurahan tebing tinggi kecamatan tebo tengah kabupaten tebo jambi, ditemukan 4 orang keluarga dekat nya yang sudah&nbsp; tergantung di salah satu pondok perkebunan kelapa sawit milik ayah nya sendiri,&nbsp;\nMenurut keterangan pihak keluarga Almarhum MW, Ali menyebutkan&nbsp; Karena hari sudh sore dan hampir magrib almarhum tidak kunjung pulang&nbsp;\nDan setelah kakak korban dan ponaan nya menuju ke perkebunan kelapa sawit tak jauh dari rumahnya almarhum MW sudah tergantung seutas kabel, Sekitar pukul 18 : 00&nbsp; pada Selasa 22/10/24 ,\nMembuat warga sekitar heboh, Dari melihat kematian almarhum MW ini sedikit kejanggalan, dan meminta pihak kepolisian Untuk Otopsi,&nbsp;\nKapolres I wayan artha ariawan melalui Kapolsek tebo tengah iptu Robin manulang SH&nbsp; membenarkan,, ia kita mendapatkan laporan adanya warga dusun karya bakti yang meninggal akibat gantung diri,&nbsp;\nUntuk saat ini kita belum bisa menyimpulkan terkait kematian anak ini, dan malam ini langsung di bawa ke rumah sakit umum sts tebo, ungkap kapolsek,( fr)'),
(2, 'Dukungan Pasangan Agus-Nazar Semakin Solid Menuju Kemenangan', 'https://www.newsportal.id/2024/10/dukungan-pasangan-agus-nazar-semakin.html', 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhUEq_e-MhzqMiHy5hduPwm4GlBHJCVYsiUP4G3pPqh6TDkwicmlBm-w1eUquIHFGYAUrHjAEtkpfyc6wtvt3qe87hbXRSKNvakmBy6j8UpQFeWkKM68uAh-4Eqpy7QvldM2tuxawmLd1vNHfVIsTUGaE68HkjKckdek4Di6gy8lRzCL98HWDx5FAHN1WA/w74-h7', '2024-10-22 10:23:00', 'NEWSPORTAL.ID - Dukungan Pasangan Calon Bupati dan Wakil Bupati Kabupaten Tebo nomor urut dua (2) Agus Rubianto dan Nazar Efendi di Wilayah Kecamatan Tebo Ulu semakin kuat,&nbsp; hal tersebut terlihat disaat pasangan muda dengan jargon Tebo Maju 2024 hadir secara langsung ditengah masyarakat pada Senin (21/10/2024).\n\nKehadiran pasangan muda ditengah masyarakat langsung disambut antusias masyarakat, seperti kunjungannya ke Desa Pulau Panjang dalam rangka pengukuhan Tim pemenangan Agus-Nazar.\n\nPada kesempatan tersebut, Afrizal selaku Kordes Pulau Panjang menyampaikan ucapan terimakasih kepada masyarakat dan juga pasangan calon yang hadir. Afrizal juga menyebut, masyarakat Desa Pulau Panjang siap untuk memenangkan pasangan Agus-Nazar, terutama Tim yang sudah dibentuk yang siap bekerja untuk meraup suara di Desa Pulau Panjang.\n\n\"kami siap memperjuangkan mencari dukungan untuk kemenangan pasangan Agus-Nazar\",tegasnya dihadapan Tim yang sudah di kukuhkan.\n\nSementara itu, pasangan calon Bupati dan Wakil Bupati yang hadir pada pertemuan tersebut menyampaikan program unggulan, diantaranya :\n\n1.	Beasiswa untuk siswa kurang mampu dan berprestasi, serta tenaga pendidik ;\n2.	Bantuan operasional ke pondok pesantren dan madrasah ;\n3.	Kesehatan gratis (UHC 100%) dan layanan kesehatan untuk semua (Health for All) ;\n4.	Dokter masuk dusun ;\n5.	Insentif guru ngaji/TPQ dan tenaga kesehatan daerah terpencil ;\n6.	Infrastruktur jalan, irigasi, pertanian, sarana olahraga dan sekretariat lembaga kecamatan ;\n7.	Membuka Kawasan siap bangun, RTH dan penataan ibukota kecamatan ;\n8.	Menyediakan Balai Latihan Kerja /BLK terpadu ;\n9.	Ekonomi kerakyatan berbasis agribisnis dan ramah lingkungan ;\n10.	Layanan perijinan dan kependudukan berbasis web dan mobile dengan moto\nsijempol (sistim perijinan jemput bola) ;\n11.	Peningkatan kesejahteraan ASN dan perangkat desa,(fr)'),
(3, 'Ketua Dekranasda Hj Tanty Harvianty Launching Tiga Motif Batik Di Kabupaten Tebo', 'https://www.newsportal.id/2024/10/ketua-dekranasda-hj-tanty-harvianty.html', 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEiyNC-nt3bbYknf1-YNl_y1CF3tA6LZd1Ny9Kwi39xO4KNvAI5Xx7aKOWbYAnAKa1sMXtmt9CFyBTD1j9x0ms7p-Mt1oXxghl-A6sMnABtXxXNRkAfSPx7Pmxh_PN_-u6b4e13bYsj28jd1r2BZ1A0YX09W0KkEXnnLUSHArly0Pz4S2N4gbH7tUFVqW5Y/w74-h7', '2024-10-16 23:11:00', 'mendampingi Ketua Umum Dekranasda kabupaten tebo Dalam kegiatan Launching motif batik&nbsp;\nDalam sambutannya hj tanty harvianty Lounching Batik tebo ini dalam rangka memperingati hari ulang tahun Kabupaten Tebo ke-25\ndikatakannya \"hj tanty harvianty bersama batik ini&nbsp; merupakan kekayaan Indonesia oleh UNESCO telah ditetapkan sebagai warisan kemanusiaan untuk budaya lisan dan Nonbendawi(Masterfieces of Humanity) sejak 2 oktober 2009,\ndimana hal tersebut menjadi cikal bakal lahirnya Hari Batik Nasional berbicara segera serta membatik kerajinan Batik ini di Indonesia telah dikenal sejak zaman kerajaan yang pada awalnya batik dikerjakan hanya terbatas dalam lingkup Keraton saja, dan hasilnya untuk pakaian raja dan keluarga serta para pengikutnya,\noleh karena itu banyak dari penjahit raja yang tinggal di luar Keraton maka kesenian batik ini dibawa oleh mereka keluar Keraton sehingga pada umumnya berkembang di Masyarakat&nbsp;\nSebagai sebuah kekayaan yang telah diakui dunia Sudah selayaknya Untuk Kita berbangga diri dengan kekayaan yang kita miliki tersebut dengan cara kita mencintai,\ndan hari ini akan di launching 3 motif batik yakni batik teluk kuali&nbsp; batik danau sigombak dan batik pagar puding lamo Kabupaten Tebo\nmari kita bersama-sama untuk peduli dan menjadi bagian dari parade berpartisipasi mensukseskan kegiatan ini serta melalui kegiatan ini dapat meningkatkan kerjasama ekonomi dan batik di Kabupaten Tebo\nuntuk lebih memperkaya motif-motif batik Tebo meningkatkan daya saing batik tenun sehingga kedepannya motif tembok dapat semakin dikenal secara luas serta memunculkan dalam diri kita rasa cinta kepada produk daerah yang kita miliki sebagai bagian dari produk dalam negeri tutup Hj tanty harvianty,(fr)'),
(4, 'Masih Solid dan Tidak Tergoyahkan, Masyarakat Giri Purno Siap Menangkan Agus-Nazar', 'https://www.newsportal.id/2024/10/masih-solid-dan-tidak-tergoyahkan.html', 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhyiZ5rpDF5gyrNyeMzl_0HWIteuIJdeskO3RXEH4P-A8Cino1uRuXkS-8cGEhBfvZuXUX97yPxpfwZ26HuIpwbzfeGNy3Z64M9gpGHDBkRCUMx0qFmd2tFkY65ee6eIBoJrp-JJn0X0UzVshTKBRDgqj2wOveKIef8T0u_ubjlgCPCUhq09CvXgXdlA-0/w74-h7', '2024-10-16 19:17:00', '&nbsp;\nNEWSPORTAL.ID - Silaturahmi Bersama Warga Giri Purno, Agus-Nazar Ucapakan Terimakasih Atas Dukungannya.\nBasis Garindra Jebol, Masyarakat Desa Giri Purno Sepakat Menangkan Agus-Nazar&nbsp;\nSilaturahmi lanjutan di wilayah Kabupaten Tebo , Pasangan Calon Bupati dan Wakil Bupati Kabupaten Tebo Agus Rubianto dan Nazar Efendi disambut dengan baik oleh masyarakat. Seperti di desa Giri Purno, Kecamatan Rimbo Ilir, Kabupaten Tebo,&nbsp; Pada Rabu (16/10/2024).\nBerlangsung dengan meriah, pertemuan yang dipusatkan dilapangan Futsal Desa Giri Purno langsung dihadiri ratusan masyarakat Desa Giri.\nKoordinator Desa Giri Purno, Nurgiyanto menyampaikan, ucapan terimakasih kepada pasangan calon Bupati dan Wakil Bupati Kabupaten Tebo Agus Rubianto dan Nazar Efendi yang hadir secara langsung pada silaturahmi bersama masyarakat Desa Giri Purno.\nNurgiyanto, juga menjelaskan, dengan dihadiri para perwakilan Tokoh agama, tokoh masyarakat, maupun perwakilan tiap Dusun di Desa Giri Purno sepakat untuk menangkan pasangan muda dengan slogan Tebo Maju.\n\"Dengan tim yang masih solid, kami siap memenangkan pasangan calon Bupati dan Wakil Bupati Agus-Nazar jadi pemimpin Tebo\", tegasnya dengan lantang.\nSelain itu, pada kesempatan tersebut, dirinya juga menyampaikan, target kemenangan di Desa Giri Purno untuk pasangan Calon Agus-Nazar mencapai 80 persen.\n\"Untuk target kemenangan bisa mencapai 80 persen untuk pasangan Agus-Nazar\", ucapanya\nSementara itu, pasangan calon Bupati dan Wakil Bupati Kabupaten Tebo Agus Rubianto dan Nazar Efendi, menyampaikan ucapan terimakasih kepada masyarakat yang sudah mendukung untuk menuju kemenangan pada pilkada 2024. Terutama untuk Desa Giri Purno dan umumnya masyarakat Kabupaten Tebo.\n\"Kita tetap solid dan kompak, dan jangan terpengaruh dengan isu-isu diluar, dan tetap fokus meraup suara untuk kemenangan, kami juga menyampaikan kepada masyarakat agar tetap menjaga politik santun, agar pilkada 2024 berlangsung aman, damai, dan sukses\", ungkap pasangan Calon Bupati dan Wakil Bupati Kabupaten Tebo nomor urut dua,( fr)'),
(5, ' Semua Diawali Dari Niat, Kemenangan Agus-Nazar Adalah Milik Kita Semua', 'https://www.newsportal.id/2024/10/semua-diawali-dari-niat-kemenangan-agus.html', 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEjUAVMESMTbFWzDVkh_FdI9ILNXbo7-sCzx1PANMOH_awNMdE0TjTvjhCUwAZ_3mmLwGWpQGEPP7BsoDI_s6akVsEe9sSDFd7fNbsogKzNHUGuNf-jzIY6PQdAXjU5wb0vEptqSsNxJZCq_oNq6I3-pBlh-5Bg7uIjwFwux8JAoP-cL1UbVzO_BZ51SNxs/w74-h7', '2024-10-20 19:50:00', 'Dihadiri, ratusan kader PKS, Pasangan Muda Koalisi Tebo Maju, Agus Rubiyanto dan Nazar Efendi, paparkan visi dan misi membangun Tebo Cerdas, Sehat dan Sejahtera.&nbsp;\nDisampaikan oleh Ketua DPD PKS Kabupaten Tebo, Yuhanas pada orasi politiknya, butuh waktu 1 tahun bagi PKS, memilih calon yang diusung pada masa seleksi pimpinan tingkat daerah.\nDiakuinya, ada&nbsp; Interaksi dari beberapa calon, dari situ tersimpul karakter dari calon. Dan mengerucut Agus-Nazar yang memiliki komitmen dengan ucapan dan perbuatan.&nbsp;\n\"Semua diawali dari niat, kemenangan Agus-Nazar adalah kita semua masyarakat Kabupaten Tebo,\" kaya Yuhanas dihadapan ratusan kader PKS Kabupaten Tebo, Sabtu (19/10/2024).&nbsp;\nMasih disampaikan Yuhanas pada orasi politiknya, Apa yang akan dilakukan Agus-Nazar, pada Visi dan Misi Tebo Maju 2024-2029, sama dengan cita-cita dan keinginan PKS.\n\"Masyarakat sejahtera, pendidikan yang merata, ini senafas dengan apa yang dicita-citakan PKS. Bagi kita kader PKS aktivitas politik ini bisa menjadi abadi, jika diniatkan dengan ibadah,\" tegas Yuhanas.&nbsp;\nDitambahkan oleh, Ust Amir Solihin, Bendahara DPW PKS, seluruh kader PKS adalah prajurit yang berkomitmen. Dalam hal ini sesuai dengan arahan dan petunjuk pimpinan PKS.\nTentunya, kader yang telah dikukuhkan berkerja keras memenangkan pasangan yang diusung PKS. Melakukan sosialisasi dari pintu ke pintu dengan santun dan riang gembira.\n\"Kader adalah prajurit, yang menjalankan keimanan dan idiologi PKS,\" ungkapnya.\nSementara itu, Pasangan muda Agus-Nazar, mengucapkan trimakasih terhadap komitmen dan semangat kader PKS. Tentunya setelah dilantik, untuk mewujudkan Tebo Maju, diperlukan sumbangan ide kreatif dari kader PKS.\n\"Mari kita kawal kemenangan ini, hingga hari pemilihan pada&nbsp; 27 November mendatang,\" ungkap Agus Rubiyanto.(fr)');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
