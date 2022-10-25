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

$startDate = DATE('Y-m-01');
$endDate = DATE('Y-m-d');
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

						<div class="basic-data-card" style="position: relative">
                            <div class="sales-loading-wrap" id="loading_wrap">
                                <div class="loading-container-2">
                                    <img src="/static/images/loading.gif" alt="">
                                </div>
                            </div>
							<div class="card-header">
								<h3 class="card-header-title">판매실적/정산조회</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">									
									<div class="wide-tab">
										<div class="wide-tab-inner">
											<!-- 활성화시 actived클래스 추가 -->
											<div class="tab-cell actived"><a href="#" class="btn-tab-item">판매실적</a></div>
											<div class="tab-cell"><a href="#" class="btn-tab-item" onclick="pop.open('firstRequestMsg1','준비중입니다.')">정산조회</a></div>
										</div>
									</div>
									<div class="basic-data-group vmiddle">
										<div class="form-bottom-info type-2">취소된 예약과 NoShow예약은 제외되며 매장에서 접수한 예약은<br>매장에서 입력한 결제 금액을 그대로 표시하여 입력하지 않은 경우 0원으로 표시됩니다.</div>
									</div>
									<div class="basic-data-group middle">
										<div class="board-form-sort">
											<form id="statsForm" class="sort-inner">
                                                <input type="hidden" name="partner_id" value="<?=$artist_id?>">
												<div class="sort-cell flex-auto">
													<div class="form-group-item">
														<div class="form-item-label">검색기간 선택</div>
														<div class="form-item-data type-2">
															<div class="grid-layout toggle-button-group">
																<div class="grid-layout-inner">
																	<div class="grid-layout-cell grid-4"><label class="form-toggle-box middle auto"><input type="radio" name="quick" class="quick" value="today"><em>금일</em></label></div>
																	<div class="grid-layout-cell grid-4"><label class="form-toggle-box middle auto"><input type="radio" name="quick" class="quick" value="a_week"><em>1주</em></label></div>
																	<div class="grid-layout-cell grid-4"><label class="form-toggle-box middle auto"><input type="radio" name="quick" class="quick" value="a_month"><em>1달</em></label></div>
																	<div class="grid-layout-cell grid-4"><label class="form-toggle-box middle auto"><input type="radio" name="quick" class="quick" value="three_month"><em>3달</em></label></div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="sort-cell flex-auto">
													<div class="form-group-item">
														<div class="form-item-label">검색일자 선택</div>
														<div class="form-item-data type-2">
															<div class="form-datepicker-group">
																<div class="form-datepicker auto"><input type="text" name="st_date" class="datepicker_date datepicker-start" value="<?=$startDate?>"></div>
																<div class="form-unit">~</div>
																<div class="form-datepicker auto"><input type="text" name="fi_date" class="datepicker_date datepicker-end" value="<?=$endDate?>"></div>
															</div>
														</div>
													</div>
												</div>
												<div class="sort-cell flex-1">
													<div class="form-group-item">
														<div class="form-item-label">검색조건</div>
														<div class="form-item-data type-2">
															<div class="grid-layout basic">
																<div class="grid-layout-inner">
																	<div class="grid-layout-cell grid-4">
																		<select name="order_type" class="order_type">
                                                                            <option value="date" selected>최신순</option>
                                                                            <option value="payment">예약/결제방식별</option>
                                                                            <option value="service">미용-미용별</option>
                                                                            <option value="artist">미용-미용사별</option>
																		</select>										
																	</div>
																	<div class="grid-layout-cell grid-4">
																		<select name="where_type" class="where_type">
                                                                            <option value="" selected>전체</option>
																			<option value="미용">미용</option>
																			<option value="호텔">호텔</option>
																			<option value="유치원">유치원</option>
																		</select>										
																	</div>
																	<div class="grid-layout-cell grid-2">
																		<div class="board-form-btns">
																			<button type="button" class="btn-data-refresh" onclick="location.reload();">초기화</button>
																			<a href="#" class="btn btn-purple btn-inline btn-basic-small submit_stats">조회</a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
									<div class="basic-data-group">
										<div>
											<div class="stats-result-graph">
												<div class="stats-result-graph-inner">
													<div class="stats-result-graph-cell">
														<div class="stats-result-graph-items">
															<h6 class="con-title absolute">최신순</h6>
															<div class="stats-result-graph-view">
																<div class="new-doughnut-graph">
																	<div class="new-doughnutgraph-view">
																		<div class="new-doughnutgraph-subject">
																			<div class="item-inner">
																				<div class="item-name">매출기여도</div>
