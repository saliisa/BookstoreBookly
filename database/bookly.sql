-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2024 at 10:57 AM
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
-- Database: `bookly`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `Book_id` int(11) NOT NULL,
  `isbn` char(13) NOT NULL,
  `title` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `pub_year` date NOT NULL,
  `price` float NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `subcategory` varchar(100) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `cover_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`Book_id`, `isbn`, `title`, `author`, `pub_year`, `price`, `category`, `subcategory`, `short_description`, `cover_image`) VALUES
(1, '9780545582889', 'Harry Potter and The Sorcerer&#39;s Stone', 'J.K. Rowling', '1997-06-26', 12.5, 'Fiction', 'Fantasy', '\"Till now there\'s been no magic for Harry Potter. He lives with the miserable Dursleys and their abominable son, Dudley. Harry\'s room is a tiny closet beneath the stairs, and he hasn\'t had a birthday party in eleven years.\r\n\r\nBut then a mysterious letter arrives by owl messenger: a letter with an invitation to an incredible place called Hogwarts School of Witchcraft and Wizardry. And there he finds not only friends, flying sports on broomsticks, and magic in everything from classes to meals, but a great destiny that\'s been waiting for him... if Harry can survive the encounter.\"', 'https://i2.wp.com/geekdad.com/wp-content/uploads/2013/02/HP1-Kibuishi.jpg'),
(2, '9780141036144', '1984', 'George Orwell', '1949-06-08', 15.5, 'Fiction', 'Sci Fi', '\'It was a bright cold day in April, and the clocks were striking thirteen.\'\r\n\r\nWinston Smith works for the Ministry of truth in London, chief city of Airstrip One. Big Brother stares out from every poster, the Thought Police uncover every act of betrayal. When Winston finds love with Julia, he discovers that life does not have to be dull and deadening, and awakens to new possibilities. Despite the police helicopters that hover and circle overhead, Winston and Julia begin to question the Party; they are drawn towards conspiracy. Yet Big Brother will not tolerate dissent - even in the mind. For those with original thoughts they invented Room 101 . . .\r\n\r\nNineteen Eighty-Four is George Orwell\'s terrifying vision of a totalitarian future in which everything and everyone is slave to a tyrannical regime.', 'https://d30a6s96kk7rhm.cloudfront.net/original/readings/978/014/103/9780141036144.jpg'),
(3, '9780141439518', 'Pride and Prejudice', 'Jane Austen', '1813-01-28', 12.5, 'Fiction', 'Romance', 'Since its immediate success in 1813, Pride and Prejudice has remained one of the most popular novels in the English language. Jane Austen called this brilliant work \"her own darling child\" and its vivacious heroine, Elizabeth Bennet, \"as delightful a creature as ever appeared in print.\" The romantic clash between the opinionated Elizabeth and her proud beau, Mr. Darcy, is a splendid performance of civilized sparring. And Jane Austen\'s radiant wit sparkles as her characters dance a delicate quadrille of flirtation and intrigue, making this book the most superb comedy of manners of Regency England.', 'https://images.thenile.io/r1000/9780141439518.jpg'),
(4, '9780062316110', 'Sapiens: A Brief History of Humankind ', 'Yuval Noah Harari', '2014-07-13', 18.5, 'Non-Fiction', 'History', 'From a renowned historian comes a groundbreaking narrative of humanity’s creation and evolution—a #1 international bestseller—that explores the ways in which biology and history have defined us and enhanced our understanding of what it means to be “human.”\r\n<br> <br>\r\n One hundred thousand years ago, at least six different species of humans inhabited Earth. Yet today there is only one—homo sapiens. What happened to the others? And what may happen to us? Most books about the history of humanity pursue either a historical or a biological approach, but Dr. Yuval Noah Harari breaks the mold with this highly original book that begins about 70,000 years ago with the appearance of modern cognition. From examining the role evolving humans have played in the global ecosystem to charting the rise of empires, Sapiens integrates history and science to reconsider accepted narratives, connect past developments with contemporary concerns, and examine specific events within the context of larger ideas. \r\n<br> <br>\r\nDr. Harari also compels us to look ahead, because over the last few decades humans have begun to bend laws of natural selection that have governed life for the past four billion years. We are acquiring the ability to design not only the world around us, but also ourselves. Where is this leading us, and what do we want to become? ', 'https://cdn2.penguin.com.au/covers/original/9780099590088.jpg'),
(5, '9780425196403', 'Serial Killers: The Method and Madness of Monsters', 'Peter Vronsky', '2004-04-23', 34.5, 'Non-Fiction', 'Crime', 'In this unique book, Peter Vronsky documents the psychological, investigative, and cultural aspects of serial murder, beginning with its first recorded instance in ancient Rome, through fifteenth-century France, up to such notorious contemporary cases as cannibal/necrophile Ed Kemper, Henry Lee Lucas, Ted Bundy, and the emergence of what he classifies as the serial rampage killer such as Andrew Cunanan. Exhaustively researched with transcripts of interviews with killers, and featuring up-to-date information on the apprehension and conviction of the Green River Killer and the Beltway Snipers, Vronsky\'s one-of-a-kind book covers every conceivable aspect of an endlessly riveting true-crime phenomenon.', 'https://prodimage.images-bn.com/pimages/9781101204627_p0_v2_s550x406.jpg'),
(6, '97803853338', 'Slaughterhouse Five ', 'Kurt Vonnegut', '1969-03-31', 15.5, 'Fiction', 'Sci Fi', 'An instant bestseller, Slaughterhouse-Five made Kurt Vonnegut a cult hero in American literature, a reputation that only strengthened over time, despite his being banned and censored by some libraries and schools for content and language. But it was precisely those elements of Vonnegut’s writing—the political edginess, the genre-bending inventiveness, the frank violence, the transgressive wit—that have inspired generations of readers not just to look differently at the world around them but to find the confidence to say something about it. Fifty years after its initial publication at the height of the Vietnam War, Vonnegut&#039;s portrayal of political disillusionment, PTSD, and postwar anxiety feels as relevant, darkly humorous, and profoundly affecting as ever, an enduring beacon through our own era’s uncertainties.', 'https://rd-prod.twic.pics/media/Slaughterhouse-Five-2.jpg'),
(7, '9780062464347', 'Homo Deus: A Brief History of Tomorrow', 'Yuval Noah Harari', '2017-01-21', 16.5, 'Non-Fiction', 'History', 'Yuval Noah Harari, author of the critically-acclaimed New York Times bestseller and international phenomenon Sapiens, returns with an equally original, compelling, and provocative book, turning his focus toward humanity’s future, and our quest to upgrade humans into gods.', 'https://images-na.ssl-images-amazon.com/images/I/71FX96Ae-PL.jpg'),
(8, ' 97809957535', 'The Meaning of Life', 'Alain de Botton', '2020-01-07', 20.5, 'Non-Fiction', 'Self-Help', 'To wonder too openly or intensely about the meaning of life can seem a peculiar, ill-fated and faintly ridiculous pastime. It can seem like a topic on which ordinary mortals cannot make much progress. In truth, it is for all of us to wonder about, define and work towards a more meaningful existence.\r\n\r\nThis book considers a range of options for where the meaning of life is to be found, including love, family, friendship, work, self-knowledge and nature. We learn why certain things feel meaningful while others don’t, and consider how we might introduce more meaning into our activities. What follows is a hugely thought-provoking as well as a practical guide to one of the greatest questions we will ever face.', 'https://i.gr-assets.com/images/S/compressed.photo.goodreads.com/books/1559139093l/42195298.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `Cart_id` int(11) NOT NULL,
  `customer_id` char(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `original_price` float NOT NULL,
  `total_price` float NOT NULL,
  `cart_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Customer_id` char(11) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `cus_password` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `postal_code` char(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Customer_id`, `first_name`, `last_name`, `email`, `cus_password`, `address`, `city`, `country`, `postal_code`) VALUES
