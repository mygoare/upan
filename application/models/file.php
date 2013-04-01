<?php

class File extends CI_model {
  function __construct(){
    parent::__construct();
    $this->load->database();
  }

  function insert_file($fileInfo){
    $this->db->insert('file', $fileInfo);
    return true;
  }

  function create_slug($file_url)
  {
    $query = $this->db->get_where('file', array('file_url' => $file_url));
    $query_row = $query->row_array();
    $id = $query_row['id'];

    $dic = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
    $slug = array(0,0,0);

    $i = 0;
    do {
      $a = $id%62;
      $slug[$i] = $dic[$a];
      $i++;
      $id = floor($id/62);
    } while ($id > 0);

    $dic_rand_key = array_rand($dic);
    array_push($slug, $dic[$dic_rand_key]);

    $slug = implode("", $slug);
    $this->db->update('file',array('slug' => $slug), array('file_url' => $file_url));

    return $slug;

  }

  function get_file($slug)
  {
    $query = $this->db->get_where('file', array('slug' => $slug));
    if ($query->num_rows() == 1) {
      $query_row = $query->row_array();
      $file_url = base_url().'home/download_file?id='.$query_row['id'].'&file_name='.$query_row['file_name'];
      return $file_url;
    } else {
      return false;
    }
  }

  function get_file_info($id)
  {
    $query = $this->db->get_where('file', array('id' => $id));
    if ($query->num_rows() == 1) {
      $query_row = $query->row_array();
      $file_something = array("file_name" => $query_row['file_name'], "file_size" => $query_row['file_size'], "file_location" => "./assets/upload_files/".$query_row['file_url'], "file_type" => $query_row['file_type']);
      return $file_something ;
    } else {
      return false;
    }
  }

}
