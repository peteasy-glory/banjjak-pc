
var memo_array = [];

//일간 예약관리 렌더
function schedule_render(id){

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'day_book',
            login_id:id,
            st_date:`${date.getFullYear()}-${fill_zero(date.getMonth()+1)}-${fill_zero(date.getDate())}`,
            fi_date:`${date.getFullYear()}-${fill_zero(date.getMonth()+1)}-${fill_zero(date.getDate()+1)}`,
        },
        beforeSend:function(){
            let height;


            if(document.getElementById('reserve_calendar_inner_day')){
                height = document.getElementById('reserve_calendar_inner_day').offsetHeight;
                document.getElementById('reserve_calendar_inner_day').style.display = 'none';
                document.getElementById('day_schedule_loading').style.height = `${height}px`;
                document.getElementById('day_schedule_loading').style.display = 'flex';

            }
        },
        success:function (res){
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
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


                reserve_schedule(id).then(function(){
                    reserve_prohibition_list(id);

                    cols(id).then(function (body_data){

                        no_one(body_data);

                        let color;
                        body.forEach(function (el, index){
                            // 툴팁배열에 idx 넣기
                            tooltip(el.product.payment_idx);

                            Array.from(document.getElementsByClassName('calendar-day-body-col')).forEach(function (el_){

                                if(el_.getAttribute('data-name') === el.product.worker && new Date(el_.getAttribute('data-year'),el_.getAttribute('data-month'),el_.getAttribute('data-date'),el_.getAttribute('data-hour'),el_.getAttribute('data-minutes')).getTime() === new Date(el.product.date.booking_st).getTime() && el.product.is_cancel === 0){
                                    switch(el.product.pay_type){

                                        case "pos-card" : case "pos-cash" : color = 'yellow'; break;
                                        case "offline-card" : case "offline-cash" : color = 'purple'; break;
                                        default : color = ''; break;

                                    }


                                    el_.setAttribute('data-pay',el.product.payment_idx)
                                    el_.setAttribute('data-time_length',(new Date(el.product.date.booking_fi).getTime()-new Date(el.product.date.booking_st).getTime())/1000/60)

                                    let multiple = (new Date(el.product.date.booking_fi).getTime() - new Date(el.product.date.booking_st).getTime())/1800000;
                                    el_.innerHTML = `<div class="calendar-drag-item-group">
                                                                        <a href="./reserve_pay_management_beauty_1.php" data-tooltip_idx="${index}" data-payment_idx="${el_.getAttribute('data-pay')}" onclick="localStorage.setItem('payment_idx',${el_.getAttribute('data-pay')})" class="calendar-week-time-item toggle green ${color} ${el.product.is_no_show === 1 ? "red" : ''} ${el.product.is_approve === 0 ? 'gray': ''}" style="height: calc(100% * ${multiple}); ">
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


                        $.ajax({

                            url:'/data/pc_ajax.php',
                            type:'post',
                            async:false,
                            data:{
                                mode:'schedule_artist',
                                login_id:id,
                            },
                            success:function (res){
                                let response = JSON.parse(res);
                                let head = response.data.head;
                                let body = response.data.body;
                                if (head.code === 401) {
                                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                                } else if (head.code === 200) {



                                    body.working.forEach(function(el){

                                        if(!el.is_leave && el.is_show){
                                            Array.from(document.getElementsByClassName('time-compare-cols')).forEach(function(el_){


                                                el.work.forEach(function(_el){



                                                    if(el_.getAttribute('data-nick') === el.nick
                                                        && parseInt(_el.week) === date.getDay()
                                                        && ( time_compare(_el.time_st,el_.getAttribute('data-time-to'))
                                                            || time_compare(el_.getAttribute('data-time-from'),_el.time_fi))
                                                    ){


                                                        el_.classList.add('break')

                                                    }

                                                })


                                            })

                                        }

                                    })



                                }

                            }


                        })



                        day_drag();
                    });
                });

            }


        },

    })
}


function reserve_schedule_week_cols(body,body_,parent,id,session_id){





    let body_col = document.getElementsByClassName('calendar-week-body-col-add');

    // $(document).on('mouseenter mouseleave mousemove', '.calendar-week-time-item',function(){
    //
    //
    //     document.getElementById('tooltip_date').innerText = booking_st;
    //     document.getElementById('tooltip_desc').innerText = _el.product.memo;
    // })
    Array.from(document.getElementsByClassName('header-worker')).forEach(function (el){

        el.addEventListener('click',function(){

            Array.from(document.getElementsByClassName('header-worker')).forEach(function(el_){

                el_.classList.remove('actived');

            })

            Array.from(body_col).forEach(function(__el){

                if(sessionStorage.getItem('direct') === '1'){
                    __el.innerHTML =`<div class="calendar-drag-item-group">
                                    <a href="#add" onclick="direct_get_pet_info('${id}',this,${sessionStorage.getItem('direct_pet_seq')},'${session_id}')" class="btn-calendar-add">등록하기</a>
                                    </div>`
                }else{
                    __el.innerHTML =`<div class="calendar-drag-item-group">
                                    <a href="#add" onclick="reserve_pop(this)" class="btn-calendar-add">등록하기</a>
                                    </div>`
                }

            })
            el.classList.add('actived');

            body_.forEach(function(_el, index){
                tooltip(_el.product.payment_idx);

                //console.log(_el);
                if(_el.product.worker === el.getAttribute('data-worker')){



                    let booking_st = _el.product.date.booking_st
                    let booking_fi = _el.product.date.booking_fi
                    let day = new Date(booking_st).getDay();
                    let _booking_st = _el.product.date.booking_st.split(' ')[1];


                    let color;

                    switch(_el.product.pay_type){

                        case "pos-card" : case "pos-cash" : color = 'yellow'; break;
                        case "offline-card" : case "offline-cash" : color = 'purple'; break;
                        default : color = ''; break;

                    }
                    let multiple = (new Date(booking_fi).getTime() - new Date(booking_st).getTime())/1800000;



                    Array.from(body_col).forEach(function(el__){






                        if(parseInt(el__.getAttribute('data-day')) === day && _booking_st === el__.getAttribute('data-time-to') && _el.product.is_cancel === 0){



                            el__.setAttribute('data-pay',_el.product.payment_idx);

                            el__.setAttribute('data-time_length',(new Date(_el.product.date.booking_fi).getTime()-new Date(_el.product.date.booking_st).getTime())/1000/60)

                            el__.innerHTML = `<div class="calendar-drag-item-group">
                                                    <a href="/booking/reserve_pay_management_beauty_1.php" data-tooltip_idx="${index}" onclick="localStorage.setItem('payment_idx',${_el.product.payment_idx})" data-pay="${_el.product.payment_idx}" class="calendar-week-time-item toggle green ${color} ${_el.product.is_no_show === 1 ? "red" : ''} ${_el.product.is_approve === 0 ? 'gray': ''}" style="height: calc(100% * ${multiple}); ">
                                                        <div class="item-inner">
                                                            <div class="item-name">
                                                                <div class="txt">${_el.pet.name}</div>
                                                                <button type="button" class="btn-calendar-item-more"></button>
                                                            </div>
                                                            <div class="item-cate">${_el.pet.type}</div>
                                                            <div class="item-price">${((parseInt(_el.product.store_payment.card === null || _el.product.store_payment.card === "" ? 0 : parseInt(_el.product.store_payment.card))+(_el.product.store_payment.cash === null || _el.product.store_payment.cash === "" ? 0 : parseInt(_el.product.store_payment.cash)))-parseInt(_el.product.store_payment.discount.toString().length <3 ? (parseInt(_el.product.store_payment.cash === null || _el.product.store_payment.cash === "" ? 0 : _el.product.store_payment.cash) + parseInt(_el.product.store_payment.card === null || _el.product.store_payment.card === "" ? 0 : _el.product.store_payment.card)) * _el.product.store_payment.discount /100: _el.product.store_payment.discount  )).toLocaleString()}원</div>
                                                            <div class="item-option">${_el.product.category}</div>
                                                            <div class="item-stats">
                                                                                ${_el.product.is_confirm ? `<div class="right">
                                                                                        <div class="item-cash">
                                                                                            ${_el.product.pay_type === "pos-card" ? `<div class="icon icon-reservation-card-off"></div>` : `<div class="icon icon-reservation-cash-off"></div>` }
                                                                                            
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


                }









            })


            Array.from(body_col).forEach(function (e){

                e.classList.remove('break')
            })


            let work_day = [];

            Array.from(body).forEach(function (q){


                if(el.getAttribute('data-worker') === q.name){

                    q.work.forEach(function (w){

                        work_day.push(w.week);



                        Array.from(body_col).forEach(function (e){


                            if(w.week === e.getAttribute('data-day') && (time_compare(w.time_st,e.getAttribute('data-time-to')) || time_compare(e.getAttribute('data-time-from'),w.time_fi))){



                                e.classList.add('break')

                            }

                            if(e.getAttribute('data-day').includes(work_day_search(work_day))){

                                e.classList.add('break')
                            }



                        })


                    })
                }
            })



            console.log(work_day_search(work_day))

            week_holiday(parent,id).then(function(){

                Array.from(document.getElementsByClassName('week-day-check')).forEach(function(el){

                    if(el.parentElement.children[0].innerText === ''){

                        Array.from(document.getElementsByClassName('calendar-week-body-col-add')).forEach(function (el_){

                            if(el_.getAttribute('data-day') === el.getAttribute('data-day')){

                                el_.classList.add('break4');

                                el_.classList.remove('break','break1','break1-1','break2','break2-1')

                            }
                        })
                    }
                })


            });
            reserve_prohibition_list(id);
            setTimeout(function(){week_drag()},200)






        })


    })


}

function work_day_search(work_day){


    for(let i=0; i<7; i++) {

        if(work_day.includes(i.toString())){
            let value = i.toString();
            work_day = work_day.filter(function(item){
                return item !== value;
            })
        }else{

            work_day.push(i.toString())
        }

    }

    if(work_day.length === 0){

        work_day.push('999')
    }

    return work_day;




}


function week_holiday(parent,id){

    return new Promise(function (resolve){
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

                    let bool = false;


                    if(parseInt(body.week_type) === 1){

                        bool = true;

                    }else if(parseInt(body.week_type)  === 2){

                        if(parent.classList.contains('1or3')){

                            bool = true;
                        }
                    }else if(parseInt(body.week_type)  ===3){

                        if(parent.classList.contains('2or4')){

                            bool = true;
                        }
                    }


                    if(bool){
                        if(body.is_work_sun) {

                            Array.from(body_col).forEach(function(el_,i){

                                if(parseInt(el_.getAttribute('data-day')) === 0){

                                    el_.classList.add('break2')
                                    if(i === 0){
                                        el_.classList.add('break2-1');
                                    }

                                }
                            })


                        }
                        if(body.is_work_mon){

                            Array.from(body_col).forEach(function(el_,i){

                                if(parseInt(el_.getAttribute('data-day')) === 1){

                                    el_.classList.add('break2')
                                    if(i === 1){
                                        el_.classList.add('break2-1');
                                    }

                                }
                            })


                        }
                        if(body.is_work_tue){

                            Array.from(body_col).forEach(function(el_,i){

                                if(parseInt(el_.getAttribute('data-day')) === 2){

                                    el_.classList.add('break2')
                                    if(i === 2){
                                        el_.classList.add('break2-1');
                                    }

                                }
                            })


                        }
                        if(body.is_work_wed){


                            Array.from(body_col).forEach(function(el_,i){

                                if(parseInt(el_.getAttribute('data-day')) === 3){
                                    el_.classList.add('break2')
                                    if(i === 3){
                                        el_.classList.add('break2-1');
                                    }

                                }
                            })



                        }
                        if(body.is_work_thu){


                            Array.from(body_col).forEach(function(el_,i){

                                if(parseInt(el_.getAttribute('data-day')) === 4){

                                    el_.classList.add('break2')
                                    if(i === 4){
                                        el_.classList.add('break2-1');
                                    }

                                }
                            })


                        }
                        if(body.is_work_fri){
                            Array.from(body_col).forEach(function(el_,i){
                                if(parseInt(el_.getAttribute('data-day')) === 5){
                                    el_.classList.add('break2')
                                    if(i === 5){
                                        el_.classList.add('break2-1');
                                    }

                                }
                            })
                        }
                        if(body.is_work_sat){
                            Array.from(body_col).forEach(function(el_,i){
                                if(parseInt(el_.getAttribute('data-day')) === 6){
                                    el_.classList.add('break2')
                                    if(i === 6){
                                        el_.classList.add('break2-1');
                                    }

                                }
                            })
                        }
                    }

                    resolve();
                }

            }

        })

    })


}
function week_working(id){
    return new Promise(function (resolve){



        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            async:false,
            data:{
                mode:'working',
                login_id:id,
            },
            success:function (res){

                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {
                    console.log(body)

                    document.getElementById('grid_layout_inner').innerHTML = '';

                    body.forEach(function(el){

                        if(!el.is_leave && el.is_show){

                            document.getElementById('grid_layout_inner').innerHTML += `<div class="grid-layout-cell flex-auto" >
                                                                                                        <button type="button" class="btn-toggle-button header-worker" data-worker="${el.name}" data-nick="${el.nick}">${el.nick}</button>
                                                                                                  </div>`
                        }
                    })


                    document.getElementById('grid_layout_inner').innerHTML+= `<div class="grid-layout-cell flex-auto"><button type="button" onclick="location.href = '/setting/set_teacher.php'" class="btn-toggle-button btn-toggle-basic"><span class="icon icon-plus-more-small"></span></button></div>`

                    resolve(body);
                }
            }
        })
    })
}

function week_timebar(){
    let day_body = document.getElementById('day_body');

    let open = localStorage.getItem('open_close').split('/')[0]
    let close = localStorage.getItem('open_close').split('/')[1]


    let day_height = day_body.offsetHeight;

    let now_hour = new Date().getHours();
    let now_minutes = new Date().getMinutes();

    let work_time = (close - open) * 60;
    let division = day_height / work_time;
    let div_height = (((now_hour - open) * 60) + now_minutes) * division;

    console.log(day_height);
    console.log(division);
    console.log(div_height);
    if (open <= now_hour && now_hour < close) {
        day_body.innerHTML += `<div class="calendar-day-current-time" style="top:${div_height}px"><div class="bar"></div><div class="value">${fill_zero(date.getHours())}:${fill_zero(date.getMinutes())}</div></div>`
    }

}


function reserve_schedule_week(id,body_data) {

    return new Promise(function (resolve) {





    $.ajax({

        url: '/data/pc_ajax.php',
        type: 'post',
        data: {
            mode: 'open_close',
            login_id: id,

        },
        success: function (res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                let break_time = '';
                let break_times = '';
                if(localStorage.getItem('break_time') !== ''){
                    break_time = JSON.parse(localStorage.getItem('break_time'))

                    break_time.forEach(function(el,i){
                        break_times += `${el.time.split('~')[0]} `
                    })
                }

                let day_body = document.getElementById('day_body');


                let open = body[0].open_time;
                let close = body[0].close_time;
                let row = document.getElementById('week_header_row');



                day_body.innerHTML = '';


                for (let i = open; i < close; i++) {

                    for (let t = 0; t < 60; t += 30) {

                        let thisTime = `${fill_zero(i)}:${fill_zero(t)}`
                        let thisTime_s = thisTime.split(':');
                        let date_ = fill_zero(new Date('', '', '', thisTime_s[0], thisTime_s[1]));
                        let date__ = fill_zero(new Date('', '', '', thisTime_s[0], thisTime_s[1]));

                        date__.setMinutes(date__.getMinutes() + 30);


                        day_body.innerHTML += `<div class="calendar-week-body-row" data-time-to="${thisTime}" data-time-from="${fill_zero(date__.getHours())}:${fill_zero(date__.getMinutes())}" data-hour="${thisTime_s[0]}" data-minutes="${thisTime_s[1]}">
                                                                                        <div class="calendar-week-body-col time">
                                                                                            ${thisTime === `${fill_zero(open)}:00` && thisTime < '12:00'
                            ? `<div class="day-division-label">오전</div>`
                            : `${thisTime === `${fill_zero(open)}:00` && thisTime >= '12:00'
                                ? `<div class="day-division-label">오후</div>`
                                : `${thisTime === '12:00'
                                    ? `<div class="day-division-label">오후</div>`
                                    : ``}`}`}
                                                                                            
                                                                                            <div class="time-label">
                                                                                                <div class="time-start-label">${am_pm_check3(fill_zero(date_.getHours()))}:${fill_zero(date_.getMinutes())}</div>
                                                                                                <div class="time-end-label"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    
                                                                                    <div class="calendar-week-body-col calendar-week-body-col-add sunday ${break_times.match(thisTime) ? 'break1':'' } ${thisTime === break_times.split(' ')[0] ? 'break1-1':''}" data-day="0" data-time-to="${thisTime}" data-time-from="${fill_zero(date__.getHours())}:${fill_zero(date__.getMinutes())}" data-hour="${thisTime_s[0]}" data-minutes="${thisTime_s[1]}" data-year="${date.getFullYear()}" data-month="${date.getMonth()}">
                                                                                        <div class="calendar-drag-item-group">
                                                                                            <a href="#add" class="btn-calendar-add">등록하기</a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="calendar-week-body-col calendar-week-body-col-add ${break_times.match(thisTime) ? 'break1':'' } ${thisTime === break_times.split(' ')[0] ? 'break1-1':''}" data-day="1" data-time-to="${thisTime}" data-time-from="${fill_zero(date__.getHours())}:${fill_zero(date__.getMinutes())}" data-hour="${thisTime_s[0]}" data-minutes="${thisTime_s[1]}" data-year="${date.getFullYear()}" data-month="${date.getMonth()}">
                                                                                        <div class="calendar-drag-item-group">
                                                                                            <a href="#add" class="btn-calendar-add">등록하기</a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="calendar-week-body-col calendar-week-body-col-add ${break_times.match(thisTime) ? 'break1':'' } ${thisTime === break_times.split(' ')[0] ? 'break1-1':''}" data-day="2" data-time-to="${thisTime}" data-time-from="${fill_zero(date__.getHours())}:${fill_zero(date__.getMinutes())}" data-hour="${thisTime_s[0]}" data-minutes="${thisTime_s[1]}" data-year="${date.getFullYear()}" data-month="${date.getMonth()}">
                                                                                        <div class="calendar-drag-item-group">
                                                                                            <a href="#add" class="btn-calendar-add">등록하기</a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="calendar-week-body-col calendar-week-body-col-add ${break_times.match(thisTime) ? 'break1':'' } ${thisTime === break_times.split(' ')[0] ? 'break1-1':''}" data-day="3" data-time-to="${thisTime}" data-time-from="${fill_zero(date__.getHours())}:${fill_zero(date__.getMinutes())}" data-hour="${thisTime_s[0]}" data-minutes="${thisTime_s[1]}" data-year="${date.getFullYear()}" data-month="${date.getMonth()}">
                                                                                        <div class="calendar-drag-item-group">
                                                                                            <a href="#add" class="btn-calendar-add">등록하기</a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="calendar-week-body-col calendar-week-body-col-add ${break_times.match(thisTime) ? 'break1':'' } ${thisTime === break_times.split(' ')[0] ? 'break1-1':''}" data-day="4" data-time-to="${thisTime}" data-time-from="${fill_zero(date__.getHours())}:${fill_zero(date__.getMinutes())}" data-hour="${thisTime_s[0]}" data-minutes="${thisTime_s[1]}" data-year="${date.getFullYear()}" data-month="${date.getMonth()}">
                                                                                        <div class="calendar-drag-item-group">
                                                                                            <a href="#add" class="btn-calendar-add">등록하기</a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="calendar-week-body-col calendar-week-body-col-add ${break_times.match(thisTime) ? 'break1':'' } ${thisTime === break_times.split(' ')[0] ? 'break1-1':''}" data-day="5" data-time-to="${thisTime}" data-time-from="${fill_zero(date__.getHours())}:${fill_zero(date__.getMinutes())}" data-hour="${thisTime_s[0]}" data-minutes="${thisTime_s[1]}" data-year="${date.getFullYear()}" data-month="${date.getMonth()}">
                                                                                        <div class="calendar-drag-item-group">
                                                                                            <a href="#add" class="btn-calendar-add">등록하기</a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="calendar-week-body-col calendar-week-body-col-add saturday ${break_times.match(thisTime) ? 'break1':'' } ${thisTime === break_times.split(' ')[0] ? 'break1-1':''}" data-day="6" data-time-to="${thisTime}" data-time-from="${fill_zero(date__.getHours())}:${fill_zero(date__.getMinutes())}" data-hour="${thisTime_s[0]}" data-minutes="${thisTime_s[1]}" data-year="${date.getFullYear()}" data-month="${date.getMonth()}">
                                                                                        <div class="calendar-drag-item-group">
                                                                                            <a href="#add" class="btn-calendar-add">등록하기</a>
                                                                                        </div>
                                                                                    </div>
</div>`




                    }
                }


            }

            resolve(body);
        }


    })


})
}

function schedule_render_week(el,id){


return new Promise(function (resolve){






    let body_col = document.getElementsByClassName('mini-calendar-month-body-col');

            Array.from(body_col).forEach(function (el_) {
                el_.classList.remove('actived');
                el_.parentElement.classList.remove('week-check');
            })
            el.classList.add('actived');
            el.parentElement.classList.add('week-check')

            let parent = el.parentElement;

            localStorage.setItem('row',el.parentElement.outerHTML);

            let st_count = 0;
            let fi_count = el.parentElement.children.length - 1;

            for (let i = 0; i < el.parentElement.children.length; i++) {
                if (!el.parentElement.children[i].classList.contains('before')) {
                    st_count = i;
                    break;
                }
            }

            for (let i = el.parentElement.children.length - 1; i >= 0; i--) {
                if (!el.parentElement.children[i].classList.contains('after')) {
                    fi_count = i;
                    break;
                }
            }
            let st_target = el.parentElement.children[st_count].children[0].children[0].children[0].children[0].innerText;
            let fi_target = el.parentElement.children[fi_count].children[0].children[0].children[0].children[0].innerText;

            let st_date = `${date.getFullYear()}-${fill_zero(date.getMonth() + 1)}-${fill_zero(st_target)}`
            let fi_date = `${date.getFullYear()}-${fill_zero(date.getMonth() + 1)}-${fill_zero(parseInt(fi_target)+1)}`

            console.log(fi_date.substring(5))
            $.ajax({


                url: '/data/pc_ajax.php',
                type: 'post',
                // async:false,
                data: {

                    mode: 'week_book',
                    login_id: id,
                    st_date: st_date,
                    fi_date: fi_date
                },
                beforeSend:function(){
                    let height;

                    if(document.getElementById('week_schedule_card_body')){
                        height = document.getElementById('week_schedule_card_body').offsetHeight;
                        document.getElementById('week_schedule_card_body').style.display = 'none';
                        document.getElementById('week_schedule_loading').style.height =`${height}px`;
                        document.getElementById('week_schedule_loading').style.display ='flex';


                    }

                },
                success: function (res) {
                    let response = JSON.parse(res);
                    let head = response.data.head;
                    let body_ = response.data.body;
                    if (head.code === 401) {
                        pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                    } else if (head.code === 200) {
                        console.log(body_)

                        let cancel = 0;
                        let noshow = 0;

                        body_.forEach(function (el) {

                            if (el.product.is_cancel === 1) {
                                cancel++;
                            }

                            if (el.product.is_no_show === 1) {
                                noshow++;
                            }
                        })

                        document.getElementById('day_today').innerHTML = `${st_date.replaceAll('-', '.')} ~ ${fi_date.substr(0,4)}.${fi_date.substring(5).split('-')[0]}.${parseInt(fi_date.substring(5).split('-')[1])-1}`
                        document.getElementById('day_total').innerHTML = `${body_.length}건`
                        document.getElementById('day_cancel').innerHTML = `${cancel}건`
                        document.getElementById('day_noshow').innerHTML = `${noshow}건`
                        document.getElementById('schedule_day').innerHTML = `${st_date.substring(5).replaceAll('-', '.')} ~ ${fi_date.substring(5).split('-')[0]}.${fill_zero(parseInt(fi_date.substring(5).split('-')[1])-1)}`
                        let days = [];


                        Array.from(document.querySelector('.week-check').children).forEach(function (el) {


                            if (el.classList.contains('before') || el.classList.contains('after')) {
                                days.push('');
                            } else {
                                days.push(el.children[0].children[0].children[0].children[0].innerText);
                            }


                        })
                        console.log(days)

                        Array.from(document.getElementsByClassName('week-date')).forEach(function (el, i) {

                            el.innerText = days[i]
                        })


                        let data = [body_,parent];
                        resolve(data);


                    }

                }
            })


        })



}

function reload_list(id){

    let year = localStorage.getItem('day_select') !== null ? localStorage.getItem('day_select').split('.')[0] : date.getFullYear()
    let month = localStorage.getItem('day_select') !== null ? localStorage.getItem('day_select').split('.')[1] : date.getMonth()+1

    $.ajax({
        url: '/data/pc_ajax.php',
        data: {
            mode: 'month_book',
            login_id: id,
            year: year,
            month: month
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
                list = body;
            }

        }
    })
}


//booking
function book_list(id) {




    return new Promise(function (resolve){

        $.ajax({
            url: '/data/pc_ajax.php',
            data: {
                mode: 'month_book',
                login_id: id,
                year: date.getFullYear(),
                month: date.getMonth()+1,
            },
            type: 'POST',
            beforeSend:function(){
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


                }else if(document.getElementById('month_calendar_inner')){

                    height = document.getElementById('month_calendar_inner').offsetHeight;
                    document.getElementById('month_calendar_inner').style.display = 'none';
                    document.getElementById('month_schedule_loading').style.display = 'flex';
                }
            },

            success: function (res) {
                
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {
                    list = body;
                    console.log(list)

                    if(location.href.match('reserve_beauty_month')){
                        let cancel = 0;
                        let noshow = 0;

                        body.beauty.forEach(function (el){

                            if(el.product.is_cancel === 1){

                                cancel++;
                            }
                        })

                        // body.hotel.forEach(function(el){
                        //
                        //     if(el.product.is_cancel === 1){
                        //         cancel++;
                        //     }
                        //
                        // })
                        //
                        // body.kindergarden.forEach(function(el){
                        //
                        //     if(el.product.is_cancel === 1){
                        //         cancel++;
                        //     }
                        // })

                        body.beauty.forEach(function (el){

                            if(el.product.is_no_show === 1){

                                noshow++;
                            }
                        })

                        // body.hotel.forEach(function(el){
                        //
                        //     if(el.product.is_no_show === 1){
                        //         noshow++;
                        //     }
                        //
                        // })
                        //
                        // body.kindergarden.forEach(function(el){
                        //
                        //     if(el.product.is_no_show === 1){
                        //         noshow++;
                        //     }
                        // })
                        document.getElementById('day_today').innerText = `${date.getFullYear()}.${fill_zero(date.getMonth()+1)}`
                        document.getElementById('day_total').innerText =`${body.beauty.length + body.hotel.length + body.kindergarden.length}건`


                        document.getElementById('day_cancel').innerText = `${cancel}건`
                        document.getElementById('day_noshow').innerText = `${noshow}건`



                        document.getElementById('this_month').innerText = `${date.getFullYear()}.${fill_zero(date.getMonth()+1)}`
                    }
                }
                resolve(body);
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

//상담대기 리스트
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
            case 1: status = '미용'; break;
            case 2: status = '완료'; break;
            case 3: status = '거부'; break;
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

//상담 처리내역 리스트
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
            case 1: status = '미용'; break;
            case 2: status = '완료'; break;
            case 3: status = '거부'; break;
        }

        if(i >= data.consulting_count &&  status !== '미용') {
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

//상담내역선택
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
                    // console.log(el_)


                    if(el_.pet_name === el.getAttribute('data-pet_name') && el_.phone === el.getAttribute('data-phone')){
                        let data = el_.disliked_part;
                        let text = '';
                        data = [...data];
                        data.forEach(function (d,i){
                            if(parseInt(d)===1){
                                if(i===0){
                                    text += '눈 '
                                }
                                if(i===1){
                                    text += '코 '
                                }
                                if(i===2){
                                    text += '입 '
                                }
                                if(i===3){
                                    text += '귀 '
                                }
                                if(i===4){
                                    text += '목 '
                                }
                                if(i===5){
                                    text += '몸통 '
                                }
                                if(i===6){
                                    text += '다리 '
                                }
                                if(i===7){
                                    text += '꼬리 '
                                }
                                if(i===8){
                                    text += '생식기 '
                                }
                                if(i===9){
                                    text += '없음 '
                                }
                            }
                        })

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
                                                                                                                            <div class="flex-table-data-inner">${el_.vaccination === "" || el_.vaccination === null ? '미기입' : el_.vaccination}</div>
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
                                                                                                                            <div class="flex-table-data-inner">${text === '' ? '없음' : text}</div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="flex-table-cell">
                                                                                                                    <div class="flex-table-item">
                                                                                                                        <div class="flex-table-title">
                                                                                                                            <div class="txt">슬개골 탈구</div>
                                                                                                                        </div>
                                                                                                                        <div class="flex-table-data">
                                                                                                                            <div class="flex-table-data-inner">${el_.luxation === '' || el_.luxation === null ? '미기입':el_.vaccination }</div>
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
                                                                                                                <h5 class="con-title">${el_.memo === "" || el_.memo === null ? '미기입' : el_.memo} </h5>
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

//미니달력 달기준 바꾸기
function calendar_change_month(id){

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
            book_list(id).then(function(){
                _renderCalendar_mini(id);
                document.querySelector('.calendar-title-sort').classList.remove('actived')


                if(el.innerText.trim() == date.getMonth()+1){
                    el.classList.add('actived');
                }
            })

        })

    })
}

//미니달력 버튼으로 달 바꾸기
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

//미니달력 날짜 수정
function mini_calendar_init(){

    return new Promise(function (resolve){

        let select;

        if(localStorage.getItem('day_select') !== null){


            select = localStorage.getItem('day_select').split('.');

            date.setFullYear(parseInt(select[0]));
            date.setMonth(parseInt(select[1])-1);
            date.setDate(parseInt(select[2]));


        }
        resolve();


    })


}

//일간 예약관리 스케쥴 시간cols
function reserve_schedule(id){

    return new Promise(function (resolve){




        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:'open_close',
                login_id:id,

            },
            success:function(res){
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {

                    let open = body[0].open_time;
                    let close = body[0].close_time;
                    localStorage.setItem('open_close',`${open}/${close}`)
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







                    resolve();





                }
            }
        })
    })
}

function no_one(body){

    let header = document.getElementById('day_header_row')

    if(header.children.length > 1){

        return;

    }else{

        body.forEach(function(el){

            if(!el.is_leave && el.is_show){



                header.innerHTML += `<div class="calendar-day-header-col">${el.nick}</div>`

                Array.from(document.getElementsByClassName('calendar-day-body-row')).forEach(function(_el,i){
                    _el.innerHTML += `<div class="calendar-day-body-col time-compare-cols break" data-name="${el.name}" data-nick="${el.nick}" data-time-to="${_el.getAttribute('data-time-to')}" data-time-from="${_el.getAttribute('data-time-from')}" data-year="${date.getFullYear()}" data-month="${date.getMonth()}" data-date="${date.getDate()}" data-hour="${_el.getAttribute('data-hour')}" data-minutes="${_el.getAttribute('data-minutes')}">
                                                            <div class="calendar-drag-item-group">
                                                                <a href="#" class="btn-calendar-add" onclick="reserve_pop(this)">등록하기</a>
                                                            </div>       
                                                         </div>`

                })
            }
        })
    }
}

//일간 예약관리 스케쥴 cols
function cols(id){


    return new Promise(function (resolve){



        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            async:false,
            data:{
                mode:'working',
                login_id:id,
            },
            success:function (res){

                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {

                    document.getElementById('day_header_row').innerHTML = `<div class="calendar-day-header-col time"></div>`

                    let break_time = '';
                    let break_times = '';
                    if(localStorage.getItem('break_time') !== ''){
                        break_time = JSON.parse(localStorage.getItem('break_time'))

                        break_time.forEach(function(el,i){
                            break_times += `${el.time.split('~')[0]} `
                        })
                    }


                    body.forEach(function (el){
                        if(el.is_show && !el.is_leave){
                            el.work.forEach(function (el_){
                                if(parseInt(el_.week) === date.getDay() ){
                                    document.getElementById('day_header_row').innerHTML +=`<div class="calendar-day-header-col">${el.nick}</div>`
                                    Array.from(document.getElementsByClassName('calendar-day-body-row')).forEach(function(_el,i){
                                        _el.innerHTML += `<div class="calendar-day-body-col time-compare-cols ${break_times.match(_el.getAttribute('data-time-to')) ? 'break1':'' } ${_el.getAttribute('data-time-to') === break_times.split(' ')[0] ? 'break1-1':''}" data-name="${el.name}" data-nick="${el.nick}" data-time-to="${_el.getAttribute('data-time-to')}" data-time-from="${_el.getAttribute('data-time-from')}" data-year="${date.getFullYear()}" data-month="${date.getMonth()}" data-date="${date.getDate()}" data-hour="${_el.getAttribute('data-hour')}" data-minutes="${_el.getAttribute('data-minutes')}">
                                                            <div class="calendar-drag-item-group">
                                                                <a href="#" class="btn-calendar-add" onclick="reserve_pop(this)">등록하기</a>
                                                            </div>       
                                                         </div>`

                                    })
                                }



                            })
                        }
                    })

                    resolve(body);






                }
            },
            complete:function(){



                if(document.getElementById('reserve_calendar_inner_day')){

                    document.getElementById('reserve_calendar_inner_day').style.display='block';
                    document.getElementById('day_schedule_loading').style.display ='none';

                    document.getElementById('btn-schedule-prev').removeAttribute('disabled');
                    document.getElementById('btn-schedule-next').removeAttribute('disabled')
                    let day_body = document.getElementById('day_body');

                    let day_height = day_body.offsetHeight;

                    let open = parseInt(localStorage.getItem('open_close').split('/')[0]);
                    let close = parseInt(localStorage.getItem('open_close').split('/')[1]);

                    let now_hour = new Date().getHours();
                    let now_minutes = new Date().getMinutes();

                    let work_time = (close-open)*60;
                    let division = day_height/work_time;
                    let div_height = (((now_hour-open)*60)+now_minutes)*division;


                    if(open <= now_hour && now_hour < close ){
                        day_body.innerHTML += `<div class="calendar-day-current-time" style="top:${div_height}px"><div class="bar"></div><div class="value">${fill_zero(date.getHours())}:${fill_zero(date.getMinutes())}</div></div>`
                    }

                }
            }
        })
    })
}

//일간 예약관리 스케쥴 버튼 날짜변경
function btn_schedule(id){

    if(location.href.match('reserve_beauty_day') || location.href.match('reserve_beauty_list')){

        document.getElementById('btn-schedule-next').addEventListener('click',function(){
            this.setAttribute('disabled',true);
            date.setDate(date.getDate()+1)
            if(date.getDate() === 1){
                book_list(id).then(function (){


                    renderCalendar_mini(id).then(function(div_dates){

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

                    if(list !== undefined){
                        booking_list = list;
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


                                if(count !==0){

                                    siblings(el.parentElement.parentElement.parentElement.parentElement,0).children[1].innerHTML= `${count}`;
                                }

                            })
                        }
                    })
                }).then(function(){
                    let mini_col = document.getElementsByClassName('mini-calendar-month-body-col');

                    Array.from(mini_col).forEach(function(el) {

                        if(el.classList.contains('actived')){
                            el.classList.remove('actived');
                        };
                        el.addEventListener('click', function () {

                            Array.from(mini_col).forEach(function (el_) {

                                el_.classList.remove('actived');
                            })

                            el.classList.add('actived');
                            localStorage.setItem('day_select', `${date.getFullYear()}.${fill_zero(date.getMonth() + 1)}.${fill_zero(el.children[0].children[0].children[0].children[0].innerText.trim())}`)
                            date.setDate(el.children[0].children[0].children[0].children[0].innerText.trim());

                            if(location.href.match('reserve_beauty_list')){
                                schedule_render_list(id).then(function (body){

                                    _schedule_render_list(body)
                                })
                            }else{

                                schedule_render(id);
                            }

                        })
                    })
                })
            }
            if(location.href.match('reserve_beauty_list')){
                schedule_render_list(id).then(function (body){

                    _schedule_render_list(body)
                })
            }else{

                schedule_render(id);
            }


        })

        document.getElementById('btn-schedule-prev').addEventListener('click',function (){
            this.setAttribute('disabled',true);
            date.setDate(date.getDate()-1)
            if(date.getDate() >= 28){
                book_list(id).then(function (){


                    renderCalendar_mini(id).then(function(div_dates){
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

                    if(list !== undefined){
                        booking_list = list;
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
                                if(count !==0){

                                    siblings(el.parentElement.parentElement.parentElement.parentElement,0).children[1].innerHTML= `${count}`;
                                }
                                ;
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

                            if(location.href.match('reserve_beauty_list')){
                                schedule_render_list(id).then(function (body){

                                    _schedule_render_list(body)
                                })
                            }else{

                                schedule_render(id);
                            }

                        })
                    })




                })
            }
            if(location.href.match('reserve_beauty_list')){
                schedule_render_list(id).then(function (body){

                    _schedule_render_list(body)
                })
            }else{

                schedule_render(id);
            }


        })

    }else if(location.href.match('reserve_beauty_week')){

        let lows = document.getElementsByClassName('mini-calendar-month-body-row');



        let select_low = parseInt(localStorage.getItem('select_row'));


        document.getElementById('btn-schedule-next').addEventListener('click',function(){
            select_low = parseInt(localStorage.getItem('select_row'));
            console.log(select_low)
            this.setAttribute('disabled',true);

            if(select_low !== lows.length-1){
                lows[select_low+1].children[0].click();
                localStorage.setItem('select_row',select_low+1)
                select_low = parseInt(localStorage.getItem('select_row'));

            }



        })

        document.getElementById('btn-schedule-prev').addEventListener('click',function(){
            this.setAttribute('disabled',true);
            select_low = parseInt(localStorage.getItem('select_row'));

            if(select_low !== 0){

                lows[select_low-1].children[0].click();
                localStorage.setItem('select_row',select_low-1)
                select_low = parseInt(localStorage.getItem('select_row'));
            }




        })

    }

}

//일간 예약관리 스케쥴표 break_time
function break_time(id){


    $.ajax({


        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'break_time',
            login_id:id,
        },
        success:function(res){
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                if(body.length >0){
                    localStorage.setItem('break_time',JSON.stringify(body[0].res_time_off))
                }else{
                    localStorage.setItem('break_time','');
                }





            }


        }
    })
}


//일간 예약관리 스케쥴표 드래그
function day_drag(){
    $('.calendar-day-body-col').each(function(){
        $(this).on('click',function(){
        })
        if( !$(this).hasClass('time')){
            //휴무가 아닐 경우 드래그앤 드롭 가능 처리
            var sortable = Sortable.create($(this).find('.calendar-drag-item-group')[0] , {
                group : 'shared',
                delay : 250,
                delayOnTouchOnly : true,
                ghostClass: 'guide',
                draggable : '.calendar-week-time-item',
                onStart : function(evt){
                    //드래그 시작
                    // console.log('drag start');
                },
                onEnd : function(evt){
                    //드래그 끝
                    // console.log('drag end');
                    //evt.to;    // 현재 아이템
                    //evt.from;  // 이전 아이템
                    //evt.oldIndex;  // 이전 인덱스값
                    //evt.newIndex;  // 새로운 인덱스값

                    if(evt.from != evt.to){
                        _thisWorker = $(evt.from).parent().attr("data-nick");
                        _thisYear = $(evt.from).parent().attr("data-year");
                        _thisMonth = $(evt.from).parent().attr("data-month")
                        _thisDate = $(evt.from).parent().attr("data-date");
                        _thisHour = $(evt.from).parent().attr("data-hour");
                        _thisMinutes = $(evt.from).parent().attr("data-minutes")
                        _thisTimeStart   = $(evt.from).parent().attr("data-time-to");
                        _thisTimeEnd   = $(evt.from).parent().attr("data-time-from");
                        thisLogSeq = $(evt.from).parent().attr("data-pay");



                        thisWorker = $(evt.to).parent().attr("data-nick");
                        thisYear = $(evt.to).parent().attr("data-year");
                        thisMonth = $(evt.to).parent().attr("data-month")
                        thisDate = $(evt.to).parent().attr("data-date");
                        thisHour = $(evt.to).parent().attr("data-hour");
                        thisMinutes = $(evt.to).parent().attr("data-minutes")
                        thisTimeStart   = $(evt.to).parent().attr("data-time-to");
                        thisTimeEnd   = $(evt.to).parent().attr("data-time-from");
                        thisWorker2 = $(evt.to).parent().attr("data-name");

                        let time_length = $(evt.from).parent().attr("data-time_length");

                        let target_date = new Date(date.getFullYear(),date.getMonth(),date.getDate(),thisTimeStart.split(':')[0],thisTimeStart.split(':')[1]);


                        target_date.setMinutes(target_date.getMinutes()+time_length);


                        let fi_time = `${fill_zero(target_date.getHours())}:${fill_zero(target_date.getMinutes())}`


                        $("#reserveCalendarPop4 .con-title").text(thisWorker);
                        $("#reserveCalendarPop4 .msg-text-date").text(am_pm_check2(`${thisYear}.${fill_zero(parseInt(thisMonth)+1)}.${fill_zero(thisDate)} ${fill_zero(thisHour)}:${fill_zero(thisMinutes)}`));

                        $("#reserveCalendarPop4 input[name='log_type']").val("week");
                        $("#reserveCalendarPop4 input[name='log_seq']").val(thisLogSeq);
                        $("#reserveCalendarPop4 input[name='log_worker']").val(thisWorker2);
                        $("#reserveCalendarPop4 input[name='log_year']").val(thisYear);
                        $("#reserveCalendarPop4 input[name='log_month']").val(parseInt(thisMonth)+1);
                        $("#reserveCalendarPop4 input[name='log_date']").val(thisDate);
                        $("#reserveCalendarPop4 input[name='log_start_time']").val(thisTimeStart);
                        $("#reserveCalendarPop4 input[name='log_end_time']").val(fi_time);

                        pop.open('reserveCalendarPop4');
                    }
                },
                onUpdate : function(evt){
                    // console.log('update');
                },
                onUpdate : function(evt){
                    // console.log('onChange');
                },
                onRemove: function (/**Event*/evt) {
                    // console.log('remove');
                }

            });
        }
    });
}

function week_drag(){

    $('.calendar-week-body-col-add').each(function(){

        if(!$(this).hasClass('time') && !$(this).hasClass('break4')){
            //휴무가 아닐 경우 드래그앤 드롭 가능 처리
            var sortable = Sortable.create($(this).find('.calendar-drag-item-group')[0] , {
                group : 'shared',
                delay : 0,
                delayOnTouchOnly : true,
                ghostClass: 'guide',
                draggable : '.calendar-week-time-item',
                onStart : function(evt){
                    //드래그 시작
                    // console.log('drag start');
                },
                onEnd : function(evt){
                    //드래그 끝
                    // console.log('drag end');
                    //evt.to;    // 현재 아이템
                    //evt.from;  // 이전 아이템
                    //evt.oldIndex;  // 이전 인덱스값
                    //evt.newIndex;  // 새로운 인덱스값


                    if(evt.from != evt.to){

                        let thisWorker;
                        let thisWorker2;
                        Array.from(document.getElementsByClassName('header-worker')).forEach(function (el){

                            if(el.classList.contains('actived')){

                                thisWorker = el.getAttribute('data-worker');
                                thisWorker2 = el.getAttribute('data-nick');
                            }
                        })
                        _thisYear = $(evt.from).parent().attr("data-year");
                        _thisMonth = $(evt.from).parent().attr("data-month")
                        _thisDate = $(evt.from).parent().attr("data-date");
                        _thisHour = $(evt.from).parent().attr("data-hour");
                        _thisMinutes = $(evt.from).parent().attr("data-minutes")
                        _thisTimeStart   = $(evt.from).parent().attr("data-time-to");
                        _thisTimeEnd   = $(evt.from).parent().attr("data-time-from");
                        thisLogSeq = $(evt.from).parent().attr("data-pay");



                        thisYear = $(evt.to).parent().attr("data-year");
                        thisMonth = $(evt.to).parent().attr("data-month")
                        thisDate = $(evt.to).parent().attr("data-date");
                        thisHour = $(evt.to).parent().attr("data-hour");
                        thisMinutes = $(evt.to).parent().attr("data-minutes")
                        thisTimeStart   = $(evt.to).parent().attr("data-time-to");
                        thisTimeEnd   = $(evt.to).parent().attr("data-time-from");
                        // thisWorker2 = $(evt.to).parent().attr("data-name");

                        let time_length = $(evt.from).parent().attr("data-time_length");

                        let target_date = new Date(2022,0,1,thisTimeStart.split(':')[0],thisTimeStart.split(':')[1]);



                        target_date.setMinutes(target_date.getMinutes()+120);


                        let fi_time = `${fill_zero(target_date.getHours())}:${fill_zero(target_date.getMinutes())}`



                        $("#reserveCalendarPop4 .con-title").text(thisWorker2);
                        $("#reserveCalendarPop4 .msg-text-date").text(am_pm_check2(`${thisYear}.${fill_zero(parseInt(thisMonth)+1)}.${fill_zero(thisDate)} ${fill_zero(thisHour)}:${fill_zero(thisMinutes)}`));

                        $("#reserveCalendarPop4 input[name='log_type']").val("week");
                        $("#reserveCalendarPop4 input[name='log_seq']").val(thisLogSeq);
                        $("#reserveCalendarPop4 input[name='log_worker']").val(thisWorker);
                        $("#reserveCalendarPop4 input[name='log_year']").val(thisYear);
                        $("#reserveCalendarPop4 input[name='log_month']").val(parseInt(thisMonth)+1);
                        $("#reserveCalendarPop4 input[name='log_date']").val(thisDate);
                        $("#reserveCalendarPop4 input[name='log_start_time']").val(thisTimeStart);
                        $("#reserveCalendarPop4 input[name='log_end_time']").val(fi_time);



                        pop.open('reserveCalendarPop4');

                    }
                },
                onUpdate : function(evt){
                    // console.log('update');
                },
                onUpdate : function(evt){
                    // console.log('onChange');
                },
                onRemove: function (/**Event*/evt) {
                    // console.log('remove');
                }

            });
        }
    });

}



//작업결제관리 페이지
function pay_management(id){

    return new Promise(function (resolve){




    $.ajax({


        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'pay_management',
            payment_idx:localStorage.getItem('payment_idx'),
        },
        beforeSend:function (){

            let height;

            if(document.getElementById('pay_management_body')){

                height = document.getElementById('pay_management_body').offsetHeight;
                document.getElementById('pay_management_body').style.display = 'none';
                document.getElementById('pay_management_loading').style.height = `${height}px`;
                document.getElementById('pay_management_loading').style.display = `flex`;

            }


        },
        success:function (res){
            
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            let body_ = [response.data2.body,response.data3.body,body.pet_seq,body]
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                console.log(body)
                let work_body_inner = document.getElementById('work_body_inner');
                let data_col_right = document.getElementById('data_col_right_1');

                if(body.is_approve === 0){

                    document.getElementById('approve').innerText ='상담대기'
                    document.getElementById('waiting_footer').style.display = 'block';
                    document.getElementById('approve_wrap').style.display ='block';
                    $.ajax({
                        url:'/data/pc_ajax.php',
                        type:'post',
                        data:{
                            mode:'waiting',
                            partner_id:id,
                        },
                        success:function(res) {
                            
                            let response = JSON.parse(res);
                            let head = response.data.head;
                            let body1 = response.data.body;
                            if (head.code === 401) {
                                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                            } else if (head.code === 200) {

                                console.log(body1);

                                body1.forEach(function(el){

                                    if(el.product.payment_idx === parseInt(localStorage.getItem('payment_idx'))){
                                        Array.from(document.getElementsByClassName('approve_idx')).forEach(function(el_){


                                            el_.setAttribute('data-approve',`${el.product.approve_idx}`)
                                        })

                                    }
                                })



                            }
                        }


                    })
                }else if(body.is_approve === 1 || body.is_approve === 2 || body.is_approve === -1){
                    document.getElementById('approve').innerText ='예약확정'
                    document.getElementById('approve_wrap').style.display ='block';

                }else if(body.is_approve === 3){
                    document.getElementById('approve').innerText = '상담거절'
                    document.getElementById('approve_wrap').style.display ='block';
                }




                let data = body.disliked_part;
                let text = '';
                data = [...data];
                data.forEach(function (d,i){
                    if(parseInt(d)===1){
                        if(i===0){
                            text += '눈 '
                        }
                        if(i===1){
                            text += '코 '
                        }
                        if(i===2){
                            text += '입 '
                        }
                        if(i===3){
                            text += '귀 '
                        }
                        if(i===4){
                            text += '목 '
                        }
                        if(i===5){
                            text += '몸통 '
                        }
                        if(i===6){
                            text += '다리 '
                        }
                        if(i===7){
                            text += '꼬리 '
                        }
                        if(i===8){
                            text += '생식기 '
                        }
                        if(i===9){
                            text += '없음 '
                        }
                    }
                })

                // work_body_inner.innerHTML = ''


                work_body_inner.innerHTML += `<div  id="manage_1"><div class="basic-data-group vsmall" >
                                        <div class="con-title-group">
                                            <h4 class="con-title">예약자 정보</h4>
                                        </div>
                                        <div class="customer-view-user-info">
                                            <div class="customer-user-table">
                                                <div class="customer-user-table-row">
                                                    <div class="customer-user-table-title">
                                                        <div class="table-title">아이디</div>
                                                    </div>
                                                    <div class="customer-user-table-data">
                                                        <div class="table-data">
                                                            <div class="table-user-name">
                                                                <span id="customer_id">${body.customer_Id === "" ? body.tmp_id : body.customer_Id}</span>
                                                                <div class="user-grade-item">
                                                                    <div class="icon icon-grade-${body.grade_ord === 1 ? 'vip' : body.grade_ord === 2 ? 'normal' : 'normalb'}"></div>
                                                                    <div class="icon-grade-label">${body.grade_name}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="customer-user-info-ui">
                                                    
                                                        ${body.noshow_count > 0 ? `<div class="label label-outline-pink">NO SHOW ${body.noshow_count}회</div>`:''}
                                                        ${body.is_noshow === 0 ? `<a href="#" onclick="pop.open('noshow')" class="btn btn-inline btn-red">NO SHOW 등록</a>` : `<div class="btn btn-inline" style="cursor:pointer; background: #8f8f8f; color:white;" onclick="pop.open('cancel_noshow')">노쇼 취소</div>` }
                                                    </div>
                                                </div>
                                                <div class="customer-user-table-row">
                                                    <div class="customer-user-table-title">
                                                        <div class="table-title">연락처</div>
                                                    </div>
                                                    <div class="customer-user-table-data">
                                                        <div class="table-data">
                                                            <div class="customer-user-phone-wrap read">
                                                                <div class="item-main-phone">
                                                                    <div class="value" id="cellphone_detail">${body.cell_phone}</div>
                                                                </div>
                                                                <div class="item-sub-phone" id="item_sub_phone">
                                                                
                                                                
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="basic-data-group">
                                        <div class="con-title-group">
                                            <h4 class="con-title">예약동물 정보</h4>
                                            <div class="con-title-btns">
                                                <div class="btns-cell">
                                                    <button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline" onclick="pop.open('reserveBeautyGalleryPop')">미용 갤러리</button>
                                                </div>
                                                <div class="btns-cell" id="beauty_agree_view">
                                                    <button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline">미용 동의서</button>
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="customer-view-pet-info detail-toggle-parents">
                                            <div class="item-thumb">
                                                <div class="user-thumb large"><img src="" id="beauty_img_target" alt=""></div>
                                                <div class="item-thumb-ui">
                                                    <a href="#" class="btn btn-outline-gray btn-vsmall-size btn-inline" id="modify_pet">펫 정보 수정</a>
                                                </div>
                                            </div>
                                            <div class="item-user-data">
                                                <div class="grid-layout flex-table">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-2">
                                                            <div class="flex-table-item">
                                                                <div class="flex-table-title">
                                                                    <div class="txt">이름</div>
                                                                </div>
                                                                <div class="flex-table-data">
                                                                    <div class="flex-table-data-inner">
                                                                        ${body.name}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2">
                                                            <div class="flex-table-item">
                                                                <div class="flex-table-title">
                                                                    <div class="txt">품종</div>
                                                                </div>
                                                                <div class="flex-table-data">
                                                                    <div class="flex-table-data-inner">
                                                                        ${body.pet_type}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2">
                                                            <div class="flex-table-item">
                                                                <div class="flex-table-title">
                                                                    <div class="txt">성별</div>
                                                                </div>
                                                                <div class="flex-table-data">
                                                                    <div class="flex-table-data-inner">
                                                                        ${body.gender}
                                                                    </div>
                                                                </div>
                                                            </div>  
                                                        </div>
                                                        <div class="grid-layout-cell grid-2">
                                                            <div class="flex-table-item">
                                                                <div class="flex-table-title">
                                                                    <div class="txt">무게</div>
                                                                </div>
                                                                <div class="flex-table-data">
                                                                    <div class="flex-table-data-inner">
                                                                        ${body.weight}kg
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2">
                                                                <div class="flex-table-item">
                                                                    <div class="flex-table-title">
                                                                        <div class="txt">생일</div>
                                                                    </div>
                                                                    <div class="flex-table-data">
                                                                        <div class="flex-table-data-inner">
                                                                            ${body.birth.replaceAll('-','.')}(${Math.floor((new Date().getTime() - new Date(body.birth.split('-')[0],body.birth.split('-')[1],body.birth.split('-')[2]).getTime())/1000/60/60/24/30/12)}년 ${Math.floor((new Date().getTime() - new Date(body.birth.split('-')[0],body.birth.split('-')[1],body.birth.split('-')[2]).getTime())/1000/60/60/24/30%12)}개월)
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2">
                                                            <div class="flex-table-item">
                                                                <div class="flex-table-title">
                                                                    <div class="txt">중성화</div>
                                                                </div>
                                                                <div class="flex-table-data">
                                                                    <div class="flex-table-data-inner">
                                                                        ${body.neutral === 0 ? 'X' : 'O'}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2 toggle">
                                                            <div class="flex-table-item">
                                                                <div class="flex-table-title">
                                                                    <div class="txt">미용경험</div>
                                                                </div>
                                                                <div class="flex-table-data">
                                                                    <div class="flex-table-data-inner">
                                                                        ${body.beauty_exp === null || body.beauty_exp ==="" ? '미기입': body.beauty_exp}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2 toggle">
                                                            <div class="flex-table-item">
                                                                <div class="flex-table-title">
                                                                    <div class="txt">예방접종</div>
                                                                </div>
                                                                <div class="flex-table-data">
                                                                    <div class="flex-table-data-inner">
                                                                        ${body.vaccination === null || body.vaccination === "" ? '미기입': body.vaccination}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2 toggle">
                                                            <div class="flex-table-item">
                                                                <div class="flex-table-title">
                                                                    <div class="txt">입질</div>
                                                                </div>
                                                                <div class="flex-table-data">
                                                                    <div class="flex-table-data-inner">
                                                                        ${parseInt(body.bite) === 0 ? '안해요':'해요'}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2 toggle">
                                                            <div class="flex-table-item">
                                                                <div class="flex-table-title">
                                                                    <div class="txt">슬개골 탈구</div>
                                                                </div>
                                                                <div class="flex-table-data">
                                                                    <div class="flex-table-data-inner">
                                                                        ${body.luxation === "" || body.luxation === null ? "미기입" : body.luxation}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2 toggle">
                                                            <div class="flex-table-item">
                                                                <div class="flex-table-title">
                                                                    <div class="txt">특이사항</div>
                                                                </div>
                                                                <div class="flex-table-data">
                                                                    <div class="flex-table-data-inner">
                                                                    ${body.dermatosis ? '피부병' : '' } ${body.heart_trouble ? '심장 질환' : ''} ${body.marking ? '마킹': ''} ${body.mounting ? '마운팅' : ''}
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2 toggle">
                                                            <div class="flex-table-item">
                                                                <div class="flex-table-title">
                                                                    <div class="txt">싫어하는 부위</div>
                                                                </div>
                                                                <div class="flex-table-data">
                                                                    <div class="flex-table-data-inner">
                                                                        ${text === "" ? '없음' : text}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2 toggle">
                                                            <div class="flex-table-item">
                                                                <div class="flex-table-title">
                                                                    <div class="txt">기타</div>
                                                                </div>
                                                                <div class="flex-table-data">
                                                                    <div class="flex-table-data-inner">
                                                                        ${body.etc === "" ? '없음' : body.etc}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="item-action">
                                                <button type="button" class="btn-detail-toggle">펫 정보 자세히 보기</button>
                                            </div>
                                        </div>
                                        <div class="basic-data-group middle">
                                            <div class="form-group">
                                                <div class="grid-layout margin-14-17">
                                                    <div class="grid-layout-inner">
                                                        <div class="grid-layout-cell grid-2">
                                                            <div class="form-group-item">
                                                                <div class="form-item-label">특이사항</div>
                                                                <div class="form-item-data type-2">
                                                                    <div class="form-textarea-btns">
                                                                        <textarea style="height:60px;" id="payment_memo" placeholder="입력">${body.payment_memo}</textarea>
                                                                        <button type="button" class="btn btn-outline-gray" onclick="payment_memo()">저장</button>
                                                                    </div>
                                                                    <div class="form-input-info">(고객에게는 노출되지 않습니다.)</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2">
                                                            <div class="form-group-item">
                                                                <div class="form-item-label">견주관련 메모</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="form-textarea-btns">
                                                                            <textarea style="height:60px;" id="customer_memo"  placeholder="입력"></textarea>
                                                                            <button type="button" class="btn btn-outline-gray" onclick="customer_memo()">저장</button>
                                                                        </div>
                                                                        <div class="form-input-info">(고객에게는 노출되지 않습니다.)</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="basic-data-group">
                                                    <div class="wide-tab card">
                                                        <div class="wide-tab-inner">
                                                            <!-- 활성화시 actived클래스 추가 -->
                                                            <div class="tab-cell actived">
                                                                <a href="#" class="btn-tab-item">미용</a>
                                                            </div>
                                                            <div class="tab-cell">
                                                                <a href="#" class="btn-tab-item" onclick="pop.open('firstRequestMsg1','준비 중 입니다.');">호텔</a>
                                                            </div>
                                                            <div class="tab-cell">
                                                                <a href="#" class="btn-tab-item" onclick="pop.open('firstRequestMsg1','준비 중 입니다.');">유치원</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="basic-data-group vvsmall3">
                                                        <div class="grid-layout margin-14-17">
                                                            <div class="grid-layout-inner">
                                                                <div class="grid-layout-cell grid-2">
                                                                    <div class="note-toggle-group">
                                                                        <div class="con-title-group">
                                                                            <!--
                                                                            <h4 class="con-title"><a href="#" class="btn-con-title"><div>이전 특이사항</div><div class="icon icon-btn-more-black"></div></a></h4>
                                                                            -->
                                                                            <h4 class="con-title">이전 특이사항</h4>
                                                                        </div>
                                                                        <div class="memo-item-list note-toggle-list" id="etc1_list">
                                                                            
                                                                        </div>
                                                                        ${response.data2.body.length >5 ? `<div class="note-toggle-ui">
                                                                            <button type="button" class="btn-note-toggle">더보기</button>
                                                                        </div>` : ''}
                                                                     
                                                                    </div>
                                                                </div>
                                                                <div class="grid-layout-cell grid-2">
                                                                    <div class="note-toggle-group">
                                                                        <div class="con-title-group">
                                                                            <!--
                                                                            <h4 class="con-title"><a href="#" class="btn-con-title"><div>이전 이용내역</div><div class="icon icon-btn-more-black"></div></a></h4>
                                                                            -->
                                                                            <h4 class="con-title">이전 이용내역</h4>
                                                                        </div>
                                                                        <div class="memo-item-list note-toggle-list" id="etc2_list">
                                                                            
                                                                        </div>
                                                                        ${response.data3.body.length >5 ? `<div class="note-toggle-ui">
                                                                            <button type="button" class="btn-note-toggle">더보기</button>
                                                                        </div>` : ''}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div></div>`

                
                
                data_col_right.innerHTML = `<div class="basic-data-card">
                                                <div class="card-header">
                                                    <h3 class="card-header-title">예약 정보</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div class="card-body-inner">
                                                        <div class="basic-data-group">
                                                            <div class="user-receipt-item">
                                                                <div class="con-title-group">
                                                                    <h5 class="con-title">예약 내용</h5>
                                                                    <button type="button" class="btn-side btn btn-outline-purple btn-round-full btn-vsmall-size">알림톡 발송 이력</button>
                                                                </div>
                                                                <div class="text-list-wrap type-2">
                                                                    <div class="text-list-cell">
                                                                        <div class="item-title unit">날짜</div>
                                                                        <div class="item-data" id="day_book_target" data-date="${body.beauty_date}">${am_pm_check2(body.beauty_date)}</div>
                                                                    </div>
                                                                    <div class="text-list-cell">
                                                                        <div class="item-title unit">선생님</div>
                                                                            <div class="item-data" id="day_book_target_worker" data-worker="${body.worker}">${body.worker === id ? "실장" : body.worker}</div>
                                                                        </div>
                                                                        <div class="text-list-cell">
                                                                            <div class="item-title unit align-self-center">시간</div>
                                                                                <div class="item-data">
                                                                                    <div class="form-datepicker-group">
                                                                                        <div class="form-datepicker">
                                                                                            <select id="start_time">
                                                                                                
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="form-unit">~</div>
                                                                                            <div class="form-datepicker">
                                                                                                <select id="end_time">
                                                                                                    
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="basic-data-group vsmall">
                                                                                <button type="button" class="btn btn-outline-gray btn-basic-full" onclick="check_time();">시간만 변경</button>
                                                                            </div>
                                                                            <div class="form-bottom-info">
                                                                                <span>*시간 변경만 하는 경우 시간선택 후 변경을 눌러주세요.</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="basic-data-group small">
                                                                            <div class="grid-layout btn-grid-group">
                                                                                <div class="grid-layout-inner">
                                                                                    <div class="grid-layout-cell grid-2">
                                                                                        <button type="button" class="btn btn-purple" id="change_check_worker_btn" data-worker="${body.worker}" onclick="pop.open('reservePayManagementMsg1')">날짜/미용사 변경</button>
                                                                                    </div>
                                                                                    <div class="grid-layout-cell grid-2">
                                                                                        <button type="button" class="btn btn-outline-purple" onclick="pop.open('reserveCancel')">예약 취소</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="basic-data-group">
                                                                        <div class="con-title-group">
                                                                            <h4 class="con-title">미용 종료 알림 발송</h4>
                                                                        </div>
                                                                        <div class="basic-data-group vvsmall">
                                                                            <div class="grid-layout basic">
                                                                                <div class="grid-layout-inner">
                                                                                    <div class="grid-layout-cell grid-4">
                                                                                        <label class="form-toggle-box block">
                                                                                            <input type="radio" name="time1">
                                                                                            <em>지금종료</em>
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="grid-layout-cell grid-4">
                                                                                        <label class="form-toggle-box block">
                                                                                            <input type="radio" name="time1">
                                                                                            <em>10분전</em>
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="grid-layout-cell grid-4">
                                                                                        <label class="form-toggle-box block">
                                                                                            <input type="radio" name="time1">
                                                                                            <em>15분전</em>
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="grid-layout-cell grid-4">
                                                                                        <label class="form-toggle-box block">
                                                                                            <input type="radio" name="time1">
                                                                                            <em>20분전</em>
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="grid-layout-cell grid-4">
                                                                                        <label class="form-toggle-box block">
                                                                                            <input type="radio" name="time1">
                                                                                            <em>30분전</em>
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-bottom-info">*시간 선택 후 발송을 누르면 견주에게 즉시알림이 발송됩니다.</div>
                                                                            <div class="basic-data-group vmiddle">
                                                                                <div class="grid-layout btn-grid-group">
                                                                                    <div class="grid-layout-inner">
                                                                                        <div class="grid-layout-cell grid-2">
                                                                                            <button type="button" class="btn btn-outline-gray">예시보기</button>
                                                                                        </div>
                                                                                        <div class="grid-layout-cell grid-2">
                                                                                            <button type="button" class="btn btn-outline-purple">발송</button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>`
                
                document.getElementById('data_col_right_2').innerHTML += `<div class="basic-data-card">
                                                                            <div class="card-header">
                                                                                <h3 class="card-header-title">서비스 내역</h3>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div class="card-body-inner">
                                                                                    <div class="user-receipt-item total">
                                                                                        <div class="receipt-buy-detail">
                                                                                            <div class="item-data-list" id="service_list">
                                                                                                
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="receipt-buy-detail total-price">
                                                                                            <div class="item-data-list" id="price_list">
                                                                                                <div class="list-cell">
                                                                                                    <div class="list-title"><strong>합산 금액</strong></div>
                                                                                                    <div class="list-value"><strong id="total_price"></strong></div>
                                                                                                </div>
                                                                                                
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="receipt-buy-detail result-price">
                                                                                            <div class="item-data-list">
                                                                                                <div class="list-cell">
                                                                                                    <div class="list-title font-color-purple"><strong>총 결제 합산 금액</strong>
                                                                                                    </div>
                                                                                                    <div class="list-value font-color-purple"><strong id="real_total_price" value="0"></strong></div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="pay-accordion-group">
                                                                                        <div class="pay-accordion-items">
                                                                                            <div class="items-header">
                                                                                                <div class="items-title">보유 쿠폰</div>
                                                                                                <div class="items-value">4개 보유</div>
                                                                                                <button type="button" class="btn-data-view">열기</button>
                                                                                            </div>
                                                                                            <div class="items-body">
                                                                                                <div class="form-group">
                                                                                                    <div class="form-group-cell small">
                                                                                                        <div class="form-group-item">
                                                                                                            <div class="form-item-label">쿠폰 명</div>
                                                                                                            <div class="form-item-data type-2">
                                                                                                                <div class="form-control-btns small">
                                                                                                                    <select>
                                                                                                                        <option value="">쿠폰명1</option>
                                                                                                                        <option value="">쿠폰명2</option>
                                                                                                                        <option value="">쿠폰명3</option>
                                                                                                                    </select>
                                                                                                                    <div class="btn btn-gray btn-inline">보유 4</div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group-cell small">
                                                                                                        <div class="form-group-item">
                                                                                                            <div class="form-item-label">쿠폰 차감</div>
                                                                                                            <div class="form-item-data type-2">
                                                                                                                <div class="form-control-btns small">
                                                                                                                    <select>
                                                                                                                        <option value="">1</option>
                                                                                                                        <option value="">2</option>
                                                                                                                        <option value="">3</option>
                                                                                                                    </select>
                                                                                                                    <button type="button"
                                                                                                                            class="btn btn-outline-gray btn-inline">적용
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                                <div
                                                                                                                    class="form-bottom-info font-color-purple text-align-right">적용
                                                                                                                    후 잔액 3회
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="pay-accordion-items">
                                                                                            <div class="items-header">
                                                                                                <div class="items-title">단골 고객 확인</div>
                                                                                                <button type="button" class="btn-data-view">열기</button>
                                                                                            </div>
                                                                                            <div class="items-body">
                                                                                                <div class="items-info">*원하시는 할인방법을 선택하신 후 적용을 누르세요.</div>
                                                                                                <div class="regular-user-confirm-select">
                                                                                                    <div class="regular-user-confirm-input">
                                                                                                        <div class="item-check"><label class="form-radiobox"><input
                                                                                                            type="radio" name="regular" id="discount_1_btn"><span
                                                                                                            class="form-check-icon"><em>퍼센트할인</em></span></label></div>
                                                                                                        <div class="item-data">
                                                                                                            <select id="discount_1">
                                                                                                                
                                                                                                            </select>
                                                                                                            <div class="unit">%</div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="regular-user-confirm-input">
                                                                                                        <div class="item-check"><label class="form-radiobox"><input
                                                                                                            type="radio" name="regular" id="discount_2_btn"><span
                                                                                                            class="form-check-icon"><em>금액할인</em></span></label></div>
                                                                                                        <div class="item-data">
                                                                                                            <select id="discount_2">
                                                                                                                
                                                                                                            </select>
                                                                                                            <div class="unit">원</div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-bottom-info font-color-purple text-align-right">할인금액 : <span class="discount_price" value="0"></span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="pay-accordion-items">
                                                                                            <div class="items-header">
                                                                                                <div class="items-title">펫샵 적립금
                                                                                                    <button type="button" class="btn-data-helper" onclick="pop.open('reservePayManagementMsg8')">도움말</button>
                                                                                                </div>
                                                                                                <div class="items-value now_reserves"></div>
                                                                                                <button type="button" class="btn-data-view">열기</button>
                                                                                            </div>
                                                                                            <div class="items-body">
                                                                                                <div class="receipt-buy-detail">
                                                                                                    <div class="item-data-list">
                                                                                                        <div class="list-cell">
                                                                                                            <div class="list-title"><strong>현 적립금</strong></div>
                                                                                                            <div class="list-value"><strong
                                                                                                                class="large now_reserves"></strong></div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="basic-data-group vsmall line">
                                                                                                    <div class="form-group">
                                                                                                        <div class="form-group-cell">
                                                                                                            <div class="form-group-item">
                                                                                                                <div class="form-item-label">사용적립금</div>
                                                                                                                <div class="form-item-data type-2">
                                                                                                                    <div class="form-point-input">
                                                                                                                        <input type="text" id="use_reserves" class="" placeholder="">
                                                                                                                            <div class="char">원</div>
                                                                                                                            <button type="button"
                                                                                                                                    class="btn btn-outline-gray btn-round btn-inline" onclick="document.getElementById('use_reserves').value = document.querySelector('.now_reserves').getAttribute('value')">전액
                                                                                                                                사용
                                                                                                                            </button>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="basic-data-group vsmall">
                                                                                                    <button type="button"
                                                                                                            class="btn btn-outline-gray btn-middle-size btn-basic-full" onclick="reserves_set()">적용
                                                                                                    </button>
                                                                                                </div>
<!--                                                                                                <div class="form-bottom-info font-color-purple text-align-right">본 예약의 적립금이-->
<!--                                                                                                    아직 지급되지 않았습니다.-->
<!--                                                                                                </div>-->
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="pay-accordion-total">
                                                                                            <div class="receipt-buy-detail">
                                                                                                <div class="item-data-list">
                                                                                                    <div class="list-cell">
                                                                                                        <div class="list-title"><strong>할인금액</strong></div>
                                                                                                        <div class="list-value"><strong class="discount_price" value="0"></strong></div>
                                                                                                    </div>
                                                                                                    <div class="list-cell">
                                                                                                        <div class="list-title"><strong>적립금 사용</strong></div>
                                                                                                        <div class="list-value"><strong class="reserves_use" value="0"></strong></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="receipt-buy-detail result-price">
                                                                                                <div class="item-data-list">
                                                                                                    <div class="list-cell">
                                                                                                        <div class="list-title font-color-purple"><strong>최종 결제액</strong>
                                                                                                        </div>
                                                                                                        <div class="list-value font-color-purple"><strong id="last_price"></strong>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="basic-data-group vmiddle">
                                                                                                <div class="form-change-wrap">
                                                                                                    <div class="form-change-item">
                                                                                                        <div class="form-change-label"><strong>카드</strong> (단위:원)</div>
                                                                                                        <div class="form-change-data"><input type="text" id="last_card" value="0"></div>
                                                                                                    </div>
                                                                                                    <button type="button" class="btn-data-change" onclick="data_change()">전환하기</button>
                                                                                                    <div class="form-change-item">
                                                                                                        <div class="form-change-label"><strong>현금</strong> (단위:원)</div>
                                                                                                        <div class="form-change-data"><input type="text" id="last_cash" value="0"></div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="basic-data-group vsmall">
                                                                                                <button type="button"
                                                                                                        class="btn btn-outline-gray btn-middle-size btn-basic-full">적용
                                                                                                </button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="basic-data-group none">
                                                                                        <div class="con-title-group">
                                                                                            <h5 class="con-title">결제완료 처리</h5>
                                                                                            <label htmlFor="switch-toggle" class="form-switch-toggle"><input type="checkbox"
                                                                                                                                                                 id="switch-toggle"><span
                                                                                                class="bar"></span></label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>`

                resolve(body_);
            }

        }
    })
    })

}

function pay_management_(id){

    pay_management(id).then(function (body_){

        management_wide_tab()
        management_wide_tab2()
        wide_tab();

        let sub_phone;
        if(body_[3].sub_phone !== ""){
            sub_phone = body_[3].sub_phone.split(',');

            sub_phone.forEach(function (el,i){

                if(i<3){
                    document.getElementById('item_sub_phone').innerHTML += `<div class="value">${el.split('|')[1]}</div>`
                }

                if(i===3){

                    document.getElementById('item_sub_phone').innerHTML += `<div class="value">외 ${sub_phone.length -3}개 연락처처</div>`
                }

           })
        }




        document.getElementById('item_sub_phone').innerHTML += ``

        body_[0].forEach(function (el){


            document.getElementById('etc1_list').innerHTML += `<div class="memo-item note-toggle-cell">
                                                                                <div class="note-desc">
                                                                                    <em>${el.booking_date}</em>
                                                                                    <div class="txt">${el.memo}</div>
                                                                                </div>
                                                                          </div>`
        })

        body_[1].forEach(function (el){

            let split_el = el.product.split('|');
            document.getElementById('etc2_list').innerHTML += `<div class="memo-item note-toggle-cell">${el.booking_date} / ${split_el[0]} / ${split_el[4]} / ${el.product_parsing === null || el.product_parsing === undefined ? '미기입':  el.product_parsing.base.weight.unit }Kg / ${el.product_parsing === null || el.product_parsing === undefined ? '미기입': el.product_parsing.base.weight.price }원
                                                                                <div class="memo-link">
                                                                                    <a href="#" class="btn-memo-link">상세보기
                                                                                        <div class="icon icon-arrow-right-small"></div>
                                                                                    </a>
                                                                                </div>
                                                                          </div>`

        })



        document.getElementById('modify_pet').addEventListener('click',function(){

            pay_management_modify_pet(body_[2]).then(function(body){

                pay_management_modify_pet_(body)

            });

        });


        let customer_id = '';
        let tmp_seq = '';

        if(document.getElementById('customer_id').innerText.match('@')){


            customer_id = document.getElementById('customer_id').innerText;

        }else{

            tmp_seq = document.getElementById('customer_id').innerText;

        }



        $.ajax({

           url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:'get_customer_memo',
                login_id:id,
                customer_id : customer_id,
                tmp_seq : tmp_seq,
                cellphone: document.getElementById('cellphone_detail').innerText,
            },
            success:function(res) {
               
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {


                    document.getElementById('customer_memo').value = body.memo;
                    document.getElementById('customer_memo').setAttribute('data-scm_seq',body.scm_seq);

                }
            }


        })

        let st_date = document.getElementById('day_book_target').getAttribute('data-date').split(' ')[0];


        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:"day_book",
                login_id:id,
                st_date:st_date,
                fi_date:`${st_date.split('-')[0]}-${st_date.split('-')[1]}-${fill_zero(parseInt(st_date.split('-')[2])+1)}`


            },
            success:function(res) {
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {





                    let reserve_st = [];
                    let reserve_fi = [];

                    body.forEach(function (el){


                        if(document.getElementById('day_book_target_worker').getAttribute('data-worker') === el.product.worker && el.product.is_cancel === 0){
                            reserve_st.push(new Date(el.product.date.booking_st).getTime());
                            reserve_fi.push(new Date(el.product.date.booking_fi).getTime());
                        }

                    })

                    reserve_st.sort();
                    reserve_fi.sort();

                    for(let i=0; i<reserve_st.length; i++){

                        reserve_st[i] = `${fill_zero(new Date(reserve_st[i]).getHours())}:${fill_zero(new Date(reserve_st[i]).getMinutes())}`;
                    }

                    for(let i=0; i<reserve_fi.length; i++){

                        reserve_fi[i] = `${fill_zero(new Date(reserve_fi[i]).getHours())}:${fill_zero(new Date(reserve_fi[i]).getMinutes())}`;
                    }





                    document.getElementById('start_time').innerHTML = ''
                    document.getElementById('end_time').innerHTML = ''

                    let open_close = localStorage.getItem('open_close');

                    let open = parseInt(open_close.split('/')[0]);
                    let close = parseInt(open_close.split('/')[1]);

                    let time = [];

                    for(open; open<=close; open++){

                        time.push(open);

                    }


                    let next = '';
                    for(let i=0; i< reserve_st.length; i++){

                        if(document.getElementById('day_book_target').getAttribute('data-date').split(' ')[1] === reserve_st[i]){

                            next = reserve_st[i+1]
                            break;
                        }
                    }



                    let prev = '';
                    for(let i=0; i<reserve_fi.length; i++){

                        if(document.getElementById('day_book_target').getAttribute('data-date').split(' ')[1] === reserve_st[i]){


                            prev = reserve_fi[i-1];
                            break;
                        }
                    }



                    if(prev === undefined){

                        loop:
                        for(let i=0; i<time.length-1; i++){

                            for(let t= 0; t<60; t +=30){


                                if(`${fill_zero(time[i])}:${fill_zero(t)}` === next){

                                    break loop;
                                }else{
                                    document.getElementById('start_time').innerHTML += `<option value ="${fill_zero(time[i])}${fill_zero(t)}">${fill_zero(am_pm_check(time[i]))}:${fill_zero(t)}</option>`
                                }





                            }
                        }

                        loop2:
                        for(let i=0; i<time.length; i++){

                            for(let t=0; t<60; t+=30){

                                if(i===0){
                                    t=30;
                                }
                                if(i===time.length-1 && t ===30){

                                    break;
                                }
                                if(`${fill_zero(time[i])}:${fill_zero(t)}` === next){
                                    document.getElementById('end_time').innerHTML += `<option value ="${fill_zero(time[i])}${fill_zero(t)}">${fill_zero(am_pm_check(time[i]))}:${fill_zero(t)}</option>`
                                    break loop2;
                                }else{


                                    document.getElementById('end_time').innerHTML += `<option value ="${fill_zero(time[i])}${fill_zero(t)}">${fill_zero(am_pm_check(time[i]))}:${fill_zero(t)}</option>`
                                }
                            }
                        }
                    }else{

                        loop3:
                            for(let i=0; i<time.length-1; i++){

                                for(let t= 0; t<60; t +=30){


                                    if(`${fill_zero(time[i])}:${fill_zero(t)}` === prev){


                                        loop4:
                                        for(let j=i; j<time.length-1; j++){

                                            for(let t2=0; t2<60; t2+=30){

                                                if(`${fill_zero(time[j])}:${fill_zero(t2)}` === next){

                                                    break loop4;

                                                }else if(`${fill_zero(time[j])}:${fill_zero(t2)}` === `${prev.split(':')[0]}:00`){
                                                    continue;

                                                }else{
                                                    document.getElementById('start_time').innerHTML += `<option value ="${fill_zero(time[j])}${fill_zero(t2)}">${fill_zero(am_pm_check(time[j]))}:${fill_zero(t2)}</option>`
                                                }

                                            }
                                        }
                                       break loop3;
                                    }
                                }
                            }


                            let fi_times = [];

                            for(let i =0; i<document.getElementById('start_time').options.length; i++){

                                fi_times.push(document.getElementById('start_time').options[i].value);
                            }


                            for(let i=0; i<fi_times.length; i++){

                                fi_times[i] = new Date(date.getFullYear(),date.getMonth(),date.getDate(),fi_times[i].substr(0,2),fi_times[i].substr(2,2));

                                fi_times[i].setMinutes(fi_times[i].getMinutes()+30);

                                document.getElementById('end_time').innerHTML += `<option value ="${fill_zero(fi_times[i].getHours())}${fill_zero(fi_times[i].getMinutes())}">${am_pm_check(fill_zero(fi_times[i].getHours()))}:${fill_zero(fi_times[i].getMinutes())}</option>`
                            }







                    }



                }
            }





        })



        beauty_gallery_get(body_).then(function(){

            beauty_gallery_add(id,body_[2]);
        });

        get_coupon(id);
        get_etc_product(id);



        management_service_1(id,body_).then(function(body){
            management_total_price();
            discount_init();
            reserves(id,body_);

            management_service_2(body).then(function(base_svc){

                management_service_3(base_svc).then(function(base_svc){

                    management_service_4(base_svc);

                })
            })
        });


        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:'get_beauty_agree',
                partner_id:id,
                pet_idx:body_[2],
            },
            success:function(res) {
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {

                  if(body.length === 0){

                      document.getElementById('beauty_agree_view').innerHTML =  `<button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline" id="beauty_agree_btn">미용 동의서 작성</button>`

                      setTimeout(function(){
                          document.getElementById('beauty_agree_btn').addEventListener('click',function(){

                              beauty_agree_init(body_[3]).then(function(data_){

                                  beauty_agree_init_(data_);
                              });
                          })
                      },50)

                  }else{

                      document.getElementById('beauty_agree_view').innerHTML = `<button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline" id="beauty_agree_view_btn">미용 동의서 보기</button>`

                      setTimeout(function(){
                          document.getElementById('beauty_agree_view_btn').addEventListener('click',function(){


                                  beauty_agree_init(body_[3]).then(function(data_) {

                                      beauty_agree_init_(data_);
                                      document.getElementById('beauty_agree_title').innerText ='미용 동의서 보기';
                                      document.getElementById('agree_name').value = body.customer_name;
                                      document.getElementById('agree_name2').innerText = body.customer_name;
                                      document.getElementById('beauty_agree_footer').innerHTML = '';
                                      document.getElementById('beauty_agree_all_btn').setAttribute('checked',true);
                                      document.getElementById('beauty_agree_1_btn').setAttribute('checked',true);
                                      document.getElementById('beauty_agree_2_btn').setAttribute('checked',true);
                                      document.getElementById('agree_date').innerText= `${body.reg_date.substr(0,4)}.${body.reg_date.substr(4,2)}.${body.reg_date.substr(6,2)}`
                                      document.getElementById('signature_clear').remove();
                                      document.getElementById('user_sign_wrap').innerHTML = `<img src="https://image.banjjakpet.com${body.image}" alt="">`


                                  });



                              });

                      },50)


                  }

                }

            },
            complete:function(){
                if(document.getElementById('pay_management_body')){

                    if(document.getElementById('pay_management_body')){


                        document.getElementById('pay_management_body').style.display = 'block';
                        document.getElementById('pay_management_loading').style.display = `none`;

                    }
                }
            }
        })



    })

}


function today_reserve_month(id){

    let reserve_list = document.getElementById('month_today_reserve_list');



    let booking_list;

    if(list !== undefined){
        booking_list = list;
    }else{
        booking_list = data;
    }

    if(booking_list.beauty.length > 0 || booking_list.hotel.length >0 || booking_list.kindergarden.length >0){


        if(booking_list.beauty.length > 0){
            document.getElementById('common_none_data').style.display = 'none';
            booking_list.beauty.forEach(function(el){

                let today_reserve = el.product.date.booking_st;
                let date_today_reserve = new Date(today_reserve);
                let today_reserve_fi = el.product.date.booking_fi;
                let date_today_reserve_fi = new Date(today_reserve_fi);

                if(date_today_reserve.getFullYear() === new Date().getFullYear()
                    && date_today_reserve.getMonth() === new Date().getMonth()
                    && date_today_reserve.getDate() === new Date().getDate()
                    && el.product.is_cancel !== 1
                ){


                    reserve_list.innerHTML += `<div class="customer-card-list-cell">
                                                    <a href="../booking/reserve_pay_management_beauty_1.php" onclick="localStorage.setItem('payment_idx',${el.product.payment_idx})"  class="customer-card-item small transparent">
                                                        <div class="item-info-wrap">
                                                            <div class="item-thumb">
                                                                <div class="user-thumb small"><img src="${el.pet.photo !== null ? `https://image.banjjakpet.com${el.pet.photo}`  : `${el.pet.animal === 'dog' ? `../static/images/icon/icon-pup-select-off.png`: `../static/images/icon/icon-cat-select-off.png`}` }" alt=""></div>
                                                                <div class="item-kind">
                                                                    <span>${el.product.category_sub.match(':') ? el.product.category_sub.split(':')[0].replace('_',' ') : el.product.category_sub }</span>
                                                                </div>
                                                            </div>
                                                            <div class="item-data">
                                                                <div class="item-data-inner">
                                                                    <div class="item-name">${el.pet.name}
                                                                        <div class="pet-name">${el.pet.type}</div>
                                                                    </div>
                                                                    <div class="item-phone">${el.customer.phone.replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`)}</div>
                                                                    <div class="item-option">
                                                                        <div class="option-cell">
                                                                            <div class="icon icon-size-16 icon-time-purple"></div>
                                                                             ${am_pm_check(date_today_reserve.getHours())}:${fill_zero(date_today_reserve.getMinutes())} ~ ${am_pm_check(date_today_reserve_fi.getHours())}:${fill_zero(date_today_reserve_fi.getMinutes())}
                                                                        </div>
                                                                        <div class="option-cell">${el.product.worker === id ? '실장' : el.product.worker}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>`



                }


            })
        }else{

            document.getElementById('common_none_data').setAttribute('style','display:block')
        }




    }



}

function renderCalendar_month(){


    return new Promise(function(resolve){

        let viewYear = date.getFullYear();
        let viewMonth = date.getMonth();
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

            dates[i] = `<div class="calendar-month-body-col  ${prevDates.indexOf(_date) >= 0 && i <= 7 ? "before" : ""} ${nextDates.indexOf(_date) >= 0 && i >= dates.length - 7 ? "after" : ""}" >
                            <div class="calendar-col-inner" id="inner_data_${i}">
                                <div class="calendar-day-value">
                                    <div class="number">${_date}</div>
                                    <div class="state"></div>
                                </div>
                                <div class="calendar-drag-item-group insert_data" data-year="${date.getFullYear()}" data-month="${date.getMonth()}" data-date="${_date}" >
                                    <a href="#add" class="btn-calendar-add">등록하기</a>
                                </div>
                            </div>
                        </div>`


        })

        const div_dates = dates.division(7);

        //row 생성
        document.getElementById('calendar_month_body').innerHTML = '';
        for (let i = 0; i < div_dates.length; i++) {
            document.getElementById('calendar_month_body').innerHTML += ` <div class="calendar-month-body-row ${i > 0 && i < 5 ? "op-1" : ""} ${i === 0 || i === 2 ? '1or3' : i === 1 || i === 3 ? '2or4':""} " id="calendar-month-body-row-${i}" ></div>`
        }

        resolve(div_dates);



    })
}

function _renderCalendar_month(){

return new Promise(function (resolve){


    renderCalendar_month()
        .then(function(div_dates){
            for (let i = 0; i < div_dates.length; i++) {
                document.getElementById(`calendar-month-body-row-${i}`).innerHTML = '';
                for (let j = 0; j < div_dates[i].length; j++) {
                    document.getElementById(`calendar-month-body-row-${i}`).innerHTML += div_dates[i][j]
                }
            }

    })
    resolve();
})
}

function month_reserve_cols(body){

return new Promise(function (resolve){

    if(body === undefined){
        if(document.getElementById('month_calendar_inner')){

            document.getElementById('month_calendar_inner').style.display = 'block';
            document.getElementById('month_schedule_loading').style.display = 'none';
        }
    }else{
        Array.from(document.getElementsByClassName('insert_data')).forEach(function(el){

            body.beauty.forEach(function(el_){


                let color;
                switch(el_.product.pay_type){

                    case "pos-card": case "pos-cash" : color = 'yellow'; break;
                    case "offline-card" : case "offline-cash" : color = 'purple'; break;
                    default : color = ''; break;

                }

                let date_init = el_.product.date.booking_st.split(' ')[0].split('-');



                if(!el.parentElement.parentElement.classList.contains('before') && !el.parentElement.parentElement.classList.contains('after') ){

                    if(new Date(date_init[0],date_init[1]-1,date_init[2]).getTime() === new Date(el.getAttribute('data-year'),el.getAttribute('data-month'),el.getAttribute('data-date')).getTime() && el_.product.is_cancel === 0 ){

                        el.innerHTML += `<div class="calendar-drag-item"><a href="./reserve_pay_management_beauty_1.php" onclick="localStorage.setItem('payment_idx',${el_.product.payment_idx})" class="calendar-month-day-item green ${color} ${el_.product.pay_type} ${el_.product.is_no_show === 1 ? "red" : ''} ${el_.product.is_approve === 0 ? 'gray':''}" style="color: white;"><div class="calendar-month-day-item-name"><strong>${el_.pet.name}</strong><span>(${el_.pet.type})</span></div></a></div>`
                    }
                }

            })


        })
    }




    resolve();
})

}

function day_total_reserve(){


    let data_length = [];
    Array.from(document.getElementsByClassName('insert_data')).forEach(function (el){


        data_length.push( el.children.length-1);


    })

    for(let i=0; i<data_length.length; i++){


        if(!document.getElementById(`inner_data_${i}`).parentElement.classList.contains('before') && !document.getElementById(`inner_data_${i}`).parentElement.classList.contains('after')){

            if(data_length[i] !== 0){


            document.getElementById(`inner_data_${i}`).innerHTML += `<div class="calendar-total-value">총 ${data_length[i]}건</div>`
            }

        }
    }
}

function month_holiday(id){

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
                    case 1 : body_rows = document.getElementsByClassName('calendar-month-body-row')
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
                            el.childNodes[0].childNodes[1].childNodes[1].childNodes[3].innerText = '정휴'

                        }
                    })

                }
                if(body.is_work_mon){
                    Array.from(body_rows).forEach(function(el){
                        if(el.childNodes.length !== 0){
                            el.childNodes[1].classList.add('break');
                            el.childNodes[1].childNodes[1].childNodes[1].childNodes[3].innerText = '정휴'

                        }
                    })

                }
                if(body.is_work_tue){
                    Array.from(body_rows).forEach(function(el){
                        if(el.childNodes.length !== 0){
                            el.childNodes[2].classList.add('break');
                            el.childNodes[2].childNodes[1].childNodes[1].childNodes[3].innerText = '정휴'

                        }
                    })

                }
                if(body.is_work_wed){
                    Array.from(body_rows).forEach(function(el){
                        if(el.childNodes.length !== 0){
                            el.childNodes[3].classList.add('break');
                            el.childNodes[3].childNodes[1].childNodes[1].childNodes[3].innerText = '정휴'
                        }
                    })

                }
                if(body.is_work_thu){
                    Array.from(body_rows).forEach(function(el){
                        if(el.childNodes.length !== 0){
                            el.childNodes[4].classList.add('break');
                            el.childNodes[4].childNodes[1].childNodes[1].childNodes[3].innerText = '정휴'
                        }
                    })

                }
                if(body.is_work_fri){
                    Array.from(body_rows).forEach(function(el){
                        if(el.childNodes.length !== 0){
                            el.childNodes[5].classList.add('break');
                            el.childNodes[5].childNodes[1].childNodes[1].childNodes[3].innerText = '정휴'

                        }
                    })
                }
                if(body.is_work_sat){
                    Array.from(body_rows).forEach(function(el){
                        if(el.childNodes.length !== 0){
                            el.childNodes[6].classList.add('break');
                            el.childNodes[6].childNodes[1].childNodes[1].childNodes[3].innerText = '정휴'

                        }
                    })
                }
            }

        },
        complete:function(){
            if(document.getElementById('month_calendar_inner')){
                document.getElementById('month_calendar_inner').style.display = 'block';
                document.getElementById('month_schedule_loading').style.display = 'none';
                document.getElementById('btn-month-next').removeAttribute('disabled')
                document.getElementById('btn-month-prev').removeAttribute('disabled')
            }

        }
    })

}


