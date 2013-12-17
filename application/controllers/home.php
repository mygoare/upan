<?php

class Home extends CI_controller {
  function index(){
    $this->load->view("templates/header");
    $this->load->view("home/index");
    $this->load->view("templates/footer");
  }

  function about(){
    $this->load->view("templates/header");
    $this->load->view("home/about");
    $this->load->view("templates/footer");
  }

  function upload_file(){
    $this->load->model("file");

    if($_FILES['file']){
      if($_FILES['file']['error'] > 0){
        echo json_encode(array('code' => $_FILES['file']['error'], 'msg' => 'upload failed, error > 0'));
      }else{
        $file_name = $_FILES['file']['name'];
        $file_tmp_name = $_FILES['file']['tmp_name'];
        $file_type = $_FILES['file']['type'];
        $file_size = $_FILES['file']['size'];

        if ($file_size > 5*1024*1024) {
          echo json_encode(array('status' => 0, 'msg' => '文件大小请不要超过5M'));
        } else {
          if($file_name && $_FILES['file']['tmp_name']){
            $file_url = md5($file_name.time());
            $fileInfo = array(
              "file_name"   => $file_name,
              "file_size"   => $file_size,
              "file_type"   => $file_type,
              "file_url"    => $file_url,
              "upload_time" => date("Y-m-d H:i:s")
            );

            $upload = move_uploaded_file($file_tmp_name, "./assets/upload_files/".$file_url);
            if($upload){
              if ($this->file->insert_file($fileInfo)) {
                $slug = $this->file->create_slug($file_url);
                echo json_encode(array('status' => 1,  'msg' => $file_name, 'slug' => $slug, 'file_name' => $file_name));
              }
            }else{
              echo json_encode(array('status'=> 0, 'msg' => 'move uploaded file failed'));
            }
          }else{
            echo json_encode(array('status'=> 0, 'msg' => 'info get failed'));
          }
        }

      }
    }else{
      echo json_encode(array('status'=> 0, 'msg' => 'wrong'));
    }
  }

  function get_file(){
    $this->load->model("file");

    $file_code = $this->input->post("input_code");
    $file_url = $this->file->get_file($file_code);
    if ($file_url) {
      echo json_encode(array('status' => 1, 'msg' => '找到文件了', 'file_url' => $file_url));
    } else {
      echo json_encode(array('status' => 0,  'msg' => '提取码错误'));
    }
  }

  function download_file()
  {
    $this->load->model('file');

    $file_id = $_GET['id'];
    $file_name = $_GET['file_name'];

    if ($file_id && $file_name) {
      $file_something = $this->file->get_file_info($file_id);
      if (!$file_something) {
        show_404();
      }
      $file_location = $file_something['file_location'];
      $file_size = $file_something['file_size'];
      $file_type = $file_something['file_type'];

      if ($file_name != $file_something['file_name']) {
        show_404();
      }

      if (! file_exists($file_location)) {
        echo "文件找不到了";
        exit();
      } else {
        $file = fopen($file_location, 'r');
        Header("Content-type:".$file_type);
        Header("Accept-Ranges:bytes");
        Header("Accept-Length:".$file_size);
        Header("Content-Disposition: attachment; filename=".$file_name);

        echo fread($file, $file_size);
        fclose($file);
        exit();
      }
    } else {
      show_404();
    }
  }

  function create_qr()
  {
    $input_code = $this->input->post("slug");
    $file_name = $this->input->post("file_name");
    $qr_msg = "提取码：".$input_code."，文件名：".$file_name;
    $qr_url = "https://chart.googleapis.com/chart?cht=qr&chs=150x150&chl=".$qr_msg;
    echo json_encode(array('status' => 1, 'msg' => $qr_url));
  }

  // mail模块
  function send_mail($mail_file, $send_to, $params, $subject)
  {
    $mail_url = "http://mail.upan.us/".$mail_file."?send_to=".$send_to.$params."&subject=".$subject;
    $mail_re = file_get_contents($mail_url);
    return $mail_re;
  }

  function checkup_email()
  {
    $this->load->model('mail');

    $email_addr = $this->input->post("email_addr");
    if($this->mail->checkup_email($email_addr)){
      echo json_encode(array("status" => 1, "msg" => "ok"));
    } else {
      echo json_encode(array("status" => 0, "msg" => "need send checkup mail"));
    }
  }

