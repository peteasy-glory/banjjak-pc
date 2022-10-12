
let data;
let list;


// 세자리 숫자 콤마
Number.prototype.format = function() {
    if (this == 0) return 0;

    var reg = /(^[+-]?\d+)(\d{3})/;
    var n = (this + '');

    while (reg.test(n)) n = n.replace(reg, '$1' + ',' + '$2');

    return n;
};

// 문자열 타입에서 쓸 수 있도록 format() 함수 추가
String.prototype.format = function() {
    var num = parseFloat(this);
    if (isNaN(num)) return "0";

    return num.format();
};

// image 링크 바꾸기 함수
function img_link_change(img){
    var img 	= img.replace("/pet/images", "/images");
    var img 	= img.replace("/pet/upload", "/upload");

    return "https://image.banjjakpet.com"+img;
}

// db to str 이모지
function db_to_str(str){
    let return_str = str;
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'db_to_str',
            str: str,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            let response = JSON.parse(res);
            return_str = response.data;
        }
    })
    return return_str;
}

// str to db 이모지
function str_to_db(str){
    let return_str = str;
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'str_to_db',
            str: str,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            let response = JSON.parse(res);
            return_str = response.data;
        }
    })
    return return_str;
}

function get_navi(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'navi',
            login_id: id,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            ////console.log(res);
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                data = body;
                //$(".shop_name").prepend(body.shop_name);
                $(".consulting_count").text(body.consult_cnt);
                $(".nick").text(body.nickname);
                $(".front_image").attr("src",img_link_change(body.front_image));
            }
        }
    })
}

function data_set(id){

    return new Promise(function(resolve){



            $.ajax({
                url: '/data/pc_ajax.php',
                data: {
                    mode: 'home',
                    login_id: id,
                },
                type: 'POST',
                async:false,
                success: function (res) {
                    //console.log(res)
                    let response = JSON.parse(res);
                    let head = response.data.head;
                    let body = response.data.body;
                    if (head.code === 401) {
                        pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                    } else if (head.code === 200) {
                        data = body;

                        


                        localStorage.setItem('total_count',data.total_count);

                        resolve();
                    }
                }
            })



    })



}
// 홈 캘린더
function home_cal(id){
        $.ajax({
            url: '/data/pc_ajax.php',
            data: {
                mode: 'cal_count',
                login_id: id,
                st_date:date.getFullYear()+'-'+fill_zero(date.getMonth()+1)+'-01',
                fi_date:date.getFullYear()+'-'+fill_zero(date.getMonth()+2)+'-01'
            },
            type: 'POST',
            success: function (res) {
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {

                    let reserve;

                    if(body[0].length !== undefined){
                        if(body[0].length > 0){
                            reserve = body[0];

                            let date_info = document.getElementsByClassName('date-info');

                            Array.from(date_info).forEach(function(el){

                                reserve.forEach(function(el_){


                                    if(`20${el.innerText.trim().replaceAll('.','-')}` === el_.date){


                                        siblings(el,1).innerText = `${el_.count}건`;

                                        siblings(el.parentElement.parentElement.parentElement.parentElement,0).children[1].innerText= `${el_.count}`;

                                        el.parentElement.parentElement.parentElement.childNodes[3].childNodes[1].childNodes[3].innerText = `${el_.count}건`
                                    }

                                })
                            })

                        }
                    }





                }
            },complete:function(){
                if(document.getElementById('main-calendar-month-body')){


                    document.getElementById('main-calendar-month-body').style.display = 'block';
                    document.getElementById('home_main_calendar_loading').style.display = 'none';
                }else if(document.getElementById('mini-calendar-month-body')){
                    document.getElementById('mini-calendar-month-body').style.display = 'block';
                    if(document.getElementById('day_mini_calendar_loading')){

                        document.getElementById('day_mini_calendar_loading').style.display = 'none';
                    }else if(document.getElementById('week_mini_calendar_loading')){
                        document.getElementById('week_mini_calendar_loading').style.display = 'none';

                    }

                }

            }
        })
}

function home_stats(id){


    $.ajax({
        url: '/data/pc_ajax.php',
        data: {
            mode: 'stats',
            login_id: id,
            st_date: date.getFullYear() + '-' + fill_zero(date.getMonth() + 1) + '-01',
            fi_date: date.getFullYear() + '-' + fill_zero(date.getMonth() + 2) + '-01'
        },
        type: 'POST',
        success: function (res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {


                if(body[0].card_price === null){

                    document.querySelector('.main-reserve-graph').innerHTML = '';
                    document.getElementById('main_reserve_graph_none').style.display = 'block';
                }else{
                    document.getElementById('main_reserve_graph_none').style.display = 'none';

                    let card = parseInt(body[0].card_price);
                    let cash = parseInt(body[0].cash_price);

                    let dog = 0;
                    let cat = 0;
                    body.forEach(function(el){

                        if(el?.pet_type){
                            if(el.pet_type === 'dog'){

                                dog = parseInt(el.pet_cnt);
                            }else{
                                cat = parseInt(el.pet_cnt);

                            }
                        }



                    })


                    let total_price = card+cash
                    let card_ = Math.round(card / total_price * 100)
                    let cash_ = Math.round(cash / total_price *100)

                    //console.log(card_);
                    //console.log(cash_)

                    //console.log(dog)
                    //console.log(cat)
                    let total_pet = cat+dog;
                    let cat_ = Math.round(cat/total_pet*100)
                    let dog_ = Math.round(dog/total_pet*100)

                    //console.log(total_pet);

                    //console.log(cat_)
                    //console.log(dog_)


                    document.querySelector('.main-reserve-graph').innerHTML = `<div class="graph-cell">
                                                                                        <div class="graph-item yellow" style="${cash_ === 0 ? 'display:none;' : `width:${cash_}%;`} ${cash_ < 30 ? `font-size:10px ; flex-direction:column` : ""}; ${cash_ < 8 ? `color:transparent` : ""};">현금 <em style="${cash_ < 30 ? `font-size:10px` : ""}">${cash_}%</em></div>
                                                                                        <div class="graph-item purple" style="${card_ === 0 ? 'display:none;' : `width:${card_}%;`} ${card_ < 30 ? `font-size:10px ; flex-direction:column` : ""}; ${card_ < 8 ? `color:transparent` : ""};">카드 <em style="${card_ < 30 ? `font-size:10px` : ""}">${card_}%</em></div>
                                                                                    </div>
                                                                                    <div class="graph-cell">
                                                                                        <div class="graph-item yellow" style="${dog_ === 0 ? 'display:none;' : `width:${dog_}%;`} ${dog_ < 30 ? `font-size:10px ; flex-direction:column` : ""};  ${dog_ < 8 ? `color:transparent` : ""}; ">강아지 <em style="${dog_ < 30 ? `font-size:10px` : ""};">${dog_}%</em></div>
                                                                                        <div class="graph-item purple" style="${cat_  === 0 ? 'display:none;' : `width:${cat_}%;`} ${cat_ < 30 ? `font-size:10px ; flex-direction:column` : ""}; ${cat_ < 8 ? `color:transparent` : ""};">고양이 <em style="${cat_ < 30 ? `font-size:10px` : ""}; ">${cat_}%</em></div>
                                                                                    </div>`

                }



            }
        }
    })
}


//등록 현황 통계 날짜
function update(){
    document.getElementById('item_date').prepend(date_);
}

Array.prototype.division = function( n ) {
    const array = this;
    const length = array.length;
    const divide = Math.floor(length / n ) + (Math.floor( length % n ) > 0 ? 1 : 0);
    const newArray = [];

    for (let i = 0; i <= divide; i++) {

        newArray.push(array.splice(0, n));
    }

    return newArray;
}


//input 숫자만 가능

// setInputFilter(document.getElementById("myTextBox"), function(value) {
//     return /^\d*\.?\d*$/.test(value); // Allow digits and '.' only, using a RegExp
// });

function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
        textbox.addEventListener(event, function() {
            if (inputFilter(this.value)) {
                this.oldValue = this.value;
                this.oldSelectionStart = this.selectionStart;
                this.oldSelectionEnd = this.selectionEnd;
            } else if (this.hasOwnProperty("oldValue")) {
                this.value = this.oldValue;
                this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
            } else {
                this.value = "";
            }
        });
    });
}

function input_enter(form_el,btn_el){

    document.getElementById(form_el).addEventListener('keydown',function(evt){
        if(evt.keyCode === 13){
            document.getElementById(btn_el).click();
        }
    })


}

function phone_edit(phone){

    return phone.replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`)
}

function gnb_actived(element1,element2) {

    switch (arguments.length){

        case 1 :document.getElementById(element1).classList.add('actived','current'); break;

        case 2 : document.getElementById(element1).classList.add('actived','current');
            document.getElementById(element2).classList.add('actived');
            break;


    }
}



// let data = JSON.parse(localStorage.getItem('data'));

//현재 날짜

let date = new Date();

let year = date.getFullYear();
let month = date.getMonth();
let day = date.getDate();
let hours = date.getHours();
let minutes = date.getMinutes();
let times = date.getTime();
let date_ = `${date.getFullYear().toString().substr(-2)}.${(date.getMonth() + 1).toString().length < 2 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1}.${date.getDate().toString().length < 2 ? '0' + date.getDate() : date.getDate()}`

// 시간형식으로 오전 오후 적용 ex) 09:00
function am_pm_check_time(time){

    var hours = time.split(":")[0];
    var minute = time.split(":")[1];
    if(hours > 12){
        time = `오후 ${(hours-12).toString().length <2 ? '0' : ''}${hours-12}:${minute}`
    }else if(hours == 12){
        time = `오후 ${hours}:${minute}`
    }else{
        time = `오전 ${hours}:${minute}`
    }

    return time;
}

//오후 오전 적용하기
function am_pm_check(hours){

    if(hours > 12){
        hours = `오후 ${(hours-12).toString().length <2 ? '0' : ''}${hours-12}`
    }else if(hours === 12){
        hours = `오후 ${hours}`
    }else{
        hours = `오전 ${hours}`
    }

    return hours;
}

//오후 오전 적용하기 2 ex) '2022.08.11 09:10'
function am_pm_check2(date){

    if(date === 'None'){
        return;
    }
    let date_ = date.split(' ')

    let _date = date_[1].split(':');

    return `${date_[0]} ${am_pm_check(_date[0])}:${_date[1]}`

}
// 오후 오전 적용하기 3 // '오후','오전' 없는
function am_pm_check3(hours){

    if(hours > 12){
        hours = `${(hours-12).toString().length <2 ? '0' : ''}${hours-12}`
    }else if(hours === 12){
        hours = `${hours}`
    }else{
        hours = `${hours}`
    }

    return hours;
}
//분 시간 0채우기
function fill_zero(time){

    if(time.toString().length < 2){

        time = `0${time}`
    }else{
        time = time;
    }

    return time;
}

//형제요소
function siblings(el,i){

    return [...el.parentElement.children][i];

}

//시간비교 // "09:00", "09:30" 형식으로
function time_compare(time1,time2){

    let time1_ = time1.split(':');
    let time2_ = time2.split(':');


    let time1_date = new Date(date.getFullYear(),date.getMonth(),date.getDate(),time1_[0],time1_[1]).getTime();
    let time2_date = new Date(date.getFullYear(),date.getMonth(),date.getDate(),time2_[0],time2_[1]).getTime();

    return time1_date > time2_date ? true : false;

}


//gnb 샵 이름넣기, gnb 메뉴 폴드 언폴드
function gnb_init() {

    if(localStorage.getItem('dark') === '1'){

        document.querySelector('html').classList.add('dark');
    }

    if(localStorage.getItem('dark') === '1'){

        document.querySelector('html').classList.add('dark');
    }
    //shop_name
    document.querySelector('.shop_name').prepend(data.shop_name);

    //gnb_menu_cell fold/unfold
    let gnb_menu_cell = document.getElementsByClassName('gnb-menu-cell');

    Array.from(gnb_menu_cell).forEach(function (el) {

        el.addEventListener('click', function () {

            if (this.classList.contains('actived')) {
                this.classList.remove('actived', 'current');
            } else {
                Array.from(gnb_menu_cell).forEach(function (el) {
                    el.classList.remove('actived', 'current');
                })

                this.classList.add('actived', 'current');
            }

        })
    })
}


//데이터 넣기 클래스이름 띄어쓰기로 구분
function prepend_data(className) {

    let classNames = className.split(" ");

    for (let i = 0; i < classNames.length; i++) {

        let _class = document.getElementsByClassName(classNames[i])

        Array.from(_class).forEach(function (el) {
            el.prepend(data[classNames[i]]);
        })
    }
}



//사진 넣기 클래스이름 띄어쓰기로 구분
function set_image(className) {

    let classNames = className.split(" ");

    for (let i = 0; i < classNames.length; i++) {

        let _class = document.getElementsByClassName(classNames[i]);

        Array.from(_class).forEach(function (el) {
            el.setAttribute('src', `https://image.banjjakpet.com${data[classNames[i]].toString().substr(0,5) === '/pet/' ? data[classNames[i]].toString().replace('/pet','') : data[classNames[i]]}`)
        })
    }

}

