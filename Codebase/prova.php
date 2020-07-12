<?php
session_start();

include("connection.php");
if(isset($_SESSION["usrID"]) && !empty($_SESSION["usrID"]))
{
    include("logged-user-navbar.php");
}
else
{
    include("visitor-navbar.php");
}

// /^[0-9]+$/  for numbers
// /^[a-zA-Z0-9]+$/   for alpha-numeric
date_default_timezone_set('Europe/Rome'); // set timezone

$person = array("name"=>"","surname"=>"","email"=>"","username"=>"","password"=>"","repassword"=>"","birthdate"=>"","gender"=>"","qualification"=>"","occupation"=>"","bio"=>"","address"=>"","housenumber"=>"","apartmentinfo"=>"","city"=>"","zipcode"=>"","state"=>"","country"=>"","tel"=>"","cell"=>"","linkedin"=>"","website"=>"");
$name=99.127;
$messaggio="";
$validation="";
include("charset.php");
$person["name"]="alessandro";

if(preg_match($DECIMALS, $name))
{
    $messaggio="e' un numero decimale valido";
}
else
{
    $messaggio="NON e' un numero decimale valido";
}

?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="favicon.ico">
        <title>Prova - Aireem</title>
        <!-- UIkit -->
        <link rel="stylesheet" href="uikit/css/uikit.min.css">
        <script src="uikit/js/uikit.min.js"></script>
        <script src="uikit/js/uikit-icons.min.js"></script>
        <!-- Bootstrap -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="custom/css/custom-css.css" rel="stylesheet">
        
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class='under-navbar-body'>
        <!-- navbar menu -->
        <?php echo $NAVBAR; ?>
        
        <div class="container-fluid">
            <div class="row">
                <div class='col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-12 col-xs-12'>
                    <div class='panel' style='width:100%;border:0px;'>
                        <div class='uk-card uk-card-default uk-card-hover uk-card-body' style='padding-top:20px;padding-bottom:20px;padding-left:15px;padding-right:20px;'>
                            <!-- user's service propic -->
                            <div class='col-lg-4 col-md-4 col-sm-1 col-xs-0' style='margin-top:5px;padding-left:0px;'>
                                <img src='images/default-propic.png' class='img-responsive img-circle center-block' alt="Profile pic" width='70px' height='70px'>
                            </div>
                            <!-- service body -->
                            <div class='col-lg-8 col-md-8 col-sm-11 col-xs-12' style='margin-top:5px;padding-left:0px;'>
                                <table border='0' style='width:100%;'>
                                    <tr>
                                        <td><h3 style='margin-top:0px;'>Riparazioni Computer</h3></td>
                                    </tr>
                                    <tr>
                                        <td><div style='margin-bottom:10px;'>Giancarlo Rossi&nbsp;&nbsp;<span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star"></span><span class="glyphicon glyphicon-star-empty"></span><span class="glyphicon glyphicon-star-empty"></span></div></td>
                                    </tr>
                                    <tr>
                                        <td><div style='margin-bottom:10px;'>Orari:&nbsp;&nbsp;08:00 - 20:00</div></td>
                                    </tr>
                                    <tr>
                                        <td><div style='margin-bottom:10px;'>Costo:&nbsp;&nbsp;20&euro;&nbsp;&nbsp;all'ora&nbsp;&nbsp;<u>Trattabile</u></div></td>
                                    </tr>
                                    <tr>
                                        <td><button class='btn btn-success btn-xs'>Consulta</button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class='col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-12 col-xs-12'>
                    <div class='panel' style='width:100%;border:0px;'>
                        <div class='uk-card uk-card-default uk-card-hover uk-card-body'>
                            <!-- user's service propic -->
                            <div class='col-lg-4 col-md-4 col-sm-1 col-xs-0' style='margin-top:5px;padding-left:0px;'>
                                <img src='images/default-propic.png' class='img-responsive img-circle center-block' alt="Profile pic" width='70px' height='70px'>
                            </div>
                            <!-- service body -->
                            <div class='col-lg-8 col-md-8 col-sm-11 col-xs-12' style='margin-top:5px;padding-left:0px;'>
                                <table border='0' style='width:100%;'>
                                    <tr>
                                        <td><h3 style='margin-top:0px;'>Riparazioni Computer</h3></td>
                                    </tr>
                                    <tr>
                                        <td><div style='margin-bottom:10px;'>Giancarlo Rossi&nbsp;&nbsp;XXXXX</div></td>
                                    </tr>
                                    <tr>
                                        <td><div style='margin-bottom:10px;'>Orari:&nbsp;&nbsp;08:00 - 20:00</div></td>
                                    </tr>
                                    <tr>
                                        <td><div style='margin-bottom:10px;'>Costo:&nbsp;&nbsp;20&euro;&nbsp;&nbsp;all'ora&nbsp;&nbsp;<u>Trattabile</u></div></td>
                                    </tr>
                                    <tr>
                                        <td><button class='btn btn-success btn-xs'>Consulta</button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>