<?php
	include 'inc/header.php';
	include 'inc/slider.php';
?>
<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<?php
					include 'inc/sidebar.php';
				?>
			</div>
			<div class="col-sm-9 padding-right">
			<?php
			include "product-price.php";
			// <!--search_items-->
			if (isset($_POST['submit'])){
				$proName = $_POST['search'];
				include "product-search.php";
			}
		// <!--brand_items-->
		
			elseif (isset($_GET['braId'])) {
		  		$id = $_GET['braId'];
		  		include "product-brand.php";
			}
		// <!--category_items-->
		
			elseif (isset($_GET['catId'])) {
				$id = $_GET['catId'];
		  		include "product-category.php";
			}
			?>
			<!--features_items-->
			<?php include "product-features.php" ?>

			<!--category-tab-->
			<?php include "category_tab.php" ?>

			<!--recommended_items-->
			<?php include "product-recommended.php" ?>
			</div>
		</div>
	</div>
</section>
<?php
	include 'inc/footer.php';
?>




