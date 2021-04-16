<?php
  include 'inc/header.php';
  include 'inc/sidebar.php';
  include '../classes/admin.php';
?>
<!-- Content Wrapper. Contains page content -->
<<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Profile</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">User Profile</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <?php
          $adm = new admin();
          $user_id = Session::get('userData')['id'];
          $getInfo = $adm->getInfoAdmin($user_id);
          if ($getInfo) {
            $row = $getInfo->fetch_assoc();
          }
          ?>
          <!-- Profile Image -->
          <div class="card card-primary card-outline">
            <div class="card-body box-profile">
              <div class="text-center">
                <img class="profile-user-img img-fluid img-circle"
                     src="uploads/<?php echo $row['adminImage'] ?>"
                     alt="User profile picture">
              </div>
              <h3 class="profile-username text-center"><?php echo $row['first_name'].' '.$row['last_name'] ?></h3>
              <p class="text-muted text-center">Administrator</p>
              <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                  <b>Followers</b> <a class="float-right">1,322</a>
                </li>
                <li class="list-group-item">
                  <b>Following</b> <a class="float-right">543</a>
                </li>
                <li class="list-group-item">
                  <b>Friends</b> <a class="float-right">13,287</a>
                </li>
              </ul>
              <a href="https://www.facebook.com/huy.nqh2/" target="_blank" class="btn btn-primary btn-block"><b>Follow</b></a>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills"> 
                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Thay đổi thông tin</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="settings">
                  <form class="form-horizontal" id="information">
                    <div class="form-group row">
                      <label for="inputName" class="col-sm-2 col-form-label">Họ</label>
                      <div class="col-sm-6">
                        <input type="text" name="last_name" class="form-control"
                                id="inputName" value="<?php echo $row['last_name'] ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id ?>" id="inputName">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputName2" class="col-sm-2 col-form-label">Tên</label>
                      <div class="col-sm-6">
                        <input type="text" name="first_name" class="form-control"
                                id="inputName2" value="<?php echo $row['first_name'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-6">
                        <input readonly type="email" name="email" class="form-control"
                                id="inputEmail" value="<?php echo $row['email'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label">Tài khoản</label>
                      <div class="col-sm-6">
                        <input readonly type="text" name="username" class="form-control"
                                id="inputEmail" value="<?php echo $row['adminUser'] ?>">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="inputEmail" class="col-sm-2 col-form-label">Ảnh đại diện</label>
                      <div class="col-sm-6">
                        <input readonly type="file" name="image" class="form-control" id="inputEmail">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-2 col-sm-6">
                        <button type="submit" class="btn btn-danger">Cập nhật</button>
                        <button type="button" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" class="btn btn-warning">Đổi mật khẩu</button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div style="width: 80%;margin-left: 10%;" class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Thay đổi mật khẩu</h4>
        <button style="margin-top: -5%;" type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="fchangepass">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Mật khẩu:</label>
            <input type="password" class="form-control" id="password-old">
            <p id="error-pass" style="color: red"></p>
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Mật khẩu mới:</label>
            <input type="password" class="form-control" id="password-new">
          </div>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Nhập lại mật khẩu:</label>
            <input type="password" class="form-control" id="re-password">
            <p id="error-repass" style="color: red"></p>
          </div>
          <div class="form-group">
            <button style="margin-left: 40%;" type="submit" class="btn btn-primary change-pass">Xác nhận</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
  include 'inc/footer.php';
?>  
