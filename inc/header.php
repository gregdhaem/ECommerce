<!DOCTYPE html>
<html lang="en">

<head>
    <title>La Boutique de Greg</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
    <link href="<?= URL ?>inc/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp"
        crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-secondary ">
        <a class="display-3 navbar-brand font-weight-bold text-warning" href="<?= URL ?>boutique.php"><i class="fas fa-2x fa-tshirt"></i>

            Greg's Tee Shop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php
                if(userIsConnected())
                {   // Accès utilisateur
                    echo '<li class="nav-item"><a class="nav-link text-dark" href="' . URL . 'profil.php">Gestion profil</a></li>';
                
                    echo '<li class="nav-item"><a class="nav-link text-dark" href="' . URL . 'boutique.php">Boutique</a></li>';
                
                    echo '<li class="nav-item"><a class="nav-link text-dark" href="' . URL . 'panier.php">Gestion panier</a></li>';
                
                    echo '<li class="nav-item"><a class="nav-link text-dark" href="' . URL . 'connexion.php?action=deconnexion">Déconnexion</a></li>';
                }
                else
                {
                    echo '<li class="nav-item"><a class="nav-link text-dark" href="' . URL . 'inscription.php">Inscription</a></li>';
                    
                    echo '<li class="nav-item"><a class="nav-link text-dark" href="' . URL . 'connexion.php">Connexion</a></li>';
                
                    echo '<li class="nav-item"><a class="nav-link text-dark" href="' . URL . 'boutique.php">Boutique</a></li>';

                    echo '<li class="nav-item"><a class="nav-link text-dark" href="' . URL . 'panier.php">Gestion panier</a></li>';
                }

                if(adminIsConnected())
                {
                    echo '<li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        Back Office
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="' . URL . 'admin/gestion_boutique.php">Gestion Boutique</a>
                            <a class="dropdown-item" href="' . URL . 'admin/gestion_membre.php">Gestion Membre</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="' . URL . 'admin/gestion_commande.php">Gestion Commande</a>
                        </div>
                    </li>';  

                }
                ?>

            </ul>
            <form class="form-inline my-2 my-md-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Chercher..." aria-label="Search">
                <button class="btn btn-outline-warning my-2 my-sm-0" type="submit">Rechercher</button>
            </form>
        </div>
    </nav>
    <section class="container mon-conteneur">