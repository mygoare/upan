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
    $this->load->database();
    if (!$this->session->userdata('logged_in')) {
      redirect('/user/login');
    } else {
      $user_id = $this->session->userdata('userid');
      $query = $this->db->query("SELECT * FROM file WHERE owned=$user_id ORDER BY upload_time DESC LIMIT 5");
      $data['file_uploaded'] = $query->result_array();

      $this->load->view("templates/header");
      $this->load->view('user/index', $data);
      $this->load->view("templates/footer");
    }
  }

  function login()
  {
    $this->load->view("templates/header");
    $this->load->view('user/login');
    $this->load->view("templates/footer");

  }

  function register()
  {
  }

  function signIn()
  {
    $this->load->model("account");

    $user_name = $this->input->post("username");
    $user_pwd = $this->input->post("pwd");
    //$re_code = $_POST['re_code'];

    $this->userFormCheck($user_name, $user_pwd);

    if ($user_name && $user_pwd) {
      $user_pwd = md5($user_pwd);

      if ($this->account->login($user_name, $user_pwd)) {
        $this->setSession($user_name);
        echo json_encode(array('status' => 1));
      } else {
        echo json_encode(array('status' => 0, 'msg' => '用户名或密码错误！'));
      }
    }
  }

  function userFormCheck($user_name, $user_pwd)
  {
    if (empty($user_name)) {
      echo json_encode(array('status' => 0, 'msg' => "用户名不得为空"));
      return false;
    } else if (empty($user_pwd)) {
      echo json_encode(array('status' => 0, 'msg' =>"密码不得为空"));
      return false;
    }
  }

  function signUp()
  {
    if (empty($user_name)) {
      echo json_encode(array('status' => 0, 'user_msg' => "用户名不得为空", 'pwd_msg' =>''));
      return false;
    } else if (empty($user_pwd)) {
      echo json_encode(array('status' => 0, 'user_msg' => "", 'pwd_msg' =>"密码不得为空"));
      return false;
    } else if (strlen($user_pwd) < 6) {
      echo json_encode(array('status' => 0, 'user_msg' => "", 'pwd_msg' =>"密码少于6位"));
      return false;
    } else {
      if ($this->account->has_user_name($user_name)->num_rows) {
        echo json_encode(array('status' => 0, 'user_msg' => "用户名已占用", 'pwd_msg' => ''));
        return false;
      }
    }

    if ($this->account->register($userInfo)) { // 如果注册成功
      $this->setSession($user_name);
      echo json_encode(array('status' => 1));
    }
  }

  function setSession($user_name)
  {
    $user_id = $this->getUserId($user_name);
    $newdata = array(
      'username' => $user_name,
      'userid'   => $user_id,
      'logged_in'=> true
    );
    // set session
    $this->session->set_userdata($newdata);
  }

  function getUserId($user_name)
  {
    //get user id
    $query = $this->db->get_where('user', array('user_name' => $user_name));
    $query_row = $query->row_array();
    $user_id = $query_row['id'];
    return $user_id;
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

  //后门
  function listUserUpload()
  {
    $this->load->database();
    $user_id = $_GET['userid'];

    $query = $this->db->get_where('file', array('owned' => $user_id), 5)->order_by('id', 'desc');
    if ($query->num_rows() > 0) {
      echo json_encode($query->result_array());
    }
  }
}

