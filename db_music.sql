-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 02, 2026 at 10:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_music`
--

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `album_id` int(11) NOT NULL,
  `album_name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `artist_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`album_id`, `album_name`, `image`, `language`, `artist_name`) VALUES
(2, 'Jal Pari', 'https://is1-ssl.mzstatic.com/image/thumb/Music112/v4/d3/96/56/d3965614-53b0-a90e-200f-c518eb9119cb/8901854079278.jpg/592x592bb.webp', 'Urdu', 'Atif Aslam'),
(3, 'Doorie', 'https://is1-ssl.mzstatic.com/image/thumb/Music211/v4/b3/ee/06/b3ee06b8-b90f-af94-543f-cf5df81a1142/8901854004799.jpg/592x592bb.webp', 'Urdu', 'Atif Aslam'),
(6, 'Huqa Pani', 'https://is1-ssl.mzstatic.com/image/thumb/Music126/v4/bb/e4/7c/bbe47cd0-db16-5236-1c36-d19c8bdb2635/884385803766.jpg/592x592bb.webp', 'Urdu', 'Ali Zafar'),
(7, 'Masty', 'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/d7/70/97/d7709728-0e47-1011-ee25-0cb71f02b95a/24UM1IM20008.rgb.jpg/592x592bb.webp', 'Urdu', 'Ali Zafar'),
(8, 'Asim Ali', 'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/3e/1d/15/3e1d15d4-7c6e-37b4-0a28-74b295c37903/5026854192758.jpg/592x592bb.webp', 'Urdu', 'Asim Azhar'),
(10, 'Bematlab', 'https://is1-ssl.mzstatic.com/image/thumb/Music211/v4/67/44/fe/6744feec-3508-1ed2-75b3-075fb5ae6b16/24UMGIM46071.rgb.jpg/592x592bb.webp', 'Urdu', 'Asim Azhar'),
(15, 'My Terrible Mind ', 'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/6a/94/d6/6a94d69e-3ba6-af74-fc2e-769a6b80b061/198846875156.jpg/592x592bb.webp', 'Urdu', 'Talha Anjum'),
(16, 'Open letter', 'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/e6/65/4c/e6654cb0-682e-caeb-bd48-10c030f1325e/198846672137.jpg/592x592bb.webp', 'Urdu', 'Talha Anjum'),
(17, 'Abdul Hannan Single', 'https://cdn-images.dzcdn.net/images/artist/2cbd1f3bf1188a966940d576a34df64d/500x500-000000-80-0-0.jpg', 'Urdu', 'Abdul Hannan'),
(22, 'Baran Baran', 'https://is1-ssl.mzstatic.com/image/thumb/Music2/v4/40/43/13/40431396-b63a-4419-a4e7-67feac131d26/cover.jpg/592x592bb.webp', 'Sindhi', 'Shazia Khushk'),
(23, 'balay  balay', 'https://is1-ssl.mzstatic.com/image/thumb/Music2/v4/1a/7f/f5/1a7ff5e0-149f-c518-234f-64df65f933ee/cover.jpg/592x592bb.webp', 'Sindhi', 'Shazia Khushk'),
(24, 'Bloodline', 'https://i.pinimg.com/474x/c9/4b/8f/c94b8f5320920db7c4782e877d65925c.jpg', 'Punjabi', 'Bilal Saeed'),
(25, 'Nach punjaban', 'https://is1-ssl.mzstatic.com/image/thumb/Music211/v4/a0/d7/8e/a0d78e7b-f15f-52e1-2a65-58900f4120c5/196006049430.png/592x592bb.webp', 'Punjabi', 'Abrar ul haq'),
(26, 'Safar  Bayan', 'https://is1-ssl.mzstatic.com/image/thumb/Music211/v4/23/12/5d/23125df9-bf28-43d9-5bc3-ec62cb696ff4/196872705256.jpg/592x592bb.webp', 'Punjabi', 'Hassan Raheem'),
(27, 'Arey Chand Arey Chan', 'https://is1-ssl.mzstatic.com/image/thumb/Music30/v4/bc/d1/f9/bcd1f922-4b80-3fef-b71e-5a8358a7444f/mzm.atgnyuwa.jpg/592x592bb.webp', 'Sindhi', 'Sarmad Sindhi'),
(28, 'Ashiq Jo Phone', 'https://is1-ssl.mzstatic.com/image/thumb/Music2/v4/aa/ff/1e/aaff1e47-6c14-e23c-bb2a-66e24788168a/cover.jpg/592x592bb.webp', 'Sindhi', 'Shaman ali mirali '),
(29, 'Star boy', 'https://is1-ssl.mzstatic.com/image/thumb/Music115/v4/e2/61/f8/e261f8c1-73db-9a7a-c89e-1068f19970e0/16UMGIM67863.rgb.jpg/592x592bb.webp', 'English', 'The Weeknd'),
(31, 'Earthling', 'https://is1-ssl.mzstatic.com/image/thumb/Video116/v4/d8/b4/83/d8b483af-a95c-c319-3a0e-8c85e9018632/Job880c6706-5d88-4d4b-b7da-05f6ce2406d4-128656294-PreviewImage_preview_image_nonvideo_sdr-Time1644508089166.png/592x592bb.webp', 'English', 'Eddie Veddar');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE `artists` (
  `artist_id` int(11) NOT NULL,
  `artist_name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `followers` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`artist_id`, `artist_name`, `image`, `followers`) VALUES
