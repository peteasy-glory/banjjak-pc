


//일간 예약관리 렌더
function schedule_render(id){

    $.ajax({

        url:'../data/pc_ajax.php',
        type:'post',
        data:{
            mode:'day_book',
            login_id:id,
            st_date:`${date.getFullYear()}-${fill_zero(date.getMonth()+1)}-${fill_zero(date.getDate())}`,
            fi_date:`${date.getFullYear()}-${fill_zero(date.getMonth()+1)}-${fill_zero(date.getDate()+1)}`,
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
                        body.forEach(function (el){


                            Array.from(document.getElementsByClassName('calendar-day-body-col')).forEach(function (el_){

                                if(el_.getAttribute('data-name') === el.product.worker && new Date(el_.getAttribute('data-year'),el_.getAttribute('data-month'),el_.getAttribute('data-date'),el_.getAttribute('data-hour'),el_.getAttribute('data-minutes')).getTime() === new Date(el.product.date.booking_st).getTime() ){
                                    switch(el.product.pay_type){

                                        case "pos-card" : case "pos-cash" : color = 'yellow'; break;
                                        case "offline-card" : case "offline-cash" : color = 'purple'; break;
                                        default : color = ''; break;

                                    }

                                    el_.setAttribute('data-pay',el.product.payment_idx)

                                    let multiple = (new Date(el.product.date.booking_fi).getTime() - new Date(el.product.date.booking_st).getTime())/1800000;
                                    el_.innerHTML = `<div class="calendar-drag-item-group">
                                                                        <a href="./reserve_pay_management_beauty_1.php" onclick="localStorage.setItem('payment_idx',${el_.getAttribute('data-pay')})" class="calendar-week-time-item toggle green ${color} ${el.product.is_no_show === 1 ? "red" : ''}" style="height: calc(100% * ${multiple}); ">
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

                            url:'../data/pc_ajax.php',
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


        }
    })
}


function reserve_schedule_week_cols(body,body_,parent,id){

    console.log(body)




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

                __el.innerHTML =`<div class="calendar-drag-item-group">
                                    <a href="#add" onclick="reserve_pop(this)" class="btn-calendar-add">등록하기</a>
                                    </div>`
            })
            el.classList.add('actived');

            body_.forEach(function(_el){


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





                        if(parseInt(el__.getAttribute('data-day')) === day && _booking_st === el__.getAttribute('data-time-to')){




                            el__.innerHTML = `<div class="calendar-drag-item-group">
                                                    <a href="#add" class="btn-calendar-add">등록하기</a>
                                                    <a href="#5" class="calendar-week-time-item toggle green ${color} ${_el.product.is_no_show === 1 ? "red" : ''}" style="height: calc(100% * ${multiple}); ">
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

            week_holiday(parent,id);
            reserve_prohibition_list(id);
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

    return work_day;




}


function week_holiday(parent,id){

    let body_col = document.getElementsByClassName('calendar-week-body-col-add');


    $.ajax({
        url:'../data/pc_ajax.php',
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
            }

        }
    })

}
function week_working(id){
    return new Promise(function (resolve){



        $.ajax({

            url:'../data/pc_ajax.php',
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


                    document.getElementById('grid_layout_inner').innerHTML+= `<div class="grid-layout-cell flex-auto"><button type="button" class="btn-toggle-button btn-toggle-basic"><span class="icon icon-plus-more-small"></span></button></div>`

                    resolve(body);
                }
            }
        })
    })
}

function week_timebar(body){
    let day_body = document.getElementById('day_body');

    let open = body[0].open_time;
    let close = body[0].close_time;


    let day_height = day_body.offsetHeight;

    let now_hour = new Date().getHours();
    let now_minutes = new Date().getMinutes();

    let work_time = (close - open) * 60;
    let division = day_height / work_time;
    let div_height = (((now_hour - open) * 60) + now_minutes) * division;

    if (open <= now_hour && now_hour < close) {
        day_body.innerHTML += `<div class="calendar-day-current-time" style="top:${div_height}px"><div class="bar"></div><div class="value">${fill_zero(date.getHours())}:${fill_zero(date.getMinutes())}</div></div>`
    }

}


function reserve_schedule_week(id,body_data) {

    return new Promise(function (resolve) {





    $.ajax({

        url: '../data/pc_ajax.php',
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
            let fi_date = `${date.getFullYear()}-${fill_zero(date.getMonth() + 1)}-${fill_zero(fi_target)}`

            $.ajax({

                url: '../data/pc_ajax.php',
                type: 'post',
                async:false,
                data: {

                    mode: 'week_book',
                    login_id: id,
                    st_date: st_date,
                    fi_date: fi_date
                },
                success: function (res) {
                    let response = JSON.parse(res);
                    let head = response.data.head;
                    let body_ = response.data.body;
                    if (head.code === 401) {
                        pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                    } else if (head.code === 200) {

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

                        document.getElementById('day_today').innerHTML = `${st_date.replaceAll('-', '.')} ~ ${fi_date.replaceAll('-', '.')}`
                        document.getElementById('day_total').innerHTML = `${body_.length}건`
                        document.getElementById('day_cancel').innerHTML = `${cancel}건`
                        document.getElementById('day_noshow').innerHTML = `${noshow}건`
                        document.getElementById('schedule_day').innerHTML = `${st_date.substring(5).replaceAll('-', '.')} ~ ${fi_date.substring(5).replaceAll('-', '.')}`
                        let days = [];

                        Array.from(document.querySelector('.week-check').children).forEach(function (el) {


                            if (el.classList.contains('before') || el.classList.contains('after')) {
                                days.push('');
                            } else {
                                days.push(el.children[0].children[0].children[0].children[0].innerText);
                            }


                        })

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
        url: '../data/pc_ajax.php',
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
            url: '../data/pc_ajax.php',
            data: {
                mode: 'month_book',
                login_id: id,
                year: date.getFullYear(),
                month: date.getMonth()+1,
            },
            type: 'POST',

            success: function (res) {
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {
                    list = body;

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

            url:'../data/pc_ajax.php',
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

            url:'../data/pc_ajax.php',
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
            }
        })
    })
}

//일간 예약관리 스케쥴 버튼 날짜변경
function btn_schedule(id){

    if(location.href.match('reserve_beauty_day') || location.href.match('reserve_beauty_list')){//여기수정해야함

        document.getElementById('btn-schedule-next').addEventListener('click',function(){
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


            if(select_low !== lows.length-1){


                lows[select_low+1].children[0].click();
                localStorage.setItem('select_row',select_low+1)
                select_low = parseInt(localStorage.getItem('select_row'));

            }



        })

        document.getElementById('btn-schedule-prev').addEventListener('click',function(){

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


        url:'../data/pc_ajax.php',
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
                    console.log('drag start');
                },
                onEnd : function(evt){
                    //드래그 끝
                    console.log('drag end');
                    //evt.to;    // 현재 아이템
                    //evt.from;  // 이전 아이템
                    //evt.oldIndex;  // 이전 인덱스값
                    //evt.newIndex;  // 새로운 인덱스값

                    if(evt.from != evt.to){
                        console.log($(evt.from).parent().attr("data-nick"));
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

                        $("#reserveCalendarPop4 .con-title").text(thisWorker);
                        $("#reserveCalendarPop4 .msg-text-date").text(am_pm_check2(`${thisYear}.${fill_zero(parseInt(thisMonth)+1)}.${fill_zero(thisDate)} ${fill_zero(thisHour)}:${fill_zero(thisMinutes)}`));

                        $("#reserveCalendarPop4 input[name='log_type']").val("week");
                        $("#reserveCalendarPop4 input[name='log_seq']").val(thisLogSeq);
                        $("#reserveCalendarPop4 input[name='log_worker']").val(thisWorker2);
                        $("#reserveCalendarPop4 input[name='log_date']").val(thisDate);
                        $("#reserveCalendarPop4 input[name='log_start_time']").val(thisTimeStart);
                        $("#reserveCalendarPop4 input[name='log_end_time']").val(thisTimeEnd);
                        $("#reserveCalendarPop4 input[name='log_move_start_time']").val(thisHour);

                        pop.open('reserveCalendarPop4');
                    }
                },
                onUpdate : function(evt){
                    console.log('update');
                },
                onUpdate : function(evt){
                    console.log('onChange');
                },
                onRemove: function (/**Event*/evt) {
                    console.log('remove');
                }

            });
        }
    });
}

function week_drag(){

    $('.calendar-week-body-col-add').each(function(){
        $(this).on('click',function(){

        })
        if(!$(this).hasClass('time')){
            //휴무가 아닐 경우 드래그앤 드롭 가능 처리
            var sortable = Sortable.create($(this).find('.calendar-drag-item-group')[0] , {
                group : 'shared',
                delay : 0,
                delayOnTouchOnly : true,
                ghostClass: 'guide',
                draggable : '.calendar-week-time-item',
                onStart : function(evt){
                    //드래그 시작
                    console.log('drag start');
                },
                onEnd : function(evt){
                    //드래그 끝
                    console.log('drag end');
                    //evt.to;    // 현재 아이템
                    //evt.from;  // 이전 아이템
                    //evt.oldIndex;  // 이전 인덱스값
                    //evt.newIndex;  // 새로운 인덱스값


                    if(evt.from != evt.to){

                        console.log(evt.from)
                        console.log(evt.to);


                        let thisWorker;
                        Array.from(document.getElementsByClassName('header-worker')).forEach(function (el){

                            if(el.classList.contains('actived')){

                                thisWorker = el.getAttribute('data-nick');
                            }
                        })
                        _thisYear = $(evt.from).parent().attr("data-year");
                        _thisMonth = $(evt.from).parent().attr("data-month")
                        _thisDate = $(evt.from).parent().attr("data-date");
                        _thisHour = $(evt.from).parent().attr("data-hour");
                        _thisMinutes = $(evt.from).parent().attr("data-minutes")
                        _thisTimeStart   = $(evt.from).parent().attr("data-time-to");
                        _thisTimeEnd   = $(evt.from).parent().attr("data-time-from");
                        // thisLogSeq = $(evt.from).parent().attr("data-pay");


                        thisYear = $(evt.to).parent().attr("data-year");
                        thisMonth = $(evt.to).parent().attr("data-month")
                        thisDate = $(evt.to).parent().attr("data-date");
                        thisHour = $(evt.to).parent().attr("data-hour");
                        thisMinutes = $(evt.to).parent().attr("data-minutes")
                        thisTimeStart   = $(evt.to).parent().attr("data-time-to");
                        thisTimeEnd   = $(evt.to).parent().attr("data-time-from");
                        // thisWorker2 = $(evt.to).parent().attr("data-name");

                        $("#reserveCalendarPop4 .con-title").text(thisWorker);
                        $("#reserveCalendarPop4 .msg-text-date").text(am_pm_check2(`${thisYear}.${fill_zero(parseInt(thisMonth)+1)}.${fill_zero(thisDate)} ${fill_zero(thisHour)}:${fill_zero(thisMinutes)}`));

                        $("#reserveCalendarPop4 input[name='log_type']").val("week");
                        // $("#reserveCalendarPop4 input[name='log_seq']").val(thisLogSeq);
                        $("#reserveCalendarPop4 input[name='log_worker']").val(thisWorker);
                        $("#reserveCalendarPop4 input[name='log_date']").val(thisDate);
                        $("#reserveCalendarPop4 input[name='log_start_time']").val(thisTimeStart);
                        $("#reserveCalendarPop4 input[name='log_end_time']").val(thisTimeEnd);
                        $("#reserveCalendarPop4 input[name='log_move_start_time']").val(thisHour);

                        pop.open('reserveCalendarPop4');

                    }
                },
                onUpdate : function(evt){
                    console.log('update');
                },
                onUpdate : function(evt){
                    console.log('onChange');
                },
                onRemove: function (/**Event*/evt) {
                    console.log('remove');
                }

            });
        }
    });

}



//작업결제관리 페이지
function pay_management(id){

    return new Promise(function (resolve){




    $.ajax({


        url:'../data/pc_ajax.php',
        type:'post',
        data:{

            mode:'pay_management',
            payment_idx:localStorage.getItem('payment_idx'),
        },
        success:function (res){
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            let body_ = [response.data2.body,response.data3.body]
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                console.log(body)
                let work_body_inner = document.getElementById('work_body_inner');
                let data_col_right = document.getElementById('data_col_right');

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

                work_body_inner.innerHTML = ''

                work_body_inner.innerHTML += `<div class="basic-data-group vsmall">
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
                                                                ${body.customer_Id === "" ? body.tmp_id : body.customer_Id}
                                                                <div class="user-grade-item">
                                                                    <div class="icon icon-grade-${body.grade_ord === 1 ? 'vip' : body.grade_ord === 2 ? 'normal' : 'normalb'}"></div>
                                                                    <div class="icon-grade-label">${body.grade_name}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="customer-user-info-ui">
                                                    
                                                        ${body.noshow_count > 0 ? `<div class="label label-outline-pink">NO SHOW ${body.noshow_count}회</div>`:''}
                                                        ${body.is_noshow === 0 ? `<a href="#" class="btn btn-inline btn-red">NO SHOW 등록</a>` : `<div class="btn btn-inline btn-red">NO SHOW</div>` }
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
                                                                    <div class="value">${body.cell_phone}</div>
                                                                </div>
                                                                <div class="item-sub-phone">
                                                                
                                                                    <div class="value">010-1234-1234</div>
                                                                    
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
                                                    <button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline">미용 갤러리</button>
                                                </div>
                                                <div class="btns-cell">
                                                    <button type="button" class="btn btn-outline-gray btn-vsmall-size btn-inline">미용 동의서 작성</button>
                                                </div>  
                                            </div>
                                        </div>
                                        <div class="customer-view-pet-info detail-toggle-parents">
                                            <div class="item-thumb">
                                                <div class="user-thumb large"><img src="${body.photo === "" ? body.type === "dog" ? '../static/images/icon/icon-pup-select-off.png' : '../static/images/icon/icon-cat-select-off.png' : `https://image.banjjakpet.com${body.photo}`}" alt=""></div>
                                                <div class="item-thumb-ui">
                                                    <a href="#" class="btn btn-outline-gray btn-vsmall-size btn-inline">펫 정보 수정</a>
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
                                                                        ${body.etc === "" ? '없음' : body.etc}
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
                                                                        ${body.dermatosis ? '피부병' : '' } ${body.heart_trouble ? '심장 질환' : ''} ${body.marking ? '마킹': ''} ${body.mounting ? '마운팅' : ''}
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
                                                                        <textarea style="height:60px;" placeholder="입력"></textarea>
                                                                        <button type="button" class="btn btn-outline-gray">저장</button>
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
                                                                            <textarea style="height:60px;" placeholder="입력"></textarea>
                                                                            <button type="button" class="btn btn-outline-gray">저장</button>
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
                                                </div>`

                
                
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
                                                                        <div class="item-data">${body.beauty_date}</div>
                                                                    </div>
                                                                    <div class="text-list-cell">
                                                                        <div class="item-title unit">선생님</div>
                                                                            <div class="item-data">${body.worker === id ? "실장" : body.worker}</div>
                                                                        </div>
                                                                        <div class="text-list-cell">
                                                                            <div class="item-title unit align-self-center">시간</div>
                                                                                <div class="item-data">
                                                                                    <div class="form-datepicker-group">
<!--                                                                                    이부분처리를 어떻게해야하지?-->
                                                                                        <div class="form-datepicker">
                                                                                            <select>
                                                                                                <option value="">오전 11:30</option>
                                                                                                <option value="">오전 11:30</option>
                                                                                                <option value="">오전 11:30</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="form-unit">~</div>
                                                                                            <div class="form-datepicker">
                                                                                                <select>
                                                                                                    <option value="">오후 11:30</option>
                                                                                                    <option value="">오후 11:30</option>
                                                                                                    <option value="">오후 11:30</option>
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="basic-data-group vsmall">
                                                                                <button type="button" class="btn btn-outline-gray btn-basic-full">시간만 변경</button>
                                                                            </div>
                                                                            <div class="form-bottom-info">
                                                                                <span>*시간 변경만 하는 경우 시간선택 후 변경을 눌러주세요.</span>
                                                                            </div>
                                                                        </div>
                                                                        <div class="basic-data-group small">
                                                                            <div class="grid-layout btn-grid-group">
                                                                                <div class="grid-layout-inner">
                                                                                    <div class="grid-layout-cell grid-2">
                                                                                        <button type="button" class="btn btn-purple">날짜/미용사 변경</button>
                                                                                    </div>
                                                                                    <div class="grid-layout-cell grid-2">
                                                                                        <button type="button" class="btn btn-outline-purple">예약 취소</button>
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

                resolve(body_);
            }

        }
    })
    })

}

function pay_management_(id){

    pay_management(id).then(function (body_){

        console.log(body_)
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

                if(date_today_reserve.getFullYear() === date.getFullYear()
                    && date_today_reserve.getMonth() === date.getMonth()
                    && date_today_reserve.getDate() === date.getDate()
                ){


                    reserve_list.innerHTML += `<div class="customer-card-list-cell">
                                                    <a href="../booking/reserve_pay_management_beauty_1.php" onclick="localStorage.setItem('payment_idx',${el.product.payment_idx})"  class="customer-card-item small transparent">
                                                        <div class="item-info-wrap">
                                                            <div class="item-thumb">
                                                                <div class="user-thumb small"><img src="${el.pet.photo !== null ? `https://image.banjjakpet.com${el.pet.photo}`  : `${el.pet.animal === 'dog' ? `../static/images/icon/icon-pup-select-off.png`: `../static/images/icon/icon-cat-select-off.png`}` }" alt=""></div>
                                                                <div class="item-kind">
                                                                    <span>${el.product.category_sub }</span>
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

    console.log(body)
    Array.from(document.getElementsByClassName('insert_data')).forEach(function(el){

        body.beauty.forEach(function(el_){

            let color;
            switch(el_.product.pay_type){

                case "pos-card": case "pos-cash" : color = 'yellow'; break;
                case "offline-card" : case "offline-cash" : color = 'purple'; break;
                default : color = ''; break;

            }

            let date_init = el_.product.date.booking_st.split(' ')[0].split('-');



            if(!el.parentElement.parentElement.classList.contains('before') && !el.parentElement.parentElement.classList.contains('after')){

                if(new Date(date_init[0],date_init[1]-1,date_init[2]).getTime() === new Date(el.getAttribute('data-year'),el.getAttribute('data-month'),el.getAttribute('data-date')).getTime()){

                    el.innerHTML += `<div class="calendar-drag-item"><a href="./reserve_pay_management_beauty_1.php" onclick="localStorage.setItem('payment_idx',${el_.product.payment_idx})" class="calendar-month-day-item ${color} ${el_.product.pay_type} ${el_.product.is_no_show === 1 ? "red" : ''} "><div class="calendar-month-day-item-name"><strong>${el_.pet.name}</strong><span>(${el_.pet.type})</span></div></a></div>`
                }
            }

        })


    })


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
        url:'../data/pc_ajax.php',
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

        }
    })

}


function btn_month_calendar(id){


    document.getElementById('btn-month-prev').addEventListener('click', function (evt) {


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

            url: '../data/pc_ajax.php',
            type: 'post',
            data: {
                mode: 'day_book',
                login_id: id,
                st_date: `${date.getFullYear()}-${fill_zero(date.getMonth() + 1)}-${fill_zero(date.getDate())}`,
                fi_date: `${date.getFullYear()}-${fill_zero(date.getMonth() + 1)}-${fill_zero(date.getDate() + 1)}`,
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


                    resolve(body);
                }

            }
        })

    })


}

function _schedule_render_list(body){


    console.log(body)


    let color;
    body.forEach(function (el){

        switch(el.product.pay_type){

            case "pos-card" : case "pos-cash" : color = 'yellow'; break;
            case "offline-card" : case "offline-cash" : color = 'purple'; break;
            default : color = ''; break;

        }

        Array.from(document.getElementsByClassName('reserve-calendar-list-data')).forEach(function (el_){

            if(el_.getAttribute(`id`).replaceAll('list-data-','') === el.product.worker){
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

        console.log(thisWorker);
        console.log(thisWorker2)

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


        url:'../data/pc_ajax.php',
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
            console.log(res)
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

function reserve_search(id){


    return new Promise(function(resolve){



        let search_value = document.getElementById('reserve_search').value.trim();

        $.ajax({

            url:'../data/pc_ajax.php',
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
                    console.log(body);

                    if(body.length === undefined){
                        body = [body];
                    }

                    if(body.length > 0 ){
                        document.getElementById('common_none_data').setAttribute('style','display:none');

                        document.getElementById('reserve_inner').innerHTML = '';
                        body.forEach(function(el,i){


                            document.getElementById('reserve_inner').innerHTML += `<div class="grid-layout-cell grid-2">
                                                                                            <a href="#" class="customer-card-item">
                                                                                                <div class="item-info-wrap">
                                                                                                    <div class="item-thumb">
                                                                                                        <div class="user-thumb large">
                                                                                                        <img src="${el.photo === "" ? el.type === 'dog' ? `../static/images/icon/icon-pup-select-off.png` : `../static/images/icon/icon-cat-select-off.png` : `https://image.banjjakpet.com${el.photo}`}" alt="">
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

function reserve_toggle(){

    document.getElementById('exist_btn').addEventListener('click',function(){

        document.getElementById('new_user').style.display = 'none';
        document.getElementById('exist_user').style.display = 'block'
    })

    document.getElementById('new_btn').addEventListener('click',function(){

        document.getElementById('exist_user').style.display = 'none';
        document.getElementById('new_user').style.display = 'block';
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

        url:'../data/pc_ajax.php',
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

        }
    })
}


function reserve_prohibition_delete(){

    let ph_seq = document.getElementById('reserveCalendarPop10').getAttribute('data-ph_seq');



    $.ajax({

        url:'../data/pc_ajax.php',
        type:'post',
        data:{
            mode:'delete_prohibition',
            ph_seq:ph_seq
        },
        success:function(res) {
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


        }

    })
}