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
            <p>Déconnexion</p>
        </div>
    </nav>
    <section class="container">
        <div>
            <div class="sidebar">
                <div>
                    <p class="active" id="tousLesProduits">Accueil</p>
                    <p>Catégorie</p>
                    <p>Utilisateurs </p>
                </div>

                <div class="filter-section">

                    <div class="price-filter-div">
                        <form>
                            <label for="minPrice">Minimum Price:</label>
                            <input type="number" id="minPrice" name="minPrice" min="0" placeholder="Enter minimum price"
                                required>

                            <label for="maxPrice">Maximum Price:</label>
                            <input type="number" id="maxPrice" name="maxPrice" min="0" placeholder="Enter maximum price"
                                required>

                            <br>

                            <button type="submit">Apply Filter</button>
                        </form>

                    </div>
                    <select id="categories" name="categories">
                        <option value="cat1">Categorie 1</option>
                        <option value="cat2">Categorie 2</option>
                        <option value="cat3">Categorie 3</option>
                    </select>
                </div>
                <div class="user-div">
                    <img src="assets/images/user.png" alt="user" height="60" width="60">
                    <p>Admin name </p>
                </div>
            </div>

        </div>

    </section>
    <footer>
        <p>copyright ElectroNAcer 2023</p>
    </footer>









    <script src="assets/js/main.js"></script>
</body>

</html>