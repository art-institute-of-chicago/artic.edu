<?php

if (!function_exists('createDefaultDetailTableFields')) {
    function createDefaultDetailTableFields($table)
    {
        $table->string('title');
        $table->string('short_copy')->nullable();
        $table->string('header_copy')->nullable();
    }
}

?>
