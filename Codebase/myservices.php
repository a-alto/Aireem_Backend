<?php
session_start();

if(!isset($_SESSION["usrID"]) || empty($_SESSION["usrID"]))
{
    header('Location:login.php');
    exit();
}

include("connection.php");
include("logged-user-navbar.php");
$OFFERS="";
$ERROR="";

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

$sql="SELECT offID,prfName,offInfo,offStartTime,offEndTime FROM Offers,Performances WHERE offUserID=".$_SESSION["usrID"]." AND offPrfID=prfID;";
$res=mysqli_query($cn,$sql); // query execution

if(!$res)
{
    $_SESSION["error"] = "Ops... Ci sono dei problemi con il caricamento della pagina!";
    $_SESSION["errorinfo"] = "Ci sono stati dei problemi con l'ottenimento delle offerte da te create. Riprovare.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}

if(mysqli_num_rows($res) > 0)
{
    while($riga = mysqli_fetch_assoc($res))
    {
        // prepare time
        $STARTTIME=date_create($riga["offStartTime"]);
        $ENDTIME=date_create($riga["offEndTime"]);
        
        // prepare table
        $OFFERS.="<tr>\n";
        $OFFERS.="<td>".$riga["offID"]."</td>\n";
        $OFFERS.="<td>".$riga["prfName"]."</td>\n";
        $OFFERS.="<td>".$riga["offInfo"]."</td>\n";
        $OFFERS.="<td>".date_format($STARTTIME,'H:i')."</td>\n";
        $OFFERS.="<td>".date_format($ENDTIME,'H:i')."</td>\n";
        $OFFERS.="<td><button class='btn btn-primary btn-sm' onclick=\"window.location.href='service.php?id=".$riga["offID"]."'\">Visualizza</button></td>\n";
        $OFFERS.="<td><button class='btn btn-danger btn-sm' onclick=\"window.location.href='delete_service.php?id=".$riga["offID"]."'\">Elimina</button></td>\n";
        $OFFERS.="</tr>\n";
    }
}
else
{
    $ERROR.="<br>\n<div class='text-center'><h2>Non hai creato ancora alcun'offerta!</h2></div>\n";
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
        
        <div class="container-fluid">
            <div class="text-center"><h1>Servizi offerti</h1></div>
            <br>
            <br>
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12 col-xs-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Servizio</th>
                                <th>Info</th>
                                <th>Ora inizio</th>
                                <th>Ora fine</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $OFFERS; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php echo $ERROR; ?>
        </div>
        
        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>