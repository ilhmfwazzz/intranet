$(document).ready(function () {
  // Start Custom File Input JS
  bsCustomFileInput.init();

  // Click form set profile picture when profile image clicked
  $('#changeProfilePic').on('click', function(){
    alert('Make sure the picture size less than 200kb, has square shape, and lower than 500 x 500 pixel resolution');
    $('#pictureInput').click();
  });

  // Submit form profile picture when input value changed
  $('#pictureInput').on('input', function(){
    // Validate image size and dimension first, before submitting it    
    var fileInput = $('#formProfilePic').find("input[type=file]")[0],
        file = fileInput.files && fileInput.files[0];

    if( file ) {
      var img = new Image();
      var sizeAlert = ''
      var dimensionAlert = '';

      img.src = window.URL.createObjectURL( file );

      img.onload = function() {
        var width = img.naturalWidth;
        var height = img.naturalHeight;

        window.URL.revokeObjectURL( img.src );

        if( width != height  ) {
          dimensionAlert = 'Image must be square <br>'
        }
        if(fileInput.files[0].size/1024 >= 200){
          sizeAlert = 'Image must less than 200kb'
        }

        if ( sizeAlert === '' && dimensionAlert === '' ) {
          $('#formProfilePic').submit();
        } else {
          toastr.error( dimensionAlert + sizeAlert );
        }
        $('#formProfilePic input[type=file]').val(null);
      };
    }
    else { //No file was input or browser doesn't support client side reading
        
    }
  });

  //----------------------------------//
  //----- Ajax Edit Profile Form -----//
  //----------------------------------//
  $("#submitProfileButton").click(function(event){
    // Disable Form Submit Behavior
    event.preventDefault();

    // Send Ajax Request
    var request = $.ajax({
      type      : 'POST',
      url       : $('#profileForm').attr('action'),
      dataType  : 'JSON',
      data      : $("#profileForm").serialize()
    });
    request.done(function (response) {
      console.log(response);
      switch (response.code) {
        case 200:
          toastr.success('Success updated profile');
          setTimeout(function(){
            location.reload();
          }, 1000);
          break;
        case 400:
          toastr.error( response.message );
          break;
        case 422:
          toastr.error( 
            (response.data.full_name ? response.data.full_name+'<br>' : '') +
            (response.data.bio ? response.data.bio+'<br>' : '') +
            (response.data.phone_number ? response.data.phone_number : '')
          );
          break;
        case 401:
          toastr.error( 'Session expired, please re-login' );
          break;
        default:
          toastr.error('Error ' + response.code + ' : ' + response.reason_phrase + '<br>' + response.message);
      }
    });

    request.fail(function (response) {
      console.log(response);
      toastr.error('Unknown error');
    });
  });


  //-------------------------------------//
  //----- Ajax Change Password Form -----//
  //-------------------------------------//
  $("#submitPasswordButton").click(function(event){
    // Disable Form Submit Behavior
    event.preventDefault();

    // Send Ajax Request
    var request = $.ajax({
      type      : 'POST',
      url       : $('#passwordForm').attr('action'),
      dataType  : 'JSON',
      data      : $("#passwordForm").serialize()
    });
    request.done(function (response) {
      console.log(response);
      switch (response.code) {
        case 200:
          toastr.success('Success changed password, redirecting...');
          setTimeout(function(){
            location.reload();
          }, 1000);
          break;
        case 400:
          toastr.error( response.message );
          break;
        case 422:
          toastr.error( 
            (response.data.password ? response.data.password+'<br>' : '') +
            (response.data.password_confirm ? response.data.password_confirm : '')
          );
          break;
        case 401:
          toastr.error( response.message );
          break;
        default:
          toastr.error('Error ' + response.code + ' : ' + response.reason_phrase + '<br>' + response.message);
      }
    });

    request.fail(function (response) {
      console.log(response);
      toastr.error('Unknown error');
    });
  });
});