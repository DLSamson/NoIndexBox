<?php

return [
    'noIndexBox' => [
        'file' => 'noindexbox',
        'description' => '',
        'events' => [
            'OnDocFormPrerender' => [],
            'OnDocFormSave' => [],
            'OnLoadWebDocument' => [],
            'OnEmptyTrash' => [],
        ],
    ],
];