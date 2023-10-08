<?php
    @session_start();
    @$userId = $_SESSION['userId'];
    $db = new PDO("sqlite:db/kunddb.db");
    
    if(!empty($_POST['postDelete'])) {

        $postDelete = (int) $_POST['postDelete'];
        $stmt = $db->prepare("DELETE FROM orders WHERE orderId={$postDelete}");
        $stmt->execute();

    }


    $stmt = $db->prepare("SELECT orderId,orderUserId, userFirstname, userLastname, userAge, ticketType
    FROM orders
    JOIN kundkonto ON orders.orderUserId = kundkonto.userId
    JOIN tickets ON orders.orderTicketId = tickets.ticketId
    WHERE orderUserId = ?;
    ");
    $stmt->bindParam(1, $userId, PDO::PARAM_INT);
    $stmt->execute();




?>
    <div>
        <table>

            <tr>

                <th>First Name</th>
                <th>Last Name</th>
                <th>Age</th>
                <th>Product</th>

            </tr>

            <?php

            while($shoplist = $stmt->fetch()) {
                echo <<<TABELLRAD
            <tr>

                <td>{$shoplist['userFirstname']}</td>
                <td>{$shoplist['userLastname']}</td>
                <td>{$shoplist['userAge']}</td>
                <td>{$shoplist['ticketType']}</td>
                <td>
                <form action="index.php?pageid=cart" method="post">

                <button type="submit" value="{$shoplist['orderId']}" name="postDelete">Radera
                </form>

                </td>
                
                
            </tr>


TABELLRAD;}

            ?>

        </table>


      


        </div>