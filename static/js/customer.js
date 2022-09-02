//펫이름or 전화번호검색
function search(search_value,id) {

    return new Promise(function (resolve){

        document.getElementById('search').value = search_value.toString();
        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:'search',
                login_id:id,
                search:search_value,
            },
            success:function(res){
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {
                    if(body.length === undefined){
                        body = [body];
                    }

                    console.log(body)
                    if(body.length > 0){
                        document.getElementById('search_phone_none_data').style.display = 'none';
                        document.getElementById('search_phone_inner').innerHTML = ''
                        body.forEach(function (el,i){

                            let image ='';


                            if(el.beauty_photo !== null && el.beauty_photo !== ""){

                                if(el.beauty_photo.substr(0,4) === '/pet'){

                                    image = `https://image.banjjakpet.com${el.beauty_photo.replace('/pet','')}`;
                                }else{
                                    image = `https://image.banjjakpet.com${el.beauty_photo}`;
                                }


                            }else if(el.pet_photo !== null && el.pet_photo !== ""){
                                if(el.pet_photo.substr(0,4) === '/pet'){

                                    image = `https://image.banjjakpet.com${el.pet_photo.replace('/pet','')}`;
                                }else{
                                    image = `https://image.banjjakpet.com${el.pet_photo}`;
                                }
                            }else{
                                if(el.type === 'dog'){
                                    image = `/static/images/icon/icon-pup-select-off.png`
                                }else{
                                    image = `/static/images/icon/icon-cat-select-off.png`
                                }

                            }

                            let sub_cellphone = '0';
                            if(el.family.length >0){
                                sub_cellphone ='';
                                el.family.forEach(function(fam){

                                    sub_cellphone += `${fam.phone}|`
                                })
                            }


                            document.getElementById('search_phone_inner').innerHTML += `<div class="grid-layout-cell grid-2">
                                                                                                <a href="/customer/customer_view.php" onclick="localStorage.setItem('customer_select','${el.cellphone}'); localStorage.setItem('noshow_cnt','${el.no_show_count > 0 ? el.no_show_count : 0}'); localStorage.setItem('sub_cellphone','${sub_cellphone}')" class="customer-card-item">
                                                                                                    <div class="item-info-wrap">
                                                                                                        <div class="item-thumb">
                                                                                                            <div class="user-thumb large">
                                                                                                                <img src="${image}" alt="">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="item-data">
                                                                                                            <div class="item-data-inner">
                                                                                                                <div class="item-pet-name">${el.name}
                                                                                                                    <div class="label label-yellow middle">
                                                                                                                    <strong>${el.pet_type}</strong>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="item-main-phone">
                                                                                                                    <div class="value">${el.cellphone}</div>
                                                                                                                    ${el.no_show_count >0 ? `<div class="label label-outline-pink label-noshow">NO SHOW ${el.no_show_count}회</div>`: ''}
                                                                                                                </div>
                                                                                                                
                                                                                                                <div class="item-sub-phone">
                                                                                                                    <div class="grid-layout margin-2-5">
                                                                                                                        <div class="grid-layout-inner" id="grid_layout_inner_${i}"></div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </a>
                                                                                           </div>`
                        })
                        resolve(body);
                    }else{
                        document.getElementById('search_phone_inner').innerHTML = ''
                        document.getElementById('search_phone_none_data').style.display = 'block';
                    }

                }else{
                    document.getElementById('search_phone_inner').innerHTML = ''
                    document.getElementById('search_phone_none_data').style.display = 'block';
                }
            }
        })
    })
}

//보조연락처(가족)
function search_fam(search_value,id){
    search(search_value,id).then(function(body){
        body.forEach(function (el,i){
            document.getElementById(`grid_layout_inner_${i}`).innerHTML = ''
            if(el.family.length > 0 ){

                el.family.forEach(function(el_,i_){
                    document.getElementById(`grid_layout_inner_${i}`).innerHTML += `<div class="grid-layout-cell flex-auto">
                                                                                                   <div class="value">${i_ < 3 ? el_.phone : i_ === 3 ? `외 ${el.family.length-3}개의 연락처` : ""}</div>
                                                                                               </div>`

                })
            }

        })



    })

}

let list_loging = false;
let list_end = false;

