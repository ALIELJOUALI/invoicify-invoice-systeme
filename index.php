<?php 

include('header.php');

$loginError = '';
if (!empty($_POST['email']) && !empty($_POST['pwd'])) {
    include 'Invoice.php';
    $invoice = new Invoice();
    $user = $invoice->loginUsers($_POST['email'], $_POST['pwd']); 

    if (!empty($user)) {
        $_SESSION['user'] = $user[0]['first_name'] . " " . $user[0]['last_name'];
        $_SESSION['userid'] = $user[0]['id'];
        $_SESSION['email'] = $user[0]['email'];       
        $_SESSION['address'] = $user[0]['address'];
        $_SESSION['mobile'] = $user[0]['mobile'];

        if ($_POST['email'] === 'admin@gmail.com' && $_POST['pwd'] === 'admin') {
            header("Location: admin.php");
            exit; // Add exit to prevent further execution of the code after redirection
        }
           
        header("Location: invoice_list.php");
        exit; // Add exit to prevent further execution of the code after redirection
    } else {
        $loginError = "Invalid email or password!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Invoice System</title>
  
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

         /* Adjust the width of the container */
         .row {
           position: absolute;
           top: 50%;
           left: 50%;
           transform: translate(-50%, -50%);
           display: flex;
           justify-content: center;
           align-items: center;
           min-height: 100vh;
         }

       /* Form Styles */
      form {
      width: 110%; /* Adjust the width as needed */
      max-width: 500px;
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
            width: 99%;
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

        /* Center-align the content */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        /* Move the heading to the top */
        .login-heading {
            text-align: center;
            font-weight: bold;
            font-size: 47px; /* Adjust the font size as needed */
            margin-top: 20px;
            margin-bottom: 40px;
            color: #fffff; /* Change to your preferred color */
            text-transform: uppercase;
            letter-spacing: 2px;
        }
    </style>
</head>
<body>
    <!-- Logo -->
    <header>
        <img src="logo11.png" alt="Logo" class="logo">
    </header>

    <!-- Back Button -->
    <div class="back-button">
    <a href="/invoice-system-php/home/homepage.php">Homepage</a>
    </div>

    <!-- Login Form -->
    <div class="row">
        <div class="login-form">  
            <br>
            <br>
            <!-- Move the heading to the top -->
            <h1 class="login-heading">Login Page</h1>
            
            <form method="post" action="">
                <div class="form-group">
                    <?php if ($loginError ) { ?>
                        <div class="alert alert-warning"><?php echo $loginError; ?></div>
                    <?php } ?>
              
                    <label>Email:</label>
                    <input name="email" id="email" type="email" class="form-control" required>
               
                    <label>Password:</label>
                    <input type="password" class="form-control" name="pwd" required>
                 
                    <button type="submit" name="login" class="btn btn-success">Login</button>
                    <br>
                    <p> </p>
                    <p>Create an <a href="signup.php">account</a></p>
                </div>
            </form>
            <br>
        </div>      
    </div>

    <!-- Footer included from container.php -->
    <?php include('footer.php');?> 
</body>
</html>
