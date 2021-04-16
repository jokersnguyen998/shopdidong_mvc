	<footer id="footer"><!--Footer-->
		<div class="footer-bottom">
			<div class="container">
				<div class="row">
					<p class="pull-left">Copyright © 2013 E-SHOPPER Inc. All rights reserved.</p>
					<p class="pull-right">Designed by <span><a target="_blank" href="http://www.themeum.com">Themeum</a></span></p>
				</div>
			</div>
		</div>
	</footer>
    <script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/price-range.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(function(){
            $(document).on('click', '.add123', addCart);
            $(document).on('click', '.cart_quantity_update', updateItem);
            $(document).on('click', '.cart_quantity_delete', deleteItem);
        })
        function addCart(){
            var id = $(this).data('id');
            var qty = $("#quantity123").val();
            var qtyprocart = $("#qtyprocart").val();
            var totalqtyprocart = Number(qty) + Number(qtyprocart);
            
            if (qtyprocart != "" && totalqtyprocart > 4) {
                Swal.fire({
                  icon: 'warning',
                  text: 'Giỏ hàng của bạn đã có ' + qtyprocart + ' sản phẩm này!',
                  showConfirmButton: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        var z = 4 - Number(qtyprocart);
                        if (z <= 0) {
                            $("#quantity123").val(1);
                            qty = 1;
                        } else{
                            $("#quantity123").val(z);
                            qty = z;
                        }
                    }
                });
            } else{
                if (qty > 4) {
                    Swal.fire({
                      icon: 'warning',
                      text: 'Mỗi sản phẩm chỉ cho phép mua tối đa số lượng 4',
                      showConfirmButton: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $("#quantity123").val('4');
                        }
                    });
                } else{
                    if (qty == 0) {
                        Swal.fire({
                            icon: 'warning',
                            text: 'Mỗi sản phẩm phải chọn ít nhất số lượng 1',
                            showConfirmButton: true,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#quantity123").val('1');
                            }
                        });  
                    } else {
                        $.post("ajax_cart.php",{"id": id, "qty":qty}, function (data, status){
                            if (status == "success"){
                                Swal.fire({
                                icon: 'success',
                                title: 'Thêm vào giỏ hàng thành công!',
                                showConfirmButton: false,
                                timer: 1000
                                }).then((result) => {
                                    if (result.isConfirmed == false) {
                                        window.location='cart.php';
                                    }
                                });
                            }
                        });
                    }
                }
            }
        }

        function updateItem(event){
            event.preventDefault();
            var id = $(this).data('id');
            qty = $("#quantity_" + id).val();
            if (qty > 4) {
                Swal.fire({
                  icon: 'warning',
                  text: 'Mỗi sản phẩm chỉ cho phép mua tối đa số lượng 4',
                  showConfirmButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
            } else{
                Swal.fire({
                  icon: 'success',
                  text: 'Cập nhật số lượng thành công!',
                  showConfirmButton: false,
                  timer: 1000
                }).then((result) => {
                    $.get("cart.php?id="+id+"&qty="+qty, function (data, status){
                        if (status == 'success') {
                            location.reload();
                        }
                    });
                });
            }
        }

        function deleteItem(event){
            event.preventDefault();
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.get("cart.php?id="+id+"&action=del", function (data, status){
                        if (status == 'success') {
                            Swal.fire({
                                title: 'Deleted!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1000
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    });                
                }
            });
        }
    </script>
    <!-- <script>
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
        })
    </script> -->
    <!-- search -->
    <script type="text/javascript">
        $(document).ready(function(){
            $("#search").keyup(function(){
                var text = $(this).val();
                if (text.length >= 2) {
                    $.ajax({
                        url: 'search.php?type=search',
                        method: 'post',
                        data: {query: text},
                        success: function(response){
                            $("#show-list").html(response);
                        }
                    });
                } else{
                    $("#show-list").html('');
                }
            });

            $(document).on('click','a',function(){
                $("#search").val($(this).text());
                $("#show-list").html('');
            });
        });
    </script>
    <!-- price range -->
    <script type="text/javascript">
        $(document).ready(function(){
            $(".slider-track").mouseup(function(){
                var price_range = $(".tooltip-inner").text();
                var index = price_range.indexOf(":");
                var price_min = price_range.substr(0,index-1) * 1000000;
                var price_max = price_range.substr(index+2) * 1000000;
                $.ajax({
                    url: 'search.php?type=pricerange',
                    method: 'get',
                    data: {price_min:price_min, price_max:price_max},
                    success: function(data){
                        $("#show-pro").html(data);
                    }
                });
            });
        });
    </script>
    <!-- product reviews -->
    <script type="text/javascript">
        function remove_color_start(product_id){
            for (var count = 1; count <= 5; count++) {
                $('#'+product_id+'-'+count).css('color','#ccc');
            }
        }
        //hover rating
        // $(document).on('mouseenter','.rating',function(){
        //     var index = $(this).data('index'); //vi tri sao ma chuot dang hover
        //     var product_id = $(this).data('product-id');
            
        //     remove_color_start(product_id); //xoa mau tat ca cac sao khi chuot hover len bat ki sao nao

        //     for (var count = 1; count <= index; count++) {
        //         $('#'+product_id+'-'+count).css('color','#ffcc00');
        //     } //to mau sao tu vi tri index ma chuot dang hover tro ve truoc
        // });
        //leave rating
        // $(document).on('mouseleave','.rating',function(){
        //     var index = $(this).data('index'); //vi tri sao ma chuot dang hover
        //     var product_id = $(this).data('product-id');
        //     var rating = $(this).data('rating');

        //     remove_color_start(product_id); //xoa mau tat ca cac sao khi chuot hover len bat ki sao nao

        //     for (var count = 1; count <= index; count++) {
        //         $('#'+product_id+'-'+count).css('color','#ffcc00');
        //     } //to mau sao tu vi tri rating ma chuot leave tro ve truoc
        // });
        //click rating
        $(document).on('click','.rating',function(){
            var index = $(this).data('index'); //vi tri sao ma chuot dang hover
            var product_id = $(this).data('product-id');
            $("#index").val(index);

            remove_color_start(product_id); //xoa mau tat ca cac sao khi chuot hover len bat ki sao nao

            for (var count = 1; count <= index; count++) {
                $('#'+product_id+'-'+count).css('color','#ffcc00');
            } //to mau sao tu vi tri index ma chuot dang hover tro ve truoc
            // $.ajax({
            //     url:'search.php',
            //     method:'POST',
            //     data:{index:index, product_id:product_id},
            //     success:function(data){
            //         if (data == 'done') {
            //             alert(index+"/5");
            //         } else{
            //             alert("Error");
            //         }
            //     }
            // });
        });
    </script>
    <!-- check mail exits -->
    <script type="text/javascript">
        function checkEmail(email){
            $.post('search.php?type=checkmail',{'email':email},function(data){
                if (data == 'true') {
                    $("#check").text("Email exits");
                    $("#reg").attr({'disabled':''});
                    $("#error-mail").addClass('error-mail');
                    $("#check").css('color','red');
                } else{
                    $("#check").text("OK");
                    $("#reg").removeAttr('disabled');
                    $("#error-mail").removeClass('error-mail');
                    $("#check").css('color','green');
                }
            });
        }
    </script>
    <!-- signup mail -->
    <script type="text/javascript">
        $(document).ready(function(){
            $("#reg").on('click', function(e){
                e.preventDefault();
                var first_name = $("#firstName").val();
                var last_name = $("#lastName").val();
                var email = $("#error-mail").val();
                var pass = $("#pass").val();
                var address = $("#address").val();
                var city = $("#city").val();
                var zipcode = $("#zipcode").val();
                var phone = $("#phone").val();
                if (first_name == "" || last_name == "" || email == "" || pass == ""
                    || address == "" || city == "" || zipcode == "" || phone =="") {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Các trường không được để trống',
                        showConfirmButton: true,
                    });
                } else{
                    $.post("search.php?type=signup",{
                        first_name:first_name,
                        last_name:last_name,
                        email:email,
                        pass:pass,
                        address:address,
                        city:city,
                        zipcode:zipcode,
                        phone:phone
                    }, function(data){
                        Swal.fire({
                            icon: 'success',
                            title: 'Đăng ký thành công!',
                            showConfirmButton: false,
                            timer: 1000
                        }).then((result) => {
                            if (result.isConfirmed == false) {
                                location.reload();
                            }
                        });
                    })
                }
            })
        })
    </script>
    <!-- login -->
    <script type="text/javascript">
        $(document).ready(function(){
            $("#login1").on('click', function(e){
                e.preventDefault();
                var email = $.trim($("#email-login").val());
                var pass = $.trim($("#pass-login").val());
                if (email == "" || pass == "") {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Các trường không được để trống',
                        showConfirmButton: true,
                    });
                } else{
                    $.ajax({
                        url:"search.php?type=login",
                        type:"POST",
                        data:{email:email, pass:pass},
                        success:function(data){
                            if (data == 0) {
                                Swal.fire({
                                    icon: 'error',
                                    text: 'Email hoặc mật khẩu không chính xác',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else{
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Đăng nhập thành công!',
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then((result) => {
                                    if (result.isConfirmed == false) {
                                        window.location = "index.php";
                                    }
                                });
                            }
                        }
                    });
                }
            });
        })
    </script>
    <!-- paginate -->
    <script type="text/javascript">
        $(document).on("click","#prev",function(){
            $("#prev").attr("href","index.php");
        });

        $(document).on("click","#next",function(){
            var lastpage = $("#page-last").val();
            var url = "index.php?page="+lastpage;
            $("#next").attr("href",url);
        });
    </script>

    <!-- comment product -->
    <script type="text/javascript">
        $(document).ready(function(){
            load_comment();
            function load_comment(){
                var productID = $('#productID').val();
                var user_id = $('#user_id').val();
                $.ajax({
                    url:'search.php?type=loadcomment',
                    method: 'post',
                    data:{productID:productID, user_id:user_id},
                    success:function(data){
                        $('#comment').html(data);
                    }
                });
            }
            $('#submit').click(function(event){
                event.preventDefault();
                var productID = $('#productID').val();
                var comment = $('#commentarea').val();
                var user_id = $('#user_id').val();
                var index = $('#index').val();
                if (comment == "" || index == 0) {
                    Swal.fire({
                      icon: 'warning',
                      text: 'Bạn phải nhập nội dung và đánh giá sản phẩm trước khi bình luận',
                      showConfirmButton: true,
                    });
                } else{
                    $.ajax({
                        url:'search.php?type=postcomment',
                        method:'post',
                        data:{productID:productID, comment:comment, user_id:user_id, index:index},
                        success:function(data){
                            load_comment();
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
    <!-- contact -->
    <script type="text/javascript">
        $(document).ready(function(){
            var contact = $("#contact-page").attr("data-contact");
            if (contact == 1) {
                $(".alert-success").css("display","block");
                $(".alert-success").html("Gửi phản hồi thành công!");
            }
        })
    </script>
    <!-- wishlist -->
    <script type="text/javascript">
        $(function () {
            $('.wishlist').on('click', addToWishlist);
            $('#btnwishlist').on('click', checkWishlist);
            $('.delele-wishlist').on('click', deleteWishlist);
        });

        function addToWishlist(event)
        {
            event.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: 'search.php?type=wishlist',
                method: 'get',
                data: {id:id},
                success: function (data) {
                    if (data == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Thêm thành công',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    } else{
                        Swal.fire({
                            icon: 'warning',
                            title: 'Sản phẩm này đã có trông danh sách yêu thích',
                            showConfirmButton: true,
                        });
                    }
                }
            })
        }

        function checkWishlist(e)
        {
            e.preventDefault();
            $.ajax({
                url: 'search.php?type=checkwishlist',
                method: 'get',
                success: function (data) {
                    if (data == 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Danh sách yêu thích đang trống',
                            showConfirmButton: false,
                            timer: 1000
                        });
                    } else {
                        window.location = "wishlist.php";
                    }
                }
            })
        }

        function deleteWishlist(e)
        {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: 'search.php?type=deletewishlist',
                method: 'get',
                data : {id:id},
                success: function (data) {
                    if (data == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Xóa thành công',
                            showConfirmButton: false,
                            timer: 1000
                        }).then((result) => {
                            if (result.isConfirmed == false) {
                                location.reload();
                            }
                        });
                    } else {
                        alert("Có lỗi xảy ra");
                    }
                }
            })
        }
    </script>
    <!-- update profile -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#profile').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url  : 'search.php?type=profile',
                    type : 'post',
                    data : new FormData(this), //Tạo đối tượng FormData mới lấy tất cả các name của form cũ
                    processData: false,
                    contentType: false,
                    success:function(response){
                        if (response == -1) {
                            Swal.fire({
                            icon: 'error',
                            text: 'Ảnh phải là jpg, jpeg, png, gif',
                            showConfirmButton: true,
                        });
                        } else{
                            if (response == 1) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Cập nhật thành công!',
                                    showConfirmButton: false,
                                    timer: 1000
                                }).then((result) => {
                                    if (result.isConfirmed == false) {
                                        location.reload();
                                    }
                                });
                            }
                        }
                    }
                });
            })
        });
    </script>
    <!-- history buy -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#history-detail').on('click', function(e){
                e.preventDefault();
                var order_id = $('#history-detail').data('id');
                $.ajax({
                    url : 'search.php?type=history-detail',
                    type : 'get',
                    data : {order_id:order_id},
                    success:function(data){
                        $('#list-modal').html(data);
                    }
                });
            });
        });
        $('#myModal').on('shown.bs.modal', function () {
            $('#myInput').trigger('focus')
        });
    </script>
    <!-- change pass -->
    <script type="text/javascript">
        $(document).ready(function(){
            $('#password-old').blur(function(){
                var pass_old = $('#password-old').val();
                if (pass_old == "") {
                    Swal.fire({
                        icon: 'warning',
                        text: 'Trường này không được để trống',
                        showConfirmButton: false,
                        timer: 1000
                    })
                } else {
                    $.ajax({
                        url  : 'search.php?type=checkpass',
                        type : 'post',
                        data : {pass_old:pass_old},
                        success:function(data){
                            if (data == 0) {
                                $('#error-pass').text("Mật khẩu không đúng");
                            } else {
                                $('#error-pass').text("");
                            }
                        }
                    });
                }
            });
            $(document).on('blur', '#password-new', check);
            $(document).on('blur', '#re-password', check);


            function check() {    
                var pass_new = $('#password-new').val(),
                    re_pass  = $('#re-password').val();
                
                    if (pass_new != re_pass && pass_new != "" && re_pass != "") {
                        $('#error-repass').text("Nhập lại mật khẩu không khớp");
                    } else {
                        $('#error-repass').text("");
                    } 
            }
            $('#fchangepass').submit(function(e){
                e.preventDefault();
                if ($('#error-repass').text() == "" && $('#error-pass').text() == "") {
                    var pass_old = $('#password-old').val(),
                        pass_new = $('#password-new').val(),
                        re_pass  = $('#re-password').val();
                    if (pass_old == "" || pass_new == "" || re_pass == "") {
                        Swal.fire({
                            icon: 'warning',
                            text: 'Các trường này không được để trống',
                            showConfirmButton: false,
                            timer: 1000
                        })
                    } else {
                        $.ajax({
                            url  : 'search.php?type=changepass',
                            type : 'post',
                            data : {pass_new:pass_new},
                            success:function(data){
                                if (data == 1) {
                                    Swal.fire({
                                        icon: 'success',
                                        text: 'Đổi mật khẩu thành công!',
                                        showConfirmButton: false,
                                        timer: 1000
                                    }).then((result) => {
                                        if (result.isConfirmed == false) {
                                            location.reload();
                                        }
                                    });
                                }
                            }
                        });
                    }
                }
            });
        });
    </script>
    <!-- discount -->
    <script>
    $(document).ready(function(){
        $(document).on('click', '.apdung', confirmDiscount);
        function confirmDiscount(e) {
            e.preventDefault();
            let discount = $(this).parent().find('span').find('input').val();
            let discount_code = $(this).parent().find('span').find('p').text();
            $('#recipient-name').val(discount_code);
            $('#recipient-code').val(discount);
            $('#discount').text(discount + '%');
            $('#giamgia').val(discount);
            $('#giamgia_code').val(discount_code);
            Swal.fire({
                icon: 'success',
                text: 'Áp dụng thành công',
                showConfirmButton: false,
                timer: 1000
            });
        }
    })
    </script>
    <!-- cancel order -->
    <script>
    $(document).ready(function() {
        $(document).on('click', '.huy-don', cancelOrder)
        
        function cancelOrder() {
            var order_id = $(this).data('id');
            $.ajax({
                url  : 'search.php?type=cancelorder',
                type : 'post',
                data : {order_id:order_id},
                success:function(data)
                {
                    if (data == 1) {
                        Swal.fire({
                            icon: 'success',
                            text: 'Hủy đơn hàng thành công',
                            showConfirmButton: false,
                            timer: 1000
                        }).then((result) => {
                            if (result.isConfirmed == false) {
                                location.reload();
                            }
                        });
                    }
                }
            })
        }
    })
    </script>
</body>
</html>