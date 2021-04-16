<?php
    include 'inc/header.php';
?>
<?php
$getInfo = $cus->get_customer();
$row = $getInfo->fetch_assoc();
?>
<div class="cart_wrapper">
    <div style="float: right" class="col-md-12">
        <div class="clearfix"></div>
        <div class="col-md-offset-1">
            <p class="info">Cảm ơn <b><?php echo $row['first_name'] .' '. $row['last_name'] ?></b>, bạn đã thanh toán thành công</p>
            <p>&#9830; Hóa đơn mua hàng của bạn đã được gửi đến địa chỉ email <b><?php echo $row['email'] ?></b></p>
            <p>&#9830; Sản phẩm của bạn sẽ được chuyển đến địa chỉ <b><?php echo $row['cus_address'] ?></b> sau thời gian 2 đến 3 ngày, tính từ thời điểm này.</p>
            <p>&#9830; Nhân viên giao hàng sẽ liên hệ với Quý khách qua số điện thoại <b><?php echo $row['cus_phone'] ?></b> trước khi giao hàng 24 tiếng.</p>
            <p>&#9830; Địa chỉ tại Khu II, đường 3/2, P. Xuân Khánh, Q. Ninh Kiều, TP. Cần Thơ.</p>
            <p>Cảm ơn bạn đã mua hàng tại website H-Shop của chúng Tôi!</p>
        </div>
    </div>
    <p class="text-center"><a href="index.php">Tiếp tục mua sắm</a></p>
</div>
<?php
    include 'inc/footer.php';
?>