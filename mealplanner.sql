-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 17. Apr 2023 um 15:28
-- Server-Version: 10.4.27-MariaDB
-- PHP-Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `mealplanner`
--
CREATE DATABASE IF NOT EXISTS `mealplanner` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `mealplanner`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ingredient`
--

CREATE TABLE `ingredient` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ingredient_meal`
--

CREATE TABLE `ingredient_meal` (
  `id` int(11) NOT NULL,
  `fk_meal_id` int(11) NOT NULL,
  `fk_ingredient_id` int(11) NOT NULL,
  `amount` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ingredient_nutrition`
--

CREATE TABLE `ingredient_nutrition` (
  `ingredient_id` int(11) NOT NULL,
  `nutrition_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `meal`
--

CREATE TABLE `meal` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `calories` int(11) NOT NULL,
  `rating` double NOT NULL,
  `preparation` varchar(1000) NOT NULL,
  `cooking_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `meal_user`
--

CREATE TABLE `meal_user` (
  `meal_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext NOT NULL,
  `headers` longtext NOT NULL,
  `queue_name` varchar(190) NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `nutrition`
--

CREATE TABLE `nutrition` (
  `id` int(11) NOT NULL,
  `engery` double NOT NULL,
  `fat` double NOT NULL,
  `protein` double NOT NULL,
  `carbs` double NOT NULL,
  `sugar` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(180) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`roles`)),
  `password` varchar(255) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone` varchar(50) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `blocked` tinyint(1) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `week`
--

CREATE TABLE `week` (
  `id` int(11) NOT NULL,
  `fk_user_id` int(11) DEFAULT NULL,
  `fk_monday_id` int(11) DEFAULT NULL,
  `fk_tuesday_id` int(11) DEFAULT NULL,
  `fk_wednesday_id` int(11) DEFAULT NULL,
  `fk_thursday_id` int(11) DEFAULT NULL,
  `fk_friday_id` int(11) DEFAULT NULL,
  `fk_saturday_id` int(11) DEFAULT NULL,
  `fk_sunday_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `ingredient`
--
ALTER TABLE `ingredient`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `ingredient_meal`
--
ALTER TABLE `ingredient_meal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C0A73E0A93B95BFA` (`fk_meal_id`),
  ADD KEY `IDX_C0A73E0AF775954E` (`fk_ingredient_id`);

--
-- Indizes für die Tabelle `ingredient_nutrition`
--
ALTER TABLE `ingredient_nutrition`
  ADD PRIMARY KEY (`ingredient_id`,`nutrition_id`),
  ADD KEY `IDX_BDB1C886933FE08C` (`ingredient_id`),
  ADD KEY `IDX_BDB1C886B5D724CD` (`nutrition_id`);

--
-- Indizes für die Tabelle `meal`
--
ALTER TABLE `meal`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `meal_user`
--
ALTER TABLE `meal_user`
  ADD PRIMARY KEY (`meal_id`,`user_id`),
  ADD KEY `IDX_974D05BD639666D6` (`meal_id`),
  ADD KEY `IDX_974D05BDA76ED395` (`user_id`);

--
-- Indizes für die Tabelle `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Indizes für die Tabelle `nutrition`
--
ALTER TABLE `nutrition`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Indizes für die Tabelle `week`
--
ALTER TABLE `week`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5B5A69C05741EEB9` (`fk_user_id`),
  ADD KEY `IDX_5B5A69C0403EC0E7` (`fk_monday_id`),
  ADD KEY `IDX_5B5A69C0ABF98571` (`fk_tuesday_id`),
  ADD KEY `IDX_5B5A69C09A7FECA7` (`fk_wednesday_id`),
  ADD KEY `IDX_5B5A69C0BF7B4269` (`fk_thursday_id`),
  ADD KEY `IDX_5B5A69C0E072444E` (`fk_friday_id`),
  ADD KEY `IDX_5B5A69C0D19C6ACE` (`fk_saturday_id`),
  ADD KEY `IDX_5B5A69C0C94774E7` (`fk_sunday_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `ingredient`
--
ALTER TABLE `ingredient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `ingredient_meal`
--
ALTER TABLE `ingredient_meal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `meal`
--
ALTER TABLE `meal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `nutrition`
--
ALTER TABLE `nutrition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `week`
--
ALTER TABLE `week`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `ingredient_meal`
--
ALTER TABLE `ingredient_meal`
  ADD CONSTRAINT `FK_C0A73E0A93B95BFA` FOREIGN KEY (`fk_meal_id`) REFERENCES `meal` (`id`),
  ADD CONSTRAINT `FK_C0A73E0AF775954E` FOREIGN KEY (`fk_ingredient_id`) REFERENCES `ingredient` (`id`);

--
-- Constraints der Tabelle `ingredient_nutrition`
--
ALTER TABLE `ingredient_nutrition`
  ADD CONSTRAINT `FK_BDB1C886933FE08C` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredient` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_BDB1C886B5D724CD` FOREIGN KEY (`nutrition_id`) REFERENCES `nutrition` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `meal_user`
--
ALTER TABLE `meal_user`
  ADD CONSTRAINT `FK_974D05BD639666D6` FOREIGN KEY (`meal_id`) REFERENCES `meal` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_974D05BDA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `week`
--
ALTER TABLE `week`
  ADD CONSTRAINT `FK_5B5A69C0403EC0E7` FOREIGN KEY (`fk_monday_id`) REFERENCES `meal` (`id`),
  ADD CONSTRAINT `FK_5B5A69C05741EEB9` FOREIGN KEY (`fk_user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_5B5A69C09A7FECA7` FOREIGN KEY (`fk_wednesday_id`) REFERENCES `meal` (`id`),
  ADD CONSTRAINT `FK_5B5A69C0ABF98571` FOREIGN KEY (`fk_tuesday_id`) REFERENCES `meal` (`id`),
  ADD CONSTRAINT `FK_5B5A69C0BF7B4269` FOREIGN KEY (`fk_thursday_id`) REFERENCES `meal` (`id`),
  ADD CONSTRAINT `FK_5B5A69C0C94774E7` FOREIGN KEY (`fk_sunday_id`) REFERENCES `meal` (`id`),
  ADD CONSTRAINT `FK_5B5A69C0D19C6ACE` FOREIGN KEY (`fk_saturday_id`) REFERENCES `meal` (`id`),
  ADD CONSTRAINT `FK_5B5A69C0E072444E` FOREIGN KEY (`fk_friday_id`) REFERENCES `meal` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