function btn_month_calendar(id){


    document.getElementById('btn-month-prev').addEventListener('click', function (evt) {

        this.setAttribute('disabled',true);


        date.setMonth(date.getMonth() - 1);
        book_list(id).then(function (body){
            document.getElementById('calendar_month_body').innerHTML = '';
            today_reserve_month(id);
            _renderCalendar_month().then(function(){
                month_reserve_cols(body).then(function (){

                    day_total_reserve()
                    month_holiday(id)

                });
            });
        })
    })

    document.getElementById('btn-month-next').addEventListener('click', function (evt) {

        this.setAttribute('disabled',true);

        date.setMonth(date.getMonth() + 1 );
        book_list(id).then(function(body){

            document.getElementById('calendar_month_body').innerHTML = '';
            today_reserve_month(id);
            _renderCalendar_month().then(function(){
                month_reserve_cols(body).then(function (){

                    day_total_reserve()
                    month_holiday(id)

                });
            });



        });
    })

}

function schedule_render_list(id){

    return new Promise(function (resolve){
        $.ajax({

            url: '/data/pc_ajax.php',
            type: 'post',
            data: {
                mode: 'day_book',
                login_id: id,
                st_date: `${date.getFullYear()}-${fill_zero(date.getMonth() + 1)}-${fill_zero(date.getDate())}`,
                fi_date: `${date.getFullYear()}-${fill_zero(date.getMonth() + 1)}-${fill_zero(date.getDate() + 1)}`,
            },
            beforeSend:function(){
                let height;

                if(document.getElementById('list_inner')){

                    height = document.getElementById('list_inner').offsetHeight;
                    document.getElementById('list_inner').style.display = 'none';
                    document.getElementById('list_schedule_loading').style.height =`${height}px`;
                    document.getElementById('list_schedule_loading').style.display ='flex';
                }

            },
            success: function (res) {
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {


                    document.getElementById('day_today').innerHTML = `${date.getFullYear()}.${fill_zero(date.getMonth() + 1)}.${fill_zero(date.getDate())}`
                    document.getElementById('day_total').innerHTML = `${body.length}건`
                    let cancel = 0;
                    let noshow = 0;

                    body.forEach(function (el) {
                        if (el.product.is_cancel === 1) {
                            cancel++;
                        }
                        if (el.product.is_no_show === 1) {
                            noshow++;
                        }
                    })
                    document.getElementById('day_cancel').innerHTML = `${cancel}건`
                    document.getElementById('day_noshow').innerHTML = `${noshow}건`



                    let week = ['일', '월', '화', '수', '목', '금', '토']
                    document.getElementById('schedule_day').innerHTML = `${fill_zero(date.getMonth() + 1)}.${fill_zero(date.getDate())}(${week[date.getDay()]})`




                    let list_inner = document.getElementById('list_inner');

                    if(body.length > 0){
                        let set = new Set();
                        body.forEach(function (el){

                            set.add(el.product.worker);

                        })

                        list_inner.innerHTML = '';
                        set.forEach(function (el){

                            list_inner.innerHTML +=`<div class="reserve-calendar-list-group">
                                                <div class="con-title-group">
                                                    <h5 class="con-title worker_id">${el === id ? '실장' : el}</h5>
                                                </div>
                                                <div class="reserve-calendar-list-data" id="list-data-${el}"></div>
                                            </div>`
                        })
                    }else{


                        list_inner.innerHTML = `<div style="height:300px; margin:0 auto; line-height: 300px; text-align: center">확정된 예약일정이 없습니다.</div>`
                    }



                    resolve(body);
                }

            }
        })

    })


}

