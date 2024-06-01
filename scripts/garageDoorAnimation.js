// <!-- 
// Proyek UAS Lab - PW IBDA2012
// Deffrand Farera
// 222201312
// -->

const div = document.querySelector(".garage-door");
setTimeout(() => {
  div.style.transform = "translateY(-100%)";
}, 3000);

setTimeout(() => {
  div.remove();
}, 1000);
