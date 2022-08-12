
let data;
let list;


function data_set(){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'home',
            login_id: sessionStorage.getItem('id'),
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
}
// 데이터 갱신
function data_interval(){


    setInterval(function () {
        $.ajax({
            url: '../data/pc_ajax.php',
            data: {
                mode: 'home',
                login_id: sessionStorage.getItem('id'),
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



// let data = JSON.parse(sessionStorage.getItem('data'));

//현재 날짜

let date = new Date();

let year = date.getFullYear();
let month = date.getMonth();
let day = date.getDate();
let hours = date.getHours();
let minutes = date.getMinutes();
let times = date.getTime();
let date_ = `${date.getFullYear().toString().substr(-2)}.${(date.getMonth() + 1).toString().length < 2 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1}.${date.getDate().toString().length < 2 ? '0' + date.getDate() : date.getDate()}`


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
                    reserve_list.innerHTML += `<div class="main-reserve-list-cell">
                                                <a href="../booking/reserve_pay_management_beauty_1.php" onclick="sessionStorage.setItem('payment_idx',${el.product.payment_idx})" class="customer-card-item transparent">
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
                                                                    <div class="option-cell">${el.product.worker === sessionStorage.getItem('id')? '실장' : el.product.worker}</div>
                                                                  
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
function renderCalendar() {
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
            dates[i] = `<div class="main-calendar-month-body-col ${prevDates.indexOf(_date) >= 0 && i <= 7 ? "before" : ""} ${nextDates.indexOf(_date) >= 0 && i >= dates.length - 7 ? "after" : ""}">
                        <div class="main-calendar-col-inner">
                            <div class="main-calendar-toggle-group">
                                <a href="javascript:;" class="main-calendar-day-value">
                                    <div class="number">${_date}</div>
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
                                            <a href="../booking/reserve_beauty_day.php" class="btn-list-nav" onclick="sessionStorage.setItem('day_select','${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${fill_zero(_date)}')">

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
        holiday();
        resolve(div_dates);
    })
}

function _renderCalendar() {
    renderCalendar()
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
        }).then(function(){

        //오늘날짜 표시시
        Array.from(document.getElementsByClassName('date-info')).forEach(function (el){
            if(el.innerText.trim() === `${new Date().getFullYear().toString().substr(2,2)}.${fill_zero(new Date().getMonth()+1).toString()}.${fill_zero(new Date().getDate()).toString()}`){
                el.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.classList.add('today');
            }
        })
    })
}

//캘린더 버튼
function btn_month(){



    document.getElementById('btn-month-prev').addEventListener('click', function (evt) {

        date.setDate(1);
        date.setMonth(date.getMonth() - 1);
        book_list().then(function (){
            if(document.getElementById('main-calendar-month-body')){
                _renderCalendar();
            }else{
                _renderCalendar_mini();
            }
            if(document.getElementById('main_reserve_graph_none')){
                stats();
            }
        })
    })

    document.getElementById('btn-month-next').addEventListener('click', function (evt) {

        date.setDate(1);
        date.setMonth(date.getMonth() + 1);
        book_list().then(function (){
            if(document.getElementById('main-calendar-month-body')){
                _renderCalendar();
            }else{
                _renderCalendar_mini();
            }


            if(document.getElementById('main_reserve_graph_none')){
                stats();
            }

        })


    })


}


function renderCalendar_mini() {

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
                                            <a href="../booking/reserve_beauty_day.php" class="btn-list-nav" onclick="sessionStorage.setItem('day_select','${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${fill_zero(_date)}')">

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
            document.getElementById(`mini-calendar-month-body`).innerHTML += ` <div class="mini-calendar-month-body-row ${i > 0 && i < 5 ? "op-1" : ""} ${i === 0 || i === 2 ? '1or3' : i === 1 || i === 3 ? '2or4':""} " id="mini-calendar-month-body-row-${i}" ></div>`
        }
        holiday();
        resolve(div_dates);
    })
}

//새로고침 달력
function _renderCalendar_mini(){
    renderCalendar_mini()
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
                console.log('리스트호출')
                booking_list = list;
            }else{
                booking_list = data;
            }
            console.log(booking_list)

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

                el.addEventListener('click',function(){

                    Array.from(mini_col).forEach(function(el_){

                        el_.classList.remove('actived');
                    })

                    el.classList.add('actived');
                    sessionStorage.setItem('day_select',`${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${fill_zero(el.children[0].children[0].children[0].children[0].innerText.trim())}`)
                    date.setDate(el.children[0].children[0].children[0].children[0].innerText.trim());

                    schedule_render();

                })


                let day = sessionStorage.getItem('day_select') !== null ? sessionStorage.getItem('day_select').split('.')[2] : date.getDate();
                if(fill_zero(el.children[0].children[0].children[0].children[0].innerText.trim()) === day && !el.classList.contains('after') && !el.classList.contains('before')){
                    el.click();

                }




            })
            if(sessionStorage.getItem('day_select') === null){

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
function holiday(){
    $.ajax({
        url:'../data/pc_ajax.php',
        type:'post',
        data:{
            mode:'holiday',
            login_id:sessionStorage.getItem('id')
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
                }
                if(body.is_work_mon){
                    Array.from(body_rows).forEach(function(el){
                        if(el.childNodes.length !== 0){
                            el.childNodes[1].classList.add('break');
                        }
                    })
                }
                if(body.is_work_tue){
                    Array.from(body_rows).forEach(function(el){
                        if(el.childNodes.length !== 0){
                            el.childNodes[2].classList.add('break');
                        }
                    })
                }
                if(body.is_work_wed){
                    Array.from(body_rows).forEach(function(el){
                        if(el.childNodes.length !== 0){
                            el.childNodes[3].classList.add('break');
                        }
                    })
                }
                if(body.is_work_thu){
                    Array.from(body_rows).forEach(function(el){
                        if(el.childNodes.length !== 0){
                            el.childNodes[4].classList.add('break');
                        }
                    })
                }
                if(body.is_work_fri){
                    Array.from(body_rows).forEach(function(el){
                        if(el.childNodes.length !== 0){
                            el.childNodes[5].classList.add('break');
                        }
                    })
                }
                if(body.is_work_sat){
                    Array.from(body_rows).forEach(function(el){
                        if(el.childNodes.length !== 0){
                            el.childNodes[6].classList.add('break');
                        }
                    })
                }
            }
        }
    })
}
