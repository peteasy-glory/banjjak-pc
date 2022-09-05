var report_array = [];
var result = [];

// 기본 영업시간 가져오기
function get_performancee(data){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: data,
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
                result = body;
            }
        }
    })
}

// 미용-미용별 가져오기
function get_beauty_list(id){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode:'get_beauty_list',
            login_id:id,
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
                report_array.push(body.worktime);
            }
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
                report_array.push(body);
            }
        }
    })
}