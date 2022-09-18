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
								<h3 class="card-header-title">미용 추가옵션 등록/수정</h3>
							</div>
							<form id="optionProductForm" class="card-body">
                                <input type="hidden" name="partner_id" value="<?=$artist_id?>">
                                <input type="hidden" name="idx" class="option_product_idx">
								<div class="card-body-inner">
									<div class="product-management">
										<div class="basic-data-group small">											
											<div class="basic-data-group vmiddle">
												<div class="basic-data-group">
													<div class="grid-layout margin-14-17">
														<div class="grid-layout-inner">
															<div class="grid-layout-cell grid-3">
																<div class="form-group-item">
																	<div class="form-item-label">제공방식</div>
																	<div class="form-item-data type-2">
																		<div class="grid-layout toggle-button-group">
																			<div class="grid-layout-inner">
																				<div class="grid-layout-cell grid-3"><label class="form-toggle-box middle auto"><input type="radio" class="offer0" name="offer" value="0"><em>매장상품</em></label></div>
																				<div class="grid-layout-cell grid-3"><label class="form-toggle-box middle auto"><input type="radio" class="offer1" name="offer" value="1"><em>출장상품</em></label></div>
																				<div class="grid-layout-cell grid-3"><label class="form-toggle-box middle auto"><input type="radio" class="offer2" name="offer" value="2"><em>출장/매장</em></label></div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="basic-data-group">										
													<div class="con-title-group">
														<h4 class="con-title">얼굴 디자인컷 추가</h4>
														<div class="grid-layout btn-grid-group">
															<div class="grid-layout-inner justify-content-end">
																<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small" onclick="add_table('face')">구간추가</button></div>
															</div>
														</div>
													</div>
													<div class="basic-data-group vvsmall">
														<div class="read-table">
															<table>
																<colgroup>
																	<col style="width:53px;">
																	<col style="width:auto;">
																	<col style="width:30%;">
																	<col style="width:10%;">
																</colgroup>
																<thead>
																	<tr>
																		<th></th>
																		<th>상품명</th>
																		<th>가격 (단위:원)</th>
																		<th>삭제</th>
																	</tr>
																</thead>
																<tbody class="drag-sort-wrap face_table">
																	<tr class="drag-sort-cell">
																		<td class="no-padding">
																			<div class="form-table-select">
																				<button type="button" class="btn-data-handler">드래그바</button>
																			</div>
																		</td>
																		<td class="no-padding">
																			<div class="form-table-select">
																				<input type="text" placeholder="입력" value="기본얼굴컷" disabled>
																			</div>
																		</td>
																		<td class="no-padding">
																			<div class="form-table-select">
																				<input type="number" class="basic_price" name="basic_price">
																			</div>
																		</td>
																		<td class="no-padding text-align-center vertical-center">
																			<button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
																		</td>
																	</tr>
                                                                    <tr class="drag-sort-cell">
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <button type="button" class="btn-data-handler">드래그바</button>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="text" placeholder="입력" value="곰돌이컷" disabled>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="number" class="bear_price" name="bear_price">
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding text-align-center vertical-center">
                                                                            <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="drag-sort-cell">
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <button type="button" class="btn-data-handler">드래그바</button>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="text" placeholder="입력" value="브로컬리컷" disabled>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="number" class="brocoli_price" name="brocoli_price">
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding text-align-center vertical-center">
                                                                            <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="drag-sort-cell">
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <button type="button" class="btn-data-handler">드래그바</button>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="text" placeholder="입력" value="하이바컷" disabled>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="number" class="highba_price" name="highba_price">
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding text-align-center vertical-center">
                                                                            <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                                                                        </td>
                                                                    </tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>		
												<div class="basic-data-group">										
													<div class="con-title-group">
														<h4 class="con-title">미용털길이 조절 추가</h4>
														<div class="grid-layout btn-grid-group">
															<div class="grid-layout-inner justify-content-end">
																<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small" onclick="add_table('hair_len')">구간추가</button></div>
															</div>
														</div>
													</div>
													<div class="basic-data-group vvsmall">
														<div class="read-table">
															<table>
																<colgroup>
																	<col style="width:53px;">
																	<col style="width:auto;">
																	<col style="width:30%;">
																	<col style="width:10%;">
																</colgroup>
																<thead>
																	<tr>
																		<th></th>
																		<th>상품명</th>
																		<th>가격 (단위:원)</th>
																		<th>삭제</th>
																	</tr>
																</thead>
																<tbody class="drag-sort-wrap hair_len_table">
																	<tr class="drag-sort-cell">
																		<td class="no-padding">
																			<div class="form-table-select">
																				<button type="button" class="btn-data-handler">드래그바</button>
																			</div>
																		</td>
																		<td class="no-padding">
																			<div class="form-table-select">
																				<input type="text" placeholder="입력">
																			</div>
																		</td>
																		<td class="no-padding">
																			<div class="form-table-select">
                                                                                <input type="number">
																			</div>
																		</td>
																		<td class="no-padding text-align-center vertical-center">
																			<button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
																		</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>			
												<div class="basic-data-group">										
													<div class="con-title-group">
														<h4 class="con-title">털 특징 별 추가요금</h4>
														<div class="grid-layout btn-grid-group">
															<div class="grid-layout-inner justify-content-end">
																<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small" onclick="add_table('plus')">구간추가</button></div>
															</div>
														</div>
													</div>
													<div class="basic-data-group vvsmall">
														<div class="read-table">
															<table>
																<colgroup>
																	<col style="width:53px;">
																	<col style="width:auto;">
																	<col style="width:30%;">
																	<col style="width:10%;">
																</colgroup>
																<thead>
																	<tr>
																		<th></th>
																		<th>상품명</th>
																		<th>가격 (단위:원)</th>
																		<th>삭제</th>
																	</tr>
																</thead>
																<tbody class="drag-sort-wrap plus_table">
																	<tr class="drag-sort-cell">
																		<td class="no-padding">
																			<div class="form-table-select">
																				<button type="button" class="btn-data-handler">드래그바</button>
																			</div>
																		</td>
																		<td class="no-padding">
																			<div class="form-table-select">
																				<input type="text" placeholder="입력" value="단모목욕" disabled>
																			</div>
																		</td>
																		<td class="no-padding">
																			<div class="form-table-select">
                                                                                <input type="number" name="short_bath_price" class="short_bath_price">
																			</div>
																		</td>
																		<td class="no-padding text-align-center vertical-center">
																			<button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
																		</td>
																	</tr>
                                                                    <tr class="drag-sort-cell">
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <button type="button" class="btn-data-handler">드래그바</button>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="text" placeholder="입력" value="장모목욕" disabled>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="number" name="long_bath_price" class="long_bath_price">
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding text-align-center vertical-center">
                                                                            <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="drag-sort-cell">
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <button type="button" class="btn-data-handler">드래그바</button>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="text" placeholder="입력" value="이중모목욕" disabled>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="number" name="double_bath_price" class="double_bath_price">
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding text-align-center vertical-center">
                                                                            <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                                                                        </td>
                                                                    </tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>			
												<div class="basic-data-group">										
													<div class="con-title-group">
														<h4 class="con-title">현장판단 후 현장 결제추가 가능옵션</h4>
														<div class="grid-layout btn-grid-group">
															<div class="grid-layout-inner justify-content-end">
																<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small" onclick="add_table('place_plus')">구간추가</button></div>
															</div>
														</div>
													</div>
													<div class="basic-data-group vvsmall">
														<div class="read-table">
															<table>
																<colgroup>
																	<col style="width:53px;">
																	<col style="width:auto;">
																	<col style="width:30%;">
																	<col style="width:10%;">
																</colgroup>
																<thead>
																	<tr>
																		<th></th>
																		<th>상품명</th>
																		<th>가격 (단위:원)</th>
																		<th>삭제</th>
																	</tr>
																</thead>
																<tbody class="drag-sort-wrap place_plus_table">
																	<tr class="drag-sort-cell">
																		<td class="no-padding">
																			<div class="form-table-select">
																				<button type="button" class="btn-data-handler">드래그바</button>
																			</div>
																		</td>
																		<td class="no-padding">
																			<div class="form-table-select">
																				<input type="text" placeholder="입력" value="털엉킴" disabled>
																			</div>
																		</td>
																		<td class="no-padding">
																			<div class="form-table-select">
                                                                                <input type="number" name="hair_clot_price" class="hair_clot_price">
																			</div>
																		</td>
																		<td class="no-padding text-align-center vertical-center">
																			<button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
																		</td>
																	</tr>
                                                                    <tr class="drag-sort-cell">
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <button type="button" class="btn-data-handler">드래그바</button>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="text" placeholder="입력" value="사나움" disabled>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="number" name="ferocity_price" class="ferocity_price">
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding text-align-center vertical-center">
                                                                            <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="drag-sort-cell">
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <button type="button" class="btn-data-handler">드래그바</button>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="text" placeholder="입력" value="진드기" disabled>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="number" name="tick_price" class="tick_price">
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding text-align-center vertical-center">
                                                                            <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                                                                        </td>
                                                                    </tr>
																</tbody>
															</table>
														</div>
													</div>
												</div>			
												<div class="basic-data-group">										
													<div class="con-title-group">
														<h4 class="con-title">기타</h4>
													</div>
													<div class="wide-tab card">
														<div class="wide-tab-inner">
															<!-- 활성화시 actived클래스 추가 -->
															<div class="tab-cell option_etc_tab leg_tab actived"><a href="#" class="btn-tab-item">다리</a></div>
															<div class="tab-cell option_etc_tab spa_tab"><a href="#" class="btn-tab-item">스파</a></div>
															<div class="tab-cell option_etc_tab dyeing_tab"><a href="#" class="btn-tab-item">염색</a></div>
															<div class="tab-cell option_etc_tab etc_tab"><a href="#" class="btn-tab-item">기타</a></div>
														</div>
													</div>
													<div class="basic-data-group vsmall option_etc_wrap leg_table_wrap">
														<div class="grid-layout btn-grid-group">
															<div class="grid-layout-inner justify-content-end">
																<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small" onclick="add_table('leg')">구간추가</button></div>
															</div>
														</div>
														<div class="basic-data-group vvsmall4">
															<div class="read-table">
																<table>
																	<colgroup>
																		<col style="width:53px;">
																		<col style="width:auto;">
																		<col style="width:30%;">
																		<col style="width:10%;">
																	</colgroup>
																	<thead>
																		<tr>
																			<th></th>
																			<th>상품명</th>
																			<th>가격 (단위:원)</th>
																			<th>삭제</th>
																		</tr>
																	</thead>
																	<tbody class="drag-sort-wrap leg_table">
																		<tr class="drag-sort-cell">
																			<td class="no-padding">
																				<div class="form-table-select">
																					<button type="button" class="btn-data-handler">드래그바</button>
																				</div>
																			</td>
																			<td class="no-padding">
																				<div class="form-table-select">
																					<input type="text" placeholder="입력" value="발톱" disabled>
																				</div>
																			</td>
																			<td class="no-padding">
																				<div class="form-table-select">
																					<input type="number" name="tonail_price" class="tonail_price">
																				</div>
																			</td>
																			<td class="no-padding text-align-center vertical-center">
																				<button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
																			</td>
																		</tr>
                                                                        <tr class="drag-sort-cell">
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <button type="button" class="btn-data-handler">드래그바</button>
                                                                                </div>
                                                                            </td>
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <input type="text" placeholder="입력" value="장화" disabled>
                                                                                </div>
                                                                            </td>
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <input type="number" name="boots_price" class="boots_price">
                                                                                </div>
                                                                            </td>
                                                                            <td class="no-padding text-align-center vertical-center">
                                                                                <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                                                                            </td>
                                                                        </tr>
                                                                        <tr class="drag-sort-cell">
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <button type="button" class="btn-data-handler">드래그바</button>
                                                                                </div>
                                                                            </td>
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <input type="text" placeholder="입력" value="방울" disabled>
                                                                                </div>
                                                                            </td>
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <input type="number" name="bell_price" class="bell_price">
                                                                                </div>
                                                                            </td>
                                                                            <td class="no-padding text-align-center vertical-center">
                                                                                <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                                                                            </td>
                                                                        </tr>
																	</tbody>
																</table>
															</div>
														</div>
													</div>
                                                    <div class="basic-data-group vsmall option_etc_wrap spa_table_wrap" style="display: none;">
                                                        <div class="grid-layout btn-grid-group">
                                                            <div class="grid-layout-inner justify-content-end">
                                                                <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small" onclick="add_table('spa')">구간추가</button></div>
                                                            </div>
                                                        </div>
                                                        <div class="basic-data-group vvsmall4">
                                                            <div class="read-table">
                                                                <table>
                                                                    <colgroup>
                                                                        <col style="width:53px;">
                                                                        <col style="width:auto;">
                                                                        <col style="width:30%;">
                                                                        <col style="width:10%;">
                                                                    </colgroup>
                                                                    <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>상품명</th>
                                                                        <th>가격 (단위:원)</th>
                                                                        <th>삭제</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="drag-sort-wrap spa_table">
                                                                    <tr class="drag-sort-cell">
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <button type="button" class="btn-data-handler">드래그바</button>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="text" placeholder="입력">
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="number" name="">
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding text-align-center vertical-center">
                                                                            <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="basic-data-group vsmall option_etc_wrap dyeing_table_wrap" style="display: none;">
                                                        <div class="grid-layout btn-grid-group">
                                                            <div class="grid-layout-inner justify-content-end">
                                                                <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small" onclick="add_table('dyeing')">구간추가</button></div>
                                                            </div>
                                                        </div>
                                                        <div class="basic-data-group vvsmall4">
                                                            <div class="read-table">
                                                                <table>
                                                                    <colgroup>
                                                                        <col style="width:53px;">
                                                                        <col style="width:auto;">
                                                                        <col style="width:30%;">
                                                                        <col style="width:10%;">
                                                                    </colgroup>
                                                                    <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>상품명</th>
                                                                        <th>가격 (단위:원)</th>
                                                                        <th>삭제</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="drag-sort-wrap dyeing_table">
                                                                    <tr class="drag-sort-cell">
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <button type="button" class="btn-data-handler">드래그바</button>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="text" placeholder="입력">
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="number" name="">
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding text-align-center vertical-center">
                                                                            <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="basic-data-group vsmall option_etc_wrap etc_table_wrap" style="display: none;">
                                                        <div class="grid-layout btn-grid-group">
                                                            <div class="grid-layout-inner justify-content-end">
                                                                <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small" onclick="add_table('etc')">구간추가</button></div>
                                                            </div>
                                                        </div>
                                                        <div class="basic-data-group vvsmall4">
                                                            <div class="read-table">
                                                                <table>
                                                                    <colgroup>
                                                                        <col style="width:53px;">
                                                                        <col style="width:auto;">
                                                                        <col style="width:30%;">
                                                                        <col style="width:10%;">
                                                                    </colgroup>
                                                                    <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>상품명</th>
                                                                        <th>가격 (단위:원)</th>
                                                                        <th>삭제</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody class="drag-sort-wrap etc_table">
                                                                    <tr class="drag-sort-cell">
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <button type="button" class="btn-data-handler">드래그바</button>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="text" placeholder="입력">
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <input type="number" name="">
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding text-align-center vertical-center">
                                                                            <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
												</div>														
												<div class="basic-data-group">			
													<div class="form-group-item">
														<div class="form-item-label">추가설명</div>
														<div class="form-item-data type-2">
															<textarea style="height:100px;" name="comment" class="comment" placeholder="입력"></textarea>
															<div class="form-input-info">0/1000</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
							<div class="card-footer">
								<!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
								<a href="javascript:open_pop();" class="btn-page-bottom">저장하기</a>
							</div>
						</div>			
					</div>
				</div>
			</div>
			<!-- //view -->
		</section>
		<!-- //contents -->
        <article id="saveOptionProduct" class="layer-pop-wrap">
            <div class="layer-pop-parent">
                <div class="layer-pop-children">
                    <div class="pop-data alert-pop-data">
                        <div class="pop-body">
                            <div class="msg-txt">저장하시겠습니까?</div>
                        </div>
                        <div class="pop-footer">
                            <button type="button" class="btn btn-confirm" onclick="save_option_product();">저장</button>
                            <button type="button" class="btn btn-cancel" onclick="pop.close();">취소</button>
                        </div>
                    </div>

                </div>
            </div>
        </article>
    </section>
    <!-- //container -->
