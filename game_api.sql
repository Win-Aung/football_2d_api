-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2026 at 07:43 PM
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
-- Database: `game_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `sender_type` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`id`, `user_id`, `message`, `sender_type`, `created_at`, `updated_at`) VALUES
(88, 11, 'hello', 'user', '2026-09-18 07:16:42', '2026-09-18 07:16:42'),
(89, 11, 'hello', 'user', '2026-09-18 07:16:54', '2026-09-18 07:16:54'),
(90, 11, 'SSSS', 'admin', '2026-09-18 07:17:47', '2026-09-18 07:17:47'),
(91, 11, 'SSSS', 'admin', '2026-09-18 07:17:54', '2026-09-18 07:17:54'),
(92, 11, 'ကူညီပါ', 'user', '2026-09-18 07:45:03', '2026-09-18 07:45:03'),
(93, 11, 'ok', 'admin', '2026-09-18 07:46:32', '2026-09-18 07:46:32'),
(94, 9, 'ကူညီပါ', 'user', '2026-09-18 08:12:19', '2026-09-18 08:12:19'),
(95, 9, '123', 'user', '2026-09-18 10:08:01', '2026-09-18 10:08:01'),
(96, 9, '34', 'admin', '2026-09-18 10:08:58', '2026-09-18 10:08:58'),
(97, 9, '7777', 'user', '2026-09-18 10:28:46', '2026-09-18 10:28:46'),
(98, 9, '7777', 'user', '2026-09-18 10:29:45', '2026-09-18 10:29:45'),
(99, 9, 'aefaefaefန်ေန်ေန်ေန်ေ', 'user', '2026-09-18 10:40:13', '2026-09-18 10:40:13'),
(100, 9, 'fsgfgsdfasdf', 'user', '2026-09-18 10:50:25', '2026-09-18 10:50:25');

-- --------------------------------------------------------

--
-- Table structure for table `football_matches`
--

CREATE TABLE `football_matches` (
  `id` int(11) NOT NULL,
  `league_name` varchar(255) DEFAULT NULL,
  `home_team` varchar(100) NOT NULL,
  `away_team` varchar(100) NOT NULL,
  `home_odds` varchar(50) DEFAULT NULL,
  `away_odds` varchar(50) DEFAULT NULL,
  `goal_total` varchar(50) DEFAULT NULL,
  `body_odds` varchar(50) DEFAULT NULL,
  `body_away_odds` varchar(255) DEFAULT NULL,
  `body_goal_total` varchar(255) DEFAULT NULL,
  `video_link` text DEFAULT NULL,
  `close_time` datetime NOT NULL,
  `body_status` int(11) DEFAULT 1,
  `maung_status` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `football_matches`
--

INSERT INTO `football_matches` (`id`, `league_name`, `home_team`, `away_team`, `home_odds`, `away_odds`, `goal_total`, `body_odds`, `body_away_odds`, `body_goal_total`, `video_link`, `close_time`, `body_status`, `maung_status`, `created_at`, `updated_at`) VALUES
(36, 'Serie A', 'Roma', 'Inter', NULL, 'L+50', '2+50', NULL, '1-50', '1+50', 'blob:https://socolive-football.pro/05a53ce0-7bca-4403-9721-d364c0eb12c7', '2026-09-30 15:00:00', 1, 1, '2026-09-09 02:01:54', '2026-09-17 00:14:23'),
(37, 'Premier League', 'Arsenal', 'Chelsea', '1+50', NULL, '3-50', '1-50', NULL, '4+30', 'MM', '2026-09-30 15:00:00', 1, 1, '2026-09-09 02:02:38', '2026-09-17 00:23:16'),
(38, 'LaLiga', 'Barcelona', 'Real Madrid', '2-50', NULL, '3-50', NULL, '1-50', '4+50', NULL, '2026-09-30 15:00:00', 1, 1, '2026-09-09 02:13:38', '2026-09-09 02:13:38'),
(39, 'LaLiga', 'Atlético Madrid', 'Alavés', '1+30', NULL, '2-50', NULL, 'L-10', '3+50', 'https://mm-football.com/player.html?src=aHR0cHM6Ly9wdWxsLm5pdXIubGl2ZS9saXZlL3N0cmVhbS00NTk0MDFfbGhkLm0zdTg/dHhTZWNyZXQ9YzQ0ZGM1YTBiYzk1MjU0YTdlMzZiYTRmM2YwNTc5ODYmdHhUaW1lPTZhYWI5ZThjI3NraXA=', '2026-09-30 15:00:00', 1, 1, '2026-09-09 03:23:06', '2026-09-17 02:09:34'),
(40, 'Champions League', 'အာဆင်နယ်', 'AEK', '1+50', NULL, '3+50', '2-30', NULL, '4+50', NULL, '2026-09-18 23:12:00', 0, 0, '2026-09-17 10:12:21', '2026-09-18 16:42:07');

-- --------------------------------------------------------

--
-- Table structure for table `gamefootball_bits`
--

CREATE TABLE `gamefootball_bits` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_doc_id` varchar(255) NOT NULL,
  `bet_type` varchar(50) NOT NULL,
  `match_id` varchar(50) NOT NULL,
  `home_team` varchar(100) NOT NULL,
  `goal_total` varchar(50) DEFAULT NULL,
  `away_team` varchar(100) NOT NULL,
  `selected_option` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `win_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `lost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gamefootball_bits`
--

INSERT INTO `gamefootball_bits` (`id`, `user_doc_id`, `bet_type`, `match_id`, `home_team`, `goal_total`, `away_team`, `selected_option`, `amount`, `win_amount`, `lost`, `status`, `created_at`, `updated_at`) VALUES
(6, '6', 'body', 'MULTI_BODY', 'Roma , Arsenal , Barcelona', '4+50 , 4+50 , 4+50', 'Inter , Chelsea , Real Madrid', '[{\"match_id\":36,\"home_team\":\"Roma\",\"away_team\":\"Inter\",\"home_odds\":\"\",\"away_odds\":\"1-50\",\"goal_total\":\"4+50\",\"selected_option\":\"Roma\",\"amount\":1000,\"win_amount\":1950,\"status\":\"win\"},{\"match_id\":37,\"home_team\":\"Arsenal\",\"away_team\":\"Chelsea\",\"home_odds\":\"\",\"away_odds\":\"1-50\",\"goal_total\":\"4+50\",\"selected_option\":\"ဂိုးအောက်\",\"amount\":2000,\"win_amount\":1950,\"status\":\"win\"},{\"match_id\":38,\"home_team\":\"Barcelona\",\"away_team\":\"Real Madrid\",\"home_odds\":\"\",\"away_odds\":\"1-50\",\"goal_total\":\"4+50\",\"selected_option\":\"ဂိုးပေါ်\",\"amount\":3000,\"win_amount\":4500,\"status\":\"win\"}]', 6000.00, 8400.00, 0.00, 'completed', '2026-09-09 08:50:10', '2026-09-09 09:03:39'),
(7, '6', 'body', 'MULTI_BODY', 'Roma , Arsenal , Barcelona', '4+50 , 4+30 , 4+50', 'Inter , Chelsea , Real Madrid', '[{\"match_id\":36,\"home_team\":\"Roma\",\"away_team\":\"Inter\",\"home_odds\":\"\",\"away_odds\":\"1-50\",\"goal_total\":\"4+50\",\"selected_option\":\"Roma\",\"amount\":2000,\"status\":\"lose\"},{\"match_id\":37,\"home_team\":\"Arsenal\",\"away_team\":\"Chelsea\",\"home_odds\":\"1-50\",\"away_odds\":\"\",\"goal_total\":\"4+30\",\"selected_option\":\"Arsenal\",\"amount\":1000,\"status\":\"lose\"},{\"match_id\":38,\"home_team\":\"Barcelona\",\"away_team\":\"Real Madrid\",\"home_odds\":\"\",\"away_odds\":\"1-50\",\"goal_total\":\"4+50\",\"selected_option\":\"Barcelona\",\"amount\":3000,\"win_amount\":5900,\"status\":\"win\"}]', 6000.00, 5900.00, 3000.00, 'completed', '2026-09-09 09:11:54', '2026-09-09 09:14:33'),
(8, '6', 'maung', 'MULTI', 'မောင်းစလပ် (4 ပွဲပေါင်း)', '', '', '[{\"match_id\":36,\"home_team\":\"Roma\",\"away_team\":\"Inter\",\"home_odds\":\"\",\"away_odds\":\"L+50\",\"goal_total\":\"2+50\",\"selected_option\":\"Roma\"},{\"match_id\":37,\"home_team\":\"Arsenal\",\"away_team\":\"Chelsea\",\"home_odds\":\"1+50\",\"away_odds\":\"\",\"goal_total\":\"3-50\",\"selected_option\":\"Chelsea\"},{\"match_id\":38,\"home_team\":\"Barcelona\",\"away_team\":\"Real Madrid\",\"home_odds\":\"2-50\",\"away_odds\":\"1-50\",\"goal_total\":\"3-50\",\"selected_option\":\"Barcelona\"},{\"match_id\":39,\"home_team\":\"Atlético Madrid\",\"away_team\":\"Alavés\",\"home_odds\":\"1+30\",\"away_odds\":\"L-10\",\"goal_total\":\"2-50\",\"selected_option\":\"Atlético Madrid\"}]', 2000.00, 45000.00, 0.00, 'win', '2026-09-09 10:04:33', '2026-09-09 03:35:51'),
(9, '6', 'maung', 'MULTI', 'မောင်းစလပ် (4 ပွဲပေါင်း)', '', '', '[{\"match_id\":36,\"home_team\":\"Roma\",\"away_team\":\"Inter\",\"home_odds\":\"\",\"away_odds\":\"L+50\",\"goal_total\":\"2+50\",\"selected_option\":\"Roma\"},{\"match_id\":37,\"home_team\":\"Arsenal\",\"away_team\":\"Chelsea\",\"home_odds\":\"1+50\",\"away_odds\":\"\",\"goal_total\":\"3-50\",\"selected_option\":\"Chelsea\"},{\"match_id\":38,\"home_team\":\"Barcelona\",\"away_team\":\"Real Madrid\",\"home_odds\":\"2-50\",\"away_odds\":\"1-50\",\"goal_total\":\"3-50\",\"selected_option\":\"Barcelona\"},{\"match_id\":39,\"home_team\":\"Atlético Madrid\",\"away_team\":\"Alavés\",\"home_odds\":\"1+30\",\"away_odds\":\"L-10\",\"goal_total\":\"2-50\",\"selected_option\":\"Atlético Madrid\"}]', 3000.00, 0.00, 0.00, 'pending', '2026-09-09 10:06:42', '2026-09-09 03:36:42'),
(10, '8', 'body', 'MULTI_BODY', 'Roma', '1+50', 'Inter', '[{\"match_id\":\"36\",\"home_team\":\"Roma\",\"away_team\":\"Inter\",\"home_odds\":\"\",\"away_odds\":\"1-50\",\"goal_total\":\"1+50\",\"selected_option\":\"ဂိုးပေါ်\",\"amount\":4000,\"win_amount\":7900,\"status\":\"win\"}]', 4000.00, 7900.00, 0.00, 'completed', '2026-09-15 10:56:28', '2026-09-15 11:31:31'),
(11, '8', 'maung', 'MULTI', 'မောင်းစလပ် (3 ပွဲပေါင်း)', '', '', '[{\"match_id\":\"36\",\"home_team\":\"Roma\",\"away_team\":\"Inter\",\"home_odds\":\"\",\"away_odds\":\"L+50\",\"goal_total\":\"2+50\",\"selected_option\":\"Roma\"},{\"match_id\":\"37\",\"home_team\":\"Arsenal\",\"away_team\":\"Chelsea\",\"home_odds\":\"1+50\",\"away_odds\":\"\",\"goal_total\":\"3-50\",\"selected_option\":\"Chelsea\"},{\"match_id\":\"38\",\"home_team\":\"Barcelona\",\"away_team\":\"Real Madrid\",\"home_odds\":\"2-50\",\"away_odds\":\"1-50\",\"goal_total\":\"3-50\",\"selected_option\":\"Barcelona\"}]', 6000.00, 30000.00, 0.00, 'win', '2026-09-15 11:10:03', '2026-09-17 10:33:26'),
(12, '8', 'maung', 'MULTI', 'မောင်းစလပ် (3 ပွဲပေါင်း)', '', '', '[{\"match_id\":\"36\",\"home_team\":\"Roma\",\"away_team\":\"Inter\",\"home_odds\":\"\",\"away_odds\":\"L+50\",\"goal_total\":\"2+50\",\"selected_option\":\"Roma\"},{\"match_id\":\"37\",\"home_team\":\"Arsenal\",\"away_team\":\"Chelsea\",\"home_odds\":\"1+50\",\"away_odds\":\"\",\"goal_total\":\"3-50\",\"selected_option\":\"Chelsea\"},{\"match_id\":\"38\",\"home_team\":\"Barcelona\",\"away_team\":\"Real Madrid\",\"home_odds\":\"2-50\",\"away_odds\":\"1-50\",\"goal_total\":\"3-50\",\"selected_option\":\"Barcelona\"}]', 1000.00, 5000.00, 0.00, 'win', '2026-09-16 05:41:34', '2026-09-17 10:34:12'),
(13, '8', 'body', 'MULTI_BODY', 'Roma , Arsenal , Barcelona', '1+50 , 4+30 , 4+50', 'Inter , Chelsea , Real Madrid', '[{\"match_id\":\"36\",\"home_team\":\"Roma\",\"away_team\":\"Inter\",\"home_odds\":\"\",\"away_odds\":\"1-50\",\"goal_total\":\"1+50\",\"selected_option\":\"Roma\",\"amount\":1000,\"win_amount\":19000,\"status\":\"win\"},{\"match_id\":\"37\",\"home_team\":\"Arsenal\",\"away_team\":\"Chelsea\",\"home_odds\":\"1-50\",\"away_odds\":\"\",\"goal_total\":\"4+30\",\"selected_option\":\"Arsenal\",\"amount\":2000},{\"match_id\":\"38\",\"home_team\":\"Barcelona\",\"away_team\":\"Real Madrid\",\"home_odds\":\"2-50\",\"away_odds\":\"1-50\",\"goal_total\":\"4+50\",\"selected_option\":\"Barcelona\",\"amount\":2999}]', 5999.00, 19000.00, 0.00, 'pending', '2026-09-16 05:41:58', '2026-09-17 10:32:14'),
(14, '8', 'body', 'MULTI_BODY', 'Roma , Arsenal , Barcelona , Atlético Madrid', '1+50 , 4+30 , 4+50 , 3+50', 'Inter , Chelsea , Real Madrid , Alavés', '[{\"match_id\":\"36\",\"home_team\":\"Roma\",\"away_team\":\"Inter\",\"home_odds\":\"\",\"away_odds\":\"1-50\",\"goal_total\":\"1+50\",\"selected_option\":\"Roma\",\"amount\":2000,\"win_amount\":3900,\"status\":\"win\"},{\"match_id\":\"37\",\"home_team\":\"Arsenal\",\"away_team\":\"Chelsea\",\"home_odds\":\"1-50\",\"away_odds\":\"\",\"goal_total\":\"4+30\",\"selected_option\":\"Arsenal\",\"amount\":1996,\"win_amount\":4500,\"status\":\"win\"},{\"match_id\":\"38\",\"home_team\":\"Barcelona\",\"away_team\":\"Real Madrid\",\"home_odds\":\"2-50\",\"away_odds\":\"1-50\",\"goal_total\":\"4+50\",\"selected_option\":\"ဂိုးပေါ်\",\"amount\":2000,\"win_amount\":5000,\"status\":\"win\"},{\"match_id\":\"39\",\"home_team\":\"Atlético Madrid\",\"away_team\":\"Alavés\",\"home_odds\":\"1+30\",\"away_odds\":\"L-10\",\"goal_total\":\"3+50\",\"selected_option\":\"ဂိုးအောက်\",\"amount\":1999,\"status\":\"lose\"}]', 7995.00, 13400.00, 1999.00, 'completed', '2026-09-17 08:51:12', '2026-09-17 17:01:07'),
(16, '8', 'maung', 'MULTI', 'မောင်းစလပ် (5 ပွဲပေါင်း)', '', '', '[{\"match_id\":\"36\",\"home_team\":\"Roma\",\"away_team\":\"Inter\",\"home_odds\":\"\",\"away_odds\":\"L+50\",\"goal_total\":\"2+50\",\"selected_option\":\"Roma\"},{\"match_id\":\"37\",\"home_team\":\"Arsenal\",\"away_team\":\"Chelsea\",\"home_odds\":\"1+50\",\"away_odds\":\"\",\"goal_total\":\"3-50\",\"selected_option\":\"Chelsea\"},{\"match_id\":\"38\",\"home_team\":\"Barcelona\",\"away_team\":\"Real Madrid\",\"home_odds\":\"2-50\",\"away_odds\":\"1-50\",\"goal_total\":\"3-50\",\"selected_option\":\"ဂိုးပေါ်\"},{\"match_id\":\"39\",\"home_team\":\"Atlético Madrid\",\"away_team\":\"Alavés\",\"home_odds\":\"1+30\",\"away_odds\":\"L-10\",\"goal_total\":\"2-50\",\"selected_option\":\"ဂိုးအောက်\"},{\"match_id\":\"40\",\"home_team\":\"အာဆင်နယ်\",\"away_team\":\"AEK\",\"home_odds\":\"1+50\",\"away_odds\":\"\",\"goal_total\":\"3+50\",\"selected_option\":\"အာဆင်နယ်\"}]', 5000.00, 0.00, 5000.00, 'lost', '2026-09-17 16:43:11', '2026-09-17 10:15:44');

-- --------------------------------------------------------

--
-- Table structure for table `game_bets`
--

CREATE TABLE `game_bets` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `bets_json` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `animal` varchar(50) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `winAmount` decimal(15,2) DEFAULT 0.00,
  `luckyAnimal` varchar(50) DEFAULT '',
  `time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `game_bets`
