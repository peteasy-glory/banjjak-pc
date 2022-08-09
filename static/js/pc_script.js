let data = JSON.parse(localStorage.getItem('data'));


//현재 날짜

let date = new Date();

let year = date.getFullYear();
let month = date.getMonth();
let day = date.getDate();
let hours = date.getHours();
let minutes = date.getMinutes();
let times = date.getTime();
let date_ = `${date.getFullYear().toString().substr(-2)}.${(date.getMonth() + 1).toString().length < 2 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1}.${date.getDate().toString().length < 2 ? '0' + date.getDate() : date.getDate()}`

function update(){
    document.getElementById('item_date').prepend(date_);
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

//오후 오전 적용하기 2
function am_pm_check2(date){

    if(date === 'None'){
        return;
    }
    let date_ = date.split(' ')

    let _date = date_[1].split(':');

    return `${date_[0]} ${am_pm_check(_date[0])}:${_date[1]}:${_date[2]}`

}

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

// 데이터 갱신
setInterval(function () {
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'home',
            login_id: localStorage.getItem('id'),
        },
        type: 'POST',
        success: function (res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '서버 오류입니다.');
            } else if (head.code === 200) {
                localStorage.setItem('data', JSON.stringify(body));
            }
        }
    })
}, 10000)


//gnb 데이터 넣기
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

//등록 현황 통계

function stats(){


    let pay_type_card = 0;
    let pay_type_cash = 0;
    let pet_type_dog = 0;
    let pet_type_cat = 0;

    let stats;

    if(localStorage.getItem('list')){
        stats = JSON.parse(localStorage.getItem('list'));
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
                                                <a href="#" class="customer-card-item transparent">
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
        const div_dates = dates.division(7);
        document.getElementById(`main-calendar-month-body`).innerHTML = '';
        for (let i = 0; i < div_dates.length; i++) {
            document.getElementById(`main-calendar-month-body`).innerHTML += ` <div class="main-calendar-month-body-row ${i > 0 && i < 5 ? "op-1" : ""} ${i === 0 || i === 2 ? '1or3' : i === 1 || i === 3 ? '2or4':""} " id="main-calendar-month-body-row-${i}" ></div>`
        }
        holiday();
        resolve(div_dates);
    })
}

