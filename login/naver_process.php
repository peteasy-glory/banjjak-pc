<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");

$gender=$_REQUEST["gender"];
$email=$_REQUEST["email"];
//naver
//    $email="pettester@peteasy.kr";
$age=$_REQUEST["age"];
$pc=$_REQUEST["pc"];

if (!$email || strlen($email) < 5 || strpos($email, "@") === false) {
    ?>
    <script>
        alert("이메일 정보가 포함되어있지 않아,<br>네이버 아이디로 로그인을 사용 할 수 없습니다.");
        location.href = 'login.php';
    </script>
    <?php
    return;
}

// 선가입 확인
$login_insert_sql = "select * from tb_customer where id = '".$email."';";
$result = mysqli_query($connection, $login_insert_sql);
if ($rows = mysqli_fetch_object($result)) {

    // 회원 탈퇴하면 로그인 취소
    if($rows->enable_flag == 0){
        ?>
        <script>
            alert("이미 탈퇴한 회원입니다. 로그인화면으로 이동합니다.");
            location.href = "login.php";
        </script>
        <?php
        return false;
    }

    $user_name = $rows->id;
    $artist_flag = $rows->artist_flag;
    $my_shop_flag = $rows->my_shop_flag;

    $_SESSION['gobeauty_user_id'] = $rows->id;
    //naver
    //$_SESSION['gobeauty_user_id'] = "pettester@peteasy.kr";
    $_SESSION['my_shop_flag'] = $my_shop_flag;

    // 20200716 ulmo 최근 로그인 시간 기록
    $last_login_sql = "
			UPDATE tb_customer SET
				last_login_time = NOW(),
				last_applogin_time=now() 
			WHERE id = '".$email."'
				AND nickname = '".$rows->nickname."'
		";
    $last_login_result = mysqli_query($connection, $last_login_sql);

    if($artist_flag == "1"){
        $artist_sql = "SELECT * FROM tb_shop_artist WHERE artist_id = '{$email}' AND del_yn = 'N'";
        $artist_result = mysqli_query($connection, $artist_sql);

        if($artist_data = mysqli_fetch_object($artist_result)){
            $_SESSION['artist_flag'] = $artist_flag;
            $_SESSION['shop_user_id'] = $artist_data->customer_id;
        }
    }
    cookie_save($email,$master_key_name);


    ?>
    <script>
        location.href="../home/index.php";
    </script>
    <?php
} else {
    // 가입 처리
    $pwd = rand_id();
    $random_number = sprintf("%06d",rand(000000,999999));
    $id_pos = strpos($email, "@");
    $nickname = "";
    if ($id_pos > 5) {
        $nickname = substr($email, 0, $id_pos-3)."_".$random_number;
    } else {
        $nickname = substr($email, 0, $id_pos)."_".$random_number;
    }
    $login_sql = "insert into tb_customer (is_regist_by_naver,age,gender,id,password,nickname,last_login_time,registration_time,push_option) values (1, '".$age."', '".$gender."', '".$email."','".make_password_hash($pwd)."','".$nickname."',now(),now(),1);";
    $result_login = mysqli_query($connection, $login_sql);
    if ($result_login) {
        $_SESSION['gobeauty_user_id'] = $email;
        //naver
        //$_SESSION['gobeauty_user_id'] = "pettester@peteasy.kr";
        //$_SESSION['my_shop_flag']='1';

    }

    cookie_save($email,$master_key_name);
    ?>i
    <script>
        location.href="naver_cellphone";
    </script>
    <?php
}
closeDB();
?>

