<?php
    $servername = "localhost";
    $username = "your_username";
    $password = "your_password";
    $dbname = "exclusaodedados";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // User ID to delete
    $userID = 1; // replace with the ID of the user you want to delete

    // sql to delete a record
    $sql = "DELETE FROM pedidos WHERE usuario_id = $userID";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    // sql to delete a user
    $sql = "DELETE FROM usuarios WHERE id = $userID";

    if ($conn->query($sql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    // close connection
    $conn->close();
?>