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
								<h3 class="card-header-title">판매실적/정산조회</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">									
									<div class="wide-tab">
										<div class="wide-tab-inner">
											<!-- 활성화시 actived클래스 추가 -->
											<div class="tab-cell actived"><a href="#" class="btn-tab-item">판매실적</a></div>
											<div class="tab-cell"><a href="#" class="btn-tab-item">정산조회</a></div>
										</div>
									</div>
									<div class="basic-data-group vmiddle">
										<div class="form-bottom-info type-2">취소된 예약과 NoShow예약은 제외되며 매장에서 접수한 예약은<br>매장에서 입력한 결제 금액을 그대로 표시하여 입력하지 않은 경우 0원으로 표시됩니다.</div>
									</div>
									<div class="basic-data-group middle">
										<div class="board-form-sort">
											<div class="sort-inner">
												<div class="sort-cell flex-auto">
													<div class="form-group-item">
														<div class="form-item-label">검색기간 선택</div>
														<div class="form-item-data type-2">
															<div class="grid-layout toggle-button-group">
																<div class="grid-layout-inner">
																	<div class="grid-layout-cell grid-4"><label class="form-toggle-box middle auto"><input type="radio" name="time1"><em>금일</em></label></div>
																	<div class="grid-layout-cell grid-4"><label class="form-toggle-box middle auto"><input type="radio" name="time1"><em>1주</em></label></div>
																	<div class="grid-layout-cell grid-4"><label class="form-toggle-box middle auto"><input type="radio" name="time1"><em>1달</em></label></div>
																	<div class="grid-layout-cell grid-4"><label class="form-toggle-box middle auto"><input type="radio" name="time1"><em>3달</em></label></div>
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
																<div class="form-datepicker auto"><input type="text" class="datepicker-start"></div>
																<div class="form-unit">~</div>
																<div class="form-datepicker auto"><input type="text" class="datepicker-end"></div>
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
																		<select>
																			<option value="">전체</option>
																			<option value="">전체</option>
																			<option value="">전체</option>
																		</select>										
																	</div>
																	<div class="grid-layout-cell grid-4">
																		<select>
																			<option value="">전체</option>
																			<option value="">전체</option>
																			<option value="">전체</option>
																		</select>										
																	</div>
																	<div class="grid-layout-cell grid-2">
																		<div class="board-form-btns">
																			<button type="button" class="btn-data-refresh">초기화</button>
																			<a href="#" class="btn btn-purple btn-inline btn-basic-small">조회</a>
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
													</div>
													<div class="stats-result-graph-cell">
														<div class="stats-result-graph-items">
															<h6 class="con-title absolute">결제수단</h6>
															<div class="stats-result-graph-view">	
																<div class="stacked-horizontal-bar-group">
																	<div class="stacked-horizontal-bar">
																		<div class="stacked-horizontal-items">
																			<div class="graph-item yellow" style="width:70%"><em>70%</em></div>
																			<div class="graph-item purple" style="width:30%"><em>30%</em></div>
																		</div>
																	</div>
																	<div class="stacked-horizontal-labels">
																		<div class="stacked-horizontal-label">
																			<div class="label-title"><div class="colors" style="background-color:#8667c1;"></div>카드</div>
																			<div class="label-value"><strong>1,450,000</strong>원</div>
																		</div>
																		<div class="stacked-horizontal-label">
																			<div class="label-title"><div class="colors" style="background-color:#fed84e;"></div>현금</div>
																			<div class="label-value"><strong>1,450,000</strong>원</div>
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
															<div class="tab-cell actived"><a href="#" class="btn-tab-item"><strong>고객</strong> (187)</a></div>
															<div class="tab-cell"><a href="#" class="btn-tab-item"><strong>동물</strong> (340)</a></div>
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
															<tbody>
																<!-- 없을 경우 -->
																<tr>
																	<td class="none" colspan="5">결제 내역이 없습니다.</td>
																</tr>
																<!-- //없을 경우 -->
																<!-- 하나의 아이템 -->
																<tr class="customer-table-cell">		
																	<td>
																		<div class="customer-table-txt"><strong>콩돌이</strong></div>
																	</td>
																	<td>
																		<div class="customer-table-txt">2021.12.25 오후 01:25</div>
																	</td>
																	<td>
																		<div class="customer-table-txt">미용 | 가위컷</div>
																	</td>
																	<td>
																		<div class="customer-table-txt">130,000</div>
																	</td>
																	<td>
																		<div class="customer-table-txt">0</div>
																	</td>
																</tr>
																<!-- //하나의 아이템 -->
																<tr class="customer-table-cell">		
																	<td>
																		<div class="customer-table-txt"><strong>콩돌이</strong></div>
																	</td>
																	<td>
																		<div class="customer-table-txt">2021.12.25 오후 01:25</div>
																	</td>
																	<td>
																		<div class="customer-table-txt">미용 | 가위컷</div>
																	</td>
																	<td>
																		<div class="customer-table-txt">130,000</div>
																	</td>
																	<td>
																		<div class="customer-table-txt">0</div>
																	</td>
																</tr>
																<tr class="customer-table-cell">		
																	<td>
																		<div class="customer-table-txt"><strong>콩돌이</strong></div>
																	</td>
																	<td>
																		<div class="customer-table-txt">2021.12.25 오후 01:25</div>
																	</td>
																	<td>
																		<div class="customer-table-txt">미용 | 가위컷</div>
																	</td>
																	<td>
																		<div class="customer-table-txt">130,000</div>
																	</td>
																	<td>
																		<div class="customer-table-txt">0</div>
																	</td>
																</tr>
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
												<div class="stats-result-total-item"><em>건수</em><p>999건</p></div>
											</div>
											<div class="grid-layout-cell">
												<div class="stats-result-total-item"><em>카드</em><p>20,500,000원</p></div>
											</div>
											<div class="grid-layout-cell">
												<div class="stats-result-total-item"><em>현금</em><p>10,450,000원</p></div>
											</div>
										</div>
									</div>
								</div>
								<div class="stats-result-total">
									<div class="grid-layout">
										<div class="grid-layout-inner">
											<div class="grid-layout-cell total">
												<div class="stats-result-total-item total"><em>실적합계</em><p>3,950,000원</p></div>
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
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        get_performancee(artist_id);
        console.log(report_array);
    })

        var chart = bb.generate({
        size: {
            height: 285,
            width: 285
        },
        data: {
            columns: [
                ["유치원", 12],
                ["호텔", 25],
                ["미용", 63]
            ],
            colors: {                
                유치원: "#7AE19A",                
                호텔: "#FDD94E",                
                미용: "#8667c1",  
                          
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
                유치원: 90, 
                호텔: 90,
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
		buttonImage: "../assets/images/icon/icon-datepicker_black.png",
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
		buttonImage: "../assets/images/icon/icon-datepicker_black.png",
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

</script>

</body>
</html>