<?php
    session_start(); 
    
    // delete SESSION data
    unset($_SESSION["usrID"]);
    unset($_SESSION["usrEmail"]);
    unset($_SESSION["usrUsername"]);
    unset($_SESSION["usrProPic"]);
    unset($_SESSION["usrPremium"]);
    unset($_SESSION["usrPersonCode"]);
    unset($_SESSION["usrP_Iva"]);
    session_destroy(); // destroy session
    
    header('Location:/');
    exit();
    
?>