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
								<h3 class="card-header-title">판매 상품 관리</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="product-management">
										<div class="page-tab-group">
											<div class="page-tab">
												<div class="page-tab-inner">
													<!-- 활성화시 actived클래스 추가 -->
													<div class="tab-cell"><a href="#" class="btn-tab-item"><span>미용</span></a></div>
													<div class="tab-cell actived"><a href="#" class="btn-tab-item"><span>호텔</span></a></div>
													<div class="tab-cell"><a href="#" class="btn-tab-item"><span>유치원</span></a></div>
												</div>
											</div>
											<!-- actived클래스 추가시 활성화 -->
											<button type="button" class="btn btn-outline-gray btn-inline btn-surtax-set"><div class="icon"></div>부가세 설정</button>
										</div>		
										<div class="basic-data-group small">											
											<div class="con-title-group">
												<h4 class="con-title">상품구분</h4>
											</div>
											<div class="wide-tab">
												<div class="wide-tab-inner">
													<!-- 활성화시 actived클래스 추가 -->
													<div class="tab-cell actived"><button type="button" class="btn-tab-item">호텔상품</button></div>
													<div class="tab-cell"><button type="button" class="btn-tab-item">매장상품</button></div>
												</div>
											</div>
											<div class="basic-data-group middle">
												<!-- 내용이 없을 경우 -->
												<div class="btn-group vertical text-align-center">
													<div class="btn-group-cell"><button type="button" class="btn btn-purple btn-basic-wide"><strong>호텔상품 등록하기</strong></button></div>
												</div>
												<div class="common-none-data">
													<div class="none-inner">
														<div class="item-visual"><img src="../assets/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
														<div class="item-info">등록된 상품이 없습니다.</div>
													</div>
												</div>
												<!-- //내용이 없을 경우 -->
												<!-- 내용이 있을을 경우 -->
												<div class="wide-tab card inline">
													<div class="wide-tab-inner">
														<!-- 활성화시 actived클래스 추가 -->
														<div class="tab-cell actived"><a href="#" class="btn-tab-item">강아지 호텔</a></div>
														<div class="tab-cell"><a href="#" class="btn-tab-item">고양이 호텔</a></div>
													</div>
												</div>
												<div  class="basic-data-group vvsmall">
													<div class="basic-data-group none">
														<div class="con-title-group large">
															<h6 class="con-title">호텔 요금표</h6>
														</div>
														<div class="read-table">
															<div class="read-table-unit large">(단위:원)</div>
															<table>
																<colgroup>
																	<col style="width:auto;">
																	<col style="width:auto;">
																</colgroup>
																<thead>
																	<tr>
																		<th>무게</th>
																		<th>가격</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td>~5.0kg</td>
																		<td>35</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="basic-data-group large line pt-px-0">
														<div class="con-title-group large">
															<h6 class="con-title">쿠폰(횟수)상품</h6>
														</div>
														<div class="read-table">
															<table>
																<colgroup>
																	<col style="width:auto;">
																	<col style="width:auto;">
																	<col style="width:auto;">
																</colgroup>
																<thead>
																	<tr>
																		<th>상품명</th>
																		<th>이용 횟수</th>
																		<th>가격 (단위:원)</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td>상품명</td>
																		<td>3회</td>
																		<td>20,000</td>
																	</tr>
																	<tr>
																		<td>상품명</td>
																		<td>3회</td>
																		<td>20,000</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
													<div class="basic-data-group large line pt-px-0">
														<div class="con-title-group large">
															<h6 class="con-title">정액 적립 상품</h6>
														</div>
														<div class="read-table">
															<table>
																<colgroup>
																	<col style="width:auto;">
																	<col style="width:auto;">
																	<col style="width:auto;">
																</colgroup>
																<thead>
																	<tr>
																		<th>상품명</th>
																		<th>이용 횟수</th>
																		<th>실 적립금</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td>상품명</td>
																		<td>3회</td>
																		<td>20,000</td>
																	</tr>
																	<tr>
																		<td>상품명</td>
																		<td>3회</td>
																		<td>20,000</td>
																	</tr>
																</tbody>
															</table>
														</div>
														<div class="form-bottom-info">- 중성화 안된 경우 추가요금 :$$,$$$원<br>- 픽업서비스를 제공 안함<br>- 체크인/아웃 시간:오전 09:00 ~ 오후 06:00<br>(이 시간 외 체크인/아웃은 추가요금 발생할 수 있음)</div>
													</div>
													<div class="basic-data-group vmiddle">
														<div class="memo-item large">
															<div class="memo-item-title">추가 설명</div>
															<div class="memo-item-txt">프론트 샵페이지 상품하단에 위치하는 안내입니다.</div>
														</div>
													</div>
													<div class="btn-basic-action">
														<div class="grid-layout btn-grid-group">
															<div class="grid-layout-inner justify-content-end">
																<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-purple btn-small-size btn-basic-small">수정</button></div>
																<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small">삭제</button></div>
															</div>
														</div>																
													</div>	
												</div>
												<!-- //내용이 있을을 경우 -->
											</div>
										</div>
										<div class="basic-data-group">										
											<div class="con-title-group">
												<h4 class="con-title">안내사항</h4>
											</div>
											<div class="form-group">
												<div class="form-group-item">
													<div class="form-item-label">추가설명</div>
													<div class="form-item-data type-2">
														<textarea style="height:100px;" placeholder="입력"></textarea>
														<div class="form-input-info">0/1000</div>
													</div>
												</div>
											</div>
											<div class="btn-basic-action">
												<div class="grid-layout btn-grid-group">
													<div class="grid-layout-inner justify-content-end">
														<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-purple btn-small-size btn-basic-small">수정</button></div>
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
        gnb_actived('gnb_detail_wrap', 'gnb_merchandise');
    })
</script>
</body>
</html>