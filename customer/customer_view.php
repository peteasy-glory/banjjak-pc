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
								<h3 class="card-header-title" id="customer_view_cellphone"></h3>
								<div class="card-header-right">
									<a href="#" class="btn btn-small-size btn-outline-gray btn-basic-vsmall btn-inline" onclick="pop.open('deleteCustomer')">삭제</a>
								</div>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="basic-data-group large">
										<div class="con-title-group">
											<h4 class="con-title">고객 정보</h4>
										</div>
										<div class="customer-view-user-info">
											<div class="customer-user-table" id="user_table">

											</div>
										</div>
									</div>
									<div class="basic-data-group large">
										<div class="con-title-group">
											<h4 class="con-title">펫 정보</h4>
										</div>
										<div class="basic-data-group vvsmall">
											<div class="grid-layout btn-grid-group">
												<div class="grid-layout-inner" id="pet_table">
													<!-- btn-toggle-button 클래스에 actived클래스 추가시 활성화 -->

												</div>
											</div>
										</div>
									</div>
									<div class="basic-data-group large">
										<div class="con-title-group">
											<h4 class="con-title">예약동물 정보</h4>
											<div class="con-title-btns">
												<div class="btns-cell"><button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline" onclick="pop.open('reserveBeautyGalleryPop')">미용 갤러리</button></div>
												<div class="btns-cell" id="beauty_agree_view"><button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline">미용 동의서</button></div>
<!--												<div class="btns-cell"><button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline">호텔 동의서 작성</button></div>-->
											</div>
										</div>
										<div class="customer-view-pet-info detail-toggle-parents">
											<div class="item-thumb">
												<div class="user-thumb large"><img src="" id="target_pet_img" alt=""></div>
												<div class="item-thumb-ui"><a href="#" class="btn btn-outline-gray btn-vsmall-size btn-inline" id="modify_pet">펫 정보 수정</a></div>
                                                <div class="item-thumb-ui"><a href="#" class="btn btn-outline-gray btn-vsmall-size btn-inline" id="modify_pet">펫 정보 삭제</a></div>
											</div>
											<div class="item-user-data">
												<div class="grid-layout flex-table">
													<div class="grid-layout-inner">
														<div class="grid-layout-cell grid-2">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">이름</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner" id="target_pet_name">
																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">품종</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner" id="target_pet_type">
																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">성별</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner" id="target_pet_gender">

																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">무게</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner" id="target_pet_weight">
																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">생일</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner" id="target_pet_birthday">
																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">중성화</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner" id="target_pet_neutral">

																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2 toggle">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">미용경험</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner" id="target_pet_beauty_exp">
																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2 toggle">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">예방접종</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner" id="target_pet_vaccination">

																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2 toggle">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">입질</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner" id="target_pet_bite">

																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2 toggle">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">슬개골 탈구</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner" id="target_pet_luxation">
																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2 toggle">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">특이사항</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner" id="target_pet_special">

																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2 toggle">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">싫어하는 부위</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner" id="target_pet_disliked">

																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2 toggle">
															<div class="flex-table-item">
																<div class="flex-table-title"><div class="txt">기타</div></div>
																<div class="flex-table-data">
																	<div class="flex-table-data-inner" id="target_pet_etc">

																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="item-action">
												<button type="button" class="btn-detail-toggle">펫 정보 자세히 보기</button>
											</div>
										</div>
										<div class="basic-data-group middle text-align-center">
											<a href="#" class="btn btn-purple btn-inline btn-basic-wide" id="direct_reserve_btn" onclick="direct_reserve(this)">즉시 예약</a>
										</div>
										<div class="form-bottom-info text-align-center" ><strong>*[즉시예약]</strong>은 주간 스케줄에서만 사용 가능</div>
									</div>
									<div class="basic-data-group large">
										<div class="con-title-group">
											<h4 class="con-title">특이사항</h4>
										</div>
										<div class="basic-data-group vvsmall2 note-toggle-group">
											<div class="grid-layout margin-5-17 note-toggle-list">
												<div class="grid-layout-inner" id="special_note">


												</div>
											</div>
											<div class="note-toggle-ui">
												<button type="button" class="btn-note-toggle">더보기</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="data-col-right">
						<div class="basic-data-card">
							<div class="card-header">
								<h3 class="card-header-title">이용내역</h3>
							</div>
							<div class="card-body">
								<div>
									<table class="customer-table small">
										<colgroup>
											<col style="width:28%">
											<col style="width:22%">
											<col style="width:18%">
											<col style="width:16%">
											<col style="width:16%">
										</colgroup>
										<thead>
											<tr>
												<th rowspan="2">펫이름</th>
												<th rowspan="2">미용 일시</th>
												<th rowspan="2">내역</th>
												<th colspan="2">총 이용내역</th>
											</tr>
											<tr>
												<th>카드</th>
												<th>현금</th>
											</tr>
										</thead>
										<tbody id="usage_history_list">
											<!-- 하나의 아이템 -->



										</tbody>
									</table>
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

