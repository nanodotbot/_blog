<?php
session_start();
if (isset($_SESSION['user'])) {
?>
    <!DOCTYPE html>
    <html lang="de">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Blog</title>

        <link rel="stylesheet" href="./main.css">
        <link rel="stylesheet" href="./blog.css">
        
        <script src="./blog.js" defer></script>
        
        <script src="./_textarea.js" defer></script>
        <script src="./_modal.js" defer></script>

        <link rel="stylesheet" href="./_theme.css">
        <link rel="stylesheet" href="./_theme-color-picker.css">
        <script src="./_theme-modal-open.js" defer></script>
        <script src="./_theme-themes.js" defer></script>
        <script src="./_theme-colors.js" defer></script>
        <script src="./_theme-toggle.js" defer></script>
        <script src="./_theme-color-picker.js" defer></script>

        <link rel="icon" type="image/png" href="./imgs/favicon.ico">
    </head>

    <body>

        <header id="main-header">

            <a href="<?= './profile.php/' . urlencode($_SESSION['user']) ?>"><?= $_SESSION['user'] ?></a>
            <button id="logout" class="link"><span>Logout</span></button>
            <button id="open-modal" class="link"><svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M482.308-160q-133.334 0-226.667-93.333Q162.307-346.667 162.307-480q0-121.539 79.231-210.77Q320.769-780 437.693-796.154q3.23 0 6.346.231 3.115.23 6.115.692-20.231 28.231-32.038 62.808-11.808 34.577-11.808 72.423 0 106.667 74.667 181.333Q555.641-404 662.308-404q38.077 0 72.538-11.808 34.462-11.808 61.923-32.039.462 3 .693 6.116.231 3.115.231 6.346-15.385 116.923-104.616 196.154T482.308-160Zm0-40q88 0 158-48.5t102-126.5q-20 5-40 8t-40 3q-123 0-209.5-86.5t-86.5-209.5q0-20 3-40t8-40q-78 32-126.5 102t-48.5 158q0 116 82 198t198 82Zm-10-270Z" /></svg></button>

        </header>

        <main>

            <form>
                
                <div id="drop-area">
                    <label id="files-label" for="file-input">Bild hierher ziehen oder hier klicken</label>
                    <input id="file-input" name="file-input" type="file" accept="image/*" multiple>
                </div>

                <div id="preview">
                    <img id="preview-image" src="">
                </div>
                
                <div>
                    <label for="message">Nachricht</label>
                    <textarea class="textarea" name="message" id="message" autofocus></textarea>
                </div>

                <button id="send">Absenden</button>

            </form>
            <p id="message-feedback" class="textarea-feedback feedback"></p>

            <div id="posts">
                <?php 
                    require('./blog-get.php');
                    foreach ($response as $key => $value) {
                        $date = date_create($value['created_at']);
                        $date = date_format($date,"d.m.Y H:i:s");
                ?>
                    <div class="post">
                        <div class="meta">
                            <p class="meta-user">
                                <a href="./user.php/<?= urlencode($value['username']) ?>"><?= $value['username'] ?></a>
                            </p>
                            <div class="meta-right">
                                <p class="date"><?= $date ?></p>
                                <button class="link post-delete" data-id="<?= $value['id'] ?>" data-message="<?= $value['message'] ?>">
                                    <?php 
                                        if($_SESSION['user'] === $value['username']) {
                                    ?>
                                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" height="15" viewBox="0 -960 960 960" width="15"><path d="M304.615-160q-26.846 0-45.731-18.884Q240-197.769 240-224.615V-720h-40v-40h160v-30.77h240V-760h160v40h-40v495.385Q720-197 701.5-178.5 683-160 655.385-160h-350.77ZM680-720H280v495.385q0 10.769 6.923 17.692T304.615-200h350.77q9.23 0 16.923-7.692Q680-215.385 680-224.615V-720ZM392.307-280h40.001v-360h-40.001v360Zm135.385 0h40.001v-360h-40.001v360ZM280-720v520-520Z"/></svg>
                                    <?php 
                                    }
                                    ?>
                                </button>
                            </div>
                        </div>
                        <p><?= $value['message'] ?></p>
                    </div>
                    <hr>
                <?php 
                    }
                ?>
            </div>

        </main>

        <div id="theme-modal" class="modal">

            <div id="theme-modal-inner" class="modal-inner">

                <div id="theme-modal-header" class="modal-header">
                    
                    <button id="close-modal" class="modal-close link"><svg class="icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M256-213.847 213.847-256l224-224-224-224L256-746.153l224 224 224-224L746.153-704l-224 224 224 224L704-213.847l-224-224-224 224Z" /></svg></button>
                    
                </div>

                <div id="theme">

                    <h2>Farbschema</h2>
                    
                    <div class="theme-picker">

                        <div id="light">
                            <p>hell</p>
                        </div>
                        
                        <div>
                            <input type="checkbox" class="toggle-input" id="theme-toggle">
                            <label for="theme-toggle" class="toggle-label" id="theme-toggle-label"></label>
                        </div>
                        
                        <div id="dark">
                            <p>dunkel</p>
                        </div>
                        
                    </div>
                    
                    <div class="color-picker">
                        
                        <label for="blue" class="blue">
                            <input type="radio" name="color-picker" id="blue">
                        </label>
                        
                        <label for="green" class="green">
                            <input type="radio" name="color-picker" id="green">
                        </label>
                        
                        <label for="red" class="red">
                            <input type="radio" name="color-picker" id="red">
                        </label>
                        
                    </div>

                    <div id="theme-save-meta">

                        <p>Farbschema speichern</p>

                        <input type="checkbox" class="toggle-input" id="theme-save-toggle">
                        <label for="theme-save-toggle" class="toggle-label" id="theme-save-toggle-label"></label>

                    </div>
                    
                </div>

            </div>

        </div>

        <div id="delete-modal" class="modal">

            <div id="delete-modal-inner" class="modal-inner">

                <div id="delete-header" class="modal-header">
                    <button id="close-modal" class="modal-close link"><svg class="icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M256-213.847 213.847-256l224-224-224-224L256-746.153l224 224 224-224L746.153-704l-224 224 224 224L704-213.847l-224-224-224 224Z" /></svg></button>
                </div>
                <div class="modal-body">
                    <h2>Post löschen</h2>
                    <p id="post-info"></p>
                    <p>Möchtest du diesen Post wirklich unwiderruflich löschen?</p>
                    <button id="delete-post-confirmation" class="danger">Ja</button>
                </div>

            </div>

        </div>

    </body>

    </html>
<?php
} else {
    header("Location: ./index.php");
}
?>