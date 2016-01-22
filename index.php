<html>
<head>
	<title>Co-op</title>
	<script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>
	<script type="text/javascript" src='js/main.js'></script>
	<script src="http://jpillora.com/jquery.rest/dist/1/jquery.rest.min.js"></script>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
<?php
	# Logging in with Steam accounts requires setting special identity, so this example shows how to do it.
	# http://steamcommunity.com/dev/
	require 'php/openid.php';
	try {
	    # Change 'localhost' to your domain name.
	   $openid = new LightOpenID('localhost:8080');
	    if(!$openid->mode) {
	        if(isset($_GET['login'])) {
	            $openid->identity = 'http://steamcommunity.com/openid';
	            header('Location: ' . $openid->authUrl());
	        }
	?>
	<form action="?login" method="post">
	    <input type="image" src="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_large_border.png">
	</form>
	<?php
	    } elseif($openid->mode == 'cancel') {
	        echo 'User has canceled authentication!';
	    } else {
	        if($openid->validate()) {
	                $id = $openid->identity;
	                // identity is something like: http://steamcommunity.com/openid/id/76561197994761333
	                // we only care about the unique account ID at the end of the URL.
	                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
	                preg_match($ptn, $id, $matches);
	                $steamid = $matches[1];
	               	echo "<div id='wrapper'><div id='mainUser'></div><div id='friendsList'></div><button id='getUserGames'>Pick Me A Game</button></div>";
	        } else {
	                echo "User is not logged in.\n";
	        }
	 
	    }
	} catch(ErrorException $e) {
	     echo $e->getMessage();
	}
?>
</body>

</html>

