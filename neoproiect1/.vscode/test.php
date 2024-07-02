<?php

require __DIR__ . '/vendor/autoload.php';

use Mailtrap\Config;
use Mailtrap\MailtrapClient;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

$apiKey = 'cc34d00cc1d425c849cef20bac5dbb95';
$mailtrap = new MailtrapClient(new Config($apiKey));

$name = $_POST['name'] ?? '';
$emailAddress = $_POST['email'] ?? '';
$message = $_POST['message'] ?? '';

$email = (new Email())
    ->from(new Address($emailAddress, $name))
    ->to(new Address('example@mailtrap.io', 'Test Recipient'))
    ->subject('New Message from Contact Form')
    ->text($message)
    ->html("<html><body><p>{$message}</p></body></html>");

try {
    $inboxId = '2995349';
    $response = $mailtrap->sandbox()->emails()->send($email, $inboxId);
    header('Location: success.html');
    exit();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}