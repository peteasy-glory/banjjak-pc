<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");
include($_SERVER['DOCUMENT_ROOT']."/include/skin/header.php");
?>
<script>

    if(sessionStorage.getItem('check2') !== 'check' ){

        alert('잘못된 접근입니다.\n회원가입 첫 화면으로 이동합니다.');
        location.href = "./join.php"
    }

</script>
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
					<div class="page-title">계정생성</div>
					<div class="join-wrap">
						<div class="account-create">
							<div class="form-group">

                                    <input type="hidden" name="banjjakpet_nickname" id="banjjakpet_nickname" value="">

								<div class="form-group-cell">
									<div class="form-group-item">
										<div class="form-item-label">이메일 입력</div>
										<div class="form-item-data">
											<div class="form-control-btns">
												<input type="text" name="check_email" id="check_email" class="form-control" placeholder="">
												<button type="button" class="btn btn-outline-purple btn-member-phone" onclick="ck_id()"><em>중복확인</em></button>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group-cell">
									<div class="form-group-item">
										<div class="form-item-label">비밀번호</div>
										<div class="form-item-data">
											<input type="password" name="check_pw" id="check_pw" class="form-control" placeholder="비밀번호입력(6~20자 영문, 숫자조합)">
										</div>
										<div style="display:none;" id="warning_pw">
											<div class="form-input-valid font-color-error" id="warning_pw_in">숫자를 포함해주세요.</div>
										</div>
									</div>
								</div>
								<div class="form-group-cell">
									<div class="form-group-item">
										<div class="form-item-label">비밀번호 확인</div>
										<div class="form-item-data">
											<input type="password" name="check_pw_ck" id="check_pw_ck" class="form-control" placeholder="비밀번호 확인">
										</div>
										<div style="display:none" id="warning_pw2">
											<div class="form-input-valid font-color-error" id="warning_pw2_in">비밀번호가 일치하지 않습니다.</div>
										</div>
									</div>
								</div>

							</div>
						</div>
						<div class="basic-data-group middle text-align-center">
							<!-- btn 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
							<a href="#" class="btn btn-yellow btn-basic-full disabled" id="join-btn-next" onclick="process_check3()"><strong>다음</strong></a>
						</div>	
					</div>

                    <!-- 탈퇴한 아이디 팝업 -->
                    <div id="quitId" class="toast-pop-wrap red">
                        <div class="toast-pop-data">탈퇴한 이메일 계정은<br>재사용이 불가합니다. </div>
                    </div>
                    <!-- //탈퇴한 아이디 팝업 -->

                    <!-- 아이디존재 팝업 -->
                    <div id="noneId" class="toast-pop-wrap red">
                        <div class="toast-pop-data">아이디가 이미 존재합니다.</div>
                    </div>
                    <!-- //아이디존재 팝업 -->

                    <!-- 사용가능 아이디 팝업 -->
                    <div id="useId" class="toast-pop-wrap">
                        <div class="toast-pop-data">사용 가능한 아이디입니다.</div>
                    </div>
                    <!-- //사용가능 아이디 팝업 -->

                    <!-- 이메일 입력하지 않음 팝업 -->
                    <div id="notExistId" class="toast-pop-wrap red">
                        <div class="toast-pop-data">이메일을 입력해주세요.</div>
                    </div>
                    <!-- //이메일 입력하지 않음 팝업 -->

                    <!-- 이메일 형식 오류 팝업 -->
                    <div id="errorFormId" class="toast-pop-wrap red">
                        <div class="toast-pop-data">이메일 형식을 확인해주세요.</div>
                    </div>
                    <!-- //이메일 형식 오류 팝업 -->
				</div>
			</div>
		</div>
	</div>
</div>

