var customer_id = '';
var tmp_seq = '';

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
            beforeSend:function(){
                let height;

                if(document.getElementById('search_phone_data')){

                    document.getElementById('search_phone_data').style.display = 'none';
                    document.getElementById('customer_inquiry_loading').style.display = 'flex';
                }
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

                    //console.log(body)
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


                            // }else if(el.pet_photo !== null && el.pet_photo !== ""){
                            //     if(el.pet_photo.substr(0,4) === '/pet'){
                            //
                            //         image = `https://image.banjjakpet.com${el.pet_photo.replace('/pet','')}`;
                            //     }else{
                            //         image = `https://image.banjjakpet.com${el.pet_photo}`;
                            //     }
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
                                                                                                <a href="/customer/customer_view.php" onclick="localStorage.setItem('user_pet_seq','${el.pet_seq}'); localStorage.setItem('customer_select','${el.cellphone}'); localStorage.setItem('noshow_cnt','${el.no_show_count > 0 ? el.no_show_count : 0}'); localStorage.setItem('sub_cellphone','${sub_cellphone}')" class="customer-card-item">
                                                                                                    <div class="item-info-wrap">
                                                                                                        <div class="item-thumb">
                                                                                                            <div class="user-thumb large" onclick="thumb_view(this,\`${el.beauty_photo}\`)">
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
                        document.getElementById('customer_inquiry_loading').style.display ='none';
                    }

                }else{
                    document.getElementById('search_phone_inner').innerHTML = ''
                    document.getElementById('search_phone_none_data').style.display = 'block';

                    document.getElementById('customer_inquiry_loading').style.display ='none';
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

        if(document.getElementById('search_phone_data')){

            document.getElementById('search_phone_data').style.display = 'block';
            document.getElementById('customer_inquiry_loading').style.display ='none';
        }



    })

}

let list_loging = false;
let list_end = false;

