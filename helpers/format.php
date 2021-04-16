<?php
/**
* Format Class
*/
    class Format{
        public function formatDate($date){
            return date('F j, Y, g:i a', strtotime($date));
        }

        public function textShorten($text, $limit = 400){
            $text = $text. " ";
            $text = substr($text, 0, $limit);
            $text = substr($text, 0, strrpos($text, ' '));
            $text = $text.".....";
            return $text;
        }

        public function validation($data){
            $data = trim($data);
            $data = stripcslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        public function title(){
            $path = $_SERVER['SCRIPT_FILENAME'];
            $title = basename($path, '.php');
            //$title = str_replace('_', ' ', $title);
            if ($title == 'index') {
             $title = 'home';
            }elseif ($title == 'contact') {
             $title = 'contact';
            }
            return $title = ucfirst($title);
        }

        public function slug($str)
        { 
            $str = trim(mb_strtolower($str));
            $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
            $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
            $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
            $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
            $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
            $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
            $str = preg_replace('/(đ)/', 'd', $str);
            $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
            $str = preg_replace('/([\s]+)/', '-', $str);
            return $str;
        }

        public function get_current_weekday()
        {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $weekday = date("l");
            $weekday = strtolower($weekday);
            switch($weekday) {
                case 'monday':
                    $weekday = 'Thứ hai';
                    break;
                case 'tuesday':
                    $weekday = 'Thứ ba';
                    break;
                case 'wednesday':
                    $weekday = 'Thứ tư';
                    break;
                case 'thursday':
                    $weekday = 'Thứ năm';
                    break;
                case 'friday':
                    $weekday = 'Thứ sáu';
                    break;
                case 'saturday':
                    $weekday = 'Thứ bảy';
                    break;
                default:
                    $weekday = 'Chủ nhật';
                    break;
            }
            return date('Y-m-d H:i:s');
        }

        public function getListDayInMonth()
        {
            $arrDay = [];
            $month  = date('m');
            $year   = date('Y');
            // Lấy tất cả ngày trong tháng
            for ($day = 1; $day <= 31; $day++)
            {
                $time = mktime(12, 0, 0, $month, $day, $year);
                if (date('m', $time) == $month) {
                    $arrDay[] = date('Y-m-d', $time);
                }
            }

            return $arrDay;
        }
    }
?>
