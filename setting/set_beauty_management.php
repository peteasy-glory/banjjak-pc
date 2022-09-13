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
													<div class="tab-cell"><a href="#" class="btn-tab-item"><span>호텔</span></a></div>
													<div class="tab-cell"><a href="#" class="btn-tab-item"><span>유치원</span></a></div>
												</div>
											</div>
											<!-- actived클래스 추가시 활성화 -->
											<button type="button" class="btn btn-outline-gray btn-inline btn-surtax-set"><div class="icon"></div>부가세 설정</button>
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
													<div class="btn-group-cell"><button type="button" class="btn btn-purple btn-basic-wide"><strong>미용상품 추가하기</strong></button></div>
													<div class="btn-group-cell" style="display: none;"><button type="button" class="btn btn-outline-purple btn-basic-wide"><strong>미용 소요시간 설정하기</strong></button></div>
												</div>
												<!-- 내용이 없을 경우 -->
												<div class="common-none-data">
													<div class="none-inner">
														<div class="item-visual"><img src="../static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
														<div class="item-info">등록된 상품이 없습니다.</div>
													</div>
												</div>
												<!-- //내용이 없을 경우 -->
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
														<div class="basic-data-group">				
															<div class="con-title-group large">
																<h6 class="con-title">소형견 미용<div class="label label-outline-purple vmiddle round">매장상품</div></h6>
															</div>
															<div class="read-table">
																<div class="read-table-unit large">(단위:원)</div>
																<table>
																	<colgroup>
																		<col style="width:16.66%;">
																		<col style="width:auto;">
																		<col style="width:auto;">
																	</colgroup>
																	<thead>
																		<tr>
																			<th>무게</th>
																			<th>목욕만</th>
																			<th>부분 목욕</th>
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
																			<td colspan="2">kg당 5,000원 추가</td>
																		</tr>
																	</tbody>
																</table>
															</div>
															<div class="basic-data-group large">
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
														<div class="basic-data-group">				
															<div class="con-title-group large">
																<h6 class="con-title">중형견 미용<div class="label label-outline-purple vmiddle round">출장상품</div></h6>
															</div>
															<div class="read-table">
																<div class="read-table-unit large">(단위:원)</div>
																<table>
																	<colgroup>
																		<col style="width:auto;">
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
																			<th>무게</th>
																			<th>목욕만</th>
																			<th>부분미용</th>
																			<th>전체미용</th>
																			<th>스포팅</th>
																			<th>가위컷</th>
																			<th>내맘대로컷</th>
																			<th>전체+얼굴</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td>~2kg</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																		</tr>
																		<tr>
																			<td>~3kg</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																		</tr>
																		<tr>
																			<td>~4kg</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																		</tr>
																		<tr>
																			<td>~5kg</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																			<td>20,000</td>
																		</tr>
																		<tr>
																			<td>10kg~</td>
																			<td colspan="7">kg당 10,000원 추가</td>
																		</tr>
																	</tbody>
																</table>
															</div>
															<div class="basic-data-group large">
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
													</div>
												</div>
												<div class="basic-data-group line">												
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
																					<h6 class="con-title">미용<div class="label label-outline-purple vmiddle round">출장/매장</div></h6>
																				</div>																				
																				<div class="read-table">
																					<div class="read-table-unit large">(단위:원)</div>
																					<table>
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
																			<div class="grid-layout-cell grid-2">
																				<div class="con-title-group large">
																					<h6 class="con-title">목욕<div class="label label-outline-purple vmiddle round">매장상품</div></h6>
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
																								<td>5,000</td>
																							</tr>
																							<tr>
																								<td>장모</td>
																								<td>5,000</td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
																			</div>
																			<div class="grid-layout-cell grid-2">
																				<div class="con-title-group large">
																					<h6 class="con-title">현장 판단 후 결제 추가 기능 옵션<div class="label label-outline-purple vmiddle round">매장상품</div></h6>
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
																								<td>털엉킴</td>
																								<td>20,000</td>
																							</tr>
																							<tr>
																								<td>사나움</td>
																								<td>20,000</td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
																			</div>
																			<div class="grid-layout-cell grid-2">
																				<div class="con-title-group large">
																					<h6 class="con-title">추가요금<div class="label label-outline-purple vmiddle round">매장상품</div></h6>
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
																								<td>발톱</td>
																								<td>5,000</td>
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
													</div>
												</div>
												<div class="basic-data-group">			
													<div class="form-group-item">
														<div class="form-item-label">추가설명</div>
														<div class="form-item-data type-2">
															<textarea style="height:100px;" placeholder="입력"></textarea>
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
                                                <div class="common-none-data">
                                                    <div class="none-inner">
                                                        <div class="item-visual"><img src="../static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
                                                        <div class="item-info">등록된 상품이 없습니다.<br><span>*쿠폰/제품 탭의 등록 상품은 견주 예약과정에 나타나지 않습니다.<br>*매장판매 상품등록/관리에 활용하시면 좋습니다.</span></div>
                                                    </div>
                                                </div>
                                                <!-- //내용이 없을 경우 -->
                                                <!-- 내용이 있을을 경우 -->
                                                <div class="basic-data-group">
                                                    <div class="con-title-group">
                                                        <h4 class="con-title">강아지</h4>
                                                    </div>
                                                    <div class="grid-layout margin-14-17">
                                                        <div class="grid-layout-inner">
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">얼굴 디자인컷 추가<div class="label label-outline-purple vmiddle round">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때
                                                                <div class="list-none-data type-2">등록된 상품이 없습니다.</div>
                                                                //내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
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
                                                                            <td>기본얼굴컷</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">미용털길이 조절 추가<div class="label label-outline-purple vmiddle round">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때
                                                                <div class="list-none-data type-2">등록된 상품이 없습니다.</div>
                                                                //내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
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
                                                                            <td>20mm</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>30mm</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>40mm</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>50mm</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">털 특징 별 추가요금<div class="label label-outline-purple vmiddle round">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때
                                                                <div class="list-none-data type-2">등록된 상품이 없습니다.</div>
                                                                //내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
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
                                                                            <td>단모 목욕</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">현장 판단 후 결제 추가 기능 옵션<div class="label label-outline-purple vmiddle round">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때
                                                                <div class="list-none-data type-2">등록된 상품이 없습니다.</div>
                                                                //내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
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
                                                                            <td>털엉킴</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>사나움</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">다리<div class="label label-outline-purple vmiddle round">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때
                                                                <div class="list-none-data type-2">등록된 상품이 없습니다.</div>
                                                                //내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
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
                                                                            <td>발톱</td>
                                                                            <td>5,000</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>장화</td>
                                                                            <td>5,000</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">스파<div class="label label-outline-purple vmiddle round">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때
                                                                <div class="list-none-data type-2">등록된 상품이 없습니다.</div>
                                                                //내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
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
                                                                            <td>스파1</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>스파2</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>스파3</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">염색<div class="label label-outline-purple vmiddle round">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때 -->
                                                                <div class="list-none-data type-2">등록된 상품이 없습니다.</div>
                                                                <!-- //내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">기타<div class="label label-outline-purple vmiddle round">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때
                                                                <div class="list-none-data type-2">등록된 상품이 없습니다.</div>
                                                                //내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
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
                                                                            <td>기타1</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>기타21</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>기타3</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="form-bottom-info">*기타 탭의 상품은 견주예약과정에서 보이지 않습니다.<br>*추가되는 비용(다듬기 정도, 사나움 정도, 등)을 등록하여 예약관리에 활용하시면 좋습니다.</div>
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
                                                <div class="basic-data-group">
                                                    <div class="con-title-group">
                                                        <h4 class="con-title">고양이</h4>
                                                    </div>
                                                    <div class="grid-layout margin-14-17">
                                                        <div class="grid-layout-inner">
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">털 특징 별 추가요금<div class="label label-outline-purple vmiddle round">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때
                                                                <div class="list-none-data type-2">등록된 상품이 없습니다.</div>
                                                                //내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
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
                                                                            <td>단모 목욕</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <!-- //내용이 있을 때 -->
                                                            </div>
                                                            <div class="grid-layout-cell grid-2">
                                                                <div class="con-title-group large">
                                                                    <h6 class="con-title">현장 판단 후 결제 추가 기능 옵션<div class="label label-outline-purple vmiddle round">매장상품</div></h6>
                                                                </div>
                                                                <!-- 내용이 없을 때
                                                                <div class="list-none-data type-2">등록된 상품이 없습니다.</div>
                                                                //내용이 없을 때 -->
                                                                <!-- 내용이 있을 때 -->
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
                                                                            <td>털엉킴</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>사나움</td>
                                                                            <td>20,000</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
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
                                                <div class="common-none-data">
                                                    <div class="none-inner">
                                                        <div class="item-visual"><img src="../static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
                                                        <div class="item-info">등록된 상품이 없습니다.<br><span>*쿠폰/제품 탭의 등록 상품은 견주 예약과정에 나타나지 않습니다.</span></div>
                                                    </div>
                                                </div>
                                                <!-- //내용이 없을 경우 -->
                                                <!-- 내용이 있을을 경우 -->
                                                <div class="basic-data-group">
                                                    <div class="con-title-group">
                                                        <h4 class="con-title">쿠폰 &amp; 적립상품</h4>
                                                    </div>
                                                    <div>
                                                        <div class="basic-data-group none">
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
                                                                    <div class="memo-item-txt">프론트 샵페이지 상품하단에 위치하는 안내입니다.</div>
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
                                                                <table>
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
                                                                    <div class="memo-item-txt">프론트 샵페이지 상품하단에 위치하는 안내입니다.</div>
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
                                                <div class="common-none-data">
                                                    <div class="none-inner">
                                                        <div class="item-visual"><img src="../static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
                                                        <div class="item-info">등록된 상품이 없습니다.<br><span>*쿠폰/제품 탭의 등록 상품은 견주 예약과정에 나타나지 않습니다.<br>*매장판매 상품등록/관리에 활용하시면 좋습니다.</span></div>
                                                    </div>
                                                </div>
                                                <!-- //내용이 없을 경우 -->
                                                <!-- 내용이 있을을 경우 -->
                                                <div class="wide-tab card">
                                                    <div class="wide-tab-inner">
                                                        <!-- 활성화시 actived클래스 추가 -->
                                                        <div class="tab-cell actived"><a href="#" class="btn-tab-item">용품</a></div>
                                                        <div class="tab-cell"><a href="#" class="btn-tab-item">간식</a></div>
                                                        <div class="tab-cell"><a href="#" class="btn-tab-item">사료</a></div>
                                                        <div class="tab-cell"><a href="#" class="btn-tab-item">기타</a></div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="basic-data-group">
                                                        <div class="con-title-group large">
                                                            <h6 class="con-title">용품</h6>
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
                                                                    <td>상품명</td>
                                                                    <td>20,000</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>상품명</td>
                                                                    <td>20,000</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>상품명</td>
                                                                    <td>20,000</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>상품명</td>
                                                                    <td>20,000</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>상품명</td>
                                                                    <td>20,000</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>상품명</td>
                                                                    <td>20,000</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>상품명</td>
                                                                    <td>20,000</td>
                                                                </tr>
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
        // 미용별 소요시간
        var col_html = '<colgroup>';
        var thead_html = '<thead><tr>';
        var tbody_html = '<tbody><tr>';
        var add_service = ['무게'];
        $.each(setting_array[0].worktime, function(i,v){
            var txt = '';
            switch (i){
                case 'bath' : txt = '목욕'; break;
                case 'part' : txt = '부분미용'; break;
                case 'bath_part' : txt = '부분+목욕'; break;
                case 'sanitation' : txt = '위생'; break;
                case 'sanitation_bath' : txt = '위생+목욕'; break;
                case 'all' : txt = '전체미용'; break;
                case 'spoting' : txt = '스포팅'; break;
                case 'scissors' : txt = '가위컷'; break;
                case 'summercut' : txt = '썸머컷'; break;
                default : txt = i; add_service.push(txt);
            }
            col_html += '<col style="width:auto;">';
            thead_html += `<th>${txt}</th>`;
            tbody_html += `<td>${v.time}</td>`;
        })
        col_html += '</colgroup>';
        thead_html += '</tr></thead>';
        tbody_html += '</tr></tbody>';
        $(".beauty_time_wrap").html(col_html+thead_html+tbody_html);

        // 강아지 미용 가격
        console.log(setting_array[0].dog);
        var test = `

                        <colgroup>
                            <col style="width:16.66%;">
                            <col style="width:auto;">
                            <col style="width:auto;">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>무게</th>
                                <th>목욕만</th>
                                <th>부분 목욕</th>
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
                                <td colspan="2">kg당 5,000원 추가</td>
                            </tr>
                        </tbody>

        `;
        var dog_total_html = '';
        $.each(setting_array[0].dog, function(index,value){
            var service_type = '';
            if(value.in_shop == 1 && value.out_shop == 1){
                service_type = '출장/매장';
            }else if(value.in_shop == 1){
                service_type = '매장상품';
            }else if(value.out_shop == 1){
                service_type = '출장상품';
            }
            var dog_st_html = `
                <div class="basic-data-group">
                    <div class="con-title-group large">
                        <h6 class="con-title">${value.second_type}<div class="label label-outline-purple vmiddle round">${service_type}</div></h6>
                    </div>
                    <div class="read-table">
                        <div class="read-table-unit large">(단위:원)</div>
                        <table>
            `;
            var dog_col_html = `<colgroup>`;
            var dog_thead_html = `<thead><tr>`;
            var dog_tbody_html = ``;

            var is_service = [];
            $.each(value.service, function(i,v){
                dog_tbody_html += `<tbody><tr>`;
                var number = 0;
                $.each(v, function(_i, _v){
                    //console.log(i);
                    var txt = '';
                    switch (_i){
                        case 'bath_price' : txt = '목욕'; break;
                        case 'part_price' : txt = '부분미용'; break;
                        case 'bath_part_price' : txt = '부분+목욕'; break;
                        case 'sanitation_price' : txt = '위생'; break;
                        case 'sanitation_bath_price' : txt = '위생+목욕'; break;
                        case 'all_price' : txt = '전체미용'; break;
                        case 'spoting_price' : txt = '스포팅'; break;
                        case 'scissors_price' : txt = '가위컷'; break;
                        case 'summercut_price' : txt = '썸머컷'; break;
                        default : txt = add_service[number]; number ++;
                    }
                    is_service.push(_i);
                    console.log(is_service);
                    dog_col_html += `<col style="width:auto;">`;
                    dog_thead_html += `<th class="table_th service_${index}_${_i}">${txt}</th>`;

                    if(_i == 'kg'){
                        dog_tbody_html += `<td>~${_v}kg</td>`;
                    }else{
                        dog_tbody_html += `<td>${_v.price}</td>`;
                    }
                })
                dog_tbody_html += `</tr></tbody>`;
            })

            dog_col_html += `</colgroup>`;
            dog_thead_html += `</tr></thead>`;
            //dog_tbody_html += `</tr></tbody>`;
            var dog_fi_html = `
                        </table>
                    </div>
                <div class="basic-data-group large">
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
            `;
            dog_total_html += dog_st_html + dog_col_html + dog_thead_html + dog_tbody_html + dog_fi_html;
        })
        $(".append_dog_service_wrap").append(dog_total_html);
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
</script>
</body>
</html>