
var memo_array = [];

//일간 예약관리 렌더
function schedule_render(id){
    memo_array = [];
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
            pay_management_toggle(true);
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
                let day_count = 0;
                console.log(body)

                let cancel = 0;
                let noshow = 0;

                body.forEach(function (el){

                    if(el.product.is_cancel === 1 ){
                        cancel ++;
                    }
                    if(el.product.is_no_show === 1){
                        noshow ++;
                    }

                    if(el.product.is_cancel !== 1 && el.product.is_no_show !== 1){
                        day_count++;
                    }

                })
                document.getElementById('day_cancel').innerHTML = `${cancel}건`
                document.getElementById('day_noshow').innerHTML = `${noshow}건`
                document.getElementById('day_total').innerHTML = `${day_count}건`
                let week = ['일','월','화','수','목','금','토']
                document.getElementById('schedule_day').innerHTML =`${fill_zero(date.getMonth()+1)}.${fill_zero(date.getDate())}(${week[date.getDay()]})`


                reserve_schedule(id).then(function(){
                    reserve_prohibition_list(id);

                    cols(id).then(function (body_data){


                        if(localStorage.getItem('time_type') == '2'){

                            $.ajax({

                                url: '/data/pc_ajax.php',
                                type: 'post',
                                data: {
                                    mode: 'get_part_time',
                                    id: id,
                                },
                                success: function (res) {

                                    let response = JSON.parse(res);
                                    let head = response.data.head;
                                    let body = response.data.body;
                                    if (head.code === 401) {
                                        pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                                    } else if (head.code === 200) {
                                        body.forEach(function(el){
                                            console.log(el)





                                            el.res_time_off.forEach(function(el_){

                                                Array.from(document.getElementsByClassName('time-compare-cols')).forEach(function(_el){


                                                    if(_el.getAttribute('data-name') === el.name && _el.getAttribute('data-time-to') == el_.time.split('~')[0] ){

                                                        _el.style.borderTop = '4px solid #828282';

                                                    }

                                                })
                                            })
                                        })
                                    }
                                }

                            })
                        }


                        console.log(body)

                        no_one(body_data);

                        let color;
                        body.forEach(function (el, index){

                            if(el.product.store_payment.card === null || el.product.store_payment.card === ''){

                                el.product.store_payment.card = 0;

                            }

                            if(el.product.store_payment.cash === null || el.product.store_payment.cash === ''){
                                el.product.store_payment.cash = 0;
                            }

                            if(typeof el.product.store_payment.cash === 'string'){
                                el.product.store_payment.cash = parseInt(el.product.store_payment.cash)
                            }

                            if(typeof el.product.store_payment.card === 'string'){
                                el.product.store_payment.card = parseInt(el.product.store_payment.card)
                            }

                                // 툴팁배열에 idx 넣기




                            Array.from(document.getElementsByClassName('calendar-day-body-col')).forEach(function (el_){

                                if(el_.getAttribute('data-name') === el.product.worker && new Date(el_.getAttribute('data-year'),el_.getAttribute('data-month'),el_.getAttribute('data-date'),el_.getAttribute('data-hour'),el_.getAttribute('data-minutes')).getTime() === new Date(el.product.date.booking_st.replace(' ','T')).getTime() && el.product.is_cancel === 0){
                                    if(el.product.store_payment.discount === null){

                                        el.product.store_payment.discount = 0
                                    }
                                    switch(el.product.pay_type){

                                        case "pos-card" : case "pos-cash" : color = 'green'; break;
                                        case "offline-card" : case "offline-cash" : color = 'purple'; break;
                                        case "card" : case "bank" : color = 'yellow'; break;
                                        default : color = ''; break;

                                    }
                                    if(el.product.reserve_pay_price === null || el.product.reserve_pay_price ===''){

                                        el.product.reserve_pay_price = 0;
                                    }


                                    if(el.product.store_payment.card == '' || el.product.store_payment.card == null){
                                        el.product.store_payment.card = 0;

                                    }

                                    if(el.product.store_payment.cash == '' || el.product.store_payment.cash == null){
                                        el.product.store_payment.cash = 0;

                                    }

                                    if(el.pet.idx === 0){
                                        return;
                                    }

                                    el_.setAttribute('data-payment_idx',el.product.payment_idx)
                                    el_.setAttribute('data-time_length',(new Date(el.product.date.booking_fi.replace(' ','T')).getTime()-new Date(el.product.date.booking_st.replace(' ','T')).getTime())/1000/60)


                                    let multiple = (new Date(el.product.date.booking_fi.replace(' ','T')).getTime() - new Date(el.product.date.booking_st.replace(' ','T')).getTime())/1800000;
                                    el_.innerHTML = `<div class="calendar-drag-item-group"  data-pet_name="${el.pet.name}" data-cellphone="${el.customer.phone}">
                                                                        <a href="#" onclick="pay_management_init(artist_id,this,false,${el.product.is_approve === 0 ? false : true}); pay_management_toggle(false); localStorage.setItem('payment_idx','${el_.getAttribute('data-payment_idx')}')" ${el.product.approve_idx === null ? '' : `data-approve_idx="${el.product.approve_idx}"`} data-tooltip_idx="${index}" data-cellphone="${el.customer.phone}" data-payment_idx="${el_.getAttribute('data-payment_idx')}" onclick="localStorage.setItem('payment_idx',${el_.getAttribute('data-payment_idx')})" class="calendar-week-time-item toggle ${color} ${el.product.is_no_show === 1 ? "red" : ''} ${el.product.is_approve === 0 ? 'gray': ''}" style="height: calc(100% * ${multiple}); " data-height="${multiple}">
                                                                            <div class="item-inner" >
                                                                                <div class="item-photo-name">
                                                                                

                                                                                        
                                                                                    <div class="item-photo" ${el.pet.photo === null || el.pet.photo === '' ? '' : `onclick="thumb_view(this,'${el.pet.photo === null ? '' : el.pet.photo}')"`}>
                                                                                        <img src="${el.pet.photo === null ? el.pet.animal === 'dog' ? '/static/images/icon/icon-pup-select-off.png' : '/static/images/icon/icon-cat-select-off.png' : img_link_change(el.pet.photo)}" alt="">
                                                                                    </div>
                                                                                    <div class="item-name">
                                                                                        <div class="txt" style="font-size:17px; margin-bottom:2px; max-width:100px;">${el.pet.name}</div>
                                                                                        ${multiple <4 ? `<button type="button" class="btn-calendar-item-more"></button>`:``}
                                                                                    </div> 
                                                                                    ${el.product.noshow_cnt >0 ? `<div class="item-noshow"><img src="/static/images/noshow@2x.png" alt="">${el.product.noshow_cnt}회</div>` : ''}
                                                                                </div>
                                                                                <div class="item-other">
                                                                                    <div class="item-cate">${el.pet.type}${(el.product.is_reserve_pay === 1 && el.product.reserve_pay_yn === 0) ? `<div class="deposit-box">예약금 대기</div>` :''}${el.product.is_reserve_pay === 1 && el.product.reserve_pay_yn === 1 ? `<div class="deposit-box-fin">예약금입금완</div>`:''}</div>
                                                                                    <div class="item-price">${(el.product.store_payment.card + el.product.store_payment.cash).toLocaleString()}원</div>
                                                                                    <div class="item-option">${el.product.category} ${el.product.category_sub !== ''? '|':''}${el.product.category_sub}</div>
                                                                                    <div class="item-memo" style="font-size:12px;">${el.product.memo === null ? '' : el.product.memo}</div>
                                                                                </div>
                                                                                <div class="item-stats">
                                                                                ${el.product?.product_detail_parsing?.base?.size !== undefined ? (el.product.product_detail_parsing.base.size === '' || el.product.product_detail_parsing.base.size=== null) ? `<div class="left">
                                                                                                                                                                                                    <div class="item-master">
                                                                                                                                                                                                        <div class="icon icon-reservation-selfadd"></div>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                </div>`  : el.product.is_confirm === true ? el.product.store_payment.card >= el.product.store_payment.cash ? `<div class="right"><div class="item-cash"><div class="icon icon-reservation-card-on"></div></div></div>` : `<div class="right"><div class="item-cash"><div class="icon icon-reservation-cash-on"></div></div></div>` : el.product.store_payment.card >= el.product.store_payment.cash ? `<div class="right"><div class="item-cash"><div class="icon icon-reservation-card-off"></div></div></div>` : `<div class="right"><div class="item-cash"><div class="icon icon-reservation-cash-off"></div></div></div>` : ''}
                                                                                    
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



                        let workers = [];

                        body_data.forEach(function(el){

                            if(el.is_show && !el.is_leave){

                                workers.push(el);
                            }
                        })

                        // if(workers.length > 3){

                            // Array.from(document.getElementsByClassName('item-photo')).forEach(function(el){
                            //
                            //     el.style.display = 'none';
                            // })

                            // Array.from(document.getElementsByClassName('item-other')).forEach(function(el){
                            //
                            //     el.style.paddingLeft = '0px'
                            // })
                        // }

                        day_drag();
                    });
                });

            }


        },

    })
}


function reserve_schedule_week_cols(body,body_,parent,id,session_id){
    memo_array = [];







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
                }else if(localStorage.getItem('change_check')==='1'){
                    __el.innerHTML = `<div class="calendar-drag-item-group">
                                    <a href="#add" onclick="change_check_reserve(this)" class="btn-calendar-add">등록하기</a>
                                    </div>`



                }else{
                    __el.innerHTML =`<div class="calendar-drag-item-group">
                                    <a href="#add" onclick="reserve_pop(this)" class="btn-calendar-add">등록하기</a>
                                    </div>`
                }

            })
            el.classList.add('actived');


            console.log(body_)

            Array.from(document.getElementsByClassName('calendar-week-body-col-add')).forEach(function(el){

                el.style.borderTop = '1px solid #ebebeb';
            })
            body_.forEach(function(_el, index){


                if(_el.product.worker === el.getAttribute('data-worker')){



                    let booking_st = _el.product.date.booking_st
                    let booking_fi = _el.product.date.booking_fi
                    let day = new Date(booking_st.replace(' ','T')).getDay();
                    let _booking_st = _el.product.date.booking_st.split(' ')[1];



                    let color;

                    switch(_el.product.pay_type){

                        case "pos-card" : case "pos-cash" : color = 'green'; break;
                        case "offline-card" : case "offline-cash" : color = 'purple'; break;
                        case "card" : case "bank" : color = 'yellow'; break;
                        default : color = ''; break;

                    }
                    let multiple = (new Date(booking_fi.replace(' ','T')).getTime() - new Date(booking_st.replace(' ','T')).getTime())/1800000;



                    Array.from(body_col).forEach(function(el__){





                        if(parseInt(el__.getAttribute('data-day')) === day
                            && _booking_st === el__.getAttribute('data-time-to')
                            && _el.product.is_cancel == 0
                        ){

                            if(_el.product.store_payment.discount == null){

                                _el.product.store_payment.discount=0;
                            }

                            if(_el.product.store_payment.cash == null || _el.product.store_payment.cash == '' ){

                                _el.product.store_payment.cash=0;
                            }

                            if(_el.product.store_payment.card == null || _el.product.store_payment.card == ''){

                                _el.product.store_payment.card=0;
                            }


                            if(_el.product.reserve_pay_price === null || _el.product.reserve_pay_price ===''){

                                _el.product.reserve_pay_price = 0;
                            }

                            if(_el.pet.idx === 0){
                                return;
                            }

                            el__.setAttribute('data-payment_idx',_el.product.payment_idx);

                            el__.setAttribute('data-time_length',(new Date(_el.product.date.booking_fi.replace(' ','T')).getTime()-new Date(_el.product.date.booking_st.replace(' ','T')).getTime())/1000/60)

                            el__.innerHTML = `<div class="calendar-drag-item-group" data-cellphone="${_el.customer.phone}" data-pet_name="${_el.pet.name}" >
                                                    <a href="#" data-tooltip_idx="${index}" onclick="pay_management_init(artist_id,this,false,${_el.product.is_approve === 0 ? false : true}); pay_management_toggle(false);localStorage.setItem('payment_idx',${_el.product.payment_idx})" ${_el.product.approve_idx === null ? '' : `data-approve_idx="${_el.product.approve_idx}"`} data-payment_idx="${_el.product.payment_idx}" class="calendar-week-time-item toggle ${color} ${_el.product.is_no_show === 1 ? "red" : ''} ${_el.product.is_approve === 0 ? 'gray': ''}" data-cellphone="${_el.customer.phone}" data-pet_name="${_el.pet.name}" style="height: calc(100% * ${multiple}); " data-height="${multiple}">
                                                        <div class="item-inner">
                                                            <div class="item-photo-name">
                                                            <div class="item-name">
                                                                <div class="txt" style="font-size:17px; margin-bottom:2px; max-width:80px;">${_el.pet.name}</div>
                                                                <button type="button" class="btn-calendar-item-more"></button>
                                                            </div>
                                                            ${_el.product.noshow_cnt > 0 ? `<div class="item-noshow"><img src="/static/images/noshow@2x.png" alt="">${_el.product.noshow_cnt}회</div>`:''}
                                                            </div>
                                                            
                                                            <div class="item-cate">${_el.pet.type}${(_el.product.is_reserve_pay === 1 && _el.product.reserve_pay_yn === 0) ? `<div class="deposit-box">예약금 대기</div>` :''}${_el.product.is_reserve_pay === 1 && _el.product.reserve_pay_yn === 1 ? `<div class="deposit-box-fin">예약금입금완</div>`:''}</div>
                                                            <div class="item-price">${(parseInt(_el.product.store_payment.card) + parseInt(_el.product.store_payment.cash)).toLocaleString()}원</div>
                                                            <div class="item-option">${_el.product.category}${_el.product.category_sub !== '' ? '|':''}${_el.product.category_sub}</div>
                                                            <div class="item-memo" style="font-size:12px;">${_el.product.memo === null ? '' : _el.product.memo}</div>
                                                            <div class="item-stats">
                                                                               
                                                                         ${_el.product?.product_detail_parsing?.base?.size ? _el.product.product_detail_parsing.base.size === '' || _el.product.product_detail_parsing.base.size=== null ? `<div class="left">
                                                                                                                                                                                                    <div class="item-master">
                                                                                                                                                                                                        <div class="icon icon-reservation-selfadd"></div>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                </div>`  : _el.product.is_confirm === true ? _el.product.store_payment.card >= _el.product.store_payment.cash ? `<div class="right"><div class="item-cash"><div class="icon icon-reservation-card-on"></div></div></div>` : `<div class="right"><div class="item-cash"><div class="icon icon-reservation-cash-on"></div></div></div>` : _el.product.store_payment.card >= _el.product.store_payment.cash ? `<div class="right"><div class="item-cash"><div class="icon icon-reservation-card-off"></div></div></div>` : `<div class="right"><div class="item-cash"><div class="icon icon-reservation-cash-off"></div></div></div>` : ''}
                                                                                                
                                                            </div>
                                                        </div>
                                                    </a>
                                            </div>`

                        }
                    })


                }









            })

            //tooltip(tooltip_arr);


            Array.from(body_col).forEach(function (e){

                e.classList.remove('break')
            })


            let work_day = [];

            Array.from(body).forEach(function (q){


                if(el.getAttribute('data-worker') === q.name){

                    q.work.forEach(function (w){
                        
                        work_day.push(w.week)







                        Array.from(body_col).forEach(function (e){



                            if(!work_day.toString().match(e.getAttribute('data-day'))){

                                e.classList.add('break')
                            }else{

                                e.classList.remove('break')
                            }

                            if(w.week === e.getAttribute('data-day') && (time_compare(w.time_st,e.getAttribute('data-time-to')) || time_compare(e.getAttribute('data-time-from'),w.time_fi))){



                                e.classList.add('break')

                            }






                        })




                    })
                }

            })




            week_holiday(parent,id).then(function(){

                if(localStorage.getItem('time_type') == '2'){
                    $.ajax({

                        url:'/data/pc_ajax.php',
                        type:'post',
                        data:{
                            mode:'get_part_time',
                            id:id,
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

                                    Array.from(document.getElementsByClassName('header-worker')).forEach(function(el_){


                                        if(el_.classList.contains('actived')){

                                            if(el_.getAttribute('data-worker') === el.name){

                                                el.res_time_off.forEach(function(_el){

                                                    Array.from(document.getElementsByClassName('calendar-week-body-col-add')).forEach(function(__el){

                                                        if(__el.getAttribute('data-time-to') == _el.time.split('~')[0]){

                                                            __el.style.borderTop = '4px solid #828282';
                                                        }
                                                    })
                                                })
                                            }

                                        }
                                    })
                                })
                            }
                        }
                    })
                }


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




            setTimeout(function(){
                reserve_prohibition_list(id);
                week_drag()},500)







        })


    })



    


}

// function work_day_search(work_day){
//
//
//     for(let i=0; i<7; i++) {
//
//         if(work_day.includes(i.toString())){
//             let value = i.toString();
//             work_day = work_day.filter(function(item){
//                 return item !== value;
//             })
//         }
//         // else{
//         //
//         //     work_day.push(i.toString())
//         // }
//
//     }
//
//     if(work_day.length === 0){
//
//         work_day.push('999')
//     }
//
//     return work_day;
//
//
//
//
// }


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

                    let open = `${fill_zero(localStorage.getItem('open_close').split('/')[0])}:00`;
                    let close = `${fill_zero(localStorage.getItem('open_close').split('/')[1])}:00`;
                    


                    document.getElementById('grid_layout_inner').innerHTML = '';


                    body.forEach(function(el){

                        if(!el.is_leave && el.is_show){


                            document.getElementById('grid_layout_inner').innerHTML += `<div class="grid-layout-cell flex-auto" >
                                                                                                        <button type="button" class="btn-toggle-button header-worker" data-worker="${el.name}" data-nick="${el.nick}" data-week-0="0|${open}|${close}" data-week-1="1|${open}|${close}" data-week-2="2|${open}|${close}" data-week-3="3|${open}|${close}" data-week-4="4|${open}|${close}" data-week-5="5|${open}|${close}" data-week-6="6|${open}|${close}">${el.nick}</button>
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


    if (open <= now_hour && now_hour < close) {
        day_body.innerHTML += `<div class="calendar-day-current-time" style="top:${div_height}px"><div class="bar"></div><div class="value">${fill_zero(date.getHours())}:${fill_zero(date.getMinutes())}</div></div>`
    }

}


function reserve_schedule_week(id,body_data) {

    return new Promise(function (resolve) {



        let break_time = '';
        let break_times = '';
        if(localStorage.getItem('break_time') !== ''){
            break_time = JSON.parse(localStorage.getItem('break_time'))

            break_time.forEach(function(el,i){
                break_times += `${el.time.split('~')[0]} `
            })
        }

        let day_body = document.getElementById('day_body');


        let open = parseInt(localStorage.getItem('open_close').split('/')[0]);
        let close = parseInt(localStorage.getItem('open_close').split('/')[1]);
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


        resolve();

})
}

function schedule_render_week(el,id){


return new Promise(function (resolve){


    pay_management_toggle(true);




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


            $.ajax({


                url: '/data/pc_ajax.php',
                type: 'post',
                // async:false,
                // beforeSend:function(){
                //
                // },
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

                        if(document.getElementById('week_schedule_card_body')){
                            document.getElementById('week_schedule_card_body').style.display = 'block';
                            document.getElementById('week_schedule_loading').style.display ='none';
                            document.getElementById('btn-schedule-prev').removeAttribute('disabled');
                            document.getElementById('btn-schedule-next').removeAttribute('disabled');
                            week_timebar();
                            week_drag();

                        }

                        let data = [body_,parent];


                        resolve(data);

                        let week_count = 0;
                        let cancel = 0;
                        let noshow = 0;

                        body_.forEach(function (el) {
                            // 툴팁배열에 idx 넣기
                            // tooltip(el.product.payment_idx);

                            if (el.product.is_cancel === 1) {
                                cancel++;
                            }

                            if (el.product.is_no_show === 1) {
                                noshow++;
                            }

                            if(el.product.is_cancel !== 1 && el.product.is_no_show !==1 ){

                                week_count++;
                            }
                        })

                        document.getElementById('day_today').innerHTML = `${st_date.replaceAll('-', '.')} ~ ${fi_date.substr(0,4)}.${fi_date.substring(5).split('-')[0]}.${parseInt(fi_date.substring(5).split('-')[1])-1}`
                        document.getElementById('day_total').innerHTML = `${week_count}건`
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

                        Array.from(document.getElementsByClassName('week-date')).forEach(function (el, i) {

                            el.innerText = days[i]
                        })





                    }

                }
                // ,complete:function(){


                // }
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
                month: fill_zero(date.getMonth()+1),
                month_1:fill_zero(date.getMonth()+2),
            },
            type: 'POST',
            beforeSend:function(){
                pay_management_toggle(true)
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

                    if(location.href.match('reserve_beauty_month')){
                        let count = 0;
                        let cancel = 0;
                        let noshow = 0;

                        body.forEach(function (el){

                            if(el.product.is_cancel === 1){

                                cancel++;
                            }

                            if(el.product.is_no_show === 1){

                                noshow++;
                            }

                            if(el.product.is_cancel !== 1 && el.product.is_no_show !==1){
                                count++;
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



                        document.getElementById('day_total').innerText = `${count}건`
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
                                                                                                       <div class="item-time">${((new Date().getTime() - new Date(el.date.replace(' ','T')).getTime())/1000/60).toFixed() <60 ? ((new Date().getTime() - new Date(el.date.replace(' ','T')).getTime())/1000/60).toFixed() < 1 ? '방금 전' : `${((new Date().getTime() - new Date(el.date.replace(' ','T')).getTime())/1000/60).toFixed()}분 전` : `${((new Date().getTime() - new Date(el.date.replace(' ','T')).getTime())/1000/60/60).toFixed()}시간 전` }</div>
                                                                                                   </div>
                                                                                               </div>
                                                                                           </a>
                                                                                       </div>`;
                }
            }
        })


    }
}

function consulting_toggle(bool){

    document.getElementById('consulting_data').style.opacity = '0'

    if(bool){
        document.getElementById('consulting_list_2').style.display = 'none';
        document.getElementById('consulting_list').style.display = 'flex';


    }else{
        document.getElementById('consulting_list').style.display = 'none';
        document.getElementById('consulting_list_2').style.display = 'flex';

    }






}
//상담대기 리스트
function consulting_hold_list(id){




    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'get_consulting_count',
            login_id:id
        },
        success: function (res) {

            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {


                $.ajax({

                    url:'/data/pc_ajax.php',
                    type:'post',
                    data:{

                        mode:'get_consulting',
                        login_id:id
                    },
                    success: function (res) {


                        let response = JSON.parse(res);
                        let head = response.data.head;
                        let body_ = response.data.body;
                        if (head.code === 401) {
                            pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                        } else if (head.code === 200) {

                            if(body_.length === undefined){

                                body_ = [body_];
                            }

                            let status = '';

                            if(body_.length === 0){
                                document.getElementById('consulting_hold_list_none_data').style.display = 'block';

                            }
                            body_.forEach(function(el, i){

                                switch (el.approval){

                                    case 0: status = '대기'; break;
                                    case 1: status = '미용'; break;
                                    case 2: status = '완료'; break;
                                    case 3: status = '거부'; break;
                                }

                                if(status === '대기' && i < body.consult_waiting_num){

                                    document.getElementById('consulting_list').innerHTML += `<div class="grid-layout-cell grid-2">
                                                                                         <div class="thema-gray-item white consulting-select" data-pet_name="${el.pet_name}" data-phone="${el.phone}">
                                                                                            <a href="#" class="basic-list-item store">
                                                                                                <div class="info-wrap">
                                                                                                    <div class="item-name">
                                                                                                        <strong>${el.pet_name}</strong>
                                                                                                        <br>
                                                                                                        <div class="">${phone_edit(el.phone)}</div>
                                                                                                    </div>
                                                                                                    <div class="item-date2">${am_pm_check2(el.date.replace('T',' '))}</div>
                                                                                                </div>
                                                                                            </a>
                                                                                            <div class="item-state2">
                                                                                                <strong class="font-color-lightgray">${status}</strong>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>`
                                }else{

                                    document.getElementById('consulting_list_2').innerHTML += `<div class="grid-layout-cell grid-2">
                                                                                         <div class="thema-gray-item white consulting-select ${(el.pet_name + el.phone).toString() === localStorage.getItem('consulting_select') ? 'actived' : ''}" data-pet_name="${el.pet_name}" data-phone="${el.phone}">
                                                                                            <a href="#" class="basic-list-item store">
                                                                                                <div class="info-wrap">
                                                                                                    <div class="item-name">
                                                                                                        <strong>${el.pet_name}</strong>
                                                                                                        <br>
                                                                                                        <div class="item-phone">${phone_edit(el.phone)}</div>
                                                                                                    </div>
                                                                                                    <div class="item-date2">${am_pm_check2(el.date.replace('T',' '))}</div>
                                                                                                </div>
                                                                                            </a>
                                                                                            <div class="item-state2">
                                                                                                <strong class="font-color-lightgray" ${el.approval == 2 ? 'style="color:#6840B1 !important"' : el.approval == 3 ? 'style=color:red !important':''}>${status}</strong>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>`
                                }
                            })


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
                                        body_.forEach(function(el_){


                                            if(el_.pet_name === el.getAttribute('data-pet_name') && el_.phone === el.getAttribute('data-phone')){
                                                // let data = el_.disliked_part;
                                                // let text = '';
                                                // data = [...data];
                                                // data.forEach(function (d,i){
                                                //     if(parseInt(d)===1){
                                                //         if(i===0){
                                                //             text += '눈 '
                                                //         }
                                                //         if(i===1){
                                                //             text += '코 '
                                                //         }
                                                //         if(i===2){
                                                //             text += '입 '
                                                //         }
                                                //         if(i===3){
                                                //             text += '귀 '
                                                //         }
                                                //         if(i===4){
                                                //             text += '목 '
                                                //         }
                                                //         if(i===5){
                                                //             text += '몸통 '
                                                //         }
                                                //         if(i===6){
                                                //             text += '다리 '
                                                //         }
                                                //         if(i===7){
                                                //             text += '꼬리 '
                                                //         }
                                                //         if(i===8){
                                                //             text += '생식기 '
                                                //         }
                                                //         if(i===9){
                                                //             text += '없음 '
                                                //         }
                                                //     }
                                                // })



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
                                                                                                                            <div class="flex-table-data-inner">
                                                                                                                                ${el_.dislike_string.replaceAll(',',' ')}
                                                                                                                            </div>
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
                                                                                                                <h5 class="con-title">${el_.dermatosis ? "피부병" : ""} ${el_.heart_trouble ? "심장질환" : ""} ${el_.marking ? "마킹" : ""} ${el_.mounting ? "마운팅" : ""} ${!el_.dermatosis && !el_.heart_trouble && !el_.marking && !el_.mounting ? '없음' : ''} </h5>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="basic-data-group">
                                                                                                            <div class="con-title-group">
                                                                                                                <h4 class="con-title">원하는 미용</h4>
                                                                                                            </div>
                                                                                                            <div class="con-title-group">
                                                                                                                <h5 class="con-title"> 
                                                                                                                ${el_.memo}
                                                                                                                </h5>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="basic-data-group">
                                                                                                            <div class="con-title-group">
                                                                                                                <h4 class="con-title">현재 아이 모습</h4>
                                                                                                            </div>
                                                                                                            <div class="basic-data-group vvsmall2">
                                                                                                                <div class="portfolio-list-wrap">
                                                                                                                    
                                                                                                                        ${el_.consult_photo.length > 0 ? `<div class="list-inner">
                                                                                                                        <div class="list-cell" onclick="thumb_view(this,\`${el_.consult_photo[0].photo.replace('/pet','')}\`)"><a href="#" class="btn-portfolio-item">
                                                                                                                                                            <img src="https://image.banjjakpet.com${el_.consult_photo[0].photo.replace('/pet','')}" alt="">
                                                                                                                                                        </a></div>
                                                                                                                    </div>` : `<span>업로드된 이미지가 없습니다.</span>`}
                                                                                                                            
                                                                                                                        
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="basic-data-group">
                                                                                                            <button type="button" class="btn btn-outline-red btn-basic-full" onclick="pop.open('adviceCustomer1');">예약 거부</button>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="card-footer">
                                                                                            <!-- btn-page-bottom 클래스에 disabled 클래스 추가시 비활성화 또는 button 태그일 시 disabled 속성 추가시 비활성화 -->
                                                                                                <button type="button" class="btn-page-bottom" id="consult_btn" data-payment_idx="${el_.payment_log_seq}" onclick="pop.open('adviceCustomer2')" >상담완료</button>
                                                                                            </div>
                                                                                        </div>`


                                            }
                                        })
                                    }
                                })
                            })







                        }
                    }


                })

            }
        }
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
            book_list(id).then(function(body){
                if(location.href.match('reserve_beauty_month')){

                    _renderCalendar_month().then(function(){
                        month_reserve_cols(body).then(function (){

                            day_total_reserve()
                            month_holiday(id)

                        });
                    });
                }else{

                    _renderCalendar_mini(id);
                }
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


        let open = parseInt(localStorage.getItem('open_close').split('/')[0]);
        let close = parseInt(localStorage.getItem('open_close').split('/')[1]);
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
                    console.log(body)

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
                                    document.getElementById('day_header_row').innerHTML +=`<div class="calendar-day-header-col" data-start="${el_.time_st}" data-end="${el_.time_fi}" data-worker="${el.name}">${el.nick}</div>`
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
                // book_list(id).then(function (){
                //
                //
                //     renderCalendar_mini(id).then(function(div_dates){
                //
                //         for (let i = 0; i < div_dates.length; i++) {
                //             document.getElementById(`mini-calendar-month-body-row-${i}`).innerHTML = '';
                //             for (let j = 0; j < div_dates[i].length; j++) {
                //                 document.getElementById(`mini-calendar-month-body-row-${i}`).innerHTML += div_dates[i][j]
                //             }
                //         }
                //     })
                // }).then(function(){
                //
                //     let date_info = document.getElementsByClassName('date-info');
                //     let booking_list ;
                //
                //     if(list !== undefined){
                //         booking_list = list;
                //     }else{
                //         booking_list = data;
                //     }
                //
                //     Array.from(date_info).forEach(function(el,i){
                //         let count = 0;
                //         let date_ck_1 = new Date(`20${el.innerText.trim()}`);
                //
                //         if(booking_list.beauty.length === 0){
                //             Array.from(document.getElementsByClassName('reserve-total')).forEach(function (el,i){
                //                 el.innerHTML = '0';
                //             })
                //         }else{
                //             booking_list.beauty.forEach(function(el_,i_){
                //                 let date_ck_2  =  new Date(el_.product.date.booking_st);
                //
                //                 if(date_ck_1.getFullYear() === date_ck_2.getFullYear()
                //                     && date_ck_1.getMonth() === date_ck_2.getMonth()
                //                     && date_ck_1.getDate() === date_ck_2.getDate()){
                //                     count++;
                //                 }
                //
                //
                //                 if(count !==0){
                //
                //                     siblings(el.parentElement.parentElement.parentElement.parentElement,0).children[1].innerHTML= `${count}`;
                //                 }
                //
                //             })
                //         }
                //     })
                // }).then(function(){
                //     let mini_col = document.getElementsByClassName('mini-calendar-month-body-col');
                //
                //     Array.from(mini_col).forEach(function(el) {
                //
                //         if(el.classList.contains('actived')){
                //             el.classList.remove('actived');
                //         };
                //         el.addEventListener('click', function () {
                //
                //             Array.from(mini_col).forEach(function (el_) {
                //
                //                 el_.classList.remove('actived');
                //             })
                //
                //             el.classList.add('actived');
                //             localStorage.setItem('day_select', `${date.getFullYear()}.${fill_zero(date.getMonth() + 1)}.${fill_zero(el.children[0].children[0].children[0].children[0].innerText.trim())}`)
                //             date.setDate(el.children[0].children[0].children[0].children[0].innerText.trim());
                //
                //             if(location.href.match('reserve_beauty_list')){
                //                 schedule_render_list(id).then(function (body){
                //
                //                     _schedule_render_list(body)
                //                 })
                //             }else{
                //
                //                 schedule_render(id);
                //             }
                //
                //         })
                //     })
                // })

                // renderCalendar_mini(id).then(function(div_dates){
                //
                //     for (let i = 0; i < div_dates.length; i++) {
                //                     document.getElementById(`mini-calendar-month-body-row-${i}`).innerHTML = '';
                //                     for (let j = 0; j < div_dates[i].length; j++) {
                //                         document.getElementById(`mini-calendar-month-body-row-${i}`).innerHTML += div_dates[i][j]
                //                     }
                //                 }
                //
                //     home_cal(id)
                //
                //
                // })
                _renderCalendar_mini(id)
                let new_date = new Date(date.getFullYear(),date.getMonth(),0);
                localStorage.setItem('day_select',`${new_date.getFullYear()}.${fill_zero(new_date.getMonth()+1)}.01`)

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
            let new_date_2 = new Date(date.getFullYear(),date.getMonth()-1,0);
            if(date.getDate() === new_date_2.getDate()){
                // book_list(id).then(function (){
                //
                //
                //     renderCalendar_mini(id).then(function(div_dates){
                //         for (let i = 0; i < div_dates.length; i++) {
                //             document.getElementById(`mini-calendar-month-body-row-${i}`).innerHTML = '';
                //             for (let j = 0; j < div_dates[i].length; j++) {
                //                 document.getElementById(`mini-calendar-month-body-row-${i}`).innerHTML += div_dates[i][j]
                //             }
                //         }
                //     })
                // }).then(function(){
                //
                //     let date_info = document.getElementsByClassName('date-info');
                //     let booking_list ;
                //
                //     if(list !== undefined){
                //         booking_list = list;
                //     }else{
                //         booking_list = data;
                //     }
                //
                //     Array.from(date_info).forEach(function(el,i){
                //         let count = 0;
                //         let date_ck_1 = new Date(`20${el.innerText.trim()}`);
                //
                //         if(booking_list.beauty.length === 0){
                //             Array.from(document.getElementsByClassName('reserve-total')).forEach(function (el,i){
                //                 el.innerHTML = '0';
                //             })
                //         }else{
                //             booking_list.beauty.forEach(function(el_,i_){
                //                 let date_ck_2  =  new Date(el_.product.date.booking_st);
                //
                //                 if(date_ck_1.getFullYear() === date_ck_2.getFullYear()
                //                     && date_ck_1.getMonth() === date_ck_2.getMonth()
                //                     && date_ck_1.getDate() === date_ck_2.getDate()){
                //                     count++;
                //                 }
                //                 if(count !==0){
                //
                //                     siblings(el.parentElement.parentElement.parentElement.parentElement,0).children[1].innerHTML= `${count}`;
                //                 }
                //                 ;
                //             })
                //         }
                //     })
                // }).then(function(){
                //     let mini_col = document.getElementsByClassName('mini-calendar-month-body-col');
                //
                //     Array.from(mini_col).forEach(function(el) {
                //
                //         el.addEventListener('click', function () {
                //
                //             Array.from(mini_col).forEach(function (el_) {
                //
                //                 el_.classList.remove('actived');
                //             })
                //
                //             el.classList.add('actived');
                //             localStorage.setItem('day_select', `${date.getFullYear()}.${fill_zero(date.getMonth() + 1)}.${fill_zero(el.children[0].children[0].children[0].children[0].innerText.trim())}`)
                //             date.setDate(el.children[0].children[0].children[0].children[0].innerText.trim());
                //
                //             if(location.href.match('reserve_beauty_list')){
                //                 schedule_render_list(id).then(function (body){
                //
                //                     _schedule_render_list(body)
                //                 })
                //             }else{
                //
                //                 schedule_render(id);
                //             }
                //
                //         })
                //     })
                //
                //
                //
                //
                // })
                // renderCalendar_mini(id).then(function(div_dates){
                //
                //     for (let i = 0; i < div_dates.length; i++) {
                //         document.getElementById(`mini-calendar-month-body-row-${i}`).innerHTML = '';
                //         for (let j = 0; j < div_dates[i].length; j++) {
                //             document.getElementById(`mini-calendar-month-body-row-${i}`).innerHTML += div_dates[i][j]
                //         }
                //     }
                //
                //     home_cal(id)
                //
                //
                // })
                _renderCalendar_mini(id)
                let new_date = new Date(date.getFullYear(),date.getMonth()+1,0);
                localStorage.setItem('day_select',`${new_date.getFullYear()}.${fill_zero(new_date.getMonth()+1)}.${fill_zero(new_date.getDate())}`)


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


        document.getElementById('btn-schedule-next').addEventListener('click',function() {
                select_low = parseInt(localStorage.getItem('select_row'));
                this.setAttribute('disabled', true);

                if (select_low !== lows.length - 1) {
                    lows[select_low + 1].children[0].click();
                    localStorage.setItem('select_row', select_low + 1)
                    select_low = parseInt(localStorage.getItem('select_row'));

                } else if (select_low === lows.length - 1) {

                    date.setMonth(date.getMonth() + 1);
                    localStorage.setItem('day_select',`${date.getFullYear()}.${fill_zero(date.getMonth()+1)}.01`)
                    _renderCalendar_mini(id);

                }







        })

        document.getElementById('btn-schedule-prev').addEventListener('click',function(){
            this.setAttribute('disabled',true);
            select_low = parseInt(localStorage.getItem('select_row'));

            if(select_low !== 0){

                lows[select_low-1].children[0].click();
                localStorage.setItem('select_row',select_low-1)
                select_low = parseInt(localStorage.getItem('select_row'));
            } else if (select_low === 0) {

                let new_date = new Date(date.getFullYear(),date.getMonth(),0);
                date.setMonth(date.getMonth() -1);
                date.setDate(new_date.getDate())
                localStorage.setItem('day_select',`${date.getFullYear()}.${fill_zero(new_date.getMonth())}.${fill_zero(new_date.getDate())}`)
                _renderCalendar_mini(id);

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
               
                },
                onEnd : function(evt){
                    //드래그 끝
                 
                    //evt.to;    // 현재 아이템
                    //evt.from;  // 이전 아이템
                    //evt.oldIndex;  // 이전 인덱스값
                    //evt.newIndex;  // 새로운 인덱스값

                    if(evt.from != evt.to){

                        let pet_name = $(evt.from).attr('data-pet_name');

                        let cellphone = $(evt.from).attr('data-cellphone');

                        _thisWorker = $(evt.from).parent().attr("data-nick");
                        _thisYear = $(evt.from).parent().attr("data-year");
                        _thisMonth = $(evt.from).parent().attr("data-month")
                        _thisDate = $(evt.from).parent().attr("data-date");
                        _thisHour = $(evt.from).parent().attr("data-hour");
                        _thisMinutes = $(evt.from).parent().attr("data-minutes")
                        _thisTimeStart   = $(evt.from).parent().attr("data-time-to");
                        _thisTimeEnd   = $(evt.from).parent().attr("data-time-from");
                        thisLogSeq = $(evt.from).parent().attr("data-payment_idx");



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
                        $("#reserveCalendarPop4 input[name='log_cellphone']").val(cellphone);
                        $("#reserveCalendarPop4 input[name='log_pet_name']").val(pet_name);
                        $("#reserveCalendarPop4 input[name='log_a_year']").val(_thisYear);
                        $("#reserveCalendarPop4 input[name='log_a_month']").val(parseInt(_thisMonth)+1);
                        $("#reserveCalendarPop4 input[name='log_a_date']").val(_thisDate);
                        $("#reserveCalendarPop4 input[name='log_a_start_hour']").val(_thisHour);
                        $("#reserveCalendarPop4 input[name='log_a_start_min']").val(_thisMinutes);

                        pop.open('reserveCalendarPop4');
                    }
                },
                onUpdate : function(evt){
                    // ////console.log('update');
                },
                onUpdate : function(evt){
                    // ////console.log('onChange');
                },
                onRemove: function (/**Event*/evt) {
                    // ////console.log('remove');
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
                    // ////console.log('drag start');
                },
                onEnd : function(evt){
                    //드래그 끝
                    // ////console.log('drag end');
                    //evt.to;    // 현재 아이템
                    //evt.from;  // 이전 아이템
                    //evt.oldIndex;  // 이전 인덱스값
                    //evt.newIndex;  // 새로운 인덱스값


                    if(evt.from != evt.to){

                        let pet_name = $(evt.from).attr('data-pet_name');

                        let cellphone = $(evt.from).attr('data-cellphone');

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
                        thisLogSeq = $(evt.from).parent().attr("data-payment_idx");



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
                        $("#reserveCalendarPop4 input[name='log_cellphone']").val(cellphone);
                        $("#reserveCalendarPop4 input[name='log_pet_name']").val(pet_name);
                        $("#reserveCalendarPop4 input[name='log_a_year']").val(_thisYear);
                        $("#reserveCalendarPop4 input[name='log_a_month']").val(parseInt(_thisMonth)+1);
                        $("#reserveCalendarPop4 input[name='log_a_date']").val(_thisDate);
                        $("#reserveCalendarPop4 input[name='log_a_start_hour']").val(_thisHour);
                        $("#reserveCalendarPop4 input[name='log_a_start_min']").val(_thisMinutes);







                        pop.open('reserveCalendarPop4');

                    }
                },
                onUpdate : function(evt){
                    // ////console.log('update');
                },
                onUpdate : function(evt){
                    // ////console.log('onChange');
                },
                onRemove: function (/**Event*/evt) {
                    // ////console.log('remove');
                }

            });
        }
    });

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
                                <div class="calendar-day-value" style="cursor:pointer" onclick="localStorage.setItem('day_select',\`${date.getFullYear()}.${fill_zero(parseInt(date.getMonth())+1)}.${fill_zero(_date)}\`); location.href='/booking/reserve_beauty_day.php'">
                                    <div class="number" style="cursor:pointer;">${_date}</div>
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

            body.forEach(function(el_){

                let color;
                switch(el_.product.pay_type){

                    case "pos-card": case "pos-cash" : color = 'green'; break;
                    case "offline-card" : case "offline-cash" : color = 'purple'; break;
                    case "card" : case "bank" : color = 'yellow'; break;
                    default : color = ''; break;

                }

                let date_init = el_.product.date.booking_st.split(' ')[0].split('-');



                if(!el.parentElement.parentElement.classList.contains('before') && !el.parentElement.parentElement.classList.contains('after') ){

                    if(new Date(date_init[0],date_init[1]-1,date_init[2]).getTime() === new Date(el.getAttribute('data-year'),el.getAttribute('data-month'),el.getAttribute('data-date')).getTime() && el_.product.is_cancel === 0 ){

                        el.innerHTML += `<div class="calendar-drag-item calendar-drag-item-add"><a href="#" onclick="pay_management_init(artist_id,this,false,true); pay_management_toggle(false); localStorage.setItem('payment_idx',${el_.product.payment_idx})" data-payment_idx="${el_.product.payment_idx}" class="calendar-month-day-item ${color} ${el_.product.pay_type} ${el_.product.is_no_show === 1 ? "red" : ''} ${el_.product.is_approve === 0 ? 'gray':''}" style="color: white;"><div class="calendar-month-day-item-name"><strong>${el_.pet.name}</strong><span>(${el_.pet.type})</span></div></a></div>`
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
            today_reserve(id,false);
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
            today_reserve(id,false);
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
                    //console.log(body)


                    document.getElementById('day_today').innerHTML = `${date.getFullYear()}.${fill_zero(date.getMonth() + 1)}.${fill_zero(date.getDate())}`

                    let day_count = 0;
                    let cancel = 0;
                    let noshow = 0;

                    body.forEach(function (el) {
                        if (el.product.is_cancel === 1) {
                            cancel++;
                        }
                        if (el.product.is_no_show === 1) {
                            noshow++;
                        }

                        if(el.product.is_cancel !== 1 && el.product.is_no_show !==1){
                            day_count++;
                        }
                    })
                    document.getElementById('day_cancel').innerHTML = `${cancel}건`
                    document.getElementById('day_noshow').innerHTML = `${noshow}건`
                    document.getElementById('day_total').innerHTML = `${day_count}건`


                    let week = ['일', '월', '화', '수', '목', '금', '토']
                    document.getElementById('schedule_day').innerHTML = `${fill_zero(date.getMonth() + 1)}.${fill_zero(date.getDate())}(${week[date.getDay()]})`



                    $.ajax({
                        url:'/data/pc_ajax.php',
                        type:'post',
                        data:{
                            mode:'working',
                            login_id:id,
                        },success:function(res){
                            let response = JSON.parse(res);
                            let head = response.data.head;
                            let body_ = response.data.body;
                            if (head.code === 401) {
                                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                            } else if (head.code === 200) {

                                let list_inner = document.getElementById('list_inner');

                                let set = new Set();
                                body.forEach(function (el){

                                    set.add(el.product.worker);

                                })

                                list_inner.innerHTML = '';

                                if(set.size >0){
                                    set.forEach(function(_el){

                                        body_.forEach(function(el){

                                            if(el.is_show && !el.is_leave && el.name === _el){

                                                //console.log(el)

                                                el.work.forEach(function(el_){

                                                    if(el_.week == date.getDay()){

                                                        //console.log(el_)
                                                        list_inner.innerHTML +=`<div class="reserve-calendar-list-group">
                                                                                <div class="con-title-group">
                                                                                    <h5 class="con-title worker_id" data-worker="${_el}" data-start="${el_.time_st}" data-end="${el_.time_fi}" >${el.nick}</h5>
                                                                                </div>
                                                                                <div class="reserve-calendar-list-data" id="list-data-${_el}"></div>
                                                                            </div>`

                                                    }

                                                })

                                            }
                                        })
                                    })



                                }else{
                                    list_inner.innerHTML = `<div style="height:300px; margin:0 auto; line-height: 300px; text-align: center">확정된 예약일정이 없습니다.</div>`

                                }





                            }

                            resolve(body);
                        }
                    })




                    // if(body.length > 0){
                    //     let set = new Set();
                    //     body.forEach(function (el){
                    //
                    //         set.add(el.product.worker);
                    //
                    //     })
                    //
                    //     list_inner.innerHTML = '';
                    //     set.forEach(function (el){
                    //
                    //         list_inner.innerHTML +=`<div class="reserve-calendar-list-group">
                    //                             <div class="con-title-group">
                    //                                 <h5 class="con-title worker_id">${el === id ? '실장' : el}</h5>
                    //                             </div>
                    //                             <div class="reserve-calendar-list-data" id="list-data-${el}"></div>
                    //                         </div>`
                    //     })
                    // }else{
                    //
                    //
                    //
                    // }




                }

            }
        })

    })


}

