<?php
    session_start();
    
    include("connection.php");
    $REGISTERBUTTON="";
    $STATES="";
    
    // create page if user is logged
    if(isset($_SESSION["usrID"]) && !empty($_SESSION["usrID"]))
    {
        include("logged-user-navbar.php");
    }
    else // create page if user is not logged
    {
        include("visitor-navbar.php");
        
        $REGISTERBUTTON.="<!-- Signup for visitors not logged -->\n";
        $REGISTERBUTTON.="<br>\n";
        $REGISTERBUTTON.="<br>\n";
        $REGISTERBUTTON.="<br>\n";
        $REGISTERBUTTON.="<br>\n";
        $REGISTERBUTTON.="<br>\n";
        $REGISTERBUTTON.="<div class=\"text-center\">\n";
        $REGISTERBUTTON.="<p><h3>Prenota facilmente o offri un servizio</h3></p>\n";
        $REGISTERBUTTON.="<div><span class=\"glyphicon glyphicon-circle-arrow-down glyphicon-lg\" style='font-size:20px;' onclick=\"window.location.href='#register-button'\"></span></div>\n";
        $REGISTERBUTTON.="</div>\n";
        $REGISTERBUTTON.="<br>\n";
        $REGISTERBUTTON.="<form class=\"text-center\" action=\"signup.php\">\n";
        $REGISTERBUTTON.="<button id=\"register-button\" type=\"submit\" class=\"btn btn-success btn-lg\">Registrati</button></div>\n";
        $REGISTERBUTTON.="</form>\n";
    }
    
    // DB connection
    $cn=mysqli_connect($HOSTDB,$USERDB,$PASSDB,$NAMEDB);
    
    // db connection error
    if(!$cn)
    {
        $_SESSION["errorcode"] = 1;
        $_SESSION["error"] = "Ops! C'è stato un errore";
        $_SESSION["errorinfo"]="Il database è momentaneamente irraggiungibile. Riprovare tra qualche minuto.";
        mysqli_close($cn);
        header("Location:error.php");
        exit();
    }
    
    $sql="SELECT DISTINCT cyState FROM Cities ORDER BY cyState ASC";
    
    $res=mysqli_query($cn,$sql); // query execution
    
    // reading from db error
    if(!$res)
    {
        $_SESSION["errorcode"] = 2;
        $_SESSION["error"] = "Ops! C'è stato un errore";
        $_SESSION["errorinfo"]="Temporanei problemi di lettura dei dati dal database. Riprovare tra qualche minuto.";
        mysqli_close($cn);
        header("Location:error.php");
        exit();
    }
    
    // fill with data if db is not empty
    if(mysqli_num_rows($res)>1)
    {
        while($riga=mysqli_fetch_assoc($res))
        {
            $STATES.="<option value='".$riga["cyState"]."'>".$riga["cyState"]."</option>\n";
        }
    }
    
    mysqli_close($cn);
?>
<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="favicon.ico">
        <title>Aireem - Compra e vendi prestazioni online</title>
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
        
        <!-- page body -->
        <div class="container-fluid">
            <p class="center-block"><h1 class="text-center">Di chi hai bisogno?</h1></p>
            <br>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
                    <form class="center-block" name="search" action="result.php" method="get">
                        <div class="form-group">
                            <input type="text" class="form-control" name="service" id="service" placeholder="Es: idraulico, babysitter...">
                        </div>
                        <br>
                        <div class="form-group">
                            <!-- data to upload -->
                            <select class="form-control" name="state" id="state">
                                <option value=''>Seleziona la regione...</option>
                                <option role="separator" class="divider" disabled></option>
                                <?php echo $STATES; ?>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary center-block" style="width:100%;">Cerca professionisti</button>
                    </form>
                </div>
            </div>
            <?php echo $REGISTERBUTTON ?>
        </div><!-- end body page -->
        
        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>