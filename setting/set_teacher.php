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
								<h3 class="card-header-title">미용사 관리</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="set-teacher-wrap">
										<div class="basic-data-group text-align-center">
											<button type="button" class="btn btn-outline-purple btn-basic-wide" onclick="pop.open('teacherSet')"><strong>미용사 추가</strong></button>
										</div>
										<div class="basic-data-group vvsmall3 text-align-center">
											<div class="con-title-info type-2">미용사 이름을 드래그하여 순서 변경 가능합니다.</div>
										</div>
										<div class="basic-data-group large">
											<ul class="accordion-list card drag-sort-wrap artist_list_wrap">
												<!--
												// 숨김 및 퇴사시 accordion-cell클래스에 hide클래스 추가
												-->
											</ul>
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
    <!-- 미용사 등록/수정 팝업 -->
    <article id="teacherSet" class="layer-pop-wrap">
        <div class="layer-pop-parent">
            <div class="layer-pop-children">
                <form id="artist_form" class="pop-data data-pop-view">
                    <input type="hidden" name="artist_id" value="<?=$artist_id?>">
                    <input type="hidden" name="is_main" value="0">
                    <input type="hidden" name="is_out" value="2">
                    <input type="hidden" name="is_view" value="2">
                    <input type="hidden" name="sequ_prnt" value="9999">
                    <div class="pop-header">
                        <h4 class="con-title">미용사 등록/수정</h4>
                    </div>
                    <div class="pop-body">
                        <!-- set-teacher-add -->
                        <div class="set-teacher-add">
                            <div class="basic-data-group">
                                <div class="form-group">
                                    <div class="form-group-cell middle">
                                        <div class="form-group-item">
                                            <div class="form-item-label">이름</div>
                                            <div class="form-item-data">
                                                <input type="text" class="form-control name" name="name" placeholder="입력">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-cell middle">
                                        <div class="form-group-item">
                                            <div class="form-item-label">닉네임</div>
                                            <div class="form-item-data">
                                                <input type="text" class="form-control nicname" name="nicname" placeholder="입력">
                                                <div class="form-bottom-info">닉네임은 고객에게 보여지는 명칭입니다.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="basic-data-group">
                                <div class="con-title-group">
                                    <h4 class="con-title">업무요일/시간</h4>
                                </div>
                                <div class="basic-data-group vvsmall4">
                                    <div class="schedule-day-list">
                                        <div class="schedule-day-item input">
                                            <div class="item-check">
                                                <label class="form-radiobox week"><input type="checkbox" class="week_ch_box" id="artist_0" name="week[]" value="0" checked><span class="form-check-icon"><em>일</em></span></label>
                                            </div>
                                            <div class="item-input">
                                                <div class="form-datepicker-group">
                                                    <div class="form-datepicker">
                                                        <select class="time_select start_time" id="artist_0_st" name="st_time[]">
                                                        </select>
                                                    </div>
                                                    <div class="form-unit">~</div>
                                                    <div class="form-datepicker">
                                                        <select class="time_select finish_time" id="artist_0_fi" name="fi_time[]">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="schedule-day-item input">
                                            <div class="item-check">
                                                <label class="form-radiobox week"><input type="checkbox" class="week_ch_box" id="artist_1" name="week[]" value="1" checked><span class="form-check-icon"><em>월</em></span></label>
                                            </div>
                                            <div class="item-input">
                                                <div class="form-datepicker-group">
                                                    <div class="form-datepicker">
                                                        <select class="time_select start_time" id="artist_1_st" name="st_time[]">
                                                        </select>
                                                    </div>
                                                    <div class="form-unit">~</div>
                                                    <div class="form-datepicker">
                                                        <select class="time_select finish_time" id="artist_1_fi" name="fi_time[]">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="schedule-day-item input">
                                            <div class="item-check">
                                                <label class="form-radiobox week"><input type="checkbox" class="week_ch_box" id="artist_2" name="week[]" value="2" checked><span class="form-check-icon"><em>화</em></span></label>
                                            </div>
                                            <div class="item-input">
                                                <div class="form-datepicker-group">
                                                    <div class="form-datepicker">
                                                        <select class="time_select start_time" id="artist_2_st" name="st_time[]">
                                                        </select>
                                                    </div>
                                                    <div class="form-unit">~</div>
                                                    <div class="form-datepicker">
                                                        <select class="time_select finish_time" id="artist_2_fi" name="fi_time[]">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="schedule-day-item input">
                                            <div class="item-check">
                                                <label class="form-radiobox week"><input type="checkbox" class="week_ch_box" id="artist_3" name="week[]" value="3" checked><span class="form-check-icon"><em>수</em></span></label>
                                            </div>
                                            <div class="item-input">
                                                <div class="form-datepicker-group">
                                                    <div class="form-datepicker">
                                                        <select class="time_select start_time" id="artist_3_st" name="st_time[]">
                                                        </select>
                                                    </div>
                                                    <div class="form-unit">~</div>
                                                    <div class="form-datepicker">
                                                        <select class="time_select finish_time" id="artist_3_fi" name="fi_time[]">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="schedule-day-item input">
                                            <div class="item-check">
                                                <label class="form-radiobox week"><input type="checkbox" class="week_ch_box" id="artist_4" name="week[]" value="4" checked><span class="form-check-icon"><em>목</em></span></label>
                                            </div>
                                            <div class="item-input">
                                                <div class="form-datepicker-group">
                                                    <div class="form-datepicker">
                                                        <select class="time_select start_time" id="artist_4_st" name="st_time[]">
                                                        </select>
                                                    </div>
                                                    <div class="form-unit">~</div>
                                                    <div class="form-datepicker">
                                                        <select class="time_select finish_time" id="artist_4_fi" name="fi_time[]">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="schedule-day-item input">
                                            <div class="item-check">
                                                <label class="form-radiobox week"><input type="checkbox" class="week_ch_box" id="artist_5" name="week[]" value="5" checked><span class="form-check-icon"><em>금</em></span></label>
                                            </div>
                                            <div class="item-input">
                                                <div class="form-datepicker-group">
                                                    <div class="form-datepicker">
                                                        <select class="time_select start_time" id="artist_5_st" name="st_time[]">
                                                        </select>
                                                    </div>
                                                    <div class="form-unit">~</div>
                                                    <div class="form-datepicker">
                                                        <select class="time_select finish_time" id="artist_5_fi" name="fi_time[]">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="schedule-day-item input">
                                            <div class="item-check">
                                                <label class="form-radiobox week"><input type="checkbox" class="week_ch_box" id="artist_6" name="week[]" value="6" checked><span class="form-check-icon"><em>토</em></span></label>
                                            </div>
                                            <div class="item-input">
                                                <div class="form-datepicker-group">
                                                    <div class="form-datepicker">
                                                        <select class="time_select start_time" id="artist_6_st" name="st_time[]">
                                                        </select>
                                                    </div>
                                                    <div class="form-unit">~</div>
                                                    <div class="form-datepicker">
                                                        <select class="time_select finish_time" id="artist_6_fi" name="fi_time[]">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- //set-teacher-add -->
                    </div>
                    <div class="pop-footer">
                        <a href="#" class="btn btn-purple" onclick="save_artist('#teacherSet')"><strong>저장하기</strong></a>
                    </div>
                    <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
                </form>
            </div>
        </div>
    </article>
    <!-- //미용사 등록/수정 팝업 -->
