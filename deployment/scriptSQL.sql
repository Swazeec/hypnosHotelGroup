-- CREATION BDD

CREATE DATABASE IF NOT EXISTS hypnos DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_ci;
USE hypnos;
SET default_storage_engine = InnoDB;

-- CREATION TABLES

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(60) NOT NULL,
    password VARCHAR(60) NOT NULL
) engine = innodb;

CREATE TABLE IF NOT EXISTS managers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(60) NOT NULL,
    password VARCHAR(60) NOT NULL
) engine = innodb;

CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(60) NOT NULL,
    password VARCHAR(60) NOT NULL
) engine = innodb;

CREATE TABLE IF NOT EXISTS hotels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    city VARCHAR(50) NOT NULL,
    address VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    manager_id INT NOT NULL,
    FOREIGN KEY (manager_id) REFERENCES managers(id)
) engine = innodb;

CREATE TABLE IF NOT EXISTS prices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    price DECIMAL(6,2) NOT NULL
) engine = innodb;

CREATE TABLE IF NOT EXISTS suites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    primePicture TEXT,
    link TEXT NOT NULL,
    price_id INT NOT NULL,
    hotel_id INT NOT NULL,
    FOREIGN KEY (price_id) REFERENCES prices(id),
    FOREIGN KEY (hotel_id) REFERENCES hotels(id) ON DELETE CASCADE
) engine = innodb;

CREATE TABLE IF NOT EXISTS pictures (
    id INT AUTO_INCREMENT PRIMARY KEY,
    picture TEXT NOT NULL,
    suite_id INT NOT NULL,
    FOREIGN KEY (suite_id) REFERENCES suites(id) ON DELETE CASCADE
) engine = innodb;

CREATE TABLE IF NOT EXISTS bookingStatus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
) engine = innodb;

CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    startDate DATE NOT NULL,
    endDate DATE NOT NULL,
    cancellationDate DATE DEFAULT (ADDDATE(startDate, INTERVAL -3 DAY)),
    bookingStatus_id INT NOT NULL DEFAULT 1,
    suite_id INT NOT NULL,
    client_id INT NOT NULL,
    FOREIGN KEY (bookingStatus_id) REFERENCES bookingStatus(id),
    FOREIGN KEY (suite_id) REFERENCES suites(id) ON DELETE CASCADE,
    FOREIGN KEY (client_id) REFERENCES clients(id)
) engine = innodb;

CREATE TABLE IF NOT EXISTS topics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
) engine = innodb;

CREATE TABLE IF NOT EXISTS requestStatus (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
) engine = innodb;

CREATE TABLE IF NOT EXISTS contactRequests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(60) NOT NULL,
    message TEXT NOT NULL,
    requestDate DATE DEFAULT NOW(),
    topic_id INT NOT NULL,
    client_id INT DEFAULT null,
    requestStatus_id INT NOT NULL DEFAULT 1,
    FOREIGN KEY (topic_id) REFERENCES topics(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (requestStatus_id) REFERENCES requestStatus(id)
) engine = innodb;

-- CREATION UTILISATEURS / PRIVILEGES

-- admin
CREATE USER 'admin'@'localhost' IDENTIFIED BY '@@34tcx7ES';
GRANT ALL PRIVILEGES ON hypnos.* TO 'admin'@'localhost';

-- manager
CREATE USER 'manager'@'localhost' IDENTIFIED BY '7@rn2Tp2H@';
GRANT INSERT, UPDATE, DELETE ON hypnos.suites, hypnos.pictures, hypnos.prices TO 'manager'@'localhost';
GRANT SELECT ON hypnos.* TO 'manager'@'localhost';

-- client
CREATE USER 'client'@'localhost' IDENTIFIED BY 'WMh9@t7@p3';
GRANT INSERT, UPDATE ON hypnos.clients, hypnos.bookings TO 'client'@'localhost';
GRANT INSERT ON hypnos.contactRequests TO 'client'@'localhost';
GRANT SELECT ON hypnos.* TO 'client'@'localhost';

