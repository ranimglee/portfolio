<?php

// Allow requests from any origin
header("Access-Control-Allow-Origin: *");

// Allow specific methods (POST, GET, OPTIONS)
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// Allow specific headers
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200); // Respond to preflight with a 200 OK
    exit();
}


// Replace contact@example.com with your real receiving email address
$receiving_email_address = 'ranim.abassi20@gmail.com';

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

// SMTP configuration
$contact->smtp = array(
    'host' => 'smtp.gmail.com',
    'username' => 'ranim.abassi20@gmail.com',
    'password' => getenv('GMAIL_PASSWORD'), // Use an environment variable
    'port' => '587' // Change to '465' if using SSL
);

$contact->add_message($_POST['name'], 'From');
$contact->add_message($_POST['email'], 'Email');
$contact->add_message($_POST['message'], 'Message', 10);

echo $contact->send();
?>
