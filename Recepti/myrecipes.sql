-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 02, 2024 at 06:08 PM
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
-- Database: `myrecipes`
--

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `title`, `description`, `instructions`, `user_id`, `image`, `created_at`) VALUES
(1, 'Pizza', 'Klasična italijanska pizza sa hrskavom korom i bogatim ukusom.\r\nSavršena kombinacija hrskavog testa, sočnog paradajz sos, aromatičnih začina i svežih sastojaka.\r\nPizza koja će zadovoljiti i najzahtevnije gurmane, idealna za porodične večere ili zabave sa prijateljima.', 'Pripremite testo: Zamesite testo od brašna, kvasca, vode, soli i malo maslinovog ulja. Ostavite ga da odmara i naraste.\r\nPripremite sos: Na pari prokuvajte pelat paradajz sa začinima i belim lukom dok ne postane gust.\r\nRazvaljajte testo: Razvucite testo na radnoj površini i prenesite ga na pleh.\r\nDodajte sos: Ravnomerno nanesite paradajz sos na testo.\r\nDodajte punjenje: Dodajte omiljene sastojke kao što su mocarela sir, šunka, pečurke, paprika, masline i origano.\r\nPecite: Pecite u zagrejanoj rerni na visokoj temperaturi dok pizza ne postane hrskava i sir ne postane zlatno smeđ.\r\nPoslužite: Izvadite iz rerne, secite na parčad i poslužite vruće.', NULL, 'images/pizza.jpg', '2024-06-02 16:02:32'),
(2, 'Pasta', 'Klasična italijanska pasta sa bogatim sosom i savršeno skuvanim testeninom.\r\nJednostavan, ali izuzetno ukusan obrok koji oduševljava svojom jednostavnošću i punim ukusom.\r\nPasta koja spaja sveže sastojke i začine u harmoničnu celinu, idealna za brz i zadovoljavajući obrok.', 'Skuvajte testeninu: Stavite vodu da proključa, posolite je i dodajte testeninu. Kuvajte prema uputstvu na pakovanju dok ne postane al dente.\r\nPripremite sos: Na maslinovom ulju propržite iseckani beli luk dok ne postane blago zlatan. Dodajte iseckane paradajze, bosiljak, so i biber. Kuvajte dok paradajz ne omekša i formira sos.\r\nDodajte testeninu: Ocedite skuvanu testeninu i dodajte je u sos. Dobro promešajte kako bi se testenina obložila sosom.\r\nPoslužite: Poslužite pastu u dubokim tanjirima ili posudama. Pospite svežim parmezanom i dodajte listiće svežeg bosiljka kao dekoraciju.\r\nPo želji, servirajte uz krišku svežeg hleba ili salatu od sezonskog povrća.', NULL, 'images/pasta.jpg', '2024-06-02 16:05:19');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_reviews`
--

CREATE TABLE `recipe_reviews` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipe_reviews`
--

INSERT INTO `recipe_reviews` (`id`, `recipe_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 6, 5, 'Ovo je odlican recept,sve preporuke!', '2024-06-02 16:03:11'),
(2, 1, 7, 4, 'Odlican recept!', '2024-06-02 16:04:42'),
(3, 2, 7, 3, 'Recept je sasvim uredu!', '2024-06-02 16:06:30');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `is_admin`, `created_at`) VALUES
(5, 'Aleksa', 'alex.mladicevic@gmail.com', '$2y$10$LGpR.NSzKYB5PLjBRTOon.DEON5Zo7RWmODHIXtqbXI6aeXGWaXBa', 1, '2024-06-02 16:00:44'),
(6, 'Petar', 'petar123@gmail.com', '$2y$10$8t/y1YD4g5lGL8OUddeX.eFBGgIc4IyzYjZz4iE1w3hQbuHef5woq', 0, '2024-06-02 16:02:50'),
(7, 'Milos', 'milos123@gmail.com', '$2y$10$93uBflWrKxqnBQcUPVlo/uk4fCxiGLNarJfSCrWIhtwFirkYddWZ2', 0, '2024-06-02 16:04:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `recipe_reviews`
--
ALTER TABLE `recipe_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_id` (`recipe_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `recipe_reviews`
--
ALTER TABLE `recipe_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `recipe_reviews`
--
ALTER TABLE `recipe_reviews`
  ADD CONSTRAINT `recipe_reviews_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`),
  ADD CONSTRAINT `recipe_reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
