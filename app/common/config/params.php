<?php
return [
    'domain' => 'https://dummy.loc/',
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'mail' => [
        'api_user' => 'dummy.loc',
        'api_pass' => '',
        'sendgrid_endpoint' => 'https://api.sendgrid.com/api/mail.send.json',
        'sendgrid_unsubscibe' => 'https://api.sendgrid.com/api/unsubscribes.add.json',
        'sendgrid_api_key' => '',
        'auth_required' => true
    ],
    'gtm_id' => '',
    'telegram' => [
        'token' => '513356544:AAFJjs-esINpHvzAoPxgAlwYCgsfcUfdtXo',
        'disable_web_page_preview' => true,
        'parse_mode' => 'MARKDOWN',
        'chat_ids' => [
            -316705612
        ],
    ],
];