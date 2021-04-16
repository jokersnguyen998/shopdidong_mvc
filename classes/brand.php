<?php
	$file_path = realpath(dirname(__FILE__));
	include_once ($file_path . '/../lib/database.php');
	include_once ($file_path . '/../helpers/format.php');
?>
<?php
	/**
	 * 
	 */
	class brand
	{
		private $db;
		private $fm;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function insert_brand($braName, $braSlug)
		{
			$braName = $this->fm->validation($braName);
			$braSlug = $this->fm->slug($braSlug);

			$braName = mysqli_real_escape_string($this->db->link, $braName);
			$braSlug = mysqli_real_escape_string($this->db->link, $braSlug);

			if (empty($braName)) {
				$alert = "<span class='error'>Brand must be not empty</span>";
				return $alert;
			} else{
				$query = "INSERT INTO tbl_brand(brandName, brandSlug) VALUES ('$braName', '$braSlug')";
				$result = $this->db->insert($query);

				if ($result) {
					// header('Location:catlist.php');
					$alert = "<span class='success'>Insert done!</span>";
					return $alert;
				} else{
					$alert = "<span class='error'>Insert faild!</span>";
					return $alert;
				}
			}
		}

		public function show_brand()
		{
			$query = "SELECT * FROM tbl_brand ORDER BY brandId DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function get_brand_by_id($id)
		{
			$query = "SELECT * FROM tbl_brand WHERE brandId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}

		public function update_brand($braName, $braSlug, $id)
		{
			$braName = $this->fm->validation($braName);
			$braSlug = $this->fm->slug($braSlug);

			$braName = mysqli_real_escape_string($this->db->link, $braName);
			$braSlug = mysqli_real_escape_string($this->db->link, $braSlug);
			$id = mysqli_real_escape_string($this->db->link, $id);

			if (empty($braName)) {
				$alert = "<span class='error'>Brand must be not empty</span>";
				return $alert;
			} else{
				$query = "UPDATE tbl_brand SET brandName = '$braName', brandSlug = '$braSlug' WHERE brandId = '$id'";
				$result = $this->db->update($query);

				if ($result) {
					// header('Location:catlist.php');
					$alert = "<span class='success'>Update done!</span>";
					return $alert;
				} else{
					$alert = "<span class='error'>Update faild!</span>";
					return $alert;
				}
			}
		}

		public function delete_brand($id)
		{
			$query = "DELETE FROM tbl_brand WHERE brandId = '$id'";
			$result = $this->db->delete($query);
			if ($result) {
				// header('Location:catlist.php');
				$alert = "<span class='success'>Delete done!</span>";
				return $alert;
			} else{
				$alert = "<span class='error'>Delete faild!</span>";
				return $alert;
			}
		}

		///////////////////////FrontEnd//////////////////////////
		public function show_brand_sidebar()
		{
			$query = "SELECT * FROM tbl_brand ORDER BY brandName ASC";
			$result = $this->db->select($query);
			return $result;
		}

		public function count_product_by_brand($braId)
		{
			$query = "SELECT COUNT(*) AS total FROM tbl_product WHERE brandId = '$braId'";
			$result = $this->db->select($query);
			$data = $result->fetch_assoc();
			return $data;
		}

		public function get_product_by_brand($id)
		{
			$query = "SELECT * FROM tbl_product WHERE brandId = '$id' ORDER BY brandId DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function get_name_by_brand($id)
		{
			$query = "SELECT * FROM tbl_brand WHERE brandId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}

	}
?>