function onScroll(e){
    const sticky_target = document.querySelector("#sticky-tab-group-target");
    const classes = sticky_target.classList;
    const st_bt_target = pageYOffset + document.querySelector("#sticky-bottom").getBoundingClientRect().top;

    if(window.scrollY >= st_bt_target -100){
        if(!classes.contains("sticky-remove")) {
            sticky_target.classList.add("sticky-remove")

        }
    }else{
        sticky_target.classList.remove("sticky-remove")
    }
}

//오늘 예약 내역
function today_reserve(id,bool){


    let reserve_list = document.getElementById('main_reserve_list');

    let artist_id = id;


    $.ajax({


        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'day_book',
            login_id:id,
            st_date:`${new Date().getFullYear()}-${fill_zero(new Date().getMonth()+1)}-${fill_zero(new Date().getDate())}`,
            fi_date:`${new Date().getFullYear()}-${fill_zero(new Date().getMonth()+1)}-${fill_zero(new Date().getDate()+1)}`

        },
        success:function (res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                console.log(body)

                if(body.length === undefined){

                    body =[body];

                }

                if(body.length > 0){

                    body.forEach(function(el){
                        let today_reserve = el.product.date.booking_st;
                        let date_today_reserve = new Date(today_reserve.replace(' ','T'));
                        let today_reserve_fi = el.product.date.booking_fi;
                        let date_today_reserve_fi = new Date(today_reserve_fi.replace(' ','T'));

                        if(date_today_reserve.getFullYear() === date.getFullYear()
                            && date_today_reserve.getMonth() === date.getMonth()
                            && date_today_reserve.getDate() === date.getDate()
                            &&el.product.is_cancel !== 1
                        ){

                            //console.log(el)
                            document.getElementById('reserve_after_none').style.display = 'none';
                            if(el.pet.photo !== null && el.pet.photo.substr(0,4) === '/pet'){
                                el.pet.photo = el.pet.photo.replace('/pet','');
                            }

                            let diary_time;
                            if(el.product.diary_idx !== null ){

                                diary_time = new Date(el.product.diary_time);

                            }
                            reserve_list.innerHTML += `<div class="${bool ? 'main-reserve-list-cell' : 'customer-card-list-cell'}">
                                                <a href="/booking/reserve_beauty_day.php" onclick="localStorage.setItem('payment_idx',${el.product.payment_idx}); localStorage.setItem('day_select',\`${new Date().getFullYear()}.${fill_zero(new Date().getMonth() + 1)}.${fill_zero(new Date().getDate())}\`)" class="customer-card-item transparent">
                                                    <div class="item-info-wrap">
                                                        <div class="item-thumb">
                                                            <div class="user-thumb ${bool ? 'middle' : 'small'}" ${el.pet.photo !== null ? `onclick="thumb_view(this,\`${el.pet.photo}\`)"` : ''}><img src="${el.pet.photo !== null ? `https://image.banjjakpet.com${el.pet.photo}`  : `${el.pet.animal === 'dog' ? `../static/images/icon/icon-pup-select-off.png`: `../static/images/icon/icon-cat-select-off.png`}` }" alt=""></div>
                                                        </div>
                                                        <div class="item-data">
                                                            <div class="item-data-inner">
                                                                <div class="${bool ? 'item-pet-name' : 'item-name'}">${el.pet.name}
                                                                    ${bool ? `<div class="label label-yellow middle">
                                                                        <strong>${el.pet.type}</strong>
                                                                    </div>` : `<div class="pet-name">${el.pet.type}</div>`}
                                                                </div>
                                                                <div class="item-phone">${el.customer.phone.replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`)}</div>
                                                                <div class="item-option">
                                                                    <div class="option-cell">
                                                                        <div class="icon icon-size-16 icon-time-purple"></div>
                                                                        ${am_pm_check(date_today_reserve.getHours())}:${fill_zero(date_today_reserve.getMinutes())} ~ ${am_pm_check(date_today_reserve_fi.getHours())}:${fill_zero(date_today_reserve_fi.getMinutes())}
                                                                    </div>
                                                                    <div class="option-cell">${el.product.worker_nick === artist_id? '실장' : el.product.worker_nick}</div>
                                                                  
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        ${bool ? `<div class="item-state">
                                                            <div class="item-sort">
                                                                <div class="txt-1">미용</div>
                                                                <div class="txt-2">${el.product.category_sub }</div>
                                                            </div>
                                                        </div>` : ''}
                                                        
                                                    </div>
                                                    <div class="item-diary">
                                                                    ${el.product.diary_idx === null ? `<div class="diary-not-exist" data-cellphone="${el.customer.phone}" data-pet_seq="${el.pet.idx}" data-payment_idx="${el.product.payment_idx}" data-date="${el.product.date.booking_st}" data-pet_name="${el.pet.name}" onclick="allimi_send_pop(this,'${artist_id}')">알리미 보내기</div>` : `<div class="diary-exist" data-cellphone="${el.customer.phone}" data-pet_seq="${el.pet.idx}" data-payment_idx="${el.product.payment_idx}">알리미 발송완료</div>`}
                                                                    ${el.product.diary_idx !== null ? `<div class="diary-date"><span>(${diary_time.getFullYear()}. ${fill_zero(diary_time.getMonth()+1)}. ${fill_zero(diary_time.getDate())}. ${am_pm_check(diary_time.getHours())}시 ${fill_zero(diary_time.getMinutes())}분)</span></div>`:''}
                                                                </div>
                                                </a>
                                            </div>`
                        }

                    })
                }





            }
        }

    })




}


