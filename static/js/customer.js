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