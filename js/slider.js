const  slider = document.querySelector("#slider");
let sliderSection = document.querySelectorAll(".slider__section");
let sliderSectionLast = sliderSection[sliderSection.length -1];

const btnLeft = document.querySelector("#btn-left");
const btnRight = document.querySelector("#btn-right");

slider.insertAdjacentElement('afterbegin' , sliderSectionLast);

function Next(){
    let sliderSectionFirst = document.querySelectorAll(".slider__section")[0];
    slider.style.marginLeft = "-200%";
    slider.style.transition = "all 0.5s";
    setTimeout(function(){
        slider.style.transition = "none";
        slider.insertAdjacentElement('beforeend' , sliderSectionFirst);
        slider.style.marginLeft = "-100%";
    }, 500);
}
function Prev(){
    let sliderSection = document.querySelectorAll(".slider__section");
    let sliderSectionLast = sliderSection [sliderSection.length -1];
    slider.style.marginLeft = "0";
    slider.style.transition = "all 0.5s";
    setTimeout(function(){
        slider.style.transition = "none";
        slider.insertAdjacentElement('afterbegin' , sliderSectionFirst);
        slider.style.marginLeft = "-100%";
    }, 500);
}
btnRight.addEventListener('click' , function(){
    Next();
});
btnLeft.addEventListener('click' , function(){
    Prev();
});

setInterval(function(){
    Next();
    
}, 7000);

window.addEventListener( 'load', function(){
    new Glider(document.querySelector( '.carousel__lista'), {
        slidesToShow: 4,
        slidesToScroll: 4,
        draggable: true,
        dots: '.carousel__indicadores',
        arrows: {
          prev: '.carousel__anterior',
          next: '.carousel__siguiente'
        }

    });
});