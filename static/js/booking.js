//일간 예약관리 렌더
function schedule_render(){

    $.ajax({

        url:'../data/pc_ajax.php',
        type:'post',
        data:{
            mode:'day_book',
            login_id:sessionStorage.getItem('id'),
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


                reserve_schedule().then(function(){
                    cols().then(function (){


                        let color;
                        body.forEach(function (el){


                            Array.from(document.getElementsByClassName('calendar-day-body-col')).forEach(function (el_){

                                if(el_.getAttribute('data-name') === el.product.worker && new Date(el_.getAttribute('data-year'),el_.getAttribute('data-month'),el_.getAttribute('data-date'),el_.getAttribute('data-hour'),el_.getAttribute('data-minutes')).getTime() === new Date(el.product.date.booking_st).getTime() ){
                                    switch(el.product.pay_type){

                                        case "pos-card" || "pos-cash" : color = 'yellow'; break;
                                        case "offline-card" || "offline-cash" : color = 'purple'; break;
                                        default : color = ''; break;

                                    }

                                    el_.setAttribute('data-pay',el.product.payment_idx)

                                    let multiple = (new Date(el.product.date.booking_fi).getTime() - new Date(el.product.date.booking_st).getTime())/1800000;
                                    el_.innerHTML = `<div class="calendar-drag-item-group">
                                                                        <a href="#" class="btn-calendar-add">등록하기</a>
                                                                        <a href="./reserve_pay_management_beauty_1.php" onclick="sessionStorage.setItem('payment_idx',${el_.getAttribute('data-pay')})" class="calendar-week-time-item toggle green ${color} ${el.product.is_no_show === 1 ? "red" : ''}" style="height: calc(100% * ${multiple}); ">
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
                                login_id:sessionStorage.getItem('id'),
                            },
                            success:function (res){
                                let response = JSON.parse(res);
                                let head = response.data.head;
                                let body = response.data.body;
                                if (head.code === 401) {
                                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                                } else if (head.code === 200) {
                                    console.log(body);


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


//booking
function book_list() {
    return new Promise(function (resolve){

        $.ajax({
            url: '../data/pc_ajax.php',
            data: {
                mode: 'month_book',
                login_id: sessionStorage.getItem('id'),
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
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {
                    sessionStorage.setItem('list', JSON.stringify(body));
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
                                                                                           <a href="../booking/reserve_advice_view.php" onclick="sessionStorage.setItem('consulting_select','${(el.pet_name + el.phone).toString()}')" class="customer-card-item transparent">
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
                                                                                         <div class="${(el.pet_name+el.phone).toString() === sessionStorage.getItem('consulting_select') ? 'actived':''} thema-gray-item white consulting-select" data-pet_name="${el.pet_name}" data-phone="${el.phone}">
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
    sessionStorage.removeItem('consulting_select');

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
                                                                                         <div class="thema-gray-item white consulting-select ${(el.pet_name + el.phone).toString() === sessionStorage.getItem('consulting_select') ? 'actived' : ''}" data-pet_name="${el.pet_name}" data-phone="${el.phone}">
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
                                                                                                                            <div class="txt">슬개골 탈구</div>
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

//미니달력 달바꾸기
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

        let select = sessionStorage.getItem('day_select').split('.');

        date.setFullYear(parseInt(select[0]));
        date.setMonth(parseInt(select[1])-1);
        date.setDate(parseInt(select[2]));

        resolve();

    })


}

//일간 예약관리 스케쥴 시간cols
function reserve_schedule(){

    return new Promise(function (resolve){




        $.ajax({

            url:'../data/pc_ajax.php',
            type:'post',
            data:{
                mode:'open_close',
                login_id:sessionStorage.getItem('id')

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

//일간 예약관리 스케쥴 cols
function cols(){


    return new Promise(function (resolve){



        $.ajax({

            url:'../data/pc_ajax.php',
            type:'post',
            async:false,
            data:{
                mode:'working',
                login_id:sessionStorage.getItem('id'),
            },
            success:function (res){

                let response = JSON.parse(res);
                let head = response.data.head;
                let body = response.data.body;
                if (head.code === 401) {
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
                } else if (head.code === 200) {

                    document.getElementById('day_header_row').innerHTML = `<div class="calendar-day-header-col time"></div>`
                    let break_time = JSON.parse(sessionStorage.getItem('break_time'))
                    let break_times = '';
                    break_time.forEach(function(el,i){
                        break_times += `${el.time.split('~')[0]} `
                    })
                    body.forEach(function (el){
                        if(el.is_show && !el.is_leave){
                            el.work.forEach(function (el_){
                                if(parseInt(el_.week) === date.getDay() ){
                                    document.getElementById('day_header_row').innerHTML +=`<div class="calendar-day-header-col">${el.nick}</div>`
                                    Array.from(document.getElementsByClassName('calendar-day-body-row')).forEach(function(_el){
                                        _el.innerHTML += `<div class="calendar-day-body-col time-compare-cols ${break_times.match(_el.getAttribute('data-time-to')) ? 'break':'' }" data-name="${el.name}" data-nick="${el.nick}" data-time-to="${_el.getAttribute('data-time-to')}" data-time-from="${_el.getAttribute('data-time-from')}" data-year="${date.getFullYear()}" data-month="${date.getMonth()}" data-date="${date.getDate()}" data-hour="${_el.getAttribute('data-hour')}" data-minutes="${_el.getAttribute('data-minutes')}">
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

//일간 예약관리 스케쥴 버튼 날짜변경
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

                if(sessionStorage.getItem('list')){
                    booking_list = JSON.parse(sessionStorage.getItem('list'));
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
                        sessionStorage.setItem('day_select', `${date.getFullYear()}.${fill_zero(date.getMonth() + 1)}.${fill_zero(el.children[0].children[0].children[0].children[0].innerText.trim())}`)
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

                if(sessionStorage.getItem('list')){
                    booking_list = JSON.parse(sessionStorage.getItem('list'));
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
                        sessionStorage.setItem('day_select', `${date.getFullYear()}.${fill_zero(date.getMonth() + 1)}.${fill_zero(el.children[0].children[0].children[0].children[0].innerText.trim())}`)
                        date.setDate(el.children[0].children[0].children[0].children[0].innerText.trim());

                        schedule_render();

                    })
                })




            })
        }
        schedule_render()


    })
}

//일간 예약관리 스케쥴표 break_time
function break_time(){


    $.ajax({


        url:'../data/pc_ajax.php',
        type:'post',
        data:{

            mode:'break_time',
            login_id:sessionStorage.getItem('id'),
        },
        success:function(res){
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {

                sessionStorage.setItem('break_time',JSON.stringify(body[0].res_time_off))




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

//작업결제관리 페이지
function pay_management(){


    $.ajax({


        url:'../data/pc_ajax.php',
        type:'post',
        data:{

            mode:'pay_management',
            payment_idx:sessionStorage.getItem('payment_idx'),
        },
        success:function (res){
            let response = JSON.parse(res);
            let head = response.data.head;
            let body = response.data.body;
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                console.log(body);
                let work_body_inner = document.getElementById('work_body_inner');


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
                                                    
<!--                                               노쇼 데이터         <div class="label label-outline-pink">NO SHOW 1회</div>-->
<!--                                                        <a href="#" class="btn btn-inline btn-red">NO SHOW 등록</a>-->
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
                                                                <!-- 입질 데이터 -->
                                                                    <div class="txt">입질</div>
                                                                </div>
                                                                <div class="flex-table-data">
                                                                    <div class="flex-table-data-inner">
                                                                        미기입
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2 toggle">
                                                            <div class="flex-table-item">
                                                                <div class="flex-table-title">
                                                                <!-- 슬개골 탈구 데이터 -->
                                                                    <div class="txt">슬개골 탈구</div>
                                                                </div>
                                                                <div class="flex-table-data">
                                                                    <div class="flex-table-data-inner">
                                                                        미기입
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
                                                                        ${body.etc}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid-layout-cell grid-2 toggle">
                                                            <div class="flex-table-item">
                                                                <div class="flex-table-title">
                                                                <!-- 싫어하는 부위 -->
                                                                    <div class="txt">싫어하는 부위</div>
                                                                </div>
                                                                <div class="flex-table-data">
                                                                    <div class="flex-table-data-inner">
                                                                        미기입
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
                                        </div>`

            }

        }
    })

}

function payment_before_etc(){

    $.ajax({

        url:'../data/pc_ajax.php',
        type:'post',
        data:{

            mode:'payment_before_etc',
            payment_idx:sessionStorage.getItem('payment_idx'),
        },
        success:function(res){
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
}


function work_body_inner(){




}