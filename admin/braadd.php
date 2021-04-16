<?php
  include 'inc/header.php';
  include 'inc/sidebar.php';
  include '../classes/brand.php';
?>
<?php
  $bra = new brand();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $braName = $_POST['braName'];
    $braSlug = $_POST['braName'];

    $insertBra = $bra->insert_brand($braName, $braSlug);
  }
?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Brand Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Add</a></li>
              <li class="breadcrumb-item active">Brand</li>
            </ol>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <form action="braadd.php" method="post">
                <div class="form-group">
                  <label>Tên thương hiệu</label>
                  <input type="text"
                         class="form-control"
                         name="braName"
                         placeholder="Nhập tên thương hiệu">
                    <?php
                    if (isset($insertBra)) {
                      echo $insertBra;
                    }
                    ?>
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
