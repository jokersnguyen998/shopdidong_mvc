<div class="recommended_items">
	<h2 class="title text-center">Sản phẩm nổi bật</h2>
	<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
		<div class="carousel-inner">
			<?php
				$get_pro_recommended = $pro->show_recommended_product();
				if ($get_pro_recommended) {
					$i = -1;
					while ($result_pro_rec = $get_pro_recommended->fetch_assoc()) {
						$i++;
			?>
			<?php
				if ($i % 3 == 0) {
			?>
			<div class="item <?php if($i == 0){echo "active";} ?>">	
			<?php
				}
			?>
				<div class="col-sm-4">
					<div class="product-image-wrapper">
						<div class="single-products">
							<div class="productinfo text-center">
								<img src="admin/uploads/<?php echo $result_pro_rec['proImage'] ?>" alt="" />
								<h2><?php echo number_format($result_pro_rec['proPrice'],0,".",".").'đ' ?></h2>
								<p><?php echo $result_pro_rec['proName'] ?></p>
								<a href="product-details.php?proId=<?php echo $result_pro_rec['proId']; ?>"
                                   class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Xem chi tiết</a>
                                <a href="" data-id="<?php echo $result_pro_rec['proId']; ?>" class="btn btn-default wishlist"><i class="fa fa-heart"></i> Yêu thích</a>
							</div>
						</div>
					</div>
				</div>
			<?php
				if (($i % 3 == 2)) {
			        echo "</div>";
				}
			?>
			<?php
					}
				}
			?>
		</div>
	</div>
	<a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
		<i class="fa fa-angle-left"></i>
	</a>
	<a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
		<i class="fa fa-angle-right"></i>
	</a>
</div>