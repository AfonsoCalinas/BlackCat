-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 02-Jun-2021 às 11:58
-- Versão do servidor: 10.4.19-MariaDB
-- versão do PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `phpproject01`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `memes`
--

CREATE TABLE `memes` (
  `id_meme` int(11) NOT NULL,
  `date_meme` date NOT NULL,
  `time_meme` int(11) NOT NULL,
  `title_meme` varchar(200) NOT NULL,
  `pub_meme` varchar(200) NOT NULL,
  `desc_meme` varchar(200) DEFAULT NULL,
  `user_meme` varchar(200) NOT NULL,
  `type_meme` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `memes`
--

INSERT INTO `memes` (`id_meme`, `date_meme`, `time_meme`, `title_meme`, `pub_meme`, `desc_meme`, `user_meme`, `type_meme`) VALUES
(1, '0000-00-00', 16, 'Da Sun', 'folder_memes/meme1.png', 'Hotter than the sun boyy', 'YellowCat', 0),
(2, '0000-00-00', 16, 'The Government', 'folder_memes/meme2.png', 'They are fooling you', 'YellowCat', 0),
(3, '0000-00-00', 16, 'Wrong Attributes', 'folder_memes/when_your_program_is_a_complete_mess.gif', 'Wrong Object', 'YellowCat', 0),
(4, '0000-00-00', 16, 'Crazy Photos', 'folder_memes/WAVSiZI.mp4', 'Amazing Graphics', 'YellowCat', 1),
(5, '0000-00-00', 18, 'Gato', 'folder_memes/cattest.jpg', 'Gato', 'YellowCat', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `userUid` varchar(128) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `profile`
--

INSERT INTO `profile` (`id`, `userid`, `userUid`, `status`) VALUES
(1, 1, 'YellowCat', 0),
(2, 2, 'BlackCat', 0),
(3, 3, 'Professor', 1),
(4, 4, 'Johny', 0),
(5, 5, 'Mari', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `usersId` int(11) NOT NULL,
  `usersName` varchar(128) NOT NULL,
  `usersEmail` varchar(128) NOT NULL,
  `usersUid` varchar(128) NOT NULL,
  `usersPwd` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`usersId`, `usersName`, `usersEmail`, `usersUid`, `usersPwd`) VALUES
(1, 'Afonso', 'a46892@ubi.pt', 'YellowCat', '$2y$10$WaSNQpyhoPfVTcqwzoeWI.keYizBb6u9DCJdq1iTiafDzDRYRQY4O'),
(2, 'Fernando', 'a45511@ubi.pt', 'BlackCat', '$2y$10$JflR1juBxdfG3pJavlLjMuBfS4W1Vv23QJ35upp4Y7/UQtS5j4mP2'),
(3, 'Sebastião', 'sebastiao@di.ubi.pt', 'Professor', '$2y$10$CuDiEHRfQQTMg5.8edRzYeA9YGFPMEvMIx7jCzHu/r/l40E3oNlUe'),
(4, 'John Jones', 'johnjones@ubi.pt', 'Johny', '$2y$10$TggDsfS1/pGG2rRfCkaxQ.gqBkY6P1mF3QQUUUpgBIxi5Ffv9YFUm'),
(5, 'Mari', 'mari@mari.com', 'Mari', '$2y$10$TbksvtP8wHJEGFWeJ86.Tujw8tAsfNz3Joyb9zIDTuSUyHTNZPbxu');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `memes`
--
ALTER TABLE `memes`
  ADD PRIMARY KEY (`id_meme`);

--
-- Índices para tabela `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`usersId`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `memes`
--
ALTER TABLE `memes`
  MODIFY `id_meme` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `usersId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
