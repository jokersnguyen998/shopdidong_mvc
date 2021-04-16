<?php
  include 'inc/header.php';
  include 'inc/sidebar.php';
  include '../classes/category.php';
  include '../classes/brand.php';
  include '../classes/product.php';
?>
<?php
  $pro = new product();
  $fm = new Format();
  if (isset($_GET['delId'])) {
    $id = $_GET['delId'];
    $deletePro = $pro->delete_product($id);
  }
?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Product List</h1>
            <?php
              if (isset($deletePro)) {
                echo $deletePro;
              }
            ?>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">List</a></li>
              <li class="breadcrumb-item active">Product</li>
            </ol>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <a href="proadd.php" class="btn btn-primary float-right m-2">Add</a>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Serial No.</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Brand</th>
                        <th>Quantity</th>
                        <th>Type</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                        $show_pro = $pro->show_product_index();
                        if ($show_pro) {
                          $i = 0;
                          while ($result = $show_pro->fetch_assoc()) {
                            $i++;
                      ?>
                      <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td><?php echo $result['proName']; ?></td>
                        <td><?php echo $result['proPrice']; ?></td>
                        <td><img style="object-fit: contain;" width="150px" height="100px" src="uploads/<?php echo $result['proImage']; ?>" alt=""></td>
                        <td><?php echo $result['brandName']; ?></td>
                        <td class="text-center"class="text-center"><?php echo $result['proQuantity']; ?></td>
                        <td>
                          <?php
                            if ($result['proType'] == 1) {
                              echo "Nổi bật";
                            } else{
                              echo "Không nổi bật";
                            }
                          ?></td>
                        <td>
                          <a href="proedit.php?proId=<?php echo $result['proId'] ?>" class="btn btn-success">Edit</a>
                          <a onclick="return confirm('Do you want to delete?')" href="?delId=<?php echo $result['proId'] ?>" class="btn btn-danger">Delete</a>
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
  </div>
<?php
  include 'inc/footer.php';
?>  
