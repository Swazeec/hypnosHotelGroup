-- MariaDB dump 10.19  Distrib 10.4.19-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: hypnos
-- ------------------------------------------------------
-- Server version	10.4.19-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'Alvar','Aalto','alvar.aalto@hypnos.fr','$2y$10$ct2ywHpq62Hjfcr4huxNlu0SkPAD071DQze/FnKa5sy4huoc4WqKG');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `cancellationDate` date DEFAULT (`startDate` + interval -3 day),
  `bookingStatus_id` int(11) NOT NULL DEFAULT 1,
  `suite_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bookingStatus_id` (`bookingStatus_id`),
  KEY `suite_id` (`suite_id`),
  KEY `client_id` (`client_id`),
  CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`bookingStatus_id`) REFERENCES `bookingstatus` (`id`),
  CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`suite_id`) REFERENCES `suites` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES (1,'2022-03-03','2022-03-06','2022-02-28',1,2,3),(2,'2022-06-03','2022-06-06','2022-05-31',1,1,1),(3,'2022-06-03','2022-06-06','2022-05-31',1,2,2),(4,'2022-06-03','2022-06-06','2022-05-31',1,3,3),(5,'2022-06-03','2022-06-06','2022-05-31',1,4,4),(6,'2022-05-03','2022-05-06','2022-04-30',1,5,5),(7,'2022-06-16','2022-06-19','2022-06-13',1,6,1),(8,'2022-04-03','2022-04-06','2022-03-31',1,7,2),(9,'2022-08-03','2022-08-06','2022-07-31',1,8,3),(10,'2022-06-03','2022-06-06','2022-05-31',1,9,4),(11,'2022-07-03','2022-07-06','2022-06-30',1,10,5),(12,'2022-11-03','2022-11-06','2022-10-31',1,11,1),(13,'2022-05-03','2022-05-06','2022-04-30',1,12,2),(14,'2022-06-03','2022-06-06','2022-05-31',1,13,3),(15,'2022-05-03','2022-05-06','2022-04-30',1,14,4),(16,'2022-06-03','2022-06-06','2022-05-31',1,15,5);
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bookingstatus`
--

DROP TABLE IF EXISTS `bookingstatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bookingstatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookingstatus`
--

LOCK TABLES `bookingstatus` WRITE;
/*!40000 ALTER TABLE `bookingstatus` DISABLE KEYS */;
INSERT INTO `bookingstatus` VALUES (1,'validée'),(2,'annulée');
/*!40000 ALTER TABLE `bookingstatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'Wally','Joysey','wjoysey0@weebly.com','$2y$10$StI0j2U66u0FxxItQcXDHOjbVV9atUSQuOOzvTw4.pE.ZzmD5RM9K'),(2,'Phip','Celler','pceller1@mlb.com','$2y$10$O2SqZ1tpVDHFnsmrHxSCB.ewchAPnQAp4Sxx0fUq71A3auvSzOtnS'),(3,'Christy','Le febre','clefebre2@washingtonpost.com','$2y$10$KN/dq9AUrS868uCi2U7/puKkyFjF6IIjcbRKuYtf5mZv8Cv0QAbzm'),(4,'Sebastiano','Ambrosini','sambrosini3@geocities.com','$2y$10$FyMuktbrxxbeyDt1hjEAeOiOYCVgl0o89dYWrpZ0Tuo/DlkDIPKya'),(5,'Barn','Tyas','btyas4@mlb.com','$2y$10$cy3rwbTr.0h9qBeSUIP8AumzEWZ31hGKmps0usjVBu4RohZzm83QG'),(6,'Isiahi','Ducrow','iducrow5@elpais.com','$2y$10$muXuDwbAYsvqWgbdY80g7eWPEpkU76PoItBRSQXMXCyypbvqW/J7C'),(7,'Kessiah','Rean','krean6@1und1.de','$2y$10$FpqNRg8P3Lzud/YSm5WhO.ro0zqAeTIL3RayFr8j6T5RyHbf6oZ/S'),(8,'Thorsten','Thorington','tthorington7@pen.io','$2y$10$uxh8dVfukfrHQusWZwiG5.jibR0fPVqFF6LpjVXlk7zjALRSyUXqm'),(9,'Oren','Dwire','odwire8@webeden.co.uk','$2y$10$hYL9WDd3lTaTqylXCgWd5.l66c1s6YBhJfGMpkbdYrHvTjT1C/gkS'),(10,'Winny','Coltherd','wcoltherd9@globo.com','$2y$10$iifkRCIsUMDRPUPYQyZKV.UmhJO7g2cpUjuZ1Bu//BDtQpxNg.fvK');
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contactrequests`
--

DROP TABLE IF EXISTS `contactrequests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `contactrequests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestDate` date DEFAULT (DATE( NOW() )),
  `topic_id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `requestStatus_id` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `topic_id` (`topic_id`),
  KEY `client_id` (`client_id`),
  KEY `requestStatus_id` (`requestStatus_id`),
  CONSTRAINT `contactrequests_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`),
  CONSTRAINT `contactrequests_ibfk_2` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  CONSTRAINT `contactrequests_ibfk_3` FOREIGN KEY (`requestStatus_id`) REFERENCES `requeststatus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contactrequests`
--

LOCK TABLES `contactrequests` WRITE;
/*!40000 ALTER TABLE `contactrequests` DISABLE KEYS */;
INSERT INTO `contactrequests` VALUES (1,'Wally','Joysey','wjoysey0@weebly.com','Bonjour, et merci pour vos si belles suites. Pour mon prochain séjour, je souhaiterais ajouter un service à ma réservation. J\'aimerais profiter d\'une séance de massage à mon arrivée. Est-ce possible ? Merci !','2022-03-17',2,1,1),(2,'Fabien','Durand','fdurand@pouet.com','Bonjour, je ne comprends pas du tout votre application, et je n\'arrive pas à réserver une suite, pouvez-vous m\'aider ? Merci !','2022-03-18',4,NULL,1),(3,'Christy','Le febre','clefebre2@washingtonpost.com','Bonjour, je ne suis pas du tout satisfaite de mon séjour dans votre hôtel. La suite ne correspondait pas du tout aux photos, il manquait une chaise ! Indamissible. Merci de me proposer un geste commercial. Bien à vous.','2022-03-20',1,3,2);
/*!40000 ALTER TABLE `contactrequests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotels`
--

DROP TABLE IF EXISTS `hotels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hotels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `manager_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `manager_id` (`manager_id`),
  CONSTRAINT `hotels_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `managers` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotels`
--

LOCK TABLES `hotels` WRITE;
/*!40000 ALTER TABLE `hotels` DISABLE KEYS */;
INSERT INTO `hotels` VALUES (1,'Hôtel Marimekko','Paris','12 rue Annika Rimala','L\'hôtel Marimekko vous accueille lorem ipsum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis. Non consequatur labore est eligendi quos sit omnis iste non corporis dolores. Ut velit quod est impedit molestiae non dignissimos molestiae vel dolore minima ut Quis saepe sit unde corrupti sed sapiente optio.  ',1),(2,'Hôtel Artek','Rennes','2 avenue de la Finlande','L\'hôtel Artek vous propose une ambiance digne des plus grands designers danois. Lorem ipsum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis. Non consequatur labore est eligendi quos sit omnis iste non corporis dolores. Ut velit quod est impedit molestiae non dignissimos molestiae vel dolore minima ut Quis saepe sit unde corrupti sed sapiente optio. ',2),(3,'Hôtel Louis Poulsen','Lyon','5 allée de la lumière','L\'hôtel Louis Poulsen vous acceuille dans un environnement propice à la détente. Lorem ipsum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis. Non consequatur labore est eligendi quos sit omnis iste non corporis dolores. Ut velit quod est impedit molestiae non dignissimos molestiae vel dolore minima ut Quis saepe sit unde corrupti sed sapiente optio. ',3);
/*!40000 ALTER TABLE `hotels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `managers`
--

