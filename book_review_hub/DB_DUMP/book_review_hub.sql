-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 08:05 AM
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
-- Database: `book_review_hub`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `Book_ID` int(11) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Author` varchar(50) NOT NULL,
  `Description` varchar(2000) DEFAULT NULL,
  `Genre` varchar(500) DEFAULT NULL,
  `Cover_Image` varchar(500) DEFAULT NULL,
  `Curr_Rating` float DEFAULT NULL,
  `Rating_User_Count` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`Book_ID`, `Title`, `Author`, `Description`, `Genre`, `Cover_Image`, `Curr_Rating`, `Rating_User_Count`) VALUES
(1, 'To Kill a Mockingbird', 'Harper Lee', 'A gripping story of racial injustice in the Deep South seen through the eyes of a young girl.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8225261-L.jpg', 10, 1),
(2, '1984', 'George Orwell', 'A dystopian novel that examines totalitarianism, mass surveillance, and repressive regimentation of persons and behaviors.', 'Action', 'https://covers.openlibrary.org/b/id/7222246-L.jpg', 5.9, 35),
(3, 'The Great Gatsby', 'F. Scott Fitzgerald', 'A novel about the American dream and the decadence of the 1920s.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/7222276-L.jpg', 9, 1),
(4, 'The Catcher in the Rye', 'J.D. Salinger', 'A story of teenage angst and alienation in post-war America.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8231856-L.jpg', 10, 1),
(5, 'Pride and Prejudice', 'Jane Austen', 'A classic romance that explores manners, morality, and love in 19th-century England.', 'Fiction, Romance', 'https://covers.openlibrary.org/b/id/8091016-L.jpg', 6, 1),
(6, 'The Lord of the Rings', 'J.R.R. Tolkien', 'An epic fantasy adventure in Middle-earth filled with battles, magic, and friendship.', 'Fantasy, Adventure', 'https://covers.openlibrary.org/b/id/8231851-L.jpg', 8, 1),
(7, 'Animal Farm', 'George Orwell', 'A satirical allegory of the Russian Revolution and Soviet totalitarianism.', 'Fiction, Satire', 'https://covers.openlibrary.org/b/id/8225262-L.jpg', 7, 1),
(8, 'Jane Eyre', 'Charlotte Bronte', 'The story of an orphaned girl who overcomes hardship to find love and independence.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8225111-L.jpg', NULL, 0),
(9, 'Brave New World', 'Aldous Huxley', 'A futuristic society controlled by technology, genetic manipulation, and social conditioning.', 'Fiction, Dystopia', 'https://covers.openlibrary.org/b/id/8225121-L.jpg', NULL, 0),
(10, 'Wuthering Heights', 'Emily Bronte', 'A turbulent tale of passion and revenge set on the Yorkshire moors.', 'Fiction, Romance', 'https://covers.openlibrary.org/b/id/8231996-L.jpg', NULL, 0),
(11, 'The Hobbit', 'J.R.R. Tolkien', 'A fantasy adventure about Bilbo Baggins and his unexpected journey.', 'Fantasy, Adventure', 'https://covers.openlibrary.org/b/id/6979861-L.jpg', NULL, 0),
(12, 'Fahrenheit 451', 'Ray Bradbury', 'A dystopian vision where books are banned and \"firemen\" burn any that are found.', 'Fiction, Dystopia', 'https://covers.openlibrary.org/b/id/8232000-L.jpg', NULL, 0),
(13, 'Moby-Dick', 'Herman Melville', 'The epic tale of Captain Ahab\'s obsessive quest to kill a giant white whale.', 'Fiction, Adventure', 'https://covers.openlibrary.org/b/id/5551116-L.jpg', NULL, 0),
(14, 'The Odyssey', 'Homer', 'An ancient Greek epic poem recounting Odysseus\' long journey home after the Trojan War.', 'Classics, Epic', 'https://covers.openlibrary.org/b/id/8231991-L.jpg', NULL, 0),
(15, 'Crime and Punishment', 'Fyodor Dostoevsky', 'A psychological exploration of guilt, redemption, and the nature of evil.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8225321-L.jpg', NULL, 0),
(16, 'Great Expectations', 'Charles Dickens', 'The coming-of-age story of Pip and the influence of wealth and society.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8225331-L.jpg', NULL, 0),
(17, 'The Adventures of Huckleberry Finn', 'Mark Twain', 'A tale of adventure and freedom along the Mississippi River.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8225341-L.jpg', NULL, 0),
(18, 'The Divine Comedy', 'Dante Alighieri', 'A monumental epic poem describing the journey through Hell, Purgatory, and Paradise.', 'Classics, Epic', 'https://covers.openlibrary.org/b/id/8225351-L.jpg', NULL, 0),
(19, 'Les Misérables', 'Victor Hugo', 'A sweeping narrative of love, justice, and revolution in 19th-century France.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8232041-L.jpg', NULL, 0),
(20, 'War and Peace', 'Leo Tolstoy', 'An epic novel that interweaves personal and historical narratives during the Napoleonic Wars.', 'Fiction, Historical', 'https://covers.openlibrary.org/b/id/8232051-L.jpg', NULL, 0),
(21, 'The Brothers Karamazov', 'Fyodor Dostoevsky', 'A profound exploration of faith, doubt, and the nature of free will.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8225361-L.jpg', NULL, 0),
(22, 'Madame Bovary', 'Gustave Flaubert', 'A tragic story of a woman driven by desire and the search for fulfillment.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8225371-L.jpg', NULL, 0),
(23, 'The Iliad', 'Homer', 'An epic poem about the events of the Trojan War and heroic exploits.', 'Classics, Epic', 'https://covers.openlibrary.org/b/id/8232061-L.jpg', NULL, 0),
(24, 'One Hundred Years of Solitude', 'Gabriel Garcia Marquez', 'A magical realist saga chronicling the multi-generational story of the Buendía family.', 'Fiction, Magical Realism', 'https://covers.openlibrary.org/b/id/8232071-L.jpg', 6, 1),
(25, 'Catch-22', 'Joseph Heller', 'A satirical novel about the absurdities of war and bureaucratic operations.', 'Fiction, Satire', 'https://covers.openlibrary.org/b/id/8225381-L.jpg', NULL, 0),
(26, 'The Sound and the Fury', 'William Faulkner', 'A challenging narrative of a Southern family’s decline told in a stream-of-consciousness style.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8225391-L.jpg', NULL, 0),
(27, 'The Grapes of Wrath', 'John Steinbeck', 'A novel about the hardships of American farmers during the Great Depression.', 'Fiction, Historical', 'https://covers.openlibrary.org/b/id/8225401-L.jpg', NULL, 0),
(28, 'The Old Man and the Sea', 'Ernest Hemingway', 'A story of an aging fisherman\'s epic struggle with a giant marlin in the Gulf Stream.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8225411-L.jpg', NULL, 0),
(29, 'A Tale of Two Cities', 'Charles Dickens', 'A story of love, sacrifice, and revolution set against the backdrop of the French Revolution.', 'Fiction, Historical', 'https://covers.openlibrary.org/b/id/8225421-L.jpg', 8, 1),
(30, 'Don Quixote', 'Miguel de Cervantes', 'A classic Spanish novel about a man who imagines himself a knight-errant.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8225431-L.jpg', NULL, 0),
(31, 'The Picture of Dorian Gray', 'Oscar Wilde', 'A novel exploring vanity, corruption, and the nature of beauty through a man who never ages.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8225441-L.jpg', NULL, 0),
(32, 'Lolita', 'Vladimir Nabokov', 'A controversial novel about obsession, forbidden love, and the manipulation of desire.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8225451-L.jpg', NULL, 0),
(33, 'The Sun Also Rises', 'Ernest Hemingway', 'A story of post-war disillusionment among expatriates in Europe.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8225461-L.jpg', NULL, 0),
(34, 'A Clockwork Orange', 'Anthony Burgess', 'A dystopian novel about youth violence and state control.', 'Adventure, Fiction, Action', 'https://covers.openlibrary.org/b/id/8225471-L.jpg', 7, 1),
(35, 'Ulysses', 'James Joyce', 'A modernist novel chronicling a single day in Dublin with experimental narrative techniques.', 'Fiction, Modernist', 'https://covers.openlibrary.org/b/id/8225481-L.jpg', NULL, 0),
(36, 'Frankenstein', 'Mary Shelley', 'A gothic tale about a scientist who creates life—and faces terrible consequences.', 'Fiction, Horror', 'https://covers.openlibrary.org/b/id/8225491-L.jpg', NULL, 0),
(37, 'Dracula', 'Bram Stoker', 'A horror classic chronicling the legend of Count Dracula and his quest for blood.', 'Fiction, Horror', 'https://covers.openlibrary.org/b/id/8225501-L.jpg', NULL, 0),
(38, 'The Count of Monte Cristo', 'Alexandre Dumas', 'A tale of betrayal, revenge, and redemption set in 19th-century France.', 'Fiction, Adventure', 'https://covers.openlibrary.org/b/id/8225511-L.jpg', NULL, 0),
(39, 'The Kite Runner', 'Khaled Hosseini', 'A moving story of friendship and redemption set against the backdrop of Afghanistan\'s turbulent history.', 'Fiction, Drama', 'https://covers.openlibrary.org/b/id/8225521-L.jpg', NULL, 0),
(40, 'Life of Pi', 'Yann Martel', 'A fantastical survival story of a young boy stranded on a lifeboat with a Bengal tiger.', 'Fiction, Adventure', 'https://covers.openlibrary.org/b/id/8225531-L.jpg', NULL, 0),
(41, 'The Road', 'Cormac McCarthy', 'A bleak, post-apocalyptic journey of a father and son through a devastated landscape.', 'Fiction, Dystopia', 'https://covers.openlibrary.org/b/id/8225541-L.jpg', NULL, 0),
(42, 'Memoirs of a Geisha', 'Arthur Golden', 'A historical novel about a young Japanese girl who rises to become a renowned geisha.', 'Fiction, Historical', 'https://covers.openlibrary.org/b/id/8225551-L.jpg', NULL, 0),
(43, 'Gone with the Wind', 'Margaret Mitchell', 'A sweeping epic of love and loss during the American Civil War.', 'Fiction, Historical', 'https://covers.openlibrary.org/b/id/8225561-L.jpg', NULL, 0),
(44, 'The Da Vinci Code', 'Dan Brown', 'A fast-paced mystery blending art, history, and conspiracy in a modern thriller.', 'Fiction, Mystery', 'https://covers.openlibrary.org/b/id/8225571-L.jpg', NULL, 0),
(45, 'Harry Potter and the Sorcerer\'s Stone', 'J.K. Rowling', 'The first book in the magical series about a young wizard and his adventures.', 'Fantasy, Adventure', 'https://covers.openlibrary.org/b/id/8225581-L.jpg', NULL, 0),
(46, 'Harry Potter and the Chamber of Secrets', 'J.K. Rowling', 'The second installment of the Harry Potter series, full of mystery and magic.', 'Fantasy, Adventure', 'https://covers.openlibrary.org/b/id/8225591-L.jpg', NULL, 0),
(47, 'Harry Potter and the Prisoner of Azkaban', 'J.K. Rowling', 'The third book in the series, with darker themes and new dangers.', 'Fantasy, Adventure', 'https://covers.openlibrary.org/b/id/8225601-L.jpg', NULL, 0),
(48, 'Harry Potter and the Goblet of Fire', 'J.K. Rowling', 'The fourth book where Harry competes in a dangerous magical tournament.', 'Fantasy, Adventure', 'https://covers.openlibrary.org/b/id/8225611-L.jpg', NULL, 0),
(49, 'Harry Potter and the Order of the Phoenix', 'J.K. Rowling', 'The fifth book, chronicling Harry’s struggle against dark forces.', 'Fantasy, Adventure', 'https://covers.openlibrary.org/b/id/8225621-L.jpg', NULL, 0),
(50, 'Harry Potter and the Half-Blood Prince', 'J.K. Rowling', 'The sixth book, revealing secrets of the dark lord.', 'Fantasy, Adventure', 'https://covers.openlibrary.org/b/id/8225631-L.jpg', NULL, 0),
(51, 'Harry Potter and the Deathly Hallows', 'J.K. Rowling', 'The final installment of the series, concluding Harry’s epic journey.', 'Fantasy, Adventure', 'https://covers.openlibrary.org/b/id/8225641-L.jpg', NULL, 0),
(52, 'The Hunger Games', 'Suzanne Collins', 'A dystopian novel where teenagers fight to the death in a televised competition.', 'Fiction, Dystopia', 'https://covers.openlibrary.org/b/id/8225651-L.jpg', NULL, 0),
(53, 'Catching Fire', 'Suzanne Collins', 'The second book in The Hunger Games trilogy, intensifying the rebellion.', 'Fiction, Dystopia', 'https://covers.openlibrary.org/b/id/8225661-L.jpg', NULL, 0),
(54, 'Mockingjay', 'Suzanne Collins', 'The final installment of the dystopian trilogy, focusing on revolution and sacrifice.', 'Fiction, Dystopia', 'https://covers.openlibrary.org/b/id/8225671-L.jpg', NULL, 0),
(55, 'The Girl with the Dragon Tattoo', 'Stieg Larsson', 'A gripping mystery thriller with complex characters and dark secrets.', 'Fiction, Mystery', 'https://covers.openlibrary.org/b/id/8225681-L.jpg', NULL, 0),
(56, 'The Fault in Our Stars', 'John Green', 'A touching love story between two teenagers facing terminal illness.', 'Fiction, Romance', 'https://covers.openlibrary.org/b/id/8225691-L.jpg', NULL, 0),
(57, 'Divergent', 'Veronica Roth', 'In a divided society, one girl discovers her unique identity and challenges the system.', 'Fiction, Dystopia', 'https://covers.openlibrary.org/b/id/8225701-L.jpg', NULL, 0),
(58, 'The Maze Runner', 'James Dashner', 'A group of teens must navigate a deadly maze with no memory of the outside world.', 'Fiction, Dystopia', 'https://covers.openlibrary.org/b/id/8225711-L.jpg', NULL, 0),
(59, 'Fifty Shades of Grey', 'E.L. James', 'A controversial romance exploring themes of desire and control.', 'Fiction, Romance', 'https://covers.openlibrary.org/b/id/8225721-L.jpg', NULL, 0),
(60, 'The Shining', 'Stephen King', 'A horror novel about an isolated hotel haunted by supernatural forces.', 'Fiction, Horror', 'https://covers.openlibrary.org/b/id/8225731-L.jpg', NULL, 0),
(61, 'It', 'Stephen King', 'A terrifying tale of a shape-shifting entity that preys on the fears of a small town.', 'Fiction, Horror', 'https://covers.openlibrary.org/b/id/8225741-L.jpg', NULL, 0),
(62, 'The Stand', 'Stephen King', 'An epic struggle between good and evil in a post-apocalyptic world.', 'Fiction, Horror', 'https://covers.openlibrary.org/b/id/8225751-L.jpg', NULL, 0),
(63, 'A Game of Thrones', 'George R.R. Martin', 'The first book in the epic fantasy series, setting the stage for political intrigue and war.', 'Fantasy, Adventure', 'https://covers.openlibrary.org/b/id/8225761-L.jpg', NULL, 0),
(64, 'A Clash of Kings', 'George R.R. Martin', 'The second installment in the epic fantasy series, with battles for power and survival.', 'Adventure, Fantasy', 'https://covers.openlibrary.org/b/id/8225771-L.jpg', 3, 1),
(65, 'A Storm of Swords', 'George R.R. Martin', 'A pivotal entry in the series marked by betrayal, revenge, and dramatic twists.', 'Fantasy, Adventure', 'https://covers.openlibrary.org/b/id/8225781-L.jpg', 7, 1),
(66, 'A Feast for Crows', 'George R.R. Martin', 'A continuation of the epic saga with new challenges and political intrigue.', 'Fantasy, Adventure', 'https://covers.openlibrary.org/b/id/8225791-L.jpg', NULL, 0),
(67, 'A Dance with Dragons', 'George R.R. Martin', 'The fifth book in the series, depicting power struggles and unexpected alliances.', 'Adventure, Fantasy', 'https://covers.openlibrary.org/b/id/8225801-L.jpg', NULL, 0),
(68, 'The Name of the Wind', 'Patrick Rothfuss', 'The first book in the Kingkiller Chronicle, recounting the adventures of a legendary wizard.', 'Fantasy, Adventure', 'https://covers.openlibrary.org/b/id/8225811-L.jpg', NULL, 0),
(69, 'The Wise Man\'s Fear', 'Patrick Rothfuss', 'The second installment of the Kingkiller Chronicle, continuing the epic tale.', 'Fantasy, Adventure', 'https://covers.openlibrary.org/b/id/8225821-L.jpg', NULL, 0),
(70, 'The Alchemist', 'Paulo Coelho', 'A philosophical story of a shepherd boy on a journey to discover his destiny.', 'Fiction, Adventure', 'https://covers.openlibrary.org/b/id/8225831-L.jpg', NULL, 0),
(71, 'The Little Prince', 'Antoine de Saint-Exupéry', 'A poetic tale of a young prince exploring life, love, and loss.', 'Fiction, Classics', 'https://covers.openlibrary.org/b/id/8225841-L.jpg', NULL, 0),
(72, 'Siddhartha', 'Hermann Hesse', 'A novel about a man\'s journey toward enlightenment and self-discovery.', 'Fiction, Philosophy', 'https://covers.openlibrary.org/b/id/8225851-L.jpg', NULL, 0),
(73, 'The Book Thief', 'Markus Zusak', 'A moving story narrated by Death about a young girl in Nazi Germany.', 'Fiction, Historical', 'https://covers.openlibrary.org/b/id/8225861-L.jpg', NULL, 0),
(74, 'All the Light We Cannot See', 'Anthony Doerr', 'A novel about the lives of a blind French girl and a German boy during WWII.', 'Fiction, Historical', 'https://covers.openlibrary.org/b/id/8225871-L.jpg', NULL, 0),
(75, 'The Help', 'Kathryn Stockett', 'A story of African American maids working in white households in the segregated South.', 'Fiction, Historical', 'https://covers.openlibrary.org/b/id/8225881-L.jpg', NULL, 0),
(76, 'A Thousand Splendid Suns', 'Khaled Hosseini', 'The tale of two Afghan women whose lives become intertwined by fate and hardship.', 'Fiction, Drama', 'https://covers.openlibrary.org/b/id/8225891-L.jpg', NULL, 0),
(77, 'The Secret Life of Bees', 'Sue Monk Kidd', 'A novel about a young girl finding solace and family among beekeeping women in the South.', 'Fiction, Historical', 'https://covers.openlibrary.org/b/id/8225901-L.jpg', NULL, 0),
(78, 'Never Let Me Go', 'Kazuo Ishiguro', 'A dystopian tale of a boarding school with a dark secret about its students.', 'Fiction, Dystopia', 'https://covers.openlibrary.org/b/id/8225911-L.jpg', NULL, 0),
(79, 'The Time Traveler\'s Wife', 'Audrey Niffenegger', 'A love story about a man with a genetic disorder that causes unpredictable time travel.', 'Fiction, Romance', 'https://covers.openlibrary.org/b/id/8225921-L.jpg', NULL, 0),
(80, 'Memoirs of a Geisha', 'Arthur Golden', 'A historical novel that chronicles the life of a geisha in Japan.', 'Fiction, Historical', 'https://covers.openlibrary.org/b/id/8225931-L.jpg', NULL, 0),
(81, 'The Shadow of the Wind', 'Carlos Ruiz Zafón', 'A mystery about a young boy who discovers a forgotten book and unravels its dark past.', 'Fiction, Mystery', 'https://covers.openlibrary.org/b/id/8225941-L.jpg', NULL, 0),
(82, 'The Curious Incident of the Dog in the Night-Time', 'Mark Haddon', 'A novel about an autistic boy investigating the death of a neighbor\'s dog.', 'Fiction, Mystery', 'https://covers.openlibrary.org/b/id/8225951-L.jpg', NULL, 0),
(83, 'The Girl on the Train', 'Paula Hawkins', 'A psychological thriller about a woman who becomes entangled in a missing persons investigation.', 'Fiction, Thriller', 'https://covers.openlibrary.org/b/id/8225961-L.jpg', NULL, 0),
(84, 'Gone Girl', 'Gillian Flynn', 'A dark mystery about a marriage gone terribly wrong.', 'Fiction, Thriller', 'https://covers.openlibrary.org/b/id/8225971-L.jpg', NULL, 0),
(85, 'The Goldfinch', 'Donna Tartt', 'A sweeping story of loss, art, and redemption following a tragic accident.', 'Fiction, Drama', 'https://covers.openlibrary.org/b/id/8225981-L.jpg', NULL, 0),
(86, 'The Nightingale', 'Kristin Hannah', 'A novel about the courage of two sisters during WWII in Nazi-occupied France.', 'Fiction, Historical', 'https://covers.openlibrary.org/b/id/8225991-L.jpg', NULL, 0),
(87, 'Where the Crawdads Sing', 'Delia Owens', 'A coming-of-age mystery set in the marshlands of North Carolina.', 'Fiction, Mystery', 'https://covers.openlibrary.org/b/id/8226001-L.jpg', NULL, 0),
(88, 'Educated', 'Tara Westover', 'A memoir of a woman who grew up in a strict and abusive household and eventually earned a PhD.', 'Memoir, Non-Fiction', 'https://covers.openlibrary.org/b/id/8226011-L.jpg', NULL, 0),
(89, 'Becoming', 'Michelle Obama', 'The former First Lady shares the experiences that have shaped her.', 'Memoir, Non-Fiction', 'https://covers.openlibrary.org/b/id/8226021-L.jpg', 8, 1),
(90, 'The Silent Patient', 'Alex Michaelides', 'A psychological thriller about a woman who stops speaking after committing a violent act.', 'Fiction, Thriller', 'https://covers.openlibrary.org/b/id/8226031-L.jpg', NULL, 0),
(91, 'Normal People', 'Sally Rooney', 'A novel exploring the complex relationship between two young people from different backgrounds.', 'Fiction, Romance', 'https://covers.openlibrary.org/b/id/8226041-L.jpg', NULL, 0),
(92, 'The Vanishing Half', 'Brit Bennett', 'A story of twin sisters who live in two very different worlds.', 'Fiction, Drama', 'https://covers.openlibrary.org/b/id/8226051-L.jpg', NULL, 0),
(93, 'The Midnight Library', 'Matt Haig', 'A novel about a library that contains an infinite number of lives one could have lived.', 'Fiction, Fantasy', 'https://covers.openlibrary.org/b/id/8226061-L.jpg', NULL, 0),
(94, 'Klara and the Sun', 'Kazuo Ishiguro', 'A novel narrated by an Artificial Friend exploring love, humanity, and what it means to be alive.', 'Fiction, Sci-Fi', 'https://covers.openlibrary.org/b/id/8226071-L.jpg', NULL, 0),
(95, 'Project Hail Mary', 'Andy Weir', 'A thrilling tale of survival and ingenuity in space as a lone astronaut battles an extinction-level threat.', 'Fiction, Sci-Fi', 'https://covers.openlibrary.org/b/id/8226081-L.jpg', NULL, 0),
(96, 'The Four Winds', 'Kristin Hannah', 'A story of love, resilience, and the fight for survival during the Great Depression.', 'Fiction, Historical', 'https://covers.openlibrary.org/b/id/8226091-L.jpg', NULL, 0),
(97, 'The Last Thing He Told Me', 'Laura Dave', 'A suspenseful mystery about a woman who must piece together her missing husband’s secrets.', 'Fiction, Thriller', 'https://covers.openlibrary.org/b/id/8226101-L.jpg', NULL, 0),
(98, 'Verity', 'Colleen Hoover', 'A psychological thriller that blurs the lines between truth and fiction.', 'Fiction, Thriller', 'https://covers.openlibrary.org/b/id/8226111-L.jpg', NULL, 0),
(99, 'It Ends with Us', 'Colleen Hoover', 'A powerful novel about love, loss, and the complexity of relationships.', 'Fiction, Romance', 'https://covers.openlibrary.org/b/id/8226121-L.jpg', NULL, 0),
(100, 'The Last Thing He Told Me', 'Laura Dave', 'A suspenseful mystery about family secrets and personal discovery.', 'Fiction, Thriller', 'https://covers.openlibrary.org/b/id/8226131-L.jpg', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `book_genres`
--

CREATE TABLE `book_genres` (
  `Book_ID` int(11) NOT NULL,
  `Genre_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_genres`
--

INSERT INTO `book_genres` (`Book_ID`, `Genre_ID`) VALUES
(1, 10),
(2, 19),
(3, 10),
(4, 10),
(5, 10),
(5, 29),
(6, 1),
(6, 8),
(7, 10),
(8, 10),
(9, 10),
(10, 10),
(10, 29),
(11, 1),
(11, 8),
(12, 10),
(13, 1),
(13, 10),
(15, 10),
(16, 10),
(17, 10),
(19, 10),
(20, 10),
(21, 10),
(22, 10),
(24, 10),
(25, 10),
(26, 10),
(27, 10),
(28, 10),
(29, 10),
(30, 10),
(31, 10),
(32, 10),
(33, 10),
(34, 1),
(34, 10),
(34, 19),
(35, 10),
(36, 10),
(36, 15),
(37, 10),
(37, 15),
(38, 1),
(38, 10),
(39, 10),
(40, 1),
(40, 10),
(41, 10),
(42, 10),
(43, 10),
(44, 10),
(44, 24),
(45, 1),
(45, 8),
(46, 1),
(46, 8),
(47, 1),
(47, 8),
(48, 1),
(48, 8),
(49, 1),
(49, 8),
(50, 1),
(50, 8),
(51, 1),
(51, 8),
(52, 10),
(53, 10),
(54, 10),
(55, 10),
(55, 24),
(56, 10),
(56, 29),
(57, 10),
(58, 10),
(59, 10),
(59, 29),
(60, 10),
(60, 15),
(61, 10),
(61, 15),
(62, 10),
(62, 15),
(63, 1),
(63, 8),
(64, 1),
(64, 8),
(65, 1),
(65, 8),
(66, 1),
(66, 8),
(67, 1),
(67, 8),
(68, 1),
(68, 8),
(69, 1),
(69, 8),
(70, 1),
(70, 10),
(71, 10),
(72, 10),
(72, 26),
(73, 10),
(74, 10),
(75, 10),
(76, 10),
(77, 10),
(78, 10),
(79, 10),
(79, 29),
(80, 10),
(81, 10),
(81, 24),
(82, 10),
(82, 24),
(83, 10),
(84, 10),
(85, 10),
(86, 10),
(87, 10),
(87, 24),
(88, 11),
(89, 11),
(90, 10),
(91, 10),
(91, 29),
(92, 10),
(93, 8),
(93, 10),
(94, 10),
(95, 10),
(96, 10),
(97, 10),
(98, 10),
(99, 10),
(99, 29),
(100, 10);

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `Genre_ID` int(11) NOT NULL,
  `Genre_Name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `genre`
