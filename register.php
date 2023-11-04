<?php 
$data = file_get_contents('php://input');
$data = json_decode($data, true);

$username = $data['username'];
$password = $data['password'];

$username = htmlspecialchars($username);
$password = htmlspecialchars($password);
$password = password_hash($password, PASSWORD_DEFAULT);

require './pdo.php';

try {
    $statement = $pdo->prepare('INSERT INTO users (username, password) VALUES (:username, :password)');
    $statement->bindParam(':username', $username);
    $statement->bindParam(':password', $password);
    $statement->execute();
    $message = 'Erfolgreich registriert. Bitte melde dich an.';
} catch (PDOException $e) {
    if (strpos($e->getMessage(),'UNIQUE constraint failed')){
        $message = 'Benutzername ist bereits vergeben.';
    } else {
        $message = 'Ein unbekannter Fehler ist aufgetreten.';
    }
}

$json = '{
    "message": "' . $message . '"
}';
echo $json;
?>