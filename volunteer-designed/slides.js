let currentSlide = 1;
const totalSlides = document.querySelectorAll('.slide').length;

function showSlide(slideIndex) {
    const slides = document.querySelectorAll('.slide');
    const radios = document.querySelectorAll('.slideshow input[type="radio"]');
    const navLabels = document.querySelectorAll('.navigation label');

    if (slideIndex > totalSlides) {
        currentSlide = 1;
    } else if (slideIndex < 1) {
        currentSlide = totalSlides;
    } else {
        currentSlide = slideIndex;
    }

    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
        radios[i].checked = false;
        navLabels[i].classList.remove('active');
    }

    slides[currentSlide - 1].style.display = 'block';
    radios[currentSlide - 1].checked = true;
    navLabels[currentSlide - 1].classList.add('active');
}

function nextSlide() {
    showSlide(currentSlide + 1);
}

function prevSlide() {
    showSlide(currentSlide - 1);
}

document.addEventListener('DOMContentLoaded', () => {
    const navLabels = document.querySelectorAll('.navigation label');
    navLabels.forEach((label, index) => {
        label.addEventListener('click', () => {
            showSlide(index + 1);
        });
    });

    showSlide(currentSlide);
});
