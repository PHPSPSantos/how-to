<?php
	require_once("vendor/autoload.php");

	$previsao = new \Meteorologia\Previsao();

	//Veremos sobre essa pratica posteriormente
	echo $previsao->getPrevisao($_POST);

