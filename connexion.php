<?php 
require_once "./inc/init.php";

if(isset($_GET['action']) && $_GET['action'] == 'deconnexion')
{
    session_destroy();
}

if(userIsConnected())
{
    header("location:profil.php");
}

// debug($_POST);
if(isset($_POST['form_connexion']))
{
    $result = $bdd->prepare("SELECT * FROM membre WHERE pseudo = :pseudo OR email = :email");// selection de tous les membres dans la base de données
    $result->bindValue(':pseudo', $_POST['pseudo_email'], PDO::PARAM_STR); // association des marqueurs
    $result->bindValue(':email', $_POST['pseudo_email'], PDO::PARAM_STR);
    $result->execute();

    if($result->rowCount() > 0) // Si résultat > 0 le pseudo ou l'email est présent en base de données
    {
        $membre = $result->fetch(PDO::FETCH_ASSOC); // On récupère avec fetch() les données du user
        #debug($membre);
        if($membre['mdp'] == $_POST['mdp'])// On vérifie les mots de passe bdd vs login
        #if(password_verify($_POST['mdp'], $membre['mdp']))


        {
            foreach($membre as $indices => $valeur)// On passe en revu les données du user
            {
                if($indices != 'mdp')// On exclu le mot de passe de la session 
                {
                    $_SESSION['membre'][$indices] = $valeur;// On crée un fichier temp de SESSION : tableau membre, donnes du user
                }
            }   
            #debug($_SESSION);
            header("location:profil.php"); //redirection du user vers sa session
        }
        else // Le user a entré un mauvais mdp
        {
            $content .= '<div class ="alert alert-danger text-center" > Identifiants erronné! <br><a href="inscription.php" class="alert-link">Inscrivez vous</a> afin de vous connecter ou vérifiez vos identifiants</div>';

        }
    }
    else // Le user a entré un mauvais identifiant
    {
        $content .= '<div class ="alert alert-danger text-center" > Identifiants erronné! <br><a href="inscription.php" class="alert-link">Inscrivez vous</a> afin de vous connecter ou vérifiez vos identifiants</div>';

    }
}


require_once "./inc/header.php";

?>
<div class="col-md-8 offset-md-2 mt-2">
    <form method="post" action=""> 
        <h2 class=" display-3 text-warning text-center">Se connecter</h2>
        <?= $content ?>
        <div class="form-group mt-5">
            <label for="societe" class="">Pseudo ou Email</label>       
            <input name="pseudo_email" 
            type="text" class="form-control col-form-label-sm" id="pseudo_email"  placeholder="Entrez votre pseudo ou Email...">
        </div>
        <div class="form-group mt-3">
            <label for="mdp" class="">Mot de Passe</label>
            <input name="mdp"
            type="password" class="form-control col-form-label-sm" id="mdp" placeholder="Entrez votre mot de passe...">
        </div>
        <button type="submit" class="btn btn-warning btn-block mb-2 mt-5" name="form_connexion" value="valid-form_connexion">Connexion</button>
    </form>   
</div>
<?php require "./inc/footer.php";
?>