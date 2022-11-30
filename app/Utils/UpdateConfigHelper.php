<?php

namespace App\Utils;

use Illuminate\Support\Facades\Artisan;

class UpdateConfigHelper
{
    public static function update($config_name, $key, $value, $implodeCharacter = '.')
    {
        config([$config_name . $implodeCharacter . $key => $value]);
        $fp = fopen(base_path() . '/config/' . $config_name . '.php', 'w');
        fwrite($fp, '<?php return ' . var_export(config($config_name), true) . ';');
        fclose($fp);

        self::clearCache();
    }


    public static function clearCache()
    {
        Artisan::call('config:clear');
    }
}