//달력
function renderCalendar(id) {
    return new Promise(function (resolve) {





        let viewYear = date.getFullYear();
        let viewMonth = date.getMonth();

        // year-month 채우기
        document.querySelector('.year-month').innerText = `${viewYear}.${fill_zero(viewMonth+1)}`;

        // 지난 달 마지막 Date, 이번 달 마지막 Date
        let prevLast = new Date(viewYear, viewMonth, 0);
        let thisLast = new Date(viewYear, viewMonth + 1, 0);
        let PLDate = prevLast.getDate();
        let PLDay = prevLast.getDay();
        let TLDate = thisLast.getDate();
        let TLDay = thisLast.getDay();

        // Dates 기본 배열들
        let prevDates = [];
        let thisDates = [...Array(TLDate + 1).keys()].slice(1);
        let nextDates = [];

        // prevDates 계산
        if (PLDay !== 6) {
            for (let i = 0; i < PLDay + 1; i++) {
                prevDates.unshift(PLDate - i);
            }
        }

        // nextDates 계산
        for (let i = 1; i < 7 - TLDay; i++) {
            nextDates.push(i)
        }

        // Dates 합치기
        let dates = prevDates.concat(thisDates, nextDates);

        // Dates 정리
        dates.forEach(function(_date, i){
            dates[i] = `<div class="main-calendar-month-body-col ${prevDates.indexOf(_date) >= 0 && i <= 7 ? "before" : ""} ${nextDates.indexOf(_date) >= 0 && i >= dates.length - 7 ? "after" : ""} ${new Date(date.getFullYear(),date.getMonth(),_date).getDay() === 0 ? 'sunday' : ''} ${new Date(date.getFullYear(),date.getMonth(),_date).getDay() === 6 ? 'saturday' : '' } ">
                        <div class="main-calendar-col-inner">
                            <div class="main-calendar-toggle-group">
                                <a href="/booking/reserve_beauty_day.php" onclick="localStorage.setItem('day_select',\`${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${fill_zero(_date)}\`)" class="main-calendar-day-value">
                                    <div class="number ${new Date(date.getFullYear(),date.getMonth(),_date).getDay() === 0 ? 'sunday' : ''} ${new Date(date.getFullYear(),date.getMonth(),_date).getDay() === 6 ? 'saturday' : '' }" >${_date}</div>
                                    <div class="value reserve-total"></div>
                                </a>
                                <div class="main-calendar-toggle-data">
                                    <div class="main-calendar-toggle-list">
                                        <div class="list-cell">
                                            <div class="btn-list-nav total">
                                                <div class="title">전체</div>
                                                <div class="value beauty-count"></div>
                                                <div class="title date-info" style="display: none">
                                                
                                                ${prevDates.indexOf(_date) >= 0 && i <= 7 ? `${date.getFullYear().toString().substr(-2)}.${fill_zero(date.getMonth())}.${fill_zero(_date)}` : `${nextDates.indexOf(_date) >= 0 && i >= dates.length - 7 ? `${date.getFullYear().toString().substr(-2)}.${fill_zero(date.getMonth()+2)}.${fill_zero(_date)}` : `${date.getFullYear().toString().substr(-2)}.${fill_zero(date.getMonth()+1)}.${fill_zero(_date)}`}`}
                                                </div>
                                                
                                               
                                            </div>
                                        </div>
                                        <div class="list-cell">
                                            <a href="../booking/reserve_beauty_day.php" class="btn-list-nav" onclick="localStorage.setItem('day_select','${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${fill_zero(_date)}')">

                                                <div class="title">미용</div>
                                                <div class="value beauty-count"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
        })
        //7일단위로 나눔
        const div_dates = dates.division(7);

        //row 생성
        document.getElementById(`main-calendar-month-body`).innerHTML = '';
        for (let i = 0; i < div_dates.length; i++) {
            document.getElementById(`main-calendar-month-body`).innerHTML += ` <div class="main-calendar-month-body-row ${i > 0 && i < 5 ? "op-1" : ""} ${i === 0 || i === 2 ? '1or3' : i === 1 || i === 3 ? '2or4':""} " id="main-calendar-month-body-row-${i}" ></div>`
        }

        holiday(id);
        statutory_holiday(id)
        //정기휴일적용
        resolve(div_dates);
    })
}

function _renderCalendar(id) {


    renderCalendar(id)
        .then(function (div_dates) {
            //row에 col data 넣기
            for (let i = 0; i < div_dates.length; i++) {
                document.getElementById(`main-calendar-month-body-row-${i}`).innerHTML = '';
                for (let j = 0; j < div_dates[i].length; j++) {
                    document.getElementById(`main-calendar-month-body-row-${i}`).innerHTML += div_dates[i][j]
                }
            }
        })
        .then(function(){


            home_cal(id)
            home_stats(id);


        }).then(function() {

        //오늘날짜 표시시
        Array.from(document.getElementsByClassName('date-info')).forEach(function (el) {
            if (el.innerText.trim() === `${new Date().getFullYear().toString().substr(2, 2)}.${fill_zero(new Date().getMonth() + 1).toString()}.${fill_zero(new Date().getDate()).toString()}`) {
                el.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.classList.add('today');
            }
        })
       $(document).ready( function () {
            setTimeout(function () {
                //console.log(1)
                document.getElementById('wrap').style.display = 'block';
                document.getElementById('splash').style.display = 'none';
                sessionStorage.setItem('splash', '1');

            }, 1000)
        })

    })
}


function statutory_holiday(id){
    $.ajax({

        url: '/data/pc_ajax.php',
        type: 'post',
        data: {
            mode:'statutory',
            login_id:id,
            year: date.getFullYear(),
            month: 0
        },
        success: function (res) {
            //console.log(res)
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                //console.log(body)

                Array.from(document.getElementsByClassName('main-calendar-month-body-col')).forEach(function (el){


                    body.forEach(function (el_){

                        if(date.getFullYear() === el_.year && date.getMonth()+1 === el_.month && parseInt(el.children[0].children[0].children[0].children[0].innerText) === el_.day){

                            el.children[0].children[0].children[0].children[0].setAttribute('style','color: red !important');


                        }
                    })
                })

            }
        }
    })

}
//캘린더 버튼
function btn_month(id){


    document.getElementById('btn-month-prev').addEventListener('click', function (evt) {

        let height;
        if(document.getElementById('main-calendar-month-body')){


            height = document.getElementById('main-calendar-month-body').offsetHeight;
            document.getElementById('main-calendar-month-body').style.display = 'none';
            document.getElementById('home_main_calendar_loading').style.height = `${height}px`;
            document.getElementById('home_main_calendar_loading').style.display = 'flex';
        }else if(document.getElementById('mini-calendar-month-body')){
            height = document.getElementById('mini-calendar-month-body').offsetHeight;
            document.getElementById('mini-calendar-month-body').style.display = 'none';
            if(document.getElementById('day_mini_calendar_loading')){

                document.getElementById('day_mini_calendar_loading').style.height = `${height}px`;
                document.getElementById('day_mini_calendar_loading').style.display = 'flex';
            }else if(document.getElementById('week_mini_calendar_loading')){

                document.getElementById('week_mini_calendar_loading').style.height = `${height}px`;
                document.getElementById('week_mini_calendar_loading').style.display = 'flex';
            }


        }

        date.setDate(1);
        date.setMonth(date.getMonth() - 1);
            if(document.getElementById('main-calendar-month-body')){

                _renderCalendar(id);
            }else{

                _renderCalendar_mini(id);
            }
            if(document.getElementById('main_reserve_graph_none')){
                // stats();
            }
    })

    document.getElementById('btn-month-next').addEventListener('click', function (evt) {

        let height;
        if(document.getElementById('main-calendar-month-body')){


            height = document.getElementById('main-calendar-month-body').offsetHeight;
            document.getElementById('main-calendar-month-body').style.display = 'none';
            document.getElementById('home_main_calendar_loading').style.height = `${height}px`;
            document.getElementById('home_main_calendar_loading').style.display = 'flex';
        }else if(document.getElementById('mini-calendar-month-body')){
            height = document.getElementById('mini-calendar-month-body').offsetHeight;
            document.getElementById('mini-calendar-month-body').style.display = 'none';
            if(document.getElementById('day_mini_calendar_loading')){

                document.getElementById('day_mini_calendar_loading').style.height = `${height}px`;
                document.getElementById('day_mini_calendar_loading').style.display = 'flex';
            }else if(document.getElementById('week_mini_calendar_loading')){

                document.getElementById('week_mini_calendar_loading').style.height = `${height}px`;
                document.getElementById('week_mini_calendar_loading').style.display = 'flex';
            }


        }

        date.setDate(1);
        date.setMonth(date.getMonth() + 1);
        if(document.getElementById('main-calendar-month-body')){

            _renderCalendar(id);
        }else{

            _renderCalendar_mini(id);
        }
        if(document.getElementById('main_reserve_graph_none')){
            // stats();
        }


    })


}


function renderCalendar_mini(id) {


    return new Promise(function (resolve){
        let viewYear = date.getFullYear();
        let viewMonth = date.getMonth();

        //year-month 채우기
        document.querySelector('.year-month').innerText = `${viewYear}.${fill_zero(viewMonth+1)}`;

        // 지난 달 마지막 Date, 이번 달 마지막 Date
        let prevLast = new Date(viewYear, viewMonth, 0);
        let thisLast = new Date(viewYear, viewMonth + 1, 0);
        let PLDate = prevLast.getDate();
        let PLDay = prevLast.getDay();
        let TLDate = thisLast.getDate();
        let TLDay = thisLast.getDay();

        // Dates 기본 배열들
        let prevDates = [];
        let thisDates = [...Array(TLDate + 1).keys()].slice(1);
        let nextDates = [];

        // prevDates 계산
        if (PLDay !== 6) {
            for (let i = 0; i < PLDay + 1; i++) {
                prevDates.unshift(PLDate - i);
            }
        }

        // nextDates 계산
        for (let i = 1; i < 7 - TLDay; i++) {
            nextDates.push(i)
        }

        // Dates 합치기
        let dates = prevDates.concat(thisDates, nextDates);

        // Dates 정리
        dates.forEach(function(_date, i){
            dates[i] = `<div class="mini-calendar-month-body-col ${prevDates.indexOf(_date) >= 0 && i <= 7 ? "before" : ""} ${nextDates.indexOf(_date) >= 0 && i >= dates.length - 7 ? "after" : ""}">
                        <div class="mini-calendar-col-inner">
                            <div class="main-calendar-toggle-group">
                                <a href="javascript:;" class="mini-calendar-day-value">
                                    <div class="number">${_date}</div>
                                    <div class="value reserve-total"></div>
                                </a>
                                
                                <div class="main-calendar-toggle-data" style="display:none;">
                                    <div class="main-calendar-toggle-list">
                                        <div class="list-cell">
                                            <div class="btn-list-nav total">
                                                <div class="title date-info">
                                                
                                                ${prevDates.indexOf(_date) >= 0 && i <= 7 ? `${date.getFullYear().toString().substr(-2)}.${fill_zero(date.getMonth())}.${fill_zero(_date)}` : `${nextDates.indexOf(_date) >= 0 && i >= dates.length - 7 ? `${date.getFullYear().toString().substr(-2)}.${fill_zero(date.getMonth()+2)}.${fill_zero(_date)}` : `${date.getFullYear().toString().substr(-2)}.${fill_zero(date.getMonth()+1)}.${fill_zero(_date)}`}`}
                                                </div>
                                                <div class="value reserve-total-2"></div>
                                            </div>
                                        </div>
                                        <div class="list-cell">
                                            <a href="../booking/reserve_beauty_day.php" class="btn-list-nav" onclick="localStorage.setItem('day_select','${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${fill_zero(_date)}')">

                                                <div class="title">미용</div>
                                                <div class="value beauty-count"></div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
        })
        const div_dates = dates.division(7).slice(0,-1);
        if(document.getElementById('mini-calendar-month-body')){
            document.getElementById(`mini-calendar-month-body`).innerHTML = '';
            for (let i = 0; i < div_dates.length; i++) {
                document.getElementById(`mini-calendar-month-body`).innerHTML += ` <div class="mini-calendar-month-body-row ${i > 0 && i < 5 ? "op-1" : ""} ${i === 0 || i === 2 ? '1or3' : i === 1 || i === 3 ? '2or4':""} " id="mini-calendar-month-body-row-${i}" data-row="${i}" ></div>`
            }
        }

        holiday(id);
        resolve(div_dates);
    })
}

