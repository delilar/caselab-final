
document.addEventListener("DOMContentLoaded", function() {
    const slides = document.querySelectorAll('.slide');
    const prevButton = document.getElementById('prevBtn');
    const nextButton = document.getElementById('nextBtn');
    const submitButton = document.getElementById('submitBtn');
    let currentSlide = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            if (i === index) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });

        if (index === 0) {
            prevButton.style.display = 'none';
        } else {
            prevButton.style.display = 'inline-block';
        }

        if (index === slides.length - 1) {
            nextButton.style.display = 'none';
            submitButton.style.display = 'block';
        } else {
            nextButton.style.display = 'block';
            submitButton.style.display = 'none';
        }
    }

    showSlide(currentSlide);

    prevButton.addEventListener('click', function() {
        if (currentSlide > 0) {
            currentSlide--;
            showSlide(currentSlide);
        }
    });

    nextButton.addEventListener('click', function() {
        if (currentSlide < slides.length - 1) {
            currentSlide++;
            showSlide(currentSlide);
        }
    });

    submitButton.addEventListener('click', function() {
        document.querySelector('.modal').showModal();
    })

    document.querySelector('.modal .close').addEventListener('click', function () {
        document.querySelector('.modal').close();
    });
});
