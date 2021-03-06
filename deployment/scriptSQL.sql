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
    requestDate DATE DEFAULT (DATE( NOW() )),
    topic_id INT NOT NULL,
    client_id INT DEFAULT null,
    requestStatus_id INT NOT NULL DEFAULT 1,
    FOREIGN KEY (topic_id) REFERENCES topics(id),
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (requestStatus_id) REFERENCES requestStatus(id)
) engine = innodb;

-- CREATION UTILISATEURS / PRIVILEGES -- NON DISPO AVEC JAWSDB/HEROKU EN VERSION GRATUITE

-- admin
CREATE USER 'admin'@'localhost' IDENTIFIED BY '@@34tcx7ES';
GRANT ALL PRIVILEGES ON hypnos.* TO 'admin'@'localhost';

-- manager
CREATE USER 'manager'@'localhost' IDENTIFIED BY '7@rn2Tp2H@';
GRANT INSERT, UPDATE, DELETE ON hypnos.suites TO 'manager'@'localhost';
GRANT INSERT, UPDATE, DELETE ON hypnos.pictures TO 'manager'@'localhost';
GRANT INSERT, UPDATE, DELETE ON hypnos.prices TO 'manager'@'localhost';
GRANT SELECT ON hypnos.* TO 'manager'@'localhost';

-- client
CREATE USER 'client'@'localhost' IDENTIFIED BY 'WMh9@t7@p3';
GRANT INSERT, UPDATE ON hypnos.clients TO 'client'@'localhost';
GRANT INSERT, UPDATE ON hypnos.bookings TO 'client'@'localhost';
GRANT INSERT ON hypnos.contactRequests TO 'client'@'localhost';
GRANT SELECT ON hypnos.* TO 'client'@'localhost';

-- no-auth
CREATE USER 'noauth'@'localhost' IDENTIFIED BY '2@x@RMqm57';
GRANT INSERT ON hypnos.clients TO 'noauth'@'localhost';
GRANT INSERT ON hypnos.contactRequests TO 'noauth'@'localhost';
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
INSERT INTO hotels (name, city, address, description, manager_id) VALUES ('H??tel Marimekko', 'Paris', '12 rue Annika Rimala', 'L''h??tel Marimekko vous accueille lorem ipsum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis. Non consequatur labore est eligendi quos sit omnis iste non corporis dolores. Ut velit quod est impedit molestiae non dignissimos molestiae vel dolore minima ut Quis saepe sit unde corrupti sed sapiente optio.  ', 1);
INSERT INTO hotels (name, city, address, description, manager_id) VALUES ('H??tel Artek', 'Rennes', '2 avenue de la Finlande', 'L''h??tel Artek vous propose une ambiance digne des plus grands designers danois. Lorem ipsum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis. Non consequatur labore est eligendi quos sit omnis iste non corporis dolores. Ut velit quod est impedit molestiae non dignissimos molestiae vel dolore minima ut Quis saepe sit unde corrupti sed sapiente optio. ', 2);
INSERT INTO hotels (name, city, address, description, manager_id) VALUES ('H??tel Louis Poulsen', 'Lyon', '5 all??e de la lumi??re', 'L''h??tel Louis Poulsen vous acceuille dans un environnement propice ?? la d??tente. Lorem ipsum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis. Non consequatur labore est eligendi quos sit omnis iste non corporis dolores. Ut velit quod est impedit molestiae non dignissimos molestiae vel dolore minima ut Quis saepe sit unde corrupti sed sapiente optio. ', 3);

-- prices
INSERT INTO prices (price) VALUE (300);

