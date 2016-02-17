<!DOCTYPE html>
<html>
	<body>
		<?php 
			//store inputs from deleteNode.html
			$ndId = (int)$_POST["nodeId"];
			
			//read from graphConnections.json
			$filename = "./ping-module/graphConnections.json";
			
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
			
			//delete ndId from nodes
			$i = 0;
			foreach ( $jsonObj['nodes'] as $value ) {
				if ($value['id'] == $ndId) {
					unset($jsonObj['nodes'][$i]);
				}	
				$i++;
			}	 
			$jsonObj['nodes'] = array_values($jsonObj['nodes']);
			
			//delete ndId from links
			$i = 0;
			foreach ( $jsonObj['links'] as $value ) {
				if (($value['source'] == $ndId) || ($value['target'] == $ndId)) {
					unset($jsonObj['links'][$i]);
				}	
				$i++;
			}
			$jsonObj['links'] = array_values($jsonObj['links']);
			
			//print_r($jsonObj['nodes']);
			//print_r($jsonObj['links']);
			
			//encode json object
			$jsonStr = json_encode($jsonObj);
			
			
			echo "<br>", "graphConnections.json", "<br>", $jsonStr;
			echo "<br>", "<br>";
			
			//write to file
			$file = fopen($filename, "w");
			if( $file == false ) {
				echo ("Error in opening graphConnections.json");
				exit();
			}
			fwrite($file, $jsonStr);
			fclose($file);

			echo "Node is deleted";
		?>	
	</body>
</html>
