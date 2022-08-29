function join_check(){

    let check_all = document.getElementById('check_all');


    let checks = document.getElementsByClassName('form-check-box');

    let check_all_toggle = false;

    //전체동의
    check_all.addEventListener('click',function(){
        if(check_all_toggle === false){
            Array.from(checks).forEach(function(el,i){
                el.checked = true;
            })
        }else if(check_all_toggle === true){
            Array.from(checks).forEach(function(el,i){
                el.checked = false;
            })
        }
        check_all_toggle = !check_all_toggle;
    })


    let join_btn_next = document.getElementById('join-btn-next');

    //필수동의시 버튼 활성화
    Array.from(checks).forEach(function(el){
        el.addEventListener('click',function (){
            if(document.getElementById('agree1').checked === true
                && document.getElementById('agree2').checked === true
                && document.getElementById('agree6').checked === true){
                join_btn_next.classList.remove('disabled');
                join_btn_next.href = './join_1.php'
            }else{
                if(!join_btn_next.classList.contains('disabled')){
                    join_btn_next.classList.add('disabled');
                    join_btn_next.href = '#';
                }
            }
        })
    })

}

let regExp = /^(01[016789]{1}|02|0[3-9]{1}[0-9]{1})-?[0-9]{3,4}-?[0-9]{4}$/;

// setInputFilter(document.getElementById("check_cellphone_1"), function(value) {
//     return /^-?\d*$/.test(value); });



function checkphonenumber(objstr) {
    if (!objstr) {
        pop.open('firstRequestMsg1', '전화번호를 입력하세요.');
        return false;
    } else if (!regExp.test(objstr)) {
        pop.open('firstRequestMsg1',"잘못된 전화번호입니다. 숫자, - 를 포함한 숫자만 입력하세요. 예) 010-XXXX-XXXX");
        return false;
    }
    return true;
}

function sendsms() {
    let phonestr = document.getElementById("check_cellphone_1").value;
    if (!(checkphonenumber(phonestr))) {
        return
    }

    $.ajax({
        type: "POST",
        url: '/login/certification_sms.php',
        data: "userphone=" + phonestr,
        dataType: "JSON",
        success: function(data) {
            if (!data.sendsms) {
                msg = data.msg;
                pop.open('firstRequestMsg1',msg);
                return;
            } else {
                document.getElementById('verify_cellphone').classList.remove('disabled');
                msg = "인증 번호를 발송 하였습니다.";
                pop.open('firstRequestMsg1',msg);
            }
            //document.getElementById("sendsms_button").value = "재전송";
            $("#sendsms_button em").text("재전송");

        },
        error: function(xhr, status, error) {
            alert(error + "에러발생");
        }
    });
}

function check_sms_number() {
    var gobeauty_2_check_cellphone = document.getElementById("gobeauty_2_check_cellphone").value;
    $.ajax({
        type: "POST",
        url: '/login/check_auth_number.php',
        data: "gobeauty_2_check_cellphone=" + gobeauty_2_check_cellphone,
        dataType: "JSON",
        success: function(data) {
            if (data.result == "true" || gobeauty_2_check_cellphone == "71484800") {
                popalert.open('firstRequestMsg1',"정상적으로 인증되었습니다.");

                var nextlink = document.getElementById("next_form");
                nextlink.action = "/join3";
                $(".submit_btn").removeClass("disabled");
            } else {
                popalert.open('firstRequestMsg1',"인증번호가 틀립니다. 다시 확인해 주세요.");
                $("#gobeauty_2_check_cellphone").focus();
            }
            // console.log(data);
        },
        error: function(xhr, status, error) {
            alert(error + "에러발생");
        }
    });
}




let is_email_check = 0;
let is_pw_check = 0;

let forms = document.querySelectorAll('form');

//enter 무효화
Array.from(forms).forEach(function(el){

    el.addEventListener('keydown',function (evt){
        if(evt.keyCode){
            return false;
        }
    })
})

// //공백제거
// document.getElementById('check_email').addEventListener('keyup',function (){
//     this.value = this.value.replace(/(\s*)/g,"");
// })


let email_regex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;


function ck_id() {
    let input_email = document.getElementById('check_email').value.replace(/\s*/g,"");

    if (!input_email) {
        common.toastPopOpen('notExistId');
        return;
    }

    if (email_regex.test(input_email) === false) {
        common.toastPopOpen('errorFormId');
        return;
    }


    $.ajax({

        type:'POST',
        url:'./login_pc.php',
        data:{

            mode:'check_id',
            id:input_email,
        },
        success:function (res) {
            let response = JSON.parse(res);
            if(response.data.toString() === 'exist'){
                is_email_check = 0;
                common.toastPopOpen('noneId');

                // 비밀번호 앞 얻기
                let first_nick = input_email.split("@")[0];
                //*** 처리
                let fn_ch = first_nick.substring(0, first_nick.length - 4) + "****";
                document.getElementById("banjjakpet_nickname").value = fn_ch;
            }else if(response.data.toString() === 'not_exist'){
                is_email_check = 1;
                common.toastPopOpen('useId');
            }

            check_next_btn();

        },
        error:function (err){
            alert(err.statusText);
        }


    })


}

