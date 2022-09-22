<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/global.php");
include($_SERVER['DOCUMENT_ROOT'] . "/common/TRestAPI.php");
include($_SERVER['DOCUMENT_ROOT']."/common/TEmoji.php");
$emoji = new TEmoji();

$user_id = (isset($_SESSION['gobeauty_user_id'])) ? $_SESSION['gobeauty_user_id'] : "";
$user_name = (isset($_SESSION['gobeauty_user_nickname'])) ? $_SESSION['gobeauty_user_nickname'] : "";





//$api = new TRestAPI("https://partnerapi.banjjakpet.com","Token 2156d1824c98f27a1f163a102cf742002b15e624");
$api = new TRestAPI("http://stg-partnerapi.banjjakpet.com:8080","Token 55dda3818c897ef163b09a13d37199a7d211b6d2");
//$api2 = new TRestAPI("http://192.168.20.216:8080","Token 2156d1824c98f27a1f163a102cf742002b15e624");


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

    } else if ($r_mode === "cal_count") {


        $login_id = $_POST['login_id'];
        $st_date = $_POST['st_date'];
        $fi_date = $_POST['fi_date'];

        $home = $api->get('/partner/booking/count/' . $login_id. '?st_date=' . $st_date . '&fi_date=' . $fi_date);

        $return_data = array("code" => "000000", "data" => $home);

    } else if ($r_mode === "month_book") {


        $login_id = $_POST['login_id'];
        $year = $_POST['year'];
        $month = $_POST['month'];
        $month_1 = $_POST['month_1'];

        $month_book = $api->get('/partner/booking/b/'.$login_id.'?st_date='.$year.'-'.$month.'-01&fi_date='.$year.'-'.$month_1.'-01');
//        $month_book = $api->get('/partner/home/' . $login_id . '?y=' . $year . '&m=' . $month);

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

        $time_type = $api -> get('/partner/setting/part-time-set/'.$login_id);

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
    }else if($r_mode === "get_blog_list"){

        $login_id = $_POST['login_id'];
        $data = array('naver'=>false);
        $data_json = json_encode($data);

        $time_type = $api -> get('/partner/shop/blog/'.$login_id, $data_json);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "get_naver_blog_list"){

        $login_id = $_POST['login_id'];
        $query = $_POST['txt'];
        $display = intval($_POST['display']);
        $start = intval($_POST['start']);
        $data = array('naver'=>true,'query'=>$query,'display'=>$display,'start'=>$start);
        $data_json = json_encode($data);

        $time_type = $api -> get('/partner/shop/blog/'.$login_id, $data_json);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "post_naver_blog_list"){

        $login_id = $_POST['login_id'];
        $link = $_POST['link'];
        $title = $_POST['title'];
        $desc = $_POST['desc'];
        $post_date = $_POST['post_date'];
        $blogger = $_POST['blogger'];

        $data = array('partner_id'=>$login_id,'link'=>$link,'title'=>$title,'desc'=>$desc,'thumb'=>'','post_date'=>$post_date,'blogger'=>$blogger);
        $data_json = json_encode($data);

        $time_type = $api -> post('/partner/shop/blog', $data_json);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "del_blog"){

        $idx = intval($_POST['idx']);

        $data = array('idx'=>$idx);
        $data_json = json_encode($data);

        $result = $api ->delete('/partner/shop/blog' ,$data_json);

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
    }else if($r_mode === "post_vacation"){

        $partner_id = $_POST['partner_id'];
        $type = $_POST['break_type'];
        $all_start = $_POST['all_start'];
        $all_finish = $_POST['all_finish'];
        $notall_year = $_POST['notall_year'];
        $notall_month = $_POST['notall_month'];
        $notall_day = $_POST['notall_day'];
        $notall_st_time = $_POST['notall_st_time'];
        $notall_fi_time = $_POST['notall_fi_time'];
        $break_worker = $_POST['break_worker'];

        $worker = [];
        for($i=0;$i<count($break_worker);$i++){
            $work_data = array('name'=>$break_worker[$i]);
            array_push($worker, $work_data);
        }
        if($type == 'all'){
            $st_date = $all_start;
            $fi_date = $all_finish;
        }else{
            $st_date = $notall_year.$notall_month.$notall_day.$notall_st_time;
            $fi_date = $notall_year.$notall_month.$notall_day.$notall_fi_time;
        }

        $data = array('partner_id'=>$partner_id,'worker'=>$worker,'type'=>$type,'st_date'=>$st_date,'fi_date'=>$fi_date);
        $data_json = json_encode($data);

        $result = $api ->post('/partner/setting/artist-vacation' ,$data_json);

        $return_data = array("code"=>"000000",'data'=>$result);
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
    }else if($r_mode === "del_vacation"){

        $idx = intval($_POST['idx']);

        $data = array('idx'=>$idx);
        $data_json = json_encode($data);

        $result = $api ->delete('/partner/setting/artist-vacation' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "put_shop_etc"){

        $artist_id = $_POST['artist_id'];
        $name1 = $_POST['name1'];
        $price1 = $_POST['price1'];
        if(count($name1)>0){
            $goods1 = [];
            for($i=0;$i<count($name1);$i++){
                if($name1[$i] != ''){
                    $array = array('name'=>$name1[$i],'price'=>$price1[$i]);
                    array_push($goods1, $array);
                }
            }
            $data = array('partner_id'=>$artist_id,'product_kind'=>'1','goods'=>$goods1);
            $data_json = json_encode($data);
            $result = $api ->post('/partner/setting/beauty-store-goods' ,$data_json);
        }
        $name2 = $_POST['name2'];
        $price2 = $_POST['price2'];
        if(count($name2)>0){
            $goods2 = [];
            for($i=0;$i<count($name2);$i++){
                if($name2[$i] != ''){
                    $array = array('name'=>$name2[$i],'price'=>$price2[$i]);
                    array_push($goods2, $array);
                }
            }
            $data = array('partner_id'=>$artist_id,'product_kind'=>'2','goods'=>$goods2);
            $data_json = json_encode($data);
            $result = $api ->post('/partner/setting/beauty-store-goods' ,$data_json);
        }
        $name3 = $_POST['name3'];
        $price3 = $_POST['price3'];
        if(count($name3)>0){
            $goods3 = [];
            for($i=0;$i<count($name3);$i++){
                if($name3[$i] != ''){
                    $array = array('name'=>$name3[$i],'price'=>$price3[$i]);
                    array_push($goods3, $array);
                }
            }
            $data = array('partner_id'=>$artist_id,'product_kind'=>'3','goods'=>$goods3);
            $data_json = json_encode($data);
            $result = $api ->post('/partner/setting/beauty-store-goods' ,$data_json);
        }
        $name4 = $_POST['name4'];
        $price4 = $_POST['price4'];
        if(count($name4)>0){
            $goods4 = [];
            for($i=0;$i<count($name4);$i++){
                if($name4[$i] != ''){
                    $array = array('name'=>$name4[$i],'price'=>$price4[$i]);
                    array_push($goods4, $array);
                }
            }
            $data = array('partner_id'=>$artist_id,'product_kind'=>'4','goods'=>$goods4);
            $data_json = json_encode($data);
            $result = $api ->post('/partner/setting/beauty-store-goods' ,$data_json);
        }

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "put_coupon"){

        $partner_id = $_POST['partner_id'];

        // 횟수쿠폰
        $idx_c = $_POST['idx_c'];
        $name_c = $_POST['name_c'];
        $price_c = $_POST['price_c'];
        $given_c = $_POST['given_c'];
        for($i=0;$i<count($idx_c);$i++){
            if($idx_c[$i] != ''){
                // 수정
                $data = array('idx'=>intval($idx_c[$i]),'partner_id'=>$partner_id,'product_type'=>'B','type'=>'C','name'=>$name_c[$i],'given'=>$given_c[$i],'price'=>$price_c[$i]);
                $data_json = json_encode($data);
                $result = $api ->put('/partner/setting/beauty-coupon' ,$data_json);
            }else{
                // post
                if($name_c[$i] != ''){
                    $data = array('partner_id'=>$partner_id,'product_type'=>'B','type'=>'C','name'=>$name_c[$i],'given'=>$given_c[$i],'price'=>$price_c[$i]);
                    $data_json = json_encode($data);
                    $result = $api ->post('/partner/setting/beauty-coupon' ,$data_json);
                }
            }
        }

        // 정액쿠폰
        $idx_f = $_POST['idx_f'];
        $name_f = $_POST['name_f'];
        $price_f = $_POST['price_f'];
        $given_f = $_POST['given_f'];
        for($i=0;$i<count($idx_f);$i++){
            if($idx_f[$i] != ''){
                // 수정
                $data = array('idx'=>intval($idx_f[$i]),'partner_id'=>$partner_id,'product_type'=>'B','type'=>'F','name'=>$name_f[$i],'given'=>$given_f[$i],'price'=>$price_f[$i]);
                $data_json = json_encode($data);
                $result = $api ->put('/partner/setting/beauty-coupon' ,$data_json);
            }else{
                // post
                if($name_f[$i] != ''){
                    $data = array('partner_id'=>$partner_id,'product_type'=>'B','type'=>'F','name'=>$name_f[$i],'given'=>$given_f[$i],'price'=>$price_f[$i]);
                    $data_json = json_encode($data);
                    $result = $api ->post('/partner/setting/beauty-coupon' ,$data_json);
                }
            }
        }

        $coupon_memo_idx = $_POST['coupon_memo_idx'];
        $coupon_c_memo = $_POST['coupon_c_memo'];
        $coupon_f_memo = $_POST['coupon_f_memo'];
        if($coupon_memo_idx>0){
            // 수정
            $data = array('idx'=>intval($coupon_memo_idx),'partner_id'=>$partner_id,'coupon_memo'=>$coupon_c_memo,'flat_memo'=>$coupon_f_memo);
            $data_json = json_encode($data);
            $result = $api ->put('/partner/setting/beauty-coupon-memo' ,$data_json);
        }else{
            // post
            if($coupon_c_memo != '' || $coupon_f_memo != ''){
                $data = array('partner_id'=>$partner_id,'coupon_memo'=>$coupon_c_memo,'flat_memo'=>$coupon_f_memo);
                $data_json = json_encode($data);
                $result = $api ->post('/partner/setting/beauty-coupon-memo' ,$data_json);
            }
        }

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "del_coupon"){

        $idx = intval($_POST['idx']);
        $data = array('idx'=>$idx);
        $data_json = json_encode($data);
        $result = $api ->delete('/partner/setting/beauty-coupon' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "put_option_product"){

        $partner_id = $_POST['partner_id'];
        $offer = $_POST['offer'];
        if($offer == 0){
            $in_shop = '1';
            $out_shop = '0';
        }else if($offer == 1){
            $in_shop = '0';
            $out_shop = '1';
        }else if($offer == 2){
            $in_shop = '1';
            $out_shop = '1';
        }
        // 얼굴컷
        $basic_price = $_POST['basic_price'];
        $bear_price = $_POST['bear_price'];
        $brocoli_price = $_POST['brocoli_price'];
        $highba_price = $_POST['highba_price'];
        $face_name = $_POST['face_name'];
        $face_price = $_POST['face_price'];
        $addition_face_product = '';
        if(count($face_name) > 0){
            for($i=0;$i<count($face_name);$i++){
                $addition_face_product.= $face_name[$i].":".$face_price[$i].",";
            }
            $addition_face_product = substr($addition_face_product, 0, -1);
        }

        // 털길이
        $beauty_length_1 = '';
        $beauty_length_2 = '';
        $beauty_length_3 = '';
        $beauty_length_4 = '';
        $beauty_length_5 = '';
        $beauty_length_1_price = '';
        $beauty_length_2_price = '';
        $beauty_length_3_price = '';
        $beauty_length_4_price = '';
        $beauty_length_5_price = '';
        $hair_len_name = $_POST['hair_len_name'];
        $hair_len_price = $_POST['hair_len_price'];
        $hair_length_product = '';
        if(count($hair_len_name) > 0){
            $beauty_length_1 = $hair_len_name[0];
            $beauty_length_1_price = $hair_len_price[0];
            if(count($hair_len_name) > 1){
                $beauty_length_2 = $hair_len_name[1];
                $beauty_length_2_price = $hair_len_price[1];
            }
            if(count($hair_len_name) > 2){
                $beauty_length_3 = $hair_len_name[2];
                $beauty_length_3_price = $hair_len_price[2];
            }
            if(count($hair_len_name) > 3){
                $beauty_length_4 = $hair_len_name[3];
                $beauty_length_4_price = $hair_len_price[3];
            }
            if(count($hair_len_name) > 4){
                $beauty_length_5 = $hair_len_name[4];
                $beauty_length_5_price = $hair_len_price[4];
            }
            if(count($hair_len_name) > 5){
                for($i=5;$i<count($hair_len_name);$i++){
                    $hair_length_product .= $hair_len_name[$i].":".$hair_len_price[$i].",";
                }
                $hair_length_product = substr($hair_length_product, 0, -1);
            }
        }

        // 털특징별 추가
        $short_hair_price = $_POST['short_bath_price'];
        $long_hair_price = $_POST['long_bath_price'];
        $double_hair_price = $_POST['double_bath_price'];
        $plus_name = $_POST['plus_name'];
        $plus_price = $_POST['plus_price'];
        $addition_bath_hair = '';
        if(count($plus_name) > 0){
            for($i=0;$i<count($plus_name);$i++){
                $addition_bath_hair.= $plus_name[$i].":".$plus_price[$i].",";
            }
            $addition_bath_hair = substr($addition_bath_hair, 0, -1);
        }

        // 현장판단후 추가
        $hair_clot_price = $_POST['hair_clot_price'];
        $ferocity_price = $_POST['ferocity_price'];
        $tick_price = $_POST['tick_price'];
        $place_plus_name = $_POST['place_plus_name'];
        $place_plus_price = $_POST['place_plus_price'];
        $addition_work_product = '';
        if(count($place_plus_name) > 0){
            for($i=0;$i<count($place_plus_name);$i++){
                $addition_work_product.= $place_plus_name[$i].":".$place_plus_price[$i].",";
            }
            $addition_work_product = substr($addition_work_product, 0, -1);
        }

        // 기타 - 다리
        $tonail_price = $_POST['toenail_price'];
        $boots_price = $_POST['boots_price'];
        $bell_price = $_POST['bell_price'];
        $leg_name = $_POST['leg_name'];
        $leg_price = $_POST['leg_price'];
        $addition_option_product = '';
        if(count($leg_name) > 0){
            for($i=0;$i<count($leg_name);$i++){
                $addition_option_product.= $leg_name[$i].":".$leg_price[$i].",";
            }
            $addition_option_product = substr($addition_option_product, 0, -1);
        }

        // 기타 - 스파
        $spa_name = $_POST['spa_name'];
        $spa_price = $_POST['spa_price'];
        $spa_option_product = '';
        if(count($spa_name) > 0){
            for($i=0;$i<count($spa_name);$i++){
                $spa_option_product.= $spa_name[$i].":".$spa_price[$i].",";
            }
            $spa_option_product = substr($spa_option_product, 0, -1);
        }

        // 기타 - 염색
        $dyeing_name = $_POST['dyeing_name'];
        $dyeing_price = $_POST['dyeing_price'];
        $dyeing_option_product = '';
        if(count($dyeing_name) > 0){
            for($i=0;$i<count($dyeing_name);$i++){
                $dyeing_option_product.= $dyeing_name[$i].":".$dyeing_price[$i].",";
            }
            $dyeing_option_product = substr($dyeing_option_product, 0, -1);
        }

        // 기타 - 기타
        $etc_name = $_POST['etc_name'];
        $etc_price = $_POST['etc_price'];
        $etc_option_product = '';
        if(count($etc_name) > 0){
            for($i=0;$i<count($etc_name);$i++){
                $etc_option_product.= $etc_name[$i].":".$etc_price[$i].",";
            }
            $etc_option_product = substr($etc_option_product, 0, -1);
        }

        // 코멘트
        $add_comment = $_POST['comment'];

        $data = array('partner_id'=>$partner_id,'first_type'=>'개','second_type'=>'추가공통옵션','in_shop_product'=>$in_shop,'out_shop_product'=>$out_shop,'basic_face_price'=>$basic_price
        ,'broccoli_price'=>$brocoli_price,'highba_price'=>$highba_price,'bear_price'=>$bear_price,'hair_clot_price'=>$hair_clot_price,'ferocity_price'=>$ferocity_price,'tick_price'=>$tick_price,'short_hair_price'=>$short_hair_price
        ,'long_hair_price'=>$long_hair_price,'double_hair_price'=>$double_hair_price,'bell_price'=>$bell_price,'toenail_price'=>$tonail_price,'trumpet_etc_price'=>$boots_price,'cheek_touch_price'=>$partner_id,'addition_face_product'=>$addition_face_product
        ,'addition_work_product'=>$addition_work_product,'addition_option_product'=>$addition_option_product,'addition_bath_hair'=>$addition_bath_hair,'spa_option_product'=>$spa_option_product,'dyeing_option_product'=>$dyeing_option_product,'etc_option_product'=>$etc_option_product,'beauty_length_1'=>$beauty_length_1
        ,'beauty_length_1_price'=>$beauty_length_1_price,'beauty_length_2'=>$beauty_length_2,'beauty_length_2_price'=>$beauty_length_2_price,'beauty_length_3'=>$beauty_length_3,'beauty_length_3_price'=>$beauty_length_3_price,'beauty_length_4'=>$beauty_length_4,'beauty_length_4_price'=>$beauty_length_4_price
        ,'beauty_length_5'=>$beauty_length_5,'beauty_length_5_price'=>$beauty_length_5_price,'hair_length_product'=>$hair_length_product,'add_comment'=>$add_comment);
        $data_json = json_encode($data);

        $result = $api ->put('/partner/setting/b/product/add-opt-etc/dog' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "put_work_time"){

        $partner_id = $_POST['partner_id'];
        $work_time1 = (isset($_POST['work_time1']))? $_POST['work_time1'] : 0;
        $work_time2 = (isset($_POST['work_time2']))? $_POST['work_time2'] : 0;
        $work_time3 = (isset($_POST['work_time3']))? $_POST['work_time3'] : 0;
        $work_time4 = (isset($_POST['work_time4']))? $_POST['work_time4'] : 0;
        $work_time5 = (isset($_POST['work_time5']))? $_POST['work_time5'] : 0;
        $work_time6 = (isset($_POST['work_time6']))? $_POST['work_time6'] : 0;
        $work_time7 = (isset($_POST['work_time7']))? $_POST['work_time7'] : 0;
        $work_time8 = (isset($_POST['work_time8']))? $_POST['work_time8'] : 0;
        $work_time9 = (isset($_POST['work_time9']))? $_POST['work_time9'] : 0;
        $work_time10 = (isset($_POST['work_time10']))? $_POST['work_time10'] : 0;
        $work_time11 = (isset($_POST['work_time11']))? $_POST['work_time11'] : 0;
        $work_time12 = (isset($_POST['work_time12']))? $_POST['work_time12'] : 0;
        $work_time13 = (isset($_POST['work_time13']))? $_POST['work_time13'] : 0;
        $work_time14 = (isset($_POST['work_time14']))? $_POST['work_time14'] : 0;

        $data = array('partner_id'=>$partner_id,'work_time1'=>$work_time1,'work_time2'=>$work_time2,'work_time3'=>$work_time3,'work_time4'=>$work_time4
        ,'work_time5'=>$work_time5,'work_time6'=>$work_time6,'work_time7'=>$work_time7,'work_time8'=>$work_time8,'work_time9'=>$work_time9
        ,'work_time10'=>$work_time10,'work_time11'=>$work_time11,'work_time12'=>$work_time12,'work_time13'=>$work_time13,'work_time14'=>$work_time14);
        $data_json = json_encode($data);

        $result = $api ->put('/partner/setting/b/product/part-time/dog' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "post_product_dog"){

        $partner_id = $_POST['partner_id'];
        $second_type = $_POST['second_type'];
        $direct_title = ($second_type == '직접입력')? $_POST['direct_title'] : '';

        $offer = $_POST['offer'];
        if($offer == 0){
            $in_shop = '1';
            $out_shop = '0';
        }else if($offer == 1){
            $in_shop = '0';
            $out_shop = '1';
        }else if($offer == 2){
            $in_shop = '1';
            $out_shop = '1';
        }

        // kgs
        $kgs_array = $_POST['kgs'];
        $kgs = '';
        if($kgs_array != ''){
            for($i=0;$i<count($kgs_array);$i++){
                $kgs.= $kgs_array[$i].',';
            }
            $kgs = substr($kgs, 0, -1);
        }

        // 목욕
        $bath_price_array = $_POST['bath_price'];
        $bath_price = '';
        if($bath_price_array != ''){
            $chk_empty = 0;
            for($i=0;$i<count($bath_price_array);$i++){
                $bath_price.= $bath_price_array[$i].',';
                if($bath_price_array[$i] != ''){$chk_empty = $chk_empty + 1;}
            }
            $bath_price = substr($bath_price, 0, -1);
            if($chk_empty == 0){$bath_price = '';}
        }
        // 부분
        $part_price_array = $_POST['part_price'];
        $part_price = '';
        if($part_price_array != ''){
            $chk_empty = 0;
            for($i=0;$i<count($part_price_array);$i++){
                $part_price.= $part_price_array[$i].',';
                if($part_price_array[$i] != ''){$chk_empty = $chk_empty + 1;}
            }
            $part_price = substr($part_price, 0, -1);
            if($chk_empty == 0){$part_price = '';}
        }
        //부분+목욕
        $bath_part_price_array = $_POST['bath_part_price'];
        $bath_part_price = '';
        if($bath_part_price_array != ''){
            $chk_empty = 0;
            for($i=0;$i<count($bath_part_price_array);$i++){
                $bath_part_price.= $bath_part_price_array[$i].',';
                if($bath_part_price_array[$i] != ''){$chk_empty = $chk_empty + 1;}
            }
            $bath_part_price = substr($bath_part_price, 0, -1);
            if($chk_empty == 0){$bath_part_price = '';}
        }
        //위생
        $sanitation_price_array = $_POST['sanitation_price'];
        $sanitation_price = '';
        if($sanitation_price_array != ''){
            $chk_empty = 0;
            for($i=0;$i<count($sanitation_price_array);$i++){
                $sanitation_price.= $sanitation_price_array[$i].',';
                if($sanitation_price_array[$i] != ''){$chk_empty = $chk_empty + 1;}
            }
            $sanitation_price = substr($sanitation_price, 0, -1);
            if($chk_empty == 0){$sanitation_price = '';}
        }
        //위생+목욕
        $sanitation_bath_price_array = $_POST['sanitation_bath_price'];
        $sanitation_bath_price = '';
        if($sanitation_bath_price_array != ''){
            $chk_empty = 0;
            for($i=0;$i<count($sanitation_bath_price_array);$i++){
                $sanitation_bath_price.= $sanitation_bath_price_array[$i].',';
                if($sanitation_bath_price_array[$i] != ''){$chk_empty = $chk_empty + 1;}
            }
            $sanitation_bath_price = substr($sanitation_bath_price, 0, -1);
            if($chk_empty == 0){$sanitation_bath_price = '';}
        }
        //전체미용
        $all_price_array = $_POST['all_price'];
        $all_price = '';
        if($all_price_array != ''){
            $chk_empty = 0;
            for($i=0;$i<count($all_price_array);$i++){
                $all_price.= $all_price_array[$i].',';
                if($all_price_array[$i] != ''){$chk_empty = $chk_empty + 1;}
            }
            $all_price = substr($all_price, 0, -1);
            if($chk_empty == 0){$all_price = '';}
        }
        //스포팅
        $spoting_price_array = $_POST['spoting_price'];
        $spoting_price = '';
        if($spoting_price_array != ''){
            $chk_empty = 0;
            for($i=0;$i<count($spoting_price_array);$i++){
                $spoting_price.= $spoting_price_array[$i].',';
                if($spoting_price_array[$i] != ''){$chk_empty = $chk_empty + 1;}
            }
            $spoting_price = substr($spoting_price, 0, -1);
            if($chk_empty == 0){$spoting_price = '';}
        }
        //가위컷
        $scissors_price_array = $_POST['scissors_price'];
        $scissors_price = '';
        if($scissors_price_array != ''){
            $chk_empty = 0;
            for($i=0;$i<count($scissors_price_array);$i++){
                $scissors_price.= $scissors_price_array[$i].',';
                if($scissors_price_array[$i] != ''){$chk_empty = $chk_empty + 1;}
            }
            $scissors_price = substr($scissors_price, 0, -1);
            if($chk_empty == 0){$scissors_price = '';}
        }
        //써머컷
        $summercut_price_array = $_POST['summercut_price'];
        $summercut_price = '';
        if($summercut_price_array != ''){
            $chk_empty = 0;
            for($i=0;$i<count($summercut_price_array);$i++){
                $summercut_price.= $summercut_price_array[$i].',';
                if($summercut_price_array[$i] != ''){$chk_empty = $chk_empty + 1;}
            }
            $summercut_price = substr($summercut_price, 0, -1);
            if($chk_empty == 0){$summercut_price = '';}
        }
        //추가1
        $beauty1_price_array = $_POST['beauty1_price'];
        $beauty1_price = '';
        if($beauty1_price_array != ''){
            $chk_empty = 0;
            for($i=0;$i<count($beauty1_price_array);$i++){
                $beauty1_price.= $beauty1_price_array[$i].',';
                if($beauty1_price_array[$i] != ''){$chk_empty = $chk_empty + 1;}
            }
            $beauty1_price = substr($beauty1_price, 0, -1);
            if($chk_empty == 0){$beauty1_price = '';}
        }
        //추가2
        $beauty2_price_array = $_POST['beauty2_price'];
        $beauty2_price = '';
        if($beauty2_price_array != ''){
            $chk_empty = 0;
            for($i=0;$i<count($beauty2_price_array);$i++){
                $beauty2_price.= $beauty2_price_array[$i].',';
                if($beauty2_price_array[$i] != ''){$chk_empty = $chk_empty + 1;}
            }
            $beauty2_price = substr($beauty2_price, 0, -1);
            if($chk_empty == 0){$beauty2_price = '';}
        }
        //추가3
        $beauty3_price_array = $_POST['beauty3_price'];
        $beauty3_price = '';
        if($beauty3_price_array != ''){
            $chk_empty = 0;
            for($i=0;$i<count($beauty3_price_array);$i++){
                $beauty3_price.= $beauty3_price_array[$i].',';
                if($beauty3_price_array[$i] != ''){$chk_empty = $chk_empty + 1;}
            }
            $beauty3_price = substr($beauty3_price, 0, -1);
            if($chk_empty == 0){$beauty3_price = '';}
        }
        //추가4
        $beauty4_price_array = $_POST['beauty4_price'];
        $beauty4_price = '';
        if($beauty4_price_array != ''){
            $chk_empty = 0;
            for($i=0;$i<count($beauty4_price_array);$i++){
                $beauty4_price.= $beauty4_price_array[$i].',';
                if($beauty4_price_array[$i] != ''){$chk_empty = $chk_empty + 1;}
            }
            $beauty4_price = substr($beauty4_price, 0, -1);
            if($chk_empty == 0){$beauty4_price = '';}
        }
        //추가5
        $beauty5_price_array = $_POST['beauty5_price'];
        $beauty5_price = '';
        if($beauty5_price_array != ''){
            $chk_empty = 0;
            for($i=0;$i<count($beauty5_price_array);$i++){
                $beauty5_price.= $beauty5_price_array[$i].',';
                if($beauty5_price_array[$i] != ''){$chk_empty = $chk_empty + 1;}
            }
            $beauty5_price = substr($beauty5_price, 0, -1);
            if($chk_empty == 0){$beauty5_price = '';}
        }

        // 목욕
        $is_consult_bath_array = $_POST['is_consult_bath'];
        $is_consult_bath = '';
        if($is_consult_bath_array != ''){
            for($i=0;$i<count($is_consult_bath_array);$i++){
                $is_consult_bath.= $is_consult_bath_array[$i].',';
            }
            $is_consult_bath = substr($is_consult_bath, 0, -1);
        }
        // 부분
        $is_consult_part_array = $_POST['is_consult_part'];
        $is_consult_part = '';
        if($is_consult_part_array != ''){
            for($i=0;$i<count($is_consult_part_array);$i++){
                $is_consult_part.= $is_consult_part_array[$i].',';
            }
            $is_consult_part = substr($is_consult_part, 0, -1);
        }
        //부분+목욕
        $is_consult_bath_part_array = $_POST['is_consult_bath_part'];
        $is_consult_bath_part = '';
        if($is_consult_bath_part_array != ''){
            for($i=0;$i<count($is_consult_bath_part_array);$i++){
                $is_consult_bath_part.= $is_consult_bath_part_array[$i].',';
            }
            $is_consult_bath_part = substr($is_consult_bath_part, 0, -1);
        }
        //위생
        $is_consult_sanitation_array = $_POST['is_consult_sanitation'];
        $is_consult_sanitation = '';
        if($is_consult_sanitation_array != ''){
            for($i=0;$i<count($is_consult_sanitation_array);$i++){
                $is_consult_sanitation.= $is_consult_sanitation_array[$i].',';
            }
            $is_consult_sanitation = substr($is_consult_sanitation, 0, -1);
        }
        //위생+목욕
        $is_consult_sanitation_bath_array = $_POST['is_consult_sanitation_bath'];
        $is_consult_sanitation_bath = '';
        if($is_consult_sanitation_bath_array != ''){
            for($i=0;$i<count($is_consult_sanitation_bath_array);$i++){
                $is_consult_sanitation_bath.= $is_consult_sanitation_bath_array[$i].',';
            }
            $is_consult_sanitation_bath = substr($is_consult_sanitation_bath, 0, -1);
        }
        //전체미용
        $is_consult_all_array = $_POST['is_consult_all'];
        $is_consult_all = '';
        if($is_consult_all_array != ''){
            for($i=0;$i<count($is_consult_all_array);$i++){
                $is_consult_all.= $is_consult_all_array[$i].',';
            }
            $is_consult_all = substr($is_consult_all, 0, -1);
        }
        //스포팅
        $is_consult_spoting_array = $_POST['is_consult_spoting'];
        $is_consult_spoting = '';
        if($is_consult_spoting_array != ''){
            for($i=0;$i<count($is_consult_spoting_array);$i++){
                $is_consult_spoting.= $is_consult_spoting_array[$i].',';
            }
            $is_consult_spoting = substr($is_consult_spoting, 0, -1);
        }
        //가위컷
        $is_consult_scissors_array = $_POST['is_consult_scissors'];
        $is_consult_scissors = '';
        if($is_consult_scissors_array != ''){
            for($i=0;$i<count($is_consult_scissors_array);$i++){
                $is_consult_scissors.= $is_consult_scissors_array[$i].',';
            }
            $is_consult_scissors = substr($is_consult_scissors, 0, -1);
        }
        //써머컷
        $is_consult_summercut_array = $_POST['is_consult_summercut'];
        $is_consult_summercut = '';
        if($is_consult_summercut_array != ''){
            for($i=0;$i<count($is_consult_summercut_array);$i++){
                $is_consult_summercut.= $is_consult_summercut_array[$i].',';
            }
            $is_consult_summercut = substr($is_consult_summercut, 0, -1);
        }
        //추가1
        $is_consult_beauty1_array = $_POST['is_consult_beauty1'];
        $is_consult_beauty1 = '';
        if($is_consult_beauty1_array != ''){
            for($i=0;$i<count($is_consult_beauty1_array);$i++){
                $is_consult_beauty1.= $is_consult_beauty1_array[$i].',';
            }
            $is_consult_beauty1 = substr($is_consult_beauty1, 0, -1);
        }
        //추가2
        $is_consult_beauty2_array = $_POST['is_consult_beauty2'];
        $is_consult_beauty2 = '';
        if($is_consult_beauty2_array != ''){
            for($i=0;$i<count($is_consult_beauty2_array);$i++){
                $is_consult_beauty2.= $is_consult_beauty2_array[$i].',';
            }
            $is_consult_beauty2 = substr($is_consult_beauty2, 0, -1);
        }
        //추가3
        $is_consult_beauty3_array = $_POST['is_consult_beauty3'];
        $is_consult_beauty3 = '';
        if($is_consult_beauty3_array != ''){
            for($i=0;$i<count($is_consult_beauty3_array);$i++){
                $is_consult_beauty3.= $is_consult_beauty3_array[$i].',';
            }
            $is_consult_beauty3 = substr($is_consult_beauty3, 0, -1);
        }
        //추가4
        $is_consult_beauty4_array = $_POST['is_consult_beauty4'];
        $is_consult_beauty4 = '';
        if($is_consult_beauty4_array != ''){
            for($i=0;$i<count($is_consult_beauty4_array);$i++){
                $is_consult_beauty4.= $is_consult_beauty4_array[$i].',';
            }
            $is_consult_beauty4 = substr($is_consult_beauty4, 0, -1);
        }
        //추가5
        $is_consult_beauty5_array = $_POST['is_consult_beauty5'];
        $is_consult_beauty5 = '';
        if($is_consult_beauty5_array != ''){
            for($i=0;$i<count($is_consult_beauty5_array);$i++){
                $is_consult_beauty5.= $is_consult_beauty5_array[$i].',';
            }
            $is_consult_beauty5 = substr($is_consult_beauty5, 0, -1);
        }

        $is_over_kgs = $_POST['is_over_kgs'];
        $what_over_kgs = (isset($_POST['what_over_kgs']))? $_POST['what_over_kgs'] : '';
        $over_kgs_price = (isset($_POST['over_kgs_price']))? $_POST['over_kgs_price'] : '';
        $add_comment = $_POST['add_comment'];


        $data = array('partner_id'=>$partner_id,'first_type'=>'개','second_type'=>$second_type,'direct_title'=>$direct_title,'in_shop_product'=>$in_shop,'out_shop_product'=>$out_shop
        ,'kgs'=>$kgs,'bath_price'=>$bath_price,'part_pric'=>$part_price,'bath_part_price'=>$bath_part_price,'sanitation_price'=>$sanitation_price,'sanitation_bath_price'=>$sanitation_bath_price
        ,'all_price'=>$all_price,'spoting_price'=>$spoting_price,'scissors_price'=>$scissors_price,'summercut_price'=>$summercut_price,'beauty1_price'=>$beauty1_price,'beauty2_price'=>$beauty2_price
        ,'beauty3_price'=>$beauty3_price,'beauty4_price'=>$beauty4_price,'beauty5_price'=>$beauty5_price,'is_consult_bath'=>$is_consult_bath,'is_consult_part'=>$is_consult_part,'is_consult_bath_part'=>$is_consult_bath_part
        ,'is_consult_sanitation'=>$is_consult_sanitation,'is_consult_sanitation_bath'=>$is_consult_sanitation_bath,'is_consult_all'=>$is_consult_all,'is_consult_spoting'=>$is_consult_spoting,'is_consult_scissors'=>$is_consult_scissors
        ,'is_consult_summercut'=>$is_consult_summercut,'is_consult_beauty1'=>$is_consult_beauty1,'is_consult_beauty2'=>$is_consult_beauty2,'is_consult_beauty3'=>$is_consult_beauty3,'is_consult_beauty4'=>$is_consult_beauty4
        ,'is_consult_beauty5'=>$is_consult_beauty5,'is_over_kgs'=>$is_over_kgs,'what_over_kgs'=>$what_over_kgs,'over_kgs_price'=>$over_kgs_price,'add_comment'=>$add_comment);
        $data_json = json_encode($data);
        $result = $api ->put('/partner/setting/b/product/add-opt/dog' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "post_product_cat"){

        $customer_id = $_POST['customer_id'];

        $offer = $_POST['offer'];
        if($offer == 0){
            $in_shop = 1;
            $out_shop = 0;
        }else if($offer == 1){
            $in_shop = 0;
            $out_shop = 1;
        }else if($offer == 2){
            $in_shop = 1;
            $out_shop = 1;
        }

        $short_price = $_POST['short_price'];
        $long_price = $_POST['long_price'];

        $increase_price = ($_POST['increase_price'] == 0)? '' : $_POST['increase_price'];
        $section_array = $_POST['section'];
        $section = '';
        if($section_array != ''){
            for($i=0;$i<count($section_array);$i++){
                $section.= $section_array[$i].',';
            }
            $section = substr($section, 0, -1);
        }

        $shower_price = $_POST['shower_price'];
        $shower_price_long = $_POST['shower_price_long'];
        $toenail_price = ($_POST['toenail_price'] == 0)? '' : $_POST['toenail_price'];

        $addition_option_product_text = $_POST['addition_option_product_text'];
        $addition_option_product_price = $_POST['addition_option_product_price'];
        $addition_option_product = '';
        if($addition_option_product_text != ''){
            for($i=0;$i<count($addition_option_product_text);$i++){
                if($addition_option_product_price[$i] != '0'){
                    $addition_option_product.= $addition_option_product_text[$i].':'.$addition_option_product_price[$i].',';
                }
            }
            if(strlen($addition_option_product) > 0){
                $addition_option_product = substr($addition_option_product, 0, -1);
            }
        }


        $hair_clot_price = ($_POST['hair_clot_price'] == 0)? '' : $_POST['hair_clot_price'];
        $ferocity_price = ($_POST['ferocity_price'] == 0)? '' : $_POST['ferocity_price'];
        $tick_price = ($_POST['tick_price'] == 0)? '' : $_POST['tick_price'];

        $addition_work_product_text = $_POST['addition_work_product_text'];
        $addition_work_product_price = $_POST['addition_work_product_price'];
        $addition_work_product = '';
        if($addition_work_product_text != ''){
            for($i=0;$i<count($addition_work_product_text);$i++){
                if($addition_work_product_price[$i] != '0'){
                    $addition_work_product.= $addition_work_product_text[$i].':'.$addition_work_product_price[$i].',';
                }
            }
            if(strlen($addition_work_product) > 0){
                $addition_work_product = substr($addition_work_product, 0, -1);
            }
        }

        $is_use_weight = $_POST['is_use_weight'];
        $add_comment = $_POST['add_comment'];

        $data = array('customer_id'=>$customer_id,'in_shop_product'=>$in_shop,'out_shop_product'=>$out_shop,'short_price'=>$short_price,'long_price'=>$long_price
        ,'increase_price'=>$increase_price,'section'=>$section,'shower_price'=>$shower_price,'shower_price_long'=>$shower_price_long,'toenail_price'=>$toenail_price
        ,'addition_option_product'=>$addition_option_product,'hair_clot_price'=>$hair_clot_price,'ferocity_price'=>$ferocity_price,'tick_price'=>$tick_price
        ,'addition_work_product'=>$addition_work_product,'is_use_weight'=>$is_use_weight,'add_comment'=>$add_comment);
        $data_json = json_encode($data);
        $result = $api ->put('/partner/setting/cat' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "put_worktime_type"){

        $partner_id = $_POST['partner_id'];
        $work_time1 = (isset($_POST['worktime_bath']))? $_POST['worktime_bath'] : 'n';
        $work_time2 = (isset($_POST['worktime_part']))? $_POST['worktime_part'] : 'n';
        $work_time3 = (isset($_POST['worktime_bath_part']))? $_POST['worktime_bath_part'] : 'n';
        $work_time4 = (isset($_POST['worktime_sanitation']))? $_POST['worktime_sanitation'] : 'n';
        $work_time5 = (isset($_POST['worktime_sanitation_bath']))? $_POST['worktime_sanitation_bath'] : 'n';
        $work_time6 = (isset($_POST['worktime_all']))? $_POST['worktime_all'] : 'n';
        $work_time7 = (isset($_POST['worktime_spoting']))? $_POST['worktime_spoting'] : 'n';
        $work_time8 = (isset($_POST['worktime_scissors']))? $_POST['worktime_scissors'] : 'n';
        $work_time9 = (isset($_POST['worktime_summercut']))? $_POST['worktime_summercut'] : 'n';
        $work_time10 = (isset($_POST['add_worktime_1']))? $_POST['add_worktime_1'] : 'n';
        $work_time11 = (isset($_POST['add_worktime_2']))? $_POST['add_worktime_2'] : 'n';
        $work_time12 = (isset($_POST['add_worktime_3']))? $_POST['add_worktime_3'] : 'n';
        $work_time13 = (isset($_POST['add_worktime_4']))? $_POST['add_worktime_4'] : 'n';
        $work_time14 = (isset($_POST['add_worktime_5']))? $_POST['add_worktime_5'] : 'n';
        $display = $work_time1.'|'.$work_time2.'|'.$work_time3.'|'.$work_time4.'|'.$work_time5.'|'.$work_time6.'|'.$work_time7.'|'.$work_time8.'|'.$work_time9.'|'.$work_time10.'|'.$work_time11.'|'.$work_time12.'|'.$work_time13.'|'.$work_time14;

        $time1 = (isset($_POST['add_worktime_time_1']))? $_POST['add_worktime_time_1'] : '';
        $time2 = (isset($_POST['add_worktime_time_2']))? $_POST['add_worktime_time_2'] : '';
        $time3 = (isset($_POST['add_worktime_time_3']))? $_POST['add_worktime_time_3'] : '';
        $time4 = (isset($_POST['add_worktime_time_4']))? $_POST['add_worktime_time_4'] : '';
        $time5 = (isset($_POST['add_worktime_time_5']))? $_POST['add_worktime_time_5'] : '';
        $time = $time1.'|'.$time2.'|'.$time3.'|'.$time4.'|'.$time5;

        $add_title1 = (isset($_POST['add_worktime_title_1']))? $_POST['add_worktime_title_1'] : '';
        $add_title2 = (isset($_POST['add_worktime_title_2']))? $_POST['add_worktime_title_2'] : '';
        $add_title3 = (isset($_POST['add_worktime_title_3']))? $_POST['add_worktime_title_3'] : '';
        $add_title4 = (isset($_POST['add_worktime_title_4']))? $_POST['add_worktime_title_4'] : '';
        $add_title5 = (isset($_POST['add_worktime_title_5']))? $_POST['add_worktime_title_5'] : '';
        $add_title = $add_title1.'|'.$add_title2.'|'.$add_title3.'|'.$add_title4.'|'.$add_title5;

        $data = array('partner_id'=>$partner_id,'display'=>$display,'time'=>$time,'add_title'=>$add_title);
        $data_json = json_encode($data);
        $result = $api ->post('/partner/setting/b/product/part/dog' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "put_schedule"){

        $partner_id = $_POST['partner_id'];
        $start_time = intval($_POST['start_time']);
        $close_time = intval($_POST['close_time']);
        $is_work_holiday = ($_POST['is_work_holiday'] == '0')? false : true;
        $time1 = $_POST['time1']; // 휴게시간
        $time_type = intval($_POST['time_type']); // 예약스케줄 운영방식
        $time_type_2_cnt = intval($_POST['time_type_2_cnt']); // 미용사 수

        $week_type = $_POST['week_type']; // 정기휴무 매주 여부
        $week = $_POST['week']; // 정기휴무 요일

        // 영업시간, 공휴일휴무 설정
        $open_close_data = array('partner_id'=>$partner_id,'open_time'=>$start_time,'close_time'=>$close_time,'is_work_on_holiday'=>$is_work_holiday);
        $open_close_data_json = json_encode($open_close_data);
        $open_close_result = $api ->put('/partner/setting/open-close' ,$open_close_data_json);
        if($open_close_result['head']['code'] != 200){
            $return_data = array("code"=>"000000","data"=>$open_close_result);
            return false;
        }

        // 휴게시간 설정
        $is_tb_time_off = $api -> get('/partner/setting/break-time/'.$partner_id);
        $break_time = '';
        for($i=0;$i<count($time1);$i++){
            $break_time .= $time1[$i].",";
        }
        $break_time = substr($break_time, 0, -1);
        if(count($is_tb_time_off['body']) > 0){
            $break_data = array('partner_id'=>$partner_id,'break_time'=>$break_time);
            $break_data_json = json_encode($break_data);
            $break_result = $api ->put('/partner/setting/break-time' ,$break_data_json);
        }else{
            $break_data = array('partner_id'=>$partner_id,'break_time'=>$break_time);
            $break_data_json = json_encode($break_data);
            $break_result = $api ->post('/partner/setting/break-time' ,$break_data_json);
        }
        if($break_result['head']['code'] != 200){
            $return_data = array("code"=>"000000","data"=>$break_result);
            return false;
        }

        // 정기휴일 설정
        $is_tb_regular_holiday = $api -> get('/partner/setting/regular-holiday/'.$partner_id);
        $week_day = 0;
        for($i=0;$i<count($week);$i++){
            $week_day += intval($week[$i]);
        }
        $week_day = ($week_day == 0)? "0000000" : $week_day;
        if(count($is_tb_regular_holiday['body']) > 0){
            $regular_data = array('partner_id'=>$partner_id,'week'=>$week_day);
            $regular_data_json = json_encode($regular_data);
            $regular_result = $api ->put('/partner/setting/regular-holiday' ,$regular_data_json);
        }else{
            $regular_data = array('partner_id'=>$partner_id,'week'=>$week_day);
            $regular_data_json = json_encode($regular_data);
            $regular_result = $api ->post('/partner/setting/regular-holiday' ,$regular_data_json);
        }
        if($regular_result['head']['code'] != 200){
            $return_data = array("code"=>"000000","data"=>$regular_result);
            return false;
        }

        // 예약 스케줄 운영방식 설정
        $time_type_data = array('partner_id'=>$partner_id,'is_time_Type'=>$time_type);
        $time_type_json = json_encode($time_type_data);
        $time_type_result = $api ->put('/partner/setting/part-time-set' ,$time_type_json);

        // 타임제 설정
        if($time_type > 1){
            for($i=0;$i<$time_type_2_cnt;$i++){
                $worker = intval($_POST['worker_'.$i]);
                $worker_name = $_POST['worker_name_'.$i];
                $time2 = $_POST['time2_'.$i];
                $part_time = '';
                for($j=0;$j<count($time2);$j++){
                    $part_time .= $time2[$j].",";
                }
                $part_time = substr($part_time, 0, -1);

                if($worker > 0){
                    $part_data = array('idx'=>$worker,'partner_id'=>$partner_id,'name'=>$worker_name,'times'=>$part_time);
                    $part_data_json = json_encode($part_data);
                    $part_result = $api ->put('/partner/setting/part-time' ,$part_data_json);
                }else{
                    $part_data = array('idx'=>$worker,'partner_id'=>$partner_id,'name'=>$worker_name,'times'=>$part_time);
                    $part_data_json = json_encode($part_data);
                    $part_result = $api ->post('/partner/setting/part-time' ,$part_data_json);
                }
                if($part_result['head']['code'] != 200){
                    $return_data = array("code"=>"000000","data"=>$part_result);
                    return false;
                }
            }
        }

        $return_data = array("code"=>"000000","data"=>$time_type_result);

    }else if($r_mode === "del_dog_product"){

        $artist_id = $_POST['artist_id'];
        $second_type = $_POST['second_type'];
        $direct_title = $_POST['direct_title'];

        $que = "
            DELETE FROM tb_product_dog_static WHERE customer_id = '{$artist_id}' AND second_type = '{$second_type}' AND if( second_type != '직접입력',(direct_title = '{$direct_title}' OR direct_title IS NULL),direct_title = '{$direct_title}')
        ";
        $res = mysqli_query($connection, $que);

        $return_data = array("code"=>"000000",'data'=>$res);

    }else if($r_mode === "del_cat_product"){

        $artist_id = $_POST['artist_id'];

        $que = "
            DELETE FROM tb_product_cat WHERE customer_id = '{$artist_id}'
        ";
        $res = mysqli_query($connection, $que);

        $return_data = array("code"=>"000000",'data'=>$res);
    }else if($r_mode === "put_common_etc_comment"){

        $artist_id = $_POST['artist_id'];
        $comment = $_POST['comment'];

        $que = "
            SELECT * FROM tb_product_dog_static WHERE customer_id = '{$artist_id}' AND second_type = '기타공통'
        ";
        $res = mysqli_query($connection, $que);
        $cnt = mysqli_num_rows($res);
        if($cnt > 0){
            $query = "
                UPDATE tb_product_dog_static SET
                add_comment = '{$comment}'
                WHERE customer_id = '{$artist_id}'
                AND second_type = '기타공통'
            ";
        }else{
            $query = "
                INSERT INTO tb_product_dog_static 
                (customer_id, first_type, second_type, add_comment)
                VALUES
                ('{$artist_id}', '개', '기타공통', '{$comment}')
            ";
        }
        $result = mysqli_query($connection, $query);

        $return_data = array("code"=>"000000",'data'=>$result);

    }else if($r_mode === "customer_memo_sql"){

        $artist_id = $_POST['artist_id'];
        $customer_id = $_POST['customer_id'];
        $tmp_seq = $_POST['tmp_seq'];
        $cellphone = $_POST['cellphone'];
        $comment = $_POST['comment'];

        $que = "
            SELECT * FROM tb_shop_customer_memo WHERE artist_id = '{$artist_id}' AND cellphone = '{$cellphone}' AND customer_id = '{$customer_id}' AND tmp_seq = '{$tmp_seq}'
        ";
        $res = mysqli_query($connection, $que);
        $cnt = mysqli_num_rows($res);
        if($cnt > 0){
            $query = "
                UPDATE tb_shop_customer_memo SET
                memo = '{$comment}',
                update_dt = NOW()
                WHERE artist_id = '{$artist_id}'
                AND customer_id = '{$customer_id}'
                AND tmp_seq = '{$tmp_seq}'
                AND cellphone = '{$cellphone}'
            ";
        }else{
            $query = "
                INSERT INTO tb_shop_customer_memo 
                (artist_id, customer_id, tmp_seq, cellphone, memo)
                VALUES
                ('{$artist_id}', '{$customer_id}', '{$tmp_seq}', '{$cellphone}', '{$comment}')
            ";
        }
        $result = mysqli_query($connection, $query);

        $return_data = array("code"=>"000000",'data'=>$result);

    }else if($r_mode === "all_inquiry_graph"){

        $artist_id = $_POST['login_id'];

        $sql = "
            SELECT 
            (SELECT ifnull(SUM(ifnull(total_price,0)),0) FROM tb_hotel_payment_log WHERE artist_id = '{$artist_id}' AND is_delete = '2' AND is_no_show = '2' AND data_delete = 0) hotel_cnt,
            (SELECT ifnull(SUM(ifnull(total_price,0)),0) FROM tb_playroom_payment_log WHERE artist_id = '{$artist_id}' AND is_delete = '2' AND is_no_show = '2' AND data_delete = 0) playroom_cnt,
            SUM(ifnull(total_price,0)) + SUM(ifnull(local_price,0)) + SUM(ifnull(local_price_cash,0)) beauty_cnt
            FROM tb_payment_log WHERE artist_id = '{$artist_id}' AND is_no_show = 0 AND is_cancel = 0 AND data_delete = 0
        ";
        $res = mysqli_query($connection, $sql);
        $row = mysqli_fetch_assoc($res);

        $return_data = array("code"=>"000000",'data'=>$row);

    }else if($r_mode === "put_vat"){

        $partner_id = $_POST['artist_id'];
        $is_vat = intval($_POST['set_vat']);

        $data = array('partner_id'=>$partner_id,'is_vat'=>$is_vat);
        $json = json_encode($data);

        $type = $api -> put('/partner/setting/vat', $json);

        $return_data = array("code"=>"000000",'data'=>$type);
    }else if($r_mode === "get_dog_type_product"){

        $artist_id = $_POST['artist_id'];
        $second_type = $_POST['second_type'];
        $direct_title = $_POST['direct_title'];

        $data = array('first_type'=>'개','second_type'=>$second_type,'direct_title'=>$direct_title);
        $json = json_encode($data);

        $type = $api -> get('/partner/setting/b/product/add-opt/dog/'.$artist_id, $json);

        $return_data = array("code"=>"000000",'data'=>$type);

    }else if($r_mode === "get_beauty_product"){

        $login_id = $_POST['login_id'];

        $type = $api -> get('/partner/setting/beauty-product/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$type);
    }else if($r_mode === "get_option_product"){

        $login_id = $_POST['login_id'];

        $type = $api -> get('/partner/setting/option-product/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$type);
    }else if($r_mode === "get_beauty_coupon"){

        $login_id = $_POST['login_id'];

        $type = $api -> get('/partner/setting/beauty-coupon/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$type);
    }else if($r_mode === "get_etc_product"){

        $login_id = $_POST['login_id'];

        $type = $api -> get('/partner/setting/etc-product/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$type);
    }else if($r_mode === "get_notice"){

        $login_id = $_POST['login_id'];

        $time_type = $api -> get('/partner/etc/notice/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "get_qna"){

        $login_id = $_POST['login_id'];

        $time_type = $api -> get('/partner/etc/one-on-one/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "post_qna"){

        $partner_id = $_POST['partner_id'];
        $main_type = $_POST['main_type'];
        $title = $_POST['title'];
        $contents = $_POST['contents'];

        $data = array('partner_id'=>$partner_id,'email'=>'','main_type'=>$main_type,'sub_type'=>'','title'=>$title,'contents'=>$contents);
        $data_json = json_encode($data);

        $result = $api ->post('/partner/etc/one-on-one' ,$data_json);

        $return_data = array("code"=>"000000",'data'=>$result);
    }else if($r_mode === "put_resign"){

        $artist_id = $_POST['login_id'];

        $data = array('partner_id'=>$artist_id);
        $data_json = json_encode($data);

        $result = $api ->put('/partner/etc/resign' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "change_password"){

        $partner_id = $_POST['partner_id'];
        $old_pw = $_POST['old_pw'];
        $new_pw = $_POST['new_pw'];

        $data = array('partner_id'=>$partner_id,'old_pw'=>$old_pw,'new_pw'=>$new_pw);
        $data_json = json_encode($data);

        $result = $api ->put('/partner/etc/passwd' ,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "get_performancee"){

        $partner_id = $_POST['partner_id'];
        $st_date = $_POST['st_date'];
        $fi_date = $_POST['fi_date'];
        $order_type = $_POST['order_type'];
        $where_type = ($_POST['where_type'] != "")? str_replace(" ","+", $_POST['where_type']) : "";

        $data = array('st_date'=>$st_date,'fi_date'=>$fi_date,'order_type'=>$order_type,'where_type'=>$where_type);
        $data_json = json_encode($data);

        $time_type = $api -> get('/partner/sales/performance/'.$partner_id, $data_json);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "get_beauty_list"){

        $partner_id = $_POST['login_id'];

        $time_type = $api -> get('/partner/setting/beauty-product/'.$partner_id);

        $return_data = array("code"=>"000000",'data'=>$time_type);
    }else if($r_mode === "get_tooltip"){

        $payment_idx = $_POST['payment_idx'];
        $is_beauty_false = array("is_beauty" => false, "get_count" => 5);

        $is_beauty_false_data_json = json_encode($is_beauty_false);

        $payment_before_etc_false = $api->get('/partner/booking/payment-before-etc/' . $payment_idx, $is_beauty_false_data_json);

        $return_data = array("code"=>"000000",'data'=>$payment_before_etc_false);
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


        $return_data = array("code" => "000000", "data" => $customer_all,"type"=>$type, "ord"=>$ord,"offset"=>$offset,"number"=>$number);
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
            'partner_id' => $partner_id,
            'worker' => $worker,
            'customer_id' => $customer_id,
            'cellphone' => $cellphone,
            'pet_seq' => intval($pet_seq),
            'animal' => $animal,
            'pet_type' => $pet_type,
            'pet_name' => $pet_name,
            'pet_year' => intval($pet_year),
            'pet_month' => intval($pet_month),
            'pet_day' => intval($pet_day),
            'gender' => $gender,
            'neutral' => $neutral,
            'weight' => $weight,
            'beauty_exp' => $beauty_exp,
            'vaccination' => $vaccination,
            'luxation' => $luxation,
            'bite' => $bite,
            'dermatosis' => $dermatosis,
            'heart_trouble' => $heart_trouble,
            'marking' => $marking,
            'mounting' => $mounting,
            'year' => intval($year),
            'month' => intval($month),
            'day' => intval($day),
            'hour' => intval($hour),
            'min' => intval($min),
            'session_id' => $session_id,
            'order_id' => $order_id,
            'local_price' => $local_price,
            'pay_type' => $pay_type,
            'pay_status' => $pay_status,
            'pay_data' => $pay_data,
            'to_hour' => intval($to_hour),
            'to_min' => intval($to_min),
            'use_coupon_yn' => $use_coupon_yn,
            'is_vat' => $is_vat,
            'product' => $product,
            'reserve_yn' => $reserve_yn,
            'aday_ago_yn' => $aday_ago_yn,


        );

        $regist_data_json = json_encode($regist_data);


        $reserve_regist = $api ->post('/partner/booking/b/join/', $regist_data_json);

        $return_data = array("code" => "000000","data"=>$reserve_regist);


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
        $partner_id = $_POST['partner_id'];
        $cellphone = $_POST['cellphone'];



        $is_no_show = true ;

        $set_noshow_data = array(partner_id=>$partner_id,payment_idx=>intval($payment_idx),is_no_show=>$is_no_show,cellphone=>$cellphone);

        $set_noshow_data_json = json_encode($set_noshow_data);

        $set_noshow = $api ->put('/partner/booking/noshow',$set_noshow_data_json);

        $return_data = array("code"=>"000000","data"=>$set_noshow);



    }else if($r_mode === "cancel_noshow"){

        $payment_idx = $_POST['payment_idx'];
        $partner_id = $_POST['partner_id'];
        $cellphone = $_POST['cellphone'];


        $is_no_show = false;

        $cancel_noshow_data = array(partner_id=>$partner_id,payment_idx=>intval($payment_idx),is_no_show=>$is_no_show,cellphone=>$cellphone);

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
        $customer_id = (isset($_POST['customer_id']))? $_POST['customer_id'] : '';
        $tmp_seq = (isset($_POST['tmp_seq']))? $_POST['tmp_seq'] : '';
        $cellphone = (isset($_POST['cellphone']))? $_POST['cellphone'] : '';


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

        $pet_seq = $_POST['idx'];

        $artist_id = $_POST['artist_id'];

        $data = array('artist_id'=>$artist_id);
        $data_json = json_encode($data);

        $result = $api ->get('/partner/booking/beauty-gallery/'.$pet_seq,$data_json);

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


    }else if($r_mode === "pet_list"){


        $login_id = $_POST['login_id'];
        $cellphone = $_POST['cellphone'];

        $data = array(cellphone=>$cellphone);


        $data_json = json_encode($data);

        $result = $api -> get('/partner/customer/petlist/'.$login_id,$data_json);
        $return_data = array("code"=>"000000","data"=>$result);


    }else if($r_mode === "usage_history"){


        $login_id = $_POST['login_id'];
        $cellphone = $_POST['cellphone'];

        $data = array(cellphone=>$cellphone);


        $data_json = json_encode($data);

        $result = $api -> get('/partner/customer/usage-history/'.$login_id,$data_json);
        $return_data = array("code"=>"000000","data"=>$result);


    }else if($r_mode === "customer_delete"){

        $partner_id = $_POST['partner_id'];
        $cellphone = $_POST['cellphone'];

        $data = array(partner_id=>$partner_id,cellphone=>$cellphone);

        $data_json = json_encode($data);

        $result = $api -> delete('/partner/customer/user',$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "pet_delete"){

        $partner_id = $_POST['partner_id'];
        $idx = $_POST['idx'];

        $data = array(partner_id=>$partner_id,pet_idx=>$idx);

        $data_json = json_encode($data);

        $result = $api -> delete('/partner/customer/pet',$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "get_customer_grade"){

        $partner_id = $_POST['partner_id'];
        $cellphone = $_POST['cellphone'];

        $data = array (cellphone=>$cellphone);

        $data_json = json_encode($data);

        $result = $api -> get('/partner/booking/grade/shop/'.$partner_id,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "put_customer_grade_1"){


        $customer_idx=$_POST['customer_idx'];
        $grade_idx=$_POST['grade_idx'];

        $data= array(customer_idx=>intval($customer_idx),grade_idx=>intval($grade_idx));

        $data_json = json_encode($data);

        $result = $api ->put('/partner/booking/grade-shop',$data_json);
        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "put_customer_grade_2"){

        $customer_id = $_POST['customer_id'];
        $grade_idx = $_POST['grade_idx'];

        $data= array(grade_idx=>intval($grade_idx),customer_id=>$customer_id);

        $data_json = json_encode($data);

        $result = $api -> post('/partner/booking/grade-shop',$data_json);
        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode ==='get_customer_special'){

        $partner_id=$_POST['partner_id'];
        $cellphone = $_POST['cellphone'];

        $data = array(cellphone=>$cellphone);

        $data_json = json_encode($data);

        $result = $api -> get('/partner/customer/unique-memo/'.$partner_id,$data_json);

        $return_data = array('code'=>"000000","data"=>$result);


    }else if($r_mode === "get_sub_phone"){

        $partner_id = $_POST['partner_id'];
        $cellphone = $_POST['cellphone'];

        $data = array(cellphone=>$cellphone);

        $data_json = json_encode($data);

        $result = $api -> get('/partner/customer/subphone/'.$partner_id,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode === "delete_sub_phone"){

        $sub_phone_idx = $_POST['sub_phone_idx'];

        $data = array(sub_phone_idx=>intval($sub_phone_idx));

        $data_json = json_encode($data);

        $result = $api -> delete('/partner/customer/subphone',$data_json);

        $return_data =array("code"=>"000000","data"=>$result);

    }else if($r_mode ==="add_sub_phone"){

        $partner_id = $_POST['partner_id'];
        $main_phone = $_POST['main_phone'];
        $sub_name = $_POST['sub_name'];
        $sub_phone = $_POST['sub_phone'];

        $data = array(partner_id=>$partner_id,main_phone=>$main_phone,sub_name=>$sub_name,sub_phone=>$sub_phone);

        $data_json = json_encode($data);

        $result = $api -> post('/partner/customer/subphone',$data_json);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode ==="get_coupon"){

        $partner_id = $_POST['partner_id'];

        $result = $api -> get('/partner/setting/beauty-coupon/'.$partner_id);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode ==="coupon"){

        $partner_id = $_POST['partner_id'];

        $type = "B";
        $coupon_type = "A";

        $data = array(type=>$type,coupon_type=>$coupon_type);
        $data_json = json_encode($data);

        $result = $api ->get('/partner/booking/coupon/'.$partner_id,$data_json);

    }else if($r_mode === 'reserves'){

        $partner_id=$_POST['partner_id'];
        $payment_idx = $_POST['payment_idx'];
        $customer_id = $_POST['customer_id'];
        $tmp_user_idx = $_POST['tmp_user_idx'];
        $service = $_POST['service'];
        $reserve_type = $_POST['reserve_type'];

        $data = array(payment_idx=>intval($payment_idx),customer_id=>$customer_id,tmp_user_idx=>intval($tmp_user_idx),service=>$service,reserve_type=>$reserve_type);

        $data_json = json_encode($data);

        $result = $api -> get('/partner/customer/reserves/'.$partner_id,$data_json);

        $return_data =array("code"=>"000000","data"=>$result);


    }else if($r_mode ==="waiting"){
        $partner_id = $_POST['partner_id'];

        $result =$api ->get("/partner/booking/waiting/".$partner_id);

        $return_data = array("code"=>"000000","data"=>$result);
    }else if($r_mode ==="post_representative"){

        $partner_id = $_POST['partner_id'];
        $customer_id = "";
        $tmp_user_idx = $_POST['tmp_user_idx'];
        $old_phone = $_POST['old_phone'];
        $new_phone = $_POST['new_phone'];

        $data = array(partner_id=>$partner_id,customer_id=>$customer_id,tmp_user_idx=>intval($tmp_user_idx),old_phone=>$old_phone,new_phone=>$new_phone);

        $data_json = json_encode($data);


        $result = $api ->post('/partner/customer/phone-change',$data_json);
        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode ==="put_waiting"){

        $approve_idx=$_POST['approve_idx'];
        $decision_code = $_POST['decision_code'];
        $payment_idx = $_POST['payment_idx'];

        $data = array(approve_idx=>intval($approve_idx),decision_code=>intval($decision_code),payment_idx=>intval($payment_idx));

        $data_json =json_encode($data);

        $result = $api ->put('/partner/booking/waiting',$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode ==="get_consulting"){

        $login_id = $_POST['login_id'];

        $result = $api -> get('/partner/home/consulting/'.$login_id);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode ==="get_consulting_count") {
        $login_id = $_POST['login_id'];

        $result = $api->get('/partner/home/waiting/' . $login_id);

        $return_data = array("code" => "000000", "data" => $result);

    }else if($r_mode === "approve_consult"){

        $payment_idx = $_POST['payment_idx'];

        $approval = 2;

        $data = array('payment_idx'=>intval($payment_idx),'approval'=>$approval);

        $data_json = json_encode($data);

        $result = $api -> put('/partner/home/consulting/',$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "not_approve_consult"){
        $payment_idx = $_POST['payment_idx'];

        $approval = 3;

        $data = array('payment_idx'=>intval($payment_idx),'approval'=>$approval);

        $data_json = json_encode($data);

        $result = $api -> put('/partner/home/consulting/',$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "allim_now"){

        $cellphone = $_POST['cellphone'];
        $message = $_POST['message'];
        $tem_code = "1000004530_20005";
        $btn_link = "";

        $data = array('cellphone'=>$cellphone,'message'=>$message,'tem_code'=>$tem_code,'btn_link'=>$btn_link);

        $data_json = json_encode($data);

        $result = $api -> post('/partner/allim/send',$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === "allim_before"){

        $cellphone = $_POST['cellphone'];
        $message = $_POST['message'];
        $tem_code = "1000004530_20004";
        $btn_link = "";

        $data = array('cellphone'=>$cellphone,'message'=>$message,'tem_code'=>$tem_code,'btn_link'=>$btn_link);

        $data_json = json_encode($data);

        $result = $api -> post('/partner/allim/send',$data_json);

        $return_data = array("code"=>"000000","data"=>$result);



    }else if($r_mode === 'get_user_coupon'){

        $login_id = $_POST['login_id'];
        $customer_id = $_POST['customer_id'];
        $tmp_user_idx = $_POST['tmp_user_idx'];

        $data = array('customer_id'=>$customer_id,'tmp_user_idx'=>intval($tmp_user_idx));

        $data_json = json_encode($data);

        $result = $api -> get('/partner/booking/coupon/'.$login_id,$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode ==='confirm'){

        $payment_idx =$_POST['payment_idx'];

        $is_confirm = $_POST['is_confirm'];

        $data = array('payment_idx'=>intval($payment_idx),'is_confirm'=>intval($is_confirm));

        $data_json = json_encode($data);

        $result = $api -> put('/partner/booking/payment-confirm',$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode ==='cardcash'){

        $payment_idx = $_POST['payment_idx'];
        $card = $_POST['card'];
        $cash = $_POST['cash'];

        $data = array('payment_idx'=>intval($payment_idx),'card'=>intval($card),'cash'=>intval($cash));
        $data_json = json_encode($data);

        $result = $api ->put('/partner/booking/payment-cardcash',$data_json);

        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === 'discount'){

        $payment_idx = $_POST['payment_idx'];
        $type = $_POST['type'];
        $discount= $_POST['discount'];

        $data = array('payment_idx'=>intval($payment_idx),'type'=>intval($type),'discount'=>intval($discount));
        $data_json = json_encode($data);
        $result = $api->put('/partner/booking/payment-discount',$data_json);
        $return_data = array("code"=>"000000","data"=>$result);

    }else if($r_mode === 'reserve_get_time'){

        $pay['worker'] = $_POST['worker'];
        $artist_id = $_POST['artist_id'];
        $pay['year']=$_POST['year'];
        $pay['month']=$_POST['month'];
        $pay['day']=$_POST['day'];
        $pay['hour']=$_POST['hour'];
        $pay['minute'] = $_POST['minute'];

        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];


        $from_time_sql = "
	SELECT * FROM (
		SELECT to_hour end_hour, to_minute end_minute FROM tb_payment_log WHERE artist_id = '".$artist_id."'
		AND worker = '".$pay['worker']."' AND is_cancel = '0'
		AND YEAR = ".$pay['year']." AND MONTH = ".$pay['month']." AND DAY = ".$pay['day']."
		UNION
		SELECT end_hour, end_minute FROM tb_private_holiday WHERE customer_id = '".$artist_id."'
		AND worker = '".$pay['worker']."'
		AND start_YEAR = ".$pay['year']." AND start_MONTH = ".$pay['month']." AND start_DAY = ".$pay['day']."
		AND end_MONTH = ".$pay['month']." AND end_DAY = ".$pay['day']."
	) a
		WHERE time_format(CONCAT(a.end_hour,':',a.end_minute),'%H:%i') <= TIME_FORMAT('".$pay['hour'].':'.$pay['minute']."','%H:%i')
		ORDER BY time_format(CONCAT(a.end_hour,':',a.end_minute),'%H:%i') DESC
		LIMIT 1
";
        $from_time_result = sql_query($from_time_sql);
        $from_time_row = sql_fetch($from_time_result);
        $from_hour = (count($from_time_row)>0&&$from_time_row['end_hour']<10)?'0'.$from_time_row['end_hour']:$from_time_row['end_hour'];
        $from_minute = (count($from_time_row)>0&&$from_time_row['end_minute']<10)?'0'.$from_time_row['end_minute']:$from_time_row['end_minute'];
// 뒤 타임 미용 및 휴무 있는지 확인
        $to_time_sql = "
	SELECT * FROM (
		SELECT hour start_hour, minute start_minute FROM tb_payment_log WHERE artist_id = '".$artist_id."'
		AND worker = '".$pay['worker']."' AND is_cancel = '0'
		AND YEAR = ".$pay['year']." AND MONTH = ".$pay['month']." AND DAY = ".$pay['day']."
		UNION
		SELECT start_hour, start_minute FROM tb_private_holiday WHERE customer_id = '".$artist_id."'
		AND worker = '".$pay['worker']."'
		AND start_YEAR = ".$pay['year']." AND start_MONTH = ".$pay['month']." AND start_DAY = ".$pay['day']."
		AND end_MONTH = ".$pay['month']." AND end_DAY = ".$pay['day']."
	) a
		WHERE time_format(CONCAT(a.start_hour,':',a.start_minute),'%H:%i') > TIME_FORMAT('".$pay['hour'].':'.$pay['minute']."','%H:%i')
		ORDER BY time_format(CONCAT(a.start_hour,':',a.start_minute),'%H:%i')
		LIMIT 1
";
        $to_time_result = sql_query($to_time_sql);
        $to_time_row = sql_fetch($to_time_result);
        $to_hour = (count($to_time_row)>0&&$to_time_row['start_hour']<10)?'0'.$to_time_row['start_hour']:$to_time_row['start_hour'];
        $to_minute = (count($to_time_row)>0&&$to_time_row['start_minute']<10)?'0'.$to_time_row['start_minute']:$to_time_row['start_minute'];
        $workDate = date('Y-m-d',strtotime($pay['year'].'-'.$pay['month'].'-'.$pay['day']));


        $start_date = ($from_hour)? $workDate.' '.$from_hour.':'.$from_minute : $workDate.' '.$start_time;
        $end_date = ($to_minute)? $workDate.' '.$to_hour.':'.$to_minute : $workDate.' '.$end_time;
        $rev_from_date = strtotime($pay['year'].'-'.$pay['month'].'-'.$pay['day'].' '.$pay['hour'].':'.$pay['minute']);
        $rev_to_date = strtotime($pay['year'].'-'.$pay['month'].'-'.$pay['day'].' '.$pay['to_hour'].':'.$pay['to_minute']);

        $return_data = array("code"=>"000000","start_date"=>$start_date,"end_date"=>$end_date);
    }else if($r_mode === 'product_change'){

        $payment_idx = $_POST['payment_idx'];
        $use_coupon = $_POST['use_coupon'];
        $price = $_POST['price'];
        $product = $_POST['product'];


        $data = array(
            'payment_idx'=>intval($payment_idx),
            'use_coupon'=>$use_coupon,
            'price'=>intval($price),
            'product'=>$product

        );

        $data_json = json_encode($data);

        $result = $api ->put('/partner/booking/payment-product',$data_json);

        $return_data = array("code"=>"000000","data"=>$result);


    }else if($r_mode === 'stats'){
        $login_id = $_POST['login_id'];
        $st_date = $_POST['st_date'];
        $fi_date = $_POST['fi_date'];

        $stats = $api->get('/partner/booking/pet-pay/' . $login_id. '?st_date=' . $st_date . '&fi_date=' . $fi_date);

        $return_data = array("code" => "000000", "data" => $stats);

    }else if($r_mode === 'reserve_regist_allim'){


        $cellphone = $_POST['cellphone'];
        $message = $_POST['message'];
        $tem_code = "1000004530_20001";
        $btn_link = "https://customer.banjjakpet.com/allim/#{주문정보}";

        $data = array('cellphone'=>$cellphone,'message'=>$message,'tem_code'=>$tem_code,'btn_link'=>$btn_link);

        $data_json = json_encode($data);

        $result = $api -> post('/partner/allim/send',$data_json);

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
