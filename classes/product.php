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
	class product
	{
		private $db;
		private $fm;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function insert_product($data, $files)
		{
			$proName = mysqli_real_escape_string($this->db->link, $data['proName']);
			$catId = mysqli_real_escape_string($this->db->link, $data['catId']);
			$braId = mysqli_real_escape_string($this->db->link, $data['braId']);
			$proPrice = mysqli_real_escape_string($this->db->link, $data['proPrice']);
			$proDescription = mysqli_real_escape_string($this->db->link, $data['proDescription']);
			$proType = mysqli_real_escape_string($this->db->link, $data['proType']);
			$proQuantity = mysqli_real_escape_string($this->db->link, $data['proQuantity']);
			$permited = array('jpg', 'jpeg', 'png', 'gif');

			$file = $_FILES['proImage'];
			$file_name = $file['name'];
			$div = explode('.', $file_name);
			$file_ext = strtolower(end($div));
			$unique_image = substr(md5(rand()), 0, 10) . '.' . $file_ext;
			$uploaded_image = "uploads/" . $unique_image;

			$files = $_FILES['proImages'];
			$file_names = $files['name'];

			if ($proName == '' || $catId == '' || $braId == '' || $proPrice == '' || $proDescription == '' || $proType == '' || $proQuantity == '' || $file_name == '' || $file_names[0] == '') {
				$alert = "<span class='error'>Fields must be not empty</span>";
				return $alert;
			} else{
				if (in_array($file_ext, $permited) == false) {
					$alert = "<span class='error'>Product photo must be: " . implode(', ', $permited) . "</span>";
					return $alert;
				}
				move_uploaded_file($file['tmp_name'], $uploaded_image);
				$query = "INSERT INTO tbl_product(proName, catId, proDescription, proType, proPrice, proImage, brandId, proQuantity)
							VALUES ('$proName','$catId','$proDescription','$proType','$proPrice','$unique_image','$braId','$proQuantity')";
				$result = $this->db->insert($query);
				$proId = mysqli_insert_id($this->db->link);

				$file_exts = array();
				foreach ($file_names as $key => $value) {
					$divs = explode('.', $value);
					$file_exts[] = strtolower(end($divs));
				}
				$unique_images = array();
				foreach ($file_exts as $key => $value1) {
					$unique_images[] = substr(md5(rand()), 0, 10) . '.' . $value1;
				}
				
				foreach ($file_exts as $key => $value2) {
					if (in_array($value2, $permited) == false) {
						$alert = "<span class='error'>Details photo must be: " . implode(', ', $permited) . "</span>";
						return $alert;
						break;
					}
				}
				
				foreach ($unique_images as $key1 => $value1) {
					$uploaded_images = "uploads/" . $value1;
					move_uploaded_file($files['tmp_name'][$key1], $uploaded_images);
				}

				$check = 0;
				foreach ($unique_images as $key2 => $value2) {
					$result1 = $this->db->insert("INSERT INTO tbl_productimage(imgPath, proId) VALUES('$value2','$proId')");
					if (!$result1) {
						$check = 1;
						break;
					}
				}
				if ($result && $check == 0) {
					$alert = "<span class='success'>Insert done!</span>";
					return $alert;
				} else{
					$alert = "<span class='error'>Insert fail!</span>";
					return $alert;
				}
			}
		}

		public function show_product_index()
		{
			$query = "SELECT tbl_product.*, tbl_category.*, tbl_brand.*
			FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
			INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
			ORDER BY tbl_product.proId DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function get_product_by_id($id)
		{
			$query = "SELECT tbl_product.*, tbl_category.*
			FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
			WHERE proId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}

		public function get_image_by_product($id)
		{
			$query = "SELECT * FROM tbl_productimage WHERE proId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}

		public function update_product($data, $files, $id)
		{
			$proName = mysqli_real_escape_string($this->db->link, $data['proName']);
			$catId = mysqli_real_escape_string($this->db->link, $data['catId']);
			$braId = mysqli_real_escape_string($this->db->link, $data['braId']);
			$proPrice = mysqli_real_escape_string($this->db->link, $data['proPrice']);
			$proDescription = mysqli_real_escape_string($this->db->link, $data['proDescription']);
			$proType = mysqli_real_escape_string($this->db->link, $data['proType']);
			$proQuantity = mysqli_real_escape_string($this->db->link, $data['proQuantity']);
			$permited = array('jpg', 'jpeg', 'png', 'gif');

			if ($proName == '' || $catId == '' || $braId == '' || $proPrice == '' || $proDescription == '' || $proType == '' || $proQuantity == '') {
				$alert = "<span class='error'>Fields must be not empty</span>";
				return $alert;
			} else{
				$file = $_FILES['proImage'];
				$file_name = $file['name'];
				$div = explode('.', $file_name);
				$file_ext = strtolower(end($div));
				$unique_image = substr(md5(time()), 0, 10) . '.' . $file_ext;
				$uploaded_image = "uploads/" . $unique_image;
				
				$files = $_FILES['proImages'];
				$file_names = $files['name'];
				

				$file_exts = array();
				foreach ($file_names as $key => $value) {
					$divs = explode('.', $value);
					$file_exts[] = strtolower(end($divs));
				}
				$unique_images = array();
				foreach ($file_exts as $key => $value1) {
					$unique_images[] = substr(md5(rand()), 0, 10) . '.' . $value1;
				}
				
				if (!empty($file_name)) {
					if (in_array($file_ext, $permited) == false) {
						$alert = "<span class='error'>Product photo must be: " . implode(', ', $permited) . "</span>";
						return $alert;
					}
					move_uploaded_file($file['tmp_name'], $uploaded_image);
					$query = "UPDATE tbl_product SET
								proName = '$proName',
								catId = '$catId',
								proDescription = '$proDescription',
								proType = '$proType',
								proPrice = '$proPrice',
								proImage = '$unique_image',
								brandId = '$braId',
								proQuantity = '$proQuantity'
								WHERE proId = '$id'";
				} else{
					$query = "UPDATE tbl_product SET
								proName = '$proName',
								catId = '$catId',
								proDescription = '$proDescription',
								proType = '$proType',
								proPrice = '$proPrice',
								brandId = '$braId',
								proQuantity = '$proQuantity'
								WHERE proId = '$id'";
				}
				$result = $this->db->update($query);

				$check = 0;
				if ($file_names[0] != '') {
					foreach ($file_exts as $key => $value2) {
						if (in_array($value2, $permited) == false) {
							$alert = "<span class='error'>Details photo must be: " . implode(', ', $permited) . "</span>";
							return $alert;
							break;
						}
					}
					foreach ($unique_images as $key1 => $value1) {
						$uploaded_images = "uploads/" . $value1;
						move_uploaded_file($files['tmp_name'][$key1], $uploaded_images);
					}
					$this->db->delete("DELETE FROM tbl_productimage WHERE proId = '$id'");
					
					foreach ($unique_images as $key2 => $value2) {
						$result1 = $this->db->insert("INSERT INTO tbl_productimage(imgPath, proId) VALUES('$value2','$id')");
						if (!$result1) {
							$check = 1;
							break;
						}
					}
				}
				if ($result && $check == 0) {
					$alert = "<span class='success'>Delete done!</span>";
					return $alert;
				} else{
					$alert = "<span class='error'>Update faild!</span>";
					return $alert;
				}
			}
		}

		public function delete_product($id)
		{
			$query = "DELETE FROM tbl_product WHERE proId = '$id'";
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
		public function show_features_product()
		{
			$pro_one_page = 6;
			if (!isset($_GET['page'])) {
				$page = 1;
			} else{
				$page = $_GET['page'];
			}
			$index_page = ($page - 1) * $pro_one_page;
			$query = "SELECT * FROM tbl_product WHERE proType = 1 LIMIT $index_page, $pro_one_page";
			$result = $this->db->select($query);
			return $result;
		}

		public function paginate_features_product()
		{
			$query = "SELECT * FROM tbl_product WHERE proType = 1";
			$result = $this->db->select($query);
			return $result;
		}

		public function get_product_by_category($catId)
		{
			$query = "SELECT * FROM tbl_product WHERE catId = '$catId'";
			$result = $this->db->select($query);
			return $result;
		}

		public function show_recommended_product()
		{
			$query = "SELECT * FROM tbl_product ORDER BY view DESC";
			$result = $this->db->select($query);
			return $result;
		}

		public function get_product_by_id_frontend($id)
		{
			$query = "SELECT tbl_product.*, tbl_category.*, tbl_brand.*
			FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId
			INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
			WHERE tbl_product.proId = '$id'";
			$result = $this->db->select($query);
			return $result;
		}

		public function get_image_product_by_id($id)
		{
			$query = "SELECT * FROM tbl_productimage WHERE proId = $id";
			$result = $this->db->select($query);
			return $result;
		}

		public function get_product_by_category_id($catID, $id)
		{
			$query = "SELECT * FROM tbl_product WHERE catId = $catID AND proId NOT IN ($id) LIMIT 4";
			$result = $this->db->select($query);
			return $result;
		}

		public function get_product_by_name($proName)
		{
			$query = "SELECT * FROM tbl_product WHERE proName LIKE '%$proName%'";
			$result = $this->db->select($query);
			return $result;
		}

		public function get_rating($id)
		{
			$query = "SELECT AVG(rating) AS avg_rating FROM tbl_rating WHERE product_id = $id";
			$result = $this->db->select($query);
			return $result;
		}

		public function get_product_id($id)
		{
			$query = "SELECT * FROM tbl_product WHERE proId = '$id'";
			$result = $this->db->select($query);
			$row = $result->fetch_assoc();
			$check = 1;
			if (!isset($_SESSION["wishlist"])){
                $cart[$id] = array(
                	'id' 		  => $row['proId'],
                    'name' 	 	  => $row['proName'],
                    'image' 	  => $row['proImage'],
                    'price' 	  => $row['proPrice'],
                    'description' => $row['proDescription']
                );
                $_SESSION["wishlist"] = $cart;
            } else{
                $cart = $_SESSION["wishlist"];
            	if (array_key_exists($id, $cart) == false){
                    $cart[$id] = array(
	                	'id' 		  => $row['proId'],
	                    'name' 		  => $row['proName'],
	                    'image' 	  => $row['proImage'],
						'price' 	  => $row['proPrice'],
	                    'description' => $row['proDescription']
	                );
                    $_SESSION["wishlist"] = $cart;
                } else{
               		$check = 0;
                }
            }
            return $check;
		}
	}
?>