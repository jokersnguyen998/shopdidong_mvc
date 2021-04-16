<div class="features_items"><!--/product-brand-->
	<?php 
		$name_brand = $bra->get_name_by_brand($id);
		if ($name_brand) {
			while ($result_bra = $name_brand->fetch_assoc()) {
				echo "<h2 class='title text-center'>Thương hiệu : ".$result_bra['brandName']." </h2>";
			}
		}
	?>
	<?php
		$pro_brand = $bra->get_product_by_brand($id);
		if ($pro_brand) {
			while ($result_pro = $pro_brand->fetch_assoc()) {
	?>
	<div class="col-sm-4">
		<div class="product-image-wrapper">
			<div class="single-products">
				<div class="productinfo text-center">
					<img src="admin/uploads/<?php echo $result_pro['proImage']; ?>" alt="" />
					<h2><?php echo number_format($result_pro['proPrice'],0,".",".").'đ' ?></h2>
					<p><?php echo $result_pro['proName']; ?></p>
					<a href="product-details.php?proId=<?php echo $result_pro['proId']; ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Xem chi tiết</a>
                    <a href="" data-id="<?php echo $result_pro['proId']; ?>" class="btn btn-default wishlist"><i class="fa fa-heart"></i> Yêu thích</a>
				</div>
			</div>
		</div>
	</div>
	<?php
			}
		}
	?>
</div><!--/product-brand-->
