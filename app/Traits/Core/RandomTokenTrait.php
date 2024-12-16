<?php

namespace App\Traits\Core;

use App\Models\Core\CoreUser;

trait RandomTokenTrait
{
    public function getNewRememberToken($length = 8, $field, $add_dashes = false, $available_sets = 'luds')
    {
        $sets = array();
        if (strpos($available_sets, 'l') !== false) {
            $sets[] = 'abcdefghjkmnpqrstuvwxyz';
        }

        if (strpos($available_sets, 'u') !== false) {
            $sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
        }

        if (strpos($available_sets, 'd') !== false) {
            $sets[] = '23456789';
        }

        if (strpos($available_sets, 's') !== false) {
            $sets[] = '!?#';
        }

        $all = '';
        $token = '';

        foreach ($sets as $set) {
            $token .= $set[array_rand(str_split($set))];
            $all .= $set;
        }
        $all = str_split($all);
        for ($i = 0; $i < $length - count($sets); $i++) {
            $token .= $all[array_rand($all)];
        }
        $token = str_shuffle($token);

        if (CoreUser::where($field, $token)->first()) {
            $token = $this->getNewRememberToken($length, $field);
        }
        return $token;
    }
}
