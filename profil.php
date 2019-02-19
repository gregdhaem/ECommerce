<?php 
require_once "./inc/init.php";
require_once "./inc/header.php";

if(!userIsConnected())
{
    header("location:connexion.php");
}


$content .= '<div class ="alert alert-info text-center mt-2 col-md-8 offset-md-2 alert alert-info mt-2 mb-2">' . '<strong>' . $_SESSION['membre']['pseudo'] . '</strong> bienvenu chez Greg\'s Tee Shop <br>Quel temps fait-il à ' . $_SESSION['membre']['ville'] . ' ?' . '</div>';

#debug($_SESSION);

?>
<!-- <?= $_SESSION['membre']['pseudo']?> 
<?= $content ?>-->
<div class="container">
    
        <h2 class="text-warning text-center">Bienvenu sur votre page profil <h2>

            <div class="card ">
                <div class="card-header">
                    <h2 class="text-dark text-center"><?= $_SESSION['membre']['pseudo']?> </h2>
                </div>
                <div class="card-body">
                     
                    <div class="align-center">
                        <img alt="User Pic" src="./photo/Photo.jpg" id="profile-image1" class="rounded-circle img-fluid">

                        <!-- <input id="profile-image-upload" class="hidden" type="file"> -->
                        <!-- <div style="color:#1f1f1f;" class="font-weight-normal text-dark" >Cliquez ici pour changer votre avatar</div> -->
                    </div>
                    <br>        
                    <div class="font-weight-normal">
                        <h2 style="color:#b1b1b1;"><?= $_SESSION['membre']['prenom']?> <?= $_SESSION['membre']['nom']?> </h2>
                        </span>
                        <span>
                            <p class="text-dark">Shopper</p>
                        </span>
                    </div>
                    
                    <hr style="margin:5px 0 5px 0;">

                    <div class="title font-weight-normal text-dark">Nom et Prénom:</div>
                    <div class="text-dark"><?= $_SESSION['membre']['nom'] . ' ' . $_SESSION['membre']['prenom'] ?></div>

                    <div class="title font-weight-normal text-dark">Email :</div>
                    <div class="text-dark"> <?= $_SESSION['membre']['email']?></div>

                    <div class="title font-weight-normal text-dark">Adresse :</div>
                    <div class="text-dark"><?= $_SESSION['membre']['adresse']?></div>

                    <div class="title font-weight-normal text-dark">CP - Ville :</div>
                    <div class="text-dark"><?= $_SESSION['membre']['code_postal'] . ' - ' . $_SESSION['membre']['ville'] ?></div>

                    <div class="text-center"><a href="#" class="alert-link text-info">Modifier votre compte</a></div>
                </div>
            </div>

        <script>
            $(function() 
            {
                $('#profile-image1').on('click', function() 
                {
                    $('#profile-image-upload').click();
                });
            });
        </script>


    
</div>
<?php require "./inc/footer.php";
?>