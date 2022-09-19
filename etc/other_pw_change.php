<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");
include($_SERVER['DOCUMENT_ROOT']."/include/skin/header.php");
include($_SERVER['DOCUMENT_ROOT']."/include/check_login_shop.php");

$customer_id = (isset($_SESSION['gobeauty_user_id'])) ? $_SESSION['gobeauty_user_id'] : "";

$artist_flag = (isset($_SESSION['artist_flag'])) ? $_SESSION['artist_flag'] : "";

if ($artist_flag == 1) {
    $artist_id = (isset($_SESSION['shop_user_id'])) ? $_SESSION['shop_user_id'] : "";
} else {
    $artist_id = (isset($_SESSION['gobeauty_user_id'])) ? $_SESSION['gobeauty_user_id'] : "";
}

?>
<body>        

<!-- wrap -->
<div id="wrap">
	<!-- header -->
	<header id="header"></header>
	<!-- //header -->
	<!-- gnb -->
	<nav id="gnb"></nav>
	<!-- //gnb -->
    <!-- container -->
    <section id="container">     
		<!-- contents -->
		<section id="contents">
			<!-- view -->
			<div class="view">
				<div class="data-row">
					<div class="data-col-middle">
						<div class="basic-data-card">
							<div class="card-header">
								<h3 class="card-header-title">비밀번호 변경</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="con-title-group">
										<h4 class="con-title">새로운 비밀번호를 입력해주세요.</h4>
									</div>
									<div class="form-group">
										<div class="grid-layout margin-14-17">
											<div class="grid-layout-inner">
                                                <div class="grid-layout-cell grid-1">
                                                    <div class="form-group-item">
                                                        <div class="form-item-label">현재 비밀번호</div>
                                                        <div class="form-item-data">
                                                            <input type="password" class="form-control old_pwd" placeholder="현재 비밀번호입력">
                                                        </div>
                                                    </div>
                                                </div>
												<div class="grid-layout-cell grid-1">
													<div class="form-group-item">
														<div class="form-item-label">비밀번호</div>
														<div class="form-item-data">
															<input type="password" class="form-control new_pwd" id="gobeauty_pwd" onblur="ck_pwd()" placeholder="비밀번호입력(6~20자 영문, 숫자조합)">
                                                            <span id="MsgPw" style="display: none;">유효성체크</span>
														</div>
													</div>
												</div>
												<div class="grid-layout-cell grid-1">
													<div class="form-group-item">
														<div class="form-item-label">비밀번호 확인</div>
														<div class="form-item-data">
															<input type="password" class="form-control old_pwd_chk" placeholder="비밀번호 확인">
                                                            <span id="MsgPwck" style="display: none;">유효성체크</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
								<a href="#" class="btn-page-bottom disabled">변경하기</a>
							</div>
						</div>			
					</div>
				</div>
			</div>
			<!-- //view -->
		</section>
		<!-- //contents -->
    </section>
    <!-- //container -->
</div>
<!-- //wrap -->
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/etc.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    let customer_id = '<?=$customer_id?>';
    $(document).ready(function() {
        var artist_flag = "<?=$artist_flag?>";
        if(artist_flag == 1){
            $("#gnb_home").css("display","none");
            $("#gnb_shop_wrap").css("display","none");
            $("#gnb_detail_wrap").css("display","none");
            $("#gnb_stats_wrap").css("display","none");
        }
        get_navi(artist_id);
        gnb_init();
        gnb_actived('gnb_etc_wrap','gnb_profile');
    })

    $(document).on("keyup",".form-control",function(){
        var new_pwd = $(".new_pwd").val();
        var old_pwd_chk = $(".old_pwd_chk").val();
        var MsgPwck = document.getElementById("MsgPwck")

        if (old_pwd_chk != new_pwd || new_pwd == "") {
            MsgPwck.style.display = "block";
            MsgPwck.className = 'error'
            MsgPwck.innerHTML = "<font style='font-size:13px;color:red;'>비밀번호가 일치하지 않습니다.</font>"
            $(".btn-page-bottom").addClass('disabled');
            //            pwd_ck.focus()
            return false;
        } else {
            MsgPwck.style.display = "block";
            MsgPwck.className = 'vaild'
            MsgPwck.innerHTML = "<font style='font-size:13px;color:green;'>ok</font>"
            if(ck_pwd()){
                $(".btn-page-bottom").removeClass('disabled');
            }
            return true;password
        }
    })

    function ck_pwd() {
        var pwd = document.getElementById("gobeauty_pwd")
        var MsgPw = document.getElementById("MsgPw")
        var isPwd = /^(?=.*[a-zA-Z])((?=.*\d)|(?=.*\W)).{6,20}$/

        if (!isPwd.test(pwd.value)) {
            MsgPw.style.display = "block";
            MsgPw.className = 'error'
            MsgPw.innerHTML = "<font style='font-size:13px;color:red;'>숫자포함 최소 6자리 이상</font>"
            //            pwd.focus()
            return false;
        } else {
            MsgPw.style.display = "block";
            MsgPw.className = 'vaild'
            MsgPw.innerHTML = "<font style='font-size:13px;color:green;'>ok</font>"
            return true;
        }
    }

    // 변경하기 클릭
    $(document).on("click",".btn-page-bottom",function(){
        var old_pwd = $(".old_pwd").val();
        var new_pwd = $(".new_pwd").val();
        if($(this).hasClass("disabled") == false){
            change_password(customer_id, old_pwd, new_pwd);
        }
    })

</script>
</body>
</html>