<article id="reserveBeautyGalleryPop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data data-pop-view large">
                <div class="pop-header">
                    <h4 class="con-title">미용 갤러리</h4>
                </div>
                <div class="pop-body">
                    <div class="reserve-beauty-gallery">
                        <div class="shop-gate-picture-select">
                            <div class="list-inner img_wrap" id="beauty_gal_wrap" style="min-height:176px;">

                            </div>
                        </div>
                        <div class="picture-add-info">이미지는 최대 25개까지 등록할 수 있습니다.<br>gif, png, jpg, jpeg 형식의 절차 이미지만 등록됩니다.</div>
                    </div>
                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
</article>


<article id="petAddPop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data data-pop-view large">
                <div class="pop-header">
                    <h4 class="con-title">펫 추가하기</h4>
                    <input type="hidden" id="customer_cellphone" value="">
                </div>
                <div class="pop-body">
                    <div class="basic-data-group">
                        <div class="con-title-group">
                            <h4 class="con-title">펫 정보</h4>
                        </div>
                        <div class="form-group">
                            <div class="grid-layout margin-14-17">
                                <div class="grid-layout-inner">
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label"><em class="need">*</em>펫 이름</div>
                                            <div class="form-item-data">
                                                <input type="text" class="form-control" maxlength="20" id="customer_name" placeholder="펫 이름 입력">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label"><em class="need">*</em>품종</div>
                                            <div class="form-item-data type-2">
                                                <div class="pet-breed-select-wrap">
                                                    <div class="pet-breed-select">
                                                        <div class="breed-select">
                                                            <label class="form-toggle-box" for="breed1"><input type="radio" name="breed" class="load-pet-type" value="dog" id="breed1"><em><span>강아지</span></em></label>
                                                            <label class="form-toggle-box" for="breed2"><input type="radio" name="breed" class="load-pet-type" value="cat" id="breed2"><em><span>고양이</span></em></label>
                                                        </div>
                                                    </div>
                                                    <div class="pet-breed-sort">
                                                        <div style="display:block">
                                                            <select id="breed_select">
                                                                <option value="">선택</option>
                                                            </select>
                                                            <div class="pet-breed-other" id="breed_other_box" style="display:none;">
                                                                <input type="text" placeholder="입력" id="breed_other" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">생일</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout margin-12">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="birthday_year" class="birthday">

                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="birthday_month" class="birthday">

                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="birthday_date">

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">성별 선택</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout toggle-button-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="gender1"><input type="radio" name="gender" value="남아" id="gender1"><em>남아</em></label></div>
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="gender2"><input type="radio" name="gender" value="여아" id="gender2"><em>여아</em></label></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">중성화</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout toggle-button-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="neutralize1"><input type="radio" name="neutralize" value="0" id="neutralize1"><em>X</em></label></div>
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="neutralize2"><input type="radio" name="neutralize" value="1" id="neutralize2"><em>O</em></label></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label"><em class="need">*</em>몸무게</div>
                                            <div class="form-item-data type-2">
                                                <div class="form-flex">
                                                    <select class="inline-block" id="weight1">

                                                    </select>
                                                    <div class="form-unit-point">.</div>
                                                    <select class="inline-block" id="weight2">
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                    <div class="form-unit-label">kg</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">미용 경험</div>
                                            <div class="form-item-data type-2">
                                                <select id="beauty_exp">
                                                    <option value="0">선택</option>
                                                    <option value="없음">없음</option>
                                                    <option value="1회">1회</option>
                                                    <option value="2회">2회</option>
                                                    <option value="3회 이상">3회 이상</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">예방 접종</div>
                                            <div class="form-item-data type-2">
                                                <select id="vaccination">
                                                    <option value="0">선택</option>
                                                    <option value="2차 이하">2차 이하</option>
                                                    <option value="3차">3차 완료</option>
                                                    <option value="4차">4차 완료</option>
                                                    <option value="5차">5차 완료</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">입질</div>
                                            <div class="form-item-data type-2">
                                                <select id="bite">
                                                    <option value="0">선택</option>
                                                    <option value="안해요">안해요</option>
                                                    <option value="해요">해요</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">슬개골 탈구</div>
                                            <div class="form-item-data type-2">
                                                <select id="luxation">
                                                    <option value="0">선택</option>
                                                    <option value="없음">없음</option>
                                                    <option value="1기">1기</option>
                                                    <option value="2기">2기</option>
                                                    <option value="3기">3기</option>
                                                    <option value="4기">4기</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label">특이사항</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout toggle-button-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="special1"><input type="checkbox" name="special" id="special1"><em>피부병</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="special2"><input type="checkbox" name="special" id="special2"><em>심장질환</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="special3"><input type="checkbox" name="special" id="special3"><em>마킹</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="special4"><input type="checkbox" name="special" id="special4"><em>마운팅</em></label></div>
                                                        <div class="grid-layout-cell grid-1">
                                                            <div class="form-group-item">
                                                                <div class="form-item-label">메모</div>
                                                                <div class="form-item-data type-2">
                                                                    <textarea style="height:60px;" id="memo" placeholder="입력"></textarea>
                                                                    <div class="form-input-info">*필수항목만 입력해도 예약등록 가능</div>
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
                    </div>
                </div>
                <div class="pop-footer type-2">
                    <!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
                    <a href="#" class="btn-page-bottom" onclick="validate=true; customer_new(artist_id)">저장</a>
                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
