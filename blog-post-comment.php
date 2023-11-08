<?php
session_start();
$user = $_SESSION['user'];
$userid = $_SESSION['userid'];

$data = file_get_contents('php://input');
$data = json_decode($data);
$id = $data->id;
$message = $data->message;

$to_be_replaced = array('&lt;b&gt;', '&lt;/b&gt;', '&lt;i&gt;', '&lt;/i&gt;', '&lt;em&gt;', '&lt;/em&gt;', '&lt;u&gt;', '&lt;/u&gt;');
$by = array('<b>', '</b>', '<i>', '</i>', '<em>', '</em>', '<u>', '</u>' );

$message = htmlspecialchars($message);
$message = nl2br($message);

$message = str_replace($to_be_replaced, $by, $message);

require('./pdo.php');
$statement = $pdo->prepare('INSERT INTO comments (userid, postid, message) VALUES (:userid, :postid, :message)');
$statement->bindParam(':userid', $userid);
$statement->bindParam(':postid', $id);
$statement->bindParam(':message', $message);
$statement->execute();

// TODO: add to productive
$mail_message = wordwrap($message, 70);
mail('info@nano.sx', 'blog', $mail_message);

$data = '{
    "message": "Beitrag erfolgreich gepostet."
}';
$data = json_encode($data); // just to escape illegal characters
echo $data;
?>