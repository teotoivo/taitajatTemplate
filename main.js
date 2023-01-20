$(function () {
  $(".menuBurger").on("click", function () {
    $(".menu").toggleClass("open");
    $("nav").toggleClass("open");
    $("header").toggleClass("open");
  });
});