function customer_all_scroll_paging(id){

    let list = document.getElementById('customer_scroll_paging');

    let timer;


    list.addEventListener('scroll',function(){
        // console.log('-------------------------')
        // console.log('list.offsetHeight = ' + list.offsetHeight);
        // console.log('list.scrollTop = ' + list.scrollTop);
        // console.log('list.scrollHeight = ' + list.scrollHeight);
        // console.log(list.offsetHeight + list.scrollTop >= (list.scrollHeight - 200));

        if(list.offsetHeight + list.scrollTop >= (list.scrollHeight - 200)){


            if(!list_loging){
                timer = setTimeout(function(){

                    time = null;
                    customer_all(id).then(function(customers){
                        customer_list(customers);
                    });
                },100)
            }

        }



    })


}

function customer_select_(id){


    if(document.getElementById('customer_select')){
        document.getElementById('customer_select').addEventListener('change',function(){

            document.getElementById('tbody').innerHTML ='';
            offset = 1;
            list_loging = false;
            list_end = false;
            customer_all(id).then(function(customers) {
                customer_list(customers);
            })
        })

    }
}


let offset = 1;

function customer_all(id){

    offset =1;

    return new Promise(function (resolve){
        if(list_loging || list_end){
            return false;
        }

        list_loging = true;
        // document.getElementById('tbody').innerHTML ='';

        let ord = 0;

        let customer_select = document.getElementById('customer_select');

        let value = customer_select.options[customer_select.selectedIndex].value;

        let type = document.querySelector('input[name="customer_type"]:checked').value;

        let number;

        if(parseInt(localStorage.getItem('total_count')) <20){

            number = parseInt(localStorage.getItem('total_count'))
        }else{
            number = 20;
        }



        switch(value){

            case 'a' : ord = 0; break;
            case 'b' : ord = 1; break;
            case 'c' : ord = 2; break;
            case 'd' : ord = 3; break;
            case 'e' : ord = 4; break;
        }


        $.ajax({

            url: '/data/pc_ajax.php',
            type:'post',
            data:{

                mode:'customer_all',
                login_id:id,
                type:type,
                ord:ord,
                offset:offset,
                number:number,

            },
            success:function (res){
                console.log(res)
                let response = JSON.parse(res);
                let customers =response.data
                let head = response.data.head;
                let body = response.data.body;

                if(body.length <=0){

                    list_end = true;
                }

                console.log(body);
                resolve(customers)
            }
            ,complete:function(){
                offset +=20
                list_loging=false;
            }
        })
    })

}



function customer_count(id){


    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'customer_count',
            login_id:id,

        },
        success:function(res){
            let response = JSON.parse(res);
            let animal = response.animal.body.count;
            let people = response.people.body.count;


            document.getElementById('count_people').innerHTML = `고객(${people})`
            document.getElementById('count_animal').innerHTML = `동물(${animal})`
        }

    })
}

function customer_graph(customers){

    let all = (customers[0].body.length === undefined ? 0 : customers[0].body.length)+(customers[1].body.length === undefined ? 0 : customers[1].body.length)+(customers[2].body.length === undefined ? 0 : customers[2].body.length)
    let beauty = (customers[0].body.length === undefined ? 0 : (customers[0].body.length/all*100).toFixed(1));
    let hotel = (customers[1].body.length === undefined ? 0 : (customers[1].body.length/all*100).toFixed(1));
    let kinder = (customers[2].body.length === undefined ? 0 : (customers[2].body.length/all*100).toFixed(1));

    var chart = bb.generate({
        size: {
            height: 285,
            width: 285
        },
        data: {
            columns: [
                ["유치원", kinder],
                ["호텔", hotel],
                ["미용", beauty]
            ],
            colors: {
                유치원: "#7AE19A",
                호텔: "#FDD94E",
                미용: "#8667c1",

            },
            type: "pie",
            labels: {
                show: false
            }
        },
        /* order: "asc", */ // 그래프 순서 변경하기
        legend: {
            show: false
        },
        // tooltip: {
        //     show: false
        // },
        pie: {
            startingAngle: 0.75,
            innerRadius: {  // 차트 두께
                유치원: 90,
                호텔: 90,
                미용: 90,
            },
            label: {   // text 위치
                ratio: 1,
                format: function(value, id) {		return value +"%";       }
            }
        },
        tooltip: {
            format: {
                value:
                    function(value, id) {		return value +"%";    }
            }
        },
        bindto: "#labelRatio"
    });
}

