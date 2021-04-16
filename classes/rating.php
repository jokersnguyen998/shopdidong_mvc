<?php
	$file_path = realpath(dirname(__FILE__));
	include_once ($file_path . '/../lib/database.php');
	include_once ($file_path . '/../helpers/format.php');
?>
<?php
	/**
	 * 
	 */
	class rating
	{
		private $db;
		private $fm;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function check_user_rating($id)
		{
			$cus_id = Session::get('customer_id');
			$query = "SELECT * FROM tbl_rating WHERE user_id = '$cus_id' AND product_id = '$id'";
		    $result = $this->db->select($query);
		    return $result;
		}
	}
?>