-- suites
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Maija Isola', 'Une magnifique suite ?? la d??coration florale, propice ?? la d??tente. Lorem ispum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis.', 'https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-hotel1-suite-1.jpg', 'https://www.google.com/', 1, 1);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Maija Louekari', 'Profitez, dans cette suite orn??e du motif Siirtolapuutarha, d''un univers de jardin onirique et color??. Lorem ispum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis.', 'https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-hotel1-suite-2.jpg', 'https://www.google.com/', 1, 1);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Armi Ratia ', 'L''univers de la suite Armi Ratia conviendra aux adeptes de la simplicit??. Lorem ispum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis.', 'https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-hotel1-suite-3.jpg', 'https://www.google.com/', 1, 1);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Sanna Annuka', 'Cette suite nous plonge dans une tradition finlandaise tr??s color??e. Lorem ispum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis.', 'https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-hotel1-suite-4.jpg', 'https://www.google.com/', 1, 1);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Annika Rimala', 'Pour les amoureux de design r??tro ! Lorem ispum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis.', 'https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-hotel1-suite-5.jpg', 'https://www.google.com/', 1, 1);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Ilmari Tapiovaara', 'Suite luxueuse et meubl??e avec salle de bain priv??e. La suite Tapiovaara va vous faire voyager. Vous pourrez profiter des avantages de votre propre suite et salle de bain privative avec douche ?? l''italienne et sauna, de la connexion Wifi en haut-d??bit, d''une vue sur l''ext??rieur ainsi que d''un mini bar avec de l''eau.', 'https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-hotel2-suite-1.jpg', 'https://www.google.com', 1, 2);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Aino Aalto', 'L''Extravagante Suite Aino Aalto offre confort dans un d??cor inspir?? des tendances des pays scandinaves. R??cemment r??nov??e, cette suite est id??ale pour les escapades en amoureux. Vous appr??cierez sa salle de bain moderne munie d''un bain et d''une douche.', 'https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-hotel2-suite-2.jpg', 'https://www.google.com/', 1, 2);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Bouroullec', 'Sobre et coquette, la suite Bouroullec rappelle les chalets nordiques et se d??marque par sa gamme de textures et de couleurs. Le bois brut des meubles contraste avec les teintes iris??es, aux airs d???aurore bor??ale, des lattes de c??ramique qui enveloppent sa douche multi-jets et sa baignoire sabot.', 'https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-hotel2-suite-3.jpg', 'https://www.google.com/', 1, 2);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Fintone', 'Le spectaculaire d??cor de la suite Finetone joue sur le contraste entre le dor?? lumineux de ses murs et le noir profond de sa paroi en bois laqu??. Amateurs de lieux au luxe chatoyant, venez vous pr??lasser dans sa magnifique baignoire qui est une pi??ce ?? part enti??re!', 'https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-hotel2-suite-4.jpg', 'https://www.google.com/', 1, 2);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Rybakken', 'Avec ses tons bleut??s, la suite Rybakken saura vous transporter au firmament. Son d??cor a??rien et lumineux en fait le lieu id??al pour se d??tendre, en paressant dans sa baignoire douillette ou sur son lit ?? baldaquin moderne, tous deux surplomb??s d''un plafond de miroirs.', 'https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-hotel2-suite-5.jpg', 'https://www.google.com/', 1, 2);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Poul Henningsen', 'Suite de luxe avec acc??s priv??, la suite Poul Henningsen est am??nag??e sur deux ??tages, dans un d??cor ??clatant qui ose le rose et le dor?? ! Avec sa chambre mezzanine surplombant le salon, la Nordique est particuli??rement spacieuse. Son ambiance s??duisante est mise en valeur par de nombreux ??clairages et un jeu de miroirs.', 'https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-hotel3-suite-1.jpg', 'https://www.google.com/', 1, 3);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Arne Jacobsen', 'Multipliant les touches qui ??voquent la nature, la Arne Jacobsen est une suite d???esprit nordique. Avec ses panneaux imitation bois et son large banc, sa salle de bain n''est pas sans rappeler l''espace du sauna, tout en ??tant ??quip??e d???une luxueuse douche pluie. Petits plus : un balcon priv?? et un lit king.', 'https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-hotel3-suite-2.jpg', 'https://www.google.com/', 1, 3);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Anu Moser', 'La suite Siberia a l''intimit?? et le cachet d''une cabane dans la for??t, le confort en plus ! Cette suite tire tout son charme de son mobilier en bois rustique, son foyer et ses couleurs chaleureuses. Une jolie particularit?? : le miroir mural au-dessus de la grande baignoire ??lot.', 'https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-hotel3-suite-3.jpg', 'https://www.google.com/', 1, 3);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Vilhelm Lauritzen', 'Sobre et coquette, la suite Vilhelm Lauritzen rappelle les chalets nordiques et se d??marque par sa gamme de textures et de couleurs. Le bois brut des meubles contraste avec les teintes iris??es, aux airs d???aurore bor??ale, des lattes de c??ramique qui enveloppent sa douche multi-jets et sa baignoire sabot.', 'https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-hotel3-suite-4+.jpg', 'https://www.google.com/', 1, 3);
INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) VALUES ('Verner Panton', 'Suite luxueuse et meubl??e avec salle de bain priv??e. La suite Tapiovaara va vous faire voyager. Vous pourrez profiter des avantages de votre propre suite et salle de bain privative avec douche ?? l''italienne et sauna, de la connexion Wifi en haut-d??bit, d''une vue sur l''ext??rieur ainsi que d''un mini bar avec de l''eau.', 'https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-hotel3-suite-5.jpg', 'https://www.google.com/', 1, 3);

