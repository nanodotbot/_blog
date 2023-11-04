<?php
session_start();
$user = $_SESSION['user'];
$userid = $_SESSION['userid'];

$data = file_get_contents('php://input');
$data = json_decode($data);
$id = $data->id;
$id = htmlspecialchars($id);

require('./pdo.php');
$statement = $pdo->prepare('SELECT userid FROM posts WHERE id = :id');
$statement->bindParam(':id', $id);
$statement->execute();

$response = $statement->fetchAll(PDO::FETCH_ASSOC);
$response = $response[0];
$uid = $response['userid'];

if ($userid === $uid) {
    $statement2 = $pdo->prepare('DELETE FROM posts WHERE id = :id');
    $statement2->bindParam(':id', $id);
    $statement2->execute();    

    $data = '{
        "message": "post deleted"
    }';
} else {
    $data = '{
        "message": "request denied"
    }';
}
echo $data;

// TODO: add to productive
// $mail_message = wordwrap($message, 70);
// mail('info@nano.sx', 'blog', $mail_message);
?>