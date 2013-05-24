<?php

class User extends CI_controller
{
  function handbook()
  {
    $this->load->view("templates/header");
    $this->load->view('user/handbook');
    $this->load->view("templates/footer");
  }

  function index()
  {
    if (!$this->session->userdata('logged_in')) {
      redirect('/user/login');
    }
    $this->load->view("templates/header");
    $this->load->view('user/index');
    $this->load->view("templates/footer");
  }

  function login()
  {
    $this->load->view("templates/header");
    $this->load->view('user/login');
    $this->load->view("templates/footer");
  }

  function login_in()
  {
    $this->load->model("account");

    $user_name = $this->input->post("username");
    $user_pwd = $this->input->post("pwd");
    //$re_code = $_POST['re_code'];

    if (empty($user_name)) {
      echo json_encode(array('status' => 0, 'user_msg' => "用户名不得为空", 'pwd_msg' =>''));
      return false;
    } else if (empty($user_pwd)) {
      echo json_encode(array('status' => 0, 'user_msg' => "", 'pwd_msg' =>"密码不得为空"));
      return false;
    } else {
      if ($this->account->has_user_name($user_name)->num_rows) {
        echo json_encode(array('status' => 0, 'user_msg' => "用户名已占用", 'pwd_msg' => ''));
        return false;
      }
    }
    $user_pwd = md5($user_pwd);

    $userInfo = array(
      'user_name' => $user_name,
      'user_pwd' => $user_pwd
    );

    if ($this->account->login_in($userInfo)) {
      $newdata = array(
        'username' => $user_name,
        'logged_in'=> true
      );
      $this->session->set_userdata($newdata);
      echo json_encode(array('status' => 1));
    }
  }

  function check_username()
  {
    $this->load->model("account");

    $user_name = $_GET['username'];
    if ($this->account->has_user_name($user_name)->num_rows) {
      echo json_encode(array('status' => 0, 'msg' => "用户名已占用"));
    } else {
      echo json_encode(array('status' => 1));
    }
  }
}

