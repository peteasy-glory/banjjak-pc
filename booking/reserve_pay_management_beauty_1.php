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
								<h3 class="card-header-title">작업 / 결제관리</h3>
								<div class="card-header-right">
									<div class="label label-outline-purple large round"><em>예약확정</em></div>
								</div>
							</div>
							<div class="card-body">
								<div class="card-body-inner" id="work_body_inner">
                                    <div class="wide-tab">
                                        <div class="wide-tab-inner" id="wide-tab-inner">
                                            <!-- 활성화시 actived클래스 추가 -->
                                            <div class="tab-cell actived"><a href="#" class="btn-tab-item">작업 관리</a></div>
                                            <div class="tab-cell"><a href="#" class="btn-tab-item">결제 관리</a></div>
                                        </div>
                                    </div>


								</div>
							</div>
						</div>			
					</div>
					<div class="data-col-right" id="data_col_right">

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

<article id="noshow" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">

            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-title">확인</div>
                    <div class="msg-txt">해당 예약정보를 노쇼로 등록을 하시겠습니까?</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm btn-cf" onclick="set_noshow(); location.reload();">확인</button>
                    <button type="button" class="btn btn-confirm btn-cc" onclick="pop.close();">취소</button>

                </div>
            </div>

        </div>
    </div>
</article>

<article id="cancel_noshow" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">

            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-title">확인</div>
                    <div class="msg-txt">해당 노쇼를 취소 하시겠습니까?</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm btn-cf" onclick="cancel_noshow(); location.reload();">확인</button>
                    <button type="button" class="btn btn-confirm btn-cc" onclick="pop.close();">취소</button>

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

<article id="reserveAcceptMsg2" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt" id="msg2_txt"></div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="location.reload()">확인</button>
                </div>
            </div>
        </div>
    </div>
</article>

<article id="show_image" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <img src="" alt="" id="show_image_wrap">
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="pop.close()">확인</button>
                </div>
            </div>
        </div>
    </div>
</article>

<article id="reserveCancel" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt">예약취소 알림톡을 발송 하시겠습니까?</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm btn-reserv-block cancel-cls" onclick="reserve_cancel(true) pop.close();">발송</button>
                    <button type="button" class="btn btn-confirm btn-reserv-send cancel-cls" onclick="reserve_cancel(false); pop.close();">미발송</button>
                </div>
            </div>
        </div>
    </div>
</article>

<article id="only_change_time" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">

            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-title">확인</div>
                    <div class="msg-txt">예약시간을 변경 하시겠습니까?</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm btn-cc" onclick="pop.close();">취소</button>
                    <button type="button" class="btn btn-confirm btn-cf" onclick="pop.open('reserveChange'); ">확인</button>
                </div>
            </div>

        </div>
    </div>
</article>

<article id="reserveChange" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt">예약변경 알림톡을 발송 하시겠습니까?</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm btn-reserv-block change-cls" id="change_cls" onclick="set_change_time(true)">발송</button>
                    <button type="button" class="btn btn-confirm btn-reserv-send change-cls" onclick="set_change_time(false);">미발송</button>
                </div>
            </div>
        </div>
    </div>
</article>

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
                            <div class="list-inner img_wrap" id="beauty_gal_wrap">
                                <div class="list-cell"><a href="#" class="btn-gate-picture-register" onclick="MemofocusNcursor()"><span><em>이미지 추가</em></span></a></div>
                                <div style="display:block;position:absolute;top:-50px;"><input type="file" accept="image/*" name="imgupfile" id="addimgfile"></div>

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
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_special2"><input type="checkbox" name="agree_special" id="agree_special3"><em>마킹</em></label></div>
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
                        </div>
                    </div>
                    <div class="basic-data-group small" id="signature_pad">
                        <div class="con-title-group">
                            <h4 class="con-title">서명</h4>
                            <span data-action="clear" id="signature_clear" style="cursor:pointer">서명 지우기</span>
                        </div>
                        <div class="user-sign-wrap" id="user_sign_wrap">
                            <canvas id="cview"></canvas>
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

<article id="reservePayManagementMsg1" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data middle">
                <div class="pop-body">
                    <div class="msg-title">날짜/ 미용사 변경</div>
                    <div class="msg-txt">1. 변경을 위해 주간 스케줄로 이동합니다.<br>현재 페이지에서 저장하지 않은 정보는 분실될 수 있으니 변경전에 확인해주세요.<br><br>2. 변경을 완료하기 전에 다른 페이지로 이동하면 오류가 발생할 수 있으니 주의해주세요.<br><br>변경하시겠습니까?<br><br>[주의] 주간 스케줄표에서만 변경 가능합니다!</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="location.href = '/booking/reserve_beauty_week.php'">변경</button>
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">취소</button>
                </div>
            </div>
        </div>
    </div>
</article>

<script src="/static/js/common.js"></script>
<script src="/static/js/dev_common.js"></script>
<script src="/static/js/booking.js"></script>
<script src="/static/js/customer.js"></script>
<script src="/static/js/shop.js"></script>
<script src="/static/js/signature_pad.umd.js"></script>


<script>

    let artist_id = "<?=$artist_id?>";

    data_set(artist_id)

    $(document).ready(function(){

        gnb_init();
        prepend_data('consulting_count nick');
        set_image('front_image');
        wide_tab();
        pay_management_(artist_id)
        gnb_actived('gnb_reserve_wrap','gnb_beauty')


        customer_new_birthday().then(function(){ customer_new_birthday_date()})
        customer_pet_type(artist_id);
        customer_new_weight();
        setInputFilter(document.getElementById("agree_cellphone"), function(value) {
            return /^\d*\.?\d*$/.test(value);
        })


        agree_birthday().then(function(){ agree_birthday_date()})
        agree_pet_type(artist_id);

        var main = '';
        var html = '';



    })

    let wrapper = document.getElementById('signature_pad');
    let clear_btn = document.getElementById('signature_clear');

    let canvas = document.getElementById('cview');

    let signature_pad = new SignaturePad(canvas,{

        backgroundColor:'rgb(255,255,255)'
    })

    canvas.width = canvas.parentElement.offsetWidth;
    canvas.height=canvas.parentElement.offsetHeight;


    clear_btn.addEventListener("click", function (event) {
        signature_pad.clear();
    });






</script>
</body>
</html>