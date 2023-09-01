<?php
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
    // Connect to the database
    $conn = mysqli_connect("localhost", "root", "", "simpleinvoicephp");

    // Check if the connection was successful
    if ($conn) {
        $user_id = $_GET['id'];
        // Fetch user record by ID
        $sql = "SELECT * FROM invoice_user WHERE id = '$user_id'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            echo 'User not found.';
            exit;
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        echo 'Database connection failed.';
        exit;
    }
} else {
    // Redirect back to manage-user.php if ID is not provided
    header("Location: manage-user.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
        body {
            /* Gradient Background */
            background-image: linear-gradient(to left, #59B0F5, #FFFFFF);
            /* Add more styles here if needed */
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: #333;
        }

        /* Logo */
        .logo {
            position: absolute;
            top: 30px;
            left: 45px;
            width: 180px; /* Adjust the width as needed */
            height: auto; /* Maintain aspect ratio */
        }

        /* User Management Heading */
        .user-management {
            text-align: center;
            font-weight: bold;
            font-size: 47px; /* Adjust the font size as needed */
            margin-top: 90px;
        }

        /* Back Button Styles */
        .back-button {
            position: absolute;
            top: 30px;
            right: 45px;
        }

        .back-button a {
            display: inline-block;
            padding: 10px 30px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px; /* Adjust the font size as needed */
        }

        .back-button a:hover {
            background-color: #0056b3;
        }

        /* Form Styles */
        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 93%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px; /* Adjust the font size as needed */
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
    <!-- Logo -->
    <header>
        <img src="logo11.png" alt="Logo" class="logo">
    </header>

    <!-- User Management Heading -->
    <h1 class="user-management">User Management</h1>

    <!-- Back Button -->
    <div class="back-button">
        <a href="manage-user.php">Back to </a>
    </div>

    <!-- Edit USER Form -->
    <form method="post" action="manage-user.php">
        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $row['email']; ?>" required>

        <label>First Name:</label>
        <input type="text" name="first_name" value="<?php echo $row['first_name']; ?>" required>

        <label>Last Name:</label>
        <input type="text" name="last_name" value="<?php echo $row['last_name']; ?>" required>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo $row['address']; ?>" required>

        <label>Mobile:</label>
        <input type="text" name="mobile" value="<?php echo $row['mobile']; ?>" required>

        <button type="submit">Update User</button>
    </form>
</body>
</html>
