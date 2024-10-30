(function() {

  var $ = window.jQuery;

  window.clearappDomain = "http://dashboard.clearapp.net";

  $(function() {

    $(".button-hero").on("click", function() {
      $(this).val("Installing...");
      getUserId();
      return false;
    });

    var getUserId = function() {

      $.ajax({
        type: "GET",
        url: window.clearappDomain + "/api/me?jsonp=true&callback=?",
        async: false,
        jsonpCallback: "jsonCallback",
        contentType: "application/json",
        dataType: "jsonp",
        success: function(response) {
          if (response.error) {
            alert("You are not logged in to the Clearapp dashboard. Please login to install the plugin.");
          } else {
            $("input[name='clearapp_container_id']").val(response.id);
            // setAsInstalled(true, function() {
              $("#clearapp-settings form").submit();
            // });            
          }
        }
      });

    };

  });


}());