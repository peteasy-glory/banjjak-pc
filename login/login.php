<?php

include($_SERVER['DOCUMENT_ROOT']."/include/global.php");
include($_SERVER['DOCUMENT_ROOT'] . "/include/skin/header.php");

$client_id = "UJ2SBwYTjhQSTvsZF8TO";
$redirectURI = urlencode("https://partner-pc.banjjakpet.com/login/naver");
$state = "RAMDOM_STATE";
$apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=" . $client_id . "&redirect_uri=" . $redirectURI . "&state=" . $state;


$client_id_a = 'com.banjjakpet.banjjak';

$redirect_uri = 'https://partner-pc.banjjakpet.com/login/apple_callback';

$_SESSION['state'] = RandomToken(5);

$authorize_url = 'https://appleid.apple.com/auth/authorize'.'?'.http_build_query([
        'content-type' => 'application/x-www-form-urlencoded',
        'response_type' => 'code',
        'response_mode' => 'form_post',
        'client_id' => $client_id_a,
        'redirect_uri' => $redirect_uri,
        'state' => $_SESSION['state'],
        'scope' => 'name email',
    ]);

function RandomToken($length = 32){
    if(!isset($length) || intval($length) <= 8 ){
        $length = 32;
    }
    if (function_exists('random_bytes')) {
        return bin2hex(random_bytes($length));
    }
    if (function_exists('mcrypt_create_iv')) {
        return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
    }
    if (function_exists('openssl_random_pseudo_bytes')) {
        return bin2hex(openssl_random_pseudo_bytes($length));
    }
}


?>

<body>

<!-- wrap -->
<div id="wrap">


    <div class="member-header">
        <div class="member-header-inner">
            <h1><a href="#">반짝 반려미용샵의 단짝</a></h1>
        </div>
    </div>
    <div class="member-wrap">
        <div class="member-inner">
            <div class="member-view">
                <div class="member-view-inner">
                    <div class="login-wrap">
                        <div class="login-logo">MY SHOP관리 로그인</div>
                        <div class="form-group">
                            <div class="form-group-cell">
                                <div class="form-group-item">
                                    <div class="form-item-label">아이디</div>
                                    <div class="form-item-data">
                                        <input type="text" class="form-control" id="gobeauty_user_name" name="gobeauty_user_name" placeholder="이메일 아이디 입력" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group-cell">
                                <div class="form-group-item">
                                    <div class="form-item-label">비밀번호</div>
                                    <div class="form-item-data">
                                        <input type="password" class="form-control" id="gobeauty_user_password" name="gobeauty_user_password" placeholder="비밀번호 입력" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="login-agree">
                            <div class="check"><label class="form-checkbox"><input type="checkbox" id="remember" name="check"><span class="form-check-icon"><em>로그인 상태유지</em></span></label></div>
                            <div class="btn-ui"><a href="./login_find_id.php" class="btn-member">아이디/비밀번호 찾기</a></div>
                        </div>
                        <div class="login-btn-group">
                            <a href="javascript:;" class="btn-login-item login">로그인</a>
                            <a href="<?=$apiURL?>" class="btn-login-item naver">네이버 아이디로 로그인</a>
                            <a href="<?=$authorize_url?>" class="btn-login-item apple">Sign in with Apple</a>
                            <a href="./join.php" class="btn-simple-join">10초 초간편 회원가입하기</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- //wrap -->
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/login.js"></script>
<script>
    window.onload = function(){

        login();

    }
</script>
</body>
</html>
