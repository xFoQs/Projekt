<!DOCTYPE html>
<html lang="pl">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <meta name="author" content="Michał Kornak">
        <title>Strona użytkownika</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
        <link rel="stylesheet" href="../static/user/css/style.css">
        <script src="./js/shelf-functions.js"></script>
        <script src="./js/jquery-3.6.0.js"></script>
        <script src="./js/jq-functions.js"></script>

    </head>
    <body>
        
            <?php include('../user/include/header.php');?>

<!-- <div class="container mb-3 mt-3"> -->
            <div class="container" id="mainDiv">
                <?php include('../user/include/functions/changeInclude.php');?>
            </div>

            <div class="stack" id='jqmw'>

            </div>

            <?php include('../user/include/footer.php');?>
        
    </body>
    </html>
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>