-- pictures
INSERT INTO pictures (picture, suite_id) VALUES ('https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-pexels-atbo-245208.jpg', 1);
INSERT INTO pictures (picture, suite_id) VALUES ('https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-pexels-christa-grover-1910472.jpg', 1);
INSERT INTO pictures (picture, suite_id) VALUES ('https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-pexels-houzlook-com-3797991.jpg', 1);
INSERT INTO pictures (picture, suite_id) VALUES ('https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-pexels-chait-goli-1918291.jpg', 3);
INSERT INTO pictures (picture, suite_id) VALUES ('https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-pexels-jean-van-der-meulen-1457842.jpg', 4);
INSERT INTO pictures (picture, suite_id) VALUES ('https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-pexels-joey-342800.jpg', 5);
INSERT INTO pictures (picture, suite_id) VALUES ('https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-pexels-pixabay-276724.jpg', 5);
INSERT INTO pictures (picture, suite_id) VALUES ('https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-pexels-ksenia-chernaya-3965521.jpg', 6);
INSERT INTO pictures (picture, suite_id) VALUES ('https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-pexels-quang-nguyen-vinh-2134224.jpg', 8);
INSERT INTO pictures (picture, suite_id) VALUES ('https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-pexels-terry-magallanes-2635038.jpg', 8);
INSERT INTO pictures (picture, suite_id) VALUES ('https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-pexels-quark-studio-2507016.jpg', 9);
INSERT INTO pictures (picture, suite_id) VALUES ('https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-pexels-vecislavas-popa-1571460.jpg', 11);
INSERT INTO pictures (picture, suite_id) VALUES ('https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-pexels-terry-magallanes-2988860.jpg', 12);
INSERT INTO pictures (picture, suite_id) VALUES ('https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-pexels-terry-magallanes-2988865.jpg', 14);
INSERT INTO pictures (picture, suite_id) VALUES ('https://hypnoshotelgroup.s3.eu-west-3.amazonaws.com/hypnos-pexels-victoria-borodinova-1648776.jpg', 14);

-- bookingStatus
INSERT INTO bookingStatus (name) VALUE ('valid??e');
INSERT INTO bookingStatus (name) VALUE ('annul??e');

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
INSERT INTO topics (name) VALUE ('Je souhaite poser une r??clamation');
INSERT INTO topics (name) VALUE ('Je souhaite commander un service suppl??mentaire');
INSERT INTO topics (name) VALUE ('Je souhaite en savoir plus sur une suite');
INSERT INTO topics (name) VALUE ('J''ai un souci avec cette application');

-- requestStatus
INSERT INTO requestStatus (name) VALUE ('non lu');
INSERT INTO requestStatus (name) VALUE ('lu');

-- contactRequests
INSERT INTO contactRequests (firstname, lastname, email, message, requestDate, topic_id, client_id) VALUES ('Wally', 'Joysey', 'wjoysey0@weebly.com', 'Bonjour, et merci pour vos si belles suites. Pour mon prochain s??jour, je souhaiterais ajouter un service ?? ma r??servation. J''aimerais profiter d''une s??ance de massage ?? mon arriv??e. Est-ce possible ? Merci !', '2022-03-17', 2, 1);
INSERT INTO contactRequests (firstname, lastname, email, message, requestDate, topic_id, client_id) VALUES ('Fabien', 'Durand', 'fdurand@pouet.com', 'Bonjour, je ne comprends pas du tout votre application, et je n''arrive pas ?? r??server une suite, pouvez-vous m''aider ? Merci !', '2022-03-18', 4, null);
INSERT INTO contactRequests (firstname, lastname, email, message, requestDate, topic_id, client_id, requestStatus_id) VALUES ('Christy', 'Le febre', 'clefebre2@washingtonpost.com', 'Bonjour, je ne suis pas du tout satisfaite de mon s??jour dans votre h??tel. La suite ne correspondait pas du tout aux photos, il manquait une chaise ! Indamissible. Merci de me proposer un geste commercial. Bien ?? vous.', '2022-03-20', 1, 3,2);