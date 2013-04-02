<?php

class Mobile extends CI_model {
  function __construct(){
    parent::__construct();
    $this->load->database();
  }

  function checkup_mobile($mobile_num)
  {
    $query = $this->db->get_where('mobile', array('mobile_num' => $mobile_num));
    if ($query->num_rows()) {
      return true;
    } else {
      return false;
    }
  }
}
