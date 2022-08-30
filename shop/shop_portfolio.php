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
				<div class="basic-data-group">
					<div class="data-row">
						<div class="data-col-middle">
							<div class="basic-data-card">
								<div class="card-header">
									<h3 class="card-header-title">포트폴리오 관리</h3>
								</div>
								<div class="card-body">
									<div class="card-body-inner">
										<div class="master-portfolio-list">
											<ul id="sortable" class="list-inner img_wrap" >
												<li class="list-cell filtered" onclick="MemofocusNcursor();">
													<div class="btn-gate-picture-register">
														<span><em>이미지 추가</em></span>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>			
						</div>
                        <div style="display:block;position:absolute;top:-50px"><input type="file" accept="image/*" name=imgupfile id=addimgfile></div>
						<div class="data-col-right">
							<div class="basic-data-card page-preview-wrap">
								<iframe src="https://customer.banjjakpet.com/reserve_view_shop?type=beauty&artist_id=<?=$artist_id?>" class="page-preview-view"></iframe>
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
<script src="../static/js/shop.js"></script>
<script src="../static/js/Sortable.min.js"></script>
<script>

    let artist_id = "<?=$artist_id?>";
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        get_portfolio(artist_id);
        console.log(shop_array);

        var html = '';
        $.each(shop_array[0], function(i, v){
            var img_path = img_link_change(v.image);
            html += `
                <li class="list-cell">
                    <div class="master-portfolio-item">
                        <div class="item-thumb"><img src="${img_path}" alt=""></div>
                        <div class="item-info">
                            <div class="item-number">${v.sort_number}</div>
                            <button type="button" class="btn-item-hand"></button>
                        </div>
                        <button type="button" class="btn-data-del" data-idx=${v.idx}>데이타삭제</button>
                    </div>
                </li>
            `;
        })
        $(".img_wrap").append(html);
    })

    // 이미지 추가
    $(document).on("change", "#addimgfile", function(e){
        var ext = $('#addimgfile').val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['png', 'jpg', 'jpeg']) == -1) {
            alert('gif,png,jpg,jpeg 파일만 업로드 할수 있습니다.');
            return;
        }

        var filename = $("input[name=imgupfile]")[0].files[0];
        console.log($("input[name=imgupfile]")[0]);
        var type = ($("input[name=imgupfile]")[0].files[0].type).split('/')[1];
        //console.log(type);
        var formData = new FormData();
        formData.append("mode", "post_shop_gallery");
        formData.append("login_id", artist_id);
        formData.append("mime", type);
        formData.append("image", $("input[name=imgupfile]")[0].files[0]);
        console.log(filename);

        $.ajax({
            url: '/data/pc_ajax.php',
            enctype: 'multipart/form-data',
            data: formData,
            type: 'POST',
            processData: false,
            contentType: false,
            success: function(data) {

                if (/(MSIE|Trident)/.test(navigator.userAgent)) {
                    // ie 일때 input[type=file] init.
                    $("#addimgfile").replaceWith($("#addimgfile").clone(true));
                } else {
                    // other browser 일때 input[type=file] init.
                    $("#addimgfile").val("");
                }
                //console.log(data);
                pop.open('reloadPop', '완료되었습니다.');

            },
            error: function(xhr, status, error) {
                alert(error + "에러발생");
            }
        });
    });

    $(function(){
        /*
        $( "#sortable" ).sortable({
            placeholder: "ui-state-highlight",
            cancel:''
        });
        $( "#sortable" ).disableSelection();
        */

        //https://github.com/SortableJS/Sortable

        var el = document.getElementById('sortable');
        var sortable = Sortable.create(el , {
            handle : '.btn-item-hand',
            delay : 0,
            ghostClass: 'guide',
            dataIdAttr:'data-id',
            filter: '.filtered',
            onMove: function(evt) {
                return evt.related.className.indexOf('filtered') === -1; //and this
              },
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

        $(document).on('click' , '.btn-data-del' , function(){
            //$(this).parents('.list-cell').remove();
            var idx = parseInt($(this).data("idx"));
            console.log(typeof idx)
            del_gallery(idx);
        });

    });
</script>
</body>
</html>