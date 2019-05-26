<?php

namespace app\forms;

use Exception;
use std, gui, framework, app;
use app\game_data\game;

class viewGame extends AbstractForm
{
    var $player = 1;
    var $map;
    var $player_data;
    var $game_data;
    var $select;
    var $ux;
    
    var $eco_ux;
    var $creator;

    /**
     * @event show
     */
    function doShow(UXWindowEvent $e = null)
    {
        $this->game_data = new game();
        $this->creator = $this->game_data->uxcreator;
    
        $sector_names = file('db/sectors.txt');
    
        $this->ux['box_bg'] = new UXImage('UI/box_bg.png');
        $this->ux['player_sector'][0] = new UXImage('UI/0.png');
        $this->ux['player_sector'][1] = new UXImage('UI/1.png');
        $this->ux['player_sector'][2] = new UXImage('UI/2.png');
        $this->ux['player_sector_b'] = new UXImage('UI/sector_b.png');
        $this->ux['player_sector_add'] = new UXImage('UI/add.png');
        $this->ux['player_sector_build'] = new UXImage('UI/build.png');
        $this->ux['player_sector_build_wait'] = new UXImage('UI/wait_build.png');
        $this->ux['line_process_color'] = new UXImage('UI/process_build.png');
        
            $player = $this->player;
            $this->listViewAlt->items->clear();
            
            $label_area = new UXHBox();
            $label_area->spacing = 5;
            $this->eco_ux['label_area_minerals'] = $label_area;
            
            $label_blue = $this->creator->label('Минералы: ', 'label label_blue');
            $label_area->add($label_blue);
            $this->eco_ux['label_minerals'] = $label_blue;
            
            $label_blue = $this->creator->label(0, 'label');
            $label_area->add($label_blue);
            $this->eco_ux['label_minerals_store'] = $label_blue;
            
            $label_blue = $this->creator->label(0, 'label label_green');
            $label_area->add($label_blue);
            $this->eco_ux['label_minerals_incum'] = $label_blue;
            
            $this->listViewAlt->items->add($label_area);
            
            $label_area = new UXHBox();
            $label_area->spacing = 5;
            $this->eco_ux['label_area_energy'] = $label_area;
            $label_blue = new UXLabel();
            $label_blue->autosize = true;
            $label_blue->text = "Энергия:";
            $label_blue->classesString = 'label label_yellow';
            $label_area->add($label_blue);
            $this->eco_ux['label_energy'] = $label_blue;
            $label_blue = new UXLabel();
            $label_blue->autosize = true;
            $label_blue->text = 0;
            $label_blue->classesString = 'label';
            $label_area->add($label_blue);
            $this->eco_ux['label_energy_store'] = $label_blue;
            $label_blue = new UXLabel();
            $label_blue->autosize = true;
            $label_blue->text = 0;
            $label_blue->classesString = 'label label_green';
            $label_area->add($label_blue);
            $this->eco_ux['label_energy_incum'] = $label_blue;
            
            $this->listViewAlt->items->add($label_area);
            
            //$this->listViewAlt->items->add('Минералы: ' . $this->player_data[$player]['minerals'] . " (" . $this->player_data[$player]['minerals_inc'] . ")");
            
            //$this->listViewAlt->items->add('Энергия: ' . $this->player_data[$player]['energy'] . " (" . $this->player_data[$player]['energy_inc'] . ")");
            $this->listViewAlt->items->add('Армия: ' . $this->player_data[$player]['army'] . " (" . $this->player_data[$player]['supply'] . ")");

        for ($i = 0; $i < 15; $i++) {
            for ($j = 0; $j < 15; $j++) {
                $UX = new UXCanvas();
                $UX->data('name', $sector_names[$i*15+$j]);
                $UX->size = [50, 50];
                $UX->position = [$j * 50, $i * 50];
                $UX->gc()->drawImage($this->ux['box_bg'], 0, 0);
                $UX->gc()->drawImage($this->ux['player_sector'][0], 0, 0);
                $UX->gc()->font = UXFont::of('Arial',14);
                //$UX->gc()->font = UXFont::
                //$UX->gc()->font = "6px Arial";
                $UX->strokeColor = '#808080';
                $UX->fillColor = '#cccccc';
                $UX->data('x', $j);
                $UX->data('y', $i);
                $UX->gc()->fillText($UX->data('x').":".$UX->data('y'),3,14);
                $UX->data('mineral', 0.5);
                $UX->data('energy', 0.5);
                $UX->data('supply', 5);
                $UX->data('supply_army', 10);
                $UX->data('size', 8);
                $UX->data('player', 0);
                $UX->data('build_speed', 1);
                $UX->data('structures', array());
                $UX->on('mouseEnter', function ($e) {
                    //$this->select = [$e->target->data('x'), $e->target->data('y')];
                    //$this->click_zone();
                });
                $UX->on('click', function ($e) {
                    $this->game_data->create_panel($e, $this);
                });

                /*for ($z = 0; $z < $UX->data('size'); $z++) {
                    if ($z >= 12) {
                        $UX->gc()->drawImage($this->ux['player_sector_b'], $z*8 + 6 - 96, 40);
                    } elseif ($z >= 8) {
                        $UX->gc()->drawImage($this->ux['player_sector_b'], $z*8 + 6 - 64, 30);
                    } elseif ($z >= 4) {
                        $UX->gc()->drawImage($this->ux['player_sector_b'], $z*8 + 6 - 32, 20);
                    } else {
                        $UX->gc()->drawImage($this->ux['player_sector_b'], $z*8 + 6, 10);
                    }
                }*/

                $this->map[$j][$i] = $UX;
                $this->container->content->add($UX);
            }
        }

        $dt['minerals'] = 99999;
        $dt['energy'] = 99999;
        $dt['army'] = 0;

        $this->player_data[1] = $dt;
        $this->player_data[2] = $dt;

        $this->set_color(14, 0, 1);
        $this->set_color(0, 14, 2);

        Timer::setInterval(function () {
            if ($this->progressBar->progress == 100) {
                $this->game_application();
                $this->progressBar->progress = 0;
            } else {
                $this->progressBar->progress += 10;
            }
        }, 200);

        $this->game_application();
    }

