<?php
require_once '../inc/init.php';

if(!adminIsConnected())
{
    header("location:" . URL . "connexion.php");
}
// Suppression produit
if(isset($_GET['action']) && $_GET['action'] == 'suppression')
{
    
    $ref = $bdd->prepare("SELECT reference FROM produit WHERE id_produit = :id_produit");
    $ref->bindValue(':id_produit', $_GET['id_produit'], PDO::PARAM_INT);
    $ref->execute();
    $reference = $ref->fetch(PDO::FETCH_ASSOC);

    #debug($_GET);
    $result = $bdd->prepare("DELETE FROM produit WHERE id_produit = :id_produit");
    $result->bindValue(':id_produit', $_GET['id_produit'], PDO::PARAM_INT);
    $result->execute();

    $_GET['action'] = 'affichage';

    $content .= '<div class ="alert alert-success text-center" > Référence <strong>' . $reference['reference'] . '</strong> supprimée de la Base de données ! </div>';

}

if(isset($_GET['action']) && $_GET['action'] == 'suppression')
{

}


// Enregistrement produit 
if(isset($_POST['form_produit']))
{
    $photo_bdd = '';
    if(isset($_GET['action']) && $_GET['action'] == 'modification')
    {
        $photo_bdd = $_POST['photo_actuelle'];
    }
    if(!empty($_FILES['photo']['name']))
    {
        $nom_photo = $_POST['reference'] . '-' . $_FILES['photo']['name']; // 
        #echo $nom_photo . '<br>';

        $photo_bdd = URL . "photo/$nom_photo"; // URL de la photo pour la bdd
        #echo $photo_bdd . '<br>';
        
        $photo_dossier = RACINE_SITE . "photo/$nom_photo"; // Chemin physique de la photo
        #echo $photo_dossier . '<br>';

        copy($_FILES['photo']['tmp_name'], $photo_dossier); // Copy de la photo choisie

    }
    if(isset($_GET['action']) && $_GET['action'] == 'ajout')
    {
        $erreur = '';

        $result = $bdd->prepare("SELECT * FROM produit WHERE reference = :reference");
        $result->bindValue(':reference' , $_POST['reference'], PDO::PARAM_STR);
        $result->execute();

        if($result->rowCount() > 0)
        {
            $erreur.= '<div class ="alert alert-danger text-center" > ATTENTION : Référence déjà utilisée base de données ! </div>';

        }
        if(empty($erreur))
        {
            $insert = $bdd->prepare("INSERT INTO produit (reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES (:reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo, :prix, :stock)");
            $insert->bindValue(':reference', $_POST['reference'], PDO::PARAM_STR);
            $insert->bindValue(':categorie', $_POST['categorie'], PDO::PARAM_STR);
            $insert->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
            $insert->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
            $insert->bindValue(':couleur', $_POST['couleur'], PDO::PARAM_STR);
            $insert->bindValue(':taille', $_POST['taille'], PDO::PARAM_STR);
            $insert->bindValue(':public', $_POST['public'], PDO::PARAM_STR);
            $insert->bindValue(':photo', $photo_bdd, PDO::PARAM_STR);
            $insert->bindValue(':prix', $_POST['prix'], PDO::PARAM_INT);
            $insert->bindValue(':stock', $_POST['stock'], PDO::PARAM_INT);
            $insert->execute();
            $_GET['action'] = 'affichage';
            $erreur.= '<div class ="alert alert-success text-center" > NOTE : Nouvelle référence <strong>' . $_POST['reference'] .  ' </strong> entrée en Base de données ! </div>';

        }

    }

    if(isset($_GET['action']) && $_GET['action'] == 'modification')
    {
        $erreur = '';
        $insert = $bdd->prepare("UPDATE produit SET categorie = :categorie, titre = :titre, description = :description, couleur = :couleur, taille = :taille, public = :public, photo = :photo, prix = :prix, stock = :stock WHERE id_produit = $_POST[id_produit]");
        $insert->bindValue(':categorie', $_POST['categorie'], PDO::PARAM_STR);
        $insert->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
        $insert->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
        $insert->bindValue(':couleur', $_POST['couleur'], PDO::PARAM_STR);
        $insert->bindValue(':taille', $_POST['taille'], PDO::PARAM_STR);
        $insert->bindValue(':public', $_POST['public'], PDO::PARAM_STR);
        $insert->bindValue(':photo', $photo_bdd, PDO::PARAM_STR);
        $insert->bindValue(':prix', $_POST['prix'], PDO::PARAM_INT);
        $insert->bindValue(':stock', $_POST['stock'], PDO::PARAM_INT);
        $insert->execute();
        $_GET['action'] = 'affichage';
        $erreur.= '<div class ="alert alert-success text-center" > NOTE : Votre référence <strong>' . $_POST['titre'] .  ' </strong> a été mise à jour en Base de données ! </div>';

    }
    $content .= $erreur;
    
}
// Affichage produits sous forme de tableau html plus nombre de produits dans la boutique et lien de modif et suppression de produit

