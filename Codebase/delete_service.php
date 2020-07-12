<?php
session_start();

if(!isset($_SESSION["usrID"]) || empty($_SESSION["usrID"]))
{
    header('Location:login.php');
    exit();
}

include("connection.php");
include("logged-user-navbar.php");
$MESSAGE=""; // output message

// DB connection
$cn=mysqli_connect($HOSTDB,$USERDB,$PASSDB,$NAMEDB);
                
// db connection error
if(!$cn)
{
    $_SESSION["error"] = "Ops... Ci sono dei problemi di connessione!";
    $_SESSION["errorinfo"] = "Il servizio è temporaneamente non disponibile. Riprovare tra qualche minuto.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}

$sql="SELECT offUserID FROM Offers WHERE offID=".$_GET["id"].";";
$res=mysqli_query($cn,$sql); // query execution

// reading from db error
if(!$res)
{
    $_SESSION["error"] = "Ops... Qualcosa è andato storto";
    $_SESSION["errorinfo"] = "Non è stato possibile eliminare l'offerta con l'ID immesso, oppure tale offerta è inesistente.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}

if(mysqli_num_rows($res) != 1)
{
    $_SESSION["error"] = "Offerta inesistente!";
    $_SESSION["errorinfo"] = "L'offerta che si sta cercando di eliminare non esiste.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}
$riga = mysqli_fetch_assoc($res);

// check if the offer provider user correspond to the logged user
if($riga["offUserID"]==$_SESSION["usrID"])
{
    // delete related reviews
    $sql="DELETE FROM Reviews WHERE revOffID=".$_GET["id"].";";
    $res=mysqli_query($cn,$sql); // query execution
    
    // reading from db error
    if(!$res)
    {
        $_SESSION["error"] = "Ops... Qualcosa è andato storto";
        $_SESSION["errorinfo"] = "L'offerta non è stata eliminata. Riprovare.";
        mysqli_close($cn);
        header("Location:error.php");
        exit();
    }
    
    // delete the offer
    $sql="DELETE FROM Offers WHERE offID=".$_GET["id"].";";
    $res=mysqli_query($cn,$sql); // query execution
    
    // reading from db error
    if(!$res)
    {
        $_SESSION["error"] = "Ops... Qualcosa è andato storto";
        $_SESSION["errorinfo"] = "L'offerta non è stata eliminata. Riprovare.";
        mysqli_close($cn);
        header("Location:error.php");
        exit();
    }
    
    // everything has gone good. Show a succesful message
    $MESSAGE.="<div class='alert alert-success' role='alert'><strong>Operazione riuscita!</strong> Offerta eliminata con successo   :)</div>";
}
else
{
    $MESSAGE.="<div class='alert alert-danger' role='alert'><strong>Operazione non ammessa.</strong> Non è possibile eliminare l'offerta con l'ID selezionato!</div>";
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
            <div clas='row'>
                <div class='col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3'>
                    <?php echo $MESSAGE; ?>
                </div>
            </div>
        </div>
        
        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
