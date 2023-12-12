<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") { //is a PHP superglobal variable that holds the request method used by the client to access the web server.

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    try {

        $stmt = $pdo->prepare("INSERT INTO utilisateur (login_, psword, email) VALUES (:username, :pass, :email)");

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':pass', $password);
        $stmt->bindParam(':email', $email);

        $stmt->execute();
        $_SESSION['registration_success'] = true;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']) {
    echo "<script>alert('Registration successful!\\nPlease wait for the approval of your registration by the admin.');</script>";
    unset($_SESSION['registration_success']); // Reset the session variable
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="assets/css/style.css">


</head>

<body class="body-login">
    <div class="signup-form">
        <form action="" method="post">
            <h2>Sign Up</h2>
            <p>Please fill in this form to create an account!</p>
            <hr>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <input type="text" class="form-control" name="username" placeholder="Username" required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-paper-plane"></i></span>
                    <input type="email" class="form-control" name="email" placeholder="Email Address"
                        required="required">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" placeholder="Password" required="required">
                </div>
            </div>
            <div class="form-group">
                <label class="checkbox-inline"><input type="checkbox" > I accept the <a
                        href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg">Sign Up</button>
            </div>
        </form>
        <div class="text-center">Already have an account? <a href="login.php">Login here</a></div>
    </div>


</body>

</html>