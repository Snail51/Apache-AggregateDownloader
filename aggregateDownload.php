<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	//remove downloads older than 1 hour
	$command = "find /mnt/hdd/web/aggrDownload/tmp_download -type f -mmin +60 -delete";
	exec($command);
	
    //check if the 'dir' parameter is set
    if (isset($_GET['dir']))
    {
    	$now = microtime(true);
		$now = str_replace(".", "", $now);
		$source = "/mnt/hdd/web" . $_GET['dir'];
		$source = realpath($source);

		if($source == false || strpos($source, "/mnt/hdd/web") !== 0) //abort if tried to acces an illegal path (this is after pathname canonicalization)
		{
			print_r("ILLEGAL_DOWNLOAD_ABORTED");
			exit;
		}
		if( $source == "/mnt/hdd/web" ) //explicitly disallow downloading the whole /web folder
		{
			print_r("ILLEGAL_DOWNLOAD_ABORTED");
			exit;
		}
		if(str_contains($source, "/mnt/hdd/web/control")) //abort any attempts to access `/control` or any of its children
		{
			print_r("ILLEGAL_DOWNLOAD_ABORTED");
			exit;
		}
		if(str_contains($source, "/mnt/hdd/web/assets")) //abort any attempts to access `/assets` or any of its children
		{
			print_r("ILLEGAL_DOWNLOAD_ABORTED");
			exit;
		}
		
		$destination = "/mnt/hdd/web/control/aggrDownload/tmp_download/download_" . $now . ".zip";

		$dirname = substr($source, strrpos($source, "/") + 1);
		
		$source_safe = escapeshellarg($source);
		$destination_safe = escapeshellarg($destination);
		$dirname_safe = escapeshellarg($dirname);

        $command = "/mnt/hdd/web/control/aggrDownload/aggregateDownload.sh $source_safe $destination_safe $dirname_safe";

        exec($command . " 2>&1", $output);

        $file = "/mnt/hdd/web/control/aggrDownload/tmp_download/download_" . $now . ".zip";

		print_r("download_" . $now . ".zip");
	}

	exit;
	
?>
