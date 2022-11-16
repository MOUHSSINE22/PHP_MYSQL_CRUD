<?php
include('ConnexionConfig.php');

$ref_prod = trim($_GET["ProduitRef"]);
$req = "SELECT * from produits where ProduitRef='$ref_prod'";
$res = mysqli_query($CN, $req);
if (isset($res)) {
    $array_data = mysqli_fetch_assoc($res);
}

$nom_err = "";
$dateprod_err = "";
$dateexp_err = "";
$qte_err = "";
$prix_err = "";
$image_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['BtnModifier'])) {

        $ProduitNom = $_POST['ProduitNom'];
        $ProdDateProduction = $_POST['ProdDateProduction'];
        $ProdDateExpiration = $_POST['ProdDateExpiration'];
        $ProduitQuantite = $_POST['ProduitQuantite'];
        $ProduitPrix = $_POST['ProduitPrix'];
        $ProduitImage = $_FILES['ProduitImage']['name'];
        $tmp_dir = $_FILES['ProduitImage']['tmp_name'];
        $taille = $_FILES['ProduitImage']['size'];


        if (!$ProduitNom) {
            $GLOBALS["nom_err"] = "Veuillez Saisir La Nom Du Produit";
        } elseif (!$ProdDateProduction) {
            $GLOBALS["dateprod_err"] = "Veuillez Saisir La Date Production Produit";
        } elseif (!$ProdDateExpiration) {
            $GLOBALS["dateexp_err"] = "Veuillez Saisir La Date Expiration Produit";
        } elseif (!$ProduitQuantite) {
            $GLOBALS["qte_err"] = "Veuillez Saisir Quantité Produit";
        } elseif (!$ProduitPrix) {
            $GLOBALS["prix_err"] = "Veuillez Saisir Prix Produit";
        } else {


            if (!$ProduitImage) {
                $pdo = $CN;
                $sql_update = "UPDATE produits SET ProduitNom = ? , ProdDateProduction = ?, ProdDateExpiration = ?, ProduitQuantite = ?, ProduitPrix = ?, ProduitImage= ? WHERE ProduitRef=?";
                $pdo->prepare($sql_update)->execute([$ProduitNom, $ProdDateProduction, $ProdDateExpiration, $ProduitQuantite, $ProduitPrix, $array_data['ProduitImage'], $array_data['ProduitRef']]);
                if (isset($pdo)) {
                    echo "<script>alert('Modification avec succes')</script>";
                    header("Location:index.php");
                } else {
                    echo "<script>alert('Echec De Modification Produit Veuillez Reessayer a Nouveau !')</script>";
                }
            } else {
                $path = 'images/';
                $extension = strtolower(pathinfo($ProduitImage, PATHINFO_EXTENSION));
                $extensions = array('jpg', 'png');
                if (in_array($extension, $extensions) && $taille < 1000000) {
                    $GLOBALS["image_err"] = "";
                    move_uploaded_file($tmp_dir, $path . $ProduitImage);

                    $pdo = $CN;
                    $sql_update = "UPDATE produits SET ProduitNom = ? , ProdDateProduction = ?, ProdDateExpiration = ?, ProduitQuantite = ?, ProduitPrix = ?, ProduitImage= ? WHERE ProduitRef=?";
                    $pdo->prepare($sql_update)->execute([$ProduitNom, $ProdDateProduction, $ProdDateExpiration, $ProduitQuantite, $ProduitPrix, $path . $ProduitImage, $array_data['ProduitRef']]);
                    unlink($array_data['ProduitImage']);
                    if (isset($pdo)) {
                        echo "<script>alert('Modification avec succes')</script>";
                        header("Location:index.php");
                    } else {
                        echo "<script>alert('Echec De Modification Produit Veuillez Reessayer a Nouveau !')</script>";
                    }
                } else {
                    if (in_array($extension, $extensions)) {
                        $GLOBALS["image_err"] = "Format Image Non Valide , Veuillez Selectionner Une Image  JPG ou PNG ";
                    } else if ($taille < 1000000) {
                        $GLOBALS["image_err"] = "Veuillez Selectionner Une Image Qui Depasse Pas 1MB";
                    }
                }
            }
        }
    }
}

?>

<html>

<head>
    <title>Modifier Produit</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>


    <div class="container">
        <form enctype="multipart/form-data" method="POST">
            <div class="mb-3 mt-3">
                <label for="ProduitNom" class="form-label">Nom Produit:</label>
                <input type="text" value="<?php echo $array_data['ProduitNom'] ?>" class="form-control" placeholder="Veuillez Saisir Le Nom Du Produit " name="ProduitNom">
                <span style="color: red;"><?php echo $GLOBALS["nom_err"]; ?></span>
            </div>
            <div class="mb-3 mt-3">
                <label for="ProdDateProduction" class="form-label">Date Production:</label>
                <input type="date" value="<?php echo $array_data['ProdDateProduction']; ?>" class="form-control" title="Veuillez Saisir La Date De Production" name="ProdDateProduction">
                <span style="color: red;"><?php echo $GLOBALS["dateprod_err"] ?></span>
            </div>
            <div class="mb-3 mt-3">
                <label for="ProdDateExpiration" class="form-label">Date Expiration:</label>
                <input type="date" value="<?php echo $array_data['ProdDateExpiration']; ?>" class="form-control" title="Veuillez Saisir La Date D'expiration'" name="ProdDateExpiration">
                <span style="color: red;"><?php echo $GLOBALS["dateexp_err"] ?></span>
            </div>
            <div class="mb-3 mt-3">
                <label for="ProduitQuantite" class="form-label">Quantité Produit:</label>
                <input type="number" value="<?php echo $array_data['ProduitQuantite']; ?>" class="form-control" placeholder="Veuillez Saisir La Quantité Du Produit" name="ProduitQuantite">
                <span style="color: red;"><?php echo $GLOBALS["qte_err"] ?></span>
            </div>
            <div class="mb-3 mt-3">
                <label for="ProduitPrix" class="form-label">Prix Produit:</label>
                <input type="text" value="<?php echo $array_data['ProduitPrix']; ?>" class="form-control" placeholder="Veuillez Saisir Le Prix Du Produit" name="ProduitPrix">
                <span style="color: red;"><?php echo $GLOBALS["prix_err"] ?></span>
            </div>
            <div class="mb-3 mt-3">
                <label for="ProduitImage" class="form-label">Image Produit:</label>
                <input type="file" class="form-control" title="Veuillez Telecharger L'image Du Produit" name="ProduitImage">
                <span style="color: red;"><?php echo $GLOBALS["image_err"] ?></span>
            </div>

            <div class="mb-3 mt-3">
                <img src="<?php echo $array_data['ProduitImage']; ?>" style="width: 200px ; height:200px">
            </div>

            <button type="submit" name="BtnModifier" class="btn btn-primary">Modifier Produit</button>

        </form>
    </div>



</body>

</html>