//새로고침 달력
function _renderCalendar_mini(id,session_id){
    renderCalendar_mini(id)
        .then(function (div_dates){
            for (let i = 0; i < div_dates.length; i++) {
                document.getElementById(`mini-calendar-month-body-row-${i}`).innerHTML = '';
                for (let j = 0; j < div_dates[i].length; j++) {
                    document.getElementById(`mini-calendar-month-body-row-${i}`).innerHTML += div_dates[i][j]
                }
            }

        })
        .then(function(){


            home_cal(id)

            // let date_info = document.getElementsByClassName('date-info');
            // let booking_list ;
            //
            // if(list !== undefined){
            //     booking_list = list;
            // }else{
            //     booking_list = data;
            // }
            //
            // Array.from(date_info).forEach(function(el,i){
            //     let count = 0;
            //     let date_ck_1 = new Date(`20${el.innerText.trim()}`);
            //
            //     if(booking_list.beauty.length === 0){
            //         // Array.from(document.getElementsByClassName('reserve-total')).forEach(function (el,i){
            //         //     el.innerHTML = '0';
            //         // })
            //     }else{
            //         booking_list.beauty.forEach(function(el_,i_){
            //             let date_ck_2  =  new Date(el_.product.date.booking_st);
            //
            //             if(date_ck_1.getFullYear() === date_ck_2.getFullYear()
            //                 && date_ck_1.getMonth() === date_ck_2.getMonth()
            //                 && date_ck_1.getDate() === date_ck_2.getDate()){
            //                 count++;
            //             }
            //
            //
            //             if(count !==0){
            //
            //                 siblings(el.parentElement.parentElement.parentElement.parentElement,0).children[1].innerHTML= `${count}`;
            //             }
            //
            //         })
            //     }
            // })
        })
        .then(function(){
            Array.from(document.getElementsByClassName('date-info')).forEach(function (el){
                if(el.innerText.trim() === `${new Date().getFullYear().toString().substr(2,2)}.${fill_zero(new Date().getMonth()+1).toString()}.${fill_zero(new Date().getDate()).toString()}`){
                    el.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.classList.add('today');
                    el.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.setAttribute('id','today');
                }


            })

            let mini_col = document.getElementsByClassName('mini-calendar-month-body-col');

            Array.from(mini_col).forEach(function(el){

                el.addEventListener('click',function(evt){



                     Array.from(mini_col).forEach(function click_event(el_){

                        el_.classList.remove('actived');
                    })

                    el.classList.add('actived');
                    localStorage.setItem('day_select',`${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${fill_zero(el.children[0].children[0].children[0].children[0].innerText.trim())}`)
                    date.setDate(el.children[0].children[0].children[0].children[0].innerText.trim());


                    if(location.href.match('reserve_beauty_day')){
                        schedule_render(id);
                    }else if(location.href.match('reserve_beauty_week')){


                        localStorage.setItem('select_row',el.parentElement.getAttribute('data-row'))

                        schedule_render_week(el,id).then(function(data){

                            let body_ = data[0];
                            let parent = data[1]



                            week_working(id).then(function (body_data){



                                body_data.forEach(function(el){

                                    Array.from(document.getElementsByClassName('header-worker')).forEach(function(el_){

                                        if(el_.getAttribute('data-worker') === el.name){

                                            el.work.forEach(function(_el){
                                                el_.setAttribute(`data-week-${_el.week}`,`${_el.week}|${_el.time_st}|${_el.time_fi}`)
                                            })


                                        }
                                    })
                                })




                                reserve_schedule_week_cols(body_data,body_,parent,id,session_id)
                                reserve_schedule_week(id,body_data).then(function(_body){





                                    if(document.getElementById('week_schedule_card_body')){
                                        document.getElementById('week_schedule_card_body').style.display = 'block';
                                        document.getElementById('week_schedule_loading').style.display ='none';
                                        document.getElementById('btn-schedule-prev').removeAttribute('disabled');
                                        document.getElementById('btn-schedule-next').removeAttribute('disabled');
                                        week_timebar();
                                        week_drag();

                                    }

                                        //console.log(new Date().toISOString())



                                    document.getElementById('grid_layout_inner').children[0].children[0].click();
                                    let test = document.getElementsByClassName('week-date');

                                    let text = [''];
                                    Array.from(test).forEach(function (el){
                                        text.push(el.innerText)
                                    })

                                    for(let i=0; i<text.length; i++){
                                        Array.from(document.getElementsByClassName('calendar-week-body-row')).forEach(function(el){

                                            if(el.children[i].classList.contains('calendar-week-body-col-add')){
                                                el.children[i].setAttribute('data-date',text[i])
                                            }

                                        })
                                    }



                                    if(localStorage.getItem('change_check') === '1'){

                                        setTimeout(function(){


                                            guide_reserve();



                                        },100)
                                    }

                                    if(sessionStorage.getItem('direct_new') === '1'){
                                        direct_new(id,sessionStorage.getItem('direct_cellphone')).then(function(){direct_event(id,session_id)});
                                    }else{
                                        direct_event(id,session_id)
                                    }






                                });

                            })

                        });



                    }else if(location.href.match('reserve_beauty_list')){


                        schedule_render_list(id).then(function(body){

                            _schedule_render_list(body)
                        })
                    }

                })


                let day = localStorage.getItem('day_select') !== null ? localStorage.getItem('day_select').split('.')[2] : date.getDate();
                if(fill_zero(el.children[0].children[0].children[0].children[0].innerText.trim()) === day && !el.classList.contains('after') && !el.classList.contains('before')){
                    el.click();

                }




            })
            if(localStorage.getItem('day_select') === null){

                document.querySelector('.today').click()
            }


        })

}



//배너 렌더링
function banner() {
    let swiper = document.querySelector('.swiper-wrapper');
    for (let i = 0; i < data.banner.length; i++) {

        swiper.innerHTML += `<div class="swiper-slide"><a href="${data.banner[i]?.link}" class="btn-basic-swiper-banner-nav"><img src="https://image.banjjakpet.com${data.banner[i]?.image.toString().substr(0,5) === '/pet/' ? data.banner[i].image.toString().replace('/pet', '') :data.banner[i]?.image}" alt=""/></a></div>`
    }
}




//wide-tab // 활성화할 wide-tab 에 id 부여
function wide_tab(){
    let tab_cell = document.getElementById('wide-tab-inner').children;

    Array.from(tab_cell).forEach(function (el) {

        el.addEventListener('click', function () {
            if (!this.classList.contains('actived')) {


                Array.from(tab_cell).forEach(function (el) {
                    el.classList.remove('actived');
                })

                this.classList.add('actived');
            } else {
                return;
            }
        })
    })
}

function wide_tab_2(){
    let tab_cell = document.getElementById('wide-tab-inner2').children;

    Array.from(tab_cell).forEach(function (el) {

        el.addEventListener('click', function () {
            if (!this.classList.contains('actived')) {

                Array.from(tab_cell).forEach(function (el) {
                    el.classList.remove('actived');
                })

                this.classList.add('actived');
            } else {
                return;
            }
        })
    })
}


function wide_tab_3(){
    let tab_cell = document.getElementById('wide-tab-inner3').children;

    Array.from(tab_cell).forEach(function (el) {

        el.addEventListener('click', function () {
            if (!this.classList.contains('actived')) {

                Array.from(tab_cell).forEach(function (el) {
                    el.classList.remove('actived');
                })

                this.classList.add('actived');
            } else {
                return;
            }
        })
    })
}


//notice
function notice(){

    let main_notice_list = document.querySelector('.main-notice-list');

    for (let i = 0; i < data.notice.length; i++) {
        main_notice_list.innerHTML += `<div class="main-notice-cell">
                                        <a href="/etc/other_notice_list.php" class="btn-main-notice-item">
                                            <div class="txt">${data.notice[i].title}</div>
                                            <div class="date">${data.notice[i].reg_date.split(" ")[0]}</div>
                                        </a>
                                   </div>`
    }
}




//정기휴일
function holiday(id){


    let week = location.href.match('reserve_beauty_week');
    let body_col = document.getElementsByClassName('calendar-week-body-col-add');

    $.ajax({
        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'holiday',
            login_id:id
        },
        success:function(res){
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body[0];
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {


                let body_rows;
                if(body !== undefined){


                    switch (parseInt(body.week_type)){
                        case 1 : if(document.getElementsByClassName('mini-calendar-month-header-row').length >0){
                            body_rows = document.getElementsByClassName('mini-calendar-month-body-row');
                        }else{
                            body_rows = document.getElementsByClassName('main-calendar-month-body-row');
                        }
                            break;
                        case 2 : body_rows = document.getElementsByClassName('1or3');
                            break;
                        case 3 : body_rows = document.getElementsByClassName('2or4');
                            break;
                        default :break;
                    }
                    if(body.is_work_sun) {
                        Array.from(body_rows).forEach(function(el){
                            if(el.childNodes.length !== 0){
                                el.childNodes[0].classList.add('break');
                            }
                        })

                        if(week){

                            Array.from(body_col).forEach(function(el_){

                                if(el_.getAttribute('data-day') === 0){

                                    el_.classList.add('break')
                                }
                            })

                        }
                    }
                    if(body.is_work_mon){
                        Array.from(body_rows).forEach(function(el){
                            if(el.childNodes.length !== 0){
                                el.childNodes[1].classList.add('break');
                            }
                        })

                        if(week){

                            Array.from(body_col).forEach(function(el_){

                                if(el_.getAttribute('data-day') === 1){

                                    el_.classList.add('break')
                                }
                            })

                        }
                    }
                    if(body.is_work_tue){
                        Array.from(body_rows).forEach(function(el){
                            if(el.childNodes.length !== 0){
                                el.childNodes[2].classList.add('break');
                            }
                        })

                        if(week){

                            Array.from(body_col).forEach(function(el_){

                                if(el_.getAttribute('data-day') === 2){

                                    el_.classList.add('break')
                                }
                            })

                        }
                    }
                    if(body.is_work_wed){
                        Array.from(body_rows).forEach(function(el){
                            if(el.childNodes.length !== 0){
                                el.childNodes[3].classList.add('break');
                            }
                        })

                        if(week){

                            Array.from(body_col).forEach(function(el_){

                                if(el_.getAttribute('data-day') === 3){

                                    el_.classList.add('break')
                                }
                            })

                        }

                    }
                    if(body.is_work_thu){
                        Array.from(body_rows).forEach(function(el){
                            if(el.childNodes.length !== 0){
                                el.childNodes[4].classList.add('break');
                            }
                        })

                        if(week){

                            Array.from(body_col).forEach(function(el_){

                                if(el_.getAttribute('data-day') === 4){

                                    el_.classList.add('break')
                                }
                            })

                        }
                    }
                    if(body.is_work_fri){
                        Array.from(body_rows).forEach(function(el){
                            if(el.childNodes.length !== 0){
                                el.childNodes[5].classList.add('break');
                            }
                        })
                        if(week){

                            Array.from(body_col).forEach(function(el_){

                                if(el_.getAttribute('data-day') === 5){

                                    el_.classList.add('break')
                                }
                            })

                        }
                    }
                    if(body.is_work_sat){
                        Array.from(body_rows).forEach(function(el){
                            if(el.childNodes.length !== 0){
                                el.childNodes[6].classList.add('break');
                            }
                        })
                        if(week){

                            Array.from(body_col).forEach(function(el_){

                                if(el_.getAttribute('data-day') === 6){

                                    el_.classList.add('break')
                                }
                            })

                        }
                    }
                }
            }

        }
    })


}
function array_empty(arr){

    if (!Array.isArray(arr)) {
        return false;
    }
    return arr.length == 0;

}
// 발송실패 알림톡 문자조회
function mms_log(cellphone,date,seq){
    var txt = '';
    $.ajax({
        url: '../data/mms_alarm_inquiry.php',
        data: {
            cellphone:cellphone,
            date: date,
            seq: seq,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            ////console.log(res);
            let response = JSON.parse(res);
            ////console.log(response);
            txt = response.data;
        }
    })
    return txt;
}

function between(int,int2){

    let result =[];

    for(let i=int; i<=int2; i++){

        result.push(i);
    }

    return result;

}



