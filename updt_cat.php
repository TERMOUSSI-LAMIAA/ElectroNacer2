<?php
session_start();
include 'db.php';

// Retrieve id_category from the URL
$id_category = isset($_GET['id']) ? $_GET['id'] : null;

// Fetch data for the selected row
try {
    $query = "SELECT * FROM categorie WHERE idCat = :id_category";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':id_category', $id_category);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get form data
        $id_category = $_POST['id_category'];
        $nom_category = $_POST['nom_category'];
        $photoTmp = $_FILES['img_category']['tmp_name'];
        $photoData = file_get_contents($photoTmp);
        // Add other form fields

        // Update data in the database
        $query = "UPDATE categorie SET nomCat = :nom_category ,photoCat=:img_category WHERE idCat = :id_category";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id_category', $id_category);
        $statement->bindParam(':nom_category', $nom_category);
        $statement->bindParam(':img_category', $photoData, PDO::PARAM_LOB);
        // Bind other parameters
        $statement->execute();
        header("Location: categorie.php");
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
    <form method="POST" action="updt_cat.php" enctype="multipart/form-data"><!-- Add appropriate action and method -->
        <label>Id categorie:</label>
        <input type="text" id="id_category" name="id_category" value="<?= $row['idCat'] ?>" readonly><br>
        <label>Nom categorie:</label>
        <input type="text" id="nom_category" name="nom_category" value="<?= $row['nomCat'] ?>"><br>
        <label>Category Photo:</label>
        <input type="file" id="img_category" name="img_category"><br>
        <!-- Add other form fields -->

        <input type="submit" value="Update">
    </form>
</body>

</html>
