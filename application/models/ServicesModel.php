<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ServicesModel extends CI_Model
    {
        private $table = 'services';
        public $id;
        public $name;
        public $price;
        public $type;
        public $created_at;
        public $rule = [
            [
            'field' => 'name',
            'label' => 'name',
            'rules' => 'required'
            ],
        ];
public function Rules() { return $this->rule; }

public function getAll() { return
    $this->db->get('data_mahasiswa')->result();
}

public function store($request) {
    $this->name = $request->name;
    $this->price = $request->price;
    $this->type = $request->type;
    $date = new DateTime();
    $this->created_at = date("Y-m-d").' '.date('H:i:s');

    if($this->db->insert($this->table, $this)){
        return ['msg'=>'Berhasil','error'=>false];
    }
    return ['msg'=>'Gagal','error'=>true];
}

public function update($request,$id) {
    $updateData = ['price' => $request->price, 'name' =>$request->name, 'type'=>$request->type];
    if($this->db->where('id',$id)->update($this->table, $updateData)){
        return ['msg'=>'Berhasil','error'=>false];
    }
    return ['msg'=>'Gagal','error'=>true];
}
    public function destroy($id){
       if (empty($this->db->select('*')
       ->where(array('id' => $id))
       ->get ($this->table)->row())) return ['msg'=>'Id tidak ditemukan','error'=>true];

        if($this->db->delete($this->table, array('id' => $id))){
            return ['msg'=>'Berhasil','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
}
?>