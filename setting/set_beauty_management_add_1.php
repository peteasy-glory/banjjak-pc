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
								<h3 class="card-header-title">미용상품 등록/수정</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="product-management">
										<div class="basic-data-group small">											
											<div class="con-title-group">
												<h4 class="con-title">상품분류</h4>
											</div>
											<div class="wide-tab">
												<div class="wide-tab-inner">
													<!-- 활성화시 actived클래스 추가 -->
													<div class="tab-cell product_tab product_tab_dog  actived"><button type="button" class="btn-tab-item">강아지</button></div>
													<div class="tab-cell product_tab product_tab_cat"><button type="button" class="btn-tab-item">고양이</button></div>
												</div>
											</div>
											<div class="basic-data-group vmiddle produt_section product_dog_section">
												<div class="basic-data-group">
													<div class="grid-layout margin-14-17">
														<div class="grid-layout-inner">
															<div class="grid-layout-cell grid-3">
																<div class="form-group-item">
																	<div class="form-item-label">제공방식</div>
																	<div class="form-item-data type-2">
																		<div class="grid-layout toggle-button-group">
																			<div class="grid-layout-inner">
																				<div class="grid-layout-cell grid-3"><label class="form-toggle-box middle auto"><input type="radio" name="offer"><em>매장상품</em></label></div>
																				<div class="grid-layout-cell grid-3"><label class="form-toggle-box middle auto"><input type="radio" name="offer"><em>출장상품</em></label></div>
																				<div class="grid-layout-cell grid-3"><label class="form-toggle-box middle auto"><input type="radio" name="offer"><em>출장/매장</em></label></div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="grid-layout-cell grid-3">
																<div class="form-group-item">
																	<div class="form-item-label">상품명</div>
																	<div class="form-item-data type-2">
																		<select>
																			<option value="">소형견미용</option>
																			<option value="">중형견미용</option>
																			<option value="">대형견미용</option>
																			<option value="">특수견미용</option>
																			<option value="">직접입력</option>
																		</select>
																	</div>
																</div>
															</div>
															<!-- 직접 입력시 -->
															<div class="grid-layout-cell grid-3" style="display:block;">
																<div class="form-group-item">
																	<div class="form-item-data type-2">
																		<input type="text" placeholder="입력"/>
																	</div>
																</div>
															</div>
															<!-- //직접 입력시 -->
														</div>
													</div>
												</div>
												<div class="basic-data-group">										
													<div class="con-title-group">
														<h4 class="con-title">미용구분(옵션1)</h4>
													</div>
													<div class="basic-info" style="display:block;">목욕 · 부분미용</div>
													<div class="basic-data-group vsmall">
														<div class="grid-layout margin-14-17">
															<div class="grid-layout-inner">
																<div class="grid-layout-cell grid-3">
																	<button type="button" class="btn btn-outline-purple btn-basic-full" onclick="pop.open('setBeautyDivision')">미용구분 선택</button>
																</div>
															</div>
														</div>
													</div>
													<!-- 옵션목록이 없을 경우 -->
													<div class="basic-data-group vmiddle" style="display:block;">
														<div class="form-group-item">
															<div class="form-item-label">옵션목록</div>
															<div class="form-item-data type-3">
																<div class="basic-info font-color-black">미용구분이 선택되지 않았습니다.</div>
															</div>
														</div>
													</div>
													<!-- //옵션목록이 없을 경우 -->
													<!-- 옵션목록이 있을 경우 -->
													<div class="basic-data-group vmiddle" style="display:block;">
														<div class="basic-data-group middle">
															<div class="form-group-item">
																<div class="form-item-label">
																	옵션목록
																	<div class="grid-layout btn-grid-group">
																		<div class="grid-layout-inner justify-content-end">
																			<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small">구간추가</button></div>
																			<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small">구간삭제</button></div>
																		</div>
																	</div>		
																</div>
																<div class="form-item-data type-2">		
																	<div class="read-table">
																		<table>
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
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																						</div>
																					</td>
																				</tr>
																				<tr>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																							<label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em>상담</em></span></label>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																							<label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em>상담</em></span></label>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																							<label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em>상담</em></span></label>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																							<label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em>상담</em></span></label>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																							<label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em>상담</em></span></label>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																							<label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em>상담</em></span></label>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																							<label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em>상담</em></span></label>
																						</div>
																					</td>
																				</tr>
																				<tr>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select disabled>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																							<label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em>상담</em></span></label>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select disabled>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																							<label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em>상담</em></span></label>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select disabled>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																							<label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em>상담</em></span></label>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																							<label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em>상담</em></span></label>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																							<label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em>상담</em></span></label>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																							<label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em>상담</em></span></label>
																						</div>
																					</td>
																					<td class="no-padding">
																						<div class="form-table-select">
																							<select>
																								<option value="">선택</option>
																								<option value="">선택</option>
																								<option value="">선택</option>
																							</select>
																							<label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em>상담</em></span></label>
																						</div>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																</div>
															</div>
														</div>
														<div class="basic-data-group middle">
															<div class="form-group-item">
																<div class="form-item-label">Kg당 추가요금설정(추가옵션1)</div>
																<div class="form-item-data type-2">									
																	<div class="form-check-group">
																		<div class="form-check-inner">
																			<div class="check-cell"><label class="form-radiobox"><input type="radio" name="time2"><span class="form-check-icon"><em>설정</em></span></label></div>
																			<div class="check-cell"><label class="form-radiobox"><input type="radio" name="time2"><span class="form-check-icon"><em>설정안함</em></span></label></div>
																		</div>
																	</div>
																	<div class="form-bottom-info type-2 font-color-black">*위 가격표에 표시된 무게가 넘는 아이를 위한 kg당 추가요금이 있을 경우</div>
																</div>
															</div>
														</div>
														<!-- 설정일 경우 -->
														<div class="basic-data-group middle" style="display:block;">
															<div class="grid-layout margin-14-17">
																<div class="grid-layout-inner">
																	<div class="grid-layout-cell grid-3">
																		<div class="form-group-item">
																			<div class="form-item-label">무게입력</div>
																			<div class="form-item-data">									
																				<div class="form-char">
																					<input type="text" class="form-control" placeholder="숫자 및 '.'만 입력가능">
																					<div class="char">Kg 당</div>
																				</div>
																				<div class="form-input-info">최대 8자까지 입력가능합니다.</div>
																			</div>
																		</div>
																	</div>
																	<div class="grid-layout-cell grid-3">
																		<div class="form-group-item">
																			<div class="form-item-label">금액입력</div>
																			<div class="form-item-data">									
																				<div class="form-char">
																					<div class="char-input">										
																						<input type="text" class="form-control" placeholder="숫자 및 '.'만 입력가능">
																						<div class="form-input-info">최대 8자까지 입력가능합니다.</div>
																					</div>
																					<div class="char">원 추가</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<!-- //설정일 경우 -->
													</div>
													<!-- //옵션목록이 있을 경우 -->
												</div>												
												<div class="basic-data-group">			
													<div class="form-group-item">
														<div class="form-item-label">추가설명</div>
														<div class="form-item-data type-2">
															<textarea style="height:100px;" placeholder="입력"></textarea>
															<div class="form-input-info">0/1000</div>
														</div>
													</div>
												</div>
											</div>
                                            <div class="basic-data-group vmiddle produt_section product_cat_section" style="display: none;">
                                                <div class="basic-data-group">
                                                    <div class="grid-layout margin-14-17">
                                                        <div class="grid-layout-inner">
                                                            <div class="grid-layout-cell grid-3">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">제공방식</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="grid-layout toggle-button-group">
                                                                            <div class="grid-layout-inner">
                                                                                <div class="grid-layout-cell grid-3"><label class="form-toggle-box middle auto"><input type="radio" name="offer"><em>매장상품</em></label></div>
                                                                                <div class="grid-layout-cell grid-3"><label class="form-toggle-box middle auto"><input type="radio" name="offer"><em>출장상품</em></label></div>
                                                                                <div class="grid-layout-cell grid-3"><label class="form-toggle-box middle auto"><input type="radio" name="offer"><em>출장/매장</em></label></div>
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
                                                        <h4 class="con-title">미용</h4>
                                                    </div>
                                                    <div class="basic-data-group vvsmall2">
                                                        <div class="form-group-item row">
                                                            <div class="form-item-label">무게</div>
                                                            <div class="form-item-data">
                                                                <div class="form-check-group">
                                                                    <div class="form-check-inner">
                                                                        <div class="check-cell"><label class="form-radiobox"><input type="radio" name="time2"><span class="form-check-icon"><em>사용</em></span></label></div>
                                                                        <div class="check-cell"><label class="form-radiobox"><input type="radio" name="time2" checked=""><span class="form-check-icon"><em>미사용</em></span></label></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="basic-data-group none" style="display:block;">
                                                        <div class="basic-data-group middle">
                                                            <div class="read-table">
                                                                <div class="read-table-unit top">(단위:원)</div>
                                                                <table>
                                                                    <colgroup>
                                                                        <col style="width:auto;">
                                                                        <col style="width:auto;">
                                                                        <col style="width:auto;">
                                                                    </colgroup>
                                                                    <thead>
                                                                    <tr>
                                                                        <th>무게 당 추가 금액</th>
                                                                        <th>단모</th>
                                                                        <th>장모</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <select>
                                                                                    <option value="">선택</option>
                                                                                    <option value="">선택</option>
                                                                                    <option value="">선택</option>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <select>
                                                                                    <option value="">선택</option>
                                                                                    <option value="">선택</option>
                                                                                    <option value="">선택</option>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <select>
                                                                                    <option value="">선택</option>
                                                                                    <option value="">선택</option>
                                                                                    <option value="">선택</option>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="basic-data-group middle">
                                                            <div class="grid-layout btn-grid-group">
                                                                <div class="grid-layout-inner justify-content-end">
                                                                    <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small">구간추가</button></div>
                                                                    <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small">구간삭제</button></div>
                                                                </div>
                                                            </div>
                                                            <div class="basic-data-group vvsmall4">
                                                                <div class="read-table">
                                                                    <table>
                                                                        <colgroup>
                                                                            <col style="width:auto;">
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
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <select>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                    </select>
                                                                                </div>
                                                                            </td>
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <select>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                    </select>
                                                                                </div>
                                                                            </td>
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <select>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                    </select>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <select>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                    </select>
                                                                                </div>
                                                                            </td>
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <select>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                    </select>
                                                                                </div>
                                                                            </td>
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <select>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                    </select>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <select>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                    </select>
                                                                                </div>
                                                                            </td>
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <select>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                    </select>
                                                                                </div>
                                                                            </td>
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <select>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                        <option value="">선택</option>
                                                                                    </select>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="basic-data-group">
                                                    <div class="con-title-group">
                                                        <h4 class="con-title">목욕</h4>
                                                    </div>
                                                    <div class="read-table">
                                                        <div class="read-table-unit">(단위:원)</div>
                                                        <table>
                                                            <colgroup>
                                                                <col style="width:auto;">
                                                                <col style="width:auto;">
                                                            </colgroup>
                                                            <thead>
                                                            <tr>
                                                                <th>단모</th>
                                                                <th>장모</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td class="no-padding">
                                                                    <div class="form-table-select">
                                                                        <select>
                                                                            <option value="">선택</option>
                                                                            <option value="">선택</option>
                                                                            <option value="">선택</option>
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td class="no-padding">
                                                                    <div class="form-table-select">
                                                                        <select>
                                                                            <option value="">선택</option>
                                                                            <option value="">선택</option>
                                                                            <option value="">선택</option>
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="basic-data-group">
                                                    <div class="con-title-group">
                                                        <h4 class="con-title">털 특징 별 추가요금</h4>
                                                        <div class="grid-layout btn-grid-group">
                                                            <div class="grid-layout-inner justify-content-end">
                                                                <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small">구간추가</button></div>
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
                                                                <tbody class="drag-sort-wrap">
                                                                <tr class="drag-sort-cell">
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <button type="button" class="btn-data-handler">드래그바</button>
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <input type="text" value="상품명 1" placeholder="입력">
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <select>
                                                                                <option value="">선택</option>
                                                                                <option value="">선택</option>
                                                                                <option value="">선택</option>
                                                                            </select>
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
                                                                            <input type="text" value="상품명 2" placeholder="입력">
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <select>
                                                                                <option value="">선택</option>
                                                                                <option value="">선택</option>
                                                                                <option value="">선택</option>
                                                                            </select>
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
                                                                            <input type="text" placeholder="입력">
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <select>
                                                                                <option value="">선택</option>
                                                                                <option value="">선택</option>
                                                                                <option value="">선택</option>
                                                                            </select>
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
                                                                <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small">구간추가</button></div>
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
                                                                <tbody class="drag-sort-wrap">
                                                                <tr class="drag-sort-cell">
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <button type="button" class="btn-data-handler">드래그바</button>
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <input type="text" value="상품명 1" placeholder="입력">
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <select>
                                                                                <option value="">선택</option>
                                                                                <option value="">선택</option>
                                                                                <option value="">선택</option>
                                                                            </select>
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
                                                                            <input type="text" value="상품명 2" placeholder="입력">
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <select>
                                                                                <option value="">선택</option>
                                                                                <option value="">선택</option>
                                                                                <option value="">선택</option>
                                                                            </select>
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
                                                                            <input type="text" placeholder="입력">
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <select>
                                                                                <option value="">선택</option>
                                                                                <option value="">선택</option>
                                                                                <option value="">선택</option>
                                                                            </select>
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
                                                    <div class="form-group-item">
                                                        <div class="form-item-label">추가설명</div>
                                                        <div class="form-item-data type-2">
                                                            <textarea style="height:100px;" placeholder="입력"></textarea>
                                                            <div class="form-input-info">0/1000</div>
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
								<a href="#" class="btn-page-bottom">저장하기</a>
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
    <!-- 미용구분 선택 팝업 -->
    <article id="setBeautyDivision" class="layer-pop-wrap">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">
                <div class="pop-data data-pop-view">
                    <div class="pop-header">
                        <h4 class="con-title">미용구분 선택</h4>
                    </div>
                    <div class="pop-body">
                        <div class="set-beauty-division">
                            <div class="con-title-group">
                                <h4 class="con-title">미용구분</h4>
                            </div>
                            <div class="basic-data-group vvsmall2">
                                <div class="grid-layout margin-5-12">
                                    <div class="grid-layout-inner">
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="check" class="bath"><span class="form-check-icon"><em>목욕</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="check" class="part"><span class="form-check-icon"><em>부분미용</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="check" class="bath_part"><span class="form-check-icon"><em>부분+목욕</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="check" class="sanitation"><span class="form-check-icon"><em>위생</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="check" class="sanitation_bath"><span class="form-check-icon"><em>위생+목욕</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="check" class="all"><span class="form-check-icon"><em>전체미용</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="check" class="spoting"><span class="form-check-icon"><em>스포팅</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="check" class="scissors"><span class="form-check-icon"><em>가위컷</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="check" class="summercut"><span class="form-check-icon"><em>썸머컷</em></span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 추가하기 활성화시 -->
                            <div class="basic-data-group middle beauty_add_wrap" style="display:block;">
                                <div class="form-vertical-group">
                                    <div class="form-vertical-header">
                                        <div class="grid-layout basic">
                                            <div class="grid-layout-inner flex-nowrap">
                                                <div class="grid-layout-cell flex-2"><div class="form-item-label">미용구분</div></div>
                                                <div class="grid-layout-cell flex-1"><div class="form-item-label">미용시간</div></div>
                                                <div class="grid-layout-cell flex-auto w-px-55"><div class="form-item-label">삭제</div></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-vertical-body beauty_add_table_wrap">
                                        <div class="form-vertical-cell">
                                            <div class="grid-layout basic">
                                                <div class="grid-layout-inner flex-nowrap">
                                                    <div class="grid-layout-cell flex-2">
                                                        <div class="card-check-box white">
                                                            <label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em></em></span></label>
                                                            <input type="text" class="form-transparent" placeholder="입력">
                                                        </div>
                                                    </div>
                                                    <div class="grid-layout-cell flex-1">
                                                        <select>
                                                            <option value="">30분</option>
                                                            <option value="">60분</option>
                                                            <option value="">90분</option>
                                                            <option value="">120분</option>
                                                            <option value="">150분</option>
                                                            <option value="">180분</option>
                                                            <option value="">210분</option>
                                                            <option value="">240분</option>
                                                        </select>
                                                    </div>
                                                    <div class="grid-layout-cell flex-auto w-px-55"><button type="button" class="btn-data-trash">휴지통</button></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-basic-action">
                                <button type="button" class="btn btn-outline-purple btn-basic-full beauty_add_table_add">추가하기</button>
                            </div>
                            <div class="form-bottom-info">*추가 항목은 최대 5개까지 가능합니다.</div>
                        </div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-purple"><strong>저장하기</strong></button>
                    </div>
                    <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
                </div>
            </div>
        </div>
    </article>
    <!-- //미용구분 선택 팝업 -->
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
        get_beauty_product(artist_id);
        console.log(setting_array);

        var add_html = '';
        $.each(setting_array[0].worktime, function(i,v){

            if(i == 'bath'){
                if(v.is_use == 'y'){
                    $(".bath").prop("checked",true);
                }
            }else if(i == 'part'){
                if(v.is_use == 'y'){
                    $(".part").prop("checked",true);
                }
            }else if(i == 'bath_part'){
                if(v.is_use == 'y'){
                    $(".bath_part").prop("checked",true);
                }
            }else if(i == 'sanitation'){
                if(v.is_use == 'y'){
                    $(".sanitation").prop("checked",true);
                }
            }else if(i == 'sanitation_bath'){
                if(v.is_use == 'y'){
                    $(".sanitation_bath").prop("checked",true);
                }
            }else if(i == 'all'){
                if(v.is_use == 'y'){
                    $(".all").prop("checked",true);
                }
            }else if(i == 'spoting'){
                if(v.is_use == 'y'){
                    $(".spoting").prop("checked",true);
                }
            }else if(i == 'scissors'){
                if(v.is_use == 'y'){
                    $(".scissors").prop("checked",true);
                }
            }else if(i == 'summercut'){
                if(v.is_use == 'y'){
                    $(".summercut").prop("checked",true);
                }
            }else{
                var checked = (v.is_use == 'y')? 'checked':'';
                add_html += `
                    <div class="form-vertical-cell">
                        <div class="grid-layout basic">
                            <div class="grid-layout-inner flex-nowrap">
                                <div class="grid-layout-cell flex-2">
                                    <div class="card-check-box white">
                                        <label class="form-checkbox"><input type="checkbox" name="check" ${checked}><span class="form-check-icon"><em></em></span></label>
                                        <input type="text" class="form-transparent" placeholder="입력" value="${i}">
                                    </div>
                                </div>
                                <div class="grid-layout-cell flex-1">
                                    <select>
                `;
                for(var j=30;j<=240;j=j+30){
                    var selected = (v.time == j)? 'selected':'';
                    add_html += `<option value="${j}" ${selected}>${j}분</option>`;
                }
                add_html += `
                                    </select>
                                </div>
                                <div class="grid-layout-cell flex-auto w-px-55"><button type="button" class="btn-data-trash">휴지통</button></div>
                            </div>
                        </div>
                    </div>
                `;
            }
        })
        if(add_html != ''){
            $(".beauty_add_table_wrap").html(add_html);
        }


    })

    // 상품구분 탭 클릭
    $(document).on("click",".product_tab",function(){
        $(".product_tab").removeClass("actived");
        $(this).addClass("actived");
        $(".produt_section").css("display","none");

        if($(this).hasClass('product_tab_dog')){
            $(".product_dog_section").css("display","block");
        }else if($(this).hasClass('product_tab_cat')){
            $(".product_cat_section").css("display","block");
        }
    })

    $(document).on("click",".beauty_add_table_add", function(){
        var html = `
            <div class="form-vertical-cell">
                <div class="grid-layout basic">
                    <div class="grid-layout-inner flex-nowrap">
                        <div class="grid-layout-cell flex-2">
                            <div class="card-check-box white">
                                <label class="form-checkbox"><input type="checkbox" name="check"><span class="form-check-icon"><em></em></span></label>
                                <input type="text" class="form-transparent" placeholder="입력">
                            </div>
                        </div>
                        <div class="grid-layout-cell flex-1">
                            <select>
                                <option value="">30분</option>
                                <option value="">60분</option>
                                <option value="">90분</option>
                                <option value="">120분</option>
                                <option value="">150분</option>
                                <option value="">180분</option>
                                <option value="">210분</option>
                                <option value="">240분</option>
                            </select>
                        </div>
                        <div class="grid-layout-cell flex-auto w-px-55"><button type="button" class="btn-data-trash">휴지통</button></div>
                    </div>
                </div>
            </div>
        `;
        $(".beauty_add_table_wrap").append(html);
    })
</script>
</body>
</html>