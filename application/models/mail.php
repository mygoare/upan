<?php

class Mail extends CI_model {
  function __construct(){
    parent::__construct();
    $this->load->database();
  }

  function checkup_email($email_addr)
  {
    $query = $this->db->get_where('email', array('email_addr' => $email_addr));
    if ($query->num_rows()) {
      return true;
    } else {
      return false;
    }
  }

  function add_mail($email)
  {
    $this->db->insert('email', $email);
    return true;
  }
}
