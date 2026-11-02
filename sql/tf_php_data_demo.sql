/* Se selecciona la base de datos 'tf_php' */
USE tf_php;

/* Se insertan usuarios de demo en 'users_data' */
INSERT INTO
    users_data (nombre, apellidos, email, telefono, fecha_de_nacimiento, sexo)
VALUES
    ('Demo nombre admin 1', 'Demo apellido admin 1', 'admin1@demo.demo', '612345678', '2001-01-01', 'Hombre'),
    ('Demo nombre admin 2', 'Demo apellido admin 2', 'admin2@demo.demo', '623456789', '2002-02-02', 'Mujer'),
    ('Demo nombre admin 3', 'Demo apellido admin 3', 'admin3@demo.demo', '634567890', '2003-03-03', 'No indicado'),
    ('Demo nombre user 1', 'Demo apellido user 1', 'user1@demo.demo', '645678901', '2004-04-04', 'Hombre'),
    ('Demo nombre user 2', 'Demo apellido user 2', 'user2@demo.demo', '656789012', '2005-05-05', 'Mujer'),
    ('Demo nombre user 3', 'Demo apellido user 3', 'user3@demo.demo', '667890123', '2006-06-06', 'No indicado');

/* Se insertan inicios de sesión de demo en 'users_login' */
INSERT INTO
    users_login (id_user, usuario, password_hash, rol)
VALUES
    (1, 'admin1', '$2y$10$IWHwxUv5oq5dk8EQwAT7qeYN9.1mh8.GPyz6KZnc9J7occ8qMRy/i', 'admin'),
    (2, 'admin2', '$2y$10$MkdxJiMCcofVx4UZIWKoW.0LZneqqSRsfMHTlxB6boxOc7/MwEocy', 'admin'),
    (3, 'admin3', '$2y$10$oMBzG4Qzdiev19cL/qWVk.kBnkA3qyVl32UL0rsU0oxXWTa0A2S7C', 'admin'),
    (4, 'user1', '$2y$10$m9O4SnXDGgQTmhPei4rnseZfJUbf9cn0MdF.GyFyq3VfE.AwE1Uqq', 'user'),
    (5, 'user2', '$2y$10$TZRgv0wTRchSTEmMfqLNy.Vz30AsX8al/tlmWP6QkSLWCXrrkC3g2', 'user'),
    (6, 'user3', '$2y$10$fnCp80cEi7K4MY9Qa2jSNeROKeEOKYXzZhn37IpV/uOJlUCBxWQKq', 'user');

/* Se insertan citas de demo en la tabla 'citas' */
INSERT INTO
    citas (id_user, fecha_cita, motivo_cita)
VALUES
    (4, '2026-03-03 10:00:00', "Este es el motivo de la cita demo 1 del usuario 'Demo nombre user 1'."),
    (4, '2026-06-06 11:15:00', "Este es el motivo de la cita demo 2 del usuario 'Demo nombre user 1'."),
    (4, '2026-09-09 12:30:00', "Este es el motivo de la cita demo 3 del usuario 'Demo nombre user 1'."),
    (4, '2026-10-10 13:45:00', "Este es el motivo de la cita demo 4 del usuario 'Demo nombre user 1'."),
    (4, '2026-11-11 15:00:00', "Este es el motivo de la cita demo 5 del usuario 'Demo nombre user 1'."),
    (4, '2026-12-12 16:15:00', "Este es el motivo de la cita demo 6 del usuario 'Demo nombre user 1'."),
    (5, '2026-10-10 10:30:00', "Este es el motivo de la cita demo 1 del usuario 'Demo nombre user 2'."),
    (5, '2026-11-11 11:45:00', "Este es el motivo de la cita demo 2 del usuario 'Demo nombre user 2'.");

/* Se insertan noticias de demo en la tabla 'noticias' */
INSERT INTO
    noticias (titulo, imagen, texto, fecha, id_user)
