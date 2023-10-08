<?php


    @session_start();

    if(!empty($_POST['logout'])) {
		session_unset();
		session_destroy();
        header("Refresh:0");

	}

    


    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: index.php?pageid=buy");
    }

    $db = new PDO("sqlite:db/kunddb.db");

    $errorMsg = null;
    

    

    if (!empty($_POST['email'])) {
        $email = htmlspecialchars($_POST['email']);
    }
    else {
        $email = null;
    }

    if (!empty($_POST['pass'])) {
        $pass = htmlspecialchars($_POST['pass']);

    }
    else {
        $pass = null;

    }


    $stmt = $db->prepare("SELECT userEmail FROM kundkonto WHERE userEmail LIKE ?");
    $stmt->bindparam(1, $email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch();

    if (!is_bool($result)) {
        
        $result = strtolower(implode(array_unique($result)));

        if(strtolower($email) === $result) {


            
            $stmt = $db->prepare("SELECT userPass FROM kundkonto WHERE userEmail Like ? ") ;
            $stmt->bindparam(1, $email, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch();


            if (!is_bool($result)) {

                $result = implode(array_unique($result));


                if ($pass = password_verify($pass,$result)) {

                    $errorMsg = "Logged in!";
                    $stmt = $db->prepare("SELECT userId FROM kundkonto WHERE userEmail Like ? ");
                    $stmt->bindparam(1, $email, PDO::PARAM_STR);
                    $stmt->execute();
                    $result = $stmt->fetch();



                    $_SESSION["loggedin"] = true;

                    $_SESSION['userId'] = implode(array_unique($result));

                    header("location: index.php?pageid=buy");

                }
                else {
                    $errorMsg = "wrong password!";
                }

            }
    
        }
        else {
            $errorMsg = "username or pass wrong!";
        }
    }
         

        
   




?>

    <div>
		<form action="index.php?pageid=login" method="post">
		    <label for="email"> Email </label> <input autocomplete="off" type="email" id="email" name="email" required>
		    <label for="pass"> Password </label> <input type="password" id="pass" name="pass" required minlength="6">
            <button type="submit" value="Submit"> Submit </button>
	    </form>

        <p> <?php  echo $errorMsg; ?> </p>
        
	</div>