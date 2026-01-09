function loadPage(page, push = true) {
    $('#app-content').html(`
        <div id="loading-overlay">
    <div class="loading-box">
        <div class="apple-spinner"></div>
        <div class="loading-text">Đang tải...</div>
    </div>
</div>
        `);

    const currentPage = history.state?.page;

    // ❌ Nếu đang ở page này → không làm gì
    if (push && currentPage === page) {
        return;
    }
    

    $.get('/spa/' +page, function (html) {
        $('#app-content').html(html);

        if (push) {
            history.pushState({ page }, '', '/' + page);
            console.log(history.state);
        }
    });
}


// Click menu
$(document).on('click', '.spa-link', function (e) {
    e.preventDefault();
    loadPage($(this).data('page'));
});

// Back / Forward
window.onpopstate = function (e) {
    const page = e.state?.page || 'dashboard';

    // Load nội dung
    loadPage(page, false);

    // 🔥 ĐỒNG BỘ LẠI STATE VỚI URL
    history.replaceState({ page }, '', '/' + page);
};

function spaBack() {
    if (history.length > 1) {
        history.back();
    } else {
        loadPage('dashboard'); // hoặc page mặc định
    }
}
$(document).ready(function () {
    if (history.state) return;

    const page = location.pathname.replace('/', '') || 'dashboard';
    history.replaceState({ page }, '', '/' + page);
});