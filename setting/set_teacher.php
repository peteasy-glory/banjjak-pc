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
											<button type="button" class="btn btn-outline-purple btn-basic-wide"><strong>미용사 추가</strong></button>
										</div>
										<div class="basic-data-group vvsmall3 text-align-center">
											<div class="con-title-info type-2">미용사 이름을 드래그하여 순서 변경 가능합니다.</div>
										</div>
										<div class="basic-data-group large">
											<ul class="accordion-list card drag-sort-wrap artist_list_wrap">
												<!--
												// 숨김 및 퇴사시 accordion-cell클래스에 hide클래스 추가
												-->
												<li class="accordion-cell">		
													<div class="card-teacher-item">
														<div class="card-teacher-header">
															<div class="item-info-wrap">
																<div class="item-info-inner">
																	<div class="item-name">김반짝</div>
																	<div class="item-info">닉네임 : 크리스티아누 호날두</div>
																</div>
															</div>
															<div class="item-state"><div class="label label-outline-purple round vmiddle">대표미용사</div></div>
															<button type="button" class="btn-accordion-menu"></button>
														</div>
														<div class="accordion-content">								
															<div class="card-teacher-body">
																<div class="btn-basic-action">
																	<div class="grid-layout basic btn-grid-group">
																		<div class="grid-layout-inner justify-content-end">
																			<div class="grid-layout-cell flex-auto"><a href="#" class="btn btn-outline-gray btn-basic-small">수정</a></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>			
													</div>			
												</li>           
												<li class="accordion-cell">		
													<div class="card-teacher-item">
														<div class="card-teacher-header">
															<div class="item-info-wrap">
																<div class="item-info-inner">
																	<div class="item-name">김반짝</div>
																	<div class="item-info">닉네임 : 크리스티아누 호날두</div>
																</div>
															</div>
															<div class="item-state"></div>
															<button type="button" class="btn-accordion-menu"></button>
														</div>
														<div class="accordion-content">								
															<div class="card-teacher-body">
																<div class="schedule-day-list">
																	<div class="schedule-day-item">
																		<div class="item-title"><div class="schedule-day-state">월</div></div>
																		<div class="item-value">오전 09:00 ~ 오후 07:00</div>
																	</div>
																	<div class="schedule-day-item">
																		<div class="item-title"><div class="schedule-day-state">화</div></div>
																		<div class="item-value">오전 09:00 ~ 오후 07:00</div>
																	</div>
																</div>
																<div class="btn-basic-action">
																	<div class="grid-layout basic btn-grid-group">
																		<div class="grid-layout-inner justify-content-end">
																			<div class="grid-layout-cell flex-auto"><a href="#" class="btn btn-outline-gray btn-basic-small">수정</a></div>
																			<div class="grid-layout-cell flex-auto"><a href="#" class="btn btn-outline-gray btn-basic-small">퇴사</a></div>
																			<div class="grid-layout-cell flex-auto"><a href="#" class="btn btn-outline-gray btn-basic-small">숨김</a></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>			
													</div>			
												</li>             
												<li class="accordion-cell hide">		
													<div class="card-teacher-item">
														<div class="card-teacher-header">
															<div class="item-info-wrap">
																<div class="item-info-inner">
																	<div class="item-name">김반짝</div>
																	<div class="item-info">닉네임 : 크리스티아누 호날두</div>
																</div>
															</div>
															<div class="item-state"><div class="txt">(퇴사)</div></div>
															<button type="button" class="btn-accordion-menu"></button>
														</div>
														<div class="accordion-content">								
															<div class="card-teacher-body">
																<div class="schedule-day-list">
																	<div class="schedule-day-item">
																		<div class="item-title"><div class="schedule-day-state">월</div></div>
																		<div class="item-value">오전 09:00 ~ 오후 07:00</div>
																	</div>
																	<div class="schedule-day-item">
																		<div class="item-title"><div class="schedule-day-state">화</div></div>
																		<div class="item-value">오전 09:00 ~ 오후 07:00</div>
																	</div>
																</div>
																<div class="btn-basic-action">
																	<div class="grid-layout basic btn-grid-group">
																		<div class="grid-layout-inner justify-content-end">
																			<div class="grid-layout-cell flex-auto"><a href="#" class="btn btn-outline-gray btn-basic-small">수정</a></div>
																			<div class="grid-layout-cell flex-auto"><a href="#" class="btn btn-outline-gray btn-basic-small">퇴사취소</a></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>			
													</div>			
												</li>           
												<li class="accordion-cell hide">		
													<div class="card-teacher-item">
														<div class="card-teacher-header">
															<div class="item-info-wrap">
																<div class="item-info-inner">
																	<div class="item-name">김반짝</div>
																	<div class="item-info">닉네임 : 크리스티아누 호날두</div>
																</div>
															</div>
															<div class="item-state"><div class="txt">(숨김)</div></div>
															<button type="button" class="btn-accordion-menu"></button>
														</div>
														<div class="accordion-content">								
															<div class="card-teacher-body">
																<div class="schedule-day-list">
																	<div class="schedule-day-item">
																		<div class="item-title"><div class="schedule-day-state">월</div></div>
																		<div class="item-value">오전 09:00 ~ 오후 07:00</div>
																	</div>
																	<div class="schedule-day-item">
																		<div class="item-title"><div class="schedule-day-state">화</div></div>
																		<div class="item-value">오전 09:00 ~ 오후 07:00</div>
																	</div>
																</div>
																<div class="btn-basic-action">
																	<div class="grid-layout basic btn-grid-group">
																		<div class="grid-layout-inner justify-content-end">
																			<div class="grid-layout-cell flex-auto"><a href="#" class="btn btn-outline-gray btn-basic-small">수정</a></div>
																			<div class="grid-layout-cell flex-auto"><a href="#" class="btn btn-outline-gray btn-basic-small">퇴사</a></div>
																			<div class="grid-layout-cell flex-auto"><a href="#" class="btn btn-outline-gray btn-basic-small">숨김해제</a></div>
																		</div>
																	</div>
																</div>
															</div>
														</div>			
													</div>			
												</li>    
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
        get_artist_list(artist_id);
        console.log(setting_array);

        // 미용사 리스트
        var artist_array = setting_array[0];
        var html = '';
        $.each(artist_array, function (i, v){
            var host = (v.name == artist_id)? '<div class="label label-outline-purple round vmiddle">대표미용사</div>' : '';
            html += `
                <li class="accordion-cell">
                    <div class="card-teacher-item">
                        <div class="card-teacher-header">
                            <div class="item-info-wrap">
                                <div class="item-info-inner">
                                    <div class="item-name">${v.name}</div>
                                    <div class="item-info">닉네임 : ${v.nick}</div>
                                </div>
                            </div>
                            <div class="item-state">${host}</div>
                            <button type="button" class="btn-accordion-menu"></button>
                        </div>
                        <div class="accordion-content">
                            <div class="card-teacher-body">
                                <div class="schedule-day-list artist_${i}">
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
                                    <div class="schedule-day-item sun" style="display: none;">
                                        <div class="item-title"><div class="schedule-day-state">일</div></div>
                                        <div class="item-value">오전 09:00 ~ 오후 07:00</div>
                                    </div>
                                </div>
                                <div class="btn-basic-action">
                                    <div class="grid-layout basic btn-grid-group">
                                        <div class="grid-layout-inner justify-content-end">
                                            <div class="grid-layout-cell flex-auto"><a href="#" class="btn btn-outline-gray btn-basic-small">수정</a></div>
                                            <div class="grid-layout-cell flex-auto"><a href="#" class="btn btn-outline-gray btn-basic-small">퇴사</a></div>
											<div class="grid-layout-cell flex-auto"><a href="#" class="btn btn-outline-gray btn-basic-small">숨김</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            `;


        })
        $(".artist_list_wrap").html(html);

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
            })
        })
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