<?php
return [
    'status'=>[
        '1'=>"yes",
        '2'=>"no",
],
    //webUploader 图片组件
        'domain' =>  '@web/',
        'webuploader' => [
            // 后端处理图片的地址，value 是相对的地址
            'uploadUrl' => 'upload',
            // 多文件分隔符
            'delimiter' => ',',
            // 基本配置
            'baseConfig' => [
                'defaultImage' => '',
                'disableGlobalDnd' => true,
                'accept' => [
                    'title' => 'Images',
                    'extensions' => 'gif,jpg,jpeg,bmp,png',
                    'mimeTypes' => 'image/*',
                ],
                'pick' => [
                    'multiple' => false,
                ],
            ],

    ],
];
