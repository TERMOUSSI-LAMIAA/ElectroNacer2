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
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <nav>
        <img src="assets/images/logo.png" alt="logo" height="60" width="300">
        <a href="logout.php">Déconnexion</a>
    </nav>
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
    <!-- not approved -->
    <div class="content">
        <table class="table table-hover">
            <h2>Users Not Approved</h2>
            <thead>
                <tr>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Add user</th>
                    <!-- Add other relevant columns -->
                </tr>
            </thead>
            <tbody>
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
                            <button class="approve-button" data-user-id="<?= $user['login_'] ?>">
                                <img src="assets/images/accept-check-good-mark-ok-tick-svgrepo-com.svg" alt="approve Icon"
                                    width="30" height="30">
                            </button>
                            <button class="reject-button" data-user-id="<?= $user['login_'] ?>">
                                <img src="assets/images/forbidden-cancel-svgrepo-com.svg" alt="reject Icon" width="30"
                                    height="30">
                            </button>
                        </td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- approved -->
        <table class="table table-hover">
            <h2>Users Approved</h2>
            <thead>
                <tr>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Add admin</th>
                    <!-- Add other relevant columns -->
                </tr>
            </thead>
            <tbody>
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
                            <button class="admin-button" data-user-id="<?= $user['login_'] ?>">
                                <img src="assets/images/admin-1-svgrepo-com.svg" alt="beadmin Icon" width="30" height="30">
                            </button>
                        </td>
                        <!-- Add other relevant columns -->
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Admins -->
        <table class="table table-hover">
            <h2>Admins</h2>
            <thead>
                <tr>
                    <th>Login</th>
                    <th>Email</th>
                    <!-- Add other relevant columns -->
                </tr>
            </thead>
            <tbody>
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
            </tbody>
        </table>
    </div>
    <script src="assets/js/main.js"></script>
</body>

</html>