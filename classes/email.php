<?php
    $file_path = realpath(dirname(__FILE__));
    include_once ($file_path . '/../lib/database.php');
    include_once ($file_path . '/../lib/session.php');
    Session::init();
    include_once ($file_path . '/../helpers/format.php');
?>
<?php
    /**
     * 
     */
    class email
    {
        private $db;
        private $fm;

        public function __construct()
        {
            $this->db = new Database();
            $this->fm = new Format();
        }

        public function html_email($user_name, $shipping, $phone, $address, $total, $discount_code, $discount)
        {
            if (isset($_SESSION['cart'])) {
                $carts = Session::get("cart");
            }
            $content = '<div marginheight="0" marginwidth="0" style="background:#f0f0f0">
                <div id="wrapper" style="background-color:#f0f0f0">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="margin:0 auto;width:600px!important;min-width:600px!important" class="container">
            <tbody>
            <tr>
                <td align="center" valign="middle" style="background:#ffffff">
                    <table style="width:580px;border-bottom:1px solid #ff3333" cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                        <tr>
                            <td align="left" valign="middle" style="width:500px;height:60px">
                                <a href="" style="border:0" target="_blank" width="130" height="35" style="display:block;border:0px">
                                    <img src="https://i.imgur.com/SJMpt6k.png" height="100" width="115" style="display:block;border:0px;float: left;"> <b style="float: left;line-height: 100px;color: #ff0000;font-size: 20px;">H-Shop</b>
                                </a>
                            </td>
                            <td align="right" valign="middle" style="padding-right:15px">
                                <a href="javascript:" style="border:0">
                                    <img src="https://i.imgur.com/eL1uAJx.png" height="36" width="115" style="display:block;border:0px">
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" valign="middle" style="background:#ffffff">
                    <table style="width:580px" cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                        <tr>
                            <td align="left" valign="middle" style="font-family:Arial,Helvetica,sans-serif;font-size:24px;color:#ff3333;text-transform:uppercase;font-weight:bold;padding:25px 10px 15px 10px">
                                Thông báo đặt hàng thành công
                            </td>
                        </tr>
                        <tr>';
            $content .= '<td align="left" valign="middle" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;padding:0 10px 20px 10px;line-height:17px">
                                Chào '.$user_name.',
                                <br> Cám ơn bạn đã mua sắm tại H-Shop
                                <br> Tổng hóa đơn: '.number_format($total,0,',').' VNĐ
                                <br> Đây là mã giảm '.$discount.'% cho lần mua sau: <b>'.$discount_code.'</b>
                                <br>
                                <br> Hình thức thanh toán: <b>'.$shipping.'</b>.
                                <br> Đơn hàng của bạn đang
                                <b>chờ shop</b>
                                <b>xác nhận</b> (trong vòng 24h)
                                <br> Chúng tôi sẽ thông tin <b>trạng thái đơn hàng</b> trong email tiếp theo.
                                <br> Bạn vui lòng kiểm tra email thường xuyên nhé.
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" valign="middle" style="background:#ffffff">
                    <table style="width:580px;border:1px solid #ff3333;border-top:3px solid #ff3333" cellpadding="0" cellspacing="0" border="0">
                        <tbody>';
                        foreach ($carts as $key => $cart) {
                            $content .= '<tr>
                                <td align="left" valign="top" style="width:120px;padding-left:15px">
                                    <a href="#_" style="border:0">
                                        <img src="'.$cart['image'].'" height="120" width="120" style="display:block;border:0px">
                                    </a>
                                </td>
                                <td align="left" valign="top">
                                    <table style="width:100%" cellpadding="0" cellspacing="0" border="0">
                                        <tbody>
                                        <tr>
                                            <td align="left" valign="top" style="width:120px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;padding-left:15px;padding-right:10px;line-height:20px;padding-bottom:5px">
                                                <b>Sản phẩm</b>
                                            </td>
                                            <td align="left" valign="top" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;line-height:20px;padding-bottom:5px">:</td>
                                            <td align="left" valign="top" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;line-height:20px;padding-left:10px;padding-bottom:5px">
                                                <a href="#" style="color:#115fff;text-decoration:none" target="_blank">
                                                    '.$cart['name'].'x'.$cart['quantity'].'
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top" style="width:120px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;padding-left:15px;padding-right:10px;line-height:20px;padding-bottom:5px">
                                                <b>Tên Shop</b>
                                            </td>
                                            <td align="left" valign="top" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;line-height:20px;padding-bottom:5px">:</td>
                                            <td align="left" valign="top" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;line-height:20px;padding-left:10px;padding-bottom:5px">
                                                <a href="" style="color:#115fff;text-decoration:none" target="_blank">
                                                    H-Shop
                                                </a>
                                                - 0938858944
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top" style="width:120px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;line-height:20px;padding-left:15px;padding-right:10px;padding-bottom:5px">
                                                <b>Tổng thanh toán</b>
                                            </td>
                                            <td align="left" valign="top" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;line-height:20px;padding-bottom:5px">:</td>
                                            <td align="left" valign="top" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;line-height:20px;padding-left:10px;padding-bottom:5px">
                                                '.number_format($cart['price'] * $cart['quantity'],0,',').' VNĐ
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" valign="top" style="width:120px;font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;line-height:20px;padding-left:15px;padding-right:10px;padding-bottom:5px">
                                                <b>Người nhận</b>
                                            </td>
                                            <td align="left" valign="top" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;line-height:20px;padding-bottom:5px">:</td>
                                            <td align="left" valign="top" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;line-height:20px;padding-left:10px;padding-bottom:5px">
                                                <b>'.$user_name.'</b> - '.$phone.'
                                                <br>
                                                '.$address.'                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>';
                        }
                        $content .= '<tr>
                            <td colspan="2" align="center" valign="top" style="padding-top:20px;padding-bottom:20px;border-bottom:1px solid #ebebeb">
                                <a href="http://localhost/shopdidong_mvc/" style="border:0px" target="_blank">
                                    <img src="https://i.imgur.com/f92hL68.jpg" height="29" width="191" alt="Tiếp tục mua sắm" style="border:0px">
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" valign="middle" style="background:#ffffff;padding-top:20px">
                    <table style="width:500px" cellpadding="0" cellspacing="0" border="0">
                        <tbody>
                        <tr>
                            <td align="center" valign="middle" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#666666;line-height:20px;padding-bottom:5px">
                                Đây là thư tự động từ hệ thống. Vui lòng không trả lời email này.
                                <br> Nếu có bất kỳ thắc mắc hay cần giúp đỡ, Bạn vui lòng ghé thăm
                                <b style="font-family:Arial,Helvetica,sans-serif;font-size:13px;text-decoration:none;font-weight:bold">Trung tâm trợ giúp</b> của chúng tôi tại địa chỉ:
                                <a href="https://www.facebook.com/quochuy.0712" style="font-family:Arial,Helvetica,sans-serif;font-size:13px;color:#0066cc;text-decoration:none;font-weight:bold" target="_blank">
                                    help.h-shop.vn
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>';

            return $content;
        }
    }
?>