var gallery = {

    element : null,
    swiper : null,
    swiperCur : 0,
    swiperLen : -1,

    init : function(){
        gallery.element = $('.gallery-pop-wrap');
        gallery.swiperLen = gallery.element.find('.swiper-slide').length;
        gallery.swiper = new Swiper( gallery.element.find('.swiper-container')[0] , {
            loop : false,
            slidesPerView : 1 ,
            spaceBetween : 0,
            simulateTouch : true,
            speed : 450,
            navigation: {
                nextEl: gallery.element.find('.btn-swiper-slider-next')[0],
                prevEl: gallery.element.find('.btn-swiper-slider-prev')[0]
            }
        });
        gallery.swiper.on('slideChange' , function(){
            gallery.swiperCur = this.realIndex;
            gallery.pageSort();
        });
        gallery.pageSort();

        $(document).on('click' , '.btn-gallery-thumb-nav' , function(){
            var $index = $(this).index();
            gallery.swiper.slideTo($index , 450);
        });
    },
    pageSort : function(){
        var _value = '<em>' + String((gallery.swiperCur + 1) + '</em> / ' + gallery.swiperLen);
        gallery.element.find('.swiper-page').html(_value);
        gallery.element.find('.gallery-thumb-list > .btn-gallery-thumb-nav').eq(gallery.swiperCur).addClass('actived').siblings().removeClass('actived');
    },

    dataSet : function(imgList){
        //샘플링 데이타
        // -> <div class="swiper-slide"><div class="slider-item"><img src="/static/pub/images/gate_picture.jpg" alt=""/></div></div>
        var i = 0;
        var len = Math.floor(Math.random() * (14 - 1)) + 1;
        var result = '';
        var resultThumb = '';
        for(i = 0; i < imgList.length; i++){
            result += '<div class="swiper-slide"><div class="slider-item hide">';
            result += '<span class="loading-bar"><span class="sk-fading-circle"><span class="sk-circle1 sk-circle"></span><span class="sk-circle2 sk-circle"></span><span class="sk-circle3 sk-circle"></span><span class="sk-circle4 sk-circle"></span><span class="sk-circle5 sk-circle"></span><span class="sk-circle6 sk-circle"></span><span class="sk-circle7 sk-circle"></span><span class="sk-circle8 sk-circle"></span><span class="sk-circle9 sk-circle"></span><span class="sk-circle10 sk-circle"></span><span class="sk-circle11 sk-circle"></span><span class="sk-circle12 sk-circle"></span></span></span>	';
            result += '<img src="'+imgList[i]+'" alt="" />';
            result += '</div></div>';

            resultThumb += '<a type="button" class="btn-gallery-thumb-nav hide">';
            resultThumb += '<span class="loading-bar"><span class="sk-fading-circle"><span class="sk-circle1 sk-circle"></span><span class="sk-circle2 sk-circle"></span><span class="sk-circle3 sk-circle"></span><span class="sk-circle4 sk-circle"></span><span class="sk-circle5 sk-circle"></span><span class="sk-circle6 sk-circle"></span><span class="sk-circle7 sk-circle"></span><span class="sk-circle8 sk-circle"></span><span class="sk-circle9 sk-circle"></span><span class="sk-circle10 sk-circle"></span><span class="sk-circle11 sk-circle"></span><span class="sk-circle12 sk-circle"></span></span></span>';
            resultThumb += '<img src="'+imgList[i]+'" alt="" >';
            resultThumb += '</button>';
        };

        //데이타 삽입
        gallery.element.find('.swiper-wrapper').html(result);
        gallery.element.find('.gallery-thumb-list').html(resultThumb);

        gallery.element.find('.swiper-wrapper .slider-item').each(function(){
            $(this).imagesLoaded().always(function(instance){
                ////console.log('model image loaded');
            }).done(function(instance){
                $(instance.elements).removeClass('hide');
            }).fail( function(){
                //alert('프로필 이미지가 없습니다.');
            }).progress(function(instance,image){

            });
        });

        gallery.element.find('.gallery-thumb-list .btn-gallery-thumb-nav').each(function(){
            $(this).imagesLoaded().always(function(instance){
                ////console.log('model image loaded');
            }).done(function(instance){
                $(instance.elements).removeClass('hide');
            }).fail( function(){
                //alert('프로필 이미지가 없습니다.');
            }).progress(function(instance,image){

            });
        });

        //데이타 삽입 후 재설정
        gallery.swiperCur = 0;
        gallery.swiperLen = i;

        //데이타 삽입 후 재정렬
        gallery.viewUpdate();
        gallery.pageSort();
    },

    open : function(startIndex){
        gallery.element.addClass('actived');
        gallery.viewUpdate();
        gallery.swiper.slideTo(startIndex,0);
    },
    close : function(){
        gallery.element.removeClass('actived');
    },
    viewModeChange : function(obj){
        if($(obj).hasClass('actived')){
            //리스트 비활성화

            document.getElementById('sw-con').style.width = 'auto';
            document.getElementById('ga-da').style.height = 'auto';
            document.getElementById('ga-sl').style.height = 'auto';
            document.getElementById('ga-sl').style.width = 'auto';
            document.getElementById('ga-btn').style.right = '0';
            $(obj).removeClass('actived');
            gallery.element.removeClass('thumb');
        }else{
            //리스트 활성화
            document.getElementById('sw-con').style.width = '100%';
            document.getElementById('ga-da').style.height = '80%';
            document.getElementById('ga-sl').style.height = '100%';
            document.getElementById('ga-sl').style.width = '70%';
            document.getElementById('ga-btn').style.right = '15%';
            $(obj).addClass('actived')

            gallery.element.addClass('thumb');
        }

        setTimeout(function(){
            if(gallery.swiper) gallery.viewUpdate();
        } , 300);
    },
    viewUpdate : function(){
        gallery.swiper.update();
        gallery.swiper.updateSize();
        gallery.swiper.updateSlides();
        gallery.swiper.updateProgress();
    }
};

function showReviewGallery(startIndex, img_list){
    var imgs	= img_list.split('|');
    $.each(imgs, function(i,v){
        if(imgs[i].substr(0,7) === '/static'){
            imgs[i] = imgs[i]
        }else{

            imgs[i] = img_link_change(imgs[i]);
        }
    });
    // imgs.forEach(element => {
    //     element = img_link_change(element);
    // });
    //console.log(imgs);
    gallery.dataSet(imgs);
    gallery.open(startIndex);
};


function thumb_view(e,img){

    event.preventDefault();
    event.stopPropagation();
    showReviewGallery(0,img);

}

function minutes_to_hour(minutes){

    let hours = Math.floor(minutes/60);
    let min = minutes%60;


    return `${hours !== 0 ? hours : ''}${hours !== 0 ? '시간 ':''}${min !== 0 ? min : ''}${min !== 0 ? '분' :''}`

}


let banks = [
    {
        code : '003',
        name : '기업은행'
    },{
        code : '004',
        name : '국민은행'
    },{
        code : '011',
        name : '농협중앙회'
    },{
        code : '012',
        name : '단위농협'
    },{
        code : '020',
        name : '우리은행'
    },{
        code : '031',
        name : '대구은행'
    },{
        code : '005',
        name : '외환은행'
    },{
        code : '023',
        name : 'SC제일은행'
    },{
        code : '032',
        name : '부산은행'
    },{
        code : '045',
        name : '새마을금고'
    },{
        code : '027',
        name : '한국씨티은행'
    },{
        code : '034',
        name : '광주은행'
    },{
        code : '039',
        name : '경남은행'
    },{
        code : '007',
        name : '수협'
    },{
        code : '048',
        name : '신협'
    },{
        code : '037',
        name : '전북은행'
    },{
        code : '035',
        name : '제주은행'
    },{
        code : '064',
        name : '산림조합'
    },{
        code : '071',
        name : '우체국'
    },{
        code : '081',
        name : '하나은행'
    },{
        code : '088',
        name : '신한은행'
    },{
        code : '090',
        name : '카카오뱅크'
    },{
        code : '209',
        name : '동양종금증권'
    },{
        code : '243',
        name : '한국투자증권'
    },{
        code : '240',
        name : '삼성증권'
    },{
        code : '230',
        name : '미래에셋'
    },{
        code : '247',
        name : '우리투자증권'
    },{
        code : '218',
        name : '현대증권'
    },{
        code : '266',
        name : 'SK증권'
    },{
        code : '278',
        name : '신한금융투자'
    },{
        code : '262',
        name : '하이증권'
    },{
        code : '263',
        name : 'HMC증권'
    },{
        code : '267',
        name : '대신증권'
    },{
        code : '270',
        name : '하나대투증권'
    },{
        code : '279',
        name : '동부증권'
    },{
        code : '280',
        name : '유진증권'
    },{
        code : '287',
        name : '메리츠증권'
    },{
        code : '291',
        name : '신영증권'
    },{
        code : '238',
        name : '대우증권'
    }

]