function _schedule_render_list(body){


    //console.log(body)



    let color;
    body.forEach(function (el){

        switch(el.product.pay_type){

            case "pos-card" : case "pos-cash" : color = 'green'; break;
            case "offline-card" : case "offline-cash" : color = 'purple'; break;
            case "card" : case "bank" : color = 'yellow'; break;
            default : color = ''; break;

        }

        Array.from(document.getElementsByClassName('reserve-calendar-list-data')).forEach(function (el_){

            if(el_.getAttribute(`id`).replaceAll('list-data-','') === el.product.worker && el.product.is_cancel === 0){


                if(el.product.reserve_pay_price === null || el.product.reserve_pay_price ===''){

                    el.product.reserve_pay_price = 0;
                }
                document.getElementById(`list-data-${el.product.worker}`).innerHTML +=`<a href="#" onclick="pay_management_init(artist_id,this,false,true); pay_management_toggle(false);localStorage.setItem('payment_idx',${el.product.payment_idx})" data-payment_idx="${el.product.payment_idx}" class="reserve-calendar-list-items ${color} ${el.product.is_no_show === 1 ? "red" : ''}">
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
                                                                                                                <div class="item-options-txt">카드 : ${el.product.store_payment.card === "" || el.product.store_payment.card === null ? '0' : parseInt(el.product.store_payment.card)+parseInt(el.product.reserve_pay_price)}원</div>
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

                location.reload();
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
            beforeSend:function(res){

                if(document.getElementById('search_phone_data')){

                    document.getElementById('search_phone_data').style.display = 'none';
                    document.getElementById('customer_inquiry_loading').style.display = 'flex';
                }
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
                                                                                                        <div class="user-thumb large" ${el.pet_photo !== '' ? `onclick="thumb_view(this,'${el.pet_photo.replace('/pet/','/')}')"`:''}>
                                                                                                        <img src="${el.pet_photo === "" ? el.type === 'dog' ? `../static/images/icon/icon-pup-select-off.png` : `../static/images/icon/icon-cat-select-off.png` : `https://image.banjjakpet.com${el.pet_photo.replace('/pet/','/')}`}" alt="">
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


        if(document.getElementById('search_phone_data')){

            document.getElementById('search_phone_data').style.display = 'block';
            document.getElementById('customer_inquiry_loading').style.display ='none';
        }




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

        st_date = `${date.getFullYear()}-${fill_zero(date.getMonth()+1)}-${fill_zero(date.getDate())}`;
        fi_date = `${date.getFullYear()}-${fill_zero(date.getMonth()+1)}-${fill_zero(date.getDate()+1)}`
    }else if(location.href.match('reserve_beauty_week')){

        let dates = document.getElementById('schedule_day').innerText.replaceAll('.','-').split(' ~ ');

        st_date = `${date.getFullYear()}-${dates[0]}`;
        fi_date = `${date.getFullYear()}-${dates[1]}`;


    }


    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        async:false,
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


                            let st_date = new Date(el.st_date.replace(' ','T')).getTime();
                            let fi_date = new Date(el.fi_date.replace(' ','T')).getTime();
                            let time = [];

                            for(let i=st_date; i<=fi_date; i+=1800000){

                                time.push(i);
                            }


                            setTimeout(function(){

                                Array.from(document.getElementsByClassName('time-compare-cols')).forEach(function (el_,i){

                                    let el_year = el_.getAttribute('data-year');
                                    let el_month= el_.getAttribute('data-month');
                                    let el_date= el_.getAttribute('data-date');
                                    let el_hour= el_.getAttribute('data-hour');
                                    let el_minutes = el_.getAttribute('data-minutes');

                                    let el_new_date = new Date(`${el_year}-${fill_zero(parseInt(el_month)+1)}-${fill_zero(parseInt(el_date))}T${fill_zero(el_hour)}:${fill_zero(el_minutes)}`).getTime();

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
                            },500)


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

                            let st_date = new Date(el.st_date.replace(' ','T')).getTime();

                            let fi_date = new Date(el.fi_date.replace(' ','T')).getTime();

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

                                    let el_new_date = new Date(`${el_year}-${fill_zero(parseInt(el_month)+1)}-${fill_zero(parseInt(el_date))}T${fill_zero(el_hour)}:${fill_zero(el_minutes)}`).getTime();


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

        case 1 : document.getElementById('basic_service_select').innerHTML = '<div class="toggle-button-cell" onclick="reserve_merchandise_load_reset(2)"><label class="form-toggle-box large "><input type="radio" value="" name="s1"><em class="font-size-12">선택 안함</em></label></div>';
            document.getElementById('basic_weight').innerHTML = '<div class="toggle-button-cell" id="weight_not_select"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="s2" checked ><em><span class="font-size-12">선택 안함</span></em></label></div>';

            break;
        case 2 :
            document.getElementById('basic_weight').innerHTML = '<div class="toggle-button-cell" id="weight_not_select"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="s2" checked><em><span class="font-size-12">선택 안함</span></em></label></div>';

            break;


    }

}


function reserve_merchandise_load_reset_(i){

    switch (i){

        case 1 : document.getElementById('payment_basic_service_select').innerHTML = '<div class="toggle-button-cell" onclick="reserve_merchandise_load_reset_(2)"><label class="form-toggle-box large "><input type="radio" value="" name="s1"><em class="font-size-12">선택 안함</em></label></div>';
            document.getElementById('payment_basic_weight').innerHTML = '<div class="toggle-button-cell" id="payment_weight_not_select"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="s2" checked ><em><span class="font-size-12">선택 안함</span></em></label></div>';

            break;
        case 2 :
            document.getElementById('payment_basic_weight').innerHTML = '<div class="toggle-button-cell" id="payment_weight_not_select"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="s2" checked><em><span class="font-size-12">선택 안함</span></em></label></div>';

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


function reserve_merchandise_load_event(artist_id){

    Array.from(document.getElementsByClassName('load-pet-type')).forEach(function (el){

        el.addEventListener('click',function (evt){
            // let id=artist_id;

            reserve_merchandise_load_init(artist_id).then(function(body){
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


                            if(body.is_vat == 1){
                                //console.log('1이야')
                                localStorage.setItem('is_vat','1');
                            }else{
                                //console.log('0이야');
                                localStorage.setItem('is_vat','0');
                            }
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
                                                                          <div class="toggle-button-cell" onclick="reserve_merchandise_load_reset(1)"><label class="form-toggle-box large"><input type="radio" value="" name="size" onclick="reserve_service_list('service2_basic_size','','0')" checked><em class="font-size-12">선택 안함</em></label></div>
                                                                     
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label">서비스</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="basic_service_select">
                                                                              <div class="toggle-button-cell" onclick="reserve_merchandise_load_reset(2)"><label class="form-toggle-box large"><input type="radio" value="" name="s1" onclick="reserve_service_list('service2_basic_service','','0')" checked ><em class="font-size-12">선택 안함</em></label></div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="grid-layout-cell grid-5">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label">무게</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="toggle-button-group vertical" id="basic_weight">
                                                                            <div class="toggle-button-cell" id="weight_not_select"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="s2" onclick="reserve_service_list('service2_basic_weight','','0')" checked><em><span class="font-size-12">선택 안함</span></em></label></div>
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
                                                                            <div class="toggle-button-cell" ><label class="form-toggle-box large"><input type="radio" value="" name="hairBeauty" onclick="reserve_service_list('service2_basic_hair_length','','0')" checked ><em class="font-size-12">선택 안함</em></label></div>
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
                                                                                <div class="toggle-button-cell" ><label class="form-toggle-box large"><input type="radio" value="" name="f1" onclick="reserve_service_list('service2_other_list_face','','0')" checked ><em class="font-size-12">선택 안함</em></label></div>
                                                                                </div>
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
                                                                                        <div class="toggle-button-cell" ><label class="form-toggle-box large"><input type="radio" value="" name="beauty" onclick="reserve_service_list('service2_basic_beauty','','0')" checked><em class="font-size-12">선택 안함</em></label></div>
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
                                                                                        <div class="toggle-button-cell" ><label class="form-toggle-box large"><input type="radio" value="" name="bath" onclick="reserve_service_list('service2_basic_bath','','0')" checked><em class="font-size-12">선택 안함</em></label></div>
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

                    if(el.type !== 'mm'){
                        document.getElementById('basic_hair_length').innerHTML += `<div class="toggle-button-cell">
                                                                                            <label class="form-toggle-box form-toggle-price large" for="hairBeauty${i}">
                                                                                                <input type="radio" name="hairBeauty" value="${el.type}"  data-price="${el.price}" id="hairBeauty${i}" onclick="reserve_service_list('service2_basic_hair_length','${el.type}',${el.price})">
                                                                                                <em>
                                                                                                    <span>${el.type}</span>
                                                                                                    <strong>${el.price === '' ? 0 : parseInt(el.price).toLocaleString()}원</strong>
                                                                                                </em>
                                                                                            </label>
                                                                                        </div>`
                    }



                })
            }

            if(body.face.length >0){

                body.face.forEach(function(el,i){

                    document.getElementById('other_face').innerHTML += `<div class="toggle-button-cell">
                                                                                        <label class="form-toggle-box form-toggle-price middle">
                                                                                            <input type="radio" name="f1" data-price="${el.price}" value="${el.type}" onclick="reserve_service_list('service2_other_list_face','+${el.type}',${el.price})">
                                                                                            <em>
                                                                                                <span>${el.type}</span>
                                                                                                <strong>+${el.price === '' ? 0 : parseInt(el.price).toLocaleString()}원</strong>
                                                                                            </em>
                                                                                        </label>
                                                                                    </div>`

                    if(i===body.face.length-1){

                        document.getElementById('service2_other_list').innerHTML += `<div class="service-selected-list-cell">
                                                                                                    <div class="list-title list-data" id="service2_other_list_face"></div>
                                                                                                </div>`
                    }
                })
            }


            if(body.leg.length>0){

                body.leg.forEach(function(el,i){

                    if(el.price === ''){
                        el.price = 0;
                    }
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
                                                                                                    <div class="list-title" id="service2_other_list_leg"></div>
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
                                                                                                    <div class="list-title" id="service2_other_list_spa"></div>
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
                                                                                                    <div class="list-title" id="service2_other_list_dyeing"></div>
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
                                                                                                    <div class="list-title" id="service2_other_list_etc"></div>
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



                document.getElementById('basic_service_select').innerHTML= '<div class="toggle-button-cell" onclick="reserve_merchandise_load_reset(2)"><label class="form-toggle-box large"><input type="radio" value="" name="s1" onclick="reserve_service_list(\'service2_basic_service\',\'\')" checked><em class="font-size-12">선택 안함</em></label></div>';
                document.getElementById('basic_weight').innerHTML = '<div class="toggle-button-cell" id="weight_not_select"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="s2" onclick="reserve_service_list(\'service2_basic_weight\',\'\',\'0\')" checked><em><span class="font-size-12">선택 안함</span></em></label></div>';
                let value = el.children[0].children[0].value;

                base_svc.forEach(function(el_){


                    if(value === el_.size){

                        el_.svc.forEach(function (_el){


                            if(_el.is_show === "y" && _el.unit.length >0){
                                document.getElementById('basic_service_select').innerHTML += `<div class="toggle-button-cell toggle-button-cell-service">
                                                                                                        <label class="form-toggle-box large">
                                                                                                            <input type="radio" value="${_el.type}" data-size="${el_.size}" data-time="${_el.time}" name="s1" onclick="reserve_service_list('service2_basic_service','${_el.type} ${_el.time}분')">
                                                                                                            <em>${_el.type} <br/> ${_el.time}분</em>
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

            document.getElementById('basic_weight').innerHTML= '<div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" data-price="" name="s2" onclick="reserve_service_list(\'service2_basic_weight\',\'\',\'0\')" checked><em><span class="font-size-12">선택 안함</span></em></label></div>'


            let size = el.children[0].children[0].getAttribute('data-size');
            let value = el.children[0].children[0].value;



            let surcharge ;
            base_svc.forEach(function(el_){


                if(el_.size === size){


                    el_.svc.forEach(function(_el){

                        if(_el.type === value){


                            if(_el.unit.length > 0){

                                _el.unit.forEach(function (ele,i){





                                    if(el_.surcharge.is_huge_weight !== 1){
                                        document.getElementById('basic_weight').innerHTML += `<div class="toggle-button-cell">
                                                                                                    <label class="form-toggle-box form-toggle-price large">
                                                                                                        <input type="radio" value="${ele.kg}" name="s2" data-price="${ele.price}"  onclick="reserve_service_list('service2_basic_weight','~${ele.kg}kg',${ele.is_consulting === "0" ? ele.price : '0'})">
                                                                                                            <em>
                                                                                                                <span>~${ele.kg}Kg</span>
                                                                                                            <strong>${ele.is_consulting == "1" ? '상담' :`${parseInt(ele.price).toLocaleString()}원` }</strong>
                                                                                                            
                                                                                                        </em>
                                                                                                    </label>
                                                                                                </div>`
                                    }

                                    if(el_.surcharge.is_huge_weight === 1){

                                        document.getElementById('basic_weight').innerHTML += `<div class="toggle-button-cell">
                                                                                                    <div class="form-toggle-options">
                                                                                                        <input type="radio" name="s2"  id="huge_weight" data-price="${ele.price}" value="huge" onclick="reserve_service_list('service2_basic_weight','~${ele.kg}kg','huge')">
                                                                                                            <div class="form-toggle-options-data">
                                                                                                                <div class="options-labels">
                                                                                                                    <span class="font-size-12">~${ele.kg}kg당</span><strong style="font-size:10px">+${ele.price}원</strong></div>
                                                                                                                <div class="form-amount-input">
                                                                                                                    <button type="button" 
                                                                                                                            class="btn-form-amount-minus" onclick="document.getElementById('reserve_huge_weight').value = parseInt(document.getElementById('reserve_huge_weight').value)-1">감소
                                                                                                                    </button>
                                                                                                                    <div class="form-amount-info">
                                                                                                                        <input type="number" id="reserve_huge_weight" readOnly="" value="1" data-price="${ele.price}"
                                                                                                                               class="form-amount-val">
                                                                                                                    </div>
                                                                                                                    <button type="button" 
                                                                                                                            class="btn-form-amount-plus" onclick="document.getElementById('reserve_huge_weight').value = parseInt(document.getElementById('reserve_huge_weight').value)+1">증가
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                </div>`
                                    }


                                    if(el_.surcharge.is_have ===1 && i === _el.unit.length-1){


                                        let surcharge_kg = el_.surcharge.kg ;
                                        let surcharge_std_price = ele.kg <= surcharge_kg ? ele.price : 0;
                                        localStorage.setItem('surcharge_std_price',surcharge_std_price);
                                        localStorage.setItem('surcharge_kg',surcharge_kg);
                                        localStorage.setItem('surcharge_price',el_.surcharge.price);



                                        document.getElementById('basic_weight').innerHTML += `<div class="toggle-button-cell">
                                                                                                <div class="form-toggle-options">
                                                                                                    <input type="radio" name="s2" name="options1" value="no" id="surcharge" onclick="reserve_service_list('service2_basic_weight','${el_.surcharge.kg}kg~','surcharge')">
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
                                document.getElementById('basic_weight').innerHTML = '<div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="s2" onclick="reserve_service_list(\'service2_basic_weight\',\'\',0)"><em><span class="font-size-12">선택 안함</span></em></label></div>';
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

    return new Promise(function(resolve){

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


        resolve();
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
            let weight_input = document.querySelector('input[name="s2"]:checked');
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


            let worker = document.getElementById('reserveCalendarPop2').getAttribute('data-name');

            if(cellphone === ''){

                document.getElementById('msg1_txt').innerText = '전화번호를 입력해주세요.'
                pop.open('reserveAcceptMsg1');
                return;
            }
            if(worker === '' || worker === null){


                document.getElementById('msg1_txt').innerText = '선생님을 선택해주세요.'
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


            if(weight_input === null){
                document.getElementById('msg1_txt').innerText = '무게를 선택해주세요.'
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
                document.getElementById('notice_check').checked = false;
                document.getElementById('notice_check_span').innerText ='미발송';
            }else{
                pop.open('reserveCalendarPop11');
                document.getElementById('notice_check').checked = true;
                document.getElementById('notice_check_span').innerText ='발송';
            }




        })
    })

}
function reserve_regist(artist_id,session_id){


    let reserve_yn = '';

    if(document.getElementById('notice_check').checked === true){
        reserve_yn = 'Y';
    }else{
        reserve_yn = 'N';

    }

    let deposit_notice = '';

    if(document.getElementById('deposit_check').checked === true){
        deposit_notice = 'Y';

    }else{
        deposit_notice ='N';
    }

    let yesterday = '';

    if(document.getElementById('yesterday_check').checked === true){

        yesterday = 'Y';
    }else{
        yesterday = 'N';
    }


    let customer_id = document.querySelector('input[name="pet_no"]:checked') === null ? '' : document.querySelector('input[name="pet_no"]:checked').getAttribute('data-id');
    let pet_seq = document.querySelector('input[name="pet_no"]:checked') === null ? '' :document.querySelector('input[name="pet_no"]:checked').getAttribute('value')
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
    let bath_input = document.querySelector('input[name="bath"]:checked');

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
        weight_merchandise = weight_input === null ? '' : weight_input.value ==='no' ? `${document.getElementById('weight_target').value}` : weight_input.value === 'huge' ? `${document.getElementById('reserve_huge_weight').value}`:weight_input.value;
        hair_feature = hair_feature_input === null ? '' :hair_feature_input.value;
        hair_length = hair_length_input === null ? '' : hair_length_input.value;


        if(weight_input.value === 'no'){
            weight_price =  parseInt(localStorage.getItem('surcharge_std_price')) + (parseInt(document.getElementById('weight_target').value)- parseInt(localStorage.getItem('surcharge_kg'))) * parseInt(localStorage.getItem('surcharge_price'))
        }else if(weight_input.value ==='huge'){

            weight_price = parseInt(document.getElementById('reserve_huge_weight').value) * parseInt(document.getElementById('reserve_huge_weight').getAttribute('data-price'))
        }else{
            weight_price = weight_input === null ? '' : weight_input.getAttribute('data-price');
        }

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

        arr_hair_feature.push(`${hair_feature_input[i].value}${hair_feature_input[i].getAttribute('data-price') === null ? '':':'}${hair_feature_input[i].getAttribute('data-price') === null ? '' : hair_feature_input[i].getAttribute('data-price')}`)
    }

    let arr_face = [];
    for(let i=0; i<face_input.length;i++){

        arr_face.push(`${face_input[i].value}${face_input[i].getAttribute('data-price') === null ? '' : ':'}${face_input[i].getAttribute('data-price') === null ? '' : face_input[i].getAttribute('data-price')}`);
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

        }else if(el.getAttribute('data-price') === 'huge'){

            total_price += parseInt(document.getElementById('huge_weight').getAttribute('data-price')) * parseInt(document.getElementById('reserve_huge_weight').value);


        }else {
            total_price += parseInt(el.getAttribute('data-price'));

        }

    })


    if(localStorage.getItem('is_vat') === '1'){

        total_price += (total_price/10);
    }


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
            befor_day_alarm_yn : yesterday,
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
            befor_day_alarm_yn : yesterday,
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


            product += `${name}|${breed === 'dog' ? '개' : ''}|${shop_name}|${size}|${service}|${weight_merchandise}:${weight_price === null ? '0' : weight_price}|${arr_face.toString()}|${hair_length}${hair_length_price === null ? '' : ':'}${hair_length_price === null ? '' : hair_length_price}|${arr_hair_feature.toString()}|`;


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

        product += `${name}|${breed === 'cat' ? '고양이': ''}|${shop_name}|${beauty === '' ? '' : '미용'}|all:0|${beauty.replace('_미용','')}:${document.getElementById('service2_basic_beauty').getAttribute('data-price')}|`

        if(document.querySelectorAll('input[name="add_svc"]')[0].checked === true){

            product += `${document.querySelectorAll('input[name="add_svc"]')[0].getAttribute('data-price')}|`
        }else{
            product += `0|`
        }


        if(bath_input.getAttribute('data-price') === "" || bath_input.getAttribute('data-price') === undefined || bath_input.getAttribute('data-price') === null || bath_input.getAttribute('data-price') === '0'){

            product += `0|`;
        }else{

            if(bath_input.value === '단모'){
                product += `${bath_input.getAttribute('data-price')}|`
            }else{
                product += `|`
            }

            if(bath_input.value === '장모'){
                product +=  `${bath_input.getAttribute('data-price')}|`
            }else{
                product += `|`
            }


        }

        let add_svc_count = 0;
        let add_svc_arr = [];

        add_svc_input.forEach(function(el){

            if(el.value !== '발톱'){

                add_svc_count ++;
                add_svc_arr.push(`${el.value}:${el.getAttribute('data-price')}`)

            }
        })

        product += `${add_svc_count}|`

        add_svc_arr.forEach(function(el){

            product += `${el}|`
        })

        product += `0|0|`


    }


    let worker = document.getElementById('reserveCalendarPop2').getAttribute('data-name');


    let deposit_btn = document.getElementById('deposit_btn');

    let is_reserve_pay, reserve_pay_price, reserve_pay_deadline;
    if(deposit_btn.checked === true){

        is_reserve_pay = 1;
        reserve_pay_price = parseInt(document.getElementById('reserve_deposit_input').value);

        let deposit_time = parseInt(document.getElementById('reserve_deposit_time').value);
        let deposit_date = new Date();

        deposit_date.setMinutes(deposit_date.getMinutes() + deposit_time);

        reserve_pay_deadline = `${deposit_date.getFullYear()}-${fill_zero(deposit_date.getMonth()+1)}-${fill_zero(deposit_date.getDate())} ${fill_zero(deposit_date.getHours())}:${fill_zero(deposit_date.getMinutes())}:${fill_zero(deposit_date.getSeconds())}`


    }else{

        is_reserve_pay = 0;
        reserve_pay_price = 0;
        reserve_pay_deadline = '';
    }

    console.log(reserve_pay_deadline);






    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'reserve_regist',
            partner_id : login,
            worker : worker,
            customer_id : customer_id,
            cellphone : cellphone,
            pet_seq : pet_seq,
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
            year:document.getElementById('reserve_time_year').value,
            month:document.getElementById('reserve_time_month').value,
            day:document.getElementById('reserve_time_date').value,
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
            reserve_yn : reserve_yn ,
            aday_ago_yn : yesterday,
            is_reserve_pay : is_reserve_pay,
            reserve_pay_price : reserve_pay_price,
            reserve_pay_deadline : reserve_pay_deadline



        },
        success:function(res){
            console.log(res)
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                let year = document.getElementById('reserve_time_year').value;
                let month = document.getElementById('reserve_time_month').value;
                let day = document.getElementById('reserve_time_date').value;
                let hour = document.getElementById('reserve_st_time').value.split(':')[0];
                let min = document.getElementById('reserve_st_time').value.split(':')[1];

                if(document.getElementById('notice_check').checked === true && document.getElementById('deposit_btn').checked === false){



                    let message = `반려생활의 단짝, 반짝에서 ${cellphone.slice(-4)}님의 ${name} 미용예약 내용을 알려드립니다.\n` +
                        '\n' +
                        `- 예약펫샵 : ${shop_name}\n` +
                        `- 예약일시 : ${year}년 ${month}월 ${day}일 ${hour}시 ${min}분\n` +
                        '\n' +
                        '예약내용 상세확인과 예약은\n' +
                        '반려생활의 단짝, 반짝에서도 가능합니다.';



                    $.ajax({

                        url:'/data/pc_ajax.php',
                        type:'post',
                        data:{

                            mode:'reserve_regist_allim',
                            cellphone:cellphone,
                            message:message,
                            payment_idx:body.idx,


                        },success:function(res){



                        }
                    })




                }else if(document.getElementById('deposit_check').checked === true){

                    let bank = document.getElementById('reserve_deposit_input').getAttribute('data-bank');
                    let account = document.getElementById('reserve_deposit_input').getAttribute('data-account');

                    let deposit_time = parseInt(document.getElementById('reserve_deposit_time').value);
                    let deposit_date = new Date();

                    deposit_date.setMinutes(deposit_date.getMinutes() + deposit_time);

                    let message = `${name} 보호자님\n` +
                        `${shop_name}에서 ${name} 미용예약 확정을 위한 예약금 입금 안내를 드립니다.\n` +
                        '\n' +
                        `저희 ${shop_name}에서는 예약금 ${reserve_pay_price}원 입금 후에 예약이 확정됩니다.\n` +
                        '\n' +
                        '1. 예약내용\n' +
                        `- 예약일시 : ${year}년 ${month}월 ${day}일 ${hour}시 ${min}분\n` +
                        '\n' +
                        '2. 예약금 입금계좌\n' +
                        `- 예약금 : ${reserve_pay_price}원\n` +
                        `- ${bank} / ${account}\n` +
                        `- 결제기한 : ${deposit_date.getFullYear()}년 ${deposit_date.getMonth()+1}월 ${deposit_date.getDate()}일 ${deposit_date.getHours()}시 ${deposit_date.getMinutes()}분\n` +
                        '\n' +
                        '▶ 결제기한 경과시 예약은 자동취소 되오니 기한 내 꼭 입금부탁드립니다. '

                    $.ajax({

                        url:'/data/pc_ajax.php',
                        type:'post',
                        data:{

                            mode:'deposit_allim',
                            cellphone:cellphone,
                            message:message,


                        },success:function(res){



                        }
                    })
                }

                location.reload()




            }

        }
    })



}


function reserve_pop_init(id){

    console.log(id)

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
                            <div class="basic-data-group middle" id="select_pet" style="display: none;">
                                <div class="form-group-item">
                                    <div class="form-item-label">펫 선택</div>
                                    <div class="form-item-data type-2">
                                        <div class="grid-layout basic">
                                            <div class="grid-layout-inner" id="select_pet_list">
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
                            <div class="basic-data-group allimi-wrap-bg-gray" style="width:100%; left:-20px;padding:20px;">
                                <div class="con-title-group" style="justify-content: flex-start; background: transparent">
                                    <h4 class="con-title">예약금 안내발송</h4>
                                    <label for="switch-toggle" class="form-switch-toggle" style="margin-left:10px;"><input type="checkbox" id="deposit_btn" onclick="deposit_background(this); deposit_toggle(artist_id)"><span class="bar"></span></label>
                                    <div class="grid-layout-cell grid-4" style="margin-left:20px;"><button type="button" class="btn btn-outline-gray btn-middle-size btn-round" onclick="pop.open('depositExam');">미리보기</button></div>
                                </div>
                                <div class="form-group" id="deposit_form_1" style="display:none;">
                                    <div class="grid-layout margin-14-17">
                                        <div class="grid-layout-inner">
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">예약금</div>
                                                    <div class="form-item-data type-2">
                                                        <div class="form-datepicker-group">
                                                            <div class="form-datepicker">
                                                                <input type="number" placeholder="최소 예약금은 1천원" min="0" class="deposit_input" id="reserve_deposit_input">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="grid-layout-cell grid-2">
                                                <div class="form-group-item">
                                                    <div class="form-item-label">결제기한 설정</div>
                                                    <div class="form-item-data type-2">
                                                        <div class="form-datepicker-group">
                                                            <div class="form-datepicker">
                                                                <select id="reserve_deposit_time">
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
                <button type="button" class="btn-pop-close" onclick="pop.close2('reserveAcceptUser'); reserve_pop_init('${artist_id}');">닫기</button>
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
    document.getElementById('reserve_deposit_time').innerHTML = '';
    document.getElementById('deposit_time').innerHTML = '';
    document.getElementById('deposit_bank').innerHTML = '';

    for(let i=30; i<=1440; i+=30){
        document.getElementById('reserve_deposit_time').innerHTML += `<option value=${i}>${minutes_to_hour(i)} 이내</option>`
    }

    for(let i=30; i<=1440; i+=30){
        document.getElementById('deposit_time').innerHTML += `<option value=${i}>${minutes_to_hour(i)} 이내</option>`
    }
    banks.forEach(function(el){

        document.getElementById('deposit_bank').innerHTML += `<option value="${el.name}" data-code="${el.code}">${el.name}</option>`
    })


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
                                                                                                    <input name="pet_no" class="pet-no" type="radio" data-id="${el.detail.customer_id}" value="${el.pet_seq}" onclick="exist_user_reserve_('${el.pet_seq}').then(function(body){exist_user_reserve_init(body)})">
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
            }
        }

    })

}

function pay_management_modify_pet(target){


    let pet_seq = target.getAttribute('data-pet_seq');
    return new Promise(function (resolve){


        document.getElementById('modify_special1').checked = false;
        document.getElementById('modify_special2').checked = false;
        document.getElementById('modify_special3').checked = false;
        document.getElementById('modify_special4').checked = false;



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

                    document.getElementById('modify_customer_name').value = body.name;

                    if(body.type === 'dog'){


                        document.getElementById('modify_breed1').click();
                    }else{
                        document.getElementById('modify_breed2').click();

                    }

                    pop.open('petModifyPop');

                    setTimeout(function(){

                        resolve(body);
                    },300)




                }
            }
        })

    })



}
function pay_management_modify_pet_(body){




    for(let i=0; i<document.getElementById('modify_breed_select').options.length; i++){

        if(document.getElementById('modify_breed_select').options[i].value === body.pet_type){

            document.getElementById('modify_breed_select').options[i].selected = true;
        }
    }
    for(let i=0; i<document.getElementById('modify_birthday_year').options.length; i++){

        if(document.getElementById('modify_birthday_year').options[i].value === body.year.toString()){

            document.getElementById('modify_birthday_year').options[i].selected = true;
        }
    }
    for(let i=0; i<document.getElementById('modify_birthday_month').options.length; i++){

        if(document.getElementById('modify_birthday_month').options[i].value === fill_zero(body.month)){

            document.getElementById('modify_birthday_month').options[i].selected = true;
        }
    }
    for(let i=0; i<document.getElementById('modify_birthday_date').options.length; i++){

        if(document.getElementById('modify_birthday_date').options[i].value === fill_zero(body.day)){

            document.getElementById('modify_birthday_date').options[i].selected = true;
        }
    }

    if(body.gender === '남아'){

        document.getElementById('modify_gender1').checked = true;
    }else{
        document.getElementById('modify_gender2').checked = true;

    }

    if(body.neutral === 0){

        document.getElementById('modify_neutralize1').checked = true;
    }else{

        document.getElementById('modify_neutralize2').checked = true;

    }


    for(let i=0; i<document.getElementById('modify_weight1').options.length; i++){

        if(document.getElementById('modify_weight1').options[i].value === body.weight.split('.')[0]){


            document.getElementById('modify_weight1').options[i].selected = true;
        }
    }


    for(let i=0; i<document.getElementById('modify_weight2').options.length; i++){

        if(document.getElementById('modify_weight2').options[i].value === body.weight.split('.')[1]){


            document.getElementById('modify_weight2').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('modify_beauty_exp').options.length; i++){

        if(document.getElementById('modify_beauty_exp').options[i].value === body.beauty_exp){

            document.getElementById('modify_beauty_exp').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('modify_vaccination').options.length; i++){

        if(document.getElementById('modify_vaccination').options[i].value === body.vaccination){

            document.getElementById('modify_vaccination').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('modify_bite').options.length; i++){

        if(document.getElementById('modify_bite').options[i].value === body.bite){

            document.getElementById('modify_bite').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('modify_luxation').options.length; i++){

        if(document.getElementById('modify_luxation').options[i].value === body.luxation){

            document.getElementById('modify_luxation').options[i].selected = true;
        }
    }

    if(body.dermatosis === 1){

        document.getElementById('modify_special1').checked = true;

    }

    if(body.heart_trouble === 1){

        document.getElementById('modify_special2').checked = true;
    }

    if(body.marking === 1){

        document.getElementById('modify_special3').checked = true;
    }

    if(body.mounting === 1){

        document.getElementById('modify_special4').checked = true;
    }

    document.getElementById('modify_pet_info_btn').addEventListener('click',function(){


        modify_pet_info(body)
    },{once:true})


}

function modify_pet_info(body){

    if(document.getElementById('modify_customer_name').value === '' || document.getElementById('modify_customer_name').value === null || document.getElementById('modify_customer_name').value === undefined ){

        document.getElementById('msg1_txt').innerText = '펫 이름을 입력해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }



    if(document.querySelector('input[name="modify_breed"]:checked') === null || document.querySelector('input[name="modify_breed"]:checked') === undefined || document.querySelector('input[name="modify_breed"]:checked') === ''){

        document.getElementById('msg1_txt').innerText = '품종을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }

    if(document.getElementById('modify_breed_select').value === "선택" || document.getElementById('modify_breed_select').value === ''){
        document.getElementById('msg1_txt').innerText = '품종을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;

    }
    if((document.getElementById('modify_breed_select').value === "기타" || document.getElementById('modify_breed_select').value === "") && document.getElementById('modify_breed_other').value === ''){
        document.getElementById('msg1_txt').innerText = '품종을 선택해주세요.'
        pop.open('reserveAcceptMsg1');
        return;

    }

    if(document.getElementById('modify_weight1').value === "0" && document.getElementById('modify_weight2').value ==="0"){

        document.getElementById('msg1_txt').innerText = '몸무게를 입력해주세요.'
        pop.open('reserveAcceptMsg1');
        return;
    }


    let breed = document.getElementById('modify_breed_select').value === '기타' ? document.getElementById('modify_breed_other').value : document.getElementById('modify_breed_select').value;

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:"modify_pet_info",
            idx:body.pet_seq,
            name:document.getElementById('modify_customer_name').value,
            type:document.querySelector('input[name="modify_breed"]:checked').value,
            pet_type:breed,
            year:document.getElementById('modify_birthday_year').value,
            month:document.getElementById('modify_birthday_month').value,
            day:document.getElementById('modify_birthday_date').value,
            gender:document.querySelector('input[name="modify_gender"]:checked') === null ? '0' : document.querySelector('input[name="modify_gender"]:checked').value,
            neutral:document.querySelector('input[name="modify_neutralize"]:checked') === null ? '0' : document.querySelector('input[name="modify_neutralize"]:checked').value,
            weight:`${document.getElementById('modify_weight1').value}.${document.getElementById('modify_weight2').value}`,
            beauty_exp : document.getElementById('modify_beauty_exp').value,
            vaccination : document.getElementById('modify_vaccination').value,
            luxation : document.getElementById('modify_luxation').value,
            bite : document.getElementById('modify_bite').value,
            dermatosis:document.getElementById('modify_special1').checked === true ? 1:0,
            heart_trouble:document.getElementById('modify_special2').checked === true ? 1:0,
            marking:document.getElementById('modify_special3').checked === true ? 1:0,
            mounting:document.getElementById('modify_special4').checked === true ? 1:0,
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

function customer_memo(target,id){

    let scm_seq = document.getElementById('pay_customer_memo_text').getAttribute('data-scm_seq');
    let memo = document.getElementById('pay_customer_memo_text').value;

    let customer_id = target.getAttribute('data-customer_id');
    let tmp_id = target.getAttribute('data-tmp_id');
    let cellphone = target.getAttribute('data-cellphone');

    if(scm_seq === '' || scm_seq === null){

        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{

                mode:'customer_memo_sql',
                artist_id:id,
                customer_id:customer_id,
                tmp_seq:tmp_id,
                cellphone:cellphone,
                comment:document.getElementById('pay_customer_memo_text').value,

            },
            success:function(res) {

                    document.getElementById('msg2_txt').innerText = '견주 메모가 변경되었습니다.'
                    pop.open('reserveAcceptMsg2');

            }
        })

    }else{
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


                    document.getElementById('msg2_txt').innerText = '견주 메모가 변경되었습니다.'
                    pop.open('reserveAcceptMsg2');
                }
            }
        })

    }



}

function payment_memo(){

    let idx = localStorage.getItem('payment_idx');
    let memo = document.getElementById('pay_special_memo_text').value;

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


                document.getElementById('msg2_txt').innerText = '특이사항이 변경되었습니다.'
                pop.open('reserveAcceptMsg2');
            }
        }
    })

}

