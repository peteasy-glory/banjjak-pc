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
								<h3 class="card-header-title">공지사항</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="basic-board-list">
										<ul class="notice_wrap">
										</ul>
										<!--<div class="board-more"><button type="button" class="btn btn-outline-purple btn-inline btn-basic-wide">더보기 (10/31)</button></div>-->
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
<script src="../static/js/etc.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    $(document).ready(function() {
        var artist_flag = "<?=$artist_flag?>";
        if(artist_flag == 1){
            $("#gnb_home").css("display","none");
            $("#gnb_shop_wrap").css("display","none");
            $("#gnb_detail_wrap").css("display","none");
            $("#gnb_stats_wrap").css("display","none");
        }
        get_navi(artist_id);
        gnb_init();
        gnb_actived('gnb_etc_wrap','gnb_notice');
        get_notice(artist_id);
        console.log(etc_array);

        // 리스트 뿌려주기
        var html = '';
        $.each(etc_array[0], function(i,v){
            var date = v.req_date.substr(0,10);
            var type_txt = (v.type == '1')? "업데이트" : "공지";
            html += `
                <li>
                    <a href="other_notice_view.php?type=${type_txt}&title=${v.title}&date=${date}&img=${v.image}&notice=${v.notice}" class="btn-board-item">
                        <div class="item-cate">${type_txt}</div>
                        <div class="item-info">
                            <div class="item-subject">${v.title}</div>
                            <div class="item-date">${date}</div>
                        </div>
                    </a>
                </li>
            `;
        })
        $(".notice_wrap").html(html);
    })
</script>
</body>
</html>