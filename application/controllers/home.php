<?php

class Home extends CI_controller {
  function index(){
    $this->load->view("home/index");
  }

  function about(){
    $this->load->view("home/about");
  }

  function upload_file(){
    $this->load->model("file");

    if($_FILES['file']){
      if($_FILES['file']['error'] > 0){
        echo json_encode(array('code' => $_FILES['file']['error'], 'msg' => 'upload failed, error > 0'));
      }else{
        $file_name = $_FILES['file']['name'];
        $file_tmp_name = $_FILES['file']['tmp_name'];

        if($file_name && $_FILES['file']['tmp_name']){
          $upload = move_uploaded_file($file_tmp_name, "./assets/upload_files/".md5($file_name.time()));
          if($upload){
            echo json_encode(array('msg' => $file_name));
          }else{
            echo json_encode(array('msg' => 'move uploaded file failed'));
          }
        }else{
          echo json_encode(array('msg' => 'info get failed'));
        }
      }
    }else{
      echo json_encode(array('msg' => 'wrong'));
    }
  }

  function get_file(){
  }

}
