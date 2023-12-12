<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST["userId"];
    $action = $_POST["action"];

    try {
        if ($action == "approve") {
            // Update user approval status to true
            $query = "UPDATE utilisateur SET is_approved = true WHERE login_ = :userId";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            echo "User approved successfully";
        } elseif ($action == "reject") {
            // Delete the user
            $query = "DELETE FROM utilisateur WHERE login_ = :userId";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            echo "User rejected and deleted successfully";
        } elseif ($action == "make_admin") {
            // Update user is_admin status to true
            $query = "UPDATE utilisateur SET is_admin = true WHERE login_ = :userId";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':userId', $userId);
            $stmt->execute();

            echo "User set as admin successfully";
        } else {
            echo "Invalid action";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
