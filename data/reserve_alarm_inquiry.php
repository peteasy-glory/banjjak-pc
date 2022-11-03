<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");

$nowDate = DATE('Y-m'); // 현재 년월
$startDate =  DATE('Y-m-d'); // 달력검색 시작 날짜



$cellphone = $_POST["cellphone"];
$payment_log_seq = $_POST["payment_log_seq"];
$pet_name = $_POST["pet_name"];

$payment_sql = "
	SELECT * FROM tb_payment_log WHERE payment_log_seq = '".$payment_log_seq."'
";
$payment_result = mysqli_query($connection,$payment_sql);
$payment_row = mysqli_fetch_array($payment_result);

$startYearMonth = date("Y-m", strtotime($payment_row["year"]."-".$payment_row["month"]));
$after_error = date("Y-m-d", strtotime($payment_row["year"]."-".$payment_row["month"]."-".$payment_row["day"])); // 서비스 재시작 이후 tran에 샇여있는 데이터
if($startYearMonth > $nowDate){ // 예약날이 현재보다 미래일 경우
    $startYearMonth = $nowDate; // 조회 시작 년월을 이번달부터로 시작 (미래의 월 알림톡 테이블은 생성되지 않았기 때문에 오류발생)
}
$searchList = null;
$data = array();

$return_data = array("code" => "999999", "data" => "잘못된 접근입니다.");

