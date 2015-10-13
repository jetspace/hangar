<?php

	$version = 0.01;

	print (":: Jetspace Hangar Version " . $version . " started!\n");

	$isCritical = true;
	$success = 0;
	$failure = 1;

	$ini = parse_ini_file("test/example.hangar", TRUE);

	print(":: Configuration\n");
	if(isset($ini['Settings']['isCritical']))
	{
		$isCritical = $ini['Settings']['isCritical'];
		if($isCritical == 1)
		{
			$isCritical = true;
		}
		else
		{
			$isCritical = false;
		}
		echo $isCritical ? "\tisCritical set to true\n" : "\tisCritical set to false\n";
	}

	if(isset($ini['Settings']['success']))
	{
		$success = $ini['Settings']['success'];
	}

	if(isset($ini['Settings']['failure']))
	{
		$failure = $ini['Settings']['failure'];
	}

	print ":: Return Values:\n";
	print "\tSuccess: " . $success . "\n";
	print "\tFailure: " . $failure . "\n";

?>
