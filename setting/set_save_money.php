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
								<h3 class="card-header-title">적립금 설정</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="set-save-money">
										<div class="basic-data-group">
											<div class="con-title-group">
												<h4 class="con-title">기본 적립율 설정</h4>
											</div>
											<div class="form-group">
												<div class="grid-layout margin-14-17">
													<div class="grid-layout-inner">
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label">결제액의</div>
																<div class="form-item-data type-2">
																	<select class="percent">
                                                                        <option value="0">0%</option>
                                                                        <option value="0.1">0.1%</option>
                                                                        <option value="0.2">0.2%</option>
                                                                        <option value="0.3">0.3%</option>
                                                                        <option value="0.4">0.4%</option>
                                                                        <option value="0.5">0.5%</option>
                                                                        <option value="0.6">0.6%</option>
                                                                        <option value="0.7">0.7%</option>
                                                                        <option value="0.8">0.8%</option>
                                                                        <option value="0.9">0.9%</option>
                                                                        <option value="1">1%</option>
                                                                        <option value="1.1">1.1%</option>
                                                                        <option value="1.2">1.2%</option>
                                                                        <option value="1.3">1.3%</option>
                                                                        <option value="1.4">1.4%</option>
                                                                        <option value="1.5">1.5%</option>
                                                                        <option value="1.6">1.6%</option>
                                                                        <option value="1.7">1.7%</option>
                                                                        <option value="1.8">1.8%</option>
                                                                        <option value="1.9">1.9%</option>
                                                                        <option value="2">2%</option>
                                                                        <option value="2.1">2.1%</option>
                                                                        <option value="2.2">2.2%</option>
                                                                        <option value="2.3">2.3%</option>
                                                                        <option value="2.4">2.4%</option>
                                                                        <option value="2.5">2.5%</option>
                                                                        <option value="2.6">2.6%</option>
                                                                        <option value="2.7">2.7%</option>
                                                                        <option value="2.8">2.8%</option>
                                                                        <option value="2.9">2.9%</option>
                                                                        <option value="3">3%</option>
                                                                        <option value="3.1">3.1%</option>
                                                                        <option value="3.2">3.2%</option>
                                                                        <option value="3.3">3.3%</option>
                                                                        <option value="3.4">3.4%</option>
                                                                        <option value="3.5">3.5%</option>
                                                                        <option value="3.6">3.6%</option>
                                                                        <option value="3.7">3.7%</option>
                                                                        <option value="3.8">3.8%</option>
                                                                        <option value="3.9">3.9%</option>
                                                                        <option value="4">4%</option>
                                                                        <option value="4.1">4.1%</option>
                                                                        <option value="4.2">4.2%</option>
                                                                        <option value="4.3">4.3%</option>
                                                                        <option value="4.4">4.4%</option>
                                                                        <option value="4.5">4.5%</option>
                                                                        <option value="4.6">4.6%</option>
                                                                        <option value="4.7">4.7%</option>
                                                                        <option value="4.8">4.8%</option>
                                                                        <option value="4.9">4.9%</option>
                                                                        <option value="5">5%</option>
                                                                        <option value="5.1">5.1%</option>
                                                                        <option value="5.2">5.2%</option>
                                                                        <option value="5.3">5.3%</option>
                                                                        <option value="5.4">5.4%</option>
                                                                        <option value="5.5">5.5%</option>
                                                                        <option value="5.6">5.6%</option>
                                                                        <option value="5.7">5.7%</option>
                                                                        <option value="5.8">5.8%</option>
                                                                        <option value="5.9">5.9%</option>
                                                                        <option value="6">6%</option>
                                                                        <option value="6.1">6.1%</option>
                                                                        <option value="6.2">6.2%</option>
                                                                        <option value="6.3">6.3%</option>
                                                                        <option value="6.4">6.4%</option>
                                                                        <option value="6.5">6.5%</option>
                                                                        <option value="6.6">6.6%</option>
                                                                        <option value="6.7">6.7%</option>
                                                                        <option value="6.8">6.8%</option>
                                                                        <option value="6.9">6.9%</option>
                                                                        <option value="7">7%</option>
                                                                        <option value="7.1">7.1%</option>
                                                                        <option value="7.2">7.2%</option>
                                                                        <option value="7.3">7.3%</option>
                                                                        <option value="7.4">7.4%</option>
                                                                        <option value="7.5">7.5%</option>
                                                                        <option value="7.6">7.6%</option>
                                                                        <option value="7.7">7.7%</option>
                                                                        <option value="7.8">7.8%</option>
                                                                        <option value="7.9">7.9%</option>
                                                                        <option value="8">8%</option>
                                                                        <option value="8.1">8.1%</option>
                                                                        <option value="8.2">8.2%</option>
                                                                        <option value="8.3">8.3%</option>
                                                                        <option value="8.4">8.4%</option>
                                                                        <option value="8.5">8.5%</option>
                                                                        <option value="8.6">8.6%</option>
                                                                        <option value="8.7">8.7%</option>
                                                                        <option value="8.8">8.8%</option>
                                                                        <option value="8.9">8.9%</option>
                                                                        <option value="9">9%</option>
                                                                        <option value="9.1">9.1%</option>
                                                                        <option value="9.2">9.2%</option>
                                                                        <option value="9.3">9.3%</option>
                                                                        <option value="9.4">9.4%</option>
                                                                        <option value="9.5">9.5%</option>
                                                                        <option value="9.6">9.6%</option>
                                                                        <option value="9.7">9.7%</option>
                                                                        <option value="9.8">9.8%</option>
                                                                        <option value="9.9">9.9%</option>
                                                                        <option value="10">10%</option>
                                                                        <option value="10">10%</option>
                                                                        <option value="10.5">10.5%</option>
                                                                        <option value="11">11%</option>
                                                                        <option value="11.5">11.5%</option>
                                                                        <option value="12">12%</option>
                                                                        <option value="12.5">12.5%</option>
                                                                        <option value="13">13%</option>
                                                                        <option value="13.5">13.5%</option>
                                                                        <option value="14">14%</option>
                                                                        <option value="14.5">14.5%</option>
                                                                        <option value="15">15%</option>
                                                                        <option value="15.5">15.5%</option>
                                                                        <option value="16">16%</option>
                                                                        <option value="16.5">16.5%</option>
                                                                        <option value="17">17%</option>
                                                                        <option value="17.5">17.5%</option>
                                                                        <option value="18">18%</option>
                                                                        <option value="18.5">18.5%</option>
                                                                        <option value="19">19%</option>
                                                                        <option value="19.5">19.5%</option>
                                                                        <option value="20">20%</option>
																	</select>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="basic-data-group">
											<div class="con-title-group">
												<h4 class="con-title">최소 사용금액 설정</h4>
											</div>											
											<div class="form-group">
												<div class="grid-layout margin-14-17">
													<div class="grid-layout-inner">
														<div class="grid-layout-cell grid-1">
															<div class="form-mulity-input">
																<div class="input-txt font-weight-300">누적된 적립금</div>
																<select class="min_pay">
                                                                    <option value="0">0</option>
                                                                    <option value="500">500</option>
                                                                    <option value="1000">1,000</option>
                                                                    <option value="1500">1,500</option>
                                                                    <option value="2000">2,000</option>
                                                                    <option value="2500">2,500</option>
                                                                    <option value="3000">3,000</option>
                                                                    <option value="3500">3,500</option>
                                                                    <option value="4000">4,000</option>
                                                                    <option value="4500">4,500</option>
                                                                    <option value="5000">5,000</option>
																</select>
																<div class="input-txt font-weight-300">원 이하라면 사용할 수 없도록 설정합니다.</div>
															</div>
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
								<a href="#" class="btn-page-bottom save_reserve">저장하기</a>
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
        get_pay_reserve(artist_id);
        $(".percent").val(setting_array[0].percent);
        $(".min_pay").val(setting_array[0].min_reserve);
    })

    $(document).on("click",".save_reserve", function(){
        var percent = $(".percent").val();
        var min_pay = $(".min_pay").val();
        var is_use = (percent == 0 && min_pay == 0)? 2 : 1;
        put_pay_reserve(artist_id, is_use, percent, min_pay);
    })
</script>
</body>
</html>