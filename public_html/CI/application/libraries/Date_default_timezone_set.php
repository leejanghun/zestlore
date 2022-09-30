<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class date_default_timezone_set { 

	function __construct(){

		$host_server_name = trim(shell_exec("uname -a"));

		// debug_var($host_server_name);

		switch ($host_server_name)
		{
			case "Linux ip-172-31-8-78.ap-northeast-2.compute.internal 3.10.0-1160.76.1.el7.x86_64 #1 SMP Wed Aug 10 16:21:17 UTC 2022 x86_64 x86_64 x86_64 GNU/Linux":
				// aws
				date_default_timezone_set("UTC");
				break;

			default:
				debug_var("server config error");
				debug_var(simple_debug_backtrace());
				break;

		}// end - switch


	}// end -fun


}// end - class

?>
