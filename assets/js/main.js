$(function(){
  // ajax upload file
  $("#upload_file").change(function(){
    $("#upload_file_form").submit();
  });
  var upload_file_options = {
    dataType : 'json',
    type : 'POST',
    url : upload_url,
    success : function(res){
      $(".entry_hover").fadeOut(800,function(){
        $("#file_code").slideDown(1000);
      });
    }
  };
  $("#upload_file_form").ajaxForm(upload_file_options);

  // enter to download
  $("#input_code").keyup(function(){
    if($(this).val().length == 4){
      console.log("you can press enter to download your file.")
    }
  });

  //nav focus
  function nav_focus(a_link){
    var nav_path_name = window.location.pathname;
    var nav_a_link = $(a_link);
    for(var i = 0; i < nav_a_link.length; i++){
      if(nav_a_link[i].href.search(nav_path_name) != -1){
        $(nav_a_link[i]).css({"box-shadow":"0px 3px 0px #d0d0d0"});
        break;  // stop the if search, so the nav link won't all be focused
      }
    }
  }

  nav_focus("#nav>ul>li>a");

});
