<?php 
require_once "./inc/init.php";

//---------------Ajout Panier---------------

if(isset($_POST['ajout_panier']))
{
    #debug($_POST);
    $req = $bdd->prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
    $req->bindValue(':id_produit', $_POST['id_produit'], PDO::PARAM_INT);
    $req->execute();

    $prod = $req->fetch(PDO::FETCH_ASSOC);
    #debug($prod);

    addProdToBasket($prod['titre'], $_POST['id_produit'], $_POST['quantite'], $prod['prix']);

    #debug($_SESSION);

}


require "./inc/header.php";
?>
<table class="table mt-4">

    <tr><th colspan="5" class="text-center"> <h3 class="text-warning display-4">PANIER</h3> </th></tr>
    <tr><th>Titre</th><th>Quantité</th><th>Prix Unitaire</th><th>Prix Total</th><th>Supprimer</th></tr>

    <?php if(empty($_SESSION['panier']['id_produit'])): ?>

    <tr><td colspan="5"><p class="text-center display-2 text-warning">VOTRE PANIER EST VIDE !!</p></td></tr>

    <?php else: ?>

        <?php for($i = 0; $i < count($_SESSION['panier']['id_produit']); $i++): ?>

        <tr>
        
            <td><?= $_SESSION['panier']['titre'][$i] ?></td>
            <td><?= $_SESSION['panier']['quantite'][$i] ?></td>
            <td><?= $_SESSION['panier']['prix'][$i] ?></td>
            <td><?= $_SESSION['panier']['quantite'][$i]*$_SESSION['panier']['prix'][$i] ?> €</td>
            <td><a href="" class="text-warning"><i class="fas fa-2x fa-trash-alt"></i></a></td>  
        
        </tr>

        <?php endfor; ?>
            <tr><th colspan="3"><th colspan="2"> Total : <?= totalBasketAmount() ?> €</th></th></tr>
    <?php endif; ?>
</table>



<?php require "./inc/footer.php"; 

?>