function customer_list(customers){



    let beauty = customers.body;

    if(beauty.length === undefined){
        beauty = [beauty];
    }
    let tbody = document.getElementById('tbody');
    

    beauty.forEach(function (el,i){

        // if(i<300) {


            let y = el.ymdhm.substr(0, 4);
            let M = el.ymdhm.substr(4, 2);
            let d = el.ymdhm.substr(6, 2);
            let h = el.ymdhm.substr(8, 2);
            let m = el.ymdhm.substr(10, 2);
            let product = el.product.split('|');
            let size = product[3];
            let b_product = product[4];
            let grade = parseInt(el.grade.split('|')[1]);

            tbody.innerHTML += `<tr class="customer-table-cell">
                                <td>
                                    <div class="customer-table-txt">
                                        <strong>${el.name}</strong>
                                    </div>
                                    <div class="customer-table-txt">
                                        <span class="icon icon-grade-${grade ===  1 ? 'vip' : grade === 2 ? 'normal' : 'normalb'}"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="customer-table-txt">
                                        <strong>${el.type === "dog" ? '개' : '고양이'}</strong>
                                    </div>
                                    <div class="customer-table-txt">${el.pet_type}</div>
                                </td>
                                <td>
                                    <div class="customer-table-txt">${el.cellphone.replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`)}</div>
                                    <div class="customer-table-txt">${el.reserve}P</div>
                                </td>
                                <td>
                                
                                    <div class="customer-table-txt">${y !== '' ? `${y}.${M}.${d}`:''}</div>
                                    <div class="customer-table-txt">${h !== '' ? `${am_pm_check(h)}:${m}` : ''}</div>
                                </td>
                                <td>
                                    <div class="customer-table-txt">${el.type === "dog" ? `${size === null || size === "" || size === undefined ? '미기입' : size}` : `${size === null || size === "" || size === undefined ? '미기입' : `${size.split(':')[0]}`} `}</div>
                                </td>
                                <td>
                                    <div class="customer-table-txt">${el.type === "dog" ? `${b_product === null || b_product === "" || b_product === undefined ? '미기입' : b_product}` : `${b_product === null || b_product === "" || b_product === undefined ? '미기입' : `${b_product.split(':')[0]}`} `}</div>
                                </td>
                                <td>
                                    <div class="customer-table-txt">미용</div>
                                    <div class="customer-table-txt">${el.use_count}</div>
                                </td>
                                <td>
                                    <div class="customer-table-txt">${el.sum_card}원</div>
                                    <div class="customer-table-txt">${el.sum_cash}원</div>
                                </td>
                                <td>
                                    <div class="customer-table-txt">
                                        <button type="button" class="btn btn-outline-gray btn-small-size">보기</button>
                                    </div>
                                </td>
                            </tr>`

        // }
    })


}

function customer_pet_type(){


    let breed_input;

    let breed;

    let breed_select = document.getElementById('breed_select')

    breed_select.addEventListener('change',function(){
        if(breed_select.options[breed_select.selectedIndex].value === "기타"){

            document.getElementById('breed_other_box').setAttribute('style','display:block');
        }else{
            document.getElementById('breed_other_box').setAttribute('style','display:none');
        }

    })
    Array.from(document.getElementsByClassName('load-pet-type')).forEach(function(el){


        el.addEventListener('click',function(){
            document.getElementById('breed_other_box').setAttribute('style','display:none');
            breed_input = document.querySelector('input[name="breed"]:checked');
            breed = breed_input.value

            $.ajax({

                url:'/data/pc_ajax.php',
                type:'post',
                data:{
                    mode:'pet_type',
                    breed:breed
                },
                success:function(res){
                    let response = JSON.parse(res);
                    let head = response.data.head;
                    let body = response.data.body;
                    if (head.code === 401) {
                        pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                    } else if (head.code === 200) {
                        document.getElementById('breed_select').innerHTML = '<option value="선택">선택</option>';
                        body.forEach(function(el){


                                if(el.name !== "기타"){
                                    document.getElementById('breed_select').innerHTML += `<option value="${el.name}">${el.name}</option>`
                                }


                        })

                        document.getElementById('breed_select').innerHTML += '<option value="기타">기타</option>';




                    }


                }
            })





        })
    })
}

function customer_new_birthday(){

    return new Promise(function (resolve){

        for(let i = 2000; i<=new Date().getFullYear(); i++){

            document.getElementById('birthday_year').innerHTML += `<option value="${fill_zero(i)}" ${i===2022 ? 'selected':''}>${i}</option>`
        }


        for(let i = 1; i<=12; i++){
            document.getElementById('birthday_month').innerHTML += `<option value="${fill_zero(i)}">${i}</option>`
        }

        resolve();
    })

}



function customer_new_birthday_date(){


    let year = document.getElementById('birthday_year').value;
    let month = document.getElementById('birthday_month').value;

    let date_length = new Date(year,month,0).getDate();
    document.getElementById('birthday_date').innerHTML = '';
    for(let i = 1; i<=date_length; i++){
        document.getElementById('birthday_date').innerHTML += `<option value="${fill_zero(i)}">${i}</option>`

    }

    Array.from(document.getElementsByClassName('birthday')).forEach(function(el){

        el.addEventListener('change',function(){

            year = document.getElementById('birthday_year').value;
            month = document.getElementById('birthday_month').value;

            date_length = new Date(year,month,0).getDate();
            document.getElementById('birthday_date').innerHTML = '';
            for(let i = 1; i<=date_length; i++){
                document.getElementById('birthday_date').innerHTML += `<option value="${i}">${i}</option>`

            }
        })
    })

}

function customer_new_weight(){

    document.getElementById('weight1').innerHTML = '';

    for(let i=0; i<=50; i++){

        document.getElementById('weight1').innerHTML += `<option value=${i}>${i}</option>`
    }
}


let validate = false;
function customer_new_cellphone_chk(id){

    let cellphone_input = document.getElementById('customer_cellphone');

    let cellphone = cellphone_input.value;

    if(cellphone.length <8){
        document.getElementById('msg1_txt').innerText = '전화번호를 8자 이상 입력해주세요.'
        pop.open('reserveAcceptMsg1');
        return;

    }


    $.ajax({
        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'search',
            login_id:id,
            search:cellphone
        },
        success:function (res){
            console.log(res);
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                if(body.length === undefined){
                    body = [body];
                }

                body.forEach(function (el){

                    if(cellphone === el.cellphone) {
                        console.log(1)
                        cellphone_input.setAttribute('style', 'background : rgb(255, 204, 204);')

                        validate = false;
                        document.getElementById('msg1_txt').innerText = '이미 가입된 번호입니다.'
                        pop.open('reserveAcceptMsg1');
                    }else{
                        validate=true;
                        cellphone_input.setAttribute('style', 'background : rgb(204, 255, 204);')
                    }


                })
            }else if(head.code === 999){
                validate=true;
                cellphone_input.setAttribute('style', 'background : rgb(204, 255, 204);')

            }
        }

    })


}

function customer_new(id){

    let cellphone_input = document.getElementById('customer_cellphone');
    let name_input = document.getElementById('customer_name')
    let breed_select_input = document.getElementById('breed_select');
    let breed_input = document.querySelector('input[name="breed"]:checked')
    let breed_other_input = document.getElementById('breed_other');
    let gender_input = document.querySelector('input[name="gender"]:checked')
    let neutral_input = document.querySelector('input[name="neutralize"]:checked');
    let weight1_input = document.getElementById('weight1');
    let weight2_input = document.getElementById('weight2');
    let beauty_exp_input = document.getElementById('beauty_exp');
    let vaccination_input = document.getElementById('vaccination');
    let bite_input = document.getElementById('bite');
    let luxation_input = document.getElementById('luxation');
    let special_input = document.querySelectorAll('input[name="special"]:checked');
    let memo_input = document.getElementById('memo');




    let cellphone = cellphone_input.value;
    let name = name_input.value;
    let breed_value = breed_input === null ? '' : breed_input.value
    let breed_select = breed_select_input.options[breed_select_input.selectedIndex].value;
    let breed_other = breed_other_input.value;
    let year = document.getElementById('birthday_year').value;
    let month = document.getElementById('birthday_month').value;
    let date = document.getElementById('birthday_date').value;
    let gender =  gender_input === null ? '0' :  gender_input.value;
    let neutral = neutral_input === null ? '0' : neutral_input.value;
    let weight1 = weight1_input.options[weight1_input.selectedIndex].value;
    let weight2 = weight2_input.options[weight2_input.selectedIndex].value;
    let weight = `${weight1}.${weight2}`;
    let beauty_exp = beauty_exp_input.options[beauty_exp_input.selectedIndex].value;
    let vaccination = vaccination_input.options[vaccination_input.selectedIndex].value;
    let bite = bite_input.options[bite_input.selectedIndex].value;
    let luxation = luxation_input.options[luxation_input.selectedIndex].value;
    let dermatosis = '0';
    let heart_trouble = '0';
    let marking = '0';
    let mounting = '0';
    let submit_and_reserve = document.querySelector('input[name="submit_and_reserve"]:checked') === null ? false : true;

    console.log(breed_select);
    console.log(breed_value);

    let special = [];
    for(let i =0; i<special_input.length;i++){

        special.push(special_input[i].getAttribute('id'));
    }

    if(special.length >0){
        dermatosis = special.includes('special1')  ? '1' : '0';
        heart_trouble = special.includes('special2') ? '1' : '0';
        marking = special.includes('special3') ? '1' : '0';
        mounting = special.includes('special4') ? '1' : '0';

    }

    let memo = memo_input.value;


    if(breed_select === "기타"){

        breed_select = breed_other;
    }



    let breed;
    if(cellphone === ''){

        document.getElementById('msg1_txt').innerText = '전화번호를 입력해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }


    if(validate === false){
        document.getElementById('msg1_txt').innerText = '중복확인을 진행해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }

    if(name === '' ){
        document.getElementById('msg1_txt').innerText = '펫 이름을 입력해주세요.'
        pop.open('reserveAcceptMsg1');
        return;

    }

    if(breed_input === null || breed_input === undefined || breed_input === ''){

        document.getElementById('msg1_txt').innerText = '품종을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }else{
        breed =  breed_input.value;
    }

    if(breed_select === "선택" || breed_select === ''){
        document.getElementById('msg1_txt').innerText = '품종을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;

    }
    if((breed_select === "기타" || breed_select === "") && breed_other === ''){
        document.getElementById('msg1_txt').innerText = '품종을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;

    }

    if(weight1 === "0" && weight2 ==="0"){

        document.getElementById('msg1_txt').innerText = '몸무게를 입력해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }




    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'customer_new',
            partner_id:id,
            cellphone:cellphone,
            name:name,
            type:breed_value,
            pet_type:breed_select,
            year:year,
            month:month,
            date:date,
            gender:gender,
            neutral:neutral,
            weight:weight,
            beauty_exp:beauty_exp,
            vaccination:vaccination,
            bite:bite,
            luxation:luxation,
            dermatosis:dermatosis,
            heart_trouble:heart_trouble,
            marking:marking,
            mounting:mounting,
            memo:memo,

        },
        success:function(res){
            console.log(res);
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                console.log(body)
                location.reload();
                // if(submit_and_reserve){
                //
                // }
            }
        }
    })


}

function customer_view(id){

    return new Promise(function (resolve) {

        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{

                mode:'pet_list',
                login_id:id,
                cellphone:localStorage.getItem('customer_select'),
            },
            success:function(res){
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {

                    if(body.length === undefined){

                        body =[body];
                    }
                    console.log(body)

                    $.ajax({

                        url:'/data/pc_ajax.php',
                        type:'post',
                        data:{

                            mode:'usage_history',
                            login_id:id,
                            cellphone:localStorage.getItem('customer_select')
                        },success:function(res) {
                            let response = JSON.parse(res);
                            let head_ = response.data.head;
                            let body_ = response.data.body;
                            if (head_.code === 401) {
                                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                            } else if (head_.code === 200) {
                                console.log(body_)

                                let body_data= [body,body_]

                                document.getElementById('customer_view_cellphone').innerText = phone_edit(localStorage.getItem('customer_select'));
                                document.getElementById('user_table').innerHTML = `<div class="customer-user-table-row">
                                                                        <div class="customer-user-table-title">
                                                                            <div class="table-title">대표 펫</div>
                                                                        </div>
                                                                        <div class="customer-user-table-data">
                                                                            <div class="table-data">
                                                                                <div class="table-user-name">
                                                                                    ${body[0].name}
                                                                                    <div class="user-grade-item">
                                                                                        <div class="icon icon-grade-vip"></div>
                                                                                        <div class="icon-grade-label">VIP</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="customer-user-info-ui">
                                                                            <div class="label label-outline-pink">NO SHOW ${localStorage.getItem('noshow_cnt')}회</div>
                                                                            <button type="button" class="btn btn-red">초기화</button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="customer-user-table-row">
                                                                        <div class="customer-user-table-title">
                                                                            <div class="table-title">최근이용내역</div>
                                                                        </div>
                                                                        <div class="customer-user-table-data">
                                                                            <div class="table-data">
                                                                                <div class="table-data-txt">${body_[0].product.split('|')[3]}</div>
                                                                            </div>
                                                                            <div class="table-data-side">
                                                                                <button type="button" class="font-color-purple font-underline btn-text">알림톡 발송 조회
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="customer-user-table-row">
                                                                        <div class="customer-user-table-title">
                                                                            <div class="table-title">연락처</div>
                                                                        </div>
                                                                        <div class="customer-user-table-data">
                                                                            <div class="table-data">
                                                                                <div class="customer-user-phone-wrap">
                                                                                    <div class="item-main-phone">
                                                                                        <div class="value">${localStorage.getItem('customer_select')}</div>
                                                                                        <button type="button" class="btn-data-modify">편집</button>
                                                                                    </div>
                                                                                    <div class="item-sub-phone" id="sub_cellphone">
                                                                                        <div class="value">010-1234-1234</div>
                                                                                        <div class="value">010-1234-1234</div>
                                                                                        <div class="value">010-1234-1234</div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="customer-user-table-row wide">
                                                                        <div class="customer-user-table-title">
                                                                            <div class="table-title">메모</div>
                                                                        </div>
                                                                        <div class="customer-user-table-data">
                                                                            <div class="table-data">
                                                                                <div>
                                                                                    <textarea style="height:60px;" placeholder="입력"></textarea>
                                                                                    <div class="form-input-info">*메모는 입력 후 자동 저장됩니다.</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>`

                                body.forEach(function(el,i){

                                    document.getElementById('pet_table').innerHTML += `<div class="grid-layout-cell flex-auto">
                                                                                                    <label class="form-toggle-box" for="pet_list_${i}">
                                                                                                        <input type="radio" name="pet_list" class="btn-toggle-button pet-list-btn" data-pet_seq="${el.pet_seq}" id="pet_list_${i}">
                                                                                                        <em>${el.name}</em>
                                                                                                    </label>
                                                                                                </div>`
                                })

                                    document.getElementById('pet_table').innerHTML += `<div class="grid-layout-cell flex-auto" onClick="pop.open('petAddPop')">
                                                                                                    <button type="button" class="btn-toggle-button btn-toggle-basic">
                                                                                                        <span class="icon icon-plus-more-small"></span>
                                                                                                    </button>
                                                                                                </div>`



                                resolve(body_data);
                            }

                        }


                    })



                }
            }
        })




    })


}

function customer_view_(id){

    customer_view(id).then(function(body_data){

        pet_reserve_info(body_data);

    })

}

function get_grade(id){


    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'get_grade',
            login_id:id,
        },
        success:function(res){
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                body.forEach(function (el){

                    console.log(body)
                    if(el.is_delete === 0){
                        switch (el.grade_ord){

                            case 1: document.getElementById('grade1').value = el.grade_name;
                                    document.getElementById('grade1').setAttribute('data-idx',el.idx);
                            break;
                            case 2: document.getElementById('grade2').value = el.grade_name;
                                document.getElementById('grade2').setAttribute('data-idx',el.idx);
                            break;
                            case 3: document.getElementById('grade3').value = el.grade_name;
                                document.getElementById('grade3').setAttribute('data-idx',el.idx);
                            break;
                        }
                    }

                })

            }
        }

    })

}

function post_grade(){


    Array.from(document.getElementsByClassName('grade-input')).forEach(function (el){

        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:'post_grade',
                grade_idx:el.getAttribute('data-idx'),
                name:el.value,
            },
            success:function(res){

                console.log(res)
            }
        })

    })
}

function customer_delete(id){

    let cellphone = localStorage.getItem('customer_select');
    let partner_id = id;

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'customer_delete',
            partner_id:partner_id,
            cellphone:cellphone
        },
        success:function(res){
            document.getElementById('msg3_txt').innerText = '삭제되었습니다.'
            pop.open('reserveAcceptMsg3');
        }

    })

}

function pet_reserve_info(data){

    console.log(data)

    let pet_list = data[0];


    Array.from(document.getElementsByClassName('pet-list-btn')).forEach(function(el){

        el.addEventListener('click',function(){


            pet_list.forEach(function(el_){

                if(parseInt(el.getAttribute('data-pet_seq')) === el_.pet_seq){

                    console.log(el_)
                }
            })



        })
    })
}