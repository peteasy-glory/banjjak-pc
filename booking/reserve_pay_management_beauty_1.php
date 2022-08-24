<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");
include($_SERVER['DOCUMENT_ROOT']."/include/skin/header.php");
include($_SERVER['DOCUMENT_ROOT']."/include/check_login_shop.php");

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
								<h3 class="card-header-title">작업 / 결제관리</h3>
								<div class="card-header-right">
									<div class="label label-outline-purple large round"><em>예약확정</em></div>
								</div>
							</div>
							<div class="card-body">
								<div class="card-body-inner" id="work_body_inner">
									<div class="wide-tab">
										<div class="wide-tab-inner" id="wide-tab-inner">
											<!-- 활성화시 actived클래스 추가 -->
											<div class="tab-cell actived"><a href="#" class="btn-tab-item">작업 관리</a></div>
											<div class="tab-cell"><a href="#" class="btn-tab-item">결제 관리</a></div>
										</div>
									</div>


								</div>
							</div>
						</div>			
					</div>
					<div class="data-col-right" id="data_col_right">

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
<script src="../static/js/booking.js"></script>

<script>

    let artist_id = "<?=$artist_id?>";

    data_set(artist_id)

    $(document).ready(function(){

        gnb_init();
        prepend_data('consulting_count nick');
        set_image('front_image');
        wide_tab();
        pay_management_(artist_id)
        gnb_actived('gnb_reserve_wrap','gnb_beauty')




    })




</script>
</body>
</html>