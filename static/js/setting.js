

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
            console.log(res);
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                // 샵 오픈, 종료 시간
                $(".open_close").text(am_pm_check(body[0].open_time)+":00 ~ "+am_pm_check(body[0].close_time)+":00");
            }
        }
    })
}