</div>
<!-- //wrap -->
<script src="../static/js/Sortable.min.js"></script>
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/setting.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        gnb_actived('gnb_detail_wrap', 'gnb_merchandise');
        get_option_product(artist_id);

        var option_array = setting_array[0].option;
        console.log(option_array);

        // 제공방식
        if(option_array.in_shop == 1 && option_array.out_shop == 1){
            $(".offer2").prop("checked", true);
        }else if(option_array.in_shop == 1){
            $(".offer0").prop("checked", true);
        }else if(option_array.out_shop == 1){
            $(".offer1").prop("checked", true);
        }

        // 얼굴컷
        if(option_array.face != ''){
            var add_html = '';
            $.each(option_array.face, function(i,v){
                if(i == 'basic') {
                    $(".basic_price").val(v);
                }else if(i == 'bear'){
                    $(".bear_price").val(v);
                }else if(i== 'broccoli'){
                    $(".brocoli_price").val(v);
                }else if(i == 'highba'){
                    $(".highba_price").val(v);
                }else{
                    add_html += `
                        <tr class="drag-sort-cell">
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <button type="button" class="btn-data-handler">드래그바</button>
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="text" placeholder="입력" name="face_name[]" value="${i}">
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="number"name="face_price[]" value="${v}">
                                </div>
                            </td>
                            <td class="no-padding text-align-center vertical-center">
                                <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                            </td>
                        </tr>
                    `;
                }
            })
            $(".face_table").append(add_html);
        }

        // 털길이
        if(option_array.hair_len != ''){
            var add_html = '';
            $.each(option_array.hair_len, function(i,v){
                add_html += `
                    <tr class="drag-sort-cell">
                        <td class="no-padding">
                            <div class="form-table-select">
                                <button type="button" class="btn-data-handler">드래그바</button>
                            </div>
                        </td>
                        <td class="no-padding">
                            <div class="form-table-select">
                                <input type="text" placeholder="입력" name="hair_len_name[]" value="${i}">
                            </div>
                        </td>
                        <td class="no-padding">
                            <div class="form-table-select">
                                <input type="number"name="hair_len_price[]" value="${v}">
                            </div>
                        </td>
                        <td class="no-padding text-align-center vertical-center">
                            <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                        </td>
                    </tr>
                `;
            })
            $(".hair_len_table").html(add_html);
        }

        // 털특징별 추가
        if(option_array.plus != ''){
            var add_html = '';
            $.each(option_array.plus, function(i,v){
                if(i == 'short_bath') {
                    $(".short_bath_price").val(v);
                }else if(i == 'long_bath'){
                    $(".long_bath_price").val(v);
                }else if(i== 'double_bath'){
                    $(".double_bath_price").val(v);
                }else{
                    add_html += `
                        <tr class="drag-sort-cell">
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <button type="button" class="btn-data-handler">드래그바</button>
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="text" placeholder="입력" name="plus_name[]" value="${i}">
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="number"name="plus_price[]" value="${v}">
                                </div>
                            </td>
                            <td class="no-padding text-align-center vertical-center">
                                <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                            </td>
                        </tr>
                    `;
                }
            })
            $(".plus_table").append(add_html);
        }

        // 현장판단후
        if(option_array.place_plus != ''){
            var add_html = '';
            $.each(option_array.place_plus, function(i,v){
                if(i == 'hair_clot') {
                    $(".hair_clot_price").val(v);
                }else if(i == 'ferocity'){
                    $(".ferocity_price").val(v);
                }else if(i== 'tick'){
                    $(".tick_price").val(v);
                }else{
                    add_html += `
                        <tr class="drag-sort-cell">
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <button type="button" class="btn-data-handler">드래그바</button>
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="text" placeholder="입력" name="place_plus_name[]" value="${i}">
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="number"name="place_plus_price[]" value="${v}">
                                </div>
                            </td>
                            <td class="no-padding text-align-center vertical-center">
                                <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                            </td>
                        </tr>
                    `;
                }
            })
            $(".place_plus_table").append(add_html);
        }

        // 기타
        console.log(option_array.etc);
        // 다리
        if(option_array.etc.leg != ''){
            var add_html = '';
            $.each(option_array.etc.leg, function(i,v){
                if(i == 'tonail') {
                    $(".tonail_price").val(v);
                }else if(i == 'boots'){
                    $(".bell_price").val(v);
                }else if(i== 'bell'){
                    $(".bell_price").val(v);
                }else{
                    add_html += `
                        <tr class="drag-sort-cell">
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <button type="button" class="btn-data-handler">드래그바</button>
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="text" placeholder="입력" name="leg_name[]" value="${i}">
                                </div>
                            </td>
                            <td class="no-padding">
                                <div class="form-table-select">
                                    <input type="number"name="leg_price[]" value="${v}">
                                </div>
                            </td>
                            <td class="no-padding text-align-center vertical-center">
                                <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                            </td>
                        </tr>
                    `;
                }
            })
            $(".leg_table").append(add_html);
        }

        // 스파
        if(option_array.etc.spa != ''){
            var add_html = '';
            $.each(option_array.etc.spa, function(i,v){
                add_html += `
                    <tr class="drag-sort-cell">
                        <td class="no-padding">
                            <div class="form-table-select">
                                <button type="button" class="btn-data-handler">드래그바</button>
                            </div>
                        </td>
                        <td class="no-padding">
                            <div class="form-table-select">
                                <input type="text" placeholder="입력" name="spa_name[]" value="${i}">
                            </div>
                        </td>
                        <td class="no-padding">
                            <div class="form-table-select">
                                <input type="number"name="spa_price[]" value="${v}">
                            </div>
                        </td>
                        <td class="no-padding text-align-center vertical-center">
                            <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                        </td>
                    </tr>
                `;
            })
            $(".spa_table").html(add_html);
        }

        // 염색
        if(option_array.etc.dyeing != ''){
            var add_html = '';
            $.each(option_array.etc.dyeing, function(i,v){
                add_html += `
                    <tr class="drag-sort-cell">
                        <td class="no-padding">
                            <div class="form-table-select">
                                <button type="button" class="btn-data-handler">드래그바</button>
                            </div>
                        </td>
                        <td class="no-padding">
                            <div class="form-table-select">
                                <input type="text" placeholder="입력" name="dyeing_name[]" value="${i}">
                            </div>
                        </td>
                        <td class="no-padding">
                            <div class="form-table-select">
                                <input type="number"name="dyeing_price[]" value="${v}">
                            </div>
                        </td>
                        <td class="no-padding text-align-center vertical-center">
                            <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                        </td>
                    </tr>
                `;
            })
            $(".dyeing_table").html(add_html);
        }

        // 기타
        if(option_array.etc.etc_etc != ''){
            var add_html = '';
            $.each(option_array.etc.etc_etc, function(i,v){
                add_html += `
                    <tr class="drag-sort-cell">
                        <td class="no-padding">
                            <div class="form-table-select">
                                <button type="button" class="btn-data-handler">드래그바</button>
                            </div>
                        </td>
                        <td class="no-padding">
                            <div class="form-table-select">
                                <input type="text" placeholder="입력" name="etc_name[]" value="${i}">
                            </div>
                        </td>
                        <td class="no-padding">
                            <div class="form-table-select">
                                <input type="number"name="etc_price[]" value="${v}">
                            </div>
                        </td>
                        <td class="no-padding text-align-center vertical-center">
                            <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                        </td>
                    </tr>
                `;
            })
            $(".etc_table").html(add_html);
        }

        // 코멘트
        $(".comment").val(option_array.comment);
        // idx
        $(".option_product_idx").val(option_array.idx);

    })

    // 기타 탭 클릭
    $(document).on("click",".option_etc_tab",function(){
        $(".option_etc_tab").removeClass("actived");
        $(this).addClass("actived");
        $(".option_etc_wrap").css("display","none");

        if($(this).hasClass('leg_tab')){
            $(".leg_table_wrap").css("display","block");
        }else if($(this).hasClass('spa_tab')){
            $(".spa_table_wrap").css("display","block");
        }else if($(this).hasClass('dyeing_tab')){
            $(".dyeing_table_wrap").css("display","block");
        }else if($(this).hasClass('etc_tab')){
            $(".etc_table_wrap").css("display","block");
        }
    })

    // 구간추가
    function add_table(idx){
        var html = `
            <tr class="drag-sort-cell">
                <td class="no-padding">
                    <div class="form-table-select">
                        <button type="button" class="btn-data-handler">드래그바</button>
                    </div>
                </td>
                <td class="no-padding">
                    <div class="form-table-select">
                        <input type="text" placeholder="입력" name="${idx}_name[]" value="">
                    </div>
                </td>
                <td class="no-padding">
                    <div class="form-table-select">
                        <input type="number"name="${idx}_price[]" value="">
                    </div>
                </td>
                <td class="no-padding text-align-center vertical-center">
                    <button type="button" class="btn-item-del"><span class="icon icon-size-36 icon-trash"></span></button>
                </td>
            </tr>
        `;
        if(idx == 'face'){
            $(".face_table").append(html);
        }else if(idx == 'hair_len'){
            $(".hair_len_table").append(html);
        }else if(idx == 'plus'){
            $(".plus_table").append(html);
        }else if(idx == 'place_plus'){
            $(".place_plus_table").append(html);
        }else if(idx == 'leg'){
            $(".leg_table").append(html);
        }else if(idx == 'spa'){
            $(".spa_table").append(html);
        }else if(idx == 'dyeing'){
            $(".dyeing_table").append(html);
        }else if(idx == 'etc'){
            $(".etc_table").append(html);
        }
    }

    function open_pop(){
        pop.open('saveOptionProduct');
    }

    function save_option_product(){
        var postData = decodeURIComponent($("#optionProductForm").serialize());
        postData += '&mode=put_option_product';
        //console.log(postData);
        put_option_product(postData);
    }

$(function(){
	//https://github.com/SortableJS/Sortable

	$('.drag-sort-wrap').each(function(){
		var sortable = Sortable.create($(this)[0] , {
			delay : 0,
			ghostClass: 'guide',
			draggable : '.drag-sort-cell',
			handle : '.btn-data-handler',
			onStart : function(evt){
				//드래그 시작 
				console.log('drag start');
			},
			onEnd : function(evt){
				//드래그 끝
				console.log('drag end');
				//evt.to;    // 현재 아이템
				//evt.from;  // 이전 아이템
				//evt.oldIndex;  // 이전 인덱스값
				//evt.newIndex;  // 새로운 인덱스값
			},
			onUpdate : function(evt){
				console.log('update');
			},
			onUpdate : function(evt){
				console.log('onChange');
			},
			onRemove: function (/**Event*/evt) {
				console.log('remove');
			}
			
		});
	});
});
</script>
</body>
</html>