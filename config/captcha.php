<?php

// BotDetect PHP Captcha configuration options

return [
  // Captcha configuration for example page
  'ExampleCaptcha' => [
    'UserInputID' => 'CaptchaCode',
    'CodeLength' => 5,
    'ImageWidth' => 250,
    'ImageHeight' => 50,
    'AutoUppercaseInput' => true,
  ],

];


return [
    'secret' => env('NOCAPTCHA_SECRET','6LdjkB4TAAAAAAPgaClehnHmMM6KrK9fByjs9jDx'),
    'sitekey' => env('NOCAPTCHA_SITEKEY','6LdjkB4TAAAAANCNDeNycfDW7R4JxTzS2rUoDD5K'),
    'default'   => [
        'length'    => 5,
        'width'     => 120,
        'height'    => 36,
        'quality'   => 90,
    ],
];
