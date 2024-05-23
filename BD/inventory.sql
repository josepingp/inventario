-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 23-05-2024 a las 22:01:11
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventory`
--
CREATE DATABASE IF NOT EXISTS `inventory` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci;
USE `inventory`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `category`
--

CREATE TABLE `category` (
  `category_id` int(7) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `category_location` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_location`) VALUES
(2, 'Telefonos', 'Pasillo 7'),
(3, 'Videojuegos', 'Pasillo 3'),
(4, 'Laptops', 'Pasillo 4'),
(5, 'Televisores', 'pasillo 1'),
(6, 'Computadoras', 'pasillo 2'),
(7, 'Teléfonos móviles', 'pasillo 3'),
(8, 'Tabletas', 'pasillo 4'),
(9, 'Accesorios para computadoras', 'pasillo 5'),
(10, 'Cámaras', 'pasillo 6'),
(11, 'Audio', 'pasillo 7'),
(12, 'Impresoras', 'pasillo 8'),
(13, 'Relojes inteligentes', 'pasillo 9'),
(14, 'Drones', 'pasillo 10'),
(15, 'Consolas de videojuegos', 'pasillo 4'),
(16, 'Electrodomésticos', 'pasillo 11'),
(17, 'Monitores', 'pasillo 2'),
(18, 'Memorias USB', 'pasillo 5'),
(19, 'Discos duros', 'pasillo 5'),
(21, 'Componentes de PC', 'pasillo 13'),
(22, 'Proyectores', 'pasillo 14'),
(23, 'Software', 'pasillo 15'),
(24, 'televisiones', 'pasillo 13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `product_id` int(20) NOT NULL,
  `product_code` varchar(70) NOT NULL,
  `product_name` varchar(70) NOT NULL,
  `product_price` decimal(30,2) NOT NULL,
  `product_stock` int(25) NOT NULL,
  `product_photo` varchar(500) NOT NULL,
  `category_id` int(7) NOT NULL,
  `user_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`product_id`, `product_code`, `product_name`, `product_price`, `product_stock`, `product_photo`, `category_id`, `user_id`) VALUES
(19, '3242354', 'prueba', 23.00, 23, '23432dfsfdf_1.png', 10, 3),
(21, '21431254431', '2344sad', 23.00, 23, '2344sad_31.png', 5, 3),
(27, '247263481723', 'prueba2', 123.00, 21, 'prueba2_41.jpeg', 4, 3),
(28, '27345826384', 'prueba update', 33.44, 22, 'prueba_update_21.jpeg', 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `user_id` int(10) NOT NULL,
  `user_name` varchar(40) NOT NULL,
  `user_last_name` varchar(40) NOT NULL,
  `user_user` varchar(20) NOT NULL,
  `user_key` varchar(200) NOT NULL,
  `user_email` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_last_name`, `user_user`, `user_key`, `user_email`) VALUES