</article>

<article id="beautyAgreeWritePop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data data-pop-view large">
                <div class="pop-header">
                    <h4 class="con-title" id="beauty_agree_title">미용 동의서 작성</h4>
                </div>
                <div class="pop-body">
                    <div class="basic-data-group">
                        <div class="con-title-group">
                            <h4 class="con-title">고객 정보</h4>
                        </div>
                        <div class="form-group">
                            <div class="grid-layout margin-14-17">
                                <div class="grid-layout-inner">
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">고객명</div>
                                            <div class="form-item-data">
                                                <input type="text" maxlength="10" id="agree_name" class="form-control" placeholder="입력">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">연락처</div>
                                            <div class="form-item-data">
                                                <input type="text" class="form-control" maxlength="15" id="agree_cellphone" placeholder="입력">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="basic-data-group">
                        <div class="con-title-group">
                            <h4 class="con-title">펫 정보</h4>
                        </div>
                        <div class="form-group">
                            <div class="grid-layout margin-14-17">
                                <div class="grid-layout-inner">
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label">품종</div>
                                            <div class="form-item-data type-2">
                                                <div class="pet-breed-select-wrap">
                                                    <div class="pet-breed-select">
                                                        <div class="breed-select">
                                                            <label class="form-toggle-box" for="agree_breed1"><input type="radio" name="agree_breed" class="agree_load-pet-type" value="dog" id="agree_breed1"><em><span>강아지</span></em></label>
                                                            <label class="form-toggle-box" for="agree_breed2"><input type="radio" name="agree_breed" class="agree_load-pet-type" value="cat" id="agree_breed2"><em><span>고양이</span></em></label>
                                                        </div>
                                                    </div>
                                                    <div class="pet-breed-sort">
                                                        <div style="display:block">
                                                            <select id="agree_breed_select">
                                                                <option value="">선택</option>
                                                            </select>
                                                            <div class="pet-breed-other" id="agree_breed_other_box" style="display:none;">
                                                                <input type="text" placeholder="입력" id="agree_breed_other" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">생일</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout margin-12">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="agree_birthday_year" class="agree_birthday">

                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="agree_birthday_month" class="agree_birthday">

                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="agree_birthday_date">

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">성별 선택</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout toggle-button-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_gender1"><input type="radio" name="agree_gender" value="남아" id="agree_gender1"><em>남아</em></label></div>
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_gender2"><input type="radio" name="agree_gender" value="여아" id="agree_gender2"><em>여아</em></label></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">중성화</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout toggle-button-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_neutralize1"><input type="radio" name="agree_neutralize" value="0" id="agree_neutralize1"><em>X</em></label></div>
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_neutralize2"><input type="radio" name="agree_neutralize" value="1" id="agree_neutralize2"><em>O</em></label></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">예방 접종</div>
                                            <div class="form-item-data type-2">
                                                <select id="agree_vaccination">
                                                    <option value="0">선택</option>
                                                    <option value="2차 이하">2차 이하</option>
                                                    <option value="3차">3차 완료</option>
                                                    <option value="4차">4차 완료</option>
                                                    <option value="5차">5차 완료</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label">질병기록</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout toggle-button-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="disease1"><input type="checkbox" name="disease" id="disease1"><em>없음</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="disease2"><input type="checkbox" name="disease" id="disease2"><em>심장 질환</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="disease3"><input type="checkbox" name="disease" id="disease3"><em>피부병</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="disease4"><input type="checkbox" name="disease" id="disease4" onclick="disease_etc()"><em>기타</em></label></div>
                                                        <div class="grid-layout-cell grid-1">
                                                            <select id="agree_luxation">
                                                                <option value="0">슬개골탈구</option>
                                                                <option value="없음">없음</option>
                                                                <option value="1기">1기</option>
                                                                <option value="2기">2기</option>
                                                                <option value="3기">3기</option>
                                                                <option value="4기">4기</option>
                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-1">
                                                            <textarea style="height:60px; display:none;" id="disease_textarea" placeholder="입력"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label">특이사항</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout toggle-button-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_special1"><input type="checkbox" name="agree_special" id="agree_special1"><em>입질</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_special2"><input type="checkbox" name="agree_special" id="agree_special2"><em>마킹</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_special3"><input type="checkbox" name="agree_special" id="agree_special3"><em>마운팅</em></label></div>
                                                        <div class="grid-layout-cell grid-1">
                                                            <textarea style="height:60px;" placeholder="입력" id="special_textarea"></textarea>
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
                    <div class="basic-data-group customer-view-agree">
                        <div class="con-title-group">
                            <h4 class="con-title">미용동의서 상세내용</h4>
                        </div>
                        <div class="customer-view-agree-info" id="agree_info"> </div>
                        <div class="pay-card-group">
                            <div class="pay-card-cell all"><label class="form-checkbox"><input type="checkbox" id="beauty_agree_all_btn" onclick=" beauty_agree_checkbox(this)" name="payCard"><span class="form-check-icon"><em><strong>모두 동의</strong></em></span></label></div>
                            <div class="pay-card-cell rule">
                                <div class="pay-card-rule-wrap">
                                    <div class="pay-card-check">
                                        <label class="form-checkbox"><input type="checkbox" id="beauty_agree_1_btn" onclick=" beauty_agree_checkbox(this)" name="payCard"><span class="form-check-icon"><em>미용 동의서</em></span></label>
                                        <button type="button" class="btn-pay-card-toggle">자세히 보기</button>
                                    </div>
                                    <div class="pay-card-rule">
                                        <div class="pay-card-agree">
                                            1. 백내장, 치주염, 관절염, 당뇨병, 심장질환 등과 같이 노령견에서 흔히 발생하는 질병은 미용 시에 노령견(묘)에게 쇼크 및 스트레스의 원인이 될 수 있으며, 증상이 심각할 경우 사망까지 이를 수 있습니다.
                                            <br><br>
                                            2. 노령견(묘)이나, 예민한 견(묘)의 경우 미용 시 받는 스트레스가 더 심할 수 있습니다. 또한, 미용 및 목욕 시 평소보다 오래 서 있게 되어, 관절에 무리가 올 수 있으며, 이런 경우 미용 후에 일시적으로 다리를 절 수 있습니다.
                                            <br><br>
                                            3. 당일 반려견(묘)의 컨디션이 좋지 않거나, 구토, 설사, 감기 증상이 있을 경우, 미용 후에 증상이 더 심해질 수 있으므로 미용을 미루시는 것이 좋습니다.
                                            <br><br>
                                            4. 목욕 시 적절한 물 온도 유지 및 수압 체크를 하여도 노령견(묘)은 신경계 및 심장혈관 상태가 비교적 약하여, 심장마비로 인한 쇼크 사망사고가 발생할 수도 있습니다.
                                            <br><br>
                                            5. 반려견(묘)의 질병에 대해 사전에 고지하지 않은 경우, 그 질병에 대해 책임지지 않습니다.
                                            <br><br>
                                            6. 미용 전 보이지 않던 피부 질환이 미용 후 노출되어 긁거나 핥아 2차 감염이 발생할 수 있습니다. 미용 전 피부 상태를 잘 확인하시고 주의해주세요.
                                            <br><br>
                                            7. 엉킴이 있는 경우 미용 전 이미 피부가 상해 있는 경우가 많으며, 빗질 혹은 클리핑 시 피부가 붉어지기도 합니다. 최대한 주의하나 이 과정에서 상처가 발생할 수 있음을 미리 고지 드립니다.
                                            <br><br>
                                            8. 미용 전 고지 되지 않은 사항에 의해 일어난 사고는 펫샵에서 책임지지 않습니다.
                                            <br><br>
                                            9. 미용 거부가 심각하거나, 질병적 문제가 있는 경우 미용이 중단될 수 있습니다.
                                            <br><br>
                                            10. 미용 중 엉킴, 길이 등에 대한 추가비용이 발생할 수 있습니다.
                                            <br><br>
                                            11. 반려견(묘) 미용 시 발생할 수 있는 사고를 미용을 요청한 보호자는 인지 하였으며, 이와 관련하여 해당 견(묘)에게 발생하는 사고에 대해 미용을 요청한 보호자는 추후 이의 제기를 하지 않음에 동의합니다.
                                            <br><br>
                                            12. 이 미용 동의서는 작성일 이후부터 차후 미용을 이용하시는 모든 기간에 동일하게 적용됨을 확인합니다.

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pay-card-cell rule">
                                <div class="pay-card-rule-wrap">
                                    <div class="pay-card-check">
                                        <label class="form-checkbox"><input type="checkbox" id="beauty_agree_2_btn" onclick=" beauty_agree_checkbox(this)" name="payCard"><span class="form-check-icon"><em>개인정보 수집 및 허용</em></span></label>
                                        <button type="button" class="btn-pay-card-toggle">자세히 보기</button>
                                    </div>
                                    <div class="pay-card-rule">
                                        <div class="pay-card-agree">
                                            개인정보수집/이용/제공 동의서
                                            <br><br>
                                            [개인정보 보호법] 제15조 및 제17조에 따라 아래의 내용으로 개인정보를 수집, 이용 및 제공하는데 동의합니다.
                                            <br><br>
                                            □ 개인정보의 수집 및 이용에 관한 사항
                                            <br><br>
                                            - 수집하는 개인정보 항목 : 이름, 전화번호, 펫정보(품종,몸무게,성별 등 펫 특이사항)과 그 外 미용동의서 기재 내용 일체
                                            <br><br>
                                            - 개인정보의 이용 목적 : 수집된 개인정보를 선택한 펫샵에서 미용작업에 대한 상호(보호자-펫샵)동의를 위해 사용하며, 목적 외의 용도로는 사용하지 않습니다.
                                            <br><br>
                                            □ 개인정보의 보관 및 이용 기간
                                            <br><br>
                                            - 수집, 이용 및 제공목적이 달성될 때 까지, 달성이후 [개인정보 보호법] 제21조에 따라 폐기처리합니다

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="customer-view-agree-date">
                            <div class="item-date" id="agree_date"></div>
                            <div class="item-name" id="agree_name2"></div>
                            <input type="hidden" id="agree_pet_name">
                        </div>
                    </div>
                    <div class="basic-data-group small" id="signature_pad">
                        <div class="con-title-group">
                            <h4 class="con-title">서명</h4>
                            <span data-action="clear" id="signature_clear" style="cursor:pointer">서명 지우기</span>
                        </div>
                        <div class="user-sign-wrap" id="user_sign_wrap">
                            <canvas id="cview"></canvas>
                            <img src="" alt="" id="sign_img" style="display:none";>
                        </div>
                    </div>
                </div>
                <div class="pop-footer type-2" id="beauty_agree_footer">
                    <!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->

                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
