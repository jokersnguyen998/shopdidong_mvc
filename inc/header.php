<?php
  	include 'lib/session.php';
  	Session::init();
  	include_once 'lib/database.php';
	include_once 'lib/config.php';
	include_once 'helpers/format.php';
	spl_autoload_register(function($className){
		include_once "classes/" . $className . ".php";
	});

	$db = new Database();
	$fm = new Format();
	$cus = new customer();
	$cat = new category();
	$pro = new product();
	$bra = new brand();
	$ord = new order();
	$cmt = new comment();
	$rat = new rating();
	$sli = new slider();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | E-Shopper</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/price-range.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    <link rel="shortcut icon" href="images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <style>
        .popup{
            float: right;
			margin-top: -45px;
			font-size: 20px;
			width: 7%;
        }
        .quantity{
            margin-left: 10px;
        }
        .addtocart{
            display: block;
            margin-left: 20%;
            width: 60%;
        }
        .search_box input{
        	background-image: none;
        	background-position: 205px;
        	width: 80%;
    		font-size: 15px;
    		padding-left: 20px;
    		float: left;
        }
        .search_box #btn-submit{
        	width: 20%;
    		float: right;
    		background-color: #FE980F;
    		border-radius: initial;
    		padding-left: 14px;
    		color: white;
        }
        .search_box #btn-submit:hover{
    		color: black;
        }
        .search_box #search{
    		border-radius: 20px;
    		margin-left: 75px;
        }
        #show-content{
    	    width: 390px;
		    position: relative;
		    margin-top: 0px;
		    padding-right: 115px;
		    float: right;
        }
        #show-list{
        	position: absolute;
        	z-index: 1;
        	width: 290px;
        }
        #show-list a{
        	border-top: none;
        }
        #check{
        	position: absolute;
	    	margin-left: 95%;
		    margin-top: -8%;
		    width: 200px;
        }
        #navpaginate{
        	float: right;
    		margin-right: 3%;
        }
        #ul-rating{
        	margin-left: 1% !important;
   			margin-top: -7px !important;
        }
        #login_facebook{
        	margin-top: -14.5%;
    		margin-left: 30%;
    		height: 33px;
    		background-color: #007bff;
    		border-color: #007bff;
        }
        #login_facebook:hover{
        	background-color: #0069d9;
        	border-color: #0062cc;
        }
        #firstName{
        	width: 49%;
        }
        #lastName{
        	width: 49%;
   			margin-left: 51%;
   			margin-top: -50px;
        }
        .checkout{
        	font-size: 15px;
        	color: green;
        	width: 50% !important;
        }
        #firstNamediv{
        	width: 48%;
        }
        #lastNamediv{
    	    width: 48%;
			margin-left: 52%;
			margin-top: -72px;
        }
        .controller i{
        	background-color: green !important;
        	color: red !important;
        }
        #form-checkout div{
        	margin-bottom: 12px;
        }
        #form-checkout label{
        	margin-bottom: -1px;
        }
        #form-checkout input{
        	background: #E6E4DF;
		    color: #696763;
		    margin-top: 10px;
		    padding: 7px 20px;
		    border: none;
        }
        .error-mail{
        	border: 1px solid red !important;
    		color: red !important;
        }
        .wishlist{
        	background: none;
        	border: none;
        }
        .wishlist:hover{
        	background: none;
        	
        }
		.voucher{
			display: block;
			height: 50px;
			line-height: 50px;
			border: 1px solid #E6E4DF;
			background-color: #E6E4DF;
			margin-bottom: 20px;
		}
		.voucher span{
			padding-left: 10px;
		}
		.voucher a{
			float: right;
			height: 50px;
			line-height: 40px;
			padding-right: 10px;
			margin-top: -1px !important;
			/* background: #007bff !important; */
		}
		.ok{
			border-radius: 0 !important;
			border: 1px solid #FE980F;
		}
        .add-to-cart{
            background: none;
        }
        .add-to-cart:hover{
            border-radius: 4px;
        }
        .wishlist:hover{
            background: red;
            color: white;
        }
        .wishlist{
            margin-top: -25px;
            color: #696763
        }
        #footer{
            /*position: fixed;*/
            bottom: 0;
            width: 100%;
        }
    </style>
</head><!--/head-->

<body>
	<header id="header">
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="contactinfo">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +84 938 858 944</a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> klthuynguyen1998@gmail.com</a></li>
							</ul>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#"><i class="fa fa-facebook"></i></a></li>
								<li><a href="#"><i class="fa fa-twitter"></i></a></li>
								<li><a href="#"><i class="fa fa-linkedin"></i></a></li>
								<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
								<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header_top-->
		<div class="header-middle"><!--header-middle-->
			<div class="container">
				<div class="row">
					<div class="col-md-4 clearfix">
						<div class="logo pull-left">
							<a href="index.php"><img src="images/home/your-logo.png" alt="" /></a>
						</div>
					</div>
					<?php
					if (isset($_GET['cus_id'])) {
						Session::destroy();
					}
					?>
					<div class="col-md-8 clearfix">
						<div class="shop-menu clearfix pull-right">
							<ul class="nav navbar-nav">
								<?php
								$check_login = Session::get('customer_login');
								if ($check_login == true) {
									echo '<li><a href="profile.php"><i class="fa fa-user"></i> '.Session::get('userData')['first_name'].' '.Session::get('userData')['last_name'].'</a></li>';
								} else{
									echo '';
								}
								?>
								<li><a id="btnwishlist" href="wishlist.php"><i class="fa fa-star"></i> Yêu thích</a></li>
								<?php
								$check_login = Session::get('customer_login');
								if ($check_login == true) {
									echo '<li><a href="checkout.php"><i class="fa fa-crosshairs"></i> Checkout</a></li>';
								} else{
									echo '';
								}
								?>
								<li><a href="cart.php"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
								<?php
								$check_login = Session::get('customer_login');
								if ($check_login == true) {
									echo '<li><a href="?cus_id='.Session::get('userData')['id'].'"><i class="fa fa-lock"></i> Đăng xuất</a></li>';
								} else{
									echo '<li><a href="login.php"><i class="fa fa-lock"></i> Đăng nhập</a></li>';
								}
								?>
								
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div><!--/header-middle-->
		<div class="header-bottom"><!--header-bottom-->
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<div class="mainmenu pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="index.php" class="active">Trang chủ</a></li>
								<li class="dropdown"><a href="#">Shop<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        <li><a href="index.php">Sản phẩm</a></li>
										<li><a href="checkout.php">Thanh toán</a></li>
										<li><a href="cart.php">Giỏ hàng</a></li>
                                    </ul>
                                </li>
								<li><a href="404.php">404</a></li>
								<li><a href="contact-us.php">Liên hệ</a></li>
							</ul>
						</div>
					</div>
					<?php
					$chuoicha = $_SERVER['PHP_SELF'];
					if (strlen(strstr($chuoicha, 'index.php')) > 0) {
					?>
					<div class="col-sm-4">
						<div class="search_box pull-right" style="width: 100%">
							<form action="" method="post">
								<input type="text" name="search" id="search" placeholder="Bạn tìm gì..."/>
								<input style="visibility: hidden; width: 5%;" type="submit" name="submit" value="Tìm" class="btn btn-info" id="btn-submit">
							</form>
						</div>
					</div>
					<?php 
					}
					?>
					<div class="col-sm-3" id="show-content">
						<div class="list-group" id="show-list"></div>
					</div>
				</div>
			</div>
		</div><!--/header-bottom-->
	</header>