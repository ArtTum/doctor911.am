<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'crmSubscribeUrl' => getenv('CRM_SUBSCRIBE_URL') ?: 'https://crm.doctor911.am/site/add-subscribes',
    'crmSubscribeKey' => getenv('CRM_SUBSCRIBE_KEY') ?: '',
    'crmSubscribeToken' => getenv('CRM_SUBSCRIBE_TOKEN') ?: '',
];
