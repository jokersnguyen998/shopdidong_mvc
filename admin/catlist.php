<?php
  include 'inc/header.php';
  include 'inc/sidebar.php';
  include '../classes/category.php';
?>
<?php
  $cat = new category();
  if (isset($_GET['delId'])) {
    $id = $_GET['delId'];
    $deleteCat = $cat->delete_category($id);
  }
?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Category List</h1>
            <?php
              if (isset($deleteCat)) {
                echo $deleteCat;
              }
            ?>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">List</a></li>
              <li class="breadcrumb-item active">Category</li>
            </ol>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <a href="catadd.php" class="btn btn-primary float-right m-2">Add</a>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <table  class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Serial No.</th>
                      <th>Category Name</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                      echo $cat->show_category_index();
                    ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php
  include 'inc/footer.php';
?>  