function reserve_cancel(bool,target){

    let idx = localStorage.getItem('payment_idx');

    let cellphone = target.getAttribute('data-cellphone');
    let pet_name = target.getAttribute('data-pet_name');

    let beauty_date = new Date(target.getAttribute('data-beauty_date').replace(' ','T'));



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


                if(bool){

                    let message = `반려생활의 단짝, 반짝에서 ${cellphone.slice(-4)}님의 ${pet_name} 미용예약이 취소되었음을 알려드립니다.\n` +
                        '\n' +
                        `- 취소일시 : ${new Date().getFullYear()}년 ${new Date().getMonth()+1}월 ${new Date().getDate()}일 ${new Date().getHours()}시 ${new Date().getMinutes()}분\n` +
                        '\n' +
                        `- 예약펫샵 : ${data.shop_name}\n` +
                        `- 예약일시 : ${beauty_date.getFullYear()}년 ${beauty_date.getMonth()+1}월 ${beauty_date.getDate()}일 ${beauty_date.getHours()}시 ${beauty_date.getMinutes()}분\n` +
                        '\n' +
                        '\n' +
                        '취소내역 상세확인은\n' +
                        '반려생활의 단짝, 반짝에서도 가능합니다.'

                    $.ajax({

                        url:'/data/pc_ajax.php',
                        type:'post',
                        data:{
                            mode:'reserve_cancel_allim',
                            cellphone:cellphone,
                            payment_idx:idx,
                            message:message



                        }
                    })


                }

                location.reload();
            }
        }
    })
}


