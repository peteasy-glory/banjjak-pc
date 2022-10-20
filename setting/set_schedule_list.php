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
								<h3 class="card-header-title">일정관리</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="set-schedule-wrap">
										<div class="wide-tab">
											<div class="wide-tab-inner">
												<!-- 활성화시 actived클래스 추가 -->
												<div class="tab-cell actived"><a href="#" class="btn-tab-item">미용</a></div>
												<div class="tab-cell"><a href="#" class="btn-tab-item" onclick="pop.open('firstRequestMsg1', '준비중입니다.')">호텔</a></div>
												<div class="tab-cell"><a href="#" class="btn-tab-item" onclick="pop.open('firstRequestMsg1', '준비중입니다.')">유치원</a></div>
											</div>
										</div>
										<!-- 내용이 있을 경우 -->
										<div class="basic-data-group vmiddle">
											<div class="con-title-group">
												<h4 class="con-title">영업시간</h4>
											</div>
											<div class="grid-layout margin-14-17">
												<div class="grid-layout-inner">
													<div class="grid-layout-cell grid-2">
														<div class="con-title-group">
															<h6 class="con-title">기본영업시간</h6>
														</div>
														<div class="msg-select-group">
															<div class="msg-item read">
																<div class="item-value open_close"></div>
															</div>
															<div class="msg-item read">
																<div class="item-value is_work_holiday">공휴일은 쉬어요</div>
															</div>
														</div>
													</div>
													<div class="grid-layout-cell grid-2">
														<div class="con-title-group">
															<h6 class="con-title">휴게시간</h6>
														</div>
														<div class="msg-select-group break_time_wrap">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="basic-data-group">
											<div class="grid-layout margin-14-17">
												<div class="grid-layout-inner">
													<div class="grid-layout-cell grid-2">
														<div class="con-title-group">
															<h4 class="con-title">예약스케줄 운영시간</h4>
														</div>
														<div class="con-title-group">
															<h6 class="con-title time_type_title">자유시간제</h6>
														</div>
														<div class="msg-select-group time_type_wrap">
														</div>
													</div>
													<div class="grid-layout-cell grid-2">
														<div class="con-title-group">
															<h4 class="con-title">정기휴무</h4>
														</div>
														<div class="con-title-group">
															<h6 class="con-title">요일</h6>
														</div>
														<div class="form-week-select">
															<div class="form-week-select-inner">
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" class="mon" name="week" disabled><em>월</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" class="tue" name="week" disabled><em>화</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" class="wed" name="week" disabled><em>수</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" class="thu" name="week" disabled><em>목</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" class="fri" name="week" disabled><em>금</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" class="sat" name="week" disabled><em>토</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" class="sun" name="week" disabled><em>일</em></label></div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="basic-data-group">
											<div class="con-title-group">
												<h4 class="con-title">임시휴무</h4>
											</div>
											<div class="flex-table read w-90 vacation_wrap">
											</div>
										</div>
										<!-- //내용이 있을 경우 -->
										<!-- 내용이 없을 경우 -->
										<!--<div class="basic-data-group vmiddle text-align-center">
											<a href="#" class="btn btn-purple btn-basic-wide"><strong>영업시간 등록하기</strong></a>
											<div class="common-none-data">
												<div class="none-inner">
													<div class="item-visual"><img src="../assets/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
													<div class="item-info">영업시간이 등록되지 않았습니다.</div>
													<div class="item-desc text-align-center">미용, 호텔, 유치원/놀이터의 각 서비스 유형에 맞춰 영업시간을 설정할 수 있습니다.<br>영업시간 내 휴식 및 점심간은 휴게시간으로 간편하게 설정하세요.</div>
												</div>
											</div>
										</div>-->
										<!-- //내용이 없을 경우 -->
									</div>
								</div>
							</div>
							<div class="card-footer">
								<!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
								<a href="set_schedule_modify_1.php" class="btn-page-bottom">수정하기</a>
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
        gnb_actived('gnb_detail_wrap','gnb_schedule');
        get_open_close(artist_id); // 0
        break_time(artist_id); // 1
        time_type(artist_id); // 2
        part_time(artist_id); // 3
        regular_holiday(artist_id); // 4
        artist_vacation(artist_id); // 5
        console.log(setting_array);

        // 샵 오픈, 종료 시간
        $(".open_close").text(am_pm_check(fill_zero(setting_array[0].open_time))+":00 ~ "+am_pm_check(setting_array[0].close_time)+":00");

        // 공휴일 휴무 여부
        if(setting_array[0].is_work_on_holiday == false){
            $(".is_work_holiday").text("공휴일도 일해요");
        }else{
            $(".is_work_holiday").text("공휴일은 쉬어요");
        }

        // 휴게시간
        var break_array = setting_array[1].res_time_off;
        var html = '';
        console.log(break_array);
        if(break_array[0].time != 'False'){
            $.each(break_array, function(i,v){
                var st_time = (v.time).split('~')[0];
                var fi_time = (v.time).split('~')[1];
                html += `
                <div class="msg-item read">
                    <div class="item-value">${am_pm_check_time(st_time)} ~ ${am_pm_check_time(fi_time)}</div>
                </div>
            `;
            });
            $(".break_time_wrap").html(html);
        }

        // 자유시간제, 타임제
        var t_type = setting_array[2].is_time_Type; // 1:자유시간제, 2:타임제
        if(t_type == '2'){
            $('.time_type_title').text("타임제");
            var time_array = setting_array[3];
            var html = '';
            $.each(time_array,function(i, v){
                html += (v.name == artist_id)? "실장" : v.name;
                $.each(v.res_time_off,function(index, value){
                    var st_time = (value.time).split('~')[0];
                    var fi_time = (value.time).split('~')[1];
                    html += `
                        <div class="msg-item read">
                            <div class="item-value">${am_pm_check_time(st_time)} ~ ${am_pm_check_time(fi_time)}</div>
                        </div>
                    `;
                });
                html += '<br>';
            });
            $(".time_type_wrap").html(html);
        }

        // 정기휴일
        var holiday = setting_array[4];
        if(holiday.is_work_mon == true){
            $(".mon").prop("checked", true);
        }
        if(holiday.is_work_tue == true){
            $(".tue").prop("checked", true);
        }
        if(holiday.is_work_wed == true){
            $(".wed").prop("checked", true);
        }
        if(holiday.is_work_thu == true){
            $(".thu").prop("checked", true);
        }
        if(holiday.is_work_fri == true){
            $(".fri").prop("checked", true);
        }
        if(holiday.is_work_sat == true){
            $(".sat").prop("checked", true);
        }
        if(holiday.is_work_sun == true){
            $(".sun").prop("checked", true);
        }

        // 임시휴무
        console.log(setting_array[5]);
        var vacation_array = setting_array[5];
        var html = '';
        $.each(vacation_array,function(i, v){
            var name = (v.worker == artist_id)? "실장" : v.worker;
            $.each(v.vacation,function(index, value){
                // 휴가 판단
                var vacation_time
                if(value.type == "all"){
                    vacation_time = (value.date_st).split(" ")[0] + " ~ " + (value.date_fi).split(" ")[0];
                }else{
                    vacation_time = `${am_pm_check2(value.date_st)} ~ ${am_pm_check_time((value.date_fi).split(" ")[1])}`;
                }
                html += `
                    <div class="flex-table-cell">
                        <div class="flex-table-item">
                            <div class="flex-table-title"><div class="txt">${name}</div></div>
                            <div class="flex-table-data">
                                <div class="flex-table-data-inner">
                                    ${vacation_time}
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });

        });
        $(".vacation_wrap").html(html);

    })
</script>
</body>
</html>