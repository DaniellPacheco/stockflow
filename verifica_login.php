<?php

session_start();
if(!$_SESSION['idUser']) {
    header('Location: index.php');
    exit();
}