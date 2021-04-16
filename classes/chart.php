<?php
	$file_path = realpath(dirname(__FILE__));
	include_once ($file_path . '/../lib/database.php');
	include_once ($file_path . '/../helpers/format.php');
?>
<?php
	/**
	 * 
	 */
	class chart
	{
		private $db;
		private $fm;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function getDate()
		{
			$arrDay = $this->fm->getListDayInMonth();
			return json_encode($arrDay);
		}

		public function getRevenue()
		{
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			$date = date('m');
			$query = "SELECT DATE(date_confirm) AS day, SUM(total) AS total FROM `tbl_order` WHERE status = 3 AND MONTH(date_confirm) = '$date' GROUP BY DAY(date_confirm)";
			$result = $this->db->select($query);
			if ($result) {
				foreach ($result as $key => $value) {
					$arrRev[] = array(
						'day'   => $value['day'],
						'total' => $value['total']
					);
				}
				$arrDay = $this->fm->getListDayInMonth();

				$arrRevenue = [];
				foreach ($arrDay as $day) {
					$total = 0;
					foreach ($arrRev as $key => $rev) {
						if ($rev['day'] == $day) {
							$total = $rev['total'];
							break;
						}
					}
					$arrRevenue[] = $total;
				}
				return json_encode($arrRevenue);
			}
		}

		public function getAllRevenue()
		{
			date_default_timezone_set('Asia/Ho_Chi_Minh');
			$date = date('m');
			$query = "SELECT DATE(date_order) AS day, SUM(total) AS total FROM `tbl_order` WHERE status = 1 AND MONTH(date_order) = '$date' GROUP BY DAY(date_order)";
			$result = $this->db->select($query);
			if ($result) {
				foreach ($result as $key => $value) {
					$arrRev[] = array(
						'day'   => $value['day'],
						'total' => $value['total']
					);
				}
				$arrDay = $this->fm->getListDayInMonth();

				$arrRevenue = [];
				foreach ($arrDay as $day) {
					$total = 0;
					foreach ($arrRev as $key => $rev) {
						if ($rev['day'] == $day) {
							$total = $rev['total'];
							break;
						}
					}
					$arrRevenue[] = $total;
				}
				return json_encode($arrRevenue);
			}
		}
	}
?>