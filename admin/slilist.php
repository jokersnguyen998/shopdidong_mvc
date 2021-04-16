<?php
  include 'inc/header.php';
  include 'inc/sidebar.php';
  include '../classes/slider.php';
?>
<?php
  $sli = new slider();
  if (isset($_GET['delId'])) {
    $id = $_GET['delId'];
    $deleteSli = $sli->delete_slider($id);
  }
?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Slider List</h1>
            <?php
              if (isset($deleteSli)) {
                echo $deleteSli;
              }
            ?>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">List</a></li>
              <li class="breadcrumb-item active">Slider</li>
            </ol>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <a href="sliadd.php" class="btn btn-primary float-right m-2">Add</a>
            </div>
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Serial No.</th>
                        <th>Slider Name</th>
                        <th>Slider Image</th>
                        <th>Slider Content</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      $show_slider = $sli->show();
                      if ($show_slider) {
                        $i = 0;
                        while ($row = $show_slider->fetch_assoc()) {
                          $i++;
                      ?>
                      <tr>
                        <td class="text-center"><?php echo $i ?></td>
                        <td><?php echo $row['slider_name'] ?></td>
                        <td style="text-align: center;"><img style="object-fit: contain;" width="150px" height="100px" src="uploads/<?php echo $row['slider_img'] ?>" alt=""></td>
                        <td><?php echo $row['slider_content'] ?></td>
                        <td>
                          <a href="sliedit.php?sliId=<?php echo $row['slider_id'] ?>" class="btn btn-success">Edit</a>
                          <a onclick="return confirm('Do you want to delete?')" href="?delId=<?php echo $row['slider_id'] ?>" class="btn btn-danger">Delete</a>
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
