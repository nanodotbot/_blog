<?php
session_start();
$user = $_SESSION['user'];
$userid = $_SESSION['userid'];

require('./pdo.php');
$statement1 = $pdo->prepare('PRAGMA foreign_keys = ON;');
$statement1->execute();
$statement2 = $pdo->prepare('DELETE FROM users WHERE id = :userid;');
$statement2->bindParam(':userid', $userid);
$statement2->execute();

$message = $user . ' destroyed.';

// TODO: add to productive
$mail_message = wordwrap($message, 70);
mail('info@nano.sx', 'blog', $mail_message);

session_unset();
session_destroy();

$data = '{
    "message": "' . $message . '"
}';
echo $data;
?>