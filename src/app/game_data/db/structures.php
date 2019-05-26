<?php
namespace app\game_data\db;

use bundle\sql\SqliteClient;
use gui;

class structures 
{
    private $structures;

    public function __construct(){
        $sql = new SqliteClient;
        $sql->file = 'db/structures.db3';
        $sql->open();
        $result = $sql->query('SELECT * FROM structures INNER JOIN `settings` settings ON settings.structure_id = structures.id');
        $stop = 0;
        foreach ($result as $record) {
            $data = $record->toArray();
            $structures[$data['code']]['name'] = $data['name']; 
            $structures[$data['code']]['code'] = $data['code']; 
            if($data['code_setting'] != 'picture' and $data['code_setting'] != 'icon' and $data['code_setting'] != 'product_unit')
                $structures[$data['code']][$data['code_setting']] = $data['value']; 
            elseif($data['code_setting'] == 'picture' or $data['code_setting'] == 'icon') {
                $structures[$data['code']][$data['code_setting']] = new UXImage($data['value']); 
            }
            elseif($data['code_setting'] == 'product_unit')
                $structures[$data['code']][$data['code_setting']][] = $data['value']; 
        }
        //var_dump($structures);
        $this->structures = $structures;
    }
    
    public function get($code){
        return $this->structures[$code];
    }
    
    public function get_all(){
        foreach ($this->structures as $structure){
            $data[] = $structure;
        }
        return $data;
    }
}