function _schedule_render_list(body){




    let color;
    body.forEach(function (el){

        switch(el.product.pay_type){

            case "pos-card" : case "pos-cash" : color = 'yellow'; break;
            case "offline-card" : case "offline-cash" : color = 'purple'; break;
            default : color = ''; break;

        }

        Array.from(document.getElementsByClassName('reserve-calendar-list-data')).forEach(function (el_){

            if(el_.getAttribute(`id`).replaceAll('list-data-','') === el.product.worker && el.product.is_cancel === 0){
                document.getElementById(`list-data-${el.product.worker}`).innerHTML +=`<a href="../booking/reserve_pay_management_beauty_1.php" onclick="localStorage.setItem('payment_idx',${el.product.payment_idx})" class="reserve-calendar-list-items ${color} ${el.product.is_no_show === 1 ? "red" : ''}">
                                                                                                        <div class="item-time">
                                                                                                            <div class="item-time-start">
                                                                                                                <em>${parseInt(el.product.date.booking_st.split(' ')[1].split(':')[0]) < 12 ? '오전' : '오후' }</em>
                                                                                                                <strong>${am_pm_check3(el.product.date.booking_st.split(' ')[1].split(':')[0])}:${el.product.date.booking_st.split(' ')[1].split(':')[1]}</strong>
                                                                                                            </div>
                                                                                                            <div class="item-time-unit">~</div>
                                                                                                            <div class="item-time-end">
                                                                                                                <em>${parseInt(el.product.date.booking_fi.split(' ')[1].split(':')[0]) < 12 ? '오전' : '오후' }</em>
                                                                                                                <strong>${am_pm_check3(el.product.date.booking_fi.split(' ')[1].split(':')[0])}:${el.product.date.booking_fi.split(' ')[1].split(':')[1]}</strong>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="item-info">
                                                                                                            <div class="item-name">
                                                                                                                <div class="item-name-txt">
                                                                                                                    <strong>${el.pet.name}</strong>
                                                                                                                </div>
                                                                                                                <div class="item-name-division">/</div>
                                                                                                                <div class="item-name-txt">${el.pet.type}</div>
                                                                                                            </div>
                                                                                                            <div class="item-options">
                                                                                                                <div class="item-options-txt">카드 : ${el.product.store_payment.card === "" || el.product.store_payment.card === null ? '0' : el.product.store_payment.card}원</div>
                                                                                                                <div class="item-options-division">/</div>
                                                                                                                <div class="item-options-txt">현금 : ${el.product.store_payment.cash === "" || el.product.store_payment.cash === null ? '0' : el.product.store_payment.cash}원</div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </a>`

            }
        })
    })


    if(document.getElementById('list_inner')){
        document.getElementById('list_inner').style.display = 'block';
        document.getElementById('list_schedule_loading').style.display = 'none';
        document.getElementById('btn-schedule-next').removeAttribute('disabled');
        document.getElementById('btn-schedule-prev').removeAttribute('disabled');


    }


}

