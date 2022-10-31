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

$second_type = (isset($_GET['second_type']))? $_GET['second_type'] : "소형견미용";
$direct_title = (isset($_GET['direct_title']))? $_GET['direct_title'] : "";

$pet_type = (isset($_GET['is_cat']))? $_GET['is_cat'] : "dog";

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
											<form id="dogForm" class="basic-data-group vmiddle produt_section product_dog_section">
                                                <input type="hidden" name="partner_id" value="<?=$artist_id?>">
												<div class="basic-data-group">
													<div class="grid-layout margin-14-17">
														<div class="grid-layout-inner">
															<div class="grid-layout-cell grid-3">
																<div class="form-group-item">
																	<div class="form-item-label">제공방식</div>
																	<div class="form-item-data type-2">
																		<div class="grid-layout toggle-button-group">
																			<div class="grid-layout-inner">
																				<div class="grid-layout-cell grid-3"><label class="form-toggle-box middle auto"><input type="radio" class="dog_offer0" name="offer" value="0" checked><em>매장상품</em></label></div>
																				<div class="grid-layout-cell grid-3"><label class="form-toggle-box middle auto"><input type="radio" class="dog_offer1" name="offer" value="1"><em>출장상품</em></label></div>
																				<div class="grid-layout-cell grid-3"><label class="form-toggle-box middle auto"><input type="radio" class="dog_offer2" name="offer" value="2"><em>출장/매장</em></label></div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="grid-layout-cell grid-3">
																<div class="form-group-item">
																	<div class="form-item-label">상품명</div>
																	<div class="form-item-data type-2">
																		<select name="second_type" class="second_type">
																			<option value="소형견미용" <?php echo ($second_type == '소형견미용')? 'selected' : ''; ?>>소형견미용</option>
																			<option value="중형견미용" <?php echo ($second_type == '중형견미용')? 'selected' : ''; ?>>중형견미용</option>
																			<option value="대형견미용" <?php echo ($second_type == '대형견미용')? 'selected' : ''; ?>>대형견미용</option>
																			<option value="특수견미용" <?php echo ($second_type == '특수견미용')? 'selected' : ''; ?>>특수견미용</option>
																			<option value="직접입력" <?php echo ($second_type == '직접입력' || ($second_type != '소형견미용' && $second_type != '중형견미용' && $second_type != '대형견미용' && $second_type != '특수견미용'))? 'selected' : ''; ?>>직접입력</option>
																		</select>
																	</div>
																</div>
															</div>
															<!-- 직접 입력시 -->
															<div class="grid-layout-cell grid-3 direct_title_wrap" style="display:<?php echo ($second_type == '직접입력' || ($second_type != '소형견미용' && $second_type != '중형견미용' && $second_type != '대형견미용' && $second_type != '특수견미용'))? 'block' : 'none'; ?>;">
																<div class="form-group-item">
																	<div class="form-item-data type-2">
																		<input type="text" name="direct_title" value="<?php echo ($second_type == '직접입력')? $direct_title : (($second_type != '소형견미용' && $second_type != '중형견미용' && $second_type != '대형견미용' && $second_type != '특수견미용')? $second_type : ''); ?>" placeholder="입력"/>
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
<!--													<div class="basic-info" style="display:block;">목욕 · 부분미용</div>-->
													<div class="basic-data-group vsmall">
														<div class="grid-layout margin-14-17">
															<div class="grid-layout-inner">
																<div class="grid-layout-cell grid-3">
																	<button type="button" class="btn btn-outline-purple btn-basic-full" onclick="pop.open('setBeautyDivision')">미용구분 선택</button>
																</div>
															</div>
														</div>
													</div>
													<!-- 옵션목록이 있을 경우 -->
													<div class="basic-data-group vmiddle" style="display:block;">
														<div class="basic-data-group middle">
															<div class="form-group-item">
                                                                <div class="basic-data-group middle huge_weight_wrap" style="display: none;">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">Kg당 추가요금설정(개별등록)</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="form-check-group">
                                                                                <div class="form-check-inner">
                                                                                    <div class="check-cell"><label class="form-radiobox"><input type="radio" class="huge_weight is_kgs_by_price1" name="is_kgs_by_price" value="1"><span class="form-check-icon"><em>설정</em></span></label></div>
                                                                                    <div class="check-cell"><label class="form-radiobox"><input type="radio" class="huge_weight is_kgs_by_price0" name="is_kgs_by_price" value="0" checked><span class="form-check-icon"><em>설정안함</em></span></label></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
																<div class="form-item-label">
																	옵션목록
																	<div class="grid-layout btn-grid-group add_del_wrap">
																		<div class="grid-layout-inner justify-content-end">
																			<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small dog_add_table">구간추가</button></div>
																			<div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small dog_del_table">구간삭제</button></div>
																		</div>
																	</div>		
																</div>
																<div class="form-item-data type-2">		
																	<div class="read-table">
																		<table class="dog_table_wrap">
																			<colgroup class="col_table">
																				<col style="width:auto;">
																				<col style="width:auto;">
																				<col style="width:auto;">
																				<col style="width:auto;">
																				<col style="width:auto;">
																				<col style="width:auto;">
																				<col style="width:auto;">
																			</colgroup>
																			<thead>
																				<tr class="thead_table">
																					<th>무게</th>
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
														<div class="basic-data-group middle is_over_kgs_warp">
															<div class="form-group-item">
																<div class="form-item-label">Kg당 추가요금설정(추가옵션1)</div>
																<div class="form-item-data type-2">									
																	<div class="form-check-group">
																		<div class="form-check-inner">
																			<div class="check-cell"><label class="form-radiobox"><input type="radio" class="dog_over_kg is_over_kgs1" name="is_over_kgs" value="1"><span class="form-check-icon"><em>설정</em></span></label></div>
																			<div class="check-cell"><label class="form-radiobox"><input type="radio" class="dog_over_kg is_over_kgs0" name="is_over_kgs" value="0"><span class="form-check-icon"><em>설정안함</em></span></label></div>
																		</div>
																	</div>
																	<div class="form-bottom-info type-2 font-color-black">*위 가격표에 표시된 무게가 넘는 아이를 위한 kg당 추가요금이 있을 경우</div>
																</div>
															</div>
														</div>
														<!-- 설정일 경우 -->
														<div class="basic-data-group middle dog_over_kgs_wrap" style="display:block;">
															<div class="grid-layout margin-14-17">
																<div class="grid-layout-inner">
																	<div class="grid-layout-cell grid-3">
																		<div class="form-group-item">
																			<div class="form-item-label">무게입력</div>
																			<div class="form-item-data">									
																				<div class="form-char">
																					<input type="number" class="form-control what_over_kgs" name="what_over_kgs" placeholder="숫자 및 '.'만 입력가능">
																					<div class="char">Kg 이상</div>
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
                                                                                    <div class="char">Kg 당</div>
																					<div class="char-input">
																						<input type="number" class="form-control over_kgs_price" name="over_kgs_price" placeholder="숫자 및 '.'만 입력가능">
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
															<textarea style="height:100px;" class="dog_add_comment" placeholder="입력"></textarea>
