-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 20/03/2024 às 20:23
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `formulario`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `forms`
--

CREATE TABLE `forms` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `profissao` varchar(100) NOT NULL,
  `numero_registro` varchar(50) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(2) NOT NULL,
  `data_hora` datetime NOT NULL,
  `representante` varchar(100) NOT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `classe_do_registro_medico` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `forms`
--

INSERT INTO `forms` (`id`, `nome`, `telefone`, `profissao`, `numero_registro`, `cidade`, `estado`, `data_hora`, `representante`, `celular`, `classe_do_registro_medico`, `email`) VALUES
(1, 'Anderson', '(11) 0000-0000', 'Teste', '123456789', 'Gotham', 'SP', '2024-03-20 18:14:20', 'Teste', '(11) 00000-0000', NULL, 'email@email.com'),
(4, 'rhearhreh', '11987769905', 'gfasdgasdg', '1234567890', 'São Paulo', 'SP', '0000-00-00 00:00:00', '<br /><b>Warning</b>:  Undefined global variable $_SESSION in <b>C:xampphtdocsFormulario-de-Cadastro', NULL, NULL, NULL),
(5, 'Anderson Cavalcante Barbosa', '11912345678', 'Teste', '27377733772', 'São Paulo', 'SP', '2024-03-18 20:56:33', '<br /><b>Warning</b>:  Undefined global variable $_SESSION in <b>C:xampphtdocsFormulario-de-Cadastro', NULL, NULL, NULL),
(6, 'Anderson Cavalcante Barbosa', '11111111111', 'Teste', '1234567890', 'São Paulo', 'SP', '2024-03-18 21:15:32', '<br /><b>Warning</b>:  Undefined global variable $_SESSION in <b>C:xampphtdocsFormulario-de-Cadastro', NULL, NULL, NULL),
(7, 'Roger Federer', '(11) 1111-1111', 'Medico', '11111111111111111111111', 'São Paulo', 'SP', '2024-03-19 15:22:27', 'Anderson Cavalcante', '', NULL, ''),
(8, 'Tom Brady', '(33) 3333-3333', 'Medico', '555555555555', 'São Paulo', 'SP', '2024-03-19 15:30:50', 'Anderson Cavalcante', '(44) 44444-4444', NULL, NULL),
(9, 'Anderson Barbosa', '(66) 6666-6666', 'Medico', '4984916519198', 'São Paulo', 'SP', '2024-03-19 15:39:12', 'Anderson Cavalcante', '(77) 77777-7777', NULL, 'anderson@email.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `nome` varchar(100) NOT NULL,
  `sobrenome` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `is_admin`, `nome`, `sobrenome`) VALUES
(3, 'admin', '202cb962ac59075b964b07152d234b70', 1, 'Anderson', 'Cavalcante'),
(5, 'anderson.c', '$2y$10$lqwnjZI7zz7qvxAUHE3aIOBmIhZenZL7zNX6BaTm2r4MS0G0tLYtG', 1, 'Anderson', 'Cavalcante'),
(6, 'teste', '827ccb0eea8a706c4c34a16891f84e7b', 0, 'Teste', 'Testando'),
(7, 'Teste1', '$2y$10$xojGkEneNAAgeLUQoE857ObQilpinOKu80cPJ/saQc2AMe7OBLktq', 0, '', ''),
(8, 'hash', '0800fc577294c34e0b28ad2839435945', 0, 'hash', 'hash'),
(9, 'Batman', '202cb962ac59075b964b07152d234b70', 0, 'Bruce', 'Wayne'),
(10, 'Batman', '202cb962ac59075b964b07152d234b70', 0, 'Bruce', 'Wayne'),
(11, 'Batman', '202cb962ac59075b964b07152d234b70', 0, 'Bruce', 'Wayne'),
(12, 'AndersonC96', '202cb962ac59075b964b07152d234b70', 1, 'Anderson', 'Barbosa'),
(13, 'CR7', '202cb962ac59075b964b07152d234b70', 1, 'Cristiano', 'Ronaldo'),
(14, 'teste52', '202cb962ac59075b964b07152d234b70', 0, 'Teste', 'Teste'),
(15, 'ccc', '202cb962ac59075b964b07152d234b70', 0, 'aaaa', 'bbb');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `forms`
--
ALTER TABLE `forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
