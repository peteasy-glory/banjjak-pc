<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");
include($_SERVER['DOCUMENT_ROOT']."/include/skin/header.php");
?>

<script>

    if(sessionStorage.getItem('check1') !== 'check'){

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
					<div class="page-title">핸드폰 소유 인증</div>
					<div class="join-wrap">
						<div class="join-desc">회원가입을 위해<br>휴대폰 소유 인증을 진행합니다.</div>
						<div class="phone-confirm">
                            <form action="" id="next_form" method="POST">
							<div class="form-group">							
								<div class="form-group-cell">
									<div class="form-group-item">
										<div class="form-item-label">휴대폰 번호</div>
										<div class="form-item-data">
											<div class="form-control-btns">
												<input type="text" maxlength="15" name="check_cellphone_1" id="check_cellphone_1" class="form-control" placeholder="">
												<button type="button" onclick="sendsms()" id="sendsms_btn" class="btn btn-outline-purple btn-member-phone"><em>전송</em></button>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group-cell">
									<div class="form-group-item">
										<div class="form-item-label">인증 번호 입력</div>
										<div class="form-item-data">
											<div class="form-control-btns">
												<input type="text" name="check_cellphone_2" id="check_cellphone_2" class="form-control" placeholder="">
												<!-- btn 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
												<button type="button" class="btn btn-purple btn-member-phone disabled" id="verify_cellphone"><em>인증확인</em></button>
											</div>
										</div>
									</div>
								</div>
							</div>
                            </form>
						</div>
						<div class="basic-data-group middle text-align-center">
							<!-- btn 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
							<a href="#" class="btn btn-yellow btn-basic-full disabled" id="join-btn-next"><strong>다음</strong></a>
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

    $(document).ready(function(){
        $(".check_number").click(function(){
            check_sms_number();
        })
        $(".submit_btn").click(function(){
            if(!$(this).hasClass("disabled")){
                $("#next_form").submit();
            }

        })

    })



    //잘못된 접근 방지
    function process_check2(){
        sessionStorage.setItem('check2','check');
    }







</script>

</body>
</html>