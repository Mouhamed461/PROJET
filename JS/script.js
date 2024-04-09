let slideIndex = 0;
showSlides();

function showSlides() {
    let slides = document.querySelectorAll('.slide');
    let radios = document.querySelectorAll('input[type="radio"][name="slider"]');
    slideIndex++;
    if (slideIndex >= slides.length) {
        slideIndex = 0;
    }
    radios[slideIndex].checked = true;
    setTimeout(showSlides, 5000); 
}