function _renderCalendar() {
    renderCalendar()
        .then(function (div_dates) {
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

            if(localStorage.getItem('list')){
                booking_list = JSON.parse(localStorage.getItem('list'));
            }else{
                booking_list = data;
            }

            Array.from(date_info).forEach(function(el,i){
                let count = 0;
                let date_ck_1 = new Date(`20${el.innerText.trim()}`);

                if(booking_list.beauty.length === 0){
                    Array.from(document.getElementsByClassName('reserve-total')).forEach(function (el,i){
                        el.innerHTML = '0';
                    })
                    Array.from(document.getElementsByClassName('reserve-total-2')).forEach(function (el,i){
                        el.innerHTML = '0건';
                    })
                    Array.from(document.getElementsByClassName('beauty-count')).forEach(function (el,i){
                        el.innerHTML = '0건';
                    })
                }else{
                    booking_list.beauty.forEach(function(el_,i_){
                        let date_ck_2  =  new Date(el_.product.date.booking_st);

                        if(date_ck_1.getFullYear() === date_ck_2.getFullYear()
                        && date_ck_1.getMonth() === date_ck_2.getMonth()
                        && date_ck_1.getDate() === date_ck_2.getDate()){
                          count++;
                        }

                        siblings(el,1).innerHTML = `${count}건`;

                        siblings(el.parentElement.parentElement.parentElement.parentElement,0).children[1].innerHTML= `${count}`;

                        el.parentElement.parentElement.parentElement.childNodes[3].childNodes[1].childNodes[3].innerHTML = `${count}건`
                    })
                }
            })
        }).then(function(){
            Array.from(document.getElementsByClassName('date-info')).forEach(function (el){
                if(el.innerText.trim() === `${new Date().getFullYear().toString().substr(2,2)}.${fill_zero(new Date().getMonth()+1).toString()}.${fill_zero(new Date().getDate()).toString()}`){
                    el.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.parentElement.classList.add('today');
                }
            })
    })
}


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
        const div_dates = dates.division(7);
        document.getElementById(`mini-calendar-month-body`).innerHTML = '';
        for (let i = 0; i < div_dates.length; i++) {
            document.getElementById(`mini-calendar-month-body`).innerHTML += ` <div class="mini-calendar-month-body-row ${i > 0 && i < 5 ? "op-1" : ""} ${i === 0 || i === 2 ? '1or3' : i === 1 || i === 3 ? '2or4':""} " id="mini-calendar-month-body-row-${i}" ></div>`
        }
        holiday();
        resolve(div_dates);
    })
}

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

            if(localStorage.getItem('list')){
                booking_list = JSON.parse(localStorage.getItem('list'));
            }else{
                booking_list = data;
            }

            Array.from(date_info).forEach(function(el,i){
                let count = 0;
                let date_ck_1 = new Date(`20${el.innerText.trim()}`);

                if(booking_list.beauty.length === 0){
                    Array.from(document.getElementsByClassName('reserve-total')).forEach(function (el,i){
                        el.innerHTML = '0';
                    })
                }else{
                    booking_list.beauty.forEach(function(el_,i_){
                        let date_ck_2  =  new Date(el_.product.date.booking_st);

                        if(date_ck_1.getFullYear() === date_ck_2.getFullYear()
                            && date_ck_1.getMonth() === date_ck_2.getMonth()
                            && date_ck_1.getDate() === date_ck_2.getDate()){
                            count++;
                        }



                        siblings(el.parentElement.parentElement.parentElement.parentElement,0).children[1].innerHTML= `${count}`;

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
                    localStorage.setItem('day_select',`${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${fill_zero(el.children[0].children[0].children[0].children[0].innerText.trim())}`)
                    date.setDate(el.children[0].children[0].children[0].children[0].innerText.trim());

                    schedule_render();

                })

                if(fill_zero(el.children[0].children[0].children[0].children[0].innerText.trim()) === localStorage.getItem('day_select').split('.')[2] && !el.classList.contains('after') && !el.classList.contains('before')){
                    el.click();

                }


            })



        })

}
function schedule_render(){

    $.ajax({

        url:'../data/pc_ajax.php',
        type:'post',
        data:{
            mode:'day_book',
            login_id:localStorage.getItem('id'),
            st_date:`${date.getFullYear()}-${fill_zero(date.getMonth()+1)}-${fill_zero(date.getDate())}`,
            fi_date:`${date.getFullYear()}-${fill_zero(date.getMonth()+1)}-${fill_zero(date.getDate()+1)}`,
        },
        success:function (res){
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '서버 오류입니다.');
            } else if (head.code === 200) {
                document.getElementById('day_today').innerHTML = `${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.${fill_zero(date.getDate())}`
                document.getElementById('day_total').innerHTML = `${body.length}건`
                let cancel = 0;
                let noshow = 0;

                body.forEach(function (el){
                    if(el.product.is_cancel === 1 ){
                        cancel ++;
                    }
                    if(el.product.is_no_show === 1){
                        noshow ++;
                    }
                })
                document.getElementById('day_cancel').innerHTML = `${cancel}건`
                document.getElementById('day_noshow').innerHTML = `${noshow}건`

                let week = ['일','월','화','수','목','금','토']
                document.getElementById('schedule_day').innerHTML =`${fill_zero(date.getMonth()+1)}.${fill_zero(date.getDate())}(${week[date.getDay()]})`


                reserve_schedule().then(function(){
                    cols().then(function (){

                        let color;
                        body.forEach(function (el){
                            console.log(el);

                            Array.from(document.getElementsByClassName('calendar-day-body-col')).forEach(function (el_){

                                if(el_.getAttribute('data-name') === el.product.worker && new Date(el_.getAttribute('data-year'),el_.getAttribute('data-month'),el_.getAttribute('data-date'),el_.getAttribute('data-hour'),el_.getAttribute('data-minutes')).getTime() === new Date(el.product.date.booking_st).getTime() ){
                                    switch(el.product.pay_type){

                                        case "pos-card" || "pos-cash" : color = 'yellow'; break;
                                        case "offline-card" || "offline-cash" : color = 'purple'; break;
                                        default : color = ''; break;

                                    }
                                    let multiple = (new Date(el.product.date.booking_fi).getTime() - new Date(el.product.date.booking_st).getTime())/1800000;
                                    el_.innerHTML = `<div class="calendar-drag-item-group">
                                                                        <a href="#" class="btn-calendar-add">등록하기</a>
                                                                        <a href="#" class="calendar-week-time-item toggle green ${color} ${el.product.is_no_show === 1 ? "red" : ''}" style="height: calc(100% * ${multiple}); ">
                                                                            <div class="item-inner" style=" ${multiple <4 ? `` : `border:none !important`}">
                                                                                <div class="item-name">
                                                                                    <div class="txt">${el.pet.name}</div>
                                                                                    ${multiple <4 ? `<button type="button" class="btn-calendar-item-more"></button>`:``}
                                                                                    
                                                                                </div> 
                                                                                <div class="item-cate">${el.pet.type}</div>
                                                                                <div class="item-price">${((parseInt(el.product.store_payment.card === null || el.product.store_payment.card === "" ? 0 : parseInt(el.product.store_payment.card))+(el.product.store_payment.cash === null || el.product.store_payment.cash === "" ? 0 : parseInt(el.product.store_payment.cash)))-parseInt(el.product.store_payment.discount.toString().length <3 ? (parseInt(el.product.store_payment.cash === null || el.product.store_payment.cash === "" ? 0 : el.product.store_payment.cash) + parseInt(el.product.store_payment.card === null || el.product.store_payment.card === "" ? 0 : el.product.store_payment.card)) * el.product.store_payment.discount /100: el.product.store_payment.discount  )).toLocaleString()}원</div>
                                                                                <div class="item-option">${el.product.category}</div>
                                                                                <div class="item-stats">
                                                                                ${el.product.is_confirm ? `<div class="right">
                                                                                        <div class="item-cash">
                                                                                            ${el.product.pay_type === "pos-card" ? `<div class="icon icon-reservation-card-off"></div>` : `<div class="icon icon-reservation-cash-off"></div>` }
                                                                                            
                                                                                        </div>
                                                                                    </div>` : `<div class="left">
                                                                                        <div class="item-master">
                                                                                            <div class="icon icon-reservation-selfadd"></div>
                                                                                        </div>
                                                                                    </div>`}
                                                                                    
                                                                                </div>
                                                                                
                                                                            </div>
                                                                        </a>
                                                                     </div>`
                                }

                            })


                        })
                    });
                });

            }


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


//wide-tab

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

//booking

function book_list() {
    return new Promise(function (resolve){

        $.ajax({
            url: '../data/pc_ajax.php',
            data: {
                mode: 'month_book',
                login_id: localStorage.getItem('id'),
                year: date.getFullYear(),
                month: date.getMonth()+1,
            },
            type: 'POST',
            async:false,
            success: function (res) {
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '서버 오류입니다.');
                } else if (head.code === 200) {
                    localStorage.setItem('list', JSON.stringify(body));
                }
                resolve();
            }
        })
    })


}