function reserve_pop(element){

    if(location.href.match('reserve_beauty_day')){
        let parent = element.parentElement.parentElement

        let thisYear = parent.getAttribute('data-year');
        let thisMonth = parent.getAttribute('data-month');
        let thisDate = parent.getAttribute('data-date');
        let thisHour = parent.getAttribute('data-hour');
        let thisMinutes = parent.getAttribute('data-minutes');


        let thisWorker = parent.getAttribute('data-name');
        let thisWorker2 = parent.getAttribute('data-nick');

        document.getElementById('pop2_worker').innerText = thisWorker2;
        document.getElementById('pop2_date').innerText = `${thisYear}-${fill_zero(parseInt(thisMonth)+1)}-${fill_zero(thisDate)}`;
        document.getElementById('pop2_time').innerText = `${am_pm_check(thisHour)}:${thisMinutes}`

        document.getElementById('reserveCalendarPop2').setAttribute('data-name',thisWorker);
        document.getElementById('reserveCalendarPop2').setAttribute('data-nick',thisWorker2);
        document.getElementById('reserveCalendarPop2').setAttribute('data-year',thisYear);
        document.getElementById('reserveCalendarPop2').setAttribute('data-month',thisMonth);
        document.getElementById('reserveCalendarPop2').setAttribute('data-date',thisDate);
        document.getElementById('reserveCalendarPop2').setAttribute('data-Hour',thisHour);
        document.getElementById('reserveCalendarPop2').setAttribute('data-minutes',thisMinutes);


    }else if(location.href.match('reserve_beauty_week')){
        let parent = element.parentElement.parentElement

        let thisYear = parent.getAttribute('data-year');
        let thisMonth = parent.getAttribute('data-month');
        let thisDate = parent.getAttribute('data-date');
        let thisHour = parent.getAttribute('data-hour');
        let thisMinutes = parent.getAttribute('data-minutes');

        let thisWorker;
        let thisWorker2;


        Array.from(document.getElementsByClassName('header-worker')).forEach(function (el){

            if(el.classList.contains('actived')){

                thisWorker = el.getAttribute('data-worker');
                thisWorker2 = el.getAttribute('data-nick');
            }
        })


        document.getElementById('pop2_worker').innerText = thisWorker2;
        document.getElementById('pop2_date').innerText = `${thisYear}-${fill_zero(parseInt(thisMonth)+1)}-${fill_zero(thisDate)}`;
        document.getElementById('pop2_time').innerText = `${am_pm_check(thisHour)}:${thisMinutes}`

        document.getElementById('reserveCalendarPop2').setAttribute('data-name',thisWorker);
        document.getElementById('reserveCalendarPop2').setAttribute('data-nick',thisWorker2);
        document.getElementById('reserveCalendarPop2').setAttribute('data-year',thisYear);
        document.getElementById('reserveCalendarPop2').setAttribute('data-month',thisMonth);
        document.getElementById('reserveCalendarPop2').setAttribute('data-date',thisDate);
        document.getElementById('reserveCalendarPop2').setAttribute('data-Hour',thisHour);
        document.getElementById('reserveCalendarPop2').setAttribute('data-minutes',thisMinutes);


    }


    pop.open('reserveCalendarPop2')


}

function reserve_prohibition_init(){

return new Promise(function (resolve){

    pop.open('reserveCalendarPop3')

    let thisWorker = document.getElementById('reserveCalendarPop2').getAttribute('data-name');
    let thisWorker2 = document.getElementById('reserveCalendarPop2').getAttribute('data-nick');
    let thisYear = document.getElementById('reserveCalendarPop2').getAttribute('data-year');
    let thisMonth = document.getElementById('reserveCalendarPop2').getAttribute('data-month');
    let thisDate = document.getElementById('reserveCalendarPop2').getAttribute('data-date');
    let thisHour = document.getElementById('reserveCalendarPop2').getAttribute('data-hour');
    let thisMinutes = document.getElementById('reserveCalendarPop2').getAttribute('data-minutes');


    document.getElementById('reserveCalendarPop3').setAttribute('data-name',thisWorker);
    document.getElementById('reserveCalendarPop3').setAttribute('data-nick',thisWorker2);
    document.getElementById('reserveCalendarPop3').setAttribute('data-year',thisYear);
    document.getElementById('reserveCalendarPop3').setAttribute('data-month',thisMonth);
    document.getElementById('reserveCalendarPop3').setAttribute('data-date',thisDate);
    document.getElementById('reserveCalendarPop3').setAttribute('data-Hour',thisHour);
    document.getElementById('reserveCalendarPop3').setAttribute('data-minutes',thisMinutes);




    document.getElementById('ph_start_time').innerHTML = ''
    document.getElementById('ph_end_time').innerHTML = ''
    let open_close = localStorage.getItem('open_close');

    let open = parseInt(open_close.split('/')[0]);
    let close = parseInt(open_close.split('/')[1]);
    let time = [];

    for(open; open<=close; open++){

        time.push(open);

    }

    for(let i=0; i<time.length-1; i++){

        for(let t= 0; t<60; t +=30){

            document.getElementById('ph_start_time').innerHTML += `<option value ="${thisYear}${fill_zero(parseInt(thisMonth)+1)}${fill_zero(thisDate)}${fill_zero(time[i])}${fill_zero(t)}">${fill_zero(am_pm_check(time[i]))}:${fill_zero(t)}</option>`




        }
    }

    for(let i=0; i<time.length; i++){

        for(let t=0; t<60; t+=30){

            if(i===0){
                t=30;
            }
            if(i===time.length-1 && t ===30){

                break;
            }
            document.getElementById('ph_end_time').innerHTML += `<option value ="${thisYear}${fill_zero(parseInt(thisMonth)+1)}${fill_zero(thisDate)}${fill_zero(time[i])}${fill_zero(t)}">${fill_zero(am_pm_check(time[i]))}:${fill_zero(t)}</option>`
        }
    }

    resolve();
})





}

function reserve_prohibition_select(){

    let target = document.getElementById('reserveCalendarPop3');

    let thisYear = target.getAttribute('data-year');
    let thisMonth = fill_zero(parseInt(target.getAttribute('data-month'))+1);
    let thisDate = fill_zero(parseInt(target.getAttribute('data-date')));
    let thisHour = fill_zero(target.getAttribute('data-hour'))
    let thisMinutes = fill_zero(target.getAttribute('data-minutes'));

    let st_time = thisYear+thisMonth+thisDate+thisHour+thisMinutes;


    let fi_time = new Date(thisYear,thisMonth-1,thisDate,thisHour,thisMinutes);

    fi_time.setMinutes(fi_time.getMinutes()+30)

    let ty = fi_time.getFullYear().toString();
    let tm = (fill_zero(fi_time.getMonth()+1)).toString();
    let td = (fill_zero(fi_time.getDate())).toString();
    let th = (fill_zero(fi_time.getHours())).toString();
    let tM = (fill_zero(fi_time.getMinutes())).toString();

    let tf = ty+tm+td+th+tM;
    let st_select = document.getElementById('ph_start_time');
    let st_length = st_select.options.length;

    let fi_select = document.getElementById('ph_end_time');
    let fi_length = fi_select.options.length;

    for(let i=0; i<st_length; i++){

        if(st_select.options[i].value === st_time){

            st_select.options[i].selected = true;
        }
    }

    for(let i=0; i<fi_length; i++){

        if(fi_select.options[i].value === tf){
            fi_select.options[i].selected = true;
        }
    }


}

function reserve_prohibition(id){

    let start = document.getElementById('ph_start_time').value;
    let end = document.getElementById('ph_end_time').value;

    $.ajax({


        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'post_prohibition',
            login_id:id,
            worker:document.getElementById('reserveCalendarPop3').getAttribute('data-name'),
            type:'notall',
            st_date:start,
            fi_date:end,
        },
        success:function(res){

            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                // location.reload();
            }

        }
    })

}

function reserve_search(id){



    return new Promise(function(resolve){


        let search_value = document.getElementById('reserve_search').value.trim();

        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{

                mode:'search',
                login_id:id,
                search:search_value,

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


                    if(body.length > 0 ){
                        document.getElementById('common_none_data').setAttribute('style','display:none');

                        document.getElementById('reserve_inner').innerHTML = '';
                        body.forEach(function(el,i){

                            document.getElementById('reserve_inner').innerHTML += `<div class="grid-layout-cell grid-2">
                                                                                            <a href="#" onclick="exist_user_reserve(artist_id,'${el.cellphone}')" class="customer-card-item">
                                                                                                <div class="item-info-wrap">
                                                                                                    <div class="item-thumb">
                                                                                                        <div class="user-thumb large">
                                                                                                        <img src="${el.pet_photo === "" ? el.type === 'dog' ? `../static/images/icon/icon-pup-select-off.png` : `../static/images/icon/icon-cat-select-off.png` : `https://image.banjjakpet.com${el.pet_photo}`}" alt="">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="item-data">
                                                                                                        <div class="item-data-inner">
                                                                                                            <div class="item-pet-name">${el.name}<div class="label label-yellow middle"><strong>${el.pet_type}</strong></div></div>
                                                                                                            <div class="item-main-phone">
                                                                                                                <div class="value">${phone_edit(el.cellphone)}</div>
                                                                                                                ${el.no_show_count >0 ? `<div class="label label-outline-pink label-noshow">NO SHOW ${el.no_show_count}회</div>`: ''}
                                                                                                            </div>
                                                                                                            <div class="item-sub-phone">
                                                                                                                <div class="grid-layout margin-2-5">
                                                                                                                    <div class="grid-layout-inner" id="grid_layout_inner_${i}">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </a>
                                                                                        </div>`



                        })
                    }



                    resolve(body);

                }


            }
        })

    })
}


function reserve_search_fam(id){

    reserve_search(id).then(function(body){
        console.log(body)

        body.forEach(function (el,i){
            console.log(el)
            document.getElementById(`grid_layout_inner_${i}`).innerHTML = ''
            // el.family.split(',').forEach(function(el_,i_){
            //
            //     document.getElementById(`grid_layout_inner_${i}`).innerHTML += `<div class="grid-layout-cell flex-auto">
            //                                                                                        <div class="value">${i_ < 3 ? el_ : i_ === 3 ? `외 ${el.family.split(',').length-3}개의 연락처` : ""}</div>
            //                                                                                    </div>`
            //
            // })

            if(el.family.length >0){
                el.family.forEach(function(el_,i_){

                    document.getElementById(`grid_layout_inner_${i}`).innerHTML += `<div class="grid-layout-cell flex-auto">
                                                                                                    <div class="value">${i_ < 3 ? el_.phone : i_ === 3 ? `외 ${el.family.length-3}개의 연락처` : ""}</div>
                                                                                               </div>`
                })
            }

        })


    })

}

function reserve_toggle(){

    document.getElementById('exist_btn').addEventListener('click',function(){

        document.getElementById('new_user').style.display = 'none';
        document.getElementById('exist_user').style.display = 'block'
        document.getElementById('reserve_footer').style.display = 'none';
    })

    document.getElementById('new_btn').addEventListener('click',function(){

        document.getElementById('reserve_cellphone').removeAttribute('readonly');
        document.getElementById('exist_user').style.display = 'none';
        document.getElementById('select_pet').style.display = 'none';
        document.getElementById('new_user').style.display = 'block';
        document.getElementById('reserve_footer').style.display = 'block';
    })

}

function reserve_prohibition_list(id){

    let st_date;
    let fi_date;
    if(location.href.match('reserve_beauty_day')){

        st_date = `${date.getFullYear()}${fill_zero(date.getMonth()+1)}${fill_zero(date.getDate())}`;
        fi_date = `${date.getFullYear()}${fill_zero(date.getMonth()+1)}${fill_zero(date.getDate()+1)}`
    }else if(location.href.match('reserve_beauty_week')){

        let dates = document.getElementById('schedule_day').innerText.replaceAll('.','').split(' ~ ');

        st_date = `${date.getFullYear()}${dates[0]}`;
        fi_date = `${date.getFullYear()}${dates[1]}`;


    }

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'get_prohibition',
            login_id : id,
            st_date:st_date,
            fi_date:fi_date,
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

                if(body.length > 0){



                    if(location.href.match('reserve_beauty_day')){
                        body.forEach(function(el){


                            let st_date = new Date(el.st_date).getTime();
                            let fi_date = new Date(el.fi_date).getTime();
                            let time = [];

                            for(let i=st_date; i<=fi_date; i+=1800000){

                                time.push(i);
                            }

                            Array.from(document.getElementsByClassName('time-compare-cols')).forEach(function (el_){

                                let el_year = el_.getAttribute('data-year');
                                let el_month= el_.getAttribute('data-month');
                                let el_date= el_.getAttribute('data-date');
                                let el_hour= el_.getAttribute('data-hour');
                                let el_minutes = el_.getAttribute('data-minutes');

                                let el_new_date = new Date(`${el_year}-${fill_zero(parseInt(el_month)+1)}-${fill_zero(parseInt(el_date))} ${fill_zero(el_hour)}:${fill_zero(el_minutes)}`).getTime();


                                for(let i=0; i<time.length-1; i++){

                                    if(el_new_date === time[i] && el.worker === el_.getAttribute('data-name')){


                                        if(i===0){
                                            el_.classList.add('break3-1')
                                        }

                                        el_.setAttribute('onclick',`pop.open("reserveCalendarPop10"); document.getElementById("reserveCalendarPop10").setAttribute('data-ph_seq',${el.ph_seq})`)
                                        el_.setAttribute('data-ph_seq',el.ph_seq)
                                        el_.classList.add('break3');
                                    }
                                }

                            })

                        })
                    }else if(location.href.match('reserve_beauty_week')){


                        let worker;
                        Array.from(document.getElementsByClassName('header-worker')).forEach(function(el){

                            if(el.classList.contains('actived')){

                                worker = el.getAttribute('data-worker');
                            }

                        })
                        Array.from(document.getElementsByClassName('calendar-week-body-col-add')).forEach(function (el_){
                            if(el_.classList.contains('break3')){
                                el_.classList.remove('break3','break3-1')
                            }
                        })

                        body.forEach(function(el){

                            let st_date = new Date(el.st_date).getTime();

                            let fi_date = new Date(el.fi_date).getTime();

                            let time = [];

                            for(let i=st_date; i<=fi_date; i+=1800000){

                                time.push(i);
                            }


                            if(worker === el.worker){
                                Array.from(document.getElementsByClassName('calendar-week-body-col-add')).forEach(function (el_){



                                    let el_year = el_.getAttribute('data-year');
                                    let el_month= el_.getAttribute('data-month');
                                    let el_date= el_.getAttribute('data-date');
                                    let el_hour= el_.getAttribute('data-hour');
                                    let el_minutes = el_.getAttribute('data-minutes');

                                    let el_new_date = new Date(`${el_year}-${fill_zero(parseInt(el_month)+1)}-${fill_zero(parseInt(el_date))} ${fill_zero(el_hour)}:${fill_zero(el_minutes)}`).getTime();


                                    for(let i=0; i<time.length-1; i++){

                                        if(el_new_date === time[i]){

                                            if(i===0){
                                                el_.classList.add('break3-1')
                                            }
                                            el_.setAttribute('onclick',`pop.open("reserveCalendarPop10"); document.getElementById("reserveCalendarPop10").setAttribute('data-ph_seq',${el.ph_seq})`)
                                            el_.setAttribute('data-ph_seq',el.ph_seq)
                                            el_.classList.add('break3');
                                        }
                                    }

                                })
                            }





                        })





                    }

                }
            }

        },
        complete:function(){

            if(document.getElementById('week_schedule_card_body')){
                document.getElementById('week_schedule_card_body').style.display = 'block';
                document.getElementById('week_schedule_loading').style.display ='none';
                document.getElementById('btn-schedule-prev').removeAttribute('disabled');
                document.getElementById('btn-schedule-next').removeAttribute('disabled');
                week_timebar();

            }
        }
    })
}


function reserve_prohibition_delete(){

    let ph_seq = document.getElementById('reserveCalendarPop10').getAttribute('data-ph_seq');



    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'delete_prohibition',
            ph_seq:ph_seq
        },
        success:function(res) {
            // 
            location.reload();
        }
    })

}

function reserve_regist_tab(){

    let basic_btn = document.getElementById('basic_service_btn');
    let other_btn = document.getElementById('other_service_btn');
    let basic = document.getElementById('basic_service');
    let other = document.getElementById('other_service');

    basic_btn.addEventListener('click',function(){

        if(other.classList.contains('actived')){

            other.classList.remove('actived')

        }

        basic.classList.add('actived')

    })

    other_btn.addEventListener('click',function(){

        if(basic.classList.contains('actived')){

            basic.classList.remove('actived')
        }

        other.classList.add('actived')
    })
}

function reserve_merchandise_load_reset(i){

    switch (i){

        case 1 : document.getElementById('basic_service_select').innerHTML = '<div class="toggle-button-cell" onclick="reserve_merchandise_load_reset(2)"><label class="form-toggle-box large "><input type="radio" value="" name="s1"><em>선택 안함</em></label></div>';
            document.getElementById('basic_weight').innerHTML = '<div class="toggle-button-cell" id="weight_not_select"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="s2" checked ><em><span>선택 안함</span></em></label></div>';

            break;
        case 2 :
            document.getElementById('basic_weight').innerHTML = '<div class="toggle-button-cell" id="weight_not_select"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="s2" checked><em><span>선택 안함</span></em></label></div>';

            break;


    }

}

function reserve_service_list(element,text,price){


    if(element === 'service2_basic_size'){
        document.getElementById(element).innerHTML = text;
        document.getElementById('service2_basic_service').innerHTML = '';
        document.getElementById('service2_basic_weight').innerHTML = '';


    }else if(element === 'service2_basic_service'){

        document.getElementById(element).innerHTML = text;
        document.getElementById('service2_basic_weight').innerHTML = '';

    }else{
        document.getElementById(element).innerHTML = text;
        document.getElementById(element).setAttribute('data-price',price);
    }

}

function reserve_service_list_2(element,type,price){


    document.getElementById(element).innerHTML += `<div class="list-data" data-price="${price}">${type}</div>`

}

function reserve_service_list_2_delete(element,string){


    Array.from(document.getElementById(element).children).forEach(function(el){

        if(el.innerText === string){
            el.remove();
        }
    })
}


