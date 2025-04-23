<?php

	# === Error Reporting ===
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	# === Populate Variables with Data ===
	$dir=$_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'];
	$parts=explode('/', $dir);
	$name=array_slice($parts, -2, 1);
	$name=end($name);
	$name=$name;
    
	$request=$_SERVER['REQUEST_URI'];
	$request=explode("?", $request)[0];
	$request=str_replace("/host/", "/", $request);
	$request=trim($request,"/");
	$request="/".$request;
	$elements=scandir(explode("?", $dir)[0]);
	$count=count($elements)-2;

	# === Start <head> ===
	echo("\n<head>\n");

	# === Replace and insert metadata ===
	$metadata = file_get_contents("./metatags.html");
	$metadata = str_replace("{{pageTitle}}", $request, $metadata);
	$metadata = str_replace("{{description}}", "Browse " . $count . " files", $metadata);
	$metadata = str_replace("{{siteName}}", "Snailien Concepts", $metadata);
	$metadata = str_replace("{{siteURL}}", $_SERVER["SERVER_NAME"], $metadata);
	$metadata = str_replace("{{tags}}", "index, autoindex, directory, directory listing, files, view, browse", $metadata);
	$metadata = str_replace("{{icon}}", "/assets/image/internal/snailien_logo.jpg", $metadata);
    $metadata = str_replace("{{revisedTime}}", date("Y-m-d H:i:s", filemtime($_SERVER["SCRIPT_FILENAME"])), $metadata);
    $metadata = str_replace("{{supportsMobile}}", "True", $metadata);
    $metadata = str_replace("{{timeNow}}", date("Y-m-d H:i:s"), $metadata);
    $metadata = str_replace("{{contentType}}", "Directory Index", $metadata);
    $metadata = str_replace("{{archiveTitle}}", "null", $metadata);
    $metadata = str_replace("{{archiveURL}}", "null", $metadata);
	echo $metadata;

    echo("\n<link rel='stylesheet' href='/assets/css/site.css'>\n");

	# === End <head> ===
	echo("\n</head>\n");

	# === Start <body> ===
	echo("\n<body>\n");
	echo("<h1> Index of " . $request . "</h1>");


	# === Insert "Download All" Script ===
	$aggrDownload = file_get_contents("./../aggrDownload/aggrDownloadHeader.html");
	echo $aggrDownload;
?>
