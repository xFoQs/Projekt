<?php


        session_start();

?>


<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="author" content="Łukasz Flisak, Michał Kornak, Kamil Grocholski">
    <title>Panel admina</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="/src/static/admin/css/style.css">
</head>

<body>

    <div class="columns my-hero">
        <div class="column is-one-fifth">

            <nav class="panel">
                <p class="panel-heading">Biblioteka</p>
                <p class="panel-tabs">
                    <a data-group="tables" class="is-active">Tabele</a>
                    <a data-group="views">Widoki</a>
                    <a data-group="queries">Kwerendy</a>
                </p>
            </nav>
        </div>
        <div class="column">
            <div class="tabs">
                <ul>
                    <li data-view="queries" class="invisible"><a>Tworzenie</a></li>
                    <li data-view="sql" class="invisible"><a>SQL</a></li>
                    <li data-view="preview" class="is-active"><a>Podgląd</a></li>
                    <li data-view="preview">
                        <?php
                            echo '<a href="logaut.php">Wyloguj</a>';
                        ?>
                        
                    </li>
                </ul>
            </div>
            <div>
                <div class="buttons flex-end">
                    <button id="import-btn" class="button is-warning">Import</button>
                    <button class="export-toggle button is-primary">Export</button>
                </div>

                <div class="view" id="preview"></div>
                <div class="view invisible" id="queries"></div>
                <div class="view invisible" id="sql"></div>
            </div>
        </div>
    </div>

    <div class="message-wrapper invisible">
        <article class="message my-message">
            <div class="message-header">
                <p>Eksportowanie danych</p>
                <button class="delete export-toggle" aria-label="delete"></button>
            </div>
            <div class="message-body">
                <div>
                    <label for="filename">Nazwa pliku</label>
                    <input name="filename" class="input" type="text" placeholder="np. autorzy, czytelnicy">
                </div>
                <div>
                    <label for="separator">Separator kolumn</label>
                    <input name="separator" class="input" type="text" value=",">
                </div>
                <div>
                    <label class="checkbox">
                        <input name="headers" checked type="checkbox"> Dołącz nazwy kolumn
                    </label>
                </div>
                <button id="export-btn" class="button">Eksportuj</button>
                <div class="invisible" id="download-link">
                    Kliknij <a class="has-text-primary has-text-weight-bold" download href="">tutaj</a> aby pobrać dane
                </div>
            </div>
        </article>
    </div>

    <script src="/src/static/admin/js/database.js"></script>
    <script src="/src/static/admin/js/table.js"></script>
    <script src="/src/static/admin/js/filter.js"></script>
    <script src="/src/static/admin/js/ui.js"></script>
</body>

</html>