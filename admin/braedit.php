<?php
  include 'inc/header.php';
  include 'inc/sidebar.php';
  include '../classes/brand.php';
?>
<?php
  $bra = new brand();
  if (!isset($_GET['braId']) || $_GET['braId'] == NULL) {
    echo "<script>window.location='bralist.php'</script>";
  } else{
    $id = $_GET['braId'];
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $braName = $_POST['braName'];
    $braSlug = $_POST['braName'];

    $updateBra = $bra->update_brand($braName, $braSlug, $id);
  }
?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Brand Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Edit</a></li>
              <li class="breadcrumb-item active">Brand</li>
            </ol>
          </div>
        </div>
      </div>
    <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                      <?php
                        $get_bra_name = $bra->get_brand_by_id($id);
                        if ($get_bra_name) {
                          while ($result = $get_bra_name->fetch_assoc()) {
                      ?>
                        <form action="" method="post">
                            <div class="form-group">
                                <label>Tên thương hiệu</label>
                                <input type="text"
                                       class="form-control"
                                       name="braName"
                                       value="<?php echo $result['brandName'] ?>">
                                <?php
                                  if (isset($updateBra)) {
                                    echo $updateBra;
                                  }
                                ?>
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
 