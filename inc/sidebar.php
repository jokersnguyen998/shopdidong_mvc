<div class="left-sidebar">
<?php
	$minimum = 2; //*1000000đ
	$maximum = 80
?>
<?php
	$chuoicha = $_SERVER['PHP_SELF'];
	if (strlen(strstr($chuoicha, 'index.php')) > 0) {
?>
	<div class="price-range"><!--price-range-->
		<h2>Lọc giá</h2>
		<div class="well text-center">
			<input type="text" class="span2" value="" data-slider-min="2" data-slider-max="80"
					data-slider-step="2" data-slider-value="[2,80]" id="sl2" ><br />
			<b class="pull-left"><?php echo $minimum; ?></b> <b class="pull-right"><?php echo $maximum; ?></b>
			<p style="margin-top: 15px;margin-bottom: -10px;"><b>x1.000.000 VNĐ</b></p>
		</div>
	</div><!--/price-range-->
<?php
	}
?>

	<h2>Danh mục</h2>
	<div class="panel-group category-products" id="accordian"><!--category-productsr-->
		<?php
			$get_cat_sidebar = $cat->show_category_sidebar();
			if ($get_cat_sidebar) {
				while ($resultCS = $get_cat_sidebar->fetch_assoc()) {
					$catId = $resultCS['catId'];
		?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4 class="panel-title">
				<?php
					$check_cs_child = $cat->categoryChildrent($catId);
					if ($check_cs_child) {
				?>
					<a data-toggle="collapse" data-parent="#accordian"
						href="#<?php echo $resultCS['catSlug'] . "_" . $resultCS['catId'] ?>">
						<span class='badge pull-right'><i class='fa fa-plus'></i></span>
						<?php echo $resultCS['catName'] ?>
					</a>
				<?php
					} else{
				?>
					<a href="">
						<span class="badge pull-right"></span>
						<?php echo $resultCS['catName'] ?>
					</a>
				<?php	
					}
				?>
				</h4>
			</div>

			<div id="<?php echo $resultCS['catSlug'] . "_" . $resultCS['catId'] ?>" class="panel-collapse collapse">
				<div class="panel-body">
					<ul>
						<?php
							$get_cs_child = $cat->categoryChildrent($catId);
							if ($get_cs_child) {
								while ($resultCSChild = $get_cs_child->fetch_assoc()) {
						?>
						<li><a href="index.php?<?php echo $resultCSChild['catSlug'] ?>&catId=<?php echo $resultCSChild['catId'] ?>"><?php echo $resultCSChild['catName'] ?> </a></li>
						<?php
								}
							}
						?>
					</ul>
				</div>
			</div>

		</div>
		<?php
				}
			}
		?>
	</div><!--/category-products-->

	<div class="brands_products"><!--brands_products-->
		<h2>Thương hiệu</h2>
		<div class="brands-name">
			<ul class="nav nav-pills nav-stacked">
				<?php 
					$getBra = $bra->show_brand_sidebar();
					if ($getBra) {
						while ($resultBra = $getBra->fetch_assoc()) {
							$braId = $resultBra['brandId'];
							$total = $bra->count_product_by_brand($braId);
							echo "<li>
									<a href='index.php?".$resultBra['brandSlug']."&braId=".$resultBra['brandId']."'>
										<span class='pull-right'>(".$total['total'].")</span>".$resultBra['brandName']."
									</a>
								</li>";
						}
					}
				?>
			</ul>
		</div>
	</div><!--/brands_products-->
</div>