<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <title>Network Mapper</title>
        <script type="text/javascript" src="d3.v2.js"></script>
        <!-- Autorefresh 5 min.
        <meta http-equiv="refresh" content="300">
        -->
    </head>
	<body>
		Execute mapper
		<?php
			// execute mapper
			$ret = exec('./mapper');
			//echo "return value : ". $ret;
		?>
		
		<?php
			include_once("ViaNettSMS.php");
			
			$Username = "shubhamkumawat@yahoo.com";
			$Password = "23msp";
			$MsgSender = "+919981257279";
			$DestinationAddress = "+919893592401";
			$Message = "Down IPs are :";
			
			
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
			$brlinkscnt = 0;
			
			// for all links  
			foreach ($lnks as $l) {
				if ($l['value'] == 0) {
					$brlinkscnt = $brlinkscnt+1; 
					$m = $nds[$l['target']]['ip'];
					$Message = $Message . $m . "<br>" ;
				}		
			}	
			
			if ($brlinkscnt > 0) {		//if broken links are greater than 0
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
			}		
		?>
		
		
		<svg id="cloud" width="1000" height="1000">
            <defs>
                <marker id="arrow" viewbox="0 -5 10 10" refX="18" refY="0"
                        markerWidth="6" markerHeight="6" orient="auto">
                    <path d="M0,-5L10,0L0,5Z">
                </marker>
           </defs>
        </svg>
        <link href="net.css" rel="stylesheet" type="text/css" />
        <script src="net.js" type="text/javascript"></script>
	</body>
</html>	
