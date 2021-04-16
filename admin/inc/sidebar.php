<?php
$first_name = Session::get('userData')['first_name'];
$last_name = Session::get('userData')['last_name'];
if (isset(Session::get('userData')['picture']['url'])) {
	$image = Session::get('userData')['picture']['url'];
} else{
	$image = Session::get('userData')['adminImage'];
}
?>
<aside style="position: fixed;" class="main-sidebar sidebar-dark-primary elevation-4">
	<!-- Brand Logo -->
	<a href="index.php" class="brand-link">
		<img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
				 style="opacity: .8">
		<span class="brand-text font-weight-light">Admin H-Shop</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<!-- <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image"> -->
				<img src="uploads/<?php echo $image ?>" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="profile.php" class="d-block"><?php echo $first_name . " " . $last_name ?></a>
			</div>
		</div>
		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item has-treeview menu-open">
					<a href="#" class="nav-link " id="abc1">
						<i class="fas fa-laptop"></i>
						<p>
							Dashboard
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="slilist.php" class="nav-link">
								<i class="nav-icon far fa-circle"></i>
								<p>
									Slider
								</p>
							</a>
						</li>
					</ul>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="catlist.php" class="nav-link">
								<i class="nav-icon far fa-circle"></i>
								<p>
									Danh mục
								</p>
							</a>
						</li>
					</ul>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="bralist.php" class="nav-link">
								<i class="nav-icon far fa-circle"></i>
								<p>
									Thương hiệu
								</p>
							</a>
						</li>
					</ul>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="prolist.php" class="nav-link">
								<i class="nav-icon far fa-circle"></i>
								<p>
									Sản phẩm
								</p>
							</a>
						</li>
					</ul>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="order.php" class="nav-link">
								<i class="nav-icon far fa-circle"></i>
								<p>
									Đơn hàng
								</p>
							</a>
						</li>
					</ul>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="index.php" class="nav-link">
								<i class="nav-icon far fa-circle"></i>
								<p>
									Thống kê
								</p>
							</a>
						</li>
					</ul>
				</li>
				<li class="nav-item has-treeview menu-open">
					<a href="#" class="nav-link " id="abc1">
						<i class="fas fa-laptop"></i>
						<p>
							Profile
							<i class="right fas fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						<li class="nav-item">
							<a href="profile.php" class="nav-link">
								<i class="nav-icon far fa-circle"></i>
								<p>
									Thông tin tài khoản
								</p>
							</a>
						</li>
					</ul>
				</li>        
			</ul>
		</nav>
		<!-- /.sidebar-menu -->
	</div>
	<!-- /.sidebar -->
</aside>