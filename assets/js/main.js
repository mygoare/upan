$(function(){
  // ajax upload file
  $("#upload_file").change(function(){
    if (html5_read_file_size()) {
      $("#upload_file_form").submit();
    }
  });
  var upload_file_options = {
    dataType     : 'json',
    type         : 'POST',
    url          : data.upload_url,
    beforeSubmit : function () {
      $('#upload_file').attr('disabled', "disabled").css("cursor","not-allowed").parent().find("span").html("Uploading...");
    },
    success      : function(res){
      if (res.status == 0) {
        $("#upload_file_form > .file_upload_error").html(res.msg);
        $('#upload_file').removeAttr('disabled').css('cursor', 'pointer').parent().find("span").html('选择文件');
      } else {
        $(".entry_hover").fadeOut(800,function(){
          $("#file_code").slideDown(1000).find("#slug").html(res.slug);
        });
      }
    }
  };
  $("#upload_file_form").ajaxForm(upload_file_options).resetForm();

  //html5 read file size
  var file_size_warning = "文件大小请不要超过5M";
  function html5_read_file_size () {
    if (window.File) {
      if (window.document.getElementById("upload_file").files[0].size > 5*1024*1024) {
        // do some action
        $("#upload_file_form > .file_upload_error").html(file_size_warning);
        return false;
      } else {
        return true;
      }
    } else {
      return true;
    }
  }


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

  // enter to download
  var press_enter = "回车提交";
  var notice_4 = "请输入4位提取码";
  function guard_input_code () {
    $("#input_code").keyup(function(){
      if($(this).val().length == 4){
        $(".code_notice_box").html('<span class="notice">'+press_enter+'</span>');
      } else if ($(this).val().length == 0) {
        $(".code_notice_box").html("");
      } else {
        $(".code_notice_box").html('<span class="warn">'+notice_4+'</span>');
      }
    });
  }
  guard_input_code();

  var flag = false;  // 防止重复提交
  var get_file_options = {
    dataType     : 'json',
    type         : 'POST',
    url          : data.get_file_url,
    beforeSubmit : function () {
        if($("#input_code").val().length != 4){
          $(".code_notice_box").html('<span class="warn">'+notice_4+'</span>');
          return false;
        } else {
          if (flag == true) {
            return false;
          }
          flag = true;
          $("#input_code").attr("disabled", "disabled");
        }
    },
    success      : function(res){
      if (res.status) {
        count_down(5);
        $(".entry_hover").fadeOut(800,function(){
          $("#get_file").slideDown(1000).find("#file_url").attr("href", res.file_url);
        }).append('<meta http-equiv="Refresh" content="5;'+res.file_url+'">');
      } else {
        $(".notice_box").html('<span class="error">'+res.msg+'</span>');
      }
      flag = false;
      $("#input_code").removeAttr("disabled").blur();
    }
  };
  $("#input_code_form").ajaxForm(get_file_options);

  // ie or not ie
  if (!-[1,]) {
    $(".recommend_browder").show();
  }
});
