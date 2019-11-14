<?php
use Restserver \Libraries\REST_Controller ;
Class Services extends REST_Controller{
    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, ContentLength, Accept-Encoding");
        parent::__construct();
        $this->load->model('ServicesModel');
        $this->load->library('form_validation');
    }
    public function index_get(){
        return $this->returnData($this->db->get('services')->result(), false);
    }
    public function index_post($id = null){
        $validation = $this->form_validation;
        $rule = $this->ServicesModel->rules();
        if($id == null){
            array_push($rule,[
                'field' => 'price',
                'label' => 'price',
                'rules' => 'required'
            ],
            [
            'field' => 'type',
            'label' => 'type',
            'rules' => 'required'
            ]
        );
    }
    else{
        array_push($rule,
            [
                'field' => 'price',
                'label' => 'price',
                'rules' => 'required'
            ],
            [
            'field' => 'type',
            'label' => 'type',
            'rules' => 'required'
            ]
        );
    }
    $validation->set_rules($rule);
    if (!$validation->run()) {
        return $this->returnData($this->form_validation
        ->error_array(), true);
    }
    $services = new ServicesData();
    $services->name = $this->post('name');
    $services->price = $this->post('price');
    $services->type = $this->post('type');
    $services->created_at = $this->post('created_at');
    if($id == null){
        $response = $this->ServicesModel->store($services);
    }else{
        $response = $this->ServicesModel->update($services,$id);
        }
        return $this->returnData($response['msg'], $response['error']);
    }
    public function index_delete($id = null){
        if($id == null){
            return $this->returnData('Parameter Id Tidak Ditemukan', true);
        }
        $response = $this->ServicesModel->destroy($id);
        return $this->returnData($response['msg'], $response['error']);
    }
    public function returnData($msg,$error){
        $response['error']=$error;
        $response['message']=$msg;
        return $this->response($response);
        }
    }
    Class ServicesData{
        public $name;
        public $price;
        public $type;
        public $created_at;
}
?>