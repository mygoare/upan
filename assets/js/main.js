$(function(){
  String.prototype.trim=function(){return this.replace(/^\s+|\s+$/g, '');};
  // ajax upload file
  $("#upload_file").change(function(){
    var is_file_type = upload_file_checker("upload_file");
    if (is_file_type  === false) {
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
      if (res.status === 0) {
        $("#upload_file_form > .file_upload_error").html(res.msg);
        $('#upload_file').removeAttr('disabled').css({'cursor': 'pointer', 'z-index': 0}).parent().find("span").html('选择文件');
      } else {
        $(".entry_hover").fadeOut(800,function(){
          $("#file_code").slideDown(1000).find("#slug").html(res.slug).parent().find(".show_slug").attr({"data": res.slug, "name": res.file_name});
          // 定义全局变量
          slug_val = res.slug;
          slug_file_name = encodeURIComponent(res.file_name);  // encodeURIComponent 转义，而不是用 escape， 见evernote
        });
      }
    }
  };
  $("#upload_file_form").ajaxForm(upload_file_options).resetForm();

  // get file size
  var file_size_warning = "文件大小请不要超过5M";
  function get_file_size (id) {
    var obj = document.getElementById(id);
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
    if(nav_path_name === dir_name){
      nav.find("a[title='home']").css({"box-shadow":"0px 3px 0px #d0d0d0"});
    }else{
      for(var i = 0; i < nav_a_link.length; i++){
        if(nav_path_name.search(nav_a_link[i].title) != -1){
          $(nav_a_link[i]).css({"box-shadow":"0px 3px 0px #d0d0d0"});
        }
      }
    }
  }
  nav_focus("#nav");

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

  var show_slug_notice = "提取码是区分大小写的";
  var send_email_notice = "若没收到邮件请到\"垃圾箱\"里看一看";
  var create_qr_notice = "请在扫瞄二维码后务必保存！";
  var send_mobile_notice = "开通短信功能，请发送短信 201314 到 1069 0133 9400 9395";

  $(".show_slug").click(function(){
    $("#slug").html($(this).attr("data"));
    $(this).attr("src", data.base_url+"assets/images/slug_sel.png");
    $(".toggle-notice").text(show_slug_notice);
  });

  // create qr code
  $(".create_qr").bind('click',function(){
    $("#slug").html("<span>努力生成二维码...</span>");
    $.ajax({
      type     : 'POST',
      data     : {"slug" : slug_val, "file_name" : slug_file_name},
      dataType : 'json',
      url      : data.base_url+'home/create_qr',
      success  : function (res) {
        var img = new Image();
        img.src = res.msg;  // preload the img src
        img.onload = function(){
          $("#slug").html("<img src="+res.msg+">");
        }
      }
    });
    $(this).attr("src", data.base_url+"assets/images/qr_sel.png");
    $(".toggle-notice").text(create_qr_notice);
  });

  $(".send_email").click(function(){
    var email_slug = '<div class="wrap-div"><span class="email_re_msg"></span><input id="email_addr" style="display:inline;" type="text" name="email" placeholder="请输入邮箱" /><input type="button" class="send-button" value="发送邮件"></div>';
    $("#slug").html(email_slug);
    slug_send_email();
    $(this).attr("src", data.base_url+"assets/images/send_email_sel.png");
    $(".toggle-notice").text(send_email_notice);
  });

  $(".send_mobile").click(function(){
    var mobile_slug = '<div class="wrap-div"><span class="mobile_re_msg"></span><input id="mobile_num" style="display:inline;" type="text" name="mobile" placeholder="请输入手机号" /><input type="button" class="send-button" value="发送短信"></div>';
    $("#slug").html(mobile_slug);
    slug_send_mobile();
    $(this).attr("src", data.base_url+"assets/images/send_mobile_sel.png");
    $(".toggle-notice").text(send_mobile_notice);
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

  function email_checker (email_addr) {
    //checkup_email_addr
    var email_reg = /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
    var flag = true;
    if (email_reg.test(email_addr) == false) {
      $(".email_re_msg").text("请填写正确的邮件地址").css("color","#da4f49");
      flag = false;
    } else { // if block 执行了，else block则不会执行
      // 检查emali是否验证过
      $(".email_re_msg").text("验证中...").css("color","#5bb75b");;
      $.ajax({
        async: false,  // 设置同步 !important
        type : 'POST',
        data : {'email_addr' : email_addr},
        dataType : 'json',
        url : data.base_url+"home/checkup_email",
        success : function (res) {
          if (res.status == 0) {  // 没有通过验证
            $.post(data.base_url+'home/send_checkup_email', {"email_addr" : email_addr}, function(res){
              if (res.status == 1) {
                $(".email_re_msg").text(res.msg).css("color","#da4f49").siblings().hide().parent().append('<input class="verify_input" type="text" style="display:inline;" placeholder="输入验证码" /><input type="button" class="send-button" value="提交验证">');;
                var auth_pair = res.auth;  // 传回的加密后的匹配码
                $(".verify_input").focus();
                var mark = false;  // 防止重复提交插入
                $(".send-button").bind("click",function(){
                  // verify email
                  if (mark == true) {
                    return false;
                  }
                  mark = true;

                  var auth_code = $(".verify_input").val();
                  $(".email_re_msg").text("提交中...").css("color","#5bb75b");;
                  $.post(data.base_url+"home/verify_email", {"auth_code" : auth_code, "auth_pair" : auth_pair, "email_addr" : email_addr, "slug_val" : slug_val, "slug_file_name" : slug_file_name}, function(res){
                    if (res.status == 1) {
                      $(".email_re_msg").text(res.msg).css("color","#5bb75b");
                    } else {
                      $(".email_re_msg").text(res.msg).css("color","#da4f49");
                      mark = false;  // 重置mark为false，可多次验证
                    }
                  }, 'json');
                });
              } else {
                $(".email_re_msg").text(res.msg).css("color","#da4f49");
              }
            }, 'json');
            flag = false;
          }
        }
      });
    }
    return flag;
  }

  function slug_send_email () {
    $(".send-button").click(function () {
      var send_to = $("#email_addr").val().trim();  // 去除空格

      if (email_checker(send_to) == false) {
        return false;
      };

      $.post(data.base_url+"home/send_slug_mail", {"email_addr" : send_to, "slug_val" : slug_val, "slug_file_name" : slug_file_name}, function(res){
        if (res.status == 1) {
          $(".email_re_msg").text(res.msg).css("color","#5bb75b");
        } else {
          $(".email_re_msg").text(res.msg).css("color","#da4f49");
        }
      }, 'json');
      //var mail_url = "http://www.upan.us/send_mail.php?send_to="+send_to+"&slug_val="+slug_val+"&file_name="+slug_file_name+"&subject=您的云文件提取码&callback=?";
      //$.ajax({
        //dataType : 'jsonp',
        //url : mail_url,
        //success : function (res) {
          //if (res.status) {
            //$(".email_re_msg").text("邮件已发送至 "+$("#email_addr").val()+"，请注意查收").css("color","#5bb75b");
          //} else {
          //}
        //}
      //});
    });
  }

  // 短信模块
  function mobile_checker (mobile_num) {
    var flag = true;
    var mobile_reg = /^(1(([35][0-9])|(47)|[8][0126789]))\d{8}$/;
    if (mobile_reg.test(mobile_num) == false) {
      $(".mobile_re_msg").text("请填写正确的手机号码").css("color","#da4f49");
      flag = false;
    } else {
      $.ajax({
        type : 'POST',
        async : false,
        data : {"mobile_num" : mobile_num},
        dataType : 'json',
        url : data.base_url+'home/checkup_mobile',
        success : function (res) {
          if (res.status == 0) {
            $(".mobile_re_msg").text("您的手机号未通过系统验证").css("color","#da4f49");
            flag = false;
          }
        }
      });
    }
    return flag;
  }

  function slug_send_mobile () {
    $(".send-button").click(function () {
      var mobile_num = $("#mobile_num").val().trim();
      if (mobile_checker(mobile_num) == false) {
        return false;
      }

      var mobile_url = data.base_url + "home/slug_send_mobile";
      $(".send-button").attr("disabled", "true");  // disable button 点击后防刷
      $(".mobile_re_msg").text("发送中...").css("color","#5bb75b");;
      $.ajax({
        type : 'post',
        data : {'mobile_num' : mobile_num, 'slug_val' : slug_val, 'slug_file_name' : slug_file_name},
        dataType : 'json',
        url : mobile_url,
        success : function (res) {
          if (res.status) {
            $(".mobile_re_msg").text(res.msg).css("color","#5bb75b");
          } else {
            $(".mobile_re_msg").text(res.msg).css("color","#da4f49");
          }
        }
      });
    });
  }

});
