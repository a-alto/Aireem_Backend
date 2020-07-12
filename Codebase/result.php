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

$RESULTS=""; // results string

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

$sql="SELECT offID,offStartTime,offEndTime,offCost,offHourlycost,offCostToBeDetermined,offUserID,prfName,pplName,pplSurname,usrProPic,curCode,revOffID,AVG(revRating) AS 'Rating' FROM Offers,Performances,People,Users,Cities,Currencies,Reviews WHERE prfName LIKE '%".$_GET["service"]."%' AND offPrfID=prfID AND offUserID=usrID AND usrPersonCode=pplPersonCode AND cyState='".$_GET["state"]."' AND pplCyID=cyID AND offCurID=curID AND revOffID=offID GROUP BY revOffID,offID,offStartTime,offEndTime,offCost,offHourlycost,offCostToBeDetermined,offUserID,prfName,pplName,pplSurname,usrProPic,curCode;";
$res=mysqli_query($cn,$sql);

if(!$res)
{
    $_SESSION["error"] = "Ops... Qualcosa è andato storto!";
    $_SESSION["errorinfo"] = "Non è stato possibile effettuare la ricerca richiesta. Riprovare cambiando i termini di ricerca.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}

if(mysqli_num_rows($res) < 1)
{
    $RESULTS.="<div class='row'>\n<div class='col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3'>\n<div class='alert alert-warning' role='alert'><strong>:(</strong> Non è stata trovata alcuna offerta con i termini di ricerca immessi.</div>\n</div>\n</div>\n";
}
else
{
    while($riga = mysqli_fetch_assoc($res))
    {
        // create time
        $STARTTIME=date_create($riga["offStartTime"]);
        $ENDTIME=date_create($riga["offEndTime"]);
        
        // compose result card
        $RESULTS.="<div class='row'>
                <div class='col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-12 col-xs-12'>
                    <div class='panel' style='width:100%;border:0px;'>
                        <div class='uk-card uk-card-default uk-card-hover uk-card-body' style='padding-top:20px;padding-bottom:20px;padding-left:15px;padding-right:20px;'>
                            <!-- user's service propic -->
                            <div class='col-lg-4 col-md-4 col-sm-1 col-xs-0' style='margin-top:5px;padding-left:0px;'>
                                <img src='".$riga["usrProPic"]."' class='img-responsive img-circle center-block' alt='Profile pic' width='70px' height='70px' style=\"cursor:pointer;cursor:hand;\" onclick=\"window.location.href='user.php?id=".$riga["offUserID"]."'\">
                            </div>
                            <!-- service body -->
                            <div class='col-lg-8 col-md-8 col-sm-11 col-xs-12' style='margin-top:5px;padding-left:0px;'>
                                <table border='0' style='width:100%;'>
                                    <tr>
                                        <td><h3 style='margin-top:0px;'>".$riga["prfName"]."</h3></td>
                                    </tr>
                                    <tr>
                                        <td><div style='margin-bottom:10px;'><a href='user.php?id=".$riga["offUserID"]."' target='_blank'>".$riga["pplName"]." ".$riga["pplSurname"]."</a>&nbsp;&nbsp;".($riga["Rating"]>=0.5?"<span class='glyphicon glyphicon-star'></span>":"<span class='glyphicon glyphicon-star-empty'></span>").($riga["Rating"]>=1.5?"<span class='glyphicon glyphicon-star'></span>":"<span class='glyphicon glyphicon-star-empty'></span>").($riga["Rating"]>=2.5?"<span class='glyphicon glyphicon-star'></span>":"<span class='glyphicon glyphicon-star-empty'></span>").($riga["Rating"]>=3.5?"<span class='glyphicon glyphicon-star'></span>":"<span class='glyphicon glyphicon-star-empty'></span>").($riga["Rating"]>=4.5?"<span class='glyphicon glyphicon-star'></span>":"<span class='glyphicon glyphicon-star-empty'></span>")."</div></td>
                                    </tr>
                                    <tr>
                                        <td><div style='margin-bottom:10px;'>Orari:&nbsp;&nbsp;".date_format($STARTTIME,'H:i')." - ".date_format($ENDTIME,'H:i')."</div></td>
                                    </tr>
                                    <tr>
                                        <td><div style='margin-bottom:10px;'>Costo:&nbsp;&nbsp;".$riga["offCost"]."&nbsp;".$riga["curCode"]."&nbsp;&nbsp;".($riga["offHourlycost"]?"all'ora":"")."&nbsp;&nbsp;".($riga["offCostToBeDetermined"]?"<u>Trattabile</u>":"")."</div></td>
                                    </tr>
                                    <tr>
                                        <td><button class='btn btn-success btn-xs' onclick=\"window.location.href='service.php?id=".$riga["offID"]."'\">Consulta</button></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";
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
        <title>Risultati per: <?php echo $_GET["service"]; ?> - Aireem</title>
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
        
        <div class="text-center">
            <h3>Risultati per:</h3>
            <h1><?php echo $_GET["service"]; ?></h1>
        </div>
        <br>
        <div class="container-fluid">
            <?php echo $RESULTS; ?>
        </div>
        
        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>