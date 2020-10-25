let arrow = document.querySelector('i.fa-arrow-circle-up')
window.addEventListener('scroll', () => {
    if (document.querySelector('.bss').getBoundingClientRect().top < 0) {
        arrow.style.opacity = '1';
        arrow.style.display = 'block';
    } else {
        arrow.style.opacity = '0';
    }
    if (document.querySelector('.bss').getBoundingClientRect().top - 30 > 0) {
        arrow.style.display = 'none'
    }
})

arrow.addEventListener('click', () => {
    window.scrollTo(0, 0)
})

document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.bss').getBoundingClientRect().top < 0) {
        arrow.style.opacity = '1'
        arrow.style.display = 'block'
    }
})
