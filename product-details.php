<?php
	include 'inc/header.php';
?>	
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-3">
					<?php
						include 'inc/sidebar.php';
					?>
				</div>
				<?php
					if (!isset($_GET['proId']) || $_GET['proId'] == NULL) {
				 		echo "<script>window.location='404.php'</script>";
					} else{
				  		$id = $_GET['proId'];
					}
				?>
				<div class="col-sm-9 padding-right">
					<?php
						$getPro = $pro->get_product_by_id_frontend($id);
						if ($getPro) {
						    $catID = "";
							while ($result = $getPro->fetch_assoc()) {
							    $catID = $result['catId'];
					?>
					<div class="product-details"><!--product-details-->
						<div class="col-sm-5">
							<div class="view-product">
								<img style="height: auto" src="admin/uploads/<?php echo $result['proImage'] ?>" alt="" />
							</div>
                            <div class="row">
                                <div id="similar-product" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner"><!-- Wrapper for slides -->
                                        <?php
                                        $getImagePro = $pro->get_image_product_by_id($id);
                                        if ($getImagePro){
                                        $i=-1;
                                        while ($resultImage = $getImagePro->fetch_assoc()){
                                        $i++;
                                        ?>
                                        <?php
                                        if ($i % 3 == 0) {
                                        ?>
                                        <div class="item <?php if($i == 0){echo "active";} ?>">
                                            <?php
                                            }
                                            ?>
                                            <a href=""><img style="width: 97px;height: 100px" src="admin/uploads/<?php echo $resultImage['imgPath'] ?>" alt=""></a>
                                            <?php
                                            if (($i % 3 == 2)) {
                                                echo "</div>";
                                            }
                                            ?>
                                            <?php
                                            }
                                            }
                                            ?>
                                        </div><!-- Wrapper for slides -->
                                        <!-- Controls -->
                                        <a class="left item-control controler" href="#similar-product" data-slide="prev">
                                            <i class="fa fa-angle-left"></i>
                                        </a>
                                        <a class="right item-control controler" href="#similar-product" data-slide="next">
                                            <i class="fa fa-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

						<div class="col-sm-7">
							<div class="product-information row"><!--/product-information-->
								<h2 style="font-size: 25px"><?php echo $result['proName'] ?></h2>
                                <ul class="list-inline" style="cursor:context-menu;">
                                    <?php
                                    $get_rating = $pro->get_rating($id);
                                    if ($get_rating) {
                                    $row = $get_rating->fetch_assoc();
                                    $rating = round($row['avg_rating']);
                                        for ($count=1; $count <= 5 ; $count++) {
                                            if ($count <= $rating) {
                                                $color = 'color: #ffcc00';
                                            } else{
                                                $color = 'color: #ccc';
                                            }
                                    ?>

                                    <li style="cursor:context-menu;font-size:25px;<?php echo $color ?>">&#9733;</li>

                                    <?php
                                        }
                                    }
                                    ?>
                                </ul>
								<span>
									<span style="margin-top: -10%;"><?php echo number_format($result['proPrice'],0,".",".").'đ' ?></span>
                                    <div style="margin-left: 63%;margin-top: -15%;" class="col-md-12">
                                        <label style="float: left; margin-top: 5px;"
                                                for="">Số lượng:</label>
                                        <div class="clearfix">
                                            <input style="float: initial; margin-left: 10px; width: 70px"       type="number" class="cart_quantity_input" min="1"
                                                    value="1" id="quantity123">
                                            <?php
                                            if (isset($_SESSION["cart"][$result["proId"]])) {
                                                $qtyprocart = $_SESSION["cart"][$result["proId"]]["quantity"];
                                                echo '<input type="hidden" id="qtyprocart" value="'.$qtyprocart.'">';
                                            }
                                            
                                            ?>
                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php
                                            if ($result['proQuantity'] > 0) {
                                                echo '<button type="button" class="btn btn-primary addtocart add123" data-id="'.$result["proId"].'">
                                                        <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng</button>';
                                            } else{
                                                echo '<button style="background: gray;" type="button" class="btn btn-primary addtocart">
                                                        <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng</button>';
                                            }
                                        ?>
                                        
                                    </div>
								</span><br>
								<?php 
									if (isset($insertCart)) {
										echo $insertCart;
									}
								?>
								<p><b>Trạng thái:</b>
								<?php
									if ($result['proQuantity'] <= 0) {
										echo "<i style='color:red; font-style:normal'>Hết hàng</i>";
									} else{
										echo "<i style='color:green; font-style:normal'>Còn hàng</i>";
									}
								?>
								</p>
								<?php
									if ($result['proType'] == 1) {
										echo "<p><b>Tình trạng:</b> Mới</p>";
									} else{
										echo "<p><b>Tình trạng:</b> Bình thường</p>";
									}
								?>
								<p><b>Thương hiệu:</b> <?php echo $result['brandName'] ?></p>
							</div><!--/product-information-->
						</div>
					</div><!--/product-details-->
					<?php
							}
						}
					?>
					<div class="category-tab shop-details-tab"><!--category-tab-->
						<?php
                        $count_cmt = $cmt->count($id);
                        $row_cmt = $count_cmt->fetch_assoc();
                        ?>
                        <div class="col-sm-12">
							<ul class="nav nav-tabs">
								<li class="active"><a href="#reviews" data-toggle="tab">
                                    Đánh giá <?php echo $a = $row_cmt['cmt'] == 0 ? '' : "(".$row_cmt['cmt'].")" ?></a></li>
                                <li><a href="#details" data-toggle="tab">Chi tiết</a></li>
                                <li><a href="#others" data-toggle="tab">Sản phẩm khác</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<div class="tab-pane fade" id="details" >
								<div class="row">
                                    <?php
                                    $getPro = $pro->get_product_by_id_frontend($id);
                                    if ($getPro){
                                        $rowDes = $getPro->fetch_assoc();
                                    ?>
                                    <div class="col-md-12" id="detailsab">
                                        <?php echo $rowDes["proDescription"]?>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
							</div>

							<div class="tab-pane fade" id="others" >
                                <?php
                                $getprobycat = $pro->get_product_by_category_id($catID, $id);
                                if ($getprobycat) {
                                    while ($ress = $getprobycat->fetch_assoc()) {
                                ?>
                                <div class="col-sm-3">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<img src="admin/uploads/<?php echo $ress['proImage'] ?>" alt="" />
												<h2><?php echo number_format($ress['proPrice'],0,".",".") ?>đ</h2>
												<p><?php echo $ress['proName'] ?></p>
                                                <a href="product-details.php?proId=<?php echo $ress['proId']; ?>"
                                                   class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Views</a>
											</div>
										</div>
									</div>
								</div>
                                <?php
                                    }
                                }
                                ?>
							</div>
							
							<div class="tab-pane fade active in" id="reviews" >
								<div class="col-sm-12">
                                    <?php
                                    $check_cus = Session::get('customer_login');
                                    if ($check_cus == true) {
                                        $check_cus_cmt = $cus->check_user_commneted($id);
                                        if ($check_cus_cmt) {
                                            echo "<p style='margin-bottom: 65px;color:green'><b>Cảm ơn bạn đã đánh giá sản phẩm!</b></p>";
                                        } else{
                                    ?>
                                    <div style="margin-bottom: 65px">
                                        <p><b>Write Your Review</b></p>
                                        <form action="" method="POST">
                                            <textarea name="comment" id="commentarea"></textarea>
                                            <span style="display: flex;">
                                                <p style="font-size: 15px"><b>Rating: </b></p>
                                            <ul class="list-inline" id="ul-rating">
                                            <?php
                                            $check_user_rating = $rat->check_user_rating($id);
                                            if ($check_user_rating) {
                                                $row = $check_user_rating->fetch_assoc();
                                                $rating = $row['rating'];
                                                    for ($count=1; $count <= 5 ; $count++) {
                                                        if ($count <= $rating) {
                                                            $color = 'color: #ffcc00';
                                                        } else{
                                                            $color = 'color: #ccc';
                                                        }
                                                        echo '<li class="rating" data-index="'.$count.'"
                                                        id="'.$id.'-'.$count.'"
                                                        data-product-id="'.$id.'"
                                                        data-rating="'.$rating.'"
                                                        style="cursor:pointer;font-size:25px;'.$color.'">&#9733;</li>';
                                                    }
                                            } else{
                                                for ($count=1; $count <= 5 ; $count++) {
                                            ?>
                                                <li class="rating" data-index="<?php echo $count ?>"
                                                    id="<?php echo $id."-".$count ?>"
                                                    data-product-id="<?php echo $id ?>"
                                                    data-rating="<?php echo $rating ?>"
                                                    style="cursor:pointer;font-size:25px;color:#ccc">&#9733;</li>
                                            <?php
                                                }
                                            }
                                            ?>
                                            </ul>
                                            </span>
                                            <input type="hidden" name="rating" id="index" value="0" />
                                            <button style="margin-top: -20px;" type="submit" id="submit"
                                                    class="btn btn-default pull-right">
                                                Submit
                                            </button>
                                        </form>
                                    </div>
                                    <?php
                                        }
                                    } else{
                                        echo "<p style='margin-bottom: 65px; color:red'><b>Bạn phải đăng nhập để bình luận!</b><a href='login.php' style='cursor: pointer;'> Đăng nhập ngay</a></p>";
                                    }
                                    ?>
                                    <input type="hidden" name="productID" id="productID" value="<?php echo $id ?>">
                                    <input type="hidden" name="user_id" id="user_id" value="<?php echo Session::get('userData')['id']; ?>">
                                    <div id="comment"></div>
								</div>
							</div>
							
						</div>
					</div><!--/category-tab-->
					
				</div>
			</div>
		</div>
    </section>
<?php
	include 'inc/footer.php';
?>