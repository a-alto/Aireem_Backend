<?php
    session_start();
    
    if(isset($_SESSION["usrID"]) && !empty($_SESSION["usrID"]))
    {
        header('Location:/');
        exit();
    }
    
    date_default_timezone_set('Europe/Rome'); // set timezone
    include("connection.php");
    include("visitor-navbar.php");
    include("charset.php");
    $person = array("name"=>"","surname"=>"","email"=>"","username"=>"","password"=>"","repassword"=>"","birthdate"=>"","gender"=>"","qualification"=>"","occupation"=>"","bio"=>"","address"=>"","housenumber"=>"","apartmentinfo"=>"","city"=>"","zipcode"=>"","state"=>"","country"=>"","tel"=>"","cell"=>"","linkedin"=>"","website"=>"");
    $errorreg=FALSE;
    $errormessage="";
    $MESSAGE="";
    $name_error="";
    $surname_error="";
    $email_error="";
    $username_error="";
    $password_error="";
    $repassword_error="";
    $birthdate_error="";
    $address_error="";
    $housenumber_error="";
    $city_error="";
    $zipcode_error="";
    $country_error="";
    $tel_error="";
    $cell_error="";
    $REGISTRATION="";
    
    if(isset($_GET["t"]) && !empty($_GET["t"]) && ($_GET["t"]==1 || $_GET["t"]==2))
    {
        // print registration error message if it is set
        if(isset($_SESSION["errorreg"]) && !empty($_SESSION["errorreg"]))
        {
            $MESSAGE="<div class=\"alert alert-danger\" role=\"alert\"><span class=\"glyphicon glyphicon-exclamation-sign\" aria-hidden=\"true\"></span> ".$_SESSION["errorreg"]."</div>\n";
            $person["name"]=$_SESSION["name"];
            $person["surname"]=$_SESSION["surname"];
            $person["email"]=$_SESSION["email"];
            $person["username"]=$_SESSION["username"];
            $person["birthdate"]=$_SESSION["birthdate"];
            $person["gender"]=$_SESSION["gender"];
            $person["qualification"]=$_SESSION["qualification"];
            $person["occupation"]=$_SESSION["occupation"];
            $person["bio"]=$_SESSION["bio"];
            $person["address"]=$_SESSION["address"];
            $person["housenumber"]=$_SESSION["housenumber"];
            $person["apartmentinfo"]=$_SESSION["apartmentinfo"];
            $person["city"]=$_SESSION["city"];
            $person["zipcode"]=$_SESSION["zipcode"];
            $person["state"]=$_SESSION["state"];
            $person["country"]=$_SESSION["country"];
            $person["tel"]=$_SESSION["tel"];
            $person["cell"]=$_SESSION["cell"];
            $person["linkedin"]=$_SESSION["linkedin"];
            $person["website"]=$_SESSION["website"];
            $name_error=$_SESSION["name_error"];
            $surname_error=$_SESSION["surname_error"];
            $email_error=$_SESSION["email_error"];
            $username_error=$_SESSION["username_error"];
            $password_error=$_SESSION["password_error"];
            $repassword_error=$_SESSION["repassword_error"];
            $birthdate_error=$_SESSION["birthdate_error"];
            $address_error=$_SESSION["address_error"];
            $housenumber_error=$_SESSION["housenumber_error"];
            $city_error=$_SESSION["city_error"];
            $zipcode_error=$_SESSION["zipcode_error"];
            $country_error=$_SESSION["country_error"];
            $tel_error=$_SESSION["tel_error"];
            $cell_error=$_SESSION["cell_error"];
            unset($_SESSION["name"]);
            unset($_SESSION["surname"]);
            unset($_SESSION["email"]);
            unset($_SESSION["username"]);
            unset($_SESSION["birthdate"]);
            unset($_SESSION["gender"]);
            unset($_SESSION["qualification"]);
            unset($_SESSION["occupation"]);
            unset($_SESSION["bio"]);
            unset($_SESSION["address"]);
            unset($_SESSION["housenumber"]);
            unset($_SESSION["apartmentinfo"]);
            unset($_SESSION["city"]);
            unset($_SESSION["zipcode"]);
            unset($_SESSION["state"]);
            unset($_SESSION["country"]);
            unset($_SESSION["tel"]);
            unset($_SESSION["cell"]);
            unset($_SESSION["linkedin"]);
            unset($_SESSION["website"]);
            unset($_SESSION["errorreg"]);
            unset($_SESSION["name_error"]);
            unset($_SESSION["surname_error"]);
            unset($_SESSION["email_error"]);
            unset($_SESSION["username_error"]);
            unset($_SESSION["password_error"]);
            unset($_SESSION["repassword_error"]);
            unset($_SESSION["birthdate_error"]);
            unset($_SESSION["address_error"]);
            unset($_SESSION["housenumber_error"]);
            unset($_SESSION["city_error"]);
            unset($_SESSION["zipcode_error"]);
            unset($_SESSION["country_error"]);
            unset($_SESSION["tell_error"]);
            unset($_SESSION["cell_error"]);
        }
        else
        {
            // registration
            if(isset($_POST["type"]) && !empty($_POST["type"]))
            {
                // errors are set to "" at the beginning
                $_SESSION["name_error"]="";
                $_SESSION["surname_error"]="";
                $_SESSION["email_error"]="";
                $_SESSION["username_error"]="";
                $_SESSION["password_error"]="";
                $_SESSION["repassword_error"]="";
                $_SESSION["birthdate_error"]="";
                $_SESSION["address_error"]="";
                $_SESSION["housenumber_error"]="";
                $_SESSION["city_error"]="";
                $_SESSION["zipcode_error"]="";
                $_SESSION["country_error"]="";
                $_SESSION["tel_error"]="";
                $_SESSION["cell_error"]="";
                
                // for individuals
                if($_POST["type"]==1)
                {
                    // get POST data
                    $_SESSION["name"]=$person["name"]=$_POST["name"];
                    $_SESSION["surname"]=$person["surname"]=$_POST["surname"];
                    $_SESSION["email"]=$person["email"]=$_POST["email"];
                    $_SESSION["username"]=$person["username"]=$_POST["username"];
                    $person["password"]=$_POST["password"]; // password and repassword do not go into the session
                    $person["repassword"]=$_POST["repassword"];
                    $_SESSION["birthdate"]=$person["birthdate"]=$_POST["birthdate"];
                    $_SESSION["gender"]=$person["gender"]=$_POST["gender"];
                    $_SESSION["qualification"]=$person["qualification"]=$_POST["qualification"];
                    $_SESSION["occupation"]=$person["occupation"]=$_POST["occupation"];
                    $_SESSION["bio"]=$person["bio"]=$_POST["bio"];
                    $_SESSION["address"]=$person["address"]=$_POST["address"];
                    $_SESSION["housenumber"]=$person["housenumber"]=$_POST["housenumber"];
                    $_SESSION["apartmentinfo"]=$person["apartmentinfo"]=$_POST["apartmentinfo"];
                    $_SESSION["city"]=$person["city"]=$_POST["city"];
                    $_SESSION["zipcode"]=$person["zipcode"]=$_POST["zipcode"];
                    $_SESSION["state"]=$person["state"]=$_POST["state"];
                    $_SESSION["country"]=$person["country"]=$_POST["country"];
                    $_SESSION["tel"]=$person["tel"]=$_POST["tel"];
                    $_SESSION["cell"]=$person["cell"]=$_POST["cell"];
                    $_SESSION["linkedin"]=$person["linkedin"]=$_POST["linkedin"];
                    $_SESSION["website"]=$person["website"]=$_POST["website"];
                    
                    if(isset($_POST["name"]) && !empty($_POST["name"]) && isset($_POST["surname"]) && !empty($_POST["surname"]) && isset($_POST["email"]) && !empty($_POST["email"]) && isset($_POST["username"]) && !empty($_POST["username"]) && isset($_POST["password"]) && !empty($_POST["password"]) && isset($_POST["repassword"]) && !empty($_POST["repassword"]) && isset($_POST["birthdate"]) && !empty($_POST["birthdate"]) && isset($_POST["address"]) && !empty($_POST["address"]) && isset($_POST["housenumber"]) && !empty($_POST["housenumber"]) && isset($_POST["city"]) && !empty($_POST["city"]) && isset($_POST["zipcode"]) && !empty($_POST["zipcode"]) && isset($_POST["country"]) && !empty($_POST["country"]))
                    {
                        // check for values' characters to be less than a specified length
                        if(strlen($person["email"])>100)
                        {
                            $_SESSION["email_error"]="has-error";
                            $errorreg=TRUE;
                            $errormessage.="- L'email non può essere più lunga di 100 caratteri.<br>";
                        }
                        if(strlen($person["password"])>100)
                        {
                            $_SESSION["password_error"]="has-error";
                            $errorreg=TRUE;
                            $errormessage.="- La password non può essere più lunga di 100 caratteri.<br>";
                        }
                        if(strlen($person["username"])>100)
                        {
                            $_SESSION["username_error"]="has-error";
                            $errorreg=TRUE;
                            $errormessage.="- L'username non può essere più lungo di 100 caratteri.<br>";
                        }
                        if(strlen($person["housenumber"])>5)
                        {
                            $_SESSION["housenumber_error"]="has-error";
                            $errorreg=TRUE;
                            $errormessage.="- Il numero civico non può contenere più di 5 caratteri.<br>";
                        }
                        if(strlen($person["tel"])>18)
                        {
                            $_SESSION["tel_error"]="has-error";
                            $errorreg=TRUE;
                            $errormessage.="- Il numero di telefono non può contenere più di 18 caratteri.<br>";
                        }
                        if(strlen($person["cell"])>18)
                        {
                            $_SESSION["cell_error"]="has-error";
                            $errorreg=TRUE;
                            $errormessage.="- Il numero di cellulare non può contenere più di 18 caratteri.<br>";
                        }
                        
                        // check if password and re-typed password correspond
                        if($person["password"]!==$person["repassword"])
                        {
                            $_SESSION["password_error"]="has-error";
                            $_SESSION["repassword_error"]="has-error";
                            $errorreg=TRUE;
                            $errormessage.="- Le password immesse non corrispondono.<br>";
                        }
                        
                        // check name for errors
                        if(!preg_match($LETTERS, $person["name"]))
                        {
                            $_SESSION["name_error"]="has-error";
                            $errorreg=TRUE;
                            $errormessage.="- Immettere un nome valido.<br>";
                        }
                        
                        // check surname for errors
                        if(!preg_match($LETTERS, $person["surname"]))
                        {
                            $_SESSION["surname_error"]="has-error";
                            $errorreg=TRUE;
                            $errormessage.="- Immettere un cognome valido.<br>";
                        }
                        
                        // check tel for errors
                        if(!preg_match($TELEFONIC, $person["tel"]))
                        {
                            $_SESSION["tel_error"]="has-error";
                            $errorreg=TRUE;
                            $errormessage.="- Immettere un numero telefonico valido.<br>";
                        }
                        
                        // check cell for errors
                        if(!preg_match($TELEFONIC, $person["cell"]))
                        {
                            $_SESSION["cell_error"]="has-error";
                            $errorreg=TRUE;
                            $errormessage.="- Immettere un di cellulare valido.<br>";
                        }
                        
                        // check birthdate for errors (date format)
                        if(!preg_match($DATE, $person["birthdate"]))
                        {
                            $_SESSION["birthdate_error"]="has-error";
                            $errorreg=TRUE;
                            $errormessage.="- La data deve essere nel formato YYYY-MM-DD.<br>";
                        }
                        else
                        {
                            // check birthdate for errors (user must be at least 16 years old to get signed up)
                            list($year, $month, $day) = split('[-]', $person["birthdate"]);

                            if((date('Y')-$year)==16)
                            {
                                if((date('m')-$month)==0)
                                {
                                    if((date('d')-$day)<0)
                                    {
                                        $_SESSION["birthdate_error"]="has-error";
                                        $errorreg=TRUE;
                                        $errormessage.="- Per iscriversi bisogna avere almeno 16 anni.<br>";
                                    }
                                }
                                else if((date('m')-$month)<0)
                                {
                                    $_SESSION["birthdate_error"]="has-error";
                                    $errorreg=TRUE;
                                    $errormessage.="- Per iscriversi bisogna avere almeno 16 anni.<br>";
                                }
                            }
                            else if((date('Y')-$year)<16)
                            {
                                $_SESSION["birthdate_error"]="has-error";
                                $errorreg=TRUE;
                                $errormessage.="- Per iscriversi bisogna avere almeno 16 anni.<br>";
                            }
                        }
                        
                        // if there are errors, refresh and show message
                        if($errorreg)
                        {
                            $_SESSION["errorreg"] = "Alcuni dati inseriti non sono validi:<br>";
                            $_SESSION["errorreg"] .= $errormessage;
                            $_SESSION["errorreg"] .= "Reinserire le informazioni nei campi rossi.";
                            header("Location:signup.php?t=1");
                            exit();
                        }
                        
                        // at this point there are no errors. Register new user into the database
                        // DB connection
                        $cn=mysqli_connect($HOSTDB,$USERDB,$PASSDB,$NAMEDB);
                        
                        // db connection error
                        if(!$cn)
                        {
                            $_SESSION["errorreg"] = "Ci sono problemi di connessione. Riprovare tra qualche minuto.";
                            mysqli_close($cn);
                            header("Location:signup.php?t=1");
                            exit();
                        }
                        
                        // first: check if email or username already exist
                        // check email
                        $sqlEmail="SELECT usrRegistrationDate FROM Users WHERE usrEmail='".$person["email"]."';";
                        $resEmail=mysqli_query($cn,$sqlEmail); // query execution
                        
                        // reading from db error
                        if(!$resEmail)
                        {
                            $_SESSION["errorreg"] = "Ci sono problemi con il controllo dell'email. Riprovare tra qualche minuto.";
                            mysqli_close($cn);
                            header("Location:signup.php?t=1");
                            exit();
                        }
                        
                        if(mysqli_num_rows($resEmail) > 0)
                        {
                            $_SESSION["email_error"]="has-error";
                            $errormessage.="- Un altro utente è registrato con l'email immessa. Inserire un altro indirizzo email valido.<br>";
                            $_SESSION["errorreg"] = "Alcuni dati inseriti non sono validi:<br>";
                            $_SESSION["errorreg"] .= $errormessage;
                            $_SESSION["errorreg"] .= "Reinserire le informazioni nei campi rossi.";
                            mysqli_close($cn);
                            header("Location:signup.php?t=1");
                            exit();
                        }
                        
                        // check username
                        $sqlUsername="SELECT usrRegistrationDate FROM Users WHERE usrUsername='".$person["username"]."';";
                        $resUsername=mysqli_query($cn,$sqlUsername); // query execution
                        
                        // reading from db error
                        if(!$resUsername)
                        {
                            $_SESSION["errorreg"] = "Ci sono problemi con il controllo dell'username. Riprovare tra qualche minuto.";
                            mysqli_close($cn);
                            header("Location:signup.php?t=1");
                            exit();
                        }
                        
                        if(mysqli_num_rows($resUsername) > 0)
                        {
                            $_SESSION["username_error"]="has-error";
                            $errormessage.="- Un altro utente è registrato con l'username immesso. Inserire un altro username valido.<br>";
                            $_SESSION["errorreg"] = "Alcuni dati inseriti non sono validi:<br>";
                            $_SESSION["errorreg"] .= $errormessage;
                            $_SESSION["errorreg"] .= "Reinserire le informazioni nei campi rossi.";
                            mysqli_close($cn);
                            header("Location:signup.php?t=1");
                            exit();
                        }
                        
                        $sql="SELECT cyID FROM Cities WHERE cyCountry='".$person["country"]."' AND cyState='".$person["state"]."' AND cyZipCode='".$person["zipcode"]."' AND cyName='".$person["city"]."';";
            
                        $res=mysqli_query($cn,$sql); // query execution
                        
                        // reading from db error
                        if(!$res)
                        {
                            $_SESSION["errorreg"] = "Ci sono problemi di acquisizione dati. Riprovare tra qualche minuto.";
                            mysqli_close($cn);
                            header("Location:signup.php?t=1");
                            exit();
                        }
                        
                        // number of rows: if it is <1 city does not exist so insert a new one
                        if (mysqli_num_rows($res) < 1)
                        {
                            // city not found: insert a new one
                            $sqlInsertion="INSERT INTO `Cities` (`cyID`,`cyName`,`cyZipCode`,`cyState`,`cyCountry`) VALUES (NULL,'".$person["city"]."','".$person["zipcode"]."','".$person["state"]."','".$person["country"]."');";
            
                            $resInsertion=mysqli_query($cn,$sqlInsertion); // query execution
                            
                            // reading from db error
                            if(!$resInsertion)
                            {
                                $_SESSION["errorreg"] = "Ci sono problemi nella registrazione della città inserita. Riprovare tra qualche minuto.";
                                mysqli_close($cn);
                                header("Location:signup.php?t=1");
                                exit();
                            }
                            
                            
                            // now select the city
                            $sqlSelect="SELECT cyID FROM Cities WHERE cyCountry='".$person["country"]."' AND cyState='".$person["state"]."' AND cyZipCode='".$person["zipcode"]."' AND cyName='".$person["city"]."';";
            
                            $resSelect=mysqli_query($cn,$sqlSelect); // query execution
                            
                            // reading from db error
                            if(!$resSelect)
                            {
                                $_SESSION["errorreg"] = "Ci sono problemi di acquisizione dati. Riprovare tra qualche minuto.";
                                mysqli_close($cn);
                                header("Location:signup.php?t=1");
                                exit();
                            }
                            
                            // check the number of rows returned
                            if(mysqli_num_rows($resSelect) < 1)
                            {
                                $_SESSION["errorreg"] = "Errore di registrazione della città. Riprovare tra qualche minuto.";
                                mysqli_close($cn);
                                header("Location:signup.php?t=1");
                                exit();
                            }
                            
                            $riga = mysqli_fetch_assoc($resSelect);
                        }
                        else
                        {
                            $riga = mysqli_fetch_assoc($res);
                        }
                        
                        $cyID=$riga["cyID"]; // take cyID to insert the new person
                        
                        // insert new person
                        $sqlPerson="INSERT INTO `People` (`pplPersonCode`,`pplName`,`pplSurname`,`pplBirthdate`,`pplGender`,`pplQualification`,`pplOccupation`,`pplBio`,`pplAddress`,`pplHouseNumber`,`pplApartmentInfo`,`pplTel`,`pplCell`,`pplLinkedin`,`pplWebsite`,`pplCyID`) VALUES (NULL,'".$person["name"]."','".$person["surname"]."','".$person["birthdate"]."','".$person["gender"]."','".$person["qualification"]."','".$person["occupation"]."','".$person["bio"]."','".$person["address"]."','".$person["housenumber"]."','".$person["apartmentinfo"]."','".$person["tel"]."','".$person["cell"]."','".$person["linkedin"]."','".$person["website"]."','".$cyID."');";
            
                        $resPerson=mysqli_query($cn,$sqlPerson); // query execution
                            
                        // reading from db error
                        if(!$resPerson)
                        {
                            $_SESSION["errorreg"] = "Ci sono problemi nella registrazione dei dati. Riprovare tra qualche minuto.";
                            mysqli_close($cn);
                            header("Location:signup.php?t=1");
                            exit();
                        }
                        
                        // select the inserted person to get her/his ID
                        $sqlSelPerson="SELECT pplPersonCode FROM People WHERE pplName='".$person["name"]."' AND pplSurname='".$person["surname"]."' AND pplBirthdate='".$person["birthdate"]."' AND pplGender='".$person["gender"]."' AND pplQualification='".$person["qualification"]."' AND pplOccupation='".$person["occupation"]."' AND pplBio='".$person["bio"]."' AND pplAddress='".$person["address"]."' AND pplHouseNumber='".$person["housenumber"]."' AND pplApartmentInfo='".$person["apartmentinfo"]."' AND pplTel='".$person["tel"]."' AND pplCell='".$person["cell"]."' AND pplLinkedin='".$person["linkedin"]."' AND pplWebsite='".$person["website"]."' AND pplCyID=$cyID;";
            
                        $resSelPerson=mysqli_query($cn,$sqlSelPerson); // query execution
                            
                        // reading from db error
                        if(!$resSelPerson)
                        {
                            $_SESSION["errorreg"] = "Ci sono problemi nell'acquisizione dei dati inseriti. Riprovare tra qualche minuto.";
                            mysqli_close($cn);
                            header("Location:signup.php?t=1");
                            exit();
                        }
                        
                        // check the number of rows returned
                        if(mysqli_num_rows($resSelPerson) < 1)
                        {
                            $_SESSION["errorreg"] = "Errore di registrazione dei dati. Riprovare tra qualche minuto.";
                            mysqli_close($cn);
                            header("Location:signup.php?t=1");
                            exit();
                        }
                            
                        $riga = mysqli_fetch_assoc($resSelPerson);
                        $pplPersonCode = $riga["pplPersonCode"]; // get pplPerson code
                        
                        // insert new user
                        $sqlUser="INSERT INTO `Users` (`usrID`,`usrEmail`,`usrPassword`,`usrUsername`,`usrProPic`,`usrPremium`,`usrRegistrationDate`,`usrIPAddress`,`usrPersonCode`,`usrP_Iva`) VALUES (NULL,'".$person["email"]."','".$person["password"]."','".$person["username"]."','images/default-propic.png','0','".date('Y-m-d H:i:s')."',NULL,'$pplPersonCode',NULL);";
            
                        $resUser=mysqli_query($cn,$sqlUser); // query execution
                            
                        // reading from db error
                        if(!$resUser)
                        {
                            $_SESSION["errorreg"] = "Ci sono problemi nella registrazione del nuovo utente. Riprovare tra qualche minuto.";
                            mysqli_close($cn);
                            header("Location:signup.php?t=1");
                            exit();
                        }
                        
                        // Everything has gone well, login the new user
                        $sqlLogin="SELECT * FROM Users WHERE usrEmail='".$person["email"]."'";
            
                        $resLogin=mysqli_query($cn,$sqlLogin); // query execution
                        
                        // reading from db error
                        if(!$resLogin)
                        {
                            $_SESSION["errorreg"] = "Ci sono stati problemi con l'accesso automatico tramite il nuovo utente. Effettuare il login.";
                            mysqli_close($cn);
                            header("Location:signup.php?t=1");
                            exit();
                        }
                        
                        // number of rows
                        if (mysqli_num_rows($resLogin) != 1)
                        {
                            $_SESSION["errorreg"] = "Ci sono stati problemi con l'accesso automatico tramite il nuovo utente. Effettuare il login.";
                            mysqli_close($cn);
                            header("Location:signup.php?t=1");
                            exit();
                        }
                        
                        $riga = mysqli_fetch_assoc($resLogin);
                        
                        // put data in session and go to the home page
                        $_SESSION["usrID"] = $riga["usrID"];
                        $_SESSION["usrEmail"] = $email;
                        $_SESSION["usrUsername"] = $riga["usrUsername"];
                        $_SESSION["usrProPic"] = $riga["usrProPic"];
                        $_SESSION["usrPremium"] = $riga["usrPremium"];
                        $_SESSION["usrPersonCode"] = $riga["usrPersonCode"];
                        $_SESSION["usrP_Iva"] = $riga["usrP_Iva"];
                        mysqli_close($cn);
                        header('Location:/');
                        exit();
                    }
                    else
                    {
                        // check all the fields and put errors in session
                        if(!isset($_POST["name"]) || empty($_POST["name"]))
                        {
                            $_SESSION["name_error"]="has-error";
                        }
                        
                        if(!isset($_POST["surname"]) || empty($_POST["surname"]))
                        {
                            $_SESSION["surname_error"]="has-error";
                        }
                        
                        if(!isset($_POST["email"]) || empty($_POST["email"]))
                        {
                            $_SESSION["email_error"]="has-error";
                        }
                        
                        if(!isset($_POST["username"]) || empty($_POST["username"]))
                        {
                            $_SESSION["username_error"]="has-error";
                        }
                        
                        if(!isset($_POST["password"]) || empty($_POST["password"]))
                        {
                            $_SESSION["password_error"]="has-error";
                        }
                        
                        if(!isset($_POST["repassword"]) || empty($_POST["repassword"]))
                        {
                            $_SESSION["repassword_error"]="has-error";
                        }
                        
                        if(!isset($_POST["birthdate"]) || empty($_POST["birthdate"]))
                        {
                            $_SESSION["birthdate_error"]="has-error";
                        }
                        
                        if(!isset($_POST["address"]) || empty($_POST["address"]))
                        {
                            $_SESSION["address_error"]="has-error";
                        }
                        
                        if(!isset($_POST["housenumber"]) || empty($_POST["housenumber"]))
                        {
                            $_SESSION["housenumber_error"]="has-error";
                        }
                        
                        if(!isset($_POST["city"]) || empty($_POST["city"]))
                        {
                            $_SESSION["city_error"]="has-error";
                        }
                        
                        if(!isset($_POST["zipcode"]) || empty($_POST["zipcode"]))
                        {
                            $_SESSION["zipcode_error"]="has-error";
                        }
                        
                        if(!isset($_POST["country"]) || empty($_POST["country"]))
                        {
                            $_SESSION["country_error"]="has-error";
                        }
                        
                        $_SESSION["errorreg"] = "La registrazione è incompleta. Inserire le informazioni nei campi rossi.";
                        header("Location:signup.php?t=1");
                        exit();
                    }
                }
                
                // for companies or freelancer
                if($_POST["type"]==2)
                {
                    
                }
            }
        }
    }
    
    // if visitor already chose the type of user he/she/it is
    if(isset($_GET["t"]) && !empty($_GET["t"]) && ($_GET["t"]==1 || $_GET["t"]==2))
    {
        // if the visitor is an individual
        if($_GET["t"]==1)
        {
            $REGISTRATION="<div class=\"row\">
                <div class=\"col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3\">
                    <h1 class=\"text-center\">Registrati come privato</h1>
                    <br>
                    ".$MESSAGE."
                    <h6 class=\"text-right\">* - Campo obbligaotrio</h6>
                    <form id=\"registration\" name=\"registration\" action=\"signup.php?t=1\" method=\"post\" enctype=\"multipart/form-data\">
                        <div class=\"row\">
            				<div class=\"col-xs-12 col-sm-6 col-md-6\">
            					<div class=\"form-group ".$name_error."\">
                                    <input required type=\"text\" name=\"name\" id=\"name\" class=\"form-control\" placeholder=\"* Nome\" tabindex=\"1\" value=\"".$person["name"]."\">
            					</div>
            				</div>
            				<div class=\"col-xs-12 col-sm-6 col-md-6\">
            					<div class=\"form-group ".$surname_error."\">
            						<input required type=\"text\" name=\"surname\" id=\"surname\" class=\"form-control\" placeholder=\"* Cognome\" tabindex=\"2\" value=\"".$person["surname"]."\">
            					</div>
            				</div>
            			</div>
            			<div class=\"form-group ".$email_error."\">
            				<input required type=\"email\" name=\"email\" id=\"email\" class=\"form-control\" placeholder=\"* Email\" tabindex=\"3\" value=\"".$person["email"]."\">
            			</div>
            			<div class=\"form-group ".$username_error."\">
            				<input required type=\"text\" name=\"username\" id=\"username\" class=\"form-control\" placeholder=\"* Username\" tabindex=\"4\" value=\"".$person["username"]."\">
            			</div>
            			<div class=\"row\">
            				<div class=\"col-xs-12 col-sm-6 col-md-6\">
            					<div class=\"form-group ".$password_error."\">
                                    <input required type=\"password\" name=\"password\" id=\"password\" class=\"form-control\" placeholder=\"* Password\" tabindex=\"5\">
            					</div>
            				</div>
            				<div class=\"col-xs-12 col-sm-6 col-md-6\">
            					<div class=\"form-group ".$repassword_error."\">
            						<input required type=\"password\" name=\"repassword\" id=\"repassword\" class=\"form-control\" placeholder=\"* Ripeti password\" tabindex=\"6\">
            					</div>
            				</div>
            			</div>
            			<div class=\"form-group ".$birthdate_error."\">
							<label for=\"datepicker\">* Data di nascita</label>
                            <div class=\"input-group date\" id='datepicker'>
    							<input required type='text' class=\"form-control\" name=\"birthdate\" id=\"birthdate\" placeholder=\"1990-12-31\" value=\"".$person["birthdate"]."\">
    							<span class=\"input-group-addon\">
                                    <span class=\"glyphicon glyphicon-calendar\"></span>
                                </span>
			                </div>
						</div>
						<div class=\"form-group\">
            				<label for=\"selectGender\">Sono:&nbsp;&nbsp;&nbsp;</label>
            				<div id=\"selectGender\" class=\"selectContainer\" style=\"display:inline-block;\">
                                <select class=\"form-control\" name=\"gender\" id=\"gender\">
                                    <option value=\"\">Seleziona...</option>
                                    <option value=\"F\" ".($person["gender"]==="F"?"selected":"").">Donna</option>
                                    <option value=\"M\" ".($person["gender"]==="M"?"selected":"").">Uomo</option>
                                    <option value=\"O\" ".((!empty($person["gender"]) && $person["gender"]!=="F" && $person["gender"]!=="M")?"selected":"").">Altro</option>
                                </select>
                            </div>
            			</div>
            			<hr>
            			<div class=\"form-group\">
            			    <div class=\"row\">
            			        <div class=\"col-lg-3 col-md-3 col-sm-4\">
                				    <label for=\"selectQualification\" style=\"display:inline-block;\">Qualifica:&nbsp;&nbsp;&nbsp;</label>
                				</div>
                				<div id=\"selectQualification\" class=\"selectContainer col-lg-9 col-md-9 col-sm-8 col-xs-12\" style=\"display:inline-block;\">
                                    <select class=\"form-control\" name=\"qualification\" id=\"qualification\">
                                        <option value=\"\">Seleziona...</option>
                                        <option value=\"Licenza media\" ".($person["qualification"]==="Licenza media"?"selected":"").">Licenza media</option>
                                        <option value=\"Diploma di istruzione secondaria superiore\" ".($person["qualification"]==="Diploma di istruzione secondaria superiore"?"selected":"").">Diploma di istruzione secondaria superiore</option>
                                        <option value=\"Laurea\" ".($person["qualification"]==="Laurea"?"selected":"").">Laurea</option>
                                        <option value=\"Laurea magistrale\" ".($person["qualification"]==="Laurea magistrale"?"selected":"").">Laurea magistrale</option>
                                        <option value=\"Dottorato di ricerca\" ".($person["qualification"]==="Dottorato di ricerca"?"selected":"").">Dottorato di ricerca</option>
                                        <option value=\"Altro titolo di studio\" ".((!empty($person["qualification"]) && $person["qualification"]!=="Licenza media" && $person["qualification"]!=="Licenza media" && $person["qualification"]!=="Diploma di istruzione secondaria superiore" && $person["qualification"]!=="Laurea" && $person["qualification"]!=="Laurea magistrale" && $person["qualification"]!=="Dottorato di ricerca")?"selected":"").">Altro titolo di studio</option>
                                    </select>
                                </div>
                            </div>
            			</div>
            			<div class=\"form-group\">
            			    <div class=\"row\">
            			        <div class=\"col-lg-3 col-md-3 col-sm-4\">
                			        <label for=\"occupation\" style=\"display:inline-block;\">Occupazione:&nbsp;&nbsp;&nbsp;</label>
                			    </div>
                				<div class=\"col-lg-9 col-md-9 col-sm-8 col-xs-12\">
                				    <input type=\"text\" name=\"occupation\" id=\"occupation\" class=\"form-control\" placeholder=\"Es: impiegato, tecnico informatico...\" style=\"display:inline-block;\" value=\"".$person["occupation"]."\">
                				</div>
            				</div>
            			</div>
            			<div class=\"form-group\">
            			    <label for=\"bio\">Su di te:&nbsp;&nbsp;&nbsp;</label>
            				<textarea class=\"form-control\" name=\"bio\" id=\"bio\" rows=\"5\" placeholder=\"Bio...\">".$person["bio"]."</textarea>
            			</div>
            			<hr>
            			<div>
            			<p><h4><b>Domicilio</b></h4></p>
            			<p><h5 class=\"text-justify\">(servirà per prenotare appuntamenti o come luogo in cui ricevere i clienti nel caso offrirai dei servizi)</h5></p>
            			</div>
            			<div class=\"row\">
            				<div class=\"col-xs-9 col-sm-9 col-md-10\">
            					<div class=\"form-group ".$address_error."\">
                                    <input required type=\"text\" name=\"address\" id=\"address\" class=\"form-control\" placeholder=\"* Via, Viale, Piazza...\" value=\"".$person["address"]."\">
            					</div>
            				</div>
            				<div class=\"col-xs-3 col-sm-3 col-md-2\">
            					<div class=\"form-group ".$housenumber_error."\">
            						<input required type=\"text\" name=\"housenumber\" id=\"housenumber\" class=\"form-control\" placeholder=\"* N°\" value=\"".$person["housenumber"]."\">
            					</div>
            				</div>
            			</div>
            			<div class=\"form-group\">
            				<input type=\"text\" name=\"apartmentinfo\" id=\"apartmentinfo\" class=\"form-control\" placeholder=\"Piano, interno, scala...\" value=\"".$person["apartmentinfo"]."\">
            			</div>
            			<div class=\"row\">
            				<div class=\"col-xs-9 col-sm-9 col-md-10\">
            					<div class=\"form-group ".$city_error."\">
                                    <input required type=\"text\" name=\"city\" id=\"city\" class=\"form-control\" placeholder=\"* Città\" value=\"".$person["city"]."\">
            					</div>
            				</div>
            				<div class=\"col-xs-3 col-sm-3 col-md-2\">
            					<div class=\"form-group ".$zipcode_error."\">
            						<input required type=\"text\" name=\"zipcode\" id=\"zipcode\" class=\"form-control\" placeholder=\"* CAP\" value=\"".$person["zipcode"]."\">
            					</div>
            				</div>
            			</div>
            			<div class=\"form-group\">
            				<input type=\"text\" name=\"state\" id=\"state\" class=\"form-control\" placeholder=\"Stato, regione, provincia...\" value=\"".$person["state"]."\">
            			</div>
            			<div class=\"form-group ".$country_error."\">
            			    <div id=\"selectCountry\" class=\"selectContainer\">
                                <select required class=\"form-control\" name=\"country\" id=\"country\">
                                    <option value=''>* Nazione...</option>
                                    <option role='separator' class='divider' disabled></option>
                                    <option value='IT'>Italia</option>
                                    <option value='US'>United States</option>
                                </select>
                            </div>
            			</div>
            			<hr>
            			<div>
            			    <p><h4><b>Contatti</b></h4></p>
            			</div>
            			<div class=\"form-group ".$tel_error."\">
            			    <div class=\"row\">
            			        <div class=\"col-lg-3 col-md-3 col-sm-4\">
                			        <label for=\"tel\" style=\"display:inline-block;\">Telefono:&nbsp;&nbsp;&nbsp;</label>
                			    </div>
                				<div class=\"col-lg-9 col-md-9 col-sm-8 col-xs-12\">
                				    <input type=\"text\" name=\"tel\" id=\"tel\" class=\"form-control\" placeholder=\"Es: +390001112233\" style=\"display:inline-block;\" value=\"".$person["tel"]."\">
                				</div>
            				</div>
            			</div>
            			<div class=\"form-group ".$cell_error."\">
            			    <div class=\"row\">
            			        <div class=\"col-lg-3 col-md-3 col-sm-4\">
                			        <label for=\"cell\" style=\"display:inline-block;\">Cellulare:&nbsp;&nbsp;&nbsp;</label>
                			    </div>
                				<div class=\"col-lg-9 col-md-9 col-sm-8 col-xs-12\">
                				    <input type=\"text\" name=\"cell\" id=\"cell\" class=\"form-control\" placeholder=\"Es: +393442227771\" style=\"display:inline-block;\" value=\"".$person["cell"]."\">
                				</div>
            				</div>
            			</div>
            			<div class=\"form-group\">
            			    <div class=\"row\">
            			        <div class=\"col-lg-3 col-md-3 col-sm-4\">
            			            <img src=\"images/brands/linkedin.png\" class=\"img-responsive\" alt=\"LinkedIn-logo\" style=\"display:inline-block\">
                			        <label for=\"cell\" style=\"display:inline-block;\">LinkedIn:&nbsp;&nbsp;&nbsp;</label>
                			    </div>
                				<div class=\"col-lg-9 col-md-9 col-sm-8 col-xs-12\">
                				    <input type=\"text\" name=\"linkedin\" id=\"linkedin\" class=\"form-control\" placeholder=\"www.linkedin.com/in/my-profile\" style=\"display:inline-block;\" value=\"".$person["linkedin"]."\">
                				</div>
            				</div>
            			</div>
            			<div class=\"form-group\">
            			    <div class=\"row\">
            			        <div class=\"col-lg-3 col-md-3 col-sm-4\">
                			        <label for=\"tel\" style=\"display:inline-block;\">Sito web:&nbsp;&nbsp;&nbsp;</label>
                			    </div>
                				<div class=\"col-lg-9 col-md-9 col-sm-8 col-xs-12\">
                				    <input type=\"text\" name=\"website\" id=\"website\" class=\"form-control\" placeholder=\"www.mywebsite.com\" style=\"display:inline-block;\" value=\"".$person["website"]."\">
                				</div>
            				</div>
            			</div>
            			<div class=\"form-group\">
                            <input type=\"hidden\" name=\"type\" id=\"type\" value=\"1\">
                        </div>
            			<br>
            			<button type=\"submit\" class=\"btn btn-success\" style=\"width:100%;\">Registrati</button>
            			<br>
                    </form>
                </div>
            </div>";
        }
        else // if the visitr is a company or a freelancer
        {
            
        }
    }
    else // if user type is not chosen yet
    {
        $REGISTRATION.="<h1 class=\"text-center\">Sono</h1>\n";
        $REGISTRATION.="<br>\n";
        $REGISTRATION.="<div class=\"row\">\n";
        $REGISTRATION.="<div class=\"col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-2 col-sm-3 col-sm-offset-2 col-xs-12\">\n";
        $REGISTRATION.="<div class=\"panel center-block\" style=\"width:300;height:300;\">\n";
        $REGISTRATION.="<div class=\"uk-card uk-card-default uk-card-hover uk-card-body\" style=\"width:300;height:300;\" onclick=\"window.location.href='signup.php?t=1'\">\n";
        $REGISTRATION.="<div class=\"panel-body\">\n";
        $REGISTRATION.="<img src=\"images/individual.png\" class=\"img-responsive center-block\" alt=\"Individual\" width='125' height='125'>\n";
        $REGISTRATION.="<h4 class=\"text-center\">un privato</h4>\n";
        $REGISTRATION.="</div>\n";
        $REGISTRATION.="</div>\n";
        $REGISTRATION.="</div>\n";
        $REGISTRATION.="</div>\n";
        $REGISTRATION.="<div class=\"col-lg-3 col-lg-offset-2 col-md-3 col-md-offset-2 col-sm-3 col-sm-offset-2 col-xs-12\">\n";
        $REGISTRATION.="<div class=\"panel center-block\" style=\"width:300;height:300;\">\n";
        $REGISTRATION.="<div class=\"uk-card uk-card-default uk-card-hover uk-card-body\" style=\"width:300;height:300;\" onclick=\"window.location.href='signup.php?t=2'\">\n";
        $REGISTRATION.="<div class=\"panel-body\">\n";
        $REGISTRATION.="<img src=\"images/company.png\" class=\"img-responsive center-block\" alt=\"Company or freelancer\" width='125' height='125'>\n";
        $REGISTRATION.="<h4 class=\"text-center\">un'impresa o un libero professionista</h4>\n";
        $REGISTRATION.="</div>\n";
        $REGISTRATION.="</div>\n";
        $REGISTRATION.="</div>\n";
        $REGISTRATION.="</div>\n";
        $REGISTRATION.="</div>\n";
    }
?>
<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="favicon.ico">
        <title>Aireem - Registrati</title>
        <!-- UIkit -->
        <link rel="stylesheet" href="uikit/css/uikit.min.css">
        <script src="uikit/js/uikit.min.js"></script>
        <script src="uikit/js/uikit-icons.min.js"></script>
        <!-- Bootstrap -->
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
        
        <div class="container-fluid">
            <?php echo $REGISTRATION; ?>
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
                $('#datepicker').datetimepicker({
                    viewMode: 'years',
              		format: 'YYYY-MM-DD'
              		});
                });
            });
        </script>
    </body>
</html>