if(isset($_GET['action']) && $_GET['action'] == 'affichage')
{
    $display = $bdd->query("SELECT * FROM produit");
  
    $content .= '<div class=" mt-2 ">
                    <h2 class="text-white text-center">Affichage Produits</h2>
                    <p>Note : Nombre de produits(s) dans la boutique : <strong>' . $display->rowCount() . '</strong>
                </div>';

    $content .= '<table class="table text-center" border=3><tr>';
    
    for($i = 0; $i < $display->ColumnCount(); $i++)
    {
        $colonne = $display->getColumnMeta($i);
        #debug($colonne);
        if($colonne['name'] != 'id_produit')
        {
            $content .= "<th>$colonne[name]</th>";
        }
    }
    $content .= '<th>modifier</th>';   
    $content .= '<th>supprimer</th>'; 
    $content .= '</tr>';
    while($produit = $display->fetch(PDO::FETCH_ASSOC))
    {
        $content.= '<tr>';
        //debug($produit);
        foreach($produit as $key => $value)
        {
            if($key != 'id_produit')
            {
                if($key == 'photo')
                {
                    $content .= "<td><img class='img-thumbnail' src=' $value' alt='$key'></td>";
                }           
                else
                {
                    if($key == 'prix')
                    {
                        $content .= '<td>' . $value . '€</td>';
                    }
                    else
                    {
                        $content .= "<td>$value</td>";
                    }
                }
            }
        }
        $content .= '<td><a class="text-warning" href="?action=modification&id_produit=' . $produit['id_produit'] . '"><i class="fas fa-2x fa-edit"></i></a></td>';
        $content .= '<td><a class="text-warning" href="?action=suppression&id_produit=' . $produit['id_produit'] . '" onClick="return(confirm(\'Êtes vous sur de vouloir supprimer cette référence ?\'));"><i class="fas fa-2x fa-trash-alt"></i></a></td>';
        $content .= '</tr>';
    }
    $content .= '</table>';
}


require_once '../inc/header.php';
#debug($_POST);
#debug($_FILES);
?>
<div class="list-group col-md-8 offset-md-2 mt-2">
    <p class="list-group-item list-group-item-action bg-warning font-weight-bold">BACK OFFICE</p>
    <a href="?action=affichage" class="list-group-item list-group-item-action">Affichage des références</a>
    <a href="?action=ajout" class="list-group-item list-group-item-action">Ajout d'une référence</a>
</div>
<hr>
<?= $content ?>

<?php if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')): 

    if(isset($_GET['id_produit']))
    {
        $result = $bdd->prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
        $result->bindValue(':id_produit', $_GET['id_produit'], PDO::PARAM_INT);
        $result->execute();

        $modify_ref = $result->fetch(PDO::FETCH_ASSOC);
        #debug($modify_ref);
    }
            
    $idp = (isset($modify_ref['id_produit'])) ? $modify_ref['id_produit'] : '';
    $ref = (isset($modify_ref['reference'])) ? $modify_ref['reference'] : '';
    $cat = (isset($modify_ref['categorie'])) ? $modify_ref['categorie'] : '';
    $tit = (isset($modify_ref['titre'])) ? $modify_ref['titre'] : '';
    $des = (isset($modify_ref['description'])) ? $modify_ref['description'] : '';
    $col = (isset($modify_ref['couleur'])) ? $modify_ref['couleur'] : '';
    $tai = (isset($modify_ref['taille'])) ? $modify_ref['taille'] : '';
    $pub = (isset($modify_ref['public'])) ? $modify_ref['public'] : '';
    $pho = (isset($modify_ref['photo'])) ? $modify_ref['photo'] : '';
    $pri = (isset($modify_ref['prix'])) ? $modify_ref['prix'] : '';
    $sto = (isset($modify_ref['stock'])) ? $modify_ref['stock'] : '';
    $desabled = (isset($_GET['action']) && $_GET['action'] == 'modification') ? 'disabled' : '';

?>

