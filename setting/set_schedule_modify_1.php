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
										<div class="basic-data-group">
											<div class="con-title-group">
												<h4 class="con-title">기본 영업시간 설정</h4>
											</div>
											<div class="form-group">
												<div class="grid-layout margin-14-17">
													<div class="grid-layout-inner">
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label">영업시간</div>
																<div class="form-item-data type-2">
																	<div class="form-datepicker-group">
																		<div class="form-datepicker">
																			<select class="start_time">
																				<option value="09:00">오전 09:00</option>
																				<option value="10:00">오전 10:00</option>
                                                                                <option value="11:00">오전 11:00</option>
                                                                                <option value="12:00">오후 12:00</option>
                                                                                <option value="13:00">오후 01:00</option>
                                                                                <option value="14:00">오후 02:00</option>
                                                                                <option value="15:00">오후 03:00</option>
                                                                                <option value="16:00">오후 04:00</option>
                                                                                <option value="17:00">오후 05:00</option>
                                                                                <option value="18:00">오후 06:00</option>
                                                                                <option value="19:00">오후 07:00</option>
                                                                                <option value="20:00">오후 08:00</option>
                                                                                <option value="21:00">오후 09:00</option>
                                                                                <option value="22:00">오후 10:00</option>
                                                                                <option value="23:00">오후 11:00</option>
																			</select>
																		</div>
																		<div class="form-unit">~</div>
																		<div class="form-datepicker">
																			<select class="close_time">
                                                                                <option value="09:00">오전 09:00</option>
                                                                                <option value="10:00">오전 10:00</option>
                                                                                <option value="11:00">오전 11:00</option>
                                                                                <option value="12:00">오후 12:00</option>
                                                                                <option value="13:00">오후 01:00</option>
                                                                                <option value="14:00">오후 02:00</option>
                                                                                <option value="15:00">오후 03:00</option>
                                                                                <option value="16:00">오후 04:00</option>
                                                                                <option value="17:00">오후 05:00</option>
                                                                                <option value="18:00">오후 06:00</option>
                                                                                <option value="19:00">오후 07:00</option>
                                                                                <option value="20:00">오후 08:00</option>
                                                                                <option value="21:00">오후 09:00</option>
                                                                                <option value="22:00">오후 10:00</option>
                                                                                <option value="23:00">오후 11:00</option>
																			</select>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="form-group-item">
																<div class="form-item-label">공휴일 휴무 설정</div>
																<div class="form-item-data type-2">
																	<div class="memo-item type-2">
																		<div class="flex align-items-center justify-content-space-between">
																			<div>
																				<div class="holiday_txt">*공휴일은 쉬어요.</div>
																			</div>
																			<div><label for="switch-toggle" class="form-switch-toggle"><input type="checkbox" id="switch-toggle" name="is_work_holiday"><span class="bar"></span></label></div>
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
											<h6 class="con-title">휴게시간 설정</h6>
											<div class="basic-data-group vvsmall4">
												<div class="grid-layout toggle-button-group">
													<div class="grid-layout-inner break_time_wrap">
													</div>
												</div>
											</div>
										</div>
										<div class="basic-data-group">
											<div class="con-title-group">
												<h4 class="con-title">예약 스케줄 운영방식 선택</h4>
											</div>
											<div class="form-check-group">
												<div class="form-check-inner">
													<div class="check-cell"><label class="form-radiobox"><input type="radio" class="time_schedule" name="time2" value="1"><span class="form-check-icon"><em>자유시간제</em></span></label></div>
													<div class="check-cell"><label class="form-radiobox"><input type="radio" class="time_schedule" name="time2" value="2"><span class="form-check-icon"><em>타임제</em></span></label></div>
												</div>
											</div>
											<!-- 타임제 -->
											<div class="form-check-detail time_type_2_wrap" style="display:none;">
												<div class="basic-data-group">
													<div class="grid-layout basic">
														<div class="grid-layout-inner time_name_wrap">
														</div>
													</div>					
												</div>
												<div class="basic-data-group vvsmall3 line">
													<div>
														<div class="grid-layout toggle-button-group time_wrap">
														</div>
													</div>
												</div>
											</div>
											<!-- //타임제 -->
										</div>			
										<div class="basic-data-group">
											<div class="con-title-group">
												<h4 class="con-title">정기휴일 설정</h4>
											</div>
											<div class="grid-layout margin-14-17">
												<div class="grid-layout-inner">
													<div class="grid-layout-cell flex-auto">
														<div class="grid-layout basic">
															<div class="grid-layout-inner">
																<div class="grid-layout-cell flex-auto"><label class="form-toggle-box h-45"><input type="radio" value="1" name="time4"><em>매주</em></label></div>
																<div class="grid-layout-cell flex-auto"><label class="form-toggle-box h-45"><input type="radio" value="2" name="time4"><em>1/3주</em></label></div>
																<div class="grid-layout-cell flex-auto"><label class="form-toggle-box h-45"><input type="radio" value="3" name="time4"><em>2/4주</em></label></div>
															</div>
														</div>
													</div>
													<div class="grid-layout-cell flex-1">
														<div class="form-week-select">
															<div class="form-week-select-inner">
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week" class="mon"><em>월</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week" class="tue"><em>화</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week" class="wed"><em>수</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week" class="thu"><em>목</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week" class="fri"><em>금</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week" class="sat"><em>토</em></label></div>
																<div class="form-week-select-cell"><label class="form-toggle-box circle"><input type="checkbox" name="week" class="sun"><em>일</em></label></div>
															</div>
														</div>
													</div>
												</div>
											</div>											
										</div>			
										<div class="basic-data-group">
											<div class="con-title-group">
												<h4 class="con-title">임시휴일 설정</h4>
											</div>
											<div class="basic-data-group vvsmall">
												<div class="grid-layout margin-14-17">
													<div class="grid-layout-inner">
														<div class="grid-layout-cell grid-2">
															<button type="button" class="btn btn-icons btn-outline-gray btn-basic-full"><span class="txt">사정이 있어서 쉬어요</span><span class="icon icon-share-middle-black"></span></button>
														</div>
													</div>
												</div>
											</div>
											<div class="basic-data-group vvsmall4">
												<div class="grid-layout margin-5-17">
													<div class="grid-layout-inner vacation_wrap">
														<div class="grid-layout-cell grid-2">
															<div class="memo-item modify">2021.10.04 ~ 2021.10.04 (실장)<button type="button" class="btn-memo-del"><span class="icon icon-close-small-black"></span></button></div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="memo-item modify">2021.10.04 ~ 2021.10.04 (실장)<button type="button" class="btn-memo-del"><span class="icon icon-close-small-black"></span></button></div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="memo-item modify">2021.10.04 ~ 2021.10.04 (실장)<button type="button" class="btn-memo-del"><span class="icon icon-close-small-black"></span></button></div>
														</div>
														<div class="grid-layout-cell grid-2">
															<div class="memo-item modify">2021.10.04 ~ 2021.10.04 (실장)<button type="button" class="btn-memo-del"><span class="icon icon-close-small-black"></span></button></div>
														</div>
													</div>
												</div>
												<div class="form-bottom-info">휴가를 가거나 급한 사정이 있어서 쉴 때 이용하세요.<br>예약이 잡혀 있는데 쉬시려면 고객의 예약취소/변경이 먼저 등록되어야 합니다.</div>
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
    <article id="talkExam" class="layer-pop-wrap">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">

                <div class="pop-data alert-pop-data">
                    <div class="pop-body">
                        <div class="msg-txt"></div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-confirm"  onclick="$('.time_type_2_wrap').css('display','none');pop.close();">확인</button>
                    </div>
                </div>

            </div>
        </div>
    </article>
    <article id="talkExam1" class="layer-pop-wrap">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">

                <div class="pop-data alert-pop-data">
                    <div class="pop-body">
                        <div class="msg-txt"></div>
                    </div>
                    <div class="pop-footer">
                        <button type="button" class="btn btn-confirm"  onclick="$('.time_type_2_wrap').css('display','block');pop.close();">확인</button>
                    </div>
                </div>

            </div>
        </div>
    </article>
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
        get_open_close(artist_id); // 0
        break_time(artist_id); // 1
        time_type(artist_id); // 2
        part_time(artist_id); // 3
        regular_holiday(artist_id); // 4
        artist_vacation(artist_id); // 5
        console.log(setting_array);

        // 샵 오픈, 종료 시간
        $(".open_close").text(am_pm_check(fill_zero(setting_array[0].open_time))+":00 ~ "+am_pm_check(setting_array[0].close_time)+":00");
        var start_time = fill_zero(setting_array[0].open_time)+":00";
        var close_time = fill_zero(setting_array[0].close_time)+":00";
        $(".start_time").val(start_time);
        $(".close_time").val(close_time);

        // 공휴일 휴무 여부
        if(setting_array[0].is_work_on_holiday == false){
            $("#switch-toggle").prop("checked", true);
            $('#switch-toggle').val("0");
            $(".holiday_txt").text("*공휴일도 일해요");
        }else{
            $("#switch-toggle").prop("checked", false);
            $('#switch-toggle').val("1");
            $(".holiday_txt").text("*공휴일은 쉬어요");
        }

        // 휴게시간, 타임제 시간 리스트 출력
        var start_hour = setting_array[0].open_time;
        var close_hour = setting_array[0].close_time;
        var html = '';
        for(start_hour;start_hour<close_hour;start_hour++){
            html += `
                <div class="grid-layout-cell grid-8"><label class="form-toggle-box auto middle"><input type="checkbox" name="time1" class="time_${fill_zero(start_hour)}00" value="${fill_zero(start_hour)}:00"><em>${am_pm_check(fill_zero(start_hour))}:00</em></label></div>
                <div class="grid-layout-cell grid-8"><label class="form-toggle-box auto middle"><input type="checkbox" name="time1" class="time_${fill_zero(start_hour)}30" value="${fill_zero(start_hour)}:30"><em>${am_pm_check(fill_zero(start_hour))}:30</em></label></div>
            `;
        }
        $(".break_time_wrap").html(html);

        // 휴게시간
        var break_array = setting_array[1].res_time_off;
        var html = '';
        $.each(break_array, function(i,v){
            var st_time = ".break_time_wrap .time_"+((v.time).split('~')[0]).replace(':','');
            $(st_time).prop("checked", true);
        });

        // 자유시간제, 타임제
        var t_type = setting_array[2].shop_time_type; // 1:자유시간제, 2:타임제
        if(t_type == '2'){
            $("input:radio[name='time2']:radio[value='2']").prop('checked', true);
            $(".time_type_2_wrap").css("display","block");
            var time_array = setting_array[3];
            var html = '';
            var html_2 = '';
            $.each(time_array,function(i, v){
                var name = (v.name == artist_id)? "실장" : v.name;
                var checked = (name == '실장')? "checked" : "";
                var is_block = (name == '실장')? "flex" : "none";
                html += `
                    <div class="grid-layout-cell flex-auto"><label class="form-toggle-box"><input type="radio" class="worker" value="${v.idx}" name="time3" ${checked}><em>${name}</em></label></div>
                `;

                start_hour = setting_array[0].open_time;
                close_hour = setting_array[0].close_time;
                html_2 += `<div class="grid-layout-inner worker_time_wrap worker_${v.idx}" style="display: ${is_block}">`;
                for(start_hour;start_hour<close_hour;start_hour++){
                    html_2 += `
                        <div class="grid-layout-cell grid-8"><label class="form-toggle-box auto middle"><input type="checkbox" name="time1" class="time_${fill_zero(start_hour)}00" value="${fill_zero(start_hour)}:00"><em>${am_pm_check(fill_zero(start_hour))}:00</em></label></div>
                        <div class="grid-layout-cell grid-8"><label class="form-toggle-box auto middle"><input type="checkbox" name="time1" class="time_${fill_zero(start_hour)}30" value="${fill_zero(start_hour)}:30"><em>${am_pm_check(fill_zero(start_hour))}:30</em></label></div>
                    `;
                }
                html_2 += '</div>';
                $(".time_wrap").html(html_2);

                //$.each(v.res_time_off,function(index, value){
                    // var st_time = ".time_wrap .worker_"+v.idx+" .time_"+((value.time).split('~')[0]).replace(':','');
                    // $(st_time).prop("checked", true);
                //});
            });
            $(".time_name_wrap").html(html);

        }else{
            $("input:radio[name='time2']:radio[value='1']").prop('checked', true);
            $(".time_type_2_wrap").css("display","none");
        }

        // 정기휴일
        var holiday = setting_array[4];
        if(holiday.week_type == '1'){
            $("input:radio[name='time4']:radio[value='1']").prop('checked', true);
        }else if(holiday.week_type == '2'){
            $("input:radio[name='time4']:radio[value='2']").prop('checked', true);
        }else if(holiday.week_type == '3'){
            $("input:radio[name='time4']:radio[value='3']").prop('checked', true);
        }
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
                    <div class="grid-layout-cell grid-2">
                        <div class="memo-item modify">${vacation_time} (${name})<button type="button" class="btn-memo-del"><span class="icon icon-close-small-black"></span></button></div>
                    </div>
                `;
            });

        });
        $(".vacation_wrap").html(html);

        // 타임제일 경우 선택 (순서때문에 checked 안되는 현상때문에 뒤로 따로 빼놓음)
        if(t_type == '2'){
            $("input:radio[name='time2']:radio[value='2']").prop('checked', true);
            $(".time_type_2_wrap").css("display","block");
            var time_array = setting_array[3];
            var html = '';
            var html_2 = '';
            $.each(time_array,function(i, v){
                $.each(v.res_time_off,function(index, value){
                    var st_time = ".time_wrap .worker_"+v.idx+" .time_"+((value.time).split('~')[0]).replace(':','');
                    $(st_time).prop("checked", true);
                });
            });

        }
    })

    // 공휴일 휴무설정 변경 이벤트
    $('#switch-toggle').on('click',function(){
        if($(this).is(':checked')==true){
            $('.holiday_txt').text('공휴일도 일해요');
            $('#switch-toggle').val("0");
        } else {
            $('.holiday_txt').text('공휴일은 쉬어요');
            $('#switch-toggle').val("1");
        }
    });

    // 시간제 선택
    $(document).on('click','.time_schedule',function(){
        if($(this).val() == 1){
            pop.open('talkExam','예약 스케줄을 자유시간제로 변경합니다.');
        } else {
            pop.open('talkExam1','예약 스케줄을 타임제로 변경합니다.');
        }
    });

    // 타임제에서 미용사 선택
    $(document).on("click", '.worker', function(){
        $(".worker_time_wrap").css("display","none");
        var class_name = ".worker_"+$(this).val();
        $(class_name).css("display","flex");
    })

</script>
</body>
</html>