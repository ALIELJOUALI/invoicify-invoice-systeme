<?php 
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_POST['companyName']) && $_POST['companyName'] && !empty($_POST['invoiceId']) && $_POST['invoiceId']) {	
	// Get the selected status from the dropdown
	$status = $_POST['status'];
	$invoice->updateInvoice($_POST);	
	header("Location:invoice_list.php");	
}
if(!empty($_GET['update_id']) && $_GET['update_id']) {
	$invoiceValues = $invoice->getInvoice($_GET['update_id']);		
	$invoiceItems = $invoice->getInvoiceItems($_GET['update_id']);		
}
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
<script src="home/js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
    <!-- Logo -->
    <header>
        <img src="logo11.png" alt="Logo" class="logo">
    </header>
<div class="container content-invoice">
    	<div class="cards">
    		<div class="card-bodys">
    			<form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate=""> 
	    	<div class="load-animate animated fadeInUp">
		    	<div class="row">
		    		<div class="col-xs-12">
					<br>
   <br>
   <br>         <br>
   <br>
   <br>
						<?php include('menu.php');?>			
		    		</div>		    		
		    	</div>
		      	<input id="currency" type="hidden" value="$">
		    	<div class="row">
		      		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		      			<h3>From,</h3>
						<?php echo $_SESSION['user']; ?><br>	
						<?php echo $_SESSION['address']; ?><br>	
						<?php echo $_SESSION['mobile']; ?><br>
						<?php echo $_SESSION['email']; ?><br>		      						      									
		      		</div>      		
		      		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		      			<h3>To,</h3>
		      			<div class="form-group">
							<input value="<?php echo $invoiceValues['order_receiver_name']; ?>" type="text" class="form-control" name="companyName" id="companyName" placeholder="Company Name" autocomplete="off">
						</div>
						<div class="form-group">
							<textarea class="form-control" rows="3" name="address" id="address" placeholder="Your Address"><?php echo
							 $invoiceValues['order_receiver_address']; ?></textarea>
						</div>
						
		      		</div>
		      	</div>
		      	<div class="row">
		      		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		      			<table class="table table-condensed table-striped" id="invoiceItem">	
							<tr>
								<th width="2%">	
								  <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input" id="checkAll" name="checkAll">
                                    <label class="custom-control-label" for="checkAll"></label>
                                  </div>
                                </th>
								<th width="15%">Item No</th>
								<th width="38%">Item Name</th>
								<th width="15%">Quantity</th>
								<th width="15%">Price</th>								
								<th width="15%">Total</th>
							</tr>
							<?php 
							$count = 0;
							foreach($invoiceItems as $invoiceItem){
								$count++;
							?>								
							<tr>
								<td><div class="custom-control custom-checkbox">
		                        <input type="checkbox" class="custom-control-input itemRow" id="itemRow">
		                        <label class="custom-control-label" for="itemRow"></label>
		                        </div></td>
								<td><input type="text" value="<?php echo $invoiceItem["item_code"]; ?>" name="productCode[]" id="productCode_<?php echo $count; ?>" class="form-control" autocomplete="off"></td>
								<td><input type="text" value="<?php echo $invoiceItem["item_name"]; ?>" name="productName[]" id="productName_<?php echo $count; ?>" class="form-control" autocomplete="off"></td>			
								<td><input type="number" value="<?php echo $invoiceItem["order_item_quantity"]; ?>" name="quantity[]" id="quantity_<?php echo $count; ?>" class="form-control quantity" autocomplete="off"></td>
								<td><input type="number" value="<?php echo $invoiceItem["order_item_price"]; ?>" name="price[]" id="price_<?php echo $count; ?>" class="form-control price" autocomplete="off"></td>
								<td><input type="number" value="<?php echo $invoiceItem["order_item_final_amount"]; ?>" name="total[]" id="total_<?php echo $count; ?>" class="form-control total" autocomplete="off"></td>
								<input type="hidden" value="<?php echo isset($invoiceItem['order_item_id']) ? $invoiceItem['order_item_id'] : ''; ?>" class="form-control" name="itemId[]">
							</tr>	
							<?php } ?>		
						</table>
		      		</div>
		      	</div>
		      	<div class="row mt-3 mb-3">
		      		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
		      			<button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
		      			<button class="btn btn-primary border-0" id="addRows" type="button">+ Add More</button>
		      		</div>
		      	</div>
		      	<div class="row">	
				 	    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group mt-3 mb-3">
								<label>Subtotal: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-prepend currency">
										<span class="input-group-text currency">$</span>
									</div>
									<input value="<?php echo $invoiceValues['order_total_before_tax']; ?>" type="number" class="form-control" name="subTotal" id="subTotal" placeholder="Subtotal">
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								<label>Tax Rate: &nbsp;</label>
								<div class="input-group">
								<div class="input-group-prepend">
									<span class="input-group-text">%</span>
								</div>
									<input value="<?php echo $invoiceValues['order_tax_per']; ?>" type="number" class="form-control" name="taxRate" id="taxRate" placeholder="Tax Rate">
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								<label>Tax Amount: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-append currency"><span class="input-group-text">$</span></div>
									<input value="<?php echo $invoiceValues['order_total_tax']; ?>" type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="Tax Amount">
								</div>
							</div>	
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">						
							<div class="form-group">
								<label>Total: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-append currency"><span class="input-group-text">$</span></div>
									<input value="<?php echo $invoiceValues['order_total_after_tax']; ?>" type="number" class="form-control" name="totalAftertax" id="totalAftertax" placeholder="Total">
								</div>
							</div>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								<label>Amount Paid: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-append currency"><span class="input-group-text">$</span></div>
									<input value="<?php echo $invoiceValues['order_amount_paid']; ?>" type="number" class="form-control" name="amountPaid" id="amountPaid" placeholder="Amount Paid">
								</div>
							</div>
							</div>
							<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								<label>Amount Due: &nbsp;</label>
								<div class="input-group">
									<div class="input-group-append currency"><span class="input-group-text">$</span></div>
									<input value="<?php echo $invoiceValues['order_total_amount_due']; ?>" type="number" class="form-control" name="amountDue" id="amountDue" placeholder="Amount Due">
								</div>
							</div>
							</div>
		     		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<br>
		      			<h3>Notes: </h3>
		      			<div class="form-group">
							<textarea class="form-control txt" rows="5" name="notes" id="notes" placeholder="Your Notes"><?php echo $invoiceValues['note']; ?></textarea>
						</div>
						
						
		      		</div>
					  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                         <h3>Status:</h3>
                         <div class="form-group">
                           <select name="status" id="status" class="form-control">
                              <option value="paid" <?php echo ($invoiceValues['status'] === 'paid') ? 'selected' : ''; ?>>Paid</option>
                              <option value="not_paid" <?php echo ($invoiceValues['status'] === 'not_paid') ? 'selected' : ''; ?>>Not Paid</option>
                           </select>
                         </div>
						 <br>
						 <div class="form-group">
							<input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
							<input type="hidden" value="<?php echo $invoiceValues['order_id']; ?>" class="form-control" name="invoiceId" id="invoiceId">
			      			<input data-loading-text="Updating Invoice..." type="submit" name="invoice_btn" value="Save Invoice" class="btn btn-success submit_btn invoice-save-btm">
							<br>
			      		</div>
						<br>
                    </div>
		      	</div>
				
		      	<div class="clearfix"></div>		      	
	      	</div>
		</form>	
    		</div>
    	</div>		
    </div>
</div>	
<?php include('footer.php');?>