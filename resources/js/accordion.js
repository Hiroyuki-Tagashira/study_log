document.querySelectorAll('.accordion-header').forEach((header) => {
    header.addEventListener('click',() => {
        const content = header.nextElementSibling;
        //クリックしたらhiddenを切り替える
        content.classList.toggle('hidden');

        //hiddenがあればfalse,なければtrue
        const isExpanded = content.classList.contains('hidden');
        //isExpandedがfalseならaria-expandedをtrueにして、コンテンツを展開する
        content.setAttribute('aria-expanded', !isExpanded);
        if(!isExpanded) {
            header.textContent = "コードを閉じる";
        } else {
            header.textContent = "コードを見る";
        }
    });
});