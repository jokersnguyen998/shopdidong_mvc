<?php
	include 'inc/header.php';
?>
<?php
	if (!isset($_SESSION['cart'])) {
		echo "<script>window.location='index.php'</script>";
	}
?>
<?php
	//update cart
    if (isset($_GET["id"]) && isset($_GET["qty"])){
        
        $id = $_GET["id"];

        $query = "SELECT * FROM tbl_product WHERE proId = $id";
        $result = $db->select($query);
        $row = mysqli_fetch_row($result);

        $qty_befor = $_SESSION["cart"][$id]['quantity'];
        if ($qty_befor < $_GET["qty"]) {
        	
        	$a = (int)$_GET["qty"] - (int)$qty_befor;
        	$proQuantity = (int)$row[9] - (int)$a;
        } else{
        	
        	$a = (int)$qty_befor - (int)$_GET["qty"];
        	$proQuantity = (int)$row[9] + (int)$a;
        }
        if (($_GET["qty"] + $qty_befor) < $row[9]){
            if ($_GET["qty"] > 0){
	            
	            $_SESSION["cart"][$id] = array(
	                'name' => $row[1],
	                'image' => $row[6],
	                'price' => $row[5],
	                'quantity' => $_GET["qty"]
	            );
	            $query2 = "UPDATE tbl_product SET proQuantity = $proQuantity WHERE proId = $id";
	            $db->update($query2);
        	} else{
	            
	            unset($_SESSION["cart"][$id]);
	            $qty = $_SESSION["cart"][$id]["quantity"];
	            $proQuantity = (int)$row[9] + (int)$qty;
	            $query2 = "UPDATE tbl_product SET proQuantity = $proQuantity WHERE proId = $id";
	            $db->update($query2);
	        }
        }
    }

    //delete cart
    if (isset($_GET["id"]) && isset($_GET["action"])){
        $id = $_GET["id"];
        $qty = $_SESSION["cart"][$id]["quantity"];

        $query = "SELECT * FROM tbl_product WHERE proId = $id";
        $result = $db->select($query);
        $row = mysqli_fetch_row($result);

        unset($_SESSION["cart"][$_GET["id"]]);
        $proQuantity = (int)$row[9] + (int)$qty;
        $query2 = "UPDATE tbl_product SET proQuantity = $proQuantity WHERE proId = $id";
        $result2 = $db->update($query2);
        if ($_SESSION["cart"] == null) {
        	unset($_SESSION["cart"]);
        }
    }
?>
<section id="cart_items">
	<div class="container">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
			  <li><a href="index.php">Home</a></li>
			  <li class="active">Shopping Cart</li>
			</ol>
		</div>
		<div class="table-responsive cart_info">
			<table class="table table-condensed">
				<thead>
					<tr class="cart_menu">
						<td class="image">Sản phẩm</td>
						<td class="description"></td>
						<td class="price">Giá</td>
						<td class="quantity">Số lượng</td>
						<td class="total">Thành tiền</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					<?php
                        if (isset($_SESSION["cart"])) {
                            $subtotal = 0;
                            $cart = $_SESSION["cart"];
                            foreach ($cart as $key => $value){
                                $total = (int)$value['price'] * (int)$value['quantity'];
					?>
					<tr>
						<td class="cart_product">
							<a href="product-details.php?proId=<?php echo $key ?>">
                                <img style="object-fit: contain;width: 150px;height: 150px" src="admin/uploads/<?php echo $value['image'] ?>" alt="">
                            </a>
						</td>
						<td class="cart_description">
							<h4><a href="product-details.php?proId=<?php echo $key ?>"><?php echo $value['name'] ?></a></h4>
						</td>
						<td class="cart_price">
							<p><?php echo number_format($value['price'],0,",") ?> VNĐ</p>
						</td>
						<td class="cart_quantity">
							<div class="cart_quantity_button">
								<input style="width: 60px" class="cart_quantity_input" type="number"
                                       name="quantity_<?php echo $key ?>" value="<?php echo $value['quantity'] ?>"
                                       autocomplete="off" size="2" min="1" id="quantity_<?php echo $key ?>">
							</div>
						</td>
						<td class="cart_total">
							<p class="cart_total_price"><?php echo number_format($total,0,",") ?> VNĐ</p>
						</td>
						<td class="cart_delete">
							<a class="cart_quantity_update" href="" data-id="<?php echo $key ?>">
								 <!-- onclick="updateItem(<?php echo $key ?>)" -->
                                <i class="fa fa-save"></i></a>
							<a class="cart_quantity_delete" href="" data-id="<?php echo $key ?>">
								 <!-- onclick="deleteItem(<?php echo $key ?>)" -->
                                <i class="fa fa-times"></i></a>
						</td>
					</tr>
					<?php
                                $subtotal += $total;
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</section> <!--/#cart_items-->

<section id="do_action">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 right">
                <?php
                    if (isset($_SESSION["cart"])){
                        $vat = $subtotal * 10/100;
                        $totalAll = $subtotal + $vat;
                ?>
				<div class="total_area">
					<ul>
						<li>Tổng tiền giỏ hàng <span><?php echo number_format($subtotal,0,",") ?> VNĐ</span></li>
						<li>Thuế VAT <span><?php echo number_format($vat,0,",") ?> VNĐ</span></li>
						<li>Phí vận chuyển <span>Free</span></li>
						<li>Tổng tiền <span><?php echo number_format($totalAll,0,".",".") ?> VNĐ</span></li>
					</ul>
						<a class="btn btn-default update" href="">Cập nhật</a>
						<a class="btn btn-default check_out" href="checkout.php">Thanh toán</a>
				</div>
                <?php
                    }
                ?>
			</div>
		</div>
	</div>
</section><!--/#do_action-->
<?php
	include 'inc/footer.php';
?>