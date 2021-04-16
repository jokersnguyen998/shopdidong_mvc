<?php
    include 'inc/header.php';
?>
<?php
$getUser = $cus->get_customer();
$row = $getUser->fetch_assoc();
?>
<div class="container">
    <div class="row gutters">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="account-settings">
                        <div class="user-profile">
                            <div class="user-avatar">
                                <?php
                                if ($row['cus_image'] == null) {
                                    echo '<img style="width: 80%; margin-top: 10%;" src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin">';
                                } else{
                                    if ($row['type'] == 0) {
                                        echo '<img style="width: 80%; margin-top: 10%;" src="admin/uploads/'.$row["cus_image"].'" alt="Maxwell Admin">';
                                    } 
                                    if ($row['type'] == 1) {
                                        echo '<img style="width: 80%; margin-top: 10%;" src="admin/uploads/'.$row["cus_image"].'" alt="Maxwell Admin">';
                                    }
                                }
                                ?> 
                            </div>
                        </div>
                        <div style="margin-top: 10px" class="about">
                            <ul style="margin-left: -35px">
                                <li>
                                    <a id="list-history" href="history.php">Lịch sử mua hàng</a>
                                </li>
                                <li>
                                    <a data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" href="#">Đổi mật khẩu</a>
                                    
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body" id="list">
                   <h3>Lịch sử mua hàng</h3>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ngày đặt</th>
                                <th scope="col">Tổng tiền</th>
                                <th scope="col">Ngày xác nhận</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $get_history = $ord->get_order_history();
                        if ($get_history) {
                            foreach ($get_history as $key => $row) {
                        ?>
                        <tr>
                            <th scope="row"><?php echo $key ?></th>
                            <td><?php echo $row['date_order'] ?></td>
                            <td><?php echo number_format($row['total'], 0, ',')?> VNĐ</td>
                            <td><?php echo $row['date_confirm'] ?></td>
                            <td>
                                <button style="margin-top: -4px;" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Chi tiết</button>
                                <?php
                                if ($row['date_confirm'] == "") {
                                    echo '<button style="margin-top: -4px;" type="button" class="btn btn-danger huy-don" data-id="'.$row['order_id'].'">Hủy đơn</button>';
                                }
                                ?>
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
<!-- Modal Details -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div style="width: 800px;" class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Chi tiết đơn hàng</h4>
            <button style="margin-top: -5%;" type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
                    <th scope="col">Sản phẩm</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $get_history_detail = $ord->get_orderdetail($row['order_id']);
            if ($get_history_detail) {
                foreach ($get_history_detail as $key => $val) {
            ?>
            <tr>
                <th scope="row"><?php echo $key ?></th>
                <td><img style="width: 50px; height: 50px;" src="admin/uploads/<?php echo $val['image'] ?>"></td>
                <td><?php echo $val['proName'] ?> VNĐ</td>
                <td><?php echo number_format($val['price'],0,',') ?> VNĐ</td>
                <td><?php echo $val['quantity'] ?></td>
                <td><?php echo number_format($val['quantity']*$val['price'], 0, ',')?> VNĐ</td>
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
<!-- Modal Change Password -->
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