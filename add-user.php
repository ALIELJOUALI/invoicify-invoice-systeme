<?php
// Ensure the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $mobile = $_POST['mobile'];

    // Validate data
    if ($email && $password && $first_name && $last_name && $address && $mobile) {
        // Connect to the database
        $conn = mysqli_connect("localhost", "root", "", "simpleinvoicephp");

        // Check if the connection was successful
        if ($conn) {
            // Prepare the SQL query
            $sql = "INSERT INTO invoice_user (email, password, first_name, last_name, address, mobile) 
                    VALUES ('$email', '$password', '$first_name', '$last_name', '$address', '$mobile')";

            // Execute the query
            if (mysqli_query($conn, $sql)) {
                // Signup success, you can redirect the user to a success page
                header("Location: manage-user.php");
                exit;
            } else {
                // Signup failed, display an error message or handle the error appropriately
                $error_message = "Signup failed. Please try again later.";
            }

            // Close the database connection
            mysqli_close($conn);
        } else {
            // Database connection error
            $error_message = "Database connection failed. Please try again later.";
        }
    } else {
        // Invalid data, display an error message or handle the error appropriately
        $error_message = "Invalid data. Please fill in all the required fields.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ADD User Page</title>
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
            margin-top: 100px;
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

    <!-- ADD USER Form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <label>First Name:</label>
        <input type="text" name="first_name" required>

        <label>Last Name:</label>
        <input type="text" name="last_name" required>

        <label>Address:</label>
        <input type="text" name="address" required>

        <label>Mobile:</label>
        <input type="text" name="mobile" required>

        <button type="submit">ADD USER</button>
    </form>
    <br>
</body>
</html>
