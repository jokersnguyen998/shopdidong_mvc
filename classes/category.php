<?php
	$file_path = realpath(dirname(__FILE__));
	include_once ($file_path . '/../lib/database.php');
	include_once ($file_path . '/../helpers/format.php');
	include_once ('recusive.php');
?>
<?php
	/**
	 * 
	 */
	class category
	{
		private $db;
		private $fm;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function insert_category($catName, $catSlug, $parentId)
		{
			$catName = $this->fm->validation($catName);
			$parentId = $this->fm->validation($parentId);
			$catSlug = $this->fm->slug($catName);

			$catName = mysqli_real_escape_string($this->db->link, $catName);
			$parentId = mysqli_real_escape_string($this->db->link, $parentId);
			$catSlug = mysqli_real_escape_string($this->db->link, $catSlug);

			if (empty($catName)) {
				$alert = "<span class='error'>Category must be not empty</span>";
				return $alert;
			} else{
				if (empty($parentId)) {
					$query = "INSERT INTO tbl_category(catName, catSlug) VALUES ('$catName', '$catSlug')";
				} else{
					$query = "INSERT INTO tbl_category(catName, catSlug, parentId) VALUES ('$catName', '$catSlug', '$parentId')";
				}
				
				$result = $this->db->insert($query);

				if ($result) {
					$alert = "<span class='success'>Insert done!</span>";
					return $alert;
				} else{
					$alert = "<span class='error'>Insert faild!</span>";
					return $alert;
				}
			}
		}

		public function get_category()
		{
			$query = "SELECT * FROM tbl_category";
			$result = $this->db->select($query);
			return $result;
		}

		public function array_category()
		{
			$result = $this->get_category();
			$data = array();
			if ($result) {
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
			}
			return $data;
		}

		public function get_catetgory_recusive($parentId)
		{
			$data = $this->array_category();
			$recusive = new recusive($data);
			$htmlSelect = $recusive->CategoryRecusiveSelect($parentId);
			return $htmlSelect;
		}

		public function get_catetgory_recusive_by_product($parentId)
		{
			$data = $this->array_category();
			$recusive = new recusive($data);
			$htmlSelect = $recusive->CategoryRecusiveSelectByProduct($parentId);
			return $htmlSelect;
		}

		public function show_category_product($parentId)
		{
			$html = $this->get_catetgory_recusive_by_product($parentId);
			return $html;
		}

		public function show_category_create()
		{
			$html = $this->get_catetgory_recusive($parentId = '');
			return $html;
		}

		public function show_category_edit($parentId)
		{
			$html = $this->get_catetgory_recusive($parentId);
			return $html;
		}

		public function show_category_index()
		{
			$data = $this->array_category();
			$recusiveTable = new recusive($data);
			$htmlTable = $recusiveTable->CategoryRecusiveTable();
			return $htmlTable;
		}

		public function get_category_by_id($id)
		{
			$query = "SELECT * FROM tbl_category WHERE catId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}

		public function update_category($catName, $catSlug, $parentId, $id)
		{
			$catName = $this->fm->validation($catName);
			$parentId = $this->fm->validation($parentId);
			$catSlug = $this->fm->slug($catName);

			$catName = mysqli_real_escape_string($this->db->link, $catName);
			$parentId = mysqli_real_escape_string($this->db->link, $parentId);
			$catSlug = mysqli_real_escape_string($this->db->link, $catSlug);
			$id = mysqli_real_escape_string($this->db->link, $id);

			if (empty($catName)) {
				$alert = "<span class='error'>Category must be not empty</span>";
				return $alert;
			} else{
				if (empty($parentId)) {
					$query = "UPDATE tbl_category SET catName = '$catName', catSlug = '$catSlug' WHERE catId = '$id'";
				} else{
					$query = "UPDATE tbl_category SET catName = '$catName', catSlug = '$catSlug', parentId = '$parentId' WHERE catId = '$id'";
				}
				
				$result = $this->db->update($query);

				if ($result) {
					$alert = "<span class='success'>Insert done!</span>";
					return $alert;
				} else{
					$alert = "<span class='error'>Insert faild!</span>";
					return $alert;
				}
			}
		}

		public function delete_category($id)
		{
			$query = "DELETE FROM tbl_category WHERE catId = '$id'";
			$result = $this->db->delete($query);
			if ($result) {
				$alert = "<span class='success'>Delete done!</span>";
				return $alert;
			} else{
				$alert = "<span class='error'>Delete faild!</span>";
				return $alert;
			}
		}

		///////////////////////FrontEnd//////////////////////////
		public function show_category_sidebar()
		{
			$query = "SELECT * FROM tbl_category WHERE parentId = 0";
			$result = $this->db->select($query);
			return $result;
		}

		public function show_category_tab()
		{
			$query = "SELECT * FROM tbl_category ORDER BY catId DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function categoryChildrent($catId)
		{
			$query = "SELECT * FROM tbl_category WHERE parentId = '$catId'";
			$result = $this->db->select($query);
			return $result;
		}

		public function get_product_by_category($id)
		{
			$query = "SELECT * FROM tbl_product WHERE catId = '$id' ORDER BY catId DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function get_name_by_category($id)
		{
			$query = "SELECT * FROM tbl_category WHERE catId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}
	}
?>