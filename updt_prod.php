<?php
session_start();
include 'db.php';

$id_prod = isset($_GET['id']) ? $_GET['id'] : null;
try {
    $query = "SELECT * FROM produit WHERE ref_prod = :id_category";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_category', $id_prod);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

try {
    $query = "SELECT * FROM categorie where isHide=0";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $categories = $statement->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get form data
        $ref_prod = $_POST['ref_prod'];
        $photoTmp = $_FILES['img_prod']['tmp_name'];
        $photoData = file_get_contents($photoTmp);
        $etiqt = $_POST['etiqt'];
        $cd_barre = $_POST['cd_barre'];
        $pr_ach = $_POST['pr_ach'];
        $pr_fin = $_POST['pr_fin'];
        $offre_pr = $_POST['offre_pr'];
        $qte_min = $_POST['qte_min'];
        $qte_stck = $_POST['qte_stck'];
        $fk_idCat = $_POST['category'];
        // Add other form fields

        // Update data in the database
        $query = "UPDATE produit SET image = :img_prod, etiquette=:etiqt,code_barre=:cd_barre,pr_achat=:pr_ach,
        pr_final=:pr_fin,offre_pr=:offre_pr,qte_min=:qte_min,qte_stock=:qte_stck,fk_idCat=:fk_idCat WHERE ref_prod = :ref_prod";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':ref_prod', $ref_prod);
        $statement->bindParam(':img_prod', $photoData, PDO::PARAM_LOB);
        $statement->bindParam(':etiqt', $etiqt);
        $statement->bindParam(':cd_barre', $cd_barre);
        $statement->bindParam(':pr_ach', $pr_ach);
        $statement->bindParam(':pr_fin', $pr_fin);
        $statement->bindParam(':offre_pr', $offre_pr);
        $statement->bindParam(':qte_min', $qte_min);
        $statement->bindParam(':qte_stck', $qte_stck);
        $statement->bindParam(':fk_idCat', $fk_idCat);
        // Bind other parameters
        $statement->execute();
        header("Location: index.php");
        echo "Update successful";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Update Category</title>
    <!-- Add necessary meta tags, stylesheets, and scripts -->
</head>

<body>
    <h2>Update Category</h2>
    <form method="POST" action="" enctype="multipart/form-data">
        <label>reference produit:</label>
        <input type="text" id="ref_prod" name="ref_prod" value="<?= $row['ref_prod'] ?>" readonly><br>
        <label>Image produit:</label>
        <input type="file" id="img_prod" name="img_prod"><br>
        <label>Etiquette:</label>
        <input type="text" id="etiqt" name="etiqt" value="<?= $row['etiquette'] ?>"> <br>
        <label>Code barre:</label>
        <input type="text" id="cd_barre" name="cd_barre" value="<?= $row['code_barre'] ?>"><br>
        <label>Prix achat:</label>
        <input type="number" id="pr_ach" name="pr_ach" value="<?= $row['pr_achat'] ?>"><br>
        <label>Prix final:</label>
        <input type="number" id="pr_fin" name="pr_fin" value="<?= $row['pr_final'] ?>"><br>
        <label>Offre prix:</label>
        <input type="number" id="offre_pr" name="offre_pr" value="<?= $row['offre_pr'] ?>"><br>
        <label>Quantité min:</label>
        <input type="number" id="qte_min" name="qte_min" value="<?= $row['qte_min'] ?>"><br>
        <label>Quantité stock:</label>
        <input type="number" id="qte_stck" name="qte_stck" value="<?= $row['qte_stock'] ?>"><br>
        <label>Catégorie:</label>
        <select id="category" name="category">
            <?php
            foreach ($categories as $category) {
                echo "<option value='" . $category['idCat'] . "'>" . $category['nomCat'] . "</option>";
            }
            ?>
        </select><br>
        <input type="submit" value="Ajouter">
    </form>
</body>

</html>