-- no-auth
CREATE USER 'noauth'@'localhost' IDENTIFIED BY '2@x@RMqm57';
GRANT INSERT ON hypnos.clients, hypnos.contactRequests TO 'noauth'@'localhost';
GRANT SELECT ON hypnos.* TO 'noauth'@'localhost';

-- INSERTION DES DONNEES

-- admin
INSERT INTO admins (firstname, lastname, email, password) VALUES ('Alvar', 'Aalto', 'alvar.aalto@hypnos.fr', '$2y$10$ct2ywHpq62Hjfcr4huxNlu0SkPAD071DQze/FnKa5sy4huoc4WqKG' );

-- managers
INSERT INTO managers (firstname, lastname, email, password) VALUES ('Marice', 'Overnell', 'movernell0@constantcontact.com', '$2y$10$0xt5NIjlTTV.0G5LjFYxzeINoBTW/Iom7ul.DyN4bo0zDHFXrKsdm');
INSERT INTO managers (firstname, lastname, email, password) VALUES ('Maire', 'Duchant', 'mduchant1@google.ru', '$2y$10$h5MYG.Uv32a2cvZUonADl.pCJlklT8kIozi8uJI9InIIBfu2CCsO2');
INSERT INTO managers (firstname, lastname, email, password) VALUES ('Adoree', 'Bonnier', 'abonnier2@chron.com', '$2y$10$5sR8Bar7wYNsfgHGekWMLOGvHCNM/JTn./1sKOBqNZDT9wNBHug1.');

-- clients
INSERT INTO clients (firstname, lastname, email, password) VALUES ('Wally', 'Joysey', 'wjoysey0@weebly.com', '$2y$10$StI0j2U66u0FxxItQcXDHOjbVV9atUSQuOOzvTw4.pE.ZzmD5RM9K');
INSERT INTO clients (firstname, lastname, email, password) VALUES ('Phip', 'Celler', 'pceller1@mlb.com', '$2y$10$O2SqZ1tpVDHFnsmrHxSCB.ewchAPnQAp4Sxx0fUq71A3auvSzOtnS');
INSERT INTO clients (firstname, lastname, email, password) VALUES ('Christy', 'Le febre', 'clefebre2@washingtonpost.com', '$2y$10$KN/dq9AUrS868uCi2U7/puKkyFjF6IIjcbRKuYtf5mZv8Cv0QAbzm');
INSERT INTO clients (firstname, lastname, email, password) VALUES ('Sebastiano', 'Ambrosini', 'sambrosini3@geocities.com', '$2y$10$FyMuktbrxxbeyDt1hjEAeOiOYCVgl0o89dYWrpZ0Tuo/DlkDIPKya');
INSERT INTO clients (firstname, lastname, email, password) VALUES ('Barn', 'Tyas', 'btyas4@mlb.com', '$2y$10$cy3rwbTr.0h9qBeSUIP8AumzEWZ31hGKmps0usjVBu4RohZzm83QG');
INSERT INTO clients (firstname, lastname, email, password) VALUES ('Isiahi', 'Ducrow', 'iducrow5@elpais.com', '$2y$10$muXuDwbAYsvqWgbdY80g7eWPEpkU76PoItBRSQXMXCyypbvqW/J7C');
INSERT INTO clients (firstname, lastname, email, password) VALUES ('Kessiah', 'Rean', 'krean6@1und1.de', '$2y$10$FpqNRg8P3Lzud/YSm5WhO.ro0zqAeTIL3RayFr8j6T5RyHbf6oZ/S');
INSERT INTO clients (firstname, lastname, email, password) VALUES ('Thorsten', 'Thorington', 'tthorington7@pen.io', '$2y$10$uxh8dVfukfrHQusWZwiG5.jibR0fPVqFF6LpjVXlk7zjALRSyUXqm');
INSERT INTO clients (firstname, lastname, email, password) VALUES ('Oren', 'Dwire', 'odwire8@webeden.co.uk', '$2y$10$hYL9WDd3lTaTqylXCgWd5.l66c1s6YBhJfGMpkbdYrHvTjT1C/gkS');
INSERT INTO clients (firstname, lastname, email, password) VALUES ('Winny', 'Coltherd', 'wcoltherd9@globo.com', '$2y$10$iifkRCIsUMDRPUPYQyZKV.UmhJO7g2cpUjuZ1Bu//BDtQpxNg.fvK');

