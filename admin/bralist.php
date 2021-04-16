<?php
  include 'inc/header.php';
  include 'inc/sidebar.php';
  include '../classes/brand.php';
?>
<?php
  $bra = new brand();
  if (isset($_GET['delId'])) {
    $id = $_GET['delId'];
    $deleteBra = $bra->delete_brand($id);
  }
?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Brand List</h1>
            <?php
              if (isset($deleteBra)) {
                echo $deleteBra;
              }
            ?>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">List</a></li>
              <li class="breadcrumb-item active">Brand</li>
            </ol>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <a href="braadd.php" class="btn btn-primary float-right m-2">Add</a>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Serial No.</th>
                      <th>Brand Name</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                      $show_bra = $bra->show_brand();
                      if ($show_bra) {
                        $i = 0;
                        while ($result = $show_bra->fetch_assoc()) {
                          $i++;
                    ?>
                    <tr>
                      <td class="text-center"><?php echo $i ?></td>
                      <td><?php echo $result['brandName'] ?></td>
                      <td>
                        <a href="braedit.php?braId=<?php echo $result['brandId'] ?>" class="btn btn-success">Edit</a>
                        <a onclick="return confirm('Do you want to delete?')" href="?delId=<?php echo $result['brandId'] ?>" class="btn btn-danger">Delete</a>
                      </td>
                    </tr>
                    <?php
                        }
                      }
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
