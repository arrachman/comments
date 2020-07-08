<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Comment extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('Comment_model','comment_model');
    }
 
    function index(){
        $this->load->view('comment_view');
    }
 
    function get_comment(){
        $data = $this->comment_model->get_comment()->result();
        echo json_encode($data);
    }
 
    function create(){
        $comment = $this->input->post('comment',TRUE);
        $this->comment_model->insert($comment);
 
        require_once(APPPATH.'views/vendor/autoload.php');
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher\Pusher(
            '5ae581c740dcfc9c4309', //ganti dengan App_key pusher Anda
            'c201080612315d34713d', //ganti dengan App_secret pusher Anda
            '1033534', //ganti dengan App_key pusher Anda
            $options
        );
 
        $data['message'] = 'success';
        $pusher->trigger('my-channel', 'my-event', $data);
    }
 
}