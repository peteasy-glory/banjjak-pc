<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");
include($_SERVER['DOCUMENT_ROOT']."/include/skin/header.php");
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
					<div class="page-title">약관동의</div>
					<div class="join-wrap">
						<div class="join-desc">우리 만난 적은 없지만,<br>약관동의가 필요해요</div>
						<div class="agree-check-list">
							<div class="agree-check-item all">
								<div class="item-inner">
									<div class="check-subject" >전체선택</div>
									<div class="check-value"  ><label class="form-checkbox"><input type="checkbox" class="form-check-box" id="check_all"><span class="form-check-icon"><em></em></span></label></div>
								</div>
							</div>
							<div class="agree-check-item">
								<div class="item-inner">
									<div class="check-subject font-underline"><a href="#">반짝 이용약관 동의(필수)</a></div>
									<div class="check-value"><label class="form-checkbox"><input type="checkbox" class="form-check-box required-box" id="agree1" required><span class="form-check-icon"><em></em></span></label></div>
								</div>
							</div>
							<div class="agree-check-item">
								<div class="item-inner">
									<div class="check-subject font-underline"><a href="#">개인정보 수집 및 이용 동의(필수)</a></div>
									<div class="check-value"><label class="form-checkbox"><input type="checkbox" class="form-check-box required-box" id="agree2" required><span class="form-check-icon"><em></em></span></label></div>
								</div>
							</div>
							<div class="agree-check-item">
								<div class="item-inner">
									<div class="check-subject font-underline"><a href="#">개인정보 수집 및 이용 동의(선택)</a></div>
									<div class="check-value"><label class="form-checkbox"><input type="checkbox" class="form-check-box" id="agree3"><span class="form-check-icon"><em></em></span></label></div>
								</div>
							</div>
							<div class="agree-check-item">
								<div class="item-inner">
									<div class="check-subject font-underline"><a href="#">위치기반서비스 이용동의(선택)</a></div>
									<div class="check-value"><label class="form-checkbox"><input type="checkbox" class="form-check-box" id="agree4"><span class="form-check-icon"><em></em></span></label></div>
								</div>
							</div>
							<div class="agree-check-item">
								<div class="item-inner">
									<div class="check-subject">마켓팅정보 수신동의(선택)</div>
									<div class="check-value"><label class="form-checkbox"><input type="checkbox" class="form-check-box" id="agree5"><span class="form-check-icon"><em></em></span></label></div>
								</div>
							</div>
							<div class="agree-check-item minor">
								<div class="item-inner">
									<div class="check-subject">만 14세 이상입니다.(필수)</div>
									<div class="check-value"><label class="form-checkbox"><input type="checkbox" class="form-check-box required-box" id="agree6" required><span class="form-check-icon"><em></em></span></label></div>
								</div>
								<div class="check-info">만 14세 이상 고객만 가입 가능합니다.</div>
							</div>
						</div>
						<div class="basic-data-group middle text-align-center">
							<!-- btn 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
							<a href="#" class="btn btn-yellow btn-basic-full disabled" id="join-btn-next" onclick="process_check1()"><strong>다음</strong></a>
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

        join_check();
    }

    //잘못된 접근 방지
    function process_check1(){
        sessionStorage.setItem('check1','check');
    }

</script>
</body>
</html>