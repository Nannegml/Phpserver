<?php

    $db = new PDO("sqlite:db/kunddb.db");

    $errorMsg = "";


    if(!empty($_POST['postFirstname'])) {
        $postFirstname = htmlspecialchars($_POST['postFirstname']);

    }
    else {
        $postFirstname = null;
    }

    if(!empty($_POST['postLastname'])) {
        $postLastname = htmlspecialchars($_POST['postLastname']);

    }
    else {
        $postLastname = null;
    }
    if(!empty($_POST['postAge'])) {
        $postAge = htmlspecialchars($_POST['postAge']);

    }
    else {
        $postAge = null;
    }

    if(!empty($_POST['postEmail'])) {
        $postEmail = htmlspecialchars($_POST['postEmail']);

    }
    else {
        $postEmail = null;
    }
    if(!empty($_POST['postPass1'])) {
        $postPass1 = htmlspecialchars($_POST['postPass1']);

    }
    else {
        $postPass1 = null;
    }

    if(!empty($_POST['postPass2'])) {
        $postPass2 = htmlspecialchars($_POST['postPass2']);

    }
    else {
        $postPass2 = null;
    }
    if ($postFirstname != null & $postLastname != null 
    & $postAge != null & $postEmail != null & $postPass1 != null & $postPass2 != null) {
      
        if($postPass1 === $postPass2) {
        $stmt = $db->prepare("INSERT INTO kundkonto (userFirstName, userLastName, userAge, userEmail, userPass)  
            VALUES (?, ?, ?, ?, ?)");
        
        $hashPassword = password_hash($postPass1, PASSWORD_DEFAULT);

        $stmt->bindParam(1, $postFirstname, PDO::PARAM_STR);
        $stmt->bindParam(2, $postLastname, PDO::PARAM_STR);
        $stmt->bindParam(3, $postAge, PDO::PARAM_INT);
        $stmt->bindParam(4, $postEmail, PDO::PARAM_STR);
        $stmt->bindParam(5, $hashPassword, PDO::PARAM_STR);

    
        $stmt->execute();
        $errorMsg = "Registerd successfully";

        } else {
            $errorMsg = "The passwords do not match!";
        }
    
        

    }
    

    






?>



<div>
		<form action="" method="post">
		<label for="firstName"> First name </label> <input autocomplete="off" type="text" id="firstName" name="postFirstname" required>
		<label for="lastName"> Last Name </label> <input autocomplete="off" type="text" id="lastName" name="postLastname" required>
        <label for="age"> Age </label> <input type="number" id="age" name="postAge" required>
        <label for="email"> Email </label> <input autocomplete="on" type="email" id="email" name="postEmail" required>
		<label for="pass1"> Password </label> <input type="password" id="pass1" name="postPass1" required minlength="6">
        <label for="pass2"> Confirm password </label> <input type="password" id="pass2" name="postPass2" required minlength="6">



        <button type="submit" value="Submit"> Register </button>

	    </form>
        <p> <?php echo $errorMsg; ?> </p>

	</div>