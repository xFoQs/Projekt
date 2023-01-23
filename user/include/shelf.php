<?php
    include('connection.php');
?>

<div class="container" id="div1">
    <div class="container" id="order">
        <form action="" method="GET">
            <input class="button mb-2 has-text-centered" style="width: 10%;" id="wypo" type="hidden" name="scr" value="zamowiono"/>
            <input class="button mb-2 has-text-centered" style="width: 10%;" value="Zamów" type="submit" name='cookie' onClick="cs()">
        </form>
    </div>

<?php
    echo "<script type='text/javascript'>pokaz();</script>";
?>
</div>