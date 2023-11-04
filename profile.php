<?php
session_start();
if (isset($_SESSION['user'])){
    $uri = $_SERVER['REQUEST_URI']; // /user.php/username
    $ending = substr($uri, 13); // username
    $ending = urldecode($ending);

    if($_SESSION['user'] !== $ending){
        header('Location: ../profile.php/' . $_SESSION['user']);
    }

    require('./pdo.php');
    $statement = $pdo->prepare('SELECT username, description from users WHERE username = :ending');
    $statement->bindParam(':ending', $ending);
    $statement->execute();

    $response = $statement->fetchAll(PDO::FETCH_ASSOC);

    if ($response != null) {
        foreach($response as $item) {
            $username = htmlspecialchars($item['username']);
            $description = htmlspecialchars($item['description']);
        }    
?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>uri</title>

            <link rel="stylesheet" href="../main.css">
            <link rel="stylesheet" href="../profile.css">

            <script src="../_textarea.js" defer></script>
            <script src="../_modal.js" defer></script>

            <script src="../_theme-themes.js" defer></script>
            <script src="../_theme-colors.js" defer></script>
            <script src="../_theme-storage.js" defer></script>
            
            <script src="../profile.js" defer></script>

            <link rel="icon" type="image/png" href="./imgs/favicon.ico">
        </head>
        <body>
            <section>
                <h1><?= $username ?></h1>

                <form>
                    <fieldset>
                        <legend>Persönliche Angaben</legend>
                        <label for="description">Beschreibe dich</label>
                        <textarea name="description" id="description" autofocus><?= $description ?></textarea>
                        <button id="save-description">Beschreibung speichern</button>
                    </fieldset>
                </form>

                <p id="descrition-feedback"></p>

                <form>
                    <fieldset>
                        <legend>Passwort ändern</legend>
                        <label for="old-password">Altes Passwort</label>
                        <input type="password" name="old-password" id="old-password">
                        <label for="new-password">Neues Passwort</label>
                        <input type="password" name="new-password" id="new-password">
                        <div class='showPassword'>
                            <p>Passwörter anzeigen</p>
                            <input type="checkbox" class="toggle-input" id="toggle-password">
                            <label for="toggle-password" class="toggle-label" id="toggle-label"></label>
                        </div>
                        <button id="save-new-password">Neues Passwort speichern</button>
                    </fieldset>
                </form>

                <p id="password-feedback"></p>

                <form>
                    <fieldset class="danger">
                        <legend>Konto löschen</legend>
                        <p>Dieser Schritt ist unwiderruflich. Gelöscht wird nicht nur das Nutzerkonto, sondern alle damit verbundenen Beiträge.</p>
                        <button id="delete-account" class="danger"><span class="text">Konto löschen</span><span class="icon"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M280-120v-156.154q-36.693-15.461-66.193-40.5-29.5-25.038-50.384-57.192-20.885-32.154-32.154-69.308Q120-480.308 120-520q0-141.077 100.782-230.539Q321.564-840 479.936-840t259.218 89.461Q840-661.077 840-520q0 39.692-11.269 76.846t-32.154 69.308q-20.884 32.154-50.384 57.192-29.5 25.039-66.193 40.64V-120H280Zm40-40h56.923v-61.539h61.539V-160h83.076v-61.539h61.539V-160H640v-142q36.462-11.308 65.962-32.692 29.5-21.385 50.5-50.036 21.001-28.652 32.269-63.231Q800-482.538 800-520q0-125-88.5-202.5T480-800q-143 0-231.5 77.5T160-520q0 37.462 11.269 72.041 11.268 34.579 32.269 63.231 21 28.651 50.616 50.036Q283.769-313.308 320-302v142Zm107.692-200h104.616L480-464.615 427.692-360Zm-87.556-95.385q26.71 0 45.595-19.02 18.884-19.021 18.884-45.731t-19.02-45.595q-19.021-18.884-45.731-18.884t-45.595 19.02q-18.884 19.021-18.884 45.731t19.02 45.595q19.021 18.884 45.731 18.884Zm280 0q26.71 0 45.595-19.02 18.884-19.021 18.884-45.731t-19.02-45.595q-19.021-18.884-45.731-18.884t-45.595 19.02q-18.884 19.021-18.884 45.731t19.02 45.595q19.021 18.884 45.731 18.884ZM480-160Z"/></svg></span></button>
                    </fieldset>
                </form>

                <a href="../blog.php"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="m276.846-460 231.693 231.692L480-200 200-480l280-280 28.539 28.308L276.846-500H760v40H276.846Z"/></svg>zurück zur Hauptseite</a>
            </section>

            <div id="delete-modal" class="modal">

                <div id="delete-modal-inner" class="modal-inner">

                    <div id="delete-header" class="modal-header">
                        <button id="close-modal" class="modal-close link"><svg class="icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M256-213.847 213.847-256l224-224-224-224L256-746.153l224 224 224-224L746.153-704l-224 224 224 224L704-213.847l-224-224-224 224Z" /></svg></button>
                    </div>
                    <div class="modal-body">
                        <h2><?= $username ?> löschen</h2>
                        <p>Möchtest du das Konto wirklich unwiderruflich löschen?</p>
                        <button id="delete-account-confirmation" class="danger">Ja</button>
                    </div>

                </div>

            </div>

        </body>
    </html>
<?php
    } else {
        header('Location: ../user-not-found.php');
    }
} else {
    header("Location: ./index.php");
}
?>