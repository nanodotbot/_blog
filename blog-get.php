<?php 
require('./pdo.php');
$statement = $pdo->prepare('SELECT posts.*, users.username FROM posts INNER JOIN users ON posts.userid = users.id ORDER BY created_at DESC');
$statement->execute();

$response = $statement->fetchAll(PDO::FETCH_ASSOC);
?>