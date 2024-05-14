<?php
session_start();
unset($_SESSION['id_session']);
header('Location: login.php');
