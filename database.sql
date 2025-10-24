-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-10-2025 a las 03:08:34
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tienda_celulares`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `celulares`
--

CREATE TABLE `celulares` (
  `id` int(11) NOT NULL,
  `imei` varchar(15) NOT NULL,
  `numero_serie` varchar(50) NOT NULL,
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `procesador` varchar(100) DEFAULT NULL,
  `pantalla` varchar(50) DEFAULT NULL,
  `camara_principal_mpx` int(11) DEFAULT NULL,
  `camara_frontal_mpx` int(11) DEFAULT NULL,
  `bateria_mah` int(11) DEFAULT NULL,
  `carga_rapida` tinyint(1) DEFAULT 0,
  `ram_gb` int(11) DEFAULT NULL,
  `almacenamiento_gb` int(11) DEFAULT NULL,
  `sistema_operativo` varchar(50) DEFAULT NULL,
  `conectividad_5g` tinyint(1) DEFAULT 0,
  `nfc` tinyint(1) DEFAULT 0,
  `puerto_usb` varchar(20) DEFAULT NULL,
  `dual_sim` tinyint(1) DEFAULT 0,
  `peso_gramos` int(11) DEFAULT NULL,
  `grosor_mm` decimal(3,1) DEFAULT NULL,
  `precio_usd` decimal(8,2) DEFAULT NULL,
  `fecha_lanzamiento` date DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `celulares`
--

INSERT INTO `celulares` (`id`, `imei`, `numero_serie`, `marca`, `modelo`, `procesador`, `pantalla`, `camara_principal_mpx`, `camara_frontal_mpx`, `bateria_mah`, `carga_rapida`, `ram_gb`, `almacenamiento_gb`, `sistema_operativo`, `conectividad_5g`, `nfc`, `puerto_usb`, `dual_sim`, `peso_gramos`, `grosor_mm`, `precio_usd`, `fecha_lanzamiento`, `activo`) VALUES
(1, '123456789012345', 'SN001', 'Samsung', 'Galaxy S21', 'Exynos 2100', '6.2\" AMOLED FHD+', 64, 10, 4000, 1, 8, 128, 'Android 11', 1, 1, 'USB-C', 1, 169, 7.9, 799.99, '2021-01-29', 1),
(2, '223456789012346', 'SN002', 'Apple', 'iPhone 13', 'A15 Bionic', '6.1\" Super Retina XDR', 12, 12, 3240, 1, 4, 128, 'iOS 15', 1, 1, 'Lightning', 0, 174, 7.7, 899.99, '2021-09-24', 1),
(3, '323456789012347', 'SN003', 'Xiaomi', 'Redmi Note 10 Pro', 'Snapdragon 732G', '6.67\" AMOLED 120Hz', 108, 16, 5020, 1, 6, 128, 'Android 11', 0, 1, 'USB-C', 1, 193, 8.1, 299.99, '2021-03-04', 1),
(4, '423456789012348', 'SN004', 'OnePlus', '9 Pro', 'Snapdragon 888', '6.7\" Fluid AMOLED 120Hz', 48, 16, 4500, 1, 8, 256, 'Android 11', 1, 1, 'USB-C', 1, 197, 8.7, 969.99, '2021-03-23', 1),
(5, '523456789012349', 'SN005', 'Huawei', 'P40 Pro', 'Kirin 990 5G', '6.58\" OLED 90Hz', 50, 32, 4200, 1, 8, 256, 'HarmonyOS', 1, 1, 'USB-C', 1, 209, 9.0, 799.99, '2020-03-26', 1),
(6, '623456789012350', 'SN006', 'Motorola', 'Edge 20 Pro', 'Snapdragon 870', '6.7\" OLED 144Hz', 108, 32, 4500, 1, 12, 256, 'Android 11', 1, 1, 'USB-C', 1, 185, 7.9, 699.99, '2021-08-05', 1),
(7, '723456789012351', 'SN007', 'Oppo', 'Find X3 Pro', 'Snapdragon 888', '6.7\" AMOLED QHD+ 120Hz', 50, 32, 4500, 1, 12, 256, 'Android 11', 1, 1, 'USB-C', 1, 193, 8.3, 1099.99, '2021-03-11', 1),
(8, '823456789012352', 'SN008', 'Realme', 'GT Neo 2', 'Snapdragon 870', '6.62\" AMOLED 120Hz', 64, 16, 5000, 1, 8, 128, 'Android 11', 1, 1, 'USB-C', 1, 199, 8.6, 429.99, '2021-09-22', 1),
(9, '923456789012353', 'SN009', 'Sony', 'Xperia 1 III', 'Snapdragon 888', '6.5\" OLED 4K 120Hz', 12, 8, 4500, 1, 12, 256, 'Android 11', 1, 1, 'USB-C', 1, 186, 8.2, 1299.99, '2021-04-14', 1),
(10, '103456789012354', 'SN010', 'Nokia', '8.3 5G', 'Snapdragon 765G', '6.81\" IPS LCD', 64, 24, 4500, 1, 8, 128, 'Android 10', 1, 1, 'USB-C', 1, 220, 8.9, 599.99, '2020-09-22', 1),
(11, '113456789012355', 'SN011', 'Samsung', 'Galaxy A52', 'Snapdragon 720G', '6.5\" Super AMOLED 90Hz', 64, 32, 4500, 1, 6, 128, 'Android 11', 0, 1, 'USB-C', 1, 189, 8.4, 349.99, '2021-03-17', 1),
(12, '123456789012356', 'SN012', 'Apple', 'iPhone 12 Mini', 'A14 Bionic', '5.4\" Super Retina XDR', 12, 12, 2227, 1, 4, 64, 'iOS 14', 1, 1, 'Lightning', 0, 135, 7.4, 699.99, '2020-10-13', 1),
(13, '133456789012357', 'SN013', 'Xiaomi', 'Mi 11 Ultra', 'Snapdragon 888', '6.81\" AMOLED QHD+ 120Hz', 50, 20, 5000, 1, 12, 256, 'Android 11', 1, 1, 'USB-C', 1, 234, 8.4, 1199.99, '2021-03-29', 0),
(14, '143456789012358', 'SN014', 'Google', 'Pixel 6 Pro', 'Google Tensor', '6.71\" AMOLED 120Hz', 50, 11, 5000, 1, 12, 128, 'Android 12', 1, 1, 'USB-C', 1, 210, 8.9, 899.99, '2021-10-25', 1),
(15, '153456789012359', 'SN015', 'Vivo', 'X60 Pro+', 'Snapdragon 888', '6.56\" AMOLED 120Hz', 50, 32, 4200, 1, 12, 256, 'Android 11', 1, 1, 'USB-C', 1, 191, 7.6, 899.99, '2021-01-21', 1),
(16, '163456789012360', 'SN016', 'Samsung', 'Galaxy Z Fold3', 'Snapdragon 888', '7.6\" Foldable AMOLED 120Hz', 12, 10, 4400, 1, 12, 256, 'Android 11', 1, 1, 'USB-C', 1, 271, 6.4, 1799.99, '2021-08-11', 1),
(17, '173456789012361', 'SN017', 'Xiaomi', 'Poco X3 Pro', 'Snapdragon 860', '6.67\" IPS LCD 120Hz', 48, 20, 5160, 1, 8, 128, 'Android 11', 0, 1, 'USB-C', 1, 215, 9.4, 249.99, '2021-03-22', 1),
(18, '183456789012362', 'SN018', 'Huawei', 'Mate 40 Pro', 'Kirin 9000', '6.76\" OLED 90Hz', 50, 13, 4400, 1, 8, 256, 'HarmonyOS', 1, 1, 'USB-C', 1, 212, 9.1, 1099.99, '2020-10-22', 1),
(19, '193456789012363', 'SN019', 'Asus', 'ROG Phone 5', 'Snapdragon 888', '6.78\" AMOLED 144Hz', 64, 24, 6000, 1, 16, 256, 'Android 11', 1, 1, 'USB-C', 1, 238, 10.3, 999.99, '2021-03-10', 1),
(20, '203456789012364', 'SN020', 'Lenovo', 'Legion Phone Duel 2', 'Snapdragon 888', '6.92\" AMOLED 144Hz', 64, 44, 5500, 1, 12, 256, 'Android 11', 1, 1, 'USB-C', 1, 259, 9.9, 899.99, '2021-04-08', 0),
(21, '13213142', '4124241221', 'Samsung', 'Galaxy S21s', '', '', 0, 0, 0, 0, 0, 0, '', 1, 1, 'USB-C', 0, 0, 0.0, 0.00, NULL, 1),
(22, 'w124214', '12423424', '423424', '34', '', '', 0, 0, 0, 0, 0, 0, '', 0, 0, 'USB-C', 0, 0, 0.0, 0.00, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `client_api`
--

CREATE TABLE `client_api` (
  `id` int(11) NOT NULL,
  `ruc` varchar(20) NOT NULL,
  `razon_social` varchar(150) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `estado` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `client_api`
--

INSERT INTO `client_api` (`id`, `ruc`, `razon_social`, `telefono`, `correo`, `fecha_registro`, `estado`) VALUES
(1, 'e1323', '213131aaa', '2133', '1232@sss.com', '2025-10-01 18:54:14', 1),
(2, '20523682947', 'delcomp sac', '969696969', 'info@delcomp.pe', '2025-10-03 08:51:16', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `count_request`
--

CREATE TABLE `count_request` (
  `id` int(11) NOT NULL,
  `id_token` int(11) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tokens_api`