</article>

<article id="reserveAcceptMsg1" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt" id="msg1_txt"></div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">확인</button>
                </div>
            </div>
        </div>
    </div>
</article>

<article id="deleteCustomer" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt">이 고객의 모든 펫 정보와 미용이력이 삭제되며, 복구할 수 없습니다.<br>삭제하시겠습니까?</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="customer_delete(artist_id)">삭제</button>
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">취소</button>
                </div>
            </div>
        </div>
    </div>
</article>
<article id="reserveAcceptMsg2" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt" id="msg2_txt"></div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="location.reload();">확인</button>
                </div>
            </div>
        </div>
    </div>
</article>
<article id="petModifyPop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data data-pop-view large">
                <div class="pop-header">
                    <h4 class="con-title">펫 정보 수정하기</h4>
                </div>
                <div class="pop-body">
                    <div class="basic-data-group">
                        <div class="con-title-group">
                            <h4 class="con-title">펫 정보</h4>
                        </div>
                        <div class="form-group">
                            <div class="grid-layout margin-14-17">
                                <div class="grid-layout-inner">
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label"><em class="need">*</em>펫 이름</div>
                                            <div class="form-item-data">
                                                <input type="text" class="form-control" maxlength="20" id="modify_customer_name" placeholder="펫 이름 입력">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label"><em class="need">*</em>품종</div>
                                            <div class="form-item-data type-2">
                                                <div class="pet-breed-select-wrap">
                                                    <div class="pet-breed-select">
                                                        <div class="breed-select">
                                                            <label class="form-toggle-box" for="modify_customer_breed1"><input type="radio" name="modify_customer_breed" class="modify_customer_load-pet-type" value="dog" id="modify_customer_breed1"><em><span>강아지</span></em></label>
                                                            <label class="form-toggle-box" for="modify_customer_breed2"><input type="radio" name="modify_customer_breed" class="modify_customer_load-pet-type" value="cat" id="modify_customer_breed2"><em><span>고양이</span></em></label>
                                                        </div>
                                                    </div>
                                                    <div class="pet-breed-sort">
                                                        <div style="display:block">
                                                            <select id="modify_customer_breed_select">
                                                                <option value="">선택</option>
                                                            </select>
                                                            <div class="pet-breed-other" id="modify_customer_breed_other_box" style="display:none;">
                                                                <input type="text" placeholder="입력" id="modify_customer_breed_other" class="form-control">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">생일</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout margin-12">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="modify_customer_birthday_year" class="birthday">

                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="modify_customer_birthday_month" class="birthday">

                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="modify_customer_birthday_date">

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">성별 선택</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout toggle-button-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="modify_customer_gender1"><input type="radio" name="modify_customer_gender" value="남아" id="modify_customer_gender1"><em>남아</em></label></div>
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="modify_customer_gender2"><input type="radio" name="modify_customer_gender" value="여아" id="modify_customer_gender2"><em>여아</em></label></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">중성화</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout toggle-button-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="modify_customer_neutralize1"><input type="radio" name="modify_customer_neutralize" value="0" id="modify_customer_neutralize1"><em>X</em></label></div>
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="modify_customer_neutralize2"><input type="radio" name="modify_customer_neutralize" value="1" id="modify_customer_neutralize2"><em>O</em></label></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label"><em class="need">*</em>몸무게</div>
                                            <div class="form-item-data type-2">
                                                <div class="form-flex">
                                                    <select class="inline-block" id="modify_customer_weight1">

                                                    </select>
                                                    <div class="form-unit-point">.</div>
                                                    <select class="inline-block" id="modify_customer_weight2">
                                                        <option value="0">0</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="6">6</option>
                                                        <option value="7">7</option>
                                                        <option value="8">8</option>
                                                        <option value="9">9</option>
                                                    </select>
                                                    <div class="form-unit-label">kg</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">미용 경험</div>
                                            <div class="form-item-data type-2">
                                                <select id="modify_customer_beauty_exp">
                                                    <option value="0">선택</option>
                                                    <option value="없음">없음</option>
                                                    <option value="1회">1회</option>
                                                    <option value="2회">2회</option>
                                                    <option value="3회 이상">3회 이상</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">예방 접종</div>
                                            <div class="form-item-data type-2">
                                                <select id="modify_customer_vaccination">
                                                    <option value="0">선택</option>
                                                    <option value="2차 이하">2차 이하</option>
                                                    <option value="3차">3차 완료</option>
                                                    <option value="4차">4차 완료</option>
                                                    <option value="5차">5차 완료</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">입질</div>
                                            <div class="form-item-data type-2">
                                                <select id="modify_customer_bite">
                                                    <option value="0">선택</option>
                                                    <option value="안해요">안해요</option>
                                                    <option value="해요">해요</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">슬개골 탈구</div>
                                            <div class="form-item-data type-2">
                                                <select id="modify_customer_luxation">
                                                    <option value="0">선택</option>
                                                    <option value="없음">없음</option>
                                                    <option value="1기">1기</option>
                                                    <option value="2기">2기</option>
                                                    <option value="3기">3기</option>
                                                    <option value="4기">4기</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-1">
                                        <div class="form-group-item">
                                            <div class="form-item-label">특이사항</div>
                                            <div class="form-item-data type-2">
                                                <div class="grid-layout toggle-button-group">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="modify_customer_special1"><input type="checkbox" name="modify_customer_special" id="modify_customer_special1"><em>피부병</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="modify_customer_special2"><input type="checkbox" name="modify_customer_special" id="modify_customer_special2"><em>심장질환</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="modify_customer_special3"><input type="checkbox" name="modify_customer_special" id="modify_customer_special3"><em>마킹</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="modify_customer_special4"><input type="checkbox" name="modify_customer_special" id="modify_customer_special4"><em>마운팅</em></label></div>
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
                <div class="pop-footer type-2">
                    <!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
                    <a href="#" class="btn-page-bottom" id="modify_pet_info_btn">저장</a>
                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
