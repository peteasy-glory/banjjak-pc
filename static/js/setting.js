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
                pop.open('scheduleBackUrl', '완료되었습니다.');
            }
        }
    })
}
//////////// 일정관리 수정 저장 끝 //////////

// 임시휴무 삭제하기
function del_vacation(idx){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode:"del_vacation",
            idx: idx,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                pop.open('reloadPop', '삭제되었습니다.');
            }
        }
    })
}

// 판매상품관리
// 기본미용상품가져오기
function get_beauty_product(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'get_beauty_product',
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

// 강아지 추가옵션 가져오기
function get_option_product(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'get_option_product',
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

// 쿠폰상품 가져오기
function get_beauty_coupon(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'get_beauty_coupon',
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

// 매장판매 물품 가져오기
function get_etc_product(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'get_etc_product',
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

// 메인상품 뿌려주기
function view_beauty_product(){
    // 미용별 소요시간
    var col_html = '<colgroup>';
    var thead_html = '<thead><tr>';
    var tbody_html = '<tbody><tr>';
    var add_service = ['무게'];
    $.each(setting_array[0].worktime, function(i,v){
        var txt = '';
        switch (i){
            case 'bath' : txt = '목욕'; break;
            case 'part' : txt = '부분미용'; break;
            case 'bath_part' : txt = '부분+목욕'; break;
            case 'sanitation' : txt = '위생'; break;
            case 'sanitation_bath' : txt = '위생+목욕'; break;
            case 'all' : txt = '전체미용'; break;
            case 'spoting' : txt = '스포팅'; break;
            case 'scissors' : txt = '가위컷'; break;
            case 'summercut' : txt = '썸머컷'; break;
            default : txt = i; add_service.push(txt);
        }
        col_html += '<col style="width:auto;">';
        thead_html += `<th>${txt}</th>`;
        tbody_html += `<td>${v.time}</td>`;
    })
    col_html += '</colgroup>';
    thead_html += '</tr></thead>';
    tbody_html += '</tr></tbody>';
    $(".beauty_time_wrap").html(col_html+thead_html+tbody_html);

    // 강아지 미용 가격
    //console.log(setting_array[0].dog);
    var dog_total_html = '';
    $.each(setting_array[0].dog, function(index,value){
        var service_type = '';
        if(value.in_shop == 1 && value.out_shop == 1){
            service_type = '출장/매장';
        }else if(value.in_shop == 1){
            service_type = '매장상품';
        }else if(value.out_shop == 1){
            service_type = '출장상품';
        }
        var dog_title = '';
        if($.trim(value.second_type) == '직접입력' && value.direct_title != ''){
            dog_title = value.direct_title;
        }else{
            dog_title = value.second_type;
        }
        var dog_st_html = `
            <div class="basic-data-group">
                <div class="con-title-group large">
                    <h6 class="con-title">${dog_title}<div class="label label-outline-purple vmiddle round">${service_type}</div></h6>
                </div>
                <div class="read-table">
                    <div class="read-table-unit large">(단위:원)</div>
                    <table>
        `;
        var dog_col_html = `<colgroup>`;
        var dog_thead_html = `<thead><tr>`;
        var dog_tbody_html = ``;

        var is_service = [];
        $.each(value.service, function(i,v){
            dog_tbody_html += `<tbody><tr>`;
            var add_number = 0;
            var empty_td = 0;
            $.each(v, function(_i, _v){
                //console.log(i);
                var txt = '';
                switch (_i){
                    case 'bath_price' : txt = '목욕'; break;
                    case 'part_price' : txt = '부분미용'; break;
                    case 'bath_part_price' : txt = '부분+목욕'; break;
                    case 'sanitation_price' : txt = '위생'; break;
                    case 'sanitation_bath_price' : txt = '위생+목욕'; break;
                    case 'all_price' : txt = '전체미용'; break;
                    case 'spoting_price' : txt = '스포팅'; break;
                    case 'scissors_price' : txt = '가위컷'; break;
                    case 'summercut_price' : txt = '썸머컷'; break;
                    default : txt = add_service[add_number]; add_number ++;
                }

                if(is_service.indexOf(_i) < 0){
                    dog_col_html += `<col style="width:auto;">`;
                    dog_thead_html += `<th>${txt}</th>`;
                    is_service.push(_i);
                }


                if(_i == 'kg'){
                    dog_tbody_html += `<td>~ ${_v}kg</td>`;
                }else{
                    //console.log(_v.consult);
                    var price = '';
                    if(_v.consult == 0){
                        price = (_v.price).format();
                    }else{
                        price = '상담';
                    }
                    if(is_service.indexOf(_i) == empty_td){
                        dog_tbody_html += `<td>${price}</td>`;
                    }else{
                        var cnt = is_service.indexOf(_i) - empty_td;
                        for(var i=0;i<cnt;i++){
                            dog_tbody_html += `<td></td>`;
                            empty_td ++;
                        }
                        dog_tbody_html += `<td>${price}</td>`;
                    }

                }
                empty_td ++;
            })
            dog_tbody_html += `</tr></tbody>`;
        })

        dog_col_html += `</colgroup>`;
        dog_thead_html += `</tr></thead>`;

        if(value.is_over_kgs == 1){
            var colspan = is_service.length - 1;
            dog_tbody_html += `
                    <tr>
                        <td>${value.over_kg}kg ~</td>
                        <td colspan="${colspan}">kg당 ${(value.over_price).format()}원 추가</td>
                    </tr>
                `;
        }

        var dog_fi_html = `
                    </table>
                </div>
            <div class="basic-data-group large">
                <div class="memo-item large">
                    <div class="memo-item-title">상품별 안내사항</div>
                    <div class="memo-item-txt">${db_to_str(value.comment)}</div>
                </div>
            </div>
            <div class="btn-basic-action">
                <div class="grid-layout btn-grid-group">
                    <div class="grid-layout-inner justify-content-end">
                        <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-purple btn-small-size btn-basic-small">수정</button></div>
                        <div class="grid-layout-cell flex-auto"><button type="button" class="btn btn-outline-gray btn-small-size btn-basic-small">삭제</button></div>
                    </div>
                </div>
            </div>
        </div>
        `;
        dog_total_html += dog_st_html + dog_col_html + dog_thead_html + dog_tbody_html + dog_fi_html;
    })
    $(".append_dog_service_wrap").append(dog_total_html);

    // 공통 안내사항
    $(".etc_comment").text(setting_array[0].etc_comment);

    // 부가세
    if(setting_array[0].is_vat == 0){
        $("#switch-toggle").prop("checked", false);
    }else{
        $("#switch-toggle").prop("checked", true);
    }

    // 고양이 미용가격
    //console.log(setting_array[0].cat);
    if(setting_array[0].cat != ''){
        var cat_product_type = '';
        if(setting_array[0].cat.in_shop == 1 && setting_array[0].cat.out_shop == 1){
            cat_product_type = '출장/매장';
        }else if(setting_array[0].cat.in_shop == 1){
            cat_product_type = '매장상품';
        }else if(setting_array[0].cat.out_shop == 1){
            cat_product_type = '출장상품';
        }
        $(".cat_product_type").text(cat_product_type);

        var cat_col_html = `<colgroup>`;
        var cat_thead_html = `<thead><tr>`;
        var cat_tbody_html = `<tbody>`;
        if(setting_array[0].cat.is_use_weight == 1){
            cat_col_html += `
                    <col style="width:16.66%;">
                    <col style="width:auto;">
                    <col style="width:auto;">
                </colgroup>
            `;
            cat_thead_html += `
                        <th>무게</th>
                        <th>단모</th>
                        <th>장모</th>
                    </tr>
                </thead>
            `;
            var section = (setting_array[0].cat.section).split(',');
            for(var i=0;i<section.length;i++){
                console.log(section[i]);
                cat_tbody_html += `
                    <tr>
                        <td>~ ${section[i]}kg</td>
                        <td>${(setting_array[0].cat.service[i].short_price).format()}</td>
                        <td>${(setting_array[0].cat.service[i].long_price).format()}</td>
                    </tr>
                `;
            }
            cat_tbody_html += `</tbody>`;
        }else{
            cat_col_html += `
                    <col style="width:auto;">
                    <col style="width:auto;">
                </colgroup>
            `;
            cat_thead_html += `
                        <th>단모</th>
                        <th>장모</th>
                    </tr>
                </thead>
            `;
            cat_tbody_html += `
                <tr>
                    <td>${(setting_array[0].cat.short_price).format()}</td>
                    <td>${(setting_array[0].cat.long_price).format()}</td>
                </tr>
            `;
        }
        $(".cat_beauty_price_wrap").html(cat_col_html+cat_thead_html+cat_tbody_html);

        $(".shower_price").text((setting_array[0].cat.shower_price).format());
        $(".shower_price_long").text((setting_array[0].cat.shower_price_long).format());
        if(setting_array[0].cat.shower_price_long == '' && setting_array[0].cat.shower_price == ''){
            $(".shower_wrap").css("display","none");
        }

        $(".hair_clot_price").text((setting_array[0].cat.hair_clot_price).format());
        if(setting_array[0].cat.hair_clot_price == ''){
            $(".hair_clot_wrap").css("display","none");
        }
        $(".ferocity_price").text((setting_array[0].cat.ferocity_price).format());
        if(setting_array[0].cat.ferocity_price == ''){
            $(".ferocity_wrap").css("display","none");
        }
        var cat_shop_option_html = ``;
        $.each(setting_array[0].cat.shop_option, function(i,v){
            cat_shop_option_html += `
                <tr>
                    <td>${i}</td>
                    <td>${v.format()}</td>
                </tr>
            `;
        })
        $(".shop_option_append_wrap").append(cat_shop_option_html);

        $(".toenail_price").text((setting_array[0].cat.toenail_price).format());
        if(setting_array[0].cat.toenail_price == ''){
            $(".toenail_wrap").css("display","none");
        }
        var cat_option_html = ``;
        $.each(setting_array[0].cat.option, function(i,v){
            cat_option_html += `
                <tr>
                    <td>${i}</td>
                    <td>${v.format()}</td>
                </tr>
            `;
        })
        $(".option_append_wrap").append(cat_option_html);
        $(".cat_comment").text(setting_array[0].cat.comment);

        $(".total_cat_wrap").css("display","block");
        $(".cat_none_wrap").css("display","none");
    }
}

// 강아지 추가옵션 뿌려주기
function view_option_product(){
    //console.log(setting_array[1].option);
    if(setting_array[1].option != ''){
        var option_col_html = `
            <colgroup>
                <col style="width:auto;">
                <col style="width:auto;">
            </colgroup>
        `;
        var option_thead_html = `
            <thead>
                <tr>
                    <th>상품명</th>
                    <th>가격</th>
                </tr>
            </thead>
        `;
        //console.log(setting_array[1].option.face);
        if(setting_array[1].option.face != ''){

            var face_tbody_html = `<tbody>`;
            $.each(setting_array[1].option.face, function(i,v){
                var txt = '';
                switch (i){
                    case 'basic' : txt = '기본얼굴컷'; break;
                    case 'bear' : txt = '곰돌이컷'; break;
                    case 'broccoli' : txt = '브로컬리컷'; break;
                    case 'highba' : txt = '하이바컷'; break;
                    default : txt = i;
                }
                face_tbody_html += `
                    <tr>
                        <td>${txt}</td>
                        <td>${v.format()}</td>
                    </tr>
                `;
            })
            face_tbody_html += `</tbody>`;
            $(".face_wrap").html(option_col_html+option_thead_html+face_tbody_html);
        }else{
            $(".do_face").css("display","none");
            $(".no_face").css("display","block");
        }

        if(setting_array[1].option.hair_len != ''){

            var hair_len_tbody_html = `<tbody>`;
            $.each(setting_array[1].option.hair_len, function(i,v){
                hair_len_tbody_html += `
                    <tr>
                        <td>${i}mm</td>
                        <td>${v.format()}</td>
                    </tr>
                `;
            })
            hair_len_tbody_html += `</tbody>`;
            $(".hair_len_wrap").html(option_col_html+option_thead_html+hair_len_tbody_html);
        }else{
            $(".do_hair_lene").css("display","none");
            $(".no_hair_len").css("display","block");
        }

        if(setting_array[1].option.plus != ''){

            var plus_tbody_html = `<tbody>`;
            $.each(setting_array[1].option.plus, function(i,v){
                var txt = '';
                switch (i){
                    case 'short_bath' : txt = '단모 목욕'; break;
                    case 'long_bath' : txt = '장모 목욕'; break;
                    case 'double_bath' : txt = '이중모 목욕'; break;
                    case 'highba' : txt = '하이바컷'; break;
                    default : txt = i;
                }
                plus_tbody_html += `
                    <tr>
                        <td>${txt}</td>
                        <td>${v.format()}</td>
                    </tr>
                `;
            })
            plus_tbody_html += `</tbody>`;
            $(".plus_wrap").html(option_col_html+option_thead_html+plus_tbody_html);
        }else{
            $(".do_plus").css("display","none");
            $(".no_plus").css("display","block");
        }

        if(setting_array[1].option.plus != ''){

            var plus_tbody_html = `<tbody>`;
            $.each(setting_array[1].option.plus, function(i,v){
                var txt = '';
                switch (i){
                    case 'short_bath' : txt = '단모 목욕'; break;
                    case 'long_bath' : txt = '장모 목욕'; break;
                    case 'double_bath' : txt = '이중모 목욕'; break;
                    default : txt = i;
                }
                plus_tbody_html += `
                    <tr>
                        <td>${txt}</td>
                        <td>${v.format()}</td>
                    </tr>
                `;
            })
            plus_tbody_html += `</tbody>`;
            $(".plus_wrap").html(option_col_html+option_thead_html+plus_tbody_html);
        }else{
            $(".do_plus").css("display","none");
            $(".no_plus").css("display","block");
        }

        if(setting_array[1].option.place_plus != ''){

            var place_plus_tbody_html = `<tbody>`;
            $.each(setting_array[1].option.place_plus, function(i,v){
                var txt = '';
                switch (i){
                    case 'hair_clot' : txt = '털엉킴'; break;
                    case 'ferocity' : txt = '사나움'; break;
                    case 'tick' : txt = '진드기'; break;
                    default : txt = i;
                }
                place_plus_tbody_html += `
                    <tr>
                        <td>${txt}</td>
                        <td>${v.format()}</td>
                    </tr>
                `;
            })
            place_plus_tbody_html += `</tbody>`;
            $(".place_plus_wrap").html(option_col_html+option_thead_html+place_plus_tbody_html);
        }else{
            $(".do_place_plus").css("display","none");
            $(".no_place_plus").css("display","block");
        }

        if(setting_array[1].option.etc.leg != ''){

            var leg_tbody_html = `<tbody>`;
            $.each(setting_array[1].option.etc.leg, function(i,v){
                var txt = '';
                switch (i){
                    case 'tonail' : txt = '발톱'; break;
                    case 'boots' : txt = '장화'; break;
                    case 'bell' : txt = '방울'; break;
                    default : txt = i;
                }
                leg_tbody_html += `
                    <tr>
                        <td>${txt}</td>
                        <td>${v.format()}</td>
                    </tr>
                `;
            })
            leg_tbody_html += `</tbody>`;
            $(".leg_wrap").html(option_col_html+option_thead_html+leg_tbody_html);
        }else{
            $(".do_leg").css("display","none");
            $(".no_leg").css("display","block");
        }

        if(setting_array[1].option.etc.spa != ''){

            var spa_tbody_html = `<tbody>`;
            $.each(setting_array[1].option.etc.spa, function(i,v){
                spa_tbody_html += `
                    <tr>
                        <td>${i}</td>
                        <td>${v.format()}</td>
                    </tr>
                `;
            })
            spa_tbody_html += `</tbody>`;
            $(".spa_wrap").html(option_col_html+option_thead_html+spa_tbody_html);
        }else{
            $(".do_spa").css("display","none");
            $(".no_spa").css("display","block");
        }

        if(setting_array[1].option.etc.dyeing != ''){

            var dyeing_tbody_html = `<tbody>`;
            $.each(setting_array[1].option.etc.dyeing, function(i,v){
                dyeing_tbody_html += `
                    <tr>
                        <td>${i}</td>
                        <td>${v.format()}</td>
                    </tr>
                `;
            })
            dyeing_tbody_html += `</tbody>`;
            $(".dyeing_wrap").html(option_col_html+option_thead_html+dyeing_tbody_html);
        }else{
            $(".do_dyeing").css("display","none");
            $(".no_dyeing").css("display","block");
        }

        if(setting_array[1].option.etc.etc_etc != ''){

            var etc_etc_tbody_html = `<tbody>`;
            $.each(setting_array[1].option.etc.etc_etc, function(i,v){
                etc_etc_tbody_html += `
                    <tr>
                        <td>${i}</td>
                        <td>${v.format()}</td>
                    </tr>
                `;
            })
            etc_etc_tbody_html += `</tbody>`;
            $(".etc_etc_wrap").html(option_col_html+option_thead_html+etc_etc_tbody_html);
        }else{
            $(".do_etc_etc").css("display","none");
            $(".no_etc_etc").css("display","block");
        }

        $(".no_option_product").css("display","none");
        $(".do_option_product").css("display","block");
    }
}

// 쿠폰상품 뿌려주기
function view_beauty_coupon(){
    //console.log(setting_array[2]);
    if(setting_array[2] != ''){
        var coupon_col_html = `
            <colgroup>
                <col style="width:auto;">
                <col style="width:auto;">
                <col style="width:auto;">
            </colgroup>
        `;
        var coupon_c_thead_html = `
            <thead>
                <tr>
                    <th>상품명</th>
                    <th>이용 횟수</th>
                    <th>가격(단위:원)</th>
                </tr>
            </thead>
        `;
        var coupon_f_thead_html = `
            <thead>
                <tr>
                    <th>상품명</th>
                    <th>실 적립금</th>
                    <th>가격(단위:원)</th>
                </tr>
            </thead>
        `;
        var coupon_c_tbody_html = `<tbody>`;
        var coupon_f_tbody_html = `<tbody>`;
        $.each(setting_array[2], function(i,v){
            //console.log(v);
            if(v.type == 'C'){
                coupon_c_tbody_html += `
                    <tr>
                        <td>${v.name}</td>
                        <td>${v.given}</td>
                        <td>${(v.price).format()}</td>
                    </tr>
                `;
                $(".coupon_c_memo").text(v.memo);
            }else{
                coupon_f_tbody_html += `
                    <tr>
                        <td>${v.name}</td>
                        <td>${(v.given).format()}</td>
                        <td>${(v.price).format()}</td>
                    </tr>
                `;
                $(".coupon_f_memo").text(v.memo);
            }
        })
        coupon_c_tbody_html += `</tbody>`;
        coupon_f_tbody_html += `</tbody>`;

        $(".coupon_c_wrap").html(coupon_col_html+coupon_c_thead_html+coupon_c_tbody_html);
        $(".coupon_f_wrap").html(coupon_col_html+coupon_f_thead_html+coupon_f_tbody_html);
        $(".do_coupon").css("display","block");
        $(".no_coupon").css("display","none");
    }
}

// 매장상품 뿌려주기
function view_etc_product(){
    //console.log(setting_array[3]);
    if(setting_array[3] != ''){
        var shop_etc_st_html = `
                <colgroup>
                        <col style="width:auto;">
                        <col style="width:auto;">
                    </colgroup>
                    <thead>
                    <tr>
                        <th>상품명</th>
                        <th>가격</th>
                    </tr>
                    </thead>
                <tbody>
            `;
        var shop_etc_merchandise_body_html = '';
        var shop_etc_snack_body_html = '';
        var shop_etc_feed_body_html = '';
        var shop_etc_etc_body_html = '';
        $.each(setting_array[3], function(i,v){
            if(v.type == 1){
                shop_etc_merchandise_body_html += `
                        <tr>
                            <td>${v.name}</td>
                            <td>${(v.price).format()}</td>
                        </tr>
                    `;
                $(".no_shop_etc_merchandise").css("display","none");
                $(".do_shop_etc_merchandise").css("display","block");
            }else if(v.type == 2){
                shop_etc_snack_body_html += `
                        <tr>
                            <td>${v.name}</td>
                            <td>${(v.price).format()}</td>
                        </tr>
                    `;
                $(".no_shop_etc_snack").css("display","none");
                $(".do_shop_etc_snack").css("display","block");
            }else if(v.type == 3){
                shop_etc_feed_body_html += `
                        <tr>
                            <td>${v.name}</td>
                            <td>${(v.price).format()}</td>
                        </tr>
                    `;
                $(".no_shop_etc_feed").css("display","none");
                $(".do_shop_etc_feed").css("display","block");
            }else if(v.type == 4){
                shop_etc_etc_body_html += `
                        <tr>
                            <td>${v.name}</td>
                            <td>${(v.price).format()}</td>
                        </tr>
                    `;
                $(".no_shop_etc_etc").css("display","none");
                $(".do_shop_etc_etc").css("display","block");
            }
        })
        var shop_etc_fi_html = `</tbody>`;
        $(".shop_etc_merchandise_wrap").html(shop_etc_st_html+shop_etc_merchandise_body_html+shop_etc_etc_body_html);
        $(".shop_etc_snack_wrap").html(shop_etc_st_html+shop_etc_snack_body_html+shop_etc_etc_body_html);
        $(".shop_etc_feed_wrap").html(shop_etc_st_html+shop_etc_feed_body_html+shop_etc_etc_body_html);
        $(".shop_etc_etc_wrap").html(shop_etc_st_html+shop_etc_etc_body_html+shop_etc_etc_body_html);
    }
}

// 매장상품 등록/수정
function put_shop_etc(data){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: data,
        type: 'POST',
        async:false,
        success: function (res) {
            //console.log(res);
            let response = JSON.parse(res);
            //console.log(response);
            let head = response.data.head;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                pop.open('historyBackUrl', '완료되었습니다.');

            }
        }
    })
}

// 쿠폰 등록/수정
function put_coupon(data){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: data,
        type: 'POST',
        async:false,
        success: function (res) {
            console.log(res);
            let response = JSON.parse(res);
            console.log(response);
            let head = response.data.head;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                pop.open('historyBackUrl', '완료되었습니다.');

            }
        }
    })
}

function del_coupon(idx){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode:'del_coupon',
            idx:idx
        },
        type: 'POST',
        async:false,
        success: function (res) {
            console.log(res);
            let response = JSON.parse(res);
            console.log(response);
            let head = response.data.head;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                pop.close();
                pop.open('firstRequestMsg1', '삭제되었습니다.');
                $(".is_del_"+idx).parents('.tr_data').remove();
            }
        }
    })
}