    function click_zone()
    {
        /*$target = $this->map[$this->select[0]][$this->select[1]];
        $player = $target->data('player');
        $build_speed = $target->data('build_speed');;
        $minerals = $target->data('mineral');
        $energy = $target->data('energy');
        $supply = $target->data('supply');
        $supply_army = $target->data('supply_army');
        $sector_build_units = false;
        $struc_count = 0;
        for ($k = 0; $k < count($target->data('structures')); $k++) {
            if ($target->data('structures')[$k]['build'] <= 0) {
                $build_speed += $target->data('structures')[$k]['bust_build_speed'];
                $minerals += $target->data('structures')[$k]['incum_minerals'];
                $energy += $target->data('structures')[$k]['incum_energy'];
                $minerals -= $target->data('structures')[$k]['minerals_steep_sale'];
                $energy -= $target->data('structures')[$k]['energy_steep_sale'];
                $supply += $target->data('structures')[$k]['bust_supply'];
                $supply_army += $target->data('structures')[$k]['bust_supply_army'];
            }

            if (is_array($target->data('structures')[$k]['unit_product'])) {
                $sector_build_units = true;
            }
            $struc_count++;
        }

        $minerals += $target->data('mineral');
        $energy += $target->data('energy');
        $this->listView->items->clear();
        $this->listView->items->add("X:Y - " . $target->data('x') . ":" . $target->data('y'));
        $this->listView->items->add("Минералы: " . $minerals);
        $this->listView->items->add("Энергия: " . $energy);
        $this->listView->items->add("Припасы: " . $supply);
        $this->listView->items->add("Вместимость армии: " . $supply_army);
        $this->listView->items->add("Размер: " . $target->data('size') . " ($struc_count)");
        $this->listView->items->add("Скорость строительства: " . $build_speed);
        for ($i = 0; $i < count($target->data('structures')); $i++) {
            $s_name = $target->data('structures')[$i]['name'];
            if ($target->data('structures')[$i]['build'] > 0)
                $s_name .= ' (строится ' . $target->data('structures')[$i]['build'] . ')';
            $this->listView->items->add($s_name);
        }*/
    }