--

INSERT INTO `game_bets` (`id`, `userId`, `userName`, `bets_json`, `total_amount`, `animal`, `amount`, `status`, `winAmount`, `luckyAnimal`, `time`) VALUES
(51, 8, 'SM', '[{\"animal_index\":0,\"animal_name\":\"မြင်း\",\"amount\":200,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":1,\"animal_name\":\"တော\",\"amount\":300,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":2,\"animal_name\":\"ရွှေနဂါး\",\"amount\":100,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":4,\"animal_name\":\"ဆတ်\",\"amount\":300,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":5,\"animal_name\":\"မြွေ\",\"amount\":300,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"}]', 1200.00, '', 0.00, 'Lost', 0.00, 'ခွေး', '2026-09-15 09:03:15'),
(52, 8, 'SM', '[{\"animal_index\":0,\"animal_name\":\"မြင်း\",\"amount\":200,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":1,\"animal_name\":\"တော\",\"amount\":300,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":2,\"animal_name\":\"ရွှေနဂါး\",\"amount\":300,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"}]', 800.00, '', 0.00, 'Lost', 0.00, 'ခွေး', '2026-09-15 11:34:14'),
(53, 8, 'SM', '[{\"animal_index\":0,\"animal_name\":\"မြင်း\",\"amount\":300,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":3,\"animal_name\":\"လိပ်ပြာ\",\"amount\":300,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":7,\"animal_name\":\"ပင့်ကူ\",\"amount\":300,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"}]', 900.00, '', 0.00, 'Lost', 0.00, 'ခွေး', '2026-09-15 23:18:19'),
(54, 8, 'SM', '[{\"animal_index\":6,\"animal_name\":\"မျောက်\",\"amount\":100,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":8,\"animal_name\":\"ဗျိုင်း\",\"amount\":100,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":9,\"animal_name\":\"သီလ\",\"amount\":100,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":13,\"animal_name\":\"ရွှေငါး\",\"amount\":100,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":16,\"animal_name\":\"ကျီး\",\"amount\":100,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":19,\"animal_name\":\"ဝက်\",\"amount\":100,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":21,\"animal_name\":\"ယုန်\",\"amount\":100,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"}]', 700.00, '', 0.00, 'Lost', 0.00, 'ခွေး', '2026-09-15 23:29:14'),
(55, 8, 'SM', '[{\"animal_index\":0,\"animal_name\":\"မြင်း\",\"amount\":300,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"}]', 300.00, '', 0.00, 'Lost', 0.00, 'ခွေး', '2026-09-16 00:10:28'),
(56, 8, 'SM', '[{\"animal_index\":0,\"animal_name\":\"မြင်း\",\"amount\":100,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":1,\"animal_name\":\"တော\",\"amount\":100,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":2,\"animal_name\":\"ရွှေနဂါး\",\"amount\":100,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"},{\"animal_index\":3,\"animal_name\":\"လိပ်ပြာ\",\"amount\":100,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ခွေး\"}]', 400.00, '', 0.00, 'Lost', 0.00, 'ခွေး', '2026-09-16 00:16:54'),
(57, 8, 'SM', '[{\"animal_index\":0,\"animal_name\":\"မြင်း\",\"amount\":501,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ရွှေငါး\"}]', 501.00, '', 0.00, 'Lost', 0.00, 'ရွှေငါး', '2026-09-16 01:59:13'),
(58, 8, 'SM', '[{\"animal_index\":0,\"animal_name\":\"မြင်း\",\"amount\":5000,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ရွှေငါး\"}]', 5000.00, '', 0.00, 'Lost', 0.00, 'ရွှေငါး', '2026-09-16 02:09:14'),
(59, 8, 'SM', '[{\"animal_index\":0,\"animal_name\":\"မြင်း\",\"amount\":10000,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ရွှေနဂါး\"},{\"animal_index\":3,\"animal_name\":\"လိပ်ပြာ\",\"amount\":900,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ရွှေနဂါး\"}]', 10900.00, '', 0.00, 'Lost', 0.00, 'ရွှေနဂါး', '2026-09-16 02:25:32'),
(60, 8, 'SM', '[{\"animal_index\":0,\"animal_name\":\"မြင်း\",\"amount\":100,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ရွှေနဂါး\"}]', 100.00, '', 0.00, 'Lost', 0.00, 'ရွှေနဂါး', '2026-09-16 02:34:35'),
(61, 8, 'SM', '[{\"animal_index\":0,\"animal_name\":\"မြင်း\",\"amount\":1000,\"status\":\"Lost\",\"winAmount\":0,\"luckyAnimal\":\"ကျောက်\"}]', 1000.00, '', 0.00, 'Lost', 0.00, 'ကျောက်', '2026-09-16 03:39:32');

-- --------------------------------------------------------

--
-- Table structure for table `league_matches`
--