--

INSERT INTO `genre` (`Genre_ID`, `Genre_Name`) VALUES
(19, 'Action'),
(1, 'Adventure'),
(2, 'Art'),
(3, 'Biographical'),
(4, 'Business'),
(5, 'Computer/Internet'),
(6, 'Crafts'),
(7, 'Crime/Thriller'),
(8, 'Fantasy'),
(10, 'Fiction'),
(9, 'Food'),
(12, 'Historical Fiction'),
(13, 'History'),
(14, 'Home/Garden'),
(15, 'Horror'),
(16, 'Humor'),
(17, 'Instructional'),
(18, 'Juvenile'),
(20, 'Language'),
(21, 'Literary Classics'),
(22, 'Math/Science/Tech'),
(23, 'Medical'),
(24, 'Mystery'),
(25, 'Nature'),
(11, 'Non-Fiction'),
(26, 'Philosophy'),
(27, 'Pol/Soc/Relig'),
(28, 'Recreation'),
(29, 'Romance'),
(30, 'Science Fiction'),
(31, 'Self-Help'),
(32, 'Travel/Adventure'),
(33, 'True Crime'),
(34, 'Urban Fantasy'),
(35, 'Western');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `Person_ID` int(11) NOT NULL,
  `Username` varchar(50) NOT NULL,
  `Join_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `Email` varchar(50) NOT NULL,
  `Role` tinyint(1) DEFAULT NULL,
  `BanStatus` timestamp NULL DEFAULT NULL,
  `InSession` tinyint(1) DEFAULT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`Person_ID`, `Username`, `Join_Date`, `Email`, `Role`, `BanStatus`, `InSession`, `Password`) VALUES
(14, 'Ali G', '2025-05-04 10:47:22', 'ali@vu.com', 1, NULL, 0, 'pw'),
(1, 'Ihtsham', '2025-05-04 10:47:22', 'ihtsham@vu.com', 0, NULL, 0, 'pw'),
(37, 'Ihtsham', '2025-05-09 13:47:54', 'a@aba', 0, NULL, 0, 'pw'),
(10, 'user10', '2025-05-04 10:47:22', 'user10@example.com', 0, NULL, 0, 'pw'),
(11, 'user11', '2025-05-04 10:47:22', 'user11@example.com', 0, NULL, 0, 'pw'),
(12, 'user12', '2025-05-04 10:47:22', 'user12@example.com', 0, NULL, 0, 'pw'),
(13, 'user13', '2025-05-04 10:47:22', 'user13@example.com', 0, NULL, 0, 'pw'),
(15, 'user15', '2025-05-04 10:47:22', 'user15@example.com', 0, NULL, 0, 'pw'),
(16, 'user16', '2025-05-04 10:47:22', 'user16@example.com', 0, NULL, 0, 'pw'),
(17, 'user17', '2025-05-04 10:47:22', 'user17@example.com', 0, NULL, 0, 'pw'),
(18, 'user18', '2025-05-04 10:47:22', 'user18@example.com', 0, NULL, 0, 'pw'),
(19, 'user19', '2025-05-04 10:47:22', 'user19@example.com', 0, NULL, 0, 'pw'),
(2, 'user2', '2025-05-04 10:47:22', 'user2@example.com', 0, NULL, 0, 'pw'),
(20, 'user20', '2025-05-04 10:47:22', 'user20@example.com', 0, NULL, 0, 'pw'),
(21, 'user21', '2025-05-04 10:47:22', 'user21@example.com', 0, NULL, 0, 'pw'),
(22, 'user22', '2025-05-04 10:47:22', 'user22@example.com', 0, NULL, 0, 'pw'),
(23, 'user23', '2025-05-04 10:47:22', 'user23@example.com', 0, NULL, 0, 'pw'),
(24, 'user24', '2025-05-04 10:47:22', 'user24@example.com', 0, NULL, 0, 'pw'),
(25, 'user25', '2025-05-04 10:47:22', 'user25@example.com', 0, NULL, 0, 'pw'),
(26, 'user26', '2025-05-04 10:47:22', 'user26@example.com', 0, NULL, 0, 'pw'),
(27, 'user27', '2025-05-04 10:47:22', 'user27@example.com', 0, NULL, 0, 'pw'),
(28, 'user28', '2025-05-04 10:47:22', 'user28@example.com', 0, NULL, 0, 'pw'),
(29, 'user29', '2025-05-04 10:47:22', 'user29@example.com', 0, NULL, 0, 'pw'),
(3, 'user3', '2025-05-04 10:47:22', 'user3@example.com', 0, NULL, 0, 'pw'),
(30, 'user30', '2025-05-04 10:47:22', 'user30@example.com', 0, NULL, 0, 'pw'),
(31, 'user31', '2025-05-04 10:47:22', 'user31@example.com', 0, NULL, 0, 'pw'),
(32, 'user32', '2025-05-04 10:47:22', 'user32@example.com', 0, NULL, 0, 'pw'),
(33, 'user33', '2025-05-04 10:47:22', 'user33@example.com', 0, NULL, 0, 'pw'),
(34, 'user34', '2025-05-04 10:47:22', 'user34@example.com', 0, NULL, 0, 'pw'),
(35, 'user35', '2025-05-04 10:47:22', 'user35@example.com', 0, NULL, 0, 'pw'),
(4, 'user4', '2025-05-04 10:47:22', 'user4@example.com', 0, NULL, 0, 'pw'),
(5, 'user5', '2025-05-04 10:47:22', 'user5@example.com', 0, NULL, 0, 'pw'),
(6, 'user6', '2025-05-04 10:47:22', 'user6@example.com', 0, NULL, 0, 'pw'),
(7, 'user7', '2025-05-04 10:47:22', 'user7@example.com', 0, NULL, 0, 'pw'),
(8, 'user8', '2025-05-04 10:47:22', 'user8@example.com', 0, NULL, 0, 'pw'),
(9, 'user9', '2025-05-04 10:47:22', 'user9@example.com', 0, NULL, 0, 'pw');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `Person_ID` int(11) NOT NULL,
  `Book_ID` int(11) NOT NULL,
  `Rating` int(11) DEFAULT NULL,
  `rating_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`Person_ID`, `Book_ID`, `Rating`, `rating_id`) VALUES
