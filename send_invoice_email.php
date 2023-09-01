<?php
require 'path_to/tcpdf_library/tcpdf.php'; // Replace with the path to TCPDF library
require 'path_to/PHPMailer/PHPMailerAutoload.php'; // Replace with the path to PHPMailer

$invoiceId = $_POST['invoice_id'];
$recipientEmail = $_POST['recipient_email'];

// Retrieve invoice details based on $invoiceId
// ...

$pdf = new TCPDF();
$pdf->AddPage();
// Add content to the PDF (e.g., invoice details)
// ...

// Save the PDF to a temporary file
$pdfPath = 'path_to_temporary_pdf_file.pdf';

$mail = new PHPMailer();
// Configure PHPMailer settings
// ...

$mail->setFrom('your_email@example.com', 'Your Name');
$mail->addAddress($recipientEmail);
$mail->Subject = 'Invoice for Order #' . $invoiceId;
$mail->Body = 'Please find attached the invoice for your recent order.';
$mail->addAttachment($pdfPath, 'invoice.pdf');

if ($mail->send()) {
    // Email sent successfully
    header("Location: invoice_list.php");
    exit;
} else {
    // Email sending failed
    echo 'Email could not be sent. Error: ' . $mail->ErrorInfo;
}
?>