(3, 'Jose Luis', 'Garcia Pelayo', 'josepingp', '$2y$10$8ZCXvwg80sG9/FgtkTjNguaJZ8tZKGr7oqUOq2jCs2gTDKhaZIljy', 'josepingp@hotmail.com'),
(4, 'jose enrique', 'garcia', 'jose1234', '$2y$10$mmJAO.nFUj/wbQH.oeRxfePjp39MACz8pg.FVKloCkRIc4F0brysK', 'mimailactualizado@mail.com'),
(5, 'dayana', 'gonzalez', 'nana', '$2y$10$RPYKafEBwy1ZTSqmjuKbyujJpOMjJ0Ozia4xMw6qmvhrYeXQoVS3e', 'dayana@mail.com'),
(6, 'Juan', 'Perez', 'jperez', 'clave123', 'jperez@example.com'),
(7, 'Maria', 'Gomez', 'mgomez', 'clave456', 'mgomez@example.com'),
(8, 'Luis', 'Lopez', 'llopez', 'clave789', 'llopez@example.com'),
(10, 'Pedro', 'Garcia', 'pgarcia', 'clave202', 'pgarcia@example.com'),
(11, 'Lucia', 'Fernandez', 'lfernandez', 'clave303', 'lfernandez@example.com'),
(12, 'Carlos', 'Rodriguez', 'crodriguez', 'clave404', 'crodriguez@example.com'),
(13, 'Elena', 'Sanchez', 'esanchez', 'clave505', 'esanchez@example.com'),
(14, 'Miguel', 'Ramirez', 'mramirez', 'clave606', 'mramirez@example.com'),
(15, 'Laura', 'Diaz', 'ldiaz', 'clave707', 'ldiaz@example.com'),
(16, 'David', 'Cruz', 'dcruz', 'clave808', 'dcruz@example.com'),
(17, 'Sofia', 'Morales', 'smorales', 'clave909', 'smorales@example.com'),
(18, 'Jorge', 'Vargas', 'jvargas', 'clave010', 'jvargas@example.com'),
(19, 'Natalia', 'Ortega', 'nortega', 'clave111', 'nortega@example.com'),
(20, 'Ricardo', 'Torres', 'rtorres', 'clave212', 'rtorres@example.com'),
(21, 'Victoria', 'Silva', 'vsilva', 'clave313', 'vsilva@example.com'),
(22, 'Hector', 'Mendoza', 'hmendoza', 'clave414', 'hmendoza@example.com'),
(23, 'Gabriela', 'Reyes', 'greyes', 'clave515', 'greyes@example.com'),
(24, 'Francisco', 'Ruiz', 'fruiz', 'clave616', 'fruiz@example.com'),
(25, 'Sara', 'Gutierrez', 'sgutierrez', 'clave717', 'sgutierrez@example.com'),
(26, 'Raul', 'Chavez', 'rchavez', 'clave818', 'rchavez@example.com'),
(27, 'Isabel', 'Ramos', 'iramos', 'clave919', 'iramos@example.com'),
(28, 'Antonio', 'Flores', 'aflores', 'clave020', 'aflores@example.com'),
(29, 'Valeria', 'Molina', 'vmolina', 'clave121', 'vmolina@example.com'),
(30, 'Enrique', 'Castro', 'ecastro', 'clave222', 'ecastro@example.com'),
(31, 'Patricia', 'Suarez', 'psuarez', 'clave323', 'psuarez@example.com'),
(32, 'Julio', 'Rojas', 'jrojas', 'clave424', 'jrojas@example.com'),
(33, 'Monica', 'Herrera', 'mherrera', 'clave525', 'mherrera@example.com'),
(34, 'Fernando', 'Aguilar', 'faguilar', 'clave626', 'faguilar@example.com'),
(35, 'Yolanda', 'Jimenez', 'yjimenez', 'clave727', 'yjimenez@example.com'),
(37, 'Carmen', 'Nunez', 'cnunez', 'clave929', 'cnunez@example.com'),
(38, 'Emilio', 'Lara', 'elara', 'clave030', 'elara@example.com'),
(39, 'Rosa', 'Salazar', 'rsalazar', 'clave131', 'rsalazar@example.com'),
(40, 'Sergio', 'Peña', 'spena', 'clave232', 'spena@example.com'),
(41, 'Daniela', 'Campos', 'dcampos', 'clave333', 'dcampos@example.com'),
(42, 'John', 'Doe', 'johndoe', 'password123', 'john.doe@example.com'),
(43, 'Jane', 'Smith', 'janesmith', 'password123', 'jane.smith@example.com'),
(44, 'Robert', 'Brown', 'robertbrown', 'password123', 'robert.brown@example.com'),
(45, 'Michael', 'Johnson', 'michaeljohnson', 'password123', 'michael.johnson@example.com'),
(46, 'Mary', 'Williams', 'marywilliams', 'password123', 'mary.williams@example.com'),
(47, 'William', 'Jones', 'williamjones', 'password123', 'william.jones@example.com'),
(48, 'Linda', 'Garcia', 'lindagarcia', 'password123', 'linda.garcia@example.com'),
(49, 'James', 'Martinez', 'jamesmartinez', 'password123', 'james.martinez@example.com'),
(50, 'Elizabeth', 'Rodriguez', 'elizabethrodriguez', 'password123', 'elizabeth.rodriguez@example.com'),
(51, 'David', 'Hernandez', 'davidhernandez', 'password123', 'david.hernandez@example.com'),
(52, 'Barbara', 'Lopez', 'barbaralopez', 'password123', 'barbara.lopez@example.com'),
(53, 'Richard', 'Gonzalez', 'richardgonzalez', 'password123', 'richard.gonzalez@example.com'),
(54, 'Susan', 'Wilson', 'susanwilson', 'password123', 'susan.wilson@example.com'),
(55, 'Joseph', 'Anderson', 'josephanderson', 'password123', 'joseph.anderson@example.com'),
(56, 'Thomas', 'Thomas', 'thomasthomas', 'password123', 'thomas.thomas@example.com'),
(57, 'Patricia', 'Taylor', 'patriciataylor', 'password123', 'patricia.taylor@example.com'),
(58, 'Charles', 'Moore', 'charlesmoore', 'password123', 'charles.moore@example.com'),
(59, 'Christopher', 'Jackson', 'christopherjackson', 'password123', 'christopher.jackson@example.com'),
(60, 'Daniel', 'Martin', 'danielmartin', 'password123', 'daniel.martin@example.com'),
(61, 'Matthew', 'Lee', 'matthewlee', 'password123', 'matthew.lee@example.com'),
(62, 'Dorothy', 'Perez', 'dorothyperez', 'password123', 'dorothy.perez@example.com'),
(63, 'Paul', 'Thompson', 'paulthompson', 'password123', 'paul.thompson@example.com'),
(64, 'Nancy', 'White', 'nancywhite', 'password123', 'nancy.white@example.com'),
(65, 'George', 'Harris', 'georgeharris', 'password123', 'george.harris@example.com'),
(66, 'Lisa', 'Sanchez', 'lisasanchez', 'password123', 'lisa.sanchez@example.com'),
(67, 'Kenneth', 'Clark', 'kennethclark', 'password123', 'kenneth.clark@example.com'),
(68, 'Karen', 'Ramirez', 'karenramirez', 'password123', 'karen.ramirez@example.com'),
(69, 'Steven', 'Lewis', 'stevenlewis', 'password123', 'steven.lewis@example.com'),
(70, 'Donna', 'Robinson', 'donnarobinson', 'password123', 'donna.robinson@example.com'),
(71, 'Edward', 'Walker', 'edwardwalker', 'password123', 'edward.walker@example.com'),
(72, 'Sarah', 'Young', 'sarahyoung', 'password123', 'sarah.young@example.com'),
(73, 'Brian', 'Allen', 'brianallen', 'password123', 'brian.allen@example.com'),
(74, 'Laura', 'King', 'lauraking', 'password123', 'laura.king@example.com'),
(75, 'Ronald', 'Wright', 'ronaldwright', 'password123', 'ronald.wright@example.com'),
(76, 'Kevin', 'Scott', 'kevinscott', 'password123', 'kevin.scott@example.com'),
(77, 'Sandra', 'Torres', 'sandratotres', 'password123', 'sandra.torres@example.com'),
(78, 'Jason', 'Nguyen', 'jasonnguyen', 'password123', 'jason.nguyen@example.com'),
(79, 'Betty', 'Hill', 'bettyhill', 'password123', 'betty.hill@example.com'),
(80, 'Jeffrey', 'Flores', 'jeffreyflores', 'password123', 'jeffrey.flores@example.com'),
(81, 'Helen', 'Green', 'helengreen', 'password123', 'helen.green@example.com'),
(82, 'Ryan', 'Adams', 'ryanadams', 'password123', 'ryan.adams@example.com'),
(83, 'Maria', 'Nelson', 'marianelson', 'password123', 'maria.nelson@example.com'),
(84, 'Frank', 'Baker', 'frankbaker', 'password123', 'frank.baker@example.com'),
(85, 'Donna', 'Rivera', 'donnarivera', 'password123', 'donna.rivera@example.com'),
(86, 'Gary', 'Campbell', 'garycampbell', 'password123', 'gary.campbell@example.com'),
(87, 'Ruth', 'Mitchell', 'ruthmitchell', 'password123', 'ruth.mitchell@example.com'),
(88, 'Deborah', 'Carter', 'deborahcarter', 'password123', 'deborah.carter@example.com'),
(89, 'Joshua', 'Roberts', 'joshuaroberts', 'password123', 'joshua.roberts@example.com'),
(90, 'Carol', 'Gomez', 'carolgomez', 'password123', 'carol.gomez@example.com'),
(91, 'Mark', 'Phillips', 'markphillips', 'password123', 'mark.phillips@example.com'),
(92, 'Michelle', 'Evans', 'michellevans', 'password123', 'michelle.evans@example.com'),
(93, 'Larry', 'Turner', 'larryturner', 'password123', 'larry.turner@example.com'),
(94, 'Laura', 'Diaz', 'lauradiaz', 'password123', 'laura.diaz@example.com'),
(95, 'Steven', 'Parker', 'stevenparker', 'password123', 'steven.parker@example.com'),
(96, 'Emily', 'Edwards', 'emilyedwards', 'password123', 'emily.edwards@example.com'),
(97, 'Gregory', 'Collins', 'gregorycollins', 'password123', 'gregory.collins@example.com'),
(98, 'Rebecca', 'Stewart', 'rebeccastewart', 'password123', 'rebecca.stewart@example.com'),
(99, 'Justin', 'Sanchez', 'justinsanchez', 'password123', 'justin.sanchez@example.com'),
(100, 'Stephanie', 'Morris', 'stephaniemorris', 'password123', 'stephanie.morris@example.com'),
(101, 'Brandon', 'Rogers', 'brandonrogers', 'password123', 'brandon.rogers@example.com'),
(103, 'Scott', 'Cook', 'scottcook', 'password123', 'scott.cook@example.com'),
(104, 'Cynthia', 'Morgan', 'cynthiamorgan', 'password123', 'cynthia.morgan@example.com'),
(105, 'Benjamin', 'Bell', 'benjaminbell', 'password123', 'benjamin.bell@example.com'),
(106, 'Rebecca', 'Murphy', 'rebeccamurphy', 'password123', 'rebecca.murphy@example.com'),
(107, 'Samuel', 'Bailey', 'samuelbailey', 'password123', 'samuel.bailey@example.com'),
(108, 'Sharon', 'Rivera', 'sharonrivera', 'password123', 'sharon.rivera@example.com'),
(109, 'Timothy', 'Cooper', 'timothycooper', 'password123', 'timothy.cooper@example.com'),
(110, 'Rachel', 'Richardson', 'rachelrichardson', 'password123', 'rachel.richardson@example.com'),
(111, 'Patrick', 'Cox', 'patrickcox', 'password123', 'patrick.cox@example.com'),
(112, 'Katherine', 'Howard', 'katherinehoward', 'password123', 'katherine.howard@example.com'),
(113, 'Dennis', 'Ward', 'dennisward', 'password123', 'dennis.ward@example.com'),
(114, 'Debra', 'Peterson', 'debrapeterson', 'password123', 'debra.peterson@example.com'),
(115, 'Jerry', 'Gray', 'jerrygray', 'password123', 'jerry.gray@example.com'),
(116, 'Margaret', 'Ramirez', 'margaretramirez', 'password123', 'margaret.ramirez@example.com'),
(117, 'Bruce', 'James', 'brucejames', 'password123', 'bruce.james@example.com'),
(118, 'Rebecca', 'Watson', 'rebeccawatson', 'password123', 'rebecca.watson@example.com'),
(119, 'David', 'Brooks', 'davidbrooks', 'password123', 'david.brooks@example.com'),
(120, 'Sara', 'Kelly', 'sarakelly', 'password123', 'sara.kelly@example.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_user` (`user_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `category_id` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
