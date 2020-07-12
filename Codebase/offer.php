<?php
session_start();

if(!isset($_SESSION["usrID"]) || empty($_SESSION["usrID"]))
{
    header('Location:login.php');
    exit();
}

include("connection.php");
include("logged-user-navbar.php");
include("charset.php");
$category;
$currency;
$prfID;
$offer = array("category"=>"","name"=>"","info"=>"","experience"=>0,"skills"=>"","cost"=>0,"currency"=>"","hourly"=>false,"tobedetermined"=>false,"homeworking"=>false,"mon"=>false,"tue"=>false,"wed"=>false,"thu"=>false,"fri"=>false,"sat"=>false,"sun"=>false,"starttime"=>"","endtime"=>"");
$erroroff=FALSE;
$erroroffmessage="";
$error = array("category"=>"","name"=>"","experience"=>"","cost"=>"","starttime"=>"","endtime"=>"");
$MESSAGE="";
$CATEGORIES="";
$CURRENCIES="";

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

$sql="SELECT catID,catName FROM Categories ORDER BY catName ASC;";
$res=mysqli_query($cn,$sql); // query execution
                        
// reading from db error
if(!$res)
{
    $_SESSION["error"] = "Ops... Ci sono dei problemi con il caricamento della pagina!";
    $_SESSION["errorinfo"] = "Il servizio è temporaneamente non disponibile. Riprovare tra qualche minuto.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}

if(mysqli_num_rows($res) < 1)
{
    $_SESSION["error"] = "Ops... Ci sono dei problemi!";
    $_SESSION["errorinfo"] = "Aireem non riesce a caricare le categorie dei servizi che possono essere offerti. Riprovare tra qualche minuto.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}

// get categories
while($category = mysqli_fetch_assoc($res))
{
    $CATEGORIES.="<option value='".$category["catID"]."' ".($_SESSION["category"]===$category["catID"]?"selected":"").">".$category["catName"]."</option>";
}

/* Now get currencies */
$sql=$res=NULL; // reset variables
$sql="SELECT curID,curCode FROM Currencies ORDER BY curCode ASC;";
$res=mysqli_query($cn,$sql); // query execution
                        
// reading from db error
if(!$res)
{
    $_SESSION["error"] = "Ops... Ci sono dei problemi con il caricamento della pagina!";
    $_SESSION["errorinfo"] = "Il servizio è temporaneamente non disponibile. Riprovare tra qualche minuto.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}

if(mysqli_num_rows($res) < 1)
{
    $_SESSION["error"] = "Ops... Ci sono dei problemi!";
    $_SESSION["errorinfo"] = "Aireem non riesce a caricare le valute dei prezzi per i servizi che possono essere offerti. Riprovare tra qualche minuto.";
    mysqli_close($cn);
    header("Location:error.php");
    exit();
}

// get currencies
while($currency = mysqli_fetch_assoc($res))
{
    $CURRENCIES.="<option value='".$currency["curID"]."' ".($currency["curCode"]=="EUR"?"selected":"").">".($currency["curID"]!=0?$currency["curCode"]:"Other")."</option>";
}
mysqli_close($cn);


/* MANAGE THE OFFER */
// print offer error message if it is set
if(isset($_SESSION["erroroff"]) && !empty($_SESSION["erroroff"]))
{
    $MESSAGE="<div class=\"alert alert-danger\" role=\"alert\"><span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span> ".$_SESSION["erroroff"]."</div>\n";
    $offer["category"]=$_SESSION["category"];
    $offer["name"]=$_SESSION["name"];
    $offer["info"]=$_SESSION["info"];
    $offer["experience"]=$_SESSION["experience"];
    $offer["skills"]=$_SESSION["skills"];
    $offer["cost"]=$_SESSION["cost"];
    $offer["currency"]=$_SESSION["currency"];
    $offer["hourly"]=$_SESSION["hourly"];
    $offer["tobedetermined"]=$_SESSION["tobedetermined"];
    $offer["homeworking"]=$_SESSION["homeworking"];
    $offer["mon"]=$_SESSION["mon"];
    $offer["tue"]=$_SESSION["tue"];
    $offer["wed"]=$_SESSION["wed"];
    $offer["thu"]=$_SESSION["thu"];
    $offer["fri"]=$_SESSION["fri"];
    $offer["sat"]=$_SESSION["sat"];
    $offer["sun"]=$_SESSION["sun"];
    $offer["starttime"]=$_SESSION["starttime"];
    $offer["endtime"]=$_SESSION["endtime"];
    
    $error["category"]=$_SESSION["category_error"];
    $error["name"]=$_SESSION["name_error"];
    $error["experience"]=$_SESSION["experience_error"];
    $error["cost"]=$_SESSION["cost_error"];
    $error["currency"]=$_SESSION["currency_error"];
    $error["starttime"]=$_SESSION["starttime_error"];
    $error["endtime"]=$_SESSION["endtime_error"];
    
    unset($_SESSION["category"]);
    unset($_SESSION["name"]);
    unset($_SESSION["info"]);
    unset($_SESSION["experience"]);
    unset($_SESSION["skills"]);
    unset($_SESSION["cost"]);
    unset($_SESSION["currency"]);
    unset($_SESSION["hourly"]);
    unset($_SESSION["tobedetermined"]);
    unset($_SESSION["homeworking"]);
    unset($_SESSION["mon"]);
    unset($_SESSION["tue"]);
    unset($_SESSION["wed"]);
    unset($_SESSION["thu"]);
    unset($_SESSION["fri"]);
    unset($_SESSION["sat"]);
    unset($_SESSION["sun"]);
    unset($_SESSION["starttime"]);
    unset($_SESSION["endtime"]);
    unset($_SESSION["category_error"]);
    unset($_SESSION["name_error"]);
    unset($_SESSION["experience_error"]);
    unset($_SESSION["cost_error"]);
    unset($_SESSION["currency_error"]);
    unset($_SESSION["starttime_error"]);
    unset($_SESSION["endtime_error"]);
    unset($_SESSION["erroroff"]);
}
else
{
    // check if user started to create an offer, if yes, process POST data
    if(isset($_POST["offering"]) && !empty($_POST["offering"]))
    {
        // errors are set to "" at the beginning
        $_SESSION["category_error"]="";
        $_SESSION["name_error"]="";
        $_SESSION["experience_error"]="";
        $_SESSION["cost_error"]="";
        $_SESSION["currency_error"]="";
        $_SESSION["starttime_error"]="";
        $_SESSION["endtime_error"]="";
        
        // get POST data
        $offer["category"]=$_SESSION["category"]=$_POST["category"];
        $offer["name"]=$_SESSION["name"]=$_POST["name"];
        $offer["info"]=$_SESSION["info"]=$_POST["info"];
        $offer["experience"]=$_SESSION["experience"]=$_POST["experience"];
        $offer["skills"]=$_SESSION["skills"]=$_POST["skills"];
        $offer["cost"]=$_SESSION["cost"]=$_POST["cost"];
        $offer["currency"]=$_SESSION["currency"]=$_POST["currency"];
        $offer["hourly"]=$_SESSION["hourly"]=$_POST["hourly"];
        $offer["tobedetermined"]=$_SESSION["tobedetermined"]=$_POST["tobedetermined"];
        $offer["homeworking"]=$_SESSION["homeworking"]=$_POST["homeworking"];
        $offer["mon"]=$_SESSION["mon"]=$_POST["mon"];
        $offer["tue"]=$_SESSION["tue"]=$_POST["tue"];
        $offer["wed"]=$_SESSION["wed"]=$_POST["wed"];
        $offer["thu"]=$_SESSION["thu"]=$_POST["thu"];
        $offer["fri"]=$_SESSION["fri"]=$_POST["fri"];
        $offer["sat"]=$_SESSION["sat"]=$_POST["sat"];
        $offer["sun"]=$_SESSION["sun"]=$_POST["sun"];
        $offer["starttime"]=$_SESSION["starttime"]=$_POST["starttime"];
        $offer["endtime"]=$_SESSION["endtime"]=$_POST["endtime"];
        
        // check if obligatory data are set
        if(isset($_POST["category"]) && !empty($_POST["category"]) && isset($_POST["name"]) && !empty($_POST["name"]) && isset($_POST["currency"]) && !empty($_POST["currency"]) && isset($_POST["starttime"]) && !empty($_POST["starttime"]) && isset($_POST["endtime"]) && !empty($_POST["endtime"]))
        {
            // check for values' characters to be less than a specified length
            if(strlen($offer["name"])>150)
            {
                $_SESSION["name_error"]="has-error";
                $erroroff=TRUE;
                $erroroffmessage.="- Il nome del servizio non può contenere più di 150 caratteri.<br>";
            }
            if(strlen($offer["experience"])>3 || $offer["experience"]>150 || $offer["experience"]<0 || !preg_match($NUMBERS, $offer["experience"]))
            {
                $_SESSION["experience_error"]="has-error";
                $erroroff=TRUE;
                $erroroffmessage.="- Inserire un numero di anni di esperienza valido.<br>";
            }
            if(strlen($offer["cost"])>12 || $offer["cost"]>1000000000 || $offer["cost"]<0 || !preg_match($DECIMALS, $offer["cost"]))
            {
                $_SESSION["cost_error"]="has-error";
                $erroroff=TRUE;
                $erroroffmessage.="- Il prezzo inserito non è valido.<br>";
            }
            
            if(strlen($offer["starttime"])>5 || !preg_match($TIME, $offer["starttime"]))
            {
                $_SESSION["starttime_error"]="has-error";
                $erroroff=TRUE;
                $erroroffmessage.="- L'orario di inizio servizio immesso non è valido. Inserire secondo la forma HH:mm.<br>";
            }
            
            if(strlen($offer["endtime"])>5 || !preg_match($TIME, $offer["endtime"]))
            {
                $_SESSION["endtime_error"]="has-error";
                $erroroff=TRUE;
                $erroroffmessage.="- L'orario di fine servizio immesso non è valido. Inserire secondo la forma HH:mm.<br>";
            }
            
            // if there are errors, refresh and show message
            if($erroroff)
            {
                $_SESSION["erroroff"] = "Alcuni dati inseriti non sono validi:<br>";
                $_SESSION["erroroff"] .= $erroroffmessage;
                $_SESSION["erroroff"] .= "Reinserire le informazioni nei campi rossi.";
                header("Location:offer.php");
                exit();
            }
            
            // at this point there are no errors. Register new offer into the database
            $cn=mysqli_connect($HOSTDB,$USERDB,$PASSDB,$NAMEDB);
                        
            // db connection error
            if(!$cn)
            {
                $_SESSION["erroroff"] = "Ci sono problemi di connessione. Riprovare tra qualche minuto.";
                mysqli_close($cn);
                header("Location:offer.php");
                exit();
            }
            
            // first: check if performance exists
            // check performance
            $sql="SELECT prfID FROM Performances WHERE prfName='".$offer["name"]."';";
            $res=mysqli_query($cn,$sql); // query execution
            
            // reading from db error
            if(!$res)
            {
                $_SESSION["erroroff"] = "Ci sono problemi con il controllo del servizio che si vuole offrire. Riprovare tra qualche minuto.";
                mysqli_close($cn);
                header("Location:offer.php");
                exit();
            }
            
            // check if the performance selected actually return one row, if not, performance does not exist so create a new one
            if(mysqli_num_rows($res)!=1)
            {
                // second, check if category exist, if it does not, put "Other" (catID=3) in category
                $sql="SELECT catID FROM Categories WHERE catID='".$offer["category"]."';";
                $res=mysqli_query($cn,$sql); // query execution
                
                // reading from db error
                if(!$res)
                {
                    $_SESSION["erroroff"] = "Ci sono problemi con il controllo della categoria del servizio che si vuole offrire. Riprovare tra qualche minuto.";
                    mysqli_close($cn);
                    header("Location:offer.php");
                    exit();
                }
                
                // if actual rows returned are != 1 category does not exist, so put 3 in category (Other)
                if(mysqli_num_rows($res)!=1)
                {
                    $offer["category"]=3; // category is now set to "Other"
                }
                
                
                // third, create a new performance into the database
                $sql="INSERT INTO `Performances` (`prfID`,`prfName`,`prfInfo`,`prfCatID`) VALUES (NULL,'".$offer["name"]."',NULL,'".$offer["category"]."');";
                $res=mysqli_query($cn,$sql); // query execution
                
                // insertion db error
                if(!$res)
                {
                    $_SESSION["erroroff"] = "Ci sono problemi con la creazione del nuovo servizio offerto. Riprovare tra qualche minuto.";
                    mysqli_close($cn);
                    header("Location:offer.php");
                    exit();
                }
                
                
                // four, now take the just-created performance's ID for creating the offer
                $sql="SELECT prfID FROM Performances WHERE prfName='".$offer["name"]."';";
                $res=mysqli_query($cn,$sql); // query execution
                
                // reading from db error
                if(!$res)
                {
                    $_SESSION["erroroff"] = "Ci sono dei problemi di comunicazione a causa della creazione del nuovo servizio offerto. Riprovare tra qualche minuto.";
                    mysqli_close($cn);
                    header("Location:offer.php");
                    exit();
                }
                
                // if returned row is not just one, something failed in the insertion process
                if(mysqli_num_rows($res)!=1)
                {
                    $_SESSION["erroroff"] = "Ci sono stati dei problemi con la registrazione del nuovo servizio offerto. Riprovare tra qualche minuto.";
                    mysqli_close($cn);
                    header("Location:offer.php");
                    exit();
                }
                
                $riga=mysqli_fetch_assoc($res); // take the row
                $prfID=$riga["prfID"];
            }
            else
            {
                $riga=mysqli_fetch_assoc($res); // take the row
                $prfID=$riga["prfID"];
            }
            
            // proceed with the offer registration
            // first, check the currency selected
            $sql="SELECT curID FROM Currencies WHERE curID='".$offer["currency"]."';";
            $res=mysqli_query($cn,$sql); // query execution
            
            // reading from db error
            if(!$res)
            {
                $_SESSION["erroroff"] = "Ci sono problemi con il controllo della valuta scelta per il prezzo del servizio. Riprovare tra qualche minuto.";
                mysqli_close($cn);
                header("Location:offer.php");
                exit();
            }
            
            // if actual rows returned are != 1 currency does not exist, so put 0 in currency (Other - OTH)
            if(mysqli_num_rows($res)!=1)
            {
                $offer["currency"]=0; // currency is now set to "Other - OTH"
            }
            
            // now insert the whole offert into the database
            $usrID=$_SESSION["usrID"];
            $sql="INSERT INTO `Offers` (`offID`,`offInfo`,`offWorkExperience`,`offSkills`,`offCost`,`offHourlyCost`,`offCostToBeDetermined`,`offHomeWorking`,`offMon`,`offTue`,`offWed`,`offThu`,`offFri`,`offSat`,`offSun`,`offStartTime`,`offEndTime`,`offCurID`,`offPrfID`,`offUserID`) VALUES (NULL,'".$offer["info"]."','".$offer["experience"]."','".$offer["skills"]."','".$offer["cost"]."','".($offer["hourly"]?'1':'0')."','".($offer["tobedetermined"]?'1':'0')."','".($offer["homeworking"]?'1':'0')."','".($offer["mon"]?'1':'0')."','".($offer["tue"]?'1':'0')."','".($offer["wed"]?'1':'0')."','".($offer["thu"]?'1':'0')."','".($offer["fri"]?'1':'0')."','".($offer["sat"]?'1':'0')."','".($offer["sun"]?'1':'0')."','".$offer["starttime"]."','".$offer["endtime"]."','".$offer["currency"]."','".$prfID."','".$usrID."');";
            $res=mysqli_query($cn,$sql); // query execution
            
            // reading from db error
            if(!$res)
            {
                $_SESSION["erroroff"] = "Ci sono problemi con la creazione dell'offerta. Riprovare tra qualche minuto.";
                mysqli_close($cn);
                header("Location:offer.php");
                exit();
            }
            
            // everything went good. Now redirect the user to the new offer's page by taking its ID
            $sql="SELECT offID FROM `Offers` WHERE offInfo='".$offer["info"]."' AND offWorkExperience=".$offer["experience"]." AND offSkills='".$offer["skills"]."' AND offCost=".$offer["cost"]." AND offHourlyCost=".($offer["hourly"]?1:0)." AND offCostToBeDetermined=".($offer["tobedetermined"]?1:0)." AND offHomeWorking=".($offer["homeworking"]?1:0)." AND offMon=".($offer["mon"]?1:0)." AND offTue=".($offer["tue"]?1:0)." AND offWed=".($offer["wed"]?1:0)." AND offThu=".($offer["thu"]?1:0)." AND offFri=".($offer["fri"]?1:0)." AND offSat=".($offer["sat"]?1:0)." AND offSun=".($offer["sun"]?1:0)." AND offStartTime='".$offer["starttime"]."' AND offEndTime='".$offer["endtime"]."' AND offCurID=".$offer["currency"]." AND offPrfID=$prfID AND offUserID=$usrID ORDER BY offID DESC LIMIT 1;";
            $res=mysqli_query($cn,$sql); // query execution
            
            // reading from db error
            if(!$res)
            {
                $_SESSION["erroroff"] = "Ci sono stati problemi con la creazione dell'offerta. Riprovare tra qualche minuto.";
                mysqli_close($cn);
                header("Location:offer.php");
                exit();
            }
            
            if(mysqli_num_rows($res)!=1)
            {
                $_SESSION["erroroff"] = "Ci sono stati problemi con la creazione dell'offerta. Riprovare tra qualche minuto.";
                mysqli_close($cn);
                header("Location:offer.php");
                exit();
            }
            
            $riga=mysqli_fetch_assoc($res);
            $offID=$riga["offID"];
            
            // post a review so rating system works
            $sql="INSERT INTO `Reviews` (`revID`,`revTitle`,`revRating`,`revComment`,`revDate`,`revOffID`,`revUserID`) VALUES (NULL,'Servizio appena creato','0','Il servizio è stato appena creato.','".date('Y-m-d H:i:s')."','".$offID."','4');";
            $res=mysqli_query($cn,$sql); // query execution
            
            // reading from db error
            if(!$res)
            {
                $_SESSION["erroroff"] = "Ci sono stati problemi con la creazione dell'offerta. Riprovare tra qualche minuto.";
                mysqli_close($cn);
                header("Location:offer.php");
                exit();
            }
            
            mysqli_close($cn); // close connection
            header("Location:service.php?id=$offID");
            exit();
        }
        else
        {
            // check all the fields and put errors in session
            if(!isset($_POST["category"]) || empty($_POST["category"]))
            {
                $_SESSION["category_error"]="has-error";
            }
            
            if(!isset($_POST["name"]) || empty($_POST["name"]))
            {
                $_SESSION["name_error"]="has-error";
            }
            
            if(!isset($_POST["currency"]) || empty($_POST["currency"]))
            {
                $_SESSION["currency_error"]="has-error";
            }
            
            if(!isset($_POST["starttime"]) || empty($_POST["starttime"]))
            {
                $_SESSION["starttime_error"]="has-error";
            }
            
            if(!isset($_POST["endtime"]) || empty($_POST["endtime"]))
            {
                $_SESSION["endtime_error"]="has-error";
            }
            
            $_SESSION["erroroff"] = "Mancano alcuni dati del servizio che si vuole offrire. Inserire le informazioni nei campi rossi.";
            header("Location:offer.php");
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
        <title>Aireem - Offri un servizio</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
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
                <div class='col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3'>
                    <h1 class='text-center'>Offri un servizio</h1>
                    <br>
                    <?php echo $MESSAGE; ?>
                    <h6 class='text-right'>* - Campo obbligaotrio</h6>
                    <form id='offer-service-form' name='offer-service' action='offer.php' method='post' enctype='multipart/form-data'>
                        <div class='form-group <?php echo $error["category"]; ?>'>
            			    <div id='selectCategory' class='selectContainer'>
                                <select required class='form-control' name='category' id='category'>
                                    <option value=''>* Seleziona la categoria...</option>
                                    <option role='separator' class='divider' disabled></option>
                                    <?php echo $CATEGORIES; ?>
                                </select>
                            </div>
            			</div>
            			<div class='form-group <?php echo $error["name"]; ?>'>
            				<input required type='text' name='name' id='name' class='form-control' placeholder='* Il servizio che offri, es: babysitter, idraulico, programmatore, ecc...' value='<?php echo $offer["name"]; ?>'>
            			</div>
            			<div class='form-group'>
            				<textarea class='form-control' name='info' id='info' rows='5' placeholder='Scrivi qualche informazione sul servizio che offri...'><?php echo $offer["info"]; ?></textarea>
            			</div>
            			<hr>
            			<div class='form-group <?php echo $error["experience"]; ?>'>
            			    <div class='row'>
            			        <div class='col-lg-4 col-md-4 col-sm-4'>
            			            <label for='experience' style='display:inline-block;'>Anni di esperienza:&nbsp;&nbsp;&nbsp;</label>
            			        </div>
            			        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-4'>
            			            <input type='number' class='form-control text-right' name='experience' id='experience' min='0' max='150' style='display:inline-block;' value='<?php echo ((isset($offer["experience"]) && !empty($offer["experience"]))?$offer["experience"]:0) ?>'>
            			        </div>
            			    </div>
            			</div>
            			<div class='form-group'>
            			    <label for='skills'>Competenze nel campo:&nbsp;&nbsp;&nbsp;</label>
            				<textarea class='form-control' name='skills' id='skills' rows='5' placeholder='Es: Public Speaking, Sviluppo front-end CSS, Full Stack Developer...'><?php echo $offer["skills"]; ?></textarea>
            			</div>
            			<div class='form-group <?php echo $error["cost"]; ?>'>
            			    <div class='row'>
            			        <div class='col-lg-2 col-md-2 col-sm-2'>
            			            <label for='cost' style='display:inline-block;'>Prezzo:&nbsp;&nbsp;&nbsp;</label>
            			        </div>
            			        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-4'>
            			            <input type='number' class='form-control text-right' name='cost' id='cost' min='0' max='1000000000' style='display:inline-block;' value='<?php echo ((isset($offer["cost"]) && !empty($offer["cost"]))?$offer["cost"]:10) ?>'>
            			        </div>
            			        <div class='col-lg-2 col-md-2 col-sm-2 col-xs-4'>
            			            <div id='selectCurrency' class='selectContainer' style='display:inline-block;'>
                                        <select required class='form-control' name='currency' id='currency'>
                                            <?php echo $CURRENCIES; ?>
                                        </select>
                                    </div>
            			        </div>
            			        <div class='col-lg-6 col-md-6 col-sm-12 col-xs-12'>
                			        <div style='display:inline-block;'>
                        			    <div class='checkbox'>
                                            <label>
                                                <input type='checkbox' name='hourly' id='hourly' <?php echo ($offer["hourly"]?'checked':''); ?>> Costo orario&nbsp;&nbsp;&nbsp;
                                            </label>
                                        </div>
                        			</div>
                        			<div style='display:inline-block'>
                        			    <div id="HourlyQuestion" class="glyphicon glyphicon-question-sign" style="cursor:pointer;display:inline-block;font-size:20px;"></div>
                        			</div>
                    			</div>
            			    </div>
            			</div>
            			<div class='form-group'>
            			    <table border='0' width='100%'>
            			        <tr>
            			            <td><b style='font-size:14px;'>Prezzo trattabile</b></td>
            			            <td>
            			                <div class='checkbox'>
                                            <label>
                                                <input type='checkbox' name='tobedetermined' id='tobedetermined' <?php echo ($offer["tobedetermined"]?'checked':''); ?>>
                                            </label>
                                        </div>
            			            </td>
            			            <td><div id="TobedeterminedQuestion" class="glyphicon glyphicon-question-sign pull-right" style="cursor:pointer;display:inline-block;font-size:20px;"></div></td>
            			        </tr>
            			        <tr>
            			            <td><b style='font-size:14px;'>Servizio a domicilio</b></td>
            			            <td>
            			                <div class='checkbox'>
                                            <label>
                                                <input type='checkbox' name='homeworking' id='homeworking' <?php echo ($offer["homeworking"]?'checked':''); ?>>
                                            </label>
                                        </div>
            			            </td>
            			            <td><div id="HomeworkingQuestion" class="glyphicon glyphicon-question-sign pull-right" style="cursor:pointer;display:inline-block;font-size:20px;"></div></td>
            			        </tr>
            			    </table>
            			</div>
            			<hr>
            			<h4>Disponibilità</h4>
            			<div class='form-group'>
                			<table border='0' width='100%'>
                			    <tr>
                			        <td><b style='font-size:14px;'>Giorni:</b></td>
                			        <td>
                			            <div class='checkbox'>
                                            <label>
                                                <input type='checkbox' name='mon' id='mon' <?php echo ($offer["mon"]?'checked':''); ?>> Lun
                                            </label>
                                        </div>
                			        </td>
                			        <td>
                			            <div class='checkbox'>
                                            <label>
                                                <input type='checkbox' name='tue' id='tue' <?php echo ($offer["tue"]?'checked':''); ?>> Mar
                                            </label>
                                        </div>
                			        </td>
                			        <td>
                			            <div class='checkbox'>
                                            <label>
                                                <input type='checkbox' name='wed' id='wed' <?php echo ($offer["wed"]?'checked':''); ?>> Mer
                                            </label>
                                        </div>
                			        </td>
                			    </tr>
                			    <tr>
                			        <td><b style='font-size:14px;'></b></td>
                			        <td>
                			            <div class='checkbox'>
                                            <label>
                                                <input type='checkbox' name='thu' id='thu' <?php echo ($offer["thu"]?'checked':''); ?>> Gio
                                            </label>
                                        </div>
                			        </td>
                			        <td>
                			            <div class='checkbox'>
                                            <label>
                                                <input type='checkbox' name='fri' id='fri' <?php echo ($offer["fri"]?'checked':''); ?>> Ven
                                            </label>
                                        </div>
                			        </td>
                			        <td>
                			            <div class='checkbox'>
                                            <label>
                                                <input type='checkbox' name='sat' id='sat' <?php echo ($offer["sat"]?'checked':''); ?>> Sab
                                            </label>
                                        </div>
                			        </td>
                			    </tr>
                			    <tr>
                			        <td><b style='font-size:14px;'></b></td>
                			        <td>
                			            <div class='checkbox'>
                                            <label>
                                                <input type='checkbox' name='sun' id='sun' <?php echo ($offer["sun"]?'checked':''); ?>> Dom
                                            </label>
                                        </div>
                			        </td>
                			        <td></td>
                			        <td></td>
                			    </tr>
                			</table>
            			</div>
            			    <label for='timeslot'>Fascia oraria</label>
            			    <p class='text-justify'>L'orario entro cui si possono svolgere una o più prestazioni.</p>
            			    <div class='row'>
            			        <div class='form-group <?php echo $error["starttime"]; ?>' style='margin-bottom:0px;'>
                			        <div class='col-lg-1 col-md-1 col-sm-1 col-xs-12' style='display:inline-block;'>
                    			        <div>Dalle:</div>
                		            </div>
                			        <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6' style='display:inline-block;'>
                    			        <div class='input-group date' id='start-timepicker'>
                        					<input required type='text' class='form-control' name='starttime' id='starttime' placeholder='09:00' value='<?php echo $offer["starttime"]; ?>'>
                        					<span class='input-group-addon'>
                                                <span class='glyphicon glyphicon-time'></span>
                                            </span>
                    		            </div>
                		            </div>
            		            </div>
            		            <div class='form-group <?php echo $error["endtime"]; ?>'>
                		            <div class='col-lg-1 col-lg-offset-4 col-md-1 col-md-offset-4 col-sm-1 col-sm-offset-4 col-xs-12' style='display:inline-block;'>
                    			        <div>alle:</div>
                		            </div>
                			        <div class='col-lg-3 col-md-3 col-sm-3 col-xs-6' style='display:inline-block;'>
                    			        <div class='input-group date' id='end-timepicker'>
                        					<input required type='text' class='form-control' name='endtime' id='endtime' placeholder='18:00' value='<?php echo $offer["endtime"]; ?>'>
                        					<span class='input-group-addon'>
                                                <span class='glyphicon glyphicon-time'></span>
                                            </span>
                    		            </div>
                		            </div>
            		            </div>
            			    </div>
            			<div class='form-group'>
                            <input type='hidden' name='offering' id='offering' value='1'>
                        </div>
            			<br>
            			<button type='submit' class='btn btn-success btn-lg' style='width:100%;'>Crea l'offerta</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- JavaScript -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="jquery/jquery-3.2.0.min.js"></script>
    	<script src="jquery/moment.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="jquery/bootstrap-datetimepicker.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="jquery/jquery.mousewheel.js"></script>
        <!-- Custom JS -->
        <script type="text/javascript">
            $(document).ready(function() { $(function() {
                $('#start-timepicker').datetimepicker({
              		format: 'HH:mm'
              		});
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() { $(function() {
                $('#end-timepicker').datetimepicker({
              		format: 'HH:mm'
              		});
                });
            });
        </script>
        <script type="text/javascript">
            $("#HourlyQuestion").on("click", function () {
                alert('Seleziona la casella "Costo orario" se il prezzo che hai stabilito è una tariffa oraria');
            });
        </script>
        <script type="text/javascript">
            $("#TobedeterminedQuestion").on("click", function () {
                alert('Seleziona la casella "Prezzo trattabile" se il prezzo che hai stabilito può essere trattato con il cliente');
            });
        </script>
        <script type="text/javascript">
            $("#HomeworkingQuestion").on("click", function () {
                alert('Seleziona la casella "Servizio a domicilio" se il servizio che offri si effettua presso la casa del cliente');
            });
        </script>
    </body>
</html>