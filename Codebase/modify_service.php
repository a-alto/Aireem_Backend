<?php
session_start();

if(!isset($_SESSION["usrID"]) || empty($_SESSION["usrID"]))
{
    header('Location:login.php');
    exit();
}

include("connection.php");
include("logged-user-navbar.php");

/* in get arriverà l'id del servizio da modificare. Eseguire una query al DB e controllare che l'utente offerente tale servizio sia effettivamente
l'utente loggato in sessione (questo tramite il confronto degli usrID) */

?>
<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="favicon.ico">
        <title>Aireem - Modifica servizio</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="custom/css/custom-css.css" rel="stylesheet">
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="under-navbar-body">
        <!-- navbar menu -->
        <?php echo $NAVBAR; ?>
        
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3'>
                    <div class='alert alert-warning' role='alert'><strong>Siamo spiacenti.</strong> Non è ancora possibile modificare le offerte :(</div>
                </div>
            </div>
        </div>
        
        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
