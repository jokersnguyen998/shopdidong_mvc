<?php 
/**
 * 
 */
	class recusive
	{
		private $data;
		private $htmlSelect = '';
		private $htmlTable = '';

		public function __construct($data)
		{
			$this->data = $data;
		}

		public function CategoryRecusiveSelect($parentId, $id = 0, $char = '')
		{
			foreach ($this->data as $value) {
	            if ($value['parentId'] == $id) {
	              	if (!empty($parentId) && $parentId == $value['catId']) {
	              		$this->htmlSelect .= "<option selected value='".$value['catId']."'>".$char.$value['catName']."</option>";
	              	} else{
		              	$this->htmlSelect .= "<option value='".$value['catId']."'>".$char.$value['catName']."</option>";
	              	}
		            $this->CategoryRecusiveSelect($parentId, $value['catId'], $char . '|---');
              	}
          	}
          	return $this->htmlSelect;
		}

		public function CategoryRecusiveSelectByProduct($parentId, $id = 0, $char = '')
		{
			foreach ($this->data as $value) {
	            if ($value['parentId'] == $id) {
	              	if (!empty($parentId) && $parentId == $value['catId']) {
	              		$this->htmlSelect .= "<option selected value='".$value['catId']."'>".$char.$value['catName']."</option>";
	              	} else{
		              	$this->htmlSelect .= "<option value='".$value['catId']."'>".$char.$value['catName']."</option>";
	              	}
		            $this->CategoryRecusiveSelect($parentId, $value['catId'], $char . '|---');
              	}
          	}
          	return $this->htmlSelect;
		}

		public function CategoryRecusiveTable($id = 0, $char = '')
		{
			foreach ($this->data as $key => $item) {
				if ($item['parentId'] == $id) {
					$this->htmlTable .= "<tr>
                                  			<td>".$item['catId']."</td>
			                                <td>".$char . $item['catName']."</td>
			                                <td>
			                                	<a href='catedit.php?catId=".$item['catId']."' class='btn btn-success'>Edit</a>
			                                	<a onclick='return confirm('Do you want to delete?')'
			                                		href='?delId=".$item['catId']."' class='btn btn-danger'>Delete</a>
			                                </td>
			                            </tr>";
			        unset($this->data[$key]);
		            $this->CategoryRecusiveTable($item['catId'], $char . '|---');
				}
			}
			return $this->htmlTable;
		}
	}
?>