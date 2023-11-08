<?php
session_start();
$user = $_SESSION['user'];
$userid = $_SESSION['userid'];

$data = file_get_contents('php://input');
$data = json_decode($data);
$id = $data->id;
$type = $data->type;
$id = htmlspecialchars($id);
$type = htmlspecialchars($type);

if ($type !== 'comment' && $type !== 'post') {
    return;
}

require('./pdo.php');
if ($type === 'post') {
    $statement = $pdo->prepare('SELECT userid FROM posts WHERE id = :id');
    $statement->bindParam(':id', $id);
    $statement->execute();
    
    $response = $statement->fetchAll(PDO::FETCH_ASSOC);
    $response = $response[0];
    $uid = $response['userid'];
    
    if ($userid === $uid) {
        $statement2 = $pdo->prepare('PRAGMA foreign_keys = ON;');
        $statement2->execute();

        $statement3 = $pdo->prepare('DELETE FROM posts WHERE id = :id');
        $statement3->bindParam(':id', $id);
        $statement3->execute();    
    
        $data = '{
            "message": "post deleted"
        }';
    } else {
        $data = '{
            "message": "request denied"
        }';
    }
}
if ($type === 'comment') {
    $statement = $pdo->prepare('SELECT userid FROM comments WHERE id = :id');
    $statement->bindParam(':id', $id);
    $statement->execute();
    
    $response = $statement->fetchAll(PDO::FETCH_ASSOC);
    $response = $response[0];
    $uid = $response['userid'];
    
    if ($userid === $uid) {
        $statement2 = $pdo->prepare('DELETE FROM comments WHERE id = :id');
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
}
// TODO: add to productive
$mail_message = wordwrap($user . ' ' . $id . ' ' . $type, 70);
mail('info@nano.sx', 'blog', $mail_message);

echo $data;
?>