function customer_all_scroll_paging(id){

    let list = document.getElementById('customer_scroll_paging');

    let timer;


    list.addEventListener('scroll',function(){
        // //console.log('-------------------------')
        // //console.log('list.offsetHeight = ' + list.offsetHeight);
        // //console.log('list.scrollTop = ' + list.scrollTop);
        // //console.log('list.scrollHeight = ' + list.scrollHeight);
        // //console.log(list.offsetHeight + list.scrollTop >= (list.scrollHeight - 200));

        if(list.offsetHeight + list.scrollTop >= (list.scrollHeight - 200)){


            if(!list_loging){
                timer = setTimeout(function(){

                    time = null;
                    customer_all(id).then(function(customers){
                        customer_list(id,customers)
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
                customer_list(id,customers);
            })
        })

    }
}


let offset = 1;

function customer_all(id){

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

        //console.log(id)
        //console.log(type)
        //console.log(ord)
        //console.log(offset)
        //console.log(number);

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
                //console.log(res)
                let response = JSON.parse(res);
                let customers =response.data
                let head = response.data.head;
                let body = response.data.body;
                //console.log(body);

                if(body.length === undefined){
                    body = [body];
                }
                if(body.length <=0){

                    list_end = true;
                }

                //console.log(body);
                resolve(customers)
            }
            ,complete:function(){

                offset +=20
                //console.log(offset)
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


function customer_list(id,customers){





        let beauty = customers.body;

        if(beauty.length === undefined){
            beauty = [beauty];
        }
        let tbody = document.getElementById('tbody');


        beauty.forEach(function (el,i){



                let y = el.ymdhm.substr(0, 4);
                let M = el.ymdhm.substr(4, 2);
                let d = el.ymdhm.substr(6, 2);
                let h = el.ymdhm.substr(8, 2);
                let m = el.ymdhm.substr(10, 2);
                let product = el.product.split('|');
                let size = product[3];
                let b_product = product[4];
                let grade = parseInt(el.grade.split('|')[1]);


                //console.log(el)


            $.ajax({
                url:'/data/pc_ajax.php',
                type:'post',
                data:{
                    mode:'get_beauty_agree',
                    partner_id:id,
                    pet_idx:el.pet_seq,
                },
                success:function(res) {
                    let response = JSON.parse(res);
                    let head = response.data.head;
                    let body = response.data.body;
                    if (head.code === 401) {
                        pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                    } else if (head.code === 200) {

                        if(body.length === undefined){
                            body = [body];
                        }

                        tbody.innerHTML += `<tr class="customer-table-cell">
                                    <td>
                                        <div class="customer-table-txt" style="cursor:pointer" onclick="localStorage.setItem('customer_select','${el.cellphone}'); location.href = '/customer/customer_view.php';">
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
                                           ${body.length > 0 && el.pet_seq !== '' ? `<button type="button" class="btn btn-outline-gray btn-small-size" data-pet_seq="${el.pet_seq}" onclick="customer_all_agree(artist_id,this)">보기</button> ` : ''}
                                        </div>
                                    </td>
                                </tr>`

                    }
                }


            })
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


function modify_pet_type(){


    let breed_input;

    let breed;

    let breed_select = document.getElementById('modify_breed_select')

    breed_select.addEventListener('change',function(){
        if(breed_select.options[breed_select.selectedIndex].value === "기타"){

            document.getElementById('modify_breed_other_box').setAttribute('style','display:block');
        }else{
            document.getElementById('modify_breed_other_box').setAttribute('style','display:none');
        }

    })
    Array.from(document.getElementsByClassName('modify_load-pet-type')).forEach(function(el){


        el.addEventListener('click',function(){
            document.getElementById('modify_breed_other_box').setAttribute('style','display:none');
            breed_input = document.querySelector('input[name="modify_breed"]:checked');
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
                        document.getElementById('modify_breed_select').innerHTML = '<option value="선택">선택</option>';
                        body.forEach(function(el){


                            if(el.name !== "기타"){
                                document.getElementById('modify_breed_select').innerHTML += `<option value="${el.name}">${el.name}</option>`
                            }


                        })

                        document.getElementById('modify_breed_select').innerHTML += '<option value="기타">기타</option>';




                    }


                }
            })





        })
    })
}

function modify_customer_pet_type(){


    let breed_input;

    let breed;

    let breed_select = document.getElementById('modify_customer_breed_select')

    breed_select.addEventListener('change',function(){
        if(breed_select.options[breed_select.selectedIndex].value === "기타"){

            document.getElementById('modify_customer_breed_other_box').setAttribute('style','display:block');
        }else{
            document.getElementById('modify_customer_breed_other_box').setAttribute('style','display:none');
        }

    })
    Array.from(document.getElementsByClassName('modify_customer_load-pet-type')).forEach(function(el){


        el.addEventListener('click',function(){
            document.getElementById('modify_customer_breed_other_box').setAttribute('style','display:none');
            breed_input = document.querySelector('input[name="modify_customer_breed"]:checked');
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
                        document.getElementById('modify_customer_breed_select').innerHTML = '<option value="선택">선택</option>';
                        body.forEach(function(el){


                            if(el.name !== "기타"){
                                document.getElementById('modify_customer_breed_select').innerHTML += `<option value="${el.name}">${el.name}</option>`
                            }


                        })

                        document.getElementById('modify_customer_breed_select').innerHTML += '<option value="기타">기타</option>';




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

function modify_new_birthday(){

    return new Promise(function (resolve){

        for(let i = 2000; i<=new Date().getFullYear(); i++){

            document.getElementById('modify_birthday_year').innerHTML += `<option value="${fill_zero(i)}" ${i===2022 ? 'selected':''}>${i}</option>`
        }


        for(let i = 1; i<=12; i++){
            document.getElementById('modify_birthday_month').innerHTML += `<option value="${fill_zero(i)}">${i}</option>`
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



function modify_new_birthday_date(){


    let year = document.getElementById('modify_birthday_year').value;
    let month = document.getElementById('modify_birthday_month').value;

    let date_length = new Date(year,month,0).getDate();
    document.getElementById('modify_birthday_date').innerHTML = '';
    for(let i = 1; i<=date_length; i++){
        document.getElementById('modify_birthday_date').innerHTML += `<option value="${fill_zero(i)}">${i}</option>`

    }

    Array.from(document.getElementsByClassName('modify_birthday')).forEach(function(el){

        el.addEventListener('change',function(){

            year = document.getElementById('modify_birthday_year').value;
            month = document.getElementById('modify_birthday_month').value;

            date_length = new Date(year,month,0).getDate();
            document.getElementById('modify_birthday_date').innerHTML = '';
            for(let i = 1; i<=date_length; i++){
                document.getElementById('modify_birthday_date').innerHTML += `<option value="${i}">${i}</option>`

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
function modify_new_weight(){

    document.getElementById('modify_weight1').innerHTML = '';

    for(let i=0; i<=50; i++){

        document.getElementById('modify_weight1').innerHTML += `<option value=${i}>${i}</option>`
    }
}


function modify_customer_new_birthday(){

    return new Promise(function (resolve){

        for(let i = 2000; i<=new Date().getFullYear(); i++){

            document.getElementById('modify_customer_birthday_year').innerHTML += `<option value="${fill_zero(i)}" ${i===2022 ? 'selected':''}>${i}</option>`
        }


        for(let i = 1; i<=12; i++){
            document.getElementById('modify_customer_birthday_month').innerHTML += `<option value="${fill_zero(i)}">${i}</option>`
        }

        resolve();
    })

}


function modify_customer_new_birthday_date(){


    let year = document.getElementById('modify_customer_birthday_year').value;
    let month = document.getElementById('modify_customer_birthday_month').value;

    let date_length = new Date(year,month,0).getDate();
    document.getElementById('modify_customer_birthday_date').innerHTML = '';
    for(let i = 1; i<=date_length; i++){
        document.getElementById('modify_customer_birthday_date').innerHTML += `<option value="${fill_zero(i)}">${i}</option>`

    }

    Array.from(document.getElementsByClassName('birthday')).forEach(function(el){

        el.addEventListener('change',function(){

            year = document.getElementById('modify_customer_birthday_year').value;
            month = document.getElementById('modify_customer_birthday_month').value;

            date_length = new Date(year,month,0).getDate();
            document.getElementById('modify_customer_birthday_date').innerHTML = '';
            for(let i = 1; i<=date_length; i++){
                document.getElementById('modify_customer_birthday_date').innerHTML += `<option value="${i}">${i}</option>`

            }
        })
    })

}

function modify_customer_new_weight(){

    document.getElementById('modify_customer_weight1').innerHTML = '';

    for(let i=0; i<=50; i++){

        document.getElementById('modify_customer_weight1').innerHTML += `<option value=${i}>${i}</option>`
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
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                if(body.length === undefined){
                    body = [body];
                }
                let check = true;

                body.forEach(function (el){

                    if(cellphone === el.cellphone) {


                        if(document.querySelector('html').classList.contains('dark')){
                            cellphone_input.setAttribute('style', 'background : rgb(255, 204, 204); color:black;')
                        }else{
                            cellphone_input.setAttribute('style', 'background : rgb(255, 204, 204);')

                        }
                        check = false;
                        validate = false;
                        document.getElementById('msg1_txt').innerText = '이미 가입된 번호입니다.'
                        pop.open('reserveAcceptMsg1');
                        return false;
                    }
                })

                if(check){
                    validate=true;

                    if(document.querySelector('html').classList.contains('dark')){
                        cellphone_input.setAttribute('style', 'background : rgb(204, 255, 204); color:black;')
                    }else{
                        cellphone_input.setAttribute('style', 'background : rgb(204, 255, 204);')

                    }

                }




            }
            // else if(head.code === 999){
            //     validate=true;
            //     cellphone_input.setAttribute('style', 'background : rgb(204, 255, 204);')
            //
            // }
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

    //console.log(breed_select);
    //console.log(breed_value);

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
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                if(submit_and_reserve){
                    sessionStorage.setItem('direct','1');
                    sessionStorage.setItem('direct_new','1');
                    sessionStorage.setItem('direct_cellphone',`${cellphone}`)

                    location.href='/booking/reserve_beauty_week.php'

                }else{
                    pop.open('reloadPop', '등록되었습니다.');
                }
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
                ////console.log(res)
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {

                    if(body.length === undefined){

                        body =[body];
                    }
                    //console.log(body)

                    $.ajax({

                        url:'/data/pc_ajax.php',
                        type:'post',
                        data:{

                            mode:'usage_history',
                            login_id:id,
                            cellphone:localStorage.getItem('customer_select')
                        },success:function(res) {
                            //console.log(res)
                            let response = JSON.parse(res);
                            let head_ = response.data.head;
                            let body_ = response.data.body;
                            if (head_.code === 401) {
                                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                            } else if (head_.code === 200) {

                                if(body_.length === undefined){

                                    body_ = [body_]
                                }

                                let body_data= [body,body_]

                                // customer_id = body[0].customer_id;
                                // tmp_seq = body[0].tmp_seq;

                                document.getElementById('customer_view_cellphone').innerText = phone_edit(localStorage.getItem('customer_select'));
                                document.getElementById('allim_cellphone').innerText = phone_edit(localStorage.getItem('customer_select'));
                                document.getElementById('allim_cellphone_val').value = localStorage.getItem('customer_select');
                                document.getElementById('user_table').innerHTML = `<div class="customer-user-table-row">
                                                                        <div class="customer-user-table-title">
                                                                            <div class="table-title">대표 펫</div>
                                                                        </div>
                                                                        <div class="customer-user-table-data">
                                                                            <div class="table-data">
                                                                                <div class="table-user-name">
                                                                                    ${body[0].name}
                                                                                    <div class="user-grade-item">
                                                                                        <div class="icon" id="customer_grade_icon"></div>
                                                                                        <div class="icon-grade-label" id="customer_grade_value"></div>
                                                                                        <button type="button" class="btn-data-modify" onclick="pop.open('memberGradeAddPop')">편집</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="customer-user-info-ui">
                                                                            ${parseInt(localStorage.getItem('noshow_cnt')) > 0 ? `<div class="label label-outline-pink">NO SHOW ${localStorage.getItem('noshow_cnt')}회</div>
                                                                            <button type="button" class="btn btn-red" id="noshow_initialize_btn">초기화</button>` : ''}
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="customer-user-table-row">
                                                                        <div class="customer-user-table-title">
                                                                            <div class="table-title">최근이용내역</div>
                                                                        </div>
                                                                        <div class="customer-user-table-data">
                                                                            <div class="table-data">
                                                                                <div class="table-data-txt">${body_.length === (undefined || 0) ? '' : body_[0].product.split('|')[3]   }</div>
                                                                            </div>
                                                                            <div class="table-data-side">
                                                                                <button type="button" class="font-color-purple font-underline btn-text" onclick="open_customer_allim('${localStorage.getItem('customer_select')}');">알림톡 발송 조회
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
                                                                                        <div class="value" id="representative_cellphone"></div>
                                                                                        <button type="button" class="btn-data-modify" onclick="pop.open('numberAddPop')">편집</button>
                                                                                    </div>
                                                                                    <div class="item-sub-phone" id="sub_cellphone">
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
                                                                                    <textarea style="height:60px;" id="customer_memo" placeholder="입력"></textarea>
                                                                                    <div class="form-input-info">*메모는 입력 후 자동 저장됩니다.</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>`

                                body.forEach(function(el,i){

                                    document.getElementById('pet_table').innerHTML += `<div class="grid-layout-cell flex-auto">
                                                                                                    <label class="form-toggle-box" for="pet_list_${i}">
                                                                                                        <input type="radio" name="pet_list" data-pet_name="${el.name}" class="btn-toggle-button pet-list-btn" data-pet_seq="${el.pet_seq}" id="pet_list_${i}">
                                                                                                        <em>${el.name}</em>
                                                                                                    </label>
                                                                                                </div>`
                                })

                                    document.getElementById('pet_table').innerHTML += `<div class="grid-layout-cell flex-auto" onClick="pop.open('petAddPop')">
                                                                                                    <button type="button" class="btn-toggle-button btn-toggle-basic">
                                                                                                        <span class="icon icon-plus-more-small"></span>
                                                                                                    </button>
                                                                                                </div>`



                                if(body_.length > 0) {
////console.log(body_);

                                    body_.forEach(function (el, i) {
                                        var is_cancel = (el.is_cancel != 0 || el.is_no_show != 0)? 'style="color: red;"' : '';
                                        document.getElementById('usage_history_list').innerHTML += `<tr class="customer-table-cell gallery-check" data-payment_idx="${el.payment_log_seq}" data-pet_seq="${el.pet_seq}" onclick="if(document.getElementById('customer_table_view_${i}').classList.contains('actived')){document.getElementById('customer_table_view_${i}').classList.remove('actived')}else{document.getElementById('customer_table_view_${i}').classList.add('actived')}; if(document.getElementById('customer_table_cell_${i}').classList.contains('actived')){document.getElementById('customer_table_cell_${i}').classList.remove('actived')}else{document.getElementById('customer_table_cell_${i}').classList.add('actived')}">
                                                                                                    <td>
                                                                                                        <!-- customer-table-toggle 클래스에 actived클래스 추가시 활성화 -->
                                                                                                        <button type="button" class="customer-table-toggle type-2 actived" id="customer_table_cell_${i}">
                                                                                                            <span class="toggle-title" ${is_cancel}><span class="ellipsis">${el?.product.split('|')[0]}</span></span>
                                                                                                        </button>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="customer-table-txt">${el.year}.${fill_zero(el.month)}.${fill_zero(el.day)}</div>
                                                                                                        <div class="customer-table-txt">${am_pm_check(el.hour)}:${fill_zero(el.minute)}</div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="customer-table-txt" style="font-size:10px;">${el?.product.split('|')[3]}</div>
                                                                                                        <div class="customer-table-txt" style="font-size:10px;">${el?.product.split('|')[4]}</div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="customer-table-txt" style="font-size:10px;">${el.local_price === "" ? '0' : el.local_price}원</div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <div class="customer-table-txt" style="font-size:10px;">${el.local_price_cash === "" ? '0' : el.local_price_cash}원</div>
                                                                                                    </td>
                                                                                                </tr>
                                                                                                <!-- actived클래스 추가시 활성화 -->
                                                                                                <tr class="customer-table-view" id="customer_table_view_${i}">
                                                                                                    <td colSpan="5">
                                                                                                        <div class="flex-table">
                                                                                                            <div class="flex-table-cell">
                                                                                                                <div class="flex-table-item">
                                                                                                                    <div class="flex-table-title">
                                                                                                                        <div class="txt">예약일시</div>
                                                                                                                    </div>
                                                                                                                    <div class="flex-table-data">
                                                                                                                        <div class="flex-table-data-inner">
                                                                                                                            ${el.buy_time.substr(0, 4)}.${el.buy_time.substr(4, 2)}.${el.buy_time.substr(6, 2)} ${el.buy_time.substr(8, 2)}:${el.buy_time.substr(10, 2)}:${el.buy_time.substr(12, 2)}
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="flex-table-cell">
                                                                                                                <div class="flex-table-item">
                                                                                                                    <div class="flex-table-title">
                                                                                                                        <div class="txt">미용사</div>
                                                                                                                    </div>
                                                                                                                    <div class="flex-table-data">
                                                                                                                        <div class="flex-table-data-inner">
                                                                                                                            ${(el.worker == artist_id)? '실장' : el.worker}
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="flex-table-cell">
                                                                                                                <div class="flex-table-item">
                                                                                                                    <div class="flex-table-title">
                                                                                                                        <div class="txt">추가</div>
                                                                                                                    </div>
                                                                                                                    <div class="flex-table-data">
                                                                                                                        <div class="flex-table-data-inner">
                                                                                                                            ${el.product.split('|')[6].split(':')[0]}
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="flex-table-cell">
                                                                                                                <div class="flex-table-item">
                                                                                                                    <div class="flex-table-title">
                                                                                                                        <div class="txt">취소일시</div>
                                                                                                                    </div>
                                                                                                                    <div class="flex-table-data">
                                                                                                                        <div class="flex-table-data-inner">
                                                                                                                            ${el.is_cancel === 1 ? el.cancel_time.substr(0, 4)+'.'+el.cancel_time.substr(4, 2)+'.'+el.cancel_time.substr(6, 2)+' '+el.cancel_time.substr(8, 2)+':'+el.cancel_time.substr(10, 2) : 'X'}
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="flex-table-cell">
                                                                                                                <div class="flex-table-item">
                                                                                                                    <div class="flex-table-title">
                                                                                                                        <div class="txt">적립금</div>
                                                                                                                    </div>
                                                                                                                    <div class="flex-table-data">
                                                                                                                        <div class="flex-table-data-inner">
                                                                                                                            사용:0 누적:0
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="flex-table-cell">
                                                                                                                <div class="flex-table-item">
                                                                                                                    <div class="flex-table-title">
                                                                                                                        <div class="txt">결제방식</div>
                                                                                                                    </div>
                                                                                                                    <div class="flex-table-data">
                                                                                                                        <div class="flex-table-data-inner">
                                                                                                                            ${el.pay_type === 'pos-card' ? '카드' : '현금'}
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                </tr>`
                                    })
                                }



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

        document.getElementById('customer_cellphone').value = localStorage.getItem('customer_select');
        pet_reserve_info(body_data)
        noshow_initialize(id,body_data);
        insert_customer_grade(id,body_data);
        insert_customer_memo(id,body_data);
        //insert_customer_special(id);



        $(document).ready(function(){

            document.querySelector('.pet-list-btn').click();
        })


        sub_phone_pop_init(id,false,'');





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

                    ////console.log(body)
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

                
            }
        })

    })
}

function customer_delete(id){

    let cellphone = localStorage.getItem('customer_select');

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'customer_delete',
            partner_id:id,
            cellphone:cellphone
        },
        success:function(res){
            document.getElementById('msg3_txt').innerText = '삭제되었습니다.'
            pop.open('reserveAcceptMsg3');
        }

    })

}

function pet_delete(id){

    var idx = $('input[name=pet_list]:checked').data("pet_seq");
    var pet_cnt = $(".pet-list-btn").length;

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'pet_delete',
            partner_id:id,
            idx:idx
        },
        success:function(res){
            if(pet_cnt == '1'){
                pop.close();
                document.getElementById('msg3_txt').innerText = '삭제되었습니다.'
                pop.open('reserveAcceptMsg3');
            }else{
                pop.close();
                pop.open('reloadPop','삭제되었습니다.');
            }

        }

    })

}

function pet_reserve_info(data){

    //console.log(data)


        let pet_list = data[0];
        let payment_idx_list = '';


        Array.from(document.getElementsByClassName('pet-list-btn')).forEach(function(el){

            el.addEventListener('click',function(){
                document.getElementById('beauty_gal_wrap').innerHTML ='';


                Array.from(document.getElementsByClassName('gallery-check')).forEach(function(el_){

                    if(el.getAttribute('data-pet_seq') === el_.getAttribute('data-pet_seq')){

                        payment_idx_list += `${el_.getAttribute('data-payment_idx')}|`

                            el.setAttribute('data-payment_idx',payment_idx_list)



                    }

                })

                payment_idx_list ='';
                customer_beauty_gallery()






                pet_list.forEach(function(el_){
                    if(parseInt(el.getAttribute('data-pet_seq'))  === el_.pet_seq){

                        ////console.log(el_)

                        let time = new Date(el_.detail.year,el_.detail.month+1,el_.detail.day).getTime()
                        let now = new Date().getTime();

                        let subtract_year= Math.floor((now-time)/1000/60/60/24/30/11);
                        let subtract_month = Math.floor((now-time)/1000/60/60/24/30%11) ;



                        insert_customer_special(artist_id, el_.pet_seq);

                        document.getElementById('target_pet_name').innerText = el_.name;
                        document.getElementById('target_pet_type').innerText = el_.detail.pet_type;
                        document.getElementById('target_pet_gender').innerText = el_.detail.gender;
                        document.getElementById('target_pet_weight').innerText = `${el_.detail.weight}kg`;

                        document.getElementById('target_pet_birthday').innerText = `${el_.detail.year}.${fill_zero(el_.detail.month)}.${fill_zero(el_.detail.day)}(${subtract_year}년 ${subtract_month}개월)`

                        document.getElementById('target_pet_neutral').innerText = `${el_.detail.neutral === 0 ? 'X' : 'O'}`;
                        document.getElementById('target_pet_beauty_exp').innerText = `${el_.detail.beauty_exp}`;
                        document.getElementById('target_pet_vaccination').innerText = `${el_.detail.vaccination}`;
                        document.getElementById('target_pet_bite').innerText = `${el_.detail.bite === '해요' || el_.detail.bite === '1' ? '해요' : '안해요'}`;
                        document.getElementById('target_pet_luxation').innerText = `${el_.detail.luxation}`;
                        document.getElementById('target_pet_special').innerText = `${el_.detail.dermatosis ? '피부병' : ''} ${el_.detail.heart_trouble ? '심장 질환' : ''} ${el_.detail.marking ? '마킹': ''} ${el_.detail.mounting ? '마운팅' : ''}`;
                        document.getElementById('target_pet_disliked').innerText = `${el_.detail.dt_body ? '몸':''} ${el_.detail.dt_ear ? '귀':''} ${el_.detail.dt_eye ? '눈':''} ${el_.detail.dt_genitilia ? '생식기':''} ${el_.dt_leg ? '다리':''} ${el_.detail.dt_mouth ? '입' : ''} ${el_.detail.dt_neck ? '목':''} ${el_.detail.dt_nose ? '코':''} ${el_.detail.dt_tail ? '꼬리' : ''}`;

                        document.getElementById('modify_pet').setAttribute('data-pet_seq',`${el_.detail.pet_seq}`)
                        document.getElementById('modify_pet').setAttribute('onclick',`customer_modify_pet(${document.getElementById('modify_pet').getAttribute('data-pet_seq')}).then(function(body){ customer_modify_pet_(body)});`)

                        document.getElementById('target_pet_etc').innerText = `${el_.detail.etc}`;


                        if(el_.detail.photo === ''){
                            document.getElementById('target_pet_img').removeAttribute('onclick');


                            if(el_.detail.type === 'dog'){

                                document.getElementById('target_pet_img').setAttribute('src','/static/images/icon/icon-pup-select-off.png');


                            }else{
                                document.getElementById('target_pet_img').setAttribute('src','/static/images/icon/icon-cat-select-off.png');


                            }

                        }else{

                            document.getElementById('target_pet_img').setAttribute('src',img_link_change(el_.detail.photo));
                            document.getElementById('target_pet_img').setAttribute('onclick',`thumb_view(this,\`${el_.detail.photo}\`)`);

                        }



                        agree_birthday().then(function(){ agree_birthday_date()})
                        agree_pet_type(artist_id);


                        setTimeout(function (){
                            customer_beauty_agree(artist_id,el_).then(function(data_){

                                customer_beauty_agree_(data_);
                            });


                        },50)

                        document.getElementById('direct_reserve_btn').setAttribute('data-pet_seq',el_.detail.pet_seq)



                   }

                })


            })
        })

}

function noshow_initialize(id,data){


    if(document.getElementById('noshow_initialize_btn')){


        document.getElementById('noshow_initialize_btn').addEventListener('click',function(){


            $.ajax({

                url:'/data/pc_ajax.php',
                type:'post',
                data:{
                    mode:'cancel_noshow',
                    partner_id:id,
                    payment_idx:0,
                    cellphone:localStorage.getItem('customer_select')

                },
                success:function (res){


                    localStorage.removeItem('noshow_cnt');
                    document.getElementById('msg2_txt').innerText = '노쇼가 초기화 되었습니다.'
                    pop.open('reserveAcceptMsg2');
                    return;
                }
            })
        })
    }

}


function insert_customer_memo(id,data){


    // let customer_id = data[0][0].customer_id;
    // let tmp_seq = data[0][0].tmp_seq;
    let cellphone = localStorage.getItem('customer_select');
//console.log(id,customer_id,tmp_seq,cellphone);
    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'get_customer_memo',
            login_id:id,
            customer_id:customer_id,
            tmp_seq:tmp_seq,
            cellphone:cellphone
        },
        success:function (res){
            let response = JSON.parse(res);
            //console.log(response);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

//console.log(body);
                document.getElementById('customer_memo').innerText = body.memo;

                // document.getElementById('customer_memo').addEventListener('keyup',function(){
                //
                //     $.ajax({
                //
                //         url:'/data/pc_ajax.php',
                //         type:'post',
                //         data:{
                //             mode:'put_customer_memo',
                //             idx:body.scm_seq,
                //             memo:document.getElementById('customer_memo').value,
                //         },
                //         success:function (res){
                //
                //         }
                //     })
                //
                // })

            }

        }

    })



}

function insert_customer_grade(id,data){


    //console.log(data);
    customer_id = data[0][0].detail.customer_id !== "" ? data[0][0].detail.customer_id : '';
    tmp_seq = data[0][0].detail.tmp_seq !== "" ? data[0][0].detail.tmp_seq : '';
    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'get_customer_grade',
            partner_id:id,
            cellphone:localStorage.getItem('customer_select'),

        },success:function (res){
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {


                let grade= '';
                switch(body.grade_ord){

                    case 1: grade = 'vip'; break;
                    case 2: grade = 'normal'; break;
                    case 3: grade = 'normalb'; break;
                }


                document.getElementById('customer_grade_icon').classList.add(`icon-grade-${grade}`);
                document.getElementById('customer_grade_value').innerText= body.grade_name;

                document.getElementById('memberGrageMsg').innerText = `현재 ${data[0][0].name} (${phone_edit(localStorage.getItem('customer_select'))}) 고객님의 등급은 ${body.grade_name} 입니다.`


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
                        let body_ = response.data.body;
                        if (head.code === 401) {
                            pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                        } else if (head.code === 200) {
                            //console.log(body);

                            body_.forEach(function(el){

                                if(el.is_delete !== 1){


                                    document.getElementById('memberGradeSelect').innerHTML += `<option data-ord="${el.grade_ord}" value="${el.idx}">${el.grade_name}</option>`



                                }
                            })

                            document.getElementById('set_grade_btn').addEventListener('click',function(){


                                set_grade(body,customer_id);
                            })
                        }
                    }

                })
            }

        }

    })
}


function set_grade(data,customer_id){

    let customer_idx;
    if(typeof data === 'object'){
        customer_idx = data.customer_idx;
    }else{
        customer_idx = data;
    }


    let grade_idx = document.getElementById('memberGradeSelect').value;




    if(customer_idx >0){


        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:"put_customer_grade_1",
                customer_idx:customer_idx,
                grade_idx:grade_idx
            },
            success:function(res) {
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {

                    document.getElementById('msg2_txt').innerText = '변경되었습니다.'
                    pop.open('reserveAcceptMsg2');

                }


            }

        })

    }else{

        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{

                mode:"put_customer_grade_2",
                grade_idx:grade_idx,
                customer_id:customer_id,

            },
            success:function(res) {
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {

                    document.getElementById('msg2_txt').innerText = '변경되었습니다.'
                    pop.open('reserveAcceptMsg2');

                }
            }
        })

    }
}

