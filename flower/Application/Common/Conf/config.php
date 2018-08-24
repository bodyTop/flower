<?php
return array(
	//'配置项'=>'配置值'
    'DB_TYPE'   =>  'mysql',
    'DB_HOST'   =>  '45.62.101.37',
    'DB_NAME'   =>  'flower',////数据库名
    'DB_USER'   =>  'root',//数据账户
    'DB_PWD'    =>  'root',//数据密码
    'DB_PORT'   =>  '3306' ,
    'DB_CHARSET'=>  'utf8',
    'DB_PREFIX' =>  'fl_',
    'AUTH_KEY'  =>  '9423453534354386787634347', ////这个KEY只是保证部分表单在没有SESSION 的情况下判断用户本人操作的作用
    'BAO_KEY'   => '',


//    'URL_MODEL'            => 3,
    'URL_HTML_SUFFIX'      => '.html',
    'URL_ROUTER_ON'        => true,
    'URL_CASE_INSENSITIVE' => true, //url不区分大小写
    'URL_ROUTE_RULES'      => array(
    ),
    'APP_SUB_DOMAIN_DEPLOY' => false,
);