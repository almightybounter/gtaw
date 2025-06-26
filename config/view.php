<?php

return [

    // View paths
    'paths' => [
        resource_path('views'),
    ],

    // Compiled templates
    'compiled' => env(
        'VIEW_COMPILED_PATH',
        storage_path('framework/views')
    ),

]; 