function reserve_merchandise_load_event(id){

    Array.from(document.getElementsByClassName('load-pet-type')).forEach(function (el){

        el.addEventListener('click',function (evt){

            reserve_merchandise_load_init(id).then(function(body){
                reserve_merchandise_load(body).then(function(base_svc){

                    reserve_merchandise_load_2(base_svc).then(function (base_svc){

                        reserve_merchandise_load_3(base_svc)

                    })
                })
            })
        })
    })
}
function reserve_merchandise_load_init(id){


    return new Promise(function(resolve){




        let breed_input;

        let breed;






                breed_input = document.querySelector('input[name="breed"]:checked');
                breed = breed_input.value

                $.ajax({

                    url:'/data/pc_ajax.php',
                    type:'post',
                    data:{

                        mode:'merchandise',
                        login_id:id,
                        animal:breed

                    },
                    success:function (res){
                        let response = JSON.parse(res);
                        let head = response.data.head;
                        let body = response.data.body;
                        if (head.code === 401) {
                            pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                        } else if (head.code === 200) {


                            let service = document.getElementById('service');
                            let service2 = document.getElementById('service2');
                            let basic_service = document.getElementById('basic_service');
                            let basic_service_inner = document.getElementById('basic_service_inner');
                            let other_service_inner = document.getElementById('other_service_inner');


                            basic_service_inner.innerHTML = '';
                            other_service_inner.innerHTML ='';
                            document.getElementById('service2_basic_list').innerHTML =   `<div class="service-selected-list-cell">
                                                                                                <div class="list-data" id="service2_basic_size"></div>
                                                                                            </div>
                                                                                        <div class="service-selected-list-cell">
                                                                                            <div class="list-data" id="service2_basic_service"></div>
                                                                                        </div>
                                                                                        <div class="service-selected-list-cell">
                                                                                            <div class="list-data" id="service2_basic_weight"></div>
                                                                                        </div>
                                                                                        <div class="service-selected-list-cell" id="service2_basic_hair_feature">
                                                                                            <div class="list-data"></div>
                                                                                        </div>
                                                                                        <div class="service-selected-list-cell">
                                                                                            <div class="list-data" id="service2_basic_hair_length"></div>
                                                                                        </div>
                                                                                         <div class="service-selected-list-cell">
                                                                                            <div class="list-data"  id="service2_basic_beauty"></div>
                                                                                        </div>
                                                                                        <div class="service-selected-list-cell">
                                                                                            <div class="list-data"  id="service2_basic_bath"></div>
                                                                                        </div>`

                            document.getElementById('service2_other_list').innerHTML = '';


                            service.style.display = 'block';
                            service2.style.display = 'block';
                            // basic_service.style.display = 'block';

                            if(breed === 'dog'){

                                if(body.base_svc.length > 0){

                                    basic_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">크기 선택</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="basic_size">
                                                                          <div class="toggle-button-cell" onclick="reserve_merchandise_load_reset(1)"><label class="form-toggle-box large"><input type="radio" value="" name="size" onclick="reserve_service_list('service2_basic_size','','0')" checked><em>선택 안함</em></label></div>
                                                                     
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">서비스</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="basic_service_select">
                                                                              <div class="toggle-button-cell" onclick="reserve_merchandise_load_reset(2)"><label class="form-toggle-box large"><input type="radio" value="" name="s1" onclick="reserve_service_list('service2_basic_service','','0')" checked ><em>선택 안함</em></label></div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="grid-layout-cell grid-5">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">무게</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="toggle-button-group vertical" id="basic_weight">
                                                                            <div class="toggle-button-cell" id="weight_not_select"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="s2" onclick="reserve_service_list('service2_basic_weight','','0')" checked><em><span>선택 안함</span></em></label></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>`
                                }


                                if(body.hair_feature.length > 0){


                                    basic_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                        <div class="form-group-item">
                                                                            <div class="form-item-label">털특징</div>
                                                                            <div class="form-item-data type-2">
                                                                                <div class="toggle-button-group vertical" id="basic_hair_feature">
                                                                             </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>`
                                }

                                if(body.hair_length.length > 0){



                                    basic_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">미용털길이</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="basic_hair_length">
                                                                            <div class="toggle-button-cell" ><label class="form-toggle-box large"><input type="radio" value="" name="hairBeauty" onclick="reserve_service_list('service2_basic_hair_length','','0')" checked ><em>선택 안함</em></label></div>
                                                                                </div>
                                                                        </div>
                                                                    </div>
                                                                </div>`

                                }

                                if(body.face.length > 0){

                                    other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">얼굴컷</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="other_face">
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>`
                                }

                                if(body.leg.length > 0){

                                    other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                        <div class="form-group-item">
                                                                            <div class="form-item-label">다리</div>
                                                                            <div class="form-item-data type-2">
                                                                                <div class="toggle-button-group vertical" id="other_leg">
                
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>`
                                }

                                if(body.spa.length > 0){

                                    other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">스파</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="other_spa">
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>`
                                }

                                if(body.dyeing.length > 0){


                                    other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">염색</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="other_dyeing">
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>`
                                }

                                if(body.etc.length > 0){

                                    other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                        <div class="form-group-item">
                                                                            <div class="form-item-label">기타</div>
                                                                            <div class="form-item-data type-2">
                                                                                <div class="toggle-button-group vertical" id="other_etc">
                                                                                   
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>`

                                }
                            }else if(breed === 'cat'){
                                if(body.beauty.length > 0){

                                    basic_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                            <div class="form-group-item">
                                                                                <div class="form-item-label">미용</div>
                                                                                <div class="form-item-data type-2">
                                                                                    <div class="toggle-button-group vertical" id="basic_beauty">
                                                                                        <div class="toggle-button-cell" ><label class="form-toggle-box large"><input type="radio" value="" name="beauty" onclick="reserve_service_list('service2_basic_beauty','','0')" checked><em>선택 안함</em></label></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>`
                                }

                                if(body.bath.length > 0){


                                    basic_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                            <div class="form-group-item">
                                                                                <div class="form-item-label">목욕</div>
                                                                                <div class="form-item-data type-2">
                                                                                    <div class="toggle-button-group vertical" id="basic_bath">
                                                                                        <div class="toggle-button-cell" ><label class="form-toggle-box large"><input type="radio" value="" name="bath" onclick="reserve_service_list('service2_basic_bath','','0')" checked><em>선택 안함</em></label></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>`
                                }

                                if(body.add_svc.length > 0){


                                    other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">추가서비스</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="other_add_svc">
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>`
                                }

                            }


                            resolve(body);
                        }
                    }
                })







    })
}

function reserve_merchandise_load(body){




    return new Promise(function(resolve){


        document.getElementById('is_vat').value = body.is_vat;

        if(body.base_svc !== undefined){
            if(body.base_svc.length > 0){


                body.base_svc.forEach(function(el){

                    document.getElementById('basic_size').innerHTML += `<div class="toggle-button-cell toggle-button-cell-size">
                                                                                        <label class="form-toggle-box large">
                                                                                            <input type="radio" value="${el.size}" name="size" onclick="reserve_service_list('service2_basic_size','${el.size}')">
                                                                                            <em>${el.size}</em>
                                                                                        </label>
                                                                                    </div>`

                })
            }

            if(body.hair_feature.length > 0){

                body.hair_feature.forEach(function(el,i){

                    if(el.price !== ''){

                        document.getElementById('basic_hair_feature').innerHTML += `<div class="toggle-button-cell">
                                                                                                    <label class="form-toggle-box form-toggle-price large" for="hair${i}">
                                                                                                        <input type="checkbox" name="hair" value="${el.type}" data-price="${el.price}" id="hair${i}" onclick="if(this.checked === true){reserve_service_list_2('service2_basic_hair_feature','${el.type}','${el.price}')}else{reserve_service_list_2_delete('service2_basic_hair_feature','${el.type}')}" >
                                                                                                        <em>
                                                                                                            <span>${el.type}</span>
                                                                                                            <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                                        </em>
                                                                                                    </label>
                                                                                                </div>`

                    }


                })
            }

            if(body.hair_length.length > 0){


                body.hair_length.forEach(function(el,i){

                   document.getElementById('basic_hair_length').innerHTML += `<div class="toggle-button-cell">
                                                                                            <label class="form-toggle-box form-toggle-price large" for="hairBeauty${i}">
                                                                                                <input type="radio" name="hairBeauty" value="${el.type}"  data-price="${el.price}" id="hairBeauty${i}" onclick="reserve_service_list('service2_basic_hair_length','${el.type}',${el.price})">
                                                                                                <em>
                                                                                                    <span>${el.type}</span>
                                                                                                    <strong>${parseInt(el.price).toLocaleString()}원</strong>
                                                                                                </em>
                                                                                            </label>
                                                                                        </div>`

                })
            }

            if(body.face.length >0){

                body.face.forEach(function(el,i){

                    document.getElementById('other_face').innerHTML += `<div class="toggle-button-cell">
                                                                                        <label class="form-toggle-box form-toggle-price middle">
                                                                                            <input type="checkbox" name="f1" data-price="${el.price}" value="${el.type}" onclick="if(this.checked === true){reserve_service_list_2('service2_other_list_face','+${el.type}','${el.price}')}else{reserve_service_list_2_delete('service2_other_list_face','+${el.type}')}">
                                                                                            <em>
                                                                                                <span>${el.type}</span>
                                                                                                <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                            </em>
                                                                                        </label>
                                                                                    </div>`

                    if(i===body.face.length-1){

                        document.getElementById('service2_other_list').innerHTML += `<div class="service-selected-list-cell">
                                                                                                    <div class="list-title" id="service2_other_list_face">얼굴컷</div>
                                                                                                </div>`
                    }
                })
            }


            if(body.leg.length>0){

                body.leg.forEach(function(el,i){

                    document.getElementById('other_leg').innerHTML += `<div class="toggle-button-cell">
                                                                                    <label class="form-toggle-box form-toggle-price middle">
                                                                                        <input type="checkbox" name="f2" value="${el.type}" data-price="${el.price}" onclick="if(this.checked === true){reserve_service_list_2('service2_other_list_leg','+${el.type}','${el.price}')}else{reserve_service_list_2_delete('service2_other_list_leg','+${el.type}')}">
                                                                                        <em>
                                                                                            <span>${el.type}</span>
                                                                                            <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                        </em>
                                                                                    </label>
                                                                                </div>`


                    if(i===body.leg.length-1){

                        document.getElementById('service2_other_list').innerHTML += `<div class="service-selected-list-cell">
                                                                                                    <div class="list-title" id="service2_other_list_leg">다리</div>
                                                                                                </div>`
                    }

                })
            }

            if(body.spa.length>0){

                body.spa.forEach(function(el,i){

                    document.getElementById('other_spa').innerHTML += `<div class="toggle-button-cell">
                                                                                    <label class="form-toggle-box form-toggle-price middle">
                                                                                        <input type="checkbox" name="f3"  value="${el.type}" data-price="${el.price}" onclick="if(this.checked === true){reserve_service_list_2('service2_other_list_spa','+${el.type}','${el.price}')}else{reserve_service_list_2_delete('service2_other_list_spa','+${el.type}')}"> 
                                                                                        <em>
                                                                                            <span>${el.type}</span>
                                                                                            <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                        </em>
                                                                                    </label>
                                                                                </div>`

                    if(i===body.spa.length-1){

                        document.getElementById('service2_other_list').innerHTML += `<div class="service-selected-list-cell">
                                                                                                    <div class="list-title" id="service2_other_list_spa">스파</div>
                                                                                                </div>`
                    }
                })
            }

            if(body.dyeing.length >0 ){

                body.dyeing.forEach(function(el,i){

                    document.getElementById('other_dyeing').innerHTML += `<div class="toggle-button-cell">
                                                                                        <label class="form-toggle-box form-toggle-price middle">
                                                                                            <input type="checkbox" name="f4" value="${el.type}" data-price="${el.price}" onclick="if(this.checked === true){reserve_service_list_2('service2_other_list_dyeing','+${el.type}','${el.price}')}else{reserve_service_list_2_delete('service2_other_list_dyeing','+${el.type}')}">
                                                                                            <em>
                                                                                                <span>${el.type}</span>
                                                                                                <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                            </em>
                                                                                        </label>
                                                                                    </div>`

                    if(i===body.dyeing.length-1){

                        document.getElementById('service2_other_list').innerHTML += `<div class="service-selected-list-cell">
                                                                                                    <div class="list-title" id="service2_other_list_dyeing">염색</div>
                                                                                                </div>`
                    }
                })
            }


            if(body.etc.length >0){

                body.etc.forEach(function(el,i){

                    document.getElementById('other_etc').innerHTML += `<div class="toggle-button-cell">
                                                                            <label class="form-toggle-box form-toggle-price middle">
                                                                                <input type="checkbox" name="f5" value="${el.type}" data-price="${el.price}" onclick="if(this.checked === true){reserve_service_list_2('service2_other_list_etc','+${el.type}','${el.price}')}else{reserve_service_list_2_delete('service2_other_list_etc','+${el.type}')}">
                                                                                <em>
                                                                                    <span>${el.type}</span>
                                                                                    <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                               </em>
                                                                            </label>
                                                                        </div>`

                    if(i===body.etc.length-1){

                        document.getElementById('service2_other_list').innerHTML += `<div class="service-selected-list-cell">
                                                                                                    <div class="list-title" id="service2_other_list_etc">기타</div>
                                                                                                </div>`
                    }
                })


            }







        }else {


            if(body.beauty.length > 0){

                body.beauty.forEach(function(el){

                    document.getElementById('basic_beauty').innerHTML += `<div class="toggle-button-cell">
                                                                                        <label class="form-toggle-box large form-toggle-price">
                                                                                            <input type="radio" value="${el.type}" name="beauty" data-price="${el.price}" onclick="reserve_service_list('service2_basic_beauty','${el.type}',${el.price})">
                                                                                            <em> 
                                                                                                <span>${el.type}</span>
                                                                                                <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                            </em>
                                                                                        </label>
                                                                                    </div>`

                })
            }

            if(body.bath.length >0){

                body.bath.forEach(function(el){

                    document.getElementById('basic_bath').innerHTML += `<div class="toggle-button-cell">
                                                                                        <label class="form-toggle-box large form-toggle-price">
                                                                                            <input type="radio" value="${el.type}" name="bath" data-price="${el.price}" onclick="reserve_service_list('service2_basic_bath','${el.type}',${el.price})">
                                                                                            <em> 
                                                                                                <span>${el.type}</span>
                                                                                                <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                            </em>
                                                                                        </label>
                                                                                    </div>`
                })
            }


            if(body.add_svc.length > 0 ){

                body.add_svc.forEach(function(el,i){

                    document.getElementById('other_add_svc').innerHTML += `<div class="toggle-button-cell">
                                                                            <label class="form-toggle-box form-toggle-price middle">
                                                                                <input type="checkbox" name="add_svc" value="${el.type}" data-price="${el.price}" onclick="if(this.checked === true){reserve_service_list_2('service2_other_list_add_svc','+${el.type}','${el.price}')}else{reserve_service_list_2_delete('service2_other_list_add_svc','+${el.type}')}">
                                                                                <em>
                                                                                    <span>${el.type}</span>
                                                                                    <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                               </em>
                                                                            </label>
                                                                        </div>`

                    if(i===body.add_svc.length-1){

                        document.getElementById('service2_other_list').innerHTML += `<div class="service-selected-list-cell">
                                                                                                    <div class="list-title" id="service2_other_list_add_svc">추가서비스</div>
                                                                                                </div>`
                    }
                })
            }


        }

        resolve(body.base_svc);
    })

}

function reserve_merchandise_load_2(base_svc){

    return new Promise(function (resolve){

        Array.from(document.getElementsByClassName('toggle-button-cell-size')).forEach(function(el){



            el.addEventListener('click',function(){


                document.getElementById('basic_service_select').innerHTML= '<div class="toggle-button-cell" onclick="reserve_merchandise_load_reset(2)"><label class="form-toggle-box large"><input type="radio" value="" name="s1" onclick="reserve_service_list(\'service2_basic_service\',\'\')" checked><em>선택 안함</em></label></div>';
                document.getElementById('basic_weight').innerHTML = '<div class="toggle-button-cell" id="weight_not_select"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="s2" onclick="reserve_service_list(\'service2_basic_weight\',\'\',\'0\')" checked><em><span>선택 안함</span></em></label></div>';
                let value = el.children[0].children[0].value;

                base_svc.forEach(function(el_){


                    if(value === el_.size){

                        el_.svc.forEach(function (_el){


                            if(_el.is_show === "y" && _el.unit.length >0){
                                document.getElementById('basic_service_select').innerHTML += `<div class="toggle-button-cell toggle-button-cell-service">
                                                                                                        <label class="form-toggle-box large">
                                                                                                            <input type="radio" value="${_el.type}" data-size="${el_.size}" data-time="${_el.time}" name="s1" onclick="reserve_service_list('service2_basic_service','${_el.type} ${_el.time}분')">
                                                                                                            <em>${_el.type} ${_el.time}분</em>
                                                                                                        </label>
                                                                                                    </div>`
                            }



                        })
                    }
                })
                reserve_merchandise_load_3(base_svc);

                resolve(base_svc)
            })
        })


    })





}

function reserve_merchandise_load_3(base_svc){


    Array.from(document.getElementsByClassName('toggle-button-cell-service')).forEach(function(el){

        el.addEventListener('click',function (){

            document.getElementById('basic_weight').innerHTML= '<div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" data-price="" name="s2" onclick="reserve_service_list(\'service2_basic_weight\',\'\',\'0\')"><em><span>선택 안함</span></em></label></div>'


            let size = el.children[0].children[0].getAttribute('data-size');
            let value = el.children[0].children[0].value;



            let surcharge ;
            base_svc.forEach(function(el_){


                if(el_.size === size){


                    el_.svc.forEach(function(_el){

                        if(_el.type === value){


                            if(_el.unit.length > 0){

                                _el.unit.forEach(function (ele,i){


                                    document.getElementById('basic_weight').innerHTML += `<div class="toggle-button-cell">
                                                                                                    <label class="form-toggle-box form-toggle-price large">
                                                                                                        <input type="radio" value="${ele.kg}" name="s2" data-price="${ele.price}"  onclick="reserve_service_list('service2_basic_weight','~${ele.kg}kg',${ele.is_consulting === "0" ? ele.price : '0'})">
                                                                                                            <em>
                                                                                                                <span>~${ele.kg}Kg</span>
                                                                                                            <strong>${ele.is_consulting === "0" ? `${parseInt(ele.price).toLocaleString()}원` : '상담'}</strong>
                                                                                                            
                                                                                                        </em>
                                                                                                    </label>
                                                                                                </div>`


                                    if(el_.surcharge.is_have ===1 && i === _el.unit.length-1){


                                        let surcharge_kg = el_.surcharge.kg ;
                                        let surcharge_std_price = ele.kg === surcharge_kg ? ele.price : '';
                                        localStorage.setItem('surcharge_std_price',surcharge_std_price);
                                        localStorage.setItem('surcharge_kg',surcharge_kg);
                                        localStorage.setItem('surcharge_price',el_.surcharge.price);



                                        document.getElementById('basic_weight').innerHTML += `<div class="toggle-button-cell">
                                                                                                <div class="form-toggle-options">
                                                                                                    <input type="radio" name="s2" name="options1"  id="surcharge" onclick="reserve_service_list('service2_basic_weight','${el_.surcharge.kg}kg~','surcharge')">
                                                                                                        <div class="form-toggle-options-data">
                                                                                                            <div class="options-labels">
                                                                                                                <span>${el_.surcharge.kg}kg~</span><strong style="font-size:10px">kg당 <br> +${parseInt(el_.surcharge.price).toLocaleString()}원</strong></div>
                                                                                                            <div class="form-amount-input">
                                                                                                                <button type="button" onclick="if(document.getElementById('weight_target').value == 10){return;}document.getElementById('weight_target').value = parseInt(document.getElementById('weight_target').value)-1"
                                                                                                                        class="btn-form-amount-minus">감소
                                                                                                                </button>
                                                                                                                <div class="form-amount-info">
                                                                                                                    <input type="number" readOnly=""  value="10" data-weight="10kg+" id="weight_target"
                                                                                                                           class="form-amount-val">
                                                                                                                </div>
                                                                                                                <button type="button" onclick="document.getElementById('weight_target').value = parseInt(document.getElementById('weight_target').value)+1 "
                                                                                                                        class="btn-form-amount-plus">증가
                                                                                                                </button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                            </div>`


                                    }



                                })
                            }else{
                                document.getElementById('basic_weight').innerHTML = '<div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="s2" onclick="reserve_service_list(\'service2_basic_weight\',\'\',0)"><em><span>선택 안함</span></em></label></div>';
                            }

                        }
                    })
                }
            })




            let st_time_input = document.getElementById('reserve_st_time');
            let st_time = st_time_input.options[st_time_input.selectedIndex].value;
            let fi_time_input = document.getElementById('reserve_fi_time');

            let selected = document.querySelector('input[name="s1"]:checked').getAttribute('data-time');

            let st_time_value = new Date(date.getFullYear(),date.getMonth(),date.getDate(),st_time.split(':')[0],st_time.split(':')[1]);

            st_time_value.setMinutes(st_time_value.getMinutes()+parseInt(selected));

            let fi_hour = st_time_value.getHours();
            let fi_minutes = st_time_value.getMinutes();
            let fi_time = `${fi_hour}:${fill_zero(fi_minutes)}`;





            for(let i=0; i<fi_time_input.options.length; i++){

                if(fi_time_input.options[i].value === fi_time){

                    fi_time_input.options[i].selected = true;

                }
            }



        })
    })

}

function reserve_time(){

    return new Promise(function (resolve){

        for(let i = 2000; i<=new Date().getFullYear(); i++){

            document.getElementById('reserve_time_year').innerHTML += `<option value="${fill_zero(i)}" ${i===2022 ? 'selected':''}>${i}</option>`
        }


        for(let i = 1; i<=12; i++){
            document.getElementById('reserve_time_month').innerHTML += `<option value="${fill_zero(i)}">${i}</option>`
        }

        resolve();
    })

}



function reserve_time_date(){


    let year = document.getElementById('reserve_time_year').value;
    let month = document.getElementById('reserve_time_month').value;

    let date_length = new Date(year,month,0).getDate();
    document.getElementById('reserve_time_date').innerHTML = '';
    for(let i = 1; i<=date_length; i++){
        document.getElementById('reserve_time_date').innerHTML += `<option value="${fill_zero(i)}">${i}</option>`

    }

    Array.from(document.getElementsByClassName('reserve-time')).forEach(function(el){

        el.addEventListener('change',function(){

            year = document.getElementById('reserve_time_year').value;
            month = document.getElementById('reserve_time_month').value;

            date_length = new Date(year,month,0).getDate();
            document.getElementById('reserve_time_date').innerHTML = '';
            for(let i = 1; i<=date_length; i++){
                document.getElementById('reserve_time_date').innerHTML += `<option value="${i}">${i}</option>`

            }
        })
    })

}

function reserve_time_init(){



        let open = parseInt(localStorage.getItem('open_close').split('/')[0]);
        let close = parseInt(localStorage.getItem('open_close').split('/')[1]);

        let time = [];

        for(open; open<=close; open++){

            time.push(open);

        }

        for(let i=0; i<time.length-1; i++){

            for(let t= 0; t<60; t +=30){

                document.getElementById('reserve_st_time').innerHTML += `<option value ="${time[i]}:${fill_zero(t)}">${fill_zero(am_pm_check(time[i]))}:${fill_zero(t)}</option>`




            }
        }

        for(let i=0; i<time.length; i++){

            for(let t=0; t<60; t+=30){

                if(i===0){
                    t=30;
                }
                if(i===time.length-1 && t ===30){

                    break;
                }
                document.getElementById('reserve_fi_time').innerHTML += `<option value ="${time[i]}:${fill_zero(t)}">${fill_zero(am_pm_check(time[i]))}:${fill_zero(t)}</option>`
            }
        }


}

function reserve_time_select(){

    let year = parseInt(document.getElementById('reserveCalendarPop2').getAttribute('data-year'));
    let month = parseInt(document.getElementById('reserveCalendarPop2').getAttribute('data-month'))+1;
    let date = parseInt(document.getElementById('reserveCalendarPop2').getAttribute('data-date'));
    let hour = parseInt(document.getElementById('reserveCalendarPop2').getAttribute('data-hour'));
    let minutes = parseInt(document.getElementById('reserveCalendarPop2').getAttribute('data-minutes'));

    for(let i =0; i<document.getElementById('reserve_time_year').options.length; i++){

        if(parseInt(document.getElementById('reserve_time_year').options[i].value) == year){

            document.getElementById('reserve_time_year').options[i].selected = true;
        }
    }

    for(let i =0; i<document.getElementById('reserve_time_month').options.length; i++){

        if(document.getElementById('reserve_time_month').options[i].value == fill_zero(month)){

            document.getElementById('reserve_time_month').options[i].selected = true;
        }
    }
    for(let i =0; i<document.getElementById('reserve_time_date').options.length; i++){

        if(parseInt(document.getElementById('reserve_time_date').options[i].value) === date){

            document.getElementById('reserve_time_date').options[i].selected = true;
        }
    }

    for(let i =0; i<document.getElementById('reserve_st_time').options.length; i++){

        if(document.getElementById('reserve_st_time').options[i].value == `${hour}:${fill_zero(minutes)}`){

            document.getElementById('reserve_st_time').options[i].selected = true;
        }
    }
    for(let i =0; i<document.getElementById('reserve_fi_time').options.length; i++){

        if(document.getElementById('reserve_fi_time').options[i].value == `${hour+2}:${fill_zero(minutes)}`){

            document.getElementById('reserve_fi_time').options[i].selected = true;
        }
    }






}


function reserve_regist_event(artist_id,session_id){




    Array.from(document.getElementsByClassName('reserve_regist_btn')).forEach(function (el){

        el.addEventListener('click',function(){
            let cellphone_input = document.getElementById('reserve_cellphone');
            let name_input = document.getElementById('reserve_name');
            let breed_select_input = document.getElementById('breed_select');
            let breed_input = document.querySelector('input[name="breed"]:checked')
            let breed_other_input = document.getElementById('breed_other');
            let cellphone = cellphone_input.value;
            let name = name_input.value;
            let breed_select = breed_select_input.value === '기타' ? breed_other_input.value : breed_select_input.value;
            let breed = breed_input === null ? '': breed_input.value;
            let weight1_input = document.getElementById('weight1');
            let weight2_input = document.getElementById('weight2');
            let weight1 = weight1_input.options[weight1_input.selectedIndex].value;
            let weight2 = weight2_input.options[weight2_input.selectedIndex].value;
            let weight = `${weight1}.${weight2}`;



            if(cellphone === ''){

                document.getElementById('msg1_txt').innerText = '전화번호를 입력해주세요.'
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

            if(el.getAttribute('id') === 'reserve_regist_1'){
                pop.open('reserveCalendarPop11');
                document.getElementById('notice_check').setAttribute('data-notice','N');
            }else{
                pop.open('reserveCalendarPop11');
                document.getElementById('notice_check').setAttribute('data-notice','Y');
            }

        })
    })

}
function reserve_regist(artist_id,session_id,yesterday){

    const shop_name = data.shop_name;
    const login = artist_id;
    const session = session_id;
    let cellphone_input = document.getElementById('reserve_cellphone');
    let name_input = document.getElementById('reserve_name');
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

    //dog
    let size_input = document.querySelector('input[name="size"]:checked');
    let service_input = document.querySelector('input[name="s1"]:checked');
    let weight_input = document.querySelector('input[name="s2"]:checked');
    let hair_feature_input = document.querySelectorAll('input[name="hair"]:checked');
    let hair_length_input = document.querySelector('input[name="hairBeauty"]:checked');

    let face_input = document.querySelectorAll('input[name="f1"]:checked');
    let leg_input = document.querySelectorAll('input[name="f2"]:checked');
    let spa_input = document.querySelectorAll('input[name="f3"]:checked');
    let dyeing_input = document.querySelectorAll('input[name="f4"]:checked');
    let etc_input = document.querySelectorAll('input[name="f5"]:checked');


    //cat
    let beauty_input = document.querySelector('input[name="beauty"]:checked');
    let bath_input = document.querySelector('input[name="beauty"]:checked');

    let add_svc_input = document.querySelectorAll('input[name="add_svc"]:checked');




    //부가세
    let is_vat = document.getElementById('is_vat').value;



    //------------------------------------------

    let cellphone = cellphone_input.value;
    let name = name_input.value;
    let breed_select = breed_select_input.value === '기타' ? breed_other_input.value : breed_select_input.value;
    let breed = breed_input === null ? '': breed_input.value;
    let pet_year = document.getElementById('birthday_year').value;
    let pet_month = document.getElementById('birthday_month').value;
    let pet_date = document.getElementById('birthday_date').value;
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


let size,service,weight_merchandise,hair_feature,hair_length;
let weight_price,hair_length_price;
let beauty,bath,add_svc;

    if(breed === "dog"){

        size = size_input === null ? '' : size_input.value;
        service = service_input === null ? '' : service_input.value;
        weight_merchandise = weight_input === null ? '' : weight_input.value;
        hair_feature = hair_feature_input === null ? '' :hair_feature_input.value;
        hair_length = hair_length_input === null ? '' : hair_length_input.value;


        weight_price = weight_input === null ? '' : weight_input.getAttribute('data-price');
        hair_length_price = hair_length_input === null ? '' : hair_length_input.getAttribute('data-price');
    }else{

        beauty = beauty_input === null ? '' : beauty_input.value;
        bath = bath_input === null ? '' : bath_input.value;

    }


    let arr_add_svc = [];

    for(let i=0; i<add_svc_input.length;i++){

        arr_add_svc.push(`${add_svc_input[i].value}:${add_svc_input[i].getAttribute('data-price')}`)
    }

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


    let arr_hair_feature = [];
    for(let i=0; i<hair_feature_input.length;i++){

        arr_hair_feature.push(`${hair_feature_input[i].value}:${hair_feature_input[i].getAttribute('data-price')}`)
    }

    let arr_face = [];
    for(let i=0; i<face_input.length;i++){

        arr_face.push(`${face_input[i].value}:${face_input[i].getAttribute('data-price')}`);
    }

    let arr_leg = [];
    for(let i=0; i<leg_input.length;i++){

        arr_leg.push(`${leg_input[i].value}:${leg_input[i].getAttribute('data-price')}`);
    }

    let arr_spa = [];
    for(let i=0; i<spa_input.length;i++){
        arr_spa.push(`${spa_input[i].value}:${spa_input[i].getAttribute('data-price')}`);
    }

    let arr_dyeing = [];
    for(let i=0; i<dyeing_input.length;i++){
        arr_dyeing.push(`${dyeing_input[i].value}:${dyeing_input[i].getAttribute('data-price')}`);
    }

    let arr_etc = [];

    for(let i=0; i<etc_input.length;i++){

        arr_etc.push(`${etc_input[i].value}:${etc_input[i].getAttribute('data-price')}`);
    }



    let total_price =0 ;

    Array.from(document.getElementsByClassName('list-data')).forEach(function(el){

        if(el.getAttribute('data-price') === null || el.getAttribute('data-price') === undefined || el.getAttribute('data-price') === ''){


            total_price += 0;
        }else if(el.getAttribute('data-price') === 'surcharge'){

            total_price += parseInt(localStorage.getItem('surcharge_std_price'))+ (parseInt(document.getElementById('weight_target').value)-parseInt(localStorage.getItem('surcharge_kg')))*parseInt(localStorage.getItem('surcharge_price'))

        }else {
            total_price += parseInt(el.getAttribute('data-price'));

        }
    })



    let target = document.getElementById('reserveCalendarPop2');
    let pay_data;

    if(breed === 'dog'){
        pay_data = {
            shopName:shop_name,
            cellphone:cellphone,
            worker:target.getAttribute('data-name'),
            workTime:`${target.getAttribute('data-hour')}:${target.getAttribute('data-minutes')}`,
            workDate : `${target.getAttribute('data-year')}-${fill_zero(parseInt(target.getAttribute('data-month'))+1)}-${fill_zero(target.getAttribute('data-date'))}`,
            customer_id: "",
            coupon_seq:"",
            alarm_yn : document.getElementById('notice_check').getAttribute('data-notice'),
            befor_day_alarm_yn : yesterday ? 'Y' : 'N',
            backurl:"",
            pet_no : "",
            pet_name : name,
            pet_kind : breed,
            pet_type : breed_select,
            pet_type2 : "",
            pet_year : pet_year,
            pet_month : pet_month,
            pet_day : pet_date,
            pet_gender_m : gender,
            neutral : neutral,
            pet_weight1 : weight,
            year : date.getFullYear(),
            month : date.getMonth()+1,
            day :date.getDate(),
            from_time:new Date(date.getFullYear(),date.getMonth(),date.getDate(),document.getElementById('reserve_st_time').value.split(':')[0],document.getElementById('reserve_st_time').value.split(':')[1]).getTime(),
            to_time: new Date(date.getFullYear(),date.getMonth(),date.getDate(),document.getElementById('reserve_fi_time').value.split(':')[0],document.getElementById('reserve_fi_time').value.split(':')[1]).getTime(),
            coupon_balance : "",
            size : size,
            service : service,
            weight:`${weight}:${weight_price}`,
            hair_type:arr_hair_feature,
            hair_length:`${hair_length}:${hair_length_price}`,
            face:arr_face,
            cat_weight:"",
            cat_bath : "",
        }
    }else{

        pay_data = {

            shopName:shop_name,
            cellphone:cellphone,
            worker:target.getAttribute('data-name'),
            workTime:`${target.getAttribute('data-hour')}:${target.getAttribute('data-minutes')}`,
            workDate : `${target.getAttribute('data-year')}-${fill_zero(parseInt(target.getAttribute('data-month'))+1)}-${fill_zero(target.getAttribute('data-date'))}`,
            customer_id: "",
            coupon_seq:"",
            alarm_yn : document.getElementById('notice_check').getAttribute('data-notice'),
            befor_day_alarm_yn : yesterday ? 'Y' : 'N',
            backurl:"",
            pet_no : "",
            pet_name : name,
            pet_kind : breed,
            pet_type : breed_select,
            pet_type2 : "",
            pet_year : pet_year,
            pet_month : pet_month,
            pet_day : pet_date,
            pet_gender_m : gender,
            neutral : neutral,
            pet_weight1 : weight,
            year : date.getFullYear(),
            month : date.getMonth()+1,
            day :date.getDate(),
            from_time:new Date(date.getFullYear(),date.getMonth(),date.getDate(),document.getElementById('reserve_st_time').value.split(':')[0],document.getElementById('reserve_st_time').value.split(':')[1]).getTime(),
            to_time: new Date(date.getFullYear(),date.getMonth(),date.getDate(),document.getElementById('reserve_fi_time').value.split(':')[0],document.getElementById('reserve_fi_time').value.split(':')[1]).getTime(),
            coupon_balance : "",
            size : '',
            service : '',
            weight:'',
            hair_type:'',
            hair_length:'',
            face:'',
            cat_weight:document.querySelector('input[name="beauty"]:checked').value, //수정필
            cat_bath :document.querySelector('input[name="bath"]:checked').value,
        }

    }

    let leg_opt ;
    let leg_opts = [];
    let leg_add_opts = [];
    if(breed === 'dog'){
        leg_opt = document.getElementById('other_leg').children;



        for(let i=0; i<3; i++){

            leg_opts.push(leg_opt[i].children[0].children[0].getAttribute('data-price'));
        }



        for(let i=0; i<document.querySelectorAll('input[name="f2"]').length;i++){

            if(document.querySelectorAll('input[name="f2"]')[i].checked && i >2){

                leg_add_opts.push(`${document.querySelectorAll('input[name="f2"]')[i].value}:${document.querySelectorAll('input[name="f2"]')[i].getAttribute('data-price')}`)

            }
        }
    }







    let product = '';

    if(breed ==='dog'){


            product += `${name}|${breed === 'dog' ? '개' : ''}|${shop_name}|${size}|${service}|${weight_merchandise}:${weight_price === null ? '0' : weight_price}|${arr_face.toString()}|${hair_length}:${hair_length_price === null ? '0' : hair_length_price}|${arr_hair_feature.toString()}|`;


        for(let i=0; i<3; i++){

            if(document.querySelectorAll('input[name="f2"]')[i].checked === true){
                product += `${document.querySelectorAll('input[name="f2"]')[i].getAttribute('data-price')}|`
            }else{
                product += `0|`
            }

        }

        product += `||`

        product += `${leg_add_opts.length}|`

        if(leg_add_opts.length > 0){
            leg_add_opts.forEach(function(el){

                product += `${el}|`
            })
        }

        if(spa_input.length > 0){

            product += `${spa_input.length}|`

            for(let i=0; i<spa_input.length; i++){

                product += `${spa_input[i].value}:${spa_input[i].getAttribute('data-price')}|`

            }
        }else{
            product += `0|`
        }

        if(dyeing_input.length > 0){

            product += `${dyeing_input.length}|`

            for(let i=0; i<dyeing_input.length; i++){
                product += `${dyeing_input[i].value}:${dyeing_input[i].getAttribute('data-price')}|`
            }
        }else{
            product += `0|`;
        }

        if(etc_input.length >0){

            product += `${etc_input.length}|`

            for(let i=0; i<etc_input.length; i++){

                product += `${etc_input[i].value}:${etc_input[i].getAttribute('data-price')}|`
            }
        }else{
            product += `0|`;
        }

        product += `0|0|`

    }else{

        product += `${name}|${breed === 'cat' ? '고양이': ''}|${shop_name}|${beauty}|${beauty}:${document.getElementById('service2_basic_beauty').getAttribute('data-price')}|`

        if(document.querySelectorAll('input[name="add_svc"]')[0].checked === true){

            product += `${document.querySelectorAll('input[name="add_svc"]')[0].getAttribute('data-price')}|`
        }else{
            product += `0|`
        }


        if(bath_input.getAttribute('data-price') === "" || bath_input.getAttribute('data-price') === undefined || bath_input.getAttribute('data-price') === null || bath_input.getAttribute('data-price') === '0'){

            product += `0|`;
        }else{


            product += `${bath_input.getAttribute('data-price')}|`
        }


        product += `0|`

        if(add_svc_input.length > 0){

            product += `${add_svc_input.length}|`

            for(let i=0; i<add_svc_input.length; i++){

                product += `${add_svc_input[i].value}:${add_svc_input[i].getAttribute('data-price')}|`
            }
        }else{
            product += `0|`
        }

        product += `0|0|`


    }
    //
    //
    //
    // console.log('---------------------')
    // console.log(`partner_id : ${login}`);
    // console.log(`wokrer : ${document.getElementById('reserveCalendarPop2').getAttribute('data-name')}`)
    // console.log(`customer_id : ${document.getElementById('customer_id').value}`)
    // console.log(`cellphone : ${cellphone}`)
    // console.log(`pet_seq : ${document.getElementById('pet_seq').value}`)
    // console.log(`animal : ${breed}`)
    // console.log(`pet_type:${breed_select}`)
    // console.log(`pet_name :${name}`)
    // console.log(`pet_year : ${pet_year}`);
    // console.log(`pet_month : ${pet_month}`)
    // console.log(`pet_day : ${pet_date}`)
    // console.log(`gender:${gender}`)
    // console.log(`neutral:${neutral}`)
    // console.log(`weight:${weight}`)
    // console.log(`beauty_exp:${beauty_exp}`)
    // console.log(`vaccination:${vaccination}`)
    // console.log(`luxation:${luxation}`)
    // console.log(`bite:${bite}`)
    // console.log(`dermatosis:${dermatosis}`)
    // console.log(`heart_trouble:${heart_trouble}`)
    // console.log(`marking:${marking}`)
    // console.log(`mounting:${mounting}`)
    // console.log(`year:${date.getFullYear()}`)
    // console.log(`month:${date.getMonth()+1}`)
    // console.log(`day:${date.getDate()}`)
    // console.log(`hour:${document.getElementById('reserve_st_time').value.split(':')[0]}`)
    // console.log(`min:${document.getElementById('reserve_st_time').value.split(':')[1]}`)
    // console.log(`session_id:${session}`)
    // console.log(`order_id:''`)
    // console.log(`local_price:${total_price}`)
    // console.log(`pay_type:'pos-card'`)
    // console.log(`pay_status:'pos'`)
    // console.log(`pay_data : ${JSON.stringify(pay_data)}`)
    // console.log(`to_hour :${document.getElementById('reserve_fi_time').value.split(':')[0]}`)
    // console.log(`to_min:${document.getElementById('reserve_fi_time').value.split(':')[1]}`)
    // console.log(`use_coupon_yn:'N'`)
    // console.log(`is_vat : ${is_vat}`)
    // console.log(`product : ${product}`)
    // console.log(`reserve_yn : ${document.getElementById('notice_check').getAttribute('data-notice')}`)
    // console.log(`aday_ago_yn :${yesterday ? 'Y':'N'}`)



    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'reserve_regist',
            partner_id : login,
            worker : document.getElementById('reserveCalendarPop2').getAttribute('data-name'),
            customer_id : document.getElementById('customer_id').value,
            cellphone : cellphone,
            pet_seq : document.getElementById('pet_seq').value, //수정필
            animal : breed,
            pet_type : breed_select,
            pet_name : name,
            pet_year : pet_year,
            pet_month: pet_month,
            pet_day : pet_date,
            gender:gender,
            neutral:neutral,
            weight:weight,
            beauty_exp:beauty_exp,
            vaccination:vaccination,
            luxation:luxation,
            bite:bite,
            dermatosis:dermatosis,
            heart_trouble:heart_trouble,
            marking:marking,
            mounting:mounting,
            year:date.getFullYear(),
            month:date.getMonth()+1,
            day:date.getDate(),
            hour:document.getElementById('reserve_st_time').value.split(':')[0],
            min:document.getElementById('reserve_st_time').value.split(':')[1],
            session_id:session,
            order_id:'',
            local_price:total_price,
            pay_type:'pos-card',
            pay_status:'pos',
            pay_data:JSON.stringify(pay_data),
            to_hour:document.getElementById('reserve_fi_time').value.split(':')[0],
            to_min:document.getElementById('reserve_fi_time').value.split(':')[1],
            use_coupon_yn:'N', // 수정필
            is_vat:is_vat,
            product:product,
            reserve_yn : document.getElementById('notice_check').getAttribute('data-notice') ,
            aday_ago_yn : yesterday ? 'Y' : 'N',



        },
        success:function(res){
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


function reserve_pop_init(id){

    let artist_id = id

    document.getElementById('reserveAcceptUser').innerHTML = `<input type="hidden" value="" id="customer_id">
    <input type="hidden" value="" id="pet_seq">
    <input type="hidden" value="" id="is_vat">
    <div class="layer-pop-parent">
        <div class="layer-pop-children">
            <div class="pop-data data-pop-view large">
                <div class="pop-header">
                    <h4 class="con-title">예약 접수</h4>
                </div>
                <div class="pop-body">
                    <div class="reserve-accept-wrap">
                        <div class="wide-tab">
                            <div class="wide-tab-inner"  id="wide-tab-inner">
                                <!-- 활성화시 actived클래스 추가 -->
                                <div class="tab-cell actived" id="exist_btn"><a href="#" class="btn-tab-item">기존 고객 예약</a></div>
                                <div class="tab-cell" id="new_btn"><a href="#" class="btn-tab-item">신규 고객 예약</a></div>
                            </div>
                        </div>
                        <div id="exist_user">
                            <div class="basic-data-group vmiddle" style="margin-top:28px !important">
                                <div class="basic-single-data">
                                    <div class="form-btns">
                                        <input type="text" id="reserve_search" placeholder="전화번호 및 펫이름 입력">
                                        <button type="button" id="reserve_search_btn" onclick="reserve_search_fam(artist_id)" class="btn-data-send btn-data-search"><span class="icon icon-size-24 icon-page-search">검색</span></button>
                                    </div>
                                </div>
                            </div>
                            <div class="basic-data-group large">
                                <!-- 검색결과 있을 때 -->
                                <div class="customer-card-list">
                                    <div class="grid-layout margin-8-12">
                                        <div class="grid-layout-inner" id="reserve_inner">

                                        </div>
                                    </div>
                                </div>
                                <!-- //검색결과 있을 때 -->
                                <!-- 검색결과 없을 때 -->
                                <div style="display:block;" id="common_none_data">
                                    <div class="common-none-data">
                                        <div class="none-inner">
                                            <div class="item-info">검색 결과가 없습니다.</span></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- //검색결과 없을 때 -->
                            </div>
                        </div>

                        <div id="new_user" style="display:none;">
                            <div class="basic-data-group middle" style="margin-top:32px !important;">
                                <div class="form-group">
                                    <div class="grid-layout margin-14-17">
                                        <div class="grid-layout-inner">
                                            <div class="grid-layout-cell grid-1">
                                                <div class="form-group-item">
                                                    <div class="form-group-item">
                                                        <div class="form-item-label">전화번호</div>
                                                        <div class="form-item-data">
                                                            <input type="text" maxlength="15" id="reserve_cellphone" class="form-control" value="">
                                                            <div class="form-input-info">'-' 없이 숫자만 입력</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="basic-data-group">
                                <div class="con-title-group">
                                    <h4 class="con-title">펫 정보<p class="title-need font-color-red">*필수사항만 입력해도 예약등록 가능</p></h4>
                                </div>
                                <div class="form-group">
                                    <div class="grid-layout margin-14-17">
                                        <div class="grid-layout-inner">
                                            <div class="grid-layout-cell grid-1">
                                                <div class="form-group-item">
                                                    <div class="form-item-label"><em class="need">*</em>펫 이름</div>
                                                    <div class="form-item-data">
                                                        <input type="text" class="form-control" value="" id="reserve_name" placeholder="펫 이름 입력">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-layout-cell grid-1">
                                                <div class="form-group-item">
                                                    <div class="form-item-label"><em class="need">*</em>품종</div>
                                                    <div class="form-item-data type-2">
                                                        <div class="pet-breed-select-wrap">
                                                            <div class="pet-breed-select">
                                                                <div class="breed-select">
                                                                    <label class="form-toggle-box" for="breed1"><input type="radio" name="breed" class="load-pet-type" value="dog" id="breed1"><em><span>강아지</span></em></label>
                                                                    <label class="form-toggle-box" for="breed2"><input type="radio" name="breed" class="load-pet-type" value="cat" id="breed2"><em><span>고양이</span></em></label>
                                                                </div>
                                                            </div>
                                                            <div class="pet-breed-sort">
                                                                <div style="display:block">
                                                                    <select id="breed_select">
                                                                        <option value="">선택</option>
                                                                    </select>
                                                                    <div class="pet-breed-other"  id="breed_other_box" style="display:none">
                                                                        <input type="text" placeholder="입력" id="breed_other" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">생일</div>
                                                    <div class="form-item-data type-2">
                                                        <div class="grid-layout margin-12">
                                                            <div class="grid-layout-inner">
                                                                <div class="grid-layout-cell grid-3">
                                                                    <select id="birthday_year" class="birthday">

                                                                    </select>
                                                                </div>
                                                                <div class="grid-layout-cell grid-3">
                                                                    <select id="birthday_month" class="birthday">

                                                                    </select>
                                                                </div>
                                                                <div class="grid-layout-cell grid-3">
                                                                    <select id="birthday_date">

                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">성별 선택</div>
                                                    <div class="form-item-data type-2">
                                                        <div class="grid-layout toggle-button-group">
                                                            <div class="grid-layout-inner">
                                                                <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="gender1"><input type="radio" name="gender" value="남아" id="gender1"><em>남아</em></label></div>
                                                                <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="gender2"><input type="radio" name="gender" value="여아" id="gender2"><em>여아</em></label></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">중성화</div>
                                                    <div class="form-item-data type-2">
                                                        <div class="grid-layout toggle-button-group">
                                                            <div class="grid-layout-inner">
                                                                <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="neutralize1"><input type="radio" name="neutralize" value="0" id="neutralize1"><em>X</em></label></div>
                                                                <div class="grid-layout-cell grid-2"><label class="form-toggle-box middle" for="neutralize2"><input type="radio" name="neutralize" value="1" id="neutralize2"><em>O</em></label></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label"><em class="need">*</em>몸무게</div>
                                                    <div class="form-item-data type-2">
                                                        <div class="form-flex">
                                                            <select class="inline-block" id="weight1">

                                                            </select>
                                                            <div class="form-unit-point">.</div>
                                                            <select class="inline-block" id="weight2">
                                                                <option value="0">0</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                                <option value="8">8</option>
                                                                <option value="9">9</option>
                                                            </select>
                                                            <div class="form-unit-label">kg</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">미용 경험</div>
                                                    <div class="form-item-data type-2">
                                                        <select id="beauty_exp">
                                                            <option value="0">선택</option>
                                                            <option value="없음">없음</option>
                                                            <option value="1회">1회</option>
                                                            <option value="2회">2회</option>
                                                            <option value="3회 이상">3회 이상</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">예방 접종</div>
                                                    <div class="form-item-data type-2">
                                                        <select id="vaccination">
                                                            <option value="0">선택</option>
                                                            <option value="2차 이하">2차 이하</option>
                                                            <option value="3차">3차 완료</option>
                                                            <option value="4차">4차 완료</option>
                                                            <option value="5차">5차 완료</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">입질</div>
                                                    <div class="form-item-data type-2">
                                                        <select id="bite">
                                                            <option value="0">선택</option>
                                                            <option value="안해요">안해요</option>
                                                            <option value="해요">해요</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">슬개골 탈구</div>
                                                    <div class="form-item-data type-2">
                                                        <select id="luxation">
                                                            <option value="0">선택</option>
                                                            <option value="없음">없음</option>
                                                            <option value="1기">1기</option>
                                                            <option value="2기">2기</option>
                                                            <option value="3기">3기</option>
                                                            <option value="4기">4기</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-layout-cell grid-1">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">특이사항</div>
                                                    <div class="form-item-data type-2">
                                                        <div class="grid-layout toggle-button-group">
                                                            <div class="grid-layout-inner">
                                                                <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="special1"><input type="checkbox" name="special" id="special1"><em>피부병</em></label></div>
                                                                <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="special2"><input type="checkbox" name="special" id="special2"><em>심장질환</em></label></div>
                                                                <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="special3"><input type="checkbox" name="special" id="special3"><em>마킹</em></label></div>
                                                                <div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle" for="special4"><input type="checkbox" name="special" id="special4"><em>마운팅</em></label></div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="basic-data-group">
                                <div class="con-title-group">
                                    <h4 class="con-title">예약 시간</h4>
                                </div>
                                <div class="form-group">
                                    <div class="grid-layout margin-14-17">
                                        <div class="grid-layout-inner">
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">날짜</div>
                                                    <div class="form-item-data type-2">
                                                        <div class="grid-layout margin-12">
                                                            <div class="grid-layout-inner">
                                                                <div class="grid-layout-cell grid-3">
                                                                    <select id="reserve_time_year" class="reserve-time">
                                                                    </select>
                                                                </div>
                                                                <div class="grid-layout-cell grid-3">
                                                                    <select id="reserve_time_month" class="reserve-time">
                                                                    </select>
                                                                </div>
                                                                <div class="grid-layout-cell grid-3">
                                                                    <select id="reserve_time_date">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">시간</div>
                                                    <div class="form-item-data type-2">
                                                        <div class="form-datepicker-group">
                                                            <div class="form-datepicker">
                                                                <select id="reserve_st_time">
                                                                </select>
                                                            </div>
                                                            <div class="form-unit">~</div>
                                                            <div class="form-datepicker">
                                                                <select id="reserve_fi_time">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="basic-data-group" id="service" style="display:none;">
                                <div class="con-title-group">
                                    <h4 class="con-title">예약 서비스 및 추가 특이사항 입력</h4>
                                </div>
                                <div class="form-group">
                                    <div class="wide-tab">
                                        <div class="wide-tab-inner" id="wide-tab-inner2">
                                            <!-- 활성화시 actived클래스 추가 -->
                                            <div class="tab-cell hit actived"><button type="button" class="btn-tab-item" id="basic_service_btn"><span>기본 서비스</span></button></div>
                                            <div class="tab-cell"><button type="button" class="btn-tab-item" id="other_service_btn"><span>추가</span></button></div>
                                        </div>
                                    </div>
                                    <div class="basic-data-group vvsmall3 tab-data-group">
                                        <!-- tab-data-cell 클래스에 actived클래스 추가시 활성화-->
                                        <!-- 기본 서비스 -->
                                        <div class="tab-data-cell actived" id="basic_service">
                                            <div class="grid-layout basic">
                                                <div class="grid-layout-inner" id="basic_service_inner">




                                                </div>
                                            </div>
                                        </div>
                                        <!-- //기본 서비스 -->
                                        <!-- 추가 -->
                                        <div class="tab-data-cell" id="other_service">
                                            <div class="grid-layout basic">
                                                <div class="grid-layout-inner" id="other_service_inner">





                                                </div>
                                            </div>
                                        </div>
                                        <!-- //추가 -->
                                    </div>
                                </div>
                            </div>
                            <div class="basic-data-group vmiddle" id="service2" style="display:none;">
                                <div class="service-selected-wrap">
                                    <div class="service-selected-group">
                                        <h5 class="con-title">서비스 선택 내역</h5>
                                        <div class="service-selected-list" id="service2_basic_list">
                                            <div class="service-selected-list-cell">
                                                <div class="list-data" id="service2_basic_size"></div>
                                            </div>
                                            <div class="service-selected-list-cell">
                                                <div class="list-data"  id="service2_basic_service"></div>
                                            </div>
                                            <div class="service-selected-list-cell">
                                                <div class="list-data"  id="service2_basic_weight"></div>
                                            </div>
                                            <div class="service-selected-list-cell" id="service2_basic_hair_feature">
                                                <div class="list-data" ></div>
                                            </div>
                                            <div class="service-selected-list-cell">
                                                <div class="list-data"  id="service2_basic_hair_length"></div>
                                            </div>

                                            <div class="service-selected-list-cell">
                                                <div class="list-data"  id="service2_basic_beauty"></div>
                                            </div>
                                            <div class="service-selected-list-cell">
                                                <div class="list-data"  id="service2_basic_hair_bath"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="service-selected-group add">
                                        <h5 class="con-title">추가 선택 내역</h5>
                                        <div class="service-selected-list" id="service2_other_list">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pop-footer line" id="reserve_footer" style="display:none;">
                    <div class="grid-layout btn-grid-group">
                        <div class="grid-layout-inner">
                            <div class="grid-layout-cell grid-2 reserve_regist_btn" id="reserve_regist_1"><a href="#" class="btn btn-outline-purple"><strong>알림없이 등록</strong></a></div>
                            <div class="grid-layout-cell grid-2 reserve_regist_btn" id="reserve_regist_2"><a href="#" class="btn btn-outline-purple"><strong>등록</strong></a></div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-pop-close" onclick="pop.close(); reserve_pop_init();">닫기</button>
            </div>
        </div>
    </div>`
    wide_tab();
    wide_tab_2();

    reserve_toggle();
    reserve_regist_tab();
    setInputFilter(document.getElementById("reserve_cellphone"), function(value) {
        return /^\d*\.?\d*$/.test(value);
    })

    input_enter('reserve_search','reserve_search_btn');

    customer_new_birthday().then(function(){ customer_new_birthday_date()})
    customer_pet_type();
    customer_new_weight()
    reserve_merchandise_load_event(artist_id)
    reserve_regist_event(artist_id,session_id);
    reserve_time().then(function (){reserve_time_date()});
    reserve_time_init()


}
function exist_user_reserve(id,cellphone){



        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:'pet_list',
                login_id:id,
                cellphone:cellphone,
            },
            success:function(res){
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {
                    console.log(body);

                    document.getElementById('reserve_cellphone').value = cellphone;
                    if(body.length === undefined){
                        body = [body];
                    }
                    if(body.length > 0){
                        document.getElementById('select_pet_list').innerHTML = '';
                        document.getElementById('select_pet').style.display = 'block';
                        body.forEach(function(el){

                            document.getElementById('select_pet_list').innerHTML += `<div class="grid-layout-cell flex-auto">
                                                                                                <label class="form-toggle-box">
                                                                                                    <input name="pet_no" class="pet-no" type="radio"  value="${el.pet_seq}" onclick="exist_user_reserve_('${el.pet_seq}').then(function(body){exist_user_reserve_init(body)})">
                                                                                                    <em>${el.name}</em>
                                                                                                </label>
                                                                                            </div>`
                        })
                    }

                }
            }

        })

        document.getElementById('exist_user').style.display = 'none';

        document.getElementById('new_user').style.display = 'block';

        document.getElementById('reserve_footer').style.display = 'block';




}

function exist_user_reserve_(pet_seq){



    return new Promise(function(resolve){
        document.getElementById('reserve_cellphone').setAttribute('readonly',true);
        document.getElementById('special1').checked = false;
        document.getElementById('special2').checked = false;
        document.getElementById('special3').checked = false;
        document.getElementById('special4').checked = false;
        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:'pet_info',
                pet_seq : pet_seq,
            },
            success:function(res){
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {

                    document.getElementById('reserve_name').value = body.name;

                    if(body.type === 'dog'){

                        document.getElementById('breed1').click()


                    }else{

                        document.getElementById('breed2').click()
                    }





                    setTimeout(function(){

                        resolve(body);
                    },300)

                }
            }
        })
    })

}


function exist_user_reserve_init(body){


    for(let i =0; i<document.getElementById('breed_select').options.length; i++){

        if(document.getElementById('breed_select').options[i].value === body.pet_type){

            document.getElementById('breed_select').options[i].selected = true;
        }
    }


    for(let i=0; i<document.getElementById('birthday_year').options.length; i++){

        if(document.getElementById('birthday_year').options[i].value === body.year.toString()){
            document.getElementById('birthday_year').options[i].selected = true;
        }
    }


    for(let i=0; i<document.getElementById('birthday_month').options.length; i++){

        if(document.getElementById('birthday_month').options[i].value === fill_zero(body.month)){
            document.getElementById('birthday_month').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('birthday_date').options.length; i++){

        if(document.getElementById('birthday_date').options[i].value ===fill_zero(body.day.toString())){
            document.getElementById('birthday_date').options[i].selected = true;
        }
    }


    if(body.gender === "남아"){

        document.getElementById('gender1').checked = true;

    }else{

        document.getElementById('gender2').checked = true;
    }

    if(body.neutral === 0){

        document.getElementById('neutralize1').checked = true;
    }else{
        document.getElementById('neutralize2').checked = true;
    }


    for(let i=0; i<document.getElementById('weight1').options.length;i++){

        if(document.getElementById('weight1').options[i].value === body.weight.split('.')[0]){

            document.getElementById('weight1').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('weight2').options.length;i++){

        if(document.getElementById('weight2').options[i].value === body.weight.split('.')[1]){
            document.getElementById('weight2').options[i].selected = true;
        }
    }


    for(let i=0; i<document.getElementById('beauty_exp').options.length; i++){

        if(document.getElementById('beauty_exp').options[i].value === body.beauty_exp){

            document.getElementById('beauty_exp').options[i].selected =true;
        }
    }

    for(let i=0; i<document.getElementById('vaccination').options.length; i++ ){

        if(document.getElementById('vaccination').options[i].value === body.vaccination){
            document.getElementById('vaccination').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('bite').options.length; i++){

        if(document.getElementById('bite').options[i].value === body.bite){

            document.getElementById('bite').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('luxation').options.length; i++){

        if(document.getElementById('luxation').options[i].value === body.luxation){

            document.getElementById('luxation').options[i].selected = true;
        }
    }


    if(body.dermatosis === 1){

        document.getElementById('special1').checked = true;

    }

    if(body.heart_trouble === 1){

        document.getElementById('special2').checked = true;
    }

    if(body.marking === 1){

        document.getElementById('special3').checked = true;
    }

    if(body.mounting === 1){

        document.getElementById('special4').checked = true;
    }
}

function set_noshow(id){


    let payment_idx = localStorage.getItem('payment_idx');

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'set_noshow',
            partner_id:"",
            cellphone:"",
            payment_idx:payment_idx
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

}


function cancel_noshow(){


    let payment_idx = localStorage.getItem('payment_idx');

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'cancel_noshow',
            partner_id:"",
            cellphone:"",
            payment_idx:payment_idx
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

}

function pay_management_modify_pet(pet_seq){


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

                    console.log(body)
                    document.getElementById('customer_name').value = body.name;

                    if(body.type === 'dog'){


                        document.getElementById('breed1').click();
                    }else{
                        document.getElementById('breed2').click();

                    }

                    setTimeout(function(){

                        resolve(body);
                    },300)




                }
            }
        })

    })



}
function pay_management_modify_pet_(body){


    console.log(body);


    for(let i=0; i<document.getElementById('breed_select').options.length; i++){

        if(document.getElementById('breed_select').options[i].value === body.pet_type){

            document.getElementById('breed_select').options[i].selected = true;
        }
    }
    for(let i=0; i<document.getElementById('birthday_year').options.length; i++){

        if(document.getElementById('birthday_year').options[i].value === body.year.toString()){

            document.getElementById('birthday_year').options[i].selected = true;
        }
    }
    for(let i=0; i<document.getElementById('birthday_month').options.length; i++){

        if(document.getElementById('birthday_month').options[i].value === fill_zero(body.month)){

            document.getElementById('birthday_month').options[i].selected = true;
        }
    }
    for(let i=0; i<document.getElementById('birthday_date').options.length; i++){

        if(document.getElementById('birthday_date').options[i].value === fill_zero(body.day)){

            document.getElementById('birthday_date').options[i].selected = true;
        }
    }

    if(body.gender === '남아'){

        document.getElementById('gender1').checked = true;
    }else{
        document.getElementById('gender2').checked = true;

    }

    if(body.neutral === 0){

        document.getElementById('neutralize1').checked = true;
    }else{

        document.getElementById('neutralize2').checked = true;

    }


    for(let i=0; i<document.getElementById('weight1').options.length; i++){

        if(document.getElementById('weight1').options[i].value === body.weight.split('.')[0]){


            document.getElementById('weight1').options[i].selected = true;
        }
    }


    for(let i=0; i<document.getElementById('weight2').options.length; i++){

        if(document.getElementById('weight2').options[i].value === body.weight.split('.')[1]){


            document.getElementById('weight2').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('beauty_exp').options.length; i++){

        if(document.getElementById('beauty_exp').options[i].value === body.beauty_exp){

            document.getElementById('beauty_exp').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('vaccination').options.length; i++){

        if(document.getElementById('vaccination').options[i].value === body.vaccination){

            document.getElementById('vaccination').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('bite').options.length; i++){

        if(document.getElementById('bite').options[i].value === body.bite){

            document.getElementById('bite').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('luxation').options.length; i++){

        if(document.getElementById('luxation').options[i].value === body.luxation){

            document.getElementById('luxation').options[i].selected = true;
        }
    }

    if(body.dermatosis === 1){

        document.getElementById('special1').checked = true;

    }

    if(body.heart_trouble === 1){

        document.getElementById('special2').checked = true;
    }

    if(body.marking === 1){

        document.getElementById('special3').checked = true;
    }

    if(body.mounting === 1){

        document.getElementById('special4').checked = true;
    }

    document.getElementById('modify_pet_info_btn').addEventListener('click',function(){


        modify_pet_info(body)
    },{once:true})

    pop.open('petModifyPop');
}

function modify_pet_info(body){

    if(document.getElementById('customer_name').value === '' || document.getElementById('customer_name').value === null || document.getElementById('customer_name').value === undefined ){

        document.getElementById('msg1_txt').innerText = '펫 이름을 입력해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }



    if(document.querySelector('input[name="breed"]:checked') === null || document.querySelector('input[name="breed"]:checked') === undefined || document.querySelector('input[name="breed"]:checked') === ''){

        document.getElementById('msg1_txt').innerText = '품종을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }

    if(document.getElementById('breed_select').value === "선택" || document.getElementById('breed_select').value === ''){
        document.getElementById('msg1_txt').innerText = '품종을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;

    }
    if((document.getElementById('breed_select').value === "기타" || document.getElementById('breed_select').value === "") && document.getElementById('breed_other').value === ''){
        document.getElementById('msg1_txt').innerText = '품종을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;

    }

    if(document.getElementById('weight1').value === "0" && document.getElementById('weight2').value ==="0"){

        document.getElementById('msg1_txt').innerText = '몸무게를 입력해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }


    let breed = document.getElementById('breed_select').value === '기타' ? document.getElementById('breed_other').value : document.getElementById('breed_select').value;

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:"modify_pet_info",
            idx:body.pet_seq,
            name:document.getElementById('customer_name').value,
            type:document.querySelector('input[name="breed"]:checked').value,
            pet_type:breed,
            year:document.getElementById('birthday_year').value,
            month:document.getElementById('birthday_month').value,
            day:document.getElementById('birthday_date').value,
            gender:document.querySelector('input[name="gender"]:checked') === null ? '0' : document.querySelector('input[name="gender"]:checked').value,
            neutral:document.querySelector('input[name="neutralize"]:checked') === null ? '0' : document.querySelector('input[name="neutralize"]:checked').value,
            weight:`${document.getElementById('weight1').value}.${document.getElementById('weight2').value}`,
            beauty_exp : document.getElementById('beauty_exp').value,
            vaccination : document.getElementById('vaccination').value,
            luxation : document.getElementById('luxation').value,
            bite : document.getElementById('bite').value,
            dermatosis:document.getElementById('special1').checked === true ? 1:0,
            heart_trouble:document.getElementById('special2').checked === true ? 1:0,
            marking:document.getElementById('special3').checked === true ? 1:0,
            mounting:document.getElementById('special4').checked === true ? 1:0,
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

function customer_memo(){

    let scm_seq = document.getElementById('customer_memo').getAttribute('data-scm_seq');
    let memo = document.getElementById('customer_memo').value;



    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'put_customer_memo',
            idx:scm_seq,
            memo:memo,
        },
        success:function(res) {
            
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                console.log(body)

                document.getElementById('msg2_txt').innerText = '견주 메모가 변경되었습니다.'
                pop.open('reserveAcceptMsg2');
            }
        }
    })

}

function payment_memo(){

    let idx = localStorage.getItem('payment_idx');
    let memo = document.getElementById('payment_memo').value;

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'put_payment_memo',
            idx:idx,
            memo:memo,
        },
        success:function(res) {
            
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                console.log(body)

                document.getElementById('msg2_txt').innerText = '특이사항이 변경되었습니다.'
                pop.open('reserveAcceptMsg2');
            }
        }
    })

}

function reserve_cancel(bool){

    let idx = localStorage.getItem('payment_idx');

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'reserve_cancel',
            idx:idx

        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                location.reload();
            }
        }
    })
}


function set_change_time(bool){


    let idx = localStorage.getItem('payment_idx');

    let st_time = document.getElementById('start_time').value;
    let fi_time = document.getElementById('end_time').value;

    let notice = bool;

    $.ajax({


        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'change_time',
            idx:idx,
            st_time:st_time,
            fi_time:fi_time,


        },
        success:function(res) {
            
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                location.reload();
            }
        }
    })

}

function check_time(){


    let st_time = document.getElementById('start_time').value;
    let fi_time = document.getElementById('end_time').value;

    let st_time_ = new Date(date.getFullYear(),date.getMonth(),date.getDate(),st_time.substr(0,2),st_time.substr(2,2)).getTime();
    let fi_time_ = new Date(date.getFullYear(),date.getMonth(),date.getDate(),fi_time.substr(0,2),fi_time.substr(2,2)).getTime();

    if(st_time >= fi_time){
        document.getElementById('msg1_txt').innerText = '시간을 확인해주세요.'
        pop.open('reserveAcceptMsg1');
        return;

    }

    pop.open('only_change_time')
}

function beauty_gallery_add(id,pet_seq){



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
        formData.append('payment_log_seq',localStorage.getItem('payment_idx'));
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

function beauty_gallery_get(body_data){



    let _data = body_data[3]

    console.log(_data)


    return new Promise(function(resolve){

        let idx = localStorage.getItem('payment_idx');



        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{

                mode:'beauty_gal_get',
                idx:idx,
            },
            success:function(res) {
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {
                    console.log(body)
                    if(body.length === undefined){

                        body = [body];
                    }


                    let file_path = '';
                    if(body.length >0){
                        file_path = `https://image.banjjakpet.com${body[0].file_path}`
                         document.getElementById('beauty_img_target').setAttribute('src', file_path)
                    }else{

                        if(_data.type === 'dog'){
                            file_path = `/static/images/icon/icon-pup-select-off.png`
                            document.getElementById('beauty_img_target').setAttribute('src', file_path)
                        }else{
                            file_path = `/static/images/icon/icon-cat-select-off.png`
                            document.getElementById('beauty_img_target').setAttribute('src', file_path)
                        }

                    }


                    body.forEach(function(el){


                        document.getElementById('beauty_gal_wrap').innerHTML += `<div class="list-cell">
                                                                                <div class="picture-thumb-view">
                                                                                    <div class="picture-obj" onclick="show_image('https://image.banjjakpet.com${el.file_path}')"><img src="https://image.banjjakpet.com${el.file_path}" alt=""></div>
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
                    })

                    resolve();
                }
            }

        })
    })
}

function beauty_gallery_del(idx){


    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'beauty_gal_del',
            idx:idx
        },
        success:function(data){

            document.getElementById('msg2_txt').innerText = '삭제되었습니다.'
           pop.open('reserveAcceptMsg2');

        }
    })

}

function show_image(src){

    document.getElementById('show_image_wrap').setAttribute('src',src);

    pop.open('show_image');


}


function agree_birthday(){

    return new Promise(function(resolve){

        for(let i = 2000; i<=new Date().getFullYear(); i++){

            document.getElementById('agree_birthday_year').innerHTML += `<option value="${fill_zero(i)}" ${i===2022 ? 'selected':''}>${i}</option>`
        }


        for(let i = 1; i<=12; i++){
            document.getElementById('agree_birthday_month').innerHTML += `<option value="${fill_zero(i)}">${i}</option>`
        }

        resolve();
    })
}

function agree_birthday_date(){

    let year = document.getElementById('agree_birthday_year').value;
    let month = document.getElementById('agree_birthday_month').value;

    let date_length = new Date(year,month,0).getDate();
    document.getElementById('agree_birthday_date').innerHTML = '';
    for(let i = 1; i<=date_length; i++){
        document.getElementById('agree_birthday_date').innerHTML += `<option value="${fill_zero(i)}">${i}</option>`

    }

    Array.from(document.getElementsByClassName('agree_birthday')).forEach(function(el){

        el.addEventListener('change',function(){

            year = document.getElementById('agree_birthday_year').value;
            month = document.getElementById('agree_birthday_month').value;

            date_length = new Date(year,month,0).getDate();
            document.getElementById('agree_birthday_date').innerHTML = '';
            for(let i = 1; i<=date_length; i++){
                document.getElementById('agree_birthday_date').innerHTML += `<option value="${i}">${i}</option>`

            }
        })
    })
}

function agree_pet_type(){
    let breed_input;

    let breed;

    let breed_select = document.getElementById('agree_breed_select')

    breed_select.addEventListener('change',function(){
        if(breed_select.options[breed_select.selectedIndex].value === "기타"){

            document.getElementById('agree_breed_other_box').setAttribute('style','display:block');
        }else{
            document.getElementById('agree_breed_other_box').setAttribute('style','display:none');
        }

    })
    Array.from(document.getElementsByClassName('agree_load-pet-type')).forEach(function(el){


        el.addEventListener('click',function(){
            document.getElementById('agree_breed_other_box').setAttribute('style','display:none');
            breed_input = document.querySelector('input[name="agree_breed"]:checked');
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
                        document.getElementById('agree_breed_select').innerHTML = '<option value="선택">선택</option>';
                        body.forEach(function(el){


                            if(el.name !== "기타"){
                                document.getElementById('agree_breed_select').innerHTML += `<option value="${el.name}">${el.name}</option>`
                            }


                        })

                        document.getElementById('agree_breed_select').innerHTML += '<option value="기타">기타</option>';




                    }


                }
            })





        })
    })
}

function beauty_agree_init(data){


    return new Promise(function(resolve){




        document.getElementById('agree_cellphone').value = data.cell_phone;

        if(data.type==='dog'){

            document.getElementById('agree_breed1').click();
        }else{

            document.getElementById('agree_breed2').click();
        }

        setTimeout(function(){

            resolve(data)
        },300);








   })


}

function beauty_agree_init_(_data){

    console.log(_data)
    document.getElementById('agree_date').innerText = `${new Date().getFullYear()}.${fill_zero(new Date().getMonth()+1)}.${fill_zero(new Date().getDate())}`

    document.getElementById('agree_name').addEventListener('change',function(){

        document.getElementById('agree_name2').innerText = document.getElementById('agree_name').value;
    })


    document.getElementById('agree_info').innerText = `${data.shop_name}은(는) 미용요청견(묘)의 나이가 10세 이상인 노령견(묘)이나, 질병이 있는 경우 건강상태를 고려하여 안내사항을 말씀드리고, 미용 동의서를 받고자 합니다.`


    for(let i=0; i<document.getElementById('agree_breed_select').options.length; i++){

        if(document.getElementById('agree_breed_select').options[i].value === _data.pet_type){

            document.getElementById('agree_breed_select').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('agree_birthday_year').options.length; i++){

        if(document.getElementById('agree_birthday_year').options[i].value === _data.birth.split('-')[0]){

            document.getElementById('agree_birthday_year').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('agree_birthday_month').options.length; i++){

        if(document.getElementById('agree_birthday_month').options[i].value === _data.birth.split('-')[1]){

            document.getElementById('agree_birthday_month').options[i].selected = true;
        }
    }    for(let i=0; i<document.getElementById('agree_birthday_date').options.length; i++){

        if(document.getElementById('agree_birthday_date').options[i].value === _data.birth.split('-')[2]){

            document.getElementById('agree_birthday_date').options[i].selected = true;
        }
    }

    if(_data.gender === '남아'){

        document.getElementById('agree_gender1').checked = true;
    }else{

        document.getElementById('agree_gender2').checked = true;
    }


    if(_data.neutral === 0){

        document.getElementById('agree_neutralize1').checked = true;
    }else{

        document.getElementById('agree_neutralize2').checked=true;
    }



    for(let i=0; i<document.getElementById('agree_vaccination').options.length; i++){

        if(document.getElementById('agree_vaccination').options[i].value === _data.vaccination){

            document.getElementById('agree_vaccination').options[i].selected = true;
        }
    }

    if(_data.heart_trouble === 1){

        document.getElementById('disease2').checked = true;
    }

    if(_data.dermatosis === 1){

        document.getElementById('disease3').checked =true;
    }

    if(_data.bite == 1 || _data.bite === "해요"){

        document.getElementById('agree_special1').checked =true;
    }

    if(_data.marking === 1){

        document.getElementById('agree_special2').checked = true;
    }

    if(_data.mounting === 1){

        document.getElementById('agree_special3').checked = true;
    }

    for (let i =0; i<document.getElementById('agree_luxation').options.length; i++){

        if(document.getElementById('agree_luxation').options[i].value === _data.luxation){

            document.getElementById('agree_luxation').options[i].selected = true;
        }
    }


    document.getElementById('beauty_agree_footer').innerHTML =`<a href="#" class="btn-page-bottom" onClick="beauty_agree_submit(artist_id,${_data.pet_seq})">저장</a>`


    pop.open('beautyAgreeWritePop');

}

function disease_etc(){

    if(document.getElementById('disease_textarea').style.display === 'none'){

        document.getElementById('disease_textarea').style.display = 'block';
    }else{
        document.getElementById('disease_textarea').style.display = 'none';
    }


}


function beauty_agree_checkbox(element){

    let id= element.getAttribute('id');


    if( id === 'beauty_agree_all_btn' ){

        if(element.checked === true){
            element.checked =true;
            document.getElementById('beauty_agree_1_btn').checked = true;
            document.getElementById('beauty_agree_2_btn').checked = true;

        }else{

            document.getElementById('beauty_agree_all_btn').checked = false;
            document.getElementById('beauty_agree_1_btn').checked = false;
            document.getElementById('beauty_agree_2_btn').checked = false;
        }
    }else if( id === 'beauty_agree_1_btn'){

        if(element.checked === true){

            element.checked = true;
        }else{
            element.checked = false;
        }
    }else if( id=== 'beauty_agree_2_btn'){

        if(element.checked === true){
            element.checked = true;
        }else{
            element.checked =false;
        }
    }
}


function download(dataURL, filename) {
    if (navigator.userAgent.indexOf("Safari") > -1 && navigator.userAgent.indexOf("Chrome") === -1) {

        var blob = dataURLToBlob(dataURL);
        var url = window.URL.createObjectURL(blob);

        var a = document.createElement("a");
        a.style = "display: none";
        a.href = url;
        a.download = filename;

        document.body.appendChild(a);
        a.click();

        window.URL.revokeObjectURL(url);
    }
}


function dataURLToBlob(dataURL) {
    var parts = dataURL.split(';base64,');
    var contentType = parts[0].split(":")[1];
    var raw = window.atob(parts[1]);
    var rawLength = raw.length;
    var uInt8Array = new Uint8Array(rawLength);

    for (var i = 0; i < rawLength; ++i) {
        uInt8Array[i] = raw.charCodeAt(i);
    }

    return new Blob([uInt8Array], { type: contentType });
}



function beauty_agree_submit(id,pet_seq){

    if(document.getElementById('agree_name').value === ''){

        document.getElementById('msg1_txt').innerText = '고객명을 입력해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }

    if(document.getElementById('agree_cellphone').value === ''){
        document.getElementById('msg1_txt').innerText = '전화번호를 입력해주세요.'
        pop.open('reserveAcceptMsg1');
        return;

    }

    if(document.querySelector('input[name="agree_breed"]:checked') === null){
        document.getElementById('msg1_txt').innerText = '품종을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;

    }

    if(document.getElementById('agree_breed_select').value === '선택'){

        document.getElementById('msg1_txt').innerText = '품종을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }

    if(document.getElementById('agree_breed_select').value ==='기타' && document.getElementById('agree_breed_other').value === ''){
        document.getElementById('msg1_txt').innerText = '품종을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;

    }

    if(document.getElementById('beauty_agree_1_btn').checked === false){

        document.getElementById('msg1_txt').innerText = '미용 동의서를 확인하고 동의해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }

    if(document.getElementById('beauty_agree_2_btn').checked === false){

        document.getElementById('msg1_txt').innerText = '개인정보 수집 및 허용을 \n 확인하고 동의해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }


    //
    // if(signature_pad.isEmpty()){
    //
    //     document.getElementById('msg1_txt').innerText = '서명을 작성해주세요.'
    //     pop.open('reserveAcceptMsg1');
    //     return;
    // }


    let data_url = signature_pad.toDataURL();
    let artist_id = id;

    let customer_id ='';

    if(document.getElementById('customer_id')) {

        customer_id = document.getElementById('customer_id').innerText;
    }

    let customer_name = document.getElementById('agree_name').value;
    let pet_idx = pet_seq;
    let cellphone = document.getElementById('agree_cellphone').value;
    let is_beauty_agree = "1";
    let is_private_agree = "1";
    let agree_type = "0";
    let mime = data_url.split(';')[0].split('/').at(-1);
    let image = data_url.split(',')[1]


    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'post_beauty_agree',
            partner_id:artist_id,
            customer_id:customer_id,
            customer_name:customer_name,
            pet_idx:pet_idx,
            phone:cellphone,
            is_beauty_agree:is_beauty_agree,
            is_private_agree:is_private_agree,
            agree_type : agree_type,
            auth_url:"",
            mime:mime,
            image:image

        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                document.getElementById('msg2_txt').innerText = '저장되었습니다.'
                pop.open('reserveAcceptMsg2');
                return;
            }
        }



    })



}

function reserve_change_time(){

    let idx = document.querySelector('input[name="log_seq"]').value;
    let st_time = document.querySelector('input[name="log_start_time"]').value.replace(':','');
    let fi_time = document.querySelector('input[name="log_end_time"]').value.replace(':','');
    let year = document.querySelector('input[name="log_year"]').value;
    let month = fill_zero(document.querySelector('input[name="log_month"]').value);
    let date = fill_zero(document.querySelector('input[name="log_date"]').value);
    let worker = document.querySelector('input[name="log_worker"]').value;



    $.ajax({


        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:"change_date_worker",
            idx:idx,
            st_date:`${year}${month}${date}`,
            fi_date:`${year}${month}${date}`,
            worker:worker,

        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                console.log(body);

                $.ajax({

                    url:'/data/pc_ajax.php',
                    type:'post',
                    data:{
                        mode:'change_time',
                        idx:idx,
                        st_time:st_time,
                        fi_time:fi_time,

                    },
                    success:function(res) {
                        
                        let response = JSON.parse(res);
                        let head = response.data.head;
                        let body = response.data.body;
                        if (head.code === 401) {
                            pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                        } else if (head.code === 200) {

                            localStorage.removeItem('payment_idx');
                            localStorage.removeItem('change_check');
                            localStorage.removeItem('change_check_worker');
                            document.getElementById('msg2_txt').innerText = '변경되었습니다.'
                            pop.open('reserveAcceptMsg2');
                            return;
                        }
                    }
                })


            }
        }


    })



}

// 이전 특이사항 툴팁
function tooltip(idx){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: "get_tooltip",
            payment_idx: idx,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            //
            let response = JSON.parse(res);
            //console.log(response);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                if(body && body.length>0){
                    var memo = '';
                    $.each(body, function(index,value){
                        memo += value.booking_date+'</br>';
                        memo += value.memo+'</br></br>';
                    })
                    memo_array.push(memo);
                }else{
                    memo_array.push('')
                }

            }
        }
    })
}

function change_check(){


    let worker = document.getElementById('change_check_worker_btn').getAttribute('data-worker');

    localStorage.setItem('change_check_worker',worker);
    localStorage.setItem('change_check','1');

    location.href = '/booking/reserve_beauty_week.php';

}

function guide_reserve_1(){

    return new Promise(function(resolve){

        Array.from(document.getElementsByClassName('header-worker')).forEach(function(el){


            if(el.getAttribute('data-worker') === localStorage.getItem('change_check_worker')){


                el.click();
            }
        })

        resolve();
    })




}

function guide_reserve(){


    guide_reserve_1().then(function(){


        Array.from(document.getElementsByClassName('calendar-week-time-item')).forEach(function(el){


            if(el.getAttribute('data-pay') === localStorage.getItem('payment_idx')){


                el.style.border = 'red dotted'
            }


        })
    })

}

function management_wide_tab(){

    document.getElementById('manage_1_btn').addEventListener('click',function (){

            document.getElementById('manage_1').style.display = 'block';
            document.getElementById('manage_2').style.display = 'none';
            document.getElementById('data_col_right_1').style.display = 'block';
            document.getElementById('data_col_right_2').style.display = 'none';

    })


    document.getElementById('manage_2_btn').addEventListener('click',function (){


            document.getElementById('manage_1').style.display = 'none';
            document.getElementById('manage_2').style.display = 'block';
        document.getElementById('data_col_right_1').style.display = 'none';
        document.getElementById('data_col_right_2').style.display = 'block';
        }
    )
}

function management_wide_tab2(){

    Array.from(document.getElementsByClassName('btn-tab-item-add')).forEach(function(el){

        el.addEventListener('click',function (){


            console.log(1)
            Array.from(document.getElementsByClassName('btn-tab-item-add')).forEach(function(el_){

                el_.parentElement.classList.remove('actived');
            })

            el.parentElement.classList.add('actived');



            if(el.getAttribute('id') === 'basic_service_btn'){

                document.getElementById('basic_service').style.display = 'block';
                document.getElementById('other_service').style.display = 'none';
                document.getElementById('other2_service').style.display = 'none';
                document.getElementById('other3_service').style.display = 'none';


            }else if(el.getAttribute('id') === 'other_service_btn'){
                document.getElementById('basic_service').style.display = 'none';
                document.getElementById('other_service').style.display = 'block';
                document.getElementById('other2_service').style.display = 'none';
                document.getElementById('other3_service').style.display = 'none';

            }else if(el.getAttribute('id')==='other2_service_btn'){

                document.getElementById('basic_service').style.display = 'none';
                document.getElementById('other_service').style.display = 'none';
                document.getElementById('other2_service').style.display = 'block';
                document.getElementById('other3_service').style.display = 'none';
            }else if(el.getAttribute('id') === 'other3_service_btn'){

                document.getElementById('basic_service').style.display = 'none';
                document.getElementById('other_service').style.display = 'none';
                document.getElementById('other2_service').style.display = 'none';
                document.getElementById('other3_service').style.display = 'block';
            }
        })
    })
}
function management_service_1(id,data){

    // reserve_merchandise_load_init(id).then(function(body){
    //     reserve_merchandise_load(body).then(function(base_svc){
    //
    //         reserve_merchandise_load_2(base_svc).then(function (base_svc){
    //
    //             reserve_merchandise_load_3(base_svc)
    //
    //         })
    //     })
    // })

    return new Promise(function (resolve){

        console.log(data)

        let body = data[3];
        let type = body.type;

        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:'merchandise',

                login_id:id,
                animal:type,
            },
            success:function (res){
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {
                    localStorage.setItem('is_vat',body.is_vat === 0 ? '0':'1')

                    let service = document.getElementById('service');
                    let service2 = document.getElementById('service2');
                    let basic_service_inner = document.getElementById('basic_service_inner');
                    let other_service_inner = document.getElementById('other_service_inner');
                    let other2_service_inner = document.getElementById('other2_service_inner');
                    let other3_service_inner = document.getElementById('other3_service_inner');


                    basic_service_inner.innerHTML = '';
                    other_service_inner.innerHTML ='';

                    if(type === 'dog'){

                        if(body.base_svc.length > 0){

                            basic_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">크기 선택</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="basic_size">
                                                                          <div class="toggle-button-cell" onclick="reserve_merchandise_load_reset(1); "><label class="form-toggle-box large"><input type="radio" value="" name="size" onclick="set_product2(this,'','','list_title_3',true)" checked><em>선택 안함</em></label></div>
                                                                     
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">서비스</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="basic_service_select">
                                                                              <div class="toggle-button-cell" onclick="reserve_merchandise_load_reset(2)"><label class="form-toggle-box large"><input type="radio" value="" name="s1" checked  onclick="set_product2(this,'','','list_title_3',true)"><em>선택 안함</em></label></div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="grid-layout-cell grid-5">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">무게</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="toggle-button-group vertical" id="basic_weight">
                                                                            <div class="toggle-button-cell" id="weight_not_select"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="s2" checked onclick="set_product2(this,'','','list_title_3',true)"><em><span>선택 안함</span></em></label></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>`
                        }


                        if(body.hair_feature.length > 0){


                            basic_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                        <div class="form-group-item">
                                                                            <div class="form-item-label">털특징</div>
                                                                            <div class="form-item-data type-2">
                                                                                <div class="toggle-button-group vertical" id="basic_hair_feature">
                                                                             </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>`
                        }

                        if(body.hair_length.length > 0){



                            basic_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">미용털길이</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="basic_hair_length">
                                                                            <div class="toggle-button-cell" ><label class="form-toggle-box large"><input type="radio" value="" name="hairBeauty" onclick="set_product2(this,'','','list_title_2',true)" checked ><em>선택 안함</em></label></div>
                                                                                </div>
                                                                        </div>
                                                                    </div>
                                                                </div>`

                        }

                        if(body.face.length > 0){

                            other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">얼굴컷</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="other_face">
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>`
                        }

                        if(body.leg.length > 0){

                            other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                        <div class="form-group-item">
                                                                            <div class="form-item-label">다리</div>
                                                                            <div class="form-item-data type-2">
                                                                                <div class="toggle-button-group vertical" id="other_leg">
                
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>`
                        }

                        if(body.spa.length > 0){

                            other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">스파</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="other_spa">
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>`
                        }

                        if(body.dyeing.length > 0){


                            other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">염색</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="other_dyeing">
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>`
                        }

                        if(body.etc.length > 0){

                            other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                        <div class="form-group-item">
                                                                            <div class="form-item-label">기타</div>
                                                                            <div class="form-item-data type-2">
                                                                                <div class="toggle-button-group vertical" id="other_etc">
                                                                                   
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>`

                        }
                    }else if(type === 'cat'){
                        if(body.beauty.length > 0){

                            basic_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                            <div class="form-group-item">
                                                                                <div class="form-item-label">미용</div>
                                                                                <div class="form-item-data type-2">
                                                                                    <div class="toggle-button-group vertical" id="basic_beauty">
                                                                                        <div class="toggle-button-cell" ><label class="form-toggle-box large"><input type="radio" value="" name="beauty" checked><em>선택 안함</em></label></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>`
                        }

                        if(body.bath.length > 0){


                            basic_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                            <div class="form-group-item">
                                                                                <div class="form-item-label">목욕</div>
                                                                                <div class="form-item-data type-2">
                                                                                    <div class="toggle-button-group vertical" id="basic_bath">
                                                                                        <div class="toggle-button-cell" ><label class="form-toggle-box large"><input type="radio" value="" name="bath" checked><em>선택 안함</em></label></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>`
                        }

                        if(body.add_svc.length > 0){


                            other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">추가서비스</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="other_add_svc">
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>`
                        }



                    }

                    resolve(body);

                }

            }
        })
    })

    
}


function management_service_2(body){

    return new Promise(function(resolve){

        document.getElementById('is_vat').value = body.is_vat;

        if(body.base_svc !== undefined){
            if(body.base_svc.length > 0){


                body.base_svc.forEach(function(el){

                    document.getElementById('basic_size').innerHTML += `<div class="toggle-button-cell toggle-button-cell-size">
                                                                                        <label class="form-toggle-box large">
                                                                                            <input type="radio" value="${el.size}" name="size">
                                                                                            <em>${el.size}</em>
                                                                                        </label>
                                                                                    </div>`

                })
            }

            if(body.hair_feature.length > 0){

                body.hair_feature.forEach(function(el,i){

                    if(el.price !== ''){

                        document.getElementById('basic_hair_feature').innerHTML += `<div class="toggle-button-cell">
                                                                                                    <label class="form-toggle-box form-toggle-price large" for="hair${i}">
                                                                                                        <input type="checkbox" name="hair" value="${el.type}" data-price="${el.price}" id="hair${i}" onclick="set_product(this,'${el.type}','${el.price.toLocaleString()}')">
                                                                                                        <em>
                                                                                                            <span>${el.type}</span>
                                                                                                            <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                                        </em>
                                                                                                    </label>
                                                                                                </div>`

                    }


                })
            }

            if(body.hair_length.length > 0){


                body.hair_length.forEach(function(el,i){

                    document.getElementById('basic_hair_length').innerHTML += `<div class="toggle-button-cell">
                                                                                            <label class="form-toggle-box form-toggle-price large" for="hairBeauty${i}">
                                                                                                <input type="radio" name="hairBeauty" value="${el.type}"  data-price="${el.price}" id="hairBeauty${i}" onclick="set_product2(this,'${el.type}','${el.price.toLocaleString()}','list_title_2',true)">
                                                                                                <em>
                                                                                                    <span>${el.type}</span>
                                                                                                    <strong>${parseInt(el.price).toLocaleString()}원</strong>
                                                                                                </em>
                                                                                            </label>
                                                                                        </div>`

                })
            }

            if(body.face.length >0){

                body.face.forEach(function(el,i){

                    document.getElementById('other_face').innerHTML += `<div class="toggle-button-cell">
                                                                                        <label class="form-toggle-box form-toggle-price middle">
                                                                                            <input type="checkbox" name="f1" data-price="${el.price}" value="${el.type}" onclick="set_product(this,'${el.type}','${el.price}')" >
                                                                                            <em>
                                                                                                <span>${el.type}</span>
                                                                                                <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                            </em>
                                                                                        </label>
                                                                                    </div>`

                })
            }


            if(body.leg.length>0){

                body.leg.forEach(function(el,i){

                    document.getElementById('other_leg').innerHTML += `<div class="toggle-button-cell">
                                                                                    <label class="form-toggle-box form-toggle-price middle">
                                                                                        <input type="checkbox" name="f2" value="${el.type}" data-price="${el.price}" onclick="set_product(this,'${el.type}','${el.price}')" >
                                                                                        <em>
                                                                                            <span>${el.type}</span>
                                                                                            <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                        </em>
                                                                                    </label>
                                                                                </div>`




                })
            }

            if(body.spa.length>0){

                body.spa.forEach(function(el,i){

                    document.getElementById('other_spa').innerHTML += `<div class="toggle-button-cell">
                                                                                    <label class="form-toggle-box form-toggle-price middle">
                                                                                        <input type="checkbox" name="f3"  value="${el.type}" data-price="${el.price}" onclick="set_product(this,'${el.type}','${el.price}')"> 
                                                                                        <em>
                                                                                            <span>${el.type}</span>
                                                                                            <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                        </em>
                                                                                    </label>
                                                                                </div>`

                })
            }

            if(body.dyeing.length >0 ){

                body.dyeing.forEach(function(el,i){

                    document.getElementById('other_dyeing').innerHTML += `<div class="toggle-button-cell">
                                                                                        <label class="form-toggle-box form-toggle-price middle">
                                                                                            <input type="checkbox" name="f4" value="${el.type}" data-price="${el.price}" onclick="set_product(this,'${el.type}','${el.price}')">
                                                                                            <em>
                                                                                                <span>${el.type}</span>
                                                                                                <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                            </em>
                                                                                        </label>
                                                                                    </div>`

                })
            }


            if(body.etc.length >0){

                body.etc.forEach(function(el,i){

                    document.getElementById('other_etc').innerHTML += `<div class="toggle-button-cell">
                                                                            <label class="form-toggle-box form-toggle-price middle">
                                                                                <input type="checkbox" name="f5" value="${el.type}" data-price="${el.price}" onclick="set_product(this,'${el.type}','${el.price}')">
                                                                                <em>
                                                                                    <span>${el.type}</span>
                                                                                    <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                               </em>
                                                                            </label>
                                                                        </div>`


                })


            }







        }else {


            if(body.beauty.length > 0){

                body.beauty.forEach(function(el){

                    document.getElementById('basic_beauty').innerHTML += `<div class="toggle-button-cell">
                                                                                        <label class="form-toggle-box large form-toggle-price">
                                                                                            <input type="radio" value="${el.type}" name="beauty" data-price="${el.price}" onclick="set_product(this,'${el.type}','${el.price}')">
                                                                                            <em> 
                                                                                                <span>${el.type}</span>
                                                                                                <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                            </em>
                                                                                        </label>
                                                                                    </div>`

                })
            }

            if(body.bath.length >0){

                body.bath.forEach(function(el){

                    document.getElementById('basic_bath').innerHTML += `<div class="toggle-button-cell">
                                                                                        <label class="form-toggle-box large form-toggle-price">
                                                                                            <input type="radio" value="${el.type}" name="bath" data-price="${el.price}" onclick="set_product(this,'${el.type}','${el.price}')">
                                                                                            <em> 
                                                                                                <span>${el.type}</span>
                                                                                                <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                            </em>
                                                                                        </label>
                                                                                    </div>`
                })
            }


            if(body.add_svc.length > 0 ){

                body.add_svc.forEach(function(el,i){

                    document.getElementById('other_add_svc').innerHTML += `<div class="toggle-button-cell">
                                                                            <label class="form-toggle-box form-toggle-price middle">
                                                                                <input type="checkbox" name="add_svc" value="${el.type}" data-price="${el.price}" onclick="set_product(this,'${el.type}','${el.price}')">
                                                                                <em>
                                                                                    <span>${el.type}</span>
                                                                                    <strong>+${parseInt(el.price).toLocaleString()}원</strong>
                                                                               </em>
                                                                            </label>
                                                                        </div>`


                })
            }


        }

        resolve(body.base_svc);
    })


}

function management_service_3(base_svc){
    console.log(base_svc);

    return new Promise(function (resolve){

        Array.from(document.getElementsByClassName('toggle-button-cell-size')).forEach(function(el){



            el.addEventListener('click',function(){

                console.log(1)

                document.getElementById('basic_service_select').innerHTML= '<div class="toggle-button-cell" onclick="reserve_merchandise_load_reset(2)"><label class="form-toggle-box large"><input type="radio" value="" name="s1" checked><em>선택 안함</em></label></div>';
                document.getElementById('basic_weight').innerHTML = '<div class="toggle-button-cell" id="weight_not_select"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="s2" checked><em><span>선택 안함</span></em></label></div>';
                let value = el.children[0].children[0].value;

                base_svc.forEach(function(el_){


                    if(value === el_.size){

                        el_.svc.forEach(function (_el){


                            if(_el.is_show === "y" && _el.unit.length >0){
                                document.getElementById('basic_service_select').innerHTML += `<div class="toggle-button-cell toggle-button-cell-service">
                                                                                                        <label class="form-toggle-box large">
                                                                                                            <input type="radio" value="${_el.type}" data-size="${el_.size}" data-time="${_el.time}" name="s1">
                                                                                                            <em>${_el.type} ${_el.time}분</em>
                                                                                                        </label>
                                                                                                    </div>`
                            }



                        })
                    }
                })
                management_service_4(base_svc);

                resolve(base_svc)
            })
        })


    })





}

function management_service_4(base_svc){



    Array.from(document.getElementsByClassName('toggle-button-cell-service')).forEach(function(el){

        el.addEventListener('click',function (){

            document.getElementById('basic_weight').innerHTML= '<div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" data-price="" name="s2"><em><span>선택 안함</span></em></label></div>'


            let size = el.children[0].children[0].getAttribute('data-size');
            let value = el.children[0].children[0].value;



            let surcharge ;
            base_svc.forEach(function(el_){


                if(el_.size === size){


                    el_.svc.forEach(function(_el){

                        if(_el.type === value){


                            if(_el.unit.length > 0){

                                _el.unit.forEach(function (ele,i){


                                    document.getElementById('basic_weight').innerHTML += `<div class="toggle-button-cell">
                                                                                                    <label class="form-toggle-box form-toggle-price large">
                                                                                                        <input type="radio" value="${ele.kg}" name="s2" data-price="${ele.price}" ${i ===  _el.unit.length-1 ? 'id="weight_target"':''}onclick="set_product2(this,'${document.querySelector('input[name="size"]:checked').value}/${document.querySelector('input[name="s1"]:checked').value}/${ele.kg}kg','${ele.price}','list_title_3',true)">
                                                                                                            <em>
                                                                                                                <span>~${ele.kg}Kg</span>
                                                                                                            <strong>${ele.is_consulting === "0" ? `${parseInt(ele.price).toLocaleString()}원` : '상담'}</strong>
                                                                                                            
                                                                                                        </em>
                                                                                                    </label>
                                                                                                </div>`


                                    if(el_.surcharge.is_have ===1 && i === _el.unit.length-1){


                                        let surcharge_kg = el_.surcharge.kg ;
                                        let surcharge_std_price = ele.kg === surcharge_kg ? ele.price : '';
                                        localStorage.setItem('surcharge_std_price',surcharge_std_price);
                                        localStorage.setItem('surcharge_kg',surcharge_kg);
                                        localStorage.setItem('surcharge_price',el_.surcharge.price);



                                        document.getElementById('basic_weight').innerHTML += `<div class="toggle-button-cell">
                                                                                                <div class="form-toggle-options">
                                                                                                    <input type="radio" name="s2" name="options1"  id="surcharge"  onclick="set_product2(this,'${document.querySelector('input[name="size"]:checked').value}/${document.querySelector('input[name="s1"]:checked').value}/${el_.surcharge.kg}kg','${el_.surcharge.price}','list_title_3',true)">
                                                                                                        <div class="form-toggle-options-data">
                                                                                                            <div class="options-labels">
                                                                                                                <span>${el_.surcharge.kg}kg~</span><strong style="font-size:10px">kg당 <br> +${parseInt(el_.surcharge.price).toLocaleString()}원</strong></div>
                                                                                                            <div class="form-amount-input">
                                                                                                                <button type="button" 
                                                                                                                        class="btn-form-amount-minus" id="surcharge" onclick="set_etc_product_count(this,'${document.querySelector('input[name="size"]:checked').value}/${document.querySelector('input[name="s1"]:checked').value}/${el_.surcharge.kg}kg','${el_.surcharge.price}',false)">감소
                                                                                                                </button>
                                                                                                                <div class="form-amount-info">
                                                                                                                    <input type="number" readOnly=""  value="10" data-weight="10kg+" id="weight_target"
                                                                                                                           class="form-amount-val">
                                                                                                                </div>
                                                                                                                <button type="button" 
                                                                                                                        class="btn-form-amount-plus" id="surcharge" onclick="set_etc_product_count(this,'${document.querySelector('input[name="size"]:checked').value}/${document.querySelector('input[name="s1"]:checked').value}/${el_.surcharge.kg}kg','${el_.surcharge.price}',true)">증가
                                                                                                                </button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                            </div>`


                                    }



                                })
                            }else{
                                document.getElementById('basic_weight').innerHTML = '<div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="s2"><em><span>선택 안함</span></em></label></div>';
                            }

                        }
                    })
                }
            })



            //
            // let st_time_input = document.getElementById('reserve_st_time');
            // let st_time = st_time_input.options[st_time_input.selectedIndex].value;
            // let fi_time_input = document.getElementById('reserve_fi_time');
            //
            // let selected = document.querySelector('input[name="s1"]:checked').getAttribute('data-time');
            //
            // let st_time_value = new Date(date.getFullYear(),date.getMonth(),date.getDate(),st_time.split(':')[0],st_time.split(':')[1]);
            //
            // st_time_value.setMinutes(st_time_value.getMinutes()+parseInt(selected));
            //
            // let fi_hour = st_time_value.getHours();
            // let fi_minutes = st_time_value.getMinutes();
            // let fi_time = `${fi_hour}:${fill_zero(fi_minutes)}`;
            //
            //
            //
            //
            //
            // for(let i=0; i<fi_time_input.options.length; i++){
            //
            //     if(fi_time_input.options[i].value === fi_time){
            //
            //         fi_time_input.options[i].selected = true;
            //
            //     }
            // }



        })
    })

}

function get_coupon(id){

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'get_coupon',
            partner_id:id
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
                console.log(body)

                body.forEach(function(el){

                    if(el.type === 'C'){

                        document.getElementById('c_coupon').innerHTML +=  `<div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical">
                                                                                <div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price middle" htmlFor="cp1-1">
                                                                                    <input type="checkbox" name="cp1" id="cp1-1" onclick="set_product(this,'${el.name}','${el.price}')"><em><span>${el.name}</span><strong>+${el.price.toLocaleString()}원</strong></em></label>
                                                                                </div>
                                                                            </div>
                                                                        </div>`
                    }else{

                        document.getElementById('f_coupon').innerHTML +=  `<div class="form-item-data type-2">
                                                                                <div class="toggle-button-group vertical">
                                                                                    <div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price middle" htmlFor="cp1-1">
                                                                                        <input type="checkbox" name="cp2" id="cp2-1" onclick="set_product(this,'${el.name}','${el.price}')"><em><span>${el.name}</span><strong>+${el.price.toLocaleString()}원</strong></em></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>`
                    }
                })
            }
        }

    })

}