<
<!-- //wrap -->
<script src="../static/js/common.js"></script>
<script>

    let is_email_check = 0;
    let is_pw_check = 0;

    let forms = document.querySelectorAll('form');

    //enter 무효화
    Array.from(forms).forEach(function(el){

        el.addEventListener('keydown',function (evt){
            if(evt.keyCode){
                return false;
            }
        })
    })

    //공백제거
    document.getElementById('check_email').addEventListener('keyup',function (){
        this.value = this.value.replace(/(\s*)/g,"");
    })


    let email_regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;


    function ck_id() {
        let input_email = document.getElementById('check_email').value.replace(/\s*/g,"");

        if (!input_email) {
            common.toastPopOpen('notExistId');
            return;
        }

        if (email_regex.test(input_email) === false) {
            common.toastPopOpen('errorFormId');
            return;
        }


        $.ajax({

            type:'POST',
            url:'./login_pc.php',
            data:{

                mode:'check_id',
                id:input_email,
            },
            success:function (res) {
                let response = JSON.parse(res);
                if(response.data.toString() === 'exist'){
                    is_email_check = 0;
                    common.toastPopOpen('noneId');

                    // 비밀번호 앞 얻기
                    let first_nick = input_email.split("@")[0];
                    //*** 처리
                    let fn_ch = first_nick.substring(0, first_nick.length - 4) + "****";
                    document.getElementById("banjjakpet_nickname").value = fn_ch;
                }else if(response.data.toString() === 'not_exist'){
                    is_email_check = 1;
                    common.toastPopOpen('useId');
                }

                check_next_btn();

            },
            error:function (err){
                alert(err.statusText);
            }


        })


    }

    function sign_up(){
        let input_email = document.getElementById('check_email').value.replace(/\s*/g,"");
        let input_pw = document.getElementById('check_pw').value.replace(/\s*/g,"");

        check_pw_error();

        $.ajax({

            type:'POST',
            url:'./login_pc.php',
            data:{

                mode:'check_id',
                id:input_email,
                pw:input_pw,
                phone:'',
            },

        })

    }



    // function login_submit() {
    //
    //     check_pw_error();
    //
    //     document.getElementById('next_form').submit();
    // }

    let warning_pw = document.getElementById('warning_pw');
    let warning_pw2 = document.getElementById('warning_pw2');
    let warning_pw_in = document.getElementById('warning_pw_in');
    let warning_pw2_in = document.getElementById('warning_pw2_in');

    //비밀번호 에러체크
    function check_pw_error(){

        //초기화

        warning_pw.style.display = 'none';
        warning_pw2.style.display = 'none';


        //진행
        let pwd = document.getElementById("check_pw");
        let MsgPw = document.getElementById("MsgPw");
        let pwd_str = pwd.value;

        //==============================================================
        // 비밀번호 유효성

        //6자 미만인 경우
        if(pwd_str.length < 6){
            pw_error_msg1("6자이상 입력바랍니다.");
            return false;
        }

        //16자이하 입력바랍니다.
        if(pwd_str.length > 20){
            pw_error_msg1("20자이하 입력바랍니다.");
            return false;
        }

        // 숫자
        let pattern1 = /[0-9]/;
        if(!pattern1.test(pwd_str)){
            pw_error_msg1("숫자를 포함해주세요.");
            return false;
        }

        // 문자
        let pattern2 = /[a-zA-Z]/;
        if(!pattern2.test(pwd_str)){
            pw_error_msg1("영문을 포함해주세요.");
            return false;
        }

        warning_pw.style.block = 'none';

        //==============================================================
        // 비밀번호 확인 유효성

        let pwd_ck = document.getElementById("check_pw_ck");
        let pwd_value = document.getElementById("check_pw").value;
        let MsgPwck = document.getElementById("MsgPwck");

        if (pwd_ck.value != pwd_value || pwd_ck.value == "") {
            pw_error_msg2("비밀번호가 일치하지 않습니다.");
            check_next_btn();
            return false;
        }else{
            warning_pw2.style.display = 'none';
        }

        check_next_btn();
    }

    //비밀번호 확인 에러체크
    function check_pw_error2(){

        //초기화
        warning_pw2.style.display = 'none';

        let pwd_ck = document.getElementById("check_pw_ck");
        let pwd_value = document.getElementById("check_pw").value;
        let MsgPwck = document.getElementById("MsgPwck");

        if (pwd_ck.value != pwd_value || pwd_ck.value == "") {
            pw_error_msg2("비밀번호가 일치하지 않습니다.");
            is_pw_check = 0;
            check_next_btn();
            return false;
        }else{
            is_pw_check = 1;
            warning_pw2.style.display = 'none';
        }

        check_next_btn();
    }

    //비밀번호 에러 메세지 표시
    function pw_error_msg1(msg){
        warning_pw.style.display = 'block';
        warning_pw_in.innerHTML = msg;
    }

    //비밀번호 호가인 에러 메세지 표시
    function pw_error_msg2(msg){
        warning_pw2.style.display = 'block';
        warning_pw2_in.innerHTML = msg;
    }

    function checkPasswordPattern(str) {
        let pattern1 = /[0-9]/; // 숫자
        let pattern2 = /[a-zA-Z]/; // 문자
        //if(!pattern1.test(str) || !pattern2.test(str) || !pattern3.test(str) || str.length < 8) {
        if(!pattern1.test(str) || !pattern2.test(str) || str.length < 6 || str.length > 20) {
            //alert("비밀번호는 8자리 이상 문자, 숫자, 특수문자로 구성하여야 합니다.");
            return false;
        }
        else {
            return true;
        }
    }

    //다음 버튼 활성화 체크
    function check_next_btn(){
        if(is_email_check == 1 && is_pw_check == 1){
           document.getElementById('join-btn-next').classList.remove('disabled');
        }else{
            //비활성
            if(!document.getElementById('join-btn-next').classList.contains('disabled')){

                document.getElementById('join-btn-next').classList.remove('disabled');
            }


        }
    }


    window.onload = function (){

        document.getElementById('join-btn-next').addEventListener('click',function (){
            if(!this.classList.contains('disabled')){
                login_submit();
            }
        });
        document.getElementById('check_pw').addEventListener('keyup',function (){
            check_pw_error();
        });

        document.getElementById('check_pw_ck').addEventListener('keyup',function (){
            check_pw_error2();
        })



    }
    function process_check3(){

        sessionStorage.setItem('check3','check');
    }

</script>
</body>
</html>