function insert_customer_special(id, seq){


    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'get_customer_special',
            partner_id:id,
            pet_seq:seq
        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                if(body.length === undefined){

                    body = [body];
                }

                document.getElementById('special_note').innerHTML = '';
                body.forEach(function(el){

                    document.getElementById('special_note').innerHTML +=`<div class="grid-layout-cell grid-2 note-toggle-cell">
                                                                                        <div class="special-note">
                                                                                            <div class="note-desc"><em>${(el.recent != '')? el.recent : '신규등록'}</em>
                                                                                                <div class="txt">${el.etc_memo}
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>`

                })

            }
        }
    })

}

function customer_beauty_agree(id,el){

    return new Promise(function(resolve){
        //console.log(el)

        let pet_seq = el.detail.pet_seq;

        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:'get_beauty_agree',
                partner_id:id,
                pet_idx:pet_seq
            },
            success:function(res) {
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {
                    //console.log(body)

                    if(body.length ===0){

                        document.getElementById('beauty_agree_title').innerText ='미용 동의서 작성';
                        document.getElementById('agree_name').value = '';
                        document.getElementById('beauty_agree_view').innerHTML =  `<button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline" id="beauty_agree_btn">미용 동의서 작성</button>`

                        document.getElementById('beauty_agree_btn').addEventListener('click',function(){

                            document.getElementById('agree_pet_name').value = document.querySelector('input[name="pet_list"]:checked').getAttribute('data-pet_name');
                            document.getElementById('cview').style.display = 'block';
                            document.getElementById('sign_img').style.display = 'none';
                            pop.open('beautyAgreeWritePop')
                        })
                        document.getElementById('beauty_agree_all_btn').removeAttribute('checked');
                        document.getElementById('beauty_agree_1_btn').removeAttribute('checked');
                        document.getElementById('beauty_agree_2_btn').removeAttribute('checked');
                        document.getElementById('agree_cellphone').value = localStorage.getItem('customer_select');
                        //console.log(el.detail.type);
                        if(el.detail.type==='dog'){

                            document.getElementById('agree_breed1').click();
                        }else{

                            document.getElementById('agree_breed2').click();
                        }

                        document.getElementById('beauty_agree_footer').innerHTML =`<a href="#" class="btn-page-bottom" onClick="beauty_agree_submit(artist_id,${
                            
                            pet_seq})">저장</a>`

                        //
                        // document.getElementById('user_sign_wrap').innerHTML = `<canvas id="cview2"></canvas>`
                        // let wrapper = document.getElementById('signature_pad');
                        // let clear_btn = document.getElementById('signature_clear');
                        //
                        // let canvas = document.getElementById('cview2');
                        //
                        // let signature_pad = new SignaturePad(canvas,{
                        //
                        //     backgroundColor:'rgb(255,255,255)'
                        // })
                        //
                        // canvas.width = canvas.parentElement.offsetWidth-2;
                        // canvas.height=canvas.parentElement.offsetHeight-2;
                        //
                        //
                        // clear_btn.addEventListener("click", function (event) {
                        //     signature_pad.clear();
                        // });




                        resolve(el)


                    }else{

                        document.getElementById('beauty_agree_view').innerHTML = `<button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline" id="beauty_agree_view_btn">미용 동의서 보기</button>`


                        setTimeout(function(){
                            document.getElementById('beauty_agree_view_btn').addEventListener('click',function(){



                                    document.getElementById('beauty_agree_title').innerText ='미용 동의서 보기';
                                    document.getElementById('agree_name').value = body.customer_name;
                                document.getElementById('agree_cellphone').value = localStorage.getItem('customer_select');
                                if(el.detail.type==='dog'){

                                    document.getElementById('agree_breed1').click();
                                }else{

                                    document.getElementById('agree_breed2').click();
                                }
                                resolve(el);
                                    document.getElementById('agree_name2').innerText = body.customer_name;

                                    document.getElementById('beauty_agree_all_btn').setAttribute('checked',true);
                                    document.getElementById('beauty_agree_1_btn').setAttribute('checked',true);
                                    document.getElementById('beauty_agree_2_btn').setAttribute('checked',true);
                                    document.getElementById('agree_date').innerText= `${body.reg_date.substr(0,4)}.${body.reg_date.substr(4,2)}.${body.reg_date.substr(6,2)}`
                                    // document.getElementById('signature_clear').remove();
                                    document.getElementById('cview').style.display = 'none';
                                    document.getElementById('sign_img').style.display = 'block';
                                    document.getElementById('sign_img').setAttribute('src',img_link_change(body.image));

                                pop.open('beautyAgreeWritePop');

                                    setTimeout(function(){
                                        document.getElementById('beauty_agree_footer').innerHTML = '';

                                    },100)





                            });

                        },50)

                    }


                }
            }

        })
    })

}