function get_etc_product(id){

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'get_etc_product',
            partner_id:id,
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


                console.log(body);

                body.forEach(function(el){

                    switch (parseInt(el.type)){
                        
                        case 1: document.getElementById('etc_product_list_1').innerHTML += `<div class="toggle-button-cell">
                                                                                                <div class="form-toggle-options">
                                                                                                    <input type="checkbox" name="options1-1" onclick="set_product(this,'${el.name}','${el.price}')">
                                                                                                        <div class="form-toggle-options-data">
                                                                                                            <div class="options-labels"><span>${el.name}</span><strong>+${el.price === null ? '': el.price.toLocaleString()}원</strong></div>
                                                                                                            <div class="form-amount-input">
                                                                                                                <button type="button" class="btn-form-amount-minus" onclick="set_etc_product_count(this,'${el.name}','${el.price}',false)">감소</button>
                                                                                                                <div class="form-amount-info">
                                                                                                                    <input type="number" value="1" class="form-amount-val">
                                                                                                                </div>
                                                                                                                <button type="button" class="btn-form-amount-plus" onclick="set_etc_product_count(this,'${el.name}','${el.price}',true)">증가</button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                            </div>`
                            break;
                        case 2:  document.getElementById('etc_product_list_2').innerHTML += `<div class="toggle-button-cell">
                                                                                                <div class="form-toggle-options">
                                                                                                    <input type="checkbox" name="options2-1"  onclick="set_product(this,'${el.name}','${el.price}')">
                                                                                                        <div class="form-toggle-options-data">
                                                                                                            <div class="options-labels"><span>${el.name}</span><strong>+${el.price === null ? '': el.price.toLocaleString()}원</strong></div>
                                                                                                            <div class="form-amount-input">
                                                                                                                <button type="button" class="btn-form-amount-minus" onclick="set_etc_product_count(this,'${el.name}','${el.price}',false)">감소</button>
                                                                                                                <div class="form-amount-info">
                                                                                                                    <input type="number" value="1" class="form-amount-val">
                                                                                                                </div>
                                                                                                                <button type="button" class="btn-form-amount-plus" onclick="set_etc_product_count(this,'${el.name}','${el.price}',true)">증가</button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                            </div>`
                            break;
                        case 3:  document.getElementById('etc_product_list_3').innerHTML += `<div class="toggle-button-cell">
                                                                                                <div class="form-toggle-options">
                                                                                                    <input type="checkbox" name="options3-1"  onclick="set_product(this,'${el.name}','${el.price}')">
                                                                                                        <div class="form-toggle-options-data">
                                                                                                            <div class="options-labels"><span>${el.name}</span><strong>+${el.price === null ? '': el.price.toLocaleString()}원</strong></div>
                                                                                                            <div class="form-amount-input">
                                                                                                                <button type="button" class="btn-form-amount-minus" onclick="set_etc_product_count(this,'${el.name}','${el.price}',false)">감소</button>
                                                                                                                <div class="form-amount-info">
                                                                                                                    <input type="number" value="1" class="form-amount-val">
                                                                                                                </div>
                                                                                                                <button type="button" class="btn-form-amount-plus" onclick="set_etc_product_count(this,'${el.name}','${el.price}',true)">증가</button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                            </div>`
                            break;
                        case 4:  document.getElementById('etc_product_list_4').innerHTML += `<div class="toggle-button-cell">
                                                                                                <div class="form-toggle-options">
                                                                                                    <input type="checkbox" name="options4-1" onclick="set_product(this,'${el.name}','${el.price}')">
                                                                                                        <div class="form-toggle-options-data">
                                                                                                            <div class="options-labels"><span>${el.name}</span><strong>+${el.price === null ? '': el.price.toLocaleString()}원</strong></div>
                                                                                                            <div class="form-amount-input">
                                                                                                                <button type="button" class="btn-form-amount-minus" onclick="set_etc_product_count(this,'${el.name}','${el.price}',false)">감소</button>
                                                                                                                <div class="form-amount-info">
                                                                                                                    <input type="number" value="1" class="form-amount-val">
                                                                                                                </div>
                                                                                                                <button type="button" class="btn-form-amount-plus" onclick="set_etc_product_count(this,'${el.name}','${el.price}',true)">증가</button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                </div>
                                                                                            </div>`
                            break;


                    }
                })
            }
        }
    })
}

