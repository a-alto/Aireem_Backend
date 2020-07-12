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

/* Connessione al DB e recupero dei dati */
$MODIFY_BUTTON="";
$DELETE_BUTTON="";
$service; // offer data
$data; // other data

// check if id put in GET is correct
if(!isset($_GET["id"]) || empty($_GET["id"]) || !is_numeric($_GET["id"]))
{
    // offer not found
    $_SESSION["error"] = "Offerta di servizio inesistente!";
    $_SESSION["errorinfo"] = "Non è stato trovato alcun servizio offerto con l'ID cercato.";
    header("Location:error.php");
    exit();
}

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

// first: get offer data
$sql="SELECT * FROM Offers WHERE offID=".$_GET["id"].";";
$res=mysqli_query($cn,$sql);

// reading from db error
if(!$res)
{
    $_SESSION["error"] = "Ops... Qualcosa è andato storto!";
    $_SESSION["errorinfo"] = "L'offerta di servizio cercata sembra inesistente o ci sono problemi di acquisizione dati. Riprovare.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}

// number of rows
if (mysqli_num_rows($res) != 1)
{
    // offer not found
    $_SESSION["error"] = "Offerta di servizio inesistente!";
    $_SESSION["errorinfo"] = "Non è stato trovato alcun servizio offerto con l'ID cercato.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}

$service=mysqli_fetch_assoc($res);


// second: get any other data is needed
$sql="SELECT prfName,curCode,usrID,usrUsername,usrEmail,usrProPic,usrPersonCode,pplName,pplSurname,pplAddress,pplHouseNumber,pplApartmentInfo,pplTel,pplCell,pplLinkedin,pplWebsite FROM Offers,Performances,Currencies,Users,People WHERE offID=".$_GET["id"]." AND offPrfID=prfID AND offCurID=curID AND offUserID=usrID AND usrPersonCode=pplPersonCode;";
$res=mysqli_query($cn,$sql);

// reading from db error
if(!$res)
{
    $_SESSION["error"] = "Ops... Qualcosa è andato storto!";
    $_SESSION["errorinfo"] = "Ci sono stati problemi di acquisizione dei dati relativi all'offerta di servizio cercata. Riprovare.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}

// number of rows
if (mysqli_num_rows($res) != 1)
{
    // offer not found
    $_SESSION["error"] = "Ops... Qualcosa è andato storto!";
    $_SESSION["errorinfo"] = "Ci sono stati problemi con l'ottenimento dei dati relativi all'offerta di servizio cercata.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}

$data=mysqli_fetch_assoc($res);
// now every data is taken
mysqli_close($cn); // close connection

/* Prepare text for body */

// create time
$STARTTIME=date_create($service["offStartTime"]);
$ENDTIME=date_create($service["offEndTime"]);

// prepare availability days for being displayed
$availability="";
// if related day are true, display it
$availability.=($service["offMon"]?"Lun":"");

if($service["offTue"])
{
    if(!empty($availability))
    {
        $availability.=" - Mar";
    }
    else
    {
        $availability.="Mar";
    }
}
if($service["offWed"])
{
    if(!empty($availability))
    {
        $availability.=" - Mer";
    }
    else
    {
        $availability.="Mer";
    }
}
if($service["offThu"])
{
    if(!empty($availability))
    {
        $availability.=" - Gio";
    }
    else
    {
        $availability.="Gio";
    }
}
if($service["offFri"])
{
    if(!empty($availability))
    {
        $availability.=" - Ven";
    }
    else
    {
        $availability.="Ven";
    }
}
if($service["offSat"])
{
    if(!empty($availability))
    {
        $availability.=" - Sab";
    }
    else
    {
        $availability.="Sab";
    }
}
if($service["offSun"])
{
    if(!empty($availability))
    {
        $availability.=" - Dom";
    }
    else
    {
        $availability.="Dom";
    }
}

// prepare cost details for being displayed
$costdetails="";
$costdetails.=($service["offHourlyCost"]?"all'ora":"");

if($service["offCostToBeDetermined"])
{
    if(!empty($costdetails))
    {
        $costdetails.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Trattabile</u>";
    }
    else
    {
        $costdetails.="<u>Trattabile</u>";
    }
}

// prepare working location for being displayed
$workinglocation="";
$workinglocation.=($service["offHomeWorking"]?"<i>Il lavoro verrà svolto presso il domicilio del cliente che prenota</i>":$data["pplAddress"].", ".$data["pplHouseNumber"]." &middot; ".$data["pplApartmentInfo"]); // if offHomeWorking is false, print the provider user's address


// prepare modify button if usrID is the same
if($_SESSION["usrID"]==$data["usrID"])
{
    $MODIFY_BUTTON.="<button type='button' class='btn btn-info' style='width:100%;' onclick=\"window.location.href='modify_service.php?id=".$_GET["id"]."'\">Modifica offerta</button>\n";
    $DELETE_BUTTON.="<div style='margin-top:40px;'>\n";
    $DELETE_BUTTON.="<a class='text-danger' href='delete_service.php?id=".$_GET["id"]."'>Cancella questa offerta</a>\n";
    $DELETE_BUTTON.="</div>\n";
}

?>
<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="favicon.ico">
        <title><?php echo $data["prfName"] ?> - Aireem</title>
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
            <div class="text-center">
                <h1>Servizio offerto: <?php echo $data["prfName"] ?></h1>
            </div>
            <br>
            <div class="row">
                <!-- user's service propic -->
                <div class='col-lg-1 col-lg-offset-1 col-md-1 col-md-offset-1 col-sm-12 col-xs-12'>
                    <img src='<?php echo $data["usrProPic"] ?>' class='img-responsive img-circle center-block' alt="User's profile image" width='100px' height='100px' style="cursor:pointer;cursor:hand;" onclick="window.location.href='user.php?id=<?php echo $data["usrID"] ?>'">
                </div>
                <!-- service body -->
                <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                    <table border='0' style='width:100%;'>
                        <tr>
                            <td><h3 style='margin-top:0px;'><?php echo $data["pplName"] ?>&nbsp;&nbsp;<?php echo $data["pplSurname"] ?></h3></td>
                        </tr>
                        <tr>
                            <td><div style='margin-bottom:15px;'><a href='user.php?id=<?php echo $data["usrID"] ?>'><?php echo $data["usrUsername"] ?></a></div></td>
                        </tr>
                        <tr>
                            <td><div style='margin-bottom:10px;'><b>Anni di esperienza:</b>&nbsp;&nbsp;&nbsp;<?php echo $service["offWorkExperience"] ?></div></td>
                        </tr>
                        <tr>
                            <td><div style='margin-bottom:5px;'><b>Competenze:</b></div></td>
                        </tr>
                        <tr>
                            <td><p class='text-justify'><?php echo $service["offSkills"] ?></p></td>
                        </tr>
                        <tr>
                            <td><div style='margin-bottom:10px;'><b>Disponibilità:</b>&nbsp;&nbsp;&nbsp;<?php echo $availability ?></div></td>
                        </tr>
                        <tr>
                            <td><div style='margin-bottom:10px;'><b>Orari:</b>&nbsp;&nbsp;&nbsp;<?php echo date_format($STARTTIME,'H:i') ?> - <?php echo date_format($ENDTIME,'H:i') ?></div></td>
                        </tr>
                        <tr>
                            <td><div style='margin-bottom:10px;'><b>Costo:</b>&nbsp;&nbsp;&nbsp;<?php echo $service["offCost"] ?>&nbsp;<?php echo $data["curCode"] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $costdetails ?></div></td>
                        </tr>
                        <tr>
                            <td><div style='margin-bottom:5px;'><b>Presso:</b></div></td>
                        </tr>
                        <tr>
                            <td><p class='text-justify' style="margin-bottom:0px;"><?php echo $workinglocation ?></p></td>
                        </tr>
                        <tr>
                            <td><hr></td>
                        </tr>
                        <tr>
                            <td><div class='text-center'><h4 style='margin-top:0px;'>Contatti</h4></div></td>
                        </tr>
                        <tr>
                            <td>
                                <table border='0' style='margin:0px;padding:0px;width:100%;'>
                                    <tr>
                                        <td style='padding:10px;'><b>Email:</b></td>
                                        <td class='text-right' style='padding:10px;'><?php echo ((isset($data["usrEmail"]) && !empty($data["usrEmail"]))?$data["usrEmail"]:"<i>Non disponibile</i>") ?></td>
                                    </tr>
                                    <tr>
                                        <td style='padding:10px;'><b>Telefono:</b></td>
                                        <td class='text-right' style='padding:10px;'><?php echo ((isset($data["pplTel"]) && !empty($data["pplTel"]))?$data["pplTel"]:"<i>Non disponibile</i>") ?></td>
                                    </tr>
                                    <tr>
                                        <td style='padding:10px;'><b>Cellulare:</b></td>
                                        <td class='text-right' style='padding:10px;'><?php echo ((isset($data["pplCell"]) && !empty($data["pplCell"]))?$data["pplCell"]:"<i>Non disponibile</i>") ?></td>
                                    </tr>
                                    <tr>
                                        <td style='padding:10px;'><img src="images/brands/linkedin.png" class="img-responsive" alt="LinkedIn-logo" style="display:inline-block">&nbsp;&nbsp;<b>LinkedIn:</b></td>
                                        <td class='text-right' style='padding:10px;'><?php echo ((isset($data["pplLinkedin"]) && !empty($data["pplLinkedin"]))?"<a href='{$data["pplLinkedin"]}' target='_blank'>Vai al profilo</a>":"<i>Non disponibile</i>") ?></td>
                                    </tr>
                                    <tr>
                                        <td style='padding:10px;'><b>Sito web:</b></td>
                                        <td class='text-right' style='padding:10px;'><?php echo ((isset($data["pplWebsite"]) && !empty($data["pplWebsite"]))?"<a href='{$data["pplWebsite"]}' target='_blank'>Vai al sito web</a>":"<i>Non disponibile</i>") ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <br>
                    <h3 class='text-justify' style='color:red;'><i>Prenota contattando l'offerente di questo servizio</i></h3>
                    <br>
                    <br>
                    <?php echo $MODIFY_BUTTON; ?>
                    <?php echo $DELETE_BUTTON; ?>
                </div>
            </div>
        </div>
        
        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>