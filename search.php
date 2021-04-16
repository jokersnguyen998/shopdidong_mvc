
<?php 
	include_once 'lib/database.php';
    include_once 'lib/session.php';
    Session::init();
    include_once 'helpers/format.php';
    spl_autoload_register(function($className){
        include_once "classes/" . $className . ".php";
    });

    $db   = new Database();
    $fm   = new Format();
    $cus  = new customer();
    $ord  = new order();
    $pro  = new product();
    $adm  = new admin();
    $admL = new adminlogin();

    if (isset($_GET['type'])) {
        $type = $_GET['type'];
        // search
        if ($type == "search") {
            $inpText = $_POST['query'];
            $query   = "SELECT proName FROM tbl_product WHERE proName LIKE '%".$inpText."%'";
            $result  = $db->select($query);
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    echo "<a href='#' class='list-group-item list-group-item-action'>".$row['proName']."</a>";
                }
            } else{
                echo "<p class='list-group-item'>No record</p>";
            }
        }
        // price range
        if ($type == "pricerange") {
            $min   = $_GET['price_min'];
            $max   = $_GET['price_max'];
            $min1  = $min / 1000000;
            $max1  = $max / 1000000;

            $query = "SELECT * FROM tbl_product WHERE proPrice BETWEEN $min AND $max ORDER BY proPrice ASC";
            $result = $db->select($query);
            $output = "<h2 class='title text-center'>Filter Items</h2>
                        <h5 style='font-size:16px;text-align: center;margin-top: 0%;padding-bottom: 3%;'>Price range: ".$min1." - ".$max1." triệu</h5>";
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $output .= '<div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <img src="admin/uploads/'.$row["proImage"].'" alt="" />
                                                <h2>'.number_format($row["proPrice"],0,".",".").'đ</h2>
                                                <p>'.$row["proName"].'</p>
                                                <a href="product-details.php?proId='.$row["proId"].'"
                                                   class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Xem chi tiết</a>
                                                <a href="" data-id="'.$row["proId"].'"
                                                   class="btn btn-default wishlist"><i class="fa fa fa-heart"></i> Yêu thích</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                }
                echo $output;
            } else{
                echo '<h5 style=" font-size: 16px; padding-left: 16px;">No record</h5>';
            }
        }

        // load comment
        if ($type == "loadcomment") {
            $productID = $_POST['productID'];
            $user_id   = $_POST['user_id'];

            $queryCheckUserRating = "SELECT rating_id FROM tbl_rating WHERE user_id = '$user_id'";
            $result = $db->select($queryCheckUserRating);
            if ($result) {
                $query = "SELECT tbl_comment.*, tbl_customer.*, tbl_rating.*
                FROM tbl_comment INNER JOIN tbl_customer ON tbl_comment.user_id = tbl_customer.id
                INNER JOIN tbl_rating ON tbl_comment.user_id = tbl_rating.user_id
                WHERE tbl_comment.product_id = $productID
                ORDER BY tbl_comment.cmt_date DESC";
                $result1 = $db->select($query);
                if ($result1) {
                    while ($row1 = $result1->fetch_assoc()) {
                        echo '<ul>
                                <li><a href="javascript:void(0)"><i class="fa fa-user"></i>'.$row1["first_name"].' '.$row1['last_name'].'</a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-clock-o"></i>'.$row1["cmt_date"].'</a></li>
                            </ul>
                            <p>'.$row1["comment"].'</p>
                            <hr>';
                    }
                } else{
                    echo "<p class='list-group-item'>No record</p>";
                }
            } else{
                $query = "SELECT tbl_comment.*, tbl_customer.*
                    FROM tbl_comment INNER JOIN tbl_customer ON tbl_comment.user_id = tbl_customer.id
                    WHERE tbl_comment.product_id = $productID
                    ORDER BY tbl_comment.cmt_date DESC";
                $result1 = $db->select($query);
                if ($result1) {
                    while ($row1 = $result1->fetch_assoc()) {
                        echo '<ul>
                                <li><a href="javascript:void(0)"><i class="fa fa-user"></i>'.$row1["first_name"].' '.$row1['last_name'].'</a></li>
                                <li><a href="javascript:void(0)"><i class="fa fa-clock-o"></i>'.$row1["cmt_date"].'</a></li>
                            </ul>
                            <p>'.$row1["comment"].'</p>
                            <hr>';
                    }
                } else{
                    echo "<p class='list-group-item'>No record</p>";
                }
            }
        }

        // post comment
        if ($type == "postcomment") {
            $productID = $_POST['productID'];
            $comment   = $_POST['comment'];
            $user_id   = $_POST['user_id'];
            $index     = $_POST['index'];

            $query = "INSERT INTO tbl_comment(comment, user_id, product_id)
                        VALUES('$comment', '$user_id', '$productID')";
            $db->insert($query);

            if ($index > 0) {
                $query = "INSERT INTO tbl_rating(product_id, user_id, rating)
                            VALUES($productID, $user_id, $index)";
                $db->insert($query);
            }
        }
        // signup
        if ($type == "signup") {
            $cus->insert_customer_ajax($_POST);
        }
        // check email exist
        if ($type == "checkmail") {
            $email  = $_POST['email'];
            $query  = "SELECT * FROM tbl_customer WHERE email = '$email'";
            $result = $db->select($query);
            if ($result) {
                    echo "true";
            } else{
                echo "false";
            }
        }
        // login
        if ($type == "login") {
            $result = $cus->login_customer($_POST);
            echo $result;
        }

        // confirm order admin
        if ($type == "confirm") {
            $order_id = $_GET['order_id'];
            $result   = $ord->set_confirm_status($order_id);
            echo $result;
        }
        // cancel order admin
        if ($type == "cancel") {
            $order_id = $_GET['order_id'];
            $result   = $ord->set_cancel_status($order_id);
            echo $result;
        }
        // checkout order
        if ($type == "checkout") {
            $order_id = $_GET['order_id'];
            $result   = $ord->set_checkout_status($order_id);
            echo $result;
        }
        // add wishlist
        if ($type == "wishlist") {
            $id     = $_GET['id'];
            $result = $pro->get_product_id($id);
            echo($result);
        }
        // check wishlist
        if ($type == "checkwishlist") {
            if (isset($_SESSION["wishlist"])) {
                echo 1;
            } else {
                echo 0;
            }
        }
        // delete wishlist
        if ($type == "deletewishlist") {
            $id = $_GET['id'];
            if (isset($_SESSION["wishlist"])) {
                unset($_SESSION["wishlist"][$id]);
                if ($_SESSION["wishlist"] == null) {
                    unset($_SESSION["wishlist"]);
                }
                echo 1;
            } else {
                echo 0;
            }

        }
        // edit profile
        if ($type == "profile") {
            $result = $cus->update_customer($_POST, $_FILES);
            echo $result;
        }

        // check pass
        if ($type == "checkpass") {
            $result = $cus->check_pass($_POST['pass_old']);
            echo $result;
        }

        // change pass
        if ($type == "changepass") {
            $result = $cus->change_pass($_POST['pass_new']);
            echo $result;
        }

        // profile admin
        if ($type == "profileadmin") {
            $result = $adm->update_profile($_POST, $_FILES);
            echo $result;
        }

        // check pass admin
        if ($type == "checkpassadmin") {
            $result = $adm->check_pass($_POST['pass_old']);
            echo $result;
        }

        // change pass admin
        if ($type == "changepassadmin") {
            $result = $adm->change_pass($_POST['pass_new']);
            echo $result;
        }

        // login admin
        if ($type == "loginadmin") {
            $result = $admL->admin_login($_POST);
            echo $result;
        }

        // cancel order guest
        if ($type == "cancelorder") {
            $result = $ord->set_cancel_status($_POST['order_id']);
            echo $result;
        }
    }
?>