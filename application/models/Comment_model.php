<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Comment_model extends CI_Model{
 
    function get_comment(){
        $query = $this->db->from('comment')->order_by('id', 'DESC')->get();
        return $query;
    }
 
    function insert($comment){
        $data = array(
            'text' => $comment
        );
        $this->db->insert('comment', $data);
    }
}