// 결제액 합계
if ($payment_log_seq != "" && $cellphone != "") {
    $findYearMonth = $startYearMonth;
    $cnt = 0; // 알림톡 테이블 조회 갯수
    if($payment_row["reserve_yn"] == "Y"){ // 미용예약알림을 보냈을 경우
        for($cnt; $cnt<=23; $cnt++){ // 일단 50개로 잡음, 예약알림 발견할 경우 break 할꺼임
            $test = str_replace('-', '', $findYearMonth);
            if($test == "202106"){
                $cnt = $cnt - 1;
                break;
            }
            $query="
				SELECT date_client_req, template_code, report_code, content, SUBSTRING_INDEX(SUBSTRING_INDEX(kko_btn_info, '=', '-1' ), '\"', '1') AS payment_log FROM ita_talk_log_".$test." 
				WHERE template_code in ('1000004530_14040', '1000004530_20001') 
				AND SUBSTRING_INDEX(SUBSTRING_INDEX(kko_btn_info, '=', '-1' ), '\"', '1') = '".$payment_log_seq."'
			";
            $result = mysqli_query($connection,$query);
            $result_cnt = mysqli_num_rows($result);

            if($result_cnt > 0){ // 미용에약알림 이전에는 알림이 갈 수 없기 때문에 break
                break;
            }
            $findYearMonth = strtotime("-1 months", strtotime($findYearMonth));
            $findYearMonth = date("Y-m", $findYearMonth);
        }
    }else{ // 전날알림 허용했건 안했건 일단 6개월 조회해보자
        $cnt = 4;
    }
    // 조회 시작
    $plus_query = "";

    // 미용종료알림톡 가져오기
    if($payment_row["notice_yn"] == "Y"){
        $notice = $startYearMonth;
        for($i=0; $i<=$cnt; $i++){
            $str_notice = str_replace('-', '', $notice);
            $plus_query .= "
				UNION ALL
				SELECT date_client_req, template_code, report_code, content, SUBSTRING_INDEX(SUBSTRING_INDEX(kko_btn_info, '=', '-1' ), '\"', '1') AS payment_log FROM ita_talk_log_".$str_notice." WHERE recipient_num = '".$cellphone."' 
				AND template_code IN ('1000004530_14042', '1000004530_14042_1', '1000004530_20004', '1000004530_20005')	
				AND SUBSTRING_INDEX(SUBSTRING_INDEX(content, ' ', 5), ' ', -1) = '".$pet_name."'
			";
            $notice = strtotime("-1 months", strtotime($notice));
            $notice = date("Y-m", $notice);
        }
    }

    // 이전
    if($startYearMonth){
        $union = $startYearMonth;
        for($i=0; $i<=$cnt; $i++){
            $union = strtotime("-1 months", strtotime($union));
            $union = date("Y-m", $union);
            $str_union = str_replace('-', '', $union);
            $plus_query .= "
				UNION ALL
				SELECT date_client_req, template_code, report_code, content, SUBSTRING_INDEX(SUBSTRING_INDEX(kko_btn_info, '=', '-1' ), '\"', '1') AS payment_log FROM ita_talk_log_".$str_union." WHERE recipient_num = '".$cellphone."' 
				AND template_code IN ('1000004530_14040', '1000004530_14041', '1000004530_14042', '1000004530_14042_1', '1000004530_14043', '1000004530_14044', '1000004530_20001', '1000004530_20002', '1000004530_20003', '1000004530_20018','1000004530_20003_1','1000004530_20017','1000004530_20016_1','1000004530_20016_2')
				AND SUBSTRING_INDEX(SUBSTRING_INDEX(kko_btn_info, '=', '-1' ), '\"', '1') = '".$payment_log_seq."'
			";  
        }
    }
    // 상세내역
    $startYearMonth = str_replace('-', '', $startYearMonth);
    $query = "
		SELECT date_client_req, template_code, report_code, content, SUBSTRING_INDEX(SUBSTRING_INDEX(kko_btn_info, '=', '-1' ), '\"', '1') AS payment_log FROM ita_talk_log_".$startYearMonth." WHERE recipient_num = '".$cellphone."' 
		AND template_code IN ('1000004530_14040', '1000004530_14041', '1000004530_14042', '1000004530_14042_1', '1000004530_14043', '1000004530_14044', '1000004530_20001', '1000004530_20002', '1000004530_20003', '1000004530_20018','1000004530_20003_1','1000004530_20017','1000004530_20016_1','1000004530_20016_2') 
		AND SUBSTRING_INDEX(SUBSTRING_INDEX(kko_btn_info, '=', '-1' ), '\"', '1') = '".$payment_log_seq."'
		".$plus_query."
		ORDER BY date_client_req
	";
    $result = mysqli_query($connection,$query);
    $reault_cnt = mysqli_num_rows($query);



    $startYearMonth = str_replace('-', '', $startYearMonth);
    $query = "
		SELECT date_client_req, template_code, report_code, content, SUBSTRING_INDEX(SUBSTRING_INDEX(kko_btn_info, '=', '-1' ), '\"', '1') AS payment_log FROM ita_talk_log_".$startYearMonth." WHERE recipient_num = '".$cellphone."' 
		AND template_code IN ('1000004530_20017','1000004530_20016_1','1000004530_20016_2') 
		".$plus_query."
		ORDER BY date_client_req
	";
    $result = mysqli_query($connection,$query);
    $reault_cnt = mysqli_num_rows($query);

    while ($data = mysqli_fetch_array($result)) {
        $searchList[] = $data;
    }

    // (211216)서비스 재시작 이후 불러옴
//	if($after_error > "2021-12-16"){
//		$query = "
//			SELECT date_client_req, template_code, report_code, content, SUBSTRING_INDEX(SUBSTRING_INDEX(kko_btn_info, '=', '-1' ), '\"', '1') AS payment_log FROM ita_talk_tran WHERE recipient_num = '".$cellphone."'
//			AND template_code IN ('1000004530_14040', '1000004530_14041', '1000004530_14042', '1000004530_14042_1', '1000004530_14043', '1000004530_14044')
//			AND SUBSTRING_INDEX(SUBSTRING_INDEX(kko_btn_info, '=', '-1' ), '\"', '1') = '".$payment_log_seq."'
//			ORDER BY date_client_req
//		";
//		$result = mysql_query($query);
//		$reault_cnt = mysql_num_rows($query);
//
//		while ($data = mysql_fetch_array($result)) {
//			$searchList[] = $data;
//		}
//	}
    $return_data = array("code"=>"000000","data"=>$searchList);
}

echo json_encode($return_data, JSON_UNESCAPED_UNICODE);
?>