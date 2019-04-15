var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
var currentScrollPos = window.pageYOffset;

  navTools = document.getElementById("navbar");
  if (prevScrollpos > currentScrollPos) {
    navTools.style.top = "0";
  } else {

    navTools.style.top = "-"+navTools.clientHeight+"px";
  }
  prevScrollpos = currentScrollPos;
}
