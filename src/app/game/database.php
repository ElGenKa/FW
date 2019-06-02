<?php
/**
 * Created by PhpStorm.
 * User: ElGen
 * Date: 01.06.2019
 * Time: 15:25
 */

namespace app\game;


use bundle\sql\SqliteClient;
use php\gui\UXImage;

class database
{
    private $structures;
    private $units;

    public function __construct(){
        $sql = new SqliteClient;
        $sql->file = 'db/structures.db3';
        $sql->open();
        $result = $sql->query('SELECT * FROM structures INNER JOIN `settings` settings ON settings.structure_id = structures.id');
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

        $this->structures = $structures;

        $sql->file = 'db/units.db3';
        $sql->open();
        $result = $sql->query('SELECT * FROM units INNER JOIN `settings` settings ON settings.unit_id = units.id');
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

    public function get_structures($code){
        return $this->structures[$code];
    }

    public function get_all_structures(){
        foreach ($this->structures as $structure){
            $data[] = $structure;
        }
        return $data;
    }
}