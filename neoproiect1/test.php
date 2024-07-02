<?php

require __DIR__ . '/vendor/autoload.php';

use Mailtrap\Config;
use Mailtrap\MailtrapClient;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

// Initialize Mailtrap Client
$apiKey = 'cc34d00cc1d425c849cef20bac5dbb95'; // Replace with your Mailtrap API Key
$mailtrap = new MailtrapClient(new Config($apiKey));

// Get form data
$name = $_POST['name'] ?? '';
$emailAddress = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

// Compose email
$email = (new Email())
    ->from(new Address('bardadarius6@gmail.com', $name))
    ->to(new Address('example@mailtrap.io', 'Test Recipient')) // Replace with your Mailtrap email address
    ->subject('New Message from Contact Form')
    ->text($message)
    ->html("<html><body><p>{$message}</p></body></html>");

// Send email and inspect response
try {
    $inboxId = '2995349'; // Replace with your Mailtrap Inbox ID
    $response = $mailtrap->sandbox()->emails()->send($email, $inboxId);

    echo 'Email has been sent!';
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}