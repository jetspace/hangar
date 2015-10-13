<?php
/*

	Copyright see Authors file
	Licensed under the terms of the MIT/X11 License

*/
	include 'src/log.php';

	function getLine($filename, $line)
	{
		$handle = fopen($filename, "r");
		$c = 0;

    while (($x = fgets($handle)))
		{
			$c++;
			if($x == $line ."\n")
				break;
    }

    fclose($handle);

		return $c;
	}



	$version = 0.05;

	$output = new Log();
	$output->Log(("JetSpace Hangar Version " . $version . " started!\n"));

	$isCritical = true;
	$success = 0;
	$failure = 1;

	if($argc < 2)
	{
		return 1;
	}

	for($x = 1; $x < $argc; $x++)
	{
		//Parse Comandline args:
		if($argv[$x] == "--quiet" || $argv[$x] == "-q")
		{
			$output->toggleDebug(false);
		}
		else if($argv[$x] == "--debug" || $argv[$x] == "-d")
		{
			$output->toggleDebug(true);
		}
		else
		{
			$ini = parse_ini_file($argv[$x], TRUE);

			$output->Debug("Configuration:\n");
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
					$output->Debug("\tisCritical set to " . ($isCritical ? "true.\n" : "false.\n"));
				}
				else
				{
					$output->Warn("On line " .getLine($argv[$x], "isCritical=" .$ini['Settings']['isCritical']) ." of file " .$argv[$x] .": isCritical has to be 'true' or 'false'.\n");
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
					$output->Warn("On line " .getLine($argv[$x], "success=" .$ini['Settings']['success']) ." of file " .$argv[$x] .": Return value must be a positive number.\n");
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
					$output->Warn("On line " .getLine($argv[$x], "failure=" .$ini['Settings']['failure']) ." of file " .$argv[$x] .": Return value must be a positive number.\n");
				}
			}

			$output->Debug("Return Values:\n");
			$output->Debug("\tSuccess: " . $success . "\n");
			$output->Debug("\tFailure: " . $failure . "\n");

			//Perform Tests:
			$testn = 1;
			$testprefix = "Test";

			while(isset($ini[$testprefix .strval($testn)]))
			{
				$testSuccess=true;
				$testname=$testprefix .strval($testn);
				$testcritical = $isCritical;
				$name="";
				$exec="";
				$outp="";
				$ret="";

				if(isset($ini[$testname]['name']))
					$name = $ini[$testname]['name'];
				else
					$output->Warn($testname ." has no name!");

				if(isset($ini[$testname]['exec']))
					$exec = $ini[$testname]['exec'];
				else
					$output->Warn($testname. "has no command to execute!");

				if(isset($ini[$testname]['outp']))
					$outp = $ini[$testname]['outp'];

				if(isset($ini[$testname]['ret']))
					$ret = $ini[$testname]['ret'];

				if(isset($ini[$testname]['isCritical']))
				{
					if($ini[$testname]['isCritical'] == 1 || $ini[$testname]['isCritical'] == "")
					{
						$testcritical = $ini[$testname]['isCritical'];
						if($testcritical == 1)
							$testcritical = true;
						else
							$testcritical = false;
					}
					else
					{
						$output->Warn("On line " .getLine($argv[$x], "isCritical=" .$ini[$testname]['isCritical']) ." of file " .$argv[$x] .": isCritical has to be 'true' or 'false'.\n");
					}
				}


				$out = Array();
				$ereturn = 0;

				exec($exec, $out, $ereturn);

				$temp = implode("", $out);


				if($outp != "")
				{
					if($temp != $outp)
					{
						$testSuccess = false;
					}
				}
				if($ret != "")
				{
					if($ereturn != $ret)
					{
						$testSuccess = false;
					}
				}


				if($testSuccess == true)
				{
					$output->Log("Test ". $name. " passed!\n");
				}
				else if($testSuccess == false)
				{
					$output->Log("Test ". $name ." failed!\n");
					if($testcritical == true)
					{
						$output->Error("Critical Test failed! Stopped Programm!\n");
					}
				}

				$testn++;

			}



		}
	}

?>
