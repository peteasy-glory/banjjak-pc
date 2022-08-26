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