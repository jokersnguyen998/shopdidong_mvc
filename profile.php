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
                                    <a href="#">Đổi mật khẩu</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body" id="list" data-id="<?php echo $row['id'] ?>">
                    <form action="search.php?type=profile" method="post" id="profile">
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mb-2 text-primary">Thông tin cá nhân</h6>
                            </div>
                            
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div id="firstNamediv" class="form-group">
                                    <label for="firstName1">Tên</label>
                                    <input type="text" class="form-control" id="firstName1"
                                           name="first_name" value="<?php echo $row['first_name'] ?>" require>
                                </div>
                                <div id="lastNamediv" class="form-group">
                                    <label for="lastName1">Họ</label>
                                    <input type="text" class="form-control" id="lastName1"
                                           name="last_name" value="<?php echo $row['last_name'] ?>" require>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="eMail">Email</label>
                                    <input style="cursor: context-menu;" readonly type="email" class="form-control" id="eMail"
                                           name="cus_email" value="<?php echo $row['email'] ?>" require>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="phone">Điện thoại</label>
                                    <input type="text" class="form-control" id="phone"
                                           name="cus_phone" value="<?php echo $row['cus_phone'] ?>" require>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div style="margin-top: -73px;" class="form-group">
                                    <label for="website">Ảnh đại diện</label>
                                    <input type="file" name="cus_image" class="form-control" id="file" require>
                                </div>
                            </div>
                        </div>
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <h6 class="mt-3 mb-2 text-primary">Địa chỉ</h6>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="Address">Địa chỉ</label>
                                    <input type="name" class="form-control" id="Address"
                                           name="cus_address" value="<?php echo $row['cus_address'] ?>" require>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="ciTy">Tỉnh/Thành</label>
                                    <input type="name" class="form-control" id="ciTy"
                                           name="cus_city" value="<?php echo $row['cus_city'] ?>">
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="sTate">Quận/Huyện</label>
                                    <input type="text" class="form-control" id="sTate" name="cus_district" value="<?php echo $row['cus_district'] ?>">
                                </div>

                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <label for="zIp">Zip Code</label>
                                    <input type="text" class="form-control" id="zIp"
                                           name="cus_zipcode" value="<?php echo $row['cus_zipcode'] ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div style="margin-bottom: 10%;" class="text-right">
                                    <!-- <button type="button"   id="submit" name="submit" class="btn btn-secondary">Cancel</button> -->
                                    <button style="margin-top: 0px;" type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    include 'inc/footer.php';
?>