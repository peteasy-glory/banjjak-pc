<?php
include($_SERVER['DOCUMENT_ROOT']."/include/global.php");

$cellphone = $_POST['cellphone'];
$date = $_POST['date'];
$payment_log_seq = ($_POST['seq'] != '')? " AND SUBSTRING_INDEX(content, '=', '-1' ) = '".$_POST['seq']."' " : "";
$return_data = array("code" => "999999", "data" => "잘못된 접근입니다.");

$mmt_sql = "SELECT * FROM em_mmt_log_".date("Ym", strtotime($date))." WHERE recipient_num = '".$cellphone."'
            ".$payment_log_seq."
            AND DATE_FORMAT(date_client_req, '%Y-%m-%d') = DATE_FORMAT('".$date."', '%Y-%m-%d' ) LIMIT 1
                                            ";
$result_mmt_sql = mysqli_query($connection,$mmt_sql);
$row = mysqli_fetch_assoc($result_mmt_sql);
if($row["mt_report_code_ib"] == "1000"){
    $return_data = array("code"=>"000000","data"=>"문자대체발송");
}else{
    $return_data = array("code"=>"000000","data"=>"발송실패");
}
echo json_encode($return_data, JSON_UNESCAPED_UNICODE);
?>