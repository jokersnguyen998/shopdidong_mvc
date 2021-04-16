<?php
	$file_path = realpath(dirname(__FILE__));
	// include ($file_path . '/../lib/session.php');
	// Session::checkLogin();
	include_once ($file_path . '/../lib/database.php');
	include_once ($file_path . '/../helpers/format.php');
?>
<?php
	/**
	 * 
	 */
	class adminlogin
	{
		private $db;
		private $fm;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function admin_login($data)
		{
			$adminEmail = mysqli_real_escape_string($this->db->link, $data['adminEmail']);
			$adminPass = mysqli_real_escape_string($this->db->link, md5($data['adminPass']));

			if (empty($adminEmail) || empty($adminPass)) {
				return -1;
			} else{
				$query = "SELECT * FROM tbl_admin WHERE email = '$adminEmail' AND adminPass = '$adminPass' LIMIT 1";
				$result = $this->db->select($query);
				if ($result) {
					$value = $result->fetch_assoc();
					Session::set('adminlogin', true);
					Session::set('userData', $value);
					return 1;
				} else{
					return 0;
				}
			}
		}
	}
?>