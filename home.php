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
    <title>Document</title>
</head>

<body class="body-home">
    <nav>
        <img src="assets/images/logo.png" alt="logo" height="60" width="300">
        <div>
            <a style="text-decoration:none;color:white;" href="logout.php">Déconnexion</a>
        </div>
    </nav>
    <section class="container">
        <div class="sidebar">
            <div>
                <p><a class="active" href="home.php">Accueil</a></p>
                <p><a href="categories.php">Catégorie</a></p>
                <p><a href="users.php">Utilisateurs</a></p>
            </div>

            <div class="filter-section">

                <div class="price-filter-div">
                    <form onsubmit="filterProducts(); return false;">
                        <label for="minPrice">Minimum Price:</label>
                        <input type="number" id="minPrice" name="minPrice" min="0" placeholder="min" required><br>
                        <label for="maxPrice">Maximum Price:</label>
                        <input type="number" id="maxPrice" name="maxPrice" min="0" placeholder="max" required>
                        <br>
                        <button type="submit">Apply</button>
                    </form>

                </div>
                <select id="categories" name="categories" onchange="filterProducts()">
                    <option value="tout">Tout produits</option>
                    <option value="2">Boitiers électroniques</option>
                    <option value="3">Capteurs électroniques</option>
                    <option value="1">Piles</option>
                </select>
            </div>
            <div class="user-div">
                <img src="assets/images/user.png" alt="user" height="60" width="60">
                <p>
                    <?= $_SESSION['username'] ?>
                </p>
            </div>
        </div>

        <?php
        try {
            $query = "SELECT * FROM produit";
            $statement = $pdo->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();

            if ($result) {
                ?>
                <div class="content">
                    <!-- add form -->
                    <button class="addCat-btn" onclick="openForm_add_prd()">Ajouter produit</button>
                    <div class="dark" onclick="closeForm_prd()"></div>
                    <div class="popup-form-prod popup-form">
                        <span class="close-btn" onclick="closeForm_prd()">X</span>
                        <h2></h2>
                        <form>
                            <label>Reference :</label>
                            <input type="text" id="id_prod" name="id_prod"><br>
                            <label>Image :</label>
                            <input type="file" id="img_prod" name="img_prod"> <br>
                            <label>Etiquette :</label>
                            <input type="text" id="etq_prod" name="etq_prod"><br>
                            <label>Code barre :</label>
                            <input type="text" id="code_barre_prod" name="code_barre_prod"><br>
                            <label>Prix achat :</label>
                            <input type="text" id="pr_ach" name="pr_ach"><br>
                            <label>Prix final :</label>
                            <input type="text" id="pr_fin" name="pr_fin"><br>
                            <label>Offre prix :</label>
                            <input type="text" id="offre" name="offre"><br>
                            <label>Description :</label>
                            <input type="text" id="desc_prod" name="desc_prod"><br>
                            <label>Categorie :</label>
                            <select id="categories" name="categories">
                                <option value="2">Boitiers électroniques</option>
                                <option value="3">Capteurs électroniques</option>
                                <option value="1">Piles</option>
                            </select><br>
                            <input type="submit" value="">
                        </form>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Produit image</th>
                                <th>etiquette/ref</th>
                                <th>Code barre</th>
                                <th>Description</th>
                                <th>Prix d’achat</th>
                                <th>Prix final</th>
                                <th>Offre de prix</th>
                                <th>quantite stock</th>
                                <th>Edit/Delete</th>
                            </tr>
                        </thead>
                        <tbody id="productTableBody">
                            <?php foreach ($result as $row) { ?>
                                <tr data-category="<?= $row['fk_idCat'] ?>" data-price="<?= $row['pr_final'] ?>">
                                    <td>
                                        <img src="data:image/jpg;base64,<?= base64_encode($row['image']) ?>" alt="Product Image"
                                            width="300" height="300">
                                    </td>
                                    <td>
                                        <?= $row['etiquette'] . ' ' . $row['ref_prod'] ?>
                                    </td>
                                    <td>
                                        <?= $row['code_barre'] ?>
                                    </td>
                                    <td>
                                        <?= $row['descProd'] ?>
                                    </td>
                                    <td>
                                        <?= $row['pr_achat'] ?>
                                    </td>
                                    <td>
                                        <?= $row['pr_final'] ?>
                                    </td>
                                    <td>
                                        <?= $row['offre_pr'] ?>
                                    </td>
                                    <td>
                                        <?= $row['qte_stock'] ?>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="edit-button" onclick="openForm_updt_prd()">
                                                <img src="assets/images/edit-svgrepo-com.svg" alt="Edit Icon" width="20"
                                                    height="20">
                                            </button>
                                            <button class="delete-button">
                                                <img src="assets/images/hide-svgrepo-com.svg" alt="hide Icon" width="20"
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
        <div id="filteredProducts">

            <?php
            include 'db.php';

            if (isset($_GET['category'])) {
                $category = $_GET['category'];

                try {
                    $whereClause = "";

                    if ($category !== 'tout') {
                        $whereClause = "WHERE category = '$category'";
                    }

                    $query = "SELECT * FROM produit $whereClause";
                    $statement = $pdo->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll();

                    if ($result) {
                        foreach ($result as $row) {
                            // Output HTML for each product, adjust as needed
                            echo '<p>' . $row['product_name'] . '</p>';
                        }
                    } else {
                        echo '<p>No records found</p>';
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
            }
            ?>

        </div>


    </section>
    <footer>
        <p>copyright ElectroNAcer 2023</p>
    </footer>









    <script src="assets/js/main.js"></script>
</body>

</html>