//이용 상담 관리

function consulting() {
    let common_none_data = document.getElementById('consulting_none_data');
    let consulting = data.consulting;


    if (data.consulting_count > 0) {

        common_none_data.style.display = 'none';


        consulting.forEach(function (el,i) {
            if(i < data.consulting_count ){


                if (el.date && el.approval === 0) {

                    let consulting_select = JSON.stringify(el);

                    document.querySelector('.main-customer-list').innerHTML += `<div class="main-customer-list-cell">
                                                                                           <a href="../booking/reserve_advice_view.php" onclick="localStorage.setItem('consulting_select','${(el.pet_name + el.phone).toString()}')" class="customer-card-item transparent">
                                                                                               <div class="item-info-wrap">
                                                                                                   <div class="item-data">
                                                                                                       <div class="item-data-inner">
                                                                                                           <div class="item-name">${el.pet_name}
                                                                                                               
                                                                                                           </div>
                                                                                                           <div class="item-phone">${phone_edit(el.phone)}</div>
                                                                                                           <div class="item-date">${am_pm_check2(el.date)}</div>
                                                                                                       </div>
                                                                                                   </div>
                                                                                                   <div class="item-state">
                                                                                                       <div class="item-time">${((new Date().getTime() - new Date(el.date).getTime())/1000/60).toFixed() <60 ? ((new Date().getTime() - new Date(el.date).getTime())/1000/60).toFixed() < 1 ? '방금 전' : `${((new Date().getTime() - new Date(el.date).getTime())/1000/60).toFixed()}분 전` : `${((new Date().getTime() - new Date(el.date).getTime())/1000/60/60).toFixed()}시간 전` }</div>
                                                                                                   </div>
                                                                                               </div>
                                                                                           </a>
                                                                                       </div>`;
                }
            }
        })


    }
}

