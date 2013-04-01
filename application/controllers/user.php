<?php

class User extends CI_controller
{
  function handbook()
  {
    $this->load->view("templates/header");
    $this->load->view('user/handbook');
    $this->load->view("templates/footer");
  }
}

