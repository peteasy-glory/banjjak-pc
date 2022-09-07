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
                        <div class="basic-data-card reserve-calendar-view">
                            <div class="card-header">
                                <div class="reserve-calendar-top page-title">

                                    예약 승인 대기

                                </div>
                            </div>
                            <div class="card-body">
                                <div class="reserve-wating">
                                    <!-- 대기 시작 -->
                                    <?php
                                    $cnt = 0;
                                    $date_same = array();
                                    $artist_same = array();
                                    $que = "
                SELECT a.idx, b.*, c.name, c.pet_type, DATE_FORMAT(CONCAT(b.year,'-',b.month,'-',b.day),'%Y-%m-%d') reg_date FROM tb_grade_reserve_approval_mgr a 
                LEFT JOIN tb_payment_log b ON a.payment_log_seq = b.payment_log_seq 
                LEFT JOIN tb_mypet c ON b.pet_seq = c.pet_seq 
                WHERE is_approve = '0'
                AND b.artist_id = '".$artist_id."'
                ORDER BY DATE_FORMAT(CONCAT(b.year,'-',b.month,'-',b.day),'%Y-%m-%d')
            ";
                                    //echo $que;
                                    $arr = sql_fetch_array($que);
                                    if(count($arr)>0){
                                        foreach($arr as $rs){
                                            $week = array('일','월','화','수','목','금','토');
                                            $beauty = explode("|",$rs['product']);

                                            ?>
                                            <div class="reserve-wating-group">
                                                <?php
                                                if($cnt == 0){
                                                    $date_same[0] = date('ymd',strtotime($rs['reg_date']));
                                                    $date = date('m.d',strtotime($rs['reg_date']));
                                                    echo '<div class="reserve-wating-date">'.$date.'('.$week[date('w',strtotime($rs['reg_date']))].')</div>';
                                                } else if($cnt > 0){
                                                    if($date_same[$cnt-1] != date('ymd',strtotime($rs['reg_date']))) {
                                                        $date = date('m.d', strtotime($rs['reg_date']));
                                                        echo '<div class="reserve-wating-date">'.$date.'('.$week[date('w',strtotime($rs['reg_date']))].')</div>';
                                                    }
                                                    $date_same[$cnt] = date('ymd',strtotime($rs['reg_date']));
                                                }
                                                ?>
                                                <div class="reserve-wating-list">
                                                    <div class="reserve-calendar-list-group">
                                                        <?php
                                                        if($cnt == 0){
                                                            $artist_same[0] = $rs['worker'];
                                                            $worker = ($rs['worker']!=$rs['artist_id'])? $rs['worker'] : "실장";
                                                            echo '<div class="con-title-group"><h5 class="con-title">'.$worker.'</h5></div>';
                                                        } else if($cnt > 0){
                                                            if($artist_same[$cnt-1] != $rs['worker'] || $date_same[$cnt-1] != date('ymd',strtotime($rs['reg_date']))) {
                                                                $worker = ($rs['worker']!=$rs['artist_id'])? $rs['worker'] : "실장";
                                                                echo '<div class="con-title-group"><h5 class="con-title">'.$worker.'</h5></div>';
                                                            }
                                                            $artist_same[$cnt] = $rs['worker'];
                                                        }
                                                        ?>

                                                        <div class="reserve-calendar-list-data">

                                                            <div class="reserve-calendar-list-items gray" onclick="location.href='/booking/reserve_beauty_day.php';localStorage.setItem('day_select',`<?=$rs['year']?>.<?=strlen($rs['month']) === 1 ? '0'.$rs['month'] : $rs['month']?>.<?=strlen($rs['day']) === 1 ? '0'.$rs['day'] : $rs['day']?>`); waiting_check()">
                                                                <div class="item-time">
                                                                    <div class="item-time-start"><em><?php echo ($rs['hour']<12)?'오전':'오후';?></em><strong><?php echo $rs['hour'];?>:<?php echo sprintf('%02d',$rs['minute']);?></strong></div>
                                                                    <div class="item-time-unit">~</div>
                                                                    <div class="item-time-end"><em><?php echo ($rs['to_hour']<12)?'오전':'오후';?></em><strong><?php echo $rs['to_hour'];?>:<?php echo sprintf('%02d',$rs['to_minute']);?></strong></div>
                                                                </div>
                                                                <div class="item-info">
                                                                    <div class="item-name">
                                                                        <div class="item-name-txt"><strong class="font-color-red">승인대기</strong></div>
                                                                        <div class="item-name-division">/</div>
                                                                        <div class="item-name-txt"><?php echo $beauty[1].'/'.$beauty[3].'/'.$beauty[4];?></div>
                                                                    </div>
                                                                    <div class="item-options">
                                                                        <div class="item-options-txt"><?php echo $rs['name'];?></div>
                                                                        <div class="item-options-division">/</div>
                                                                        <div class="item-options-txt"><?php echo $rs['pet_type'];?></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $cnt++; }} ?>
                                    <!-- 대기 끝 -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //view -->
            <button type="button" class="btn-broswer-mode" onclick="darkMode();">
                <span class="off"><span class="icons"></span>다크 모드 보기</span>
                <span class="on"><span class="icons"></span>라이트 모드 보기</span>
            </button>
        </section>
        <!-- //contents -->
    </section>
    <!-- //container -->
</div>


<section id="container">
    <!-- page-body -->
    <div class="page-body">

    </div>
    <!-- //page-body -->
</section>

<script src="../static/js/common.js"></script>
<script src="../static/js/dev_common.js"></script>
<script src="../static/js/booking.js"></script>

<script>


    let artist_id = "<?=$artist_id?>";

    $(document).ready(function(){


        get_navi(artist_id);
        gnb_init();
        set_image('front_image');




        gnb_actived('gnb_reserve_wrap','gnb_beauty');


    })

    function waiting_check(){

        sessionStorage.setItem('waiting','check');

    }
</script>




</body>
</html>