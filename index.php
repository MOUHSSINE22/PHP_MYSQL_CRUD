<?php
include('ConnexionConfig.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produit CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>

    <div class="container">


        <div class="input-group rounded">
            <a href="Ajouter_Produit.php" class="btn btn-warning">Ajouter Nouveau Produit</a>

        </div>
        <h3>Liste Produits</h3>
        <div class="table-responsive">
            <table border="1" class="table table-light table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ref Produit</th>
                        <th>Nom Produit</th>
                        <th>Date Production</th>
                        <th>Date Expiration</th>
                        <th>Quantité Produit</th>
                        <th>Prix Produit</th>
                        <th>Image Produit</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $req_affichage = "SELECT * from produits";
                    $res = mysqli_query($CN, $req_affichage);
                    while ($produit = mysqli_fetch_assoc($res)) {
                        echo "<tr>";

                        echo "<td></td>";
                        echo "<td>" . $produit['ProduitRef'] . "</td>";
                        echo "<td>" . $produit['ProduitNom'] . "</td>";
                        echo "<td>" . $produit['ProdDateProduction'] . "</td>";
                        echo "<td>" . $produit['ProdDateExpiration'] . "</td>";
                        echo "<td>" . $produit['ProduitQuantite'] . "</td>";
                        echo "<td>" . $produit['ProduitPrix'] . "</td>";
                        echo "<td><img src='" . $produit['ProduitImage'] . "' width='200px'></td>";
                        echo "<td>";
                        echo '<a class="btn btn-danger" href="Editer.php?ProduitRef=' . $produit['ProduitRef'] . '"  >Editer</a>';
                        echo '<a class="btn btn-primary" href="Supprimer.php?ProduitRef=' . $produit['ProduitRef'] . '" >Supprimer</a>';
                        echo "</td>";

                        echo "</tr>";
                    }

                    ?>

                </tbody>
            </table>
        </div>

    </div>

</body>

</html>