</article>
<article id="reserveAcceptMsg3" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt" id="msg3_txt"></div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="location.href='/customer/customer_inquiry.php'">확인</button>
                </div>
            </div>
        </div>
    </div>
</article>

<article id="memberGradeAddPop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-header">
                    <h4 class="con-title">회원등급 부여</h4>
                </div>
                <div class="pop-body">
                    <div class="msg-txt" id="memberGrageMsg">현재 까미 (010-6481-5987)고객님의 등급은 VIP 입니다.</div>
                    <div class="form-group">
                        <div class="form-group-item">
                            <select id="memberGradeSelect">
                            </select>
                            <div class="form-input-info">선택 후 저장하시면 반영됩니다.</div>
                        </div>
                    </div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" id="set_grade_btn">저장</button>
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">취소</button>
                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
</article>

<article id="numberAddPop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data data-pop-view">
                <div class="pop-header">
                    <h4 class="con-title">전화번호 추가</h4>
                </div>
                <div class="pop-body">
                    <div class="phone-add-wrap">
                        <div class="phone-add-list" id="phone_add_list">

                        <!-- 입력 불가시 phone-add-input 클래스에 disabled 클래스 추가 및 input태그에 disabled속성 추가 -->

                        </div>
                    </div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-purple" onclick="add_sub_phone(artist_id,false)"><strong>등록하기</strong></button>
                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