function set_change_time(bool,target){


    let idx = localStorage.getItem('payment_idx');

    let a_date = target.getAttribute('data-a_date');
    let name = target.getAttribute('data-name');


    let a_year = a_date.split(' ')[0].split('-')[0]
    let a_month = a_date.split(' ')[0].split('-')[1]
    let a_day = a_date.split(' ')[0].split('-')[2]
    let a_hour = a_date.split(' ')[1].split(':')[0]
    let a_min = a_date.split(' ')[1].split(':')[1]

    let cellphone = target.getAttribute('data-cellphone');
    let st_time = document.getElementById('start_time').value;
    let b_hour = st_time.substr(0,2);
    let b_min = st_time.substr(2,2);
    let fi_time = document.getElementById('end_time').value;


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

                if(bool){

                    let message = `반려생활의 단짝, 반짝에서 ${cellphone.slice(-4)}님의 ${name} 미용예약 변경 내용을 알려드립니다.\n` +
                        '\n' +
                        `- 예약펫샵 : ${data.shop_name}\n` +
                        `- 기존예약 : ${a_year}년 ${a_month}월 ${a_day}일 ${a_hour}시 ${a_min}분\n` +
                        `- 변경일시 : ${a_year}년 ${a_month}월 ${a_day}일 ${b_hour}시 ${b_min}분\n` +
                        '\n' +
                        '예약내용 상세 확인과 예약은\n' +
                        '반려생활의 단짝, 반짝에서도 가능합니다.'

                    $.ajax({

                        url:'/data/pc_ajax.php',
                        type:'post',
                        data:{

                            mode:'reserve_regist_change_allim',
                            cellphone:cellphone,
                            message:message,
                            payment_idx:idx,


                        }
                    })


                }

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

function beauty_gallery_get(target,id){





    return new Promise(function(resolve){


        let idx = target.getAttribute('data-payment_idx');
        let pet_seq = target.getAttribute('data-pet_idx');


        document.getElementById('beauty_gal_wrap').innerHTML =`<div class="list-cell"><a href="#" class="btn-gate-picture-register"
                                                                                                          onClick="MemofocusNcursor()"><span><em>이미지 추가</em></span></a></div>
                                                                        <div style="display:block;position:absolute;top:-50px;"><input type="file" accept="image/*" name="imgupfile"
                                                                                                                                       id="addimgfile"></div>`
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
                    if(body.length === undefined){

                        body = [body];
                    }


                    // let file_path = '';
                    //
                    // if(body.length >0){
                    //     file_path = `https://image.banjjakpet.com${body[0].file_path}`
                    //
                    // }
                    // else{
                    //
                    //     if(_data.photo !== ''){
                    //         document.getElementById('beauty_img_target').setAttribute('src', `https://image.banjjakpet.com${_data.photo}`)
                    //
                    //     }else{
                    //
                    //
                    //
                    //         if(_data.type === 'dog'){
                    //             file_path = `/static/images/icon/icon-pup-select-off.png`
                    //             document.getElementById('beauty_img_target').setAttribute('src', file_path)
                    //         }else{
                    //             file_path = `/static/images/icon/icon-cat-select-off.png`
                    //             document.getElementById('beauty_img_target').setAttribute('src', file_path)
                    //         }
                    //     }
                    //
                    // }


                    body.forEach(function(el){


                        document.getElementById('beauty_gal_wrap').innerHTML += `<div class="list-cell">
                                                                                <div class="picture-thumb-view">
                                                                                    <div class="picture-obj" onclick="show_image('https://image.banjjakpet.com${el.file_path.replace('/pet/','/')}')"><img src="https://image.banjjakpet.com${el.file_path.replace('/pet/','/')}" alt=""></div>
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

                    pop.open('reserveBeautyGalleryPop');

                    resolve(pet_seq);
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


function agree_view_birthday(){

    return new Promise(function(resolve){

        for(let i = 2000; i<=new Date().getFullYear(); i++){

            document.getElementById('agree_view_birthday_year').innerHTML += `<option value="${fill_zero(i)}" ${i===2022 ? 'selected':''}>${i}</option>`
        }


        for(let i = 1; i<=12; i++){
            document.getElementById('agree_view_birthday_month').innerHTML += `<option value="${fill_zero(i)}">${i}</option>`
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

function agree_view_birthday_date(){

    let year = document.getElementById('agree_view_birthday_year').value;
    let month = document.getElementById('agree_view_birthday_month').value;

    let date_length = new Date(year,month,0).getDate();
    document.getElementById('agree_view_birthday_date').innerHTML = '';
    for(let i = 1; i<=date_length; i++){
        document.getElementById('agree_view_birthday_date').innerHTML += `<option value="${fill_zero(i)}">${i}</option>`

    }

    Array.from(document.getElementsByClassName('agree_view_birthday')).forEach(function(el){

        el.addEventListener('change',function(){

            year = document.getElementById('agree_view_birthday_year').value;
            month = document.getElementById('agree_view_birthday_month').value;

            date_length = new Date(year,month,0).getDate();
            document.getElementById('agree_view_birthday_date').innerHTML = '';
            for(let i = 1; i<=date_length; i++){
                document.getElementById('agree_view_birthday_date').innerHTML += `<option value="${i}">${i}</option>`

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



function agree_view_pet_type(){
    let breed_input;

    let breed;

    let breed_select = document.getElementById('agree_view_breed_select')

    breed_select.addEventListener('change',function(){
        if(breed_select.options[breed_select.selectedIndex].value === "기타"){

            document.getElementById('agree_view_breed_other_box').setAttribute('style','display:block');
        }else{
            document.getElementById('agree_view_breed_other_box').setAttribute('style','display:none');
        }

    })
    Array.from(document.getElementsByClassName('agree_view_load-pet-type')).forEach(function(el){


        el.addEventListener('click',function(){
            document.getElementById('agree_view_breed_other_box').setAttribute('style','display:none');
            breed_input = document.querySelector('input[name="agree_view_breed"]:checked');
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
                        document.getElementById('agree_view_breed_select').innerHTML = '<option value="선택">선택</option>';
                        body.forEach(function(el){


                            if(el.name !== "기타"){
                                document.getElementById('agree_view_breed_select').innerHTML += `<option value="${el.name}">${el.name}</option>`
                            }


                        })

                        document.getElementById('agree_view_breed_select').innerHTML += '<option value="기타">기타</option>';




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


function beauty_agree_view_init(data){


    return new Promise(function(resolve){


        document.getElementById('agree_view_cellphone').value = data.cell_phone;

        if(data.type==='dog'){

            document.getElementById('agree_view_breed1').click();
        }else{

            document.getElementById('agree_view_breed2').click();
        }

        setTimeout(function(){

            resolve(data)
        },300);








    })


}
function beauty_agree_init_(_data){

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




}


function beauty_agree_view_init_(_data){


    document.getElementById('agree_view_info').innerText = `${data.shop_name}은(는) 미용요청견(묘)의 나이가 10세 이상인 노령견(묘)이나, 질병이 있는 경우 건강상태를 고려하여 안내사항을 말씀드리고, 미용 동의서를 받고자 합니다.`


    for(let i=0; i<document.getElementById('agree_view_breed_select').options.length; i++){

        if(document.getElementById('agree_view_breed_select').options[i].value === _data.pet_type){

            document.getElementById('agree_view_breed_select').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('agree_view_birthday_year').options.length; i++){

        if(document.getElementById('agree_view_birthday_year').options[i].value === _data.birth.split('-')[0]){

            document.getElementById('agree_view_birthday_year').options[i].selected = true;
        }
    }

    for(let i=0; i<document.getElementById('agree_view_birthday_month').options.length; i++){

        if(document.getElementById('agree_view_birthday_month').options[i].value === _data.birth.split('-')[1]){

            document.getElementById('agree_view_birthday_month').options[i].selected = true;
        }
    }    for(let i=0; i<document.getElementById('agree_view_birthday_date').options.length; i++){

        if(document.getElementById('agree_view_birthday_date').options[i].value === _data.birth.split('-')[2]){

            document.getElementById('agree_view_birthday_date').options[i].selected = true;
        }
    }

    if(_data.gender === '남아'){

        document.getElementById('agree_view_gender1').checked = true;
    }else{

        document.getElementById('agree_view_gender2').checked = true;
    }


    if(_data.neutral === 0){

        document.getElementById('agree_view_neutralize1').checked = true;
    }else{

        document.getElementById('agree_view_neutralize2').checked=true;
    }



    for(let i=0; i<document.getElementById('agree_view_vaccination').options.length; i++){

        if(document.getElementById('agree_view_vaccination').options[i].value === _data.vaccination){

            document.getElementById('agree_view_vaccination').options[i].selected = true;
        }
    }

    if(_data.heart_trouble === 1){

        document.getElementById('agree_view_disease2').checked = true;
    }

    if(_data.dermatosis === 1){

        document.getElementById('agree_view_disease3').checked =true;
    }

    if(_data.bite == 1 || _data.bite === "해요"){

        document.getElementById('agree_view_special1').checked =true;
    }

    if(_data.marking === 1){

        document.getElementById('agree_view_special2').checked = true;
    }

    if(_data.mounting === 1){

        document.getElementById('agree_view_special3').checked = true;
    }

    for (let i =0; i<document.getElementById('agree_view_luxation').options.length; i++){

        if(document.getElementById('agree_view_luxation').options[i].value === _data.luxation){

            document.getElementById('agree_view_luxation').options[i].selected = true;
        }
    }




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

    let pet_name = document.getElementById('agree_pet_name') ? document.getElementById('agree_pet_name').value : document.getElementById('pay_pet_name').value;

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
                //console.log(body)


                let message = `반려생활의 단짝, 반짝에서 ${cellphone.slice(-4)}님이 작성해주신 미용동의서를 공유해 드립니다.\n` +
                    '\n' +
                    `- 이용샵 : ${data.shop_name}\n` +
                    `- 펫 이름 : ${pet_name} \n` +
                    `- 작성일시 : ${new Date().getFullYear()}년 ${new Date().getMonth()+1}월 ${new Date().getDate()}일 ${new Date().getHours()}시 ${new Date().getMinutes()}분\n` +
                    '\n' +
                    '자세히 보기를 클릭하시면 미용동의서 원본을 확인하실 수 있습니다.'

                $.ajax({

                    url:'/data/pc_ajax.php',
                    type:'post',
                    data:{

                        mode:'beauty_gal_allim',
                        cellphone:cellphone,
                        message:message,
                        idx:body.idx

                    },success:function(res){
                        //console.log(res)
                    }


                })




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
    let cellphone = document.querySelector('input[name="log_cellphone"]').value;
    let name = document.querySelector('input[name="log_pet_name"]').value;

    let a_year = document.querySelector('input[name="log_a_year"]').value;
    let a_month = document.querySelector('input[name="log_a_month"]').value;
    let a_day = document.querySelector('input[name="log_a_date"]').value;
    let a_hour = document.querySelector('input[name="log_a_start_hour"]').value;
    let a_min = document.querySelector('input[name="log_a_start_min"]').value;


    let send = document.querySelector('input[name="log_msg_send"]:checked').value;

    if(send === 'Y'){

        let message = `반려생활의 단짝, 반짝에서 ${cellphone.slice(-4)}님의 ${name} 미용예약 변경 내용을 알려드립니다.\n` +
            '\n' +
            `- 예약펫샵 : ${data.shop_name}\n` +
            `- 기존예약 : ${a_year}년 ${a_month}월 ${a_day}일 ${a_hour}시 ${a_min}분\n` +
            `- 변경일시 : ${year}년 ${month}월 ${date}일 ${st_time.substr(0,2)}시 ${st_time.substr(2,2)}분\n` +
            '\n' +
            '예약내용 상세 확인과 예약은\n' +
            '반려생활의 단짝, 반짝에서도 가능합니다.'

        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{

                mode:'reserve_regist_change_allim',
                cellphone:cellphone,
                message:message,
                payment_idx:idx,


            }
        })
    }


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
function tooltip(arr){

    arr.forEach(function(el){

        $.ajax({
            url: '../data/pc_ajax.php',
            data: {
                mode: "get_tooltip",
                payment_idx: el,
            },
            type: 'POST',
            success: function (res) {
                //
                let response = JSON.parse(res);
                //////console.log(response);
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


            if(el.getAttribute('data-payment_idx') === localStorage.getItem('payment_idx')){


                el.style.border = 'red dotted'
                el.classList.add('change_target')
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
function target_event(target){



    Array.from(document.getElementsByClassName('btn-tab-item-add')).forEach(function(el_){

        el_.parentElement.classList.remove('actived');
    })

    target.parentElement.classList.add('actived');



    if(target.getAttribute('id') === 'payment_basic_service_btn' && target.getAttribute('data-type') === 'dog'){

        document.getElementById('payment_basic_service').style.display = 'block';
        document.getElementById('payment_other_service').style.display = 'none';
        document.getElementById('payment_basic_service_cat').style.display = 'none';
        document.getElementById('payment_other_service_cat').style.display = 'none';
        document.getElementById('other2_service').style.display = 'none';
        document.getElementById('other3_service').style.display = 'none';


    }else if(target.getAttribute('id') === 'payment_other_service_btn' && target.getAttribute('data-type') === 'dog'){
        document.getElementById('payment_basic_service').style.display = 'none';
        document.getElementById('payment_other_service').style.display = 'block';
        document.getElementById('payment_basic_service_cat').style.display = 'none';
        document.getElementById('payment_other_service_cat').style.display = 'none';
        document.getElementById('other2_service').style.display = 'none';
        document.getElementById('other3_service').style.display = 'none';

    }else if(target.getAttribute('id')==='payment_other2_service_btn'){

        document.getElementById('payment_basic_service').style.display = 'none';
        document.getElementById('payment_other_service').style.display = 'none';
        document.getElementById('payment_basic_service_cat').style.display = 'none';
        document.getElementById('payment_other_service_cat').style.display = 'none';
        document.getElementById('other2_service').style.display = 'block';
        document.getElementById('other3_service').style.display = 'none';
    }else if(target.getAttribute('id') === 'payment_other3_service_btn'){

        document.getElementById('payment_basic_service').style.display = 'none';
        document.getElementById('payment_other_service').style.display = 'none';
        document.getElementById('payment_basic_service_cat').style.display = 'none';
        document.getElementById('payment_other_service_cat').style.display = 'none';
        document.getElementById('other2_service').style.display = 'none';
        document.getElementById('other3_service').style.display = 'block';
    }else if(target.getAttribute('id') === 'payment_other_service_btn' && target.getAttribute('data-type') === 'cat'){
        document.getElementById('payment_basic_service').style.display = 'none';
        document.getElementById('payment_other_service').style.display = 'none';
        document.getElementById('payment_basic_service_cat').style.display = 'none';
        document.getElementById('payment_other_service_cat').style.display = 'block';
        document.getElementById('other2_service').style.display = 'none';
        document.getElementById('other3_service').style.display = 'none';


    }else if(target.getAttribute('id') === 'payment_basic_service_btn' && target.getAttribute('data-type') === 'cat'){
        document.getElementById('payment_basic_service').style.display = 'none';
        document.getElementById('payment_other_service').style.display = 'none';
        document.getElementById('payment_basic_service_cat').style.display = 'block';
        document.getElementById('payment_other_service_cat').style.display = 'none';
        document.getElementById('other2_service').style.display = 'none';
        document.getElementById('other3_service').style.display = 'none';


    }

}

function management_wide_tab2(){

    Array.from(document.getElementsByClassName('btn-tab-item-add')).forEach(function(el){

        el.addEventListener('click',target_event(el))
    })
}
function management_service_1(id,breed){

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


        let type = breed;

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
                    if(body.is_vat == 0){

                        localStorage.setItem('is_vat','0');
                    }else if(body.is_vat == 1){
                        localStorage.setItem('is_vat','1');
                    }else{
                        localStorage.setItem('is_vat','0')
                    }

                    let service = document.getElementById('service');
                    let service2 = document.getElementById('service2');
                    let basic_service_inner = document.getElementById('payment_basic_service_inner');
                    let basic_service_inner_cat = document.getElementById('payment_basic_service_inner_cat');
                    let other_service_inner = document.getElementById('payment_other_service_inner');
                    let other_service_inner_cat = document.getElementById('payment_other_service_inner_cat');
                    let other2_service_inner = document.getElementById('other2_service_inner');
                    let other3_service_inner = document.getElementById('other3_service_inner');


                    //
                    // basic_service_inner.innerHTML = '';
                    // other_service_inner.innerHTML ='';

                    if(type === 'dog'){

                        if(body.base_svc.length > 0){

                            basic_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label font-size-12 display_flex_ju_center" >크기 선택</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="payment_basic_size">
                                                                          <div class="toggle-button-cell" onclick="reserve_merchandise_load_reset_(1); "><label class="form-toggle-box large"><input type="radio" value="" name="payment_size" onclick="set_product2(this,'','','list_title_3',true)" checked><em class="font-size-12">선택 안함</em></label></div>
                                                                     
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label font-size-12 display_flex_ju_center">서비스</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="payment_basic_service_select">
                                                                              <div class="toggle-button-cell" onclick="reserve_merchandise_load_reset_(2)"><label class="form-toggle-box large"><input type="radio" value="" name="payment_s1" checked  onclick="set_product2(this,'','','list_title_3',true)"><em class="font-size-12">선택 안함</em></label></div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <div class="grid-layout-cell grid-5">
                                                                <div class="form-group-item">
                                                                    <div class="form-item-label font-size-12 display_flex_ju_center">무게</div>
                                                                    <div class="form-item-data type-2">
                                                                        <div class="toggle-button-group vertical" id="payment_basic_weight">
                                                                            <div class="toggle-button-cell" id="payment_weight_not_select"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="payment_s2" checked onclick="set_product2(this,'','','list_title_3',true)"><em><span class="font-size-12">선택 안함</span></em></label></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>`
                        }


                        if(body.hair_feature.length > 0){


                            basic_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                        <div class="form-group-item">
                                                                            <div class="form-item-label font-size-12 display_flex_ju_center">털특징</div>
                                                                            <div class="form-item-data type-2">
                                                                                <div class="toggle-button-group vertical" id="payment_basic_hair_feature">
                                                                             </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>`
                        }

                        if(body.hair_length.length > 0){



                            basic_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label font-size-12 display_flex_ju_center">미용털길이</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="payment_basic_hair_length">
                                                                            <div class="toggle-button-cell" ><label class="form-toggle-box large"><input type="radio" value="" name="payment_hairBeauty" onclick="set_product2(this,'','','list_title_2',true)" checked ><em class="font-size-12">선택 안함</em></label></div>
                                                                                </div>
                                                                        </div>
                                                                    </div>
                                                                </div>`

                        }

                        if(body.face.length > 0){

                            other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label font-size-12 display_flex_ju_center">얼굴컷</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="payment_other_face">
                                                                                <div class="toggle-button-cell" ><label class="form-toggle-box large"><input type="radio" value="" name="payment_f1" onclick="set_product2(this,'','','list_title_4',true)" checked ><em class="font-size-12">선택 안함</em></label></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>`
                        }

                        if(body.leg.length > 0){


                            other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                        <div class="form-group-item">
                                                                            <div class="form-item-label font-size-12 display_flex_ju_center" >다리</div>
                                                                            <div class="form-item-data type-2">
                                                                                <div class="toggle-button-group vertical" id="payment_other_leg">
                
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>`
                        }

                        if(body.spa.length > 0){

                            other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label font-size-12 display_flex_ju_center">스파</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="payment_other_spa">
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>`
                        }

                        if(body.dyeing.length > 0){


                            other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label font-size-12 display_flex_ju_center">염색</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="payment_other_dyeing">
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>`
                        }

                        if(body.etc.length > 0){

                            other_service_inner.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                        <div class="form-group-item">
                                                                            <div class="form-item-label font-size-12 display_flex_ju_center">기타</div>
                                                                            <div class="form-item-data type-2">
                                                                                <div class="toggle-button-group vertical" id="payment_other_etc">
                                                                                   
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>`

                        }
                    }else if(type === 'cat'){
                        if(array_empty(body)){
                            return;
                        }
                        if(body.beauty.length > 0){

                            basic_service_inner_cat.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                            <div class="form-group-item">
                                                                                <div class="form-item-label font-size-12 display_flex_ju_center">미용</div>
                                                                                <div class="form-item-data type-2">
                                                                                    <div class="toggle-button-group vertical" id="payment_basic_beauty">
                                                                                        <div class="toggle-button-cell" ><label class="form-toggle-box large"><input type="radio" value="" name="payment_beauty" checked><em class="font-size-12">선택 안함</em></label></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>`
                        }

                        if(body.bath.length > 0){


                            basic_service_inner_cat.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                            <div class="form-group-item">
                                                                                <div class="form-item-label font-size-12 display_flex_ju_center">목욕</div>
                                                                                <div class="form-item-data type-2">
                                                                                    <div class="toggle-button-group vertical" id="payment_basic_bath">
                                                                                        <div class="toggle-button-cell" ><label class="form-toggle-box large"><input type="radio" value="" name="payment_bath" checked><em class="font-size-12">선택 안함</em></label></div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>`
                        }

                        if(body.add_svc.length > 0){


                            other_service_inner_cat.innerHTML += `<div class="grid-layout-cell grid-5">
                                                                    <div class="form-group-item">
                                                                        <div class="form-item-label font-size-12 display_flex_ju_center">추가서비스</div>
                                                                        <div class="form-item-data type-2">
                                                                            <div class="toggle-button-group vertical" id="payment_other_add_svc">
                                                                                
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


    console.log(body)
    return new Promise(function(resolve){

        document.getElementById('is_vat').value = body.is_vat;

        if(body.base_svc !== undefined){
            if(body.base_svc.length > 0){


                body.base_svc.forEach(function(el){

                    document.getElementById('payment_basic_size').innerHTML += `<div class="toggle-button-cell pay-toggle-button-cell-size" data-value="${el.size}">
                                                                                        <label class="form-toggle-box large">
                                                                                            <input type="radio" id="${el.size}" value="${el.size}" name="payment_size">
                                                                                            <em class="font-size-12">${el.size}</em>
                                                                                        </label>
                                                                                    </div>`

                })
            }

            if(body.hair_feature.length > 0){

                body.hair_feature.forEach(function(el,i){

                    if(el.price !== ''){

                        document.getElementById('payment_basic_hair_feature').innerHTML += `<div class="toggle-button-cell">
                                                                                                    <label class="form-toggle-box form-toggle-price large" for="payment_hair${i}">
                                                                                                        <input type="checkbox" id="${el.type.replaceAll('_','')}" name="payment_hair" value="${el.type}" data-price="${el.price}" id="payment_hair${i}" onclick="set_product(this,'${el.type}','${el.price.toLocaleString()}')">
                                                                                                        <em>
                                                                                                            <span style="${el.type.length > 5 ? 'font-size:10px' : 'font-size:12px'}" >${el.type}</span>
                                                                                                            <strong style="${el.type.length > 5 ? 'font-size:10px' : 'font-size:12px'}" >+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                                        </em>
                                                                                                    </label>
                                                                                                </div>`

                    }


                })
            }

            if(body.hair_length.length > 0){


                body.hair_length.forEach(function(el,i){

                    if(el.type !=='mm'){
                        document.getElementById('payment_basic_hair_length').innerHTML += `<div class="toggle-button-cell">
                                                                                            <label class="form-toggle-box form-toggle-price large" for="payment_hairBeauty${i}">
                                                                                                <input type="radio" id="${el.type}${el.price}" name="payment_hairBeauty" value="${el.type}"  data-price="${el.price}" id="payment_hairBeauty${i}" onclick="set_product2(this,'${el.type}','${el.price.toLocaleString()}','list_title_2',true)">
                                                                                                <em>
                                                                                                    <span class="font-size-12">${el.type}</span>
                                                                                                    <strong class="font-size-12">${el.price === '' ? 0 : parseInt(el.price).toLocaleString()}원</strong>
                                                                                                </em>
                                                                                            </label>
                                                                                        </div>`
                    }


                })
            }

            if(body.face.length >0){

                body.face.forEach(function(el,i){

                    document.getElementById('payment_other_face').innerHTML += `<div class="toggle-button-cell">
                                                                                        <label class="form-toggle-box form-toggle-price middle">
                                                                                            <input type="radio" id="${el.type}" name="payment_f1" data-price="${el.price}" value="${el.type}" onclick="set_product2(this,'${el.type}','${el.price}','list_title_4',true)" >
                                                                                            <em>
                                                                                                <span class="font-size-12">${el.type}</span>
                                                                                                <strong class="font-size-12">+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                            </em>
                                                                                        </label>
                                                                                    </div>`

                })
            }


            if(body.leg.length>0){

                body.leg.forEach(function(el,i){

                    if(el.price === ''){
                        el.price = 0;
                    }
                        document.getElementById('payment_other_leg').innerHTML += `<div class="toggle-button-cell">
                                                                                    <label class="form-toggle-box form-toggle-price middle">
                                                                                        <input type="checkbox" id="${el.type}" name="payment_f2" value="${el.type}" data-price="${el.price}" onclick="set_product(this,'${el.type}','${el.price}')" >
                                                                                        <em>
                                                                                            <span class="font-size-12">${el.type}</span>
                                                                                            <strong class="font-size-12">+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                        </em>
                                                                                    </label>
                                                                                </div>`







                })
            }

            if(body.spa.length>0){

                body.spa.forEach(function(el,i){

                    document.getElementById('payment_other_spa').innerHTML += `<div class="toggle-button-cell">
                                                                                    <label class="form-toggle-box form-toggle-price middle">
                                                                                        <input type="checkbox" id="${el.type}" name="payment_f3"  value="${el.type}" data-price="${el.price}" onclick="set_product(this,'${el.type}','${el.price}')"> 
                                                                                        <em>
                                                                                            <span style="${el.type.length < 5 ? 'font-size:12px' : el.type.length > 10 ? 'font-size:8px' : 'font-size:12px'}">${el.type}</span>
                                                                                            <strong style="${el.type.length > 5 ? 'font-size:10px' : 'font-size:12px'}">+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                        </em>
                                                                                    </label>
                                                                                </div>`

                })
            }

            if(body.dyeing.length >0 ){

                body.dyeing.forEach(function(el,i){

                    document.getElementById('payment_other_dyeing').innerHTML += `<div class="toggle-button-cell">
                                                                                        <label class="form-toggle-box form-toggle-price middle">
                                                                                            <input type="checkbox" id="${el.type}" name="payment_f4" value="${el.type}" data-price="${el.price}" onclick="set_product(this,'${el.type}','${el.price}')">
                                                                                            <em>
                                                                                                <span class="font-size-12">${el.type}</span>
                                                                                                <strong class="font-size-12">+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                            </em>
                                                                                        </label>
                                                                                    </div>`

                })
            }


            if(body.etc.length >0){

                body.etc.forEach(function(el,i){

                    document.getElementById('payment_other_etc').innerHTML += `<div class="toggle-button-cell">
                                                                            <label class="form-toggle-box form-toggle-price middle">
                                                                                <input type="checkbox" id="${el.type}" name="payment_f5" value="${el.type}" data-price="${el.price}" onclick="set_product(this,'${el.type}','${el.price}')">
                                                                                <em>
                                                                                    <span class="font-size-12">${el.type}</span>
                                                                                    <strong class="font-size-12">+${parseInt(el.price).toLocaleString()}원</strong>
                                                                               </em>
                                                                            </label>
                                                                        </div>`


                })


            }







        }else {


            if(body.beauty.length > 0){

                body.beauty.forEach(function(el){

                    document.getElementById('payment_basic_beauty').innerHTML += `<div class="toggle-button-cell">
                                                                                        <label class="form-toggle-box large form-toggle-price">
                                                                                            <input type="radio" id="${el.type}" value="${el.type}" name="payment_beauty" data-price="${el.price}" onclick="set_product(this,'${el.type}','${el.price}')">
                                                                                            <em> 
                                                                                                <span class="font-size-12">${el.type}</span>
                                                                                                <strong class="font-size-12">+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                            </em>
                                                                                        </label>
                                                                                    </div>`

                })
            }

            if(body.bath.length >0){

                body.bath.forEach(function(el){

                    document.getElementById('payment_basic_bath').innerHTML += `<div class="toggle-button-cell">
                                                                                        <label class="form-toggle-box large form-toggle-price">
                                                                                            <input type="radio" id="${el.type}" value="${el.type}" name="payment_bath" data-price="${el.price}" onclick="set_product(this,'${el.type}','${el.price}')">
                                                                                            <em> 
                                                                                                <span class="font-size-12">${el.type}</span>
                                                                                                <strong class="font-size-12">+${parseInt(el.price).toLocaleString()}원</strong>
                                                                                            </em>
                                                                                        </label>
                                                                                    </div>`
                })
            }


            if(body.add_svc.length > 0 ){

                body.add_svc.forEach(function(el,i){

                    document.getElementById('payment_other_add_svc').innerHTML += `<div class="toggle-button-cell">
                                                                            <label class="form-toggle-box form-toggle-price middle">
                                                                                <input type="checkbox" id="${el.type}" name="payment_add_svc" value="${el.type}" data-price="${el.price}" onclick="set_product(this,'${el.type}','${el.price}')">
                                                                                <em>
                                                                                    <span class="font-size-12">${el.type}</span>
                                                                                    <strong class="font-size-12">+${parseInt(el.price).toLocaleString()}원</strong>
                                                                               </em>
                                                                            </label>
                                                                        </div>`


                })
            }


        }

        if(body.base_svc !== undefined){
            resolve(body.base_svc);
        }else{
            resolve();
        }

    })


}

function management_service_3(base_svc){



    return new Promise(function (resolve){
        //console.log(base_svc)

        Array.from(document.getElementsByClassName('pay-toggle-button-cell-size')).forEach(function(el){




            el.addEventListener('click',function(){

                document.getElementById('payment_basic_service_select').innerHTML= '<div class="toggle-button-cell" onclick="reserve_merchandise_load_reset_(2)"><label class="form-toggle-box large"><input type="radio" value="" name="payment_s1" checked><em class="font-size-12">선택 안함</em></label></div>';
                document.getElementById('payment_basic_weight').innerHTML = '<div class="toggle-button-cell" id="payment_weight_not_select"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="payment_s2" checked><em><span class="font-size-12">선택 안함</span></em></label></div>';
                let value = el.getAttribute('data-value');

                base_svc.forEach(function(el_){


                    if(value === el_.size ){

                        el_.svc.forEach(function (_el){

                            if(_el.is_show === "y" && _el.unit.length >0){
                                document.getElementById('payment_basic_service_select').innerHTML += `<div class="toggle-button-cell toggle-button-cell-service">
                                                                                                        <label class="form-toggle-box large">
                                                                                                            <input type="radio" id="${_el.type}" value="${_el.type}" data-size="${el_.size}" data-time="${_el.time}" name="payment_s1">
                                                                                                            <em class="font-size-12">${_el.type} <br> ${_el.time}분</em>
                                                                                                        </label>
                                                                                                    </div>`
                            }



                        })
                    }

                })




                management_service_4(base_svc);


            })
            resolve(base_svc)
        })


    })





}

function management_service_4(base_svc){


    return new Promise(function(resolve){




        Array.from(document.getElementsByClassName('toggle-button-cell-service')).forEach(function(el){


            el.addEventListener('click',function (){

                document.getElementById('payment_basic_weight').innerHTML= '<div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" data-price="" name="payment_s2"><em><span class="font-size-12">선택 안함</span></em></label></div>'


                let size = el.children[0].children[0].getAttribute('data-size');
                let value = el.children[0].children[0].value;



                let surcharge ;
                base_svc.forEach(function(el_){


                    if(el_.size === size){


                        el_.svc.forEach(function(_el){

                            if(_el.type === value){


                                if(_el.unit.length > 0){

                                    _el.unit.forEach(function (ele,i){



                                        if(el_.surcharge.is_huge_weight !== 1){
                                            document.getElementById('payment_basic_weight').innerHTML += `<div class="toggle-button-cell">
                                                                                                        <label class="form-toggle-box form-toggle-price large">
                                                                                                            <input type="radio" id="${ele.kg}kg" value="${ele.kg}" name="payment_s2" data-price="${ele.price}" ${i ===  _el.unit.length-1 ? 'id="weight_target"':''}onclick="set_product2(this,'${document.querySelector('input[name="payment_size"]:checked').value}/${document.querySelector('input[name="payment_s1"]:checked').value}/${ele.kg}kg','${ele.price}','list_title_3',true)">
                                                                                                                <em>
                                                                                                                    <span class="font-size-12">~${ele.kg}Kg</span>
                                                                                                                <strong class="font-size-12">${ele.is_consulting == "1" ? '상담' : `${parseInt(ele.price).toLocaleString()}원`}</strong>
                                                                                                                
                                                                                                            </em>
                                                                                                        </label>
                                                                                                    </div>`
                                        }

                                        if(el_.surcharge.is_huge_weight === 1){

                                            document.getElementById('payment_basic_weight').innerHTML += `<div class="toggle-button-cell">
                                                                                                    <div class="form-toggle-options">
                                                                                                        <input type="radio" name="payment_s2"  id="payment_huge_weight" data-price="${ele.price}" value="huge" onclick="set_product2(this,'${document.querySelector('input[name="payment_size"]:checked').value}/${document.querySelector('input[name="payment_s1"]:checked').value}/${ele.kg}kg','${ele.price}','list_title_3',true)">
                                                                                                            <div class="form-toggle-options-data">
                                                                                                                <div class="options-labels">
                                                                                                                    <span class="font-size-12">~${ele.kg}kg당</span><strong style="font-size:10px">+${ele.price}원</strong></div>
                                                                                                                <div class="form-amount-input">
                                                                                                                    <button type="button" 
                                                                                                                            class="btn-form-amount-minus" onclick="set_etc_product_count_huge(this,'${document.querySelector('input[name="payment_size"]:checked').value}/${document.querySelector('input[name="payment_s1"]:checked').value}/${ele.kg}kg','${ele.price}',false)">감소
                                                                                                                    </button>
                                                                                                                    <div class="form-amount-info">
                                                                                                                        <input type="number" id="huge_weight" readOnly="" value="1" data-price="${ele.price}"
                                                                                                                               class="form-amount-val">
                                                                                                                    </div>
                                                                                                                    <button type="button" 
                                                                                                                            class="btn-form-amount-plus" onclick="set_etc_product_count_huge(this,'${document.querySelector('input[name="payment_size"]:checked').value}/${document.querySelector('input[name="payment_s1"]:checked').value}/${ele.kg}kg','${ele.price}',true)">증가
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                </div>`
                                        }






                                        if(el_.surcharge.is_have ===1 && i === _el.unit.length-1){


                                            let surcharge_kg = el_.surcharge.kg ;
                                            let surcharge_std_price = ele.kg <= surcharge_kg ? ele.price :'0';

                                            localStorage.setItem('surcharge_std_price',surcharge_std_price);
                                            localStorage.setItem('surcharge_kg',surcharge_kg);
                                            localStorage.setItem('surcharge_price',el_.surcharge.price);



                                            document.getElementById('payment_basic_weight').innerHTML += `<div class="toggle-button-cell">
                                                                                                    <div class="form-toggle-options">
                                                                                                        <input type="radio" name="payment_s2" id="payment_surcharge" value="no" onclick="set_product2(this,'${document.querySelector('input[name="payment_size"]:checked').value}/${document.querySelector('input[name="payment_s1"]:checked').value}/${el_.surcharge.kg}kg','${el_.surcharge.price}','list_title_3',true)">
                                                                                                            <div class="form-toggle-options-data">
                                                                                                                <div class="options-labels">
                                                                                                                    <span class="font-size-12">${el_.surcharge.kg}kg~</span><strong style="font-size:10px">kg당 <br> +${parseInt(el_.surcharge.price).toLocaleString()}원</strong></div>
                                                                                                                <div class="form-amount-input">
                                                                                                                    <button type="button" 
                                                                                                                            class="btn-form-amount-minus" id="payment_surcharge" onclick="set_etc_product_count_(this,'${document.querySelector('input[name="payment_size"]:checked').value}/${document.querySelector('input[name="payment_s1"]:checked').value}/${el_.surcharge.kg}kg','${el_.surcharge.price}',false)">감소
                                                                                                                    </button>
                                                                                                                    <div class="form-amount-info">
                                                                                                                        <input type="number" readOnly=""  value="${localStorage.getItem('surcharge_kg')}" data-weight="10kg+" id="payment_weight_target" data-price="${el_.surcharge.price}"
                                                                                                                               class="form-amount-val">
                                                                                                                    </div>
                                                                                                                    <button type="button" 
                                                                                                                            class="btn-form-amount-plus" id="payment_surcharge" onclick="set_etc_product_count_(this,'${document.querySelector('input[name="payment_size"]:checked').value}/${document.querySelector('input[name="payment_s1"]:checked').value}/${el_.surcharge.kg}kg','${el_.surcharge.price}',true)">증가
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                </div>`


                                        }



                                    })
                                }else{
                                    document.getElementById('payment_basic_weight').innerHTML = '<div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price large"><input type="radio" value="" name="payment_s2"><em><span class="font-size-12">선택 안함</span></em></label></div>';
                                }

                            }
                        })
                    }
                })



            })

        })

        resolve();
    })

}

function get_coupon(id,data,payment_idx){

    return new Promise(function(resolve){



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

                    document.getElementById('c_coupon').innerHTML = '<div class="form-item-label display_flex_ju_center font-size-12">쿠폰상품</div>';
                    document.getElementById('f_coupon').innerHTML = '<div class="form-item-label display_flex_ju_center font-size-12">정액상품</div>';


                    body.forEach(function(el){

                        if(el.type === 'C'){

                            document.getElementById('c_coupon').innerHTML +=  `<div class="form-item-data type-2">
                                                                                <div class="toggle-button-group vertical">
                                                                                    <div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price middle" htmlFor="cp1-1">
                                                                                        <input class="pay_coupon" type="checkbox" name="cp1" id="${el.name}" value="${el.name}" data-idx="${el.idx}" data-price="${el.price}" onclick="set_product(this,'${el.name}','${el.price}')"><em><span>${el.name}</span><strong>+${el.price.toLocaleString()}원</strong></em></label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>`
                        }else{

                            document.getElementById('f_coupon').innerHTML +=  `<div class="form-item-data type-2">
                                                                                    <div class="toggle-button-group vertical">
                                                                                        <div class="toggle-button-cell"><label class="form-toggle-box form-toggle-price middle" htmlFor="cp2-1">
                                                                                            <input class="pay_coupon" type="checkbox" name="cp2" id="${el.name}" value="${el.name}"  data-idx="${el.idx}" data-price="${el.price}" onclick="set_product(this,'${el.name}','${el.price}')"><em><span>${el.name}</span><strong>+${el.price.toLocaleString()}원</strong></em></label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>`
                        }
                    })




                    let customer_id = data.customer_Id;
                    let tmp_user_idx = data.tmp_id;

                    if(tmp_user_idx === ""){
                        tmp_user_idx = 0;
                    }

                    $.ajax({
                        url:'/data/pc_ajax.php',
                        type:'post',
                        data:{

                            mode:'get_user_coupon',
                            login_id:id,
                            customer_id:customer_id,
                            tmp_user_idx:tmp_user_idx
                        },
                        success:function(res){
                            let response = JSON.parse(res);
                            let head = response.data.head;
                            let body_ = response.data.body;
                            if (head.code === 401) {
                                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                            } else if (head.code === 200) {

                                console.log(body_)
                                if(body_.length === undefined){

                                    body_ = [body_];
                                }

                                let coupon = [];
                                body_.forEach(function(el){

                                    // if(el.payment_log_seq === payment_idx){

                                        coupon.push(el)
                                    // }
                                })

                                console.log(coupon);
                                if(coupon.length > 0){


                                    document.getElementById('pet_shop_coupon').style.display = 'block';

                                }else{

                                    document.getElementById('pet_shop_coupon').style.display = 'none';

                                }



                                document.getElementById('coupon_name').innerHTML = '';
                                body_.forEach(function(el){

                                    body.forEach(function(el_){

                                        if(el.coupon_seq === el_.idx){
                                            if(el.del_yn === "N"
                                                // && el.payment_log_seq === payment_idx
                                            ){

                                                document.getElementById('coupon_name').innerHTML += `<option data-given="${el.given}" data-type="${el.type}" data-use="${el.use}" data-coupon_seq="${el.coupon_seq}" value="${el.user_coupon_seq}" data-price="${el.price}">${el_.name}</option>`


                                            }

                                        }
                                    })


                                })
                                document.getElementById('coupon_name').dispatchEvent(new Event('change'))
                            }

                            resolve()
                        }
                    })


                }
            }

        })
    })

}

function get_etc_product(id){


    return new Promise(function(resolve){



        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{

                mode:'get_etc_product',
                login_id:id,
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


                    document.getElementById('etc_product_list_1').innerHTML = ''
                    document.getElementById('etc_product_list_2').innerHTML = ''
                    document.getElementById('etc_product_list_3').innerHTML = ''
                    document.getElementById('etc_product_list_4').innerHTML = ''

                    body.forEach(function(el){



                        switch (parseInt(el.type)){

                            case 1: document.getElementById('etc_product_list_1').innerHTML += `<div class="toggle-button-cell">
                                                                                                    <div class="form-toggle-options">
                                                                                                        <input type="checkbox" class="pay_etc_product" id="${el.name}" name="options1-1" value="${el.name}" data-price="${el.price}" data-idx="${el.idx}" onclick="set_product(this,'${el.name}','${el.price}')">
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
                                                                                                        <input type="checkbox" class="pay_etc_product" id="${el.name}"  name="options2-1" value="${el.name}" data-price="${el.price}" data-idx="${el.idx}"  onclick="set_product(this,'${el.name}','${el.price}')">
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
                                                                                                        <input type="checkbox" class="pay_etc_product"  id="${el.name}" name="options3-1" value="${el.name}" data-price="${el.price}" data-idx="${el.idx}"  onclick="set_product(this,'${el.name}','${el.price}')">
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
                                                                                                        <input type="checkbox" class="pay_etc_product" id="${el.name}"  name="options4-1" value="${el.name}" data-price="${el.price}" data-idx="${el.idx}"  onclick="set_product(this,'${el.name}','${el.price}')">
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
                    resolve();
                }
            }

        })

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
    // if(!location.href.match('management')){
    //
    //     return;
    // }

    if(price === ''){
        price = 0;
    }

    if(bool){

            Array.from(document.getElementsByClassName(className)).forEach(function(el){

                el.parentElement.remove();
            });
    }


    if(name !== ''){


        document.getElementById('service_list').innerHTML += `<div class="list-cell">
                                                                        <div class="list-title list-title-add ${className}">${name}</div>
                                                                     <div class="list-value list-value-add" ${target.getAttribute('value') === 'no' ? 'id="surcharge_target"' : target.getAttribute('value') === 'huge' ? 'id="huge_target"' : ''}>${price.toLocaleString()}원</div>
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


function set_etc_product_count_(target,name,price,bool){

    //console.log(price);


    name =name.trim();

    Array.from(document.getElementsByClassName('list-title-add')).forEach(function(el){




        if(el.innerText === name){

            if(bool){

                siblings(target,1).children[0].value = parseInt(siblings(target,1).children[0].value)+1;

                let value = siblings(target,1).children[0].value;

                siblings(el,1).innerText = `${parseInt(localStorage.getItem('surcharge_std_price')) + ( (parseInt(document.getElementById('payment_weight_target').value) - parseInt(localStorage.getItem('surcharge_kg') ))*parseInt(localStorage.getItem('surcharge_price'))) + parseInt(localStorage.getItem('surcharge_price'))}원`

                localStorage.setItem('surcharge_result',`${parseInt(localStorage.getItem('surcharge_std_price')) + ( (parseInt(document.getElementById('payment_weight_target').value) - parseInt(localStorage.getItem('surcharge_kg') ))*parseInt(localStorage.getItem('surcharge_price'))) + parseInt(localStorage.getItem('surcharge_price'))}`)



            }else{

                if(parseInt(siblings(target,1).children[0].value ) === 1){
                    return;
                }

                siblings(target,1).children[0].value = parseInt(siblings(target,1).children[0].value)-1;


                siblings(el,1).innerText = `${parseInt(localStorage.getItem('surcharge_std_price')) + ( (parseInt(document.getElementById('payment_weight_target').value) - parseInt(localStorage.getItem('surcharge_kg') ))*parseInt(localStorage.getItem('surcharge_price')) ) +  parseInt(localStorage.getItem('surcharge_price'))}원`
                localStorage.setItem('surcharge_result',`${parseInt(localStorage.getItem('surcharge_std_price')) + ( (parseInt(document.getElementById('payment_weight_target').value) - parseInt(localStorage.getItem('surcharge_kg') ))*parseInt(localStorage.getItem('surcharge_price')) ) +  parseInt(localStorage.getItem('surcharge_price'))}`)

            }
        }
    })


}

function  set_etc_product_count_huge(target,name,price,bool){


    name =name.trim();


    Array.from(document.getElementsByClassName('list-title-add')).forEach(function(el){




        if(el.innerText.match(`${name.split('/')[0]}/${name.split('/')[1]}`)){

            if(bool){

                siblings(target,1).children[0].value = parseInt(siblings(target,1).children[0].value)+1;
                let value = siblings(target,1).children[0].value;
                siblings(el,1).innerText = `${value * price}원`
                el.innerText = `${el.innerText.split('/')[0]}/${el.innerText.split('/')[1]}/${value}kg`
            }else{

                siblings(target,1).children[0].value = parseInt(siblings(target,1).children[0].value)-1;
                let value = siblings(target,1).children[0].value;
                siblings(el,1).innerText = `${value * price}원`
                el.innerText = `${el.innerText.split('/')[0]}/${el.innerText.split('/')[1]}/${value}kg`
            }
        }
    })


}

function management_total_price(){


    if(localStorage.getItem('is_vat') === '1'){

        document.getElementById('is_vat_list').style.display = 'flex';
    }else{

        document.getElementById('is_vat_list').style.display = 'none';
    }

    let target = document.getElementById('service_list');

    //console.log(target)
    let observer = new MutationObserver(function(mutations){

        mutations.forEach(function(mutation){

            let sum = 0;
            Array.from(document.getElementsByClassName('list-value-add')).forEach(function(el){

                sum += parseInt(el.innerText.replace('원',''));



            })

            document.getElementById('total_price').innerText = `${sum.toLocaleString()}원`
            document.getElementById('total_price').setAttribute('value', `${sum}`);
            document.getElementById('vat').innerText = `${(sum/10).toLocaleString()}원`
            document.getElementById('vat').setAttribute('value', `${sum/10}`);
            if(localStorage.getItem('is_vat') === '1'){

                document.getElementById('real_total_price').innerText = `${(sum + (sum/10)).toLocaleString()}원`
                document.getElementById('real_total_price').setAttribute('value', `${sum+(sum/10)}`);
            }else{
                document.getElementById('real_total_price').innerText = `${(sum).toLocaleString()}원`
                document.getElementById('real_total_price').setAttribute('value', `${sum}`);

            }



            last_price()

       })


    })

    let config = {
        attributes:true,
        childList:true,
        characterData:true,
        subtree:true
    }
    //console.log(observer)


    observer.observe(target,config);


}

function discount_init(){


return new Promise(function(resolve){



    document.getElementById('discount_1_btn').addEventListener('click',function(){

        document.getElementById('discount_2').setAttribute('disabled','');
        document.getElementById('discount_1').removeAttribute('disabled');
    })

    document.getElementById('discount_2_btn').addEventListener('click',function(){

        document.getElementById('discount_1').setAttribute('disabled','');
        document.getElementById('discount_2').removeAttribute('disabled');


    })


    document.getElementById('discount_1').addEventListener('change',function(){

        // if(document.getElementById('real_total_price').getAttribute('value') == 0){
        //
        //     document.getElementById('msg1_txt').innerText = '상품을 먼저 적용해주세요..'
        //     pop.open('reserveAcceptMsg1');
        //     return;
        // }

        let result = (parseInt(document.getElementById('real_total_price').getAttribute('value'))*(parseInt(document.getElementById('discount_1').value)/100));

        Array.from(document.getElementsByClassName('discount_price')).forEach(function(el){

            el.innerText= `${Math.floor(result).toLocaleString()}원`
            el.setAttribute('value',`${Math.floor(result)}`)
            last_price()
        })

        // pop.open('reservePayManagementMsg4')
    })

    document.getElementById('discount_2').addEventListener('change',function(){

        // if(document.getElementById('real_total_price').getAttribute('value') == 0){
        //
        //     document.getElementById('msg1_txt').innerText = '상품을 먼저 적용해주세요..'
        //     pop.open('reserveAcceptMsg1');
        //     return;
        // }

        let result = (parseInt(document.getElementById('discount_2').value));
        Array.from(document.getElementsByClassName('discount_price')).forEach(function(el){

            el.innerText= `${Math.floor(result).toLocaleString()}원`
            el.setAttribute('value',`${Math.floor(result)}`)
            last_price()
        })
        // pop.open('reservePayManagementMsg4')
    })

    document.getElementById('discount_1_btn').click();




    resolve();
})


}


function reserves(id){






    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',

        data:{

            mode:'get_pay_reserve',
            login_id:id,

        },
        success:function(res){


            let response = JSON.parse(res);


            let data = response.data;

            //console.log(data);
            // if(bool2){
            //     if(data.is_use === '1'){
            //
            //         document.getElementById('pet_shop_reserves').style.display = 'block';
            //
            //     }else{
            //         document.getElementById('pet_shop_reserves').style.display = 'none';
            //     }
            // }



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
    let discount =  parseInt(document.getElementById('total_discount_price').getAttribute('value'));
    let reserves =  parseInt(document.getElementById('total_reserves_use').getAttribute('value'))

    let deposit = document.getElementById('deposit_price').value === null || document.getElementById('deposit_price').value === '' ||  document.getElementById('deposit_price').value === undefined ? 0 : parseInt(document.getElementById('deposit_price').value)


    document.getElementById('last_price').innerText = `${(sum-discount-reserves-deposit).toLocaleString()}원`

    // document.getElementById('last_card').value = `${(sum-discount-reserves)}`
    // document.getElementById('last_cash').value ='0';


}

function data_change(){

    let sum =  parseInt(document.getElementById('real_total_price').getAttribute('value')) ;
    let discount =  parseInt(document.getElementById('total_discount_price').getAttribute('value'));
    let reserves =  parseInt(document.getElementById('total_reserves_use').getAttribute('value'))
    let deposit = parseInt(document.getElementById('deposit_price').value);

    console.log(deposit)

    if(document.getElementById('last_card').value == 0){

        document.getElementById('last_cash').value = '0';
        document.getElementById('last_card').value =  `${(sum-discount-reserves-deposit)}`;

    }else if(document.getElementById('last_cash').value == 0){
        document.getElementById('last_cash').value = `${(sum-discount-reserves-deposit)}`;
        document.getElementById('last_card').value = '0';
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
                //console.log(res)
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
            //console.log(res)


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

function approve_consult(bool) {


    if (bool) {

        $.ajax({

            url: '/data/pc_ajax.php',
            type: 'post',
            data: {

                mode: "approve_consult",
                payment_idx: document.getElementById('consult_btn').getAttribute('data-payment_idx')
            },
            success: function (res) {
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
    }else{

        $.ajax({

            url: '/data/pc_ajax.php',
            type: 'post',
            data: {

                mode: "not_approve_consult",
                payment_idx: document.getElementById('consult_btn').getAttribute('data-payment_idx')
            },
            success: function (res) {
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
}
let toggle_validate = true;
function pay_management_toggle(bool){




        if(bool){

            document.getElementById('pay_management').classList.remove('animate-check');
            $('#pay_management').stop().animate({
                marginRight:`-${$('#pay_management').width()}px`,
                opacity:'0'

            },300,'swing')
            $('#pay_close_btn').stop().animate({
                marginRight:`-${$('#pay_management').width()}px`,
                opacity:'0'

            },300,'swing')

            $('#shortcutWrap').stop().animate({
                marginRight:`-${$('#pay_management').width()}px`,
                opacity:'0'

            },300,'swing')


            toggle_validate= true;

        }else{

            if(toggle_validate){
                document.getElementById('pay_management').classList.add('animate-check');
                $('#pay_management').stop().animate({
                    marginRight:`25px`,
                    opacity:'1'
                },300,'swing')
                $('#pay_close_btn').stop().animate({
                    marginRight:`-1px`,
                    opacity:'1'
                },300,'swing')
                $('#shortcutWrap').stop().animate({
                    marginRight:`0px`,
                    opacity:'1'

                },300,'swing')
                toggle_validate = false;
            }else{

                return;
            }


        }






}

function pay_management_init(id,target,bool,bool2){

    let payment_idx = target.getAttribute('data-payment_idx');

    if(document.getElementById('pay_card_body_inner')){

        document.getElementById('pay_card_body_inner').style.display = 'none';
        document.getElementById('pay_management_loading').style.display = 'flex';

    }
    document.getElementById('pay_management').scrollTop = 0

    setTimeout(function(){
        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:'pay_management',
                payment_idx:payment_idx,
            },
            beforeSend:function(){




                document.getElementById('payment_basic_service_btn').click();
                product_init();




                if(!bool2){

                    Array.from(document.getElementsByClassName('is_approve')).forEach(function(el){

                        el.style.display = 'none';
                    })

                    Array.from(document.getElementsByClassName('is_approve2')).forEach(function(el){

                        el.style.display = 'block';
                    })



                }else{
                    Array.from(document.getElementsByClassName('is_approve')).forEach(function(el){

                        if(el.classList.contains('user-receipt-wrap')){
                            el.style.display = 'flex';
                        }else{
                            el.style.display = 'block';

                        }
                    })

                    Array.from(document.getElementsByClassName('is_approve2')).forEach(function(el){

                        el.style.display = 'none';
                    })

                }


            },
            success:function (res){

                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                let body_2 = response.data2.body;
                let body_3 = response.data3.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {


                    console.log(body)

                    let start_time ;

                    let end_time;

                    if(document.querySelector('.calendar-day-header-col')){

                        Array.from(document.getElementsByClassName('calendar-day-header-col')).forEach(function(el){
                            if(el.getAttribute('data-worker') === body.worker){
                                start_time = el.getAttribute('data-start');
                                end_time = el.getAttribute('data-end');
                            }
                        })

                    }else if(document.querySelector('.worker_id')){

                        Array.from(document.getElementsByClassName('worker_id')).forEach(function(el){

                            if(el.getAttribute('data-worker') === body.worker){

                                start_time = el.getAttribute('data-start');
                                end_time = el.getAttribute('data-end')
                            }
                        })
                    }else if(document.querySelector('.header-worker')){


                        Array.from(document.getElementsByClassName('header-worker')).forEach(function(el){

                            if(body.worker === el.getAttribute('data-worker')){

                                let time = el.getAttribute(`data-week-${new Date(body.beauty_date.replace(' ','T')).getDay()}`)

                                start_time = time.split('|')[1];
                                end_time = time.split('|')[2];


                            }
                        })


                    }else if(document.getElementById('month_reserve_total')){


                        $.ajax({


                            url:'/data/pc_ajax.php',
                            type:'post',
                            async:false,
                            data:{

                                mode:'working',
                                login_id:id
                            },
                            success:function(res){
                                let response = JSON.parse(res);
                                let head = response.data.head;
                                let body_ = response.data.body;
                                if (head.code === 401) {
                                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                                } else if (head.code === 200) {


                                    body_.forEach(function(el){

                                        if(el.name === body.worker && !el.is_leave && el.is_show){

                                            el.work.forEach(function(el_){

                                                if(new Date(body.beauty_date.replace(' ','T')).getDay() === parseInt(el_.week)){

                                                    //console.log(el_)

                                                    start_time = el_.time_st;
                                                    end_time = el_.time_fi;


                                                }


                                            })
                                        }
                                    })


                                }

                            }
                        })


                    }

                    document.getElementById('pay_deposit_btn').setAttribute('data-payment_idx',payment_idx);
                    document.getElementById('deposit_price_list').style.display = 'none';
                    document.getElementById('deposit_price').value = 0;
                    document.getElementById('pay_deposit_btn').setAttribute('data-allim','0');
                    document.getElementById('pay_deposit_btn').setAttribute('data-cellphone',body.cell_phone);
                    document.getElementById('pay_deposit_btn').setAttribute('data-date',body.beauty_date);
                    document.getElementById('pay_deposit_btn').setAttribute('data-pet_name',body.name);
                    document.getElementById('pay_deposit_btn').setAttribute('data-reserve_pay_price',body.reserve_pay_price);
                    document.getElementById('pay_deposit_btn').setAttribute('data-deadline',body.reserve_pay_deadline);

                    $.ajax({

                        url:'/data/pc_ajax.php',
                        type:'post',
                        data:{

                            mode:'get_deposit',
                            artist_id:id

                        },success:function(res){

                            let response = JSON.parse(res);
                            let head = response.data.head;
                            let body = response.data.body;
                            if (head.code === 401) {
                                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                            } else if (head.code === 200) {

                                if(body.length >0){

                                    document.getElementById('pay_deposit_btn').setAttribute('data-bank',body[0].bank_name);
                                    document.getElementById('pay_deposit_btn').setAttribute('data-account',body[0].account_num);
                                }
                            }
                        }
                    })

                    let diary_time ;
                    if(body.diary_idx !== null ){

                        diary_time = new Date(body.diary_time.replace(' ','T'));

                    }

                    if(body.diary_idx !== null && body.diary_idx != 0){
                        document.getElementById('diary_wrap').innerHTML = `<div class="diary-exist" data-cellphone="${body.cell_phone}" data-pet_seq="${body.pet_seq}" data-payment_idx="${payment_idx}">알리미 발송완료</div><div class="diary-date"><span>(${diary_time.getFullYear()}. ${fill_zero(diary_time.getMonth()+1)}. ${fill_zero(diary_time.getDate())}. ${am_pm_check(diary_time.getHours())}시 ${fill_zero(diary_time.getMinutes())}분)</span></div>`
                    }else if(body.diary_idx === null || body.diary_idx == 0){
                        document.getElementById('diary_wrap').innerHTML = `<div class="diary-not-exist" data-cellphone="${body.cell_phone}" data-pet_seq="${body.pet_seq}" data-payment_idx="${payment_idx}" data-date="${body.beauty_date}" data-pet_name="${body.name}" onclick="allimi_send_pop(this,'${artist_id}')">알리미 보내기</div>`

                    }

                    if(body.reserve_pay_price === null || body.reserve_pay_price === ''){

                        body.reserve_pay_price = 0;
                    }
                    if(body.is_reserve_pay === 1){

                        document.getElementById('pay_card_content_0').style.display = 'block'

                    }else{
                        document.getElementById('pay_card_content_0').style.display ='none';
                        document.getElementById('pay_deposit_date').style.display = 'none';
                    }

                    if(body.is_reserve_pay === 1 && body.reserve_pay_yn === 0){

                        document.getElementById('pay_deposit_title').innerText= '예약금 미입금';
                        if(document.getElementById('pay_deposit_title').classList.contains('actived')){
                            document.getElementById('pay_deposit_title').classList.remove('actived');
                        }
                        document.getElementById('pay_deposit_btn').checked = false;
                        document.getElementById('pay_deposit_btn').setAttribute('data-allim','1');
                        document.getElementById('pay_deposit_date').style.display = 'none';

                    }else if(body.is_reserve_pay === 1 && body.reserve_pay_yn === 1){
                        // document.getElementById('pay_deposit_btn').disabled =true;
                        document.getElementById('pay_deposit_title').innerText = '예약금 입금완료';
                        if(!document.getElementById('pay_deposit_title').classList.contains('actived')){
                            document.getElementById('pay_deposit_title').classList.add('actived');
                        }
                        document.getElementById('pay_deposit_btn').checked = true;
                        document.getElementById('pay_deposit_btn').setAttribute('data-allim','0');
                        document.getElementById('pay_deposit_date').style.display ='flex';
                        let deposit_date = body.reserve_pay_confirm_time;
                        let year = deposit_date.split(' ')[0].split('-')[0]
                        let month = deposit_date.split(' ')[0].split('-')[1]
                        let date = deposit_date.split(' ')[0].split('-')[2]

                        let hour = am_pm_check(deposit_date.split(' ')[1].split(':')[0]);
                        let min = deposit_date.split(' ')[1].split(':')[1];
                        document.getElementById('pay_deposit_date').innerText = `(입금처리 : ${year}. ${month}. ${date}. ${hour}시 ${min}분)`

                        document.getElementById('deposit_price_list').style.display = 'flex';
                        document.getElementById('deposit_price').innerText = `${body.reserve_pay_price.toLocaleString()}원`
                        document.getElementById('deposit_price').value = body.reserve_pay_price;

                    }

                    if(body.type === 'dog'){

                        document.getElementById('payment_basic_service_cat').style.display = 'none';
                        document.getElementById('payment_other_service_cat').style.display = 'none';
                        document.getElementById('payment_basic_service').style.display = 'block';
                        document.getElementById('payment_basic_service_btn').setAttribute('data-type','dog');
                        document.getElementById('payment_other_service_btn').setAttribute('data-type','dog');


                    }else{

                        document.getElementById('payment_basic_service_cat').style.display = 'block';
                        document.getElementById('payment_basic_service').style.display = 'none';
                        document.getElementById('payment_other_service').style.display = 'none';
                        document.getElementById('payment_basic_service_btn').setAttribute('data-type','cat');
                        document.getElementById('payment_other_service_btn').setAttribute('data-type','cat');
                    }



                    document.getElementById('remind_coupon').innerText = '0'

                    document.getElementById('sticky-bottom').setAttribute('data-customer_id',body.customer_Id);
                    document.getElementById('sticky-bottom').setAttribute('data-tmp_id',body.tmp_id);
                    document.getElementById('sticky-bottom').setAttribute('data-payment_idx',payment_idx);
                    document.getElementById('sticky-bottom').setAttribute('data-partner_id',id);
                    document.getElementById('sticky-bottom').setAttribute('data-type',body.type === 'dog' ? '개':'고양이');
                    document.getElementById('sticky-bottom').setAttribute('data-name',body.name);

                    document.getElementById('pay_noshow').innerHTML = `<h4 class="con-title">예약자 정보</h4>
                                                                <div style="width:95px;" id="noshow_count"></div>`
                    if(body.is_noshow === 0){

                        document.getElementById('pay_noshow').innerHTML += `<div class="pay-noshow btn btn-red btn-small-size btn-round" onclick="pop.open('noshow')">노쇼 등록</div>`
                    }else if(body.is_noshow === 1){

                        document.getElementById('pay_noshow').innerHTML += `<div class="btn btn-inline  btn-small-size btn-round" style="cursor:pointer; margin-right:20px; background: #8f8f8f; color:white;" onclick="pop.open('cancel_noshow')">노쇼 취소</div>`
                    }

                    if(body.noshow_count > 0){

                        document.getElementById('noshow_count').innerHTML += `<div class="label label-outline-pink pay-noshow-count">NO SHOW ${body.noshow_count}회</div>`
                    }


                    switch(body.grade_ord){

                        case 1: document.getElementById('pay_customer_grade').classList.add('icon-grade-vip'); break;
                        case 2: document.getElementById('pay_customer_grade').classList.add('icon-grade-normal'); break;
                        case 3: document.getElementById('pay_customer_grade').classList.add('icon-grade-normalb'); break;

                        default : document.getElementById('pay_customer_grade').classList.add('icon-grade-normal'); break;
                    }

                    document.getElementById('pay_customer_grade_name').innerText = body.grade_name;
                    document.getElementById('pay_main_phone').innerText = body.cell_phone;
                    document.getElementById('pay_sub_phone').innerHTML = '';
                    if(body.sub_phone !== ''){
                        let sub_phone = body.sub_phone.split(',');

                        sub_phone.forEach(function(el){
                            document.getElementById('pay_sub_phone').innerHTML += `<div class="pay-user-sub-cellphone-wrap">
                                                                            <div class="pay-user-sub-cellphone-name">${el.split('|')[3]}</div>
                                                                            <div class="pay-user-sub-cellphone-number">${phone_edit(el.split('|')[1])}</div>
                                                                        </div>`


                        })
                    }



                    document.getElementById('memberGrageMsg').innerText = `현재 ${body.name} (${phone_edit(body.cell_phone)}) 고객님의 등급은 ${body.grade_name} 입니다.`
                    document.getElementById('pay_grade_btn').setAttribute('data-customer_id',body.customer_Id);
                    document.getElementById('pay_grade_btn').setAttribute('data-tmp_id',body.tmp_id);
                    document.getElementById('pay_grade_btn').setAttribute('data-customer_grade_idx',body.customer_grade_idx);


                    document.getElementById('customer_memo_btn').setAttribute('data-customer_id',body.customer_Id);
                    document.getElementById('customer_memo_btn').setAttribute('data-tmp_id',body.tmp_id);
                    document.getElementById('customer_memo_btn').setAttribute('data-cellphone',body.cell_phone);




                    Array.from(document.getElementsByClassName('change-cls')).forEach(function(el){

                        el.setAttribute('data-cellphone',body.cell_phone);
                        el.setAttribute('data-a_date',body.beauty_date);
                        el.setAttribute('data-name',body.name)
                    })




                    document.getElementById('phone_add_list').innerHTML = '';

                    sub_phone_pop_init(id,true,body.cell_phone)


                    document.getElementById('pay_customer_memo_text').value = '';
                    document.getElementById('pay_customer_memo_text').removeAttribute('data-scm_seq');


                    document.getElementById('pay_confirm').setAttribute('data-seq',payment_idx)
                    if(parseInt(body.is_confirm) === 1){

                        document.getElementById('pay_confirm').checked = true;


                    }else{
                        document.getElementById('pay_confirm').checked = false;
                    }

                    Array.from(document.getElementsByClassName('cancel-cls')).forEach(function(el){

                        el.setAttribute('data-cellphone',body.cell_phone);
                        el.setAttribute('data-pet_name',body.name);
                        el.setAttribute('data-beauty_date',body.beauty_date);


                    })

                    $.ajax({

                        url:'/data/pc_ajax.php',
                        type:'post',
                        data:{
                            mode:'get_customer_memo',
                            login_id:id,
                            customer_id : body.customer_Id,
                            tmp_seq : body.tmp_id,
                            cellphone: body.cell_phone
                        },
                        success:function(res) {

                            let response = JSON.parse(res);
                            let head = response.data.head;
                            let body = response.data.body;
                            if (head.code === 401) {
                                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                            } else if (head.code === 200) {


                                document.getElementById('pay_customer_memo_text').value = body.memo;
                                document.getElementById('pay_customer_memo_text').setAttribute('data-scm_seq',body.scm_seq);

                            }
                        }


                    })

                    document.getElementById('pay_customer_memo_text').value = body.owner_memo;
                    document.getElementById('beauty_img_target').setAttribute('src','');
                    document.getElementById('pay_thumb').removeAttribute('onclick');
                    document.getElementById('coupon_use').setAttribute('data-payment_idx',payment_idx);

                    if(body.photo !== ''){
                        document.getElementById('beauty_img_target').setAttribute('src',`${img_link_change(body.photo)}`);
                        document.getElementById('pay_thumb').setAttribute('onclick',`thumb_view(this,"${body.photo.replace('/pet/','/')}")`)

                    }else{
                        document.getElementById('beauty_img_target').setAttribute('src',`${body.type ==='dog' ? '/static/images/icon/icon-pup-select-off.png' : '/static/images/icon/icon-cat-select-off.png'}`);
                    }

                    document.getElementById('pay_pet_name').innerText = ''
                    document.getElementById('pay_pet_cate').innerText = ''
                    document.getElementById('pay_pet_name').innerText = body.name;
                    document.getElementById('pay_pet_cate').innerText = body.pet_type;

                    document.getElementById('pay_beauty_gal_btn').setAttribute('data-type',body.pet_type);
                    document.getElementById('pay_beauty_gal_btn').setAttribute('data-payment_idx',payment_idx);
                    document.getElementById('pay_beauty_gal_btn').setAttribute('data-pet_idx',body.pet_seq);




                    document.getElementById('agree_name').value = '';

                    $.ajax({

                        url:'/data/pc_ajax.php',
                        type:'post',
                        data:{
                            mode:'get_beauty_agree',
                            partner_id:id,
                            pet_idx:body.pet_seq
                        },
                        success:function(res) {
                            let response = JSON.parse(res);
                            let head = response.data.head;
                            let body_ = response.data.body;
                            if (head.code === 401) {
                                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                            } else if (head.code === 200) {


                                ////console.log(body_)

                                if(body_.length === 0){

                                    ////console.log(body)
                                    document.getElementById('beauty_agree_view').innerHTML =  `<button type="button" class="btn btn-outline-gray btn-middle-size btn-round" id="beauty_agree_btn">미용 동의서 작성</button>`
                                    document.getElementById('beauty_agree_all_btn').checked = false;
                                    document.getElementById('beauty_agree_1_btn').checked = false;
                                    document.getElementById('beauty_agree_2_btn').checked = false;

                                    setTimeout(function(){
                                        document.getElementById('beauty_agree_btn').addEventListener('click',function(){

                                            beauty_agree_init(body).then(function(data_){

                                                beauty_agree_init_(data_);

                                                pop.open('beautyAgreeWritePop');
                                            });
                                        })
                                    },50)

                                }else{

                                    ////console.log(body_)
                                    document.getElementById('agree_view_disease1').checked = false;
                                    document.getElementById('agree_view_disease2').checked = false;
                                    document.getElementById('agree_view_disease3').checked = false;
                                    document.getElementById('agree_view_disease4').checked = false;
                                    document.getElementById('agree_view_special1').checked = false;
                                    document.getElementById('agree_view_special2').checked = false;
                                    document.getElementById('agree_view_special3').checked = false;
                                    document.getElementById('agree_view_name').value = body_.customer_name;
                                    document.getElementById('agree_view_name2').innerText = body_.customer_name;
                                    document.getElementById('agree_view_date').innerText = `${body_.reg_date.substr(0,4)}.${body_.reg_date.substr(4,2)}.${body_.reg_date.substr(6,2)}`
                                    document.getElementById('beauty_agree_view').innerHTML = `<button type="button" class="btn btn-outline-gray btn-middle-size btn-round" id="beauty_agree_view_btn">미용 동의서 보기</button>`

                                    document.getElementById('user_sign_img').setAttribute('src',`https://image.banjjakpet.com${body_.image}`)
                                    setTimeout(function(){
                                        document.getElementById('beauty_agree_view_btn').addEventListener('click',function(){


                                            beauty_agree_view_init(body).then(function(data_) {

                                                beauty_agree_view_init_(data_);

                                                pop.open('beautyAgreeViewPop');
                                            });



                                        });

                                    },50)


                                }

                            }

                        }
                    })

                    document.getElementById('modify_pet').setAttribute('data-pet_seq',body.pet_seq);





                    // let time = new Date().getTime() - new Date(body.birth.replace(' ','T')).getTime();

                    let time_year = new Date().getFullYear() - new Date(body.birth.replace(' ','T')).getFullYear();
                    let time_month = (new Date().getMonth()+1) - new Date(body.birth.replace(' ','T')).getMonth();

                    let special = '';

                    if(body.dermatosis === 1){
                        special += '피부병 '
                    }
                    if(body.heart_trouble === 1){
                        special += '심장질환 '
                    }
                    if(body.marking === 1){
                        special += '마킹 '
                    }
                    if(body.mounting === 1){
                        special += '마운팅 '

                    }

                    let bite = '';

                    switch(body.bite){

                        case 0 : bite = '안해요'; break;
                        case 1 : bite = '해요'; break;
                        case '해요' : bite = '해요'; break;
                        case '안해요' : bite = '안해요'; break;
                        case null : bite ='미기입';break;
                        case '' : bite = '미기입'; break;
                    }



                    document.getElementById('pay_gender').innerText = body.gender;
                    document.getElementById('pay_neutral').innerText = body.neutral === 0 ? 'X' : 'O'
                    document.getElementById('pay_weight').innerText = `${body.weight}kg`;
                    document.getElementById('pay_pet_year').innerText = `${time_year}년 ${time_month}개월`;
                    document.getElementById('pay_bite').innerText = bite;
                    document.getElementById('pay_luxation').innerText = body.luxation === '' ? '미기입':body.luxation;
                    document.getElementById('pay_gender').innerText = body.gender;
                    document.getElementById('pay_beauty_exp').innerText = body.beauty_exp === '' ? '미기입' : body.beauty_exp;
                    document.getElementById('pay_vaccination').innerText = body.vaccination === '' ? '미기입' : body.vaccination;
                    document.getElementById('pay_special').innerText = special === '' ? '미기입':special;
                    document.getElementById('pay_etc').innerText = body.etc === '' ? '미기입':body.etc;

                    document.getElementById('pay_special_memo_text').value = body.payment_memo;

                    if(document.getElementById('pay_card_body_inner')){

                        document.getElementById('pay_management_loading').style.display = 'none';
                        document.getElementById('pay_card_body_inner').style.display = 'block';
                    }




                    document.getElementById('pay_before_beauty_list').innerHTML = ``
                    document.getElementById('pay_before_beauty_list_more').innerHTML = ``
                    document.getElementById('pay_before_special_list').innerHTML = ``
                    document.getElementById('pay_before_special_list_more').innerHTML = ``


                    if(body_2.length >4){
                        document.querySelector('.pay-btn-detail-toggle-3').style.display ='flex';
                    }else{

                        document.querySelector('.pay-btn-detail-toggle-3').style.display ='none';

                    }

                    if(body_2.length >0){

                        body_2.forEach(function(el,i){



                            document.getElementById(`${i >3 ? 'pay_before_special_list_more' : 'pay_before_special_list'}`).innerHTML += `<div class="pay-before-beauty-item">
                                                                                        <span class="pay-before-beauty-memo" >
                                                                                           ${el.booking_date.split(' ')[0].replaceAll('-','.')} ${el.memo}
                                                                                        </span>
                                                                                    </div>`



                        })


                    }


                    let before_price = 0;

                    console.log(body_3)
                    if(body_3.length >0){

                        body_3.forEach(function(el,i){

                            let card = el.local_price === null ? 0 : parseInt(el.local_price);
                            let cash = el.local_price_cash === null ? 0 : parseInt(el.local_price_cash);
                            before_price = cash + card;


                            if(body.type ==='dog'){
                                document.getElementById(`${i >3 ? 'pay_before_beauty_list_more' : 'pay_before_beauty_list'}`).innerHTML += `<div class="pay-before-beauty-item">
                                                                                        <span class="pay-before-beauty-memo" >
                                                                                           ${el.booking_date.split(' ')[0].replaceAll('-','.')} / ${el.product_parsing?.base?.size} / ${el.product_parsing.base?.beauty_kind} / ${before_price.toLocaleString()}원
                                                                                        </span>
                                                                                        <a href="#" class="pay-before-beauty-detail" data-payment_idx="${el.payment_idx}" onclick="localStorage.setItem('payment_idx','${el.payment_idx}');pay_management_init('${id}',this,true,true)">
                                                                                            
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="5.207" height="9.414" viewBox="0 0 5.207 9.414">
                                                                                                <path data-name="Path" class="before-path" d="m-4 8 4-4-4-4" transform="translate(4.707 .707)" style="fill:none;stroke:#202020;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"></path>
                                                                                            </svg>
                                                                                        </a>
                                                                                    </div>`
                            }else{

                                document.getElementById(`${i >3 ? 'pay_before_beauty_list_more' : 'pay_before_beauty_list'}`).innerHTML += `<div class="pay-before-beauty-item">
                                                                                        <span class="pay-before-beauty-memo" >
                                                                                           ${el.booking_date.split(' ')[0].replaceAll('-','.')} / ${el.product_parsing?.base?.hair_beauty} / ${el.product_parsing?.category} / ${before_price.toLocaleString()}원
                                                                                        </span>
                                                                                        <a href="#" class="pay-before-beauty-detail" data-payment_idx="${el.payment_idx}" onclick="localStorage.setItem('payment_idx','${el.payment_idx}');pay_management_init('${id}',this,true,true)">
                                                                                            
                                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="5.207" height="9.414" viewBox="0 0 5.207 9.414">
                                                                                                <path data-name="Path" class="before-path" d="m-4 8 4-4-4-4" transform="translate(4.707 .707)" style="fill:none;stroke:#202020;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;"></path>
                                                                                            </svg>
                                                                                        </a>
                                                                                    </div>`
                            }




                        })
                    }


                    if(body_3.length >4){
                        document.querySelector('.pay-btn-detail-toggle-2').style.display ='flex';
                    }else{

                        document.querySelector('.pay-btn-detail-toggle-2').style.display ='none';

                    }




                    document.getElementById('day_book_target').setAttribute('data-close_time', `${body.beauty_close_date}`);
                    document.getElementById('day_book_target').setAttribute('data-start_time', `${body.beauty_date}`);

                    document.getElementById('day_book_target').innerText = `${am_pm_check2(body.beauty_date)}`

                    document.getElementById('day_book_target_worker').innerText = `${body.worker_nick}`


                    let year = body.beauty_date.split(' ')[0].split('-')[0];
                    let month = body.beauty_date.split(' ')[0].split('-')[1];
                    let day = body.beauty_date.split(' ')[0].split('-')[2];
                    let hour = body.beauty_date.split(' ')[1].split(':')[0];
                    let minute = body.beauty_date.split(' ')[1].split(':')[1];









                    $.ajax({
                        url:'/data/pc_ajax.php',
                        type:'post',
                        async:false,

                        data:{
                            mode:'reserve_get_time',
                            worker:body.worker,
                            artist_id:id,
                            year:year,
                            month:month,
                            day:day,
                            hour:hour,
                            minute:minute,
                            start_time:start_time,
                            end_time:end_time

                        },success:function(res){
                            //console.log(res)
                            let response = JSON.parse(res);
                            let start = response.start_date.split(' ')[1];
                            let end = response.end_date.split(' ')[1];

                            let start_time = new Date(response.start_date.replace(' ','T')).getTime();
                            let end_time = new Date(response.end_date.replace(' ','T')).getTime();

                            document.getElementById('start_time').innerHTML = '';
                            document.getElementById('end_time').innerHTML = '';
                            let times = [];
                            let new_times = [];
                            let end_times = [];
                            let end_new_times = [];

                            for(let i=start_time; i<end_time; i+=1800000){

                                times.push(i);


                            }

                            times.forEach(function(el){

                                new_times.push(`${fill_zero(new Date(el).getHours())}:${fill_zero(new Date(el).getMinutes())}`);
                            })

                            new_times.forEach(function(el){
                                //console.log(el)

                                //console.log(document.getElementById('start_time'))
                                document.getElementById('start_time').innerHTML += `<option value="${el.replace(':','')}">${am_pm_check_time(el)}</option>`
                            })


                            times.forEach(function(el){

                                end_times.push(el+1800000);
                            })

                            end_times.forEach(function(el){

                                end_new_times.push(`${fill_zero(new Date(el).getHours())}:${fill_zero(new Date(el).getMinutes())}`);

                            })

                            end_new_times.forEach(function(el){

                                document.getElementById('end_time').innerHTML += `<option value="${el.replace(':','')}">${am_pm_check_time(el)}</option>`
                            })













                            // for(let i=start.split(':')[0]; i<end.split(':')[0]; i++){
                            //
                            //     for(let t= 0; t<60; t+=30){
                            //         if(i== start.split(':')[0] && start.split(':')[1] == 30 && t===0){
                            //             continue;
                            //         }
                            //         document.getElementById('start_time').innerHTML += `<option value="${i}${fill_zero(t)}">${am_pm_check_time(`${i}:${fill_zero(t)}`)}</option>`
                            //
                            //         times.push(`2022-01-01 ${i}:${fill_zero(t)}`)
                            //     }
                            //
                            //
                            //
                            //
                            // }
                            //
                            // times.forEach(function(el){
                            //
                            //     let new_time = new Date(el);
                            //     new_time.setMinutes(new_time.getMinutes() + 30);
                            //     new_times.push(`${fill_zero(new_time.getHours())}:${fill_zero(new_time.getMinutes())}`)
                            //
                            // })
                            //
                            // new_times.forEach(function(el){
                            //
                            //     document.getElementById('end_time').innerHTML += `<option value="${el.replace(':','')}">${am_pm_check_time(el)}</option>`
                            // })


                        },complete:function(){
                            let target_time = document.getElementById('day_book_target').getAttribute('data-start_time');
                            let end_time = document.getElementById('day_book_target').getAttribute('data-close_time');



                            let time = target_time.split(' ')[1].replace(':','');
                            let end = end_time.split(' ')[1].replace(':','');


                            for(let i=0; i<document.getElementById('start_time').options.length; i++){

                                if(document.getElementById('start_time').options[i].value === time){
                                    document.getElementById('start_time').options[i].selected = true;
                                }
                            }

                            for(let i=0; i<document.getElementById('end_time').options.length; i++){

                                if(document.getElementById('end_time').options[i].value === end ){
                                    document.getElementById('end_time').options[i].selected = true;
                                }
                            }
                        }
                    })



                    document.getElementById('change_check_worker_btn').setAttribute('data-worker',`${body.worker}`)


                    document.getElementById('pay_allim_btn').setAttribute('onclick',`open_payment_allim('${body.cell_phone}','${payment_idx}','${body.name}')`)

                    document.getElementById('allim_send_btn').setAttribute('data-cellphone',`${body.cell_phone}`);
                    document.getElementById('allim_send_btn').setAttribute('data-pet_name',`${body.name}`);

                    document.getElementById('service_list').innerHTML = '';

                    let parsing = body.product_parsing





                    if(bool2){


                        get_coupon(id,body,payment_idx).then(function(){

                            if(parsing?.coupon){

                                if(!array_empty(parsing.coupon[0])){
                                    parsing.coupon.forEach(function(el){

                                        document.getElementById(`${el.name}`).click();
                                    })

                                }


                            }

                        });
                        get_etc_product(id).then(function(){

                            if(parsing?.goods){
                                if(!array_empty(parsing.goods[0])){

                                    parsing.goods.forEach(function(el){
                                        document.getElementById(`${el.name}`).click();

                                        document.getElementById(`${el.name}`).parentElement.children[1].children[1].children[1].children[0].value = el.ea;


                                        setTimeout(function(){

                                            Array.from(document.getElementsByClassName('list-title-add')).forEach(function(_el){

                                                if(_el.innerText === el.name){

                                                    siblings(_el,1).innerText = `${el.price*el.ea}원`
                                                }
                                            })
                                        },300)
                                    })
                                }


                            }
                        });

                        if(body.type === 'dog'){
                            if(parsing.base.size === ''){


                            }else{
                                document.getElementById(`${parsing.base.size}`).click();
                            }

                            if(parsing.base.beauty_kind === ''){


                            }else{
                                document.getElementById(`${parsing.base.beauty_kind}`).click();

                            }

                            if(document.getElementById(`${parsing.base.weight.unit}kg`)){
                                document.getElementById(`${parsing.base.weight.unit}kg`).click();
                            }else if(parsing.base.weight.unit > localStorage.getItem('surcharge_kg')){

                                if(document.getElementById('payment_surcharge')){

                                    document.getElementById('payment_surcharge').click();
                                    document.getElementById('payment_weight_target').value = parsing.base.weight.unit;
                                    document.getElementById('surcharge_target').innerText = `${(parseInt(document.getElementById('payment_weight_target').value) - parseInt(localStorage.getItem('surcharge_kg'))) * parseInt(localStorage.getItem('surcharge_price')) + parseInt(localStorage.getItem('surcharge_std_price')) + parseInt(localStorage.getItem('surcharge_price'))}원`
                                }else if(document.getElementById('payment_huge_weight')){


                                    document.getElementById('payment_huge_weight').click();
                                    document.getElementById('huge_weight').value = parsing.base.weight.unit;
                                    document.getElementById('huge_target').innerText = `${parseInt(parsing.base.weight.unit)*parseInt(document.getElementById('payment_huge_weight').getAttribute('data-price'))}원`
                                    document.querySelector('.list_title_3').innerText = `${document.querySelector('.list_title_3').innerText.split('/')[0]}/${document.querySelector('.list_title_3').innerText.split('/')[1]}/${parsing.base.weight.unit}kg`
                                }


                            }

                            
                            if(parsing.base.hair_lenth.unit !== '0'){
                                document.getElementById(`${parsing.base.hair_lenth.unit.replace('mm','')}mm${parsing.base.hair_lenth.price}`).click();
                            }
                            if(parsing.add.face.unit !== '0'){
                                document.getElementById(`${parsing.add.face.unit}`).click();
                            }


                            if(parsing.base?.hair_features){
                                if(!array_empty(parsing.base.hair_features)){

                                    if(!array_empty(parsing.base.hair_features[0])){

                                        parsing.base.hair_features.forEach(function(el){
                                            if(document.getElementById(`${el.unit.replace('_','')}목욕`)){

                                                document.getElementById(`${el.unit.replace('_','')}목욕`).click()
                                            }else if(document.getElementById(`${el.unit.replace('_','')}`)){
                                                document.getElementById(`${el.unit.replace('_','')}`).click();

                                            }

                                        })
                                    }


                                }
                            }


                            if(parsing.add.leg.nail.price !== '' && parsing.add.leg.nail.price !== '0'){
                                document.getElementById('발톱').click()
                            }

                            if(parsing.add.leg.bell.price !== '' && parsing.add.leg.bell.price !== '0'){
                                document.getElementById('방울').click()
                            }

                            if(parsing.add.leg.rain_boots.price !== '' && parsing.add.leg.rain_boots.price !== '0'){
                                document.getElementById('장화').click()
                            }

                            if(parsing.add.leg?.type1){
                                if(parsing.add.leg.type1.price !==''){
                                    document.getElementById(`${parsing.add.leg.type1.unit}`).click();
                                }
                            }

                            if(parsing.add.leg?.type2){
                                if(parsing.add.leg.type2.price !==''){
                                    document.getElementById(`${parsing.add.leg.type2.unit}`).click();
                                }
                            }
                            if(parsing.add.leg?.type3){
                                if(parsing.add.leg.type3.price !==''){
                                    document.getElementById(`${parsing.add.leg.type3.unit}`).click();
                                }
                            }if(parsing.add.leg?.type4){
                                if(parsing.add.leg.type4.price !==''){
                                    document.getElementById(`${parsing.add.leg.type4.unit}`).click();
                                }
                            }if(parsing.add.leg?.type5){
                                if(parsing.add.leg.type5.price !==''){
                                    document.getElementById(`${parsing.add.leg.type5.unit}`).click();
                                }
                            }

                            if(!array_empty(parsing.add.spa[0])){
                                parsing.add.spa.forEach(function(el){

                                    document.getElementById(`${el.unit}`).click();
                                })


                            }

                            if(!array_empty(parsing.add.hair_color[0])){
                                parsing.add.hair_color.forEach(function(el){

                                    document.getElementById(`${el.unit}`).click();
                                })

                            }


                            if(parsing.add?.etc){
                                if(!array_empty(parsing.add.etc[0])){

                                    parsing.add.etc.forEach(function(el){

                                        document.getElementById(`${el.unit}`).click();
                                    })
                                }
                            }

                        }
                        if(body.type !== 'dog'){


                            if(parsing.base.hair_beauty !== ''){

                                document.getElementById(`${parsing.base.hair_beauty.split(':')[0]}_미용`).click();
                            }

                            if(parsing.base.bath_long !== ''){

                                document.getElementById('장모').click();
                            }

                            if(parsing.base.bath_shot !== ''){

                                document.getElementById('단모').click();
                            }

                            if(parsing.add.nail !== ''){
                                document.getElementById('발톱').click();
                            }

                            if(parsing.add?.etc){
                                if(parsing.add.etc.length >0){

                                    parsing.add.etc.forEach(function(el){

                                        document.getElementById(`${el.unit}`).click();
                                    })
                                }
                            }

                        }









                        discount_init().then(function(){




                            if(body.discount_type === "1"){
                                document.getElementById('discount_1_btn').click()
                                for(let i=0; i<document.getElementById('discount_1').options.length; i++){
                                    if(document.getElementById('discount_1').options[i].value === body.discount_num){
                                        document.getElementById('discount_1').options[i].selected =true;
                                        setTimeout(function(){
                                            document.getElementById('discount_1').dispatchEvent(new Event('change'));
                                        },500)

                                    }

                                }

                            }else if(body.discount_type === "2"){
                                document.getElementById('discount_2_btn').click()
                                for(let i=0; i<document.getElementById('discount_2').options.length; i++){
                                    if(document.getElementById('discount_2').options[i].value === body.discount_num){
                                        document.getElementById('discount_2').options[i].selected =true;
                                        setTimeout(function(){
                                            document.getElementById('discount_2').dispatchEvent(new Event('change'));
                                        },500)

                                    }

                                }

                            }else if(body.discount_type === "0"){


                                document.getElementById('discount_1_btn').click()
                                document.getElementById('discount_1').options[0].selected = true;
                                document.getElementById('discount_2').options[0].selected = true;
                                setTimeout(function(){

                                    document.getElementById('discount_1').dispatchEvent(new Event('change'));
                                    document.getElementById('discount_2').dispatchEvent(new Event('change'));
                                },500)
                            }






                            if(bool){
                                document.getElementById('pay_management').scrollTop = document.getElementById('scroll_target').offsetTop;
                            }
                        });





                        document.getElementById('cardcash-btn').setAttribute('data-payment_idx',payment_idx);

                        if(body.reserve_point === ''){
                            body.reserve_point = 0;
                        }
                        document.getElementById('total_reserves_use').value = body.reserve_point;
                        document.getElementById('total_reserves_use').innerText = `${body.reserve_point}원`;
                        last_price()





                        if(body.local_price === null || body.local_price === '' || body.local_price === undefined){

                            body.local_price =0;
                        }


                        if(body.local_price_cash === null || body.local_price_cash === '' || body.local_price_cash === undefined){

                            body.local_price_cash =0;
                        }


                        let card = parseInt(body.local_price);
                        let cash = parseInt(body.local_price_cash);
                        let deposit= 0;
                        if(body.reserve_pay_price !== '' || body.reserve_pay_price !== null || body.reserve_pay_price !== undefined){
                            deposit = body.reserve_pay_price
                        }

                        if(localStorage.getItem('is_vat') == '1'){
                            document.getElementById('last_card').value = card+(card/10)-deposit;
                            document.getElementById('last_cash').value = cash

                        }else{
                            document.getElementById('last_card').value = card-deposit;
                            document.getElementById('last_cash').value = cash
                        }






                    }else{


                        let parsing = body.product_parsing;


                        document.getElementById('appr_service_list').innerHTML = '';

                        document.getElementById('appr_service_list').innerHTML += `<div class="list-cell">
                                                                                    <div class="list-title">${parsing.base.size} / ${parsing.base.beauty_kind} / ~${parsing.base.weight.unit}Kg</div>
                                                                                    <div class="list-value appr_sum_target">${(parsing.base.weight.price)}</div>원
                                                                                </div>
                                                                                <div class="list-cell">
                                                                                    <div class="list-title">${parsing.base.hair_lenth.unit}mm</div>
                                                                                    <div class="list-value appr_sum_target">${(parsing.base.hair_lenth.price)}</div>원
                                                                                </div>`

                        if(parsing.base.hair_features.length > 0){

                            parsing.base.hair_features.forEach(function(el){

                                document.getElementById('appr_service_list').innerHTML += `<div class="list-cell">
                                                                                    <div class="list-title">${el.unit}</div>
                                                                                    <div class="list-value appr_sum_target">${(el.price)}</div>원
                                                                                </div>`
                            })

                        }

                        if(parsing.add.face.unit !== '0'){
                            document.getElementById('appr_service_list').innerHTML += `<div class="list-cell">
                                                                                    <div class="list-title">${parsing.add.face.unit}</div>
                                                                                    <div class="list-value appr_sum_target">${(parsing.add.face.price)}</div>원
                                                                                </div>`

                        }



                        if(parsing.add.hair_color.length > 0 && parsing.add.hair_color[0]?.unit){

                            parsing.add.hair_color.forEach(function(el){

                                document.getElementById('appr_service_list').innerHTML += `<div class="list-cell">
                                                                                    <div class="list-title">${el.unit}</div>
                                                                                    <div class="list-value appr_sum_target">${(el.price)}</div>원
                                                                                </div>`
                            })

                        }

                        if(parsing.add.spa.length > 0 && parsing.add.spa[0]?.unit){
                            parsing.add.spa.forEach(function(el){

                                document.getElementById('appr_service_list').innerHTML += `<div class="list-cell">
                                                                                    <div class="list-title">${el.unit}</div>
                                                                                    <div class="list-value appr_sum_target">${(el.price)}</div>원
                                                                                </div>`
                            })

                        }

                        if(parsing.add.leg.bell.price !== ''){

                            document.getElementById('appr_service_list').innerHTML += `<div class="list-cell">
                                                                                    <div class="list-title">${parsing.add.leg.bell.unit}</div>
                                                                                    <div class="list-value appr_sum_target">${(parsing.add.leg.bell.price)}</div>원
                                                                                </div>`
                        }

                        if(parsing.add.leg.nail.price !== ''){

                            document.getElementById('appr_service_list').innerHTML += `<div class="list-cell">
                                                                                    <div class="list-title">${parsing.add.leg.nail.unit}</div>
                                                                                    <div class="list-value appr_sum_target">${(parsing.add.leg.nail.price)}</div>원
                                                                                </div>`
                        }

                        if(parsing.add.leg.rain_boots.price !== ''){

                            document.getElementById('appr_service_list').innerHTML += `<div class="list-cell">
                                                                                    <div class="list-title">${parsing.add.leg.rain_boots.unit}</div>
                                                                                    <div class="list-value appr_sum_target">${(parsing.add.leg.rain_boots.price)}</div>원
                                                                                </div>`
                        }


                        if(parsing.add.leg.type1?.unit){

                            document.getElementById('appr_service_list').innerHTML += `<div class="list-cell">
                                                                                    <div class="list-title">${parsing.add.leg.type1?.unit}</div>
                                                                                    <div class="list-value appr_sum_target">${(parsing.add.leg.type1?.price)}</div>원
                                                                                </div>`
                        }

                        if(parsing.add.leg.type2?.unit){

                            document.getElementById('appr_service_list').innerHTML += `<div class="list-cell">
                                                                                    <div class="list-title">${parsing.add.leg.type2?.unit}</div>
                                                                                    <div class="list-value appr_sum_target">${(parsing.add.leg.type2?.price)}</div>원
                                                                                </div>`
                        }

                        if(parsing.add.leg.type3?.unit){

                            document.getElementById('appr_service_list').innerHTML += `<div class="list-cell">
                                                                                    <div class="list-title">${parsing.add.leg.type3?.unit}</div>
                                                                                    <div class="list-value appr_sum_target">${(parsing.add.leg.type3?.price)}</div>원
                                                                                </div>`
                        }


                        document.getElementById('appr_sum').innerText = '';
                        document.getElementById('appr_vat').innerText = '';
                        document.getElementById('appr_last_price').innerText = '';
                        setTimeout(function(){
                            let sum=0;
                            Array.from(document.getElementsByClassName('appr_sum_target')).forEach(function(el){

                                sum += parseInt(el.innerText);
                            })

                            document.getElementById('appr_sum').innerText = `${sum}원`;

                            if(localStorage.getItem('is_vat') === '1'){

                                document.getElementById('appr_vat_list').style.display  ='flex';

                                document.getElementById('appr_vat').innerText = `${sum/10}원`

                                document.getElementById('appr_last_price').innerText = `${sum + (sum/10)}원`

                            }else{
                                document.getElementById('appr_vat_list').style.display  ='none';
                                document.getElementById('appr_last_price').innerText = `${sum}원`
                            }






                        },300)

                        document.getElementById('appr_date').innerText = ''
                        document.getElementById('appr_worker').innerText = ''
                        document.getElementById('appr_time').innerText = ''


                        document.getElementById('appr_date').innerText = body.beauty_date.split(' ')[0].replaceAll('-','.');
                        document.getElementById('appr_worker').innerText = body.worker_nick;
                        document.getElementById('appr_time').innerText = body.beauty_date.split(' ')[1];


                        let approve_idx = target.getAttribute('data-approve_idx')
                        Array.from(document.getElementsByClassName('apporval-reserve')).forEach((function(el_){

                            el_.setAttribute('data-approve',`${approve_idx}`)
                        }))


                        // $.ajax({
                        //     url: '/data/pc_ajax.php',
                        //     type: 'post',
                        //     data: {
                        //         mode: 'waiting',
                        //         partner_id: id,
                        //     },
                        //     success: function (res) {
                        //
                        //         let response = JSON.parse(res);
                        //         let head = response.data.head;
                        //         let body1 = response.data.body;
                        //         if (head.code === 401) {
                        //             pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                        //         } else if (head.code === 200) {
                        //
                        //             body1.forEach(function(el){
                        //
                        //                 if(el.product.payment_idx == localStorage.getItem('payment_idx')){
                        //                     Array.from(document.getElementsByClassName('apporval-reserve')).forEach((function(el_){
                        //
                        //                         el_.setAttribute('data-approve',`${el.product.approve_idx}`)
                        //                     }))
                        //
                        //                 }
                        //             })
                        //
                        //         }
                        //     }
                        // })

                    }










                }
            }

        })
    },0)





}
function cardcash(target){

    let payment_idx = target.getAttribute('data-payment_idx');

    let card = document.getElementById('last_card').value;

    let cash = document.getElementById('last_cash').value;


    let type;
    let discount;

    if(document.getElementById('discount_1_btn').checked === true){
        type=1;
        discount = document.getElementById('discount_1').value;
    }else if(document.getElementById('discount_2_btn').checked === true){
        type=2;
        discount = document.getElementById('discount_2').value;
    }else if(document.getElementById('discount_1').value === "0" && document.getElementById('discount_2').value === "0"){
        type=0;
        discount=0;

    }

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'discount',
            payment_idx:payment_idx,
            type:type,
            discount:discount,
        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {




                $.ajax({
                    url:'/data/pc_ajax.php',
                    type:'post',
                    data:{
                        mode:'cardcash',
                        payment_idx:payment_idx,
                        card:card,
                        cash:cash,
                    },
                    success:function(res) {
                        let response = JSON.parse(res);
                        let head = response.data.head;
                        let body = response.data.body;
                        if (head.code === 401) {
                            pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                        } else if (head.code === 200) {

                            document.getElementById('msg1_txt').innerText = '최종 결제액이 적용되었습니다.';
                            pop.open('reserveAcceptMsg1');

                        }
                    }

                })

            }
        }
    })




}
function user_coupon_change(){


    let coupon = document.getElementById('coupon_name');

    if(coupon.options.length > 0){



        let selected = coupon.options[coupon.selectedIndex];
        document.getElementById('coupon_balance').innerHTML = '<option value="">선택</option>'
        document.getElementById('use_coupon').innerHTML = '<option value="">선택</option>'

        let given = selected.getAttribute('data-given');
        let use = selected.getAttribute('data-use');
        let type = selected.getAttribute('data-type');

        if(type === 'C'){
            let rest = parseInt(given)-parseInt(use);


            for(let i=1; i<=rest; i++){

                document.getElementById('coupon_balance').innerHTML +=`<option value="${i}">${i}</option>`
                document.getElementById('use_coupon').innerHTML += `<option value="${i}">${i}</option>`

            }
        }else{

            let rest = parseInt(given)-parseInt(use);

            for(let i=0; i<=rest; i+=1000){

                document.getElementById('coupon_balance').innerHTML +=`<option value="${i}">${i}</option>`
                document.getElementById('use_coupon').innerHTML += `<option value="${i}">${i}</option>`

            }
        }
    }




}

function allim_talk_send_change_time(target){


    let cellphone = target.getAttribute('data-cellphone');

    let name = target.getAttribute('data-pet_name');

    let when = document.querySelector('input[name="time1"]:checked').getAttribute('id');

    let mode;

    let message;





    if(when === 'timer_0'){

        mode = 'allim_now';
        message = `반려생활의 단짝, 반짝에서 ${cellphone.slice(-4)}님의 ${name} 미용 종료를 알려드립니다.\n` +
            '\n' +
            `${data.shop_name}에서 미용이 종료되었습니다.\n` +
            '\n' +
            `깔끔하고 더 귀여워진 ${name}\n` +
            '이제 만나러 가세요^^\n' +
            '\n' +
            '반짝반짝 반려생활의 단짝,\n' +
            '반짝에서 알려드렸습니다.'

    }else{


        mode = 'allim_before'

        switch (when){

            case 'timer_1': message = `반려생활의 단짝, 반짝에서 ${cellphone.slice(-4)}님의 ${name} 미용 종료시간을 알려드립니다.\n` +
                '\n' +
                `${data.shop_name}에서 미용을 마무리하고 있네요. 미용종료 10분전 입니다.\n` +
                '\n' +
                `깔끔하고 더 귀여워진 ${name}\n` +
                '이제 만나러 가세요^^\n' +
                '\n' +
                '반짝반짝 반려생활의 단짝,\n' +
                '반짝에서 알려드렸습니다.';
            break;

            case 'timer_2':message = `반려생활의 단짝, 반짝에서 ${cellphone.slice(-4)}님의 ${name} 미용 종료시간을 알려드립니다.\n` +
                '\n' +
                `${data.shop_name}에서 미용을 마무리하고 있네요. 미용종료 15분전 입니다.\n` +
                '\n' +
                `깔끔하고 더 귀여워진 ${name}\n` +
                '이제 만나러 가세요^^\n' +
                '\n' +
                '반짝반짝 반려생활의 단짝,\n' +
                '반짝에서 알려드렸습니다.';
            break;

            case 'timer_3':message = `반려생활의 단짝, 반짝에서 ${cellphone.slice(-4)}님의 ${name} 미용 종료시간을 알려드립니다.\n` +
                '\n' +
                `${data.shop_name}에서 미용을 마무리하고 있네요. 미용종료 20분전 입니다.\n` +
                '\n' +
                `깔끔하고 더 귀여워진 ${name}\n` +
                '이제 만나러 가세요^^\n' +
                '\n' +
                '반짝반짝 반려생활의 단짝,\n' +
                '반짝에서 알려드렸습니다.';
            break;

            case 'timer_4':message = `반려생활의 단짝, 반짝에서 ${cellphone.slice(-4)}님의 ${name} 미용 종료시간을 알려드립니다.\n` +
                '\n' +
                `${data.shop_name}에서 미용을 마무리하고 있네요. 미용종료 30분전 입니다.\n` +
                '\n' +
                `깔끔하고 더 귀여워진 ${name}\n` +
                '이제 만나러 가세요^^\n' +
                '\n' +
                '반짝반짝 반려생활의 단짝,\n' +
                '반짝에서 알려드렸습니다.';
            break;


        }

    }



    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:mode,
            cellphone:cellphone,
            message:message

        },
        success:function(res) {
            ////console.log(res)
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

               document.getElementById('msg1_txt').innerText = '발송되었습니다.';
               pop.open('reserveAcceptMsg1');

            }
        }

    })



}

function coupon_use(target){

    let payment_idx = target.getAttribute('data-payment_idx');


    let user_coupon_idx = document.getElementById('coupon_name').value;
    let given = document.getElementById('coupon_balance').value;
    let use = document.getElementById('use_coupon').value;

    if(given === '0' || use === '0'){
        document.getElementById('msg1_txt').innerText = '잘못입력되었습니다.';
        pop.open('reserveAcceptMsg1');
        return;

    }

    if(parseInt(given)-parseInt(use) <0){

        document.getElementById('msg1_txt').innerText = '잘못입력되었습니다.';
        pop.open('reserveAcceptMsg1');
        return;
    }else{

        $.ajax({

            url:'/data/pc_ajax.php',
            type:'post',
            data:{
                mode:'use_coupon',
                payment_idx:payment_idx,
                user_coupon_idx: user_coupon_idx,
                amount:use,
                balance:given



            },
            success:function(res) {
                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {


                    document.getElementById('remind_coupon').innerText = `${given-use}`

                }
            }
        })


    }










}


function get_worker(id){


    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'working',
            login_id:id
        },
        success:function(res){
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {


                document.getElementById('worker_inner').innerHTML = '';
                body.forEach(function(el){


                    if(!el.is_leave && el.is_show){

                        document.getElementById('worker_inner').innerHTML +=`<div class="grid-layout-cell flex-auto"><label class="form-toggle-box middle"><input type="radio" name="worker" data-name="${el.name}" data-nick="${el.nick}" onclick="registration_worker(this)"><em>${el.nick}</em></label></div>`

                    }
                })


            }

        }
    })
}

function registration_worker(target){

    let name = target.getAttribute('data-name');
    let nick = target.getAttribute('data-nick');


    document.getElementById('reserveCalendarPop2').setAttribute('data-name',name);



}

function reserve_confirm(target){

    let payment_idx = target.getAttribute('data-seq');

    let is_confirm;

    if(target.checked === true){

        is_confirm = 1;
    }else{

        is_confirm = 0;
    }


    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'confirm',
            payment_idx:payment_idx,
            is_confirm:is_confirm,
        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
            }
        }

    })



}

function pay_management_product_change(target){

    let payment_idx = target.getAttribute('data-payment_idx')
    let partner_id = target.getAttribute('data-partner_id')
    let customer_id = target.getAttribute('data-customer_id')
    let tmp_id = target.getAttribute('data-tmp_id')
    let type = target.getAttribute('data-type')
    let name =target.getAttribute('data-name');

    let product = '';


    if(type === '개'){



        if(document.querySelector('input[name="payment_s2"]:checked') === null){

            document.getElementById('msg1_txt').innerText = '무게를 선택해주세요.'
            pop.open('reserveAcceptMsg1');
            return;

        }


        let size = document.querySelector('input[name="payment_size"]:checked').value;
        let service = document.querySelector('input[name="payment_s1"]:checked').value;
        let weight;

        if(document.querySelector('input[name="payment_s2"]:checked').value === 'no'){

            weight = document.getElementById('payment_weight_target').value;
        }else if(document.querySelector('input[name="payment_s2"]:checked').value === 'huge'){

            weight = document.getElementById('huge_weight').value;
        }else{

            weight = document.querySelector('input[name="payment_s2"]:checked').value;
        }
        let weight_price;

        if(document.querySelector('input[name="payment_s2"]:checked').getAttribute('data-price')===null){

            weight_price = localStorage.getItem('surcharge_result');

        }else if(document.querySelector('input[name="payment_s2"]:checked').value === 'huge'){

            weight_price = parseInt(document.querySelector('input[name="payment_s2"]:checked').getAttribute('data-price')) * parseInt(document.getElementById('huge_weight').value);

        }else{
            weight_price= document.querySelector('input[name="payment_s2"]:checked').getAttribute('data-price');

        }
        let face = document.querySelector('input[name="payment_f1"]:checked') === null ? '' : document.querySelector('input[name="payment_f1"]:checked').value;
        let face_price = document.querySelector('input[name="payment_f1"]:checked') === null ? '' : document.querySelector('input[name="payment_f1"]:checked').getAttribute('data-price');
        let length = document.querySelector('input[name="payment_hairBeauty"]:checked') === null ? '' : document.querySelector('input[name="payment_hairBeauty"]:checked').value;
        let length_price = document.querySelector('input[name="payment_hairBeauty"]:checked') === null ? '' : document.querySelector('input[name="payment_hairBeauty"]:checked').getAttribute('data-price');

        let hair_ = document.querySelectorAll('input[name="payment_hair"]:checked')

        let hair = '';

        for(let i=0; i<hair_.length; i++){


            hair += `${hair_[i].value}:${hair_[i].getAttribute('data-price')}${i === (hair_.length)-1 ? '':','}`
        }


        let nail ='';

        let boots = '';

        let bell = '';


        let leg_ = document.querySelectorAll('input[name="payment_f2"]:checked');

        let leg_add = [];
        let leg_count = 0;
        Array.from(leg_).forEach(function(el){

            if(el.value === '발톱'){
                nail = el.getAttribute('data-price')
            }else if(el.value === '장화'){
                boots = el.getAttribute('data-price')
            }else if(el.value === '방울'){
                bell = el.getAttribute('data-price')
            }else{

                leg_count++;
                leg_add.push(`${el.value}:${el.getAttribute('data-price')}`)
            }
        })



        let spa_ = document.querySelectorAll('input[name="payment_f3"]:checked');

        let spa_count = 0;
        let spa = [];
        Array.from(spa_).forEach(function(el){

            spa_count ++;

            spa.push(`${el.value}:${el.getAttribute('data-price')}`);
        })

        let dyeing_ = document.querySelectorAll('input[name="payment_f4"]:checked');

        let dyeing_count = 0;
        let dyeing = [];

        Array.from(dyeing_).forEach(function(el){

            dyeing_count ++;

            dyeing.push(`${el.value}:${el.getAttribute('data-price')}`);
        })

        let etc_ =document.querySelectorAll('input[name="payment_f5"]:checked');

        let etc_count = 0;
        let etc = [];
        Array.from(etc_).forEach(function(el){

            etc_count ++;

            etc.push(`${el.value}:${el.getAttribute('data-price')}`);
        })

        let coupon_1 = document.querySelectorAll('input[name="cp1"]:checked');
        let coupon_2 = document.querySelectorAll('input[name="cp2"]:checked');

        let coupon_count = 0;

        let coupon = [];
        Array.from(coupon_1).forEach(function(el){

            coupon_count++;

            coupon.push(`${el.getAttribute('data-idx')}:${el.value}:${el.getAttribute('data-price')}`)
        });

        Array.from(coupon_2).forEach(function(el){

            coupon_count++;

            coupon.push(`${el.getAttribute('data-idx')}:${el.value}:${el.getAttribute('data-price')}`)
        });

        let options1 = document.querySelectorAll('input[name="options1-1"]:checked');
        let options2 = document.querySelectorAll('input[name="options2-1"]:checked');
        let options3 = document.querySelectorAll('input[name="options3-1"]:checked');
        let options4 = document.querySelectorAll('input[name="options4-1"]:checked');

        let options_count = 0;

        let options = [];


        Array.from(options1).forEach(function(el){

            options_count++;

            options.push(`${el.getAttribute('data-idx')}:${el.value}:${el.getAttribute('data-price')}:${siblings(el,1).children[1].children[1].children[0].value}`)
        });

        Array.from(options2).forEach(function(el){

            options_count++;

            options.push(`${el.getAttribute('data-idx')}:${el.value}:${el.getAttribute('data-price')}:${siblings(el,1).children[1].children[1].children[0].value}`)
        });
        Array.from(options3).forEach(function(el){

            options_count++;

            options.push(`${el.getAttribute('data-idx')}:${el.value}:${el.getAttribute('data-price')}:${siblings(el,1).children[1].children[1].children[0].value}`)
        });

        Array.from(options4).forEach(function(el){

            options_count++;

            options.push(`${el.getAttribute('data-idx')}:${el.value}:${el.getAttribute('data-price')}:${siblings(el,1).children[1].children[1].children[0].value}`)
        });



        product = `${name}|${type}|${data.shop_name}|${size}|${service}|${weight}:${weight_price}|${face}${face_price === '' ? '' : ':'}${face_price}|${length.replace('mm','')}${length_price === '' ? '' : ':'}${length_price}|${hair}|${nail}|${boots}|${bell}|||${leg_count}${leg_count >0 ? '|':''}${leg_add.toString().replaceAll(',','|')}|${spa_count}${spa_count >0 ? '|':''}${spa.toString().replaceAll(',','|')}|${dyeing_count}${dyeing_count > 0 ? '|':''}${dyeing.toString().replaceAll(',','|')}|${etc_count}${etc_count>0?'|':''}${etc.toString().replaceAll(',','|')}|${coupon_count}${coupon_count>0?'|':''}${coupon.toString().replaceAll(',','|')}|${options_count}${options_count > 0? '|':''}${options.toString().replaceAll(',','|')}|`
    }else{

        let beauty = document.querySelector('input[name="payment_beauty"]:checked').value !== '' ? '미용' : '';
        let beauty_ = document.querySelector('input[name="payment_beauty"]:checked').value.replace('_미용', '');
        let beauty_price = document.querySelector('input[name="payment_beauty"]:checked').getAttribute('data-price');
        let nail = document.querySelectorAll('input[name="payment_add_svc"]')[0].checked === true ? `${document.querySelectorAll('input[name="payment_add_svc"]')[0].getAttribute('data-price')}` : '' ;
        let short = document.querySelector('input[name="payment_bath"]:checked').value === '단모' ?  `${document.querySelector('input[name="payment_bath"]:checked').getAttribute('data-price')}` : '';
        let long = document.querySelector('input[name="payment_bath"]:checked').value === '장모' ?  `${document.querySelector('input[name="payment_bath"]:checked').getAttribute('data-price')}` : '';

        let add_count = 0 ;
        let add = [];


        let coupon_1 = document.querySelectorAll('input[name="cp1"]:checked');
        let coupon_2 = document.querySelectorAll('input[name="cp2"]:checked');

        let coupon_count = 0;

        let coupon = [];
        Array.from(coupon_1).forEach(function(el){

            coupon_count++;

            coupon.push(`${el.getAttribute('data-idx')}:${el.value}:${el.getAttribute('data-price')}`)
        });

        Array.from(coupon_2).forEach(function(el){

            coupon_count++;

            coupon.push(`${el.getAttribute('data-idx')}:${el.value}:${el.getAttribute('data-price')}`)
        });

        let options1 = document.querySelectorAll('input[name="options1-1"]:checked');
        let options2 = document.querySelectorAll('input[name="options2-1"]:checked');
        let options3 = document.querySelectorAll('input[name="options3-1"]:checked');
        let options4 = document.querySelectorAll('input[name="options4-1"]:checked');

        let options_count = 0;

        let options = [];


        Array.from(options1).forEach(function(el){

            options_count++;

            options.push(`${el.value}:${el.getAttribute('data-price')}:${siblings(el,1).children[1].children[1].children[0].value}`)
        });

        Array.from(options2).forEach(function(el){

            options_count++;

            options.push(`${el.value}:${el.getAttribute('data-price')}:${siblings(el,1).children[1].children[1].children[0].value}`)
        });
        Array.from(options3).forEach(function(el){

            options_count++;

            options.push(`${el.value}:${el.getAttribute('data-price')}:${siblings(el,1).children[1].children[1].children[0].value}`)
        });

        Array.from(options4).forEach(function(el){

            options_count++;

            options.push(`${el.value}:${el.getAttribute('data-price')}:${siblings(el,1).children[1].children[1].children[0].value}`)
        });

        document.querySelectorAll('input[name="payment_add_svc"]:checked').forEach(function(el){

            if(el.value !== '발톱'){
                 add_count ++;
                 add.push(`${el.value}:${el.getAttribute('data-price')}`)
            }

        })



        product = `${name}|${type}|${data.shop_name}|${beauty}|all:0|${beauty_}:${beauty_price}|${nail}|${short}|${long}|${add_count}|${add.toString().replaceAll(',','|')}|${coupon_count}${coupon_count>0?'|':''}${coupon.toString().replaceAll(',','|')}|${options_count}${options_count > 0? '|':''}${options.toString().replaceAll(',','|')}|`


    }


    let price = document.getElementById('real_total_price').getAttribute('value');




    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'product_change',
            payment_idx:payment_idx,
            use_coupon:'N',
            price:price,
            product:product,
        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                document.getElementById('msg2_txt').innerText = '서비스 정보가 변경되었습니다.'
                pop.open('reserveAcceptMsg2');


            }
        }
    })


}

