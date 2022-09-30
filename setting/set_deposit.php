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
                                <h3 class="card-header-title">예약금 설정</h3>
                            </div>
                            <div class="card-body">
                                <div class="card-body-inner">
                                    <div class="set-deposit">
                                        <div class="basic-data-group">
                                            <div class="con-title-group">
                                                <h4 class="con-title">예약금</h4>
                                            </div>
                                            <div class="form-group">
                                                <div class="grid-layout margin-14-17">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-2">
                                                            <div class="form-group-item">
                                                                <div class="form-item-data type-2" style="margin-top:0px; padding-top:10px; display: flex; align-items: center;">
                                                                    <input type="number" placeholder="최소 예약금은 1천원" min="0" id="deposit_input"><label style="margin-left:10px;"></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="basic-data-group">
                                            <div class="con-title-group">
                                                <h4 class="con-title">결제기한 설정</h4>
                                            </div>
                                            <div class="form-group">
                                                <div class="grid-layout margin-14-17">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-2">
                                                            <div class="form-group-item">
                                                                <div class="form-item-data type-2" style="margin-top:0px; padding-top:10px;">
                                                                    <select class="percent" id="deposit_time">

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="basic-data-group">
                                            <div class="con-title-group">
                                                <h4 class="con-title">계좌입력</h4>
                                            </div>
                                            <div class="form-group">
                                                <div class="grid-layout margin-14-17">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-2">
                                                            <div class="form-group-item">
                                                                <div class="form-item-data type-2" style="margin-top:0px; padding-top:10px; display: flex; align-items: center">
                                                                    <label style="margin-right:20px; min-width:80px;">은행명</label>
                                                                    <select class="percent" id="deposit_bank">

                                                                    </select>


                                                                </div>
                                                                <div class="form-item-data type-2" style="margin-top:0px; padding-top:10px; display: flex; align-items: center">

                                                                    <label style="margin-right:20px; min-width:80px">계좌번호</label>
                                                                    <input type="text" placeholder='" - " 포함'  type="number" min="0" id="deposit_bank_account">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="basic-data-group">
                                            <div class="con-title-group">
                                                <h4 class="con-title">예약금 결제관리</h4>
                                            </div>
                                            <div class="form-group">
                                                <div class="grid-layout margin-14-17">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-2">
                                                            <div class="form-group-item">
                                                                <div class="form-item-data type-2" style="margin-top:0px; padding-top:10px; display: flex; align-items: center; justify-content: space-between">

                                                                    <span>수동</span><label for="switch-toggle" class="form-switch-toggle"><input type="checkbox" checked onclick="return false;"><span class="bar"></span></label>
                                                                </div>
                                                                <div class="form-item-data type-2" style="margin-top:0px; padding-top:10px; display: flex; align-items: center; justify-content: space-between">

                                                                    <span>자동</span><label for="switch-toggle" class="form-switch-toggle"><input type="checkbox" onclick="event.preventDefault(); document.getElementById('msg1_txt').innerText = '열심히 오픈 준비중입니다. \n 조금만 기다려 주세요.'; pop.open('reserveAcceptMsg1') "><span class="bar"></span></label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
                                <a href="#" class="btn-page-bottom deposit_btn" onclick="deposit_save(artist_id)">저장하기</a>
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
<article id="reserveAcceptMsg1" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt" id="msg1_txt"></div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="pop.close(); pop.close('reserveCalendarPop11')">확인</button>
                </div>
            </div>
        </div>
    </div>
</article>

<article id="reserveAcceptMsg2" class="layer-pop-wrap">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data alert-pop-data">
                <div class="pop-body">
                    <div class="msg-txt" id="msg2_txt"></div>
                </div>
                <div class="pop-footer">
                    <button type="button" class="btn btn-confirm" onclick="location.reload()">확인</button>
                </div>
            </div>
        </div>
    </div>
</article>
<!-- //wrap -->
<script src="/static/js/common.js"></script>
<script src="/static/js/booking.js"></script>
<script src="/static/js/dev_common.js"></script>
<script src="/static/js/setting.js"></script>
<script>
    let artist_id = "<?=$artist_id?>";
    $(document).ready(function() {
        get_navi(artist_id);
        gnb_init();
        gnb_actived('gnb_detail_wrap','gnb_deposit');
        setInputFilter(document.getElementById("deposit_input"), function(value) {
            return /^\d*\.?\d*$/.test(value);
        })
        for(let i=30; i<=1440; i+=30){
            document.getElementById('deposit_time').innerHTML += `<option value=${i}>${minutes_to_hour(i)} 이내</option>`
        }

        get_deposit(artist_id)


    })




    function minutes_to_hour(minutes){

        let hours = Math.floor(minutes/60);
        let min = minutes%60;


        return `${hours !== 0 ? hours : ''}${hours !== 0 ? '시간 ':''}${min !== 0 ? min : ''}${min !== 0 ? '분' :''}`

    }

    let banks = [
        {
            code : '003',
            name : '기업은행'
        },{
            code : '004',
            name : '국민은행'
        },{
            code : '011',
            name : '농협중앙회회'
       },{
            code : '012',
            name : '단위농협'
        },{
            code : '020',
            name : '우리은행'
        },{
            code : '031',
            name : '대구은행'
        },{
            code : '005',
            name : '외환은행'
        },{
            code : '023',
            name : 'SC제일은행'
        },{
            code : '032',
            name : '부산은행'
        },{
            code : '045',
            name : '새마을금고'
        },{
            code : '027',
            name : '한국씨티은행'
        },{
            code : '034',
            name : '광주은행'
        },{
            code : '039',
            name : '경남은행'
        },{
            code : '007',
            name : '수협'
        },{
            code : '048',
            name : '신협'
        },{
            code : '037',
            name : '전북은행'
        },{
            code : '035',
            name : '제주은행'
        },{
            code : '064',
            name : '산림조합'
        },{
            code : '071',
            name : '우체국'
        },{
            code : '081',
            name : '하나은행'
        },{
            code : '088',
            name : '신한은행'
        },{
            code : '090',
            name : '카카오뱅크'
        },{
            code : '209',
            name : '동양종금증권'
        },{
            code : '243',
            name : '한국투자증권'
        },{
            code : '240',
            name : '삼성증권'
        },{
            code : '230',
            name : '미래에셋'
        },{
            code : '247',
            name : '우리투자증권'
        },{
            code : '218',
            name : '현대증권'
        },{
            code : '266',
            name : 'SK증권'
        },{
            code : '278',
            name : '신한금융투자'
        },{
            code : '262',
            name : '하이증권'
        },{
            code : '263',
            name : 'HMC증권'
        },{
            code : '267',
            name : '대신증권'
        },{
            code : '270',
            name : '하나대투증권'
        },{
            code : '279',
            name : '동부증권'
        },{
            code : '280',
            name : '유진증권'
        },{
            code : '287',
            name : '메리츠증권'
        },{
            code : '291',
            name : '신영증권'
        },{
            code : '238',
            name : '대우증권'
        }

    ]



    banks.forEach(function(el){

        document.getElementById('deposit_bank').innerHTML += `<option value="${el.name}" data-code="${el.code}">${el.name}</option>`
    })
</script>
</body>
</html>