</article>


<article id="reserveAcceptMsg4" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt" id="msg4_txt"></div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm " onclick="delete_sub_phone()">확인</button>
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">취소</button>
                </div>
            </div>
        </div>
    </div>
</article>

<!-- 알림톡발송조회 팝업 -->
<article id="customerAlarmInquiryPop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data data-pop-view large">
                <div class="pop-header">
                    <h4 class="con-title">알림톡 발송이력 조회</h4>
                </div>
                <div class="pop-body">
                    <div class="customer-alarm-inquiry">
                        <div class="basic-data-group">
                            <div class="board-sort-wrap">
                                <div class="left">
                                    <div class="form-datepicker-group">
                                        <div class="form-datepicker"><input type="text" class="datepicker-start" value="<?php echo date('Y-m-d', strtotime(DATE('Y-m-d')."-1 days"));?>"></div>
                                        <div class="form-unit">~</div>
                                        <div class="form-datepicker"><input type="text" class="datepicker-end" value="<?php echo DATE('Y-m-d'); ?>"></div>
                                    </div>
                                </div>
                                <div class="right">
                                    <div class="board-sort-btns">
                                        <button type="button" class="btn-data-refresh">초기화</button>
                                        <a href="#" class="btn btn-purple btn-inline btn-basic-small pop_inquiry">조회</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="basic-data-group vvsmall3">
                            <div class="con-title-group">
                                <input type="hidden" id="allim_cellphone_val" class="allim_cellphone_val" value="">
                                <h5 class="con-title"><span id="allim_cellphone"></span> 고객님의 발송이력 조회입니다.</h5>
                            </div>
                            <div>
                                <!-- 검색결과 있을 때 -->
                                <div class="customer-alarm-result do_allim">
                                    <table class="customer-table">
                                        <colgroup>
                                            <col style="width:20%">
                                            <col style="width:15%">
                                            <col style="width:46%">
                                            <col style="width:19%">
                                        </colgroup>
                                        <thead>
                                        <tr>
                                            <th>발송시간</th>
                                            <th>구분</th>
                                            <th>내용</th>
                                            <th>결과</th>
                                        </tr>
                                        </thead>
                                        <tbody id="allim_table">
                                            <tr>
                                                <td class="">2021.12.25<br>13:25</td>
                                                <td class="">예약등록</td>
                                                <td class="text-align-left">1776님의 범shop 예약이 내일이네요^^<br><br>반려생황읠 단짝, 반짝에서 내일 예약 내용을 알려드립니다.<br><br>-예약펫샵: 글로리<br>-예약일시: 2021년 9월26일 9시 0분<br><br>예약내용 상세 확인과 변경은 반려생활의 단짝, 반짝에서도 간능합니다.<br>알림톡 발송</td>
                                                <td class="">알림톡 발송</td>
                                            </tr>
                                            <tr>
                                                <td class="">2021.12.25<br>13:25</td>
                                                <td class="">예약등록</td>
                                                <td class="text-align-left">1776님의 범shop 예약이 내일이네요^^<br><br>반려생황읠 단짝, 반짝에서 내일 예약 내용을 알려드립니다.<br><br>-예약펫샵: 글로리<br>-예약일시: 2021년 9월26일 9시 0분<br><br>예약내용 상세 확인과 변경은 반려생활의 단짝, 반짝에서도 간능합니다.<br>알림톡 발송</td>
                                                <td class="">알림톡 발송</td>
                                            </tr>
                                            <tr>
                                                <td class="">2021.12.25<br>13:25</td>
                                                <td class="">예약등록</td>
                                                <td class="text-align-left">1776님의 범shop 예약이 내일이네요^^<br><br>반려생황읠 단짝, 반짝에서 내일 예약 내용을 알려드립니다.<br><br>-예약펫샵: 글로리<br>-예약일시: 2021년 9월26일 9시 0분<br><br>예약내용 상세 확인과 변경은 반려생활의 단짝, 반짝에서도 간능합니다.<br>알림톡 발송</td>
                                                <td class="">알림톡 발송</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- //검색결과 있을 때 -->
                                <!-- 검색결과 없을 때 -->
                                <div class="list-none-data none_allim">검색 결과가 없습니다.</div>
                                <!-- //검색결과 없을 때 -->
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
            </div>
        </div>
    </div>
