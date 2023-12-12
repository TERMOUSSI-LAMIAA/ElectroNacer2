<?php
session_start();
include '../db.php';
/*pagination*/
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$productsPerPage = 4;
$offset = ($page - 1) * $productsPerPage;
/*---*/
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    try {
        // Get the category ID from the URL
        $id_prod = $_GET['id'];

        // Update the isHide value to 1
        $query = "UPDATE produit SET isHide = 1 WHERE ref_prod = :id_prod";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':id_prod', $id_prod);
        $statement->execute();

        // Redirect back to the same page or do something else
        header("Location: user/index.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

try {
    $query = "SELECT * FROM categorie where isHide=0";
    $statement = $pdo->prepare($query);
    $statement->execute();
    $categories = $statement->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// try {
//     $query = "SELECT * FROM produit where isHide=0";
//     $statement = $pdo->prepare($query);
//     $statement->execute();
//     $result = $statement->fetchAll();
// } catch (PDOException $e) {
//     echo "Error: " . $e->getMessage();
// }
/*pagination*/
try {
    $query = "SELECT * FROM produit WHERE isHide = 0 LIMIT :productsPerPage OFFSET :offset";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':productsPerPage', $productsPerPage, PDO::PARAM_INT);
    $statement->bindParam(':offset', $offset, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll();
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$totalProductsQuery = "SELECT COUNT(*) as total FROM produit WHERE isHide = 0";
$totalStatement = $pdo->prepare($totalProductsQuery);
$totalStatement->execute();
$totalProducts = $totalStatement->fetch(PDO::FETCH_ASSOC)['total'];
$totalPages = ceil($totalProducts / $productsPerPage);
/*----*/
// Check if the category filter form is submitted
if (isset($_GET['category_filter'])) {
    $filter_category = isset($_GET['filter_category']) ? $_GET['filter_category'] : null;

    try {
        $query = "SELECT * FROM produit WHERE isHide = 0";

        if ($filter_category) {
            $query .= " AND fk_idCat = :filter_category";
        }

        $statement = $pdo->prepare($query);

        if ($filter_category) {
            $statement->bindParam(':filter_category', $filter_category);
        }

        $statement->execute();
        $result = $statement->fetchAll();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Check if the price filter form is submitted
if (isset($_GET['price_filter'])) {
    $min_price = isset($_GET['min_price']) ? $_GET['min_price'] : null;
    $max_price = isset($_GET['max_price']) ? $_GET['max_price'] : null;

    try {
        $query = "SELECT * FROM produit WHERE isHide = 0";

        if ($min_price !== null && $max_price !== null) {
            $query .= " AND pr_final BETWEEN :min_price AND :max_price";
        } elseif ($min_price !== null) {
            $query .= " AND pr_final >= :min_price";
        } elseif ($max_price !== null) {
            $query .= " AND pr_final <= :max_price";
        }

        $statement = $pdo->prepare($query);

        if ($min_price !== null) {
            $statement->bindParam(':min_price', $min_price);
        }

        if ($max_price !== null) {
            $statement->bindParam(':max_price', $max_price);
        }

        $statement->execute();
        $result = $statement->fetchAll();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body style="background-color:white;">
    <nav>
        <img src="../assets/images/logo.png" alt="logo" height="60" width="300">
        <a href="../logout.php">Déconnexion</a>
    </nav>
    <!-- form -->
    <div class="container">

        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Ajouter produit</h4>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data">
                            <label>reference produit:</label>
                            <input type="text" id="ref_prod" name="ref_prod"><br>
                            <label>Image produit:</label>
                            <input type="file" id="img_prod" name="img_prod"><br>
                            <label>Etiquette:</label>
                            <input type="text" id="etiqt" name="etiqt"> <br>
                            <label>Code barre:</label>
                            <input type="text" id="cd_barre" name="cd_barre"><br>
                            <label>Prix achat:</label>
                            <input type="number" id="pr_ach" name="pr_ach"><br>
                            <label>Prix final:</label>
                            <input type="number" id="pr_fin" name="pr_fin"><br>
                            <label>Offre prix:</label>
                            <input type="number" id="offre_pr" name="offre_pr"><br>
                            <label>Description produit:</label>
                            <input type="text" id="desc_prod" name="desc_prod"><br>
                            <label>Quantité min:</label>
                            <input type="number" id="qte_min" name="qte_min"><br>
                            <label>Quantité stock:</label>
                            <input type="number" id="qte_stck" name="qte_stck"><br>
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
        <!-- filter by category -->
        <form method="GET" style="margin-bottom: 10px;" class="filter-form">
            <label for="filter_category">Filter by Category:</label>
            <select id="filter_category" name="filter_category">
                <option value="">All Categories</option>
                <?php
                foreach ($categories as $category) {
                    echo "<option value='" . $category['idCat'] . "'>" . $category['nomCat'] . "</option>";
                }
                ?>
            </select>
            <input type="submit" name="category_filter" value="Filter by Category">
        </form>

        <!-- filter by price -->
        <form method="GET" class="price-filter-form">
            <label for="min_price">Min Price:</label>
            <input type="number" id="min_price" name="min_price">
            <label for="max_price">Max Price:</label>
            <input type="number" id="max_price" name="max_price">
            <input type="submit" name="price_filter" value="Filter by Price">
        </form>
        <div class="user-div">
            <img src="../assets/images/user.png" alt="user" height="40" width="40">
            <p>
                <?= $_SESSION['username'] ?>
            </p>
        </div>
    </div>

    <div class="content">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix achat</th>
                    <th>Prix final</th>
                    <th>Offre prix</th>
                    <th>Description</th>
                    <th>qte_stock</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) { ?>
                    <tr>
                        <td>
                            <img src="data:image/jpg;base64,<?= base64_encode($row['image']) ?>" alt="Product Image"
                                width="200" height="200">
                            <br>
                            <span>Etiquette:
                                <?= $row['etiquette'] ?>
                            </span><br>
                            <span>Reference:
                                <?= $row['ref_prod'] ?>
                            </span><br>
                            <span>Code barre:
                                <?= $row['code_barre'] ?>
                            </span>
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
                        <td class="description-cell">
                            <?= $row['descProd'] ?>
                        </td>
                        <td>
                            <?= $row['qte_stock'] ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
        // Display pagination links
        echo '<div class="pagination">';
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='?page=$i'>$i</a> ";
        }
        echo '</div>';

        ?>
        <?php
        // Check if the form is submitted for adding or updating
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Adding new data
            try {
                // Get the form data
                $ref_prod = $_POST['ref_prod'];
                $photoTmp = $_FILES['img_prod']['tmp_name'];
                $photoData = file_get_contents($photoTmp);
                $etiqt = $_POST['etiqt'];
                $cd_barre = $_POST['cd_barre'];
                $pr_ach = $_POST['pr_ach'];
                $pr_fin = $_POST['pr_fin'];
                $offre_pr = $_POST['offre_pr'];
                $desc_prod = $_POST['desc_prod'];
                $qte_min = $_POST['qte_min'];
                $qte_stck = $_POST['qte_stck'];
                $category = $_POST['category'];


                // Insert data into the database
                $query = "INSERT INTO produit (ref_prod, image, etiquette,code_barre,pr_achat,pr_final,offre_pr,descProd,qte_min,qte_stock,fk_idCat)VALUES (:ref_prod, :img_prod, :etiqt,:cd_barre,:pr_ach,:pr_fin,:offre_pr,:desc_prod,:qte_min,:qte_stck,:category)";
                $statement = $pdo->prepare($query);
                $statement->bindParam(':ref_prod', $ref_prod);
                $statement->bindParam(':img_prod', $photoData, PDO::PARAM_LOB);
                $statement->bindParam(':etiqt', $etiqt);
                $statement->bindParam(':cd_barre', $cd_barre);
                $statement->bindParam(':pr_ach', $pr_ach);
                $statement->bindParam(':pr_fin', $pr_fin);
                $statement->bindParam(':offre_pr', $offre_pr);
                $statement->bindParam(':desc_prod', $desc_prod);
                $statement->bindParam(':qte_min', $qte_min);
                $statement->bindParam(':qte_stck', $qte_stck);
                $statement->bindParam(':category', $category);
                $statement->execute();
                echo "success";
                exit();
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }

        }
        ?>
        <?php
        // Check if the form is submitted for adding or updating
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Adding new data
            try {
                // Get the form data
                // ... (Your existing code for adding data)
        
                // Insert data into the database
                $query = "INSERT INTO produit (ref_prod, image, etiquette,code_barre,pr_achat,pr_final,offre_pr,descProd,qte_min,qte_stock,fk_idCat)VALUES (:ref_prod, :img_prod, :etiqt,:cd_barre,:pr_ach,:pr_fin,:offre_pr,:desc_prod,:qte_min,:qte_stck,:category)";
                $statement = $pdo->prepare($query);
                // ... (Your existing code for binding parameters and executing the statement)
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