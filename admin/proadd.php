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
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $insertPro = $pro->insert_product($_POST, $_FILES);
  }
?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Product Add</h1>
            <?php
                if (isset($insertPro)) {
                  echo $insertPro;
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
              <form action="proadd.php" method="post" enctype="multipart/form-data">
                <div class="form-group col-md-12">
                  <label>Tên sản phẩm</label>
                  <input type="text"
                         class="form-control"
                         name="proName"
                         placeholder="Tên sản phẩm">
                </div>
                <div class="form-group col-md-6">
                  <label>Danh mục</label>
                  <select class="form-control"
                          name="catId">
                      <option value="">Danh mục</option>
                      <?php
                        echo $cat->show_category_create();
                      ?>
                  </select>
                </div>
                <div style="margin-left: 50%;margin-top: -14.25%;" class="form-group col-md-6"> 
                  <label>Thương hiệu</label>
                  <select class="form-control"
                          name="braId">
                      <option value="">Thương hiệu</option>
                      <?php
                        $bra = new brand();
                        $getBra = $bra->show_brand();
                        if ($getBra) {
                          while ($return = $getBra->fetch_assoc()) {
                      ?>
                      <option value="<?php echo $return['brandId']; ?>"><?php echo $return['brandName']; ?></option>
                      <?php
                        }
                      }
                      ?>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>Giá</label>
                  <input type="text"
                         class="form-control"
                         name="proPrice"
                         placeholder="Giá sản phẩm">
                </div>
                <div style="margin-left: 50%;margin-top: -14.25%;" class="form-group col-md-6">
                  <label>Loại</label>
                  <select class="form-control"
                          name="proType">
                      <option value="">Loại</option>
                      <option value="1">Nổi bật</option>
                      <option value="0">Không nổi bật</option>
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label>Số lượng</label>
                  <input type="text"
                         class="form-control"
                         name="proQuantity"
                         placeholder="Số lượng">
                </div>
                <div style="margin-left: 50%;margin-top: -14.25%;" class="form-group col-md-6">
                  <label>Màu</label>
                  <input disabled="" type="text"
                         class="form-control"
                         name="proColor"
                         placeholder="Màu sắc">
                </div>
                <div class="form-group col-md-6">
                  <label>Ảnh sản phẩm</label>
                  <input type="file"
                         class="form-control"
                         name="proImage">
                </div>
                <div style="margin-left: 50%;margin-top: -14.25%;" class="form-group col-md-6">
                  <label>Ảnh chi tiết</label>
                  <input type="file" multiple 
                         class="form-control"
                         name="proImages[]">
                </div>
                <div class="form-group col-md-12">
                  <label>Mô tả</label>
                  <textarea class="textarea" name="proDescription" cols="8" rows="5" style="resize: none; width: 100%; height: 800px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
                
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