VALUES
    ('Demo noticia 1: Donostia se prepara para celebrar su tradicional Tamborrada', 'demo_tamborrada_6ae8bade96b94.jpeg', 'Donostia se prepara para vivir una de las jornadas más especiales de su calendario festivo. El próximo 20 de enero, la ciudad celebrará la Tamborrada, una tradición centenaria que reúne a miles de personas en torno al sonido de los tambores y barriles.

La celebración comenzará durante la medianoche del 19 al 20 de enero con la izada de la bandera en la Plaza de la Constitución. A partir de ese momento, numerosas compañías recorrerán las calles de la ciudad interpretando las tradicionales marchas de Sarriegi.

Durante 24 horas, donostiarras de todas las edades participarán en los desfiles vestidos de cocineros, soldados y otros personajes tradicionales. La fiesta concluirá a medianoche con la arriada de la bandera.

La Tamborrada volverá a demostrar por qué es una de las señas de identidad más importantes de Donostia.', '2026-01-15 10:00:00', 1),
    ('Demo noticia 2: Los Carnavales llenarán Donostia de música, disfraces y color', 'demo_carnavales_6ae8bb4d80dcc.jpeg', 'Donostia comienza a prepararse para recibir una de las celebraciones más divertidas del año: los Carnavales. Durante varios días, las calles de la ciudad se transformarán en un gran escenario donde los disfraces, la música y el humor serán los protagonistas.

Uno de los momentos más esperados será el tradicional desfile de comparsas, en el que diferentes grupos recorrerán las principales calles de la ciudad con originales coreografías, vestimentas y espectaculares carrozas.

La fiesta contará también con actividades infantiles, concursos de disfraces y diferentes propuestas musicales para todos los públicos. La Parte Vieja y las principales zonas comerciales serán algunos de los puntos con mayor ambiente festivo.

Los Carnavales representan una oportunidad perfecta para disfrutar de Donostia de una manera diferente y compartir unos días de diversión con familiares y amigos.', '2026-02-10 11:00:00', 2),
    ('Demo noticia 3: La Semana Grande convertirá Donostia en el centro de la fiesta durante nueve días', 'demo_semana_grande_6ae8bb9a3693e.jpeg', 'Donostia se prepara para celebrar una nueva edición de su Semana Grande, una de las citas festivas más importantes del verano. Durante nueve días, la ciudad ofrecerá una programación repleta de conciertos, espectáculos, actividades deportivas y propuestas culturales para todos los públicos.

Uno de los grandes atractivos de estas fiestas será el tradicional Concurso Internacional de Fuegos Artificiales. Cada noche, miles de personas se reunirán alrededor de la bahía de La Concha para contemplar los espectáculos pirotécnicos que iluminarán el cielo donostiarra.

El recinto ferial, los conciertos y las actividades organizadas en diferentes puntos de la ciudad completarán una programación pensada para disfrutar tanto de día como de noche.

La Semana Grande volverá a reunir a residentes y visitantes en un ambiente festivo que convierte a Donostia en uno de los destinos más atractivos del verano.', '2026-08-05 12:00:00', 3),
    ('Demo noticia 4: Santo Tomás llenará las calles de Donostia de tradición y gastronomía', 'demo_santo_tomas_6ae8bbcc763bd.jpeg', 'El próximo 21 de diciembre, Donostia celebrará la tradicional feria de Santo Tomás, una de las jornadas más populares y esperadas del calendario festivo guipuzcoano.

Durante todo el día, diferentes plazas y calles de la ciudad acogerán puestos de productos agrícolas, artesanía y gastronomía local. Los visitantes podrán encontrar quesos, verduras, miel, dulces y otros productos elaborados por productores de la zona.

Como manda la tradición, uno de los grandes protagonistas será el talo con txistorra, que podrá degustarse en los numerosos puestos instalados para la ocasión. Tampoco faltarán la música, el ambiente festivo y las actividades para toda la familia.

La feria constituye una oportunidad para acercarse a las costumbres rurales vascas y disfrutar de los productos de proximidad en pleno corazón de Donostia.', '2026-11-01 13:00:00', 4);
