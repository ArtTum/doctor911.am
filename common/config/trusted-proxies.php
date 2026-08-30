<?php

// Cloudflare's published HTTP proxy ranges. Override with a comma-separated
// TRUSTED_PROXY_CIDRS value, or set that variable to an empty string to disable.
$defaultCloudflareCidrs = [
    '173.245.48.0/20',
    '103.21.244.0/22',
    '103.22.200.0/22',
    '103.31.4.0/22',
    '141.101.64.0/18',
    '108.162.192.0/18',
    '190.93.240.0/20',
    '188.114.96.0/20',
    '197.234.240.0/22',
    '198.41.128.0/17',
    '162.158.0.0/15',
    '104.16.0.0/13',
    '104.24.0.0/14',
    '172.64.0.0/13',
    '131.0.72.0/22',
    '2400:cb00::/32',
    '2606:4700::/32',
    '2803:f800::/32',
    '2405:b500::/32',
    '2405:8100::/32',
    '2a06:98c0::/29',
    '2c0f:f248::/32',
];

$configuredCidrs = getenv('TRUSTED_PROXY_CIDRS');
$trustedCidrs = $configuredCidrs === false
    ? $defaultCloudflareCidrs
    : preg_split('/\s*,\s*/', trim($configuredCidrs), -1, PREG_SPLIT_NO_EMPTY);

$trustedHosts = [];
foreach ($trustedCidrs as $cidr) {
    $trustedHosts[$cidr] = ['CF-Connecting-IP', 'X-Forwarded-Proto'];
}

return [
    'trustedHosts' => $trustedHosts,
    'secureHeaders' => [
        'X-Forwarded-For',
        'X-Forwarded-Host',
        'X-Forwarded-Proto',
        'X-Forwarded-Port',
        'Front-End-Https',
        'X-Rewrite-Url',
        'X-Original-Host',
        'CF-Connecting-IP',
    ],
    'ipHeaders' => ['CF-Connecting-IP'],
];
