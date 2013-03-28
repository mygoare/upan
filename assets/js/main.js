$(function(){
  // ajax upload file
  $("#upload_file").change(function(){
    var is_file_type = upload_file_checker("upload_file");
    if (is_file_type  == false) {
      $(".file_upload_error").html(file_type_warning);
      return false;
    }

    var upload_file_size = get_file_size("upload_file");
    //console.log(upload_file_size);
    if (upload_file_size > 5*1024*1024) {
      $(".file_upload_error").html(file_size_warning);
      return false;
    }

    $("#upload_file_form").submit();
  });
  var upload_file_options = {
    dataType     : 'json',
    type         : 'POST',
    url          : data.base_url+'home/upload_file',
    beforeSubmit : function () {
      $('#upload_file').attr('disabled', "disabled").css({"cursor":"not-allowed", "z-index": -1000}).parent().find("span").html("正在努力上传中...");
      $(".file_upload_error").html("");
    },
    success      : function(res){
      if (res.status == 0) {
        $("#upload_file_form > .file_upload_error").html(res.msg);
        $('#upload_file').removeAttr('disabled').css({'cursor': 'pointer', 'z-index': 0}).parent().find("span").html('选择文件');
      } else {
        $(".entry_hover").fadeOut(800,function(){
          $("#file_code").slideDown(1000).find("#slug").html(res.slug).parent().find(".show_slug").attr("data",res.slug);
        });
      }
    }
  };
  $("#upload_file_form").ajaxForm(upload_file_options).resetForm();

  // get file size
  var file_size_warning = "文件大小请不要超过5M";
  function get_file_size (id) {
    obj = document.getElementById(id);
    var obj_value = obj.value;
    if (obj_value == "") {
      return "";
    }
    var file_size = -1;
    try {
      var fso = new ActiveXObject("Scripting.FileSystemObject");
      file_size = parseInt(fso.GetFile(obj_value).Size);
    } catch (e) {
      try {
        file_size = parseInt(obj.files[0].size);
      } catch (e) {
        file_size = -1;
      }
    }
    return file_size;
  }

  // get file type
  var file_type_warning = "请不要上传禁止文件类型";
  function upload_file_checker (obj) {
    var file_obj = document.getElementById(obj);
    var re = /\.(php|js|jsp|asp|py|rb|sql|sh|html|bat)$/i;
    if (is_ie()) {
      var file_name = file_obj.value;
    } else {
      var file_name = file_obj.files[0].name;
    }
    if (file_name.match(re)) {
      return false;
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
  var checking = "验证中...";
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
    url          : data.base_url+'home/get_file',
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
          $(".code_notice_box").html('<span class="notice">'+checking+'</span>');
        }
    },
    success      : function(res){
      if (res.status) {
        count_down(5);
        $(".entry_hover").fadeOut(800,function(){
          $("#get_file").slideDown(1000).find("#file_url").attr("href", res.file_url);
        }).append('<meta http-equiv="Refresh" content="5;'+res.file_url+'">');
      } else {
        $(".code_notice_box").html('<span class="error">'+res.msg+'</span>');
      }
      flag = false;
      $("#input_code").removeAttr("disabled").blur();
    }
  };
  $("#input_code_form").ajaxForm(get_file_options);

  // ie or not ie
  function is_ie () {
    var user_agent = window.navigator.userAgent;
    return true ? user_agent.match(/msie/i) : false;
  }

  if (is_ie()) {
    $(".recommend_browder").show();
  }

  // create qr code
  $(".create_qr").bind('click',function(){
    $.ajax({
      type     : 'POST',
      data     : {slug : $(".show_slug").attr("data")},
      dataType : 'json',
      url      : data.base_url+'home/create_qr',
      success  : function (res) {
        $("#slug").html("<img src="+res.msg+">");
      }
    });
    $(this).attr("src", data.base_url+"assets/images/qr_sel.png");
  });
  $(".show_slug").click(function(){
    $("#slug").html($(this).attr("data"));
    $(this).attr("src", data.base_url+"assets/images/slug_sel.png");
  });
  $(".send_email").click(function(){
    var email_slug = '<input id="email_slug" style="display:inline;" type="text" name="email" /><button>发送邮件</button>';
    $("#slug").html(email_slug);
    //email_checker("#email_slug"); slug_send_email();
    $(this).attr("src", data.base_url+"assets/images/send_email_sel.png");
  });

  // toggle select list
  function toggle_sel () {
    var all_l = $('.toggle_sel > img');
    for (var i=0; i < all_l.length; i++) {
      $(all_l[i]).click(function(){
        $(this).siblings('img').each(function(index){  // nice each
          this.src = this.src.replace(/_sel/, "");
        });
      });
    }
  }
  toggle_sel();

  function email_checker (id) {
  }

});
