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
            $file_url = md5($file_name.time())."-".$file_name;
            $fileInfo = array(
              "file_name"   => $file_name,
              "file_url"    => $file_url,
              "upload_time" => date("Y-m-d H:i:s")
            );

            $upload = move_uploaded_file($file_tmp_name, "./assets/upload_files/".$file_url);
            if($upload){
              if ($this->file->insert_file($fileInfo)) {
                $slug = $this->file->create_slug($file_url);
                echo json_encode(array('status' => 1,  'msg' => $file_name, 'slug' => $slug));
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

}
