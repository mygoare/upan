<?php

class Account extends CI_Model {
  function __construct()
  {
    parent::__construct();
    $this->load->database();
  }

  function login_in($userInfo)
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
