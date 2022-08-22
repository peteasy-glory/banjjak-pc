<?php
include($_SERVER['DOCUMENT_ROOT'] . "/include/global.php");
include($_SERVER['DOCUMENT_ROOT'] . "/common/TRestAPI.php");



$user_id = (isset($_SESSION['gobeauty_user_id'])) ? $_SESSION['gobeauty_user_id'] : "";
$user_name = (isset($_SESSION['gobeauty_user_nickname'])) ? $_SESSION['gobeauty_user_nickname'] : "";





//$api = new TRestAPI("https://partnerapi.banjjakpet.com","Token 2156d1824c98f27a1f163a102cf742002b15e624");
$api = new TRestAPI("http://stg-partnerapi.banjjakpet.com:8080","Token 55dda3818c897ef163b09a13d37199a7d211b6d2");




$data = array();



$return_data = array("code" => "999999", "data" => "잘못된 접근입니다.");

$r_mode = ($_POST["mode"] && $_POST["mode"] != "") ? $_POST["mode"] : "";





if($r_mode){


    if($r_mode === "login"){

        $login_id = $_POST['login_id'];
        $login_pw = $_POST['login_pw'];


        $login_data = array(id=>$login_id,pw=>$login_pw);
        $login_data_json = json_encode($login_data);



        $login = $api->get("/partner/login",$login_data_json);



        $return_data = array("code" => "000000", "data" => $login);

    }else if($r_mode === "check_id"){


        $check_id = $api->get('/partner/auth-email/'.$_GET['id']);

        if($check_id['body']['exist'] === false){

            array_push($data,'not_exist');

        }else if($check_id['body']['exist'] === true){
            array_push($data,'exist');
        }


        $return_data = array("code" => "000000", "data" => $data);
    }else if($r_mode === "home"){


        $login_id = $_POST['login_id'];

        $home = $api->get('/partner/home/'.$login_id);

        $return_data = array("code" => "000000", "data"=>$home);

    }else if($r_mode ==="month_book"){


        $login_id = $_POST['login_id'];
        $year = $_POST['year'];
        $month = $_POST['month'];

        $month_book = $api->get('/partner/home/'.$login_id.'?y='.$year.'&m='.$month);

        $return_data = array("code"=>"000000","data"=>$month_book);
    }else if($r_mode ==="holiday"){

        $login_id = $_POST['login_id'];

        $holiday = $api->get('/partner/setting/regular-holiday/'.$login_id);

        $return_data = array("code"=>"000000","data"=>$holiday);
    }else if($r_mode === "search"){

        $login_id = $_POST['login_id'];
        $search = $_POST['search'];

        if((int)$search !== 0){

            $search = (int)$search;
        }

        if(gettype($search) === 'string'){
            $result = $api->get('/partner/home/search/'.$login_id.'?name='.$search);
        }else if(gettype($search) === 'integer'){
            $result = $api->get(
                '/partner/home/search/'.$login_id.'?phone='.$search);
        }


        $return_data = array("code"=>"000000","data"=>$result);


    }else if($r_mode === "day_book"){

        $login_id = $_POST['login_id'];
        $st_date = $_POST['st_date'];
        $fi_date = $_POST['fi_date'];

        $day_book = $api->get('/partner/booking/b/'.$login_id.'?st_date='.$st_date.'&fi_date='.$fi_date);

        $return_data = array("code"=>"000000",'data'=>$day_book);

    }else if($r_mode === "open_close"){

        $login_id = $_POST['login_id'];

        $open_close = $api -> get('/partner/setting/open-close/'.$login_id);

        $return_data = array('code'=>'000000','data'=>$open_close);

    }else if($r_mode === "working"){

        $login_id = $_POST['login_id'];

        $working = $api -> get('/partner/setting/working/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$working);
    }else if($r_mode === "break_time"){

        $login_id = $_POST['login_id'];

        $break_time = $api -> get('/partner/setting/break-time/'.$login_id);

        $return_data = array("code"=>"000000",'data'=>$break_time);
    }else if($r_mode === "pay_management"){

        $payment_idx = $_POST['payment_idx'];

        $pay_management = $api -> get('/partner/booking/payment-customer-pet/'.$payment_idx);


        $is_beauty_false = array("is_beauty"=>false,"get_count"=>10);
        $is_beauty_true = array("is_beauty"=>true,"get_count"=>10);

        $is_beauty_false_data_json = json_encode($is_beauty_false);
        $is_beauty_true_data_json = json_encode($is_beauty_true);

        $payment_before_etc_false = $api -> get ('/partner/booking/payment-before-etc/'.$payment_idx,$is_beauty_false_data_json);
        $payment_before_etc_true = $api -> get ('/partner/booking/payment-before-etc/'.$payment_idx,$is_beauty_true_data_json);



        $return_data = array("code"=>"000000",'data'=>$pay_management,"data2"=>$payment_before_etc_false,"data3"=>$payment_before_etc_true);
    }else if($r_mode === "schedule_artist") {


        $login_id = $_POST['login_id'];

        $schedule_artist = $api->get('/partner/booking/schedule-artist/' . $login_id);

        $return_data = array("code" => "000000", "data" => $schedule_artist);

    }else if($r_mode === "week_book"){

        $login_id = $_POST['login_id'];

        $st_date = $_POST['st_date'];
        $fi_date = $_POST['fi_date'];

        $week_book = $api->get('/partner/booking/b/'.$login_id.'?st_date='.$st_date.'&fi_date='.$fi_date);

        $return_data = array("code"=>"000000",'data'=>$week_book);

    }else if($r_mode === "customer_all"){

        $login_id = $_POST['login_id'];

        $type = $_POST['type'];
        $ord = $_POST['ord'];

        if($type === "all"){
            $customer_all_b = $api->get('/partner/customer/search/'.$login_id.'?type=beauty&ord_type='.$ord);
            $customer_all_h = $api->get('/partner/customer/search/'.$login_id.'?type=hotel&ord_type='.$ord);
            $customer_all_k = $api->get('/partner/customer/search/'.$login_id.'?type=kinder&ord_type='.$ord);

            $customer_all = array($customer_all_b,$customer_all_h,$customer_all_k);
        }else{
            $customer_all = $api->get('/partner/customer/search/'.$login_id.'?type='.$type.'&ord_type='.$ord);
        }



        $return_data = array("code"=>"000000","data"=>$customer_all);
    }else if($r_mode === "customer_count"){

        $login_id = $_POST['login_id'];


        $count_people = $api ->get('/partner/customer/search/'.$login_id.'?type=people');
        $count_animal = $api ->get('/partner/customer/search/'.$login_id.'?type=animal');

        $return_data = array("code"=>"000000","people"=>$count_people,"animal"=>$count_animal);

    }else if($r_mode === "post_prohibition"){

        $login_id = $_POST['login_id'];
        $worker = $_POST['worker'];
        $type = $_POST['type'];
        $st_date = $_POST['st_date'];
        $fi_date = $_POST['fi_date'];


        $prohibition_data = array(partner_id=>$login_id,worker=>$worker,type=>$type,st_date=>$st_date,fi_date=>$fi_date);
        $prohibition_data_json = json_encode($prohibition_data);


        $post_prohibition = $api ->post('/partner/booking/prohibition',$prohibition_data_json);

        $return_data = array("code"=>"000000","data"=>$post_prohibition);
    }else if($r_mode === "get_prohibition"){

        $login_id = $_POST['login_id'];
        $st_date = $_POST['st_date'];
        $fi_date = $_POST['fi_date'];

        $prohibition_data = array(st_date=>$st_date,fi_date=>$fi_date);
        $prohibition_data_json = json_encode($prohibition_data);

        $get_prohibition = $api -> get('/partner/booking/prohibition/'.$login_id,$prohibition_data_json);

        $return_data = array("code"=>"000000","data"=>$get_prohibition);



    }else if($r_mode === "delete_prohibition"){

        $ph_seq = $_POST['ph_seq'];

        $prohibition_data = array("idx"=>intval($ph_seq));
//        $prohibition_data_json = json_encode($prohibition_data);

        $delete_prohibition = $api -> delete('/partner/booking/prohibition',$prohibition_data);

        $return_data = array("code"=>"000000","data"=>$delete_prohibition);
    }

}






    echo json_encode($return_data, JSON_UNESCAPED_UNICODE);
?>
