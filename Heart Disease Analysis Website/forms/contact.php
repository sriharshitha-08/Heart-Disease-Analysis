<?php
// Replace contact@example.com with your real receiving email address
$receiving_email_address = 'abc@gmail.com';

require 'path_to_phpmailer/PHPMailerAutoload.php';
require 'PHPMailer/PHPMailerAutoload.php';
if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);
} else {
    die('Unable to load the "PHP Email Form" Library!');
}

$contact = new PHP_Email_Form;
$contact->ajax = true;

$contact->to = $receiving_email_address;
$contact->from_name = $_POST['name'];
$contact->from_email = $_POST['email'];
$contact->subject = $_POST['subject'];

// Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials

$contact->smtp = array(
    'host' => 'smtp.gmail.com',
    'username' => '', // Your Gmail username
    'password' => '', // Your Gmail password
    'port' => 587
);

$contact->add_message($_POST['name'], 'From');
$contact->add_message($_POST['email'], 'Email');
$contact->add_message($_POST['message'], 'Message', 10);

// Send the email using PHPMailer
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = $contact->smtp['host'];
$mail->SMTPAuth = true;
$mail->Username = $contact->smtp['username'];
$mail->Password = $contact->smtp['password'];
$mail->SMTPSecure = 'tls';
$mail->Port = $contact->smtp['port'];
$mail->setFrom($contact->from_email, $contact->from_name);
$mail->addAddress($contact->to);
$mail->Subject = $contact->subject;
$mail->Body = $contact->message;
$mail->isHTML(false);

if ($mail->send()) {
    echo 'Email sent successfully';
} else {
    echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
}
?>