function customer_beauty_agree_(_data){


    //console.log(_data)
    document.getElementById('agree_date').innerText = `${new Date().getFullYear()}.${fill_zero(new Date().getMonth()+1)}.${fill_zero(new Date().getDate())}`
    document.getElementById('agree_name').addEventListener('change',function(){

        document.getElementById('agree_name2').innerText = document.getElementById('agree_name').value;
    })
    document.getElementById('agree_info').innerText = `${data.shop_name}은(는) 미용요청견(묘)의 나이가 10세 이상인 노령견(묘)이나, 질병이 있는 경우 건강상태를 고려하여 안내사항을 말씀드리고, 미용 동의서를 받고자 합니다.`

    setTimeout(function (){

        for(let i=0; i<document.getElementById('agree_breed_select').options.length; i++){

            if(document.getElementById('agree_breed_select').options[i].value === _data.detail.pet_type){

                document.getElementById('agree_breed_select').options[i].selected = true;
            }
        }
    },500)


    if(_data.detail.gender === '남아'){

        document.getElementById('agree_gender1').click()
    }else{

        document.getElementById('agree_gender2').click()
    }


    if(_data.detail.neutral === 0){

        document.getElementById('agree_neutralize1').checked = true;
    }else{

        document.getElementById('agree_neutralize2').checked=true;
    }

    for(let i=0; i<document.getElementById('agree_birthday_year').options.length; i++){

        if(document.getElementById('agree_birthday_year').options[i].value == _data.detail.year){

            document.getElementById('agree_birthday_year').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('agree_birthday_month').options.length; i++){

        if(document.getElementById('agree_birthday_month').options[i].value == fill_zero(_data.detail.month)){

            document.getElementById('agree_birthday_month').options[i].selected = true;
        }
    }    for(let i=0; i<document.getElementById('agree_birthday_date').options.length; i++){

        if(document.getElementById('agree_birthday_date').options[i].value === fill_zero(_data.detail.day)){

            document.getElementById('agree_birthday_date').options[i].selected = true;
        }
    }


    for(let i=0; i<document.getElementById('agree_vaccination').options.length; i++){

        if(document.getElementById('agree_vaccination').options[i].value === _data.detail.vaccination){

            document.getElementById('agree_vaccination').options[i].selected = true;
        }
    }

    if(_data.detail.heart_trouble === 1){

        document.getElementById('disease2').checked = true;
    }

    if(_data.detail.dermatosis === 1){

        document.getElementById('disease3').checked =true;
    }

    if(_data.detail.bite == 1 || _data.detail.bite === "해요"){

        document.getElementById('agree_special1').checked =true;
    }

    if(_data.detail.marking === 1){

        document.getElementById('agree_special2').checked = true;
    }

    if(_data.detail.mounting === 1){

        document.getElementById('agree_special3').checked = true;
    }

    for (let i =0; i<document.getElementById('agree_luxation').options.length; i++){

        if(document.getElementById('agree_luxation').options[i].value === _data.detail.luxation){

            document.getElementById('agree_luxation').options[i].selected = true;
        }
    }








}


function sub_phone_pop_init(id,bool,cellphone){

    let cell_phone;


    if(bool){
        cell_phone = cellphone;
    }else{
        cell_phone = localStorage.getItem('customer_select')
    }
    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'get_sub_phone',
            partner_id:id,
            cellphone:cell_phone
        },
        success:function(res) {

            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                //console.log(body)




                if(body.length === undefined){

                    body = [body];
                }

                if(body.length === 0){
                    if(!bool){
                        document.getElementById('representative_cellphone').innerText = localStorage.getItem('customer_select');

                    }



                    document.getElementById('phone_add_list').innerHTML += `<div class="phone-add-input">
                                                                                        <div class="form-group">
                                                                                            <div class="form-group-cell">
                                                                                                <div class="form-group-item">
                                                                                                    <div class="form-item-label">등록이름</div>
                                                                                                    <div class="form-item-data type-6">
                                                                                                        <input type="text" class="" placeholder="입력" id="add_sub_cellphone_1" ${body.length >2 ? 'disabled':''} >
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group-cell">
                                                                                                <div class="form-group-item">
                                                                                                    <div class="form-item-label">전화번호</div>
                                                                                                    <div class="form-item-data type-6">
                                                                                                        <input type="text" class="" placeholder="'-' 제외하고 입력" id="add_sub_cellphone_2" ${body.length >2 ? 'disabled':''}>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-input-info">*보조연락처는 3개까지 등록 가능합니다.</div>`


                    return;

                }

                if(!bool){

                    document.getElementById('representative_cellphone').innerText = body[0].to_cellphone;

                }

                body.forEach(function(el,i){

                    //console.log(el)

                    if(!bool){
                        if(i <3){


                            document.getElementById('sub_cellphone').innerHTML += `<div class="value">${el.from_cellphone}</div>`
                        }
                        if(i === 3){
                            document.getElementById('sub_cellphone').innerHTML += `<div class="value">외 ${body.length-3}개 연락처</div>`
                        }
                    }



                    document.getElementById('phone_add_list').innerHTML += `<div class="phone-add-item">
                                                                                                                        <div class="item-check representative" style="display: none;"><label for="phone${i}" class="form-radiobox"><input type="radio" id="phone${i}" name="phone" data-idx="${el.client_id}" data-nick="${el.from_nickname}" data-cellphone="${el.from_cellphone}" data-to_cellphone ="${el.to_cellphone}" onclick="representative(this,artist_id)"><span class="form-check-icon"><em>대표</em></span></label></div>
                                                                                        <div class="item-data">
                                                                                            <div class="phone-add-item-value">
                                                                                                <div class="phone-add-name">
                                                                                                    <div class="ellipsis">${el.from_nickname}</div>
                                                                                                </div>
                                                                                                <div class="phone-add-num">
                                                                                                    <div class="ellipsis">${el.from_cellphone}</div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="item-ui">
                                                                                            <button type="button" class="btn-phone-del" onclick="document.getElementById('msg4_txt').innerText = '해당 연락처를 삭제하시겠습니까?' ;pop.open('reserveAcceptMsg4'); document.getElementById('reserveAcceptMsg4').setAttribute('data-seq',\'${el.family_seq}\')"><span
                                                                                                class="icon icon-phone-add-del"></span></button>
                                                                                        </div>
                                                                                    </div>`
                })


                document.getElementById('phone_add_list').innerHTML += `<div class="phone-add-input">
                                                                                        <div class="form-group">
                                                                                            <div class="form-group-cell">
                                                                                                <div class="form-group-item">
                                                                                                    <div class="form-item-label">등록이름</div>
                                                                                                    <div class="form-item-data type-6">
                                                                                                        <input type="text" class="" placeholder="입력" id="add_sub_cellphone_1" ${body.length >2 ? 'disabled':''} >
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group-cell">
                                                                                                <div class="form-group-item">
                                                                                                    <div class="form-item-label">전화번호</div>
                                                                                                    <div class="form-item-data type-6">
                                                                                                        <input type="text" class="" placeholder="'-' 제외하고 입력" id="add_sub_cellphone_2" ${body.length >2 ? 'disabled':''}>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-input-info">*보조연락처는 3개까지 등록 가능합니다.</div>`


                setInputFilter(document.getElementById("add_sub_cellphone_2"), function(value) {
                    return /^\d*\.?\d*$/.test(value);
                })

                if(!body[0].client_id.match('@')){
                    Array.from(document.getElementsByClassName('representative')).forEach(function(el){

                        el.style.display = 'block';
                    })
                }
            }

        }

    })

}

