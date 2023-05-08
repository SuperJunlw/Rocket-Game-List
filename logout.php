<?php

function logout()
{
    session_start();
    unset($_SESSION['user_name']);
    unset($_SESSION['logged_in']);
    header("Location: login.html");
}
logout();
?>