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
<!--  첫이용 상담 안내 -->
<article id="reserveAdviceMsg1" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data middle">
                <div class="pop-body">
                    <div class="msg-title"> 첫이용 상담 안내</div>
                    <div class="dot-text-list text-align-left purple">
                        <div class="list-cell">미용이 가능한 강아지로 판단되시면 “상담완료”를 꼭 눌러주세요.</div>
                        <div class="list-cell">아래 정보로 미용 가능 판단이 부족하시면 통화나 문자아이콘을 눌러 상담해 주세요</div>
                        <div class="list-cell"> 부득이한 경우 “예약거부”를 누르시면 됩니다. 이때 견주에게는 거부로 날아가지 않으니 안심하셔도 됩니다. 다만 이 고객의 재방문 가능성은 매우 낮아집니다.</div>
                        <div class="list-cell">자동취소나 거부했던 지난 이용상담도 원하시면 언제든 “상담완료”처리 하실수 있습니다.</div>
                    </div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">닫기</button>
                </div>
            </div>
        </div>
    </div>
</article>
<!-- //첫이용 상담 안내 -->
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
								<h3 class="card-header-title">이용 상담 관리</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="reserve-advice-wrap" id="reserve_advice_wrap">
										<div class="wide-tab">
											<div class="wide-tab-inner" id="wide-tab-inner">
												<!-- 활성화시 actived클래스 추가 -->
												<div class="tab-cell actived"><a href="#" class="btn-tab-item" id="consulting_hold_tab" onclick="consulting_toggle(true);">상담대기</a></div>
												<div class="tab-cell"><a href="#" class="btn-tab-item" id="consulting_history_tab" onclick="consulting_toggle(false);">처리내역</a></div>
											</div>
										</div>
										<div class="basic-data-group vmiddle" id="consulting_hold_desc">
											<div class="reserve-advice-list-info">*12시간 이내에 상담완료해 주세요. (12시간이 지나면 자동취소)<br>*예약거부를 눌러도 견주에게는 거부로 날아가지 않으니 안심하셔도 됩니다.<br>*자동취소됐거나 거부했던 지난 이용 상담도 원하시면 언제든 통화나 상담 완료하실 수 있습니다.</div>
										</div>
                                        <div class="basic-data-group vmiddle" id="consulting_history_desc" style="display: none;">
                                            <div class="reserve-advice-list-info">*자동취소됐거나 거부했던 지난 이용 상담도 원하시면 언제든 통화나 상담 완료하실 수 있습니다.</div>
                                        </div>
										<!-- 내용 있을 때 -->
										<div class="basic-data-group vmiddle">		
											<div class="grid-layout margin-8-12">
												<div class="grid-layout-inner" id="consulting_list">

												</div>
                                                <div class="grid-layout-inner" id="consulting_list_2" style="display: none;">


                                                </div>

											</div>											
										</div>
										<!-- //내용 있을 때 -->
										<!-- 내용 없을 때 -->
										<div class="common-none-data" id="consulting_hold_list_none_data" style="display:none;">
											<div class="none-inner">
												<div class="item-visual"><img src="../static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
												<div class="item-info">등록된 상담내역이 없습니다.</div>
											</div>
										</div>
										<!-- //내용 없을 때 -->
									</div>
								</div>
							</div>
						</div>			
					</div>
					<div class="data-col-right" id="consulting_data" style="opacity: 0;">
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
<article id="adviceCustomer1" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt">이 고객이 예약하는 것을 거부합니다.</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="approve_consult(false)">확인</button>
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">취소</button>
                </div>
            </div>
        </div>
    </div>
</article>
<article id="adviceCustomer2" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt">이 고객이 예약하는 것을 허용하고 상담을 완료합니다.</div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="approve_consult(true)">확인</button>
                    <button type="button" class="btn btn-confirm" onclick="pop.close();">취소</button>
                </div>
            </div>
        </div>
    </div>
</article>
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/booking.js"></script>

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
        consulting_hold_list(artist_id);
        wide_tab();
        Array.from(document.getElementsByClassName('actived consulting-select')).forEach(function (el){
            el.click();
            el.click();
        })
        gnb_actived('gnb_reserve_wrap','gnb_consulting')


    })


    window.addEventListener('beforeunload', function (){

        sessionStorage.removeItem('consulting_select')
    });


</script>
</body>
</html>