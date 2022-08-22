var slideIndex = 1;
init()


// Next/previous controls
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// init banners

function init()
{
    showSlides(slideIndex);
    var i = 0
    setInterval(() => {
    var slides = document.getElementsByClassName("mySlides");
    if (i > slides.length) {i = 0}
    currentSlide(i)
    i++
    
}, 2000);
}

// Thumbnail image controls
function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }

  slides[slideIndex-1].style.display = "block";
  
}