-- hotels
INSERT INTO hotels (name, city, address, description, manager_id) VALUES ('Hôtel Marimekko', 'Paris', '12 rue Annika Rimala', 'L''hôtel Marimekko vous accueille lorem ipsum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis. Non consequatur labore est eligendi quos sit omnis iste non corporis dolores. Ut velit quod est impedit molestiae non dignissimos molestiae vel dolore minima ut Quis saepe sit unde corrupti sed sapiente optio.  ', 1);
INSERT INTO hotels (name, city, address, description, manager_id) VALUES ('Hôtel Artek', 'Rennes', '2 avenue de la Finlande', 'L''hôtel Artek vous propose une ambiance digne des plus grands designers danois. Lorem ipsum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis. Non consequatur labore est eligendi quos sit omnis iste non corporis dolores. Ut velit quod est impedit molestiae non dignissimos molestiae vel dolore minima ut Quis saepe sit unde corrupti sed sapiente optio. ', 2);
INSERT INTO hotels (name, city, address, description, manager_id) VALUES ('Hôtel Louis Poulsen', 'Lyon', '5 allée de la lumière', 'L''hôtel Louis Poulsen vous acceuille dans un environnement propice à la détente. Lorem ipsum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis. Non consequatur labore est eligendi quos sit omnis iste non corporis dolores. Ut velit quod est impedit molestiae non dignissimos molestiae vel dolore minima ut Quis saepe sit unde corrupti sed sapiente optio. ', 3);

-- prices
INSERT INTO prices (price) VALUE (300);

