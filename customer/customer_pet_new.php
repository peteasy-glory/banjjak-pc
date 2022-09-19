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
								<h3 class="card-header-title">신규 등록</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="basic-data-group">
										<div class="form-group">
											<div class="grid-layout margin-14-17">
												<div class="grid-layout-inner">
													<div class="grid-layout-cell grid-2">
														<div class="form-group-item">
															<div class="form-item-label"><em class="need">*</em>전화번호</div>
															<div class="form-item-data">
																<div class="form-control-btns">
																	<input type="text" class="form-control" maxlength="15" id="customer_cellphone" placeholder="입력">
																	<button type="button" class="btn btn-outline-purple btn-inline" onclick="customer_new_cellphone_chk(artist_id) ">중복확인</button>
																</div>
															</div>
														</div>
													</div>	
													<div class="grid-layout-cell grid-2">
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
												</div>							
											</div>															
										</div>											
									</div>
									
									<div class="basic-data-group">
										<div class="more-toggle-parents">
											<div class="con-title-group">
												<h4 class="con-title">추가 사항 입력</h4>
												<button class="btn-side btn-more-toggle-nav"><span class="txt">추가정보 더보기</span></button>
											</div>
											<div class="more-toggle-data">											
												<div class="form-group">
													<div class="grid-layout margin-14-17">
														<div class="grid-layout-inner">						
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

																			</div>
																		</div>
																	</div>
																</div>
															</div>							
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
												<div class="basic-data-group middle">
													<label class="form-checkbox"><input type="checkbox" name="submit_and_reserve"><span class="form-check-icon"><em><strong>등록 후 즉시예약</strong></em></span></label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>							
							<div class="card-footer">
								<!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
								<a href="#" class="btn-page-bottom" onclick="customer_new(artist_id)">저장하기</a>
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

<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/customer.js"></script>

<script>

    let artist_id = "<?=$artist_id?>";


    $(document).ready(function(){
        var artist_flag = "<?=$artist_flag?>";
        if(artist_flag == 1){
            view_artist();
        }

        get_navi(artist_id)
        gnb_init();
        set_image('front_image');
        gnb_actived('gnb_customer_wrap','gnb_new');
        setInputFilter(document.getElementById("customer_cellphone"), function(value) {
            return /^\d*\.?\d*$/.test(value);
        })

        customer_new_birthday().then(function(){ customer_new_birthday_date()})
        customer_pet_type(artist_id);
        customer_new_weight()


    })



</script>
</body>
</html>