CREATE TABLE `league_matches` (
  `id` int(11) NOT NULL,
  `league_name` varchar(255) DEFAULT NULL,
  `teams` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `league_matches`
--

INSERT INTO `league_matches` (`id`, `league_name`, `teams`, `created_at`, `updated_at`) VALUES
(13, 'Premier League', '[\"Man City\",\"Arsenal\",\"Hull\",\"Chelsea\",\"Brentford\",\"Newcastle\",\"Everton\",\"Leeds\",\"Brighton\",\"Man Utd\",\"Sunderland\",\"Ipswich Town\",\"Liverpool\",\"Bournemouth\",\"Nottm Forest\",\"Fulham\",\"Coventry\",\"Palace\",\"Spurs\",\"Aston Villa\"]', '2026-09-04 10:35:13', '2026-09-04 10:35:13'),
(14, 'Serie A', '[\"Roma\",\"Inter\",\"Milan\",\"Juventus\",\"Atalanta\",\"Lazio\",\"Udinese\",\"Como\",\"Frosinone\",\"Napoli\",\"Sassuolo\",\"Cagliari\",\"Lecce\",\"Torino\",\"Bologna\",\"Parma\",\"Genoa\",\"Monza\",\"Venezia\",\"Fiorentina\"]', '2026-09-04 10:36:36', '2026-09-04 10:36:36'),
(15, 'LaLiga', '[\"Barcelona\",\"Real Madrid\",\"Atlético Madrid\",\"Alavés\",\"Osasuna\",\"Sevilla\",\"Betis\",\"Deportivo\",\"Racing Santander\",\"Levante\",\"Real Sociedad\",\"Espanyol\",\"Athletic\",\"Getafe\",\"Villarreal\",\"Celta\",\"Valencia\",\"Rayo Vallecano\",\"Elche\",\"Málaga\"]', '2026-09-04 10:37:11', '2026-09-04 10:37:11'),
(16, 'Champions League', '[\"AEK\",\"အာဆင်နယ်\"]', '2026-09-05 11:24:25', '2026-09-17 10:11:25');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_requests`
--

CREATE TABLE `payment_requests` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `payment` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `transactionId` varchar(100) DEFAULT '',
  `status` varchar(20) DEFAULT 'Pending',
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment_requests`
--

INSERT INTO `payment_requests` (`id`, `userId`, `userName`, `phone`, `payment`, `type`, `amount`, `transactionId`, `status`, `time`, `updated_at`, `created_at`) VALUES
(27, 6, 'KO', '99999', 'AYA Pay', 'deposit', 100000.00, '454948', 'approved', '2026-09-09 08:41:55', '2026-09-09 02:12:25', '2026-09-09 02:11:55'),
(28, 7, 'MMM', '11111', 'Wave Money', 'deposit', 100000.00, '879372', 'approved', '2026-09-09 17:13:24', '2026-09-09 10:43:39', '2026-09-09 10:43:24'),
(29, 8, 'SM', '22222', 'AYA Pay', 'deposit', 100000.00, '383279', 'approved', '2026-09-12 09:36:37', '2026-09-12 03:07:04', '2026-09-12 03:06:37'),
(30, 8, '', '', '', 'deposit', 100000.00, '434', 'approved', '2026-09-15 12:40:03', '2026-09-15 06:11:11', '2026-09-15 06:10:03'),
(31, 8, '', '', '', 'withdraw', 1000.00, '', 'approved', '2026-09-15 12:40:31', '2026-09-15 06:12:56', '2026-09-15 06:10:31'),
(32, 8, '', '', '', 'deposit', 1000.00, '434211', 'approved', '2026-09-15 12:41:45', '2026-09-15 06:11:52', '2026-09-15 06:11:45'),
(33, 8, '', '', '', 'deposit', 1000.00, '453453', 'approved', '2026-09-15 12:42:30', '2026-09-15 06:12:37', '2026-09-15 06:12:30'),
(34, 8, '', '', '', 'withdraw', 1000.00, '', 'approved', '2026-09-15 12:43:24', '2026-09-15 06:15:06', '2026-09-15 06:13:24'),
(35, 8, '', '', '', 'withdraw', 9000.00, '', 'reject', '2026-09-15 12:43:49', '2026-09-15 06:14:13', '2026-09-15 06:13:49'),
(36, 8, '', '', '', 'withdraw', 9000.00, '', 'approved', '2026-09-15 12:49:34', '2026-09-17 05:01:12', '2026-09-15 06:19:34'),
(37, 8, '', '', '', 'deposit', 5000.00, '453221', 'reject', '2026-09-15 14:41:18', '2026-09-15 08:11:46', '2026-09-15 08:11:18'),
(38, 8, '', '', '', 'deposit', 50000.00, '4897839', 'approved', '2026-09-17 09:00:35', '2026-09-17 02:30:58', '2026-09-17 02:30:35'),
(39, 8, '', '', '', 'withdraw', 10000.00, '', 'approved', '2026-09-17 11:31:00', '2026-09-17 05:01:37', '2026-09-17 05:01:00'),
(40, 8, '', '', '', 'deposit', 30000.00, '987073', 'Pending', '2026-09-17 11:35:10', '2026-09-17 05:05:10', '2026-09-17 05:05:10'),
(41, 8, '', '', '', 'deposit', 10000.00, '387298', 'Pending', '2026-09-17 11:35:36', '2026-09-17 05:05:36', '2026-09-17 05:05:36'),
(42, 8, '', '', '', 'withdraw', 11000.00, '', 'Pending', '2026-09-17 11:36:05', '2026-09-17 05:06:05', '2026-09-17 05:06:05');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'auth_token', 'e6b392ad3acea709a1a701003f3cf6387e5ad7405ec98370fa75d0625609343c', '[\"*\"]', NULL, NULL, '2026-08-31 08:51:24', '2026-08-31 08:51:24'),
(2, 'App\\Models\\User', 4, 'auth_token', 'c215d28b9de99b88f975dcf1fd9ba33cb35a4dc72fcb5969c513d23420bf8c8c', '[\"*\"]', NULL, NULL, '2026-08-31 09:07:08', '2026-08-31 09:07:08'),
(3, 'App\\Models\\User', 4, 'auth_token', 'b3d8966ee551b441bd33a1934f2a0b5f75b1b0f9bb745591a895a9411099d640', '[\"*\"]', NULL, NULL, '2026-08-31 09:07:21', '2026-08-31 09:07:21'),
(4, 'App\\Models\\User', 1, 'auth_token', '4cf7e093543ad99c2ec45e3e785e87cef3d02f5d30e3e37f1f33e9b9ee8b398e', '[\"*\"]', NULL, NULL, '2026-08-31 09:29:29', '2026-08-31 09:29:29'),
(5, 'App\\Models\\User', 5, 'admin_token', 'e389cc5314b8fb3910127827472a1372cbc14026c4272d03088fbd3bc03f3351', '[\"*\"]', '2026-09-09 06:44:41', NULL, '2026-09-09 01:59:40', '2026-09-09 06:44:41'),
(6, 'App\\Models\\User', 6, 'auth_token', '6cd32673ee7494209ad9a9d1957797fced9f9431b7fbc483d03ff5be5101ee15', '[\"*\"]', NULL, NULL, '2026-09-09 02:05:46', '2026-09-09 02:05:46'),
(7, 'App\\Models\\User', 6, 'auth_token', 'ddb760701e99bfdf185ac3298f971b5d2740095e0c545c1b342513ed8b59b24c', '[\"*\"]', '2026-09-09 02:17:37', NULL, '2026-09-09 02:05:54', '2026-09-09 02:17:37'),
(8, 'App\\Models\\User', 6, 'auth_token', '709153dc140caf3a485f1f9ecb926c507bb29357ada437d956ef31619e78e7ee', '[\"*\"]', '2026-09-09 02:34:08', NULL, '2026-09-09 02:19:39', '2026-09-09 02:34:08'),
(9, 'App\\Models\\User', 6, 'auth_token', 'dd3c809c6f560a688eb618e5af897cd4d8c62da6faab9cca87af75695682b2d9', '[\"*\"]', '2026-09-09 03:06:23', NULL, '2026-09-09 02:40:58', '2026-09-09 03:06:23'),
(10, 'App\\Models\\User', 6, 'auth_token', '0a66210485cef95dfd95af12d6c4b5881d517c503c9d38f8ff8f006f8e860f96', '[\"*\"]', '2026-09-09 03:29:35', NULL, '2026-09-09 03:09:38', '2026-09-09 03:29:35'),
(11, 'App\\Models\\User', 6, 'auth_token', '44579d7ea13a433659ceb8dcf7a83530b83262a5f9b4abc8940e5f4d3ce221cc', '[\"*\"]', '2026-09-09 03:37:32', NULL, '2026-09-09 03:31:13', '2026-09-09 03:37:32'),
(12, 'App\\Models\\User', 6, 'auth_token', '885c5fa9ff74ef01609ee43d068356a19a2c90b4c1fef66872db25ebd9f19473', '[\"*\"]', '2026-09-09 04:06:25', NULL, '2026-09-09 03:40:27', '2026-09-09 04:06:25'),
(13, 'App\\Models\\User', 6, 'auth_token', 'd0d1d37851cb4537ac5a62a06bef50b8d50ce7e93a0bef071ae00124aa80ebc4', '[\"*\"]', '2026-09-09 04:26:14', NULL, '2026-09-09 04:08:22', '2026-09-09 04:26:14'),
(14, 'App\\Models\\User', 6, 'auth_token', '598f9f2063d2fd2311828668c86e2941d6e9255eb4341f99c2785d573fd71846', '[\"*\"]', '2026-09-09 04:30:42', NULL, '2026-09-09 04:27:57', '2026-09-09 04:30:42'),
(15, 'App\\Models\\User', 6, 'auth_token', '60786c7b13166ae2e5a238388ca1549e3fddd95690ffc35fa621561a7c7562e2', '[\"*\"]', '2026-09-09 04:39:53', NULL, '2026-09-09 04:35:44', '2026-09-09 04:39:53'),
(16, 'App\\Models\\User', 6, 'auth_token', 'ff4672430cf0d2eb407c89fcb25ebccbca907e4d7f41ac0e8717e5feb59d5ad0', '[\"*\"]', '2026-09-09 05:30:23', NULL, '2026-09-09 05:27:06', '2026-09-09 05:30:23'),
(17, 'App\\Models\\User', 6, 'auth_token', '299a1ca170c744297d3b59e05cd3da724cc6a42f6477d2b4dfeb5374fef94a4c', '[\"*\"]', '2026-09-09 08:15:46', NULL, '2026-09-09 05:35:49', '2026-09-09 08:15:46'),
(18, 'App\\Models\\User', 5, 'admin_token', '5ceef8e54e386088b222ff3552189c880a1bca9e4bd71c4f8f29ba026f905a56', '[\"*\"]', '2026-09-09 08:19:46', NULL, '2026-09-09 06:44:44', '2026-09-09 08:19:46'),
(19, 'App\\Models\\User', 5, 'admin_token', '78ab382ca134ff82ea0db3917effd7aee8b305c59fb2186ac7850b7621f181a9', '[\"*\"]', '2026-09-09 11:08:47', NULL, '2026-09-09 09:57:29', '2026-09-09 11:08:47'),
(20, 'App\\Models\\User', 7, 'auth_token', '2761f3495b7da66783f5fffa0275b647ff76417c9adb10054596b9c9302ef562', '[\"*\"]', NULL, NULL, '2026-09-09 10:42:41', '2026-09-09 10:42:41'),
(21, 'App\\Models\\User', 7, 'auth_token', '9fe5ff018547a6201c6476a6b99edaf79c639b84baf78cef220d4fd2ad97dcc7', '[\"*\"]', '2026-09-09 11:15:46', NULL, '2026-09-09 10:42:53', '2026-09-09 11:15:46'),
(22, 'App\\Models\\User', 5, 'admin_token', '166a529ad1913f7c1aa35871a317bdd6b3c7b4daff3daca3b6df436f15f7bf07', '[\"*\"]', '2026-09-09 11:15:42', NULL, '2026-09-09 11:08:49', '2026-09-09 11:15:42'),
(23, 'App\\Models\\User', 5, 'admin_token', 'c3d8f15d68da27b7fd802a6c4d656560a11193268e054f800842dc100ad28549', '[\"*\"]', '2026-09-10 07:55:14', NULL, '2026-09-09 23:09:07', '2026-09-10 07:55:14'),
(24, 'App\\Models\\User', 6, 'auth_token', '68cba981db2f45927789aa04cba4f8ddfea7ce723d1c1633d28efdbef4c38934', '[\"*\"]', '2026-09-10 01:04:11', NULL, '2026-09-09 23:26:13', '2026-09-10 01:04:11'),
(25, 'App\\Models\\User', 6, 'auth_token', 'bcae50cdd8c5c202d6d7ca60ae6c78d404bb49310a731e459ae09bde85dd544e', '[\"*\"]', '2026-09-10 01:27:38', NULL, '2026-09-10 01:21:46', '2026-09-10 01:27:38'),
(26, 'App\\Models\\User', 6, 'auth_token', 'ff153075cc8abcc2412eb77d9a13076d5b91f35f2c38f50e312147351be29277', '[\"*\"]', NULL, NULL, '2026-09-10 01:22:15', '2026-09-10 01:22:15'),
(27, 'App\\Models\\User', 6, 'auth_token', '52269acb35cc5bbafcb7c05ce657f356a35e20a7108cc092457a6d5720c2d286', '[\"*\"]', NULL, NULL, '2026-09-10 01:22:19', '2026-09-10 01:22:19'),
(28, 'App\\Models\\User', 6, 'auth_token', '313d2b4765f3b1c3c8da3f99c2b61703b698b7313ef1e6006c2294318b79a1db', '[\"*\"]', NULL, NULL, '2026-09-10 01:23:07', '2026-09-10 01:23:07'),
(29, 'App\\Models\\User', 6, 'auth_token', 'c986b802b2d53b5ca3ac04dfc74b3ab91b6a5cd68e6d5f78259d8e2a4c8291d6', '[\"*\"]', NULL, NULL, '2026-09-10 01:23:41', '2026-09-10 01:23:41'),
(30, 'App\\Models\\User', 6, 'auth_token', '2bd324a83e086fd4fbd0fe5ee2cd0e00f559747a7c8d607b58efc4b2d22c3038', '[\"*\"]', NULL, NULL, '2026-09-10 01:24:48', '2026-09-10 01:24:48'),
(31, 'App\\Models\\User', 6, 'auth_token', 'bf6e564048fe9338feecf10d5ccb271c47a62195dc8583be51d6e8bb1a11771f', '[\"*\"]', '2026-09-10 02:26:55', NULL, '2026-09-10 01:33:54', '2026-09-10 02:26:55'),
(32, 'App\\Models\\User', 6, 'auth_token', '92a2508a9f6d104707e1d56b2492df08dfea27bdab9e0f51485e68c097ed6ca5', '[\"*\"]', '2026-09-10 03:01:27', NULL, '2026-09-10 02:28:50', '2026-09-10 03:01:27'),
(33, 'App\\Models\\User', 6, 'auth_token', '6cacf2d96f58c04e55bca150f786caf776d6e4aa8fdb68ad97101a3c763a5d32', '[\"*\"]', '2026-09-10 10:45:30', NULL, '2026-09-10 03:03:19', '2026-09-10 10:45:30'),
(34, 'App\\Models\\User', 5, 'admin_token', 'fa2c85a91739e49f7f1e5d7eb8a9ce186e60362332588f311a4852f7bd70887b', '[\"*\"]', '2026-09-10 10:45:26', NULL, '2026-09-10 07:55:16', '2026-09-10 10:45:26'),
(35, 'App\\Models\\User', 5, 'admin_token', '2d74d94d9a3f28aa7404b3c277cd63a4e770fff4d7a8fdbdd698273f7e2b507b', '[\"*\"]', '2026-09-11 11:17:06', NULL, '2026-09-11 10:24:24', '2026-09-11 11:17:06'),
(36, 'App\\Models\\User', 6, 'auth_token', '6b3c85aa1700e61b127e88ad8018586232794d61f589a01081387269fa137a83', '[\"*\"]', '2026-09-11 11:17:08', NULL, '2026-09-11 10:55:35', '2026-09-11 11:17:08'),
(37, 'App\\Models\\User', 5, 'admin_token', '21212a08a3fb866916f92cd28abf98701e7883bcf3de0c1877d1713831f625a6', '[\"*\"]', '2026-09-12 08:53:07', NULL, '2026-09-12 03:02:13', '2026-09-12 08:53:07'),
(38, 'App\\Models\\User', 8, 'auth_token', '2ef07463de7e821f45a8f96fe23996d97a05b21ace8a780545705f9d7aab7eda', '[\"*\"]', NULL, NULL, '2026-09-12 03:05:16', '2026-09-12 03:05:16'),
(39, 'App\\Models\\User', 8, 'auth_token', 'e5dd0919f27ee720d5c001ba009b5b0659181254a0f35c14dd5f4030c10c8039', '[\"*\"]', '2026-09-12 06:57:32', NULL, '2026-09-12 03:05:23', '2026-09-12 06:57:32'),
(40, 'App\\Models\\User', 5, 'admin_token', '5e5995041fcfb275929e112f1e24cffc10c5ee7f4e55e6f8bdcbeae28da3f526', '[\"*\"]', '2026-09-12 11:00:22', NULL, '2026-09-12 08:53:08', '2026-09-12 11:00:22'),
(41, 'App\\Models\\User', 8, 'auth_token', '5404ac72be04b2f68b4914ed4731d8384e466316617ae475c38638de1675a5d1', '[\"*\"]', '2026-09-12 11:00:03', NULL, '2026-09-12 09:02:30', '2026-09-12 11:00:03'),
(42, 'App\\Models\\User', 5, 'admin_token', 'b4071f9f1693468f841079f683424a7c4e94acde83815232c064f32e54e6b617', '[\"*\"]', '2026-09-13 10:58:48', NULL, '2026-09-13 03:27:13', '2026-09-13 10:58:48'),
(43, 'App\\Models\\User', 8, 'auth_token', '9cd3c24f93ce9a073875b17cb4b09d72e13bb766a806b78548a5b70b05925818', '[\"*\"]', '2026-09-13 04:13:18', NULL, '2026-09-13 03:33:03', '2026-09-13 04:13:18'),
(44, 'App\\Models\\User', 8, 'auth_token', '5b7daeb87ef6df8dceb36378cd90893267e7d6a6d96143700723dc038a31dd70', '[\"*\"]', '2026-09-13 04:25:18', NULL, '2026-09-13 04:15:58', '2026-09-13 04:25:18'),
(45, 'App\\Models\\User', 8, 'auth_token', '5ff94ff7715e6d23eed2d0e337efe7e8b1ab20b1658974d743b75ed96fb84ed5', '[\"*\"]', '2026-09-13 04:30:18', NULL, '2026-09-13 04:26:53', '2026-09-13 04:30:18'),
(46, 'App\\Models\\User', 8, 'auth_token', '36d09b48c5f1e38c240cb54a5ef6fe2d58bab6a25c7fc174ff15cc8102d6df3a', '[\"*\"]', '2026-09-13 04:34:02', NULL, '2026-09-13 04:31:49', '2026-09-13 04:34:02'),
(47, 'App\\Models\\User', 8, 'auth_token', '2455976fcd7a51d838b20b5e7d7f3faef85600d96ebbccdef7e4269a7c85b63b', '[\"*\"]', '2026-09-13 04:37:29', NULL, '2026-09-13 04:35:28', '2026-09-13 04:37:29'),
(48, 'App\\Models\\User', 8, 'auth_token', '214f88482f0f5b95dfc26e8b220053dc5a8b69b5249e9a35bda9e9d6f2552cd6', '[\"*\"]', '2026-09-13 04:43:36', NULL, '2026-09-13 04:39:44', '2026-09-13 04:43:36'),
(49, 'App\\Models\\User', 8, 'auth_token', '96334f0817848a7ef6742b25ab7bc44dd5d30d97c137ea4690fe8506aca45751', '[\"*\"]', '2026-09-13 04:49:03', NULL, '2026-09-13 04:45:05', '2026-09-13 04:49:03'),
(50, 'App\\Models\\User', 8, 'auth_token', '1d8eb98d916ea7f4dd1faa0a126192376c440dfbaa140a4d42267ac59b9042f0', '[\"*\"]', '2026-09-13 04:54:55', NULL, '2026-09-13 04:50:43', '2026-09-13 04:54:55'),
(51, 'App\\Models\\User', 8, 'auth_token', '6800c8579fef44d0a4ec8e761d01a181f629f59f20c2e666905722d99ee57cce', '[\"*\"]', '2026-09-13 05:25:34', NULL, '2026-09-13 04:56:25', '2026-09-13 05:25:34'),
(52, 'App\\Models\\User', 8, 'auth_token', '719e212d34bd6f300a01a5f9f767ba21c806f7c96c3d42cc46bbe0950871b9e2', '[\"*\"]', '2026-09-13 05:27:38', NULL, '2026-09-13 05:27:09', '2026-09-13 05:27:38'),
(53, 'App\\Models\\User', 8, 'auth_token', '5b20debb61d9d56110ae9ce333e590335ed438c74a2b9dd540f13de34c734c8c', '[\"*\"]', '2026-09-13 05:51:12', NULL, '2026-09-13 05:31:55', '2026-09-13 05:51:12'),
(54, 'App\\Models\\User', 8, 'auth_token', 'e2e18359b4cde9fd93e5b3ed5009641c27595fb3c09e6c9de202c6ce4fc4f392', '[\"*\"]', '2026-09-13 06:09:08', NULL, '2026-09-13 05:54:37', '2026-09-13 06:09:08'),
(55, 'App\\Models\\User', 8, 'auth_token', '18c5cce735ada4f6debfdff33fcf2c7bf3a95e29c53f3e1b92924b9187351400', '[\"*\"]', '2026-09-13 06:19:25', NULL, '2026-09-13 06:11:12', '2026-09-13 06:19:25'),
(56, 'App\\Models\\User', 8, 'auth_token', '24a42ee582f0c89b6936da376b221d2f58e3d866b814a32df5c2bc02b8fa5b77', '[\"*\"]', '2026-09-13 06:23:24', NULL, '2026-09-13 06:21:04', '2026-09-13 06:23:24'),
(57, 'App\\Models\\User', 8, 'auth_token', '2972e557fb283b6c7e24bb46fd82f517527c6004f620af0bed893c33572e21d0', '[\"*\"]', '2026-09-13 06:28:17', NULL, '2026-09-13 06:25:07', '2026-09-13 06:28:17'),
(58, 'App\\Models\\User', 8, 'auth_token', 'd5769acfdea7deda95850ce2ee462469bbfad71872be870ed98f1af33af52e67', '[\"*\"]', '2026-09-13 06:42:31', NULL, '2026-09-13 06:30:02', '2026-09-13 06:42:31'),
(59, 'App\\Models\\User', 8, 'auth_token', '13ad5ab247debd02c79b3ac5d819c98f173e64e24635551fc64abb7ea1a5a8d1', '[\"*\"]', '2026-09-13 07:51:58', NULL, '2026-09-13 06:44:21', '2026-09-13 07:51:58'),
(60, 'App\\Models\\User', 8, 'auth_token', 'f65cb0bf8a7a760bbb3dfa9bf1c66d2902c56d265ef331946313bacc3c5c724b', '[\"*\"]', '2026-09-13 07:54:20', NULL, '2026-09-13 07:54:13', '2026-09-13 07:54:20'),
(61, 'App\\Models\\User', 8, 'auth_token', '15370f4103851b3c729ddca814701e4ae69a9def9fedd5a81a4ea76099647904', '[\"*\"]', '2026-09-13 09:47:35', NULL, '2026-09-13 07:54:16', '2026-09-13 09:47:35'),
(62, 'App\\Models\\User', 8, 'auth_token', '9d81a3492052359c7fc026eb9e198a1d5c84cb85fd425ffe396cdae41c65a272', '[\"*\"]', '2026-09-13 09:55:52', NULL, '2026-09-13 09:52:23', '2026-09-13 09:55:52'),
(63, 'App\\Models\\User', 8, 'auth_token', '940d385de53653e2afe0fa450f2ded840e5aacc20ef36c4f00d9f2a29eaa17d5', '[\"*\"]', '2026-09-13 10:20:21', NULL, '2026-09-13 10:08:20', '2026-09-13 10:20:21'),
(64, 'App\\Models\\User', 8, 'auth_token', '74ac839a0af988070c15d084b618f076c4046f25b24fe39782ca7603ea0d56f3', '[\"*\"]', '2026-09-13 10:25:32', NULL, '2026-09-13 10:23:01', '2026-09-13 10:25:32'),
(65, 'App\\Models\\User', 8, 'auth_token', '27f2580990662cce085b01806c26f2b7d42ee90a3052a2015ccdde6445cbe182', '[\"*\"]', NULL, NULL, '2026-09-13 10:28:22', '2026-09-13 10:28:22'),
(66, 'App\\Models\\User', 8, 'auth_token', '49602a31afddfe9e85bad3d2ca4820089fcdd4951aa9d1f20ce69e43cb50671f', '[\"*\"]', '2026-09-13 10:37:04', NULL, '2026-09-13 10:28:25', '2026-09-13 10:37:04'),
(67, 'App\\Models\\User', 8, 'auth_token', 'ef05e5e0fc2b7d4df72d2b2c4821e1fcd30c942183277a44be7a640f8da4292c', '[\"*\"]', '2026-09-13 10:45:02', NULL, '2026-09-13 10:44:04', '2026-09-13 10:45:02'),
(68, 'App\\Models\\User', 8, 'auth_token', '9aae1d3f1069632984f59b35ca74b7723535327c7f2b5fa1e313437ea479b09f', '[\"*\"]', '2026-09-13 11:48:24', NULL, '2026-09-13 10:50:33', '2026-09-13 11:48:24'),
(69, 'App\\Models\\User', 5, 'admin_token', '692f0d4247351517add54db7bcf7982009f930f94017900493c23385bbdba072', '[\"*\"]', '2026-09-13 11:48:19', NULL, '2026-09-13 10:58:51', '2026-09-13 11:48:19'),
(70, 'App\\Models\\User', 5, 'admin_token', 'af67c26d2ac888011fe3ce8bd61b5ee2a70cbe5fffbc999c7e6c30f1ace9c723', '[\"*\"]', '2026-09-14 02:55:10', NULL, '2026-09-14 01:40:46', '2026-09-14 02:55:10'),
(71, 'App\\Models\\User', 8, 'auth_token', '69f2a6e7c6b3838fd13d0852e7c577a2ed207ab370ef57d2fb3128aac58ebc26', '[\"*\"]', '2026-09-14 02:54:59', NULL, '2026-09-14 02:08:54', '2026-09-14 02:54:59'),
(72, 'App\\Models\\User', 8, 'auth_token', 'b7213e7e1b91c4c62c29b139ac5cb1aaf52ee84576e474d68296c417b7750acc', '[\"*\"]', NULL, NULL, '2026-09-14 03:06:31', '2026-09-14 03:06:31'),
(73, 'App\\Models\\User', 5, 'admin_token', 'fd71bd20179e5ab80ef17ac05adf3e94132c1b3ee66a7e2fbe515f726cd26924', '[\"*\"]', '2026-09-14 05:33:05', NULL, '2026-09-14 03:06:58', '2026-09-14 05:33:05'),
(74, 'App\\Models\\User', 8, 'auth_token', '238bda33516192501a4abec1620f17884781509612ec74ef1607eb3f38a9628f', '[\"*\"]', '2026-09-14 03:38:45', NULL, '2026-09-14 03:08:00', '2026-09-14 03:38:45'),
(75, 'App\\Models\\User', 8, 'auth_token', '49e20cb567c49fb2bc62c1297e5b2c38bafa3e742b02dbb465caa6940155c226', '[\"*\"]', '2026-09-14 04:49:35', NULL, '2026-09-14 03:41:23', '2026-09-14 04:49:35'),
(76, 'App\\Models\\User', 8, 'auth_token', '27e2a066e16583fece89eaa4a7e0df0e4c1954e23c9d181884e7f8b917e2cb84', '[\"*\"]', '2026-09-14 05:32:36', NULL, '2026-09-14 04:50:41', '2026-09-14 05:32:36'),
(77, 'App\\Models\\User', 8, 'auth_token', 'b26d2c49842b928e5f1b03edfd18202affd3c9e23fae671dfb52426ae2cf8fae', '[\"*\"]', '2026-09-15 10:25:37', NULL, '2026-09-15 03:54:06', '2026-09-15 10:25:37'),
(78, 'App\\Models\\User', 5, 'admin_token', '0106f2135151d7f5fa52cfc1d787e4f37132146f8c70b0d16d61950bdc2f3a35', '[\"*\"]', '2026-09-15 10:41:00', NULL, '2026-09-15 04:19:45', '2026-09-15 10:41:00'),
(79, 'App\\Models\\User', 8, 'auth_token', '4a80ee627a3896acde491d56a5066ecfe4f597f4ecd02f2191d4c9b5f08eab08', '[\"*\"]', '2026-09-15 11:08:34', NULL, '2026-09-15 10:31:50', '2026-09-15 11:08:34'),
(80, 'App\\Models\\User', 5, 'admin_token', '526d2835535f505f6de3801e9af1562831030e03dee04bb59055b8c25c6d5f1f', '[\"*\"]', '2026-09-15 11:34:24', NULL, '2026-09-15 10:44:11', '2026-09-15 11:34:24'),
(81, 'App\\Models\\User', 8, 'auth_token', '6ce3190d4eee1764998cc80aa005d730aa028e67b3db76a4fdd531a7015019e4', '[\"*\"]', NULL, NULL, '2026-09-15 11:08:37', '2026-09-15 11:08:37'),
(82, 'App\\Models\\User', 8, 'auth_token', '338e61373b3d8ec96c0d14c87f00969988e51ae233139d446589f4e0338c74c5', '[\"*\"]', NULL, NULL, '2026-09-15 11:08:40', '2026-09-15 11:08:40'),
(83, 'App\\Models\\User', 8, 'auth_token', 'ea8169747e272f1c0204314d80178bbfe0ab3f727027496ef87f076eabeb0728', '[\"*\"]', '2026-09-16 01:10:08', NULL, '2026-09-15 11:08:43', '2026-09-16 01:10:08'),
(84, 'App\\Models\\User', 8, 'auth_token', 'd462679fb9ef0e99b943f2eadd8dc6cc0d422b4382549190ffdd2c1faa0f95e7', '[\"*\"]', NULL, NULL, '2026-09-15 11:09:05', '2026-09-15 11:09:05'),
(85, 'App\\Models\\User', 8, 'auth_token', '0517c62ac2eee48d8bb455c861888910bed8036880597a0965e2aff98e93d0f9', '[\"*\"]', NULL, NULL, '2026-09-15 11:09:24', '2026-09-15 11:09:24'),
(86, 'App\\Models\\User', 8, 'auth_token', 'bf727460be53263fe4c60073806a5721334340263cd598027c18f579e5883d84', '[\"*\"]', NULL, NULL, '2026-09-15 11:30:38', '2026-09-15 11:30:38'),
(87, 'App\\Models\\User', 8, 'auth_token', 'e75e483f8250cee33a5d5a975afa95b6236c8d210bee2c9f9184d6ebd0e8f195', '[\"*\"]', '2026-09-15 23:09:53', NULL, '2026-09-15 11:30:49', '2026-09-15 23:09:53'),
(88, 'App\\Models\\User', 5, 'admin_token', 'a8336bf2d66ca903383e7f01df43ad40d327917035a3ceb45623ede7ff98b857', '[\"*\"]', '2026-09-16 02:27:17', NULL, '2026-09-15 23:36:09', '2026-09-16 02:27:17'),
(89, 'App\\Models\\User', 8, 'auth_token', '6ff46fe41c3fe30ebc9249008347d31b3d75ecd442845b069fa9b241b2f96f4c', '[\"*\"]', NULL, NULL, '2026-09-16 01:12:39', '2026-09-16 01:12:39'),
(90, 'App\\Models\\User', 8, 'auth_token', '61dc698faab6fbdf7025e6ef14e024530989f944ff0cdf35fade3eb361d997d9', '[\"*\"]', NULL, NULL, '2026-09-16 01:12:40', '2026-09-16 01:12:40'),
(91, 'App\\Models\\User', 8, 'auth_token', '974b3e9c4cf396810e8817232baa9659a3f28d9e640cb4d779cce3f9b598162f', '[\"*\"]', '2026-09-16 02:11:36', NULL, '2026-09-16 01:12:43', '2026-09-16 02:11:36'),
(92, 'App\\Models\\User', 8, 'auth_token', 'd8cbbce1a8c5cdc9720d7c3893c226579b5f626a77fdd6d29b05b80bffa3eb96', '[\"*\"]', NULL, NULL, '2026-09-16 02:03:51', '2026-09-16 02:03:51'),
(93, 'App\\Models\\User', 8, 'auth_token', '59072349ec83c383b9ae23fdd66e461a4cbe111ccb1125e209880a2a5ffe987d', '[\"*\"]', NULL, NULL, '2026-09-16 02:03:55', '2026-09-16 02:03:55'),
(94, 'App\\Models\\User', 8, 'auth_token', '80e98e3ddb433dfc1ffa0787be0690eb9944880a3f4f44b74429e67c29c0e7a7', '[\"*\"]', '2026-09-16 02:07:20', NULL, '2026-09-16 02:04:02', '2026-09-16 02:07:20'),
(95, 'App\\Models\\User', 8, 'auth_token', 'ae04d1bc336badc4074977fed28cea2bff80d0fa29c8e1e65426820faa60a5cb', '[\"*\"]', NULL, NULL, '2026-09-16 02:04:29', '2026-09-16 02:04:29'),
(96, 'App\\Models\\User', 8, 'auth_token', 'e56627addf114bc4c94236ff031f697acd105b471cf8c67e01e83c63da10faf8', '[\"*\"]', NULL, NULL, '2026-09-16 02:04:40', '2026-09-16 02:04:40'),
(97, 'App\\Models\\User', 8, 'auth_token', 'd29a09f8817550eee7dffe099e6fb5f6d37a779f4fd0a7166ec36d22e1d97339', '[\"*\"]', NULL, NULL, '2026-09-16 02:04:45', '2026-09-16 02:04:45'),
(98, 'App\\Models\\User', 8, 'auth_token', '1c573689906f3d19988a63e7cc3f962773b70af1bac0a8a77c96ec019042c6ac', '[\"*\"]', '2026-09-16 02:27:39', NULL, '2026-09-16 02:12:50', '2026-09-16 02:27:39'),
(99, 'App\\Models\\User', 8, 'auth_token', 'f68b80ac37da12ba1f48ee3141af8e292870c261f2f39b0bcd8e270d0005f2fe', '[\"*\"]', NULL, NULL, '2026-09-16 02:18:43', '2026-09-16 02:18:43'),
(100, 'App\\Models\\User', 8, 'auth_token', '344f67d248ff2927978345307e9cda03745f3d664ae71cff84c18a246ed5a0be', '[\"*\"]', NULL, NULL, '2026-09-16 02:18:49', '2026-09-16 02:18:49'),
(101, 'App\\Models\\User', 8, 'auth_token', '52c77c9833b21e37110fbbed7ba88a5004b2400252651b39244104cbcce5d222', '[\"*\"]', NULL, NULL, '2026-09-16 02:18:53', '2026-09-16 02:18:53'),
(102, 'App\\Models\\User', 8, 'auth_token', '8305f423d5605abf80dca20bfa7b5487c19a745bdb39f9b51c7c9c3494795e3b', '[\"*\"]', NULL, NULL, '2026-09-16 02:19:01', '2026-09-16 02:19:01'),
(103, 'App\\Models\\User', 8, 'auth_token', '5dbf3264fafcffb10fe02ff1de14373d6779014ca700c0f5ad2f6681f664b3d2', '[\"*\"]', NULL, NULL, '2026-09-16 02:19:12', '2026-09-16 02:19:12'),
(104, 'App\\Models\\User', 8, 'auth_token', '87f8dabf6eea5773acf366edfe0840ace0b8fa9e083e189c2ad4f0abd096e3f1', '[\"*\"]', NULL, NULL, '2026-09-16 02:19:25', '2026-09-16 02:19:25'),
(105, 'App\\Models\\User', 8, 'auth_token', '763d651c4665562004c3ffae9bc8f5cd1607bbef951e6f3cabf56c0e3b0b8101', '[\"*\"]', NULL, NULL, '2026-09-16 02:19:59', '2026-09-16 02:19:59'),
(106, 'App\\Models\\User', 8, 'auth_token', '5404e4208b57fb106c921f00f24f2930aa67c43ac3e184d92088c5663ff60b6f', '[\"*\"]', NULL, NULL, '2026-09-16 02:20:06', '2026-09-16 02:20:06'),
(107, 'App\\Models\\User', 8, 'auth_token', '2f19bb6e2e70e51adc1b8921be031615ffd8553b18afb0db774e04a39b7f0c69', '[\"*\"]', NULL, NULL, '2026-09-16 02:20:11', '2026-09-16 02:20:11'),
(108, 'App\\Models\\User', 8, 'auth_token', 'b8636591e23a953031af4b0655d19c2cdca915236f5348ddc4b002913789210a', '[\"*\"]', NULL, NULL, '2026-09-16 02:20:19', '2026-09-16 02:20:19'),
(109, 'App\\Models\\User', 8, 'auth_token', 'b85d951b65536a7f0d0e5957d603f6999dab893c37149e121c6b7e0632250450', '[\"*\"]', NULL, NULL, '2026-09-16 02:20:22', '2026-09-16 02:20:22'),
(110, 'App\\Models\\User', 8, 'auth_token', 'e374ce9aa620680cc5d3864973f50429d1bdb52706675b9682cc684593a99ff2', '[\"*\"]', NULL, NULL, '2026-09-16 02:20:35', '2026-09-16 02:20:35'),
(111, 'App\\Models\\User', 8, 'auth_token', 'e6e50d81253d54c8da4e3ad424eb2b1ed482536df27e59a2e4e8444128a02e9c', '[\"*\"]', NULL, NULL, '2026-09-16 02:20:52', '2026-09-16 02:20:52'),
(112, 'App\\Models\\User', 8, 'auth_token', 'd7b9763eaf32109a8733f2aba9f91056e3e3a9437ccec8f6a395043604583bff', '[\"*\"]', NULL, NULL, '2026-09-16 02:20:53', '2026-09-16 02:20:53'),
(113, 'App\\Models\\User', 8, 'auth_token', 'ce040e706834c96ed4da110c018df81d407637d7200f688b706d262130e96c47', '[\"*\"]', '2026-09-16 06:34:57', NULL, '2026-09-16 02:34:20', '2026-09-16 06:34:57'),
(114, 'App\\Models\\User', 8, 'auth_token', '73aa639aa4360510385f1731c923161360934e31954fa780c9434be9b7e3c745', '[\"*\"]', '2026-09-16 08:25:20', NULL, '2026-09-16 06:37:20', '2026-09-16 08:25:20'),
(115, 'App\\Models\\User', 5, 'admin_token', '7797f1a7507b657e3facb0b5e0436b85781a62a88f4fc2f6161c64a3d47bb8a5', '[\"*\"]', '2026-09-16 11:24:36', NULL, '2026-09-16 07:04:20', '2026-09-16 11:24:36'),
(116, 'App\\Models\\User', 8, 'auth_token', '3ca3644be9def946c8d41c6047f08a193fce4836919c4430047a002d714c1b06', '[\"*\"]', NULL, NULL, '2026-09-16 08:28:51', '2026-09-16 08:28:51'),
(117, 'App\\Models\\User', 8, 'auth_token', '50f5ef7057c9c92a983a0756ac58ba8b106766c116ca443574a68488ee5cf018', '[\"*\"]', NULL, NULL, '2026-09-16 08:29:02', '2026-09-16 08:29:02'),
(118, 'App\\Models\\User', 8, 'auth_token', '9cc95ff226e7381d6251abec5f360e7183dd1e388154613fb024ce158da3decf', '[\"*\"]', '2026-09-16 08:36:36', NULL, '2026-09-16 08:29:12', '2026-09-16 08:36:36'),
(119, 'App\\Models\\User', 8, 'auth_token', 'c9c699e5799a5726ab7ade3f88e86b1c84ab9c44d73a749d6a5bff410b977b6e', '[\"*\"]', '2026-09-16 08:40:32', NULL, '2026-09-16 08:30:44', '2026-09-16 08:40:32'),
(120, 'App\\Models\\User', 8, 'auth_token', 'e71406c5e54859ba4394ec6211caf32bb4a4d82c162a53bf949a77fc2bc67d3c', '[\"*\"]', NULL, NULL, '2026-09-16 08:35:09', '2026-09-16 08:35:09'),
(121, 'App\\Models\\User', 8, 'auth_token', '119c862de1be0edc59045f24bf5dfefeccf15d8853ac53f652cb14eacb9ac772', '[\"*\"]', NULL, NULL, '2026-09-16 08:42:20', '2026-09-16 08:42:20'),
(122, 'App\\Models\\User', 8, 'auth_token', 'f4441ceb8bba2d38a8fd9c2a0b043b1bf8b2fbd62a7be4a4018e95e32d53206f', '[\"*\"]', '2026-09-16 11:24:35', NULL, '2026-09-16 08:42:23', '2026-09-16 11:24:35'),
(123, 'App\\Models\\User', 8, 'auth_token', 'c8bf6fb3183f0c987b2a68144d4b0e608830267a5e744cfb66439a3964c4d4c1', '[\"*\"]', '2026-09-17 01:15:52', NULL, '2026-09-17 00:03:17', '2026-09-17 01:15:52'),
(124, 'App\\Models\\User', 5, 'admin_token', '106b5c804d4a878af9283f2412e467be4c4b583e27d59c109e6c4f0056b369a1', '[\"*\"]', '2026-09-17 09:57:56', NULL, '2026-09-17 00:13:50', '2026-09-17 09:57:56'),
(125, 'App\\Models\\User', 8, 'auth_token', '6bcf164173ffb7394c8597b7c8bc9f32bd00549e663cbc12d30f12df21e64c8f', '[\"*\"]', NULL, NULL, '2026-09-17 01:18:13', '2026-09-17 01:18:13'),
(126, 'App\\Models\\User', 8, 'auth_token', '34af125459da9afdde5d9dd542cf6f3ce68524e39e23e44eb8e79f7dbea7f880', '[\"*\"]', NULL, NULL, '2026-09-17 01:18:19', '2026-09-17 01:18:19'),
(127, 'App\\Models\\User', 8, 'auth_token', 'e0d5b4fbcc6a6ab876ae94e031a77120ee2cbbf2945ce90c138ad85ac19fd180', '[\"*\"]', NULL, NULL, '2026-09-17 01:18:20', '2026-09-17 01:18:20'),
(128, 'App\\Models\\User', 8, 'auth_token', '31cdbab9816e94d536e014f96da98a257e63fb05c31a09b3c8629b8819622d84', '[\"*\"]', '2026-09-17 05:33:04', NULL, '2026-09-17 01:18:25', '2026-09-17 05:33:04'),
(129, 'App\\Models\\User', 8, 'auth_token', 'c87c9d7d3becdf2f5b35d17e24e1cf6e2795308e332b3b655cefdc7c5100b735', '[\"*\"]', NULL, NULL, '2026-09-17 01:18:29', '2026-09-17 01:18:29'),
(130, 'App\\Models\\User', 8, 'auth_token', '95be7d9c19a5776c225ebc9d9f00fd24dcdaa05db5a47673fa10957fe9591162', '[\"*\"]', NULL, NULL, '2026-09-17 01:18:32', '2026-09-17 01:18:32'),
(131, 'App\\Models\\User', 8, 'auth_token', 'e356f536ed1af0b3dff8f0e962553dd708ca986f43eb375c7ea7ed53445ca9ec', '[\"*\"]', NULL, NULL, '2026-09-17 01:18:36', '2026-09-17 01:18:36'),
(132, 'App\\Models\\User', 8, 'auth_token', '50db246561504bb346cbb51f704f23802f3bd0ad092b5e6c1fae28b722f3485a', '[\"*\"]', NULL, NULL, '2026-09-17 01:18:38', '2026-09-17 01:18:38'),
(133, 'App\\Models\\User', 8, 'auth_token', '01bd23f658f41d6b5c5c8cdf50ee19f9713f883c13069239bb2dbc0d7fa78a9d', '[\"*\"]', NULL, NULL, '2026-09-17 01:18:40', '2026-09-17 01:18:40'),
(134, 'App\\Models\\User', 8, 'auth_token', 'c05eb566682b7ff72bd83b76054bddfb19426df12fcc0b72328132164abfd53c', '[\"*\"]', NULL, NULL, '2026-09-17 01:18:44', '2026-09-17 01:18:44'),
(135, 'App\\Models\\User', 8, 'auth_token', '1d8065efd9cf2e42d21a292b8767ad8d01b898eadec68cf897afab035f949ba9', '[\"*\"]', NULL, NULL, '2026-09-17 01:18:47', '2026-09-17 01:18:47'),
(136, 'App\\Models\\User', 8, 'auth_token', '23c251aaa739e751190b89d5ce8d3e5c5fd9225b4c4b3bc69f5e635fd11776a9', '[\"*\"]', NULL, NULL, '2026-09-17 01:18:49', '2026-09-17 01:18:49'),
(137, 'App\\Models\\User', 8, 'auth_token', 'dfb0ad368b1e28d7cd6757034d772bbd68437f9559f351f235d0636db2f700e6', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:00', '2026-09-17 01:19:00'),
(138, 'App\\Models\\User', 8, 'auth_token', 'a97b3387a13a6f2cfb86a186c864ae3d238fa639f9224d9fbe327f27eb0baaf1', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:01', '2026-09-17 01:19:01'),
(139, 'App\\Models\\User', 8, 'auth_token', '757a73aae22c8f352410b653ac63d166198bf99ba4e82c64f500fa248767ef15', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:03', '2026-09-17 01:19:03'),
(140, 'App\\Models\\User', 8, 'auth_token', 'e7c371726ba0a353e38f07dcc4f656c8c1c2ff20a59048b27c3a58967401f1c8', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:04', '2026-09-17 01:19:04'),
(141, 'App\\Models\\User', 8, 'auth_token', 'e798317d92ec52bf3e927be62acb9ffd8dbb6e027258e06f3e745a7e6a4ddff1', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:06', '2026-09-17 01:19:06'),
(142, 'App\\Models\\User', 8, 'auth_token', 'fc3e988eeae1137a0e3dcf5ca6bce6966e5d9ab8074cb48bd9cfeddffc7a1ac6', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:07', '2026-09-17 01:19:07'),
(143, 'App\\Models\\User', 8, 'auth_token', '9ecb94370a022eaecbe021bac6336f574b1edf7508098c35b2e548ff08b581ae', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:16', '2026-09-17 01:19:16'),
(144, 'App\\Models\\User', 8, 'auth_token', '9a7d57d83ab315f38262f117e6ee966055cc8c7cfb30292ac5510a8143e365c2', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:18', '2026-09-17 01:19:18'),
(145, 'App\\Models\\User', 8, 'auth_token', 'e87b2b1b6a8ba03927031f94e2c2d2cc75dac5cb91f7d9efc399320043fcd5de', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:19', '2026-09-17 01:19:19'),
(146, 'App\\Models\\User', 8, 'auth_token', '9b4099b09d27e074a1f0a73c2f1e82cc9e2b2fda09e9d73ddc845d64d8b40625', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:20', '2026-09-17 01:19:20'),
(147, 'App\\Models\\User', 8, 'auth_token', '727c476abbd938981a9bbc16fc4441819c2bcca6b6373d244ecd92631ea0d341', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:23', '2026-09-17 01:19:23'),
(148, 'App\\Models\\User', 8, 'auth_token', 'c3eb7ab9c81df22a1c1c7ca1214fe073bf99ea062b8bfa607595bdd11285a5a4', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:24', '2026-09-17 01:19:24'),
(149, 'App\\Models\\User', 8, 'auth_token', '87c7075d938b8581988b85a708c6a98e9171cde7bb81992cb00020b60e667095', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:44', '2026-09-17 01:19:44'),
(150, 'App\\Models\\User', 8, 'auth_token', '68b452c9a5fb2723670c37df3e0e1b3eb3aa526fd38c96526f1f5cfae184dab6', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:46', '2026-09-17 01:19:46'),
(151, 'App\\Models\\User', 8, 'auth_token', 'e29ab804ed69e67c953b21f7701d9ac2fa670507ce9df279b5b105943e96d8ea', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:47', '2026-09-17 01:19:47'),
(152, 'App\\Models\\User', 8, 'auth_token', '31307015c4d246bb31dc184f4c68d902c122d1305304a2a005fb5f84db8ebaa8', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:49', '2026-09-17 01:19:49'),
(153, 'App\\Models\\User', 8, 'auth_token', '651a01059bdf40743a2e27ccc739ae612c034e647aa1fad8ba00b90ab8e7663d', '[\"*\"]', NULL, NULL, '2026-09-17 01:19:50', '2026-09-17 01:19:50'),
(154, 'App\\Models\\User', 8, 'auth_token', '2ec5d81c8c25ba53c7f39d48a001b6b63c2a4a59c14f5b9f1a562a71d82e32a6', '[\"*\"]', '2026-09-17 05:34:45', NULL, '2026-09-17 05:33:28', '2026-09-17 05:34:45'),
(155, 'App\\Models\\User', 8, 'auth_token', 'd04f2bd8891c78cc357daa4de1f1a30dc283bfc9fa08de3e913b5a2cbaebe5c7', '[\"*\"]', '2026-09-17 05:35:40', NULL, '2026-09-17 05:35:33', '2026-09-17 05:35:40'),
(156, 'App\\Models\\User', 8, 'auth_token', 'c8ee2f2bcf3eba04ff6dc3b3342fa06028b96ec7524909ff3b65ca300775582b', '[\"*\"]', '2026-09-17 05:39:02', NULL, '2026-09-17 05:38:51', '2026-09-17 05:39:02'),
(157, 'App\\Models\\User', 8, 'auth_token', 'c8dea5c55cbe3aeb1b582335e014f655ba7991a8164b9efa3ef8bfde1bf72f07', '[\"*\"]', '2026-09-17 05:40:46', NULL, '2026-09-17 05:40:40', '2026-09-17 05:40:46'),
(158, 'App\\Models\\User', 8, 'auth_token', 'be83a6a4cc05b332b560ce0cccbb3381b22e3c3c3ec364a0faedfa4fd211cc5d', '[\"*\"]', '2026-09-17 05:42:48', NULL, '2026-09-17 05:42:41', '2026-09-17 05:42:48'),
(159, 'App\\Models\\User', 9, 'auth_token', '03def8b991d293fc5bcb50045e93c27127d427472d7f0cc7c0e2fd045aea491c', '[\"*\"]', NULL, NULL, '2026-09-17 05:43:33', '2026-09-17 05:43:33'),
(160, 'App\\Models\\User', 9, 'auth_token', '5c129568019f23dd824817dbdfb6bde870925e6892e24f40b300e20cc55d6171', '[\"*\"]', '2026-09-17 05:44:48', NULL, '2026-09-17 05:43:45', '2026-09-17 05:44:48'),
(161, 'App\\Models\\User', 8, 'auth_token', '41d413b6f6355b8a399f10a51db52b3ba6848ec8066e66e60038c09a02dec7e9', '[\"*\"]', '2026-09-17 09:43:11', NULL, '2026-09-17 05:45:27', '2026-09-17 09:43:11'),
(162, 'App\\Models\\User', 10, 'auth_token', 'bb208c0a70e165ac10e920b90f496024ecc4443ee7d3eca1d2c935e0b225daee', '[\"*\"]', NULL, NULL, '2026-09-17 09:43:54', '2026-09-17 09:43:54'),
(163, 'App\\Models\\User', 10, 'auth_token', 'f784758061d5c267ea44d53960734db7b2742881f64762e68c13b9f3eee69f4c', '[\"*\"]', '2026-09-17 09:49:50', NULL, '2026-09-17 09:44:04', '2026-09-17 09:49:50'),
(164, 'App\\Models\\User', 11, 'auth_token', '456c1f39d0f6e3ebeeb556e2e2892c27df41f8564bd111998a13cd36e28d7810', '[\"*\"]', NULL, NULL, '2026-09-17 09:50:29', '2026-09-17 09:50:29'),
(165, 'App\\Models\\User', 11, 'auth_token', '2b41664e7da15585e1a0056532023b127f6fd765f0c93a16665f9f1741fdf840', '[\"*\"]', '2026-09-17 09:51:26', NULL, '2026-09-17 09:51:20', '2026-09-17 09:51:26'),
(166, 'App\\Models\\User', 5, 'admin_token', 'd44dd3c7f89946cfffe3b7e05b3810a95ed79e401d283b5ca1b0c10a8d6405f5', '[\"*\"]', '2026-09-17 09:51:49', NULL, '2026-09-17 09:51:41', '2026-09-17 09:51:49'),
(167, 'App\\Models\\User', 8, 'auth_token', 'd5c4e0a1e2d6ad8c39cfc8863f8e2d31a82f840e9c5fb383ef1eb3be22ce2f24', '[\"*\"]', '2026-09-17 09:52:28', NULL, '2026-09-17 09:52:10', '2026-09-17 09:52:28'),
(168, 'App\\Models\\User', 5, 'admin_token', 'e8ea455a7a9d077da1712ba4533e61145573140f2608412cbd1f9f8c9db54117', '[\"*\"]', '2026-09-17 10:48:09', NULL, '2026-09-17 09:58:11', '2026-09-17 10:48:09'),
(169, 'App\\Models\\User', 8, 'auth_token', '0f60a630ef1d8253f610d5f858ab5317798f868c3af9168a32e8013a3b04f6d0', '[\"*\"]', '2026-09-17 10:42:43', NULL, '2026-09-17 10:12:46', '2026-09-17 10:42:43'),
(170, 'App\\Models\\User', 11, 'auth_token', '9e648090f09adb956ac6c8d64cb7df32030daceab4116c911393ad41712f32e3', '[\"*\"]', '2026-09-17 10:48:07', NULL, '2026-09-17 10:44:56', '2026-09-17 10:48:07'),
(171, 'App\\Models\\User', 8, 'auth_token', 'fdde406132ec9f1445a58d6513c182aabc440b0e384563478ca1911cf27f3516', '[\"*\"]', '2026-09-18 00:43:01', NULL, '2026-09-18 00:21:07', '2026-09-18 00:43:01'),
(172, 'App\\Models\\User', 5, 'admin_token', '124db1ccfc00925c1eff3314ed10c2b5719f06e81f5d25edd89d4f101ca57723', '[\"*\"]', '2026-09-18 08:56:06', NULL, '2026-09-18 00:36:29', '2026-09-18 08:56:06'),
(173, 'App\\Models\\User', 11, 'auth_token', '01da70ca85e331b1996459e33f5cd5f8b8236f04a4669f18c4ad2babc9fe993b', '[\"*\"]', '2026-09-18 03:52:14', NULL, '2026-09-18 00:43:30', '2026-09-18 03:52:14'),
(174, 'App\\Models\\User', 9, 'auth_token', 'fcec399c8f46fc64062d046384f4f2c57d0b81c26bf2d0da9feb274eed74a8e7', '[\"*\"]', '2026-09-18 03:52:57', NULL, '2026-09-18 03:52:37', '2026-09-18 03:52:57'),
(175, 'App\\Models\\User', 10, 'auth_token', '870de73b9387389f703d6cde0279efa024e8f0c31df643b3700067fbc33ad8e1', '[\"*\"]', '2026-09-18 04:26:56', NULL, '2026-09-18 03:53:17', '2026-09-18 04:26:56'),
(176, 'App\\Models\\User', 9, 'auth_token', '355b1d2398286fdcf609d7e663f1dea9e46331d2ab6358af6ad9a9f7c776170b', '[\"*\"]', '2026-09-18 06:26:54', NULL, '2026-09-18 04:27:31', '2026-09-18 06:26:54'),
(177, 'App\\Models\\User', 11, 'auth_token', 'c3ee0050d24d955bd2e806f036955143f9019a25fdab6a58681027e5e531e207', '[\"*\"]', NULL, NULL, '2026-09-18 06:27:40', '2026-09-18 06:27:40'),
(178, 'App\\Models\\User', 11, 'auth_token', '24a563e1fb43325b975f3e2226a923955ced17ca976d863d3d4730237e01a513', '[\"*\"]', '2026-09-18 08:09:05', NULL, '2026-09-18 06:27:53', '2026-09-18 08:09:05'),
(179, 'App\\Models\\User', 9, 'auth_token', '314f638297af0432537464a1caa7b161d3c8759f7a34e78dcafa10860f8eab60', '[\"*\"]', '2026-09-18 10:52:00', NULL, '2026-09-18 08:11:28', '2026-09-18 10:52:00'),
(180, 'App\\Models\\User', 5, 'admin_token', '8acd53e67ce8686c3cf31dbeec0fd4082c2b33375497e7ebe65bb0c415f38166', '[\"*\"]', '2026-09-18 11:01:02', NULL, '2026-09-18 10:04:44', '2026-09-18 11:01:02'),
(181, 'App\\Models\\User', 8, 'auth_token', '029d75c65fdaa72164a50451f3e7e66bb0f57f17fb95cb8865fe4ee74684b2d9', '[\"*\"]', '2026-09-18 11:01:06', NULL, '2026-09-18 11:00:39', '2026-09-18 11:01:06');

-- --------------------------------------------------------

--
-- Table structure for table `session_status`
--

CREATE TABLE `session_status` (
  `id` int(11) NOT NULL,
  `session_name` varchar(50) NOT NULL,
  `is_open` tinyint(1) DEFAULT 1,
  `open_time` datetime DEFAULT NULL,
  `close_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `session_status`
--

INSERT INTO `session_status` (`id`, `session_name`, `is_open`, `open_time`, `close_time`) VALUES
(4, '11:00 AM', 1, '2026-09-16 21:05:00', '2026-09-17 21:03:00'),
(5, '12:00 PM', 1, '2026-09-16 21:05:00', '2026-09-17 21:03:00'),
(6, '3:00 PM', 1, '2026-09-16 21:05:00', '2026-09-17 21:03:00'),
(7, '4:30 PM', 1, '2026-09-16 21:07:00', '2026-09-17 21:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `config_key` varchar(50) NOT NULL,
  `config_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`config_key`, `config_value`) VALUES
('durationSeconds', '1800'),
('endTime', '2026-09-15T23:59'),
('football_status', '1'),
('luckyAnimal', 'နဂါး'),
('phone', '999999'),
('qrUrl', 'https://res.cloudinary.com/nya4mnkw/image/upload/v1784135561/photo_2026-07-15_23-42-24_lt31yl.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `twod_bets`
--

CREATE TABLE `twod_bets` (
  `id` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT 1,
  `win_amount` decimal(10,2) DEFAULT 0.00,
  `lost` decimal(10,2) DEFAULT 0.00,
  `userId` int(11) NOT NULL,
  `userName` varchar(100) NOT NULL,
  `session` varchar(20) NOT NULL,
  `bets` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `number` varchar(10) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp(),
  `isArchived` tinyint(1) NOT NULL DEFAULT 0,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `twod_bets`
--

INSERT INTO `twod_bets` (`id`, `status`, `win_amount`, `lost`, `userId`, `userName`, `session`, `bets`, `total_amount`, `number`, `amount`, `time`, `isArchived`, `updated_at`, `created_at`, `is_open`) VALUES
(115, 1, 24000.00, 0.00, 8, 'SM', '11:00 AM', '[{\"number\":\"00\",\"amount\":300,\"status\":\"win\",\"win_amount\":24000},{\"number\":\"01\",\"amount\":300,\"status\":\"lose\",\"lost\":300},{\"number\":\"02\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"03\",\"amount\":200,\"status\":\"lose\",\"lost\":200},{\"number\":\"07\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"08\",\"amount\":100,\"status\":\"lose\",\"lost\":100}]', 1100.00, '00', 300.00, '2026-09-14 08:45:48', 0, '2026-09-14 02:15:48', '2026-09-14 02:15:48', 0),
(116, 1, 16000.00, 0.00, 8, 'SM', '12:00 PM', '[{\"number\":\"00\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"01\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"02\",\"amount\":200,\"status\":\"win\",\"win_amount\":16000},{\"number\":\"03\",\"amount\":300,\"status\":\"lose\",\"lost\":300},{\"number\":\"05\",\"amount\":200,\"status\":\"lose\",\"lost\":200},{\"number\":\"10\",\"amount\":200,\"status\":\"lose\",\"lost\":200},{\"number\":\"17\",\"amount\":100,\"status\":\"lose\",\"lost\":100}]', 1200.00, '00', 100.00, '2026-09-14 08:48:36', 2, '2026-09-14 02:18:36', '2026-09-14 02:18:36', 0),
(117, 1, 22500.00, 0.00, 8, 'SM', '3:00 PM', '[{\"number\":\"00\",\"amount\":200,\"status\":\"lose\",\"lost\":200},{\"number\":\"01\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"06\",\"amount\":200,\"status\":\"lose\",\"lost\":200},{\"number\":\"13\",\"amount\":300,\"status\":\"win\",\"win_amount\":22500},{\"number\":\"18\",\"amount\":200,\"status\":\"lose\",\"lost\":200},{\"number\":\"21\",\"amount\":100,\"status\":\"lose\",\"lost\":100}]', 1100.00, '00', 200.00, '2026-09-14 08:49:03', 13, '2026-09-14 02:19:03', '2026-09-14 02:19:03', 0),
(118, 1, 24000.00, 0.00, 8, 'SM', '12:00 PM', '[{\"number\":\"00\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"01\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"02\",\"amount\":300,\"status\":\"win\",\"win_amount\":24000},{\"number\":\"06\",\"amount\":200,\"status\":\"lose\",\"lost\":200}]', 700.00, '00', 100.00, '2026-09-14 08:51:56', 2, '2026-09-14 02:21:56', '2026-09-14 02:21:56', 0),
(119, 1, 5000.00, 0.00, 8, 'SM', '4:30 PM', '[{\"number\":\"00\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"02\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"04\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"06\",\"amount\":100,\"status\":\"win\",\"win_amount\":5000},{\"number\":\"08\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"20\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"22\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"24\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"26\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"28\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"40\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"42\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"44\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"46\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"48\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"60\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"62\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"64\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"66\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"68\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"80\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"82\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"84\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"86\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"88\",\"amount\":100,\"status\":\"lose\",\"lost\":100}]', 2500.00, '00', 100.00, '2026-09-14 09:04:56', 6, '2026-09-14 02:34:56', '2026-09-14 02:34:56', 0),
(120, 2, 0.00, 200.00, 8, 'SM', '4:30 PM', '[{\"number\":\"00\",\"amount\":100,\"status\":\"lose\",\"lost\":100},{\"number\":\"01\",\"amount\":100,\"status\":\"lose\",\"lost\":100}]', 200.00, '00', 100.00, '2026-09-14 09:06:26', 6, '2026-09-14 02:36:26', '2026-09-14 02:36:26', 0),
(121, 0, 0.00, 0.00, 8, 'SM', '11:00 AM', '\"[{\\\"number\\\":\\\"16\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"27\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"38\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"49\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"05\\\",\\\"amount\\\":100}]\"', 500.00, '16', 100.00, '2026-09-15 10:25:16', 0, '2026-09-15 03:55:16', '2026-09-15 03:55:16', 1),
(122, 0, 0.00, 0.00, 8, 'SM', '4:30 PM', '\"[{\\\"number\\\":\\\"10\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"12\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"14\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"16\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"18\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"20\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"22\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"24\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"26\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"28\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"30\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"32\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"34\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"36\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"38\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"40\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"42\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"44\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"46\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"48\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"50\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"52\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"54\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"56\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"58\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"60\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"62\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"64\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"66\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"68\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"70\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"72\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"74\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"76\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"78\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"80\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"82\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"84\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"86\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"88\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"90\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"92\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"94\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"96\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"98\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"00\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"02\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"04\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"06\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"08\\\",\\\"amount\\\":100}]\"', 5000.00, '10', 100.00, '2026-09-15 10:25:54', 0, '2026-09-15 03:55:54', '2026-09-15 03:55:54', 1),
(123, 0, 0.00, 0.00, 8, 'SM', '11:00 AM', '\"[{\\\"number\\\":\\\"20\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"22\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"24\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"26\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"28\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"40\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"42\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"44\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"46\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"48\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"60\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"62\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"64\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"66\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"68\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"80\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"82\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"84\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"86\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"88\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"00\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"02\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"04\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"06\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"08\\\",\\\"amount\\\":100}]\"', 2500.00, '20', 100.00, '2026-09-15 10:40:59', 0, '2026-09-15 04:10:59', '2026-09-15 04:10:59', 1),
(124, 0, 0.00, 0.00, 8, 'SM', '11:00 AM', '\"[{\\\"number\\\":\\\"00\\\",\\\"amount\\\":1300}]\"', 1300.00, '00', 1300.00, '2026-09-15 10:53:19', 0, '2026-09-15 04:23:19', '2026-09-15 04:23:19', 1),
(125, 0, 0.00, 0.00, 8, 'SM', '11:00 AM', '\"[{\\\"number\\\":\\\"20\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"22\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"24\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"26\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"28\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"40\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"42\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"44\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"46\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"48\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"60\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"62\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"64\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"66\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"68\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"80\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"82\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"84\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"86\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"88\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"00\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"02\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"04\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"06\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"08\\\",\\\"amount\\\":100}]\"', 2500.00, '20', 100.00, '2026-09-16 05:43:46', 0, '2026-09-15 23:13:46', '2026-09-15 23:13:46', 1),
(126, 0, 0.00, 0.00, 8, 'SM', '11:00 AM', '\"[{\\\"number\\\":\\\"05\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"06\\\",\\\"amount\\\":300}]\"', 400.00, '05', 100.00, '2026-09-16 05:49:27', 0, '2026-09-15 23:19:27', '2026-09-15 23:19:27', 1),
(127, 0, 0.00, 0.00, 8, 'SM', '11:00 AM', '\"[{\\\"number\\\":\\\"20\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"22\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"24\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"26\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"28\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"40\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"42\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"44\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"46\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"48\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"60\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"62\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"64\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"66\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"68\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"80\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"82\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"84\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"86\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"88\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"00\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"02\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"04\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"06\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"08\\\",\\\"amount\\\":100}]\"', 2500.00, '20', 100.00, '2026-09-16 05:50:37', 0, '2026-09-15 23:20:37', '2026-09-15 23:20:37', 1),
(128, 0, 0.00, 0.00, 8, 'SM', '12:00 PM', '\"[{\\\"number\\\":\\\"10\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"11\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"12\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"13\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"14\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"15\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"16\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"17\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"18\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"19\\\",\\\"amount\\\":100}]\"', 1000.00, '10', 100.00, '2026-09-16 05:50:47', 0, '2026-09-15 23:20:47', '2026-09-15 23:20:47', 1),
(129, 0, 0.00, 0.00, 8, 'SM', '3:00 PM', '\"[{\\\"number\\\":\\\"50\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"61\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"72\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"83\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"94\\\",\\\"amount\\\":100}]\"', 500.00, '50', 100.00, '2026-09-16 05:50:56', 0, '2026-09-15 23:20:56', '2026-09-15 23:20:56', 1),
(130, 0, 0.00, 0.00, 8, 'SM', '4:30 PM', '\"[{\\\"number\\\":\\\"42\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"53\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"79\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"81\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"96\\\",\\\"amount\\\":100}]\"', 500.00, '42', 100.00, '2026-09-16 05:51:07', 0, '2026-09-15 23:21:07', '2026-09-15 23:21:07', 1),
(131, 0, 0.00, 0.00, 8, 'SM', '4:30 PM', '\"[{\\\"number\\\":\\\"11\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"21\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"31\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"41\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"51\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"61\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"71\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"81\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"91\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"01\\\",\\\"amount\\\":100}]\"', 1000.00, '11', 100.00, '2026-09-16 05:59:28', 0, '2026-09-15 23:29:28', '2026-09-15 23:29:28', 1),
(132, 0, 0.00, 0.00, 8, 'SM', '4:30 PM', '\"[{\\\"number\\\":\\\"11\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"13\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"15\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"17\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"19\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"21\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"23\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"25\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"27\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"29\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"31\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"33\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"35\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"37\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"39\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"41\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"43\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"45\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"47\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"49\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"51\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"57\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"59\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"61\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"63\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"65\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"67\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"69\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"71\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"73\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"75\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"77\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"79\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"81\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"83\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"85\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"87\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"89\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"91\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"93\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"95\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"97\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"99\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"01\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"03\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"05\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"07\\\",\\\"amount\\\":100},{\\\"number\\\":\\\"09\\\",\\\"amount\\\":100}]\"', 4800.00, '11', 100.00, '2026-09-16 06:44:13', 0, '2026-09-16 00:14:13', '2026-09-16 00:14:13', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `balance` decimal(15,2) DEFAULT 0.00,
  `payment` varchar(50) DEFAULT 'KBZPay',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `phone`, `pass`, `balance`, `payment`, `created_at`, `updated_at`) VALUES
(5, 'admin123@gmail.com', 'admin123', 'Admin', '', '', 0.00, 'KBZPay', '2026-09-09 08:29:40', NULL),
(6, '', '', 'KO', '99999', '$2y$12$TU2O/ZxENcw5TWsx/YE5/Ot5gzT5Dv0SY/cJfnFBMNqoNk3sQs6ku', 249300.00, 'AYA Pay', '2026-09-09 08:35:46', '2026-09-09 03:35:51'),
(7, '', '', 'MMM', '11111', '$2y$12$TU2O/ZxENcw5TWsx/YE5/Ot5gzT5Dv0SY/cJfnFBMNqoNk3sQs6ku', 76100.00, 'Wave Money', '2026-09-09 17:12:41', NULL),
(8, '', '', 'SM', '22222', '$2y$12$TU2O/ZxENcw5TWsx/YE5/Ot5gzT5Dv0SY/cJfnFBMNqoNk3sQs6ku', 230005.00, 'AYA Pay', '2026-09-12 09:35:16', '2026-09-17 10:34:12'),
(9, '', '', 'SWA', '55555', '$2y$12$TU2O/ZxENcw5TWsx/YE5/Ot5gzT5Dv0SY/cJfnFBMNqoNk3sQs6ku', 0.00, 'AYA Pay', '2026-09-17 12:13:33', NULL),
(10, '', '', 'Aung', '33333', '$2y$12$TU2O/ZxENcw5TWsx/YE5/Ot5gzT5Dv0SY/cJfnFBMNqoNk3sQs6ku', 0.00, 'AYA Pay', '2026-09-17 16:13:54', NULL),
(11, '', '', 'SWA', '44444', '$2y$12$TU2O/ZxENcw5TWsx/YE5/Ot5gzT5Dv0SY/cJfnFBMNqoNk3sQs6ku', 0.00, 'AYA Pay', '2026-09-17 16:20:29', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `football_matches`
--
ALTER TABLE `football_matches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gamefootball_bits`
--
ALTER TABLE `gamefootball_bits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game_bets`
--
ALTER TABLE `game_bets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `league_matches`
--
ALTER TABLE `league_matches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `league_name` (`league_name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_requests`
--
ALTER TABLE `payment_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `session_status`
--
ALTER TABLE `session_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`config_key`);

--
-- Indexes for table `twod_bets`
--
ALTER TABLE `twod_bets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `football_matches`
--
ALTER TABLE `football_matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `gamefootball_bits`
--
ALTER TABLE `gamefootball_bits`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `game_bets`
--
ALTER TABLE `game_bets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `league_matches`
--
ALTER TABLE `league_matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_requests`
--
ALTER TABLE `payment_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `session_status`
--
ALTER TABLE `session_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `twod_bets`
--
ALTER TABLE `twod_bets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
