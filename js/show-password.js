//-------------------------------------------
//---- JS for show / hide password input ----
//-------------------------------------------
$(document).ready(function () {
  $(".input-group-append.show-password").click(function(){
    // Select icon and input element
    var showIcon = $(this).find("i");
    var inputField = $(this).siblings("input");
    
    if (inputField.attr("type") === "password") {
      // Show password, and change icon to slashed eye
      inputField.attr("type", "text");
      showIcon.removeClass("fa-eye");
      showIcon.addClass("fa-eye-slash");
    } else {
      // Hide password, and change icon to normal eye
      inputField.attr("type", "password");
      showIcon.removeClass("fa-eye-slash");
      showIcon.addClass("fa-eye");
    }
  });
});