<!DOCTYPE html>
<html>
	<body>
		Execute mapper
		<?php
			// execute mapper
			$ret = exec('./mapper');
			echo "return value : ". $ret;
			
			// Redirect to display graph
			header("Location: displayGraph.html");
		?>
	</body>
</html>	
