<?php

return [
    'slack' => [
        // Slack webhook
        'alert_webhook_url' => env('SLACK_WEBHOOK'),
        // Channel nhận notification
        'alert_channel' => env('SLACK_CHANNEL', ''),
    ],
];