(3, 'Atif Aslam', 'https://i.pinimg.com/474x/cf/c2/1a/cfc21a4ebee1371e006ff27448337397.jpg', '48.2M'),
(4, 'Ali Zafar', 'https://i.pinimg.com/736x/c9/0b/8d/c90b8d218e8c877e62bfd7fc0acb0d07.jpg', '3.4M'),
(14, 'Asim Azhar', 'https://v5.ticketwala.pk/uploads/artists/asim-azhar-10.jpg', '8.2M'),
(15, 'Talha Anjum', 'https://i.pinimg.com/474x/d6/86/aa/d686aa5d3f6d4c0ef514d5692c53ff8e.jpg', '3.7M'),
(16, 'Abdul Hannan', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRWVBTUSFdmiqnpARUf6Z6skrYEHyyrBkftgAdErD62DWLZr_X9-3lqy9-O&s=10', '767k'),
(17, 'Shazia Khushk', 'https://i.tribune.com.pk/media/images/2071607-shaziakhushkexpress-1570126674/2071607-shaziakhushkexpress-1570126674-640x480.webp', '6K'),
(18, 'Bilal Saeed', 'https://i.pinimg.com/474x/ca/cc/13/cacc1316a66a8fd858c9c4122fd855c9.jpg', '23.1M'),
(19, 'Abrar ul haq', 'https://i.pinimg.com/736x/7e/53/b3/7e53b32c9a2e9551f2a8654300b5bfb0.jpg', '3.1M'),
(20, 'Hassan Raheem', 'https://is1-ssl.mzstatic.com/image/thumb/Features123/v4/ed/0d/53/ed0d5305-1bc0-eebd-030c-677773924df2/mzl.peekoghq.jpg/380x380cc.webp', '1.2M'),
(21, 'Sarmad Sindhi', 'https://i1.sndcdn.com/artworks-000061355467-pwtmt9-t500x500.jpg', '23k'),
(22, 'Shaman ali mirali ', 'https://i1.sndcdn.com/artworks-hTfmWSjTjxkDaQ4l-eKJuuQ-t1080x1080.jpg', '13k'),
(23, 'The Weeknd', 'https://i.pinimg.com/236x/21/1b/d8/211bd85e8d73e67a9d9556b88c4ea91b.jpg', '125M'),
(25, 'Eddie Veddar', 'https://is1-ssl.mzstatic.com/image/thumb/Features125/v4/50/bc/a9/50bca98c-6b46-0830-26b2-4ce9edfeb314/pr_source.png/380x380cc.webp', '4.9M');

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `genre_id` int(11) NOT NULL,
  `genre_name` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`genre_id`, `genre_name`, `image`) VALUES
