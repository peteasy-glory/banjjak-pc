var shop_array = [];

// 이미지 추가 클릭시
function MemofocusNcursor() {
    html = "<div id='upimgarea'></div>";
    //document.getElementById('dmemo').focus();
    var sel, range;
    if (window.getSelection) {
        // IE9 and non-IE
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();

            // Range.createContextualFragment() would be useful here but is
            // non-standard and not supported in all browsers (IE9, for one)
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment(),
                node, lastNode;
            while ((node = el.firstChild)) {
                lastNode = frag.appendChild(node);
            }
            range.insertNode(frag);

            // Preserve the selection
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if (document.selection && document.selection.type != "Control") {
        // IE < 9
        document.selection.createRange().pasteHTML(html);
    }

    $("#addimgfile").trigger("click");

}

// 샵 대문사진 가져오기
function get_front_img(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'get_front_img',
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
                shop_array.push(body);
            }
        }
    })
}

// 샵 대표사진 변경
function change_main(id, src){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'put_front_main',
            login_id: id,
            image:src,
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
                pop.open('reloadPop', '완료되었습니다.');
            }
        }
    })
}

// 대문사진 삭제하기
function del_front(id, src){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'del_front',
            login_id: id,
            image:src,
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
                pop.open('reloadPop', '삭제되었습니다.');
            }
        }
    })
}

// 포트폴리오 사진 불러오기
function get_portfolio(id){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'get_portfolio',
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
                shop_array.push(body);
            }
        }
    })
}

// 포트폴리오 삭제하기
function del_gallery(idx){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'del_gallery',
            idx: idx,
        },
        type: 'POST',
        async:false,
        success: function (res) {
            console.log(res);
            let response = JSON.parse(res);
            let head = response.data.head;
            console.log(response);
            if (head.code === 401) {
                pop.open('firstRequestMsg1', '잠시 후 다시 시도 해주세요.');
            } else if (head.code === 200) {
                pop.open('reloadPop', '삭제되었습니다.');
            }
        }
    })
}

// 샵 정보 가져오기
function get_shop_info(id){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'get_shop_info',
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
                shop_array.push(body);
            }
        }
    })
}

// 자격증 수상경력 가져오기 0:자격증, 1:수상경력
function get_license_award(id, type){

    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'get_license_award',
            login_id: id,
            type: type,
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
                shop_array.push(body);
            }
        }
    })
}

// 자격증/수상 삭제하기
function delete_license_award(data){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: data,
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
                pop.open('reloadPop', '삭제되었습니다.');
            }
        }
    })
}

// 샵 리뷰리스트 불러오기
function get_review_list(id){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode: 'get_review_list',
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
                shop_array.push(body);
            }
        }
    })
}

// 답글 작성 및 수정
function put_reply(data){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: data,
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
                pop.open('reloadPop', '저장되었습니다.');
            }
        }
    })
}

// 답글 삭제
function del_reply(idx){
    $.ajax({
        url: '../data/pc_ajax.php',
        data: {
            mode:"del_reply",
            idx: idx,
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
                pop.open('reloadPop', '삭제되었습니다.');
            }
        }
    })
}