<?php

namespace app\game_data;

use std, gui, framework, app;
use app\game_data\db\units;
use app\game_data\db\structures;
use app\game_data\UXCreator;

class game
{
    private $structures;
    private $units;
    public $uxcreator;

    public function __construct()
    {
        $this->structures = new structures();
        $this->units = new units();
        $this->uxcreator = new UXCreator();
    }

    public function get_structure($code)
    {
        return $this->structures->get($code);
    }

    public function get_unit($code)
    {
        return $this->units->get($code);
    }

    public function get_structures()
    {
        return $this->structures->get_all();
    }

    public function play_build_sound(){
        return $this->play_sound('sound/start_buildi.mp3');
    }

    public function play_build_unit(){
        return $this->play_sound('sound/start_build_unit.mp3');
    }

    public function play_build_tank(){
        return $this->play_sound('sound/start_build_tank.mp3');
    }

    public function play_battle(){
        return $this->play_sound('sound/battle.mp3');
    }

    public function play_sound($f){
        $s = new MediaPlayerScript();
        $s->autoplay = true;
        $s->loop = false;
        $s->open($f);
        $s->on('doPlayerPlay', function($e){
            if($s->position == 100)
                $e->free();
        });
        return $s;
    }

    public function create_panel_units($e, $form){
        $target = $e->sender;
        //$target
    }

