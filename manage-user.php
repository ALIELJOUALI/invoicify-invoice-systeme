<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
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

        .logo {
            position: absolute;
            top: 30px;
            left: 45px;
            width: 180px; /* Adjust the width as needed */
            height: auto; /* Maintain aspect ratio */
        }

        .user-management {
            text-align: center;
            font-weight: bold;
            font-size: 47px; /* Adjust the font size as needed */
            margin-top: 100px;
        }

        /* Home Button Styles */
        .home-button {
            text-align: center;
            margin-top: 20px;
        }

        .home-button a {
            display: inline-block;
            padding: 10px 30px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px; /* Adjust the font size as needed */
        }

        .home-button a:hover {
            background-color: #0056b3;
        }

        /* Table Styles */
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:hover {
            background-color: #f2f2f2;
        }
/* New Back Button Styles */
.back-button {
    position: absolute;
    top: 33px;
    right: 55px;
}

.back-button a {
    display: inline-block;
    padding: 10px 30px;
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    font-size: 18px;
}

.back-button a:hover {
    background-color: #0056b3;
}

    </style>
</head>
<body>
        <!-- Logo -->
        <header>
        <img src="logo11.png" alt="Logo" class="logo">
        </header>
        
        <h1 class="user-management" style="text-align: center;">User Management</h1>

    <br>
    <br>
    <?php
    
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['user_id'])) {
        // Handle the form submission from edit-user.php
        $user_id = $_POST['user_id'];
        $email = $_POST['email'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $address = $_POST['address'];
        $mobile = $_POST['mobile'];

        // Connect to the database
        $conn = mysqli_connect("localhost", "root", "", "simpleinvoicephp");

        // Check if the connection was successful
        if ($conn) {
            // Update user record in the database
            $sql = "UPDATE invoice_user 
                    SET email = '$email', first_name = '$first_name', last_name = '$last_name', 
                        address = '$address', mobile = '$mobile' 
                    WHERE id = '$user_id'";

            if (mysqli_query($conn, $sql)) {
                echo '<p>User updated successfully!</p>';
            } else {
                echo '<p>Error updating user: ' . mysqli_error($conn) . '</p>';
            }

            // Close the database connection
            mysqli_close($conn);
        } else {
            echo '<p>Database connection failed.</p>';
        }
    }

    // Fetch all user records
    $conn = mysqli_connect("localhost", "root", "", "simpleinvoicephp");

    // Check if the connection was successful
    if ($conn) {
        $sql = "SELECT * FROM invoice_user";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo '<table border="1">';
            echo '<tr><th>ID</th><th>Email</th><th>Password</th><th>First Name</th><th>Last Name</th><th>Address</th><th>Mobile</th><th>Action</th></tr>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $row['id'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td>' . $row['password'] . '</td>'; // Displaying the password (for testing purposes only)
                echo '<td>' . $row['first_name'] . '</td>';
                echo '<td>' . $row['last_name'] . '</td>';
                echo '<td>' . $row['address'] . '</td>';
                echo '<td>' . $row['mobile'] . '</td>';
                echo '<td>
                          <a href="edit-user.php?id=' . $row['id'] . '">Edit</a> | 
                          <a href="delete-user.php?id=' . $row['id'] . '">Delete</a> 
                      </td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo 'No users found.';
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        echo 'Database connection failed.';
    }
    
    ?>

      <div class="home-button">
        <a href="add-user.php">Add User</a>
    </div>
    <div class="back-button">
        <a href="admin.php">Back to</a>
    </div>


</body>
</html>
