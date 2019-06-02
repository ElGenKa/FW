<?php
/**
 * Created by PhpStorm.
 * User: ElGen
 * Date: 02.06.2019
 * Time: 13:37
 */

namespace app\game\Entitys;


use php\gui\UXImage;

class Entity
{
    /** @var string */
    var $name;
    /** @var string */
    var $code;
    /** @var UXImage */
    var $icon;
    /** @var UXImage */
    var $picture;
    /** @var array */
    var $alldata;
}