<?php 
require_once "./inc/init.php";
require "./inc/header.php";
?>

<div class="container">

  <div class="row">

    <div class="col-lg-3">

      <h1 class="my-2 display-4 text-center text-warning">Greg's Tee Shop</h1>
      <div class="list-group">
        <?php  
        $req = $bdd->query("SELECT DISTINCT categorie FROM produit");
        while($varcategory = $req->fetch(PDO::FETCH_ASSOC)):
        ?>
        <!-- <?= debug($varcategory) ?> -->
        <a href="?categorie=<?= $varcategory['categorie'] ?>" class="list-group-item text-warning">
          <?= $varcategory['categorie'] ?></a>
        <?php endwhile; ?>
      </div>

    </div>
    <!-- /.col-lg-3 -->

    <div class="col-lg-9">

      <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
        <ol class="carousel-indicators">
          <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
          <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner" role="listbox">
          <div class="carousel-item active">
            <img class="d-block img-fluid" src="./photo/black.jpg" alt="First slide">
          </div>
          <div class="carousel-item">
            <img class="d-block img-fluid" src="./photo/red.jpg" alt="Second slide">
          </div>
          <div class="carousel-item">
            <img class="d-block img-fluid" src="./photo/whiteVneck.jpg" alt="Third slide">
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Précédent</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Suivant</span>
        </a>
      </div>

      <div class="row">
        <?php
      if(isset($_GET['categorie'])):
        $carddata = $bdd->prepare("SELECT * FROM produit WHERE categorie = :categorie");
        $carddata->bindValue(':categorie', $_GET['categorie'], PDO::PARAM_STR);
        $carddata->execute();

        while($prod = $carddata->fetch(PDO::FETCH_ASSOC)):
        #debug($prod); 
      ?>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card h-100">
            <a href="fiche_produit.php?id_produit=<?= $prod['id_produit'] ?>">
              <img class="card-img-top" src="<?= $prod['photo'] ?>" alt="">
            </a>
            <div class="card-body">
              <h4 class="card-title">
                <a class="text-warning" href="fiche_produit.php?id_produit=<?= $prod['id_produit'] ?>">
                  <?= ucfirst($prod['titre']) ?></a>
              </h4>
              <h5>
                <?= ucfirst($prod['prix']) ?> €</h5>
              <p class="card-text">
                <?= ucfirst($prod['description']) ?>
              </p>
              <p class="card-text">Taille
                <?= ucfirst($prod['taille']) ?>
              </p>


            </div>
            <div class="card-footer">
              <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
            </div>
          </div>
        </div>
        <?php
        endwhile;

      else: 
        $carddata = $bdd->prepare("SELECT * FROM produit");
        $carddata->execute();  
        while($prod = $carddata->fetch(PDO::FETCH_ASSOC)):
      ?>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card h-100">
            <a href="fiche_produit.php?id_produit=<?= $prod['id_produit'] ?>">
              <img class="card-img-top" src="<?= $prod['photo'] ?>" alt="">
            </a>
            <div class="card-body">
              <h4 class="card-title">
                <a class="text-warning" href="fiche_produit.php?id_produit=<?= $prod['id_produit'] ?>">
                  <?= ucfirst($prod['titre']) ?></a>
              </h4>
              <h5>
                <?= ucfirst($prod['prix']) ?> €</h5>
              <p class="card-text">
                <?= ucfirst($prod['description']) ?>
              </p>
              <p class="card-text">Taille
                <?= ucfirst($prod['taille']) ?>
              </p>


            </div>
            <div class="card-footer">
              <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
            </div>
          </div>
        </div>

        <?php
        endwhile;
      endif;
      ?>

      </div>
      <!-- /.row -->

    </div>
    <!-- /.col-lg-9 -->

  </div>
  <!-- /.row -->

</div>
<!-- /.container -->



<?php require "./inc/footer.php";

?>