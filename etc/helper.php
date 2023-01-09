<?php

if(!function_exists("_lang")) {

    function _lang($key,$val = null) {

        if(!blank($val)) {
            $key .= ".".$val;
        }

        return trans($key);
    }

}
// example
// _lang('attendance.status', 1);

if(!function_exists("_permission")){
    function _permission($permission = null){
        if(!blank($permission)){
            return session()->get('division').' '.session()->get('center').' '.$permission;
        }
        return $permission;
    }
}

if(!function_exists("d")){
    function d($data = null){
        if(!blank($data)){
            echo "<pre>";
                print_r($data);
            echo "</pre>";
        }
    }
}
