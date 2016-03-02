<!DOCTYPE html>
<html>
	<body>
		<?php 
			//store inputs from addNode.html
			$ipAdr = $_POST["ipAddress"];
			$devName = $_POST["name"];
			$ndId = (int)$_POST["nodeId"];
			$prId = (int)$_POST["parentId"];
			
			
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
			$ndElem['id'] = $ndId;
			$ndElem['ip'] = $ipAdr;
			$ndElem['name'] = $devName;
			$linkElem['source'] = $prId;
			$linkElem['target'] = $ndId;
			$linkElem['value'] = 2;
			
			//push element
			array_push( $jsonObj['nodes'], $ndElem);
			array_push( $jsonObj['links'], $linkElem);
			
			//encode json object
			$jsonStr = json_encode($jsonObj);
			
			
			//echo "<br>", "graphConnections.json", "<br>", $jsonStr;
			//echo "<br>", "<br>";
			
			//write to file
			$file = fopen($filename, "w");
			if( $file == false ) {
				echo ("Error in opening graphConnections.json");
				exit();
			}
			fwrite($file, $jsonStr);
			fclose($file);

			echo "Node is added";
		?>	
	</body>
</html>
