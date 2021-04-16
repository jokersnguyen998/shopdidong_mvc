<?php
  include 'inc/header.php';
  include 'inc/sidebar.php';
  include '../classes/category.php';
  include '../classes/brand.php';
  include '../classes/product.php';
?>
<?php
  $pro = new product();
  $cat = new category();
  if (!isset($_GET['proId']) || $_GET['proId'] == NULL) {
    echo "<script>window.location='prolist.php'</script>";
  } else{
    $id = $_GET['proId'];
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $updatePro = $pro->update_product($_POST, $_FILES, $id);
  }
?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Product Add</h1>
            <?php
                if (isset($updatePro)) {
                  echo $updatePro;
                }
              ?>

          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Add</a></li>
              <li class="breadcrumb-item active">Product</li>
            </ol>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <?php
                $get_product = $pro->get_product_by_id($id);
                if ($get_product) {
                  while ($resultPro = $get_product->fetch_assoc()) {
                    $proId = $resultPro['proId'];
                    $catId = $resultPro['catId'];
              ?>
              <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group col-md-12">
                  <label>Tên sản phẩm</label>
                  <input type="text"
                         class="form-control"
                         name="proName"
                         value="<?php echo $resultPro['proName'] ?>">
                </div>
                <div class="form-group col-md-6">
                  <label>Danh mục</label>
                  <select class="form-control"
                          name="catId">
                      <option value="">Chọn danh mục</option>
                      <?php
                        echo $cat->show_category_product($catId);
                      ?>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>Thương hiệu</label>
                  <select class="form-control"
                          name="braId">
                      <option value="">Chọn thương hiệu</option>
                      <?php
                        $bra = new brand();
                        $getBra = $bra->show_brand();
                        if ($getBra) {
                          while ($result = $getBra->fetch_assoc()) {
                      ?>

                      <option 
                      <?php
                        if ($result['brandId'] == $resultPro['brandId']) {
                          echo "selected";
                        }
                      ?>
                        value="<?php echo $result['brandId']; ?>"><?php echo $result['brandName']; ?>
                        
                      </option>
                      <?php
                        }
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group col-md-12">
                  <label>Giá</label>
                  <input type="text"
                         class="form-control"
                         name="proPrice"
                         value="<?php echo $resultPro['proPrice'] ?>">
                </div>
                <div class="form-group col-md-12">
                  <label>Số lượng</label>
                  <input type="text"
                         class="form-control"
                         name="proQuantity"
                         value="<?php echo $resultPro['proQuantity'] ?>">
                </div>
                <div class="form-group col-md-12">
                  <label>Ảnh sản phẩm</label>
                  <input type="file"
                         class="form-control"
                         name="proImage">
                  <img width="100px" height="150px" src="uploads/<?php echo $resultPro['proImage']; ?>" alt="">
                </div>
                <div class="form-group col-md-12">
                  <label>Ảnh chi tiết</label>
                  <input type="file" multiple 
                         class="form-control"
                         name="proImages[]">
                  <?php
                    $getImg = $pro->get_image_by_product($proId);
                    if ($getImg) {
                      while ($result = $getImg->fetch_assoc()) {
                        echo "<img width='100px' height='150px' src='uploads/".$result['imgPath']."' alt=''>";
                      }
                    }    
                  ?>
                </div>
                <div class="form-group col-md-12">
                  <label>Mô tả</label>
                  <textarea class="textarea" name="proDescription"
                            style="width: 100%; height: 800px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?php echo $resultPro['proDescription']; ?></textarea>
                </div>
                <div class="form-group col-md-4">
                  <label>Loại</label>
                  <select class="form-control"
                          name="proType">
                      <option value="">Chọn loại</option>
                      <?php
                        if ($resultPro['proType'] == 1) {
                          echo "<option selected value='1'>Nổi bật</option>";
                          echo "<option value='0'>Không nổi bật</option>";
                        } else{
                          echo "<option value='1'>Nổi bật</option>";
                          echo "<option selected value='0'>Không nổi bật</option>";
                        }
                      ?> 
                  </select>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
