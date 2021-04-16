<?php
  include 'inc/header.php';
  include 'inc/sidebar.php';
  include '../classes/slider.php';
?>
<?php
  $sli = new slider();
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $slider_name = $_POST['slider_name'];
    $slider_content = $_POST['slider_content'];

    $insertSli = $sli->insert_slider($slider_name, $slider_content, $_FILES);
  }
?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Slider Add</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Add</a></li>
              <li class="breadcrumb-item active">Slider</li>
            </ol>
          </div>
        </div>
      </div>
    <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                      <?php
                        if (isset($insertSli)) {
                          echo $insertSli;
                        }
                      ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Tên slider</label>
                                <input type="text"
                                       class="form-control"
                                       name="slider_name"
                                       placeholder="Nhập tên slider">
                            </div>
                            <div class="form-group">
                                <label>Nội dung slider</label>
                                <textarea class="form-control" rows="5" name="slider_content"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Ảnh slider</label>
                                <input type="file"
                                       class="form-control"
                                       name="slider_img">
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
