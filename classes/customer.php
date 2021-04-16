<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;
	$file_path = realpath(dirname(__FILE__));
	include_once ($file_path . '/../lib/database.php');
	include_once ($file_path . '/../helpers/format.php');
	include_once ($file_path . '/../lib/PHPMailer/src/Exception.php');
	include_once ($file_path . '/../lib/PHPMailer/src/PHPMailer.php');
	include_once ($file_path . '/../lib/PHPMailer/src/SMTP.php');
?>
<?php
	/**
	 * 
	 */
	class customer
	{
		private $db;
		private $fm;
		private $m;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
			$this->m = new PHPMailer();
		}

		public function insert_customer_ajax($data)
		{
			$id = '';
			$count = 0;
			while($count < 16) {
			    $id .= mt_rand(0, 9);
			    $count++;
			}
			$first_name = mysqli_real_escape_string($this->db->link, $data['first_name']);
			$last_name = mysqli_real_escape_string($this->db->link, $data['last_name']);
			$cus_email = mysqli_real_escape_string($this->db->link, $data['email']);
			$cus_password = md5(mysqli_real_escape_string($this->db->link, $data['pass']));
			$cus_address = mysqli_real_escape_string($this->db->link, $data['address']);
			$cus_city = mysqli_real_escape_string($this->db->link, $data['city']);
			$cus_zipcode = mysqli_real_escape_string($this->db->link, $data['zipcode']);
			$cus_phone = mysqli_real_escape_string($this->db->link, $data['phone']);

			$query = "INSERT INTO tbl_customer(id, first_name, last_name, cus_address, cus_city, cus_zipcode, cus_phone, email, cus_password, type)
			VALUES('$id', '$first_name', '$last_name', '$cus_address', '$cus_city', '$cus_zipcode',' $cus_phone', '$cus_email', '$cus_password', '0')";
			$this->db->insert($query);
		}

		public function update_customer($data, $files)
		{
			$type = 0;
			if (isset($_SESSION['access_token'])) {
				$type = 1;
			}
			$id = Session::get('userData')['id'];
			$first_name = mysqli_real_escape_string($this->db->link, $data['first_name']);
			$last_name = mysqli_real_escape_string($this->db->link, $data['last_name']);
			$cus_email = mysqli_real_escape_string($this->db->link, $data['cus_email']);
			$cus_address = mysqli_real_escape_string($this->db->link, $data['cus_address']);
			$cus_district = mysqli_real_escape_string($this->db->link, $data['cus_district']);
			$cus_city = mysqli_real_escape_string($this->db->link, $data['cus_city']);
			$cus_zipcode = mysqli_real_escape_string($this->db->link, $data['cus_zipcode']);
			$cus_phone = mysqli_real_escape_string($this->db->link, $data['cus_phone']);
			$permited = array('jpg', 'jpeg', 'png', 'gif');

			$file = $_FILES['cus_image'];
			$file_name =  $file['name'];
			$div = explode('.', $file_name);
			$file_ext = strtolower(end($div));
			$unique_image = substr(md5(rand()), 0, 10) . '.' . $file_ext;
			$uploaded_image = "admin/uploads/" . $unique_image;

			if($file_name != ""){
				if (in_array($file_ext, $permited) == false) {
					return -1;
				}
				move_uploaded_file($file['tmp_name'], $uploaded_image);
				$query = "UPDATE tbl_customer
						SET first_name = '$first_name',
							last_name = '$last_name',
							cus_address = '$cus_address',
							cus_district = '$cus_district',
							cus_city = '$cus_city',
							cus_zipcode = '$cus_zipcode',
							cus_phone = '$cus_phone',
							email = '$cus_email',
							cus_image = '$unique_image',
							type = '$type'
						WHERE id = '$id'";
			} else {
				$query = "UPDATE tbl_customer
						SET first_name = '$first_name',
							last_name = '$last_name',
							cus_address = '$cus_address',
							cus_district = '$cus_district',
							cus_city = '$cus_city',
							cus_zipcode = '$cus_zipcode',
							cus_phone = '$cus_phone',
							email = '$cus_email',
							type = '$type'
						WHERE id = '$id'";
			}
			$result = $this->db->update($query);
			if ($result) {
				return 1;
			} else{
				return 0;
			}
		}

		public function login_customer($data)
		{
			$cus_email = mysqli_real_escape_string($this->db->link, $data['email']);
			$cus_password = md5(mysqli_real_escape_string($this->db->link, $data['pass']));

			$query = "SELECT * FROM tbl_customer WHERE email = '$cus_email' AND cus_password = '$cus_password'";
	        $result = $this->db->select($query);
	        if ($result) {
	        	$row = $result->fetch_assoc();
                Session::set('customer_login', true);
                Session::set('userData', $row);
                return 1;
	        } else{
	        	return 0;
	        }
		}

		public function get_customer()
		{
			$id = Session::get('userData')['id'];
			$query = "SELECT * FROM tbl_customer WHERE id = '$id'";
		    $result = $this->db->select($query);
		    return $result;
		}


		/////////////////////FRONTEND////////////////////////
		public function check_user_commneted($id)
		{
			$iduser = Session::get('userData')['id'];
			$query = "SELECT cmt_id FROM tbl_comment WHERE user_id = '$iduser' AND product_id = '$id'";
		    $result = $this->db->select($query);
		    return $result;
		}

		function checkout_send_mail($email, $name, $subject, $message)
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
			$this->m->addAddress("huynguyen0938858944@gmail.com");

			$this->m->isHTML(true);
			$this->m->Subject = $subject;
			$this->m->Body = "Phản hồi từ khách hàng ".$name." có địa chỉ email ".$email." với nội dung: ".$message;

			if($this->m->send()){
				return true;
			}
			return false;
		}

		public function send_contact($data)
		{
			$name = mysqli_real_escape_string($this->db->link, $data['name']);
			$email = mysqli_real_escape_string($this->db->link, $data['email']);
			$subject = mysqli_real_escape_string($this->db->link, $data['subject']);
			$message = mysqli_real_escape_string($this->db->link, $data['message']);

			$s = $this->checkout_send_mail($name, $email, $subject, $message);
			if (!$s) {
				return 0;
			}
			return 1;
		}

		public function check_pass($pass)
		{
			$pwd = mysqli_real_escape_string($this->db->link, md5($pass));
			$query = "SELECT cus_id FROM tbl_customer WHERE cus_password = '$pwd'";
		    $result = $this->db->select($query);
		    if ($result) {
		    	return 1;
		    }
		    return 0;
		}

		public function change_pass($pass)
		{
			$user_id = Session::get('userData')['id'];
			$pwd = mysqli_real_escape_string($this->db->link, md5($pass));
			
			$query = "UPDATE tbl_customer SET cus_password = '$pwd' WHERE id = '$user_id'";
			$result = $this->db->update($query);
			if ($result) {
		    	return 1;
		    }
		    return 0;
		}
		
		public function get_discount()
		{
			$user_id = Session::get('userData')['id'];
			$date = date('Y-m-d H:i:s');
			$query = "SELECT * FROM tbl_discount WHERE user_id = '$user_id' AND expiry_date > '$date'";
		    $result = $this->db->select($query);
			return $result;
		}

	}
?>