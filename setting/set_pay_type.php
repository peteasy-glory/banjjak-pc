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
								<h3 class="card-header-title">매장결제방식 관리</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="set-pay-type pay_type_wrap">
										<div class="set-pay-type-item">
											<div class="item-info-wrap">
												<div class="item-title">매장결제</div>
												<div class="item-info">매장결제방식을 원치 않으시면, OFF로 변경해주세요.</div>
											</div>
											<div class="item-check"><label class="form-switch-toggle"><input type="checkbox" class="pay_type pay_shop" value="2"><span class="bar"></span></label></div>
										</div>		
										<div class="set-pay-type-item">
											<div class="item-info-wrap">
												<div class="item-title">지금결제</div>
												<div class="item-info">지금결제방식을 원치 않으시면, OFF로 변경해주세요.</div>
												<div class="item-info font-color-red">*지금결제를 비활성화하면 견주 대상 이벤트 진행 시 참여가 불가할 수 있습니다.</div>
											</div>
											<div class="item-check"><label class="form-switch-toggle"><input type="checkbox" class="pay_type pay_now" value="0"><span class="bar"></span></label></div>
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
<script src="../static/js/setting.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        gnb_actived('gnb_detail_wrap','gnb_payment');
        get_pay_type(artist_id);
    })

    $(document).on("click",".pay_type",function(){
        var pay_shop = $(".pay_shop").is(":checked");
        var pay_now = $(".pay_now").is(":checked");

        var pay_type = -1;
        if(pay_shop == false && pay_now == false) {
            pop.open('firstRequestMsg1', "매장결제 또는 지금결제 중 한 가지는 필수적으로 선택해야 합니다.");
            $(this).prop("checked", true);
            return false;
        }else if(pay_shop == true && pay_now == true){
            pay_type = 1;
        }else if(pay_shop == true && pay_now == false){
            pay_type = 2;
        }else if(pay_shop == false && pay_now == true){
            pay_type = 0;
        }
        put_pay_type(artist_id, pay_type);
    })
</script>
</body>
</html>