-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Май 17 2025 г., 14:38
-- Версия сервера: 10.4.28-MariaDB
-- Версия PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `availabilities`
--

-- --------------------------------------------------------

--
-- Структура таблицы `availabilities`
--

CREATE TABLE `availabilities` (
  `id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `is_hidden` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `availabilities`
--

INSERT INTO `availabilities` (`id`, `amount`, `product_id`, `stock_id`, `is_hidden`) VALUES
(1, 3, 1, 1, 0),
(2, 2, 1, 5, 0),
(5, 5, 2, 1, 0),
(6, 2, 5, 5, 0),
(9, 1, 6, 1, 0),
(10, 1, 6, 5, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `is_hidden` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `is_hidden`) VALUES
(1, 'Электроника', 0),
(2, 'Бытовая техника', 0),
(5, 'Аксессуары', 0),
(6, 'Расходные материалы', 0),
(9, 'Мебель', 0),
(10, 'Товары для дачи', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `category_id` int(11) NOT NULL,
  `is_hidden` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `title`, `category_id`, `is_hidden`) VALUES
(1, 'Телевизор LG', 1, 0),
(2, 'Смартфон Samsung', 1, 0),
(5, 'Микроволновая печь Redmond', 2, 0),
(6, 'Кухонная вытяжка Elica', 2, 0),
(9, 'Кабель питания HDMI', 6, 0),
(10, 'Сетевой фильтр', 6, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `is_hidden` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `stocks`
--

INSERT INTO `stocks` (`id`, `title`, `is_hidden`) VALUES
(1, 'Главный склад', 0),
(2, 'Склад на Невской', 0),
(5, 'Склад на Бакинской', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `availabilities`
--
ALTER TABLE `availabilities`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `availabilities`
--
ALTER TABLE `availabilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
