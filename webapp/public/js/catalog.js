const activeCategory = decodeURIComponent(window.location.pathname).replace('/catalog/', '')
if (!activeCategory == '') {
    document.querySelectorAll('.products-label a').forEach(el => {
        if (el.textContent == activeCategory) {
            el.classList.add('active')
        }
    })
} else {
    document.querySelector('.products-label a:first-child').classList.add('active')
}