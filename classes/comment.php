<?php
	$file_path = realpath(dirname(__FILE__));
	include_once ($file_path . '/../lib/database.php');
	include_once ($file_path . '/../helpers/format.php');
?>
<?php
	/**
	 * 
	 */
	class comment
	{
		private $db;
		private $fm;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function count($id)
		{
			$query = "SELECT COUNT(*) AS cmt FROM tbl_comment WHERE product_id = '$id'";
			$result = $this->db->select($query);
			return $result;
		}
	}
?>