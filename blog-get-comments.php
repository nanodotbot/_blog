<?php 
require('./pdo.php');
$statement = $pdo->prepare('SELECT comments.*, users.username FROM comments INNER JOIN users ON comments.userid = users.id ORDER BY created_at ASC');
$statement->execute();

$comment = $statement->fetchAll(PDO::FETCH_ASSOC);
?>