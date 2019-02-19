<?php 
require "./inc/init.php";
// Vérification du pseudo
if (isset($_POST['form_inscription'])) 
{
    $erreur = '';
    $verif_pseudo = $bdd->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
    $verif_pseudo->bindvalue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $verif_pseudo->execute();
    if($verif_pseudo->rowCount() > 0)
    {
        $erreur .= '<div class ="alert alert-danger text-center" >Pseudo existant ! Merci d\'en chosir un autre</div>';
    }
    else
    {
        if((strlen($_POST['pseudo']) < 2 || strlen($_POST['pseudo']) > 20 ) || !preg_match('#^[A-Za-z0-9._-]+$#', $_POST['pseudo']))
        {
            $erreur .= '<div class ="alert alert-danger text-center" >Pseudo doit être entre 2 et 20 caractères autorisés : <br> [A-Za-z0-9._-]</div>';
        }
    }
    

    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    {
        $erreur .= '<div class ="alert alert-danger text-center" >Email non valide, vérifiez vos identifiants </div>';
    }
    else
    {
        $verif_email = $bdd->prepare("SELECT * FROM membre WHERE email = :email");
        $verif_email->bindvalue(':email', $_POST['email'], PDO::PARAM_STR);
        $verif_email->execute();
        if($verif_email->rowCount() > 0)
        {
            $erreur .= '<div class ="alert alert-danger text-center" >Email existant ! <a href="connexion.php" class="alert-link">Connectez vous</a> ou vérifiez vos identifiants </div>';
        }
        
    }
    
    if($_POST['mdp'] != $_POST['mdp_confirm'])
    {
        $erreur .= '<div class ="alert alert-danger text-center" >Les deux mots de passe saisis ne sont pas identiques !</div>';
    }


    $content .= $erreur;
    if(empty($erreur))
    {
    #debug($_POST);

    foreach($_POST as $indices => $valeur)
    {
        $_POST[$indices] = strip_tags(trim($valeur)); // SUPRIME LES BALISES HTML MALVEILLANTES ET ENLEVE LES ESPACES ET AUTRES CARACTERES EN DEBUT ET FIN DE CHAINE
    }

    $req = $bdd->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse) VALUES
    (:pseudo, :mdp, :nom, :prenom, :email, :civilite, :ville, :code_postal, :adresse)");
    // $req->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    // $req->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
    // $req->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
    // $req->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
    // $req->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    // $req->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
    // $req->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
    // $req->bindValue(':code_postal', $_POST['code_postal'], PDO::PARAM_INT);
    // $req->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
    // $req->execute();
    
    #$_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT); // ENCODAGE SU MOT DE PASSE

    $resultat = $bdd->query("SELECT * FROM membre");
    for($i = 0; $i < $resultat->columnCount(); $i++)
    {
        $colonne = $resultat->getColumnMeta($i);
        if($colonne['name'] != 'id_membre' && $colonne['name'] != 'statut')
        {
            if($colonne['native_type'] == 'LONG')
            {
                $req->bindValue(":$colonne[name]", $_POST["$colonne[name]"], PDO::PARAM_INT);
            }
            else
            {
                $req->bindValue(":$colonne[name]", $_POST["$colonne[name]"], PDO::PARAM_STR);
            }

        }
    }
    $req->execute();

    $content .= '<div class ="alert alert-info text-center" >Bonjour <strong>' . $_POST['pseudo'] . '</strong> votre inscription est terminé. Vous pouvez vous <a href="connexion.php" class="alert-link"> connecter sur Greg\'s Tee Shop</a></div>';
    }   
}
require "./inc/header.php";
?>

<div class="col-md-8 offset-md-2 mt-2">
    <form method="post" action=""> 
        <h2 class="display-3 text-warning text-center">S'inscrire</h2>
        <?= $content ?>
        <div class="form-group row mt-4">
            <label for="pseudo" class="col-md-4 col-form-label">Pseudo</label>
                <div class="col-md-8">
                    <input name="pseudo" type="text" class="form-control form-control-sm" id="pseudo" placeholder="Pseudo..." pattern="[A-Za-z0-9._-]{2-20}" title="Caractères acceptés : A-Z a-z 0-9 . - _">
                </div>
        </div>
        <div class="form-group row  mt-4">
            <label for="mdp" class="col-md-4 col-form-label">Mot de Passe</label>
                <div class="col-md-8">
                    <input name="mdp" type="password" class="form-control form-control-sm" id="mdp" placeholder="Mot de passe...">
                </div>        
        </div>
        <div class="form-group row  mt-4">         
            <label for="mdp_confirm" class="col-md-4 col-form-label">Confirmer mot de Passe</label>
                <div class="col-md-8">
                    <input name="mdp_confirm" type="password" class="form-control form-control-sm" id="mdp_confirm" placeholder="Confirmer mot de passe...">
                </div>        
        </div>
        <div class="form-group row  mt-4">
            <label for="nom" class="col-md-4 col-form-label">Nom de Famille</label>
                <div class="col-md-8">
                    <input name="nom" type="text" class="form-control form-control-sm" id="nom" placeholder="Nom de famille...">
                </div>        
        </div>
        <div class="form-group row mt-4">
            <label for="prenom" class="col-md-4 col-form-label">Prénom</label>
                <div class="col-md-8">
                    <input name="prenom" type="text" class="form-control form-control-sm" id="prenom" placeholder="Prénom...">
                </div>        
        </div>  
        <div class="form-group row mt-4">
            <label for="email" class="col-md-4 col-form-label"> Email</label>
                <div class="col-md-8">
                    <input name="email" type="email" class="form-control form-control-sm" id="email"  placeholder="Email...">
                    <small id="emailHelp" class="form-text text-muted ">Vos coordonnées resteront confidentielles</small>
                </div>        
        </div>
        <div class="form-group row mt-4">
            <label for="civilite" class="col-md-4 col-form-label">Civilité</label>
                <div class="col-md-8">
                    <select class="form-control form-control-sm" id="civilite" name="civilite">
                        <option value="f" selected>Madame</option>
                        <option value="h">Monsieur</option>
                    </select>
                </div>        
        </div>
        <div class="form-group row mt-4">
            <label for="adresse" class="col-md-4 col-form-label">Adresse</label>
                <div class="col-md-8">
                    <input name="adresse" type="text" class="form-control form-control-sm" id="adresse" placeholder="Adresse...">
                </div>        
        </div> 
        <div class="form-group row mt-4">
            <label for="ville" class="col-md-4 col-form-label">Ville</label>
                <div class="col-md-8">
                    <input name="ville" type="text" class="form-control form-control-sm" id="ville" placeholder="Ville...">
                </div>        
        </div> 
        <div class="form-group row mt-4">
            <label for="code_postal" class="col-md-4 col-form-label">Code Postal</label>
                <div class="col-md-8">
                    <input name="code_postal" type="number" size="5" class="form-control form-control-sm" id="code_postal" placeholder="Code Postal...">
                </div>        
        </div> 
        <button type="submit" class="btn btn-warning btn-block mb-5 mt-5 " name="form_inscription" value="valid-form_inscription">Inscription</button>
    </form>   
</div>



<?php require "./inc/footer.php";

?>