<!--															<div class="form-input-info">0/1000</div>-->
														</div>
													</div>
												</div>
											</form>
                                            <form id="catForm" class="basic-data-group vmiddle produt_section product_cat_section" style="display: none;">
                                                <input type="hidden" name="customer_id" value="<?=$artist_id?>">
                                                <div class="basic-data-group">
                                                    <div class="grid-layout margin-14-17">
                                                        <div class="grid-layout-inner">
                                                            <div class="grid-layout-cell grid-3">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">제공방식</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="grid-layout toggle-button-group">
                                                                            <div class="grid-layout-inner">
                                                                                <div class="grid-layout-cell grid-3"><label class="form-toggle-box middle auto"><input type="radio" class="cat_offer0" name="offer" value="0" checked><em>매장상품</em></label></div>
                                                                                <div class="grid-layout-cell grid-3"><label class="form-toggle-box middle auto"><input type="radio" class="cat_offer1" name="offer" value="1"><em>출장상품</em></label></div>
                                                                                <div class="grid-layout-cell grid-3"><label class="form-toggle-box middle auto"><input type="radio" class="cat_offer2" name="offer" value="2"><em>출장/매장</em></label></div>
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
                                                                        <div class="check-cell"><label class="form-radiobox"><input type="radio" class="cat_is_use_weight cat_is_use_weight1" name="is_use_weight" value="1"><span class="form-check-icon"><em>사용</em></span></label></div>
                                                                        <div class="check-cell"><label class="form-radiobox"><input type="radio" class="cat_is_use_weight cat_is_use_weight2" name="is_use_weight" value="2" checked><span class="form-check-icon"><em>미사용</em></span></label></div>
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
                                                                                <select class="increase_price" name="increase_price">
                                                                                    <?php
                                                                                    for ($pi = 0; $pi <= 200000; $pi = $pi + 500) {
                                                                                        echo "<option value='" . $pi . "'>".number_format($pi)."</option>";
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <select class="short_price" name="short_price">
                                                                                    <?php
                                                                                    for ($pi = 0; $pi <= 500000; $pi = $pi + 500) {
                                                                                        echo "<option value='" . $pi . "'>".number_format($pi)."</option>";
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                        <td class="no-padding">
                                                                            <div class="form-table-select">
                                                                                <select class="long_price" name="long_price">
                                                                                    <?php
                                                                                    for ($pi = 0; $pi <= 500000; $pi = $pi + 500) {
                                                                                        echo "<option value='" . $pi . "'>".number_format($pi)."</option>";
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="basic-data-group middle cat_use_weight_wrap" style="display: none;">
                                                            <div class="grid-layout btn-grid-group">
                                                                <div class="grid-layout-inner justify-content-end">
                                                                    <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small cat_add_table">구간추가</button></div>
                                                                    <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small cat_del_table">구간삭제</button></div>
                                                                </div>
                                                            </div>
                                                            <div class="basic-data-group vvsmall4">
                                                                <div class="read-table">
                                                                    <table class="cat_table_wrap">
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
                                                                        <tr class="cat_table_tr">
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <select name="section[]">
                                                                                        <?php
                                                                                        for ($pi = 0; $pi <= 50; $pi = $pi + 0.1) {
                                                                                            echo "<option value='" . $pi . "'>~".$pi."kg</option>";
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </td>
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <input type="text" class="short_weight_price" disabled value="0">
                                                                                </div>
                                                                            </td>
                                                                            <td class="no-padding">
                                                                                <div class="form-table-select">
                                                                                    <input type="text" class="long_weight_price" disabled value="0">
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
                                                                        <select class="shower_price" name="shower_price">
                                                                            <?php
                                                                            for ($pi = 0; $pi <= 500000; $pi = $pi + 500) {
                                                                                echo "<option value='" . $pi . "'>".number_format($pi)."</option>";
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </td>
                                                                <td class="no-padding">
                                                                    <div class="form-table-select">
                                                                        <select class="shower_price_long" name="shower_price_long">
                                                                            <?php
                                                                            for ($pi = 0; $pi <= 500000; $pi = $pi + 500) {
                                                                                echo "<option value='" . $pi . "'>".number_format($pi)."</option>";
                                                                            }
                                                                            ?>
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
                                                        <h4 class="con-title">추가요금</h4>
                                                        <div class="grid-layout btn-grid-group">
                                                            <div class="grid-layout-inner justify-content-end">
                                                                <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small cat_plus_add_table">구간추가</button></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="basic-data-group vvsmall">
                                                        <div class="read-table">
                                                            <table>
                                                                <colgroup>
                                                                    <col style="width:auto;">
                                                                    <col style="width:30%;">
                                                                    <col style="width:10%;">
                                                                </colgroup>
                                                                <thead>
                                                                <tr>
                                                                    <th>상품명</th>
                                                                    <th>가격 (단위:원)</th>
                                                                    <th>삭제</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="drag-sort-wrap cat_plus_table_wrap">
                                                                <tr class="drag-sort-cell">
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <input type="text" name="" value="발톱" disabled placeholder="입력">
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <select class="toenail_price" name="toenail_price">
                                                                                <?php
                                                                                for ($pi = 0; $pi <= 500000; $pi = $pi + 500) {
                                                                                    echo "<option value='" . $pi . "'>".number_format($pi)."</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding text-align-center vertical-center">
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
                                                                <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small cat_place_plus_add_table">구간추가</button></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="basic-data-group vvsmall">
                                                        <div class="read-table">
                                                            <table>
                                                                <colgroup>
                                                                    <col style="width:auto;">
                                                                    <col style="width:30%;">
                                                                    <col style="width:10%;">
                                                                </colgroup>
                                                                <thead>
                                                                <tr>
                                                                    <th>상품명</th>
                                                                    <th>가격 (단위:원)</th>
                                                                    <th>삭제</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="drag-sort-wrap cat_place_plus_table_wrap">
                                                                <tr class="drag-sort-cell">
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <input type="text" name="" value="털엉킴" disabled placeholder="입력">
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <select class="hair_clot_price" name="hair_clot_price">
                                                                                <?php
                                                                                for ($pi = 0; $pi <= 500000; $pi = $pi + 500) {
                                                                                    echo "<option value='" . $pi . "'>".number_format($pi)."</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding text-align-center vertical-center">
                                                                    </td>
                                                                </tr>
                                                                <tr class="drag-sort-cell">
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <input type="text" name="" value="사나움" disabled placeholder="입력">
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <select name="ferocity_price">
                                                                                <?php
                                                                                for ($pi = 0; $pi <= 500000; $pi = $pi + 500) {
                                                                                    echo "<option value='" . $pi . "'>".number_format($pi)."</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding text-align-center vertical-center">
                                                                    </td>
                                                                </tr>
                                                                <tr class="drag-sort-cell cat_place_plus_table_tr">
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <input type="text" name="addition_work_product_text[]" value="" placeholder="입력">
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding">
                                                                        <div class="form-table-select">
                                                                            <select name="addition_work_product_price[]">
                                                                                <?php
                                                                                for ($pi = 0; $pi <= 500000; $pi = $pi + 500) {
                                                                                    echo "<option value='" . $pi . "'>".number_format($pi)."</option>";
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </td>
                                                                    <td class="no-padding text-align-center vertical-center">
                                                                        <button type="button" class="btn-item-del addition_work_product_del"><span class="icon icon-size-36 icon-trash"></span></button>
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
                                                            <textarea style="height:100px;" class="cat_comment" placeholder="입력"></textarea>
                                                            <div class="form-input-info">0/1000</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
								<a href="javascript:open_submit_pop();" class="btn-page-bottom">저장하기</a>
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
    <article id="savePop" class="layer-pop-wrap">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">
                <div class="pop-data alert-pop-data">
                    <div class="pop-body">
                        <div class="msg-txt">저장하시겠습니까?</div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-confirm" onclick="save_product();">저장</button>
                        <button type="button" class="btn btn-cancel" onclick="pop.close();">취소</button>
                    </div>
                </div>

            </div>
        </div>
    </article>
    <!-- 미용구분 선택 팝업 -->
    <form id="setBeautyDivision" class="layer-pop-wrap">
        <input type="hidden" name="partner_id" value="<?=$artist_id?>">
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
                                                <label class="form-checkbox"><input type="checkbox" name="worktime_bath" class="bath" value="y"><span class="form-check-icon"><em>목욕</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="worktime_part" class="part" value="y"><span class="form-check-icon"><em>부분미용</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="worktime_bath_part" class="bath_part" value="y"><span class="form-check-icon"><em>부분+목욕</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="worktime_sanitation" class="sanitation" value="y"><span class="form-check-icon"><em>위생</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="worktime_sanitation_bath" class="sanitation_bath" value="y"><span class="form-check-icon"><em>위생+목욕</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="worktime_all" class="all" value="y"><span class="form-check-icon"><em>전체미용</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="worktime_spoting" class="spoting" value="y"><span class="form-check-icon"><em>스포팅</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="worktime_scissors" class="scissors" value="y"><span class="form-check-icon"><em>가위컷</em></span></label>
                                            </div>
                                        </div>
                                        <div class="grid-layout-cell grid-2">
                                            <div class="card-check-box">
                                                <label class="form-checkbox"><input type="checkbox" name="worktime_summercut" class="summercut" value="y"><span class="form-check-icon"><em>썸머컷</em></span></label>
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
                        <button type="button" class="btn btn-purple" onclick="save_worktime();"><strong>저장하기</strong></button>
                    </div>
                    <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
                </div>
            </div>
        </div>
    </form>
    <!-- //미용구분 선택 팝업 -->
</div>
<!-- //wrap -->
<script src="../static/js/Sortable.min.js"></script>
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/setting.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    var add_worktime = 0;
    var second_type = '<?=$second_type ?>';
    var direct_title = '<?=$direct_title ?>';
    var pet_type = '<?=$pet_type ?>';
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        gnb_actived('gnb_detail_wrap', 'gnb_merchandise');
        get_beauty_product(artist_id);

        // 기본 틀 뿌려주기(고양이 상품은 있으면 보여준다)
        view_add_product();

        // 강아지 상품 수정으로 들어왔을때
        if(second_type != ''){
            if(second_type == '대형견미용'){
                $(".huge_weight_wrap").css("display","block");
                $(".direct_title_wrap").css("display", "none");
            }else{
                $(".is_kgs_by_price0").prop("checked",true);
                $(".dog_over_kgs_wrap").css("display","block");
                $(".is_over_kgs_warp").css("display","block");
            }
            get_dog_type_product(artist_id, second_type, direct_title);
        }
        //console.log(setting_array);

    })

    // 상품구분 탭 클릭
    $(document).on("click",".product_tab",function(){
        $(".product_tab").removeClass("actived");
        $(this).addClass("actived");
        $(".produt_section").css("display","none");

        if($(this).hasClass('product_tab_dog')){
            $(".product_dog_section").css("display","block");
            pet_type = 'dog';
        }else if($(this).hasClass('product_tab_cat')){
            $(".product_cat_section").css("display","block");
            pet_type = 'cat';
        }
    })

    // 미용구분 추가
    $(document).on("click",".beauty_add_table_add", function(){
        if(add_worktime < 5){

            var html = `
            <div class="form-vertical-cell">
                <div class="grid-layout basic">
                    <div class="grid-layout-inner flex-nowrap">
                        <div class="grid-layout-cell flex-2">
                            <div class="card-check-box white">
                                <label class="form-checkbox"><input type="checkbox" name="add_worktime_${add_worktime}" value="y"><span class="form-check-icon"><em></em></span></label>
                                <input type="text" class="form-transparent" name="add_worktime_title_${add_worktime}" placeholder="입력">
                            </div>
                        </div>
                        <div class="grid-layout-cell flex-1">
                            <select name="add_worktime_time_${add_worktime}">
                                <option value="30">30분</option>
                                <option value="60">60분</option>
                                <option value="90">90분</option>
                                <option value="12">120분</option>
                                <option value="150">150분</option>
                                <option value="180">180분</option>
                                <option value="210">210분</option>
                                <option value="240">240분</option>
                            </select>
                        </div>
                        <div class="grid-layout-cell flex-auto w-px-55"><button type="button" class="btn-data-trash worktime_del">휴지통</button></div>
                    </div>
                </div>
            </div>
        `;
            add_worktime ++;
        $(".beauty_add_table_wrap").append(html);
        }
    })

    //////////////////////////////////////////////////// 강아지상품
    // 미용구분 구간삭제
    $(document).on("click",".worktime_del",function(){
        add_worktime--;
        $(this).parents('.form-vertical-cell').remove();
        //pop.open('setBeautyDivision');
        setTimeout(() => pop.open('setBeautyDivision'), 10);
    })

    // 미용구분 저장
    function save_worktime(){
        var postData = decodeURIComponent($("#setBeautyDivision").serialize());
        postData += '&mode=put_worktime_type';
        console.log(postData);
        put_worktime_type(postData);
    }

    // 직접입력 선택시 입력칸 노출
    $(document).on("change",".second_type",function(){
        if($(this).val() == '직접입력') {
            $(".direct_title_wrap").css("display", "block");
            $(".huge_weight_wrap").css("display","none");
            $(".is_kgs_by_price0").prop("checked",true);
            $(".dog_over_kgs_wrap").css("display","block");
            $(".is_over_kgs_warp").css("display","block");
        }else if($(this).val() == '대형견미용'){
            $(".direct_title_wrap").css("display","none");
            $(".huge_weight_wrap").css("display","block");
            $(".dog_over_kgs_wrap").css("display","block");
            $(".is_over_kgs_warp").css("display","block");
            get_dog_type_product(artist_id, $(this).val(), '');
        }else{
            $(".direct_title_wrap").css("display","none");
            $(".huge_weight_wrap").css("display","none");
            $(".is_kgs_by_price0").prop("checked",true);
            $(".dog_over_kgs_wrap").css("display","block");
            $(".is_over_kgs_warp").css("display","block");
            get_dog_type_product(artist_id, $(this).val(), '');
        }
    })

    // 강아지 상품 구간 추가
    $(document).on("click",".dog_add_table",function(){
        var bt_div = $('.dog_table_tr:last-child').clone();
        $('.dog_table_wrap').append(bt_div);
    })

    // 강아지 상품 구간 삭제
    $(document).on('click','.dog_del_table',function(){
        var total_cnt = $('.dog_table_tr').length;
        if(total_cnt > 1) {
            $('.dog_table_tr:last-child').remove();
        }
    });

    // kg 추가요금설정
    $(document).on("change",".dog_over_kg",function(){
        console.log('test');
        if($(this).val() == '0'){
            $(".dog_over_kgs_wrap").css("display","none");
            $(".huge_weight_wrap").css("display","block");
        }else{
            $(".dog_over_kgs_wrap").css("display","block");
            $(".huge_weight_wrap").css("display","none");
        }
    })

    // 대형견 1kg당 추가요금설정
    $(document).on("change",".huge_weight",function(){
        //console.log('test');
        if($(this).val() == '0'){
            $(".add_del_wrap").css("display","block");
            $(".is_over_kgs_warp").css("display","block");
            $(".kgs_arr").prop("disabled",false);
        }else{
            $(".add_del_wrap").css("display","none");
            $(".kgs_arr").val('1.0');
            //$(".kgs_arr").prop("disabled",true);
            $(".is_over_kgs_warp").css("display","none");
            view_add_product();
        }
    })

    //////////////////////////////////////////////////// 고양이상품
    // 무게별 사용 여부
    $(document).on("click",".cat_is_use_weight",function(){
        if($(this).val()==1){
            $(".cat_use_weight_wrap").css("display","block");
        }else{
            $(".cat_use_weight_wrap").css("display","none");
        }
    })

    // 무게별 사용 첫 칸 무게 넣기
    $(document).on("change",".short_price",function(){
        $(".short_weight_price").val($(this).val());
    })
    $(document).on("change",".long_price",function(){
        $(".long_weight_price").val($(this).val());
    })

    // 무게별 사용구간 추가
    $(document).on("click",".cat_add_table",function(){
        var bt_div = $('.cat_table_tr:last-child').clone();
        var short_price = $('.cat_table_tr:last-child .short_weight_price').val();
        var long_price = $('.cat_table_tr:last-child .long_weight_price').val();
        $('.cat_table_wrap').append(bt_div);
        $('.cat_table_tr:last-child .short_weight_price').val(parseInt(short_price) + parseInt($(".increase_price").val()));
        $('.cat_table_tr:last-child .long_weight_price').val(parseInt(long_price) + parseInt($(".increase_price").val()));
    })

    // 무게별 사용구간 삭제
    $(document).on('click','.cat_del_table',function(){
        var total_cnt = $('.cat_table_tr').length;
        if(total_cnt > 1) {
            $('.cat_table_tr:last-child').remove();
        }
    });

    // 털특징별 사용구간 추가
    $(document).on("click",".cat_plus_add_table",function(){
        var html = `
            <tr class="drag-sort-cell cat_plus_table_tr">
                <td class="no-padding">
                    <div class="form-table-select">
                        <input type="text" name="addition_option_product_text[]" value="" placeholder="입력">
                    </div>
                </td>
                <td class="no-padding">
                    <div class="form-table-select">
                        <select name="addition_option_product_price[]">`;
                        for (var i = 0; i <= 500000; i = i + 500) {
                            html += `<option value="${i}">${i.format()}</option>`;
                        }
        html +=`
                        </select>
                    </div>
                </td>
                <td class="no-padding text-align-center vertical-center">
                    <button type="button" class="btn-item-del addition_option_product_del"><span class="icon icon-size-36 icon-trash"></span></button>
                </td>
            </tr>
        `;
        $('.cat_plus_table_wrap').append(html);
    })

    // 털특징별 사용구간 삭제
    $(document).on("click",".addition_option_product_del",function(){
        $(this).parents('.cat_plus_table_tr').remove();
    })

    // 현장판단 사용구간 추가
    $(document).on("click",".cat_place_plus_add_table",function(){
        var html = `
            <tr class="drag-sort-cell cat_plus_table_tr">
                <td class="no-padding">
                    <div class="form-table-select">
                        <input type="text" name="addition_work_product_text[]" value="" placeholder="입력">
                    </div>
                </td>
                <td class="no-padding">
                    <div class="form-table-select">
                        <select name="addition_work_product_price[]">`;
        for (var i = 0; i <= 500000; i = i + 500) {
            html += `<option value="${i}">${i.format()}</option>`;
        }
        html +=`
                        </select>
                    </div>
                </td>
                <td class="no-padding text-align-center vertical-center">
                    <button type="button" class="btn-item-del addition_work_product_del"><span class="icon icon-size-36 icon-trash"></span></button>
                </td>
            </tr>
        `;
        $('.cat_place_plus_table_wrap').append(html);
    })

    // 현장판단 사용구간 삭제
    $(document).on("click",".addition_work_product_del",function(){
        $(this).parents('.cat_place_plus_table_tr').remove();
    })

   // 저장팝업
    function open_submit_pop(){
        pop.open('savePop');
    }

    // 저장하기
    function save_product(){
        if(pet_type == 'cat'){
            var dataPost = decodeURIComponent($("#catForm").serialize());
            dataPost += '&add_comment='+str_to_db($(".cat_comment").val());
            dataPost += '&mode=post_product_cat';
            console.log(dataPost);
            post_product_cat(dataPost);
        }else{
            var dataPost = decodeURIComponent($("#dogForm").serialize());
            dataPost += '&add_comment='+str_to_db($(".dog_add_comment").val());
            dataPost += '&mode=post_product_dog';
            console.log(dataPost);
            post_product_dog(dataPost);
        }
    }

    // 상담 클릭
    $(document).on("click",".is_consult",function(){
        if($(this).prop("checked") == true){
            $(this).parents(".form-table-select").children(".not_consult").prop("disabled",true);
        }else{
            $(this).parents(".form-table-select").children(".not_consult").prop("disabled",false);
        }

        //console.log(test);
    })

</script>
</body>
</html>