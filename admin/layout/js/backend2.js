$(function () {
  "use strict";

  //dashboard
  $(".toggle-info").click(function () {
    $(this)
      .toggleClass("selected")
      .parent()
      .next(".pannel-body")
      .slideToggle(200);

    if ($(this).hasClass("selected")) {
      $(this).html('<i class="fa fa-plus"></i>');
    } else {
      $(this).html('<i class="fa fa-minus"></i>');
    }
  });

  //confirmation message on delete
  $(".confirm").click(function () {
    return confirm("Are You Sure?");
  });

  $(".cat h3").click(function () {
    $(this).next(".full-view").fadeToggle(200);
  });
  $(".option span").click(function () {
    $(this).addClass("active").siblings("span").removeClass("active");

    if ($(this).data("view") === "full") {
      $(".cat .full-view").fadeIn(200);
    } else {
      $(".cat .full-view").fadeOut(200);
    }
  });
});