function allimi_btn_event(){

    Array.from(document.getElementsByClassName('allimi-check-title')).forEach(function(el){

        el.addEventListener('click',function(){

            Array.from(document.getElementsByClassName('allimi-check-list')).forEach(function(el_){
                el_.style.display = 'none';

            })
            // Array.from(document.getElementsByClassName('allimi-check-title')).forEach(function(_el){
            //     _el.classList.remove('actived');
            // })
            // el.classList.add('actived');




            if(el.getAttribute('id') === 'attitude_btn'){

                if(document.getElementById('check_list_attitude').style.display === 'none'){
                    document.getElementById('check_list_attitude').style.display = 'inline-flex';
                }
            }else if(el.getAttribute('id') === 'tangle_btn'){
                if(document.getElementById('check_list_tangle').style.display === 'none'){
                    document.getElementById('check_list_tangle').style.display = 'inline-flex';
                }

            }else if(el.getAttribute('id')==='bath_btn'){
                if(document.getElementById('check_list_bath').style.display === 'none'){
                    document.getElementById('check_list_bath').style.display = 'inline-flex';

                }

            }else if(el.getAttribute('id')==='skin_btn'){
                if(document.getElementById('check_list_skin').style.display === 'none'){
                    document.getElementById('check_list_skin').style.display = 'inline-flex';

                }
            }else if(el.getAttribute('id')==='condition_btn'){
                if(document.getElementById('check_list_condition').style.display === 'none'){
                    document.getElementById('check_list_condition').style.display = 'inline-flex';

                }
            }else if(el.getAttribute('id')==='dislike_btn'){
                if(document.getElementById('check_list_dislike').style.display === 'none'){
                    document.getElementById('check_list_dislike').style.display = 'inline-flex';

                }
            }else if(el.getAttribute('id')==='self_btn'){
                if(document.getElementById('check_list_self').style.display === 'none'){
                    document.getElementById('check_list_self').style.display = 'inline-flex';

                }
            }

        })
    })

    Array.from(document.getElementsByClassName('allimi-form-one')).forEach(function(el){

        el.addEventListener('click',function(){


            if(el.parentElement.getAttribute('id') === 'check_list_attitude'){

                if(el.getAttribute('id') === 'attitude_etc'){

                    document.getElementById('allimi_attitude_textarea').style.display = 'block';
                }else{
                    document.getElementById('allimi_attitude_textarea').style.display = 'none';
                }


            }

            if(el.parentElement.getAttribute('id')==='check_list_tangle'){

                if(el.getAttribute('id') === 'tangle_etc'){

                    if(document.getElementById('allimi_tangle_textarea').style.display === 'block'){

                        document.getElementById('allimi_tangle_textarea').style.display = 'none';
                    }else{

                        document.getElementById('allimi_tangle_textarea').style.display = 'block';
                    }

                }
            }

            if(el.parentElement.getAttribute('id')==='check_list_bath'){

                if(el.getAttribute('id') === 'bath_etc'){

                    document.getElementById('allimi_bath_textarea').style.display = 'block';
                }else{
                    document.getElementById('allimi_bath_textarea').style.display = 'none';
                }
            }

            if(el.parentElement.getAttribute('id')==='check_list_skin'){

                if(el.getAttribute('id') === 'skin_etc'){

                    if(document.getElementById('allimi_skin_textarea').style.display === 'block'){

                        document.getElementById('allimi_skin_textarea').style.display = 'none';
                    }else{

                        document.getElementById('allimi_skin_textarea').style.display = 'block';
                    }

                }
            }

            if(el.parentElement.getAttribute('id')==='check_list_condition'){

                if(el.getAttribute('id') === 'condition_etc'){

                    document.getElementById('allimi_condition_textarea').style.display = 'block';
                }else{
                    document.getElementById('allimi_condition_textarea').style.display = 'none';
                }
            }

            if(el.parentElement.getAttribute('id')==='check_list_dislike'){

                if(el.getAttribute('id') === 'dislike_etc'){

                    if(document.getElementById('allimi_dislike_textarea').style.display === 'block'){

                        document.getElementById('allimi_dislike_textarea').style.display = 'none';
                    }else{

                        document.getElementById('allimi_dislike_textarea').style.display = 'block';
                    }

                }
            }

            if(el.parentElement.getAttribute('id')==='check_list_self'){

                if(el.getAttribute('id') === 'self_etc'){

                    if(document.getElementById('allimi_self_textarea').style.display === 'block'){

                        document.getElementById('allimi_self_textarea').style.display = 'none';
                    }else{

                        document.getElementById('allimi_self_textarea').style.display = 'block';
                    }

                }
            }


        })
    })
}

function allimi_send_pop(target,id){

    event.preventDefault()
    event.stopPropagation();


    let week = ['일','월','화','수','목','금','토']

    let payment_idx = target.getAttribute('data-payment_idx');
    let pet_seq = target.getAttribute('data-pet_seq');
    let cellphone = target.getAttribute('data-cellphone');
    let pet_name = target.getAttribute('data-pet_name');
    let beauty_date = target.getAttribute('data-date').replace(' ','T');

    document.getElementById('allimi_history_btn').setAttribute('data-artist_id',id);
    document.getElementById('allimi_history_btn').setAttribute('data-cellphone',cellphone);
    document.getElementById('allimi_history_btn').setAttribute('data-pet_seq',pet_seq);

    document.getElementById('allimi_preview_btn').setAttribute('data-artist_id',id);
    let date_ = new Date(beauty_date);
    let date = `${date_.getFullYear()}년 ${date_.getMonth()+1}월 ${date_.getDate()}일(${week[date_.getDay()]})`


    document.getElementById('allimi_date').innerText = date;

    document.getElementById('allimi_pet_list').innerHTML ='';
    document.getElementById('allimi_pet_list').innerHTML += `<label class="allimi-form">
                                                                            <input type="checkbox" name="allimi-pet" onclick="allimi_get_gallery(this,'${id}')" data-artist_id="${id}" data-pet_name="${pet_name}" data-cellphone="${cellphone}" data-payment_idx="${payment_idx}" data-pet_seq="${pet_seq}">
                                                                            <em></em>
                                                                            <span class="allimi-radio-span">${pet_name}</span>
                                                                        </label>`

    document.getElementById('allimi_open_gallery').setAttribute('data-payment_idx',payment_idx);
    document.getElementById('allimi_open_gallery').setAttribute('data-pet_seq',pet_seq);
    document.getElementById('allimi_open_gallery').setAttribute('data-cellphone',cellphone);
    document.getElementById('allimi_open_gallery').setAttribute('data-pet_name',pet_name);

    document.getElementById('allimi_select_photo').setAttribute('data-payment_idx',payment_idx);
    document.getElementById('allimi_select_photo').setAttribute('data-pet_seq',pet_seq);
    document.getElementById('allimi_select_photo').setAttribute('data-cellphone',cellphone);
    document.getElementById('allimi_select_photo').setAttribute('data-pet_name',pet_name);


    pop.open('allimi_pop')
}

function allimi_open_gallery(){


    document.getElementById('allimi-right-title').innerText = '미용 갤러리';
    document.getElementById('allimi_gallery').style.display = 'flex';

    document.getElementById('allimi_defalut').style.opacity = '0';
    document.getElementById('allimi_preview').style.opacity = '0';
    document.getElementById('allimi_history').style.opacity = '0';




    setTimeout(function(){
        document.getElementById('allimi_gallery').style.opacity = '1';
        document.getElementById('allimi_defalut').style.display ='none';
        document.getElementById('allimi_preview').style.display ='none';
        document.getElementById('allimi_history').style.display ='none';


    },200)




}


function allimi_open_history(target){

    let artist_id = target.getAttribute('data-artist_id');
    let cellphone = target.getAttribute('data-cellphone');
    let pet_seq = target.getAttribute('data-pet_seq');



    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'get_allimi_history',
            artist_id:artist_id,
            cellphone:cellphone,
            pet_seq:pet_seq

        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                console.log(body)
            }
        }


    })

    document.getElementById('allimi-right-title').innerText = '알리미 발송이력';
    document.getElementById('allimi_history').style.display = 'flex';

    document.getElementById('allimi_defalut').style.opacity = '0';
    document.getElementById('allimi_preview').style.opacity = '0';
    document.getElementById('allimi_gallery').style.opacity = '0';




    setTimeout(function(){
        document.getElementById('allimi_history').style.opacity = '1';
        document.getElementById('allimi_defalut').style.display ='none';
        document.getElementById('allimi_preview').style.display ='none';
        document.getElementById('allimi_gallery').style.display ='none';


    },200)




}

