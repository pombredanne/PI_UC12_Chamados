<?php

session_start();

error_reporting(0);

if (isset($_SESSION['logado']))
	unset($_SESSION['logado']);

if (isset($_SESSION['codigo']))
	unset($_SESSION['codigo']);

if (isset($_SESSION['admin']))
	unset($_SESSION['admin']);

if (isset($_SESSION['nomeCompleto']))
	unset($_SESSION['nomeCompleto']);

if (isset($_SESSION['nomeUsuario']))
	unset($_SESSION['nomeUsuario']);

session_destroy();

header("Location: login.php");

