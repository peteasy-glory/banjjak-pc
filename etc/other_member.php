<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");
include($_SERVER['DOCUMENT_ROOT']."/include/skin/header.php");
include($_SERVER['DOCUMENT_ROOT']."/include/check_login_shop.php");

$artist_id = (isset($_SESSION['gobeauty_user_id'])) ? $_SESSION['gobeauty_user_id'] : "";


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
								<h3 class="card-header-title">회원정보 관리</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="set-main-wrap">
										<div class="grid-layout">
											<div class="grid-layout-inner">
												<div class="grid-layout-cell grid-2"><a href="other_pw_change.php" class="btn-set-main-menu"><div class="txt">비밀번호 변경</div><div class="icon icon-set-menu-7"></div></a></div>
												<div class="grid-layout-cell grid-2"><a href="/data/logout_process.php" class="btn-set-main-menu"><div class="txt">로그아웃</div><div class="icon icon-set-menu-8"></div></a></div>
												<div class="grid-layout-cell grid-2"><a href="other_terms3.php" class="btn-set-main-menu"><div class="txt">개인정보보호지침</div><div class="icon icon-set-menu-9"></div></a></div>
												<div class="grid-layout-cell grid-2"><a href="other_terms4.php" class="btn-set-main-menu"><div class="txt">이용약관</div><div class="icon icon-set-menu-10"></div></a></div>
												<div class="grid-layout-cell grid-2"><a href="other_hack.php" class="btn-set-main-menu"><div class="txt">탈퇴하기</div><div class="icon icon-set-menu-11"></div></a></div>
											</div>
										</div>
									</div>
								</div>
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
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
    })
</script>
</body>
</html>