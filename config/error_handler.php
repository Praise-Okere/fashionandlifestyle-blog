<?php
// config/error_handler.php

/**
 * Custom error handler to prevent sensitive data leakage
 * and provide clean error logging.
 */

// Show errors during development. Turn these off in production!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function customErrorHandler($errno, $errstr, $errfile, $errline) {
    $log_message = date('Y-m-d H:i:s') . " - Error: [$errno] $errstr in $errfile on line $errline" . PHP_EOL;
    // Log to a file (ensure logs directory exists or use system temp dir)
    error_log($log_message, 3, __DIR__ . '/../app_errors.log');
    
    // For user-facing errors, we might want to display a generic message in production
    // echo "An error occurred. Please try again later.";
    
    // Don't execute PHP internal error handler
    return true;
}

// Set the custom error handler
set_error_handler("customErrorHandler");

// Set a custom exception handler as well
function customExceptionHandler($exception) {
    $log_message = date('Y-m-d H:i:s') . " - Exception: " . $exception->getMessage() . 
                   " in " . $exception->getFile() . " on line " . $exception->getLine() . PHP_EOL;
    error_log($log_message, 3, __DIR__ . '/../app_errors.log');
    
    echo "An unexpected error occurred. Please try again later.";
}
set_exception_handler('customExceptionHandler');