('18098602145', 'Jane', 'Doe', 'jane.doe@email.com', '$2y$10$I5qZDTIxy2TryqYOvRVBXewO759bmE5Z8KKyK1UgDSpBHkVe9zMD2', 'Street Address 123', 'Helsinki', 'Finland', '00100'),
('78860365834', 'John', 'Doe', 'john.doe@email.com', '$2y$10$KC9Y.2Cimo33gsj3VsW5bO77y2ZqLy64KaPFtD.nz8nWxYFABDrFu', 'Street Address 1122', 'Helsinki', 'Finland', '00000');

-- --------------------------------------------------------

--
-- Table structure for table `orders_detail`
--

CREATE TABLE `orders_detail` (
  `Detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `book_id` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `total_cost` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders_table`
--

CREATE TABLE `orders_table` (
  `Order_id` int(11) NOT NULL,
  `order_date` date DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `customer_id` char(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `Staff_id` char(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `staff_email` varchar(50) NOT NULL,
  `staff_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`Staff_id`, `first_name`, `last_name`, `staff_email`, `staff_password`) VALUES
('91418900203', 'Mary', 'Smith', 'staff@bookly.com', '$2y$10$NNowvWVwjM17Dt5jkNkDl./Lz/ZFFVJBv.qRQeFup14pMZfp5hcp6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`Book_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`Cart_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Customer_id`);

--
-- Indexes for table `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD PRIMARY KEY (`Detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `orders_table`
--
ALTER TABLE `orders_table`
  ADD PRIMARY KEY (`Order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`Staff_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `Book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `Cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;

--
-- AUTO_INCREMENT for table `orders_detail`
--
ALTER TABLE `orders_detail`
  MODIFY `Detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=247;

--
-- AUTO_INCREMENT for table `orders_table`
--
ALTER TABLE `orders_table`
  MODIFY `Order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`Customer_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`Book_id`);

--
-- Constraints for table `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD CONSTRAINT `orders_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders_table` (`Order_id`),
  ADD CONSTRAINT `orders_detail_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `book` (`Book_id`);

--
-- Constraints for table `orders_table`
--
ALTER TABLE `orders_table`
  ADD CONSTRAINT `orders_table_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`Customer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