(4, 'Pop', 'https://images.unsplash.com/photo-1709846486154-f9172678be6f?fm=jpg'),
(6, 'Rock', 'https://images.pexels.com/photos/12976807/pexels-photo-12976807.jpeg'),
(7, 'Folk', 'https://images.pexels.com/photos/1010518/pexels-photo-1010518.jpeg'),
(8, 'Sufi', 'https://images.pexels.com/photos/30282825/pexels-photo-30282825.jpeg'),
(15, 'Hip Hop', 'https://images.pexels.com/photos/1481312/pexels-photo-1481312.jpeg'),
(16, 'R&B', 'https://images.pexels.com/photos/705794/pexels-photo-705794.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `music`
--
-- Error reading structure for table db_music.music: #1030 - Got error 194 &quot;Tablespace is missing for a table&quot; from storage engine InnoDB
-- Error reading data for table db_music.music: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `db_music`.`music`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--
-- Error reading structure for table db_music.reviews: #1030 - Got error 194 &quot;Tablespace is missing for a table&quot; from storage engine InnoDB
-- Error reading data for table db_music.reviews: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `db_music`.`reviews`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `address`, `phone`, `email`, `password`, `image`, `role`, `status`) VALUES
(35, 'mohiuddin', 'Street flat NO 490', '03768899000', 'mohiuddin@gmail.com', '$2y$10$pL0osTGGCpJw/D/rRfOmle12mkx3Lq.VNSaVjQZ2U0wsAjovhCC/.', 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=600&amp;auto=format&amp;fit=crop&amp;q=60&amp;ixlib=rb-4.1.0&amp;ixid=M3wxMjA3fDB8MHxzZWFyY2h8NHx8cmFuZG9tJTIwcGVyc29ufGVufDB8fDB8fHww', 'user', 'approved'),
(36, 'anmta', 'Street flat NO 420', '03667883990', 'anumta@gmail.com', '$2y$10$ob/8sKcO53siwGp9.bf9YueyAWU2dWrDiyJY4ehlHQK7X2pMsGWdi', '1788157891_albert-dera-ILip77SbmOE-unsplash.jpg', 'user', 'pending'),
(37, 'bilal', 'Street flat NO/420', '03828515679', 'bilal@gmail.com', '$2y$10$Ypjd7SSATrz3oinwMwnb/.7nDx3SuD/kErEg5BKAfEoBCIfjDpVy6', '1788267251_Screenshot 2026-08-29 164444.png', 'user', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `video_id` int(11) NOT NULL,
  `video_name` varchar(150) NOT NULL,
  `album_id` int(11) NOT NULL,
  `year_id` int(11) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `video_file` varchar(255) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`video_id`, `video_name`, `album_id`, `year_id`, `genre_id`, `image`, `description`, `video_file`, `rating`) VALUES
(12, 'Jal pari', 2, 2, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music112/v4/d3/96/56/d3965614-53b0-a90e-200f-c518eb9119cb/8901854079278.jpg/592x592bb.webp', NULL, 'Adat se.mp4', NULL),
(13, 'Bheegi Yaadein', 2, 2, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music112/v4/d3/96/56/d3965614-53b0-a90e-200f-c518eb9119cb/8901854079278.jpg/592x592bb.webp', NULL, 'Woh Lamhe Woh Baatein.mp4', NULL),
(14, 'Kuch is tarah', 3, 1, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music211/v4/b3/ee/06/b3ee06b8-b90f-af94-543f-cf5df81a1142/8901854004799.jpg/592x592bb.webp', NULL, 'Kuch is Tarah -.mp4', NULL),
(15, 'Mahi Ve', 3, 1, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music211/v4/b3/ee/06/b3ee06b8-b90f-af94-543f-cf5df81a1142/8901854004799.jpg/592x592bb.webp', NULL, 'Mahi Ve.mp4', NULL),
(16, 'Channo', 6, 1, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music126/v4/bb/e4/7c/bbe47cd0-db16-5236-1c36-d19c8bdb2635/884385803766.jpg/592x592bb.webp', NULL, 'Channo.mp4', NULL),
(17, 'Rangeen', 6, 1, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music126/v4/bb/e4/7c/bbe47cd0-db16-5236-1c36-d19c8bdb2635/884385803766.jpg/592x592bb.webp', NULL, 'Rangeen.mp4', NULL),
(18, 'jannay na koi', 7, 1, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/d7/70/97/d7709728-0e47-1011-ee25-0cb71f02b95a/24UM1IM20008.rgb.jpg/900x900bb-60.jpg', NULL, 'Jaanay Na Koi.mp4', NULL),
(19, 'Sajania', 7, 1, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/d7/70/97/d7709728-0e47-1011-ee25-0cb71f02b95a/24UM1IM20008.rgb.jpg/900x900bb-60.jpg', NULL, 'Sun Re Sajania    HD Ali Zafar.mp4', NULL),
(20, 'Apna tu kehnda	', 10, 9, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music211/v4/67/44/fe/6744feec-3508-1ed2-75b3-075fb5ae6b16/24UMGIM46071.rgb.jpg/592x592bb.webp', NULL, 'Apna Tu Kehnda.mp4', NULL),
(21, 'Bematlab', 10, 9, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music211/v4/67/44/fe/6744feec-3508-1ed2-75b3-075fb5ae6b16/24UMGIM46071.rgb.jpg/592x592bb.webp', NULL, 'Bematlab.mp4', NULL),
(22, 'Jind mahi', 8, 9, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/3e/1d/15/3e1d15d4-7c6e-37b4-0a28-74b295c37903/5026854192758.jpg/592x592bb.webp', NULL, 'Jind Mahi.mp4', NULL),
(23, 'khabbay sajjay', 8, 9, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/3e/1d/15/3e1d15d4-7c6e-37b4-0a28-74b295c37903/5026854192758.jpg/592x592bb.webp', NULL, 'khabbay sajjay.mp4', NULL),
(24, 'Good fellas', 15, 9, 15, 'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/6a/94/d6/6a94d69e-3ba6-af74-fc2e-769a6b80b061/198846875156.jpg/592x592bb.webp', NULL, 'Good Fellas.mp4', NULL),
(25, 'Run it back', 15, 9, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/6a/94/d6/6a94d69e-3ba6-af74-fc2e-769a6b80b061/198846875156.jpg/592x592bb.webp', NULL, 'Run It Back.mp4', NULL),
(26, 'Melancholy', 16, 9, 15, 'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/e6/65/4c/e6654cb0-682e-caeb-bd48-10c030f1325e/198846672137.jpg/592x592bb.webp', NULL, 'Melancholy.mp4', NULL),
(27, 'Happy Hour', 16, 9, 15, 'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/e6/65/4c/e6654cb0-682e-caeb-bd48-10c030f1325e/198846672137.jpg/592x592bb.webp', NULL, 'Happy Hour.mp4', NULL),
(28, 'Khasara', 17, 9, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/5e/61/8d/5e618d5b-3d45-a42b-d968-e2f033df97e9/5026854838427.jpg/592x592bb.webp', NULL, 'khasara.mp4', NULL),
(29, 'Sila', 17, 5, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music221/v4/5e/61/8d/5e618d5b-3d45-a42b-d968-e2f033df97e9/5026854838427.jpg/592x592bb.webp', NULL, 'sila.mp4', NULL),
(30, 'dana pe dana', 22, 1, 7, 'https://is1-ssl.mzstatic.com/image/thumb/Music2/v4/40/43/13/40431396-b63a-4419-a4e7-67feac131d26/cover.jpg/592x592bb.webp', NULL, 'Dane Pe Dana.mp4', NULL),
(31, 'Me ranjha ', 23, 1, 7, 'https://is1-ssl.mzstatic.com/image/thumb/Music2/v4/1a/7f/f5/1a7ff5e0-149f-c518-234f-64df65f933ee/cover.jpg/592x592bb.webp', NULL, 'me ranjha.mp4', NULL),
(32, 'kash', 24, 5, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music211/v4/f2/9d/c1/f29dc13b-b91a-f6e2-4ec0-0f237e9ee200/cover.jpg/592x592bb.webp', NULL, 'kash.mp4', NULL),
(33, 'Nach punjaban', 25, 1, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music211/v4/a0/d7/8e/a0d78e7b-f15f-52e1-2a65-58900f4120c5/196006049430.png/592x592bb.webp', NULL, 'NACH PUNJABAN.mp4', NULL),
(34, 'Maand', 26, 9, 4, 'https://is1-ssl.mzstatic.com/image/thumb/Music211/v4/23/12/5d/23125df9-bf28-43d9-5bc3-ec62cb696ff4/196872705256.jpg/592x592bb.webp', NULL, 'mannad.mp4', 0),
(35, 'Kandi Na Singhre', 27, 3, 7, 'https://is1-ssl.mzstatic.com/image/thumb/Music30/v4/bc/d1/f9/bcd1f922-4b80-3fef-b71e-5a8358a7444f/mzm.atgnyuwa.jpg/592x592bb.webp', NULL, 'Kandi Na Singhre.mp4', 1),
(36, 'Bismillah kiyan', 28, 3, 8, 'https://is1-ssl.mzstatic.com/image/thumb/Music2/v4/aa/ff/1e/aaff1e47-6c14-e23c-bb2a-66e24788168a/cover.jpg/592x592bb.webp', NULL, 'BisMillah Kayan.mp4', 0),
(37, 'Party Monster', 29, 9, 16, 'https://is1-ssl.mzstatic.com/image/thumb/Music115/v4/e2/61/f8/e261f8c1-73db-9a7a-c89e-1068f19970e0/16UMGIM67863.rgb.jpg/592x592bb.webp', NULL, 'Party Monster.mp4', NULL),
(38, 'Invencible', 31, 9, 6, 'https://is1-ssl.mzstatic.com/image/thumb/Video116/v4/d8/b4/83/d8b483af-a95c-c319-3a0e-8c85e9018632/Job880c6706-5d88-4d4b-b7da-05f6ce2406d4-128656294-PreviewImage_preview_image_nonvideo_sdr-Time1644508089166.png/592x592bb.webp', NULL, 'Invincible.mp4', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `years`
--

CREATE TABLE `years` (
  `year_id` int(11) NOT NULL,
  `year_duration` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `years`
--

INSERT INTO `years` (`year_id`, `year_duration`, `image`) VALUES
(1, '2002-2005', ' https://images.pexels.com/photos/29233316/pexels-photo-29233316.jpeg?'),
(2, '2005-2010', 'https://images.pexels.com/photos/5473308/pexels-photo-5473308.jpeg?'),
(3, '2010-2015', ' https://images.pexels.com/photos/11398246/pexels-photo-11398246.jpeg?'),
(5, '2015-2020', ' https://images.pexels.com/photos/6587321/pexels-photo-6587321.jpeg?'),
(9, '2020-2025', 'https://images.pexels.com/photos/14828529/pexels-photo-14828529.jpeg?');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`album_id`);

--
-- Indexes for table `artists`
--
ALTER TABLE `artists`
  ADD PRIMARY KEY (`artist_id`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`video_id`),
  ADD KEY `fk_video_album` (`album_id`),
  ADD KEY `fk_video_year` (`year_id`),
  ADD KEY `fk_video_genre` (`genre_id`);

--
-- Indexes for table `years`
--
ALTER TABLE `years`
  ADD PRIMARY KEY (`year_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `artists`
--
ALTER TABLE `artists`
  MODIFY `artist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `video_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `years`
--
ALTER TABLE `years`
  MODIFY `year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `fk_video_album` FOREIGN KEY (`album_id`) REFERENCES `albums` (`album_id`),
  ADD CONSTRAINT `fk_video_genre` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`genre_id`),
  ADD CONSTRAINT `fk_video_year` FOREIGN KEY (`year_id`) REFERENCES `years` (`year_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
