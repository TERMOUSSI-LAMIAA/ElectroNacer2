<?php
session_start();
include 'db.php';

// Fetch users who are not approved
$queryNotApproved = "SELECT * FROM utilisateur WHERE is_approved = false";
$stmtNotApproved = $pdo->query($queryNotApproved);
$usersNotApproved = $stmtNotApproved->fetchAll(PDO::FETCH_ASSOC);

// Fetch users who are approved
$queryApproved = "SELECT * FROM utilisateur WHERE is_approved = true AND is_admin = false";
$stmtApproved = $pdo->query($queryApproved);
$usersApproved = $stmtApproved->fetchAll(PDO::FETCH_ASSOC);
// admins
$queryAdmin = "SELECT * FROM utilisateur WHERE is_admin = true";
$stmtAdmin = $pdo->query($queryAdmin);
$Admins = $stmtAdmin->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Users</title>
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
                <p><a href="home.php">Accueil</a></p>
                <p><a href="categories.php">Catégorie</a></p>
                <p><a class="active" href="users.php">Utilisateurs</a></p>
            </div>
            <div class="user-div">
                <img src="assets/images/user.png" alt="user" height="60" width="60">
                <p>Admin name</p>
            </div>
        </div>
        <div class="content-users">
            <div class="user-table">
                <h2>Users Not Approved</h2>
                <table>
                    <!-- Table header -->
                    <tr>
                        <th>Login</th>
                        <th>Email</th>
                        <th>Add user</th>
                        <!-- Add other relevant columns -->
                    </tr>
                    <!-- Table data -->
                    <?php foreach ($usersNotApproved as $user): ?>
                        <tr>
                            <td>
                                <?= $user['login_'] ?>
                            </td>
                            <td>
                                <?= $user['email'] ?>
                            </td>
                            <td>
                                <button class="approve-button" onclick="">
                                    <img src="assets/images/accept-check-good-mark-ok-tick-svgrepo-com.svg"
                                        alt="approve Icon" width="30" height="30">
                                </button>
                                <button class="reject-button" onclick="">
                                    <img src="assets/images/forbidden-cancel-svgrepo-com.svg"
                                        alt="reject Icon" width="30" height="30">
                                </button>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

            <div class="user-table">
                <h2>Users Approved</h2>
                <table>
                    <!-- Table header -->
                    <tr>
                        <th>Login</th>
                        <th>Email</th>
                        <th>Add admin</th>
                        <!-- Add other relevant columns -->
                    </tr>
                    <!-- Table data -->
                    <?php foreach ($usersApproved as $user): ?>
                        <tr>
                            <td>
                                <?= $user['login_'] ?>
                            </td>
                            <td>
                                <?= $user['email'] ?>
                            </td>
                            <td>
                                <button class="admin-button" onclick="">
                                    <img src="assets/images/admin-1-svgrepo-com.svg" alt="beadmin Icon" width="30"
                                        height="30">
                                </button>
                            </td>
                            <!-- Add other relevant columns -->
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="user-table">
                <h2>Admins</h2>
                <table>
                    <!-- Table header -->
                    <tr>
                        <th>Login</th>
                        <th>Email</th>
                        <!-- Add other relevant columns -->
                    </tr>
                    <!-- Table data -->
                    <?php foreach ($Admins as $user): ?>
                        <tr>
                            <td>
                                <?= $user['login_'] ?>
                            </td>
                            <td>
                                <?= $user['email'] ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
    </section>

    <footer>
        <p>copyright ElectroNAcer 2023</p>
    </footer>









    <script src="assets/js/main.js"></script>
</body>

</html>