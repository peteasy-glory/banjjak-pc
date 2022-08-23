<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");

$is_android = 0;
$app = new App();
if ($app->is_app() == 1) {
    $is_android = 1;
    $login_insert_sql = "update tb_customer set token = '' where id = '".$_SESSION['gobeauty_user_id']."';";
    $result = mysqli_query($connection, $login_insert_sql);
}

session_destroy();

//쿠키 전체 삭제(2019-06-21 hue)
$past = time() - 3600;
foreach ($_COOKIE as $key => $value)
{
    setcookie($key, '', $past, '/','.'.$_SERVER['HTTP_HOST'] );
}


?>

<script>
    location.href="/";

    // 쿠키 생성
    function setCookie(cName, cValue, cDay){
        var expire = new Date();
        expire.setDate(expire.getDate() + cDay);
        cookies = cName + '=' + escape(cValue) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)를 합니다.
        if(typeof cDay != 'undefined') cookies += ';expires=' + expire.toGMTString() + '; SameSite=None; Secure';
        document.cookie = cookies;
    }
</script>

