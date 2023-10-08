<?php


    
	if(empty($_GET['pageid'])) {
		$pageid = "main";		// default-värde
	}
	else {
		$pageid = htmlspecialchars($_GET['pageid']);
	}


    require("incl/header.php");	

    require("php/{$pageid}.php");		

    require("incl/footer.php");	



?>