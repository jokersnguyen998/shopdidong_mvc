<?php
  include 'inc/header.php';
  include 'inc/sidebar.php';
  include '../classes/order.php';
?>
<?php
$ord = new order();
if (isset($_GET['ordId'])) {
  $ordId = $_GET['ordId'];
}
?>
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Details Page</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Details</a></li>
            <li class="breadcrumb-item active">Order</li>
          </ol>
        </div>
      </div>
    </div>
    <div class="content">
      <div class="container-fluid">
              <div class="row">
                  <div class="col-md-12">
                      <?php
                      $getOrd = $ord->get_order($ordId);
                      if ($getOrd) {
                        $row = $getOrd->fetch_assoc();
                      }
                      ?>
                      <div class="row">
                          <div class="col-sm-6">
                              <div class="form-group col-md-12">
                                  <label>Tên khách hàng</label>
                                  <input type="text"
                                         class="form-control"
                                         name="name"
                                         value="<?php echo $row['first_name'] .' '.$row['last_name'] ?>"
                                         readonly>
                              </div>
                              <div class="form-group col-md-12">
                                  <label>Email</label>
                                  <input type="text"
                                         class="form-control"
                                         name="name"
                                         value="<?php echo $row['email'] ?>" readonly>
                              </div>
                              <div class="form-group col-md-12">
                                  <label>Địa chỉ</label>
                                  <input type="text"
                                         class="form-control"
                                         name="name"
                                         value="<?php echo $row['cus_address'] ?>" readonly>
                              </div>
                          </div>
                          <div class="col-sm-6">
                              <div class="form-group col-md-12">
                                  <label>Số điện thoại</label>
                                  <input type="text"
                                         class="form-control"
                                         name="name"
                                         value="<?php echo $row['cus_phone'] ?>" readonly>
                              </div>
                              <div class="form-group col-md-12">
                                  <label>Hình thức thanh toán</label>
                                  <input type="text"
                                         class="form-control"
                                         name="name"
                                         value="<?php echo $row['shipping'] ?>" readonly>
                              </div>
                              <div class="form-group col-md-12">
                                  <label>Tổng tiền</label>
                                  <input type="text"
                                         class="form-control"
                                         name="name"
                                         value="<?php echo number_format($row['total'],'0',',') ?> VNĐ" readonly>
                               </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                              <label>Chi tiết đơn hàng: <?php echo $row['date_order'] ?></label>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Hình ảnh</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $getOrdDetails = $ord->get_orderdetails($ordId);
                            if ($getOrdDetails) {
                              $i = 0;
                              while($row1 = $getOrdDetails->fetch_assoc()){
                                $i++;
                            ?>
                            <tr>
                                <th scope="row"><?php echo $i ?></th>
                                <td><?php echo $row1['proName'] ?></td>
                                <td>
                                    <img style="object-fit: contain; width: 100px; height: 100px" class="product-image" src="uploads/<?php echo $row1['image'] ?>" alt="">
                                </td>
                                <td><?php echo number_format($row1['price'],'0',',') ?> VNĐ</td>
                                <td><?php echo $row1['quantity'] ?></td>
                                <td><?php echo number_format($row1['price']*$row1['quantity'],'0',',') ?> VNĐ</td>
                            </tr>
                            <?php
                                }
                              }
                            ?>
                        </tbody>
                        </table>
                        <?php
                        if ($row['status'] == 0) {
                        ?>
                            <div class="col-md-12 text-center">
                                <a href="" data-id="<?php echo $ordId ?>" class="btn btn-primary confirm-ord">Xác nhận đơn hàng</a>
                                <!-- <input type="hidden" id="ordId" value="<?php echo $ordId ?>"> -->
                                <a href="" data-id="<?php echo $ordId ?>" class="btn btn-danger cancel-ord">Hủy đơn hàng</a>
                            </div>
                        <?php
                        } else{
                        ?>
                        <div class="col-md-12 text-center">
                            <span><p style="font-weight: 900">Đơn hàng đã được xác nhận vào: <?php echo $row['date_confirm'] ?></p></span>
                        </div>
                        <?php    
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
