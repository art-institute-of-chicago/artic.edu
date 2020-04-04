<?php

return [

    'is_preview_mode' => false,
    'hide_interactive_features' => env('HIDE_INTERACTIVE_FEATURES', true),
    'prince_command' => env('PRINCE_COMMAND', '/usr/bin/prince'),
    'protocol' => env('APP_PROTOCOL', 'https'),

];
