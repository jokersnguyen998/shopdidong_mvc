<?php
	include 'inc/header.php';
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['submit'])) {
	$contact = $cus->send_contact($_POST);
}
?> 
<div id="contact-page" class="container" data-contact="<?php echo $a = $contact?isset($contact):'' ?>">
	<div class="bg">
    	<div class="row">    		
    		<div class="col-sm-12">    			   			
				<h2 class="title text-center">Với <strong>chúng tôi</strong></h2>
			</div>			 		
		</div>    					
		<div class="row">  	
    		<div class="col-sm-8">
    			<div class="contact-form">
    				<h2 class="title text-center">Liên lạc</h2>
    				<div class="status alert alert-success" style="display: none"></div>
			    	<form action="" class="contact-form row" name="contact-form" method="post">
			            <div class="form-group col-md-6">
			                <input type="text" name="name" class="form-control" required="required" placeholder="Họ tên">
			            </div>
			            <div class="form-group col-md-6">
			                <input type="email" name="email" class="form-control" required="required" placeholder="Email">
			            </div>
			            <div class="form-group col-md-12">
			                <input type="text" name="subject" class="form-control" required="required" placeholder="Tiêu đề">
			            </div>
			            <div class="form-group col-md-12">
			                <textarea name="message" id="message" required="required" class="form-control" rows="8" placeholder="Nội dung"></textarea>
			            </div>                        
			            <div class="form-group col-md-12">
			                <input type="submit" name="submit" class="btn btn-primary pull-right" value="Gửi">
			            </div>
			        </form>
    			</div>
    		</div>
    		<div class="col-sm-4">
    			<div class="contact-info">
    				<h2 class="title text-center">Thông tin liên lạc</h2>
    				<address>
    					<p>H-Shop Inc.</p>
						<p>Khu II, đường 3/2, P. Xuân Khánh, Q. Ninh Kiều, TP. Cần Thơ.</p>
						<p>Cần Thơ, Việt Nam</p>
						<p>Điện thoại: +84 938 858 944</p>
						<p>Fax: 1-714-252-0026</p>
						<p>Email: h-shop@gmail.com</p>
    				</address>
    				<div class="social-networks">
    					<h2 class="title text-center">Mạng xã hội</h2>
						<ul>
							<li>
								<a href="#"><i class="fa fa-facebook"></i></a>
							</li>
							<li>
								<a href="#"><i class="fa fa-twitter"></i></a>
							</li>
							<li>
								<a href="#"><i class="fa fa-google-plus"></i></a>
							</li>
							<li>
								<a href="#"><i class="fa fa-youtube"></i></a>
							</li>
						</ul>
    				</div>
    			</div>
			</div>    			
    	</div>  
	</div>	
</div><!--/#contact-page-->
<?php
	include 'inc/footer.php';
?>