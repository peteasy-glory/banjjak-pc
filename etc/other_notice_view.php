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

$type = (isset($_GET['type']))? $_GET['type'] : "";
$title = (isset($_GET['title']))? $_GET['title'] : "";
$date = (isset($_GET['date']))? $_GET['date'] : "";
$img = (isset($_GET['img']))? img_link_change($_GET['img']) : "";


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
								<div class="card-header-right small">
									<button type="button" class="btn-page-ui btn-page-action" onclick="javascript:history.back();">목록</button>
								</div>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="board-view-top">
										<div class="btn-board-item">
											<div class="item-cate"><?=$type?></div>
											<div class="item-info">
												<div class="item-subject"><?=$title?></div>
												<div class="item-date"><?=$date?></div>
											</div>
										</div>
									</div>
									<div class="board-view-detail">
										<img src="https://image.banjjakpet.com<?=$img?>" alt="">
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
    })
</script>
</body>
</html>