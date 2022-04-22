<?php
use Illuminate\Support\Facades\Log;

if (!function_exists('log_info')) {
    function log_info($log, $class = __CLASS__, $line = __LINE__)
    {
        if (is_string($log)) {
            Log::info(substr(strrchr($class, '\\'), 1) . '[' . $line . ']: ' . $log);
        } else {
            Log::info(print_r($log, true));
        }
    }
}


if (!function_exists('app_path')) {
    /**
     * Get the path to the application folder.
     *
     * @param  string $path
     * @return string
     */
    function app_path($path = '')
    {
        return app('path') . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
