
let data;
let list;
console.log(data);
console.log(list)

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
            //console.log(res);
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
// 데이터 갱신
function data_interval(){


    setInterval(function () {
        $.ajax({
            url: '/data/pc_ajax.php',
            data: {
                mode: 'home',
                login_id: localStorage.getItem('id'),
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
                    data = body;
                }
            }
        })
    }, 10000)
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
    }else if(hours === 12){
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



function stats(){


    let pay_type_card = 0;
    let pay_type_cash = 0;
    let pet_type_dog = 0;
    let pet_type_cat = 0;

    let stats;

    if(list !== undefined){
        stats = list;
    }else{
        stats = data;
    }

    if (stats.beauty.length > 0) {

        document.getElementById('main_reserve_graph_none').style.display = 'none';
        stats.beauty.forEach(function (el, i) {

            console.log(el)
           if(el.pet.animal !== null){
               if (el.product.pay_type.match(/card/i)) {
                   pay_type_card++;
               } else {
                   pay_type_cash++;
               }

               if (el.pet.animal.match(/dog/i)) {

                   pet_type_dog++;
               } else {
                   pet_type_cat++;
               }
           }

        })


        document.querySelector('.main-reserve-graph').innerHTML = `<div class="graph-cell">
                                                                                        <div class="graph-item yellow" style="${pay_type_cash / stats.beauty.length === 0 ? 'display:none;' : `width:${pay_type_cash/stats.beauty.length * 100}%;`} ${pay_type_cash / stats.beauty.length * 100 < 30 ? `font-size:10px ; flex-direction:column` : ""}; ${pay_type_cash / stats.beauty.length * 100 < 8 ? `color:transparent` : ""};">현금 <em style="${pay_type_cash / stats.beauty.length * 100 < 30 ? `font-size:10px` : ""}">${(pay_type_cash / stats.beauty.length * 100).toFixed(1)}%</em></div>
                                                                                        <div class="graph-item purple" style="${pay_type_card / stats.beauty.length === 0 ? 'display:none;' : `width:${pay_type_card/stats.beauty.length * 100}%;`} ${pay_type_card / stats.beauty.length * 100 < 30 ? `font-size:10px ; flex-direction:column` : ""}; ${pay_type_card / stats.beauty.length * 100 < 8 ? `color:transparent` : ""};">카드 <em style="${pay_type_card / stats.beauty.length * 100 < 30 ? `font-size:10px` : ""}">${(pay_type_card / stats.beauty.length * 100).toFixed(1)}%</em></div>
                                                                                    </div>
                                                                                    <div class="graph-cell">
                                                                                        <div class="graph-item yellow" style="${pet_type_dog / stats.beauty.length === 0 ? 'display:none;' : `width:${pet_type_dog/stats.beauty.length * 100}%;`} ${pet_type_dog / stats.beauty.length * 100 < 30 ? `font-size:10px ; flex-direction:column` : ""};  ${pet_type_dog / stats.beauty.length * 100 < 8 ? `color:transparent` : ""}; ">강아지 <em style="${pet_type_dog / stats.beauty.length * 100 < 30 ? `font-size:10px` : ""};">${(pet_type_dog / stats.beauty.length * 100).toFixed(1)}%</em></div>
                                                                                        <div class="graph-item purple" style="${pet_type_cat / stats.beauty.length === 0 ? 'display:none;' : `width:${pet_type_cat/stats.beauty.length * 100}%;`} ${pet_type_cat / stats.beauty.length * 100 < 30 ? `font-size:10px ; flex-direction:column` : ""}; ${pet_type_cat / stats.beauty.length * 100 < 8 ? `color:transparent` : ""};">고양이 <em style="${pet_type_cat / stats.beauty.length * 100 < 30 ? `font-size:10px` : ""}; ">${(pet_type_cat / stats.beauty.length * 100).toFixed(1)}%</em></div>
                                                                                    </div>`

    }else{
        document.querySelector('.main-reserve-graph').innerHTML = '';
        document.getElementById('main_reserve_graph_none').style.display = 'block';
    }
}


//오늘 예약 내역
function today_reserve(){


    let reserve_list = document.getElementById('main_reserve_list');


    // let booking_list;

    // if(list !== undefined){
    //     booking_list = list;
    // }else{
    //     booking_list = data;
    // }
    if(data.beauty.length > 0 || data.hotel.length > 0 || data.kindergarden.length > 0){



        if(data.beauty.length > 0){

            data.beauty.forEach(function(el,i){

                let today_reserve = el.product.date.booking_st;
                let date_today_reserve = new Date(today_reserve);
                let today_reserve_fi = el.product.date.booking_fi;
                let date_today_reserve_fi = new Date(today_reserve_fi);

                if(date_today_reserve.getFullYear() === date.getFullYear()
                    && date_today_reserve.getMonth() === date.getMonth()
                    && date_today_reserve.getDate() === date.getDate()
                ){

                    document.getElementById('reserve_after_none').style.display = 'none';
                    if(el.pet.photo !== null && el.pet.photo.substr(0,4) === '/pet'){
                        el.pet.photo = el.pet.photo.replace('/pet','');
                    }
                    reserve_list.innerHTML += `<div class="main-reserve-list-cell">
                                                <a href="/booking/reserve_pay_management_beauty_1.php" onclick="localStorage.setItem('payment_idx',${el.product.payment_idx})" class="customer-card-item transparent">
                                                    <div class="item-info-wrap">
                                                        <div class="item-thumb">
                                                            <div class="user-thumb middle"><img src="${el.pet.photo !== null ? `https://image.banjjakpet.com${el.pet.photo}`  : `${el.pet.animal === 'dog' ? `../static/images/icon/icon-pup-select-off.png`: `../static/images/icon/icon-cat-select-off.png`}` }" alt=""></div>
                                                        </div>
                                                        <div class="item-data">
                                                            <div class="item-data-inner">
                                                                <div class="item-pet-name">${el.pet.name}
                                                                    <div class="label label-yellow middle">
                                                                        <strong>${el.pet.type}</strong>
                                                                    </div>
                                                                </div>
                                                                <div class="item-phone">${el.customer.phone.replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`)}</div>
                                                                <div class="item-option">
                                                                    <div class="option-cell">
                                                                        <div class="icon icon-size-16 icon-time-purple"></div>
                                                                        ${am_pm_check(date_today_reserve.getHours())}:${fill_zero(date_today_reserve.getMinutes())} ~ ${am_pm_check(date_today_reserve_fi.getHours())}:${fill_zero(date_today_reserve_fi.getMinutes())}
                                                                    </div>
                                                                    <div class="option-cell">${el.product.worker === localStorage.getItem('id')? '실장' : el.product.worker}</div>
                                                                  
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="item-state">
                                                            <div class="item-sort">
                                                                <div class="txt-1">미용</div>
                                                                <div class="txt-2">${el.product.category_sub }</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>`
                }


            })


        }


    }
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
                                <a href="javascript:;" class="main-calendar-day-value">
                                    <div class="number ${new Date(date.getFullYear(),date.getMonth(),_date).getDay() === 0 ? 'sunday' : ''} ${new Date(date.getFullYear(),date.getMonth(),_date).getDay() === 6 ? 'saturday' : '' }" >${_date}</div>
                                    <div class="value reserve-total"></div>
                                </a>
                                <div class="main-calendar-toggle-data">
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
        //7일단위로 나눔
        const div_dates = dates.division(7);

        //row 생성
        document.getElementById(`main-calendar-month-body`).innerHTML = '';
        for (let i = 0; i < div_dates.length; i++) {
            document.getElementById(`main-calendar-month-body`).innerHTML += ` <div class="main-calendar-month-body-row ${i > 0 && i < 5 ? "op-1" : ""} ${i === 0 || i === 2 ? '1or3' : i === 1 || i === 3 ? '2or4':""} " id="main-calendar-month-body-row-${i}" ></div>`
        }

        //정기휴일적용
        holiday(id);
        statutory_holiday(id)
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

            let date_info = document.getElementsByClassName('date-info');
            let booking_list ;

            if(list !== undefined){
                booking_list = list;
            }else{
                booking_list = data;
            }

            //기타 데이터 채우기
            Array.from(date_info).forEach(function(el,i){
                let count = 0;
                let date_ck_1 = new Date(`20${el.innerText.trim()}`);

                if(booking_list.beauty.length === 0){
                    // Array.from(document.getElementsByClassName('reserve-total')).forEach(function (el,i){
                    //     el.innerHTML = '0';
                    // })
                    // Array.from(document.getElementsByClassName('reserve-total-2')).forEach(function (el,i){
                    //     el.innerHTML = '0건';
                    // })
                    // Array.from(document.getElementsByClassName('beauty-count')).forEach(function (el,i){
                    //     el.innerHTML = '0건';
                    // })
                }else{
                    booking_list.beauty.forEach(function(el_,i_){
                        let date_ck_2  =  new Date(el_.product.date.booking_st);

                        if(date_ck_1.getFullYear() === date_ck_2.getFullYear()
                            && date_ck_1.getMonth() === date_ck_2.getMonth()
                            && date_ck_1.getDate() === date_ck_2.getDate()){
                            count++;
                        }

                        if(count !== 0){


                            siblings(el,1).innerHTML = `${count}건`;

                            siblings(el.parentElement.parentElement.parentElement.parentElement,0).children[1].innerHTML= `${count}`;

                            el.parentElement.parentElement.parentElement.childNodes[3].childNodes[1].childNodes[3].innerHTML = `${count}건`
                        }
                    })
                }
            })
        }).then(function() {

        //오늘날짜 표시시
        Array.from(document.getElementsByClassName('date-info')).forEach(function (el) {
            if (el.innerText.trim() === `${new Date().getFullYear().toString().substr(2, 2)}.${fill_zero(new Date().getMonth() + 1).toString()}.${fill_zero(new Date().getDate()).toString()}`) {
                el.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.classList.add('today');
            }
        })
       $(document).ready( function () {
            setTimeout(function () {
                console.log(1)
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
            console.log(res)
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                console.log(body)

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

        date.setDate(1);
        date.setMonth(date.getMonth() - 1);
        book_list(id).then(function (){
            if(document.getElementById('main-calendar-month-body')){

                _renderCalendar(id);
            }else{

                _renderCalendar_mini(id);
            }
            if(document.getElementById('main_reserve_graph_none')){
                stats();
            }
        })
    })

    document.getElementById('btn-month-next').addEventListener('click', function (evt) {

        date.setDate(1);
        date.setMonth(date.getMonth() + 1);
        book_list(id).then(function (){
            if(document.getElementById('main-calendar-month-body')){

                _renderCalendar(id);
            }else{

                _renderCalendar_mini(id);
            }


            if(document.getElementById('main_reserve_graph_none')){
                stats();
            }

        })


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
        document.getElementById(`mini-calendar-month-body`).innerHTML = '';
        for (let i = 0; i < div_dates.length; i++) {
            document.getElementById(`mini-calendar-month-body`).innerHTML += ` <div class="mini-calendar-month-body-row ${i > 0 && i < 5 ? "op-1" : ""} ${i === 0 || i === 2 ? '1or3' : i === 1 || i === 3 ? '2or4':""} " id="mini-calendar-month-body-row-${i}" data-row="${i}" ></div>`
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

            let date_info = document.getElementsByClassName('date-info');
            let booking_list ;

            if(list !== undefined){
                booking_list = list;
            }else{
                booking_list = data;
            }

            Array.from(date_info).forEach(function(el,i){
                let count = 0;
                let date_ck_1 = new Date(`20${el.innerText.trim()}`);

                if(booking_list.beauty.length === 0){
                    // Array.from(document.getElementsByClassName('reserve-total')).forEach(function (el,i){
                    //     el.innerHTML = '0';
                    // })
                }else{
                    booking_list.beauty.forEach(function(el_,i_){
                        let date_ck_2  =  new Date(el_.product.date.booking_st);

                        if(date_ck_1.getFullYear() === date_ck_2.getFullYear()
                            && date_ck_1.getMonth() === date_ck_2.getMonth()
                            && date_ck_1.getDate() === date_ck_2.getDate()){
                            count++;
                        }


                        if(count !==0){

                            siblings(el.parentElement.parentElement.parentElement.parentElement,0).children[1].innerHTML= `${count}`;
                        }

                    })
                }
            })
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

                                reserve_schedule_week_cols(body_data,body_,parent,id,session_id)
                                reserve_schedule_week(id,body_data).then(function(_body){

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
                                    setTimeout(function(){week_drag()},200)


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


//notice
function notice(){

    let main_notice_list = document.querySelector('.main-notice-list');

    for (let i = 0; i < data.notice.length; i++) {
        main_notice_list.innerHTML += `<div class="main-notice-cell">
                                        <a href="#" class="btn-main-notice-item">
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
            //console.log(res);
            let response = JSON.parse(res);
            //console.log(response);
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
            result += '<img src="https://image.banjjakpet.com'+imgList[i]+'" alt="" />';
            result += '</div></div>';

            resultThumb += '<button type="button" class="btn-gallery-thumb-nav hide">';
            resultThumb += '<span class="loading-bar"><span class="sk-fading-circle"><span class="sk-circle1 sk-circle"></span><span class="sk-circle2 sk-circle"></span><span class="sk-circle3 sk-circle"></span><span class="sk-circle4 sk-circle"></span><span class="sk-circle5 sk-circle"></span><span class="sk-circle6 sk-circle"></span><span class="sk-circle7 sk-circle"></span><span class="sk-circle8 sk-circle"></span><span class="sk-circle9 sk-circle"></span><span class="sk-circle10 sk-circle"></span><span class="sk-circle11 sk-circle"></span><span class="sk-circle12 sk-circle"></span></span></span>';
            resultThumb += '<img src="https://image.banjjakpet.com'+imgList[i]+'" alt="" >';
            resultThumb += '</button>';
        };

        //데이타 삽입
        gallery.element.find('.swiper-wrapper').html(result);
        gallery.element.find('.gallery-thumb-list').html(resultThumb);

        gallery.element.find('.swiper-wrapper .slider-item').each(function(){
            $(this).imagesLoaded().always(function(instance){
                //console.log('model image loaded');
            }).done(function(instance){
                $(instance.elements).removeClass('hide');
            }).fail( function(){
                //alert('프로필 이미지가 없습니다.');
            }).progress(function(instance,image){

            });
        });

        gallery.element.find('.gallery-thumb-list .btn-gallery-thumb-nav').each(function(){
            $(this).imagesLoaded().always(function(instance){
                //console.log('model image loaded');
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
    imgs.forEach(element => {
        element = img_link_change(element);
    });
    console.log(imgs);
    gallery.dataSet(imgs);
    gallery.open(startIndex);
};