--

CREATE TABLE `tokens_api` (
  `id` int(11) NOT NULL,
  `id_client_api` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `estado` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tokens_api`
--

INSERT INTO `tokens_api` (`id`, `id_client_api`, `token`, `fecha_registro`, `estado`) VALUES
(1, 1, '1e81e0a34b4c38a2fc09b45d6efb39c79c70f7a443a87a8cd235d18ffe140de2', '2025-10-01 18:54:27', 1),
(2, 1, 'cb28ba9fba1e4cd7871ae8df39cf9756f595190efb3371b312acf050ab40fe9a', '2025-10-03 08:50:27', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nombre_completo` varchar(120) NOT NULL,
  `rol` enum('admin') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `username`, `password`, `nombre_completo`, `rol`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$a4qsOmIrUcXN4ptudcU57uOQ7li/aLuuuRedYHOb1YoBnoRQsWgPi', 'Administrador General', 'admin', '2025-09-11 01:11:54', '2025-09-11 01:11:54'),
(2, 'diego', '$2y$10$tAoNY7skT8Zwo5y/Z9wwduShOXS9ifRxvGox1h0YveAjuZ64yaJIi', 'Yalico', 'admin', '2025-09-11 14:54:05', '2025-09-11 14:54:05');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `celulares`
--
ALTER TABLE `celulares`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `imei` (`imei`),
  ADD UNIQUE KEY `numero_serie` (`numero_serie`);

--
-- Indices de la tabla `client_api`
--
ALTER TABLE `client_api`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `count_request`
--
ALTER TABLE `count_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_token` (`id_token`);

--
-- Indices de la tabla `tokens_api`
--
ALTER TABLE `tokens_api`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_client_api` (`id_client_api`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `celulares`
--
ALTER TABLE `celulares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `client_api`
--
ALTER TABLE `client_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `count_request`
--
ALTER TABLE `count_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tokens_api`
--
ALTER TABLE `tokens_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `count_request`
--
ALTER TABLE `count_request`
  ADD CONSTRAINT `count_request_ibfk_1` FOREIGN KEY (`id_token`) REFERENCES `tokens_api` (`id`);

--
-- Filtros para la tabla `tokens_api`
--
ALTER TABLE `tokens_api`
  ADD CONSTRAINT `tokens_api_ibfk_1` FOREIGN KEY (`id_client_api`) REFERENCES `client_api` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

APIcelulares/
│
├── config/
│   └── database.php
│
├── controllers/
│   ├── AuthController.php
│   └── CelularController.php
│
├── models/
│   ├── Celular.php
│   └── Usuario.php
│
├── views/
│   ├── include/
│   │   ├── header.php
│   │   └── footer.php
│   ├── dashboard.php
│   ├── celulares_list.php
│   └── celular_form.php
│
├── public/
│   ├── index.php
│   ├── css/
│   └── js/
│
├── index.php
└── .htaccess



-- ================================
