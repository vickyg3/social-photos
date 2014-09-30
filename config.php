<?php

class Config {
    public static function get($key) {
        $filename = dirname(__FILE__) . "/config.json";
        $config = json_decode(file_get_contents($filename), true);
        return trim($config[$key]["value"]);
    }
}

?>