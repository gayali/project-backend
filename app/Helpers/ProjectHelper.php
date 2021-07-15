<?php

namespace App\Helpers;

use App\Models\Project;
use Exception;
use Illuminate\Support\Facades\Log;

class ProjectHelper
{
    public static function getPrefix($name)
    {
        $prefix=null;
        $name = preg_replace('/[0-9]+/', '', $name);
        $name = strtoupper($name);
        $name = str_replace(' ', '', $name);

        for ($i=2; $i <= strlen($name); $i++) {
            $prefixToReturn=substr($name,0,$i);
            $isPrefixExist=Project::where('prefix',$prefixToReturn)->exists();
            if(!$isPrefixExist) {
                $prefix=$prefixToReturn;
                break;
            }
        }

        if($prefix==null){
            $prefix=Project::generateRandomString($i);
        }

        return $prefix;
    }
    public static function generateRandomString($length)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
