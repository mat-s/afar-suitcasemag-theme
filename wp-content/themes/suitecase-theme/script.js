jQuery(document).ready(function ($) {
  // ============================
  // Header positioning
  // ============================

  const $body = $("body");
  const $desktop_header = $(".desktop-header");
  var header_offset = $desktop_header.offset().top;

  // Update header position on scroll
  $(window).scroll(function () {
    var scroll_position = $(this).scrollTop();
    update_header_positon(scroll_position);
  });

  function update_header_positon(scroll_position) {
    if (scroll_position > header_offset) {
      $body.addClass("scrolled");
      $desktop_header.addClass("fixed-header");
    } else {
      $body.removeClass("scrolled");
      $desktop_header.removeClass("fixed-header");
    }
  }

  // Initial header position update
  update_header_positon($(document).scrollTop());

  // ============================
  // Search form
  // ============================

  const $search_form = $("#searchform");
  const $search_input = $search_form.find("input[type='search']");
  // Show progress indicator when submitting the search form
  $search_form.on("submit", function () {
    $("#search-progress").addClass("show-search-progress");
  });

  $search_input.on("blur", function () {
    $search_form.removeClass("active");
  });
  $search_input.on("focus", function () {
    $search_form.addClass("active");
  });

  // ============================
  // Menu interactions
  // ============================

  // Open and close menu
  $(".menu-open").on("click", function () {
    toggle_menu(this);
  });

  $(".menu-close").on("click", function () {
    toggle_menu(this);
  });

  // Function to toggle menu visibility
  function toggle_menu(button) {
    var menu_id = $(button).attr("menu-id");
    var toggle_menu = $(document).find("#" + menu_id);

    if (!toggle_menu) return;

    $(button).toggleClass("menu-close");
    $(button).toggleClass("menu-open");
    $(toggle_menu).toggleClass("opened");
    $(toggle_menu).slideToggle();
  }

  // Toggle submenu for menu items with children
  $(".toggle-menu .menu-item-has-children").on("click", function (e) {
    var menu_item = $(e.target).closest(".menu-item");
    var sub_menu = $(menu_item).children(".sub-menu");

    if ($(sub_menu).length) {
      e.preventDefault();
      $(menu_item).toggleClass("opened");
      $(sub_menu).slideToggle();
    }
  });

  // ============================
  // Mobile search
  // ============================
  // Toggle mobile search bar
  $(".mobile-search-toggle").on("click", function () {
    $("#mobile-search-container").slideToggle();
  });

  // ============================
  // Gallery initialization
  // ============================

  // Add navigation buttons to galleries
  $(document)
    .find(".block__gallery")
    .each(function (index, element) {
      $(element).append('<div class="swiper-button-next"></div>');
      $(element).append('<div class="swiper-button-prev"></div>');
    });

  // Add classes for carousel galleries
  $(document)
    .find(".block__gallery-carousel")
    .each(function (index, element) {
      $(element).addClass("swiper-wrapper");
    });

  // Add classes for gallery images in carousel
  $(document)
    .find(".block__gallery-carousel .block__gallery-image")
    .each(function (index, element) {
      $(element).addClass("swiper-slide");
    });

  // ============================
  // Image popup interactions
  // ============================

  // Close image popup
  $("body").on("click", ".image-popup-overlay", function () {
    $(this).fadeOut().remove();
  });

  // Disable default actions for gallery links
  $(".block--gallery a").on("click", function (e) {
    e.preventDefault();
  });

  // ============================
  // Newsletter button
  // ============================
  // Click on newsletter-button and scroll to newsletter section
  $("#newsletter-button").on("click", function (e) {
    e.preventDefault();
    $("html, body").animate(
      {
        scrollTop: $(".newsletter-subscription-form-container").offset().top,
      },
      500
    );
  });
});
