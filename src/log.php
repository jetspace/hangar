<?php
/*

	Copyright see Authors file
	Licensed under the terms of the MIT/X11 License

*/

class Log
{
  //Init Function
  function __construct()
  {
    $this->debug = true;
  }

  //Toogles if debug output should be visible
  function toggleDebug($state)
  {
    $this->debug = $state;
  }

  //Main function, which can output all types of logs
  function log_function($msg, $level)
  {
    if(!is_string($msg))
    {
      $this->log_function("No string is given as argument for the logging system!\n", 3);
    }

      switch($level)
      {
        case 0:
            if($this->debug)
              print(": " .$msg);
        break;

        case 1:
            print(":: " .$msg);
        break;

        case 2:
            print(":: [WARNING]: " .$msg);
        break;

        case 3:
            print(":: [ERROR] !: " .$msg);
            exit(1);
        break;

        default:
            $this->log_function("Invalid Loglevel\n", 3);
        break;
      }

    }

    //Calls Debug
    function Debug($msg)
    {
      $this->log_function($msg, 0);
    }
    //Calls Log
    function Log($msg)
    {
      $this->log_function($msg, 1);
    }
    //Calls Warning
    function Warn($msg)
    {
      $this->log_function($msg, 2);
    }
    //Calls Error
    function Error($msg)
    {
      $this->log_function($msg, 3);
    }

}

?>
