<?php

class Account extends CI_Model {
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function login($user_name, $user_pwd)
  {
    $query = $this->db->get_where('user', array('user_name' => $user_name));
    if ($query->num_rows() > 0) {
      $query_row = $query->row_array();
      if ($query_row['user_pwd'] === $user_pwd) {
        return true;
      }
    }
  }

  function register($userInfo)
  {
    $this->db->insert('user', $userInfo);
    return true;
  }

  function has_user_name($username)
  {
    return $query = $this->db->get_where('user', array('user_name' => $username));
  }
}

?>
