<?php
session_start();

include("connection.php");
$DATA="";
$MODIFY_BUTTON="";
$MESSAGE="";
$person = array("propic"=>"","name"=>"","surname"=>"","email"=>"","username"=>"","birthdate"=>"","qualification"=>"","occupation"=>"","bio"=>"","address"=>"","housenumber"=>"","city"=>"","zipcode"=>"","state"=>"","country"=>"","tel"=>"","cell"=>"","linkedin"=>"","website"=>"");

if(isset($_SESSION["usrID"]) && !empty($_SESSION["usrID"]))
{
    include("logged-user-navbar.php");
}
else
{
    include("visitor-navbar.php");
}

$usrid=$_GET["id"];

/* get user data */
// DB connection
$cn=mysqli_connect($HOSTDB,$USERDB,$PASSDB,$NAMEDB);
        
// db connection error
if(!$cn)
{
    $_SESSION["error"] = "Ops... Qualcosa è andato storto!";
    $_SESSION["errorinfo"] = "C'è stato un problema di connessione ai nostri server per l'acquisizione dei dati dell'utente cercato. Riprovare tra qualche minuto.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}
               
$sql="SELECT usrUsername,usrProPic,usrPersonCode,pplName,pplSurname,pplBirthdate,pplQualification,pplOccupation,pplBio,pplAddress,pplHouseNumber,pplTel,pplCell,pplCV,pplLinkedin,pplWebsite,cyName,cyZipCode,cyState,cyCountry FROM Users,People,Cities WHERE usrID=$usrid AND usrPersonCode=pplPersonCode AND pplCyID=cyID;";
                
$res=mysqli_query($cn,$sql); // query execution
                
// reading from db error
if(!$res)
{
    $_SESSION["error"] = "Ops... Qualcosa è andato storto!";
    $_SESSION["errorinfo"] = "L'utente cercato sembra inesistente o ci sono problemi di acquisizione dati. Riprovare.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}
                
// number of rows
if (mysqli_num_rows($res) != 1)
{
    // user not found
    $_SESSION["error"] = "Utente non trovato!";
    $_SESSION["errorinfo"] = "L'utente cercato risulta inesistente.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}
        
$riga=mysqli_fetch_assoc($res);
mysqli_close($cn); // close connection

function PrepareData()
{
    global $DATA;
    global $riga;
    $DATA.="<img src='".$riga["usrProPic"]."' class='img-responsive img-circle center-block' alt='Profile picture' width='140' height='140'>
        <br>
        <div class='container-fluid'>
            <div clas='row'>
                <div class='col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3'>
                    <div class='text-center'>
                        <h2>".$riga["pplName"]."&nbsp;&nbsp;&nbsp;&nbsp;".$riga["pplSurname"]."</h2>
                    </div>
                    <br>
                    <h4 class='text-center'>".$riga["usrUsername"]."</h4>
                    <br>
                    <h4 style='margin-bottom:15px;'><b>Info:</b></h4>
                    <dl id='info-dl' class='dl-horizontal' width='100%' style='margin-bottom:10px;'>
                        <dt style='padding-bottom:10px;'>Data di nascita:</td>
                        <dd class='text-right' style='padding-bottom:10px;'>".$riga["pplBirthdate"]."</td>
                        <dt style='padding-bottom:10px;'>Titolo di studio:</td>
                        <dd class='text-right' style='padding-bottom:10px;'>".$riga["pplQualification"]."</td>
                        <dt style='padding-bottom:10px;'>Occupazione:</td>
                        <dd class='text-right' style='padding-bottom:10px;'>".$riga["pplOccupation"]."</td>
                    </dl>
                    <dl id='bio-dl' width='100%'>
                        <dt>Bio:</dt>
                        <dd class='text-justify' style='font-size:13;'>".$riga["pplBio"]."</dd>
                    </dl>
                    <hr>
                    <h4 style='margin-bottom:15px;'><b>Contatti:</b></h4>
                    <dl id='contacts-dl' class='dl-horizontal' width='100%' style='margin-bottom:0px;'>
                        <dt style='padding-bottom:10px;'>Indirizzo:</dt>
                        <dd class='text-right' style='padding-bottom:10px;'>".$riga["pplAddress"].", ".$riga["pplHouseNumber"]." - ".$riga["cyName"].", ".$riga["cyZipCode"]." &middot; ".$riga["cyState"].", ".$riga["cyCountry"]."</dd>
                        <dt style='padding-bottom:10px;'>Telefono:</dt>
                        <dd class='text-right' style='padding-bottom:10px;'>".$riga["pplTel"]."</dd>
                        <dt style='padding-bottom:10px;'>Cellulare:</dt>
                        <dd class='text-right' style='padding-bottom:10px;'>".$riga["pplCell"]."</dd>
                        <dt style='padding-bottom:10px;'><img src='images/brands/linkedin.png' class='img-responsiv' alt='LinkedIn-logo'>&nbsp;&nbsp;LinkedIn:</dd>
                        <dd class='text-right' style='padding-bottom:10px;'>".$riga["pplLinkedin"]."</dd>
                        <dt style='padding-bottom:10px;'>Sito web:</dt>
                        <dd class='text-right' style='padding-bottom:10px;'>".$riga["pplWebsite"]."</dd>
                    </dl>";
}

if(isset($_SESSION["erroruser"]) && !empty($_SESSION["erroruser"])) // manage error
{
    $MESSAGE="<div class=\"alert alert-danger\" role=\"alert\"><span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span> ".$_SESSION["erroruser"]."</div>\n";
    unset($_SESSION["erroruser"]);
}
else
{
    // check the requested user ID is the same of the one in _SESSION
    if(isset($_SESSION["usrID"]) && !empty($_SESSION["usrID"]) && $_GET["id"]===$_SESSION["usrID"])
    {
        // make the modify form
        if($_GET["modify"]==1)
        {
            $DATA.="<div class='container-fluid'>\n";
            $DATA.="<div clas='row'>\n";
            $DATA.="<div class='col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3'>\n";
            $DATA.="<div class='alert alert-warning' role='alert'><strong>Siamo spiacenti.</strong> Non è ancora possibile modificare il proprio profilo :(</div>\n";
            $DATA.="</div>\n";
            $DATA.="</div>\n";
            $DATA.="</div>\n";
        }
        else
        {
            // show information and modify button
            PrepareData();
            $MODIFY_BUTTON.="\n<br>\n<button type='button' class='btn btn-info' style='width:100%;' onclick=\"window.location.href='user.php?id=".$_SESSION["usrID"]."&modify=1'\">Modifica profilo</button>\n";
            $DATA.=$MODIFY_BUTTON;
        }
    }
    else
    {
        PrepareData();
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
        <title><?php echo $riga["pplName"]." ".$riga["pplSurname"]; ?> - Aireem</title>
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
        
        <!-- print information or form -->
        <?php echo $DATA; ?>
        
        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>