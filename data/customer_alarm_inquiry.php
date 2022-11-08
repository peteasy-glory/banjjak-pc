<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");
$artist_flag = (isset($_SESSION['artist_flag'])) ? $_SESSION['artist_flag'] : "";


if ($artist_flag === true) {
    $artist_id = (isset($_SESSION['shop_user_id'])) ? $_SESSION['shop_user_id'] : "";
    $user_id = (isset($_SESSION['shop_user_id'])) ? $_SESSION['shop_user_id'] : "";
    $user_name = (isset($_SESSION['shop_user_nickname'])) ? $_SESSION['shop_user_nickname'] : "";
} else {
    $artist_id = (isset($_SESSION['gobeauty_user_id'])) ? $_SESSION['gobeauty_user_id'] : "";
    $user_id = (isset($_SESSION['gobeauty_user_id'])) ? $_SESSION['gobeauty_user_id'] : "";
    $user_name = (isset($_SESSION['gobeauty_user_nickname'])) ? $_SESSION['gobeauty_user_nickname'] : "";
}


$startDate = ($_POST['startDate'] && $_POST['startDate'] != "")? $_POST['startDate'] : date('Y-m-d', strtotime(DATE('Y-m-d')."-1 days")); // 달력검색 시작 날짜
$endDate = ($_POST['endDate'] && $_POST['endDate'] != "")? $_POST['endDate'] : DATE('Y-m-d'); // 달력검색 끝 날짜

$startYear = date("Y", strtotime($startDate)); // 시작 년(알림톡 테이블명 땜시)
$endYear = date("Y", strtotime($endDate)); // 끝 년
$startMonth = date("m", strtotime($startDate)); // 시작 월(알림톡 테이블명 땜시)
$endMonth = date("m", strtotime($endDate)); // 끝 월
$startYearMonth = date("Ym", strtotime($startDate)); // 시작 년월(알림톡 테이블명 땜시)
$endYearMonth = date("Ym", strtotime($endDate)); // 끝 월

// 테이블명 조회 계산
$count = 0;
if($startYear == $endYear){ // 검색 시작과 끝 년도가 같을때
    $count = $endMonth - $startMonth;
}else{
    $count_year = ($endYear - $startYear - 1)*12; // 2년 이상 차이가 나면 12개월을 더한다.
    $count = 12 - $startMonth + $endMonth + $count_year;
}


$cellphone = $_POST['cellphone'];
if(!$cellphone){

}

$searchList = null;
$data = array();

$return_data = array("code" => "999999", "data" => "잘못된 접근입니다.");
// 결제액 합계
if (($startDate != "" && $startDate != null) && ($endDate != "" && $endDate != null)) {
    $plus_query = "";
    if($startYearMonth != $endYearMonth){
        for($i=0; $i<=$count; $i++){
            $test = str_replace('-', '', $endYearMonth);
            $plus_query .= "
				UNION
				SELECT a.*, SUBSTRING_INDEX(SUBSTRING_INDEX(kko_btn_info, '=', '-1' ), '\"', '1') AS payment_log FROM ita_talk_log_".$test." a
				JOIN tb_payment_log b ON b.artist_id = '".$artist_id."'
				WHERE a.recipient_num = '".$cellphone."' AND b.payment_log_seq = SUBSTRING_INDEX(SUBSTRING_INDEX(a.kko_btn_info, '=', '-1' ), '\"', '1')
				AND template_code IN ('1000004530_14040', '1000004530_14041', '1000004530_14042', '1000004530_14042_1', '1000004530_14043', '1000004530_14044', '1000004530_20001', '1000004530_20002', '1000004530_20003', '1000004530_20018')
				AND DATE_FORMAT(date_client_req, '%Y-%m-%d')
					BETWEEN DATE_FORMAT('".$startDate."', '%Y-%m-%d')
					AND DATE_FORMAT('".$endDate."', '%Y-%m-%d')
			";
            $endYearMonth = strtotime("-1 months", strtotime($endYearMonth));
            $endYearMonth = date("Y-m", $endYearMonth);
        }

    }

    // 상세내역
    $query = "
		SELECT a.*, SUBSTRING_INDEX(SUBSTRING_INDEX(kko_btn_info, '=', '-1' ), '\"', '1') AS payment_log FROM ita_talk_log_".$startYearMonth." a
		JOIN tb_payment_log b ON b.artist_id ='".$artist_id."'
		WHERE a.recipient_num = '".$cellphone."' AND b.payment_log_seq = SUBSTRING_INDEX(SUBSTRING_INDEX(a.kko_btn_info, '=', '-1' ), '\"', '1')
		AND a.template_code IN ('1000004530_14040', '1000004530_14041', '1000004530_14042', '1000004530_14042_1', '1000004530_14043', '1000004530_14044', '1000004530_20001', '1000004530_20002', '1000004530_20003', '1000004530_20018')
		AND DATE_FORMAT(a.date_client_req, '%Y-%m-%d')
			BETWEEN DATE_FORMAT('".$startDate."', '%Y-%m-%d')
			AND DATE_FORMAT('".$endDate."', '%Y-%m-%d')
		".$plus_query."
		ORDER BY date_client_req
";
    $result = mysqli_query($connection,$query);

    while ($data = mysqli_fetch_array($result)) {
        $searchList[] = $data;
    }

    // (211221)서비스 재시작 이후 불러옴
//	if($startDate > '2021-12-16'||($startDate < '2021-12-17' && $endDate > '2021-12-16')){
//		$query = "
//			SELECT *, SUBSTRING_INDEX(SUBSTRING_INDEX(kko_btn_info, '=', '-1' ), '\"', '1') AS payment_log FROM ita_talk_tran WHERE recipient_num = '".$cellphone."'
//			AND template_code IN ('1000004530_14040', '1000004530_14041', '1000004530_14042', '1000004530_14042_1', '1000004530_14043', '1000004530_14044')
//			AND DATE_FORMAT(date_client_req, '%Y-%m-%d')
//				BETWEEN DATE_FORMAT('".$startDate."', '%Y-%m-%d')
//				AND DATE_FORMAT('".$endDate."', '%Y-%m-%d')
//			ORDER BY date_client_req
//		";
//		$result = mysql_query($query);
//
//		while ($data = mysql_fetch_array($result)) {
//			$searchList[] = $data;
//		}
//	}
    $return_data = array("code"=>"000000","data"=>$searchList);
}
echo json_encode($return_data, JSON_UNESCAPED_UNICODE);
?>