    function game_application()
    {
        $this->player_data[$this->player]['minerals_inc'] = 0;
        $this->player_data[$this->player]['energy_inc'] = 0;
        $this->player_data[$this->player]['supply'] = 0;
        for ($i = 0; $i < 15; $i++) {
            for ($j = 0; $j < 15; $j++) {
                $build_get = false;
                $UX = $this->map[$j][$i];
                $player = $UX->data('player');
                $minerals = $UX->data('mineral');
                $energy = $UX->data('energy');
                $build_speed = $UX->data('build_speed');
                $supply = $UX->data('supply');
                for ($k = 0; $k < count($UX->data('structures')); $k++) {
                    if ($UX->data('structures')[$k]['build'] <= 0 and $UX->data('structures')[$k]['code'] == 'factory') {
                        $build_speed += $UX->data('structures')[$k]['bust_build_speed'];
                    }
                }

                for ($k = 0; $k < count($UX->data('structures')); $k++) {
                    if ($UX->data('structures')[$k]['build'] > 0 and $build_get == false) {
                        $UX->data('structures')[$k]['build'] -= $build_speed;
                        $build_get = true;
                    } elseif ($UX->data('structures')[$k]['build'] <= 0) {
                        $energy += $UX->data('structures')[$k]['incum_energy'];
                        $minerals += $UX->data('structures')[$k]['incum_minerals'];
                        $energy -= $UX->data('structures')[$k]['energy_steep_sale'];
                        $minerals -= $UX->data('structures')[$k]['minerals_steep_sale'];
                        $supply += $UX->data('structures')[$k]['supply'];
                    }
                }

                $this->player_data[$player]['minerals'] += $minerals;
                $this->player_data[$player]['energy'] += $energy;
                $this->player_data[$player]['minerals_inc'] += $minerals;
                $this->player_data[$player]['energy_inc'] += $energy;
                $this->player_data[$player]['supply'] += $supply;
            }
        }
        $this->render_eco_info();
    }

    function render_eco_info()
    {
        uiLater(function () {
            $player = $this->player;
            
            $this->eco_ux['label_minerals_store']->text = $this->player_data[$player]['minerals'];
            $this->eco_ux['label_minerals_incum']->text = $this->player_data[$player]['minerals_inc'];
            
            if($this->player_data[$player]['minerals_inc'] > 0)
                $this->eco_ux['label_minerals_incum']->classesString = 'label label_green';
            else 
                $this->eco_ux['label_minerals_incum']->classesString = 'label label_red';
                
            $this->eco_ux['label_energy_store']->text = $this->player_data[$player]['energy'];
            $this->eco_ux['label_energy_incum']->text = $this->player_data[$player]['energy_inc'];
            
            if($this->player_data[$player]['energy_inc'] > 0)
                $this->eco_ux['label_energy_incum']->classesString = 'label label_green';
            else 
                $this->eco_ux['label_energy_incum']->classesString = 'label label_red';
            
            //$this->listViewAlt->items->add('Минералы: ' . $this->player_data[$player]['minerals'] . " (" . $this->player_data[$player]['minerals_inc'] . ")");
            //$this->listViewAlt->items->add($label_area);
            //$this->listViewAlt->items->add('Энергия: ' . $this->player_data[$player]['energy'] . " (" . $this->player_data[$player]['energy_inc'] . ")");
            //$this->listViewAlt->items->add('Армия: ' . $this->player_data[$player]['army'] . " (" . $this->player_data[$player]['supply'] . ")");
            //$this->click_zone();
        });
    }

    /**
     * @event construct
     */
    function doConstruct(UXEvent $e = null)
    {
        //$this->vbox->height = $this->height;
        $this->container->width = 15 * 50;
        $this->container->height = 15 * 50;
        $this->container->x = ($this->width / 2) - ($this->container->width / 2);
        $this->container->y = ($this->height / 2) - ($this->container->height / 2);
    }


    function set_color($x, $y, $player)
    {
        $UX = $this->map[$x][$y];
        $UX->data('player', $player);
        $UX->gc()->drawImage($this->ux['box_bg'], 0, 0);
        if ($player == 0) {
            $UX->gc()->drawImage($this->ux['player_sector'][0], 0, 0);
        } elseif ($player == 1) {
            $UX->gc()->drawImage($this->ux['player_sector'][1], 0, 0);
        } elseif ($player == 2) {
            $UX->gc()->drawImage($this->ux['player_sector'][2], 0, 0);
        } elseif ($player == 3) {
            $UX->gc()->drawImage($this->ux['player_sector'][3], 0, 0);
        } elseif ($player == 4) {
            $UX->gc()->drawImage($this->ux['player_sector'][4], 0, 0);
        }
        $UX->gc()->font = UXFont::of('Arial',14);
        $UX->gc()->fillText($UX->data('x').":".$UX->data('y'),3,14);
    }
}
