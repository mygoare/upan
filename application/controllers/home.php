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

}
