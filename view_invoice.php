<?php
// Start the session
session_start();

// Include necessary files
require 'TCPDF-main/tcpdf.php';
require 'Invoice.php';

// Create an instance of the Invoice class
$invoice = new Invoice();

// Check if invoice_id is provided in the URL
if (!empty($_GET['invoice_id'])) {
    // Retrieve invoice details and items
    $invoiceId = $_GET['invoice_id'];
    $invoiceValues = $invoice->getInvoice($invoiceId);
    $invoiceItems = $invoice->getInvoiceItems($invoiceId);

    // Generate the HTML content for the invoice details table
    $output = '<table width="100%" border="1" cellpadding="5" cellspacing="0">';
    // Add invoice details and items
    $output = '<table width="100%" border="1" cellpadding="5" cellspacing="0">';
    $output .= '<tr>
        <td colspan="2" align="center" style="font-size:18px"><b>Invoice</b></td>
        </tr>
        <tr>
        <td colspan="2">
        <table width="100%" cellpadding="5">
        <tr>
        <td width="65%">
        To,<br />
        <b>RECEIVER (BILL TO)</b><br />
        Name : ' . $invoiceValues['order_receiver_name'] . '<br /> 
        Billing Address : ' . $invoiceValues['order_receiver_address'] . '<br />
        </td>
        <td width="35%">         
        Invoice No. : ' . $invoiceValues['order_id'] . '<br />
        Invoice Date : ' . $invoiceValues['order_date'] . '<br />
        </td>
        </tr>
        </table>
        <br />
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
    foreach ($invoiceItems as $invoiceItem) {
        $count++;
        $output .= '<tr>
        <td align="left">' . $count . '</td>
        <td align="left">' . $invoiceItem["item_code"] . '</td>
        <td align="left">' . $invoiceItem["item_name"] . '</td>
        <td align="left">' . $invoiceItem["order_item_quantity"] . '</td>
        <td align="left">' . $invoiceItem["order_item_price"] . '</td>
        <td align="left">' . $invoiceItem["order_item_final_amount"] . '</td>   
        </tr>';
    }
    
// Calculate sub-total, tax, total, and other details
$subTotal = 0;
$taxAmount = $invoiceValues['order_total_tax'];
$totalAfterTax = $invoiceValues['order_total_after_tax'];
$amountPaid = $invoiceValues['order_amount_paid'];
$amountDue = $invoiceValues['order_total_amount_due'];

foreach ($invoiceItems as $invoiceItem) {
    $subTotal += $invoiceItem["order_item_final_amount"];
}

$output .= '<tr>
    <td align="right" colspan="5"><b>Sub Total</b></td>
    <td align="left"><b>' . $subTotal . '</b></td>
    </tr>
    <tr>
    <td align="right" colspan="5"><b>Tax Rate :</b></td>
    <td align="left">' . $invoiceValues['order_tax_per'] . '</td>
    </tr>
    <tr>
    <td align="right" colspan="5">Tax Amount: </td>
    <td align="left">' . $taxAmount . '</td>
    </tr>
    <tr>
    <td align="right" colspan="5">Total: </td>
    <td align="left">' . $totalAfterTax . '</td>
    </tr>
    <tr>
    <td align="right" colspan="5">Amount Paid:</td>
    <td align="left">' . $amountPaid . '</td>
    </tr>
    <tr>
    <td align="right" colspan="5"><b>Amount Due:</b></td>
    <td align="left">' . $amountDue . '</td>
    </tr>';

$output .= '</table>';
$output .= '</td>
    </tr>
    </table>';
;
    

    // Create a new TCPDF instance
    $pdf = new TCPDF();
    $pdf->AddPage();

    // Set font and add title to the PDF
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Invoice', 0, 1, 'C');

    // Add the generated HTML content to the PDF
    $pdf->SetFont('helvetica', '', 12);
    $pdf->writeHTML($output, true, false, true, false, '');

    // Output the PDF
    $pdf->Output('invoice.pdf', 'I'); // Display PDF inline
} else {
    echo "Invoice ID not provided.";
}
?>