function pay_get_grade(target,id){

    let customer_id = target.getAttribute('data-customer_id');
    let tmp_id = target.getAttribute('data-tmp_id');
    let customer_grade_idx = target.getAttribute('data-customer_grade_idx');

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
                document.getElementById('memberGradeSelect').innerHTML = '';

                body_.forEach(function(el){

                    if(el.is_delete !== 1){


                        document.getElementById('memberGradeSelect').innerHTML += `<option data-ord="${el.grade_ord}" value="${el.idx}">${el.grade_name}</option>`



                    }
                })

                // let customer = '';
                // if(customer_id === ''){
                //     customer =tmp_id;
                // }else{
                //     customer = customer_id;
                // }


                document.getElementById('set_grade_btn').addEventListener('click',function(){


                    pay_set_grade(customer_grade_idx)
                })

                pop.open('memberGradeAddPop')
            }
        }

    })
}


function pay_set_grade(customer_grade_idx){

    let grade_idx = document.getElementById('memberGradeSelect').value;

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:"put_customer_grade_1",
            customer_idx:customer_grade_idx,
            grade_idx:grade_idx,
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

function product_init(){
    $('input[type=radio]').each(function(){$(this).prop("checked",false)});
    $('input[type=checkbox]').each(function(){$(this).prop("checked",false)});
    document.getElementById('service_list').innerHTML = ''

}

function change_check_reserve(target){



    let worker = '';
    let nick = '';
    let thisYear = target.parentElement.parentElement.getAttribute('data-year');
    let thisMonth = target.parentElement.parentElement.getAttribute('data-month');
    let thisDate = target.parentElement.parentElement.getAttribute('data-date');
    let thisTimeStart = target.parentElement.parentElement.getAttribute('data-time-to');
    let thisHour = target.parentElement.parentElement.getAttribute('data-hour');
    let thisMinutes = target.parentElement.parentElement.getAttribute('data-minutes');


    Array.from(document.getElementsByClassName('header-worker')).forEach(function(el){

        if(el.classList.contains('actived')){

            worker = el.getAttribute('data-worker');
            nick = el.getAttribute('data-nick');
        }
    })

    let thisLogSeq = document.querySelector('.change_target').getAttribute('data-payment_idx');

    let target_date = new Date(2022,0,1,thisTimeStart.split(':')[0],thisTimeStart.split(':')[1]);
    let fi_time_ = parseInt(document.querySelector('.change_target').getAttribute('data-height')) * 30 ;

    target_date.setMinutes(target_date.getMinutes() + fi_time_);

    let fi_time = `${fill_zero(target_date.getHours())}:${fill_zero(target_date.getMinutes())}`

    let cellphone = document.querySelector('.change_target').getAttribute('data-cellphone');
    let pet_name = document.querySelector('.change_target').getAttribute('data-pet_name');


    let _thisYear = document.querySelector('.change_target').parentElement.parentElement.getAttribute('data-year')
    let _thisMonth = document.querySelector('.change_target').parentElement.parentElement.getAttribute('data-month')
    let _thisDate = document.querySelector('.change_target').parentElement.parentElement.getAttribute('data-date')
    let _thisHour = document.querySelector('.change_target').parentElement.parentElement.getAttribute('data-hour')
    let _thisMinutes = document.querySelector('.change_target').parentElement.parentElement.getAttribute('data-minutes')


    $("#reserveCalendarPop4 .con-title").text(nick);
    $("#reserveCalendarPop4 .msg-text-date").text(am_pm_check2(`${thisYear}.${fill_zero(parseInt(thisMonth)+1)}.${fill_zero(thisDate)} ${fill_zero(thisHour)}:${fill_zero(thisMinutes)}`));


    $("#reserveCalendarPop4 input[name='log_type']").val("week");
    $("#reserveCalendarPop4 input[name='log_seq']").val(thisLogSeq);
    $("#reserveCalendarPop4 input[name='log_worker']").val(worker);
    $("#reserveCalendarPop4 input[name='log_year']").val(thisYear);
    $("#reserveCalendarPop4 input[name='log_month']").val(parseInt(thisMonth)+1);
    $("#reserveCalendarPop4 input[name='log_date']").val(thisDate);
    $("#reserveCalendarPop4 input[name='log_start_time']").val(thisTimeStart);
    $("#reserveCalendarPop4 input[name='log_end_time']").val(fi_time);
    $("#reserveCalendarPop4 input[name='log_cellphone']").val(cellphone);
    $("#reserveCalendarPop4 input[name='log_pet_name']").val(pet_name);
    $("#reserveCalendarPop4 input[name='log_a_year']").val(_thisYear);
    $("#reserveCalendarPop4 input[name='log_a_month']").val(parseInt(_thisMonth)+1);
    $("#reserveCalendarPop4 input[name='log_a_date']").val(_thisDate);
    $("#reserveCalendarPop4 input[name='log_a_start_hour']").val(_thisHour);
    $("#reserveCalendarPop4 input[name='log_a_start_min']").val(_thisMinutes);

    pop.open('reserveCalendarPop4');
}

function deposit_save(id){


    if(parseInt(document.getElementById('deposit_input').value) < 1000){

        document.getElementById('msg1_txt').innerText = '최소 예약금은 1,000원 입니다.';
        pop.open('reserveAcceptMsg1');
        return;
    }

    if(document.getElementById('deposit_bank_account').value === ''){
        document.getElementById('msg1_txt').innerText = '계좌번호를 입력해주세요.';
        pop.open('reserveAcceptMsg1');
        return;

    }

    if(document.getElementById('manual_btn').checked === false){
        document.getElementById('msg1_txt').innerText = '예약금 결제관리를 선택해주세요.';
        pop.open('reserveAcceptMsg1');
        return;

    }

    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'deposit_save',
            artist_id:id,
            reserve_price:document.getElementById('deposit_input').value,
            deadline:document.getElementById('deposit_time').value,
            bank_name:document.getElementById('deposit_bank').value,
            account_num:document.getElementById('deposit_bank_account').value
        },success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                document.getElementById('deposit_btn').checked=false;
                document.getElementById('msg1_txt').innerText = '저장되었습니다.'
                pop.open('reserveAcceptMsg1');

            }


        }

    })


}

