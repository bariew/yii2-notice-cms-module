<?php  
return [
    'events'    => [
        'app\modules\user\models\RegisterForm' => [
            'afterInsert' => [
                ['bariew\noticeModule\models\Notice', 'userRegistration']
            ],  
        ],
//        'app\modules\user\models\User' => [
//            'afterUpdate' => [
//                ['bariew\noticeModule\models\Notice', 'test']
//            ],  
//        ],
    ]
];