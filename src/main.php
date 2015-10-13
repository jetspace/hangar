<?php

	$version = 0.03;

	print (":: Jetspace Hangar Version " . $version . " started!\n");

	$isCritical = true;
	$success = 0;
	$failure = 1;

	if($argc < 2)
	{
		return 1;
	}

	$ini = parse_ini_file($argv[1], TRUE);
	print(":: Configuration\n");
	if(isset($ini['Settings']['isCritical']))
	{
		if($ini['Settings']['isCritical'] == 1 || $ini['Settings']['isCritical'] == "")
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
		else
		{
			echo ":: [WARNING] isCritical has to be \"true\" or \"false\"\n";
		}
	}

	if(isset($ini['Settings']['success']))
	{
		if(is_numeric($ini['Settings']['success']) == TRUE)
		{
			$success = $ini['Settings']['success'];
		}
		else
		{
			$success = ":: [WARNING] Return Value must be a positive number!";
		}
	}

	if(isset($ini['Settings']['failure']))
	{
		if(is_numeric($ini['Settings']['failure']) == TRUE)
		{
			$failure = $ini['Settings']['failure'];
		}
		else
		{
			$failure = ":: [WARNING] Return Value must be a positive number!";
		}
	}

	print ":: Return Values:\n";
	print "\tSuccess: " . $success . "\n";
	print "\tFailure: " . $failure . "\n";

?>
