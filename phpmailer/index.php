<?php
// Include the required PHPMailer files
require '../vendor/autoload.php'; // This includes the Composer autoloader
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

// Define namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf; // Add this line for the Dompdf use statement

// Include your Invoice.php file and create an instance of the Invoice class
require '../Invoice.php';
$invoice = new Invoice();


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

// Get the invoice ID from the URL parameter
$invoiceId = isset($_GET['invoice_id']) ? $_GET['invoice_id'] : null;

if ($invoiceId !== null) {
    // Get invoice details
    $invoiceValues = $invoice->getInvoice($invoiceId);
    $invoiceItems = $invoice->getInvoiceItems($invoiceId);


// Generate the invoice PDF content using Dompdf
$dompdf = new Dompdf();



$invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceValues['order_date']));
$output = '';
$output = '<table width="100%" border="1" cellpadding="5" cellspacing="0">
    <tr>
        <td colspan="2" align="center" style="font-size:18px"><b>Invoice</b></td>
    </tr>
    <tr>
        <td colspan="2">
            <table width="100%" cellpadding="5">
                <tr>
                    <td width="60%" align="left">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <h3>From,</h3>
                            ' . $_SESSION['user'] . '<br>
                            ' . $_SESSION['address'] . '<br>
                            ' . $_SESSION['mobile'] . '<br>
                            ' . $_SESSION['email'] . '<br>
                        </div>
                    </td>
                    <td width="50%" align="left">
					<br>
                        <b>RECEIVER (BILL TO)</b><br>
						<br>
                        Name : ' . $invoiceValues['order_receiver_name'] . '<br>
                        Billing Address : ' . $invoiceValues['order_receiver_address'] . '<br>
						<br>
						<br>
                        Invoice No. : ' . $invoiceValues['order_id'] . '<br>
                        Invoice Date : ' . $invoiceDate . '<br>
                    </td>
                </tr>
            </table>
            <br>
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th align="left">Sr No.</th>
                    <th align="left">Item Code</th>
                    <th align="left">Item Name</th>
                    <th align="left">Quantity</th>
                    <th align="left">Price</th>
                    <th align="left">Actual Amt.</th>
                </tr>';
$count = 0;  
foreach($invoiceItems as $invoiceItem){
	$count++;
	$output .= '
	<tr>
	<td align="left">'.$count.'</td>
	<td align="left">'.$invoiceItem["item_code"].'</td>
	<td align="left">'.$invoiceItem["item_name"].'</td>
	<td align="left">'.$invoiceItem["order_item_quantity"].'</td>
	<td align="left">'.$currencySymbols[$invoiceValues["currency_n"]] .$invoiceItem["order_item_price"].'</td>
	<td align="left">'.$currencySymbols[$invoiceValues["currency_n"]] .$invoiceItem["order_item_final_amount"].'</td>   
	</tr>';
}
$output .= '
	<tr>
	<td align="right" colspan="5"><b>Sub Total</b></td>
	<td align="left"><b>'.$currencySymbols[$invoiceValues["currency_n"]] .$invoiceValues['order_total_before_tax'].'</b></td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>Tax Rate :</b></td>
	<td align="left">%'.$invoiceValues['order_tax_per'].'</td>
	</tr>
	<tr>
	<td align="right" colspan="5">Tax Amount: </td>
	<td align="left">'.$currencySymbols[$invoiceValues["currency_n"]] .$invoiceValues['order_total_tax'].'</td>
	</tr>
	<tr>
	<td align="right" colspan="5">Total: </td>
	<td align="left">'.$currencySymbols[$invoiceValues["currency_n"]] .$invoiceValues['order_total_after_tax'].'</td>
	</tr>
	<tr>
	<td align="right" colspan="5">Amount Paid:</td>
	<td align="left">'.$currencySymbols[$invoiceValues["currency_n"]] .$invoiceValues['order_amount_paid'].'</td>
	</tr>
	<tr>
	<td align="right" colspan="5"><b>Amount Due:</b></td>
	<td align="left">'.$currencySymbols[$invoiceValues["currency_n"]] .$invoiceValues['order_total_amount_due'].'</td>
	</tr>
';

$output .= '<tr>
    <td colspan="6"><b>Notes:</b><br />' . nl2br($invoiceValues['note']) . '</td>
</tr>';

// Add the image at the bottom
$imageData = base64_encode(file_get_contents('invoicify.png'));
$imageSrc = 'data:image/png;base64,' . $imageData;

$output .= '<tr>
    <td colspan="6"><img src="' . $imageSrc . '" style="width: 100%; max-width: 100px; margin-top: 300px;"></td>
</tr>';

$output .= '</table></td></tr></table>'; // Close the table structure



$dompdf->loadHtml($output);
$dompdf->setPaper('A4', 'portrait'); // Change to portrait if needed
$dompdf->render();

// Get the recipient's name and email from the database
$recipientName = $invoiceValues['order_receiver_name'];

    // Create instance of PHPMailer
    $mail = new PHPMailer();

// Set mailer to use SMTP
$mail->isSMTP();

// Define SMTP host
$mail->Host = "smtp.gmail.com";

// Enable SMTP authentication
$mail->SMTPAuth = true;

// Set SMTP encryption type (ssl/tls)
$mail->SMTPSecure = "tls";

// Port to connect SMTP
$mail->Port = "587";

// Set Gmail username
$mail->Username = "contact.invoicify@gmail.com";

// Set Gmail password
$mail->Password = "pbzvvauneagcykpg";

// Set email subject
$mail->Subject = "Invoice";

// Set sender email
$mail->setFrom('contact.invoicify@gmail.com');

// Enable HTML in the email body
$mail->isHTML(true);



// Add recipient
$mail->addAddress($recipientName);
$mail->Body = '<html><body>';
$mail->Body .= '<p>Invoice from <strong>' . $_SESSION['email'] . '</strong></p>';
$mail->Body .= '<p>to <strong>' . $recipientName . '</strong></p>';
$mail->Body .= '<br>';
$mail->Body .= '<br>';
$mail->Body .= '<p>Unlock Efficiency with Invoicify - Your Smart Invoice System, <a href="http://localhost/invoice-system-php/signup.php"><strong>try it now</strong></a>.</p>';
$mail->Body .= '</body></html>';

    // Attachment - Attach the generated PDF invoice
    $pdfContent = $dompdf->output(); // Assuming you have $dompdf initialized
    $invoiceFileName = 'AstroInvoice_' . $invoiceValues['order_id'] . '.pdf';
    $mail->addStringAttachment($pdfContent, $invoiceFileName, 'base64', 'application/pdf');

    // Rest of your PHPMailer email configuration here...

    // Finally send the email
    if ($mail->send()) {
		echo '<script>alert("Email sent successfully ."); window.location.href = "../invoice_list.php";</script>';		
	    } else {
			echo '<script>alert("email has not been sent X."); window.location.href = "../invoice_list.php";</script>';		
    }
} else {
    echo "Invoice ID not provided.";
}
?>


