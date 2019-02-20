<?php

session_start();

error_reporting(0);

if (isset($_SESSION['logado']))
	unset($_SESSION['logado']);

//if (isset($_SESSION['idCliente']))
//	unset($_SESSION['idCliente']);
//
//if (isset($_SESSION['nome']))
//	unset($_SESSION['nome']);
//
//if (isset($_SESSION['foto']))
//	unset($_SESSION['foto']);
//
//if (isset($_SESSION['admin']))
//	unset($_SESSION['admin']);

session_destroy();

header("Location: index.php");