function delete_sub_phone(){

    let seq = document.getElementById('reserveAcceptMsg4').getAttribute('data-seq');


    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'delete_sub_phone',
            sub_phone_idx:seq,
        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                //console.log(body);

                document.getElementById('msg2_txt').innerText = '삭제되었습니다.'
                pop.open('reserveAcceptMsg2');
                return;
            }
        }

    })
}

function add_sub_phone(id,bool){
    let main_phone;
    if(bool){

        main_phone = document.getElementById('pay_main_phone').innerText;

    }else{
        main_phone = localStorage.getItem('customer_select');
    }



    let sub_name = document.getElementById('add_sub_cellphone_1').value;
    let sub_phone = document.getElementById('add_sub_cellphone_2').value;

    $.ajax({

        url: '/data/pc_ajax.php',
        type: 'post',
        data: {
            mode:'add_sub_phone',
            partner_id: id,
            main_phone: main_phone,
            sub_name: sub_name,
            sub_phone: sub_phone,
        },
        success: function (res) {
            ;
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                //console.log(body)

                if(body.err === 0){
                    document.getElementById('msg2_txt').innerText = '등록되었습니다.'
                    pop.open('reserveAcceptMsg2');
                    return;
                }else if(body.err === 906){
                    document.getElementById('msg1_txt').innerText = '이미 등록된 번호입니다.'
                    pop.open('reserveAcceptMsg1');
                    return;
                }


            }

        }
    })



}