</article>
<div class="gallery-pop-wrap">
    <div class="gallery-pop-inner">
        <div class="gallery-pop-data" id="ga-da">
            <div class="gallery-pop-slider" id="ga-sl" style="width:100%;height:100%;">
                <div class="swiper-container" id="sw-con">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="slider-item">
                                <span class="loading-bar"><span class="sk-fading-circle"><span class="sk-circle1 sk-circle"></span><span class="sk-circle2 sk-circle"></span><span class="sk-circle3 sk-circle"></span><span class="sk-circle4 sk-circle"></span><span class="sk-circle5 sk-circle"></span><span class="sk-circle6 sk-circle"></span><span class="sk-circle7 sk-circle"></span><span class="sk-circle8 sk-circle"></span><span class="sk-circle9 sk-circle"></span><span class="sk-circle10 sk-circle"></span><span class="sk-circle11 sk-circle"></span><span class="sk-circle12 sk-circle"></span></span></span>
                                <img src="" alt=""/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-page"></div>
                <button type="button" class="btn-swiper-slider-prev"></button>
                <button type="button" class="btn-swiper-slider-next"></button>
            </div>
            <div class="gallery-pop-ui" id="ga-btn">
                <button type="button" class="btn-gallery-pop-nav btn-gallery-mode" onclick="gallery.viewModeChange(this);">
                    <span class="icon icon-size-24 icon-viewall-white off"></span>
                    <span class="icon icon-size-24 icon-viewmax-white on"></span>
                </button>
                <button type="button" class="btn-gallery-pop-nav" onclick="gallery.close();"><span class="icon icon-size-24 icon-close-white"></span></button>
            </div>
        </div>
        <div class="gallery-thumb-data">
            <div class="gallery-thumb-list">
                <button type="button" class="btn-gallery-thumb-nav">
                    <span class="loading-bar"><span class="sk-fading-circle"><span class="sk-circle1 sk-circle"></span><span class="sk-circle2 sk-circle"></span><span class="sk-circle3 sk-circle"></span><span class="sk-circle4 sk-circle"></span><span class="sk-circle5 sk-circle"></span><span class="sk-circle6 sk-circle"></span><span class="sk-circle7 sk-circle"></span><span class="sk-circle8 sk-circle"></span><span class="sk-circle9 sk-circle"></span><span class="sk-circle10 sk-circle"></span><span class="sk-circle11 sk-circle"></span><span class="sk-circle12 sk-circle"></span></span></span>
                    <img src="" alt="">
                </button>
            </div>
        </div>
    </div>
