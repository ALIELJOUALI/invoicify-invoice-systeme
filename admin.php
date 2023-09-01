<?php 

include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();


// Define an array of currency symbols
$currencySymbols = array(
  'USD' => '$',
  'EUR' => '€',
  'GBP' => '£',
  "JPY" =>  '¥',
  "AUD" =>  'A$',
  "CAD" =>  'C$',
  "CHF" =>  'Fr',
  "MAD" =>  'dh',

);

?>



<head>
    <style>
        /* Logo */
        .logo {
            position: absolute;
            top: 30px;
            left: 45px;
            width: 180px; /* Adjust the width as needed */
            height: auto; /* Maintain aspect ratio */
        }

        /* Background Gradient */
        body {
            background-image: linear-gradient(to left, #59B0F5, #FFFFFF);
            /* Add more styles here if needed */
            /* Make sure there are no conflicting styles affecting body or .container */
        }
    </style>
</head>
<title>Invoice System</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
    <!-- Logo -->
    <header>
        <img src="logo11.png" alt="Logo" class="logo">
    </header>
	<div class="container">
  <br>
  <br>
  <br>
  <br>
  <br>
  <br>	
  <br>		
	 
	  <?php include('menu-admin.php');?>			  
      <table id="data-table" class="table table-condensed table-hover table-striped">
        <thead>
          <tr>
            <th>Invoice No.</th>
            <th>Customer Name</th>
            <th>Create Date</th>
            <th>Total</th>
            <th>Status</th>
            <th>Print</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Send E</th>
          </tr>
        </thead>
        <?php		
	    	$invoiceList = $invoice->getInvoiceList();
        foreach($invoiceList as $invoiceDetails){
			$invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceDetails["order_date"]));
            echo '
              <tr>
                <td>'.$invoiceDetails["order_id"].'</td>
                <td>'.$invoiceDetails["order_receiver_name"].'</td>
                <td>'.$invoiceDate.'</td>
                <td>' .$currencySymbols[$invoiceDetails["currency_n"]] . $invoiceDetails["order_total_after_tax"].'</td>
                <td>'.($invoiceDetails["status"] === "paid" ? "Paid" : "Not Paid").'</td>
                <td><a href="print_invoice.php?invoice_id='.$invoiceDetails["order_id"].'" title="Print Invoice"><button class="btn btn-primary btn-sm"><i class="fa fa-print"></i></button></a></td>
                <td><a href="edit_invoice_admin.php?update_id='.$invoiceDetails["order_id"].'"  title="Edit Invoice"><button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button></a></td>
                <td><a href="delete-invoice_admin.php?order_id='.$invoiceDetails['order_id'].'" title="Delete Invoice"><button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button></a></td>
                <td><a href="phpmailer\index_admin.php?invoice_id='.$invoiceDetails["order_id"].'" title="Send Email"><button class="btn btn-info btn-sm"><i class="fa fa-envelope"></i></button></a></td>

              </tr>
            ';
        }       
        ?>
      </table>	
</div>	
<?php include('footer.php');?>