function representative(target,id){

    //console.log(target);

    let nick = target.getAttribute('data-nick');
    let old_phone = target.getAttribute('data-to_cellphone');
    let new_phone = target.getAttribute('data-cellphone');
    let client_id = target.getAttribute('data-idx').match('신규등록') ? target.getAttribute('data-idx').split('(')[1].replace(')','') : target.getAttribute('data-idx');

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'post_representative',
            partner_id:id,
            tmp_user_idx: client_id,
            old_phone:old_phone,
            new_phone:new_phone,

        },
        success: function (res) {

                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {

                    if(body.err ===0){
                        document.getElementById('msg3_txt').innerText = '대표 번호가 변경되었습니다.'
                        pop.open('reserveAcceptMsg3');
                        return;

                    }else{
                        document.getElementById('msg3_txt').innerText = '잠시 후 다시 시도 해주세요.'
                        pop.open('reserveAcceptMsg3');
                        return;
                    }
                }


            }
        })





}


function customer_modify_pet(pet_seq){


    return new Promise(function (resolve){



        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{

                mode:'pet_info',
                pet_seq:pet_seq
            },
            success:function(res) {
                
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {

                    //console.log(body)
                    document.getElementById('modify_customer_name').value = body.name;

                    if(body.type === 'dog'){


                        document.getElementById('modify_customer_breed1').click();
                    }else{
                        document.getElementById('modify_customer_breed2').click();

                    }

                    setTimeout(function(){

                        resolve(body);
                    },300)




                }
            }
        })

    })



}
function customer_modify_pet_(body){


    //console.log(body);


    for(let i=0; i<document.getElementById('modify_customer_breed_select').options.length; i++){

        if(document.getElementById('modify_customer_breed_select').options[i].value === body.pet_type){

            document.getElementById('modify_customer_breed_select').options[i].selected = true;
        }
    }
    for(let i=0; i<document.getElementById('modify_customer_birthday_year').options.length; i++){

        if(document.getElementById('modify_customer_birthday_year').options[i].value === body.year.toString()){

            document.getElementById('modify_customer_birthday_year').options[i].selected = true;
        }
    }
    for(let i=0; i<document.getElementById('modify_customer_birthday_month').options.length; i++){

        if(document.getElementById('modify_customer_birthday_month').options[i].value === fill_zero(body.month)){

            document.getElementById('modify_customer_birthday_month').options[i].selected = true;
        }
    }
    for(let i=0; i<document.getElementById('modify_customer_birthday_date').options.length; i++){

        if(document.getElementById('modify_customer_birthday_date').options[i].value === fill_zero(body.day)){

            document.getElementById('modify_customer_birthday_date').options[i].selected = true;
        }
    }

    if(body.gender === '남아'){

        document.getElementById('modify_customer_gender1').checked = true;
    }else{
        document.getElementById('modify_customer_gender2').checked = true;

    }

    if(body.neutral === 0){

        document.getElementById('modify_customer_neutralize1').checked = true;
    }else{

        document.getElementById('modify_customer_neutralize2').checked = true;

    }


    for(let i=0; i<document.getElementById('modify_customer_weight1').options.length; i++){

        if(document.getElementById('modify_customer_weight1').options[i].value === body.weight.split('.')[0]){


            document.getElementById('modify_customer_weight1').options[i].selected = true;
        }
    }


    for(let i=0; i<document.getElementById('modify_customer_weight2').options.length; i++){

        if(document.getElementById('modify_customer_weight2').options[i].value === body.weight.split('.')[1]){


            document.getElementById('modify_customer_weight2').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('modify_customer_beauty_exp').options.length; i++){

        if(document.getElementById('modify_customer_beauty_exp').options[i].value === body.beauty_exp){

            document.getElementById('modify_customer_beauty_exp').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('modify_customer_vaccination').options.length; i++){

        if(document.getElementById('modify_customer_vaccination').options[i].value === body.vaccination){

            document.getElementById('modify_customer_vaccination').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('modify_customer_bite').options.length; i++){

        if(document.getElementById('modify_customer_bite').options[i].value === body.bite){

            document.getElementById('modify_customer_bite').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('modify_customer_luxation').options.length; i++){

        if(document.getElementById('modify_customer_luxation').options[i].value === body.luxation){

            document.getElementById('modify_customer_luxation').options[i].selected = true;
        }
    }

    if(body.dermatosis === 1){

        document.getElementById('modify_customer_special1').checked = true;

    }

    if(body.heart_trouble === 1){

        document.getElementById('modify_customer_special2').checked = true;
    }

    if(body.marking === 1){

        document.getElementById('modify_customer_special3').checked = true;
    }

    if(body.mounting === 1){

        document.getElementById('modify_customer_special4').checked = true;
    }

    document.getElementById('modify_pet_info_btn').addEventListener('click',function(){


        customer_modify_pet_info(body)
    },{once:true})

    pop.open('petModifyPop');
}

function customer_modify_pet_info(body){

    if(document.getElementById('modify_customer_name').value === '' || document.getElementById('modify_customer_name').value === null || document.getElementById('modify_customer_name').value === undefined ){

        document.getElementById('msg1_txt').innerText = '펫 이름을 입력해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }



    if(document.querySelector('input[name="modify_customer_breed"]:checked') === null || document.querySelector('input[name="modify_customer_breed"]:checked') === undefined || document.querySelector('input[name="modify_customer_breed"]:checked') === ''){

        document.getElementById('msg1_txt').innerText = '품종을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }

    if(document.getElementById('modify_customer_breed_select').value === "선택" || document.getElementById('modify_customer_breed_select').value === ''){
        document.getElementById('msg1_txt').innerText = '품종을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;

    }
    if((document.getElementById('modify_customer_breed_select').value === "기타" || document.getElementById('modify_customer_breed_select').value === "") && document.getElementById('modify_customer_breed_other').value === ''){
        document.getElementById('msg1_txt').innerText = '품종을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;

    }

    if(document.getElementById('modify_customer_weight1').value === "0" && document.getElementById('modify_customer_weight2').value ==="0"){

        document.getElementById('msg1_txt').innerText = '몸무게를 입력해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }


    let breed = document.getElementById('modify_customer_breed_select').value === '기타' ? document.getElementById('modify_customer_breed_other').value : document.getElementById('modify_customer_breed_select').value;

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:"modify_pet_info",
            idx:body.pet_seq,
            name:document.getElementById('modify_customer_name').value,
            type:document.querySelector('input[name="modify_customer_breed"]:checked').value,
            pet_type:breed,
            year:document.getElementById('modify_customer_birthday_year').value,
            month:document.getElementById('modify_customer_birthday_month').value,
            day:document.getElementById('modify_customer_birthday_date').value,
            gender:document.querySelector('input[name="modify_customer_gender"]:checked') === null ? '0' : document.querySelector('input[name="modify_customer_gender"]:checked').value,
            neutral:document.querySelector('input[name="modify_customer_neutralize"]:checked') === null ? '0' : document.querySelector('input[name="modify_customer_neutralize"]:checked').value,
            weight:`${document.getElementById('modify_customer_weight1').value}.${document.getElementById('modify_customer_weight2').value}`,
            beauty_exp : document.getElementById('modify_customer_beauty_exp').value,
            vaccination : document.getElementById('modify_customer_vaccination').value,
            luxation : document.getElementById('modify_customer_luxation').value,
            bite : document.getElementById('modify_customer_bite').value,
            dermatosis:document.getElementById('modify_customer_special1').checked === true ? 1:0,
            heart_trouble:document.getElementById('modify_customer_special2').checked === true ? 1:0,
            marking:document.getElementById('modify_customer_special3').checked === true ? 1:0,
            mounting:document.getElementById('modify_customer_special4').checked === true ? 1:0,
            etc:"",





        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                document.getElementById('msg2_txt').innerText = '펫 정보가 변경되었습니다.'
                pop.open('reserveAcceptMsg2');

            }
        }

    })
}

function direct_reserve(target){


    sessionStorage.setItem('direct','1');
    sessionStorage.setItem('direct_pet_seq',`${target.getAttribute('data-pet_seq')}`)
    sessionStorage.setItem('direct_cellphone',`${document.getElementById('representative_cellphone').innerText}`)

    location.href='/booking/reserve_beauty_week.php'


}

function direct_event(id,session_id){

    if(sessionStorage.getItem('direct') === '1'){

        Array.from(document.getElementsByClassName('btn-calendar-add')).forEach(function(el){

            el.removeAttribute('onclick');
            el.setAttribute('onclick',`direct_get_pet_info('${id}',this,${sessionStorage.getItem('direct_pet_seq')},'${session_id}')`)

        })

    }
}

function direct_get_pet_info(id,target,pet_seq,session_id){
    let parent = target.parentElement.parentElement


    let thisYear = parent.getAttribute('data-year');
    let thisMonth = parent.getAttribute('data-month');
    let thisDate = parent.getAttribute('data-date');
    let thisHour = parent.getAttribute('data-hour');
    let thisMinutes = parent.getAttribute('data-minutes');

    let thisWorker;
    let thisWorker2;

    //console.log(thisHour)
    //console.log(thisMinutes);

    Array.from(document.getElementsByClassName('header-worker')).forEach(function (el){

        if(el.classList.contains('actived')){

            thisWorker = el.getAttribute('data-worker');
            thisWorker2 = el.getAttribute('data-nick');
        }
    })

    let a = new Date(date.getFullYear(),date.getMonth(),date.getDate(),thisHour,thisMinutes);
    a.setMinutes(a.getMinutes()+120);


    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'pet_info',
            pet_seq:pet_seq
        },
        success:function (res){
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                //console.log(body);

                let is_vat;
                $.ajax({

                    url:'/data/pc_ajax.php',
                    type:'post',
                    async:false,
                    data:{

                        mode:'merchandise',
                        login_id:id,
                        animal:body.type,
                    },
                    success:function(res){
                        let response = JSON.parse(res);
                        let head = response.data.head;
                        let body = response.data.body;
                        if (head.code === 401) {
                            pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                        } else if (head.code === 200) {
                            is_vat = body.is_vat
                        }
                    }
                })


                let user_id = '';

                if(body.customer_id === ''){

                    user_id = body.tmp_seq;
                }else{
                    user_id = body.customer_id;
                }

                document.getElementById('d_partner_id').value = id;
                document.getElementById('d_worker').value = thisWorker;
                document.getElementById('d_customer_id').value =user_id;
                document.getElementById('d_cellphone').value= sessionStorage.getItem('direct_cellphone');
                document.getElementById('d_pet_seq').value= body.pet_seq;
                document.getElementById('d_pet_name').value= body.name;
                document.getElementById('d_animal').value= body.type;
                document.getElementById('d_pet_type').value=body.pet_type;
                document.getElementById('d_pet_year').value=body.year;
                document.getElementById('d_pet_month').value=body.month;
                document.getElementById('d_pet_day').value=body.day;
                document.getElementById('d_gender').value=body.gender;
                document.getElementById('d_neutral').value=body.neutral;
                document.getElementById('d_weight').value=body.weight;
                document.getElementById('d_beauty_exp').value=body.beauty_exp;
                document.getElementById('d_vaccination').value=body.vaccination;
                document.getElementById('d_luxation').value=body.luxation === "" ? '0' : body.luxation;
                document.getElementById('d_bite').value=body.bite === "" ? '안해요' : body.bite;
                document.getElementById('d_dermatosis').value=body.dermatosis;
                document.getElementById('d_heart_trouble').value=body.heart_trouble;
                document.getElementById('d_marking').value=body.marking;
                document.getElementById('d_mounting').value=body.mounting;
                document.getElementById('d_year').value=thisYear;
                document.getElementById('d_month').value=parseInt(thisMonth)+1;
                document.getElementById('d_day').value=thisDate;
                document.getElementById('d_hour').value=thisHour
                document.getElementById('d_min').value=thisMinutes;
                document.getElementById('d_session_id').value= session_id
                document.getElementById('d_order_id').value=""
                document.getElementById('d_local_price').value=null
                document.getElementById('d_pay_type').value="pos-card"
                document.getElementById('d_pay_status').value="POS"

                document.getElementById('d_to_hour').value=fill_zero(a.getHours());
                document.getElementById('d_to_min').value=fill_zero(a.getMinutes());
                document.getElementById('d_use_coupon_yn').value=""
                document.getElementById('d_is_vat').value= is_vat
                document.getElementById('d_product').value=`${body.name}|${body.type}|${data.shop_name}|||:0|||||||||0|0|0|0|0|0`
                // document.getElementById('d_pay_data').value=`{"mode":"directRev","date":"${thisYear}-${fill_zero(thisMonth)}-${fill_zero(thisDate)}","time":"${fill_zero(thisHour)}:${fill_zero(thisMinutes)}","worker":"${thisWorker}","msg_send":"${document.querySelector('input[name="msg_send"]:checked').value}","msg_send1":"${document.querySelector('input[name="msg_send1"]:checked').value}"`
                // document.getElementById('d_reserve_yn').value=document.querySelector('input[name="msg_send"]:checked').value;
                // document.getElementById('d_aday_ago_yn').value=document.querySelector('input[name="msg_send1"]:checked').value;

                document.getElementById('direct_title').innerText=thisWorker2;
                document.getElementById('thisDate1').innerText = `${thisYear}-${fill_zero(parseInt(thisMonth)+1)}-${fill_zero(thisDate)}`;
                document.getElementById('thisTime1').innerText = `${fill_zero(am_pm_check(thisHour))}:${fill_zero(thisMinutes)}`;
                document.getElementById('pet_n').innerText = body.name;

            }

        }

    })





    pop.open('reserveCalendarPop100')

}

