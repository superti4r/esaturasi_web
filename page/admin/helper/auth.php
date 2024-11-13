<?php
session_start();

function isLogin()
{
  if(!isset($_SESSION['nik'])){
    header('Location: ../index.php');
  }
}
?>