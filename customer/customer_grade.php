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
								<h3 class="card-header-title">회원 등급 설정</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="customer-grade-wrap">
										<h4 class="con-title">등급 명칭을 설정할 수 있어요</h4>
										<div class="customer-grade-card-group">
											<div class="customer-grade-card">
												<div class="card-header">
													<div class="user-grade-item">
														<div class="icon icon-grade-vip"></div>
														<div class="icon-grade-label">VIP</div>
													</div>
												</div>
												<div class="card-body">
													<div class="customer-grade-title">등급명</div>
													<div class="customer-grade-value"><input type="text" class="form-control grade-input" id="grade1" value=""></div>
													<div class="customer-grade-info">*믿을만한 우수고객으로 비어있는 시간에 앱예약을 할 수 있습니다. VIP고객이 많을 수록 예약관리가 편리해지며 빈시간 직접판매 등 다양한 마케팅 활용이 가능합니다.</div>
												</div>
											</div>
											<div class="customer-grade-card">
												<div class="card-header">
													<div class="user-grade-item">
														<div class="icon icon-grade-normal"></div>
														<div class="icon-grade-label">Normal</div>
													</div>
												</div>
												<div class="card-body">
													<div class="customer-grade-title">등급명</div>
													<div class="customer-grade-value"><input type="text" class="form-control grade-input" id="grade2" value=""></div>
													<div class="customer-grade-info">*샵에서 컨펌을 해야 견주의 앱예약이 확정됩니다. </div>
												</div>
											</div>
											<div class="customer-grade-card">
												<div class="card-header">
													<div class="user-grade-item">
														<div class="icon icon-grade-normalb"></div>
														<div class="icon-grade-label">Normal_B</div>
													</div>
												</div>
												<div class="card-body">
													<div class="customer-grade-title">등급명</div>
													<div class="customer-grade-value"><input type="text" class="form-control grade-input" id="grade3" value=""></div>
													<div class="customer-grade-info">*샵에서 컨펌을 해야 견주의 앱예약이 확정됩니다. 주의를 요하는 고객의 경우 이 등급으로 분류하여 구분하시면 편리합니다.</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>							
							<div class="card-footer">
								<!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
								<a href="#" class="btn-page-bottom" onclick="post_grade(); pop.open('reserveAcceptMsg1');">저장</a>
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

<article id="reserveAcceptMsg1" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt" id="msg1_txt">변경되었습니다.</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="location.reload()">확인</button>
                </div>
            </div>
        </div>
    </div>
</article>

<!-- //wrap -->
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/customer.js"></script>

<script>

    let artist_id = "<?=$artist_id?>";
    data_set(artist_id)

    $(document).ready(function(){

        gnb_init();
        set_image('front_image');
        prepend_data('consulting_count nick');
        gnb_actived('gnb_customer_wrap','gnb_grade');
        get_grade(artist_id)

    })



</script>
</body>
</html>