<?php 
require_once "./inc/init.php";
require "./inc/header.php";

if(isset($_GET['id_produit'])) :

    $req = $bdd->prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
    $req->bindValue(':id_produit', $_GET['id_produit'], PDO::PARAM_INT);
    $req->execute();

    if($req->rowCount() == 0)// pas de produit présent dans la base de données
    {
        header("location:boutique.php"); // Redirection 
        exit(); // Stop le script
    }

    $prod = $req->fetch(PDO::FETCH_ASSOC);
    #debug($prod)
?>
<div class="col-md-8 offset-md-2 mt-4 mb-4">   
    <div class="card h-100">
        <div class="card-footer">
            <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>   
            <h2 class="text-warning display-4 text-center">Fiche Produit <?= $prod['titre']?> </h2>
        </div>
            <a href="fiche_produit.php?id_produit=<?= $prod['id_produit'] ?>">
                <img class="card-img-top" src="<?= $prod['photo'] ?>" alt="">
            </a>
        <div class="card-body text-center">
            <h4 class="card-title"> <?= ucfirst($prod['titre']) ?></h4>
            <h5><?= ucfirst($prod['prix']) ?> €</h5>
            <p class="card-text"><?= ucfirst($prod['description']) ?></p>
            <p class="card-text">Taille <?= ucfirst($prod['taille']) ?></p>
            <p class="card-text">Modèle <?= ucfirst($prod['public']) ?></p>
        </div>
        <div class="card-footer">
            <?php if($prod['stock'] > 0): ?>
                
            <form method="post" action="panier.php">
                <div class="form-group">
                    <input type="hidden" id="id_produit" name="id_produit" value="<?= $prod['id_produit'] ?>">
                        <label for="quantite">Quantité</label>
                        <select class="form-control" name="quantite" id="quantite">                           
                            <?php
                            for($i = 1; $i <= $prod['stock'] && $i <= 5; $i++ )
                            {
                                echo "<option>$i</option>";
                            }
                            
                            ?>
                        </select>
                </div>
                <button type="submit" class="btn btn-warning mb-2 btn-block" name="ajout_panier">Ajouter au Panier</button>
                
            </form>
            <div class="alert alert-warning text-center" role="alert"> 
                Retour vers <a href="boutique.php?categorie=<?= $prod['categorie'] ?>" class"alert-link text-center"> <?= $prod['categorie'] ?></a> de la Boutique
            </div>



            <?php else: ?>
                <p class="text-danger text-center">Ce produit est épuisé</p>

            <?php endif; ?>
        </div>
    </div>
</div>



<?php require "./inc/footer.php";
endif;
?>