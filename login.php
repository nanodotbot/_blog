<?php 
$data = file_get_contents('php://input');
$data = json_decode($data, true);

$username = $data['username'];
$password = $data['password'];

$username = htmlspecialchars($username);
$password = htmlspecialchars($password);

require './pdo.php';

$statement = $pdo->prepare('SELECT * FROM users WHERE username = :username');
$statement->bindParam(':username', $username);
$statement->execute();

$response = $statement->fetchAll(PDO::FETCH_ASSOC);
$count = $statement->rowCount();

$message = '';

if ($response != null) {
    foreach($response as $item) {
        $userid = $item['id'];
        $user = htmlspecialchars($item['username']);
        $description = htmlspecialchars($item['description']);
        if(password_verify($password, $item['password'])){
            session_start();
            $_SESSION['user'] = $user;
            $_SESSION['userid'] = $userid;
            $_SESSION['description'] = $description;
        
            $message = 'Erfolgreich eingeloggt.';
        } else {
            $message = 'Benutzername oder Passwort unbekannt.';
        }
    }
} else {
    $message = 'Benutzername oder Passwort unbekannt.';
}
$json = '{
    "message": "' . $message . '"
}';
echo $json;        
?>