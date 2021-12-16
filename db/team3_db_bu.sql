-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 16. Dez 2021 um 12:10
-- Server-Version: 10.4.21-MariaDB
-- PHP-Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `team3_db_bu`
--
CREATE DATABASE IF NOT EXISTS `team3_db_bu` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `team3_db_bu`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `categories`
--

CREATE TABLE `categories` (
  `category_id` int(4) NOT NULL,
  `category_name` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Sweets'),
(2, 'Food'),
(3, 'Desserts'),
(4, 'Toys'),
(5, 'Weapons'),
(6, 'Potions'),
(7, 'Magic'),
(8, 'Drinks'),
(9, 'Transport'),
(10, 'Clothes');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `manufacturers`
--

CREATE TABLE `manufacturers` (
  `manufacturer_id` int(4) NOT NULL,
  `company_name` varchar(55) NOT NULL,
  `company_address` varchar(55) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `manufacturers`
--

INSERT INTO `manufacturers` (`manufacturer_id`, `company_name`, `company_address`) VALUES
(1, 'Deliciously', 'Candy Street No.1, Candyland'),
(2, 'Best Bakery', 'Bread Street No.1, Eatingland'),
(3, 'Cake Shop', 'Muffin Street No.1, Dessertsland'),
(4, 'Santa’s Store', 'Elven‘s Street No.1, Nord Pole'),
(5, 'Best Weapons', 'Fight Street No.1, Warland'),
(6, 'Magic Potions', 'Charmed Street No.1, Witchesland'),
(7, 'Just Magical', ' Diagon Alley No.1, Hogwarts'),
(8, 'Refreshing Beverages', 'Drinking Street No.1, Springland'),
(9, 'Best Horse', 'Transport Street No.1, Travelland'),
(10, 'Magical Tailoring', 'Dressup Street No.1, Costumeland');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `products`
--

CREATE TABLE `products` (
  `product_id` int(8) NOT NULL,
  `product_name` varchar(55) NOT NULL,
  `picture` varchar(55) DEFAULT NULL,
  `unit_price` decimal(8,2) NOT NULL,
  `description` varchar(128) DEFAULT NULL,
  `fk_category_id` int(4) NOT NULL,
  `fk_manufacturer_id` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `picture`, `unit_price`, `description`, `fk_category_id`, `fk_manufacturer_id`) VALUES
(1, 'Bow & Arrows Set', '61ba97a81ce34.jpg', '250.00', '', 5, 5),
(2, 'Brown Carriage', '61ba9b7425994.jpg', '4500.00', 'Luxuriox Carriage, made for big queens.', 9, 9),
(3, 'Love Potion', '61ba98e2ae88b.jpg', '666.66', 'Give this to your beloved one, and he will marry you for sure.', 6, 6),
(4, 'Pink Cake', '61ba93bcc4312.jpg', '75.90', 'Let us eat a delicious pink cake, good for every ocassion!', 3, 3),
(5, 'Horse', '61baa862bcd0b.jpg', '500.00', 'Big Brown Horse. No magical powers.', 9, 9),
(6, 'Magic Chocolatte', '61ba9fd220d38.jpg', '4.99', 'Delicious Chocolatte, gives you the ability to forget about the problems in your life.', 1, 1),
(7, 'Wand', '61ba9995d8c70.jpg', '89.90', 'Everyone needs one of this! \r\nWe know exactly wich fits your powers the best.', 7, 7),
(8, 'Unicorn', '61ba9a2ae2124.jpg', '7500.00', 'Very fast transport, catches the Speed of Sound.', 9, 9),
(9, 'Invisibillity Cloak', '61ba9c0537e4b.jpeg', '566.80', 'Ver nice cloak, makes you invisible when you wear it.', 10, 10),
(10, 'Lollipop', '61ba9219c24fa.jpg', '2.00', 'Very delicios Lollipop with taste of fruits.', 1, 1),
(11, 'Woody', '61ba94aa04da9.jpg', '25.60', 'Leaving Sheriff doll who pretends and acts like not beeing alive.', 4, 4),
(12, 'Buzz', '61ba951f871cc.jpg', '25.60', 'Leaving doll, with a secret life, a guardian of the Galaxy with laser weapon.', 4, 4),
(13, 'Wealth Potion', '61bad4808e95d.jpg', '11500.00', 'This Potion brings Wealth and Happiness', 6, 6),
(14, 'White Carriage', '61ba9b4628204.jpg', '3000.00', 'Very nice carriage, made for little princesses.', 9, 9),
(15, 'Cinderrelas Dress', '61ba9cd8c006d.jpg', '350.00', 'Very beautifull dress, with the ability to make Prince Charming fall in love with you. ATENTION: Works only between 8.00 PM an 1', 10, 10),
(16, 'Red Wine', '61ba9dc9b41ae.jpg', '5.90', 'Red Wine with taste of fruits. Gives you the abillity to sing and dance like a Prince.', 8, 8),
(17, 'Ice Cake', '61ba9edde4b42.jpg', '40.00', 'Cake made of ice, tastes like a snowman.', 3, 3),
(19, 'White Wine', '61ba9e2f21ebf.jpg', '78.80', 'Tastefull white wine, gives you the abillity of narration.', 8, 8),
(20, 'Arthurs Sword', '61ba9653b6d88.jpg', '1500.00', 'The most powerfull sword of the world, gives you magical abillities.', 5, 5),
(21, 'Bread', '61ba92cebd1d3.jpg', '2.00', 'Our daily bread for today!', 2, 2),
(44, 'Poison', '61bae84f4217e.jpg', '55.75', 'Give this to your enemies.', 6, 6);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(8) NOT NULL,
  `rating` int(1) DEFAULT NULL,
  `review` varchar(500) DEFAULT NULL,
  `question` varchar(500) DEFAULT NULL,
  `fk_user_id` int(8) NOT NULL,
  `fk_product_id` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `reviews`
--

INSERT INTO `reviews` (`review_id`, `rating`, `review`, `question`, `fk_user_id`, `fk_product_id`) VALUES
(1, 5, 'This Desicion to take this Potion, was the best of my entire life! I got marryed!', NULL, 1, 3),
(2, 5, 'Thank you for this carriage, its very lovely and also pretty.', NULL, 1, 2),
(3, 5, 'The most tastefull wine i ever saw! I love it!', NULL, 3, 16),
(4, 5, 'I love this Bread! It tastes like heaven!', NULL, 4, 21),
(5, NULL, NULL, 'Does it have an expiration Date? Or hour?', 4, 2),
(6, 5, 'Very usefull in the Woods.', NULL, 5, 1),
(7, 5, 'I love this guy. I feel like it were my twin brother.', NULL, 3, 12),
(8, NULL, NULL, 'Do you also have a white one?', 4, 5),
(9, 3, 'This is my favorite cake! I cannt stop eating!', NULL, 1, 4),
(10, 5, 'I love this Dress! I fill even more beautifull then i already am!', NULL, 1, 15),
(11, 5, 'I love it, it takes like Christmass', NULL, 4, 17),
(12, 5, 'My Granny will love this!', NULL, 5, 4),
(13, NULL, NULL, 'Do you also have a female one?', 5, 11),
(14, NULL, NULL, 'Is it magical?', 3, 7),
(15, 3, 'Im not impressed by this cake. After it melts, it tastes like water...', NULL, 1, 17),
(16, NULL, NULL, 'Is it really alive?', 2, 11),
(17, 5, 'Exactly what i neaded!', NULL, 5, 21),
(18, 5, 'This is Grannys favorite red wine. Thank you very much for sending it so quiqly everytime.', NULL, 5, 16),
(19, NULL, NULL, 'Do you also have it in blue?', 3, 4),
(20, NULL, NULL, 'I love this colour, i would like to taste it before i take it. May i?', 1, 4),
(21, 5, 'Hey, it really works! I forgot even about Cinderella!', NULL, 3, 6),
(22, 5, 'This Unicorn is the most beautifull Being that i ever saw! ', NULL, 4, 8),
(24, NULL, NULL, 'Do you get dirty when you use this?', 3, 1),
(25, NULL, NULL, 'May i lick it a bit before i take it? Just to be sure that i like it...', 1, 10),
(26, NULL, NULL, 'Do you also have it in white, yellow, red or royal blue?', 1, 15),
(71, NULL, NULL, 'Do you have it in red?', 5, 9),
(72, NULL, NULL, 'This price is for the Bottle or for the hole barrel?', 42, 19),
(73, 5, 'Oh my God! Its so fluffy! I just love it!', NULL, 2, 8),
(74, 5, 'Made by my brothers, this Bow is the best! It allways comes in handy.', NULL, 43, 1),
(75, 4, 'You never know, when you nead it most. Good to have it!', NULL, 43, 20),
(76, NULL, NULL, 'Is it effective against dwarfs?', 43, 13),
(77, 5, 'Smells and Tastes like home...', NULL, 44, 21);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `user_id` int(8) NOT NULL,
  `first_name` varchar(22) NOT NULL,
  `last_name` varchar(22) NOT NULL,
  `birth_date` date DEFAULT NULL,
  `address` varchar(55) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(55) NOT NULL,
  `password` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `status` varchar(6) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `birth_date`, `address`, `username`, `email`, `password`, `picture`, `status`) VALUES
(1, 'Princess', 'Beautiful', '2000-02-20', 'Castle No1, Beauty Kingdom', 'BeautyP', 'princess@beautiful.com', 'd0b5bdaf83bc2cff421f80b73dd3b5750f7410304a72ad8d52c10847375cf7ec', '61ba8b23e16e4.png', 'user'),
(2, 'White', 'Snow', '2000-01-19', '', 'SnowWhite', 'white@snow.com', 'b87df38497770b5d52e9ae0baca9a8c832cd6f20fc160eb9541bf7cd10fc89f6', '61bb17b51e4e8.jpg', 'adm'),
(3, 'Prince', 'Charming', '1999-01-01', 'CharminCastle No.1, Disneyland Paris, France', 'PrinceCharming', 'prince@charming.com', 'bf3654a9a3dd6dda842284998049d6b5b98560f7d5bbd8040b680522394035d9', '61bab2f4df037.jpg', 'user'),
(4, 'Cinderella', 'Ashes', '2001-04-03', 'Chimney Street No. 1, Disneyland Paris, France', 'Cinderella', 'ashes@cinderella.com', '46c9ad0e0b3c064e0532e70fb9bb707c6a037fbf118accf9a38681695b75ade0', '61bab6a87d2a5.jpg', 'user'),
(5, 'RedRiding', 'Hood', '2012-12-12', 'Grannys House, In the Woods', 'RedHood', 'red@hood.com', 'be83f1a803c4c1643289fa5c9e40bad989efc7b65b42099a3decc158446056b7', '61bb17f7a29d2.jpg', 'user'),
(42, 'Bigest', 'Wolf', '1995-05-05', 'Grannys Wood nr. 4', 'BigWolf', 'big@wolf.com', 'f23db99dc9e5fd7d4c5e1b020c63f901303ff5ecbbc5db4075d8e1af1958275f', '61bb1769901be.jpg', 'user'),
(43, 'Eleven', 'Brave', '1377-02-20', 'Wood of Elfs No. 5, Magic Kingdom', 'ElevenBrave', 'eleven@brave.com', '4130ef9d17bf3ce1c6dd8b85ef1edb29e4f005e7a7b69c395b906705fc51af90', '61bac1c30bd8c.jpg', 'user'),
(44, 'Youngboy', 'Charmed', '2005-11-22', 'Main Streat No. 6, Magic Kingdom', 'YoungBoy', 'boy@young.com', 'dec5f57d8091bca4c222c011516068090d01af829f1a5dbcdb03b1472bc4bc7d', 'hirsch.jpg', 'user'),
(45, 'Witch', 'Mean', '1970-02-01', 'The Darkest Street No. 6, The Dark City', 'MeanWitch', 'witch@mean.com', 'f0665052505729c0ddf583c41ca5acbe8aa100776309071b826a4c54e513cd93', '61bb17dd3446a.jpg', 'user'),
(46, 'Prince', 'Beautiful', '2002-12-22', 'CharminCastle No.1, Disneyland Paris, France', 'lauram', 'laura@user.com', 'd16aed0a483a21d695fe5e210da62adec78c21631b5be5ff837e9fbedf2e6241', '61bb19f208032.png', 'user');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_products`
--

CREATE TABLE `user_products` (
  `user_product_id` int(8) NOT NULL,
  `fk_user_id` int(8) NOT NULL,
  `fk_product_id` int(8) NOT NULL,
  `quantity` int(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `user_products`
--

INSERT INTO `user_products` (`user_product_id`, `fk_user_id`, `fk_product_id`, `quantity`) VALUES
(125, 1, 14, 3),
(126, 1, 4, 5),
(127, 1, 3, 1),
(128, 1, 15, 3),
(129, 1, 17, 3),
(130, 1, 10, 10),
(140, 2, 2, 1),
(141, 2, 4, 10),
(142, 2, 8, 1),
(143, 2, 15, 1),
(144, 2, 11, 1),
(145, 2, 12, 1),
(146, 2, 19, 5),
(147, 3, 2, 1),
(148, 3, 16, 10),
(149, 3, 20, 1),
(150, 3, 17, 3),
(151, 3, 5, 4),
(153, 4, 15, 3),
(154, 4, 6, 2),
(155, 4, 8, 1),
(156, 4, 9, 1),
(157, 4, 21, 5),
(158, 4, 14, 1),
(159, 4, 17, 10),
(160, 5, 1, 1),
(161, 5, 4, 2),
(162, 5, 21, 5),
(163, 5, 16, 5),
(164, 42, 16, 3),
(165, 42, 13, 5),
(166, 42, 4, 5),
(167, 43, 1, 10),
(168, 43, 5, 1),
(169, 43, 20, 5),
(170, 44, 6, 2),
(171, 44, 7, 3),
(172, 44, 8, 1),
(173, 44, 9, 1);

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indizes für die Tabelle `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`manufacturer_id`);

--
-- Indizes für die Tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `fk_category_id` (`fk_category_id`),
  ADD KEY `fk_manufacturer_id` (`fk_manufacturer_id`);

--
-- Indizes für die Tabelle `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `fk_product_id` (`fk_product_id`),
  ADD KEY `fk_user_id` (`fk_user_id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indizes für die Tabelle `user_products`
--
ALTER TABLE `user_products`
  ADD PRIMARY KEY (`user_product_id`),
  ADD KEY `fk_user_id` (`fk_user_id`),
  ADD KEY `fk_product_id` (`fk_product_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT für Tabelle `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `manufacturer_id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT für Tabelle `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT für Tabelle `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT für Tabelle `user_products`
--
ALTER TABLE `user_products`
  MODIFY `user_product_id` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`fk_category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`fk_manufacturer_id`) REFERENCES `manufacturers` (`manufacturer_id`);

--
-- Constraints der Tabelle `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`fk_product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `user_products`
--
ALTER TABLE `user_products`
  ADD CONSTRAINT `user_products_ibfk_1` FOREIGN KEY (`fk_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_products_ibfk_2` FOREIGN KEY (`fk_product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
