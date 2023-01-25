'use strict';
//PHPにカードまで作らせてやるのとどっちが楽か検証
const pr_arr_li = [["",'id'],['投稿者：','user_id'],['重要度：','importance'],['モード','mode']];
function ce_topic(data){
    for(let i=0;i<data.length;i++){
        let ce_ct = document.createElement('section');
        ce_ct.classList.add('tpContainer');
        let ce_card = document.createElement('div');
        ce_card.classList.add('tpCard');

        let ce_head = document.createElement('div');
        ce_head.classList.add('cardHead');
        let ce_ul = document.createElement('ul');
        for(let i=0;i<4;i++){
            let ce_li = document.createElement('li');
            ce_li.textContent=pr_arr_li[i][0];
            let ce_span = document.createElement('span');
            ce_span.textContent = pr_arr_li[i][1];
            ce_ul.appendChild(ce_li);
        }
        ce_button = document.createElement();
        ce_head.appendChild(ce_ul);
        
        let ce_body = document.createElement('div');
        ce_body.classList.add('cardBody');

        

    }

}