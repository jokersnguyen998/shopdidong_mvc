<?php
	include 'inc/header.php';
?>
<?php
	$check_login = Session::get('customer_login');
	if (!isset($_SESSION['cart']) || $_SESSION['cart'] == null) {
		echo "<script>window.location='index.php'</script>";
	}
	if ($check_login == false){
		echo "<script>window.location='login.php'</script>";
	}
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
		$checkout = $ord->insert_order($_POST);
	}
?>
	<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="index.php">Home</a></li>
				  <li class="active">Check out</li>
				</ol>
			</div><!--/breadcrums-->

			<div class="review-payment">
				<h2>Review & Payment</h2>
			</div>
			<?php
			if (isset($checkout)) {
				echo $checkout;
			}
			?>
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
                            // $total = 0;
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
                                <i class="fa fa-save"></i></a>
							<a class="cart_quantity_delete" href="" data-id="<?php echo $key ?>">
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
			
			<div class="container">
				<div class="row">
					<div class="col-sm-12">	
						<div class="col-sm-4">
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
									<li>Tổng tiền <span><?php echo number_format($totalAll,0,",") ?> VNĐ</span></li>
									<li>Giảm giá <span id="discount"></span></li>
								</ul>
								<span><p>H-Shop Voucher <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" style="padding-left: 60px;" href="">Chọn hoặc nhập mã</a></p>
									
								</span>
							</div>
							<div class="total_area">
								
							</div>
			                <?php
			                    }
			                ?>
						</div>
						<div class="col-sm-7">
							<div style="padding-bottom: 5%;" class="shopper-informations">
								<div class="shopper-info">
									<?php
									$getCus = $cus->get_customer();
									if ($getCus) {
										$row = $getCus->fetch_assoc();
									?>
									<form id="form-checkout" action="" method="post">
										<div class="form-info">
											<label>Tên khách hàng</label><br>
											<input class="checkout" type="text" name="user_name" value="<?php echo $row['first_name'].' '.$row['last_name'] ?>" required>
										</div>
										<div class="form-info">
											<label>Email</label><br>
											<input class="checkout" type="email" id="email" name="email" value="<?php echo $row['email'] ?>" required>
										</div>
										<div class="form-info">
											<label>Số điện thoại</label><br>
										<input class="checkout" type="text" id="phone" name="phone" value="<?php echo $row['cus_phone'] ?>" required>
										</div>
										<div class="form-info">
											<label>Địa chỉ nhận hàng</label><br>
											<input class="checkout" type="text" id="address" name="address" value="<?php echo $row['cus_address'] ?>" required>
										</div>
										<div class="form-info">
											<label>Zipcode</label><br>
										<input class="checkout" type="text" name="zipcode" value="<?php echo $row['cus_zipcode'] ?>" required>
										</div>
										<div>
											<span style="margin-right: 10px;">
												<input required="" type="radio" id="payment" name="payment" value="Thanh toán trực tiếp"> 
												<label for="payment">Thanh toán trực tiếp</label>
											</span>
											<span style="margin-right: 10px;">
												<input required="" type="radio" id="payment2" name="payment" value="Thanh toán qua thẻ"> 
												<label for="payment2">Thanh toán qua thẻ</label>
											</span>
										</div>
										<input type="hidden" id="total" name="total" value="<?php echo $subtotal ?>">
										<input type="hidden" id="giamgia" name="discount" value="">
										<input type="hidden" id="giamgia_code" name="discount_code" value="">
										<button id='checkout-btn' class="btn btn-primary" type="submit" name="submit">Thanh toán</button>
									</form>
									<?php
									}
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section> <!--/#cart_items-->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="exampleModalLabel">Chọn H-Shop Voucher</h4>
				</div>
				<div class="modal-body">
					<form>
						<div class="form-group">
							<label for="recipient-name" class="col-form-label">Mã Voucher:</label>
							<input type="text" class="form-control" id="recipient-name" value="">
							<input type="hidden" class="form-control" id="recipient-code" value="">
						</div>
					</form>
					<hr>
					<?php
					$getDiscount = $cus->get_discount();
					if ($getDiscount) {
						foreach ($getDiscount as $key => $row) {
					?>
					<div class="voucher">
						<span>Mã Voucher giảm <?php echo $row['discount'] ?>% :
							<p style="display: contents;"><?php echo $row['discount_code'] ?></p>
							<input type="hidden" class="form-control discount_loop" id="<?php echo $key ?>" value="<?php echo $row['discount'] ?>">
						</span>
						<a class="btn btn-primary apdung" href="">Áp dụng</a>
							<p style="display: contents;">   ------ HSD : <?php echo $row['expiry_date'] ?></p>
					</div>
					<?php 
						}
					}
					?>
					<div style="margin-left: 240px;">
						<button type="button" class="btn btn-primary" data-dismiss="modal">Đồng ý</button>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
<?php
	include 'inc/footer.php';
?>