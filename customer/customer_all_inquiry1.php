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
												<select class="arrow" id="customer_select">
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

<article id="beautyAgreeViewPop" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data data-pop-view large">
                <div class="pop-header">
                    <h4 class="con-title" id="beauty_agree_title">미용 동의서 보기</h4>
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
                                                <input type="text" maxlength="10" id="agree_view_name" readonly class="form-control" placeholder="입력">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">연락처</div>
                                            <div class="form-item-data">
                                                <input type="text" class="form-control" maxlength="15" readonly id="agree_view_cellphone" placeholder="입력">
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
                                                            <label class="form-toggle-box" for="agree_view_breed1"><input type="radio" name="agree_view_breed" class="agree_view_load-pet-type" value="dog" id="agree_view_breed1"><em><span>강아지</span></em></label>
                                                            <label class="form-toggle-box" for="agree_view_breed2"><input type="radio"  name="agree_view_breed" class="agree_view_load-pet-type" value="cat" id="agree_view_breed2"><em><span>고양이</span></em></label>
                                                        </div>
                                                    </div>
                                                    <div class="pet-breed-sort">
                                                        <div style="display:block">
                                                            <select id="agree_view_breed_select">
                                                                <option value="">선택</option>
                                                            </select>
                                                            <div class="pet-breed-other" id="agree_view_breed_other_box" style="display:none;">
                                                                <input type="text" placeholder="입력"  disabled id="agree_view_breed_other" class="form-control">
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
                                                            <select id="agree_view_birthday_year" onclick="return false;" class="agree_view_birthday">

                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="agree_view_birthday_month" onclick="return false;"class="agree_view_birthday">

                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-3">
                                                            <select id="agree_view_birthday_date" onclick="return false;">

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
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_view_gender1"><input type="radio" name="agree_view_gender" onclick="return false;"  value="남아" id="agree_view_gender1"><em>남아</em></label></div>
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_view_gender2"><input type="radio" name="agree_view_gender" onclick="return false;"  value="여아" id="agree_view_gender2"><em>여아</em></label></div>
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
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_view_neutralize1"><input type="radio" onclick="return false;" name="agree_view_neutralize" value="0" id="agree_view_neutralize1"><em>X</em></label></div>
                                                        <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="agree_view_neutralize2"><input type="radio" onclick="return false;" name="agree_view_neutralize" value="1" id="agree_view_neutralize2"><em>O</em></label></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid-layout-cell grid-2">
                                        <div class="form-group-item">
                                            <div class="form-item-label">예방 접종</div>
                                            <div class="form-item-data type-2">
                                                <select id="agree_view_vaccination" onclick="return false;">
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
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_view_disease1"><input type="checkbox"  onclick="return false;" name="agree_view_disease" id="agree_view_disease1"><em>없음</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_view_disease2"><input type="checkbox" onclick="return false;" name="agree_view_disease" id="agree_view_disease2"><em>심장 질환</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_view_disease3"><input type="checkbox"  onclick="return false;" name="agree_view_disease" id="agree_view_disease3"><em>피부병</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_view_disease4"><input type="checkbox" onclick="return false;" name="agree_view_disease" id="agree_view_disease4"><em>기타</em></label></div>
                                                        <div class="grid-layout-cell grid-1">
                                                            <select id="agree_view_luxation" onclick="return false;">
                                                                <option value="0">슬개골탈구</option>
                                                                <option value="없음">없음</option>
                                                                <option value="1기">1기</option>
                                                                <option value="2기">2기</option>
                                                                <option value="3기">3기</option>
                                                                <option value="4기">4기</option>
                                                            </select>
                                                        </div>
                                                        <div class="grid-layout-cell grid-1">
                                                            <textarea style="height:60px; display:none;" id="agree_view_disease_textarea" placeholder="입력" readonly></textarea>
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
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_view_special1"><input type="checkbox" name="agree_view_special" onclick="return false;" id="agree_view_special1"><em>입질</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_view_special2"><input type="checkbox" name="agree_view_special" onclick="return false;" id="agree_view_special2"><em>마킹</em></label></div>
                                                        <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="agree_view_special3"><input type="checkbox" name="agree_view_special" onclick="return false;" id="agree_view_special3"><em>마운팅</em></label></div>
                                                        <div class="grid-layout-cell grid-1">
                                                            <textarea style="height:60px;" placeholder="입력" id="agree_view_special_textarea" readonly></textarea>
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
                        <div class="customer-view-agree-info" id="agree_view_info"> </div>
                        <div class="pay-card-group">
                            <div class="pay-card-cell all"><label class="form-checkbox"><input type="checkbox"  checked disabled name="payCard"><span class="form-check-icon"><em><strong>모두 동의</strong></em></span></label></div>
                            <div class="pay-card-cell rule">
                                <div class="pay-card-rule-wrap">
                                    <div class="pay-card-check">
                                        <label class="form-checkbox"><input type="checkbox" checked disabled name="payCard"><span class="form-check-icon"><em>미용 동의서</em></span></label>
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
                                        <label class="form-checkbox"><input type="checkbox"  checked disabled name="payCard"><span class="form-check-icon"><em>개인정보 수집 및 허용</em></span></label>
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
                            <div class="item-date" id="agree_view_date"></div>
                            <div class="item-name" id="agree_view_name2"></div>
                        </div>
                    </div>
                    <div class="basic-data-group small" id="signature_pad">
                        <div class="con-title-group">
                            <h4 class="con-title">서명</h4>
                        </div>
                        <div class="user-sign-wrap" id="user_sign_wrap">
                            <img src="" alt="" id="user_sign_img">
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

<!-- //wrap -->
<script src="../static/js/billboard.js"></script>
<script src="../static/js/billboard.pkgd.js"></script>


<script src="../static/js/common.js"></script>
<script src="../static/js/booking.js"></script>
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
            customer_list(artist_id,customers)

            customer_all_scroll_paging(artist_id)
        })
        customer_count(artist_id)
        customer_select_(artist_id)
        //customer_graph();
        agree_view_birthday().then(function(){ agree_view_birthday_date()})
        agree_view_pet_type(artist_id);

    })



</script>
 <script>


    </script>
</body>
</html>