function direct_reserve_regist(){




    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'reserve_regist',
            partner_id : document.getElementById('d_partner_id').value,
            worker : document.getElementById('d_worker').value,
            customer_id :document.getElementById('d_customer_id').value,
            cellphone : document.getElementById('d_cellphone').value,
            pet_seq : document.getElementById('d_pet_seq').value,
            animal : document.getElementById('d_animal').value,
            pet_type : document.getElementById('d_pet_type').value,
            pet_name : document.getElementById('d_pet_name').value,
            pet_year : document.getElementById('d_pet_year').value,
            pet_month: document.getElementById('d_pet_month').value,
            pet_day : document.getElementById('d_pet_day').value,
            gender:document.getElementById('d_gender').value,
            neutral:document.getElementById('d_neutral').value,
            weight:document.getElementById('d_weight').value,
            beauty_exp:document.getElementById('d_beauty_exp').value,
            vaccination:document.getElementById('d_vaccination').value,
            luxation:document.getElementById('d_luxation').value,
            bite:document.getElementById('d_bite').value,
            dermatosis:document.getElementById('d_dermatosis').value,
            heart_trouble:document.getElementById('d_heart_trouble').value,
            marking:document.getElementById('d_marking').value,
            mounting:document.getElementById('d_mounting').value,
            year:document.getElementById('d_year').value,
            month:document.getElementById('d_month').value,
            day:document.getElementById('d_day').value,
            hour:document.getElementById('d_hour').value,
            min:document.getElementById('d_min').value,
            session_id:document.getElementById('d_session_id').value,
            order_id:'',
            local_price:null,
            pay_type:'pos-card',
            pay_status:'pos',
            pay_data:`{"mode":"directRev","date":"${document.getElementById('d_year').value}-${fill_zero(document.getElementById('d_month').value)}-${fill_zero(document.getElementById('d_day').value)}","time":"${fill_zero(document.getElementById('d_hour').value)}:${fill_zero(document.getElementById('d_min').value)}","worker":"${document.getElementById('d_worker').value}","msg_send":"${document.querySelector('input[name="msg_send"]:checked').value}","msg_send1":"${document.querySelector('input[name="msg_send1"]:checked').value}"`,
            to_hour:document.getElementById('d_to_hour').value,
            to_min:document.getElementById('d_to_min').value,
            use_coupon_yn:'N', // 수정필
            is_vat:document.getElementById('d_is_vat').value,
            product:document.getElementById('d_product').value,
            reserve_yn : document.querySelector('input[name="msg_send"]:checked').value ,
            aday_ago_yn : document.querySelector('input[name="msg_send1"]:checked').value



        },
        success:function(res){
            //console.log(res)
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                location.reload()
            }

        }
    })



}