(14, 64, 3, 113),
(14, 6, 8, 115),
(14, 1, 10, 116),
(14, 24, 6, 117),
(14, 2, 8, 120),
(14, 3, 9, 121),
(14, 4, 10, 122),
(14, 7, 7, 123),
(14, 5, 6, 124),
(14, 29, 8, 125),
(14, 65, 7, 126),
(1, 2, 4, 127),
(2, 2, 8, 128),
(3, 2, 8, 129),
(4, 2, 6, 130),
(5, 2, 3, 131),
(6, 2, 10, 132),
(7, 2, 8, 133),
(8, 2, 2, 134),
(9, 2, 5, 135),
(10, 2, 7, 136),
(11, 2, 1, 137),
(12, 2, 2, 138),
(13, 2, 6, 139),
(15, 2, 8, 141),
(16, 2, 5, 142),
(17, 2, 9, 143),
(18, 2, 9, 144),
(19, 2, 6, 145),
(20, 2, 5, 146),
(21, 2, 5, 147),
(22, 2, 10, 148),
(23, 2, 3, 149),
(24, 2, 5, 150),
(25, 2, 7, 151),
(26, 2, 8, 152),
(27, 2, 1, 153),
(28, 2, 9, 154),
(29, 2, 1, 155),
(30, 2, 7, 156),
(31, 2, 4, 157),
(32, 2, 7, 158),
(33, 2, 2, 159),
(34, 2, 9, 160),
(35, 2, 8, 161),
(14, 89, 8, 190),
(14, 34, 7, 191);

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `Person_ID` int(11) NOT NULL,
  `Book_ID` int(11) NOT NULL,
  `Title` varchar(500) DEFAULT NULL,
  `Content` varchar(2000) DEFAULT NULL,
  `Contains_Spoilers` tinyint(1) DEFAULT NULL,
  `Review_Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `InDltProcess` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`Person_ID`, `Book_ID`, `Title`, `Content`, `Contains_Spoilers`, `Review_Date`, `InDltProcess`) VALUES
(1, 2, 'Captivating Start', 'I was immediately hooked by the opening chapters.', 1, '2025-05-04 16:36:14', 0),
(1, 7, 'sdafdas', 'sdf idk', 1, '2025-05-04 16:59:35', 0),
(1, 15, 'sadf', 'what am I postinnnng', 1, '2025-05-04 16:59:49', 0),
(1, 46, 'dsajf', 'IDK this is good or bad', 1, '2025-05-04 17:00:14', 0),
(1, 53, 'abc', 'Catching some fire', 1, '2025-05-04 17:00:37', 0),
(1, 63, 'asdf', 'rr wrote crap', 1, '2025-05-04 16:58:49', 0),
(1, 64, 'theis woudl be firstt review', 'asdljfk', 1, '2025-05-04 11:09:44', 0),
(1, 65, 'dsafdsa', 'rr is good', 1, '2025-05-05 14:45:15', 0),
(1, 76, 'asdf', 'full book is the book that is full but isn\'t full or is full not sure but am suren\'t I don\'t know what to sayin\'t', 0, '2025-05-05 14:45:27', 0),
(1, 89, 'asdfa', 'I like emilye', 1, '2025-05-04 16:59:18', 0),
(2, 2, 'Informative Guide', 'A very informative guide with clear explanations.', 0, '2025-05-04 10:50:53', 0),
(3, 2, 'Too Dense', 'The material felt too dense in some sections.', 0, '2025-05-04 10:50:53', 0),
(4, 2, 'Well Researched', 'This book is well researched and detailed.', 0, '2025-05-04 10:50:53', 0),
(5, 2, 'Great Examples', 'Loved the real-world examples used.', 0, '2025-05-04 10:50:53', 0),
(6, 2, 'Shocking Twist', 'The plot twist about the protagonist was unexpected.', 1, '2025-05-04 10:50:53', 0),
(7, 2, 'Helpful Tips', 'Contains practical tips that I applied immediately.', 0, '2025-05-04 10:50:53', 0),
(8, 2, 'Engaging Narrative', 'The narrative style kept me engaged throughout.', 0, '2025-05-04 10:50:53', 0),
(9, 2, 'A Bit Repetitive', 'Some points were repeated too often.', 0, '2025-05-04 10:50:53', 0),
(10, 2, 'Character Arc', 'The main character’s journey took a surprising turn.', 1, '2025-05-04 10:50:53', 0),
(11, 2, 'Excellent Writing', 'The writing style is elegant and clear.', 0, '2025-05-04 10:50:53', 0),
(12, 2, 'Not for Beginners', 'Assumes prior knowledge; not great for newbies.', 0, '2025-05-04 10:50:53', 0),
(13, 2, 'Well Structured', 'The chapters flow logically and build on each other.', 0, '2025-05-04 10:50:53', 0),
(14, 2, 'Insightful Observations', 'Offers insightful observations on the subject.', 1, '2025-05-12 20:47:08', 0),
(14, 64, 'SAFDS', 'SDF', 0, '2025-05-12 16:31:51', 0),
(15, 2, 'Hidden Agenda', 'The antagonist had a hidden agenda all along.', 1, '2025-05-04 10:50:53', 0),
(16, 2, 'Thorough Analysis', 'Provides a thorough analysis of key concepts.', 0, '2025-05-04 10:50:53', 0),
(17, 2, 'Long Winded', 'Some sections felt unnecessarily long.', 0, '2025-05-04 10:50:53', 0),
(18, 2, 'Clear Explanations', 'Complex ideas broken down clearly.', 0, '2025-05-04 10:50:53', 0),
(19, 2, 'Unexpected Death', 'Did not expect that character to die.', 1, '2025-05-04 10:50:53', 0),
(20, 2, 'Great References', 'Includes great references for further reading.', 0, '2025-05-04 10:50:53', 0),
(21, 2, 'Engrossing', 'Kept me engrossed from start to finish.', 0, '2025-05-04 10:50:53', 0),
(22, 2, 'Key Revelation', 'The key revelation changed my perspective.', 1, '2025-05-04 10:50:53', 0),
(23, 2, 'Well-Paced', 'Pacing was spot on throughout the book.', 0, '2025-05-04 10:50:53', 0),
(24, 2, 'Too Technical', 'Sometimes it got too technical for me.', 0, '2025-05-04 10:50:53', 0),
(25, 2, 'Highly Recommend', 'I would highly recommend this to others.', 0, '2025-05-04 10:50:53', 0),
(26, 2, 'Final Confrontation', 'The final confrontation scene was thrilling.', 1, '2025-05-04 10:50:53', 0),
(27, 2, 'Concise', 'Concise and to the point; no fluff.', 0, '2025-05-04 10:50:53', 0),
(28, 2, 'Dry at Times', 'Occasionally the tone felt dry.', 0, '2025-05-04 10:50:53', 0),
(29, 2, 'Secret Revealed', 'The secret revealed midway was surprising.', 1, '2025-05-04 10:50:53', 0),
(30, 2, 'Well Edited', 'Editing was clean with no obvious errors.', 0, '2025-05-04 10:50:53', 0),
(31, 2, 'Thought-Provoking', 'Really made me think about the topic.', 0, '2025-05-04 10:50:53', 0),
(32, 2, 'Character Betrayal', 'The betrayal scene was the highlight.', 1, '2025-05-04 10:50:53', 0),
(33, 2, 'Engaging Dialogue', 'Dialogue felt natural and engaging.', 0, '2025-05-04 10:50:53', 0),
(34, 2, 'A Bit Slow', 'Took a while to pick up pace.', 0, '2025-05-04 10:50:53', 0),
(35, 2, 'Climactic Ending', 'The climactic ending was very satisfying.', 1, '2025-05-04 10:50:53', 0);

-- --------------------------------------------------------

--
-- Table structure for table `statistics`
--

CREATE TABLE `statistics` (
  `Summary_ID` int(11) NOT NULL,
  `Total_Books` int(11) DEFAULT NULL,
  `Total_Users` int(11) DEFAULT NULL,
  `Total_Reviews` int(11) DEFAULT NULL,
  `Active_Users` int(11) DEFAULT NULL,
  `Reviews_This_Month` int(11) DEFAULT NULL,
  `Books_This_Month` int(11) DEFAULT NULL,
  `Last_Updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `Person_ID` int(11) NOT NULL,
  `Book_ID` int(11) NOT NULL,
  `wishlist_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`Person_ID`, `Book_ID`, `wishlist_id`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3),
(1, 4, 4),
(1, 7, 5),
(1, 9, 6),
(1, 12, 7),
(1, 15, 8),
(1, 24, 9),
(1, 25, 10),
(1, 29, 11),
(1, 30, 12),
(1, 34, 13),
(1, 36, 14),
(1, 37, 15),
(1, 51, 16),
(1, 57, 17),
(1, 59, 18),
(1, 64, 19),
(1, 65, 20),
(1, 67, 21),
(1, 74, 22),
(1, 84, 23),
(14, 6, 25),
(14, 29, 26),
(14, 34, 27),
(14, 65, 29),
(3, 64, 31),
(3, 34, 32),
(3, 67, 33),
(14, 15, 34),
(14, 46, 43),
(14, 2, 65),
(14, 64, 66);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`Book_ID`),
  ADD KEY `idx_book` (`Title`,`Author`,`Description`(100),`Genre`(100),`Cover_Image`(100),`Curr_Rating`);

--
-- Indexes for table `book_genres`
--
ALTER TABLE `book_genres`
  ADD PRIMARY KEY (`Book_ID`,`Genre_ID`),
  ADD KEY `Genre_ID` (`Genre_ID`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`Genre_ID`),
  ADD UNIQUE KEY `Genre_Name` (`Genre_Name`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`Person_ID`),
  ADD KEY `idx_person` (`Username`,`Join_Date`,`Email`,`Role`,`BanStatus`,`InSession`,`Password`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `idx_rating` (`Rating`),
  ADD KEY `Book_ID` (`Book_ID`),
  ADD KEY `idx_person` (`Person_ID`),
  ADD KEY `idx_book` (`Book_ID`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`Person_ID`,`Book_ID`),
  ADD KEY `Book_ID` (`Book_ID`),
  ADD KEY `idx_review` (`Title`(100),`Content`(200),`Contains_Spoilers`,`Review_Date`,`InDltProcess`);

--
-- Indexes for table `statistics`
--
ALTER TABLE `statistics`
  ADD PRIMARY KEY (`Summary_ID`),
  ADD KEY `idx_statistics` (`Total_Books`,`Total_Users`,`Total_Reviews`,`Active_Users`,`Reviews_This_Month`,`Books_This_Month`,`Last_Updated`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `Book_ID` (`Book_ID`),
  ADD KEY `fk_person` (`Person_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
  MODIFY `Book_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `Genre_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `Person_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=192;

--
-- AUTO_INCREMENT for table `statistics`
--
ALTER TABLE `statistics`
  MODIFY `Summary_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_genres`
--
ALTER TABLE `book_genres`
  ADD CONSTRAINT `book_genres_ibfk_1` FOREIGN KEY (`Book_ID`) REFERENCES `book` (`Book_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_genres_ibfk_2` FOREIGN KEY (`Genre_ID`) REFERENCES `genre` (`Genre_ID`) ON DELETE CASCADE;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`Person_ID`) REFERENCES `person` (`Person_ID`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`Book_ID`) REFERENCES `book` (`Book_ID`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`Person_ID`) REFERENCES `person` (`Person_ID`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`Book_ID`) REFERENCES `book` (`Book_ID`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `fk_book` FOREIGN KEY (`Book_ID`) REFERENCES `book` (`Book_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_person` FOREIGN KEY (`Person_ID`) REFERENCES `person` (`Person_ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
