<?php
  include 'inc/header.php';
  include 'inc/sidebar.php';
  include '../classes/category.php';
?>
<?php
  $cat = new category();
  if (!isset($_GET['catId']) || $_GET['catId'] == NULL) {
    echo "<script>window.location='catlist.php'</script>";
  } else{
    $id = $_GET['catId'];
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $catName = $_POST['catName'];
    $parentId = $_POST['parentId'];
    $catSlug = $_POST['catName'];

    $updateCat = $cat->update_category($catName, $catSlug, $parentId, $id);
  }
?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Category Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Edit</a></li>
              <li class="breadcrumb-item active">Category</li>
            </ol>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <?php
                $get_cat_name = $cat->get_category_by_id($id);
                if ($get_cat_name) {
                  while ($result = $get_cat_name->fetch_assoc()) {
                    $parentId1 = $result['parentId'];
              ?>
              <form action="" method="post">
                <div class="form-group">
                    <label>Tên danh mục</label>
                    <input type="text" class="form-control" name="catName" value="<?php echo $result['catName'] ?>">
                    <?php
                      if (isset($updateCat)) {
                        echo $updateCat;
                      }
                    ?>
                </div>
                <div class="form-group">
                  <label>Danh mục cha</label>
                  <select class="form-control" name="parentId">
                    <option value="">Chọn danh mục cha</option>
                    <?php echo $cat->show_category_edit($parentId1); ?>
                  </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
              <?php
                  }
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
  include 'inc/footer.php';
?>  
 