    public function create_panel($e, $form)
    {
        $dragging = new DraggingBehaviour();
        $target = $e->sender;
        $panel = new UXPanel();
        $panel->size = [640, 480];
        $panel->y = $form->height / 2 - 640 / 2;
        $panel->x = $form->width / 2 - 640 / 2;
        $panel->on('click', function ($e) {
            $e->sender->tofront();
        });
        $panel->classesString = 'panel_color scroll-pane';
        $panel->data('target', $target);
        $panel->borderWidth = 0;
        $panel->style = '';
        $dragging->apply($panel);
        $UX_head = new UXLabel();
        $UX_head->text = "Сектор " . $target->data('x') . ":" . $target->data('y'). " - ". $target->data('name');
        $UX_head->autosize = true;
        $panel->add($UX_head);
        $UX_head->x = 8;
        $UX_head->y = 0;

        $UX_list = new UXListView();
        $UX_list->size = [250, 640 - 32];
        $panel->add($UX_list);
        $UX_list->x = 0;
        $UX_list->y = 32;

        $UX_button_build = new UXButton();
        $UX_button_build->text = 'Производство';
        $UX_button_build->size = [100, 16];
        $panel->add($UX_button_build);
        $UX_button_build->x = 255;
        $UX_button_build->y = 16;
        $UX_button_build->on('click', function ($e) use ($target,$form) {
            $form->form('build_units')->target = $target;
            $form->form('build_units')->hide();
            $form->form('build_units')->show();
        });
        //$UX_button_build->enabled = false;

        $UX_button_build = new UXButton();
        $UX_button_build->text = 'X';
        $UX_button_build->size = [20, 20];
        $panel->add($UX_button_build);
        $UX_button_build->x = 620;
        $UX_button_build->y = 0;
        $UX_button_build->classesString = 'button';
        $UX_button_build->on('click', function ($e) use ($panel) {
            $panel->data('timer')->cancel();
            $panel->free();
        });

        for ($cb = 0; $cb < $target->data('size'); $cb++) {
            if ($cb >= 12) {
                $y = 3;
                $x = $cb - 8;
            } elseif ($cb >= 8) {
                $y = 2;
                $x = $cb - 4;
            } elseif ($cb >= 4) {
                $y = 1;
                $x = $cb - 4;
            } else {
                $y = 0;
                $x = $cb;
            }
            $UXC = new UXCanvas();
            $UXC->size = [50, 50];
            $UXC->gc()->drawImage($form->ux['player_sector_add'], 0, 0, 50, 50);
            $UXC->strokeStyle = $form->ux['line_process_color'];
            $UXC->x = 255 + $x * 50 + 5;
            $UXC->y = 46 + $y * 50 + 5;
            $UXC->on('click', function ($e) use ($panel, $form) {
                if (!$e->sender->data('build') and $form->player == $panel->data('target')->data('player')) {
                    $form->form('build_structure')->pos = [$panel->data('target')->data('x'), $panel->data('target')->data('y')];
                    $form->form('build_structure')->hide();
                    $form->form('build_structure')->show();
                }
            });
            $panel->add($UXC);
            $array_structures_build[] = $UXC;
        }
        $panel->data('structures', $array_structures_build);

        $panel->data('timer', Timer::setInterval(function (Timer $e) use ($panel, $target, $UX_list, $UX_button_build, $form) {
            uilater(function () use ($panel, $target, $UX_list, $UX_button_build, $form) {
                $build_speed = $target->data('build_speed');;
                $minerals = $target->data('mineral');
                $energy = $target->data('energy');
                $supply = $target->data('supply');
                $supply_army = $target->data('supply_army');
                $sector_build_units = false;
                $struc_count = 0;
                $one_build = false;

                for ($k = 0; $k < count($target->data('structures')); $k++) {

                    if ($k >= 12) {
                        $build_grid[3][$k - 8] = $target->data('structures')[$k];
                    } elseif ($k >= 8) {
                        $build_grid[2][$k - 4] = $target->data('structures')[$k];
                    } elseif ($k >= 4) {
                        $build_grid[1][$k - 4] = $target->data('structures')[$k];
                    } else {
                        $build_grid[0][$k] = $target->data('structures')[$k];
                    }
                    $panel->data('structures')[$k]->gc()->drawImage($target->data('structures')[$k]['icon'], 0, 0, 50, 50);
                    $panel->data('structures')[$k]->data('build', true);
                    if ($target->data('structures')[$k]['build'] <= 0) {
                        $build_speed += $target->data('structures')[$k]['bust_build_speed'];
                        $minerals += $target->data('structures')[$k]['incum_minerals'];
                        $energy += $target->data('structures')[$k]['incum_energy'];
                        $minerals -= $target->data('structures')[$k]['minerals_steep_sale'];
                        $energy -= $target->data('structures')[$k]['energy_steep_sale'];
                        $supply += $target->data('structures')[$k]['bust_supply'];
                        $supply_army += $target->data('structures')[$k]['bust_supply_army'];
                        $builds[] = $target->data('structures')[$k]['name'];
                    } else {
                        if ($one_build == false) {
                            if ($target->data('structures')[$k]['build'] > 0)
                                $proc = 100 - (($target->data('structures')[$k]['build'] / $target->data('structures')[$k]['build_max']) * 100);
                            else
                                $proc = 100;
                            $draw_proc = ($proc * 0.44);
                            $panel->data('structures')[$k]->gc()->drawImage($form->ux['player_sector_build'], 0, 0, 50, 50);
                            $panel->data('structures')[$k]->gc()->drawImage($form->ux['line_process_color'], 3, 42, $draw_proc, 4);

                            $one_build = true;
                        } else {
                            $proc = 0;
                            $panel->data('structures')[$k]->gc()->drawImage($form->ux['player_sector_build_wait'], 0, 0, 50, 50);
                        }

                        $builds[] = $target->data('structures')[$k]['name'] . " - строится (" . $target->data('structures')[$k]['build'] . ")";
                    }
                    $struc_count++;
                }

                $UX_list->items->clear();
                $UX_list->items->add("X:Y - " . $target->data('x') . ":" . $target->data('y'));
                $UX_list->items->add("Минералы: " . $minerals);
                $UX_list->items->add("Энергия: " . $energy);
                $UX_list->items->add("Припасы: " . $supply);
                $UX_list->items->add("Вместимость армии: " . $supply_army);
                $UX_list->items->add("Размер: " . $target->data('size') . " ($struc_count)");
                $UX_list->items->add("Скорость строительства: " . $build_speed);
                if (!empty($builds)) {
                    foreach ($builds as $nb) {
                        $UX_list->items->add($nb);
                    }
                }
            });
        }, 100));

        $form->add($panel);
    }
}