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
<script src="../static/js/dev_common.js"></script>

<script src="../static/js/login.js"></script>
<script>


    $(document).ready(function(){

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
    })






    function process_check3(){

        sessionStorage.setItem('check3','check');
    }

</script>
</body>
</html>