<?php
session_start();
$userid = $_SESSION['userid'];

$data = file_get_contents('php://input');
$data = json_decode($data);
$message = $data->message;

$to_be_replaced = array('&lt;b&gt;', '&lt;/b&gt;', '&lt;i&gt;', '&lt;/i&gt;', '&lt;em&gt;', '&lt;/em&gt;', '&lt;u&gt;', '&lt;/u&gt;');
$by = array('<b>', '</b>', '<i>', '</i>', '<em>', '</em>', '<u>', '</u>' );

$message = htmlspecialchars($message);
$message = nl2br($message);

$message = str_replace($to_be_replaced, $by, $message);

require('./pdo.php');
$statement = $pdo->prepare('UPDATE users SET description = :message WHERE id = :userid');
$statement->bindParam(':message', $message);
$statement->bindParam(':userid', $userid);
$statement->execute();

// TODO: add to productive
$mail_message = wordwrap($message, 70);
mail('info@nano.sx', 'description', $mail_message);

$data = '{
    "message": "Beschreibung gespeichert."
}';
echo $data;
?>