function allimi_open_preview(target){


    let artist_id = target.getAttribute('data-artist_id');

    $.ajax({
        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'get_shop_info_2',
            artist_id:artist_id,
        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                document.getElementById('allimi_preview_shop_title').innerText = body.shop_name;
                document.getElementById('allimi_preview_shop_phone').innerText = body.phone;
                document.getElementById('allimi_preview_shop_address').innerText = body.address.split('|')[1];
                //
                // var view_address = body.address.split('|')[1];
                // var lat = '';
                // var lng = '';
                // var mapContainer = document.getElementById('allimi_preview_shop_map'); // 지도를 표시할 div
                // var mapOption = {
                //     center: new daum.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
                //     level: 3 // 지도의 확대 레벨
                // };
                //
                //     // 지도를 생성합니다
                //     var map = new daum.maps.Map(mapContainer, mapOption);
                //
                //     // 주소-좌표 변환 객체를 생성합니다
                //     var geocoder = new daum.maps.services.Geocoder();
                //
                //     var coords = new daum.maps.LatLng(lat, lng);
                //
                //     // 결과값으로 받은 위치를 마커로 표시합니다
                //     var marker = new daum.maps.Marker({
                //         map: map,
                //         position: coords
                //     });
                //     // 인포윈도우로 장소에 대한 설명을 표시합니다
                //     var infowindow = new daum.maps.InfoWindow({
                //         content: '<div style="width: 300px;text-align:center;padding:6px 0;">'+view_address+'</div>'
                //     });
                //     infowindow.open(map, marker);
                //
                //     // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
                //     map.setCenter(coords);



            }
        }
    })

    if(document.querySelector('input[name="allimi-pet"]:checked') === null){

        document.getElementById('msg1_txt').innerText = '이용펫을 선택해주세요.';
        pop.open('reserveAcceptMsg1');
        return;
    }
    let attitude = document.querySelector('input[name="attitude"]:checked') === null ? '' : document.querySelector('input[name="attitude"]:checked').value
    let tangle = document.querySelectorAll('input[name="tangle"]:checked') === null ? '' : document.querySelectorAll('input[name="tangle"]:checked');
    let bath = document.querySelector('input[name="bath"]:checked') === null ? '' :document.querySelector('input[name="bath"]:checked').value
    let skin = document.querySelectorAll('input[name="skin"]:checked') === null ? '' :document.querySelectorAll('input[name="skin"]:checked');
    let condition =document.querySelector('input[name="condition"]:checked') === null ? '' : document.querySelector('input[name="condition"]:checked').value
    let dislike = document.querySelectorAll('input[name="dislike"]:checked') === null ? '' :document.querySelectorAll('input[name="dislike"]:checked');
    let self = document.querySelectorAll('input[name="self"]:checked') === null ? '' : document.querySelectorAll('input[name="self"]:checked');


    console.log(tangle);
    console.log(skin);
    console.log(dislike);




    let attitude_text, tangle_text,bath_text,skin_text,condition_text,dislike_text,self_text;

    document.getElementById('allimi_preview_attitude_wrap').style.display ='list-item';
    document.getElementById('allimi_preview_tangle_wrap').style.display ='list-item';
    document.getElementById('allimi_preview_bath_wrap').style.display ='list-item';
    document.getElementById('allimi_preview_skin_wrap').style.display ='list-item';
    document.getElementById('allimi_preview_condition_wrap').style.display ='list-item';
    document.getElementById('allimi_preview_dislike_wrap').style.display ='list-item';
    document.getElementById('allimi_preview_self_wrap').style.display ='list-item';

    document.getElementById('allimi_preview_gallery').style.display = 'block';
    tangle_text ='';
    skin_text = '';
    dislike_text = '';
    self_text = '';
    switch(attitude){
        case '1' : attitude_text = '아주 잘 했어요. 칭찬해 주세요.'; break;
        case '2' : attitude_text = '좋아요.'; break;
        case '3' : attitude_text = '힘들어해요.'; break;
        case '0' : attitude_text =  document.getElementById('allimi_attitude_textarea').value; break;
        default : attitude_text = ''; document.getElementById('allimi_preview_attitude_wrap').style.display = 'none'; break;
    }

    switch(bath){
        case '1' : bath_text = '잘해요.'; break;
        case '2' : bath_text = '조금 싫어해요.'; break;
        case '3' : bath_text = '거부감이 있어요.'; break;
        case '0' : bath_text =  document.getElementById('allimi_bath_textarea').value; break;
        default : bath_text = ''; document.getElementById('allimi_preview_bath_wrap').style.display = 'none';  break;
    }

    switch(condition){
        case '1' : condition_text = '좋아요.'; break;
        case '2' : condition_text = '긴장했어요.'; break;
        case '3' : condition_text = '피곤해 해요.'; break;
        case '0' : condition_text =  document.getElementById('allimi_condition_textarea').value; break;
        default : condition_text = ''; document.getElementById('allimi_preview_condition_wrap').style.display ='none'; break;
    }

    console.log(tangle);
    let tangle_values = [];
    let skin_values = [];
    let dislike_values = [];
    let self_values = [];
    Array.from(tangle).forEach(function(el){

        tangle_values.push(el.value);
    })
    Array.from(skin).forEach(function(el){

        skin_values.push(el.value);
    })
    Array.from(dislike).forEach(function(el){

        dislike_values.push(el.value);
    })
    Array.from(self).forEach(function(el){

        self_values.push(el.value);
    })


    tangle_values.forEach(function(el){
        switch (el){
            case '1': tangle_text += '없어요. '; break;
            case '2': tangle_text += '얼굴 '; break;
            case '3': tangle_text += '귀 '; break;
            case '4': tangle_text += '겨드랑이 '; break;
            case '5': tangle_text += '다리 '; break;
            case '6': tangle_text += '꼬리 '; break;
            case '0': tangle_text += document.getElementById('allimi_tangle_textarea').value; break;
        }
    })

    skin_values.forEach(function(el){
        switch (el){
            case '1': skin_text += '깨끗해요. '; break;
            case '2': skin_text += '피부염 '; break;
            case '3': skin_text += '각질 '; break;
            case '4': skin_text += '붉은기 '; break;
            case '5': skin_text += '습진 '; break;
            case '6': skin_text += '농피증 '; break;
            case '7': skin_text += '알로페시아 '; break;
            case '0': skin_text += document.getElementById('allimi_skin_textarea').value; break;
        }
    })

    dislike_values.forEach(function(el){
        switch (el){
            case '1': dislike_text += '얼굴 '; break;
            case '2': dislike_text += '귀 '; break;
            case '3': dislike_text += '앞발 '; break;
            case '4': dislike_text += '뒷발 '; break;
            case '5': dislike_text += '발톱 '; break;
            case '6': dislike_text += '꼬리 '; break;
            case '0': dislike_text += document.getElementById('allimi_dislike_textarea').value; break;

        }
    })

    self_values.forEach(function(el){
        switch (el){
            case '1': self_text += '피부 자극으로 긁거나 핥을 수 있으니 주의해주세요. \n'; break;
            case '2': self_text += '스트레스로 인하여 식욕 부진, 구토 및 설사 증상을 보일 수 있습니다. \n'; break;
            case '3': self_text += '항문을 끌고 다니거나 꼬리를 감추는 증상을 보일 수 있습니다. \n'; break;
            case '4': self_text += '이중모(포메,스피츠 등)의 경우 미용 후 알로페시아(클리퍼 증후군) 현상이 나타날 수 있습니다. \n'; break;
            case '0': self_text += document.getElementById('allimi_self_textarea').value; break;
        }
    })

    console.log(tangle_values);
    console.log(tangle_text);

    if(tangle_text === ''){

        document.getElementById('allimi_preview_tangle_wrap').style.display = 'none';

    }

    if(skin_text === ''){

        document.getElementById('allimi_preview_skin_wrap').style.display = 'none';

    }
    if(dislike_text === ''){

        document.getElementById('allimi_preview_dislike_wrap').style.display = 'none';

    }

    if(self_text === ''){

        document.getElementById('allimi_preview_self_wrap').style.display = 'none';

    }

    if(attitude_text === '' && tangle_text === '' && bath_text ==='' && skin_text === '' && condition_text === '' && dislike_text === '' && self_text === ''){

        document.getElementById('allimi_preview_none').style.display = 'list-item';

    }else{

        document.getElementById('allimi_preview_none').style.display = 'none';
    }



    document.getElementById('allimi_preview_attitude').innerText = attitude_text;
    document.getElementById('allimi_preview_tangle').innerText = tangle_text;
    document.getElementById('allimi_preview_bath').innerText = bath_text;
    document.getElementById('allimi_preview_skin').innerText = skin_text;
    document.getElementById('allimi_preview_condition').innerText = condition_text;
    document.getElementById('allimi_preview_dislike').innerText = dislike_text;
    document.getElementById('allimi_preview_self').innerText = self_text;


    document.getElementById('allimi-right-title').innerText = '알리미 미리보기';

    document.getElementById('allimi_preview').style.display = 'flex';
    document.getElementById('allimi_defalut').style.opacity = '0';
    document.getElementById('allimi_history').style.opacity = '0';


    document.getElementById('allimi_gallery').style.opacity = '0';

    setTimeout(function(){
        document.getElementById('allimi_preview').style.opacity = '1';
        document.getElementById('allimi_defalut').style.display ='none';
        document.getElementById('allimi_gallery').style.display ='none';
        document.getElementById('allimi_history').style.display ='none';


    },200)




    let preview_photos = [];

    Array.from(document.getElementsByClassName('allimi-gallery-cell')).forEach(function(el){

        if(!el.classList.contains('allimi-gallery-cell-icon')){
            preview_photos.push(el.children[1].getAttribute('src'));
        }
    })


    console.log(preview_photos);

    if(preview_photos.length === 0){
        document.getElementById('allimi_preview_gallery').style.display ='none';
    }

    document.getElementById('allimi-preview-swiper').innerHTML = '';

    document.getElementById('allimi_preview_date').innerText = document.getElementById('allimi_date').innerText;
    document.getElementById('allimi_preview_name').innerText = document.querySelector('input[name="allimi-pet"]:checked').getAttribute('data-pet_name');

    preview_photos.forEach(function(el){

        document.getElementById('allimi-preview-swiper').innerHTML += `<div class="swiper-slide allimi-slide">
                                                                                            <img src="${el}" alt="" />
                                                                                    </div>`
    })








}

function allimi_get_gallery(target,id){

    let payment_idx = target.getAttribute('data-payment_idx');
    let pet_seq = target.getAttribute('data-pet_seq');
    let cellphone = target.getAttribute('data-cellphone');
    let pet_name = target.getAttribute('data-pet_name');

    document.getElementById('allimi_gallery_list').innerHTML = `<div class="allimi-gallery-list-cell"><a href="#" class="btn-gate-picture-register" onclick="allimi_MemofocusNcursor()"><span><em>이미지 추가</em></span></a></div>`

    console.log(id)

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'beauty_gal_get',
            idx:pet_seq,
            artist_id:id,
        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                console.log(body);
                body.forEach(function(el){

                    document.getElementById('allimi_gallery_list').innerHTML += `<div class="allimi-gallery-list-cell list-cell">
                                                                                                <label>
                                                                                                    <div class="allimi-picture-thumb-view">
                                                                                                        <div class="allimi-picture-obj" onclick=""><img src="${img_link_change(el.file_path)}" alt=""></div>
                                                                                                        <div class="allimi-picture-date">${el.upload_dt.substr(0,4)}.${el.upload_dt.substr(4,2)}.${el.upload_dt.substr(6,2)}</div>
                                                                                                        <div class="allimi-picture-ui">
                                                                                                           <input type="checkbox" name="allimi-gallery-select" class="allimi-picture-select" data-file_path="${el.file_path}">
                                                                                                           <em></em>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </label>
                                                                                            </div>`
                })
            }
        }
    })

    allimi_beauty_gallery_add(id,pet_seq,payment_idx);

}

function allimi_select_photo(target){


    let payment_idx = target.getAttribute('data-payment_idx');
    let cellphone = target.getAttribute('data-cellphone');
    let pet_name = target.getAttribute('data-pet_name');
    let pet_seq = target.getAttribute('data-pet_seq');


    let elements = document.querySelectorAll('input[name="allimi-gallery-select"]:checked');

    let photos = [];

    Array.from(elements).forEach(function(el){

        photos.push(el.getAttribute('data-file_path'));
    })

    console.log(photos);
    document.getElementById('allimi_gallery_wrap').innerHTML = `<div class="allimi-gallery-cell allimi-gallery-cell-icon" style="cursor:pointer;" data-payment_idx="${payment_idx}" data-cellphone="${cellphone}" data-pet_name="${pet_name}" data-pet_seq="${pet_seq}" onclick="allimi_open_gallery()">
                                                                            <img src="/static/images/icon/photo_icon.png" alt="">
                                                                            <span class="allimi-gallery-span">사진첨부</span>
                                                                        </div>`

    if(photos.length >0){

        photos.forEach(function(el){

            document.getElementById('allimi_gallery_wrap').innerHTML += `<div class="allimi-gallery-cell" data-file_path="${el}" >
                                                                                        <div class="allimi-gallery-cell-delete" onclick="allimi_delete_photo(this)">
                                                                                            <img src="/static/images/icon/10-ic-24-close-white@2x.png" alt=""> 
                                                                                        </div>
                                                                                        <img src="${img_link_change(el)}" alt="">
                                                                                    </div>`


        })
    }






}

function allimi_delete_photo(target){

    target.parentElement.remove();
}

function allimi_beauty_gallery_add(id,pet_seq,payment_idx){



    document.getElementById('allimi_addimgfile').addEventListener('change',function(e){

        let ext = document.getElementById('allimi_addimgfile').value.split('.').pop().toLowerCase()

        if(!ext.match(/png|jpg|jpeg/i)){

            alert('gif,png,jpg,jpeg 파일만 업로드 할 수 있습니다.')
            return;
        }

        let filename = document.querySelector('input[name="allimi_imgupfile"]').files[0]


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
            success:function(res) {
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {
                    console.log(body);
                    if(body.err == 0){
                        allimi_get_gallery2(id);

                    }
                }
            }






        })



    })

}
function allimi_MemofocusNcursor() {
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

    $("#allimi_addimgfile").trigger("click");

}

function allimi_get_gallery2(id){

    let target = document.querySelector('input[name="allimi-pet"]:checked')

    let payment_idx = target.getAttribute('data-payment_idx');
    let pet_seq = target.getAttribute('data-pet_seq');
    let cellphone = target.getAttribute('data-cellphone');
    let pet_name = target.getAttribute('data-pet_name');

    document.getElementById('allimi_gallery_list').innerHTML = `<div class="allimi-gallery-list-cell"><a href="#" class="btn-gate-picture-register" onclick="allimi_MemofocusNcursor()"><span><em>이미지 추가</em></span></a></div>`

    console.log(id)

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'beauty_gal_get',
            idx:pet_seq,
            artist_id:id,
        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                console.log(body);
                body.forEach(function(el){

                    document.getElementById('allimi_gallery_list').innerHTML += `<div class="allimi-gallery-list-cell list-cell">
                                                                                                <label>
                                                                                                    <div class="allimi-picture-thumb-view">
                                                                                                        <div class="allimi-picture-obj" onclick=""><img src="${img_link_change(el.file_path)}" alt=""></div>
                                                                                                        <div class="allimi-picture-date">${el.upload_dt.substr(0,4)}.${el.upload_dt.substr(4,2)}.${el.upload_dt.substr(6,2)}</div>
                                                                                                        <div class="allimi-picture-ui">
                                                                                                           <input type="checkbox" name="allimi-gallery-select" class="allimi-picture-select" data-file_path="${el.file_path}">
                                                                                                           <em></em>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </label>
                                                                                            </div>`
                })
            }
        }
    })
}


