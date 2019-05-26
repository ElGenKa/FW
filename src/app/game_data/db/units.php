<?php
namespace app\game_data\db;

use bundle\sql\SqliteClient;
use gui;

class units 
{
    private $units;
    
    public function __construct(){
        $sql = new SqliteClient;
        $sql->file = 'db/units.db3';
        $sql->open();
        $result = $sql->query('SELECT * FROM units INNER JOIN `settings` settings ON settings.unit_id = units.id');
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
        $this->units = $structures;
    }
    
    public function get($code){
        return $this->units[$code];
    }
    
    public function get_all(){
        foreach ($this->units as $unit){
            $data[] = $unit;
        }
        return $data;
    }
}