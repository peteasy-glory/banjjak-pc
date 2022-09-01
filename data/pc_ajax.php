<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/global.php");
include($_SERVER['DOCUMENT_ROOT'] . "/common/TRestAPI.php");
include($_SERVER['DOCUMENT_ROOT']."/common/TEmoji.php");
$emoji = new TEmoji();

$user_id = (isset($_SESSION['gobeauty_user_id'])) ? $_SESSION['gobeauty_user_id'] : "";
$user_name = (isset($_SESSION['gobeauty_user_nickname'])) ? $_SESSION['gobeauty_user_nickname'] : "";





//$api = new TRestAPI("https://partnerapi.banjjakpet.com","Token 2156d1824c98f27a1f163a102cf742002b15e624");
$api = new TRestAPI("http://stg-partnerapi.banjjakpet.com:8080","Token 55dda3818c897ef163b09a13d37199a7d211b6d2");


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

    }else if($r_mode === "navi"){

        $login_id = $_POST['login_id'];

        $navi = $api->get('/partner/home/navigation/'.$login_id);

        $return_data = array("code" => "000000", "data"=>$navi);

    }else if($r_mode === "check_id"){


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
    }else if($r_mode === "time_type"){

        $login_id = $_POST['login_id'];

        $time_type = $api -> get('/partner/shop/info/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "get_front_img"){

        $login_id = $_POST['login_id'];

        $data = $api -> get('/partner/shop/front/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$data);
    }else if($r_mode === "post_front_img"){

        $login_id = $_POST['login_id'];
        $mime = $_POST['mime'];
        $image = $_FILES['image']['tmp_name'];
        $base_img = base64_encode(file_get_contents($image));

        $data = array('partner_id'=>$login_id,'mime'=>$mime,'image'=>$base_img);
        $data_json = json_encode($data);

        $post = $api ->post('/partner/shop/front',$data_json);

        $return_data = array("code"=>"000000","data"=>$post);
    }else if($r_mode === "put_front_main"){

        $partner_id = $_POST['login_id'];
        $image = $_POST['image'];

        $data = array('partner_id'=>$partner_id,'image'=>$image);
        $data_json = json_encode($data);

        $result = $api ->put('/partner/shop/front' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "del_front"){

        $partner_id = $_POST['login_id'];
        $image = $_POST['image'];

        $data = array('partner_id'=>$partner_id,'image'=>$image);
        $data_json = json_encode($data);

        $result = $api ->delete('/partner/shop/front' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "get_portfolio"){

        $login_id = $_POST['login_id'];

        $data = $api -> get('/partner/shop/gallery/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$data);
    }else if($r_mode === "del_gallery"){

        $idx = intval($_POST['idx']);

        $data = array('idx'=>$idx);
        $data_json = json_encode($data);

        $result = $api ->delete('/partner/shop/gallery' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "post_shop_gallery"){

        $login_id = $_POST['login_id'];
        $mime = $_POST['mime'];
        resizeImage($_FILES['image']['tmp_name'], $_FILES['image']['tmp_name']);
        $image = $_FILES['image']['tmp_name'];
        $base_img = base64_encode(file_get_contents($image));

        $data = array('partner_id'=>$login_id,'mime'=>$mime,'image'=>$base_img);
        $data_json = json_encode($data);

        $post = $api ->post('/partner/shop/gallery',$data_json);

        $return_data = array("code"=>"000000","data"=>$post);
    }else if($r_mode === "get_shop_info"){

        $login_id = $_POST['login_id'];

        $time_type = $api -> get('/partner/shop/info/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "shop_info_photo"){

        $login_id = $_POST['login_id'];
        $mime = $_POST['mime'];
        resizeImage($_FILES['image']['tmp_name'], $_FILES['image']['tmp_name']);
        $image = $_FILES['image']['tmp_name'];
        $base_img = base64_encode(file_get_contents($image));

        $data = array('partner_id'=>$login_id,'mime'=>$mime,'image'=>$base_img);
        $data_json = json_encode($data);

        $post = $api ->put('/partner/shop/info-photo',$data_json);

        $return_data = array("code"=>"000000","data"=>$post);
    }else if($r_mode === "save_shop_info"){

        $partner_id = $_POST['login_id'];
        $working_years = intval($_POST['working_years']);
        $introduction = $_POST['introduction'];
        $career = $_POST['career'];
        $kakao_channel = $_POST['kakao_channel'];
        $instagram = $_POST['instagram'];
        $kakao_id = $_POST['kakao_id'];

        $data = array('partner_id'=>$partner_id,'working_years'=>$working_years,'introduction'=>$introduction,'career'=>$career,'kakao_channel'=>$kakao_channel,'instagram'=>$instagram,'kakao_id'=>$kakao_id);
        $data_json = json_encode($data);

        $result = $api ->put('/partner/shop/info' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "get_license_award"){

        $login_id = $_POST['login_id'];
        $type = intval($_POST['type']);

        $data = array('type'=>$type);
        $data_json = json_encode($data);

        $time_type = $api -> get('/partner/shop/license-award/'.$login_id, $data_json);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "save_license_award"){

        $partner_id = $_POST['login_id'];
        $type = intval($_POST['type']);
        $name = $_POST['name'];
        $issued_by = $_POST['issued_by'];
        $published_date = $_POST['published_date'];
        $mime = $_POST['mime'];
        resizeImage($_FILES['image']['tmp_name'], $_FILES['image']['tmp_name']);
        $image = $_FILES['image']['tmp_name'];
        $base_img = base64_encode(file_get_contents($image));

        $data = array('partner_id'=>$partner_id,type=>$type,'name'=>$name,'issued_by'=>$issued_by,'published_date'=>$published_date,'mime'=>$mime,'image'=>$base_img);
        $data_json = json_encode($data);

        $result = $api ->post('/partner/shop/license-award' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "del_license_award"){

        $partner_id = $_POST['login_id'];
        $photo = $_POST['src'];
        $type = intval($_POST['type']);

        $data = array('partner_id'=>$partner_id,'photo'=>$photo,'type'=>$type);
        $data_json = json_encode($data);

        $result = $api ->delete('/partner/shop/license-award' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "get_review_list"){

        $login_id = $_POST['login_id'];

        $time_type = $api -> get('/partner/shop/review/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "put_reply"){

        $idx = intval($_POST['idx']);
        $reply = $_POST['reply'];

        $data = array('idx'=>$idx,'reply'=>$reply);
        $data_json = json_encode($data);

        $result = $api ->put('/partner/shop/review' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "del_reply"){

        $idx = intval($_POST['idx']);

        $data = array('idx'=>$idx);
        $data_json = json_encode($data);

        $result = $api ->delete('/partner/shop/review' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "regular_holiday"){

        $login_id = $_POST['login_id'];

        $time_type = $api -> get('/partner/setting/regular-holiday/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "get_authority"){

        $login_id = $_POST['login_id'];

        $time_type = $api -> get('/partner/setting/authority/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "is_authority"){

        $login_id = $_POST['login_id'];

        $time_type = $api -> get('/partner/setting/is-authority/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "get_pay_reserve"){

        $login_id = $_POST['login_id'];

        $time_type = $api -> get('/partner/setting/reserve/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "get_artist_list"){

        $login_id = $_POST['login_id'];

        $time_type = $api -> get('/partner/setting/working/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "show_modify_artist"){

        $artist_id = $_POST['login_id'];
        $name = $_POST['name'];
        $is_view = $_POST['is_view'];

        $data = array('artist_id'=>$artist_id,'name'=>$name,'is_view'=>$is_view);
        $data_json = json_encode($data);

        $result = $api ->put('/partner/setting/view-artist' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "leave_modify_artist"){

        $artist_id = $_POST['login_id'];
        $name = $_POST['name'];
        $is_out = $_POST['is_out'];

        $data = array('artist_id'=>$artist_id,'name'=>$name,'is_out'=>$is_out);
        $data_json = json_encode($data);

        $result = $api ->put('/partner/setting/out-artist' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "put_artist"){

        $artist_id = $_POST['artist_id'];
        $name = $_POST['name'];
        $nicname = $_POST['nicname'];
        $is_main = $_POST['is_main'];
        $is_out = $_POST['is_out'];
        $is_view = $_POST['is_view'];
        $week = $_POST['week'];
        $st_time = $_POST['st_time'];
        $fi_time = $_POST['fi_time'];
        $sequ_prnt = $_POST['sequ_prnt'];

        $work = [];
        $pass_i = 0;
        for($i=0;$i<7;$i++){
            if($week[$i-$pass_i] == ($i)){
                $is_work = 1;
            }else{
                $is_work = 0;
                $pass_i++;
            }
            $work_data = array('is_work'=>$is_work,'week'=>$i,'time_st'=>$st_time[$i-$pass_i],'time_fi'=>$fi_time[$i-$pass_i]);

            array_push($work, $work_data);
        }

        $data = array('artist_id'=>$artist_id,'name'=>$name,'nicname'=>$nicname,'is_main'=>$is_main,'is_out'=>$is_out,'is_view'=>$is_view,'work'=>$work,'sequ_prnt'=>$sequ_prnt);
        $data_json = json_encode($data);

        $result = $api ->put('/partner/setting/artist-put' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "ord_change_artist"){

        $artist_id = $_POST['login_id'];
        $sequ_prnt = $_POST['ord'];
        $name = $_POST['name'];
        $work = [];
        for($i=0;$i<count($name);$i++){
            $work_data = array('name'=>$name[$i],'sequ_prnt'=>$i);

            array_push($work, $work_data);
        }

        $data = array('artist_id'=>$artist_id,'work'=>$work);
        $data_json = json_encode($data);

        $result = $api ->put('/partner/setting/ord-artist' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "put_pay_reserve"){

        $artist_id = $_POST['login_id'];
        $is_use = $_POST['is_use'];
        $percent = $_POST['percent'];
        $min_reserve = $_POST['min_pay'];

        $data = array('artist_id'=>$artist_id,'is_use'=>$is_use,'percent'=>$percent,'min_reserve'=>$min_reserve,'is_delete'=>"2");
        $data_json = json_encode($data);

        $result = $api ->put('/partner/setting/reserve' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "get_pay_type"){

        $login_id = $_POST['login_id'];

        $time_type = $api -> get('/partner/setting/pay-type/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "put_pay_type"){

        $artist_id = $_POST['login_id'];
        $pay_type = $_POST['pay_type'];

        $data = array('artist_id'=>$artist_id,'pay_type'=>$pay_type);
        $data_json = json_encode($data);

        $result = $api ->put('/partner/setting/pay-type' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "put_authority"){

        $artist_id = $_POST['artist_id'];
        $customer_id = $_POST['customer_id'];
        $name = $_POST['name'];
        $del = $_POST['del'];

        $data = array('artist_id'=>$artist_id,'customer_id'=>$customer_id,'name'=>$name,'del'=>$del);
        $data_json = json_encode($data);

        $result = $api ->put('/partner/setting/authority' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "part_time"){

        $login_id = $_POST['login_id'];

        $time_type = $api -> get('/partner/setting/part-time/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "artist_vacation"){

        $login_id = $_POST['login_id'];

        $time_type = $api -> get('/partner/setting/artist-vacation/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "pay_management"){

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
        $prohibition_data_json = json_encode($prohibition_data);

        $delete_prohibition = $api->delete('/partner/booking/prohibition', $prohibition_data_json);

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

    }else if($r_mode === "db_to_str"){

        $str = $_POST['str'];

        $str = $emoji->emojiDBToStr($str);

        $return_data = array("code"=>"000000",'data'=>$str);

    }else if($r_mode === "str_to_db"){

        $str = $_POST['str'];

        $str = $emoji->emojiStrToDB($str);

        $return_data = array("code"=>"000000",'data'=>$str);
    }else if($r_mode == 'img_base64'){
        $image = $_FILES['image']['tmp_name'];
        $base_img = base64_encode(file_get_contents($image));
        $return_data = array('data'=>$base_img);
    }else if($r_mode === 'change_time'){


        $idx = $_POST['idx'];
        $st_time = $_POST['st_time'];
        $fi_time = $_POST['fi_time'];


        $change_time_data = array(idx=>intval($idx),st_time=>$st_time,fi_time=>$fi_time);

        $change_time_data_json = json_encode($change_time_data);

        $change_time = $api->put('/partner/booking/time',$change_time_data_json);

        $return_data = array("code"=>"000000","data"=>$change_time);

    }else if($r_mode === "beauty_gal_add"){

        $payment_log_seq = $_POST['payment_log_seq'];
        $partner_id = $_POST['login_id'];
        $pet_seq = $_POST['pet_seq'];
        $prnt_title = $_POST['prnt_title'];
        $mime = $_POST['mime'];

        $image = $_FILES['image']['tmp_name'];
        $base_img = base64_encode(file_get_contents($image));

        $data = array(
            payment_log_seq=>intval($payment_log_seq),
            partner_id=>$partner_id,
            pet_seq=>intval($pet_seq),
            prnt_title=>$prnt_title,
            mime=>$mime,
            image=>$base_img);
        $data_json = json_encode($data);

        $result = $api -> post('/partner/booking/beauty-gallery' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "beauty_gal_get"){

        $payment_idx = $_POST['idx'];


        $result = $api ->get('/partner/booking/beauty-gallery/'.$payment_idx);

        $return_data = array("code"=>"000000","data"=>$result);


    }else if($r_mode === "beauty_gal_del"){


        $idx=$_POST['idx'];

        $data = array(idx=>intval($idx));

        $data_json = json_encode($data);

        $result = $api -> put('/partner/booking/beauty-gallery',$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === 'post_beauty_agree'){


        $partner_id = $_POST['partner_id'];
        $customer_id = $_POST['customer_id'];
        $customer_name = $_POST['customer_name'];
        $pet_idx = $_POST['pet_idx'];
        $phone = $_POST['phone'];
        $is_beauty_agree = $_POST['is_beauty_agree'];
        $is_private_agree = $_POST['is_private_agree'];
        $agree_type = $_POST['agree_type'];
        $auth_url = $_POST['auth_url'];
        $mime = $_POST['mime'];
        $image = $_POST['image'];

        $data = array(
            partner_id=>$partner_id,
            customer_id=>$customer_id,
            customer_name=>$customer_name,
            pet_idx=>intval($pet_idx),
            phone=>$phone,
            is_beauty_agree=>$is_beauty_agree,
            is_private_agree=>$is_private_agree,
            agree_type=>$agree_type,
            auth_url=>$auth_url,
            mime=>$mime,
            image=>$image

        );

        $data_json = json_encode($data);

        $result = $api -> post('/partner/booking/beauty-sign',$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "get_beauty_agree"){

        $partner_id = $_POST['partner_id'];
        $pet_idx = $_POST['pet_idx'];

        $data = array(pet_idx=>intval($pet_idx));

        $data_json = json_encode($data);

        $result = $api -> get('/partner/booking/beauty-sign/'.$partner_id,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "change_date_worker"){

        $idx = $_POST['idx'];
        $st_date = $_POST['st_date'];
        $fi_date = $_POST['fi_date'];
        $worker = $_POST['worker'];

        $data = array(idx=>intval($idx),st_date=>$st_date,fi_date=>$fi_date,worker=>$worker);

        $data_json = json_encode($data);

        $result = $api -> put('/partner/booking/worker-date',$data_json);

        $return_data = array("code"=>"000000","data"=>$result);


    }
}

function resizeImage($file, $newfile) {
        $w = 0;
        $h = 0;
        list($width, $height) = getimagesize($file); // 업로드 파일의 가로세로 구하기
        if($width > 1080){ // 가로가 1280보다 크면
            $w = 1080;
            $h = 1080*($height/$width); // 가로 기준으로 세로 비율 구하기
        }else if($height > 1920){ // 세로가 1920보다 크면
            $h = 1920;
            $w = 1920*($width/$height); // 세로 기준으로 가로 비율 구하기
        }
        if(strpos(strtolower($file), ".jpg"))
            $src = imagecreatefromjpeg($file);
        else if(strpos(strtolower($file), ".png"))
            $src = imagecreatefrompng($file);
        else if(strpos(strtolower($file), ".gif"))
            $src = imagecreatefromgif($file);
        $dst = imagecreatetruecolor($w, $h);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
        // 이미지 회전
        if (function_exists('exif_read_data')) {
            $exif = exif_read_data($newfile);
            if ($exif && isset($exif['Orientation'])) {
                $orientation = $exif['Orientation'];
                if ($orientation != 1) {
                    $deg = 0;
                    switch ($orientation) {
                        case 3:
                            $deg = 180;
                            break;
                        case 6:
                            $deg = 270;
                            break;
                        case 8:
                            $deg = 90;
                            break;
                    }
                    if ($deg) {
                        $dst = imagerotate($dst, $deg, 0);
                    }
                } // if there is some rotation necessary
            } // if have the exif orientation info
        } // if function exists
        if(strpos(strtolower($newfile), ".jpg"))
            imagejpeg($dst, $newfile);
        else if(strpos(strtolower($newfile), ".png"))
            imagepng($dst, $newfile);
        else if(strpos(strtolower($newfile), ".gif"))
            imagegif($dst, $newfile);
    }




    echo json_encode($return_data, JSON_UNESCAPED_UNICODE);
?>
