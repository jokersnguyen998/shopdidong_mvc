<?php
  include 'inc/header.php';
  include 'inc/sidebar.php';
  include '../classes/order.php';
?>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Order Page</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Order</li>
            </ol>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Mã ĐH</th>
                        <th>Tên người đặt</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Hình thức thanh toán</th>
                        <th>Trạng thái</th>
                        <th></th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php
                      $ord = new order();
                      $getAllOrd = $ord->get_all_order();
                      if ($getAllOrd) {
                        $i = 0;
                        while($row = $getAllOrd->fetch_assoc()){
                          $i++;
                      ?>
                      <tr>
                        <td><?php echo $row['order_id'] ?></td>
                        <td><?php echo $row['first_name'] .' '.$row['last_name'] ?></td>
                        <td><?php echo $row['date_order'] ?></td>
                        <td><?php echo number_format($row['total'],'0',',') ?> VNĐ</td>
                        <td><?php echo $row['shipping'] ?></td>
                        <?php
                        if ($row['status'] == 0) {
                          $status = "Mới đặt hàng";
                          echo "<td style='color:orange'>".$status."</td>";
                        } else{
                            if ($row['status'] == 1) {
                            $status = "Đã xác nhận";
                            echo "<td style='color:green'>".$status."</td>";
                          } else{
                            if ($row['status'] == 2) {
                              $status = "Đang vận chuyển";
                              echo "<td style='color:blue'>".$status."</td>";
                            } else{
                              if ($row['status'] == 3) {
                                $status = "Đã thanh toán";
                                echo "<td style='color:forestgreen'>".$status."</td>";
                              } else{
                                $status = "Đã hủy";
                                echo "<td style='color:red'>".$status."</td>";
                              }
                            }
                          }
                        }
                        ?>
                        <td>
                          <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                            <div class="btn-group" role="group">
                              <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Tùy chọn
                              </button>
                              <div class="dropdown-menu acxx" aria-labelledby="btnGroupDrop1">
                                <a href="orderedit.php?ordId=<?php echo $row['order_id'] ?>" class="dropdown-item">Xem đơn hàng</a>

                                <?php
                                if ($row['status'] == 0) {
                                  echo '<a href="" data-id="'.$row["order_id"].'" class="dropdown-item confirm-ord">Xác nhận đơn</a>';
                                }
                                ?>
                                
                                <?php
                                if ($row['status'] == 1) {
                                  echo '<a href="" data-id="'.$row["order_id"].'" class="dropdown-item checkout-ord">Thanh toán</a>';
                                }
                                ?>

                                <?php
                                if ($row['status'] != 3) {
                                  echo '<a href="" data-id="'.$row["order_id"].'" class="dropdown-item cancel-ord">Hủy đơn</a>';
                                }
                                ?>                          
                                
                              </div>
                            </div>
                          </div>
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
