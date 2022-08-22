//펫이름or 전화번호검색
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
                    pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
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

//보조연락처(가족)
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

function customer_all(){


    return new Promise(function (resolve){

        document.getElementById('tbody').innerHTML ='';

        let ord = 0;

        let customer_select = document.getElementById('customer_select');

        let value = customer_select.options[customer_select.selectedIndex].value;

        switch(value){

            case 'a' : ord = 0; break;
            case 'b' : ord = 1; break;
            case 'c' : ord = 2; break;
            case 'd' : ord = 3; break;
            case 'e' : ord = 4; break;
        }

        $.ajax({

            url:'../data/pc_ajax.php',
            type:'post',
            data:{

                mode:'customer_all',
                login_id:localStorage.getItem('id'),
                type:'all',
                ord:ord,

            },
            success:function (res){

                let response = JSON.parse(res);
                let customers =response.data
                resolve(customers)
            }
        })
    })

}

function customer_count(){

    $.ajax({

        url:'../data/pc_ajax.php',
        type:'post',
        data:{

            mode:'customer_count',
            login_id:localStorage.getItem('id'),

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

function customer_graph(customers){

    let all = (customers[0].body.length === undefined ? 0 : customers[0].body.length)+(customers[1].body.length === undefined ? 0 : customers[1].body.length)+(customers[2].body.length === undefined ? 0 : customers[2].body.length)
    let beauty = (customers[0].body.length === undefined ? 0 : (customers[0].body.length/all*100).toFixed(1));
    let hotel = (customers[1].body.length === undefined ? 0 : (customers[1].body.length/all*100).toFixed(1));
    let kinder = (customers[2].body.length === undefined ? 0 : (customers[2].body.length/all*100).toFixed(1));

    var chart = bb.generate({
        size: {
            height: 285,
            width: 285
        },
        data: {
            columns: [
                ["유치원", kinder],
                ["호텔", hotel],
                ["미용", beauty]
            ],
            colors: {
                유치원: "#7AE19A",
                호텔: "#FDD94E",
                미용: "#8667c1",

            },
            type: "pie",
            labels: {
                show: false
            }
        },
        /* order: "asc", */ // 그래프 순서 변경하기
        legend: {
            show: false
        },
        // tooltip: {
        //     show: false
        // },
        pie: {
            startingAngle: 0.75,
            innerRadius: {  // 차트 두께
                유치원: 90,
                호텔: 90,
                미용: 90,
            },
            label: {   // text 위치
                ratio: 1,
                format: function(value, id) {		return value +"%";       }
            }
        },
        tooltip: {
            format: {
                value:
                    function(value, id) {		return value +"%";    }
            }
        },
        bindto: "#labelRatio"
    });
}

function customer_list(customers){

    console.log(customers)

    let beauty = customers[0].body;
    let hotel = customers[1].body;
    let kinder = customers[2].body;
    
    let tbody = document.getElementById('tbody');
    

    beauty.forEach(function (el,i){

        // if(i<300) {


            let y = el.ymdhm.substr(0, 4);
            let M = el.ymdhm.substr(4, 2);
            let d = el.ymdhm.substr(6, 2);
            let h = el.ymdhm.substr(8, 2);
            let m = el.ymdhm.substr(10, 2);
            let product = el.product.split('|');
            let size = product[3];
            let b_product = product[4];

            tbody.innerHTML += `<tr class="customer-table-cell">
                                <td>
                                    <div class="customer-table-txt">
                                        <strong>${el.name}</strong>
                                    </div>
                                    <div class="customer-table-txt">
                                        <span class="icon icon-grade-vip"></span>
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
                                    <div class="customer-table-txt">${y}.${M}.${d}</div>
                                    <div class="customer-table-txt">${am_pm_check(h)}:${m}</div>
                                </td>
                                <td>
                                    <div class="customer-table-txt">${size === null || size === "" || size === undefined ? '미기입' : size}</div>
                                </td>
                                <td>
                                    <div class="customer-table-txt">${b_product === null || b_product === "" || b_product === undefined ? '미기입' : b_product}</div>
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
                                        <button type="button" class="btn btn-outline-gray btn-small-size">보기</button>
                                    </div>
                                </td>
                            </tr>`

        // }
    })


}
