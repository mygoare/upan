$(function(){
  // ajax upload file
  $("#upload_file").change(function(){
    $("#upload_file_form").submit();
  });
  var upload_file_options = {
    dataType : 'json',
    type     : 'POST',
    url      : data.upload_url,
    success  : function(res){
      $(".entry_hover").fadeOut(800,function(){
        $("#file_code").slideDown(1000).find("#slug").html(res.slug);
      });
    }
  };
  $("#upload_file_form").ajaxForm(upload_file_options);

  // enter to download
  $("#input_code").keyup(function(){
    if($(this).val().length == 4){
      //console.log("you can press enter to download your file.")
    }
  });

  //nav focus
  function nav_focus(nav_id){
    // arguments
    var nav = $(nav_id);
    var dir_name = arguments[1] ? arguments[1] : '/';

    // variables
    var nav_path_name = window.location.pathname;
    var nav_a_link = nav.find("a");

    if(nav_path_name == dir_name){
      nav.find("a[title='home']").css({"box-shadow":"0px 3px 0px #d0d0d0"});
    }else{
      for(var i = 0; i < nav_a_link.length; i++){
        if(nav_path_name.search(nav_a_link[i].title) != -1){
          $(nav_a_link[i]).css({"box-shadow":"0px 3px 0px #d0d0d0"});
        }
      }
    }
  }
  nav_focus("#nav","/upan/");

  // 倒计时
  function count_down (Seconds) {
    var i = Seconds;
    var a = window.setInterval(function() {
      $("#get_file").find("span").html(i);
      if (i == 0) {
        clearInterval(a);
      }
      i--;
    }, 1000);
  }

  var get_file_options = {
    dataType : 'json',
    type     : 'POST',
    url      : data.get_file_url,
    success  : function(res){
      count_down(5);
      $(".entry_hover").fadeOut(800,function(){
        $("#get_file").slideDown(1000).find("#file_url").attr("href", res.file_url);
      }).append('<meta http-equiv="Refresh" content="5;'+res.file_url+'">');
    }
  };
  $("#input_code_form").ajaxForm(get_file_options);
});
