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
			echo "return value : ". $ret;
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
