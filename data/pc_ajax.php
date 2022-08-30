<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/global.php");
include($_SERVER['DOCUMENT_ROOT'] . "/common/TRestAPI.php");



$user_id = (isset($_SESSION['gobeauty_user_id'])) ? $_SESSION['gobeauty_user_id'] : "";
$user_name = (isset($_SESSION['gobeauty_user_nickname'])) ? $_SESSION['gobeauty_user_nickname'] : "";





//$api = new TRestAPI("https://partnerapi.banjjakpet.com","Token 2156d1824c98f27a1f163a102cf742002b15e624");
$api = new TRestAPI("http://stg-partnerapi.banjjakpet.com:8080","Token 55dda3818c897ef163b09a13d37199a7d211b6d2");
//$api2 = new TRestAPI("http://10.24.205.206:8080","Token 2156d1824c98f27a1f163a102cf742002b15e624");



$data = array();



$return_data = array("code" => "999999", "data" => "잘못된 접근입니다.");

$r_mode = ($_POST["mode"] && $_POST["mode"] != "") ? $_POST["mode"] : "";





if($r_mode) {


    if ($r_mode === "login") {

        $login_id = $_POST['login_id'];
        $login_pw = $_POST['login_pw'];
        $login_remember = $_POST['login_remember'];


        $login_data = array(id => $login_id, pw => $login_pw);
        $login_data_json = json_encode($login_data);


        $login = $api->get("/partner/login", $login_data_json);

        $en_json_login = json_encode($login);
        $de_json_login = json_decode($en_json_login);
        $code = $de_json_login->head->code;
        $is_partner = $de_json_login->body->partner;
        // 로그인 성공시 session 생성
        if ($code == 200) {
            $_SESSION['gobeauty_user_id'] = $login_id;
            // 점주/미용사 판단
            if ($is_partner) {
                $_SESSION['my_shop_flag'] = 1;
            } else {
                $_SESSION['shop_user_id'] = $is_partner = $de_json_login->body->partner_id;
                $_SESSION['artist_flag'] = 1;
            }
            // 로그인유지 선택시
            if ($login_remember == 1) {
                cookie_save($login_id, $master_key_name);
            } else {
                $past = time() - 3600;
                setcookie("auto_login_uid", '', $past, '/', '.' . $_SERVER['HTTP_HOST']);
                setcookie("user_hash", '', $past, '/', '.' . $_SERVER['HTTP_HOST']);
            }
        }

        $return_data = array("code" => "000000", "data" => $login);

    } else if ($r_mode === "check_id") {


        $check_id = $api->get('/partner/auth-email/' . $_GET['id']);

        if ($check_id['body']['exist'] === false) {

            array_push($data, 'not_exist');

        } else if ($check_id['body']['exist'] === true) {
            array_push($data, 'exist');
        }


        $return_data = array("code" => "000000", "data" => $data);
    } else if ($r_mode === "home") {


        $login_id = $_POST['login_id'];

        $home = $api->get('/partner/home/' . $login_id);

        $return_data = array("code" => "000000", "data" => $home);

    } else if ($r_mode === "month_book") {


        $login_id = $_POST['login_id'];
        $year = $_POST['year'];
        $month = $_POST['month'];

        $month_book = $api->get('/partner/home/' . $login_id . '?y=' . $year . '&m=' . $month);

        $return_data = array("code" => "000000", "data" => $month_book);
    } else if ($r_mode === "holiday") {

        $login_id = $_POST['login_id'];

        $holiday = $api->get('/partner/setting/regular-holiday/' . $login_id);

        $return_data = array("code" => "000000", "data" => $holiday);
    } else if ($r_mode === "search") {

        $login_id = $_POST['login_id'];
        $search = $_POST['search'];

        if ((int)$search !== 0) {

            $search = (int)$search;
        }

        if (gettype($search) === 'string') {
            $result = $api->get('/partner/home/search/' . $login_id . '?name=' . $search);
        } else if (gettype($search) === 'integer') {
            $result = $api->get(
                '/partner/home/search/' . $login_id . '?phone=' . $search);
        }


        $return_data = array("code" => "000000", "data" => $result);


    } else if ($r_mode === "day_book") {

        $login_id = $_POST['login_id'];
        $st_date = $_POST['st_date'];
        $fi_date = $_POST['fi_date'];

        $day_book = $api->get('/partner/booking/b/' . $login_id . '?st_date=' . $st_date . '&fi_date=' . $fi_date);

        $return_data = array("code" => "000000", 'data' => $day_book);

    } else if ($r_mode === "open_close") {

        $login_id = $_POST['login_id'];

        $open_close = $api->get('/partner/setting/open-close/' . $login_id);

        $return_data = array('code' => '000000', 'data' => $open_close);

    } else if ($r_mode === "working") {

        $login_id = $_POST['login_id'];

        $working = $api->get('/partner/setting/working/' . $login_id);

        $return_data = array("code" => "000000", 'data' => $working);
    } else if ($r_mode === "break_time") {

        $login_id = $_POST['login_id'];

        $break_time = $api->get('/partner/setting/break-time/' . $login_id);

        $return_data = array("code" => "000000", 'data' => $break_time);
    } else if ($r_mode === "pay_management") {

        $payment_idx = $_POST['payment_idx'];

        $pay_management = $api->get('/partner/booking/payment-customer-pet/' . $payment_idx);


        $is_beauty_false = array("is_beauty" => false, "get_count" => 10);
        $is_beauty_true = array("is_beauty" => true, "get_count" => 10);

        $is_beauty_false_data_json = json_encode($is_beauty_false);
        $is_beauty_true_data_json = json_encode($is_beauty_true);

        $payment_before_etc_false = $api->get('/partner/booking/payment-before-etc/' . $payment_idx, $is_beauty_false_data_json);
        $payment_before_etc_true = $api->get('/partner/booking/payment-before-etc/' . $payment_idx, $is_beauty_true_data_json);


        $return_data = array("code" => "000000", 'data' => $pay_management, "data2" => $payment_before_etc_false, "data3" => $payment_before_etc_true);
    } else if ($r_mode === "schedule_artist") {


        $login_id = $_POST['login_id'];

        $schedule_artist = $api->get('/partner/booking/schedule-artist/' . $login_id);

        $return_data = array("code" => "000000", "data" => $schedule_artist);

    } else if ($r_mode === "week_book") {

        $login_id = $_POST['login_id'];

        $st_date = $_POST['st_date'];
        $fi_date = $_POST['fi_date'];

        $week_book = $api->get('/partner/booking/b/' . $login_id . '?st_date=' . $st_date . '&fi_date=' . $fi_date);

        $return_data = array("code" => "000000", 'data' => $week_book);

    } else if ($r_mode === "customer_all") {

        $login_id = $_POST['login_id'];

        $type = $_POST['type'];
        $ord = $_POST['ord'];
        $offset = $_POST['offset'];
        $number = $_POST['number'];


        $customer_all = $api->get('/partner/customer/search/' . $login_id . '?type=' . $type . '&ord_type=' . $ord . '&offset=' . $offset . '&number=' . $number);


        $return_data = array("code" => "000000", "data" => $customer_all);
    } else if ($r_mode === "customer_count") {

        $login_id = $_POST['login_id'];


        $count_people = $api->get('/partner/customer/search/' . $login_id . '?type=people');
        $count_animal = $api->get('/partner/customer/search/' . $login_id . '?type=animal');

        $return_data = array("code" => "000000", "people" => $count_people, "animal" => $count_animal);

    } else if ($r_mode === "post_prohibition") {

        $login_id = $_POST['login_id'];
        $worker = $_POST['worker'];
        $type = $_POST['type'];
        $st_date = $_POST['st_date'];
        $fi_date = $_POST['fi_date'];


        $prohibition_data = array(partner_id => $login_id, worker => $worker, type => $type, st_date => $st_date, fi_date => $fi_date);
        $prohibition_data_json = json_encode($prohibition_data);

        $post_prohibition = $api->post('/partner/booking/prohibition', $prohibition_data_json);

        $return_data = array("code" => "000000", "data" => $post_prohibition);
    } else if ($r_mode === "get_prohibition") {

        $login_id = $_POST['login_id'];
        $st_date = $_POST['st_date'];
        $fi_date = $_POST['fi_date'];

        $prohibition_data = array(st_date => $st_date, fi_date => $fi_date);
        $prohibition_data_json = json_encode($prohibition_data);

        $get_prohibition = $api->get('/partner/booking/prohibition/' . $login_id, $prohibition_data_json);

        $return_data = array("code" => "000000", "data" => $get_prohibition);


    } else if ($r_mode === "delete_prohibition") {

        $ph_seq = $_POST['ph_seq'];

        $prohibition_data = array("idx" => intval($ph_seq));
//        $prohibition_data_json = json_encode($prohibition_data);

        $delete_prohibition = $api->delete('/partner/booking/prohibition', $prohibition_data);

        $return_data = array("code" => "000000", "data" => $delete_prohibition);
    } else if ($r_mode === "customer_new") {

        $partner_id = $_POST['partner_id'];
        $cellphone = $_POST['cellphone'];
        $name = $_POST['name'];
        $type = $_POST['type'];
        $pet_type = $_POST['pet_type'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        $day = $_POST['date'];
        $gender = $_POST['gender'];
        $neutral = $_POST['neutral'];
        $weight = $_POST['weight'];
        $beauty_exp = $_POST['beauty_exp'];
        $vaccination = $_POST['vaccination'];
        $bite = $_POST['bite'];
        $luxation = $_POST['luxation'];
        $dermatosis = $_POST['dermatosis'];
        $heart_trouble = $_POST['heart_trouble'];
        $marking = $_POST['marking'];
        $mounting = $_POST['mounting'];
        $memo = $_POST['memo'];


        $customer_data = array(partner_id => $partner_id
        , cellphone => $cellphone
        , name => $name
        , type => $type
        , pet_type => $pet_type
        , year => $year
        , month => $month
        , day => $day
        , gender => $gender
        , neutral => $neutral
        , weight => $weight
        , beauty_exp => $beauty_exp
        , vaccination => $vaccination
        , bite => $bite
        , luxation => $luxation
        , dermatosis => $dermatosis
        , heart_trouble => $heart_trouble
        , marking => $marking
        , mounting => $mounting
        , memo => $memo);

        $customer_data_json = json_encode($customer_data);

        $customer_new = $api->post('/partner/customer/search', $customer_data_json);


        $return_data = array("code" => "000000", "data" => $customer_new);

    } else if ($r_mode === "pet_type") {

        $breed = $_POST['breed'];

        $pet_type = $api->get('/partner/booking/pettype?animal=' . $breed);

        $return_data = array("code" => "000000", "data" => $pet_type);

    } else if ($r_mode === "merchandise") {

        $login_id = $_POST['login_id'];

        $animal = $_POST['animal'];

        $merchandise = $api->get('/partner/booking/b/join/' . $login_id . '?animal=' . $animal);

        $return_data = array("code" => "000000", "data" => $merchandise);


    } else if ($r_mode === "reserve_regist") {

        $partner_id = $_POST['partner_id'];
        $worker = $_POST['worker'];
        $customer_id = $_POST['customer_id'];
        $cellphone = $_POST['cellphone'];
        $pet_seq = $_POST['pet_seq'];
        $animal = $_POST['animal'];
        $pet_type = $_POST['pet_type'];
        $pet_name = $_POST['pet_name'];
        $pet_year = $_POST['pet_year'];
        $pet_month = $_POST['pet_month'];
        $pet_day = $_POST['pet_day'];
        $gender = $_POST['gender'];
        $neutral = $_POST['neutral'];
        $weight = $_POST['weight'];
        $beauty_exp = $_POST['beauty_exp'];
        $vaccination = $_POST['vaccination'];
        $luxation = $_POST['luxation'];
        $bite = $_POST['bite'];
        $dermatosis = $_POST['dermatosis'];
        $heart_trouble = $_POST['heart_trouble'];
        $marking = $_POST['marking'];
        $mounting = $_POST['mounting'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        $day = $_POST['day'];
        $hour = $_POST['hour'];
        $min = $_POST['min'];
        $session_id = $_POST['session_id'];
        $order_id = $_POST['order_id'];
        $local_price = $_POST['local_price'];
        $pay_type = $_POST['pay_type'];
        $pay_status = $_POST['pay_status'];
        $pay_data = $_POST['pay_data'];
        $to_hour = $_POST['to_hour'];
        $to_min = $_POST['to_min'];
        $use_coupon_yn = $_POST['use_coupon_yn'];
        $is_vat = $_POST['is_vat'];
        $product = $_POST['product'];
        $reserve_yn = $_POST['reserve_yn'];
        $aday_ago_yn = $_POST['aday_ago_yn'];

        $regist_data = array(
            partner_id => $partner_id,
            worker => $worker,
            customer_id => $customer_id,
            cellphone => $cellphone,
            pet_seq => intval($pet_seq),
            animal => $animal,
            pet_type => $pet_type,
            pet_name => $pet_name,
            pet_year => intval($pet_year),
            pet_month => intval($pet_month),
            pet_day => intval($pet_day),
            gender => $gender,
            neutral => $neutral,
            weight => $weight,
            beauty_exp => $beauty_exp,
            vaccination => $vaccination,
            luxation => $luxation,
            bite => $bite,
            dermatosis => $dermatosis,
            heart_trouble => $heart_trouble,
            marking => $marking,
            mounting => $mounting,
            year => intval($year),
            month => intval($month),
            day => intval($day),
            hour => intval($hour),
            min => intval($min),
            session_id => $session_id,
            order_id => $order_id,
            local_price => $local_price,
            pay_type => $pay_type,
            pay_status => $pay_status,
            pay_data => $pay_data,
            to_hour => intval($to_hour),
            to_min => intval($to_min),
            use_coupon_yn => $use_coupon_yn,
            is_vat => $is_vat,
            product => $product,
            reserve_yn => $reserve_yn,
            aday_ago_yn => $aday_ago_yn,


        );

        $regist_data_json = json_encode($regist_data);


        $reserve_regist = $api ->post('/partner/booking/b/join/', $regist_data_json);

        $return_data = array("code" => "000000","data"=>$regist_data_json);


    }else if($r_mode === "pet_info"){


        $pet_seq = $_POST['pet_seq'];

        $pet_info = $api->get('/partner/booking/pet/'.$pet_seq);

        $return_data = array("code"=>"000000","data"=>$pet_info);
    }else if($r_mode === "get_grade"){


        $login_id = $_POST['login_id'];

        $login_data = array(arg=>$login_id);

        $login_data_json = json_encode($login_data);

        $get_grade = $api->get('/partner/booking/grade-shop',$login_data_json);

        $return_data = array("code"=>"000000","data"=>$get_grade);

    }else if($r_mode === "statutory"){

        $login_id = $_POST['login_id'];

        $year = $_POST['year'];
        $month = $_POST['month'];

        $date = array(year=>intval($year),month=>intval($month));

        $date_json = json_encode($date);

        $statutory = $api->get('/partner/booking/statutory-holidays/'.$login_id,$date_json);

        $return_data = array("code"=>"000000","data"=>$statutory);
    }else if($r_mode === "post_grade"){

        $grade_idx = $_POST['grade_idx'];
        $new_name = $_POST['name'];

        $grade_data = array(grade_idx=>$grade_idx,new_name=>$new_name);

        $grade_data_json = json_encode($grade_data);

        $post_grade = $api ->put('/partner/booking/grade/shop',$grade_data_json);

        $return_data = array("code"=>"000000","data"=>$post_grade);


    }else if($r_mode === "set_noshow"){

        $payment_idx = $_POST['payment_idx'];

        $is_no_show = true ;

        $set_noshow_data = array(payment_idx=>$payment_idx,is_no_show=>$is_no_show);

        $set_noshow_data_json = json_encode($set_noshow_data);

        $set_noshow = $api ->put('/partner/booking/noshow',$set_noshow_data_json);

        $return_data = array("code"=>"000000","data"=>$set_noshow);



    }else if($r_mode === "cancel_noshow"){

        $payment_idx = $_POST['payment_idx'];

        $is_no_show = false;

        $cancel_noshow_data = array(payment_idx=>$payment_idx,is_no_show=>$is_no_show);

        $cancel_noshow_data_json = json_encode($cancel_noshow_data);

        $cancel_noshow = $api ->put('/partner/booking/noshow',$cancel_noshow_data_json);

        $return_data = array("code"=>"000000","data"=>$cancel_noshow);



    }else if($r_mode === "modify_pet_info"){


        $idx = $_POST['idx'];
        $name = $_POST['name'];
        $type = $_POST['type'];
        $pet_type = $_POST['pet_type'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        $day = $_POST['day'];
        $gender = $_POST['gender'];
        $neutral = $_POST['neutral'];
        $weight = $_POST['weight'];
        $beauty_exp = $_POST['beauty_exp'];
        $vaccination = $_POST['vaccination'];
        $luxation = $_POST['luxation'];
        $bite = $_POST['bite'];
        $dermatosis = $_POST['dermatosis'];
        $heart_trouble = $_POST['heart_trouble'];
        $marking = $_POST['marking'];
        $mounting = $_POST['mounting'];
        $etc = $_POST['etc'];


        $modify_data = array(
            idx=>intval($idx),
            name=>$name,
            type=>$type,
            pet_type=>$pet_type,
            year=>intval($year),
            month=>intval($month),
            day=>intval($day),
            gender=>$gender,
            neutral=>intval($neutral),
            weight=>$weight,
            beauty_exp=>$beauty_exp,
            vaccination=>$vaccination,
            luxation=>$luxation,
            bite=>$bite,
            dermatosis=>intval($dermatosis),
            heart_trouble=>intval($heart_trouble),
            marking=>intval($marking),
            mounting=>intval($mounting),
            etc=>$etc

        );

        $modify_data_json = json_encode($modify_data);


        $modify_pet_info = $api->put('/partner/booking/pet',$modify_data_json);

        $return_data = array("code"=>"000000","data"=>$modify_pet_info);



    }else if($r_mode === "get_customer_memo"){

        $login_id = $_POST['login_id'];
        $customer_id = $_POST['customer_id'];
        $tmp_seq = $_POST['tmp_seq'];
        $cellphone = $_POST['cellphone'];


        $get_memo_data = array(
            customer_id=>$customer_id,
            tmp_seq=>$tmp_seq,
            cellphone=>$cellphone
        );

        $get_memo_data_json = json_encode($get_memo_data);


        $get_customer_memo = $api->get('/partner/booking/customer-memo/'.$login_id,$get_memo_data_json);

        $return_data = array("code"=>"000000","data"=>$get_customer_memo);


    }else if($r_mode === "put_customer_memo"){

        $idx = $_POST['idx'];
        $memo = $_POST['memo'];

        $put_memo_data = array(
            idx=>intval($idx),
            memo=>$memo

        );

        $put_memo_data_json = json_encode($put_memo_data);

        $put_customer_memo = $api ->put('/partner/booking/customer-memo',$put_memo_data_json);

        $return_data = array("code"=>"000000","data"=>$put_customer_memo);




    }else if($r_mode ==="reserve_cancel"){

        $idx = $_POST['idx'];
        $is_cancel = 1;

        $reserve_cancel_data = array(idx=>intval($idx),is_cancel=>intval($is_cancel));

        $reserve_cancel_data_json = json_encode($reserve_cancel_data);

        $reserve_cancel = $api -> put('/partner/booking/cancel',$reserve_cancel_data_json);

        $return_data = array("code"=>"000000","data"=>$reserve_cancel);



    }else if($r_mode === "put_payment_memo"){

        $idx = $_POST['idx'];
        $memo = $_POST['memo'];

        $put_memo_data = array(
            idx=>intval($idx),
            memo=>$memo

        );

        $put_memo_data_json = json_encode($put_memo_data);

        $put_payment_memo = $api ->put('/partner/booking/payment-memo',$put_memo_data_json);

        $return_data = array("code"=>"000000","data"=>$put_payment_memo);

    }
}






    echo json_encode($return_data, JSON_UNESCAPED_UNICODE);
?>
