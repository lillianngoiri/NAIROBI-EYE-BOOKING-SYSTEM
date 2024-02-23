<?php

    $database= new mysqli("localhost","root","","nairobi-eyeassociateshospital");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>