  function send_checkup_email()
  {
    $send_to = $this->input->post("email_addr");
    $auth_code = substr(md5($send_to), 1, 6);
    $auth_code_pair = substr(md5($auth_code), 6, 8);
    $checkup_mail_re = $this->send_mail("checkup_mail.php", $send_to, "&auth_code=".$auth_code, "云U盘邮箱验证");
    if ($checkup_mail_re == 1) {
      echo json_encode(array("status" => 1, "auth" => $auth_code_pair, "msg" => "您的邮箱没有通过系统验证。已向您的邮箱发送验证邮件，请填入邮箱中的验证码"));
    } else {
      echo json_encode(array("status" => 0, "msg" => "您的邮箱没有通过系统验证。验证邮件发送失败"));
    }
  }

  function verify_email()
  {
    $this->load->model('mail');

    $auth_code = $this->input->post("auth_code");
    $auth_code_pair = $this->input->post("auth_pair");
    $email_addr = $this->input->post("email_addr");
    $slug_val = $this->input->post("slug_val");
    $slug_file_name = $this->input->post("slug_file_name");

    if ($auth_code_pair == substr(md5($auth_code), 6, 8)) {
      $mail_re = $this->send_mail("slug_mail.php", $email_addr, "&slug_val=".$slug_val."&file_name=".$slug_file_name, "您的云U盘文件提取码");
      $add_mail = $this->mail->add_mail(array('email_addr' => $email_addr, 'confirm_time' => date("Y-m-d H:i:s")));
      if ($mail_re == 1 && $add_mail == true) {
        echo json_encode(array("status" => 1, "msg" => "验证通过，提取码已发送到您的邮箱"));
      } else {
        echo json_encode(array("status" => 0, "msg" => "邮件发送失败或邮件数据插入失败"));
      }
    } else {
      echo json_encode(array("status" => 0, "msg" => "验证失败"));
    }
  }

  function send_slug_mail()
  {
    $email_addr = $this->input->post("email_addr");
    $slug_val = $this->input->post("slug_val");
    $slug_file_name = $this->input->post("slug_file_name");
    $mail_re = $this->send_mail("slug_mail.php", $email_addr, "&slug_val=".$slug_val."&file_name=".$slug_file_name, "您的云U盘文件提取码");
    //return $mail_re;
    if ($mail_re == 1) {
      echo json_encode(array("status" => 1, "msg" => "邮件已发送至".$email_addr."，请注意查收"));
    } else {
      echo json_encode(array("status" => 0, "msg" => "邮件发送失败"));
    }
  }

  // 短信模块
  function checkup_mobile()
  {
    $this->load->model('mobile');

    $mobile_num = $this->input->post("mobile_num");
    if($this->mobile->checkup_mobile($mobile_num)){
      echo json_encode(array("status" => 1, "msg" => "ok"));
    } else {
      echo json_encode(array("status" => 0, "msg" => "not valid"));
    }
  }

  function slug_send_mobile()
  {
    $mobile_num = $this->input->post("mobile_num");
    $slug_val = $this->input->post("slug_val");
    $slug_file_name = $this->input->post("slug_file_name");
    $msg_content = "您在【云U盘】上传的文件名为：".$slug_file_name."，提取码为：".$slug_val;

    $this->send_msg($mobile_num, $msg_content);
  }

  function send_msg($mobile_num, $msg_content)
  {
    $tui3_url = "http://tui3.com/api/send/?k=".$tui3_api_key."&r=json&p=2id&t=".$mobile_num."&c=".$msg_content;
    $msg_re_content = json_decode(file_get_contents($tui3_url));
    if ($msg_re_content->{'err_code'} == 0) {
      echo json_encode(array('status' => 1, 'msg' => "短信发送成功"));
    } else {
      echo json_encode(array('status' => 0, 'msg' => "短信发送失败或短信数量已用完"));
    }
  }

  function verify_mobile()
  {
    $this->load->model('mobile');

    $do = $_GET['do'];
    $mobile_num = $_GET['mobile'];
    $content = $_GET['content'];

    $is_exists_mobile = $this->mobile->checkup_mobile($mobile_num);
    if ($do == "sms" && !$is_exists_mobile && $content === "201314") {
      $add_mobile = $this->mobile->add_mobile(array('mobile_num' => $mobile_num, 'confirm_time' => date("Y-m-d H:i:s")));
      if ($add_mobile == true) {
        $msg_content = "您在【云U盘】申请的手机号".$mobile_num."已通过验证，您可以正常使用【云U盘】的短信服务";
        $this->send_msg($mobile_num, $msg_content);
      } else {
        echo json_encode(array("status" => 0, "msg" => "数据库错误"));
      }
    } else {
      echo json_encode(array("status" => 0, "msg" => "手机号已存在或接收码错误"));
    }
  }

}
