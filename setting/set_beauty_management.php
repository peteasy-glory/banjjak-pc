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
													<div class="tab-cell actived"><a href="#" class="btn-tab-item"><span>미용</span></a></div>
													<div class="tab-cell"><a href="javascript:pop.open('firstRequestMsg1','준비중입니다.');" class="btn-tab-item"><span>호텔</span></a></div>
													<div class="tab-cell"><a href="javascript:pop.open('firstRequestMsg1','준비중입니다.');" class="btn-tab-item"><span>유치원</span></a></div>
												</div>
											</div>
											<!-- actived클래스 추가시 활성화 -->
											<button type="button" class="btn btn-outline-gray btn-inline btn-surtax-set" onclick="pop.open('surtaxSet')"><div class="icon"></div>부가세 설정</button>
										</div>		
										<div class="basic-data-group small>
											<div class="con-title-group">
												<h4 class="con-title">상품구분</h4>
											</div>
											<div class="wide-tab">
												<div class="wide-tab-inner">
													<!-- 활성화시 actived클래스 추가 -->
													<div class="tab-cell product_tab beauty_product_tap actived"><button type="button" class="btn-tab-item">미용상품</button></div>
													<div class="tab-cell product_tab option_product_tap"><button type="button" class="btn-tab-item">미용 추가옵션</button></div>
													<div class="tab-cell product_tab beauty_coupon_tap"><button type="button" class="btn-tab-item">쿠폰상품</button></div>
													<div class="tab-cell product_tab etc_product_tap"><button type="button" class="btn-tab-item">매장상품</button></div>
												</div>
											</div>
											<div class="basic-data-group middle all_product_wrap beauty_product_wrap">
												<div class="btn-group vertical text-align-center">
													<div class="btn-group-cell"><button type="button" class="btn btn-purple btn-basic-wide"><strong>강아지 미용상품 추가하기</strong></button></div>
													<div class="btn-group-cell" style="display: none;"><button type="button" class="btn btn-outline-purple btn-basic-wide"><strong>미용 소요시간 설정하기</strong></button></div>
												</div>
												<!-- 내용이 있을을 경우 -->
												<div class="basic-data-group">												
													<div class="con-title-group">
														<h4 class="con-title">강아지</h4>
													</div>
													<div>
														<div class="basic-data-group append_dog_service_wrap">
															<div class="con-title-group large">
																<h6 class="con-title">미용별 소요시간</h6>
															</div>
															<div class="read-table">
																<div class="read-table-unit large">(단위:분)</div>
																<table class="beauty_time_wrap">
																	<colgroup>
																		<col style="width:auto;">
																		<col style="width:auto;">
																		<col style="width:auto;">
																		<col style="width:auto;">
																		<col style="width:auto;">
																		<col style="width:auto;">
																		<col style="width:auto;">
																	</colgroup>
																	<thead>
																		<tr>
																			<th>목욕</th>
																			<th>부분 미용</th>
																			<th>부분 목욕</th>
																			<th>전체 미용</th>
																			<th>스포팅</th>
																			<th>가위컷</th>
																			<th>썸머컷</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td>0</td>
																			<td>0</td>
																			<td>0</td>
																			<td>0</td>
																			<td>0</td>
																			<td>0</td>
																			<td>0</td>
																		</tr>
																	</tbody>
																</table>
															</div>
															<div class="btn-basic-action">
																<div class="grid-layout btn-grid-group">
																	<div class="grid-layout-inner justify-content-end">
																		<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-purple btn-small-size btn-basic-small">수정</button></div>
																	</div>
																</div>																
															</div>
														</div>
                                                        <!--
                                                         강아지 미용상품 가격
                                                         -->
													</div>
												</div>
												<div class="basic-data-group line total_cat_wrap" style="display: none;">
													<div class="con-title-group">
														<h4 class="con-title">고양이</h4>
													</div>
													<div>
														<div class="basic-data-group">				
															<div class="basic-data-group">
																<div class="basic-data-group">
																	<div class="grid-layout margin-14-17">
																		<div class="grid-layout-inner">
																			<div class="grid-layout-cell grid-1">
																				<div class="con-title-group large">
																					<h6 class="con-title">미용<div class="label label-outline-purple vmiddle round cat_product_type">출장/매장</div></h6>
																				</div>																				
																				<div class="read-table">
																					<div class="read-table-unit large">(단위:원)</div>
																					<table class="cat_beauty_price_wrap">
																						<colgroup>
																							<col style="width:16.66%;">
																							<col style="width:auto;">
																							<col style="width:auto;">
																						</colgroup>
																						<thead>
																							<tr>
																								<th>무게</th>
																								<th>단모</th>
																								<th>장모</th>
																							</tr>
																						</thead>
																						<tbody>
																							<tr>
																								<td>~3kg</td>
																								<td>20,000</td>
																								<td>상담</td>
																							</tr>
																							<tr>
																								<td>~5kg</td>
																								<td>20,000</td>
																								<td>15,000</td>
																							</tr>
																							<tr>
																								<td>5kg~</td>
																								<td colspan="2">Kg당 5,000원 추가</td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
																			</div>
																			<div class="grid-layout-cell grid-2 shower_wrap">
																				<div class="con-title-group large">
																					<h6 class="con-title">목욕<div class="label label-outline-purple vmiddle round cat_product_type">매장상품</div></h6>
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
																								<th>상품명</th>
																								<th>가격</th>
																							</tr>
																						</thead>
																						<tbody>
																							<tr>
																								<td>단모</td>
																								<td class="shower_price">5,000</td>
																							</tr>
																							<tr>
																								<td>장모</td>
																								<td class="shower_price_long">5,000</td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
																			</div>
																			<div class="grid-layout-cell grid-2">
																				<div class="con-title-group large">
																					<h6 class="con-title">현장 판단 후 결제 추가 기능 옵션<div class="label label-outline-purple vmiddle round cat_product_type">매장상품</div></h6>
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
																								<th>상품명</th>
																								<th>가격</th>
																							</tr>
																						</thead>
																						<tbody class="shop_option_append_wrap">
																							<tr class="hair_clot_wrap">
																								<td>털엉킴</td>
																								<td class="hair_clot_price">20,000</td>
																							</tr>
																							<tr class="ferocity_wrap">
																								<td>사나움</td>
																								<td class="ferocity_price">20,000</td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
																			</div>
																			<div class="grid-layout-cell grid-2">
																				<div class="con-title-group large">
																					<h6 class="con-title">추가요금<div class="label label-outline-purple vmiddle round cat_product_type">매장상품</div></h6>
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
																								<th>상품명</th>
																								<th>가격</th>
																							</tr>
																						</thead>
																						<tbody class="option_append_wrap">
																							<tr class="toenail_wrap">
																								<td>발톱</td>
																								<td class="toenail_price">5,000</td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="basic-data-group large">
																<div class="memo-item large">
																	<div class="memo-item-title">상품별 안내사항</div>
																	<div class="memo-item-txt cat_comment">프론트 샵페이지 상품하단에 위치하는 안내입니다.</div>
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
													</div>
												</div>
                                                <div class="btn-group vertical text-align-center cat_none_wrap">
                                                    <br>
                                                    <div class="btn-group-cell"><button type="button" class="btn btn-purple btn-basic-wide"><strong>고양이 미용상품 추가하기</strong></button></div>
                                                </div>
                                                <!-- 내용이 없을 경우 -->
                                                <div class="common-none-data cat_none_wrap">
                                                    <div class="none-inner">
                                                        <div class="item-visual"><img src="../static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
                                                        <div class="item-info">등록된 상품이 없습니다.</div>
                                                    </div>
                                                </div>
                                                <!-- //내용이 없을 경우 -->
												<div class="basic-data-group">			
													<div class="form-group-item">
														<div class="form-item-label">추가설명</div>
														<div class="form-item-data type-2">
															<textarea style="height:100px;" class="etc_comment" placeholder="입력"></textarea>
															<div class="form-input-info">0/1000</div>
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
												<!-- //내용이 있을을 경우 -->
											</div>
                                            <div class="basic-data-group middle all_product_wrap option_product_wrap" style="display: none;">
                                                <div class="btn-group vertical text-align-center">
                                                    <div class="btn-group-cell"><button type="button" class="btn btn-purple btn-basic-wide"><strong>미용 추가옵션 추가하기</strong></button></div>
                                                </div>
                                                <!-- 내용이 없을 경우 -->
                                                <div class="common-none-data no_option_product">
                                                    <div class="none-inner">
                                                        <div class="item-visual"><img src="../static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
                                                        <div class="item-info">등록된 상품이 없습니다.<br><span>*쿠폰/제품 탭의 등록 상품은 견주 예약과정에 나타나지 않습니다.<br>*매장판매 상품등록/관리에 활용하시면 좋습니다.</span></div>
                                                    </div>
                                                </div>
                                                <!-- //내용이 없을 경우 -->
                                                <!-- 내용이 있을을 경우 -->
                                                <div class="basic-data-group do_option_product" style="display: none;">
                                                    <div class="con-title-group">
                                                        <h4 class="con-title">강아지</h4>
                                                    </div>
                                                    <div class="grid-layout margin-14-17">
                                                        <div class="grid-layout-inner">
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">얼굴 디자인컷 추가<div class="label label-outline-purple vmiddle round option_type">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때-->
                                                                <div class="list-none-data type-2 no_face" style="display: none;">등록된 상품이 없습니다.</div>
                                                                <!--내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
                                                                <div class="read-table do_face">
                                                                    <div class="read-table-unit large">(단위:원)</div>
                                                                    <table class="face_wrap">
                                                                    </table>
                                                                </div>
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">미용털길이 조절 추가<div class="label label-outline-purple vmiddle round option_type">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때 -->
                                                                <div class="list-none-data type-2 no_hair_len" style="display: none;">등록된 상품이 없습니다.</div>
                                                                <!-- 내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
                                                                <div class="read-table do_hair_len">
                                                                    <div class="read-table-unit large">(단위:원)</div>
                                                                    <table class="hair_len_wrap">
                                                                    </table>
                                                                </div>
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">털 특징 별 추가요금<div class="label label-outline-purple vmiddle round option_type">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때 -->
                                                                <div class="list-none-data type-2 no_plus" style="display: none;">등록된 상품이 없습니다.</div>
                                                                <!--내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
                                                                <div class="read-table do_plus">
                                                                    <div class="read-table-unit large">(단위:원)</div>
                                                                    <table class="plus_wrap">
                                                                    </table>
                                                                </div>
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">현장 판단 후 결제 추가 기능 옵션<div class="label label-outline-purple vmiddle round option_type">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때 -->
                                                                <div class="list-none-data type-2 no_place_plus" style="display: none;">등록된 상품이 없습니다.</div>
                                                                <!--내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
                                                                <div class="read-table do_place_plus">
                                                                    <div class="read-table-unit large">(단위:원)</div>
                                                                    <table class="place_plus_wrap">
                                                                    </table>
                                                                </div>
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">다리<div class="label label-outline-purple vmiddle round option_type">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때 -->
                                                                <div class="list-none-data type-2 no_leg" style="display: none;">등록된 상품이 없습니다.</div>
                                                                <!--내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
                                                                <div class="read-table do_leg">
                                                                    <div class="read-table-unit large">(단위:원)</div>
                                                                    <table class="leg_wrap">
                                                                    </table>
                                                                </div>
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">스파<div class="label label-outline-purple vmiddle round option_type">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때 -->
                                                                <div class="list-none-data type-2 no_spa" style="display: none;">등록된 상품이 없습니다.</div>
                                                                <!--내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
                                                                <div class="read-table do_spa">
                                                                    <div class="read-table-unit large">(단위:원)</div>
                                                                    <table class="spa_wrap">
                                                                    </table>
                                                                </div>
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">염색<div class="label label-outline-purple vmiddle round option_type">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때 -->
                                                                <div class="list-none-data type-2 no_dyeing" style="display: none;">등록된 상품이 없습니다.</div>
                                                                <!-- //내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
                                                                <div class="read-table do_dyeing">
                                                                    <div class="read-table-unit large">(단위:원)</div>
                                                                    <table class="dyeing_wrap">
                                                                    </table>
                                                                </div>
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">기타<div class="label label-outline-purple vmiddle round option_type">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때 -->
                                                                <div class="list-none-data type-2 no_etc_etc" style="display: none;">등록된 상품이 없습니다.</div>
                                                                <!--내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
                                                                <div class="read-table do_etc_etc">
                                                                    <div class="read-table-unit large">(단위:원)</div>
                                                                    <table class="etc_etc_wrap">
                                                                    </table>
                                                                </div>
                                                                <!--<div class="form-bottom-info">*기타 탭의 상품은 견주예약과정에서 보이지 않습니다.<br>*추가되는 비용(다듬기 정도, 사나움 정도, 등)을 등록하여 예약관리에 활용하시면 좋습니다.</div>-->
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="basic-data-group">
                                                        <div class="memo-item large">
                                                            <div class="memo-item-title">상품별 안내사항</div>
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
                                            <div class="basic-data-group middle all_product_wrap beauty_coupon_wrap" style="display: none;">
                                                <div class="btn-group vertical text-align-center">
                                                    <div class="btn-group-cell"><button type="button" class="btn btn-purple btn-basic-wide"><strong>쿠폰상품 추가하기</strong></button></div>
                                                </div>
                                                <!-- 내용이 없을 경우 -->
                                                <div class="common-none-data no_coupon">
                                                    <div class="none-inner">
                                                        <div class="item-visual"><img src="../static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
                                                        <div class="item-info">등록된 상품이 없습니다.<br><span>*쿠폰/제품 탭의 등록 상품은 견주 예약과정에 나타나지 않습니다.</span></div>
                                                    </div>
                                                </div>
                                                <!-- //내용이 없을 경우 -->
                                                <!-- 내용이 있을을 경우 -->
                                                <div class="basic-data-group do_coupon" style="display: none;">
                                                    <div class="con-title-group">
                                                        <h4 class="con-title">쿠폰 &amp; 적립상품</h4>
                                                    </div>
                                                    <div>
                                                        <div class="basic-data-group none">
                                                            <div class="con-title-group large">
                                                                <h6 class="con-title">쿠폰(횟수)상품</h6>
                                                            </div>
                                                            <div class="read-table">
                                                                <table class="coupon_c_wrap">
                                                                    <colgroup>
                                                                        <col style="width:auto;">
                                                                        <col style="width:auto;">
                                                                        <col style="width:auto;">
                                                                    </colgroup>
                                                                    <thead>
                                                                    <tr>
                                                                        <th>상품명</th>
                                                                        <th>이용 횟수</th>
                                                                        <th>가격(단위:원)</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>월목욕 소형견</td>
                                                                        <td>3회</td>
                                                                        <td>20,000</td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="basic-data-group large">
                                                                <div class="memo-item large">
                                                                    <div class="memo-item-title">상품별 안내사항</div>
                                                                    <div class="memo-item-txt coupon_c_memo"></div>
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
                                                        <div class="basic-data-group none">
                                                            <div class="con-title-group large">
                                                                <h6 class="con-title">정액 적립 요금 상품</h6>
                                                            </div>
                                                            <div class="read-table">
                                                                <table class="coupon_f_wrap">
                                                                    <colgroup>
                                                                        <col style="width:auto;">
                                                                        <col style="width:auto;">
                                                                        <col style="width:auto;">
                                                                    </colgroup>
                                                                    <thead>
                                                                    <tr>
                                                                        <th>상품명</th>
                                                                        <th>실 적립금</th>
                                                                        <th>가격(단위:원)</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>미용정액권</td>
                                                                        <td>20,000</td>
                                                                        <td>20,000</td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="basic-data-group large">
                                                                <div class="memo-item large">
                                                                    <div class="memo-item-title">상품별 안내사항</div>
                                                                    <div class="memo-item-txt coupon_f_memo"></div>
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
                                                <!-- //내용이 있을을 경우 -->
                                            </div>
                                            <div class="basic-data-group middle all_product_wrap etc_product_wrap" style="display: none;">
                                                <div class="btn-group vertical text-align-center">
                                                    <div class="btn-group-cell"><button type="button" class="btn btn-purple btn-basic-wide"><strong>판매상품 추가하기</strong></button></div>
                                                </div>
                                                <!-- 내용이 없을 경우 -->
                                                <div class="common-none-data no_shop_etc">
                                                    <div class="none-inner">
