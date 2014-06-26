<?php  
return [
    'events'    => [
        'app\modules\user\models\RegisterForm' => [
            'afterInsert' => [
                ['bariew\noticeModule\models\Item', 'userRegistration']
            ],  
        ],
//        'app\modules\user\models\User' => [
//            'afterUpdate' => [
//                ['bariew\noticeModule\models\Item', 'test']
//            ],
//        ],
    ],
    'menu'  => [
        'label'    => 'Items',
        'items' => [
            ['label'    => 'Log', 'url' => ['/notice/item/index']],
            ['label'    => 'Settings', 'url' => ['/notice/email-config/index']]
        ]
    ]
];