function set_product(target,name,price){

    name= name.trim()


    if(target.checked){

        document.getElementById('service_list').innerHTML += `<div class="list-cell">
                                                                        <div class="list-title list-title-add">${name}</div>
                                                                     <div class="list-value list-value-add">${price.toLocaleString()}원</div>
                                                                    </div>`
    }else{

        Array.from(document.getElementsByClassName('list-title-add')).forEach(function(el){

            if(el.innerText === name){
                el.parentElement.remove();
            }
        })
    }


}

function set_product2(target,name,price,className,bool){

    name = name.trim()
    if(!location.href.match('management')){

        return;
    }

    if(bool){

            Array.from(document.getElementsByClassName(className)).forEach(function(el){

                el.parentElement.remove();
            });
    }


    if(name !== ''){

        document.getElementById('service_list').innerHTML += `<div class="list-cell">
                                                                        <div class="list-title list-title-add ${className}">${name}</div>
                                                                     <div class="list-value list-value-add">${price.toLocaleString()}원</div>
                                                                    </div>`
    }





}


function set_etc_product_count(target,name,price,bool){



    name =name.trim();

    Array.from(document.getElementsByClassName('list-title-add')).forEach(function(el){




        if(el.innerText === name){

            if(bool){

                siblings(target,1).children[0].value = parseInt(siblings(target,1).children[0].value)+1;

                let value = siblings(target,1).children[0].value;

                if(target.getAttribute('id') === 'surcharge'){


                    siblings(el,1).innerText = `${((price*value)-(price*parseInt(document.getElementById('weight_target').value))+parseInt(document.getElementById('weight_target').getAttribute('data-price')))}원`
                }else{
                    siblings(el,1).innerText = `${(price*value)}원`;
                }



            }else{

                if(parseInt(siblings(target,1).children[0].value ) === 1){
                    return;
                }

                siblings(target,1).children[0].value = parseInt(siblings(target,1).children[0].value)-1;

                let value = siblings(target,1).children[0].value;

                if(target.getAttribute('id') === 'surcharge'){

                    siblings(el,1).innerText = `${((price*value)-(price*parseInt(document.getElementById('weight_target').value))+parseInt(document.getElementById('weight_target').getAttribute('data-price')))}원`
                }else{
                    siblings(el,1).innerText = `${(price*value)}원`;
                }
            }
        }
    })


}

