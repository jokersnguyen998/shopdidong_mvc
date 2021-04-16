<?php
  include 'inc/header.php';
  include 'inc/sidebar.php';
  include '../classes/slider.php';
?>
<?php
  $sli = new slider();
  if (!isset($_GET['sliId']) || $_GET['sliId'] == NULL) {
    echo "<script>window.location='slilist.php'</script>";
  } else{
    $id = $_GET['sliId'];
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $slider_name = $_POST['slider_name'];
    $slider_content = $_POST['slider_content'];

    $updateSli = $sli->update_slider($slider_name, $slider_content, $_FILES, $id);
  }
?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Slider Edit</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Edit</a></li>
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
                      if (isset($updateSli)) {
                        echo $updateSli;
                      }
                      $get_slider = $sli->get_slider_by_id($id);
                      if ($get_slider) {
                        while ($row = $get_slider->fetch_assoc()) {
                      ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Tên slider</label>
                                <input type="text"
                                       class="form-control"
                                       name="slider_name"
                                       value="<?php echo $row['slider_name'] ?>">
                            </div>
                            <div class="form-group">
                                <label>Nội dung slider</label>
                                <textarea class="form-control" rows="5" name="slider_content"><?php echo $row['slider_content'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Ảnh slider</label>
                                <input type="file"
                                       class="form-control"
                                       name="slider_img">
                                <img width="100px" height="100px" src="uploads/<?php echo $row['slider_img']; ?>" alt="">
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
