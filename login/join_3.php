<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");
include($_SERVER['DOCUMENT_ROOT']."/include/skin/header.php");
?>
<script>

    if(sessionStorage.getItem('check3') !== 'check'){

        alert('잘못된 접근입니다.\n회원가입 첫 화면으로 이동합니다.');
        location.href = "join1"
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
					<div class="join-wrap">
						<div class="join-complete">
							<div class="join-complete-inner">
								<div class="logo"><img src="../static/images/icon/img-illust-1@2x.png" alt="" width="103"></div>
								<div class="complete-user-id"><?=$_SESSION["login_id_t"]?>님.</div>
								<div class="complete-desc">반짝 미용파트너 서비스 회원가입을 축하드립니다.</div>
							</div>
						</div>
						<div class="basic-data-group middle text-align-center">
							<!-- btn 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
							<a href="./login.php" class="btn btn-yellow btn-basic-full"><strong>로그인하기</strong></a>
						</div>	
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>
<!-- //wrap -->
<script src="../static/js/common.js"></script>
</body>
</html>