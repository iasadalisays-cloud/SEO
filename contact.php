<?php
// Simple PHP backend to send contact form emails

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.html');
    exit;
}

function field($name) {
    return isset($_POST[$name]) ? trim($_POST[$name]) : '';
}

$name    = field('Name');
$email   = field('Email');
$company = field('Company');
$website = field('Website');
$service = field('Service');
$message = field('Message');

// Basic validation: require email and message
if ($email === '' || $message === '') {
    header('Location: contact.html?sent=0');
    exit;
}

$to      = 'iasadalisays@gmail.com';
$subject = 'New SEO inquiry'
    . ($company !== '' ? ' - ' . $company : '')
    . ($name !== '' ? ' (from ' . $name . ')' : '');

$bodyLines = [
    "Name: " . ($name !== '' ? $name : '-'),
    "Email: " . ($email !== '' ? $email : '-'),
    "Company: " . ($company !== '' ? $company : '-'),
    "Website: " . ($website !== '' ? $website : '-'),
    "Service: " . ($service !== '' ? $service : '-'),
    "",
    "Message:",
    $message !== '' ? $message : '-',
];

$body = implode("\r\n", $bodyLines);

// IMPORTANT: change "no-reply@yoursite.com" to an email at your own domain
$headers   = "From: SEO Contact <no-reply@yoursite.com>\r\n";
$headers  .= "Reply-To: " . $email . "\r\n";
$headers  .= "Content-Type: text/plain; charset=UTF-8\r\n";

$sent = @mail($to, $subject, $body, $headers);

// Redirect back with status flag
$status = $sent ? '1' : '0';
header('Location: contact.html?sent=' . $status);
exit;