function management_total_price(){

    if(localStorage.getItem('is_vat') === '1'){

        document.getElementById('price_list').innerHTML += `<div class="list-cell">
                                                                <div class="list-title"><strong>부가세 10%</strong></div>
                                                                <div class="list-value"><strong id="vat"></strong></div>
                                                            </div>`
    }

    let target = document.getElementById('service_list');

    let observer = new MutationObserver(function(mutations){

        mutations.forEach(function(mutation){
            console.log(mutation);

            let sum = 0;
            Array.from(document.getElementsByClassName('list-value-add')).forEach(function(el){

                console.log(parseInt(el.innerText.replace('원','')));
                sum += parseInt(el.innerText.replace('원',''));



            })

            document.getElementById('total_price').innerText = `${sum.toLocaleString()}원`
            document.getElementById('total_price').setAttribute('value', `${sum}`);
            document.getElementById('vat').innerText = `${(sum/10).toLocaleString()}원`
            document.getElementById('vat').setAttribute('value', `${sum/10}`);
            document.getElementById('real_total_price').innerText = `${(sum + (sum/10)).toLocaleString()}원`
            document.getElementById('real_total_price').setAttribute('value', `${sum+(sum/10)}`);

            last_price()

       })
    })

    let config = {
        attributes:true,
        childList:true,
        characterData:true,
        subtree:true
    }


    observer.observe(target,config);


}

function discount_init(){



    for(let i=0; i<=100;i++){

        document.getElementById('discount_1').innerHTML +=`<option value="${i}">${i}</option>`
    }


    for(let i=0; i<=50000; i+=100){

        document.getElementById('discount_2').innerHTML += `<option value="${i}">${i}</option>`
    }

    document.getElementById('discount_1_btn').addEventListener('click',function(){

        document.getElementById('discount_2').setAttribute('disabled','');
        document.getElementById('discount_1').removeAttribute('disabled');
    })

    document.getElementById('discount_2_btn').addEventListener('click',function(){

        document.getElementById('discount_1').setAttribute('disabled','');
        document.getElementById('discount_2').removeAttribute('disabled');


    })


    document.getElementById('discount_1').addEventListener('change',function(){

        if(document.getElementById('real_total_price').getAttribute('value') === null){

            document.getElementById('msg1_txt').innerText = '상품을 먼저 적용해주세요..'
            pop.open('reserveAcceptMsg1');
            return;
        }

        let result = (parseInt(document.getElementById('real_total_price').getAttribute('value'))*(parseInt(document.getElementById('discount_1').value)/100));

        Array.from(document.getElementsByClassName('discount_price')).forEach(function(el){

            el.innerText= `${Math.floor(result).toLocaleString()}원`
            el.setAttribute('value',`${Math.floor(result)}`)
            last_price()
        })

        pop.open('reservePayManagementMsg4')
    })

    document.getElementById('discount_2').addEventListener('change',function(){

        if(document.getElementById('real_total_price').getAttribute('value') === null){

            document.getElementById('msg1_txt').innerText = '상품을 먼저 적용해주세요..'
            pop.open('reserveAcceptMsg1');
            return;
        }

        let result = (parseInt(document.getElementById('discount_2').value));
        Array.from(document.getElementsByClassName('discount_price')).forEach(function(el){

            el.innerText= `${Math.floor(result).toLocaleString()}원`
            el.setAttribute('value',`${Math.floor(result)}`)
            last_price()
        })
        pop.open('reservePayManagementMsg4')
    })

    document.getElementById('discount_1_btn').click();


}


function reserves(id,body){

    let data =body[3];

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'reserves',
            partner_id:id,
            payment_idx:localStorage.getItem('payment_idx'),
            customer_id:data.customer_Id,
            tmp_user_idx : data.tmp_id,
            service : 'B',
            reserve_type : 'U',
        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {



                setInputFilter(document.getElementById("use_reserves"), function(value) {
                    return /^\d*\.?\d*$/.test(value);
                })

                Array.from(document.getElementsByClassName('now_reserves')).forEach(function(el){

                    el.innerText = `${(body.accum_reserve - body.use_reserve).toLocaleString()}원`
                    el.setAttribute('value',`${body.accum_reserve - body.use_reserve}`)
                })
            }
        }

    })


}

function reserves_set(){

    let now = parseInt(document.querySelector('.now_reserves').getAttribute('value'));

    let use = parseInt(document.getElementById('use_reserves').value);


    if (use === 0){

        document.getElementById('msg1_txt').innerText = '사용할 수 있는 적립금이 없습니다.'
        pop.open('reserveAcceptMsg1');
        return;
    }
    if (use>now){

        document.getElementById('msg1_txt').innerText = '적립금을 확인해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }


    Array.from(document.getElementsByClassName('reserves_use')).forEach(function(el){

        el.innerText = `${use.toLocaleString()}원`
        el.setAttribute('value',`${use}`);

    })
    last_price()
    pop.open('reservePayManagementMsg5')

}

function last_price(){

    let sum =  parseInt(document.getElementById('real_total_price').getAttribute('value')) ;
    let discount =  parseInt(document.querySelector('.discount_price').getAttribute('value'));
    let reserves =  parseInt(document.querySelector('.reserves_use').getAttribute('value'))


    document.getElementById('last_price').innerText = `${(sum-discount-reserves)}원`

    document.getElementById('last_card').value = `${(sum-discount-reserves)}`
    document.getElementById('last_cash').value =0;


}

function data_change(){

    let sum =  parseInt(document.getElementById('real_total_price').getAttribute('value')) ;
    let discount =  parseInt(document.querySelector('.discount_price').getAttribute('value'));
    let reserves =  parseInt(document.querySelector('.reserves_use').getAttribute('value'))

    if(document.getElementById('last_card').value == 0){

        document.getElementById('last_cash').value =0;
        document.getElementById('last_card').value =  `${(sum-discount-reserves)}`;

    }else if(document.getElementById('last_cash').value == 0){
        document.getElementById('last_cash').value = `${(sum-discount-reserves)}`;
        document.getElementById('last_card').value = 0;
    }

}

function waiting(id){

        $.ajax({
            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:'waiting',
                partner_id:id,
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
                    if(body.length > 0){

                        if(sessionStorage.getItem('waiting') !=='check'){
                            document.getElementById('a_cnt').innerText = `${body.length}`
                            pop.open('approveOnly');
                        }
                    }





                }
            }


        })


}




function set_approve(target,bool){

    let decision_code ;


    if(bool){
        decision_code = 2;
    }else{
        decision_code = 3;
    }
    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'put_waiting',
            approve_idx:target.getAttribute('data-approve'),
            decision_code :decision_code,
            payment_idx:localStorage.getItem('payment_idx'),

        },
        success:function(res){

            
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                if(bool){
                    document.getElementById('msg2_txt').innerText = '예약이 확정되었습니다.'
                }else{
                    document.getElementById('msg2_txt').innerText = '예약이 취소되었습니다.'
                }


                pop.open('reserveAcceptMsg2')



            }
        }
    })





}

function new_exist_check(id){

    document.getElementById('reserve_cellphone').addEventListener('focusout',function(){


        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:'search',
                login_id:id,
                search:document.getElementById('reserve_cellphone').value,
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
                    if(body.length > 0){

                        body.forEach(function(el){

                            if(el.cellphone === document.getElementById('reserve_cellphone').value){

                                document.getElementById('msg1_txt').innerText = '이 번호의 고객이 샵 이용 이력이 있습니다.\n 기존고객예약을 이용해주세요.'
                                pop.open('reserveAcceptMsg1');
                            }
                        })

                    }

                }
            }

        })
    })
}