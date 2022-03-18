<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hypnos Hotel Group</title>
    <meta name="description" content="Bienvenue dans nos hôtels Hypnos !">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@1,400;1,600&family=Neuton:wght@300;400&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="./assets/styles/style.css">
    <link rel="shortcut icon" href="./assets/img/hypnos-logo.svg" type="image/svg">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</head>
<body class="bg-offwhite">
    <main class="container-fluid">
        <header class="row bg-dblue p-3 d-flex justify-content-between">
            <div class="col-lg-2 col">
                <a href="./index.php"><img class="" src="./assets/img/hypnos-logo-gold.svg" alt="logo Hypnos"></a>
            </div>
            <!-- NAVBAR DESKTOP -->
            <div class=" col-lg align-self-center  d-none d-lg-block">
                <h1 class="text-center text-offwhite d-none d-lg-block">Hypnos Hotel Group</h1>
                <nav class="navbar navbar-expand-lg bg-dblue">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class=""><img src="./assets/img/burger.svg" alt="menu burger"></span>
                        </button>
                        <div class="collapse navbar-collapse  d-lg-flex justify-content-end" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="./index.php">ACCUEIL</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">NOS HÔTELS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">RÉSERVEZ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">CONTACT</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">INSCRIPTION/CONNEXION</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <!-- NAVBAR MOBILE -->
            <nav class="navbar d-lg-none col">
                <div class="container-fluid d-lg-flex justify-content-end">
                    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <img src="./assets/img/burger.svg" alt="menu burger">
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                        <div class="offcanvas-header bg-dblue">
                            <h5 class="offcanvas-title text-offwhite" id="offcanvasNavbarLabel">Hypnos Hotel Group</h5>
                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body bg-dblue">
                            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                <li class="nav-item">
                                    <a class="nav-link" href="./index.php">ACCUEIL</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">NOS HÔTELS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">RÉSERVEZ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">CONTACT</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">INSCRIPTION/CONNEXION</a>
                                </li>
                            </ul>
                            
                        </div>
                    </div>
                </div>
            </nav>
        </header>