<div class="col-md-8 offset-md-2 mt-2">
    <form method="post" action="" enctype="multipart/form-data"> 
        <input type='hidden' id='id_produit' name='id_produit' value="<?= $idp ?>">
        <h2 class="text-center text-dark"><?= ucfirst($_GET['action'])?> d'une référence</h2>
        
        <div class="form-group row">           
            <label for="reference" class="col-md-4 col-form-label">Réference</label>
                <div class="col-md-8">    
                    <input name="reference" value="<?= $ref ?>" type="text" id="" class="form-control col-form-label-sm" id="reference" placeholder="Entrez la référence" pattern="[A-Za-z0-9._-]{2-20}" title="Caractères acceptés : A-Z a-z 0-9 . - _" <?= $desabled ?>>
                </div>
        </div>
        <div class="form-group row">
            <label for="categorie" class="col-md-4 col-form-label">Catégorie</label>
                <div class="col-md-8">
                    <input name="categorie" value="<?= $cat ?>" type="text" class="form-control col-form-label-sm" id="categorie" placeholder="Entrez la catégorie...">
                </div>
        </div>
        <div class="form-group row">
            <label for="titre" class="col-md-4 col-form-label">Titre</label>
                <div class="col-md-8">
                    <input name="titre" value="<?= $tit ?>" type="text" class="form-control col-form-label-sm" id="titre" placeholder="Entrez le titre...">
                </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-md-4 col-form-label">Description</label>
                <div class="col-md-8">
                    <textarea class="form-control" id="message" name="description" rows="3" placeholder="Entrez la description..."><?= $des ?></textarea>                    
            </div>
        </div>
        <div class="form-group row">
            <label for="couleur" class="col-md-4 col-form-label">Couleur</label>
                <div class="col-md-8">
                    <input name="couleur" value="<?= $col ?>" type="text" class="form-control col-form-label-sm" id="couleur" placeholder="Entrez la couleur...">
            </div>
        </div> 
        <div class="form-group row">
            <label for="taille" class="col-md-4 col-form-label">Taille</label>            
                <div class="col-md-8">
                    <select class="form-control col-form-label-sm" id="exampleFormControlSelect1" name="taille">
                        <option value="xs" <?php if($tai == 'xs') echo "selected" ?>>Extra Small</option>
                        <option value="s"  <?php if($tai  == 's') echo "selected" ?>>Small</option>
                        <option value="m"  <?php if($tai == 'm') echo "selected" ?>>Medium</option>
                        <option value="l"  <?php if($tai == 'l') echo "selected" ?>>Large</option>
                        <option value="xl" <?php if($tai == 'xl') echo "selected" ?>>Extra Large</option>
                        <option value="xxl" <?php if($tai == 'xxl') echo "selected" ?>>Double Extra Large</option>
                        <option value="xxl" <?php if($tai == 'xxl') echo "selected" ?>>Triple Extra Large</option>
                    </select>
                </div> 
        </div>  
        <div class="form-group row">       
            <label for="public" class="col-md-4 col-form-label">Public</label>
                <div class="col-md-8">
                    <select class="form-control col-form-label-sm" id="exampleFormControlSelect1" name="public">
                        <option value="homme" <?php if($pub == 'homme') echo "selected" ?>>Homme</option>
                        <option value="femme" <?php if($pub == 'femme') echo "selected" ?>>Femme</option>
                        <option value="mixte" <?php if($pub == 'mixte') echo "selected" ?>>Mixte</option>
                    </select>
                </div>
        </div>           
        <div class="form-group row">
            <label for="photo" class="col-md-4 col-form-label">Photographie</label>
                <div class="col-md-8">
                    <input name="photo" type="file" class="form-control col-form-label-sm" id="photo" placeholder="Entrez l'url de la photo...">
                    <input type="hidden" name="photo_actuelle" value="<?= $pho ?>">
                </div>
        </div> 
<?php if(!empty($pho)): ?>
        <div class="form-group row">
            <label for="photo" class="col-md-4 col-form-label text-info font-italic">Option : Vous pouvez choisir une nouvelle photo</label>
                <div class="col-md-8">  
                    <img src="<?= $pho ?>" width="100" alt="Photo produits">
                </div>
        </div>    
<?php endif; ?>
        <div class="form-group row">
            <label for="prix" class="col-md-4 col-form-label">Prix</label>
                <div class="col-md-8">
                    <input name="prix" value="<?= $pri ?>" type="number" class="form-control col-form-label-sm" id="prix" placeholder="Entrez le Prix...">
                </div>
        </div> 
        <div class="form-group row">
            <label for="stock" class="col-md-4 col-form-label">Stock</label>
                <div class="col-md-8">
                    <input name="stock" value="<?= $sto ?>" type="number" class="form-control col-form-label-sm" id="stock" placeholder="Entrez la quantité du stock...">
                </div>
        </div> 
        <button type="submit" class="btn btn-warning btn-block mb-2" name="form_produit" value="valid-form_produit"><?= ucfirst($_GET['action'])?> d'une référence</button>
    </form>   
</div>

<?php 
endif;

require_once '../inc/footer.php';
?>