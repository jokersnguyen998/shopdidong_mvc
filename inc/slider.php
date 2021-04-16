	<section id="slider">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<div id="slider-carousel" class="carousel slide" data-ride="carousel">
						<ol class="carousel-indicators">
							<li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
							<li data-target="#slider-carousel" data-slide-to="1"></li>
							<li data-target="#slider-carousel" data-slide-to="2"></li>
						</ol>
						<div class="carousel-inner">
							<?php
							$get_slider = $sli->show();
							if ($get_slider) {
								$i=-1;
								while ($row = $get_slider->fetch_assoc()) {
									$i++;
							?>
							<div class="item <?php echo $i==0 ? 'active':'' ?>">
								<div class="col-sm-6">
									<h1><span>H</span>-SHOP</h1>
									<h2><?php echo $row['slider_name'] ?></h2>
									<p><?php echo $row['slider_content'] ?></p>
									<!-- <a href="product-details.php?proId=<?php echo $row['slider_id'] ?>" class="btn btn-default get">Get it now</a> -->
								</div>
								<div class="col-sm-6">
									<img width="350px" src="admin/uploads/<?php echo $row['slider_img'] ?>" class="girl img-responsive" alt="" />
								</div>
							</div>
							<?php
								}
							}
							?>
						</div>

						<a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
							<i class="fa fa-angle-left"></i>
						</a>
						<a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
							<i class="fa fa-angle-right"></i>
						</a>
					</div>

				</div>
			</div>
		</div>
	</section>