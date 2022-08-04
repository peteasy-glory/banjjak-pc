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
        hours = `오후 ${hours-12}`
    }else if(hours === 12){
        hours = `오후 ${hours}`
    }else{
        hours = `오전 ${hours}`
    }

    return hours;
}

//분 시간 0채우기
function fill_zero(minute){

    if(minute.toString().length < 2){

        minute = `0${minute}`
    }else{
        minute = minute;
    }

    return minute;
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
        document.querySelector('.year-month').textContent = `${viewYear}.${(viewMonth + 1).toString().length < 2 ? `0${viewMonth + 1}` : viewMonth + 1}`;

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
                                                
                                                ${prevDates.indexOf(_date) >= 0 && i <= 7 ? `${date.getFullYear().toString().substr(-2)}.${date.getMonth().toString().length < 2 ? '0' + date.getMonth() : date.getMonth()}.${_date.toString().length < 2 ? '0' + _date : _date}` : `${nextDates.indexOf(_date) >= 0 && i >= dates.length - 7 ? `${date.getFullYear().toString().substr(-2)}.${(date.getMonth() + 2).toString().length < 2 ? '0' + (date.getMonth() + 2) : date.getMonth() + 2}.${_date.toString().length < 2 ? '0' + _date : _date}` : `${date.getFullYear().toString().substr(-2)}.${(date.getMonth() + 1).toString().length < 2 ? '0' + (date.getMonth() + 1) : date.getMonth() + 1}.${_date.toString().length < 2 ? '0' + _date : _date}`}`}
                                                </div>
                                                <div class="value reserve-total-2"></div>
                                            </div>
                                        </div>
                                        <div class="list-cell">
                                            <a href="#" class="btn-list-nav">
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


                if(el.innerText.trim() === `${date.getFullYear().toString().substr(2,2)}.${fill_zero(date.getMonth()+1).toString()}.${fill_zero(date.getDate()).toString()}`){
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
                _renderCalendar();
                stats();
        })
    })

    document.getElementById('btn-month-next').addEventListener('click', function (evt) {

        date.setDate(1);
        date.setMonth(date.getMonth() + 1);
        book_list().then(function (){
               _renderCalendar();
               stats();

        })


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
            if (el.date && el.approval === 0) {
                let date_proc = el.date.split("T");
                let date_proc_ymd = date_proc[0].replaceAll('-', '.');
                let date_proc_his = date_proc[1].substr(0, 5);
                let date_proc_h = parseInt(date_proc_his.substr(0, 2));
                let date_times = new Date(date_proc[0].substr(0, 4), date_proc[0].substr(5, 2) - 1, date_proc[0].substr(-2), date_proc[1].substr(0, 2), date_proc[1].substr(3, 2), date_proc[1].substr(-2)).getTime()
                let times_date_times = ((times - date_times) / 1000 / 60).toFixed();

                if (parseInt(date_proc_h) >= 12) {
                    date_proc_his = `오후 ${date_proc_h === 12 ? date_proc_his : `${(date_proc_h - 12).toString().length < 2 ? `0${date_proc_h - 12}` : date_proc_h - 12}${date_proc_his.substr(-3)}`}`;
                } else {
                    date_proc_his = `오전 ${date_proc_his}`;
                }

                let consulting_select = JSON.stringify(el);

                document.querySelector('.main-customer-list').innerHTML += `<div class="main-customer-list-cell">
                                                                                       <a href="../booking/reserve_advice_view.php" onclick="localStorage.setItem('consulting_select',${consulting_select})" class="customer-card-item transparent">
                                                                                           <div class="item-info-wrap">
                                                                                               <div class="item-data">
                                                                                                   <div class="item-data-inner">
                                                                                                       <div class="item-name">${el.pet_name}
                                                                                                           
                                                                                                       </div>
                                                                                                       <div class="item-phone">${el.phone.replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`)}</div>
                                                                                                       <div class="item-date">${date_proc_ymd} ${date_proc_his}</div>
                                                                                                   </div>
                                                                                               </div>
                                                                                               <div class="item-state">
                                                                                                   <div class="item-time">${(times_date_times / 60 / 24) > 31 ? `${(times_date_times / 60 / 24 / 31).toFixed()}달 전` : (times_date_times / 60) > 23 ? `${Math.floor(times_date_times / 60 / 24)}일 전` : (times_date_times / 60) < 1 ? `${Math.floor(times_date_times) === 0 ? `방금 전` : `${Math.floor(times_date_times)}분 전`}` : `${Math.floor(times_date_times / 60)}시간 전`}</div>
                                                                                               </div>
                                                                                           </div>
                                                                                       </a>
                                                                                   </div>`;
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
                    case 1 : body_rows = document.getElementsByClassName('main-calendar-month-body-row');
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

function search_phone(phone) {

    return new Promise(function (resolve){

        document.getElementById('search_phone').value = phone.toString();
        console.log(phone);
        $.ajax({

            url:'../data/pc_ajax.php',
            type:'post',
            data:{
                mode:'search_phone',
                login_id:localStorage.getItem('id'),
                phone:phone,
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
                    console.log(body);
                    if(body.length > 0){
                        document.getElementById('search_phone_none_data').style.display = 'none';
                        document.getElementById('search_phone_inner').innerHTML = ''
                        body.forEach(function (el,i){

                            document.getElementById('search_phone_inner').innerHTML += `<div class="grid-layout-cell grid-2">
                                                                                                <a href="#" class="customer-card-item">
                                                                                                    <div class="item-info-wrap">
                                                                                                        <div class="item-thumb">
                                                                                                            <div class="user-thumb large"></div>
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
<!--                                                                                                                    <div class="label label-outline-pink label-noshow">NO SHOW 1회</div>-->
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

                }
            }
        })
    })
}

function search_phone_fam(phone){
    search_phone(phone).then(function(body){
            body.forEach(function (el,i){
                document.getElementById(`grid_layout_inner_${i}`).innerHTML = ''
                el.family_cell.forEach(function(el_,i_){

                    document.getElementById(`grid_layout_inner_${i}`).innerHTML += `<div class="grid-layout-cell flex-auto">
                                                                                                   <div class="value">${i_ < 3 ? el_.phone : i_ === 3 ? `외 ${el.family_cell.length-3}개의 연락처` : ""}</div>
                                                                                               </div>`

                })
            })



    })

}