function get_deposit(id){


    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'get_deposit',
            artist_id:id,
        },success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                console.log(body)


                if(body[0].is_use === 0){

                    document.getElementById('manual_btn').setAttribute('data-bank',body[0].bank_name);
                    document.getElementById('manual_btn').setAttribute('data-account',body[0].account_num);

                    document.getElementById('deposit_reset_btn').setAttribute('data-bank',body[0].bank_name);
                    document.getElementById('deposit_reset_btn').setAttribute('data-account',body[0].account_num);

                    document.getElementById('deposit_input').value = body[0].reserve_price;


                    for(let i=0; i<document.getElementById('deposit_time').options.length; i++){

                        if(body[0].deadline == document.getElementById('deposit_time').options[i].value){

                            document.getElementById('deposit_time').options[i].selected = true;

                        }
                    }

                    for(let i=0; i<document.getElementById('deposit_bank').options.length; i++){

                        if(body[0].bank_name == document.getElementById('deposit_bank').options[i].value){

                            document.getElementById('deposit_bank').options[i].selected = true;

                        }
                    }

                    document.getElementById('deposit_bank_account').value = body[0].account_num;


                    if(body[0].is_manual === 0){

                        document.getElementById('manual_btn').checked = true;
                    }

                }

            }


        }

    })

}

