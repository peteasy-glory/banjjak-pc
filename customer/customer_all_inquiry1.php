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
					<div class="data-col-middle wide">
						<div class="basic-data-card">
							<div class="card-header">
								<h3 class="card-header-title">전체 고객 조회</h3>
							</div>
							<div class="card-body" id="customer_scroll_paging">
								<div class="card-body-inner">
									<div class="customer-all-inquiry">
										<div class="basic-data-group">
											<div class="con-title-group">
												<h5 class="con-title"><strong>정렬방식</strong></h5>
												<select class="arrow" id="customer_select" onchange="customer_all(artist_id).then(function(customers){customer_list(artist_id,customers);})">
													<option value="a">최신순</option>
													<option value="b">가나다순</option>
													<option value="c">이용횟수별</option>
													<option value="d">견종별</option>
													<option value="e">등급별</option>
												</select>
											</div>
											<div class="customer-state-graph">
												<div class="new-doughnut-graph">
													<div class="new-doughnutgraph-view">
														<div class="new-doughnutgraph-subject">
															<div class="item-inner">
																<div class="item-name">매출기여도</div>
																<div class="item-cate">서비스별</div>
															</div>
														</div>
														<div class="new-doughnutgraph-data">
															<div id="labelRatio"></div>
														</div>
													</div>
													<div class="new-doughnutgraph-label-group">
														<div class="group-inner">
															<div class="group-cell"><div class="new-doughnutgraph-label"><div class="colors" style="background-color:#8667c1;"></div>미용</div></div>
															<div class="group-cell"><div class="new-doughnutgraph-label"><div class="colors" style="background-color:#fed84e;"></div>호텔</div></div>
															<div class="group-cell"><div class="new-doughnutgraph-label"><div class="colors" style="background-color:#7AE19A;"></div>유치원</div></div>
														</div>
													</div>
												</div>
											</div>
										</div>										
										<div class="basic-data-group large">
											<div class="customer-all-inquiry-result">
												<div class="sort-tab big" style="justify-content: space-between">
													<div class="sort-tab-inner" id="sort_inner">
														<!-- 활성화시 actived클래스 추가 -->
														<div class="tab-cell actived"><a href="#" class="btn-tab-item" style="cursor:default"><strong id="count_people"></strong></a></div>
														<div class="tab-cell"><a href="#" class="btn-tab-item" style="cursor:default"><strong id="count_animal"></strong> </a></div>
													</div>
                                                    <div class="sort-tab big toggle-button-cell">
                                                        <label class="form-toggle-box" style="margin-left:6px;"><input type="radio" name="customer_type" value="beauty" checked><em><span>미용</span></em></label>
<!--                                                        <label class="form-toggle-box" style="margin-left:6px;"><input type="radio" name="customer_type" value="hotel"><em><span>호텔</span></em></label>-->
<!--                                                        <label class="form-toggle-box" style="margin-left:6px;"><input type="radio" name="customer_type" value="kinder"><em><span>유치원</span></em></label>-->

                                                    </div>
												</div>
												<!-- tab-data-cell 클래스에 actived클래스 추가시 활성화 -->
												<div class="tab-data-group">
													<!-- 고객 -->
													<div class="tab-data-cell actived">
														<div>
															<div class="customer-all-inquiry-list">
																<table class="customer-table">
																	<colgroup>
																		<col style="width:11%">
																		<col style="width:15%">
																		<col style="width:14%">
																		<col style="width:14%">
																		<col style="width:8%">
																		<col style="width:8%">
																		<col style="width:7%">
																		<col style="width:13%">
																		<col style="width:10%">
																	</colgroup>
																	<thead>
																		<tr>
																			<th rowspan="2">펫이름/등급</th>
																			<th rowspan="2">견종</th>
																			<th rowspan="2">전화번호/적립금</th>
																			<th colspan="3">최근 이용 내역</th>
																			<th colspan="2">총 이용내역</th>
																			<th rowspan="2">동의서</th>
																		</tr>
																		<tr>
																			<th>일시</th>
																			<th>내역</th>
																			<th>추가</th>
																			<th>건수</th>
																			<th>카드/현금</th>
																		</tr>
																	</thead>
																	<tbody id="tbody">
																		<!-- 하나의 아이템 -->


																	</tbody>
																</table>
															</div>
														</div>
													</div>
													<!-- //고객 -->
													<!-- 동물 -->
													<div class="tab-data-cell">
													</div>
													<!-- //동물 -->
												</div>
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
<article id="reserveAcceptMsg1" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt" id="msg1_txt"></div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="pop.close(); pop.close('reserveCalendarPop11')">확인</button>
                </div>
            </div>
        </div>
    </div>
</article>


<!-- //wrap -->
<script src="../static/js/billboard.js"></script>
<script src="../static/js/billboard.pkgd.js"></script>


<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/customer.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";

    // data_set(artist_id)

    $(document).ready(function(){
        var artist_flag = "<?=$artist_flag?>";
        if(artist_flag == 1){
            $("#gnb_home").css("display","none");
            $("#gnb_shop_wrap").css("display","none");
            $("#gnb_detail_wrap").css("display","none");
            $("#gnb_stats_wrap").css("display","none");
        }

        get_navi(artist_id)
        gnb_init();
        gnb_actived('gnb_customer_wrap','gnb_inquire_all')
        customer_all(artist_id).then(function (customers){

            // customer_graph(customers);
            customer_list(artist_id,customers).then(function(){

                customer_all_agree()
            });

            customer_all_scroll_paging(artist_id)
        })
        customer_count(artist_id)
        customer_select_(artist_id)
        //customer_graph();

    })



</script>
 <script>


    </script>
</body>
</html>