</div>
<!-- //wrap -->
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/setting.js"></script>
<script src="../static/js/Sortable.min.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        gnb_actived('gnb_detail_wrap','gnb_artist');
        get_artist_list(artist_id);
        get_open_close(artist_id);
        console.log(setting_array);

        // 미용사 리스트
        var artist_array = setting_array[0];
        var html = '';
        var modify_form = '';
        $.each(artist_array, function (i, v){
            var host = (v.name == artist_id)? '<div class="label label-outline-purple round vmiddle">대표미용사</div>' : '';
            var is_show = '';
            var is_leave = '';
            var hide = '';
            var mo_main = (v.name == artist_id)? '1' : '0';
            var mo_out = '2';
            var mo_view = '2';
            var show_modify = `<a href="#" class="btn btn-outline-gray btn-basic-small" onclick="show_modify_artist('${artist_id}','${v.name}','1');">숨김</a>`;
            var leave_modify = `<a href="#" class="btn btn-outline-gray btn-basic-small" onclick="leave_modify_artist('${artist_id}','${v.name}','1');">퇴사</a>`;

            if(v.is_show == false){
                is_show = '(숨김)';
                hide = 'hide';
                mo_view = '1';
                show_modify = `<a href="#" class="btn btn-outline-gray btn-basic-small" onclick="show_modify_artist('${artist_id}','${v.name}','2');">숨김 해제</a>`;
            }
            if(v.is_leave == true){
                is_leave = '(퇴사)';
                hide = 'hide';
                mo_out = '1';
                leave_modify = `<a href="#" class="btn btn-outline-gray btn-basic-small" onclick="leave_modify_artist('${artist_id}','${v.name}','2');">퇴사 취소</a>`;
            }

            html += `
                <li class="accordion-cell ${hide}" data-name="${v.name}">
                    <div class="card-teacher-item">
                        <div class="card-teacher-header">
                            <div class="item-info-wrap">
                                <div class="item-info-inner">
                                    <div class="item-name">${v.name}</div>
                                    <div class="item-info">닉네임 : ${v.nick}</div>
                                </div>
                            </div>
                            <div class="item-state">${host}<div class="txt">${is_leave} ${is_show}</div></div>
                            <button type="button" class="btn-accordion-menu"></button>
                        </div>
                        <div class="accordion-content">
                            <div class="card-teacher-body">
                                <div class="schedule-day-list artist_${i}">
                                    <div class="schedule-day-item sun" style="display: none;">
                                        <div class="item-title"><div class="schedule-day-state">일</div></div>
                                        <div class="item-value">오전 09:00 ~ 오후 07:00</div>
                                    </div>
                                    <div class="schedule-day-item mon" style="display: none;">
                                        <div class="item-title"><div class="schedule-day-state">월</div></div>
                                        <div class="item-value">오전 09:00 ~ 오후 07:00</div>
                                    </div>
                                    <div class="schedule-day-item tue" style="display: none;">
                                        <div class="item-title"><div class="schedule-day-state">화</div></div>
                                        <div class="item-value">오전 09:00 ~ 오후 07:00</div>
                                    </div>
                                    <div class="schedule-day-item wed" style="display: none;">
                                        <div class="item-title"><div class="schedule-day-state">수</div></div>
                                        <div class="item-value">오전 09:00 ~ 오후 07:00</div>
                                    </div>
                                    <div class="schedule-day-item thu" style="display: none;">
                                        <div class="item-title"><div class="schedule-day-state">목</div></div>
                                        <div class="item-value">오전 09:00 ~ 오후 07:00</div>
                                    </div>
                                    <div class="schedule-day-item fri" style="display: none;">
                                        <div class="item-title"><div class="schedule-day-state">금</div></div>
                                        <div class="item-value">오전 09:00 ~ 오후 07:00</div>
                                    </div>
                                    <div class="schedule-day-item sat" style="display: none;">
                                        <div class="item-title"><div class="schedule-day-state">토</div></div>
                                        <div class="item-value">오전 09:00 ~ 오후 07:00</div>
                                    </div>
                                </div>
                                <div class="btn-basic-action">
                                    <div class="grid-layout basic btn-grid-group">
                                        <div class="grid-layout-inner justify-content-end">
                                            <div class="grid-layout-cell flex-auto"><a href="#" class="btn btn-outline-gray btn-basic-small" onclick="pop.open('modify_${i}');">수정</a></div>
                                            <div class="grid-layout-cell flex-auto">${leave_modify}</div>
											<div class="grid-layout-cell flex-auto">${show_modify}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            `;

            modify_form += `
                <article id="modify_${i}" class="layer-pop-wrap">
                    <div class="layer-pop-parent">
                        <div class="layer-pop-children">
                            <form id="artist_form" class="pop-data data-pop-view">
                                <input type="hidden" name="artist_id" value="${artist_id}">
                                <input type="hidden" name="is_main" value="${mo_main}">
                                <input type="hidden" name="is_out" value="${mo_out}">
                                <input type="hidden" name="is_view" value="${mo_view}">
                                <input type="hidden" name="sequ_prnt" value="${v.ord}">
                                <div class="pop-header">
                                    <h4 class="con-title">미용사 등록/수정</h4>
                                </div>
                                <div class="pop-body">
                                    <!-- set-teacher-add -->
                                    <div class="set-teacher-add">
                                        <div class="basic-data-group">
                                            <div class="form-group">
                                                <div class="form-group-cell middle">
                                                    <div class="form-group-item">
                                                        <div class="form-item-label">이름</div>
                                                        <div class="form-item-data">
                                                            <input type="text" class="form-control name" name="name" placeholder="입력" value="${v.name}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group-cell middle">
                                                    <div class="form-group-item">
                                                        <div class="form-item-label">닉네임</div>
                                                        <div class="form-item-data">
                                                            <input type="text" class="form-control nicname" name="nicname" placeholder="입력" value="${v.nick}">
                                                            <div class="form-bottom-info">닉네임은 고객에게 보여지는 명칭입니다.</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="basic-data-group">
                                            <div class="con-title-group">
                                                <h4 class="con-title">업무요일/시간</h4>
                                            </div>
                                            <div class="basic-data-group vvsmall4">
                                                <div class="schedule-day-list">
                                                    <div class="schedule-day-item input">
                                                        <div class="item-check">
                                                            <label class="form-radiobox week"><input type="checkbox" class="week_ch_box" name="week[]" id="${i}_0" value="0"><span class="form-check-icon"><em>일</em></span></label>
                                                        </div>
                                                        <div class="item-input">
                                                            <div class="form-datepicker-group">
                                                                <div class="form-datepicker">
                                                                    <select class="time_select start_time" name="st_time[]" id="${i}_0_st" disabled>
                                                                    </select>
                                                                </div>
                                                                <div class="form-unit">~</div>
                                                                <div class="form-datepicker">
                                                                    <select class="time_select finish_time" name="fi_time[]" id="${i}_0_fi" disabled>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="schedule-day-item input">
                                                        <div class="item-check">
                                                            <label class="form-radiobox week"><input type="checkbox" class="week_ch_box" name="week[]" id="${i}_1" value="1"><span class="form-check-icon"><em>월</em></span></label>
                                                        </div>
                                                        <div class="item-input">
                                                            <div class="form-datepicker-group">
                                                                <div class="form-datepicker">
                                                                    <select class="time_select start_time" name="st_time[]" id="${i}_1_st" disabled>
                                                                    </select>
                                                                </div>
                                                                <div class="form-unit">~</div>
                                                                <div class="form-datepicker">
                                                                    <select class="time_select finish_time" name="fi_time[]" id="${i}_1_fi" disabled>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="schedule-day-item input">
                                                        <div class="item-check">
                                                            <label class="form-radiobox week"><input type="checkbox" class="week_ch_box" name="week[]" id="${i}_2" value="2"><span class="form-check-icon"><em>화</em></span></label>
                                                        </div>
                                                        <div class="item-input">
                                                            <div class="form-datepicker-group">
                                                                <div class="form-datepicker">
                                                                    <select class="time_select start_time" name="st_time[]" id="${i}_2_st" disabled>
                                                                    </select>
                                                                </div>
                                                                <div class="form-unit">~</div>
                                                                <div class="form-datepicker">
                                                                    <select class="time_select finish_time" name="fi_time[]" id="${i}_2_fi" disabled>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="schedule-day-item input">
                                                        <div class="item-check">
                                                            <label class="form-radiobox week"><input type="checkbox" class="week_ch_box" name="week[]" id="${i}_3" value="3"><span class="form-check-icon"><em>수</em></span></label>
                                                        </div>
                                                        <div class="item-input">
                                                            <div class="form-datepicker-group">
                                                                <div class="form-datepicker">
                                                                    <select class="time_select start_time" name="st_time[]" id="${i}_3_st" disabled>
                                                                    </select>
                                                                </div>
                                                                <div class="form-unit">~</div>
                                                                <div class="form-datepicker">
                                                                    <select class="time_select finish_time" name="fi_time[]" id="${i}_3_fi" disabled>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="schedule-day-item input">
                                                        <div class="item-check">
                                                            <label class="form-radiobox week"><input type="checkbox" class="week_ch_box" name="week[]" id="${i}_4" value="4"><span class="form-check-icon"><em>목</em></span></label>
                                                        </div>
                                                        <div class="item-input">
                                                            <div class="form-datepicker-group">
                                                                <div class="form-datepicker">
                                                                    <select class="time_select start_time" name="st_time[]" id="${i}_4_st" disabled>
                                                                    </select>
                                                                </div>
                                                                <div class="form-unit">~</div>
                                                                <div class="form-datepicker">
                                                                    <select class="time_select finish_time" name="fi_time[]" id="${i}_4_fi" disabled>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="schedule-day-item input">
                                                        <div class="item-check">
                                                            <label class="form-radiobox week"><input type="checkbox" class="week_ch_box" name="week[]" id="${i}_5" value="5"><span class="form-check-icon"><em>금</em></span></label>
                                                        </div>
                                                        <div class="item-input">
                                                            <div class="form-datepicker-group">
                                                                <div class="form-datepicker">
                                                                    <select class="time_select start_time" name="st_time[]" id="${i}_5_st" disabled>
                                                                    </select>
                                                                </div>
                                                                <div class="form-unit">~</div>
                                                                <div class="form-datepicker">
                                                                    <select class="time_select finish_time" name="fi_time[]" id="${i}_5_fi" disabled>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="schedule-day-item input">
                                                        <div class="item-check">
                                                            <label class="form-radiobox week"><input type="checkbox" class="week_ch_box" name="week[]" id="${i}_6" value="6"><span class="form-check-icon"><em>토</em></span></label>
                                                        </div>
                                                        <div class="item-input">
                                                            <div class="form-datepicker-group">
                                                                <div class="form-datepicker">
                                                                    <select class="time_select start_time" name="st_time[]" id="${i}_6_st" disabled>
                                                                    </select>
                                                                </div>
                                                                <div class="form-unit">~</div>
                                                                <div class="form-datepicker">
                                                                    <select class="time_select finish_time" name="fi_time[]" id="${i}_6_fi" disabled>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- //set-teacher-add -->
                                </div>
                                <div class="pop-footer">
                                    <a href="#" class="btn btn-purple" onclick="save_artist('#modify_${i}')"><strong>저장하기</strong></a>
                                </div>
                                <button type="button" class="btn-pop-close" onclick="pop.close();">닫기</button>
                            </form>
                        </div>
                    </div>
                </article>
            `;

        })
        $(".artist_list_wrap").html(html);
        $("#wrap").append(modify_form);

        // 영업시간만큼 time 리스트 뿌려주기
        var st_time = setting_array[1].open_time;
        var fi_time = setting_array[1].close_time;
        var html = '';
        var html_st = '';
        var html_fi = '';
        for(st_time;st_time<fi_time;st_time++){
            html += `
                <option value="${fill_zero(st_time)}:00">${am_pm_check(fill_zero(st_time))}:00</option>
                <option value="${fill_zero(st_time)}:30">${am_pm_check(fill_zero(st_time))}:30</option>
           `;
        }
        html_st = html + `<option value="${fill_zero(st_time)}:00">${am_pm_check(fill_zero(st_time))}:00</option>`;
        html_fi = html + `<option value="${fill_zero(st_time)}:00" selected>${am_pm_check(fill_zero(st_time))}:00</option>`;
        $(".start_time").html(html_st);
        $(".finish_time").html(html_fi);
        // 각 미용사별 근무 요일, 시간 출력 및 선택
        $.each(artist_array, function (i, v){
            var name = ".artist_"+i;
            $.each(v.work, function(index, value){
                var day = '';
                switch (value.week){
                    case '0': day = ' .sun'; break;
                    case '1': day = ' .mon'; break;
                    case '2': day = ' .tue'; break;
                    case '3': day = ' .wed'; break;
                    case '4': day = ' .thu'; break;
                    case '5': day = ' .fri'; break;
                    case '6': day = ' .sat'; break;
                }
                var wrap = name+day
                var start_time = am_pm_check_time(value.time_st);
                var end_time = am_pm_check_time(value.time_fi);
                var wrap_time = wrap+" .item-value";
                $(wrap_time).text(start_time + " ~ " + end_time);
                $(wrap).css("display","flex");

                // modify
                var m_week = "#"+i+"_"+value.week;
                var m_week_st = "#"+i+"_"+value.week+"_st";
                var m_week_fi = "#"+i+"_"+value.week+"_fi";
                $(m_week).prop("checked", true);
                $(m_week_st).removeAttr("disabled");
                $(m_week_fi).removeAttr("disabled");
                $(m_week_st).val(value.time_st).prop("selected", true);
                $(m_week_fi).val(value.time_fi).prop("selected", true);


            })
        })
    })

    function save_artist(id){
        var data = id+" #artist_form";
        var form_data = decodeURIComponent($(data).serialize());
        form_data += "&mode=put_artist";
        put_artist(form_data);
    }

    $(document).on("click",".week_ch_box",function(){
        var st = "#"+$(this).attr('id')+"_st";
        var fi = "#"+$(this).attr('id')+"_fi";
        if($(st).attr("disabled")){
            $(st).removeAttr("disabled");
        }else{
            $(st).attr("disabled", true);
        }
        if($(fi).attr("disabled")){
            $(fi).removeAttr("disabled");
        }else{
            $(fi).attr("disabled", true);
        }
    })


    // 드래그 이벤트
    $(function(){
        //https://github.com/SortableJS/Sortable


        $('.drag-sort-wrap').each(function(){
            var sortable = Sortable.create($(this)[0] , {
                delay : 0,
                ghostClass: 'guide',
                draggable : '.accordion-cell',
                handle : '.item-info-wrap',
                onStart : function(evt){
                    //드래그 시작
                    console.log('drag start');
                },
                onEnd : function(evt){
                    //드래그 끝
                    console.log('drag end');
                    //evt.to;    // 현재 아이템
                    //evt.from;  // 이전 아이템
                    //evt.oldIndex;  // 이전 인덱스값
                    //evt.newIndex;  // 새로운 인덱스값
                },
                onUpdate : function(evt){
                    console.log('update');
                },
                onUpdate : function(evt){
                    console.log('onChange');
                    var name = new Array();


                    $('.accordion-cell').each(function(){
                        name.push($(this).data('name'));
                    });
                    artist_ord_change(artist_id, name);
                },
                onRemove: function (/**Event*/evt) {
                    console.log('remove');
                }

            });
        });
    });
</script>
</body>
</html>