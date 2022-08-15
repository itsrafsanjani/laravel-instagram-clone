<?php

if (! function_exists('app_setting')) {
    function app_setting($key): string
    {
        $setting = DB::table('app_settings')->where('key', $key)->get();
        if (! $setting->isEmpty()) {
            return $setting[0]->value;
        }

        return '';
    }
}
