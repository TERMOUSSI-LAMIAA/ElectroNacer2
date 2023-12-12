<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    try {
        // Get the category ID from the URL
        $id_category = $_GET['id'];

        // Update the isHide value to 1
        $query = "UPDATE categorie SET isHide = 1 WHERE idCat = :id_category";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id_category', $id_category);
        $statement->execute();

        // Redirect back to the same page or do something else
        header("Location: categorie.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

try {
    $query = "SELECT * FROM categorie where isHide=0";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <nav>
        <img src="assets/images/logo.png" alt="logo" height="60" width="300">
        <a href="logout.php">Déconnexion</a>
    </nav>
    <!-- form -->
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 text-center " style="margin-top: 20px;margin-bottom:10px;">
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Ajouter
                    catégorie</button>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Ajouter catégorie</h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data">
                            <label>Id categorie:</label>
                            <input type="text" id="id_category" name="id_category"><br>
                            <label>Nom categorie:</label>
                            <input type="text" id="nom_category" name="nom_category"> <br>
                            <label>Image categorie:</label>
                            <input type="file" id="img_category" name="img_category"><br>
                            <label>Description categorie:</label>
                            <input type="text" id="desc_category" name="desc_category"><br>
                            <input type="submit" value="Ajouter">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- sidebar -->
    <div class="sidebar">
        <a href="index.php">Accueil</a>
        <a href="categorie.php">Categories</a>
        <a href="users.php">Utilisateurs</a>
        <div class="user-div">
            <img src="assets/images/user.png" alt="user" height="40" width="40">
            <p>
                <?= $_SESSION['username'] ?>
            </p>
        </div>
    </div>

    <div class="content">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Categorie image</th>
                    <th>Nom categorie</th>
                    <th>Description</th>
                    <th>Edit/Hide</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td>
                            <img src="data:image/jpg;base64,<?= base64_encode($row['photoCat']) ?>" alt="categorie Image"
                                width="200" height="200">
                        </td>
                        <td>
                            <?= $row['nomCat'] ?>
                        </td>
                        <td>
                            <?= $row['descCat'] ?>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="updt_cat.php?id=<?= $row['idCat'] ?>" class="edit-button">
                                    <img src="assets/images/edit-svgrepo-com.svg" alt="Edit Icon" width="20" height="20">
                                </a>
                                <a href="?id=<?= $row['idCat'] ?>" class="delete-button">
                                    <img src="assets/images/hide-svgrepo-com.svg" alt="Hide Icon" width="20" height="20">
                                </a>
                            </div>

                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php

        // Check if the form is submitted for adding or updating
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Adding new data
            try {
                // Get the form data
                $id_category = $_POST['id_category'];
                $nom_category = $_POST['nom_category'];
                $desc_category = $_POST['desc_category'];
                $photoTmp = $_FILES['img_category']['tmp_name'];
                $photoData = file_get_contents($photoTmp);


                // Insert data into the database
                $query = "INSERT INTO categorie (idCat, nomCat, descCat,photoCat) VALUES (:id_category, :nom_category, :desc_category,:img_category)";
                $statement = $pdo->prepare($query);
                $statement->bindParam(':id_category', $id_category);
                $statement->bindParam(':nom_category', $nom_category);
                $statement->bindParam(':desc_category', $desc_category);
                $statement->bindParam(':img_category', $photoData, PDO::PARAM_LOB);
                $statement->execute();

                // Redirect to the same page after insertion
                // header("Location: categorie.php");
                echo "success";
                exit();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

        }
        ?>

    </div>
</body>

</html>