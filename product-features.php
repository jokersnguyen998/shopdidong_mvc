<div class="features_items">
	<h2 class="title text-center">Sản phẩm mới</h2>
	<?php
		$get_pro_features = $pro->show_features_product();
		if ($get_pro_features) {
			while ($result_pro = $get_pro_features->fetch_assoc()) {
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
				<?php
					if ($result_pro['proType'] == 1) {
				?>
				<img src="images/home/new.png" class="new" alt="" />
				<?php
					}
				?>
			</div>
		</div>
	</div>
	<?php
			}
		}
	?>
</div>
<div class="row features_items">
	<nav id="navpaginate" aria-label="Page navigation">
		<ul class="pagination">
		    <li><a href="" id="prev">&laquo;</a></li>
		    <?php 
		    $profea = $pro->paginate_features_product();
		    $paginate = mysqli_num_rows($profea);
		    $button = ceil($paginate / 6);
		    for ($i=1; $i <= $button ; $i++) { 
		    	echo "<li><a id='page' data-page='".$i."' href='index.php?page=".$i."'>".$i."</a></li>";
		    }
		    echo "<input hidden id='page-last' value='".$button."'/>";
		    ?>
		    <li><a href="" id="next">&raquo;</a></li>
		</ul>
	</nav>
</div>
