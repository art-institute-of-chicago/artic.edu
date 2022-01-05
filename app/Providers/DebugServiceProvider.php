<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class DebugServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('debug', function ($app) {
            return new class() {
                private $output = [];

                public function log($class, $field, $mutator = false)
                {
                    $class = $class . ($mutator ? ' as mutator' : '');

                    if (!isset($this->output[$class])) {
                        $this->output[$class] = [];
                    }

                    if (!in_array($field, $this->output[$class])) {
                        $this->output[$class][] = $field;
                    }
                }

                public function getOutput()
                {
                    return $this->output;
                }
            };
        });
    }
}
