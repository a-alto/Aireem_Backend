<?php
    session_start();
    
    $errorcode=0;
    $error="";
    $errorinfo="";
    
    if(isset($_SESSION["usrID"]) && !empty($_SESSION["usrID"]))
    {
        include("logged-user-navbar.php");
    }
    else
    {
        include("visitor-navbar.php");
    }
    
    if(isset($_SESSION["error"]) && isset($_SESSION["errorinfo"]) && !empty($_SESSION["error"]) && !empty($_SESSION["errorinfo"]))
    {
        $errorcode=$_SESSION["errorcode"];
        $error=$_SESSION["error"];
        $errorinfo=$_SESSION["errorinfo"];
        
        // unset error in SESSION
        unset($_SESSION["errorcode"]);
        unset($_SESSION["error"]);
        unset($_SESSION["errorinfo"]);
    }
    else
    {
        header('Location:/');
        exit();
    }
?>
<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="favicon.ico">
        <title>Aireem - Errore</title>
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
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
                    <div class="alert alert-danger" role="alert">
                        <img src="images/error.png" class="img-responsive img-circle center-block" width="150" heigth="150" alt="ERROR">
                        <br>
                        <strong><h1 class="text-center"><?php echo $error; ?></h1></strong>
                        <br>
                        <a href="#" class="alert-link" data-toggle="collapse" data-target="#info">Più informazioni</a>
                        <br>
                        <div id="info" class="collapse">
                            <p class="text-justify">
                                <?php echo $errorinfo; ?>
                            </p>
                        </div>
                    </div>
                    <br>
                    <button type="button" class="btn btn-default center-block" style="width:100%" onclick="window.history.back();">Torna indietro</button>
                </div>
            </div>
        </div>
        
        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>