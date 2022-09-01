var etc_array = [];

// 공지사항 가져오기
function get_notice(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'get_notice',
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
                etc_array.push(body);
            }
        }
    })
}

// 1대1문의 내역
function get_qna(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'get_qna',
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
                etc_array.push(body);
            }
        }
    })
}

// 1대1 문의하기
function post_qna(data){
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
                pop.open('reloadPop', '완료되었습니다.');
            }
        }
    })
}

// 비밀번호 변경
function change_password(id,old_pw, new_pw){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'change_password',
            partner_id: id,
            old_pw: old_pw,
            new_pw: new_pw,
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
                if(body){
                    if(body.is_same == false){
                        pop.open('firstRequestMsg1', '현재 비밀번호가 맞지 않습니다..');
                    }else{
                        if(body.err == 1){
                            pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                        }else{
                            pop.open('reloadPop', '변경되었습니다.');
                        }
                    }
                }else{
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                }
            }
        }
    })
}