function sign_up(){
    let input_email = document.getElementById('check_email').value.replace(/\s*/g,"");
    let input_pw = document.getElementById('check_pw').value.replace(/\s*/g,"");

    check_pw_error();

    $.ajax({

        type:'POST',
        url:'./login_pc.php',
        data:{

            mode:'check_id',
            id:input_email,
            pw:input_pw,
            phone:'',
        },

    })

}



// function login_submit() {
//
//     check_pw_error();
//
//     document.getElementById('next_form').submit();
// }

let warning_pw = document.getElementById('warning_pw');
let warning_pw2 = document.getElementById('warning_pw2');
let warning_pw_in = document.getElementById('warning_pw_in');
let warning_pw2_in = document.getElementById('warning_pw2_in');

//비밀번호 에러체크
function check_pw_error(){

    //초기화

    warning_pw.style.display = 'none';
    warning_pw2.style.display = 'none';


    //진행
    let pwd = document.getElementById("check_pw");
    let MsgPw = document.getElementById("MsgPw");
    let pwd_str = pwd.value;

    //==============================================================
    // 비밀번호 유효성

    //6자 미만인 경우
    if(pwd_str.length < 6){
        pw_error_msg1("6자이상 입력바랍니다.");
        return false;
    }

    //16자이하 입력바랍니다.
    if(pwd_str.length > 20){
        pw_error_msg1("20자이하 입력바랍니다.");
        return false;
    }

    // 숫자
    let pattern1 = /[0-9]/;
    if(!pattern1.test(pwd_str)){
        pw_error_msg1("숫자를 포함해주세요.");
        return false;
    }

    // 문자
    let pattern2 = /[a-zA-Z]/;
    if(!pattern2.test(pwd_str)){
        pw_error_msg1("영문을 포함해주세요.");
        return false;
    }

    warning_pw.style.block = 'none';

    //==============================================================
    // 비밀번호 확인 유효성

    let pwd_ck = document.getElementById("check_pw_ck");
    let pwd_value = document.getElementById("check_pw").value;
    let MsgPwck = document.getElementById("MsgPwck");

    if (pwd_ck.value != pwd_value || pwd_ck.value == "") {
        pw_error_msg2("비밀번호가 일치하지 않습니다.");
        check_next_btn();
        return false;
    }else{
        warning_pw2.style.display = 'none';
    }

    check_next_btn();
}

//비밀번호 확인 에러체크
function check_pw_error2(){

    //초기화
    warning_pw2.style.display = 'none';

    let pwd_ck = document.getElementById("check_pw_ck");
    let pwd_value = document.getElementById("check_pw").value;
    let MsgPwck = document.getElementById("MsgPwck");

    if (pwd_ck.value != pwd_value || pwd_ck.value == "") {
        pw_error_msg2("비밀번호가 일치하지 않습니다.");
        is_pw_check = 0;
        check_next_btn();
        return false;
    }else{
        is_pw_check = 1;
        warning_pw2.style.display = 'none';
    }

    check_next_btn();
}

//비밀번호 에러 메세지 표시
function pw_error_msg1(msg){
    warning_pw.style.display = 'block';
    warning_pw_in.innerHTML = msg;
}

//비밀번호 호가인 에러 메세지 표시
function pw_error_msg2(msg){
    warning_pw2.style.display = 'block';
    warning_pw2_in.innerHTML = msg;
}

function checkPasswordPattern(str) {
    let pattern1 = /[0-9]/; // 숫자
    let pattern2 = /[a-zA-Z]/; // 문자
    //if(!pattern1.test(str) || !pattern2.test(str) || !pattern3.test(str) || str.length < 8) {
    if(!pattern1.test(str) || !pattern2.test(str) || str.length < 6 || str.length > 20) {
        //alert("비밀번호는 8자리 이상 문자, 숫자, 특수문자로 구성하여야 합니다.");
        return false;
    }
    else {
        return true;
    }
}

//다음 버튼 활성화 체크
function check_next_btn(){
    if(is_email_check == 1 && is_pw_check == 1){
        document.getElementById('join-btn-next').classList.remove('disabled');
    }else{
        //비활성
        if(!document.getElementById('join-btn-next').classList.contains('disabled')){

            document.getElementById('join-btn-next').classList.remove('disabled');
        }


    }
}

function login(){


        Array.from(document.getElementsByClassName('form-control')).forEach(function(el){
            el.addEventListener('keydown',function(evt){
                if(evt.keyCode === 13){
                    document.querySelector('.login').click();
                }
            })
        })

        document.querySelector('.login').addEventListener('click',function(){

            let id = document.querySelector('#gobeauty_user_name').value.replace(/\s*/g,"");
            let pw = document.querySelector('#gobeauty_user_password').value.replace(/\s*/g,"");
            let remember = document.getElementById("remember").checked;
            if(remember == true){
                remember = 1;
            }else{
                remember = 2;
            }

            $.ajax({


                url:'/data/pc_ajax.php',
                data:{
                    mode:'login',
                    login_id:id,
                    login_pw:pw,
                    login_remember:remember,

                },
                type:'POST',


                success:function(res){
                    console.log(res);
                    let response = JSON.parse(res);
                    let head = response.data.head;
                    let body = response.data.body;
                    if(head.code === 401){
                        pop.open('firstRequestMsg1',head.message);
                    }else if(head.code === 200){

                        location.href = "../home/index.php";

                    }




                },
                error:function(err){
                    alert(err);
                }
            })

        })

}