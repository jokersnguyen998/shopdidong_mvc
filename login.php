<?php
	include 'inc/header.php';
	
	$redirectTo = "http://localhost/shopdidong_mvc/callback.php";
  	$data = ['email'];
  	$fullURL = $handler->getLoginUrl($redirectTo, $data);
?>
<?php
	$check_login = Session::get('customer_login');
	if ($check_login){
		echo "<script>window.location='checkout.php'</script>";
	}
?>
<?php
	$cus = new customer();
	// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
	// 	$loginCus = $cus->login_customer($_POST);
	// }
?>
<section style="margin-top: 0%;" id="form"><!--form-->
	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-sm-offset-1">
				<div class="login-form"><!--login form-->
					<h2>Login to your account</h2>
					<form action="" method="post">
						<input id="email-login" type="email" name="cus_email" placeholder="Email" />
						<input id="pass-login" type="password" name="cus_password" placeholder="Password" />
						<span>
							<input type="checkbox" class="checkbox"> 
							Keep me signed in
						</span>
						<button type="submit" name="login" id="login1" class="btn btn-default">Login</button>
						<a href="<?php echo $fullURL ?>" id="login_facebook" class="btn btn-primary">Login with Facebook</a>
					</form>
				</div><!--/login form-->
			</div>

			<div class="col-sm-1">
				<h2 class="or">OR</h2>
			</div>
			<div class="col-sm-5">
				<div class="signup-form"><!--sign up form-->
					<h2>New User Signup!</h2>
					<form action="" method="post">
						<input id="firstName" type="text" name="first_name" placeholder="First Name"/>
						<input id="lastName" type="text" name="last_name" placeholder="Last Name"/>
						<input type="email" name="cus_email" placeholder="Email" id="error-mail" onblur="checkEmail(this.value)" />
						<span id="check"></span>
						<input id="pass" type="password" name="cus_password" placeholder="Password"/>
						<input id="address" type="text" name="cus_address" placeholder="Address"/>
						<input id="city" type="text" name="cus_city" placeholder="City"/>
						<input id="zipcode" type="text" name="cus_zipcode" placeholder="Zipcode"/>
						<input id="phone" type="text" name="cus_phone" placeholder="Phone"/>
						<button type="submit" name="submit" id="reg" class="btn btn-default">Signup</button>
					</form>
				</div><!--/sign up form-->
			</div>		
		</div>
	</div>
</section><!--/form-->
<?php
	include 'inc/footer.php';
?>