<!--																				<div class="item-cate">서비스별</div>-->
																			</div>
																		</div>
																		<div class="new-doughnutgraph-data">
																			<div id="labelRatio"></div>
																		</div>
																	</div>
<!--																	<div class="new-doughnutgraph-label-group">-->
<!--																		<div class="group-inner">-->
<!--																			<div class="group-cell"><div class="new-doughnutgraph-label"><div class="colors" style="background-color:#8667c1;"></div>미용</div></div>-->
<!--																			<div class="group-cell"><div class="new-doughnutgraph-label"><div class="colors" style="background-color:#fed84e;"></div>호텔</div></div>-->
<!--																			<div class="group-cell"><div class="new-doughnutgraph-label"><div class="colors" style="background-color:#7AE19A;"></div>유치원</div></div>-->
<!--																		</div>-->
<!--																	</div>-->
																</div>
															</div>
														</div>
													</div>
													<div class="stats-result-graph-cell">
														<div class="stats-result-graph-items">
															<h6 class="con-title absolute">결제수단</h6>
															<div class="stats-result-graph-view">	
																<div class="stacked-horizontal-bar-group">
																	<div class="stacked-horizontal-bar">
																		<div class="stacked-horizontal-items">
																			<div class="graph-item yellow cash_percent" style="width:50%"><em class="cash_percent_txt">0%</em></div>
																			<div class="graph-item purple card_percent" style="width:50%"><em class="card_percent_txt">0%</em></div>
																		</div>
																	</div>
																	<div class="stacked-horizontal-labels">
																		<div class="stacked-horizontal-label">
																			<div class="label-title"><div class="colors" style="background-color:#8667c1;"></div>카드</div>
																			<div class="label-value"><strong class="total_card">0</strong>원</div>
																		</div>
																		<div class="stacked-horizontal-label">
																			<div class="label-title"><div class="colors" style="background-color:#fed84e;"></div>현금</div>
																			<div class="label-value"><strong class="total_cash">0</strong>원</div>
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
									<div class="basic-data-group">
										<div>
											<!-- 데이타 변경 영역 -->
											<div class="stats-result-data">
												<div class="stats-result-sort">
													<div class="sort-tab big">
														<div class="sort-tab-inner">
															<!-- 활성화시 actived클래스 추가 -->
															<div class="tab-cell actived"><a href="#" class="btn-tab-item"><strong>고객</strong> (<span class="customer_cnt">0</span>)</a></div>
															<div class="tab-cell"><a href="#" class="btn-tab-item"><strong>동물</strong> (<span class="pet_cnt">0</span>)</a></div>
														</div>
													</div>
												</div>
												<div>
													<!-- 데이타 변경 영역 -->
													<div class="basic-data-group">
														<table class="customer-table">
															<colgroup>
																<col style="width:18%">
																<col style="width:20%">
																<col style="width:20%">
																<col style="width:21%">
																<col style="width:21%">
															</colgroup>
															<thead>
																<tr>
																	<th rowspan="2">펫이름</th>
																	<th rowspan="2">이용 일시</th>
																	<th rowspan="2">내역</th>
																	<th colspan="2">금액(단위:원)</th>
																</tr>
																<tr>
																	<th>카드</th>
																	<th>현금</th>
																</tr>
															</thead>
															<tbody class="table_wrap">
																<!-- 없을 경우 -->
																<tr>
																	<td class="none" colspan="5">결제 내역이 없습니다.</td>
																</tr>
																<!-- //없을 경우 -->
																<!-- 하나의 아이템 -->
															</tbody>
														</table>														
													</div>
													<!-- //데이타 변경 영역 -->
												</div>												
											</div>
											<!-- //데이타 변경 영역 -->
										</div>
									</div>
								</div>
							</div>
							<div class="card-footer">
								<div class="stats-result-total">
									<div class="grid-layout">
										<div class="grid-layout-inner">
											<div class="grid-layout-cell">
												<div class="stats-result-total-item"><em>건수</em><p><span class="total_cnt">0</span>건</p></div>
											</div>
											<div class="grid-layout-cell">
												<div class="stats-result-total-item"><em>카드</em><p><span class="total_card">0</span>원</p></div>
											</div>
											<div class="grid-layout-cell">
												<div class="stats-result-total-item"><em>현금</em><p><span class="total_cash">0</span>원</p></div>
											</div>
										</div>
									</div>
								</div>
								<div class="stats-result-total">
									<div class="grid-layout">
										<div class="grid-layout-inner">
											<div class="grid-layout-cell total">
												<div class="stats-result-total-item total"><em>실적합계</em><p><span class="total_card_cash">0</span>원</p></div>
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
<script src="../static/js/jquery-ui.min.js"></script>
<script src="../static/js/billboard.js"></script>
<script src="../static/js/billboard.pkgd.js"></script>
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/report.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    let today = new Date('<?=$endDate?>');
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        gnb_actived('gnb_stats_wrap','gnb_stats');
        get_beauty_list(artist_id);
        get_artist_list(artist_id);

    })

    // 검색기간 선택
    $(document).on("click", ".quick", function(){
        //console.log($(this).val());
        //today.setMonth(today.getMonth()-1);
        var quick_date = new Date(today);
        //console.log(quick_date);
        var quick_val = $(this).val();
        var year = 0;
        var month = 0;
        var day = 0;
        if(quick_val == 'today'){
            year = quick_date.getFullYear();
            month = quick_date.getMonth()+1;
            day = quick_date.getDate();
        }else if(quick_val == 'a_week'){
            quick_date.setDate(quick_date.getDate() -7);
            year = quick_date.getFullYear();
            month = quick_date.getMonth()+1;
            day = quick_date.getDate();

        }else if(quick_val == 'a_month'){
            quick_date.setMonth(quick_date.getMonth() -1);
            year = quick_date.getFullYear();
            month = quick_date.getMonth()+1;
            day = quick_date.getDate();

        }else if(quick_val == 'three_month'){
            quick_date.setMonth(quick_date.getMonth() -3);
            year = quick_date.getFullYear();
            month = quick_date.getMonth()+1;
            day = quick_date.getDate();
        }
        $(".datepicker-start").val(year+'-'+((month<10)?'0'+month:month)+'-'+((day<10)?'0'+day:day));
        $(".datepicker-end").val('<?=$endDate?>');
    })

    // 검색조건 변경
    $(document).on("change",".order_type",function(){
        var type = $(this).val();
        console.log(type);
        var html = '<option value="" selected>전체</option>';
        if(type == 'date'){
            html += `
                <option value="미용">미용</option>
                <option value="호텔">호텔</option>
                <option value="유치원">유치원</option>
            `;
        }else if(type == 'payment'){
            html += `
                <option value="앱-선결제">앱-선결제</option>
                <option value="앱-매장결제">앱-매장결제</option>
                <option value="매장접수 ">매장접수 </option>
            `;
        }else if(type == 'service'){
            $.each(report_array[0], function(i,v){
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
                    default : txt = i;
                }
                //console.log(txt);
                if(v.is_use == 'y'){
                    html += `
                        <option value="${txt}">${txt}</option>
                    `;
                }
            })

        }else if(type == 'artist'){
            $.each(report_array[1], function(i,v){
                var name = (v.name == artist_id)? v.nick : v.name;
                if(v.is_leave == false){
                    html += `
                        <option value="${name}">${name}</option>
                    `;
                }
            })
        }
        $(".where_type").html(html);
    })

    function loading_on(){

        return new Promise(function(resolve){
            document.getElementById('loading_wrap').style.display = 'flex';

            setTimeout(function(){resolve()},300)


        })
    }
    // 조회 클릭
    $(document).on("click",".submit_stats",function(){

        loading_on().then(function(){

            var postData = decodeURIComponent($("#statsForm").serialize());
            postData += '&mode=get_performancee';
            console.log(postData);
            get_performancee(postData);
            console.log(result);
            if(result != ''){
                console.log('잇');
                $(".customer_cnt").text(result.customer_number);
                $(".pet_cnt").text(result.animal_number);
                var html = '';
                var total_card = 0;
                var total_cash = 0;
                var next_type = '';
                var little_cnt = 0;
                var little_card = 0;
                var little_cash = 0;
                var little_idx = 0;
                if(result.data.length > 1){
                    console.log('1개 이상');
                    $.each(result.data, function(i,v){
                        if(v.card === "" || v.card === null || v.card === undefined){
                            v.card = 0;
                        }
                        if(v.cash === "" || v.cash === null || v.cash === undefined){
                            v.cash = 0;
                        }
                        total_card += parseInt(v.card);
                        total_cash += parseInt(v.cash);

                        var type = $(".order_type").val();

                        var html_form = `
                        <tr class="customer-table-cell">
                            <td>
                                <div class="customer-table-txt"><strong>${v.name}</strong></div>
                            </td>
                            <td>
                                <div class="customer-table-txt">${am_pm_check2(v.reservationDate)}</div>
                            </td>
                            <td>
                                <div class="customer-table-txt">${v.payment_type} | ${v.service}</div>
                            </td>
                            <td>
                                <div class="customer-table-txt">${(v.card).format()}</div>
                            </td>
                            <td>
                                <div class="customer-table-txt">${(v.cash).format()}</div>
                            </td>
                        </tr>
                    `;

                        if(type == 'date'){
                            if(next_type == v.payment_type){
                                html += html_form;
                            }else{
                                next_type = v.payment_type;
                                little_idx += 1;
                                html += `
                                <tr>
                                    <td class="customer-table-txt1" colspan="2">${v.payment_type} 소계</td>
                                    <td class="customer-table-txt2"><span class="little_cnt_${little_idx}"></span>건</td>
                                    <td class="customer-table-txt2"><span class="little_card_${little_idx}"></span>원</td>
                                    <td class="customer-table-txt2"><span class="little_cash_${little_idx}"></span>원</td>
                                </tr>
                            `;
                                html += html_form;
                            }
                        }else if(type == 'payment'){
                            if(next_type == v.pay_type){
                                html += html_form;
                            }else{
                                next_type = v.pay_type;
                                little_idx += 1;
                                html += `
                                <tr>
                                    <td class="customer-table-txt1" colspan="2">${v.pay_type} 소계</td>
                                    <td class="customer-table-txt2"><span class="little_cnt_${little_idx}"></span>건</td>
                                    <td class="customer-table-txt2"><span class="little_card_${little_idx}"></span>원</td>
                                    <td class="customer-table-txt2"><span class="little_cash_${little_idx}"></span>원</td>
                                </tr>
                            `;
                                html += html_form;
                            }
                        }else if(type == 'service'){
                            if(next_type == v.service){
                                html += html_form;
                            }else{
                                next_type = v.service;
                                little_idx += 1;
                                html += `
                                <tr>
                                    <td class="customer-table-txt1" colspan="2">${v.service} 소계</td>
                                    <td class="customer-table-txt2"><span class="little_cnt_${little_idx}"></span>건</td>
                                    <td class="customer-table-txt2"><span class="little_card_${little_idx}"></span>원</td>
                                    <td class="customer-table-txt2"><span class="little_cash_${little_idx}"></span>원</td>
                                </tr>
                            `;
                                html += html_form;
                            }
                        }else if(type == 'artist'){
                            var worker = (v.worker == artist_id)? "대표" : v.worker;
                            if(next_type == worker){
                                html += html_form;
                            }else{
                                next_type = worker;
                                little_idx += 1;
                                html += `
                                <tr>
                                    <td class="customer-table-txt1" colspan="2">${worker} 소계</td>
                                    <td class="customer-table-txt2"><span class="little_cnt_${little_idx}"></span>건</td>
                                    <td class="customer-table-txt2"><span class="little_card_${little_idx}"></span>원</td>
                                    <td class="customer-table-txt2"><span class="little_cash_${little_idx}"></span>원</td>
                                </tr>
                            `;
                                html += html_form;
                            }
                        }

                    })

                    var total_price = total_card + total_cash;

                    var card_percent = ((total_card/total_price)*100).toFixed(1);
                    var cash_percent = ((total_cash/total_price)*100).toFixed(1);


                    $(".table_wrap").html(html);
                    $(".total_cnt").text((result.data.length).format());
                    $(".total_card").text(total_card.format());
                    $(".total_cash").text(total_cash.format());
                    $(".total_card_cash").text((total_price).format());

                    // if(card_percent>80){
                    //     $(".card_percent").css('width','80%');
                    // }else if(card_percent<20){
                    //     $(".card_percent").css('width','20%');
                    // }else{
                    $(".card_percent").css('width',card_percent+'%');
                    // }
                    // if(cash_percent>80){
                    //     $(".cash_percent").css('width','80%');
                    // }else if(cash_percent<20){
                    //     $(".cash_percent").css('width','20%');
                    // }else{
                    $(".cash_percent").css('width',cash_percent+'%');
                    // }

                    $(".card_percent_txt").text(card_percent+'%');
                    $(".cash_percent_txt").text(cash_percent+'%');

                    if(cash_percent < 12){

                        document.querySelector('.cash_percent_txt').style.display = 'none';

                    }
                    if(card_percent <12){
                        document.querySelector('.card_percent_txt').style.display = 'none';
                    }
                    //console.log(chart);


                    // 소계 값 넣기
                    // 차트 같이 넣기
                    little_idx = 0;
                    next_type = '';
                    var chart_array = [];
                    var in_array = [];
                    $.each(result.data, function(i,v){

                        var type = $(".order_type").val();

                        if(type == 'date'){
                            if(next_type == v.payment_type){
                                little_cnt += 1;
                                little_card += parseInt(v.card);
                                little_cash += parseInt(v.cash);
                                in_array = [next_type, (little_cnt/(result.data.length)*100).toFixed(1)];
                            }else{
                                if(i != 0){
                                    chart_array.push(in_array);
                                }
                                next_type = v.payment_type;
                                little_idx = little_idx + 1;
                                little_cnt = 1;
                                little_card = parseInt(v.card);
                                little_cash = parseInt(v.cash);
                                in_array = [next_type, (little_cnt/(result.data.length)*100).toFixed(1)];
                            }
                        }else if(type == 'payment'){
                            if(next_type == v.pay_type){
                                little_cnt += 1;
                                little_card += parseInt(v.card);
                                little_cash += parseInt(v.cash);
                                in_array = [next_type, (little_cnt/(result.data.length)*100).toFixed(1)];
                            }else{
                                if(i != 0){
                                    chart_array.push(in_array);
                                }
                                next_type = v.pay_type;
                                little_idx += 1;
                                little_cnt = 1;
                                little_card = parseInt(v.card);
                                little_cash = parseInt(v.cash);
                                in_array = [next_type, (little_cnt/(result.data.length)*100).toFixed(1)];
                            }
                        }else if(type == 'service'){
                            if(next_type == v.service){
                                little_cnt += 1;
                                little_card += parseInt(v.card);
                                little_cash += parseInt(v.cash);
                                in_array = [next_type, (little_cnt/(result.data.length)*100).toFixed(1)];
                            }else{
                                if(i != 0){
                                    chart_array.push(in_array);
                                }
                                next_type = v.service;
                                little_idx += 1;
                                little_cnt = 1;
                                little_card = parseInt(v.card);
                                little_cash = parseInt(v.cash);
                                in_array = [next_type, (little_cnt/(result.data.length)*100).toFixed(1)];
                            }
                        }else if(type == 'artist'){
                            var worker = (v.worker == artist_id)? "대표" : v.worker;
                            if(next_type == worker){
                                little_cnt += 1;
                                little_card += parseInt(v.card);
                                little_cash += parseInt(v.cash);
                                in_array = [next_type, (little_cnt/(result.data.length)*100).toFixed(1)];
                            }else{
                                if(i != 0){
                                    chart_array.push(in_array);
                                }
                                next_type = worker;
                                little_idx += 1;
                                little_cnt = 1;
                                little_card = parseInt(v.card);
                                little_cash = parseInt(v.cash);
                                in_array = [next_type, (little_cnt/(result.data.length)*100).toFixed(1)];
                            }
                        }
                        $(".little_cnt_"+little_idx).text(little_cnt);
                        $(".little_card_"+little_idx).text(little_card.format());
                        $(".little_cash_"+little_idx).text(little_cash.format());

                    })
                    chart_array.push(in_array);
                    //console.log(chart_array);
                    var chart_innerRadius = '{';
                    $.each(chart_array, function(i,v){
                        chart_innerRadius += '"'+v[0]+'"' + ': 90,';
                    })
                    chart_innerRadius = chart_innerRadius.slice(0,-1);
                    chart_innerRadius += '}';
                    chart_innerRadius = JSON.parse(chart_innerRadius);
                    var chart = bb.generate({
                        size: {
                            height: 285,
                            width: 285
                        },
                        data: {
                            columns: chart_array,
                            type: "pie",
                            labels: {
                                show: false
                            }
                        },
                        /* order: "asc", */ // 그래프 순서 변경하기
                        legend: {
                            show: false
                        },
                        // tooltip: {
                        //     show: false
                        // },
                        pie: {
                            startingAngle: 0.75,
                            innerRadius: chart_innerRadius,
                            label: {   // text 위치
                                ratio: 1,
                                format: function(value, id) {		return value +"%";       }
                            }
                        },
                        tooltip: {
                            format: {
                                value:
                                    function(value, id) {		return value +"%";    }
                            }
                        },
                        bindto: "#labelRatio"
                    });
                }else{
                    console.log('1개');
                    var v = result.data;
                    total_card += parseInt(v.card);
                    total_cash += parseInt(v.cash);

                    var type = $(".order_type").val();

                    var html_form = `
                    <tr class="customer-table-cell">
                        <td>
                            <div class="customer-table-txt"><strong>${v.name}</strong></div>
                        </td>
                        <td>
                            <div class="customer-table-txt">${am_pm_check2(v.reservationDate)}</div>
                        </td>
                        <td>
                            <div class="customer-table-txt">${v.payment_type} | ${v.service}</div>
                        </td>
                        <td>
                            <div class="customer-table-txt">${(v.card).format()}</div>
                        </td>
                        <td>
                            <div class="customer-table-txt">${(v.cash).format()}</div>
                        </td>
                    </tr>
                `;

                    if(type == 'date'){
                        if(next_type == v.payment_type){
                            html += html_form;
                        }else{
                            next_type = v.payment_type;
                            little_idx += 1;
                            html += `
                            <tr>
                                <td class="none" colspan="2" style="background-color: #ededed;">${v.payment_type} 소계</td>
                                <td class="customer-table-txt" style="background-color: #f9faf9;"><span class="little_cnt_${little_idx}"></span>건</td>
                                <td class="customer-table-txt" style="background-color: #f9faf9;"><span class="little_card_${little_idx}"></span>원</td>
                                <td class="customer-table-txt" style="background-color: #f9faf9;"><span class="little_cash_${little_idx}"></span>원</td>
                            </tr>
                        `;
                            html += html_form;
                        }
                    }else if(type == 'payment'){
                        if(next_type == v.pay_type){
                            html += html_form;
                        }else{
                            next_type = v.pay_type;
                            little_idx += 1;
                            html += `
                            <tr>
                                <td class="none" colspan="2" style="background-color: #ededed;">${v.pay_type} 소계</td>
                                <td class="customer-table-txt" style="background-color: #f9faf9;"><span class="little_cnt_${little_idx}"></span>건</td>
                                <td class="customer-table-txt" style="background-color: #f9faf9;"><span class="little_card_${little_idx}"></span>원</td>
                                <td class="customer-table-txt" style="background-color: #f9faf9;"><span class="little_cash_${little_idx}"></span>원</td>
                            </tr>
                        `;
                            html += html_form;
                        }
                    }else if(type == 'service'){
                        if(next_type == v.service){
                            html += html_form;
                        }else{
                            next_type = v.service;
                            little_idx += 1;
                            html += `
                            <tr>
                                <td class="none" colspan="2" style="background-color: #ededed;">${v.service} 소계</td>
                                <td class="customer-table-txt" style="background-color: #f9faf9;"><span class="little_cnt_${little_idx}"></span>건</td>
                                <td class="customer-table-txt" style="background-color: #f9faf9;"><span class="little_card_${little_idx}"></span>원</td>
                                <td class="customer-table-txt" style="background-color: #f9faf9;"><span class="little_cash_${little_idx}"></span>원</td>
                            </tr>
                        `;
                            html += html_form;
                        }
                    }else if(type == 'artist'){
                        var worker = (v.worker == artist_id)? "대표" : v.worker;
                        if(next_type == worker){
                            html += html_form;
                        }else{
                            next_type = worker;
                            little_idx += 1;
                            html += `
                            <tr>
                                <td class="none" colspan="2" style="background-color: #ededed;">${worker} 소계</td>
                                <td class="customer-table-txt" style="background-color: #f9faf9;"><span class="little_cnt_${little_idx}"></span>건</td>
                                <td class="customer-table-txt" style="background-color: #f9faf9;"><span class="little_card_${little_idx}"></span>원</td>
                                <td class="customer-table-txt" style="background-color: #f9faf9;"><span class="little_cash_${little_idx}"></span>원</td>
                            </tr>
                        `;
                            html += html_form;
                        }
                    }


                    var total_price = total_card + total_cash;
                    var card_percent = ((total_card/total_price)*100).toFixed(1);
                    var cash_percent = ((total_cash/total_price)*100).toFixed(1);

                    $(".table_wrap").html(html);
                    $(".total_cnt").text((1).format());
                    $(".total_card").text(total_card.format());
                    $(".total_cash").text(total_cash.format());
                    $(".total_card_cash").text((total_price).format());

                    // if(card_percent>80){
                    //     $(".card_percent").css('width','80%');
                    // }else if(card_percent<20){
                    //     $(".card_percent").css('width','20%');
                    // }else{
                    $(".card_percent").css('width',card_percent+'%');
                    // }
                    // if(cash_percent>80){
                    //     $(".cash_percent").css('width','80%');
                    // }else if(cash_percent<20){
                    //     $(".cash_percent").css('width','20%');
                    // }else{
                    $(".cash_percent").css('width',cash_percent+'%');
                    // }

                    $(".card_percent_txt").text(card_percent+'%');
                    $(".cash_percent_txt").text(cash_percent+'%');

                    //console.log(chart);


                    // 소계 값 넣기
                    // 차트 같이 넣기
                    little_idx = 0;
                    var chart_array = [];
                    var in_array = [];

                    var type = $(".order_type").val();

                    if(type == 'date'){
                        little_idx = little_idx + 1;
                        little_cnt = 1;
                        little_card = parseInt(v.card);
                        little_cash = parseInt(v.cash);
                        in_array = [v.payment_type, (little_cnt/(1)*100).toFixed(1)];
                        chart_array.push(in_array);
                    }else if(type == 'payment'){
                        little_idx += 1;
                        little_cnt = 1;
                        little_card = parseInt(v.card);
                        little_cash = parseInt(v.cash);
                        in_array = [v.pay_type, (little_cnt/(1)*100).toFixed(1)];
                        chart_array.push(in_array);
                    }else if(type == 'service'){
                        little_idx += 1;
                        little_cnt = 1;
                        little_card = parseInt(v.card);
                        little_cash = parseInt(v.cash);
                        in_array = [v.service, (little_cnt/(1)*100).toFixed(1)];
                        chart_array.push(in_array);
                    }else if(type == 'artist'){
                        var worker = (v.worker == artist_id)? "대표" : v.worker;
                        little_idx += 1;
                        little_cnt = 1;
                        little_card = parseInt(v.card);
                        little_cash = parseInt(v.cash);
                        in_array = [worker, (little_cnt/(1)*100).toFixed(1)];
                        chart_array.push(in_array);
                    }
                    $(".little_cnt_"+little_idx).text(little_cnt);
                    $(".little_card_"+little_idx).text(little_card.format());
                    $(".little_cash_"+little_idx).text(little_cash.format());

                    chart_array.push(in_array);
                    //console.log(chart_array);
                    var chart_innerRadius = '{';
                    $.each(chart_array, function(i,v){
                        chart_innerRadius += '"'+v[0]+'"' + ': 90,';
                    })
                    chart_innerRadius = chart_innerRadius.slice(0,-1);
                    chart_innerRadius += '}';
                    chart_innerRadius = JSON.parse(chart_innerRadius);
                    var chart = bb.generate({
                        size: {
                            height: 285,
                            width: 285
                        },
                        data: {
                            columns: chart_array,
                            type: "pie",
                            labels: {
                                show: false
                            }
                        },
                        /* order: "asc", */ // 그래프 순서 변경하기
                        legend: {
                            show: false
                        },
                        // tooltip: {
                        //     show: false
                        // },
                        pie: {
                            startingAngle: 0.75,
                            innerRadius: chart_innerRadius,
                            label: {   // text 위치
                                ratio: 1,
                                format: function(value, id) {		return value +"%";       }
                            }
                        },
                        tooltip: {
                            format: {
                                value:
                                    function(value, id) {		return value +"%";    }
                            }
                        },
                        bindto: "#labelRatio"
                    });
                }
            }else{
                console.log('없');

                $(".table_wrap").html(`
                <tr>
                    <td class="none" colspan="5">결제 내역이 없습니다.</td>
                </tr>
            `);
                $(".total_cnt").text(0);
                $(".total_card").text(0);
                $(".total_cash").text(0);
                $(".total_card_cash").text(0);
                $(".card_percent").css('width','50%');
                $(".cash_percent").css('width','50%');
                $(".card_percent_txt").text('0%');
                $(".cash_percent_txt").text('0%');
                $(".card_percent_txt").css("display","block");
                $(".cash_percent_txt").css("display","block");
                $(".customer_cnt").text(0);
                $(".pet_cnt").text(0);
                var chart = bb.generate({
                    size: {
                        height: 285,
                        width: 285
                    },
                    data: {
                        columns: [
                            ["미용", 100],
                        ],
                        colors: {
                            미용: "#FDD94E",

                        },
                        type: "pie",
                        labels: {
                            show: false
                        }
                    },
                    /* order: "asc", */ // 그래프 순서 변경하기
                    legend: {
                        show: false
                    },
                    // tooltip: {
                    //     show: false
                    // },
                    pie: {
                        startingAngle: 0.75,
                        innerRadius: {  // 차트 두께
                            미용: 90,
                        },
                        label: {   // text 위치
                            ratio: 1,
                            format: function(value, id) {		return value +"%";       }
                        }
                    },
                    tooltip: {
                        format: {
                            value:
                                function(value, id) {		return value +"%";    }
                        }
                    },
                    bindto: "#labelRatio"
                });
            }

            document.getElementById('loading_wrap').style.display = 'none';
        })

    })

    var chart = bb.generate({
        size: {
            height: 285,
            width: 285
        },
        data: {
            columns: [
                ["미용", 100],
            ],
            colors: {
                미용: "#FDD94E",

            },
            type: "pie", 
            labels: {
                show: false
            }
        },
        /* order: "asc", */ // 그래프 순서 변경하기
        legend: {
            show: false 
        }, 
        // tooltip: {
        //     show: false
        // },
        pie: {
            startingAngle: 0.75,
            innerRadius: {  // 차트 두께
                미용: 90,
            },
            label: {   // text 위치
                ratio: 1,
                format: function(value, id) {		return value +"%";       }
            }
        },
        tooltip: {
            format: {
            value: 
            function(value, id) {		return value +"%";    }
            }
        },
        bindto: "#labelRatio"
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
		showMonthAfterYear: true, // 년도가 앞으로 설정
		yearSuffix: '.', //년도 뒤 블릿 설정
		changeMonth: false, //월 선택 불가
		changeYear: false, //년 선택 불가
		showOtherMonths:true, //이전 , 다음 달 일수 활성화
	});

    $(document).on("change",".datepicker_date",function(){
        $(".quick").prop("checked",false);
    })

</script>

</body>
</html>