DROP TABLE IF EXISTS `managers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `managers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `managers`
--

LOCK TABLES `managers` WRITE;
/*!40000 ALTER TABLE `managers` DISABLE KEYS */;
INSERT INTO `managers` VALUES (1,'Marice','Overnell','movernell0@constantcontact.com','$2y$10$0xt5NIjlTTV.0G5LjFYxzeINoBTW/Iom7ul.DyN4bo0zDHFXrKsdm'),(2,'Maire','Duchant','mduchant1@google.ru','$2y$10$h5MYG.Uv32a2cvZUonADl.pCJlklT8kIozi8uJI9InIIBfu2CCsO2'),(3,'Adoree','Bonnier','abonnier2@chron.com','$2y$10$5sR8Bar7wYNsfgHGekWMLOGvHCNM/JTn./1sKOBqNZDT9wNBHug1.');
/*!40000 ALTER TABLE `managers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pictures`
--

DROP TABLE IF EXISTS `pictures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `picture` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `suite_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `suite_id` (`suite_id`),
  CONSTRAINT `pictures_ibfk_1` FOREIGN KEY (`suite_id`) REFERENCES `suites` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pictures`
--

LOCK TABLES `pictures` WRITE;
/*!40000 ALTER TABLE `pictures` DISABLE KEYS */;
INSERT INTO `pictures` VALUES (1,'https://picsum.photos/600/400',1),(2,'https://picsum.photos/600/400',1),(3,'https://picsum.photos/600/400',1),(4,'https://picsum.photos/600/400',3),(5,'https://picsum.photos/600/400',4),(6,'https://picsum.photos/600/400',5),(7,'https://picsum.photos/600/400',5),(8,'https://picsum.photos/600/400',6),(9,'https://picsum.photos/600/400',8),(10,'https://picsum.photos/600/400',8),(11,'https://picsum.photos/600/400',9),(12,'https://picsum.photos/600/400',11),(13,'https://picsum.photos/600/400',12),(14,'https://picsum.photos/600/400',14),(15,'https://picsum.photos/600/400',14);
/*!40000 ALTER TABLE `pictures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prices`
--

DROP TABLE IF EXISTS `prices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price` decimal(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prices`
--

LOCK TABLES `prices` WRITE;
/*!40000 ALTER TABLE `prices` DISABLE KEYS */;
INSERT INTO `prices` VALUES (1,300.00);
/*!40000 ALTER TABLE `prices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requeststatus`
--

DROP TABLE IF EXISTS `requeststatus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requeststatus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requeststatus`
--

LOCK TABLES `requeststatus` WRITE;
/*!40000 ALTER TABLE `requeststatus` DISABLE KEYS */;
INSERT INTO `requeststatus` VALUES (1,'non lu'),(2,'lu');
/*!40000 ALTER TABLE `requeststatus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suites`
--

DROP TABLE IF EXISTS `suites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `primePicture` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `price_id` (`price_id`),
  KEY `hotel_id` (`hotel_id`),
  CONSTRAINT `suites_ibfk_1` FOREIGN KEY (`price_id`) REFERENCES `prices` (`id`),
  CONSTRAINT `suites_ibfk_2` FOREIGN KEY (`hotel_id`) REFERENCES `hotels` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suites`
--

LOCK TABLES `suites` WRITE;
/*!40000 ALTER TABLE `suites` DISABLE KEYS */;
INSERT INTO `suites` VALUES (1,'Maija Isola','Une magnifique suite à la décoration florale, propice à la détente. Lorem ispum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis.','https://picsum.photos/600/400','https://www.google.com/',1,1),(2,'Maija Louekari','Profitez, dans cette suite ornée du motif Siirtolapuutarha, d\'un univers de jardin onirique et coloré. Lorem ispum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis.','https://picsum.photos/600/400','https://www.google.com/',1,1),(3,'Armi Ratia ','L\'univers de la suite Armi Ratia conviendra aux adeptes de la simplicité. Lorem ispum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis.','https://picsum.photos/600/400','https://www.google.com/',1,1),(4,'Sanna Annuka','Cette suite nous plonge dans une tradition finlandaise très colorée. Lorem ispum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis.','https://picsum.photos/600/400','https://www.google.com/',1,1),(5,'Annika Rimala','Pour les amoureux de design rétro ! Lorem ispum dolor sit amet. Aut deleniti velit et culpa facere qui voluptas veritatis ut consequatur voluptas et reiciendis dolores qui mollitia blanditiis.','https://picsum.photos/600/400','https://www.google.com/',1,1),(6,'Ilmari Tapiovaara','Suite luxueuse et meublée avec salle de bain privée. La suite Tapiovaara va vous faire voyager. Vous pourrez profiter des avantages de votre propre suite et salle de bain privative avec douche à l\'italienne et sauna, de la connexion Wifi en haut-débit, d\'une vue sur l\'extérieur ainsi que d\'un mini bar avec de l\'eau.','https://picsum.photos/600/400','https://www.google.com',1,2),(7,'Aino Aalto','L\'Extravagante Suite Aino Aalto offre confort dans un décor inspiré des tendances des pays scandinaves. Récemment rénovée, cette suite est idéale pour les escapades en amoureux. Vous apprécierez sa salle de bain moderne munie d\'un bain et d\'une douche.','https://picsum.photos/600/400','https://www.google.com/',1,2),(8,'Bouroullec','Sobre et coquette, la suite Bouroullec rappelle les chalets nordiques et se démarque par sa gamme de textures et de couleurs. Le bois brut des meubles contraste avec les teintes irisées, aux airs d’aurore boréale, des lattes de céramique qui enveloppent sa douche multi-jets et sa baignoire sabot.','https://picsum.photos/600/400','https://www.google.com/',1,2),(9,'Fintone','Le spectaculaire décor de la suite Finetone joue sur le contraste entre le doré lumineux de ses murs et le noir profond de sa paroi en bois laqué. Amateurs de lieux au luxe chatoyant, venez vous prélasser dans sa magnifique baignoire qui est une pièce à part entière!','https://picsum.photos/600/400','https://www.google.com/',1,2),(10,'Rybakken','Avec ses tons bleutés, la suite Rybakken saura vous transporter au firmament. Son décor aérien et lumineux en fait le lieu idéal pour se détendre, en paressant dans sa baignoire douillette ou sur son lit à baldaquin moderne, tous deux surplombés d\'un plafond de miroirs.','https://picsum.photos/600/400','https://www.google.com/',1,2),(11,'Poul Henningsen','Suite de luxe avec accès privé, la suite Poul Henningsen est aménagée sur deux étages, dans un décor éclatant qui ose le rose et le doré ! Avec sa chambre mezzanine surplombant le salon, la Nordique est particulièrement spacieuse. Son ambiance séduisante est mise en valeur par de nombreux éclairages et un jeu de miroirs.','https://picsum.photos/600/400','https://www.google.com/',1,3),(12,'Arne Jacobsen','Multipliant les touches qui évoquent la nature, la Arne Jacobsen est une suite d’esprit nordique. Avec ses panneaux imitation bois et son large banc, sa salle de bain n\'est pas sans rappeler l\'espace du sauna, tout en étant équipée d’une luxueuse douche pluie. Petits plus : un balcon privé et un lit king.','https://picsum.photos/600/400','https://www.google.com/',1,3),(13,'Anu Moser','La suite Siberia a l\'intimité et le cachet d\'une cabane dans la forêt, le confort en plus ! Cette suite tire tout son charme de son mobilier en bois rustique, son foyer et ses couleurs chaleureuses. Une jolie particularité : le miroir mural au-dessus de la grande baignoire îlot.','https://picsum.photos/600/400','https://www.google.com/',1,3),(14,'Vilhelm Lauritzen','Sobre et coquette, la suite Vilhelm Lauritzen rappelle les chalets nordiques et se démarque par sa gamme de textures et de couleurs. Le bois brut des meubles contraste avec les teintes irisées, aux airs d’aurore boréale, des lattes de céramique qui enveloppent sa douche multi-jets et sa baignoire sabot.','https://picsum.photos/600/400','https://www.google.com/',1,3),(15,'Verner Panton','Suite luxueuse et meublée avec salle de bain privée. La suite Tapiovaara va vous faire voyager. Vous pourrez profiter des avantages de votre propre suite et salle de bain privative avec douche à l\'italienne et sauna, de la connexion Wifi en haut-débit, d\'une vue sur l\'extérieur ainsi que d\'un mini bar avec de l\'eau.','https://picsum.photos/600/400','https://www.google.com/',1,3);
/*!40000 ALTER TABLE `suites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `topics`
--

DROP TABLE IF EXISTS `topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `topics`
--

LOCK TABLES `topics` WRITE;
/*!40000 ALTER TABLE `topics` DISABLE KEYS */;
INSERT INTO `topics` VALUES (1,'Je souhaite poser une réclamation'),(2,'Je souhaite commander un service supplémentaire'),(3,'Je souhaite en savoir plus sur une suite'),(4,'J\'ai un souci avec cette application');
/*!40000 ALTER TABLE `topics` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-03-18 15:39:26
