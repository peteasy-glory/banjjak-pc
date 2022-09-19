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


$search = ($_POST['search'] && $_POST['search'] !== "") ? $_POST['search']:"";




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
								<h3 class="card-header-title">빠른 조회하기</h3>
							</div>
							<div class="card-body">
								<div class="card-body-inner">
									<div class="basic-data-group">
										<div class="basic-single-data">
											<div class="form-btns">
												<input type="text" id="search" placeholder="전화번호 또는 펫이름">
												<button type="button" id="search_btn" class="btn-data-send btn-data-search" onclick="document.getElementById('search').value === '' ? pop.open('firstRequestMsg1','전화번호나 펫이름을 입력해주세요.'):search_fam(document.getElementById('search').value,artist_id)"><span class="icon icon-size-24 icon-page-search">검색</span></button>
											</div>
										</div>
									</div>
									<div class="basic-data-group vsmall">
										<div class="wide-tab">
											<div class="wide-tab-inner">
												<!-- 활성화시 actived클래스 추가 -->
												<div class="tab-cell actived"><a href="#" class="btn-tab-item">미용</a></div>
												<div class="tab-cell"><a href="#" class="btn-tab-item" onclick="pop.open('firstRequestMsg1','준비 중 입니다.');">호텔</a></div>
												<div class="tab-cell"><a href="#" class="btn-tab-item" onclick="pop.open('firstRequestMsg1','준비 중 입니다.');">유치원</a></div>
											</div>
										</div>
									</div>
									<div class="basic-data-group vvsmall3">
                                        <div class="loading-container" id="customer_inquiry_loading" style="height:300px;">
                                            <div class="mexican-wave"></div>
                                        </div>
										<!-- 검색결과 있을 때 -->
										<div class="customer-card-list" id="search_phone_data">
											<div class="grid-layout margin-8-12">
												<div class="grid-layout-inner" id="search_phone_inner">

												</div>
											</div>
										</div>
										<!-- //검색결과 있을 때 -->
										<!-- 검색결과 없을 때 -->
										<div style="display:block;" id="search_phone_none_data">
											<div class="common-none-data">
												<div class="none-inner">
													<div class="item-info">검색 결과가 없습니다.</span></div>
												</div>
											</div>
										</div>
										<!-- //검색결과 없을 때 -->
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
        get_navi(artist_id);
        gnb_init();
        set_image('front_image');
        if('<?=$search?>' !== ''){
            search_fam('<?=$search?>',artist_id);
        }
        ////prepend_data('consult_count nickname');
        //search_fam('<?//=$search?>//',artist_id);
        input_enter('search','search_btn');
        gnb_actived('gnb_customer_wrap','gnb_inquire')
        localStorage.removeItem('noshow_cnt');
        localStorage.removeItem('customer_select');
        localStorage.removeItem('sub_cellphone');


    })



</script>
</body>
</html>
