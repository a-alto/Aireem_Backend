<?php
    session_start();
    
    if(isset($_SESSION["usrID"]) && !empty($_SESSION["usrID"]))
    {
        header('Location:/');
        exit();
    }
    
    include("connection.php");
    include("visitor-navbar.php");
    $MESSAGE="";

    // print login error message if it is set
    if(isset($_SESSION["errorlogin"]) && !empty($_SESSION["errorlogin"]) && isset($_SESSION["errorcodelogin"]) && !empty($_SESSION["errorcodelogin"]))
    {
        $MESSAGE="<div class=\"alert alert-danger\" role=\"alert\"><span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span> <strong>Codice errore ".$_SESSION["errorcodelogin"].":</strong> ".$_SESSION["errorlogin"]."</div>\n";
        unset($_SESSION["errorcodelogin"]);
        unset($_SESSION["errorlogin"]);
    }
    else
    {
        if(isset($_POST["email"]) && isset($_POST["password"]) && !empty($_POST["email"]) && !empty($_POST["password"]))
        {
            $email=$_POST["email"];
            $pw=$_POST["password"];
            
            // DB connection
            $cn=mysqli_connect($HOSTDB,$USERDB,$PASSDB,$NAMEDB);
            
            // db connection error
            if(!$cn)
            {
                $_SESSION["errorcodelogin"] = 2;
                $_SESSION["errorlogin"] = "Ci sono problemi di connessione. Riprovare tra qualche minuto.";
                mysqli_close($cn);
                header("Location:login.php");
                exit();
            }
            
            $sql="SELECT * FROM Users WHERE usrEmail='$email'";
            
            $res=mysqli_query($cn,$sql); // query execution
            
            // reading from db error
            if(!$res)
            {
                $_SESSION["errorcodelogin"] = 3;
                $_SESSION["errorlogin"] = "Ci sono problemi di acquisizione dati. Riprovare tra qualche minuto.";
                mysqli_close($cn);
                header("Location:login.php");
                exit();
            }
            
            // number of rows
            if (mysqli_num_rows($res) != 1)
            {
                // user not found
                $_SESSION["errorcodelogin"] = 4;
                $_SESSION["errorlogin"] = "Email o password errata.";
                unset($_POST["password"]);
                mysqli_close($cn);
                header('Location:login.php');
                exit();
            }
            
            // reading from DB
            $riga = mysqli_fetch_assoc($res);
              
            if ($pw == $riga["usrPassword"])  //  MD5($pw)
            {
                // password is correct
                $_SESSION["usrID"] = $riga["usrID"];
                $_SESSION["usrEmail"] = $email;
                $_SESSION["usrUsername"] = $riga["usrUsername"];
                $_SESSION["usrProPic"] = $riga["usrProPic"];
                $_SESSION["usrPremium"] = $riga["usrPremium"];
                $_SESSION["usrPersonCode"] = $riga["usrPersonCode"];
                $_SESSION["usrP_Iva"] = $riga["usrP_Iva"];
                unset($_POST["password"]);
                mysqli_close($cn);
                header('Location:/');
                exit();
            }
            else
            {
                // password is wrong
                $_SESSION["errorcodelogin"] = 4;
                $_SESSION["errorlogin"] = "Email o password errata.";
                unset($_POST["password"]);
                mysqli_close($cn);
                header('Location:login.php');
                exit();
            }
            
            mysqli_close($cn);
        }
        else
        {
            // check if the login request comes from a login page by control the "logging" value
            if(isset($_POST["logging"]) && $_POST["logging"]=="y")
            {
                $_SESSION["errorcodelogin"] = 1;
                $_SESSION["errorlogin"] = "Inserire Email e Password!";
                unset($_POST["logging"]);
                header("Location:login.php");
                exit();
            }
        }
    }
?>
<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="favicon.ico">
        <title>Aireem - Login</title>
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
            <p><img src="images/logo.png" class="img-responsive center-block" alt="aireem logo" width="300px" height="101"></p>
            <p class="text-center"><h3 class="text-center">Accedi</h3></p>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
                    <?php echo $MESSAGE; ?>
                </div>
                <div class="col-lg-2 col-lg-offset-5 col-md-2 col-md-offset-5 col-sm-4 col-sm-offset-4 col-xs-12">
                    <form id="login" name="login" action="login.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="logging" id="logging" value="y">
                        </div>
                        <button type="submit" class="btn btn-primary center-block" style="width:100%;">Accedi</button>
                    </form>
                    <form action="#" class="text-center">
                        <button type="submit" class="btn btn-link">Password dimenticata</button>
                    </form>
                </div>
                <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-12">
                    <hr>
                    <form action="signup.php">
                        <h5 style="float:left;">Non hai ancora un account?</h5> <button type="submit" class="btn btn-success btn-xs text-right" style="float:right;">Registrati</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>