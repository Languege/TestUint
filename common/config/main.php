<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db_queue' => [
            'class' => 'shmilyzxt\queue\queues\DatabaseQueue', //队列使用的类
            'jobEvent' => [ //队列任务事件配置，目前任务支持2个事件
                'on beforeExecute' => ['shmilyzxt\queue\base\JobEventHandler','beforeExecute'],
                'on beforeDelete' => ['shmilyzxt\queue\base\JobEventHandler','beforeDelete'],
            ],
            'connector' => [//队列中间件链接器配置（这是因为使用数据库，所以使用yii\db\Connection作为数据库链接实例）
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8',
            ],
            'table' => 'jobs', //存储队列数据表名
            'queue' => 'default', //队列的名称
            'expire' => 60, //任务过期时间
            'maxJob' =>0, //队列允许最大任务数，0为不限制
            'failed' => [//任务失败日志记录（目前只支持记录到数据库）
                'logFail' => true, //开启任务失败处理
                'provider' => [ //任务失败处理类
                    'class' => 'shmilyzxt\queue\failed\DatabaseFailedProvider',
                    'db' => [ //数据库链接
                        'class' => 'yii\db\Connection',
                        'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
                        'username' => 'root',
                        'password' => '',
                        'charset' => 'utf8',
                    ],
                    'table' => 'failed_jobs' //存储失败日志的表名
                ],
            ],
        ],
        'redis_queue' => [
            'class' => 'shmilyzxt\queue\queues\RedisQueue',
            'jobEvent' => [
                'on beforeExecute' => ['shmilyzxt\queue\base\JobEventHandler','beforeExecute'],
                'on beforeDelete' => ['shmilyzxt\queue\base\JobEventHandler','beforeDelete'],
            ],
            'connector' => [ //需要安装 predis\predis 扩展来操作redis
                'class' => 'shmilyzxt\queue\connectors\PredisConnector',
                'parameters' => [
                    'scheme' => 'tcp',
                    'host' => '192.168.3.103',
                    'port' => 6379,
                    'password' => '123456',
                    'db' => 0
                ],
                'options'=> [],
            ],
            'queue' => 'default',
            'expire' => 60,
            'maxJob' => 0,
            'failed' => [
                'logFail' => true,
                'provider' => [
                    'class' => 'shmilyzxt\queue\failed\DatabaseFailedProvider',
                    'db' => [
                        'class' => 'yii\db\Connection',
                        'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
                        'username' => 'root',
                        'password' => '',
                        'charset' => 'utf8',
                    ],
                    'table' => 'failed_jobs'
                ],
            ],
        ]
    ],
];
