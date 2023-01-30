$(function () {
  $(".menuBurger").on("click", function () {
    $(".menu").toggleClass("open");
    $("nav").toggleClass("open");
    $("header").toggleClass("open");
    $(document).on("click", function (event) {
      if (!$(event.target).closest("nav").length) {
        // Click happened outside of the element
        $(".menu").toggleClass("open");
        $("nav").toggleClass("open");
        $("header").toggleClass("open");
        //remove event listerer
        $(document).off("click");
      }
    });
  });
});
