# Projet hypnosHotelGroup
***
Réalisation ECF - Studi 2022
***
Hypnos est un groupe hôtelier de luxe souhaitant gérer en interne les services de présentation et de réservation de chambre. C'est pourquoi nous avons lancé le projet **Hypnos Hotel Group** avec la réalisation d'une application web et web mobile. Grâce à ce site, tout le monde peut découvrir l'ensemble de l'offre Hypnos et vérifier les disponibilités de chaque chambre. La réservation étant destinée aux clients connectés, les visiteurs ont la possibilité de s'incrire et se connecter. Concernant la gestion : un espace professionnel est réservé à l'administrateur (qui gère ce qui est relatifs aux hôtels) et aux managers (qui gèrent chacun leur hôtel et les suites associées.)
***
## SOMMAIRE
1. [Statut du projet](#statut-du-projet)
2. [Installation](#installation)
    1. [Récupérer le repo git avec git clone](#récupérer-le-repo-git-avec-git-clone)
    2. [Lancer le serveur PHP et SQL](#lancer-le-serveur-php-et-sql)
    3. [Insérer le fichier SQL dans la bdd](#insérer-le-fichier-sql-dans-la-bdd)
    4. [Renseigner les variables d’environnement](#renseigner-les-variables-denvironnement)
    5. [Composer](#composer)
3. [Technologies](#technologies)
    1. [Front](#front)
    2. [Back](#back)
    3. [Server](#server)
***
## Statut du projet
Projet en cours de développement. Version stable actuellement en ligne. Améliorations prévues concernant l'upload d'images vers S3, la réservation rapide, et les vérifications de disponibilité des suites.

## Installation
Afin de pouvoir installer le projet en local et l'utiliser, veuillez suivre les étapes suivantes :

### Récupérer le repo git avec git clone
Dans votre terminal, veillez à vous positionner dans le répertoire où vous souhaitez ajouter le projet et lancez la commande :
```git clone https://github.com/Swazeec/hypnosHotelGroup.git```
Le projet est à présent sur votre machine en local.

### Lancer le serveur PHP et SQL
Pour tester le projet en local, lancez xampp, mamp, ou le logiciel que vous utilisez sur votre machine, activez Apache et MySQL. 

### Insérer le fichier SQL dans la bdd
Utilisez le fichier scriptSQL.sql situé dans le dossier deployment du projet pour créer votre base de données.

### Renseigner les variables d’environnement
Dans le fichier db.php, situé dans components>db, spécifier vos identifiants de connexion.

Pour faire fonctionner le projet avec AWS S3, vous devrez spécifier vos variables d'environement.
```
aws_access_key_id = id de votre container
aws_secret_access_key = votre clé secrète
```
Vous devrez spécifier le nom de votre **bucket** dans les fichiers **addSuiteScript.php** et **modifySuiteScript.php**, dans le dossier **components**.

### Composer
Réaliser la commande suivante en étant dans le dossier principal : 
```composer update```


## Technologies
### Front
* HTML 5
* CSS 3
* Bootstrap 5.1
* Javascript

### Back 
* PHP 8.1 / PDO
* MySQL
* Composer 2.2.11

### Server
* Possibilité d'un WAMP/XAMPP/MAMP/LAMP
* PAAS Heroku
* Heroku addon : JawsDB MySQL
* PHP 8.1.4
* Apache 2.4.53
* Nginx 1.20.2
* compte AWS S3 nécessaire
