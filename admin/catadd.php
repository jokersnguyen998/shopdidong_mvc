<?php
  include 'inc/header.php';
  include 'inc/sidebar.php';
  include '../classes/category.php';
?>
<?php
  $cat = new category();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $catName = $_POST['catName'];
    $parentId = $_POST['parentId'];
    $catSlug = $_POST['catName'];

    $insertCat = $cat->insert_category($catName, $catSlug, $parentId);
  }
?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Category Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Add</a></li>
              <li class="breadcrumb-item active">Category</li>
            </ol>
          </div>
        </div>
      </div>
    <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <form action="catadd.php" method="post">
                            <div class="form-group">
                                <label>Tên danh mục</label>
                                <input type="text"
                                       class="form-control"
                                       name="catName"
                                       placeholder="Nhập tên danh mục">
                                <?php
                                  if (isset($insertCat)) {
                                    echo $insertCat;
                                  }
                                ?>
                            </div>
                            <div class="form-group">
                                <label>Danh mục cha</label>
                                <select class="form-control" name="parentId">
                                  <option value="">Chọn danh mục cha</option>
                                  <?php echo $cat->show_category_create() ?>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
<?php
  include 'inc/footer.php';
?>  
