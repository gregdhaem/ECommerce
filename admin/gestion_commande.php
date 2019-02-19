<?php
require_once '../inc/init.php';

if(!adminIsConnected())
{
    header("location:" . URL . "connexion.php");
}

require_once '../inc/header.php';
?>

<?php
require_once '../inc/footer.php';
?>