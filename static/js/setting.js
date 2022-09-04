var setting_array = [];

// 기본 영업시간 가져오기
function get_open_close(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'open_close',
            login_id: id,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            //console.log(res);
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                setting_array.push(body[0]);
            }
        }
    })
}

// 휴게시간 가져오기
function break_time(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'break_time',
            login_id: id,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            //console.log(res);
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                setting_array.push(body[0]);
            }
        }
    })
}

// 시간제 가져오기
function time_type(id){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'time_type',
            login_id: id,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            //console.log(res);
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                setting_array.push(body);
            }
        }
    })
}

// 타임제 스케줄 가져오기
function part_time(id){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'part_time',
            login_id: id,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            //console.log(res);
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                setting_array.push(body);
            }
        }
    })
}

// 정기휴일 가져오기
function regular_holiday(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'regular_holiday',
            login_id: id,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            //console.log(res);
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                setting_array.push(body[0]);
            }
        }
    })
}

// 임시휴무 및 휴가 가져오기
function artist_vacation(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'artist_vacation',
            login_id: id,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            //console.log(res);
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                setting_array.push(body);
            }
        }
    })
}

// 단/장기 휴무 추가하기
function post_vacation(data){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: data,
        type: 'POST',
        async:false,
        success: function (res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                pop.open('reloadPop', '완료되었습니다.');
            }
        }
    })
}

// 권한받은 미용사 불러오기
function get_authority(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'get_authority',
            login_id: id,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            //console.log(res);
            let response = JSON.parse(res);
            setting_array.push(response.data);
        }
    })
}

// 권한받은 미용사 수정/삭제
function put_authority(data){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: data,
        type: 'POST',
        async:false,
        success: function (res) {
            //console.log(res);
            let response = JSON.parse(res);
            let head = response.data.head;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                pop.close();
                pop.open('reloadPop', '완료되었습니다.');
            }
        }
    })
}

// 권한 미용사 조회
function is_authority(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'is_authority',
            login_id: id,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            console.log(body);
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                if(body.exist){
                    $(".ck_id_wrap").css('display','none');
                    pop.open('firstRequestMsg1', body.message);
                }else{
                    $("#authority_form #customer_id").val(id);
                    $(".ck_id_wrap .value").text(id);
                    $(".ck_id_wrap").css('display','block');
                }
            }
        }
    })
}

// 적립금 불러오기
function get_pay_reserve(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'get_pay_reserve',
            login_id: id,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            //console.log(res);
            let response = JSON.parse(res);
            setting_array.push(response.data);
        }
    })
}

// 적립금 수정하기
function put_pay_reserve(id, is_use, percent, min_pay){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'put_pay_reserve',
            login_id: id,
            is_use: is_use,
            percent: percent,
            min_pay: min_pay,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            pop.open('reloadPop', '저장되었습니다.');
        }
    })
}

// 결제방식 불러오기
function get_pay_type(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'get_pay_type',
            login_id: id,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            let response = JSON.parse(res);
            var type = response.data;
            if(type == 0){ // 지금결제
                $(".pay_type_wrap .pay_now").prop("checked", true);
            }else if(type == 1){ // 지금결제, 매장결제
                $(".pay_type_wrap .pay_now").prop("checked", true);
                $(".pay_type_wrap .pay_shop").prop("checked", true);
            }else if(type == 2){ // 매장결제
                $(".pay_type_wrap .pay_shop").prop("checked", true);
            }
        }
    })
}

// 결제방식 변경
function put_pay_type(id, pay_type){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'put_pay_type',
            login_id: id,
            pay_type: pay_type,
        },
        type: 'POST',
        async:false,
        success: function (res) {
        }
    })
}

// 미용사 리스트 불러오기
function get_artist_list(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'get_artist_list',
            login_id: id,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                setting_array.push(body);
            }
        }
    })
}

// 미용사 숨김 수정
function show_modify_artist(id, name, is_view){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'show_modify_artist',
            login_id: id,
            name: name,
            is_view: is_view,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            let response = JSON.parse(res);
            if(response.data.head.code == 200){
                if(is_view == 1){
                    pop.open('reloadPop', '숨김 처리되었습니다.');
                }else{
                    pop.open('reloadPop', '숨김 해제되었습니다.');
                }
            }
        }
    })
}

// 미용사 퇴사 수정
function leave_modify_artist(id, name, is_out){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'leave_modify_artist',
            login_id: id,
            name: name,
            is_out: is_out,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            let response = JSON.parse(res);
            if(response.data.head.code == 200){
                if(is_out == 1){
                    pop.open('reloadPop', '퇴사 처리되었습니다.');
                }else{
                    pop.open('reloadPop', '퇴사 취소되었습니다.');
                }
            }
        }
    })
}

// 미용사 일정등록/수정
function put_artist(data){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: data,
        type: 'POST',
        async:false,
        success: function (res) {
            console.log(res);
            let response = JSON.parse(res);
            let head = response.data.head;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                pop.close();
                pop.open('reloadPop', '완료되었습니다.');
            }
        }
    })
}

// 미용사 노출순서 변경
function artist_ord_change(id, name){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode:"ord_change_artist",
            login_id: id,
            name:name,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                console.log(res);
            }
        }
    })
}

//////////// 일정관리 수정 저장 시작 //////////
function put_schedule(data){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: data,
        type: 'POST',
        async:false,
        success: function (res) {
            console.log(res);
            let response = JSON.parse(res);
            let head = response.data.head;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                pop.open('firstRequestMsg1', '완료되었습니다.');
            }
        }
    })
}
//////////// 일정관리 수정 저장 끝 //////////