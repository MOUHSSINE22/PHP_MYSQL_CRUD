<?php

include('ConnexionConfig.php');

$ref_prod = trim($_GET["ProduitRef"]);
$req = "SELECT ProduitImage from produits where ProduitRef='$ref_prod'";
$res = mysqli_query($CN, $req);

if (isset($res)) {
    unlink(mysqli_fetch_assoc($res)['ProduitImage']);
    $pdo = $CN;
    $sql_supp = "DELETE FROM  produits WHERE ProduitRef = ?";
    $pdo->prepare($sql_supp)->execute([trim($_GET["ProduitRef"])]);
    if (isset($pdo)) {
        echo "<script>alert('Suppression avec succes')</script>";
        header("Location:index.php");
    } else {
        echo "<script>alert('Echec De Suppression Veuillez Reessayer a Nouveau !')</script>";
    }
}