function deposit_toggle(id){




    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{

            mode:'get_deposit',
            artist_id:id
        },success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                console.log(body)

                if(body.length >0 && body[0].reserve_price !==0 ){
                    if(document.getElementById('deposit_form_1').style.display === 'none'){

                        document.getElementById('deposit_form_1').style.display = 'block'
                    }else{

                        document.getElementById('deposit_form_1').style.display = 'none';
                    }


                    document.getElementById('reserve_deposit_input').value = body[0].reserve_price

                    for(let i=0; i<document.getElementById('reserve_deposit_time').options.length; i++){

                        if(body[0].deadline == document.getElementById('reserve_deposit_time').options[i].value){

                            document.getElementById('reserve_deposit_time').options[i].selected = true;
                        }

                    }

                    if(document.getElementById('deposit_btn').checked === true){
                        document.getElementById('deposit_notice').style.display = 'flex';
                    }else{
                        document.getElementById('deposit_notice').style.display = 'none';
                    }


                    document.getElementById('reserve_deposit_input').setAttribute('data-bank',`${body[0].bank_name}`)
                    document.getElementById('reserve_deposit_input').setAttribute('data-account',`${body[0].account_num}`)
                }else{

                    pop.open('deposit_confirm')

                }



            }
        }

    })



}

function deposit_finish(target){

    // event.preventDefault();
    
    let reserve_pay_yn = 0;

    if(target.checked === true){
        reserve_pay_yn = 1;
    }else if(target.checked === false){
        reserve_pay_yn = 0;
    }

    let payment_idx = target.getAttribute('data-payment_idx');
    let allim = target.getAttribute('data-allim');

    let beauty_date = target.getAttribute('data-date');
    let cellphone = target.getAttribute('data-cellphone');
    let name = target.getAttribute('data-pet_name');

    let year = beauty_date.split(' ')[0].split('-')[0];
    let month = beauty_date.split(' ')[0].split('-')[1];
    let day = beauty_date.split(' ')[0].split('-')[2];

    let hour = am_pm_check(beauty_date.split(' ')[1].split(':')[0]);
    let min = beauty_date.split(' ')[1].split(':')[1];

    let reserve_pay_price = target.getAttribute('data-reserve_pay_price');
    let deadline = target.getAttribute('data-deadline').replace(' ','T');

    let deadline_date = new Date(deadline);
    let bank = target.getAttribute('data-bank');
    let account = target.getAttribute('data-account');





    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'deposit_finish',
            payment_log_seq:payment_idx,
            reserve_pay_yn:reserve_pay_yn,
        },
        success:function(res) {
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                console.log(body)
                if(reserve_pay_yn == 1){

                    document.getElementById('pay_deposit_btn').setAttribute('data-allim','0')
                    let message = `반려생활의 단짝, 반짝에서 ${cellphone.slice(-4)}님의 ${name} 미용예약 내용을 알려드립니다.\n` +
                        '\n' +
                        `- 예약펫샵 : ${data.shop_name}\n` +
                        `- 예약일시 : ${year}년 ${month}월 ${day}일 ${hour}시 ${min}분\n` +
                        '\n' +
                        '예약내용 상세확인과 예약은\n' +
                        '반려생활의 단짝, 반짝에서도 가능합니다.';



                    $.ajax({

                        url:'/data/pc_ajax.php',
                        type:'post',
                        data:{

                            mode:'reserve_regist_allim',
                            cellphone:cellphone,
                            message:message,
                            payment_idx:body.idx,


                        },success:function(res){



                        }
                    })

                }else{





                    let message = `${name} 보호자님\n` +
                        `${data.shop_name}에서 ${name} 미용예약 확정을 위한 예약금 입금 안내를 드립니다.\n` +
                        '\n' +
                        `저희 ${data.shop_name}에서는 예약금 ${reserve_pay_price}원 입금 후에 예약이 확정됩니다.\n` +
                        '\n' +
                        '1. 예약내용\n' +
                        `- 예약일시 : ${year}년 ${month}월 ${day}일 ${hour}시 ${min}분\n` +
                        '\n' +
                        '2. 예약금 입금계좌\n' +
                        `- 예약금 : ${reserve_pay_price}원\n` +
                        `- ${bank} / ${account}\n` +
                        `- 결제기한 : ${deadline_date.getFullYear()}년 ${fill_zero(deadline_date.getMonth()+1)}월 ${fill_zero(deadline_date.getDate())}일 ${am_pm_check(deadline_date.getHours())}시 ${fill_zero(deadline_date.getMinutes())}분\n` +
                        '\n' +
                        '▶ 결제기한 경과시 예약은 자동취소 되오니 기한 내 꼭 입금부탁드립니다. '

                    $.ajax({

                        url:'/data/pc_ajax.php',
                        type:'post',
                        data:{

                            mode:'deposit_allim',
                            cellphone:cellphone,
                            message:message,


                        },success:function(res){



                        }
                    })
                }

                // target.checked = true;
                let date_ = new Date();
                if(reserve_pay_yn == 0){
                    target.checked = false;
                    document.getElementById('pay_deposit_title').innerText = '예약금 미입금';
                    document.getElementById('pay_deposit_title').classList.remove('actived');
                    document.getElementById('pay_deposit_date').style.display = 'none';
                    document.getElementById('pay_deposit_date').innerText = '';

                }else{
                    target.checked = true;
                    document.getElementById('pay_deposit_title').innerText = '예약금 입금완료';
                    document.getElementById('pay_deposit_title').classList.add('actived');
                    document.getElementById('pay_deposit_date').style.display = 'flex';
                    document.getElementById('pay_deposit_date').innerText = `(입금처리 : ${date_.getFullYear()}. ${fill_zero(date_.getMonth()+1)}. ${fill_zero(date_.getDate())}. ${am_pm_check(date_.getHours())}시 ${fill_zero(date_.getMinutes())}분)`

                }


            }
        }
    })
}

