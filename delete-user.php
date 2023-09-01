<?php
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    // Get the user ID from the URL
    $user_id = $_GET['id'];

    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "simpleinvoicephp");

    // Check if the connection was successful
    if ($conn) {
        // Prepare the SQL statement to delete the user
        $sql = "DELETE FROM invoice_user WHERE id = '$user_id'";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            header("Location: manage-user.php");
        } else {
            echo 'Error deleting user: ' . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        echo 'Database connection failed.';
    }
} else {
    echo 'Invalid request.';
}
?>
