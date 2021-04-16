<?php
	$file_path = realpath(dirname(__FILE__));
	include_once ($file_path . '/../lib/database.php');
	include_once ($file_path . '/../helpers/format.php');
?>
<?php
	/**
	 * 
	 */
	class admin
	{
		private $db;
		private $fm;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function getInfoAdmin($user_id)
		{
			$query = "SELECT * FROM tbl_admin WHERE id = '$user_id'";
			return $this->db->select($query);
		}

		public function update_profile($data, $file)
		{
			$user_id = mysqli_real_escape_string($this->db->link, $data['user_id']);
			$first_name = mysqli_real_escape_string($this->db->link, $data['first_name']);
			$last_name = mysqli_real_escape_string($this->db->link, $data['last_name']);
			$permited = array('jpg', 'jpeg', 'png', 'gif');
			$file = $_FILES['image'];
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
				$query = "UPDATE tbl_admin
						SET first_name = '$first_name',
							last_name = '$last_name',
							adminImage = '$unique_image'
						WHERE id = '$user_id'";
			} else {
				$query = "UPDATE tbl_admin
						SET first_name = '$first_name',
							last_name = '$last_name'
						WHERE id = '$user_id'";
			}
			$result = $this->db->update($query);
			if ($result) {
				return 1;
			}
			return 0;
		}

		public function check_pass($pass)
		{
			$user_id = Session::get('userData')['id'];
			$pwd = mysqli_real_escape_string($this->db->link, md5($pass));
			$query = "SELECT * FROM tbl_admin WHERE adminPass = '$pwd' AND id = '$user_id'";
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
			$query = "UPDATE tbl_admin SET adminPass = '$pwd' WHERE id = '$user_id'";
			$result = $this->db->update($query);
			if ($result) {
		    	return 1;
		    }
		    return 0;
		}
	}
?>