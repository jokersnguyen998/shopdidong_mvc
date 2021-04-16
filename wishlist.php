<?php
include 'inc/header.php';
?>
<?php
if (!isset($_SESSION["wishlist"])) {
    echo "<script>window.location='index.php'</script>";
}
?>
<div id="contact-page" class="container">
    <div class="bg">
        <div class="row">
            <div class="col-sm-12">
                <h2 class="title text-center">Danh sách yêu thích</h2>
            </div>
        </div>
        <div class="row" style="margin-bottom: 40px">
            <?php
            if (isset($_SESSION["wishlist"])){
                $wishlist = Session::get("wishlist");
                foreach ($wishlist as $item){
            ?>
            <div class="col-md-12" style="margin-bottom: 10px">
                <div class="col-md-3" style="text-align: center"><a href="product-details.php?proId=<?php echo $item['id'] ?>"><img height="150px" width="150px" src="admin/uploads/<?php echo $item['image'] ?>" alt=""></a></div>
                <div class="col-md-3" style="margin-top: 50px; font-size: 20px; text-align: center"><a style="color: #333" href="product-details.php?proId=<?php echo $item['id'] ?>"><?php echo $item['name'] ?></a></div>
                <div class="col-md-3" style="margin-top: 50px; font-size: 20px; text-align: center"><?php echo number_format($item['price'],0,',') ?> VNĐ</div>
                <div class="col-md-3" style="margin-top: 50px; font-size: 20px; text-align: center"><a class="delele-wishlist" href="" data-id="<?php echo $item['id'] ?>"><i class="fa fa-times-circle"></i></a></div>
            </div>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div><!--/#contact-page-->
<?php
include 'inc/footer.php';
?>