function reset_deposit_popup(target){

    if(target.checked === true){

        return;
    }else{


        pop.open('deposit_reset_pop');
    }


}

function reset_deposit(target,id){

    let artist_id = id;
    let bank = target.getAttribute('data-bank');
    let account = target.getAttribute('data-account');


    $.ajax({

        url:'/data/pc_ajax.php',
        type:'post',
        data:{
            mode:'deposit_save',
            artist_id:artist_id,
            reserve_price:0,
            deadline:0,
            bank_name:bank,
            account_num:account,

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

function open_payment_allim(cellphone,payment_idx,pet_name){



    $.ajax({

        url:'/data/reserve_alarm_inquiry.php',
        type:'post',
        data:{
            cellphone:cellphone,
            payment_log_seq:payment_idx,
            pet_name:pet_name,
        },
        success:function(res) {

            let response = JSON.parse(res);
            let body = response.data;

            if(body === null){
                document.getElementById('allimtalk_exist').innerHTML = `<tr id="allimtalk_none">
                                                                <td colspan="4" class="none">
                                                                    <div class="common-none-data">
                                                                        <div class="none-inner">
                                                                            <div class="item-visual"><img src="/static/images/icon/img-illust-3@2x.png" alt="" width="103"></div>
                                                                            <div class="item-info">알림톡 발송 내역이 없습니다.</span></div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>`
            }else{


                document.getElementById('allimtalk_exist').innerHTML = '';

                body.forEach(function(el){

                    console.log(el)
                    let code = '';
                    switch(el.template_code){

                        case "1000004530_14040" : code = '예약등록'; break;
                        case "1000004530_20001" : code = '예약등록'; break;
                        case "1000004530_20002" : code = '예약변경'; break;
                        case "1000004530_14041" : code = '예약변경'; break;
                        case "1000004530_20003" : code = '하루 전 알림'; break;
                        case "1000004530_14043" : code = '하루 전 알림'; break;
                        case "1000004530_20004": code = '미용종료'; break;
                        case "1000004530_14042": code = '미용종료'; break;
                        case "1000004530_20005" : code = "미용즉시종료";break;
                        case "1000004530_14042_1" : code = "미용즉시종료";break;
                        case "1000004530_20006" : code = "예약취소"; break;
                        case "1000004530_14044" : code = "예약취소"; break;
                        case "1000004530_20007" : code = "미용신청승인";break;
                        case "1000004530_14045" : code = "미용신청승인";break;
                        case "1000004530_14516" : code = "미용동의서";break;
                        case "1000004530_20018" : code = "알림장 안내"; break;

                    }
                    document.getElementById('allimtalk_exist').innerHTML += `<tr>
                                                                            <td class="">${el.date_client_req.split(' ')[0]}<br>${el.date_client_req.split(' ')[1]}</td>
                                                                            <td class="">${code}</td>
                                                                            <td class="text-align-left"><span style="white-space: pre-line">${el.content}</span></td>
                                                                            <td class="">알림톡 발송</td>
                                                                        </tr>`
                })


            }
            console.log(body)
        }
    })
    pop.open('reserveAlarmInquiryPop');



}


function pay_management_shortcut(target){

    event.preventDefault();




    let href = target.getAttribute('href').replace('#','');

    if(href === 'pay_card_header'){
        $("#pay_management").stop().animate({ scrollTop : 0 } , 500, "easeInOutExpo");
    }else if(href === 'scroll_target'){
        let scroll=0;
        let scroll_2 =0;
        try{
            Array.from($("[class*='pay-card-content']")).forEach(function(el){

                if(el.getAttribute('id') === 'scroll_target'){
                    throw new Error("stop!");
                }
                if(el.scrollHeight === undefined){
                    el.scrollHeight= 0;
                }
                scroll += $(el).outerHeight(true);

                if(document.getElementById('pay_card_content_0').style.display === 'none'){
                    scroll_2=0;
                }else{
                    scroll_2=50;
                }

            })
        }catch(e){

        }


        $("#pay_management").stop().animate({ scrollTop : Math.floor(scroll)+scroll_2 } , 500, "easeInOutExpo");

    }else if(href === 'sticky-tab-group-target'){
        let scroll=0;
        let scroll_2=0;
        try{
            Array.from($("[class*='pay-card-content']")).forEach(function(el){

                if(el.getAttribute('id') === 'sticky-tab-group-target'){
                    throw new Error("stop!");
                }
                if(el.scrollHeight === undefined){
                    el.scrollHeight= 0;
                }
                scroll += $(el).outerHeight(true);

                if(document.getElementById('pay_card_content_0').style.display === 'none'){
                    scroll_2=0;
                }else{
                    scroll_2=50;
                }
            })
        }catch(e){

        }


        $("#pay_management").stop().animate({ scrollTop : Math.floor(scroll)+scroll_2 } , 500, "easeInOutExpo");
    }

function deposit_background(target) {

    if (target.checked === true) {

        target.parentElement.parentElement.parentElement.classList.add('allimi-wrap-bg-purple')
        target.parentElement.parentElement.parentElement.classList.remove('allimi-wrap-bg-gray')
    } else {
        target.parentElement.parentElement.parentElement.classList.add('allimi-wrap-bg-gray')
        target.parentElement.parentElement.parentElement.classList.remove('allimi-wrap-bg-purple')
    }
}
    


