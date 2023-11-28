<?php
session_start();
include 'db.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Categories</title>
</head>

<body class="body-home">
    <nav>
        <img src="assets/images/logo.png" alt="logo" height="60" width="300">
        <div>
            <p>Déconnexion</p>
        </div>
    </nav>
    <section class="container">

        <div class="sidebar">
            <div>
                <p><a href="home.php">Accueil</a></p>
                <p><a class="active" href="categories.php">Catégorie</a></p>
                <p><a href="users.php">Utilisateurs</a></p>
            </div>
            <div class="user-div">
                <img src="assets/images/user.png" alt="user" height="60" width="60">
                <p>Admin name </p>
            </div>
        </div>

        <?php
        try {
            $query = "SELECT * FROM categorie";
            $statement = $pdo->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();

            if ($result) {
                ?>
                <div class="content">
                    <button class="addCat-btn" onclick="openForm_add_cat()">Ajouter catégorie</button>
                    <div class="dark" onclick="closeForm_add_cat()"></div>
                    <div class="popup-form-add-cat popup-form">
                        <span class="close-btn" onclick="closeForm()">X</span>
                        <h2>Ajouter une catégorie</h2>
                        <!-- Add your form elements here -->
                        <form>
                            <!-- Your form fields go here -->
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
                    <table>
                        <thead>
                            <tr>
                                <th>Categorie image</th>
                                <th>Nom categorie</th>
                                <th>Description</th>
                                <th>Edit/Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $row) { ?>
                                <tr>
                                    <td>
                                        <img src="data:image/jpg;base64,<?= base64_encode($row['photoCat']) ?>"
                                            alt="categorie Image" width="300" height="300">
                                    </td>
                                    <td>
                                        <?= $row['nomCat'] ?>
                                    </td>
                                    <td>
                                        <?= $row['descCat'] ?>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="edit-button">
                                                <img src="assets/images/edit-svgrepo-com.svg" alt="Edit Icon" width="20"
                                                    height="20">
                                            </button>
                                            <button class="delete-button">
                                                <img src="assets/images/delete-svgrepo-com.svg" alt="delete Icon" width="20"
                                                    height="20">
                                            </button>
                                        </div>

                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php
            } else {
                ?>
                <p>No records found</p>
                <?php
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>

    </section>
    <footer>
        <p>copyright ElectroNAcer 2023</p>
    </footer>









    <script src="assets/js/main.js"></script>
</body>

</html>