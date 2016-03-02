<!DOCTYPE html>
<html>
	<body>
		<?php
			include_once("ViaNettSMS.php");
			
			$Username = "shubhamkumawat@yahoo.com";
			$Password = "23msp";
			$MsgSender = "+919981257279";
			$DestinationAddress = "+919893592401";
			$Message = "wE are testing";
			
			/*
			//read from graphConnections.json
			$filename = "./ping-module/linkState.json";
			
			$file = fopen($filename, "r");
			if( $file == false ) {
				echo ("Error in opening graphConnections.json");
				exit();
			}
			
			$filesize = filesize( $filename );
			$jsonInput = fread( $file, $filesize );
			
			fclose($file);

			//decode json input
			$jsonObj = json_decode($jsonInput, TRUE);
			$lnks = $jsonObj['links'];
			$nds = $jsonObj['nodes'];
			
			// for all links  
			foreach ($lnks as $l) {
				if ($l['value'] == 0) {
					$m = $nds[$l['target']]['ip'];
					$Message = $Message . $m . "<br>" ;
				}		
			}	
			*/ 
			
			//send sms
			$ViaNettSMS = new ViaNettSMS($Username, $Password);
			
			try
			{
				// Send SMS through the HTTP API
				$Result = $ViaNettSMS->SendSMS($MsgSender, $DestinationAddress, $Message);
				// Check result object returned and give response to end user according to success or not.
				if ($Result->Success == true)
					$Message = "Message successfully sent!";
				else
					$Message = "Error occured while sending SMS<br />Errorcode: " . $Result->ErrorCode . "<br />Errormessage: " . $Result->ErrorMessage;
			}
			catch (Exception $e)
			{
				//Error occured while connecting to server.
				$Message = $e->getMessage();
			}
				
		?>
	</body>
</html>	