function allimi_send(){

    if(document.querySelector('input[name="allimi-pet"]:checked')===null){

        document.getElementById('msg1_txt').innerText = '이용펫을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }


    let selected = document.querySelector('input[name="allimi-pet"]:checked')



    let payment_log_seq = selected.getAttribute('data-payment_idx');
    let artist_id = selected.getAttribute('data-artist_id');
    let pet_seq = selected.getAttribute('data-pet_seq');
    let cellphone = selected.getAttribute('data-cellphone');
    let pet_name = selected.getAttribute('data-pet_name');

    let etiquette = document.querySelector('input[name="attitude"]:checked') === null ? '' : document.querySelector('input[name="attitude"]:checked');
    let etiquette_1 = etiquette.value == '1' ? '1':'0';
    let etiquette_2 = etiquette.value == '2' ? '1':'0';
    let etiquette_3 = etiquette.value == '3' ? '1':'0';
    let etiquette_etc = etiquette.value == '0' ? '1':'0';
    let etiquette_etc_memo = etiquette.value == '0' ? document.getElementById('allimi_attitude_textarea').value : '';

    let condition = document.querySelector('input[name="condition"]:checked') === null ? '' :document.querySelector('input[name="condition"]:checked');
    let condition_1 = condition.value == '1' ? '1':'0';
    let condition_2 = condition.value == '2' ? '1':'0';
    let condition_3 = condition.value == '3' ? '1':'0';
    let condition_etc = condition.value == '0' ? '1':'0';
    let condition_etc_memo = condition.value == '0' ? document.getElementById('allimi_condition_textarea').value : '';

    let tangles = document.querySelectorAll('input[name="tangle"]:checked').length === 0 ? '' : document.querySelectorAll('input[name="tangle"]:checked') ;


    let tangles_arr = [];
    if(tangles !== ''){

        tangles.forEach(function(el){

            tangles_arr.push(el.value);

        })
    }

    let tangles_1 = tangles_arr.includes('1') ? '1' : '0';
    let tangles_2 = tangles_arr.includes('2') ? '1' : '0';
    let tangles_3 = tangles_arr.includes('3') ? '1' : '0';
    let tangles_4= tangles_arr.includes('4') ? '1' : '0';
    let tangles_5 = tangles_arr.includes('5') ? '1' : '0';
    let tangles_6 = tangles_arr.includes('6') ? '1' : '0';
    let tangles_7 = tangles_arr.includes('7') ? '1' : '0';
    let tangles_etc = tangles_arr.includes('0') ? '1' : '0';
    let tangles_etc_memo = tangles_arr.includes('0') ? document.getElementById('allimi_tangle_textarea').value : '';


    let part = document.querySelectorAll('input[name="dislike"]:checked').length === 0 ? '' : document.querySelectorAll('input[name="dislike"]:checked') ;

    let part_arr = [];

    if(part !== ''){

        part.forEach(function(el){

            part_arr.push(el.value);
        })
    }

    let part_1 = part_arr.includes('1') ? '1':'0';
    let part_2 = part_arr.includes('2') ? '1':'0';
    let part_3 = part_arr.includes('3') ? '1':'0';
    let part_4 = part_arr.includes('4') ? '1':'0';
    let part_5 = part_arr.includes('5') ? '1':'0';
    let part_6 = part_arr.includes('6') ? '1':'0';
    let part_etc = part_arr.includes('0') ? '1':'0';
    let part_etc_memo = part_arr.includes('0') ? document.getElementById('allimi_dislike_textarea').value :'';


    let skin = document.querySelectorAll('input[name="skin"]:checked').length === 0 ? '' : document.querySelectorAll('input[name="skin"]:checked') ;

    let skin_arr = [];
    if(skin !== ''){

        skin.forEach(function(el){
            skin_arr.push(el.value);
        })
    }

    let skin_1 = skin_arr.includes('1') ? '1' : '0';
    let skin_2 = skin_arr.includes('2') ? '1' : '0';
    let skin_3 = skin_arr.includes('3') ? '1' : '0';
    let skin_4 = skin_arr.includes('4') ? '1' : '0';
    let skin_5 = skin_arr.includes('5') ? '1' : '0';
    let skin_6 = skin_arr.includes('6') ? '1' : '0';
    let skin_7 = skin_arr.includes('7') ? '1' : '0';
    let skin_etc = skin_arr.includes('0') ? '1' : '0';
    let skin_etc_memo = skin_arr.includes('0') ? document.getElementById('allimi_skin_textarea').value : '';

    console.log(skin_etc_memo);

    let bath = document.querySelector('input[name="bath"]:checked') === null ? '' : document.querySelector('input[name="bath"]:checked');
    let bath_1 = bath.value == '1' ? '1':'0';
    let bath_2 = bath.value == '2' ? '1':'0';
    let bath_3 = bath.value == '3' ? '1':'0';
    let bath_etc = bath.value == '0' ? '1':'0';
    let bath_etc_memo = bath.value == '0' ? document.getElementById('allimi_bath_textarea').value :'';


    let notice = document.querySelectorAll('input[name="self"]:checked').length === 0 ? '' : document.querySelectorAll('input[name="self"]:checked') ;


    let notice_arr = [];
    if(notice !== ''){

        notice.forEach(function(el){
            notice_arr.push(el.value);
        })
    }

    let notice_1 = notice_arr.includes('1') ? '1':'0';
    let notice_2 = notice_arr.includes('2') ? '1':'0';
    let notice_3 = notice_arr.includes('3') ? '1':'0';
    let notice_4 = notice_arr.includes('4') ? '1':'0';
    let notice_etc = notice_arr.includes('0') ? '1':'0';
    let notice_etc_memo = notice_arr.includes('0') ? document.getElementById('allimi_self_textarea').value :'';

    let file_path = '';

    Array.from(document.getElementsByClassName('allimi-gallery-cell')).forEach(function(el,i){

        if(!el.classList.contains('allimi-gallery-cell-icon')){

            if(i === document.getElementsByClassName('allimi-gallery-cell').length-1){

                file_path += `${el.getAttribute('data-file_path')}`
            }else{

                file_path += `${el.getAttribute('data-file_path')}|`
            }

        }
    })

    console.log(file_path)

    // console.log(etiquette)
    // console.log(etiquette_1)
    // console.log(etiquette_2)
    // console.log(etiquette_3)
    // console.log(etiquette_etc)
    // console.log(etiquette_etc_memo)

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data: {
            mode: 'post_allimi',
            payment_log_seq: payment_log_seq,
            artist_id: artist_id,
            pet_seq: pet_seq,
            cellphone:cellphone,
            etiquette_1: etiquette_1,
            etiquette_2: etiquette_2,
            etiquette_3: etiquette_3,
            etiquette_etc: etiquette_etc,
            etiquette_etc_memo: etiquette_etc_memo,
            condition_1: condition_1,
            condition_2: condition_2,
            condition_3: condition_3,
            condition_etc: condition_etc,
            condition_etc_memo: condition_etc_memo,
            tangles_1: tangles_1,
            tangles_2: tangles_2,
            tangles_3: tangles_3,
            tangles_4: tangles_4,
            tangles_5: tangles_5,
            tangles_6: tangles_6,
            tangles_7: tangles_7,
            tangles_etc: tangles_etc,
            tangles_etc_memo: tangles_etc_memo,
            part_1: part_1,
            part_2: part_2,
            part_3: part_3,
            part_4: part_4,
            part_5: part_5,
            part_6: part_6,
            part_etc: part_etc,
            part_etc_memo: part_etc_memo,
            skin_1: skin_1,
            skin_2: skin_2,
            skin_3: skin_3,
            skin_4: skin_4,
            skin_5: skin_5,
            skin_6: skin_6,
            skin_7: skin_7,
            skin_etc: skin_etc,
            skin_etc_memo: skin_etc_memo,
            bath_1: bath_1,
            bath_2: bath_2,
            bath_3: bath_3,
            bath_etc: bath_etc,
            bath_etc_memo: bath_etc_memo,
            notice_1: notice_1,
            notice_2: notice_2,
            notice_3: notice_3,
            notice_4: notice_4,
            notice_etc: notice_etc,
            notice_etc_memo: notice_etc_memo,
            file_path: file_path,
        },
        success:function(res) {
            console.log(res)
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                console.log(body);

                let message = `${pet_name} 보호자님 안녕하세요.\n` +
                    `${data.shop_name}에서 ${pet_name}의 컨디션과 활동에 대한 알리미가 도착했어요.\n` +
                    '\n' +
                    '아래 알리미보기 버튼을 눌러 확인해보세요.'

                $.ajax({

                    url:'/data/pc_ajax.php',
                    type:'post',
                    data:{

                        mode:'allimi_talk',
                        cellphone:cellphone,
                        message:message,
                        payment_log_seq:payment_log_seq,


                    },
                    success:function(res) {
                        let response = JSON.parse(res);
                        let head = response.data.head;
                        let body = response.data.body;
                        if (head.code === 401) {
                            pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                        } else if (head.code === 200) {
                            console.log(body);
                        }
                    }

                })

                document.getElementById('msg1_txt').innerText = '알리미가 전송되었습니다.';
                pop.open('reserveAcceptMsg1');
                pop.close2('allimi_pop');
            }
        }



    })


}

function allimi_recent(id,cellphone){

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'allimi_recent',
            artist_id:id,
            cellphone:cellphone,
        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                console.log(body);

                let year = body.diary_recent_time.substr(0,4);
                let month = body.diary_recent_time.substr(4,2);
                let date = body.diary_recent_time.substr(6,2);
                let hour = body.diary_recent_time.substr(8,2);
                let min = body.diary_recent_time.substr(10,2);

                let recent_date = new Date(year,parseInt(month)-1,date,hour,min);
                console.log(recent_date);
                document.getElementById('diary_recent').innerText = `( 최근발송 : ${recent_date.getFullYear()}. ${fill_zero(recent_date.getMonth()+1)}. ${fill_zero(recent_date.getDate())} ${am_pm_check(recent_date.getHours())}시 ${fill_zero(recent_date.getMinutes())}분 )`
            }
        }
    })

}