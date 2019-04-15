  var imgChoiceLength = document.querySelector(".allSlider");
  var imgChoiceSlider = document.querySelectorAll("#vignettes");
  var numberImg = imgChoiceLength.attributes[1].value;

if (window.matchMedia("(min-width: 1280px) and (max-width: 2400px)").matches) {
  for (i = 0; i < imgChoiceSlider.length; i++) {
    imgChoiceSlider[i].style.width = (200 / parseInt(numberImg)+"%");
  }
} else if (window.matchMedia("(min-width: 900px) and (max-width: 1280px)").matches) {
  for (i = 0; i < imgChoiceSlider.length; i++) {
    imgChoiceSlider[i].style.width = (300 / parseInt(numberImg)+"%");
  }
} else if (window.matchMedia("(min-width: 600px) and (max-width: 900px)").matches) {
  for (i = 0; i < imgChoiceSlider.length; i++) {
    imgChoiceSlider[i].style.width = (400 / parseInt(numberImg)+"%");
  }
} else if (window.matchMedia("(min-width: 350px) and (max-width: 600px)").matches) {
  for (i = 0; i < imgChoiceSlider.length; i++) {
    imgChoiceSlider[i].style.width = (500 / parseInt(numberImg)+"%");
  }
}
