-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 04-05-2018 a las 01:46:14
-- Versión del servidor: 10.1.25-MariaDB
-- Versión de PHP: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `aldan-project`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id_post` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(35) NOT NULL,
  `description` mediumtext NOT NULL,
  `content` mediumtext NOT NULL,
  `img` varchar(50) NOT NULL,
  `date` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `blog_posts`
--

INSERT INTO `blog_posts` (`id_post`, `title`, `description`, `content`, `img`, `date`) VALUES
(1, 'Título del primer artículo', 'Este es el <b>primer</b> articulo en la página de <b>Aldan Project</b>, aquí puedes insertar información relacionada sobre el tema que se habla en el articulo.<br> Incluyendo una <b>imagen</b> que lo acompaña a su lado izquierdo.<br><br> Y aquí hay un <a href=\'#\'>enlace</a>.', '<center>Estás leyendo el <b>contenido</b> de la primera publicación en <a href=\'#\'>Aldan Project</a>', 'blog01.jpg', '2018-02-09'),
(8, 'Publicación creada con el panel', 'Descripción escrita en un <b>textarea</b> en el panel de administrador, el cual puede eliminar, modificar y buscar publicaciones.', '<center>Contenido centrado</center>', 'blog02.jpg', '2018-02-15'),
(9, 'Nueva publicación', 'Probando el número de publicaciones impar.', 'No hay :c', 'blog01.jpg', '2018-02-15');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forums`
--

CREATE TABLE `forums` (
  `id_forum` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(60) NOT NULL,
  `description` text NOT NULL,
  `closed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `forums`
--

INSERT INTO `forums` (`id_forum`, `name`, `description`, `closed`) VALUES
(1, 'Primer foro', 'Este es el primer foro que existe, eres libre de publicar aquí', 1),
(2, 'Segundo foro de discusión', 'Se supone que aquí hay una pequeña descripción del foro, pero no la hay :c', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forum_comments`
--

CREATE TABLE `forum_comments` (
  `id_comment` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `forum_comments`
--

INSERT INTO `forum_comments` (`id_comment`, `content`, `date`, `id_user`, `id_post`) VALUES
(1, 'Este es un <b>comentario</b>.<br>\r\nY este <a href=\"https://www.google.com\">un enlace</a>.', '2018-04-30 22:40:53', 1, 1),
(2, 'Este es un segundo comentario publicado por <i>Hanatan</i>', '2018-04-30 22:43:20', 2, 1),
(5, 'Necesito ayuda con <i>este </i>proyecto.', '2018-05-01 16:36:34', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `forum_posts`
--

CREATE TABLE `forum_posts` (
  `id_post` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(60) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `id_forum` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `forum_posts`
--

INSERT INTO `forum_posts` (`id_post`, `title`, `content`, `date`, `id_forum`, `id_user`) VALUES
(1, 'Primera publicación', 'Contenido chido y <a href=\"https://www.google.com\">un enlace</a>.<br><b>Negritas</b><br><i>Cursiva</i><br><u>Subrayado</u>', '2018-04-22 19:20:30', 2, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(70) NOT NULL,
  `level` int(2) NOT NULL,
  `biography` varchar(100) NOT NULL,
  `location` varchar(40) NOT NULL,
  `gender` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `password`, `level`, `biography`, `location`, `gender`) VALUES
(1, 'Azumi', 'alejandro-hdez115@outlook.com', '215e2b2a880169c2bb2a01a7826359538bc6da2aec7b558d287ae27b2920bd31', 1, 'If does not exist, program it.', 'Tonalá, Jalisco', 1),
(2, 'Hanatan', 'alexazumi935@gmail.com', '91a73fd806ab2c005c13b4dc19130a884e909dea3f72d46e30266fe1a1f588d8', 3, '[NONE]', '[NONE]', 0),
(10, 'Rackio', 'sgcesar@outlook.es', '37b4be64dfd2c4ffc9fb610725c04192e476fe7d3b22d5c0ea77468af9886992', 3, '[NONE]', '[NONE]', 0),
(12, 'Sr_Panda', 'firerex001@gmail.com', '37b4be64dfd2c4ffc9fb610725c04192e476fe7d3b22d5c0ea77468af9886992', 2, '[NONE]', '[NONE]', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id_post`),
  ADD UNIQUE KEY `id_post` (`id_post`);

--
-- Indices de la tabla `forums`
--
ALTER TABLE `forums`
  ADD PRIMARY KEY (`id_forum`),
  ADD UNIQUE KEY `id_forum` (`id_forum`);

--
-- Indices de la tabla `forum_comments`
--
ALTER TABLE `forum_comments`
  ADD PRIMARY KEY (`id_comment`),
  ADD UNIQUE KEY `id_comment` (`id_comment`);

--
-- Indices de la tabla `forum_posts`
--
ALTER TABLE `forum_posts`
  ADD PRIMARY KEY (`id_post`),
  ADD UNIQUE KEY `id_post` (`id_post`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id_post` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `forums`
--
ALTER TABLE `forums`
  MODIFY `id_forum` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT de la tabla `forum_comments`
--
ALTER TABLE `forum_comments`
  MODIFY `id_comment` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `forum_posts`
--
ALTER TABLE `forum_posts`
  MODIFY `id_post` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
