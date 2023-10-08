<?php
    @session_start();
    $db = new PDO("sqlite:db/kunddb.db");
    $userId = htmlspecialchars($_SESSION['userId']);
    $ticketType = null;
    
    $stmt = $db->prepare("SELECT ticketLeft FROM tickets WHERE ticketId = 1");
    $stmt-> execute();
    $ticketLanExist = implode(array_unique($stmt->fetch()));

    $stmt = $db->prepare("SELECT orderId FROM orders WHERE orderTicketId = 1 ORDER BY orderId DESC");
    $stmt->execute();
    $ticketLanLeft = $ticketLanExist - sizeof($stmt->fetchAll());


    $stmt = $db->prepare("SELECT ticketLeft FROM tickets WHERE ticketId = 2");
    $stmt-> execute();
    $ticketVipExist = implode(array_unique($stmt->fetch()));

    $stmt = $db->prepare("SELECT orderId FROM orders WHERE orderTicketId = 2 ORDER BY orderId DESC");
    $stmt->execute();
    $ticketVipLeft = $ticketVipExist - sizeof($stmt->fetchAll());




    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        
        if (!empty($_POST['postType'])) {
            $ticketType = htmlspecialchars($_POST['postType']);

            if ($ticketType == 1) {
                if ($ticketLanLeft <= 0) {
                    $ticketLanLeft = "Finns inte mer!";
                    $ticketType = null;
                }
        }
            if ($ticketType == 2) {

                if ($ticketVipLeft <= 0) {
                    $ticketVipLeft = "Finns inte mer!";
                    $ticketType = null;
                }
            }
        

            if ($ticketType != null) {
                $stmt = $db->prepare("INSERT INTO orders (orderUserId, orderTicketId)  
                VALUES (?,?)");
                $stmt->bindParam(1, $userId, PDO::PARAM_INT);
                $stmt->bindParam(2, $ticketType, PDO::PARAM_INT);
                $stmt->execute();
                $_SESSION['status'] = "Du har beställt klart!"."<br>". 
            "Du kan se dina beställningar på cart sektionen!";
                header("Refresh:0");

            } else {
                $_SESSION['status'] = "Beställningen misslyckades!";
            }


            
            

        }
    

    } else  {
        header("location: index.php?pageid=login");
    }





?>


<div>

    <form action="index.php?pageid=buy" method="post">
        
        <select id="ticket" name="postType"> 
            <option value="1">Platsbiljett LAN </option>
            <option value="2">Platsbiljett LAN VIP </option>
            <option value="3">Eventpass </option>
            <option value="4">Dagpass torsdag </option>
            <option value="5">Dagpass fredag </option>
            <option value="6">Dagpass lördag </option>
            <option value="7">matkupong </option>
        </select>
        <input type="submit" value="Beställ">
    </form>
    
    <p><?php echo "Lan biljeter kvar: ",@$ticketLanLeft,"<br>","Vip biljeter kvar: ", @$ticketVipLeft; ?> </p>
    <p> <?php echo @$_SESSION['status']; ?> </p>




</div>