</div>
<!-- //알림톡발송조회 팝업 -->
<script src="/static/js/common.js"></script>
<script src="/static/js/dev_common.js"></script>
<script src="/static/js/customer.js"></script>
<script src="/static/js/shop.js"></script>
<script src="/static/js/booking.js"></script>
<script src="/static/js/signature_pad.umd.js"></script>
<script src="/static/js/swiper.min.js"></script>
<script src="/static/js/imagesloaded.pkgd.min.js"></script>
<script src="/static/js/jquery-ui.min.js"></script>
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
        set_image('front_image');
        //prepend_data('consulting_count nick');
        gnb_actived('gnb_customer_wrap','gnb_inquire');
        customer_view_(artist_id)



        customer_new_birthday().then(function(){ customer_new_birthday_date()})
        customer_pet_type(artist_id);
        customer_new_weight();
        modify_customer_new_birthday().then(function(){ modify_customer_new_birthday_date()})
        modify_customer_pet_type(artist_id);
        modify_customer_new_weight();

        gallery.init();

    })


    let wrapper = document.getElementById('signature_pad');
    let clear_btn = document.getElementById('signature_clear');

    let canvas = document.getElementById('cview');

    let signature_pad = new SignaturePad(canvas,{

        backgroundColor:'rgb(255,255,255)'
    })

    canvas.width = canvas.parentElement.offsetWidth-2;
    canvas.height=canvas.parentElement.offsetHeight-2;


    clear_btn.addEventListener("click", function (event) {
        signature_pad.clear();
    });



    $(".datepicker-start").datepicker({
        showOn: "both",
        buttonImage: "../static/images/icon/icon-datepicker_black.png",
        buttonImageOnly: true,
        dateFormat: 'yy-mm-dd',//포맷 설정
        prevText: '이전 달',//이전 버튼
        nextText: '다음 달', //다음달 버튼
        monthNames: ['1','2','3','4','5','6','7','8','9','10','11','12'],//월 설정
        monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'], //월 설정
        dayNames: ['일','월','화','수','목','금','토'],//주 타이틀 설정
        dayNamesShort: ['일','월','화','수','목','금','토'],//주 타이틀 설정
        dayNamesMin: ['일','월','화','수','목','금','토'], //주 타이틀 설정
        minDate: new Date('2021-06-05'),
        showMonthAfterYear: true, // 년도가 앞으로 설정
        yearSuffix: '.', //년도 뒤 블릿 설정
        changeMonth: false, //월 선택 불가
        changeYear: false, //년 선택 불가
        showOtherMonths:true, //이전 , 다음 달 일수 활성화
    });

    $(".datepicker-end").datepicker({
        showOn: "both",
        buttonImage: "../static/images/icon/icon-datepicker_black.png",
        buttonImageOnly: true,
        dateFormat: 'yy-mm-dd',//포맷 설정
        prevText: '이전 달',//이전 버튼
        nextText: '다음 달', //다음달 버튼
        monthNames: ['1','2','3','4','5','6','7','8','9','10','11','12'],//월 설정
        monthNamesShort: ['1','2','3','4','5','6','7','8','9','10','11','12'], //월 설정
        dayNames: ['일','월','화','수','목','금','토'],//주 타이틀 설정
        dayNamesShort: ['일','월','화','수','목','금','토'],//주 타이틀 설정
        dayNamesMin: ['일','월','화','수','목','금','토'], //주 타이틀 설정
        minDate: new Date('2021-06-05'),
        showMonthAfterYear: true, // 년도가 앞으로 설정
        yearSuffix: '.', //년도 뒤 블릿 설정
        changeMonth: false, //월 선택 불가
        changeYear: false, //년 선택 불가
        showOtherMonths:true, //이전 , 다음 달 일수 활성화
    });


    $(document).on("keyup","#customer_memo",function(){
        // console.log($(this).val());
        // console.log(localStorage.getItem('customer_select'));
        // console.log(customer_id, tmp_seq);
        $.ajax({
            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:'customer_memo_sql',
                artist_id:artist_id,
                customer_id:customer_id,
                tmp_seq:tmp_seq,
                cellphone:localStorage.getItem('customer_select'),
                comment:str_to_db($(this).val())
            },
            success:function (res){
            }
        })
    })
</script>
</body>
</html>