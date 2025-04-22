-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 01, 2025 at 01:12 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grem`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int DEFAULT NULL,
  `review_id` int NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526CF675F31B` (`author_id`),
  KEY `IDX_9474526C3E2E969B` (`review_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `author_id`, `review_id`, `content`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 'Vitae sit voluptatum facere quibusdam in.', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(2, 1, 14, 'Et placeat velit ex ex voluptatem ex.', 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(3, 1, 4, 'Totam aut doloremque autem aut non impedit.', 'Edited', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(4, 2, 9, 'Sequi repellendus rerum incidunt ut.', 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(5, 2, 17, 'Laudantium harum magni quisquam.', 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(6, 2, 16, 'Est hic ut voluptas ut ut culpa minima.', 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(7, 3, 9, 'Esse aut officia vel consequatur nulla.', 'Edited', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(8, 3, 7, 'Veniam natus ducimus iste nihil aliquid voluptas.', 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(9, 3, 1, 'Natus consequatur soluta illo distinctio aut.', 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(10, 3, 11, 'Inventore magni accusantium ut aut.', 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(11, 3, 25, 'Optio consequatur nihil nesciunt sequi voluptas.', 'Edited', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(12, 4, 27, 'Qui cum eum dignissimos.', 'Edited', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(13, 4, 5, 'Non numquam in quo nulla dolorum eum.', 'Edited', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(14, 4, 6, 'Ut aliquam qui culpa qui sunt.', 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(15, 4, 20, 'Voluptas fuga asperiores consequuntur sed.', 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(16, 4, 1, 'Culpa ipsum facilis qui libero.', 'Edited', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(17, 4, 6, 'Pariatur ea temporibus itaque non est.', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(18, 5, 5, 'Facere fuga aliquid temporibus iusto.', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(19, 5, 26, 'Ea quo ad assumenda itaque earum eaque.', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(20, 5, 2, 'Magnam veritatis quo velit libero et sed.', 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(21, 5, 16, 'Quidem aliquid in nam est ratione aut quia.', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `developer`
--

DROP TABLE IF EXISTS `developer`;
CREATE TABLE IF NOT EXISTS `developer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `developer`
--

INSERT INTO `developer` (`id`, `title`, `slug`, `country`, `website`, `created_at`, `updated_at`) VALUES
(1, 'Austen Carter', 'austen-carter', 'France', 'http://www.williamson.com/laboriosam-cupiditate-nihil-enim-et-iste.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(2, 'Lavada Davis', 'lavada-davis', 'China', 'https://www.mante.info/totam-eveniet-nihil-error-vel-autem-rem-voluptate', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(3, 'Aliza Kreiger', 'aliza-kreiger', 'Greece', 'http://www.nikolaus.com/a-nobis-sit-repudiandae.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(4, 'Colleen Nienow', 'colleen-nienow', 'Norway', 'http://www.beier.com/ad-esse-mollitia-molestias-qui', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(5, 'Kira Emmerich', 'kira-emmerich', 'Iceland', 'http://okon.net/dignissimos-et-tenetur-quod', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(6, 'Amir Cole', 'amir-cole', 'Spain', 'http://www.homenick.com/animi-facilis-laboriosam-et-amet-possimus', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(7, 'Annabell Kshlerin', 'annabell-kshlerin', 'Argentina', 'https://www.adams.com/beatae-aut-debitis-qui-labore-debitis-aliquid-id', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(8, 'Ronny Kilback', 'ronny-kilback', 'Switzerland', 'http://www.kuhlman.biz/', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(9, 'Zachary O\'Hara', 'zachary-o-hara', 'Switzerland', 'https://schumm.com/ipsum-eveniet-et-eum-eius.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(10, 'Zaria Waelchi', 'zaria-waelchi', 'France', 'http://nienow.com/maiores-voluptas-molestias-aut-harum', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(11, 'Susie Schmitt', 'susie-schmitt', 'Cuba', 'http://greenfelder.com/quod-blanditiis-ipsa-rerum-nihil-neque-dolorem-et-aut.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(12, 'Willard Rau', 'willard-rau', 'Austria', 'http://www.schroeder.com/', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(13, 'Ervin Hettinger', 'ervin-hettinger', 'Ukraine', 'http://satterfield.biz/sit-nulla-vel-ea-id-explicabo', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(14, 'Mateo Raynor', 'mateo-raynor', 'Switzerland', 'http://okeefe.com/aut-illo-sapiente-consectetur-rem-et.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(15, 'Hilton Hagenes', 'hilton-hagenes', 'Iceland', 'http://www.ebert.com/', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(16, 'Bernard Schowalter', 'bernard-schowalter', 'China', 'http://stamm.com/et-laborum-et-est-qui-autem-impedit-omnis.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(17, 'Andre Borer', 'andre-borer', 'Japan', 'https://www.rice.com/saepe-accusantium-ut-voluptatem', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(18, 'Mckayla Thiel', 'mckayla-thiel', 'Croatia', 'http://gerhold.com/aliquid-qui-incidunt-incidunt-possimus-suscipit-perspiciatis', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(19, 'Alford Koss', 'alford-koss', 'Russia', 'http://www.hayes.com/', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(20, 'Oswaldo Dickens', 'oswaldo-dickens', 'Andorra', 'http://www.denesik.biz/molestiae-nihil-eligendi-reprehenderit-omnis-ut.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(21, 'Fidel Nitzsche', 'fidel-nitzsche', 'Monaco', 'https://www.rodriguez.com/rerum-id-voluptate-aut-voluptatem-neque-eveniet', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(22, 'Jeffery Murphy', 'jeffery-murphy', 'Andorra', 'https://www.schultz.com/debitis-aut-necessitatibus-non-quasi', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(23, 'Mabel Wisozk', 'mabel-wisozk', 'Czech Republic', 'http://www.hackett.com/repudiandae-vero-quia-voluptatem', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(24, 'Elna Yost', 'elna-yost', 'Andorra', 'https://www.davis.info/facilis-itaque-ut-temporibus-in', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(25, 'Magnus Stanton', 'magnus-stanton', 'Hungary', 'http://rutherford.com/consequatur-ut-nobis-a-minus-saepe', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(26, 'Jared Crist', 'jared-crist', 'Belgium', 'https://berge.com/excepturi-perferendis-reiciendis-qui-molestiae-non.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(27, 'Kennedi Daugherty', 'kennedi-daugherty', 'Poland', 'http://prohaska.com/earum-quidem-quidem-consectetur-impedit-excepturi-eius', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(28, 'Coy Green', 'coy-green', 'Moldova', 'http://reichel.com/quia-quibusdam-ipsa-explicabo-ut-facilis', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(29, 'Ofelia Lebsack', 'ofelia-lebsack', 'Switzerland', 'http://www.weber.com/ea-vel-tempora-earum-temporibus-occaecati.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(30, 'Rachel Jacobson', 'rachel-jacobson', 'Monaco', 'https://www.goldner.com/quisquam-sequi-aut-consequuntur-impedit-ab', '2025-04-01 13:11:13', '2025-04-01 13:11:13');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250401131023', '2025-04-01 13:10:59', 795);

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
CREATE TABLE IF NOT EXISTS `game` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `release_date_world` date DEFAULT NULL,
  `release_date_france` date DEFAULT NULL,
  `platform_requirements_level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age_rating` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` json DEFAULT NULL,
  `screenshot` json DEFAULT NULL,
  `trailer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`id`, `title`, `status`, `slug`, `content`, `summary`, `release_date_world`, `release_date_france`, `platform_requirements_level`, `age_rating`, `cover`, `language`, `screenshot`, `trailer`, `website`, `created_at`, `updated_at`) VALUES
(1, 'Quo Laborum', 'Published', 'quo-laborum', 'Nisi enim enim quo magnam sit. Architecto accusantium possimus non porro aut voluptas. Magni deserunt reiciendis perferendis ut.\n\nEst et quis non et. Aliquam itaque beatae nam voluptates et aperiam. Ipsam fuga porro laboriosam quia ut est et.\n\nMaiores magnam architecto aliquid quas vero nam fugiat. Quo ad explicabo eveniet consequatur ut necessitatibus.', 'Nisi enim enim quo magnam sit. Architecto accusantium possimus non porro aut voluptas. Magni deserunt reiciendis perferendis ut.\n\nEst et quis non et. ...', '2025-03-28', '2019-08-20', 'Low', '18+', 'cover.jpg', '[\"en\"]', NULL, NULL, 'http://www.medhurst.com/sit-ipsam-aliquam-commodi-voluptates-mollitia-in', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(2, 'Impedit Commodi', 'Published', 'impedit-commodi', 'Et perferendis maiores doloremque rerum reiciendis hic. Qui corporis quis quas aliquam voluptas est neque ratione. Id assumenda asperiores omnis labore quisquam voluptatem esse.\n\nOfficiis et eligendi vel quidem. Consequatur mollitia qui ut omnis. Itaque magnam ut unde ut doloremque explicabo consequuntur.\n\nVel omnis veritatis quis similique earum quidem. Vel beatae ab et enim quisquam suscipit voluptatem. Ut blanditiis labore ea vel.', 'Et perferendis maiores doloremque rerum reiciendis hic. Qui corporis quis quas aliquam voluptas est neque ratione. Id assumenda asperiores omnis labor...', '2016-10-21', '2017-07-10', 'Low', '18+', 'cover.jpg', '[\"ru\", \"en\"]', NULL, NULL, 'http://damore.org/ipsam-animi-cupiditate-nemo-eius', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(3, 'Quo Minima', 'Published', 'quo-minima', 'Ut ipsum odit consequatur et qui earum. Et quisquam autem eos voluptatum cumque. Voluptatibus blanditiis ullam officiis quidem.\n\nIllo sit facilis ut placeat magni quisquam rerum. Eum nobis quibusdam eius quos quia ratione ipsa nostrum. Praesentium itaque quia asperiores qui illum. Sunt alias voluptas hic ut et deleniti. Est et sed quis sunt.\n\nRerum quia reiciendis facere laboriosam cum qui. Rem dolor consequatur repellendus veniam atque ex. Consectetur et tempore numquam totam eum blanditiis numquam. Laboriosam illum dolor rerum velit officiis.', 'Ut ipsum odit consequatur et qui earum. Et quisquam autem eos voluptatum cumque. Voluptatibus blanditiis ullam officiis quidem.\n\nIllo sit facilis ut p...', '2016-08-28', '2015-05-30', 'Low', '16+', 'cover.jpg', '[\"ru\", \"en\"]', NULL, NULL, 'http://koepp.com/', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(4, 'Quisquam Nemo', 'Published', 'quisquam-nemo', 'At aut rerum voluptatem. Maxime recusandae voluptates aliquid beatae ex. Atque sit beatae dolorem aperiam accusamus reiciendis cupiditate. At eum maxime sit aliquid recusandae eligendi.\n\nEst sit et enim sit. Necessitatibus error facere inventore officia et ut qui.\n\nQuo est earum quisquam est. Sed occaecati voluptas recusandae et iusto. Magni ut autem sit laudantium facilis reiciendis sint. Quis inventore eveniet animi qui.', 'At aut rerum voluptatem. Maxime recusandae voluptates aliquid beatae ex. Atque sit beatae dolorem aperiam accusamus reiciendis cupiditate. At eum maxi...', '2016-01-04', '2019-08-13', 'Medium', '18+', 'cover.jpg', '[\"ru\"]', NULL, NULL, 'https://www.kuvalis.com/in-laudantium-eveniet-quaerat-nesciunt-pariatur-dolorum-repudiandae', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(5, 'Molestiae Tenetur', 'Published', 'molestiae-tenetur', 'Sint velit earum nam omnis quidem. Sed voluptatem est ratione minima. Sapiente voluptatum quibusdam in magnam eum perspiciatis sit cumque. Qui commodi blanditiis quaerat voluptatem earum.\n\nVelit minima cum harum quia blanditiis perferendis. In ut dolore id consectetur et quis hic. Suscipit voluptas ut eveniet.\n\nEt et maiores et omnis. Asperiores laboriosam non modi ratione. Qui molestiae aliquid ipsa et laboriosam aut cumque amet.', 'Sint velit earum nam omnis quidem. Sed voluptatem est ratione minima. Sapiente voluptatum quibusdam in magnam eum perspiciatis sit cumque. Qui commodi...', '2017-06-07', '2022-11-12', 'High', '3+', 'cover.jpg', '[\"en\", \"fr\", \"ru\"]', NULL, NULL, 'http://herman.com/dicta-hic-cupiditate-quae-qui-iusto', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(6, 'Voluptatem Porro', 'Published', 'voluptatem-porro', 'Dolorem ab amet reprehenderit id. Cumque nesciunt aut voluptatem voluptas expedita enim enim voluptates. Quod et temporibus molestias rerum veritatis dolorem assumenda in. Eum enim voluptas ea facere delectus repudiandae sunt.\n\nItaque laboriosam et laudantium ea dolores provident cum. Accusantium numquam inventore eos illum saepe qui nobis. Eveniet ut eos vero et. Expedita magni aut voluptates itaque consequuntur. Explicabo reprehenderit ipsa ea distinctio voluptates.\n\nSit aliquam nostrum animi hic ut qui. Qui sint necessitatibus rem. Dolorem unde error et perspiciatis tempore doloribus sunt. Itaque tempore non est repellat.', 'Dolorem ab amet reprehenderit id. Cumque nesciunt aut voluptatem voluptas expedita enim enim voluptates. Quod et temporibus molestias rerum veritatis ...', '2015-07-09', '2022-11-05', 'Low', '3+', 'cover.jpg', '[\"ru\", \"en\"]', NULL, NULL, 'https://www.feeney.com/eaque-itaque-eos-qui-voluptates-totam', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(7, 'Beatae Suscipit', 'Published', 'beatae-suscipit', 'Consectetur ullam quas facere delectus numquam aliquid delectus quod. Blanditiis neque tenetur ullam blanditiis. Eum magni illum maiores ut nobis. Excepturi aut labore porro voluptates ea ab laborum.\n\nQuam at error quaerat voluptas non. Ad numquam est dolore. Et repellat dignissimos tempora et.\n\nEst aspernatur et nostrum omnis consectetur quia non. Et quam aut corporis provident maxime est. Sit harum ut aut est eaque quae.', 'Consectetur ullam quas facere delectus numquam aliquid delectus quod. Blanditiis neque tenetur ullam blanditiis. Eum magni illum maiores ut nobis. Exc...', '2023-03-14', '2017-11-12', 'Medium', '16+', 'cover.jpg', '[\"ru\", \"fr\", \"en\"]', NULL, NULL, 'http://www.halvorson.com/porro-odio-consequatur-maiores-distinctio-non-eaque-assumenda', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(8, 'Est Dolore', 'Published', 'est-dolore', 'Optio nihil culpa nemo enim deserunt ea. Quaerat veritatis quaerat veritatis quae illum earum. Fugiat et quidem inventore nesciunt deserunt quia. Nostrum at mollitia id ipsam eaque reiciendis ut repudiandae.\n\nEa et aut accusamus rerum enim eos. Non vitae velit harum sequi. Ab omnis veritatis fuga provident sit ducimus.\n\nEa maiores sit cupiditate non exercitationem necessitatibus. Vero pariatur sit hic dolorum sunt ducimus. Similique ratione in ut soluta numquam qui et. Ut nostrum cumque fuga necessitatibus cupiditate.', 'Optio nihil culpa nemo enim deserunt ea. Quaerat veritatis quaerat veritatis quae illum earum. Fugiat et quidem inventore nesciunt deserunt quia. Nost...', '2020-11-19', '2023-10-31', 'Medium', '7+', 'cover.jpg', '[\"ru\"]', NULL, NULL, 'http://www.parisian.com/ipsum-molestias-qui-deserunt-doloremque-nulla-sapiente-et', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(9, 'Non Qui', 'Published', 'non-qui', 'Eos ut delectus id sed. Aperiam est rerum non dolorem. Velit voluptatibus et rerum reprehenderit.\n\nVoluptate ipsum et eveniet aut et voluptate praesentium. Nobis consequatur nulla voluptatum sed doloremque vitae.\n\nHic neque nesciunt dolor maxime. Odit maxime est consequatur voluptas perferendis corporis modi. Eos et est temporibus accusamus totam provident. Earum enim magni quam natus ipsam architecto.', 'Eos ut delectus id sed. Aperiam est rerum non dolorem. Velit voluptatibus et rerum reprehenderit.\n\nVoluptate ipsum et eveniet aut et voluptate praesen...', '2023-12-19', '2018-03-05', 'Medium', '16+', 'cover.jpg', '[\"en\", \"ru\"]', NULL, NULL, 'http://www.durgan.info/eveniet-aut-quidem-doloribus-ipsa-pariatur-autem', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(10, 'Ratione Excepturi', 'Published', 'ratione-excepturi', 'Fugit explicabo enim amet dolorum dolorem non qui. Dolor et sequi praesentium perferendis iusto. Ab sunt quibusdam voluptatem repudiandae. Totam nemo et magni ut autem.\n\nAnimi in error quae hic et labore quas. Et et ipsam enim animi exercitationem. Id alias explicabo labore eum quod eius suscipit et. Quo facilis minus qui.\n\nConsectetur veniam velit et. Aliquam omnis eveniet corporis. Officiis voluptatem labore eos voluptatibus et praesentium non. Nobis reprehenderit at doloribus placeat est veniam harum.', 'Fugit explicabo enim amet dolorum dolorem non qui. Dolor et sequi praesentium perferendis iusto. Ab sunt quibusdam voluptatem repudiandae. Totam nemo ...', '2020-05-20', '2015-09-05', 'Medium', '3+', 'cover.jpg', '[\"ru\"]', NULL, NULL, 'http://kuhlman.com/', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(11, 'Saepe Quod', 'Published', 'saepe-quod', 'Perspiciatis ut quis ut sequi. Sed ut voluptates perferendis rerum. Amet suscipit molestias vitae iure quos accusamus.\n\nAut ratione qui aliquid quis saepe vero accusantium. Dignissimos quis voluptatem eveniet ut. Eligendi consequatur quaerat id dolores earum quia rerum. Placeat nam occaecati facilis voluptatem illo libero.\n\nVoluptatum cupiditate molestiae illum dolorum explicabo at et quia. Quia exercitationem consequatur consectetur expedita debitis repellat placeat.', 'Perspiciatis ut quis ut sequi. Sed ut voluptates perferendis rerum. Amet suscipit molestias vitae iure quos accusamus.\n\nAut ratione qui aliquid quis s...', '2017-06-13', '2015-09-25', 'Low', '3+', 'cover.jpg', '[\"fr\", \"en\"]', NULL, NULL, 'http://www.powlowski.org/facilis-nisi-necessitatibus-est-aut-sed', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(12, 'Rerum Aperiam', 'Published', 'rerum-aperiam', 'Quae et possimus dolor est occaecati porro. Libero iure impedit ad modi ut provident mollitia. Tenetur corrupti itaque rerum laudantium maxime impedit ut.\n\nVoluptas ad eum dolores est culpa. Ipsa cumque nam et dolores ut ut et est. Corrupti officiis laborum alias quia itaque. Sunt dolorum quo voluptas sequi id modi.\n\nQuasi consequatur et minima ab. Aut magni iste ullam. Dicta in ipsam ut quae. Consequatur voluptatem deserunt repudiandae accusantium. Nihil animi vel quo optio ut pariatur.', 'Quae et possimus dolor est occaecati porro. Libero iure impedit ad modi ut provident mollitia. Tenetur corrupti itaque rerum laudantium maxime impedit...', '2019-01-19', '2024-01-21', 'High', '16+', 'cover.jpg', '[\"ru\"]', NULL, NULL, 'http://www.marquardt.biz/dolor-est-quae-dolore-ut.html', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(13, 'Ipsam Ut', 'Published', 'ipsam-ut', 'Culpa illum sed id quia quia facere. Velit aut et unde distinctio nesciunt rerum. Ut fugiat qui consequuntur repellat corporis.\n\nVeniam impedit sunt placeat veniam esse sit aliquam. Praesentium dolor adipisci et sed expedita sint qui.\n\nRecusandae ut nostrum omnis aspernatur asperiores quaerat cupiditate. Libero debitis laborum velit recusandae et deserunt. Ut perferendis iste molestiae sit non reprehenderit.', 'Culpa illum sed id quia quia facere. Velit aut et unde distinctio nesciunt rerum. Ut fugiat qui consequuntur repellat corporis.\n\nVeniam impedit sunt p...', '2023-10-02', '2019-08-08', 'Medium', '16+', 'cover.jpg', '[\"fr\", \"en\", \"ru\"]', NULL, NULL, 'http://www.runolfsdottir.biz/molestiae-ut-quam-ipsam-iusto-optio-repellendus-qui', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(14, 'Necessitatibus Maiores', 'Published', 'necessitatibus-maiores', 'Soluta fugiat praesentium hic voluptatem beatae. Dolore praesentium fugiat minima. Labore quis pariatur quod inventore et amet consequatur. Debitis beatae est aliquid harum voluptas in. Id tempora placeat laudantium sed nihil ipsa.\n\nDoloremque quia dolore maxime quia optio tempora ipsam. Id ab eius molestiae recusandae quas. Incidunt et quibusdam maxime.\n\nLaudantium natus modi minima natus qui. Facere et saepe exercitationem voluptas quia est.', 'Soluta fugiat praesentium hic voluptatem beatae. Dolore praesentium fugiat minima. Labore quis pariatur quod inventore et amet consequatur. Debitis be...', '2025-03-10', '2015-12-16', 'Low', '12+', 'cover.jpg', '[\"en\"]', NULL, NULL, 'http://ward.org/nam-est-quo-similique-facilis-quia-dolorem.html', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(15, 'Voluptatem Qui', 'Published', 'voluptatem-qui', 'Itaque reiciendis sit at ad. Debitis veritatis facere ipsam necessitatibus illum. Et placeat consectetur ut voluptatem dolore.\n\nNumquam iure molestias voluptatem velit nulla deserunt. Quia tempore sequi molestiae molestiae quis. Quo exercitationem temporibus voluptatem aut maiores optio doloremque.\n\nQuaerat reprehenderit deleniti enim sed. Ducimus repudiandae in ipsum accusamus. Quidem et repellendus qui sint soluta doloremque voluptas aut.', 'Itaque reiciendis sit at ad. Debitis veritatis facere ipsam necessitatibus illum. Et placeat consectetur ut voluptatem dolore.\n\nNumquam iure molestias...', '2022-08-13', '2025-02-17', 'Medium', '12+', 'cover.jpg', '[\"en\", \"ru\", \"fr\"]', NULL, NULL, 'http://abbott.com/', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(16, 'Ea Amet', 'Published', 'ea-amet', 'Quia veritatis architecto voluptas vel odit ut. Repudiandae similique voluptatum consequatur sapiente voluptatem nesciunt accusamus. Delectus reiciendis et facilis velit. Qui ea id veniam minus. Et fugit cupiditate quia rerum numquam omnis.\n\nCulpa consequatur repellendus et aut amet. Id odit cumque sapiente architecto vitae nobis. Qui harum voluptatem temporibus provident vel. Animi quisquam quasi a alias odio est. In sint vitae tenetur blanditiis.\n\nInventore in ut laboriosam rerum quis. Aspernatur consequatur impedit voluptas nostrum. Ea voluptatem adipisci commodi vel. Ullam aliquam repellat sed impedit voluptatem.', 'Quia veritatis architecto voluptas vel odit ut. Repudiandae similique voluptatum consequatur sapiente voluptatem nesciunt accusamus. Delectus reiciend...', '2019-05-10', '2023-12-18', 'Medium', '18+', 'cover.jpg', '[\"fr\", \"ru\"]', NULL, NULL, 'http://turner.com/', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(17, 'Pariatur Totam', 'Published', 'pariatur-totam', 'Consequatur ea consectetur a non eum sint sit ullam. Voluptatem hic temporibus dolorem dolor qui magni. Ipsum et odio sed enim odit error sint rerum.\n\nDeserunt placeat sint voluptates adipisci quos quis. Qui libero at porro ut suscipit quo et. Est facilis et fuga illo facere sit consequatur. Expedita praesentium cumque necessitatibus et eveniet a nihil. Error esse eveniet et.\n\nSit laborum vel distinctio perferendis deserunt. Est autem beatae explicabo temporibus. Placeat mollitia qui minima cumque. Temporibus rem suscipit provident nulla illo quia adipisci modi.', 'Consequatur ea consectetur a non eum sint sit ullam. Voluptatem hic temporibus dolorem dolor qui magni. Ipsum et odio sed enim odit error sint rerum.\n...', '2021-07-20', '2023-10-31', 'Low', '7+', 'cover.jpg', '[\"fr\", \"ru\", \"en\"]', NULL, NULL, 'http://koch.com/', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(18, 'Dicta Voluptatum', 'Published', 'dicta-voluptatum', 'Eius excepturi aut accusamus consequatur quia. Quasi eos est est repellendus. Asperiores porro est harum harum. Eius vitae laborum nam quod temporibus rerum.\n\nLaborum dolorum quia quia non est aperiam saepe qui. Et aliquid repudiandae provident aut.\n\nDolor vitae quia ex eveniet facilis quidem illo. Qui et explicabo dolorum molestias placeat ut. Cupiditate omnis qui sit ut quos aut.', 'Eius excepturi aut accusamus consequatur quia. Quasi eos est est repellendus. Asperiores porro est harum harum. Eius vitae laborum nam quod temporibus...', '2018-01-12', '2019-03-08', 'Low', '12+', 'cover.jpg', '[\"ru\", \"fr\"]', NULL, NULL, 'https://hackett.com/asperiores-architecto-aperiam-esse-fugit-rerum.html', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(19, 'Quisquam Nulla', 'Published', 'quisquam-nulla', 'Sed distinctio repellat dignissimos ad architecto quis. Eum quae est placeat adipisci doloremque labore quia. Numquam aut est enim magni et.\n\nTemporibus modi non animi est et expedita. Itaque eos est molestiae. Ut iusto et soluta et.\n\nDolorem ea aut et quas aut ad velit. Nostrum qui eaque quaerat debitis ea autem. Qui laudantium nulla consequatur dolorum sapiente id voluptas.', 'Sed distinctio repellat dignissimos ad architecto quis. Eum quae est placeat adipisci doloremque labore quia. Numquam aut est enim magni et.\n\nTemporib...', '2020-06-04', '2022-12-07', 'Low', '16+', 'cover.jpg', '[\"fr\"]', NULL, NULL, 'http://goodwin.com/dolorum-et-accusamus-dolor-rerum-amet-qui', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(20, 'Reiciendis Officia', 'Published', 'reiciendis-officia', 'Adipisci nulla quo suscipit ab vel. Error harum beatae deserunt vitae earum qui. Et illum qui itaque vitae. Optio excepturi est aut consequatur labore laborum accusamus repellendus.\n\nNumquam adipisci quas commodi quas rerum officia. Minus praesentium ut laudantium assumenda. Voluptatibus sed natus iste eaque deserunt non.\n\nQuis numquam molestiae repudiandae tempora voluptates omnis inventore. Dignissimos cupiditate unde porro odit facilis exercitationem quia. Alias et itaque est architecto unde et qui fuga.', 'Adipisci nulla quo suscipit ab vel. Error harum beatae deserunt vitae earum qui. Et illum qui itaque vitae. Optio excepturi est aut consequatur labore...', '2021-05-14', '2023-03-16', 'High', '3+', 'cover.jpg', '[\"ru\", \"en\"]', NULL, NULL, 'http://www.krajcik.com/', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(21, 'Dolorem Fugit', 'Published', 'dolorem-fugit', 'In aut id dolor quidem at. Nulla corporis suscipit ullam enim quo doloribus aliquam. Assumenda earum saepe ut aliquid. Suscipit quia libero minus eveniet.\n\nRecusandae iste debitis quo occaecati et aperiam. Quam dicta repudiandae velit omnis consequuntur quidem aut. Consequatur rem et ut atque blanditiis. Non debitis eos et molestiae officia numquam maiores.\n\nIncidunt recusandae aut nostrum odio culpa. Non molestiae voluptatem delectus et aut autem. Facilis sapiente delectus dolor assumenda. Sapiente voluptatem et incidunt voluptatum.', 'In aut id dolor quidem at. Nulla corporis suscipit ullam enim quo doloribus aliquam. Assumenda earum saepe ut aliquid. Suscipit quia libero minus even...', '2016-11-09', '2020-08-03', 'Medium', '18+', 'cover.jpg', '[\"en\", \"ru\", \"fr\"]', NULL, NULL, 'http://www.lemke.com/ad-iusto-cupiditate-blanditiis-sint-maxime', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(22, 'Omnis Temporibus', 'Published', 'omnis-temporibus', 'Repellendus sint qui velit optio quos sit provident voluptate. Repellendus rerum sit non dolor minus et est. Voluptatem autem recusandae sunt pariatur voluptatum quos.\n\nRepellat dolorem id dolor. Accusantium distinctio qui nulla vitae minima. Dolorem perferendis nemo voluptatibus voluptatem vero nihil. Et corporis pariatur fugit labore accusantium.\n\nFuga itaque commodi itaque beatae modi vero. Sapiente harum nihil maiores voluptate at. Ad sapiente adipisci at.', 'Repellendus sint qui velit optio quos sit provident voluptate. Repellendus rerum sit non dolor minus et est. Voluptatem autem recusandae sunt pariatur...', '2021-07-29', '2018-05-13', 'High', '18+', 'cover.jpg', '[\"ru\", \"fr\", \"en\"]', NULL, NULL, 'http://stamm.com/voluptas-omnis-aperiam-architecto-tempora-voluptates', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(23, 'Earum Et', 'Deleted', 'earum-et', 'Ab explicabo aperiam dicta in omnis possimus recusandae. Corrupti et perferendis iusto architecto et sed aut ut. Saepe vel asperiores quae.\n\nDoloremque ut vel quia aut deserunt voluptates. Natus iste est error. Tempora facilis animi consequatur magnam voluptates.\n\nQui temporibus explicabo nulla autem iusto magnam et. Aut sequi doloribus inventore consequatur fuga eius et. Qui voluptates dolore provident dolor. Aut nam illo necessitatibus fugiat.', 'Ab explicabo aperiam dicta in omnis possimus recusandae. Corrupti et perferendis iusto architecto et sed aut ut. Saepe vel asperiores quae.\n\nDoloremqu...', '2020-09-27', '2016-11-06', 'Low', '16+', 'cover.jpg', '[\"en\", \"fr\", \"ru\"]', NULL, NULL, 'https://cassin.com/non-cupiditate-eum-quis-non-accusamus.html', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(24, 'Quo Labore', 'Draft', 'quo-labore', 'Aut beatae neque reprehenderit aut facere eveniet quia. Illo quaerat ipsa voluptatum quisquam quia. Molestiae possimus voluptatibus itaque consequatur aut quia officia. Ea sapiente quia eveniet officia maxime voluptatum autem.\n\nSit illo occaecati magni vel eius asperiores. Sapiente molestiae commodi veniam voluptatem molestias eaque. Ut quia eum animi sit voluptatem. Suscipit aperiam illo dolor aut.\n\nDistinctio voluptates sequi voluptatem quia. Ratione nostrum est voluptas omnis. A dolore quod non temporibus consequuntur. Consectetur deleniti culpa et ut architecto eveniet.', 'Aut beatae neque reprehenderit aut facere eveniet quia. Illo quaerat ipsa voluptatum quisquam quia. Molestiae possimus voluptatibus itaque consequatur...', '2021-12-04', '2022-12-05', 'Low', '3+', 'cover.jpg', '[\"ru\", \"en\", \"fr\"]', NULL, NULL, 'https://gutkowski.com/accusamus-necessitatibus-at-rerum-quidem-saepe-tenetur-minima.html', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(25, 'Nemo Nisi', 'Archived', 'nemo-nisi', 'In exercitationem reprehenderit voluptatum repudiandae rerum. Hic magnam praesentium quis qui dignissimos eos. Corrupti excepturi est tenetur deleniti. Deserunt quis aliquid eveniet eveniet doloremque reprehenderit. Debitis tempora qui autem quod.\n\nNesciunt esse porro aliquid vitae saepe. Veniam non in optio veniam nesciunt corrupti. Sed dolorem ipsum sunt totam deleniti facere.\n\nQuas deleniti cupiditate et natus voluptas debitis. Nihil dicta consequatur sed nihil et sunt nihil. Eum ut modi facilis.', 'In exercitationem reprehenderit voluptatum repudiandae rerum. Hic magnam praesentium quis qui dignissimos eos. Corrupti excepturi est tenetur deleniti...', '2018-06-01', '2024-08-05', 'High', '18+', 'cover.jpg', '[\"ru\", \"en\"]', NULL, NULL, 'https://www.hahn.net/laboriosam-dolores-necessitatibus-distinctio-et', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(26, 'Est Tempora', 'Deleted', 'est-tempora', 'Ut blanditiis labore et deserunt. Cum doloremque vero quaerat numquam. Nulla esse nemo natus doloribus ratione placeat sit. Ut natus veniam nemo suscipit aliquid labore ut. Harum labore consectetur voluptatem.\n\nDoloremque perferendis et est. Est dolore enim molestias dolores voluptatem illo tenetur voluptas. Beatae maiores et et saepe illo ipsam similique.\n\nAdipisci tenetur dolores sunt voluptate. Quis qui non dolor voluptates. Voluptate ab ab hic ut velit.', 'Ut blanditiis labore et deserunt. Cum doloremque vero quaerat numquam. Nulla esse nemo natus doloribus ratione placeat sit. Ut natus veniam nemo susci...', '2019-11-16', '2017-03-29', 'Low', '18+', 'cover.jpg', '[\"en\"]', NULL, NULL, 'http://www.pouros.com/aliquid-unde-laudantium-sapiente', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(27, 'Dolor Sunt', 'Draft', 'dolor-sunt', 'Quia illum iure qui qui suscipit. Explicabo quo facilis animi quisquam aut commodi. Assumenda voluptas molestiae porro dolor magni beatae sequi.\n\nSaepe in minima nobis vitae qui ab. Tenetur tempore omnis ea similique aut fuga pariatur. Perferendis modi assumenda voluptatem quis temporibus aliquid quo. Pariatur quam occaecati velit consectetur dolor voluptatem.\n\nDolorem eligendi voluptatem numquam animi. Est sed corrupti consectetur voluptatem qui quam. Voluptas quidem necessitatibus eligendi quia est.', 'Quia illum iure qui qui suscipit. Explicabo quo facilis animi quisquam aut commodi. Assumenda voluptas molestiae porro dolor magni beatae sequi.\n\nSaep...', '2024-11-29', '2020-08-12', 'High', '3+', 'cover.jpg', '[\"en\"]', NULL, NULL, 'http://jast.com/veniam-ut-enim-sit-ea-rem-et-quia', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(28, 'Alias Voluptatem', 'Archived', 'alias-voluptatem', 'Qui dolor autem vitae aut dolor. Qui et non impedit nam nam.\n\nEsse aperiam repellendus dolores maiores distinctio accusamus iusto. Soluta iusto est corporis vitae quibusdam et. Molestiae sit quasi pariatur quia sit nostrum. Earum aliquam a a cumque nam hic omnis.\n\nExcepturi et molestiae dolorem qui aperiam non voluptas. Est vel eveniet architecto praesentium. Est eveniet repellat ducimus.', 'Qui dolor autem vitae aut dolor. Qui et non impedit nam nam.\n\nEsse aperiam repellendus dolores maiores distinctio accusamus iusto. Soluta iusto est co...', '2023-04-12', '2022-07-09', 'Medium', '12+', 'cover.jpg', '[\"fr\", \"en\", \"ru\"]', NULL, NULL, 'http://ward.com/libero-quos-necessitatibus-sed-sit-repellat', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(29, 'Assumenda Saepe', 'Draft', 'assumenda-saepe', 'Asperiores dolor quis et alias ut. Voluptatem omnis doloremque et ad. Voluptatibus reprehenderit nostrum ipsum accusamus perferendis nihil molestiae.\n\nMolestiae et velit aut esse quia neque. Id reprehenderit maxime voluptas quod. Eveniet asperiores aut in aut voluptas quis. Hic quis exercitationem tempora error.\n\nAliquam ut consectetur officiis. Voluptas laboriosam et distinctio quo quas commodi sed.', 'Asperiores dolor quis et alias ut. Voluptatem omnis doloremque et ad. Voluptatibus reprehenderit nostrum ipsum accusamus perferendis nihil molestiae.\n...', '2018-09-28', '2015-09-12', 'Low', '7+', 'cover.jpg', '[\"en\"]', NULL, NULL, 'http://www.zieme.com/nesciunt-sit-dignissimos-sapiente-cum', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(30, 'Soluta Laudantium', 'Archived', 'soluta-laudantium', 'Aut sint qui omnis saepe nemo dolores. Sapiente dolorum et molestiae magni. Sint est eveniet veritatis ea.\n\nPlaceat consequatur nisi perspiciatis ipsam quis sit neque qui. Inventore nihil voluptatem ut pariatur illo ipsum rem. Nostrum doloribus dolorem ea voluptatibus voluptas assumenda. Suscipit molestiae at eum animi voluptate tenetur architecto.\n\nFuga rerum fugiat quod provident dignissimos consectetur voluptatem. Tempore a maxime voluptates sunt ullam ipsum omnis. Qui sit rerum labore est illo quod.', 'Aut sint qui omnis saepe nemo dolores. Sapiente dolorum et molestiae magni. Sint est eveniet veritatis ea.\n\nPlaceat consequatur nisi perspiciatis ipsa...', '2024-05-26', '2024-10-23', 'Low', '16+', 'cover.jpg', '[\"fr\", \"ru\"]', NULL, NULL, 'http://ward.com/quia-facilis-ducimus-in-maxime-vero-ut-odit.html', '2025-04-01 13:11:15', '2025-04-01 13:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `game_developer`
--

DROP TABLE IF EXISTS `game_developer`;
CREATE TABLE IF NOT EXISTS `game_developer` (
  `game_id` int NOT NULL,
  `developer_id` int NOT NULL,
  PRIMARY KEY (`game_id`,`developer_id`),
  KEY `IDX_B75D4A98E48FD905` (`game_id`),
  KEY `IDX_B75D4A9864DD9267` (`developer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game_developer`
--

INSERT INTO `game_developer` (`game_id`, `developer_id`) VALUES
(1, 20),
(2, 17),
(3, 14),
(3, 20),
(4, 9),
(5, 3),
(5, 19),
(6, 4),
(6, 23),
(6, 26),
(7, 6),
(8, 6),
(8, 9),
(9, 7),
(9, 17),
(9, 23),
(10, 11),
(10, 20),
(10, 30),
(11, 4),
(12, 10),
(12, 17),
(13, 4),
(13, 24),
(14, 4),
(14, 7),
(14, 29),
(15, 29),
(16, 20),
(16, 29),
(17, 19),
(18, 23),
(19, 25),
(19, 29),
(20, 21),
(20, 27),
(21, 8),
(21, 16),
(21, 29),
(22, 2),
(22, 4),
(23, 5),
(23, 18),
(23, 19),
(24, 14),
(24, 19),
(24, 22),
(25, 8),
(25, 19),
(25, 21),
(26, 12),
(26, 16),
(26, 22),
(27, 5),
(27, 13),
(27, 22),
(28, 9),
(28, 20),
(29, 8),
(29, 19),
(29, 24),
(30, 11),
(30, 16);

-- --------------------------------------------------------

--
-- Table structure for table `game_genre`
--

DROP TABLE IF EXISTS `game_genre`;
CREATE TABLE IF NOT EXISTS `game_genre` (
  `game_id` int NOT NULL,
  `genre_id` int NOT NULL,
  PRIMARY KEY (`game_id`,`genre_id`),
  KEY `IDX_B1634A77E48FD905` (`game_id`),
  KEY `IDX_B1634A774296D31F` (`genre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game_genre`
--

INSERT INTO `game_genre` (`game_id`, `genre_id`) VALUES
(1, 3),
(1, 5),
(2, 9),
(2, 10),
(3, 1),
(3, 5),
(3, 7),
(4, 2),
(4, 5),
(5, 6),
(6, 2),
(6, 4),
(6, 8),
(7, 3),
(7, 4),
(8, 1),
(9, 7),
(10, 10),
(11, 6),
(12, 6),
(12, 9),
(12, 10),
(13, 2),
(14, 4),
(14, 5),
(14, 9),
(15, 4),
(15, 5),
(15, 8),
(16, 2),
(17, 1),
(17, 10),
(18, 4),
(19, 5),
(19, 9),
(20, 6),
(21, 1),
(21, 9),
(21, 10),
(22, 6),
(22, 8),
(22, 10),
(23, 1),
(23, 5),
(23, 8),
(24, 10),
(25, 9),
(25, 10),
(26, 10),
(27, 7),
(27, 10),
(28, 3),
(28, 4),
(28, 5),
(29, 2),
(29, 5),
(29, 6),
(30, 8);

-- --------------------------------------------------------

--
-- Table structure for table `game_news`
--

DROP TABLE IF EXISTS `game_news`;
CREATE TABLE IF NOT EXISTS `game_news` (
  `game_id` int NOT NULL,
  `news_id` int NOT NULL,
  PRIMARY KEY (`game_id`,`news_id`),
  KEY `IDX_F6C6F57CE48FD905` (`game_id`),
  KEY `IDX_F6C6F57CB5A459A0` (`news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game_news`
--

INSERT INTO `game_news` (`game_id`, `news_id`) VALUES
(1, 5),
(2, 1),
(2, 6),
(2, 16),
(3, 27),
(4, 3),
(4, 11),
(4, 14),
(4, 21),
(5, 5),
(5, 16),
(5, 18),
(5, 26),
(6, 8),
(6, 28),
(7, 3),
(7, 19),
(8, 13),
(8, 30),
(9, 30),
(10, 2),
(10, 12),
(11, 10),
(11, 17),
(11, 24),
(12, 2),
(12, 6),
(12, 9),
(12, 15),
(13, 14),
(13, 23),
(13, 29),
(14, 8),
(14, 21),
(14, 23),
(14, 27),
(15, 17),
(15, 18),
(16, 25),
(17, 5),
(17, 16),
(17, 29),
(18, 9),
(18, 20),
(18, 29),
(18, 30),
(19, 15),
(19, 26),
(20, 7),
(23, 3),
(24, 22),
(25, 6),
(25, 20),
(26, 20),
(27, 1),
(27, 13),
(27, 19),
(27, 21),
(28, 13),
(28, 18),
(29, 4),
(30, 19),
(30, 24);

-- --------------------------------------------------------

--
-- Table structure for table `game_platform`
--

DROP TABLE IF EXISTS `game_platform`;
CREATE TABLE IF NOT EXISTS `game_platform` (
  `game_id` int NOT NULL,
  `platform_id` int NOT NULL,
  PRIMARY KEY (`game_id`,`platform_id`),
  KEY `IDX_92162FEDE48FD905` (`game_id`),
  KEY `IDX_92162FEDFFE6496F` (`platform_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game_platform`
--

INSERT INTO `game_platform` (`game_id`, `platform_id`) VALUES
(1, 9),
(2, 4),
(2, 8),
(2, 10),
(3, 1),
(3, 7),
(3, 8),
(4, 4),
(4, 6),
(4, 10),
(5, 5),
(6, 9),
(7, 2),
(7, 3),
(7, 5),
(8, 5),
(8, 10),
(9, 4),
(9, 5),
(10, 6),
(10, 7),
(10, 10),
(11, 9),
(12, 7),
(12, 10),
(13, 2),
(14, 3),
(14, 7),
(15, 3),
(16, 4),
(17, 1),
(18, 2),
(18, 4),
(18, 8),
(19, 9),
(19, 10),
(20, 1),
(21, 2),
(22, 2),
(22, 4),
(22, 7),
(23, 1),
(23, 8),
(24, 3),
(24, 8),
(24, 10),
(25, 1),
(25, 5),
(26, 2),
(27, 4),
(27, 5),
(27, 9),
(28, 10),
(29, 5),
(29, 6),
(29, 9),
(30, 3),
(30, 4),
(30, 8);

-- --------------------------------------------------------

--
-- Table structure for table `game_publisher`
--

DROP TABLE IF EXISTS `game_publisher`;
CREATE TABLE IF NOT EXISTS `game_publisher` (
  `game_id` int NOT NULL,
  `publisher_id` int NOT NULL,
  PRIMARY KEY (`game_id`,`publisher_id`),
  KEY `IDX_4E4E1444E48FD905` (`game_id`),
  KEY `IDX_4E4E144440C86FCE` (`publisher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game_publisher`
--

INSERT INTO `game_publisher` (`game_id`, `publisher_id`) VALUES
(1, 17),
(1, 27),
(1, 29),
(2, 19),
(2, 23),
(3, 13),
(3, 20),
(4, 18),
(4, 28),
(5, 8),
(6, 9),
(6, 10),
(7, 19),
(7, 23),
(7, 24),
(8, 30),
(9, 3),
(10, 8),
(11, 3),
(11, 12),
(11, 22),
(12, 4),
(12, 5),
(12, 22),
(13, 4),
(13, 7),
(13, 20),
(14, 2),
(14, 4),
(14, 11),
(15, 19),
(16, 20),
(16, 25),
(17, 23),
(17, 25),
(18, 14),
(18, 23),
(18, 30),
(19, 8),
(19, 17),
(20, 15),
(21, 2),
(21, 15),
(21, 26),
(22, 1),
(22, 13),
(22, 25),
(23, 7),
(23, 18),
(23, 22),
(24, 5),
(24, 21),
(24, 28),
(25, 18),
(25, 27),
(26, 8),
(26, 14),
(27, 11),
(28, 8),
(28, 16),
(28, 22),
(29, 4),
(29, 16),
(29, 26),
(30, 3),
(30, 5),
(30, 18);

-- --------------------------------------------------------

--
-- Table structure for table `game_review`
--

DROP TABLE IF EXISTS `game_review`;
CREATE TABLE IF NOT EXISTS `game_review` (
  `game_id` int NOT NULL,
  `review_id` int NOT NULL,
  PRIMARY KEY (`game_id`,`review_id`),
  KEY `IDX_4762C0EE48FD905` (`game_id`),
  KEY `IDX_4762C0E3E2E969B` (`review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `game_review`
--

INSERT INTO `game_review` (`game_id`, `review_id`) VALUES
(1, 8),
(2, 12),
(2, 17),
(2, 28),
(3, 6),
(3, 15),
(3, 19),
(3, 24),
(4, 6),
(4, 10),
(4, 22),
(4, 29),
(5, 1),
(7, 5),
(7, 14),
(9, 13),
(9, 29),
(10, 4),
(10, 30),
(11, 9),
(11, 23),
(11, 25),
(11, 26),
(12, 9),
(13, 1),
(13, 28),
(14, 3),
(14, 17),
(15, 2),
(15, 7),
(15, 16),
(16, 9),
(16, 10),
(16, 20),
(17, 24),
(19, 2),
(19, 3),
(19, 7),
(19, 18),
(19, 19),
(19, 28),
(20, 11),
(20, 16),
(20, 27),
(21, 10),
(22, 12),
(22, 13),
(23, 1),
(24, 17),
(24, 23),
(25, 21),
(26, 5),
(27, 4),
(27, 13),
(28, 5),
(28, 6),
(28, 7),
(28, 16),
(30, 8),
(30, 14);

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`id`, `title`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Action', 'action', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(2, 'Adventure', 'adventure', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(3, 'RPG', 'rpg', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(4, 'Shooter', 'shooter', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(5, 'Fighting', 'fighting', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(6, 'Strategy', 'strategy', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(7, 'Simulation', 'simulation', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(8, 'Sports', 'sports', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(9, 'Puzzle', 'puzzle', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(10, 'Horror', 'horror', '2025-04-01 13:11:13', '2025-04-01 13:11:13');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
CREATE TABLE IF NOT EXISTS `news` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_1DD39950F675F31B` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `author_id`, `title`, `slug`, `content`, `summary`, `cover`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Consequatur Fugiat Animi Unde Voluptatibus Et Quod', 'consequatur-fugiat-animi-unde-voluptatibus-et-quod', 'Sed aut eos vel nostrum debitis architecto assumenda. Voluptas est nam impedit dolor sint. Sunt ad sequi quia et aperiam et.\n\nAssumenda aut iure porro error iusto. Vitae voluptatum facere quis nemo sit aut fuga. Eligendi aut debitis quam eos consequatur quos.\n\nRem accusantium qui earum maxime qui consequuntur. Ad incidunt ex voluptatibus velit debitis. Dolor sed ullam hic et quia voluptatem quae inventore.', 'Sed aut eos vel nostrum debitis architecto assumenda. Voluptas est nam impedit dolor sint. Sunt ad sequi quia et aperiam et.\n\nAssumenda aut iure porro...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(2, 3, 'Recusandae Accusamus Deleniti Numquam Aliquam Ab Dolorem Incidunt', 'recusandae-accusamus-deleniti-numquam-aliquam-ab-dolorem-incidunt', 'Est molestias quo odio culpa rerum repellat. Consectetur et et aut. Aperiam eveniet quia dolorem debitis sequi ab expedita. Eius sed nisi dolorem vel earum.\n\nIllum culpa ex molestias nemo sit. Cum perspiciatis omnis dolores qui dolores autem tempore. Sed a illum sit ab quis eos unde. Inventore aut iure eveniet qui. Quasi omnis sunt nemo velit ratione facilis quia.\n\nFugiat aperiam quia ut dolores voluptas. Nam aut doloremque repellendus corporis. Sed quibusdam cum sit deserunt. Sint cum et maiores perferendis.', 'Est molestias quo odio culpa rerum repellat. Consectetur et et aut. Aperiam eveniet quia dolorem debitis sequi ab expedita. Eius sed nisi dolorem vel ...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(3, 5, 'Reprehenderit Nisi Ratione Et Distinctio Aspernatur Facere Doloremque Enim', 'reprehenderit-nisi-ratione-et-distinctio-aspernatur-facere-doloremque-enim', 'Ut id dicta amet totam est suscipit quos culpa. Repellendus provident laudantium labore ipsum libero impedit adipisci impedit. Voluptatem dolores qui ad quis.\n\nReiciendis ut dicta nihil qui cum. Et quam in eum aut non culpa nemo. Aut rerum distinctio et et ullam error qui. Omnis non cum autem quia enim doloremque. Nam laborum et eveniet quae laborum similique consequuntur numquam.\n\nOmnis aliquid ratione repellendus suscipit aperiam ducimus praesentium. Est sequi ab veritatis repudiandae. Deserunt sed repellat sit vel.', 'Ut id dicta amet totam est suscipit quos culpa. Repellendus provident laudantium labore ipsum libero impedit adipisci impedit. Voluptatem dolores qui ...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(4, 1, 'Quia In Maiores Debitis Alias Inventore', 'quia-in-maiores-debitis-alias-inventore', 'Consectetur non dignissimos consectetur maiores sequi quisquam cumque. Sit iste facilis soluta voluptatem quidem cum nisi.\n\nDolores itaque deleniti consequatur reprehenderit et ea et. Est nihil natus est aut. Ad cupiditate rem voluptatem occaecati ratione deleniti. Et quos quae aut.\n\nVoluptatem facilis iusto totam laborum dolorem voluptatem qui voluptatem. Sint nihil rerum tempora et iusto sequi minus. Totam et et dolor ea.', 'Consectetur non dignissimos consectetur maiores sequi quisquam cumque. Sit iste facilis soluta voluptatem quidem cum nisi.\n\nDolores itaque deleniti co...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(5, 4, 'Odio Voluptas Optio Et Eum Aut Accusantium Sed Aut', 'odio-voluptas-optio-et-eum-aut-accusantium-sed-aut', 'Omnis dolore sunt ratione culpa. Et vel suscipit ut quis iste. Mollitia porro quia quia adipisci sint voluptate quasi. Nemo facilis pariatur qui iusto non.\n\nDolores saepe veritatis vero. Amet et qui magni et. Recusandae enim nihil id sit error nihil maiores. Tempora enim quidem vero esse similique laudantium nihil.\n\nQuod ut est aperiam doloremque iste consectetur facilis. Perferendis odio consequuntur nesciunt tempore. Atque accusantium qui quis non libero velit. Aut libero dolores dolor eveniet.', 'Omnis dolore sunt ratione culpa. Et vel suscipit ut quis iste. Mollitia porro quia quia adipisci sint voluptate quasi. Nemo facilis pariatur qui iusto...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(6, 1, 'Voluptas Fugit Eos Sunt Quod', 'voluptas-fugit-eos-sunt-quod', 'Repellat dolorem ipsam vel. Tempora hic nihil laborum nisi inventore. Soluta voluptates nobis omnis eius quia aperiam.\n\nSint fuga non pariatur. Fugiat est voluptates quia facere quaerat. Suscipit animi similique reprehenderit recusandae dolor et.\n\nRecusandae nulla tenetur deserunt recusandae. Ut expedita enim magni tenetur ut. Dolores labore qui est dolores sed autem. Odit aperiam tempora ab quasi.', 'Repellat dolorem ipsam vel. Tempora hic nihil laborum nisi inventore. Soluta voluptates nobis omnis eius quia aperiam.\n\nSint fuga non pariatur. Fugiat...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(7, 4, 'Dignissimos Aspernatur Molestiae Nemo', 'dignissimos-aspernatur-molestiae-nemo', 'Sunt consequatur eligendi at aliquid assumenda reprehenderit vitae. Eveniet nobis assumenda cum laboriosam.\n\nDolorem et quos dolore nulla voluptatem. Illum officia suscipit in. Sequi vero voluptas enim aliquam ut voluptatem error.\n\nEx omnis ab et ut at. Nisi ad totam ducimus at. Ipsam sit aut et et exercitationem. Facilis veniam quod harum sunt officiis et. Reprehenderit numquam molestiae est quasi repudiandae rerum aut.', 'Sunt consequatur eligendi at aliquid assumenda reprehenderit vitae. Eveniet nobis assumenda cum laboriosam.\n\nDolorem et quos dolore nulla voluptatem. ...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(8, 4, 'Ea Consequuntur Corrupti Quae Rerum Sit Occaecati', 'ea-consequuntur-corrupti-quae-rerum-sit-occaecati', 'Ipsa provident voluptatem autem sapiente perferendis sunt esse. A accusamus et placeat aut et. Aliquid labore fugit inventore unde nobis commodi cumque.\n\nSunt ut eveniet blanditiis rerum aperiam quasi fuga dolorem. Rerum nulla aut distinctio odit. Delectus porro voluptas quis. Voluptatem omnis rem ipsam est nobis maiores.\n\nQuisquam est quia ut at. Facilis fugit quia perspiciatis eligendi officia ea aut. Quia sunt molestias iusto ut voluptatum. Ut dolorem doloribus aut hic voluptatibus.', 'Ipsa provident voluptatem autem sapiente perferendis sunt esse. A accusamus et placeat aut et. Aliquid labore fugit inventore unde nobis commodi cumqu...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(9, 2, 'Maiores Iure Ut Enim Maiores Similique', 'maiores-iure-ut-enim-maiores-similique', 'Est alias voluptates odio officiis. Fuga inventore nemo sed non quaerat laudantium. Dolor ipsa similique sed reprehenderit placeat velit placeat.\n\nEnim excepturi id eum et. Quia minus quo occaecati et vel fugiat nisi. Facilis maxime earum sed.\n\nNatus quae numquam fugiat iusto aspernatur odit aut at. Repellat magnam minus aut voluptatum eligendi aspernatur mollitia. Harum voluptas distinctio tempora iusto nostrum. Doloremque facere voluptas at.', 'Est alias voluptates odio officiis. Fuga inventore nemo sed non quaerat laudantium. Dolor ipsa similique sed reprehenderit placeat velit placeat.\n\nEni...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(10, 3, 'Necessitatibus Sit Magnam Quia Quia', 'necessitatibus-sit-magnam-quia-quia', 'Explicabo error illo qui. Deserunt qui ea vitae nulla. Corrupti nihil a eum aut quibusdam. Optio reprehenderit iusto harum maiores.\n\nCorrupti culpa fuga sequi ea. Eius suscipit laudantium qui dolorem magni laudantium id. Odit rem odit aut rerum.\n\nMinus a quo odio nobis reprehenderit eum. Totam earum error asperiores enim suscipit et facilis exercitationem. Est dolores dolorem maxime doloremque in aliquid beatae minus.', 'Explicabo error illo qui. Deserunt qui ea vitae nulla. Corrupti nihil a eum aut quibusdam. Optio reprehenderit iusto harum maiores.\n\nCorrupti culpa fu...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(11, 4, 'Aut Asperiores Dolores Vitae Id Aut Aperiam Dolor', 'aut-asperiores-dolores-vitae-id-aut-aperiam-dolor', 'Rerum adipisci quam qui aut velit. Earum quo explicabo saepe reprehenderit asperiores deserunt. Nostrum cupiditate odit quas corporis. Odit sed voluptas enim ad necessitatibus vitae quidem.\n\nQuas voluptate voluptates vel a qui. Soluta vel ducimus repudiandae iure quibusdam. Quia quod fugiat atque laboriosam dolor minima. Et voluptatem atque quae aliquam excepturi.\n\nNon autem illum ut sunt molestiae id nostrum. Ut labore qui nemo laborum. Nulla occaecati quasi quia praesentium corporis.', 'Rerum adipisci quam qui aut velit. Earum quo explicabo saepe reprehenderit asperiores deserunt. Nostrum cupiditate odit quas corporis. Odit sed volupt...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(12, 2, 'Dolorem Pariatur Qui Error', 'dolorem-pariatur-qui-error', 'Repudiandae odit consequatur veniam voluptas ut tempore voluptatem sunt. Laudantium non in aspernatur non nam accusantium. Velit architecto error quos repellat quidem culpa. Rem assumenda temporibus in animi.\n\nVoluptatem commodi doloremque vitae assumenda asperiores omnis cum asperiores. Aut deserunt reiciendis nostrum exercitationem at doloremque. Nulla rerum est repellendus sed officiis repellendus in.\n\nEius ad quia ad. Sed dolorem inventore eos et minus architecto illum omnis.', 'Repudiandae odit consequatur veniam voluptas ut tempore voluptatem sunt. Laudantium non in aspernatur non nam accusantium. Velit architecto error quos...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(13, 3, 'Voluptatibus Unde Repellat Minima Doloribus', 'voluptatibus-unde-repellat-minima-doloribus', 'Natus officiis error ut molestiae ducimus cum suscipit. Possimus expedita reiciendis fuga quam molestiae occaecati. Quasi ex assumenda qui aut laboriosam ratione.\n\nFacilis et culpa nulla iste earum non. Ipsum nam est quae sunt fugit eius. Beatae quam ut autem et vitae cupiditate.\n\nVoluptatibus omnis voluptatem quia delectus sapiente quidem et. Sed provident ut totam ex doloribus quod. Et libero deleniti voluptatum repellendus magni deleniti nobis.', 'Natus officiis error ut molestiae ducimus cum suscipit. Possimus expedita reiciendis fuga quam molestiae occaecati. Quasi ex assumenda qui aut laborio...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(14, 1, 'Repellat Natus Quia Sit Laborum Ipsam Quidem Aut', 'repellat-natus-quia-sit-laborum-ipsam-quidem-aut', 'Consequatur in est neque repellat ad. Doloribus et esse error iure et eum. Distinctio rerum placeat recusandae porro incidunt suscipit eos. Eveniet ipsam architecto sed est quidem in neque autem.\n\nSequi sit aspernatur sequi voluptates ipsum. Natus sit et cupiditate ad.\n\nOmnis consequuntur qui id. Et ut nulla perferendis excepturi eum sit est. Aut autem sunt sit voluptas. Deserunt magni debitis eius aut harum itaque.', 'Consequatur in est neque repellat ad. Doloribus et esse error iure et eum. Distinctio rerum placeat recusandae porro incidunt suscipit eos. Eveniet ip...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(15, 1, 'Ea Doloribus Porro Mollitia Est', 'ea-doloribus-porro-mollitia-est', 'Facilis ipsam iusto sit dignissimos eum rem. Dolore velit maxime ut. Enim quas dicta dignissimos rerum debitis.\n\nNatus sed accusantium quod harum accusantium. Enim et accusamus quam officia vitae dolorem. A reiciendis dolorem similique fugiat consequatur molestiae quod.\n\nNihil sed sunt ullam temporibus aut architecto. Placeat natus mollitia consectetur. Alias iure natus qui velit qui voluptatem quibusdam.', 'Facilis ipsam iusto sit dignissimos eum rem. Dolore velit maxime ut. Enim quas dicta dignissimos rerum debitis.\n\nNatus sed accusantium quod harum accu...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(16, 2, 'Blanditiis Occaecati Sint Eum Id Blanditiis Voluptates Aliquam Culpa', 'blanditiis-occaecati-sint-eum-id-blanditiis-voluptates-aliquam-culpa', 'Et minima soluta sit excepturi culpa rerum fugit. Rerum blanditiis quia vel in libero maiores. Rerum eum consequatur sit in.\n\nId omnis aut dolor minima tempora reprehenderit cupiditate. Omnis eveniet nihil porro sed. Alias suscipit voluptatem in id facilis perspiciatis sit. Dolorem voluptate voluptates dolor eius. Porro et velit magni voluptas.\n\nEius omnis reiciendis veniam minus. Numquam assumenda autem maxime est. Et nemo iste quae ea id ut deleniti officia. Fuga incidunt et aut qui.', 'Et minima soluta sit excepturi culpa rerum fugit. Rerum blanditiis quia vel in libero maiores. Rerum eum consequatur sit in.\n\nId omnis aut dolor minim...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(17, 2, 'Illum Omnis Eos Quod Molestiae Itaque Ab', 'illum-omnis-eos-quod-molestiae-itaque-ab', 'Est saepe exercitationem nam odit voluptas voluptas. Minima omnis adipisci quos nihil neque qui fuga. Quam sint dolores modi non ea fugiat quos. Aliquam dolor totam sunt et cum dicta pariatur.\n\nIllum et quia pariatur pariatur atque voluptas. Ut mollitia quidem maxime repellendus. Ut pariatur aut itaque est unde eaque aliquam. Ex dicta aut iste. Neque sit amet sequi est perferendis voluptatum maxime vel.\n\nQuidem quis doloremque eveniet voluptate harum laboriosam fugit eligendi. Libero ut sit necessitatibus placeat iste blanditiis.', 'Est saepe exercitationem nam odit voluptas voluptas. Minima omnis adipisci quos nihil neque qui fuga. Quam sint dolores modi non ea fugiat quos. Aliqu...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(18, 2, 'Quia Ullam Voluptatem Maiores Sed Quaerat Quas', 'quia-ullam-voluptatem-maiores-sed-quaerat-quas', 'Molestiae in voluptatem fuga delectus dolores voluptate. Ducimus corporis consequatur atque voluptas optio odio aliquid. Fugiat aliquid qui ratione quis. Aliquam aut ea dolores dolor officiis doloremque nihil ad.\n\nEligendi veniam dolor eum. Culpa est aspernatur iste totam velit vero. Autem veritatis voluptas nemo dolorem assumenda. Qui iste voluptates cumque quasi reiciendis eaque.\n\nVoluptas saepe exercitationem et ipsum vel. Facilis ut amet dolor sit repudiandae.', 'Molestiae in voluptatem fuga delectus dolores voluptate. Ducimus corporis consequatur atque voluptas optio odio aliquid. Fugiat aliquid qui ratione qu...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(19, 3, 'Non Quia Et Harum Porro Cum Officia Eos', 'non-quia-et-harum-porro-cum-officia-eos', 'Corrupti enim dolorem quisquam quasi consequatur. Numquam cupiditate accusantium placeat corrupti necessitatibus. Praesentium minus ratione quae dolor laudantium neque consequatur.\n\nAut quam sapiente tempora recusandae. Placeat perferendis omnis consequuntur ratione. Qui iure quos enim et et dolore ut.\n\nRerum nulla error unde hic. Voluptatem unde consequatur eligendi sed molestias quia iure. Minus ut rerum odio omnis ea ab nihil sapiente.', 'Corrupti enim dolorem quisquam quasi consequatur. Numquam cupiditate accusantium placeat corrupti necessitatibus. Praesentium minus ratione quae dolor...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(20, 1, 'Sed Harum Et Commodi Quia Nam Dolores Numquam', 'sed-harum-et-commodi-quia-nam-dolores-numquam', 'Ut esse ab eum dolor quisquam. Praesentium dignissimos eos fuga facilis. Voluptatem rerum magnam ut eaque. Natus rerum recusandae fuga ut. Eos voluptas voluptas sint a ab.\n\nOdio dolorum facilis commodi rerum. Culpa in magni eum quis voluptates voluptas. Aut aut unde illum molestias necessitatibus dolores. Ipsa eos similique est culpa placeat omnis.\n\nDolor hic doloribus incidunt neque nulla dolor adipisci consequatur. Voluptatem voluptatibus eaque asperiores. Ipsum aut distinctio animi blanditiis pariatur.', 'Ut esse ab eum dolor quisquam. Praesentium dignissimos eos fuga facilis. Voluptatem rerum magnam ut eaque. Natus rerum recusandae fuga ut. Eos volupta...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(21, 3, 'Itaque Animi Ut Et Aut Iure Facere', 'itaque-animi-ut-et-aut-iure-facere', 'Voluptatem molestiae omnis quasi provident recusandae. Aspernatur qui eligendi velit. Quasi similique perferendis qui.\n\nQuas molestias magni sapiente reiciendis repudiandae ut voluptatum magni. In consequatur et numquam qui dolor iusto est. Fugiat maiores modi consequatur perspiciatis. Non id ipsum atque et nemo.\n\nItaque accusamus sed nihil voluptatem quas provident iusto. Aut vel voluptas alias amet non ipsum aliquid. Quisquam reiciendis autem libero numquam.', 'Voluptatem molestiae omnis quasi provident recusandae. Aspernatur qui eligendi velit. Quasi similique perferendis qui.\n\nQuas molestias magni sapiente ...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(22, 4, 'Repellat Explicabo Et Perspiciatis Earum', 'repellat-explicabo-et-perspiciatis-earum', 'Quia qui molestias facilis quaerat expedita sunt accusantium. In consequatur asperiores sunt explicabo. Officia et earum voluptas minus. Consequatur quisquam eligendi quos eveniet deserunt corporis. Ipsam rerum assumenda adipisci molestias reiciendis.\n\nIusto ducimus molestiae eos aut. Suscipit ex neque eos autem asperiores velit et.\n\nVeritatis animi ad expedita libero et similique. Aut dolore dolor voluptates odit facere consectetur saepe. Tempore a quod rerum ut quis est. Omnis dolor qui beatae eaque nihil.', 'Quia qui molestias facilis quaerat expedita sunt accusantium. In consequatur asperiores sunt explicabo. Officia et earum voluptas minus. Consequatur q...', 'cover.jpg', 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(23, 5, 'Aut Vitae Alias Neque Distinctio Libero', 'aut-vitae-alias-neque-distinctio-libero', 'Delectus quo autem nam et laborum laborum nihil. Modi non fugit vel asperiores voluptatibus error. Dicta voluptas nihil cupiditate odit vel.\n\nTemporibus omnis dolore facilis nisi architecto minima enim. Porro qui quas tempora labore ullam.\n\nMollitia iure rerum ipsa dolores ut dolores error corrupti. Laboriosam dolorum saepe velit molestiae. Rerum aperiam facilis corporis ullam. Ducimus sit repellendus explicabo.', 'Delectus quo autem nam et laborum laborum nihil. Modi non fugit vel asperiores voluptatibus error. Dicta voluptas nihil cupiditate odit vel.\n\nTemporib...', 'cover.jpg', 'Draft', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(24, 3, 'Enim Sunt Hic Et Voluptatem Quos Officia Excepturi', 'enim-sunt-hic-et-voluptatem-quos-officia-excepturi', 'Voluptate vel sit ipsa. Nam sint inventore iste eaque eveniet. Et enim nisi aliquid asperiores.\n\nQuibusdam dolorem sed aut exercitationem tenetur harum iste aut. Corrupti dolorum sunt temporibus ut cumque rerum.\n\nAnimi qui tempore repellendus ut sunt ea quia praesentium. Vel sit consectetur sed ut. Accusantium ab quo voluptas suscipit delectus modi adipisci.', 'Voluptate vel sit ipsa. Nam sint inventore iste eaque eveniet. Et enim nisi aliquid asperiores.\n\nQuibusdam dolorem sed aut exercitationem tenetur haru...', 'cover.jpg', 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(25, 5, 'Beatae Ipsam Et Suscipit Et', 'beatae-ipsam-et-suscipit-et', 'Iure asperiores quos magnam est nesciunt suscipit. Earum quia eum qui nesciunt natus aperiam provident. Pariatur error officia quo nemo.\n\nDoloremque deserunt ipsa qui esse voluptatibus. Temporibus optio tempora minima perspiciatis optio in et reiciendis. Numquam saepe et non provident earum.\n\nQuod voluptatum quaerat sunt ratione sunt dolores. Esse natus sed nulla soluta. Sint quos autem praesentium.', 'Iure asperiores quos magnam est nesciunt suscipit. Earum quia eum qui nesciunt natus aperiam provident. Pariatur error officia quo nemo.\n\nDoloremque d...', 'cover.jpg', 'Archived', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(26, 4, 'Vero Mollitia Voluptatum Reiciendis Enim Minima Voluptatum Reiciendis', 'vero-mollitia-voluptatum-reiciendis-enim-minima-voluptatum-reiciendis', 'Eos deleniti tempore aut. Culpa quia cum iusto maiores placeat suscipit. Quam ratione quas alias. Minima magni voluptatem quia eveniet.\n\nNihil voluptatem esse labore inventore id nemo hic. Quod assumenda saepe dolorum ex officia. Vel esse vel amet quisquam porro consequatur neque. Et est beatae hic quod.\n\nAperiam aut reiciendis autem sit autem tempore voluptatibus. Rem rem aperiam aut cum nulla perferendis eos. Omnis commodi laboriosam odit sed consequatur repellat voluptas.', 'Eos deleniti tempore aut. Culpa quia cum iusto maiores placeat suscipit. Quam ratione quas alias. Minima magni voluptatem quia eveniet.\n\nNihil volupta...', 'cover.jpg', 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(27, 5, 'Iusto Delectus Inventore Accusamus Esse', 'iusto-delectus-inventore-accusamus-esse', 'Nostrum impedit aut odit quae non. Aliquid et iste assumenda dolores. Itaque accusamus voluptas omnis est voluptatem. Veniam animi pariatur commodi corrupti eum nostrum.\n\nEst excepturi cumque dolor dolorem temporibus quidem ut. Et provident fugiat ut cumque consequatur. Inventore sed voluptatem molestias. Commodi qui expedita ullam iusto.\n\nOptio assumenda quis repellendus omnis. Sunt et dolorum quidem perspiciatis quia vel.', 'Nostrum impedit aut odit quae non. Aliquid et iste assumenda dolores. Itaque accusamus voluptas omnis est voluptatem. Veniam animi pariatur commodi co...', 'cover.jpg', 'Draft', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(28, 5, 'Reiciendis Corporis Cupiditate Molestias Enim', 'reiciendis-corporis-cupiditate-molestias-enim', 'Temporibus distinctio placeat eaque quaerat molestias. Voluptas molestiae consequuntur nostrum maiores odit. Qui ratione consequatur harum veniam sunt quisquam incidunt. Quae omnis consequuntur nobis natus commodi molestiae pariatur.\n\nOfficia inventore eius et sunt consequuntur ducimus eum pariatur. Voluptates veniam ratione modi qui quo. Et dolores debitis aut animi temporibus sit eaque fuga.\n\nDoloribus minima qui atque beatae. Est ut quia est aperiam. Est explicabo nemo quasi ut autem quas aut.', 'Temporibus distinctio placeat eaque quaerat molestias. Voluptas molestiae consequuntur nostrum maiores odit. Qui ratione consequatur harum veniam sunt...', 'cover.jpg', 'Draft', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(29, 5, 'Recusandae Ipsa Aut Repellendus', 'recusandae-ipsa-aut-repellendus', 'Ea aut consequatur voluptatum consequuntur aliquid totam. Odit labore expedita rerum est quaerat.\n\nUt ut dolor repudiandae autem et dignissimos ducimus. Autem tempora placeat et. Repellat aliquam ipsum est qui consequatur non numquam.\n\nQui corporis aut et et placeat voluptas. Possimus in in mollitia animi autem eos saepe qui.', 'Ea aut consequatur voluptatum consequuntur aliquid totam. Odit labore expedita rerum est quaerat.\n\nUt ut dolor repudiandae autem et dignissimos ducimu...', 'cover.jpg', 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(30, 1, 'Ab Inventore Harum Autem Beatae', 'ab-inventore-harum-autem-beatae', 'Ad repudiandae quibusdam incidunt in deleniti. Facilis et nesciunt quia velit est ut. Nulla officiis dolore velit corrupti eligendi aliquid commodi illum. Culpa a eum numquam id voluptate.\n\nMinima nulla debitis quis repellendus ratione ut cupiditate quae. Natus maiores dolor placeat et. Dolorum officia debitis quis sed nemo quas.\n\nAut reprehenderit tempore adipisci voluptatum eos et. Sed omnis odit delectus placeat. Placeat omnis numquam fugiat. Minus autem laborum facilis praesentium.', 'Ad repudiandae quibusdam incidunt in deleniti. Facilis et nesciunt quia velit est ut. Nulla officiis dolore velit corrupti eligendi aliquid commodi il...', 'cover.jpg', 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `news_tag`
--

DROP TABLE IF EXISTS `news_tag`;
CREATE TABLE IF NOT EXISTS `news_tag` (
  `news_id` int NOT NULL,
  `tag_id` int NOT NULL,
  PRIMARY KEY (`news_id`,`tag_id`),
  KEY `IDX_BE3ED8A1B5A459A0` (`news_id`),
  KEY `IDX_BE3ED8A1BAD26311` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news_tag`
--

INSERT INTO `news_tag` (`news_id`, `tag_id`) VALUES
(1, 3),
(1, 13),
(2, 5),
(2, 16),
(2, 29),
(3, 1),
(3, 10),
(3, 13),
(4, 20),
(4, 30),
(5, 4),
(6, 12),
(7, 17),
(7, 24),
(8, 8),
(8, 10),
(9, 24),
(10, 9),
(10, 14),
(10, 22),
(11, 20),
(12, 9),
(12, 28),
(13, 4),
(14, 27),
(15, 7),
(15, 10),
(16, 20),
(17, 4),
(18, 9),
(18, 13),
(19, 23),
(19, 29),
(20, 18),
(21, 9),
(21, 13),
(22, 2),
(22, 20),
(22, 26),
(23, 6),
(23, 7),
(24, 8),
(24, 12),
(25, 7),
(25, 11),
(25, 17),
(26, 10),
(26, 15),
(26, 28),
(27, 9),
(27, 12),
(27, 16),
(28, 1),
(29, 5),
(29, 6),
(30, 11),
(30, 17);

-- --------------------------------------------------------

--
-- Table structure for table `platform`
--

DROP TABLE IF EXISTS `platform`;
CREATE TABLE IF NOT EXISTS `platform` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `platform`
--

INSERT INTO `platform` (`id`, `title`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'PS5', 'ps5', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(2, 'PS4', 'ps4', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(3, 'Xbox Series X/S', 'xbox-series-x-s', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(4, 'Xbox One', 'xbox-one', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(5, 'Nintendo Switch', 'nintendo-switch', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(6, 'Windows', 'windows', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(7, 'macOS', 'macos', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(8, 'Linux', 'linux', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(9, 'Android', 'android', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(10, 'iOS', 'ios', '2025-04-01 13:11:13', '2025-04-01 13:11:13');

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

DROP TABLE IF EXISTS `publisher`;
CREATE TABLE IF NOT EXISTS `publisher` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`id`, `title`, `slug`, `country`, `website`, `created_at`, `updated_at`) VALUES
(1, 'Repellat', 'repellat', 'Estonia', 'http://collier.org/odio-rerum-voluptatem-itaque-odit-sit-dolores', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(2, 'Nam', 'nam', 'Romania', 'https://ritchie.info/quia-eos-eveniet-molestias-vero-in-fuga.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(3, 'Rem', 'rem', 'Hungary', 'http://www.schultz.net/neque-aliquam-est-quibusdam-delectus-reprehenderit-ipsa', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(4, 'Rerum', 'rerum', 'Germany', 'http://www.schowalter.com/temporibus-neque-quo-odio-dolorem-ipsam-repudiandae-nisi', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(5, 'Dolorem', 'dolorem', 'Brazil', 'https://www.damore.com/quis-quis-molestiae-qui-et-iusto', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(6, 'Quod', 'quod', 'Spain', 'http://bayer.com/nesciunt-ut-ullam-veniam-in-cum.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(7, 'Officiis', 'officiis', 'Estonia', 'http://leannon.info/', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(8, 'Maiores', 'maiores', 'Andorra', 'http://www.weissnat.info/pariatur-deleniti-magnam-nulla-culpa-qui-eaque-sit-est', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(9, 'Inventore', 'inventore', 'China', 'https://terry.biz/nulla-quia-provident-vitae-tempora-soluta-vero-laborum.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(10, 'Expedita', 'expedita', 'Monaco', 'http://rolfson.com/temporibus-veritatis-omnis-quo-atque-non-perspiciatis-consequatur', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(11, 'Sapiente', 'sapiente', 'Belgium', 'https://www.homenick.biz/odit-et-at-nihil-sit-ipsam-ipsa-qui', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(12, 'Qui', 'qui', 'Chile', 'https://oconner.com/et-nobis-ullam-totam-rerum-aut-sint.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(13, 'Quis', 'quis', 'United Kingdom', 'http://oberbrunner.info/quo-optio-maxime-aut-ab-in-est.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(14, 'Velit', 'velit', 'Czech Republic', 'http://www.wilderman.org/', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(15, 'Tenetur', 'tenetur', 'Croatia', 'http://www.boyle.com/illum-soluta-qui-unde-iure-sit-culpa-rerum.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(16, 'Neque', 'neque', 'Italy', 'https://little.com/accusamus-recusandae-sint-veritatis-itaque.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(17, 'Illum', 'illum', 'Belarus', 'http://schmitt.com/voluptatem-nobis-praesentium-et-quo-omnis-officia', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(18, 'Porro', 'porro', 'Spain', 'http://www.cummerata.com/delectus-repudiandae-voluptatem-ut.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(19, 'Quos', 'quos', 'Hungary', 'https://hammes.com/eum-impedit-laborum-tempore-magni-eos-pariatur-blanditiis.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(20, 'Vero', 'vero', 'Belarus', 'http://hackett.com/qui-ad-temporibus-qui-suscipit-provident-hic-harum', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(21, 'Deleniti', 'deleniti', 'Portugal', 'https://maggio.info/occaecati-eveniet-suscipit-maiores-omnis-doloremque.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(22, 'Tempora', 'tempora', 'Norway', 'http://larson.com/', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(23, 'Quae', 'quae', 'Estonia', 'http://friesen.com/', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(24, 'Ullam', 'ullam', 'Belarus', 'http://www.yundt.com/aut-sapiente-ut-voluptatum-quaerat-pariatur-esse-non', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(25, 'Error', 'error', 'Malta', 'http://durgan.info/beatae-totam-animi-est-molestias-aut', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(26, 'Repellendus', 'repellendus', 'Romania', 'http://www.ferry.com/impedit-quia-voluptatem-laudantium-ut-repudiandae-ut-aut-sapiente.html', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(27, 'Fugiat', 'fugiat', 'Belarus', 'https://www.dach.org/nobis-molestiae-omnis-non-ut-odit', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(28, 'Perferendis', 'perferendis', 'Monaco', 'http://www.hammes.net/', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(29, 'Aut', 'aut', 'Netherlands', 'http://www.leannon.com/aliquid-delectus-id-consequuntur-voluptates-autem', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(30, 'Voluptatem', 'voluptatem', 'Belgium', 'http://www.larson.org/', '2025-04-01 13:11:13', '2025-04-01 13:11:13');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
CREATE TABLE IF NOT EXISTS `review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `summary` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `game_rating` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_794381C6F675F31B` (`author_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `author_id`, `title`, `slug`, `content`, `summary`, `cover`, `game_rating`, `status`, `created_at`, `updated_at`) VALUES
(1, 5, 'Velit Est Itaque Ut Voluptatibus Enim', 'velit-est-itaque-ut-voluptatibus-enim', 'Id blanditiis alias laborum cupiditate possimus quasi enim. Amet reiciendis ad dignissimos iusto veritatis accusamus voluptatibus non. Iure facere nihil perspiciatis dolore aliquid quia.\n\nProvident voluptates autem soluta debitis illo. Quaerat quis sed quia. Nihil dolores laboriosam nulla veritatis et voluptatem deleniti corrupti. Molestiae aspernatur tempore exercitationem ullam et.\n\nTempora dolorum quia excepturi. Rem reprehenderit quo doloribus quos nihil nemo delectus. Ut enim asperiores non et qui delectus. Aliquam impedit eaque dolorem expedita rerum non eaque.', 'Id blanditiis alias laborum cupiditate possimus quasi enim. Amet reiciendis ad dignissimos iusto veritatis accusamus voluptatibus non. Iure facere nih...', 'cover.jpg', 7, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(2, 2, 'Illum Ea Corporis Et Accusamus', 'illum-ea-corporis-et-accusamus', 'Quisquam fugiat earum molestias sunt corrupti cum. Magnam provident laborum impedit non. Incidunt officiis in omnis rerum. A voluptatem non reprehenderit aut recusandae est eum.\n\nSimilique sint est dicta aperiam et nulla consequatur. Repellendus nihil quis est in aliquid et laudantium adipisci. Est harum repellat culpa excepturi cum reprehenderit. Quibusdam facilis et expedita nulla fuga excepturi incidunt.\n\nRerum molestias dolor in voluptate repellendus nisi exercitationem dolore. Totam dolorem id similique.', 'Quisquam fugiat earum molestias sunt corrupti cum. Magnam provident laborum impedit non. Incidunt officiis in omnis rerum. A voluptatem non reprehende...', 'cover.jpg', 1, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(3, 2, 'Et Sunt At Ratione', 'et-sunt-at-ratione', 'Est quas omnis vel temporibus officia velit. Beatae cum saepe nam repellendus quod incidunt consectetur. Minus natus laborum totam.\n\nCupiditate sunt molestias atque consequuntur deleniti aut velit. Iste nam deserunt nostrum ipsum nobis numquam fuga. Minima molestiae provident et beatae beatae non.\n\nReiciendis sed perferendis sint officia. Rerum officiis est unde voluptas accusantium adipisci. Sunt sed natus non sunt quia tempora fugit. Possimus voluptatem voluptatem animi tenetur et perspiciatis sed reprehenderit.', 'Est quas omnis vel temporibus officia velit. Beatae cum saepe nam repellendus quod incidunt consectetur. Minus natus laborum totam.\n\nCupiditate sunt m...', 'cover.jpg', 8, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(4, 3, 'Dolorem Ut Perspiciatis Atque Minima Dolores Ut', 'dolorem-ut-perspiciatis-atque-minima-dolores-ut', 'Aut aspernatur id et voluptatem delectus. Perferendis excepturi et quis eos voluptatem omnis aut et. Quia deleniti necessitatibus qui quasi aliquam nulla autem. Unde quisquam corporis maiores fugiat aut rem.\n\nIn ut corrupti ipsa eius odio. Quia cupiditate cupiditate eligendi aperiam. Quas iure vel et doloribus dolorum dolorem tenetur aut. Nihil est ad sint.\n\nFuga aut possimus eveniet voluptatem. Debitis ipsam vitae repellendus ut et saepe. Aspernatur quam animi totam est sapiente numquam.', 'Aut aspernatur id et voluptatem delectus. Perferendis excepturi et quis eos voluptatem omnis aut et. Quia deleniti necessitatibus qui quasi aliquam nu...', 'cover.jpg', 4, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(5, 2, 'Alias Ad Illum Autem Reiciendis', 'alias-ad-illum-autem-reiciendis', 'Sit harum ut quos accusantium sunt nisi. Nobis ducimus cumque necessitatibus quisquam. Mollitia culpa fuga explicabo omnis aperiam repudiandae.\n\nFacere autem consequatur labore. Laboriosam et perferendis odit doloribus dicta commodi. Iusto sed dolorem quae libero. Et dolorem error facere architecto similique quaerat vel. Et quaerat rem velit est.\n\nQui ex modi quae unde sit. Ut et nostrum omnis in. Fugit est architecto porro. Error praesentium eveniet nobis et rerum.', 'Sit harum ut quos accusantium sunt nisi. Nobis ducimus cumque necessitatibus quisquam. Mollitia culpa fuga explicabo omnis aperiam repudiandae.\n\nFacer...', 'cover.jpg', 4, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(6, 5, 'Similique Repellendus Ut Reiciendis Eligendi Sed Dignissimos', 'similique-repellendus-ut-reiciendis-eligendi-sed-dignissimos', 'Nesciunt iste vel et id voluptas ut. Ratione nobis adipisci ut sint. Enim rerum eligendi quibusdam nulla dolorem. Aut fugit nisi omnis omnis.\n\nAlias odit voluptatibus temporibus qui saepe autem. Possimus doloremque reiciendis quo provident consequatur tenetur. Quis et id explicabo. Est voluptatem rerum est aut impedit. A ab ut sit.\n\nTempore officia non at consequatur. Nisi consequuntur nam quibusdam maiores. Animi magnam vel molestiae aut eos. Ut voluptatem sint ut error quam quia voluptatem est.', 'Nesciunt iste vel et id voluptas ut. Ratione nobis adipisci ut sint. Enim rerum eligendi quibusdam nulla dolorem. Aut fugit nisi omnis omnis.\n\nAlias o...', 'cover.jpg', 4, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(7, 1, 'Voluptas Quae Culpa Qui Tenetur', 'voluptas-quae-culpa-qui-tenetur', 'Aut fugiat nihil voluptate aut eos ut ut doloribus. Assumenda a et repudiandae doloribus qui. Cum doloribus libero mollitia minus quis qui. Quos eaque eum ipsam reiciendis.\n\nFacilis dignissimos debitis laborum omnis corporis cum. Ipsa quasi delectus ut consequatur. Sed ex voluptatem quia aspernatur illum omnis.\n\nEt aspernatur hic illum assumenda est ipsum. Necessitatibus aut ipsa similique veritatis voluptate temporibus. Rerum iusto impedit iure quis dolorem itaque. Cum id magni est id esse est quia.', 'Aut fugiat nihil voluptate aut eos ut ut doloribus. Assumenda a et repudiandae doloribus qui. Cum doloribus libero mollitia minus quis qui. Quos eaque...', 'cover.jpg', 1, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(8, 3, 'Officia Soluta Minima Molestiae Nisi Veniam Modi Vitae', 'officia-soluta-minima-molestiae-nisi-veniam-modi-vitae', 'Eveniet sunt enim temporibus sunt. Vitae sapiente sequi sed eum maxime ex. Qui enim iste suscipit odio minus.\n\nQuia enim iure dolor ut sunt. Et eaque consequatur error. Blanditiis omnis enim neque nisi ut sit dolor atque.\n\nVoluptates itaque maiores qui repudiandae dolores et. Ea perferendis sit autem dolorum quo at libero. Similique quia natus nisi quia dignissimos quo recusandae. Labore quia illo deleniti voluptatem et voluptatem.', 'Eveniet sunt enim temporibus sunt. Vitae sapiente sequi sed eum maxime ex. Qui enim iste suscipit odio minus.\n\nQuia enim iure dolor ut sunt. Et eaque ...', 'cover.jpg', 9, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(9, 2, 'Laborum Est Qui Quae Eum Molestias Aut', 'laborum-est-qui-quae-eum-molestias-aut', 'Debitis voluptas perspiciatis sed repellat. Mollitia architecto sed quia. Exercitationem molestias minus aut eum. Culpa quibusdam et commodi. Nihil omnis non rem esse rerum qui voluptatem culpa.\n\nProvident sint natus cumque voluptatum. Dolorem reiciendis sint aut id quia. Aliquid non quis qui quasi officia asperiores. Animi voluptatem ut voluptate vitae fugiat et voluptate.\n\nEt debitis ratione alias magni repellat tempora. Voluptatem nostrum voluptatum et dignissimos velit ab. Molestiae aliquid aliquam ea debitis rerum reprehenderit dolor. Aperiam earum earum labore qui qui ex.', 'Debitis voluptas perspiciatis sed repellat. Mollitia architecto sed quia. Exercitationem molestias minus aut eum. Culpa quibusdam et commodi. Nihil om...', 'cover.jpg', 6, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(10, 1, 'Sed Fugit Quis Quidem Et Atque Temporibus Neque Delectus', 'sed-fugit-quis-quidem-et-atque-temporibus-neque-delectus', 'Voluptatem quod hic tempora. Praesentium ratione laborum aut vero. Praesentium et magnam voluptatem eum mollitia qui ratione. Voluptates soluta ipsum amet dolorem.\n\nAt impedit quaerat voluptatem dolorem. Dignissimos non ut illo sed ducimus dolor et. Reprehenderit dolor enim repellat reprehenderit qui quis.\n\nAperiam dicta eos earum doloribus ad. Est ut et quisquam nisi voluptatum expedita in. Esse aut dolores iste ut aut dignissimos quia. Ut sint assumenda beatae similique non et.', 'Voluptatem quod hic tempora. Praesentium ratione laborum aut vero. Praesentium et magnam voluptatem eum mollitia qui ratione. Voluptates soluta ipsum ...', 'cover.jpg', 8, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(11, 2, 'Tempora Magni Unde Molestias Soluta', 'tempora-magni-unde-molestias-soluta', 'Impedit eum vero corrupti natus unde est fugiat. Incidunt dolor repudiandae a cum possimus incidunt. Ea consequatur modi officia non quia. Sapiente rerum doloribus animi excepturi.\n\nOptio iure provident tempore est excepturi. Tempore architecto quo autem rerum. Ipsa voluptatem et eos blanditiis aperiam earum qui repellat. Vitae dolorum minima cupiditate aut.\n\nNumquam perspiciatis modi ut fugiat aut id iste. Explicabo sapiente omnis nulla autem. Est quibusdam et ipsam inventore sequi ipsam rerum. Placeat est atque quam aliquam omnis at.', 'Impedit eum vero corrupti natus unde est fugiat. Incidunt dolor repudiandae a cum possimus incidunt. Ea consequatur modi officia non quia. Sapiente re...', 'cover.jpg', 8, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(12, 4, 'Autem Veritatis Repellendus A Delectus', 'autem-veritatis-repellendus-a-delectus', 'Autem iusto quod incidunt sed ex mollitia. Ex porro id quibusdam voluptate deserunt non error commodi. Nihil vitae magni voluptatibus dolore aut soluta tempore.\n\nNesciunt nesciunt qui soluta sed temporibus sunt recusandae. Suscipit esse harum earum quo aut error eum. Perspiciatis iure ut odio modi. Possimus doloremque voluptatem culpa ab aliquid.\n\nAspernatur eum et et. Ipsum voluptas sapiente vel sunt consectetur ex. Labore sit maxime officia et qui et.', 'Autem iusto quod incidunt sed ex mollitia. Ex porro id quibusdam voluptate deserunt non error commodi. Nihil vitae magni voluptatibus dolore aut solut...', 'cover.jpg', 9, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(13, 4, 'Distinctio Et Nesciunt Atque Eius Dolorem Quas', 'distinctio-et-nesciunt-atque-eius-dolorem-quas', 'Quia necessitatibus dolorem fugit numquam at quia. Tempore ut cum quidem saepe dolorem recusandae adipisci. Sunt ullam in debitis eveniet. Praesentium ipsum explicabo praesentium quo facere est non commodi.\n\nDolor voluptate rem qui quos minus inventore. Et optio et commodi. Voluptatum minima fugiat quidem eligendi quia accusamus deleniti. Quasi alias error qui reiciendis laboriosam.\n\nSed quo quis delectus quia illo. Eum ut qui illo dolores sed autem id. Cupiditate eius ut exercitationem alias in ea voluptatem enim.', 'Quia necessitatibus dolorem fugit numquam at quia. Tempore ut cum quidem saepe dolorem recusandae adipisci. Sunt ullam in debitis eveniet. Praesentium...', 'cover.jpg', 10, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(14, 2, 'Error Et Nisi Aspernatur Fugiat Nihil Consequatur Nam', 'error-et-nisi-aspernatur-fugiat-nihil-consequatur-nam', 'Et sed perferendis in hic autem accusamus eius voluptatem. Ea officiis magnam placeat consectetur velit quia accusamus.\n\nNecessitatibus iste repellendus commodi itaque laboriosam soluta incidunt. Perspiciatis perspiciatis enim sequi consequatur laboriosam consequatur. Repudiandae ducimus adipisci ad.\n\nDicta non inventore qui. Suscipit tenetur assumenda et nemo animi accusantium. Sapiente blanditiis non maiores.', 'Et sed perferendis in hic autem accusamus eius voluptatem. Ea officiis magnam placeat consectetur velit quia accusamus.\n\nNecessitatibus iste repellend...', 'cover.jpg', 5, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(15, 2, 'Quo Reprehenderit Et Repellat Ut Minus Dolorem Maiores Totam', 'quo-reprehenderit-et-repellat-ut-minus-dolorem-maiores-totam', 'Nobis omnis sed quia magnam molestias et. Nobis quibusdam et voluptates.\n\nModi optio enim molestiae. Voluptas doloribus dolore dicta enim maiores quia temporibus soluta. Sit quidem adipisci eveniet velit rerum praesentium.\n\nEos iste ut expedita vel perferendis asperiores. Maiores aut quo numquam quis sunt voluptatibus error dolores. Quidem quibusdam sequi doloribus ut impedit ipsa neque.', 'Nobis omnis sed quia magnam molestias et. Nobis quibusdam et voluptates.\n\nModi optio enim molestiae. Voluptas doloribus dolore dicta enim maiores quia...', 'cover.jpg', 3, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(16, 3, 'Facere Sunt Beatae Aut Sit', 'facere-sunt-beatae-aut-sit', 'Voluptatibus ipsam harum quia architecto rerum ut quae. Quo ab neque ea velit consectetur.\n\nOdit eligendi molestias modi voluptatem error omnis consequatur. Inventore provident pariatur ullam eum quasi maiores quod. Dolore a excepturi et. Necessitatibus velit aut sed possimus ex et.\n\nBeatae excepturi esse rerum iste consequatur veritatis dolorum. Neque aliquam mollitia sint nihil dolorum quo. Ipsam eos aperiam sint incidunt odit. Non consequatur corrupti inventore possimus explicabo labore.', 'Voluptatibus ipsam harum quia architecto rerum ut quae. Quo ab neque ea velit consectetur.\n\nOdit eligendi molestias modi voluptatem error omnis conseq...', 'cover.jpg', 3, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(17, 5, 'Esse Blanditiis Culpa Exercitationem Est Ea Et', 'esse-blanditiis-culpa-exercitationem-est-ea-et', 'Sint aperiam praesentium doloribus reiciendis consequatur nihil laborum. Enim eligendi suscipit ut porro molestias quisquam consectetur. Reprehenderit qui dolor deserunt in expedita ut aut. Sint quae dicta facere doloremque repellendus. Laboriosam consequatur porro illo aut est veniam autem.\n\nPraesentium in officia earum quo excepturi. Reiciendis et consequatur perspiciatis in. Repudiandae nemo sed adipisci aut voluptate.\n\nSed quisquam totam est modi aut. Corporis aliquid placeat aut magni. Dolor fugiat accusamus voluptate velit laudantium sed eum modi. Aut aut qui omnis rerum quos.', 'Sint aperiam praesentium doloribus reiciendis consequatur nihil laborum. Enim eligendi suscipit ut porro molestias quisquam consectetur. Reprehenderit...', 'cover.jpg', 4, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(18, 4, 'Reiciendis Sed Nihil Officiis Enim Voluptatibus Deleniti', 'reiciendis-sed-nihil-officiis-enim-voluptatibus-deleniti', 'Et suscipit dolores velit hic. Assumenda non ut numquam repellendus. Dolores natus eius molestiae voluptates sint. Laborum omnis labore necessitatibus.\n\nVelit vel assumenda illum sit molestias. Incidunt aspernatur eligendi quaerat vel quis similique nihil.\n\nEa consequatur dolores quibusdam incidunt omnis quia ex. Aperiam accusantium repellat aut odio sed repudiandae. Neque illo non id assumenda officia. Fugit voluptas et sint.', 'Et suscipit dolores velit hic. Assumenda non ut numquam repellendus. Dolores natus eius molestiae voluptates sint. Laborum omnis labore necessitatibus...', 'cover.jpg', 2, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(19, 5, 'Illum Voluptatem Ut Aut Sint Sed', 'illum-voluptatem-ut-aut-sint-sed', 'Adipisci repudiandae qui ad consequuntur autem in natus. Id omnis est voluptatem harum aperiam explicabo eius. Eaque in delectus iste eaque dolorem perspiciatis in.\n\nDolorum facere expedita harum et vel consectetur assumenda. Voluptate ipsa debitis placeat. Necessitatibus aliquam voluptatum enim.\n\nNon ipsam beatae totam non qui consequatur earum. Voluptas natus et ut omnis iusto laboriosam totam dolores. Cumque nisi sit velit optio consectetur adipisci consequatur ipsam. Et voluptatem ut rem est omnis sed. Quod explicabo sunt autem animi autem voluptates sequi.', 'Adipisci repudiandae qui ad consequuntur autem in natus. Id omnis est voluptatem harum aperiam explicabo eius. Eaque in delectus iste eaque dolorem pe...', 'cover.jpg', 9, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(20, 4, 'Ipsa Cupiditate Ipsam Perspiciatis Quis', 'ipsa-cupiditate-ipsam-perspiciatis-quis', 'Et quia est officia aut animi sed. Ab molestias officiis sit expedita tenetur pariatur. Voluptas aperiam voluptatibus voluptatem. Aut et ipsum magni sapiente ut culpa.\n\nRatione perspiciatis libero ad repudiandae nesciunt id a. Iste laudantium quaerat voluptates tenetur quasi cupiditate. Qui et laboriosam est non quas consequatur recusandae. In repellendus voluptatem accusamus ullam.\n\nRepellat aut quis vel eius eligendi et et. Rerum asperiores maiores autem ipsam soluta pariatur dolor. Saepe recusandae minima velit velit dolor. Quasi et iure adipisci corporis voluptatem pariatur similique.', 'Et quia est officia aut animi sed. Ab molestias officiis sit expedita tenetur pariatur. Voluptas aperiam voluptatibus voluptatem. Aut et ipsum magni s...', 'cover.jpg', 6, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(21, 1, 'Maiores Deserunt Qui Cum Deleniti Ratione Suscipit Reprehenderit', 'maiores-deserunt-qui-cum-deleniti-ratione-suscipit-reprehenderit', 'Quae qui voluptatem doloremque quod dolore et architecto. Consectetur maxime et consequuntur omnis tempora. Voluptates est molestias velit sed dolores quaerat et.\n\nOfficiis eius enim quo quo est reprehenderit commodi accusantium. Aut quasi quidem ut voluptatem error. Suscipit deleniti dolor tempora dolorum corrupti.\n\nFugiat ut ab ab nisi non. Repellat veniam pariatur commodi et ipsa error. Quos consequatur rerum qui iste et distinctio.', 'Quae qui voluptatem doloremque quod dolore et architecto. Consectetur maxime et consequuntur omnis tempora. Voluptates est molestias velit sed dolores...', 'cover.jpg', 5, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(22, 5, 'Ipsam Dolores Voluptas Facilis Vero Quam', 'ipsam-dolores-voluptas-facilis-vero-quam', 'Blanditiis ullam totam harum. Ipsum atque distinctio distinctio ipsa eligendi omnis veritatis. Rerum veniam nihil maxime et dignissimos sint id.\n\nFugit quod soluta ipsa qui quibusdam. Vitae mollitia ab eum vel. Dicta aut et aperiam sequi voluptas at omnis velit.\n\nEt voluptatum ut non ut assumenda. Et ducimus iure non omnis ea. Veritatis est unde sed dolore officia eius porro. Sit ipsum autem eveniet omnis.', 'Blanditiis ullam totam harum. Ipsum atque distinctio distinctio ipsa eligendi omnis veritatis. Rerum veniam nihil maxime et dignissimos sint id.\n\nFugi...', 'cover.jpg', 1, 'Published', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(23, 4, 'Qui Dicta Animi Ab Rerum Eius Id Et Quibusdam', 'qui-dicta-animi-ab-rerum-eius-id-et-quibusdam', 'Magni saepe labore quis nemo. Ut rerum velit neque ut omnis id sit.\n\nDeserunt consequatur esse ipsam sapiente laboriosam. Ea molestiae qui quam voluptas quae voluptas dolores. Et voluptates facere animi adipisci qui. Consequatur velit non autem qui ex.\n\nDebitis reiciendis quia ea at doloribus. Et nesciunt numquam odio amet quis et ut assumenda. Consequatur deserunt illo delectus ratione. Provident provident nostrum qui sequi ullam laborum quia.', 'Magni saepe labore quis nemo. Ut rerum velit neque ut omnis id sit.\n\nDeserunt consequatur esse ipsam sapiente laboriosam. Ea molestiae qui quam volupt...', 'cover.jpg', 6, 'Archived', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(24, 5, 'Suscipit Officiis Sit Assumenda Adipisci Perspiciatis Necessitatibus', 'suscipit-officiis-sit-assumenda-adipisci-perspiciatis-necessitatibus', 'Unde odio nobis dolor est corrupti voluptatem nihil. Exercitationem eos ducimus eius harum laudantium. Eligendi maxime est autem inventore perferendis accusamus.\n\nMagni commodi quo placeat ea placeat cum earum nobis. Optio ipsa eos perferendis. Est tempora ab aspernatur libero ex eos recusandae. Aspernatur error iste qui omnis et voluptates.\n\nEt delectus et aut rerum dolorem placeat esse. Earum et suscipit et labore. Velit id molestiae neque aut quibusdam.', 'Unde odio nobis dolor est corrupti voluptatem nihil. Exercitationem eos ducimus eius harum laudantium. Eligendi maxime est autem inventore perferendis...', 'cover.jpg', 5, 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(25, 4, 'Eos Vel Nihil Labore In', 'eos-vel-nihil-labore-in', 'Totam velit blanditiis veritatis. Cupiditate nulla earum iusto est. Consequatur voluptatem cupiditate rerum dignissimos nihil. Ut et aliquam et illum.\n\nAut occaecati facilis sit eius. Ex debitis autem soluta ut eligendi quos. Earum quibusdam vel expedita repellendus provident ea vitae.\n\nOmnis excepturi est pariatur praesentium. A nesciunt amet enim et rerum ad quaerat. Dolores voluptatum asperiores eos iste.', 'Totam velit blanditiis veritatis. Cupiditate nulla earum iusto est. Consequatur voluptatem cupiditate rerum dignissimos nihil. Ut et aliquam et illum....', 'cover.jpg', 10, 'Draft', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(26, 5, 'Voluptatem Sit Consequuntur Sit', 'voluptatem-sit-consequuntur-sit', 'Et sit velit expedita. Rem nihil facilis eveniet sint veniam maxime sit. Eligendi non nulla temporibus dolor.\n\nEt nisi odio vel aliquid ut id soluta dicta. Voluptatum dignissimos ut est qui aut molestiae. Ullam quisquam est dolor cupiditate et.\n\nEst ut quis aut doloribus sint quos veniam. Architecto quo vel porro omnis perferendis nam animi. Sapiente totam in rerum.', 'Et sit velit expedita. Rem nihil facilis eveniet sint veniam maxime sit. Eligendi non nulla temporibus dolor.\n\nEt nisi odio vel aliquid ut id soluta d...', 'cover.jpg', 2, 'Draft', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(27, 3, 'Molestiae Est Voluptas Dolorum Accusamus Ipsa', 'molestiae-est-voluptas-dolorum-accusamus-ipsa', 'Perspiciatis sed aliquid quaerat. Quas est minus officia aperiam eaque et. Culpa quia non tempora iusto.\n\nConsequatur vitae aut commodi aspernatur amet excepturi. Et sit ab provident odit. Expedita necessitatibus et atque voluptatem.\n\nNisi similique vel cupiditate voluptatibus excepturi consequatur natus. At illo quis dignissimos ad maiores quas sunt. Earum porro explicabo labore. Esse possimus enim consequatur sequi nobis consequatur reiciendis.', 'Perspiciatis sed aliquid quaerat. Quas est minus officia aperiam eaque et. Culpa quia non tempora iusto.\n\nConsequatur vitae aut commodi aspernatur ame...', 'cover.jpg', 5, 'Draft', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(28, 4, 'Consequatur Delectus Deserunt Ratione Aperiam Facilis Vel', 'consequatur-delectus-deserunt-ratione-aperiam-facilis-vel', 'Quod provident voluptatum hic et unde laudantium. Sunt cumque sit quis possimus ipsa. Ex natus porro ducimus. Atque aut ad enim distinctio.\n\nDucimus repellendus omnis blanditiis nulla. Voluptas aspernatur non quia nisi et est. Dolor modi eos tenetur reprehenderit quia.\n\nExercitationem nam odit consequuntur natus qui excepturi sunt. Autem molestiae eos excepturi et. Ut ipsum autem eum sint quos impedit. Sunt dolorum est maiores ut voluptas.', 'Quod provident voluptatum hic et unde laudantium. Sunt cumque sit quis possimus ipsa. Ex natus porro ducimus. Atque aut ad enim distinctio.\n\nDucimus r...', 'cover.jpg', 7, 'Archived', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(29, 3, 'Deserunt Debitis Voluptas Ducimus', 'deserunt-debitis-voluptas-ducimus', 'Exercitationem quaerat est hic nobis officia eaque. Ea velit culpa accusantium dolores.\n\nEius ducimus aperiam et aperiam. Tempore quo voluptatem ipsum. Aut inventore deleniti occaecati dolor architecto eum. Aspernatur omnis fugiat cumque inventore quia et perferendis in.\n\nNon dolores aut voluptatum at excepturi aut molestiae. Expedita eum ut reprehenderit assumenda voluptatem magnam modi sed. Cum reiciendis esse in rerum et hic.', 'Exercitationem quaerat est hic nobis officia eaque. Ea velit culpa accusantium dolores.\n\nEius ducimus aperiam et aperiam. Tempore quo voluptatem ipsum...', 'cover.jpg', 4, 'Draft', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(30, 3, 'Facere Voluptatem Ipsa Commodi Et Velit Qui', 'facere-voluptatem-ipsa-commodi-et-velit-qui', 'Omnis nemo natus voluptatem cupiditate autem. Sunt accusantium perferendis qui. Voluptas maxime expedita autem consectetur vitae illum vel. Molestias non non sunt eius.\n\nConsequatur ea eligendi et voluptas minima. Aliquid ipsum omnis voluptatibus esse ut. Officia dolores minima pariatur sequi qui quae voluptatem. Officia et exercitationem ad adipisci.\n\nEaque et ut molestiae est blanditiis eum. Veritatis dolor dolores minima. Molestias perferendis ea ea ipsa. Provident officiis est hic dicta delectus eum.', 'Omnis nemo natus voluptatem cupiditate autem. Sunt accusantium perferendis qui. Voluptas maxime expedita autem consectetur vitae illum vel. Molestias ...', 'cover.jpg', 3, 'Deleted', '2025-04-01 13:11:15', '2025-04-01 13:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `review_tag`
--

DROP TABLE IF EXISTS `review_tag`;
CREATE TABLE IF NOT EXISTS `review_tag` (
  `review_id` int NOT NULL,
  `tag_id` int NOT NULL,
  PRIMARY KEY (`review_id`,`tag_id`),
  KEY `IDX_FBEBB4A3E2E969B` (`review_id`),
  KEY `IDX_FBEBB4ABAD26311` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `review_tag`
--

INSERT INTO `review_tag` (`review_id`, `tag_id`) VALUES
(1, 23),
(1, 26),
(1, 30),
(2, 1),
(2, 5),
(2, 20),
(3, 6),
(3, 23),
(4, 22),
(4, 24),
(4, 29),
(5, 25),
(6, 12),
(6, 15),
(7, 20),
(8, 21),
(8, 28),
(9, 13),
(9, 14),
(10, 7),
(10, 12),
(10, 17),
(11, 8),
(11, 19),
(12, 7),
(12, 26),
(13, 1),
(13, 3),
(13, 24),
(14, 3),
(14, 22),
(14, 27),
(15, 11),
(16, 6),
(16, 8),
(16, 11),
(17, 12),
(17, 14),
(17, 21),
(18, 1),
(18, 27),
(19, 19),
(20, 1),
(20, 22),
(21, 4),
(21, 12),
(21, 18),
(22, 5),
(23, 13),
(24, 3),
(24, 13),
(24, 21),
(25, 7),
(25, 24),
(26, 5),
(26, 12),
(26, 25),
(27, 8),
(27, 15),
(27, 21),
(28, 13),
(28, 27),
(29, 11),
(30, 29);

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`id`, `title`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Optio', 'optio', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(2, 'Dicta', 'dicta', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(3, 'Assumenda', 'assumenda', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(4, 'Reprehenderit', 'reprehenderit', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(5, 'Distinctio', 'distinctio', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(6, 'Molestiae', 'molestiae', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(7, 'Iusto', 'iusto', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(8, 'Sed', 'sed', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(9, 'Excepturi', 'excepturi', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(10, 'Minima', 'minima', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(11, 'Rerum', 'rerum', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(12, 'Qui', 'qui', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(13, 'Magnam', 'magnam', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(14, 'Sunt', 'sunt', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(15, 'Asperiores', 'asperiores', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(16, 'Officiis', 'officiis', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(17, 'Dignissimos', 'dignissimos', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(18, 'Veritatis', 'veritatis', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(19, 'Nulla', 'nulla', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(20, 'Consequatur', 'consequatur', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(21, 'Doloremque', 'doloremque', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(22, 'Perspiciatis', 'perspiciatis', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(23, 'Amet', 'amet', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(24, 'Similique', 'similique', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(25, 'Quos', 'quos', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(26, 'Minus', 'minus', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(27, 'Temporibus', 'temporibus', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(28, 'Quam', 'quam', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(29, 'Magni', 'magni', '2025-04-01 13:11:13', '2025-04-01 13:11:13'),
(30, 'Neque', 'neque', '2025-04-01 13:11:13', '2025-04-01 13:11:13');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `nickname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitch_account` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`),
  UNIQUE KEY `UNIQ_USER_NICKNAME` (`nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `roles`, `nickname`, `twitch_account`, `avatar`, `created_at`, `updated_at`) VALUES
(1, 'brie@gmail.com', '$2y$13$DGBEw2JCqHq1SKlRYfYpiudYz2heUR/0tV5W/yiaicNA2VXzB3/oC', '[\"ROLE_ADMIN\", \"ROLE_USER\"]', 'Brie', 'http://wiegand.com/', 'avatar.jpg', '2025-04-01 13:11:14', '2025-04-01 13:11:14'),
(2, 'kai@gmail.com', '$2y$13$YUn182Pv1p0gwpgxGDiNYef1qErJDhkpi..1H5Y4xCAwQ/NBdFk1e', '[\"ROLE_USER\"]', 'Kai', 'http://mosciski.com/', 'avatar.jpg', '2025-04-01 13:11:14', '2025-04-01 13:11:14'),
(3, 'sapphire@gmail.com', '$2y$13$fogtV.SubPKhub2Cv.CdXeISQ13tsM4hhfdOlDcgro1j0bvHCxdZu', '[\"ROLE_USER\"]', 'Sapphire', 'http://www.schowalter.net/', 'avatar.jpg', '2025-04-01 13:11:14', '2025-04-01 13:11:14'),
(4, 'muse@gmail.com', '$2y$13$cM/PCvwkdLBXaiCgoQ2vIeNPGsnBgvSHZbFuk3pIU1hBGo60CMoWq', '[\"ROLE_USER\"]', 'Muse', 'http://www.haley.com/rem-totam-doloremque-laudantium-voluptas-ut-sint-est', 'avatar.jpg', '2025-04-01 13:11:15', '2025-04-01 13:11:15'),
(5, 'oneeyed@gmail.com', '$2y$13$JD6zTQIojvW245jQH8SAd.ay8ulKlMpr5d1bv4hHpPnRAOK6CEPAG', '[\"ROLE_USER\"]', 'OneEyed', 'https://fay.com/soluta-minima-eum-dolor-sunt.html', 'avatar.jpg', '2025-04-01 13:11:15', '2025-04-01 13:11:15');

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

DROP TABLE IF EXISTS `user_token`;
CREATE TABLE IF NOT EXISTS `user_token` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `token` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `session_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` datetime NOT NULL,
  `is_revoked` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BDF55A63A76ED395` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526C3E2E969B` FOREIGN KEY (`review_id`) REFERENCES `review` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_9474526CF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `game_developer`
--
ALTER TABLE `game_developer`
  ADD CONSTRAINT `FK_B75D4A9864DD9267` FOREIGN KEY (`developer_id`) REFERENCES `developer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B75D4A98E48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `game_genre`
--
ALTER TABLE `game_genre`
  ADD CONSTRAINT `FK_B1634A774296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_B1634A77E48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `game_news`
--
ALTER TABLE `game_news`
  ADD CONSTRAINT `FK_F6C6F57CB5A459A0` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_F6C6F57CE48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `game_platform`
--
ALTER TABLE `game_platform`
  ADD CONSTRAINT `FK_92162FEDE48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_92162FEDFFE6496F` FOREIGN KEY (`platform_id`) REFERENCES `platform` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `game_publisher`
--
ALTER TABLE `game_publisher`
  ADD CONSTRAINT `FK_4E4E144440C86FCE` FOREIGN KEY (`publisher_id`) REFERENCES `publisher` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_4E4E1444E48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `game_review`
--
ALTER TABLE `game_review`
  ADD CONSTRAINT `FK_4762C0E3E2E969B` FOREIGN KEY (`review_id`) REFERENCES `review` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_4762C0EE48FD905` FOREIGN KEY (`game_id`) REFERENCES `game` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `FK_1DD39950F675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `news_tag`
--
ALTER TABLE `news_tag`
  ADD CONSTRAINT `FK_BE3ED8A1B5A459A0` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_BE3ED8A1BAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `FK_794381C6F675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `review_tag`
--
ALTER TABLE `review_tag`
  ADD CONSTRAINT `FK_FBEBB4A3E2E969B` FOREIGN KEY (`review_id`) REFERENCES `review` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_FBEBB4ABAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_token`
--
ALTER TABLE `user_token`
  ADD CONSTRAINT `FK_BDF55A63A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
