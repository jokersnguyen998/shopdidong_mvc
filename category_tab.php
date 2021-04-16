<div class="category-tab">
	<div class="col-sm-12">
		<ul class="nav nav-tabs">
		<?php
			$get_cat = $cat->show_category_tab();
			if ($get_cat) {
				$i = 0;
				$cat_id = array();
				while ($result_cat = $get_cat->fetch_assoc()) {
					$get_cat_child = $cat->categoryChildrent($result_cat['catId']);
					if ($get_cat_child) {
						while ($result_cat_child = $get_cat_child->fetch_assoc()) {
							$i++;
		?>
			<li class="
			<?php
				if($i == 1){echo "active";}
			?>">
				<a href="#<?php
							echo $result_cat_child['catId'];
						?>" data-toggle="tab"><?php echo $result_cat_child['catName']; ?></a>
			</li>
		<?php
                            $cat_id[] = $result_cat_child['catId'];
						}
					}
				}
			}
		?>
		</ul>
	</div>
	<div class="tab-content">
		<?php
			$get_cat = $cat->show_category_tab();
			if ($get_cat) {
				$i = 0;
				while ($result_cat = $get_cat->fetch_assoc()) {
					$i++;
		?>
		<div class="tab-pane fade <?php if ($cat_id[0] == $result_cat['catId']) { echo "active in"; } ?>"
             id="<?php echo $catId = $result_cat['catId']; ?>" >
			<?php
					$get_pro_cat = $pro->get_product_by_category($catId);
					if ($get_pro_cat) {
						while ($result_pro_cat = $get_pro_cat->fetch_assoc()) {
			?>
			<div class="col-sm-4">
				<div class="product-image-wrapper">
					<div class="single-products">
						<div class="productinfo text-center">
							<img src="admin/uploads/<?php echo $result_pro_cat['proImage'] ?>" alt="" />
							<h2><?php echo number_format($result_pro_cat['proPrice'],0,".",".").'đ' ?></h2>
							<p><?php echo $result_pro_cat['proName'] ?></p>
							<a href="product-details.php?proId=<?php echo $result_pro_cat['proId'] ?>" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Xem chi tiết</a>
                            <a href="" data-id="<?php echo $result_pro_cat['proId']; ?>" class="btn btn-default wishlist"><i class="fa fa-heart"></i> Yêu thích</a>
						</div>
					</div>
				</div>
			</div>
			<?php
						}
					}
			?>
		</div>
		<?php
				}
			}
		?>
	</div>
</div>