-- suites
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Maija Isola', 'Une magnifique suite à la décoration florale, propice à la détente. Lorem ispum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis.', 'https://picsum.photos/600/400', 'https://www.google.com/', 1, 1);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Maija Louekari', 'Profitez, dans cette suite ornée du motif Siirtolapuutarha, d''un univers de jardin onirique et coloré. Lorem ispum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis.', 'https://picsum.photos/600/400', 'https://www.google.com/', 1, 1);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Armi Ratia ', 'L''univers de la suite Armi Ratia conviendra aux adeptes de la simplicité. Lorem ispum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis.', 'https://picsum.photos/600/400', 'https://www.google.com/', 1, 1);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Sanna Annuka', 'Cette suite nous plonge dans une tradition finlandaise très colorée. Lorem ispum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis.', 'https://picsum.photos/600/400', 'https://www.google.com/', 1, 1);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Annika Rimala', 'Pour les amoureux de design rétro ! Lorem ispum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis.', 'https://picsum.photos/600/400', 'https://www.google.com/', 1, 1);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Ilmari Tapiovaara', 'Suite luxueuse et meublée avec salle de bain privée. La suite Tapiovaara va vous faire voyager. Vous pourrez profiter des avantages de votre propre suite et salle de bain privative avec douche à l''italienne et sauna, de la connexion Wifi en haut-débit, d''une vue sur l''extérieur ainsi que d''un mini bar avec de l''eau.', 'https://picsum.photos/600/400', 'https://www.google.com', 1, 2);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Aino Aalto', 'L''Extravagante Suite Aino Aalto offre confort dans un décor inspiré des tendances des pays scandinaves. Récemment rénovée, cette suite est idéale pour les escapades en amoureux. Vous apprécierez sa salle de bain moderne munie d''un bain et d''une douche.', 'https://picsum.photos/600/400', 'https://www.google.com/', 1, 2);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Bouroullec', 'Sobre et coquette, la suite Bouroullec rappelle les chalets nordiques et se démarque par sa gamme de textures et de couleurs. Le bois brut des meubles contraste avec les teintes irisées, aux airs d’aurore boréale, des lattes de céramique qui enveloppent sa douche multi-jets et sa baignoire sabot.', 'https://picsum.photos/600/400', 'https://www.google.com/', 1, 2);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Fintone', 'Le spectaculaire décor de la suite Finetone joue sur le contraste entre le doré lumineux de ses murs et le noir profond de sa paroi en bois laqué. Amateurs de lieux au luxe chatoyant, venez vous prélasser dans sa magnifique baignoire qui est une pièce à part entière!', 'https://picsum.photos/600/400', 'https://www.google.com/', 1, 2);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Rybakken', 'Avec ses tons bleutés, la suite Rybakken saura vous transporter au firmament. Son décor aérien et lumineux en fait le lieu idéal pour se détendre, en paressant dans sa baignoire douillette ou sur son lit à baldaquin moderne, tous deux surplombés d''un plafond de miroirs.', 'https://picsum.photos/600/400', 'https://www.google.com/', 1, 2);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Poul Henningsen', 'Suite de luxe avec accès privé, la suite Poul Henningsen est aménagée sur deux étages, dans un décor éclatant qui ose le rose et le doré ! Avec sa chambre mezzanine surplombant le salon, la Nordique est particulièrement spacieuse. Son ambiance séduisante est mise en valeur par de nombreux éclairages et un jeu de miroirs.', 'https://picsum.photos/600/400', 'https://www.google.com/', 1, 3);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Arne Jacobsen', 'Multipliant les touches qui évoquent la nature, la Arne Jacobsen est une suite d’esprit nordique. Avec ses panneaux imitation bois et son large banc, sa salle de bain n''est pas sans rappeler l''espace du sauna, tout en étant équipée d’une luxueuse douche pluie. Petits plus : un balcon privé et un lit king.', 'https://picsum.photos/600/400', 'https://www.google.com/', 1, 3);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Anu Moser', 'La suite Siberia a l''intimité et le cachet d''une cabane dans la forêt, le confort en plus ! Cette suite tire tout son charme de son mobilier en bois rustique, son foyer et ses couleurs chaleureuses. Une jolie particularité : le miroir mural au-dessus de la grande baignoire îlot.', 'https://picsum.photos/600/400', 'https://www.google.com/', 1, 3);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Vilhelm Lauritzen', 'Sobre et coquette, la suite Vilhelm Lauritzen rappelle les chalets nordiques et se démarque par sa gamme de textures et de couleurs. Le bois brut des meubles contraste avec les teintes irisées, aux airs d’aurore boréale, des lattes de céramique qui enveloppent sa douche multi-jets et sa baignoire sabot.', 'https://picsum.photos/600/400', 'https://www.google.com/', 1, 3);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Verner Panton', 'Suite luxueuse et meublée avec salle de bain privée. La suite Tapiovaara va vous faire voyager. Vous pourrez profiter des avantages de votre propre suite et salle de bain privative avec douche à l''italienne et sauna, de la connexion Wifi en haut-débit, d''une vue sur l''extérieur ainsi que d''un mini bar avec de l''eau.', 'https://picsum.photos/600/400', 'https://www.google.com/', 1, 3);