function direct_new(id,cellphone){


    return new Promise(function(resolve){



        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:'pet_list',
                login_id:id,
                cellphone:cellphone


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

                    sessionStorage.setItem('direct_pet_seq',body[0].pet_seq)
                    resolve();
                }

            }
        })
    })
}


function customer_beauty_gallery(){




        let payment_idx_list = document.querySelector('input[name="pet_list"]:checked').getAttribute('data-payment_idx')


        if(payment_idx_list === null){
            document.getElementById('beauty_gal_wrap').innerHTML ='<div class="list-cell"><a href="#" class="btn-gate-picture-register" onclick="MemofocusNcursor();"><span><em>이미지 추가</em></span></a></div>';
            return;
        }


        let payment_idxs = payment_idx_list.split('|');


        //payment_idxs.forEach(function(el,i){

            // if(i === payment_idxs.length-1){
            //
            //     return;
            // }


            $.ajax({

                url:'/data/pc_ajax.php',
                type:'post',
                data:{
                    mode:'beauty_gal_get',
                    idx:$('input[name=pet_list]:checked').data("pet_seq"),
                    artist_id:artist_id
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

                        let imgs ='';

                        body.forEach(function(el,i){
                            if(i === body.length -1){
                                imgs += `${el.file_path}`
                            }else{
                                imgs += `${el.file_path}|`
                            }


                        })


                        //console.log('test');
                        //console.log(body);
                        var html = `<div class="list-cell"><a href="#" class="btn-gate-picture-register" onclick="MemofocusNcursor();"><span><em>이미지 추가</em></span></a></div>`;
                        body.forEach(function(el,i){


                            html += `<div class="list-cell">
                                                                                    <div class="picture-thumb-view">
                                                                                        <div class="picture-obj" onclick="showReviewGallery(${i},'${imgs}')"><img src="${img_link_change(el.file_path)}" alt=""></div>
                                                                                        <div class="picture-date">${el.upload_dt.substr(0,4)}.${el.upload_dt.substr(4,2)}.${el.upload_dt.substr(6,2)}</div>
                                                                                        <div class="picture-ui">
                                                                                            <button type="button" class="btn-picture-ui"></button>
                                                                                        </div>
                                                                                        <div class="picture-ui-list">
                                                                                            <div class="picture-ui-list-inner">
                                                                                             <a href="#" onclick="event.preventDefault(); beauty_gallery_del(${el.idx})" class="btn-picture-ui-nav">삭제</a>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>`
                            // document.getElementById('target_pet_img').setAttribute('src',img_link_change(el.file_path));
                        })
                        $("#beauty_gal_wrap").append(html);


                    }

                }

            })

       // })











}

// 이미지 추가 클릭시
function MemofocusNcursor() {
    html = "<div id='upimgarea'></div>";
    //document.getElementById('dmemo').focus();
    var sel, range;
    if (window.getSelection) {
        // IE9 and non-IE
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();

            // Range.createContextualFragment() would be useful here but is
            // non-standard and not supported in all browsers (IE9, for one)
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment(),
                node, lastNode;
            while ((node = el.firstChild)) {
                lastNode = frag.appendChild(node);
            }
            range.insertNode(frag);

            // Preserve the selection
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if (document.selection && document.selection.type != "Control") {
        // IE < 9
        document.selection.createRange().pasteHTML(html);
    }

    $("#addimgfile").trigger("click");

}

function customer_beauty_gallery_add(id,pet_data){

    let payment_idx = pet_data[0];
    let pet_seq = pet_data[1];


    document.getElementById('addimgfile').addEventListener('change',function(e){

        let ext = document.getElementById('addimgfile').value.split('.').pop().toLowerCase()

        if(!ext.match(/png|jpg|jpeg/i)){

            alert('gif,png,jpg,jpeg 파일만 업로드 할 수 있습니다.')
            return;
        }

        let filename = document.querySelector('input[name="imgupfile"]').files[0]


        let type = filename.type.split('/')[1];

        let formData = new FormData();
        formData.append('mode','beauty_gal_add');
        formData.append('login_id',id);
        formData.append('payment_log_seq',payment_idx);
        formData.append('pet_seq',pet_seq);
        formData.append('prnt_title',filename.name.split('.')[0])
        formData.append('mime',type);
        formData.append('image',filename);




        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            enctype:'multipart/form-data',
            data:formData,
            processData:false,
            contentType:false,
            success:function(data){

                document.getElementById('msg2_txt').innerText = '완료되었습니다.'
                pop.open('reserveAcceptMsg2');

            }


        })



    })
}

// 고객조회 알림톡 팝업 오픈
function open_customer_allim(cellphone){
    pop.open('customerAlarmInquiryPop');
    customer_allim_inquiry('','',cellphone);
}
// 고객조회 알림톡 조회
function customer_allim_inquiry(st_time, fi_time, cellphone){
    $.ajax({
        url: '../data/customer_alarm_inquiry.php',
        data: {
            startDate: st_time,
            endDate: fi_time,
            cellphone:cellphone,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            ////console.log(res);
            let response = JSON.parse(res);
            ////console.log(response);
            // let head = response.data.head;
            let body = response.data;
            // if (head.code === 401) {
            //     pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            // } else if (head.code === 200) {
            //     shop_array.push(body);
            // }
            //console.log(body);
            var html = '';
            if(body != null){
                $.each(body, function(i,v){
                    ////console.log(v.date_client_req.split(' ')[0]);
                    var template_code = "";
                    switch(v.template_code){
                        case "1000004530_14040" : template_code = "예약알림";
                            break;
                        case "1000004530_20001" : template_code = "예약알림";
                            break;
                        case "1000004530_14041" : template_code = "예약변경알림";
                            break;
                        case "1000004530_20002" : template_code = "예약변경알림";
                            break;
                        case "1000004530_14042" : template_code = "미용종료알림";
                            break;
                        case "1000004530_14042_1" : template_code = "미용종료알림";
                            break;
                        case "1000004530_14043" : template_code = "전날알림";
                            break;
                        case "1000004530_20003" : template_code = "전날알림";
                            break;
                        case "1000004530_14044" : template_code = "예약취소알림";
                            break;

                    }
                    html += `
                    <tr>
                        <td class="">${v.date_client_req.split(' ')[0]}<br>${v.date_client_req.split(' ')[1]}</td>
                        <td class="">${template_code}</td>
                        <td class="text-align-left">${(v.content).replace(/\n/g, "<br />")}</td>
                        <td class="">`;
                    if(v.report_code != '1000'){
                        html += mms_log(cellphone,v.date_client_req,v.payment_log);
                    }else{
                        html += `알림톡발송`;
                    }
                    html += `
                        </td>
                    </tr>
                `;
                })
                document.getElementById('allim_table').innerHTML = html;
                $("#customerAlarmInquiryPop .none_allim").css("display","none");
                $("#customerAlarmInquiryPop .do_allim").css("display","block");
            }else{
                $("#customerAlarmInquiryPop .none_allim").css("display","block");
                $("#customerAlarmInquiryPop .do_allim").css("display","none");
            }
        }
    })
}

$(document).on("click",".pop_inquiry",function(){
    var st_time = $("#customerAlarmInquiryPop .datepicker-start").val();
    var fi_time = $("#customerAlarmInquiryPop .datepicker-end").val();
    var cellphone = $("#customerAlarmInquiryPop .allim_cellphone_val").val();
    customer_allim_inquiry(st_time, fi_time, cellphone);
})


function customer_all_agree(id,target){

    let pet_seq = target.getAttribute('data-pet_seq') === '' ? 0 : target.getAttribute('data-pet_seq');

    if(pet_seq === 0){

        document.getElementById('msg1_txt').innerText = '작성된 동의서가 없습니다.'
        pop.open('reserveAcceptMsg1');
    }else{
        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{

                mode:'get_beauty_agree',
                partner_id:id,
                pet_idx:pet_seq,

            },
            success:function(res) {
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {

                    if(body.length === undefined){
                        body = [body]
                    }

                    //console.log(body)
                    if(body.length === 0 ){

                        document.getElementById('msg1_txt').innerText = '작성된 동의서가 없습니다.'
                        pop.open('reserveAcceptMsg1');
                    }else{

                        let data = body.at(-1);
                        //console.log(data)

                        let reg_date = `${data.reg_date.substr(0,4)}.${data.reg_date.substr(4,2)}.${data.reg_date.substr(6,2)}`;

                        document.getElementById('agree_view_name').value = data.customer_name;
                        document.getElementById('agree_view_date').innerText = reg_date
                        document.getElementById('agree_view_name2').innerText = data.customer_name;
                        document.getElementById('agree_view_cellphone').value = data.cellphone;
                        document.getElementById('user_sign_img').setAttribute('src',`https://image.banjjakpet.com${data.image}`)

                        pop.open('beautyAgreeViewPop');



                    }



                }
            }
        })
    }






}