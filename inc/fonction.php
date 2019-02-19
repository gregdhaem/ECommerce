<?php

function debug($var, $mode = 1)
{
    echo '<div class=" col-md-8 offset-md-2 alert alert-info mt-2 mb-2">';

    $trace = debug_backtrace(); // fonction prédéfinie retournant un tableau avec des infos comme ligne et fichier
    #echo '<pre>'; print_r($trace); echo '</pre>';

    $trace = array_shift($trace);
    #echo '<pre>'; print_r($trace); echo '</pre>';

    echo "Debug sur la ligne $trace[line] du fichier $trace[file] !<hr>";
    
    if($mode === 1)// Si le mode est à 1 (mode par défaut) print_r est utilisé
    {
        echo '<pre>'; print_r($var); echo '</pre>';
    }
    else // Var dump
    {
        echo '<pre>'; var_dump($var); echo '</pre>';
    }

    echo '</div>';
}

//---------------------------------------------Fonction Membre connecté-----------------------------------

function userIsConnected() // fonction créée pour vérifier que le tableau ARRAY membre est existant dans la session
{
    if(isset($_SESSION['membre']))
    {
        return true;
    }
    else // le user n'est pas connecté
    {
        return false;
    }
}

//---------------------------------------------Fonction administrateur connecté-----------------------------------

function adminIsConnected() // fonction créée pour vérifier que le user est admin
{
    if(userIsConnected() && $_SESSION['membre']['statut'] == 1) //On verifie qu'il est connecté par la fonction userIsConnected() et que son statut est = à 1
    {
        return true;
    }
    else // le user n'est pas admin
    {
        return false;
    }
}

//---------------------------------------------PANIER------------------------------------------------------------

function createBasket()
{
    if(!isset($_SESSION['panier'])) // Si indice panier non défini : panier créé dans la session 
    {
        $_SESSION['panier'] = array(); // tableau array pour chaque indice : plusieurs produits dans le panier
        $_SESSION['panier']['titre'] = array();
        $_SESSION['panier']['id_produit'] = array();
        $_SESSION['panier']['quantite'] = array();
        $_SESSION['panier']['prix'] = array();
    }
}

function addProdToBasket($titre, $id_produit, $quantite, $prix)
{
    createBasket(); //création du panier dans la session

    $checkIfProductPresentAndFindRowNumber = array_search($id_produit, $_SESSION['panier']['id_produit']);// array search pour trouver l'indice dans l'array

    if($checkIfProductPresentAndFindRowNumber !== false)// présence du produit dans la session 
    {
        $_SESSION['panier']['quantite'][$checkIfProductPresentAndFindRowNumber] += $quantite;// Si produit déjà dans le panier de la session : ajout de la quantité à lui même
    }
    else // produit non présent dans la session
    {
        $_SESSION['panier']['titre'][] = $titre; // [] génère des indices numériques
        $_SESSION['panier']['id_produit'][] = $id_produit;
        $_SESSION['panier']['quantite'][] = $quantite;
        $_SESSION['panier']['prix'][] = $prix;
    }
}

function totalBasketAmount()
{
    $total = 0;
    for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++)
    {
        $total += $_SESSION['panier']['quantite'][$i]* $_SESSION['panier']['prix'][$i];
    }
    return round($total, 2);
}

?>