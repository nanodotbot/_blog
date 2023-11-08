<?php
session_start();
$user = $_SESSION['user'];
$userid = $_SESSION['userid'];

$message = $_POST['message'] ?? '';

$to_be_replaced = array('&lt;b&gt;', '&lt;/b&gt;', '&lt;i&gt;', '&lt;/i&gt;', '&lt;em&gt;', '&lt;/em&gt;', '&lt;u&gt;', '&lt;/u&gt;');
$by = array('<b>', '</b>', '<i>', '</i>', '<em>', '</em>', '<u>', '</u>' );

$message = htmlspecialchars($message);
$message = nl2br($message);

$message = str_replace($to_be_replaced, $by, $message);

$file = $_FILES['file'] ?? '';
$file_name = $file['name'] ?? '';
$file_name_tmp = $file['tmp_name'] ?? '';
$file_size = $file['size'] ?? '';
$file_name_new = '';

if($file) {

    if($file_size > 15000000) {
        $message = 'Derzeit sind nur Dateigrössen bis zu 15 Megabyte erlaubt.';
        echo '{"message": "'. $message . '"}';
        return;
    }
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif', 'bmp', 'ico', 'svg', 'webp');
    $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // for debugging purposes
    // echo json_encode(array('message' => $file_extension));
    // exit();

    if (!in_array($file_extension, $allowed_extensions)){
        $message = 'Derzeit sind nur bestimmte Bildtypen erlaubt: jpg, jpeg, png, gif, bmp, ico, svg, webp';
        echo '{"message": "'. $message . '"}';
        return;
    }

    // if (preg_match('/jpg|jpeg/i', $file_extension)){
    //     $file = imagecreatefromjpeg($file);
    // } else if (preg_match('/png/i', $file_extension)) {
    //     $file = imagecreatefrompng( $file);
    // } else if (preg_match('/gif/i', $file_extension)) {
    //     $file = imagecreatefromgif($file);
    // } else if (preg_match('/bmp/i', $file_extension)) {
    //     $file = imagecreatefrombmp($file);
    // }    

    $file_name_new = uniqid('', true).".".$file_extension;
    $file_destination = './media/' . $file_name_new;
    move_uploaded_file($file_name_tmp, $file_destination);
}

require('./pdo.php');
$statement = $pdo->prepare('INSERT INTO posts (userid, message, picture) VALUES (:userid, :message, :picture)');
$statement->bindParam(':userid', $userid);
$statement->bindParam(':message', $message);
$statement->bindParam(':picture', $file_name_new);
$statement->execute();

// TODO: add to productive
$mail_message = wordwrap($message, 70);
mail('info@nano.sx', 'blog', $mail_message);

$data = '{"message": "Beitrag erfolgreich gepostet."}';
$data = json_encode($data); // just to escape illegal characters
echo $data;
?>