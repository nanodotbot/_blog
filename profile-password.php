<?php
session_start();
$user = $_SESSION['user'];
$userid = $_SESSION['userid'];

$data = file_get_contents('php://input');
$data = json_decode($data);
$oldpw = $data->oldpw;
$newpw = $data->newpw;
$oldpw = htmlspecialchars($oldpw);
$newpw = htmlspecialchars($newpw);

require('./pdo.php');

$statement = $pdo->prepare('SELECT * FROM users WHERE id = :userid');
$statement->bindParam(':userid', $userid);
$statement->execute();

$response = $statement->fetchAll(PDO::FETCH_ASSOC);
$count = $statement->rowCount();

if ($response != null) {
    foreach($response as $item) {
        if(password_verify($oldpw, $item['password'])){
            $newpw = password_hash($newpw, PASSWORD_DEFAULT);
            $statement = $pdo->prepare('UPDATE users SET password = :password WHERE id = :userid');
            $statement->bindParam(':password', $newpw);
            $statement->bindParam(':userid', $userid);
            $statement->execute();
        
            $message = 'Passwort geändert.';
            $json = '{
                "message": "' . $message . '"
            }';
            echo $json;        
        } else {
            $message = 'Bitte Eingaben prüfen.';
            $json = '{
                "message": "' . $message . '"
            }';
            echo $json;        
        }
    }
} else {
    $message = 'Bitte Eingaben prüfen.';
    $json = '{
        "message": "' . $message . '"
    }';
    echo $json;
}
?>
