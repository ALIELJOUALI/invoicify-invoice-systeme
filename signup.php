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
            // Check if email already exists in the database
            $existingEmailQuery = "SELECT * FROM invoice_user WHERE email = '$email'";
            $existingEmailResult = mysqli_query($conn, $existingEmailQuery);

            if (mysqli_num_rows($existingEmailResult) > 0) {
                // Email already exists, display an error message
                $error_message = "Email already exists. Please try a different email.";
            } else {
                // Prepare the SQL query
                $sql = "INSERT INTO invoice_user (email, password, first_name, last_name, address, mobile) 
                        VALUES ('$email', '$password', '$first_name', '$last_name', '$address', '$mobile')";

                // Execute the query
                if (mysqli_query($conn, $sql)) {
                    // Signup success, you can redirect the user to a success page
                    header("Location: index.php");
                    exit;
                } else {
                    // Signup failed, display an error message or handle the error appropriately
                    $error_message = "Signup failed. Please try again later.";
                }
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
    <title>Signup Page</title>
    <style>
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
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
        .error-message {
     color: #D19004;
     text-align: center;
     margin-top: 10px;
     margin-bottom: 20px;
     padding: 10px 15px;
     background-color: #FFF3CD;
     border: 1px solid #FFF3CD;
     border-radius: 4px;
     font-size: 16px;
     }
    </style>
</head>
<body>
    
    <!-- Logo -->
    <header>
        <img src="logo11.png" alt="Logo" class="logo">
    </header>

    <!-- User Management Heading -->
    <h1 class="user-management">Signup Page</h1>

    <!-- Back Button -->
    <div class="back-button">
    <a href="/invoice-system-php/home/homepage.php">Homepage</a>
    </div>

    <!-- Signup Form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <!-- Display the error message div at the top of the form -->
      <?php if (isset($error_message)) { ?>
        <div class="error-message">
            <?php echo $error_message; ?>
        </div>
      <?php } ?>



        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <label>First Name:</label>
        <input type="text" name="first_name" required><br>

        <label>Last Name:</label>
        <input type="text" name="last_name" required><br>

        <label>Address:</label>
        <input type="text" name="address" required><br>

        <label>Mobile:</label>
        <input type="text" name="mobile" required><br>

        <button type="submit">Sign Up</button>
        <p>Already have an <a href="index.php">account</a></p>

    </form>
</body>
</html>

