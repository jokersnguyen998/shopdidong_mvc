<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	$file_path = realpath(dirname(__FILE__));
	include_once ($file_path . '/../lib/database.php');
	include_once ($file_path . '/../helpers/format.php');	
	include_once ($file_path . '/../lib/PHPMailer/src/Exception.php');
	include_once ($file_path . '/../lib/PHPMailer/src/PHPMailer.php');
	include_once ($file_path . '/../lib/PHPMailer/src/SMTP.php');
	include_once ('email.php');
?>
<?php
	/**
	 * 
	 */
	class order
	{
		private $db;
		private $fm;
		private $m;
		private $email;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
			$this->m = new PHPMailer();
			$this->email = new email();
		}

		public function insert_order($data)
		{
			$user_id = Session::get('userData')['id'];
			$user_name = mysqli_real_escape_string($this->db->link, $data['user_name']);
			$t = mysqli_real_escape_string($this->db->link, $data['total']);
			$address = mysqli_real_escape_string($this->db->link, $data['address']);
			$email = mysqli_real_escape_string($this->db->link, $data['email']);
			$phone = mysqli_real_escape_string($this->db->link, $data['phone']);
			$zipcode = mysqli_real_escape_string($this->db->link, $data['zipcode']);
			$shipping = mysqli_real_escape_string($this->db->link, $data['payment']);
			$dis = mysqli_real_escape_string($this->db->link, $data['discount']);
			$dis_code = mysqli_real_escape_string($this->db->link, $data['discount_code']);
			$total = (int)$t - (int)$t * 5 / 100;
			$date_order = $this->fm->get_current_weekday();

			$query = "INSERT INTO tbl_order(user_id, total, address, email, phone, zipcode, date_order, status, shipping)
						VALUES('$user_id', '$total', '$address', '$email', '$phone', '$zipcode', '$date_order', '0', '$shipping')";
			$result = $this->db->insert($query);
			$order_id = mysqli_insert_id($this->db->link);

			$check = 1;
			$carts = Session::get('cart');

			foreach ($carts as $key => $cart) {
				$product_id = $key;
				$price = $cart['price'];
				$image = $cart['image'];
				$quantity = $cart['quantity'];
				$query1 = "INSERT INTO tbl_orderdetail(order_id, product_id, price, quantity, image)
							VALUES('$order_id', '$product_id', '$price', '$quantity', '$image')";
				$result1 = $this->db->insert($query1);
				if (!$result1) {
					$check = 0; break;
				}
			}
			
			if ($dis_code != "") {
				$this->db->delete("DELETE FROM tbl_discount WHERE discount_code = '$dis_code'");
			}

			$discount_code = $this->generateRandomString(15);
			$expiry_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). ' + 30 days'));
			$discount = 0;
			if ($total >= 5000000 && $total < 10000000) {
				$discount = 5;
				$query2 = "INSERT INTO tbl_discount(user_id, discount_code, discount, expiry_date) 
							VALUES('$user_id', '$discount_code', '$discount', '$expiry_date')";
				
			} elseif ($total >= 10000000) {
				$discount = 10;
				$query2 = "INSERT INTO tbl_discount(user_id, discount_code, discount, expiry_date) 
							VALUES('$user_id', '$discount_code', '$discount', '$expiry_date')";
			}
			
			if ($discount != 0) {
				$this->db->insert($query2);
			}

			$s = $this->checkout_send_mail($email, $user_name, $shipping, $phone, $address, $total, $discount_code, $discount);
			if (!$s) {
				$alert = "Không thể gửi mail";
				return $alert;
			} else{
				if ($result && $check == 1) {
					unset($_SESSION['cart']);
					$alert = "<script>window.location='mail_checkout.php'</script>";
					return $alert;
				} else{
					$alert = "Thanh toán thất bại";
					return $alert;
				}
			}
		}

		//Hàm random mã discount
		function generateRandomString($length) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}

		function checkout_send_mail($mail1, $name, $shipping, $phone, $address, $total, $discount_code, $discount)
		{
			// $this->m->SMTPDebug = 4;
			$this->m->CharSet = "UTF-8";
			$this->m->isSMTP();
			$this->m->Host = "smtp.gmail.com";
			$this->m->Port = 587;
			$this->m->SMTPAuth = true;
			$this->m->Username = "klthuynguyen1998@gmail.com";
			$this->m->Password = "7649xitrum";
			$this->m->SMTPSecure = "tls";
			
			$this->m->setFrom("hshop@gmail.com", "H-Shop");
			$this->m->addAddress($mail1, $name);

			$this->m->isHTML(true);
			$this->m->Subject = "Cảm ơn bạn đã mua hàng tại website H-Shop của chúng tôi";
			$content = $this->email->html_email($name, $shipping, $phone, $address, $total, $discount_code, $discount);
			$this->m->Body = $content;

			if($this->m->send()){
				return true;
			} else{
				return false;
			}
		}

		public function get_all_order()
		{
			$query = "SELECT tbl_order.*, tbl_customer.*
					FROM tbl_order INNER JOIN tbl_customer ON tbl_order.user_id = tbl_customer.id
					WHERE status NOT IN (4)
					ORDER BY date_order DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function get_order($id)
		{
			$query = "SELECT tbl_order.*, tbl_customer.*
					FROM tbl_order INNER JOIN tbl_customer ON tbl_order.user_id = tbl_customer.id
					WHERE order_id = '$id'";
			$result = $this->db->select($query);
			return $result;
		}

		public function get_orderdetails($id)
		{
			$query = "SELECT tbl_order.*, tbl_orderdetail.*, tbl_product.*
					FROM tbl_order
					INNER JOIN tbl_orderdetail ON tbl_order.order_id = tbl_orderdetail.order_id
					INNER JOIN tbl_product ON tbl_orderdetail.product_id = tbl_product.proId
					WHERE tbl_order.order_id = '$id'";
			$result = $this->db->select($query);
			return $result;
		}

		public function set_confirm_status($id)
		{
			$date_confirm = $this->fm->get_current_weekday();
			$query = "UPDATE tbl_order SET status = '1', date_confirm = '$date_confirm' WHERE order_id = '$id'";
			$result = $this->db->update($query);
			if ($result) {
				return 1;
			} else{
				return 0;
			}
		}

		public function set_cancel_status($id)
		{
			$query = "UPDATE tbl_order SET status = '4' WHERE order_id = '$id'";
			$result = $this->db->update($query);
			if ($result) {
				return 1;
			} else{
				return 0;
			}
		}

		public function set_checkout_status($id)
		{
			$query = "UPDATE tbl_order SET status = '3' WHERE order_id = '$id'";
			$result = $this->db->update($query);
			if ($result) {
				return 1;
			} else{
				return 0;
			}
		}

		public function get_order_history()
		{
			$user_id = Session::get('userData')['id'];
			$query  = "SELECT tbl_order.*, tbl_orderdetail.* 
                        FROM tbl_order INNER JOIN tbl_orderdetail ON tbl_order.order_id = tbl_orderdetail.order_id
                        WHERE user_id = '$user_id' AND status NOT IN (4)";
            $result = $this->db->select($query);
            return $result;
		}

		public function get_orderdetail($id)
		{
			$query  = "SELECT tbl_orderdetail.*, tbl_product.*
					FROM tbl_orderdetail
					INNER JOIN tbl_product ON tbl_orderdetail.product_id = tbl_product.proId
					WHERE tbl_orderdetail.order_id = '$id'";
            $result = $this->db->select($query);
            return $result;
		}
	}
?>