<?php

return [

    'default_limit' => 25,

    'max_limit' => 100,

    'default_order_column' => 'id',

    'default_order_direction' => 'desc',

    'page_name' => 'page',

    'global_relation_map' => [
        'supplier' => 'contacts',
        'purchaser' => 'contacts',
        'partner' => 'contacts',
        'tags' => 'taggables',
    ]
];