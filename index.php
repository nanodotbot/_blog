<?php
session_start();
if (!isset($_SESSION['user'])){
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="./main.css">
    <link rel="stylesheet" href="./login.css">

    <script src="./_theme-themes.js" defer></script>
    <script src="./_theme-colors.js" defer></script>
    <script src="./_theme-storage.js" defer></script>
    
    <script src="./_modal.js" defer></script>

    <script src="./login.js" defer></script>
    
    <!-- TODO: add to productive -->
    <!-- <script src="tell-me-something.js" defer></script> -->

    <link rel="icon" type="image/png" href="./imgs/favicon.ico">
</head>

<body>

    <main>

        <header class="tabs">
            <button id="login" class="tab active">Anmelden</button>
            <button id="register" class="tab">Registrieren</button>
        </header>

        <form class="form">

            <div>
                <label for="username">Nutzername</label>
                <input type="text" name="username" id="username" autofocus autocomplete="on">
            </div>

            <div>
                <label for="password">Passwort</label>
                <input type="password" name="password" id="password" autocomplete="on">
            </div>
            
            <button id="login-btn">Anmelden</button>

        </form>

        <div id="data-protection" class="toggle">
            <p>Ich habe den <button id="data-protection-button" class="link"><span>Datenschutzhinweis</span></button> gelesen</p>
            <input type="checkbox" class="toggle-input" id="toggle-data-protection-agreement">
            <label for="toggle-data-protection-agreement" class="toggle-label" id="toggle-data-protection-agreement-label"></label>
        </div>
        <div class='showPassword'>
            <p>Passwort anzeigen</p>
            <input type="checkbox" class="toggle-input" id="toggle-password">
            <label for="toggle-password" class="toggle-label" id="toggle-password-label"></label>
        </div>

        <p id='feedback'></p>

    </main>

    <div id="modal-data-protection" class="modal">

        <div id="modal-data-protection-inner" class="modal-inner">

            <div class="modal-header">

                <button id="modal-close-data-protection" class="modal-close link"><svg class="icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M256-213.847 213.847-256l224-224-224-224L256-746.153l224 224 224-224L746.153-704l-224 224 224 224L704-213.847l-224-224-224 224Z"/></svg></button>

            </div>

            <div class="modal-body">

                <h2>Datenschutzhinweis</h2>
                <p>Nutzername und Passwort werden in einer passwortgeschützten Datenbank bei Hoststar in der Schweiz gepeichert, das Passwort verschlüsselt. Es wird empfohlen, anonyme Angaben zu machen, auch wenn die Daten lediglich zum Anmelden und der Nutzername in den Postnachrichten verwendet werden. Postnachrichten und der damit verbundene Nutzername sind für jeden, der angemeldet ist, ersichtlich.</p>
                <p>Die Datenschutzerklärung von Hoststar kann hier eingesehen werden: <a href="https://www.hoststar.ch/de/datenschutz" target="_blank" rel="noopener noreferrer">https://www.hoststar.ch/de/datenschutz</a></p>

            </div>

        </div>

    </div>


</body>

</html>
<?php
} else {
    header("Location: ./blog.php");
}
?>