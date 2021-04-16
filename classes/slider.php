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
	class slider
	{
		private $db;
		private $fm;

		public function __construct()
		{
			$this->db = new Database();
			$this->fm = new Format();
		}

		public function insert_slider($slider_name, $slider_content, $files)
		{
			$slider_name = mysqli_real_escape_string($this->db->link, $slider_name);
			$slider_content = mysqli_real_escape_string($this->db->link, $slider_content);
			$permited = array('jpg', 'jpeg', 'png', 'gif');

			$file = $_FILES['slider_img'];
			$file_name = $file['name'];
			$div = explode('.', $file_name);
			$file_ext = strtolower(end($div));
			$unique_image = substr(md5(rand()), 0, 10) . '.' . $file_ext;
			$uploaded_image = "uploads/" . $unique_image;

			if ($slider_name == '' || $slider_content == '' || $file_name == '') {
				$alert = "<span class='error'>Fields must be not empty</span>";
				return $alert;
			} else{
				if (in_array($file_ext, $permited) == false) {
					$alert = "<span class='error'>Product photo must be: " . implode(', ', $permited) . "</span>";
					return $alert;
				}
				move_uploaded_file($file['tmp_name'], $uploaded_image);
				$query = "INSERT INTO tbl_slider(slider_name,slider_content,slider_img)
						VALUES('$slider_name','$slider_content','$unique_image')";
				$result = $this->db->insert($query);
				if ($result) {
					$alert = "<span class='success'>Insert done!</span>";
					return $alert;
				} else{
					$alert = "<span class='error'>Insert fail!</span>";
					return $alert;
				}
			}
		}

		public function update_slider($slider_name, $slider_content, $files, $id)
		{
			$slider_name = mysqli_real_escape_string($this->db->link, $slider_name);
			$slider_content = mysqli_real_escape_string($this->db->link, $slider_content);
			$permited = array('jpg', 'jpeg', 'png', 'gif');

			$file = $_FILES['slider_img'];
			$file_name = $file['name'];
			$div = explode('.', $file_name);
			$file_ext = strtolower(end($div));
			$unique_image = substr(md5(rand()), 0, 10) . '.' . $file_ext;
			$uploaded_image = "uploads/" . $unique_image;

			if ($slider_name == '' || $slider_content == '') {
				$alert = "<span class='error'>Fields must be not empty</span>";
				return $alert;
			} else{
				if (!empty($file_name)) {
					if (in_array($file_ext, $permited) == false) {
						$alert = "<span class='error'>Product photo must be: " . implode(', ', $permited) . "</span>";
						return $alert;
					}
					move_uploaded_file($file['tmp_name'], $uploaded_image);
					$query = "UPDATE tbl_slider SET slider_name = '$slider_name', slider_content='$slider_content', slider_img = '$unique_image' WHERE slider_id = $id";
				} else{
					$query = "UPDATE tbl_slider SET slider_name = '$slider_name', slider_content='$slider_content' WHERE slider_id = $id";
				}
				$result = $this->db->update($query);
				if ($result) {
					$alert = "<span class='success'>Update done!</span>";
					return $alert;
				} else{
					$alert = "<span class='error'>Update fail!</span>";
					return $alert;
				}
			}
		}

		public function show()
		{
			$query = "SELECT * FROM tbl_slider";
			$result = $this->db->select($query);
			return $result;
		}

		public function delete_slider($id)
		{
			$query = "DELETE FROM tbl_slider WHERE slider_id = $id";
			$result = $this->db->delete($query);
			if ($result) {
				$alert = "<span class='success'>Delete done!</span>";
				return $alert;
			} else{
				$alert = "<span class='error'>Delete fail!</span>";
				return $alert;
			}
		}

		public function get_slider_by_id($id)
		{
			$query = "SELECT * FROM tbl_slider WHERE slider_id = $id";
			$result = $this->db->select($query);
			return $result;
		}
	}
?>