function holiday(){
    $.ajax({
        url:'../data/pc_ajax.php',
        type:'post',
        data:{
            mode:'holiday',
            login_id:localStorage.getItem('id')
        },
        success:function(res){
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body[0];
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '서버 오류입니다.');
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

function search(search_value) {

    return new Promise(function (resolve){

        document.getElementById('search').value = search_value.toString();
        $.ajax({

            url:'../data/pc_ajax.php',
            type:'post',
            data:{
                mode:'search',
                login_id:localStorage.getItem('id'),
                search:search_value,
            },
            success:function(res){
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '서버 오류입니다.');
                } else if (head.code === 200) {
                    if(body.length === undefined){
                        body = [body];
                    }
                    if(body.length > 0){
                        document.getElementById('search_phone_none_data').style.display = 'none';
                        document.getElementById('search_phone_inner').innerHTML = ''
                        body.forEach(function (el,i){

                            document.getElementById('search_phone_inner').innerHTML += `<div class="grid-layout-cell grid-2">
                                                                                                <a href="#" class="customer-card-item">
                                                                                                    <div class="item-info-wrap">
                                                                                                        <div class="item-thumb">
                                                                                                            <div class="user-thumb large">
                                                                                                                <img src="${el.photo === "" ? el.type === 'dog' ? `../static/images/icon/icon-pup-select-off.png` : `../static/images/icon/icon-cat-select-off.png` : `https://image.banjjakpet.com${el.photo}`}" alt="">
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

function search_fam(search_value){
    search(search_value).then(function(body){
            body.forEach(function (el,i){
                document.getElementById(`grid_layout_inner_${i}`).innerHTML = ''
                el.family.split(',').forEach(function(el_,i_){

                    document.getElementById(`grid_layout_inner_${i}`).innerHTML += `<div class="grid-layout-cell flex-auto">
                                                                                                   <div class="value">${i_ < 3 ? el_ : i_ === 3 ? `외 ${el.family.split(',').length-3}개의 연락처` : ""}</div>
                                                                                               </div>`

                })
            })



    })

}

function consulting_hold_list(){
    document.getElementById('consulting_data').style.opacity = 0;
    document.getElementById('consulting_hold_desc').style.display = 'block';
    document.getElementById('consulting_history_desc').style.display = 'none';
    document.getElementById('consulting_list').innerHTML = '';
    document.getElementById('consulting_hold_list_none_data').style.display = 'none';
    let status = '';

    if(data.consulting_count === 0){
        document.getElementById('consulting_hold_list_none_data').style.display = 'block';

    }
    data.consulting.forEach(function(el, i){

        switch (el.approval){

            case 0: status = '대기'; break;
            case 1: status = '보류'; break;
            case 2: status = '승인'; break;
            case 3: status = '반려'; break;
            case 4: status = '견주 측 취소'; break;
        }

        if(status === '대기' && i < data.consulting_count){
            document.getElementById('consulting_list').innerHTML += `<div class="grid-layout-cell grid-2">
                                                                                         <div class="${(el.pet_name+el.phone).toString() === localStorage.getItem('consulting_select') ? 'actived':''} thema-gray-item white consulting-select" data-pet_name="${el.pet_name}" data-phone="${el.phone}">
                                                                                            <a href="#" class="basic-list-item store">
                                                                                                <div class="info-wrap">
                                                                                                    <div class="item-name">
                                                                                                        <strong>${el.pet_name}</strong>
                                                                                                        <br>
                                                                                                        <div class="">${phone_edit(el.phone)}</div>
                                                                                                    </div>
                                                                                                    <div class="item-date2">${am_pm_check2(el.date)}</div>
                                                                                                </div>
                                                                                            </a>
                                                                                            <div class="item-state2">
                                                                                                <strong class="font-color-lightgray">${status}</strong>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>`
        }
    })


}

function consulting_history_list(){

    document.getElementById('consulting_hold_desc').style.display = 'none';
    document.getElementById('consulting_history_desc').style.display = 'block';
    document.getElementById('consulting_list').innerHTML = '';
    document.getElementById('consulting_hold_list_none_data').style.display = 'none';
    document.getElementById('consulting_data').style.opacity = 0;
    localStorage.removeItem('consulting_select');

    let status = '';

    data.consulting.forEach(function(el, i){

        switch (el.approval){

            case 0: status = '대기'; break;
            case 1: status = '보류'; break;
            case 2: status = '승인'; break;
            case 3: status = '반려'; break;
            case 4: status = '견주 측 취소'; break;
        }

        if(i >= data.consulting_count) {
            if(status === '대기'){
                status = '자동 취소';
            }

            document.getElementById('consulting_list').innerHTML += `<div class="grid-layout-cell grid-2">
                                                                                         <div class="thema-gray-item white consulting-select ${(el.pet_name + el.phone).toString() === localStorage.getItem('consulting_select') ? 'actived' : ''}" data-pet_name="${el.pet_name}" data-phone="${el.phone}">
                                                                                            <a href="#" class="basic-list-item store">
                                                                                                <div class="info-wrap">
                                                                                                    <div class="item-name">
                                                                                                        <strong>${el.pet_name}</strong>
                                                                                                        <br>
                                                                                                        <div class="">${phone_edit(el.phone)}</div>
                                                                                                    </div>
                                                                                                    <div class="item-date2">${am_pm_check2(el.date)}</div>
                                                                                                </div>
                                                                                            </a>
                                                                                            <div class="item-state2">
                                                                                                <strong class="font-color-lightgray">${status}</strong>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>`
        //
        }
    })
}

function consulting_list_select(){
    let select = document.getElementsByClassName('consulting-select');
    Array.from(select).forEach(function (el){

        el.addEventListener('click',function (){

            if(el.classList.contains('actived')){

                el.classList.remove('actived');
                document.getElementById('consulting_data').style.opacity = 0;
            }else{

                Array.from(select).forEach(function (el_){


                    el_.classList.remove('actived')
                })


                el.classList.add('actived');

                document.getElementById('consulting_data').style.opacity = 1;
                document.getElementById('consulting_data').innerHTML = '';
                data.consulting.forEach(function(el_){

                    if(el_.pet_name === el.getAttribute('data-pet_name') && el_.phone === el.getAttribute('data-phone')){
                        document.getElementById('consulting_data').innerHTML = '';
                            document.getElementById('consulting_data').innerHTML +=`<div class="basic-data-card">
                                                                                                <div class="card-header">
                                                                                                    <h3 class="card-header-title">이용상담 정보</h3>
                                                                                                </div>
                                                                                                <div class="card-body">
                                                                                                    <div class="card-body-inner">
                                                                                                        <div class="reserve-advice-view">
                                                                                                            <div class="reserve-advice-view-info">* 상담신청 후 12시간 이내에 상담 완료를 꼭 눌러주세요.
                                                                                                                <button type="button" onclick="pop.open('reserveAdviceMsg1')" class="btn-data-helper">도움말</button>
                                                                                                            </div>
                                                                                                        <div class="basic-data-group">
                                                                                                            <div class="con-title-group">
                                                                                                                <h4 class="con-title">신청고객정보</h4>
                                                                                                            </div>
                                                                                                            <div class="flex-table type-2">
                                                                                                                <div class="flex-table-cell">
                                                                                                                    <div class="flex-table-item">
                                                                                                                        <div class="flex-table-title">
                                                                                                                            <div class="txt">연락처</div>
                                                                                                                        </div>
                                                                                                                        <div class="flex-table-data">
                                                                                                                            <div class="flex-table-data-inner">${phone_edit(el_.phone)}</div>
                                                                                                                            <div class="flex-table-data-side">
                                                                                                                                <div class="btn-ui-group">
                                                                                                                                    <a href="tel:${el_.phone}"><button type="button" class="btn-data-tel">전화하기</button></a>
                                                                                                                                    <a href="sms:${el_.phone}"><button type="button" class="btn-data-message">메시지보내기</button></a>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="basic-data-group">
                                                                                                            <div class="con-title-group">
                                                                                                                <h4 class="con-title">기본 정보</h4>
                                                                                                            </div>
                                                                                                            <div class="flex-table type-2">
                                                                                                                <div class="flex-table-cell">
                                                                                                                    <div class="flex-table-item">
                                                                                                                        <div class="flex-table-title">
                                                                                                                            <div class="txt">이름</div>
                                                                                                                        </div>
                                                                                                                        <div class="flex-table-data">
                                                                                                                            <div class="flex-table-data-inner">${el_.pet_name}</div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="flex-table-cell">
                                                                                                                    <div class="flex-table-item">
                                                                                                                        <div class="flex-table-title">
                                                                                                                            <div class="txt">품종</div>
                                                                                                                        </div>
                                                                                                                        <div class="flex-table-data">
                                                                                                                            <div class="flex-table-data-inner">${el_.pet_type}</div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="flex-table-cell">
                                                                                                                    <div class="flex-table-item">
                                                                                                                        <div class="flex-table-title">
                                                                                                                            <div class="txt">생일</div>
                                                                                                                        </div>
                                                                                                                        <div class="flex-table-data">
                                                                                                                            <div class="flex-table-data-inner">${el_.birth}</div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="flex-table-cell">
                                                                                                                    <div class="flex-table-item">
                                                                                                                        <div class="flex-table-title">
                                                                                                                            <div class="txt">성별</div>
                                                                                                                        </div>
                                                                                                                        <div class="flex-table-data">
                                                                                                                            <div class="flex-table-data-inner">${el_.gender}</div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="flex-table-cell">
                                                                                                                    <div class="flex-table-item">
                                                                                                                        <div class="flex-table-title">
                                                                                                                            <div class="txt">중성화</div>
                                                                                                                        </div>
                                                                                                                        <div class="flex-table-data">
                                                                                                                            <div class="flex-table-data-inner">${el_.neutral ? 'O' : 'X'}</div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="flex-table-cell">
                                                                                                                    <div class="flex-table-item">
                                                                                                                        <div class="flex-table-title">
                                                                                                                            <div class="txt">몸무게</div>
                                                                                                                        </div>
                                                                                                                        <div class="flex-table-data">
                                                                                                                            <div class="flex-table-data-inner">${el_.weight}Kg</div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="flex-table-cell">
                                                                                                                    <div class="flex-table-item">
                                                                                                                        <div class="flex-table-title">
                                                                                                                            <div class="txt">미용경험</div>
                                                                                                                        </div>
                                                                                                                        <div class="flex-table-data">
                                                                                                                            <div class="flex-table-data-inner">${el_.beauty_exp}</div>
                                                                                                                        </div>
                                                                                                                   </div>
                                                                                                                </div>
                                                                                                                <div class="flex-table-cell">
                                                                                                                    <div class="flex-table-item">
                                                                                                                        <div class="flex-table-title">
                                                                                                                            <div class="txt">예방접종</div>
                                                                                                                        </div>
                                                                                                                        <div class="flex-table-data">
                                                                                                                            <div class="flex-table-data-inner">${el_.vassination}</div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="flex-table-cell">
                                                                                                                    <div class="flex-table-item">
                                                                                                                        <div class="flex-table-title">
                                                                                                                            <div class="txt">입질</div>
                                                                                                                        </div>
                                                                                                                        <div class="flex-table-data">
                                                                                                                            <div class="flex-table-data-inner">${el_.bite ? '해요' : '안해요'}</div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="flex-table-cell">
                                                                                                                    <div class="flex-table-item">
                                                                                                                        <div class="flex-table-title">
                                                                                                                            <div class="txt">싫어하는 부위</div>
                                                                                                                        </div>
                                                                                                                        <div class="flex-table-data">
                                                                                                                            <div class="flex-table-data-inner">다리</div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="flex-table-cell">
                                                                                                                    <div class="flex-table-item">
                                                                                                                        <div class="flex-table-title">
                                                                                                                            <div class="txt">슬개골탈구</div>
                                                                                                                        </div>
                                                                                                                        <div class="flex-table-data">
                                                                                                                            <div class="flex-table-data-inner">${el_.luxation}</div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="basic-data-group">
                                                                                                            <div class="con-title-group">
                                                                                                                <h4 class="con-title">특이사항</h4>
                                                                                                            </div>
                                                                                                            <div class="con-title-group">
                                                                                                                <h5 class="con-title">${el_.dermatosis ? "피부병" : ""} ${el_.heart_trouble ? "심장질환" : ""} ${el_.marking ? "마킹" : ""} ${el_.mounting ? "마운팅" : ""} </h5>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="basic-data-group">
                                                                                                            <div class="con-title-group">
                                                                                                                <h4 class="con-title">원하는 미용</h4>
                                                                                                            </div>
                                                                                                            <div class="con-title-group">
                                                                                                                <h5 class="con-title">목욕 · 목욕  · 목욕 </h5>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="basic-data-group">
                                                                                                            <div class="con-title-group">
                                                                                                                <h4 class="con-title">현재 아이 모습</h4>
                                                                                                            </div>
                                                                                                            <div class="basic-data-group vvsmall2">
                                                                                                                <div class="portfolio-list-wrap">
                                                                                                                    <div class="list-inner">
                                                                                                                        <div class="list-cell">
                                                                                                                            <a href="#" class="btn-portfolio-item">
                                                                                                                                <img src="https://image.banjjakpet.com${el_.consult_photo.length >0 ? el_.consult_photo[0].photo : `${el_.photo ? el_.photo.replace('/pet','') : ``}`}" alt="">
                                                                                                                            </a>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="basic-data-group">
                                                                                                            <button type="button" class="btn btn-outline-red btn-basic-full">예약 거부</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="card-footer">
                                                                                            <!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
                                                                                                <button type="button" class="btn-page-bottom">상담완료</button>
                                                                                            </div>
                                                                                        </div>`


                    }
                })
            }
        })
    })
}

function calendar_change_month(){

    let month_nav = document.getElementsByClassName('btn-simple-calendar-month-nav')

    Array.from(month_nav).forEach(function(el){
        if(el.innerText.trim() == date.getMonth()+1){
            el.classList.add('actived');
        }

        el.addEventListener('click',function(){

            Array.from(month_nav).forEach(function (el_){
                el_.classList.remove('actived');
            })
            date.setMonth(parseInt(el.innerText.trim())-1);
            book_list().then(function(){
                _renderCalendar_mini();
                document.querySelector('.calendar-title-sort').classList.remove('actived')


                if(el.innerText.trim() == date.getMonth()+1){
                    el.classList.add('actived');
                }
            })

        })

    })
}

function btn_month_simple(){


    let simple_prev = document.getElementById('btn-simple-calendar-prev');
    let simple_next = document.getElementById('btn-simple-calendar-next');
    document.getElementById('top-title').innerHTML = date.getFullYear();

    simple_prev.addEventListener('click',function(){
        document.getElementById('top-title').innerHTML = date.getFullYear()-1;
        date.setFullYear(date.getFullYear()-1);
    })

    simple_next.addEventListener('click',function (){
        document.getElementById('top-title').innerHTML = date.getFullYear()+1;
        date.setFullYear(date.getFullYear()+1)
    })

}

function mini_calendar_init(){

    return new Promise(function (resolve){

        let select = localStorage.getItem('day_select').split('.');

        date.setFullYear(parseInt(select[0]));
        date.setMonth(parseInt(select[1])-1);
        date.setDate(parseInt(select[2]));

        resolve();

    })


}

function reserve_schedule(){

    return new Promise(function (resolve){




    $.ajax({

        url:'../data/pc_ajax.php',
        type:'post',
        data:{
            mode:'open_close',
            login_id:localStorage.getItem('id')

        },
        success:function(res){
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '서버 오류입니다.');
            } else if (head.code === 200) {
                let open = body[0].open_time;
                let close = body[0].close_time;

                let row = document.getElementsByClassName('calendar-day-body-row');
                let day_body = document.getElementById('day_body');
                day_body.innerHTML = '';
                for(let i=open; i<close; i++){

                    for(let t= 0; t<60; t +=30){

                        let thisTime = `${fill_zero(i)}:${fill_zero(t)}`
                        let thisTime_s = thisTime.split(':');
                        let date_ = fill_zero(new Date('','','',thisTime_s[0],thisTime_s[1]));
                        let date__ = fill_zero(new Date('','','',thisTime_s[0],thisTime_s[1]));

                        date__.setMinutes(date__.getMinutes()+30);


                        day_body.innerHTML += `<div class="calendar-day-body-row" data-time-to="${thisTime}" data-time-from="${fill_zero(date__.getHours())}:${fill_zero(date__.getMinutes())}" data-hour="${thisTime_s[0]}" data-minutes="${thisTime_s[1]}">
                                                                                        <div class="calendar-day-body-col time">
                                                                                            ${thisTime === `${fill_zero(open)}:00` && thisTime < '12:00' 
                                                                                            ? `<div class="day-division-label">오전</div>`
                                                                                            : `${thisTime === `${fill_zero(open)}:00` && thisTime >= '12:00' 
                                                                                            ? `<div class="day-division-label">오후</div>` 
                                                                                            : `${thisTime === '12:00' 
                                                                                            ? `<div class="day-division-label">오후</div>` 
                                                                                            : `` }` }`}
                                                                                            
                                                                                            <div class="time-label">
                                                                                                <div class="time-start-label">${am_pm_check3(fill_zero(date_.getHours()))}:${fill_zero(date_.getMinutes())}</div>
                                                                                                <div class="time-end-label"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                        
                                                                                        
                                                                                    </div>`





                    }



                }



                let day_height = day_body.offsetHeight;

                let now_hour = new Date().getHours();
                let now_minutes = new Date().getMinutes();

                let work_time = (close-open)*60;
                let division = day_height/work_time;
                let div_height = (((now_hour-open)*60)+now_minutes)*division;


                if(open <= now_hour && now_hour < close ){
                    day_body.innerHTML += `<div class="calendar-day-current-time" style="top:${div_height}px"><div class="bar"></div><div class="value">${fill_zero(date.getHours())}:${fill_zero(date.getMinutes())}</div></div>`
                }



                resolve();





            }
        }
    })
    })
}


function cols(){


    return new Promise(function (resolve){



        $.ajax({

            url:'../data/pc_ajax.php',
            type:'post',
            async:false,
            data:{
                mode:'working',
                login_id:localStorage.getItem('id'),
            },
            success:function (res){

                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '서버 오류입니다.');
                } else if (head.code === 200) {
                    document.getElementById('day_header_row').innerHTML = `<div class="calendar-day-header-col time"></div>`
                    let break_time = JSON.parse(localStorage.getItem('break_time'))
                    let break_times = '';
                    break_time.forEach(function(el,i){

                        break_times += `${el.time.split('~')[0]} `


                    })
                    console.log(break_times);

                    body.forEach(function (el){
                        if(el.is_show && !el.is_leave){
                            el.work.forEach(function (el_){
                                if(parseInt(el_.week) === date.getDay() ){
                                    document.getElementById('day_header_row').innerHTML +=`<div class="calendar-day-header-col">${el.nick}</div>`



                                    Array.from(document.getElementsByClassName('calendar-day-body-row')).forEach(function(_el){

                                        _el.innerHTML += `<div class="calendar-day-body-col ${break_times.match(_el.getAttribute('data-time-to')) ? 'break':'' } " data-name="${el.name}" data-nick="${el.nick}" data-time-to="${_el.getAttribute('data-time-to')}" data-time-from="${_el.getAttribute('data-time-from')}" data-year="${date.getFullYear()}" data-month="${date.getMonth()}" data-date="${date.getDate()}" data-hour="${_el.getAttribute('data-hour')}" data-minutes="${_el.getAttribute('data-minutes')}">
                                                            <div class="calendar-drag-item-group">
                                                                <a href="#" class="btn-calendar-add">등록하기</a>
                                                            </div>       
                                                         </div>`

                                        resolve();
                                    })
                                }
                            })
                        }

                    })





                }
            }
        })
    })
}


function btn_schedule(){

    document.getElementById('btn-schedule-next').addEventListener('click',function(){
        date.setDate(date.getDate()+1)
        if(date.getDate() === 1){
            book_list().then(function (){


                renderCalendar_mini().then(function(div_dates){

                    for (let i = 0; i < div_dates.length; i++) {
                        document.getElementById(`mini-calendar-month-body-row-${i}`).innerHTML = '';
                        for (let j = 0; j < div_dates[i].length; j++) {
                            document.getElementById(`mini-calendar-month-body-row-${i}`).innerHTML += div_dates[i][j]
                        }
                    }


                })
            }).then(function(){

                let date_info = document.getElementsByClassName('date-info');
                let booking_list ;

                if(localStorage.getItem('list')){
                    booking_list = JSON.parse(localStorage.getItem('list'));
                }else{
                    booking_list = data;
                }

                Array.from(date_info).forEach(function(el,i){
                    let count = 0;
                    let date_ck_1 = new Date(`20${el.innerText.trim()}`);

                    if(booking_list.beauty.length === 0){
                        Array.from(document.getElementsByClassName('reserve-total')).forEach(function (el,i){
                            el.innerHTML = '0';
                        })
                    }else{
                        booking_list.beauty.forEach(function(el_,i_){
                            let date_ck_2  =  new Date(el_.product.date.booking_st);

                            if(date_ck_1.getFullYear() === date_ck_2.getFullYear()
                                && date_ck_1.getMonth() === date_ck_2.getMonth()
                                && date_ck_1.getDate() === date_ck_2.getDate()){
                                count++;
                            }



                            siblings(el.parentElement.parentElement.parentElement.parentElement,0).children[1].innerHTML= `${count}`;

                        })
                    }
                })
            }).then(function(){






                let mini_col = document.getElementsByClassName('mini-calendar-month-body-col');

                Array.from(mini_col).forEach(function(el) {

                    el.addEventListener('click', function () {

                        Array.from(mini_col).forEach(function (el_) {

                            el_.classList.remove('actived');
                        })

                        el.classList.add('actived');
                        localStorage.setItem('day_select', `${date.getFullYear()}.${fill_zero(date.getMonth() + 1)}.${fill_zero(el.children[0].children[0].children[0].children[0].innerText.trim())}`)
                        date.setDate(el.children[0].children[0].children[0].children[0].innerText.trim());

                        schedule_render();

                    })
                })




            })
        }

        schedule_render()






    })

    document.getElementById('btn-schedule-prev').addEventListener('click',function (){
        date.setDate(date.getDate()-1)
        if(date.getDate() >= 28){
            book_list().then(function (){


                renderCalendar_mini().then(function(div_dates){

                    for (let i = 0; i < div_dates.length; i++) {
                        document.getElementById(`mini-calendar-month-body-row-${i}`).innerHTML = '';
                        for (let j = 0; j < div_dates[i].length; j++) {
                            document.getElementById(`mini-calendar-month-body-row-${i}`).innerHTML += div_dates[i][j]
                        }
                    }


                })
            }).then(function(){

                let date_info = document.getElementsByClassName('date-info');
                let booking_list ;

                if(localStorage.getItem('list')){
                    booking_list = JSON.parse(localStorage.getItem('list'));
                }else{
                    booking_list = data;
                }

                Array.from(date_info).forEach(function(el,i){
                    let count = 0;
                    let date_ck_1 = new Date(`20${el.innerText.trim()}`);

                    if(booking_list.beauty.length === 0){
                        Array.from(document.getElementsByClassName('reserve-total')).forEach(function (el,i){
                            el.innerHTML = '0';
                        })
                    }else{
                        booking_list.beauty.forEach(function(el_,i_){
                            let date_ck_2  =  new Date(el_.product.date.booking_st);

                            if(date_ck_1.getFullYear() === date_ck_2.getFullYear()
                                && date_ck_1.getMonth() === date_ck_2.getMonth()
                                && date_ck_1.getDate() === date_ck_2.getDate()){
                                count++;
                            }



                            siblings(el.parentElement.parentElement.parentElement.parentElement,0).children[1].innerHTML= `${count}`;

                        })
                    }
                })
            }).then(function(){






                let mini_col = document.getElementsByClassName('mini-calendar-month-body-col');

                Array.from(mini_col).forEach(function(el) {

                    el.addEventListener('click', function () {

                        Array.from(mini_col).forEach(function (el_) {

                            el_.classList.remove('actived');
                        })

                        el.classList.add('actived');
                        localStorage.setItem('day_select', `${date.getFullYear()}.${fill_zero(date.getMonth() + 1)}.${fill_zero(el.children[0].children[0].children[0].children[0].innerText.trim())}`)
                        date.setDate(el.children[0].children[0].children[0].children[0].innerText.trim());

                        schedule_render();

                    })
                })




            })
        }
        schedule_render()


    })
}


function break_time(){


    $.ajax({


        url:'../data/pc_ajax.php',
        type:'post',
        data:{

            mode:'break_time',
            login_id:localStorage.getItem('id'),
        },
        success:function(res){
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '서버 오류입니다.');
            } else if (head.code === 200) {

              localStorage.setItem('break_time',JSON.stringify(body[0].res_time_off))




            }


        }
    })
}