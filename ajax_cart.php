<?php
    session_start();
    include_once 'lib/database.php';
    include_once 'helpers/format.php';

    $db = new Database();
    $fm = new Format();

    if (isset($_POST["id"]) && isset($_POST["qty"])){
        $id = $_POST["id"];
        $query = "SELECT * FROM tbl_product WHERE proId = $id";
        $result = $db->select($query);
        $row = mysqli_fetch_row($result);
        if ($_POST["qty"] <= $row[9]){
            if (!isset($_SESSION["cart"])){
                $cart1[$id] = array(
                    'name' => $row[1],
                    'image' => $row[6],
                    'price' => $row[5],
                    'quantity' => $_POST["qty"]
                );
                $_SESSION["cart"] = $cart1;
                $qty = $_SESSION["cart"][$id]["quantity"];
                $proQuantity = (int)$row[9] - (int)$qty;
            } else{
                $cart1 = $_SESSION["cart"];
                if (array_key_exists($id, $cart1)){
                    $cart1[$id] = array(
                        'name' => $row[1],
                        'image' => $row[6],
                        'price' => $row[5],
                        'quantity' => $cart1[$id]["quantity"] + $_POST["qty"]
                    );
                    $_SESSION["cart"] = $cart1;
                    $qty = $_POST["qty"];
                    $proQuantity = (int)$row[9] - (int)$qty;
                } else{
                    $cart1[$id] = array(
                        'name' => $row[1],
                        'image' => $row[6],
                        'price' => $row[5],
                        'quantity' => $_POST["qty"]
                    );
                    $_SESSION["cart"] = $cart1;
                    $qty = $_SESSION["cart"][$id]["quantity"];
                    $proQuantity = (int)$row[9] - (int)$qty;
                }
            }
            $query2 = "UPDATE tbl_product SET proQuantity = $proQuantity WHERE proId = $id";
            $result2 = $db->update($query2);
        }
        // else{
        //     if (!isset($_SESSION["cart"])){
        //         $cart1[$id] = array(
        //             'name' => $row[1],
        //             'image' => $row[6],
        //             'price' => $row[5],
        //             'quantity' => $row[9]
        //         );
        //     } else{
        //         $cart1 = $_SESSION["cart"];
        //         if (array_key_exists($id, $cart1)){
        //             $cart1[$id] = array(
        //                 'name' => $row[1],
        //                 'image' => $row[6],
        //                 'price' => $row[5],
        //                 'quantity' => $row[9]
        //             );
        //         } else{
        //             $cart1[$id] = array(
        //                 'name' => $row[1],
        //                 'image' => $row[6],
        //                 'price' => $row[5],
        //                 'quantity' => $row[9]
        //             );
        //         }
        //     }
        //     $_SESSION["cart"] = $cart1;
            
        //     $qty = $_SESSION["cart"][$id]["quantity"];
        //     $proQuantity = (int)$row[9] - (int)$qty;
        //     $query2 = "UPDATE tbl_product SET proQuantity = $proQuantity WHERE proId = $id";
        //     $result2 = $db->update($query2);
        // }
    }
?>