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
								<h3 class="card-header-title">미용별 소요시간 설정</h3>
							</div>
							<form id="workTimeForm" class="card-body">
                                <input type="hidden" name="partner_id" value="<?=$artist_id?>">
								<div class="card-body-inner">
									<div class="product-management">
										<div class="read-table">
											<div class="read-table-unit top">(단위:분)</div>
											<table class="beauty_time_wrap">
											</table>
										</div>
									</div>
								</div>
							</form>
							<div class="card-footer">
								<!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
								<a href="javascript:open_pop();" class="btn-page-bottom">저장하기</a>
							</div>
						</div>			
					</div>
				</div>
			</div>
			<!-- //view -->
		</section>
		<!-- //contents -->
        <article id="saveWorkTime" class="layer-pop-wrap">
            <div class="layer-pop-parent">
                <div class="layer-pop-children">
                    <div class="pop-data alert-pop-data">
                        <div class="pop-body">
                            <div class="msg-txt">저장하시겠습니까?</div>
                        </div>
                        <div class="pop-footer">
                            <button type="button" class="btn btn-confirm" onclick="save_worktime();">저장</button>
                            <button type="button" class="btn btn-cancel" onclick="pop.close();">취소</button>
                        </div>
                    </div>

                </div>
            </div>
        </article>
    </section>
    <!-- //container -->
</div>
<!-- //wrap -->
<script src="../static/js/Sortable.min.js"></script>
<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/setting.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        gnb_actived('gnb_detail_wrap', 'gnb_merchandise');
        get_beauty_product(artist_id);
        console.log(setting_array);

        // 미용별 소요시간
        var col_html = '<colgroup>';
        var thead_html = '<thead><tr>';
        var tbody_html = '<tbody><tr>';
        var tbody_fi_html = '';
        var add_service = ['무게'];
        var idx = 0;
        $.each(setting_array[0].worktime, function(i,v){
            idx ++;
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
                default : txt = i; add_service.push(txt);
            }
            col_html += '<col style="width:auto;">';
            thead_html += `<th>${txt}</th>`;
            tbody_html += `
                <td class="no-padding">
                    <div class="form-table-select">
                        <select name="work_time${idx}">`;
            for(var j=30;j<=240;j=j+30){
                var selected = (v.time == j)? 'selected':'';
                tbody_html += `<option value="${j}" ${selected}>${j}분</option>`;
            }
            tbody_html +=`
                        </select>
                    </div>
                </td>
            `;
        })
        col_html += '</colgroup>';
        thead_html += '</tr></thead>';
        tbody_html += '</tr></tbody>';
        $(".beauty_time_wrap").html(col_html+thead_html+tbody_html);
    })

    function open_pop(){
        pop.open('saveWorkTime');
    }

    function save_worktime(){
        var postData = decodeURIComponent($("#workTimeForm").serialize());
        postData += '&mode=put_work_time';
        //console.log(postData);
        put_work_time(postData);
    }
</script>
</body>
</html>