<!--                                                        <div class="item-visual"><img src="../static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>-->
                                                    </div>
                                                </div>
                                                <!-- //내용이 없을 경우 -->
                                                <!-- 내용이 있을을 경우 -->
                                                <div class="wide-tab card">
                                                    <div class="wide-tab-inner">
                                                        <!-- 활성화시 actived클래스 추가 -->
                                                        <div class="tab-cell shop_etc_tab shop_etc_merchandise_tab actived"><p class="btn-tab-item">용품</p></div>
                                                        <div class="tab-cell shop_etc_tab shop_etc_snack_tab"><p class="btn-tab-item">간식</p></div>
                                                        <div class="tab-cell shop_etc_tab shop_etc_feed_tab"><p class="btn-tab-item">사료</p></div>
                                                        <div class="tab-cell shop_etc_tab shop_etc_etc_tab"><p class="btn-tab-item">기타</p></div>
                                                    </div>
                                                </div>
                                                <div class="shop_etc_wrap shop_etc_merchandise">
                                                    <div class="list-none-data type-2 no_shop_etc_merchandise">등록된 상품이 없습니다.</div>
                                                    <div class="do_shop_etc_merchandise" style="display: none;">
                                                        <div class="basic-data-group">
                                                            <div class="con-title-group large">
                                                                <h6 class="con-title">용품</h6>
                                                            </div>
                                                            <div class="read-table">
                                                                <div class="read-table-unit large">(단위:원)</div>
                                                                <table class="shop_etc_merchandise_wrap">
                                                                    <colgroup>
                                                                        <col style="width:auto;">
                                                                        <col style="width:auto;">
                                                                    </colgroup>
                                                                    <thead>
                                                                        <tr>
                                                                            <th>상품명</th>
                                                                            <th>가격</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>상품명</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>상품명</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
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
                                                <div class="shop_etc_wrap shop_etc_snack" style="display: none;">
                                                    <div class="list-none-data type-2 no_shop_etc_snack">등록된 상품이 없습니다.</div>
                                                    <div class="do_shop_etc_snack" style="display: none;">
                                                        <div class="basic-data-group">
                                                            <div class="con-title-group large">
                                                                <h6 class="con-title">간식</h6>
                                                            </div>
                                                            <div class="read-table">
                                                                <div class="read-table-unit large">(단위:원)</div>
                                                                <table class="shop_etc_snack_wrap">
                                                                    <colgroup>
                                                                        <col style="width:auto;">
                                                                        <col style="width:auto;">
                                                                    </colgroup>
                                                                    <thead>
                                                                    <tr>
                                                                        <th>상품명</th>
                                                                        <th>가격</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>상품명</td>
                                                                        <td>20,000</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>상품명</td>
                                                                        <td>20,000</td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
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
                                                <div class="shop_etc_wrap shop_etc_feed" style="display: none;">
                                                    <div class="list-none-data type-2 no_shop_etc_feed">등록된 상품이 없습니다.</div>
                                                    <div class="do_shop_etc_feed" style="display: none;">
                                                        <div class="basic-data-group">
                                                            <div class="con-title-group large">
                                                                <h6 class="con-title">사료</h6>
                                                            </div>
                                                            <div class="read-table">
                                                                <div class="read-table-unit large">(단위:원)</div>
                                                                <table class="shop_etc_feed_wrap">
                                                                    <colgroup>
                                                                        <col style="width:auto;">
                                                                        <col style="width:auto;">
                                                                    </colgroup>
                                                                    <thead>
                                                                    <tr>
                                                                        <th>상품명</th>
                                                                        <th>가격</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>상품명</td>
                                                                        <td>20,000</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>상품명</td>
                                                                        <td>20,000</td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
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
                                                <div class="shop_etc_wrap shop_etc_etc" style="display: none;">
                                                    <div class="list-none-data type-2 no_shop_etc_etc">등록된 상품이 없습니다.</div>
                                                    <div class="do_shop_etc_etc" style="display: none;">
                                                        <div class="basic-data-group">
                                                            <div class="con-title-group large">
                                                                <h6 class="con-title">기타</h6>
                                                            </div>
                                                            <div class="read-table">
                                                                <div class="read-table-unit large">(단위:원)</div>
                                                                <table class="shop_etc_etc_wrap">
                                                                    <colgroup>
                                                                        <col style="width:auto;">
                                                                        <col style="width:auto;">
                                                                    </colgroup>
                                                                    <thead>
                                                                    <tr>
                                                                        <th>상품명</th>
                                                                        <th>가격</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>상품명</td>
                                                                        <td>20,000</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>상품명</td>
                                                                        <td>20,000</td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
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
                                                <!-- //내용이 있을을 경우 -->
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

        <!--  부가세설정 -->
        <article id="surtaxSet" class="layer-pop-wrap">
            <div class="layer-pop-parent">
                <div class="layer-pop-children">
                    <div class="pop-data alert-pop-data">
                        <div class="pop-header">
                            <h4 class="con-title">부가세 설정</h4>
                        </div>
                        <div class="pop-body type-3">
                            <div class="dot-text-list text-align-left purple">
                                <div class="list-cell">고객에게 보여지는 가격에 부가세10%를 추가로 받으시는 분은 하단에 있는[부가세 10%추가]버튼을 눌러주세요.<br>(예: 전체미용 가격표 표기 10,000원, 고객이 실제 지불하는 금액 11,000원)</div>
                            </div>
                            <div class="basic-data-group vvsmall3">
                                <div class="memo-item type-2">
                                    <div class="flex align-items-center justify-content-space-between">
                                        <div>부가세 10% 추가</div>
                                        <div><label for="switch-toggle" class="form-switch-toggle"><input type="checkbox" id="switch-toggle" checked><span class="bar"></span></label></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pop-footer">
                            <button type="button" class="btn btn-confirm" onclick="pop.close();">확인</button>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <!-- //부가세설정 -->
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
        gnb_actived('gnb_detail_wrap','gnb_merchandise');
        get_beauty_product(artist_id);
        get_option_product(artist_id);
        get_beauty_coupon(artist_id);
        get_etc_product(artist_id);
        console.log(setting_array);

        // 메인 상품 뿌려주기
        view_beauty_product();

        // 강아지 추가옵션 뿌려주기
        view_option_product();

        // 쿠폰상품 뿌려주기
        view_beauty_coupon();

        // 매장상품 뿌려주기
        view_etc_product();

    });


    // 상품구분 탭 클릭
    $(document).on("click",".product_tab",function(){
        $(".product_tab").removeClass("actived");
        $(this).addClass("actived");
        $(".all_product_wrap").css("display","none");

        if($(this).hasClass('beauty_product_tap')){
            $(".beauty_product_wrap").css("display","block");
        }else if($(this).hasClass('option_product_tap')){
            $(".option_product_wrap").css("display","block");
        }else if($(this).hasClass('beauty_coupon_tap')){
            $(".beauty_coupon_wrap").css("display","block");
        }else if($(this).hasClass('etc_product_tap')){
            $(".etc_product_wrap").css("display","block");
        }
    })

    // 매장상품 탭 클릭
    $(document).on("click",".shop_etc_tab",function(){
        $(".shop_etc_tab").removeClass("actived");
        $(this).addClass("actived");
        $(".shop_etc_wrap").css("display","none");

        if($(this).hasClass('shop_etc_merchandise_tab')){
            $(".shop_etc_merchandise").css("display","block");
        }else if($(this).hasClass('shop_etc_snack_tab')){
            $(".shop_etc_snack").css("display","block");
        }else if($(this).hasClass('shop_etc_feed_tab')){
            $(".shop_etc_feed").css("display","block");
        }else if($(this).hasClass('shop_etc_etc_tab')){
            $(".shop_etc_etc").css("display","block");
        }
    })
</script>
</body>
</html>