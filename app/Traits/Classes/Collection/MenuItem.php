<?php

namespace App\Traits\Classes\Collection;
use Illuminate\Support\Collection;

class MenuItem extends Collection{
    public $text;
    public $href;
    public $icon;
    public $show;
    public $id_menu;
    public $menu_active;
    public $childre;

    public function __construct($text, $href, $icon, $show, $id_menu, $menu_active, $children)
    {
        $this->text = $text;
        $this->href = $href;
        $this->icon = $icon;
        $this->show = $show;
        $this->id_menu = $id_menu;
        $this->menu_active = $menu_active;
        $this->children = $children;
    }

}