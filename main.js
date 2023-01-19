$(function () {
  $(".menuBurger").on("click", function () {
    console.log("clicked");
    $(".menu").toggleClass("open");
  });
});