-- pictures
INSERT INTO pictures (picture, suite_id) VALUES ('https://picsum.photos/600/400', 1);
INSERT INTO pictures (picture, suite_id) VALUES ('https://picsum.photos/600/400', 1);
INSERT INTO pictures (picture, suite_id) VALUES ('https://picsum.photos/600/400', 1);
INSERT INTO pictures (picture, suite_id) VALUES ('https://picsum.photos/600/400', 3);
INSERT INTO pictures (picture, suite_id) VALUES ('https://picsum.photos/600/400', 4);
INSERT INTO pictures (picture, suite_id) VALUES ('https://picsum.photos/600/400', 5);
INSERT INTO pictures (picture, suite_id) VALUES ('https://picsum.photos/600/400', 5);
INSERT INTO pictures (picture, suite_id) VALUES ('https://picsum.photos/600/400', 6);
INSERT INTO pictures (picture, suite_id) VALUES ('https://picsum.photos/600/400', 8);
INSERT INTO pictures (picture, suite_id) VALUES ('https://picsum.photos/600/400', 8);
INSERT INTO pictures (picture, suite_id) VALUES ('https://picsum.photos/600/400', 9);
INSERT INTO pictures (picture, suite_id) VALUES ('https://picsum.photos/600/400', 11);
INSERT INTO pictures (picture, suite_id) VALUES ('https://picsum.photos/600/400', 12);
INSERT INTO pictures (picture, suite_id) VALUES ('https://picsum.photos/600/400', 14);
INSERT INTO pictures (picture, suite_id) VALUES ('https://picsum.photos/600/400', 14);

-- bookingStatus
INSERT INTO bookingStatus (name) VALUE ('validée');
INSERT INTO bookingStatus (name) VALUE ('annulée');

--bookings
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-03-03', '2022-03-06', 2, 3);
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-06-03', '2022-06-06', 1, 1);
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-06-03', '2022-06-06', 2, 2);
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-06-03', '2022-06-06', 3, 3);
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-06-03', '2022-06-06', 4, 4);
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-05-03', '2022-05-06', 5, 5);
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-06-16', '2022-06-19', 6, 1);
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-04-03', '2022-04-06', 7, 2);
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-08-03', '2022-08-06', 8, 3);
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-06-03', '2022-06-06', 9, 4);
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-07-03', '2022-07-06', 10, 5);
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-11-03', '2022-11-06', 11, 1);
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-05-03', '2022-05-06', 12, 2);
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-06-03', '2022-06-06', 13, 3);
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-05-03', '2022-05-06', 14, 4);
INSERT INTO bookings (startDate, endDate, suite_id, client_id) VALUES ('2022-06-03', '2022-06-06', 15, 5);

-- topics
INSERT INTO topics (name) VALUE ('Je souhaite poser une réclamation');
INSERT INTO topics (name) VALUE ('Je souhaite commander un service supplémentaire');
INSERT INTO topics (name) VALUE ('Je souhaite en savoir plus sur une suite');
INSERT INTO topics (name) VALUE ('J''ai un souci avec cette application');

-- requestStatus
INSERT INTO requestStatus (name) VALUE ('non lu');
INSERT INTO requestStatus (name) VALUE ('lu');

-- contactRequests
INSERT INTO contactRequests (firstname, lastname, email, message, requestDate, topic_id, client_id) VALUES ('Wally', 'Joysey', 'wjoysey0@weebly.com', 'Bonjour, et merci pour vos si belles suites. Pour mon prochain séjour, je souhaiterais ajouter un service à ma réservation. J''aimerais profiter d''une séance de massage à mon arrivée. Est-ce possible ? Merci !', '2022-03-17', 2, 1);
INSERT INTO contactRequests (firstname, lastname, email, message, requestDate, topic_id, client_id) VALUES ('Fabien', 'Durand', 'fdurand@pouet.com', 'Bonjour, je ne comprends pas du tout votre application, et je n''arrive pas à réserver une suite, pouvez-vous m''aider ? Merci !', '2022-03-18' 4, null);
INSERT INTO contactRequests (firstname, lastname, email, message, requestDate, topic_id, client_id, requestStatus_id) VALUES ('Christy', 'Le febre', 'clefebre2@washingtonpost.com', 'Bonjour, je ne suis pas du tout satisfaite de mon séjour dans votre hôtel. La suite ne correspondait pas du tout aux photos, il manquait une chaise ! Indamissible. Merci de me proposer un geste commercial. Bien à vous.', '2022-03-20', 1, 3,2);