<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiKeyController extends Controller
{
    private $apiKeyGroups = [
        'payment' => [
            'label' => 'Payment Services',
            'icon' => 'credit-card',
            'keys' => [
                'STRIPE_PUBLISHABLE_KEY' => ['label' => 'Stripe Publishable Key', 'type' => 'string', 'testable' => false],
                'STRIPE_SECRET_KEY' => ['label' => 'Stripe Secret Key', 'type' => 'secret', 'testable' => true],
                'STRIPE_WEBHOOK_SECRET' => ['label' => 'Stripe Webhook Secret', 'type' => 'secret', 'testable' => false],
            ],
        ],
        'social' => [
            'label' => 'Social Media APIs',
            'icon' => 'share',
            'keys' => [
                'FACEBOOK_APP_ID' => ['label' => 'Facebook App ID', 'type' => 'string', 'testable' => false],
                'FACEBOOK_APP_SECRET' => ['label' => 'Facebook App Secret', 'type' => 'secret', 'testable' => true],
                'LINKEDIN_CLIENT_ID' => ['label' => 'LinkedIn Client ID', 'type' => 'string', 'testable' => false],
                'LINKEDIN_CLIENT_SECRET' => ['label' => 'LinkedIn Client Secret', 'type' => 'secret', 'testable' => false],
            ],
        ],
        'email' => [
            'label' => 'Email Services',
            'icon' => 'mail',
            'keys' => [
                'SMTP_HOST' => ['label' => 'SMTP Host', 'type' => 'string', 'testable' => false],
                'SMTP_PORT' => ['label' => 'SMTP Port', 'type' => 'integer', 'testable' => false],
                'SMTP_USERNAME' => ['label' => 'SMTP Username', 'type' => 'string', 'testable' => false],
                'SMTP_PASSWORD' => ['label' => 'SMTP Password', 'type' => 'secret', 'testable' => true],
                'SMTP_ENCRYPTION' => ['label' => 'SMTP Encryption', 'type' => 'string', 'testable' => false],
                'MAIL_FROM_ADDRESS' => ['label' => 'Mail From Address', 'type' => 'email', 'testable' => false],
                'MAIL_FROM_NAME' => ['label' => 'Mail From Name', 'type' => 'string', 'testable' => false],
            ],
        ],
        'integrations' => [
            'label' => 'Third-Party Integrations',
            'icon' => 'puzzle-piece',
            'keys' => [
                'N8N_WEBHOOK_URL' => ['label' => 'N8N Webhook URL', 'type' => 'string', 'testable' => true],
                'N8N_API_KEY' => ['label' => 'N8N API Key', 'type' => 'secret', 'testable' => false],
            ],
        ],
    ];

    public function index()
    {
        $apiKeys = [];

        foreach ($this->apiKeyGroups as $groupKey => $group) {
            $apiKeys[$groupKey] = [
                'label' => $group['label'],
                'icon' => $group['icon'],
                'keys' => [],
            ];

            foreach ($group['keys'] as $key => $config) {
                $setting = AdminSetting::where('key', $key)->first();
                $value = $setting ? $setting->value : null;
                
                $apiKeys[$groupKey]['keys'][$key] = [
                    'label' => $config['label'],
                    'type' => $config['type'],
                    'testable' => $config['testable'],
                    'has_value' => !empty($value),
                    'masked_value' => $this->maskValue($value, $config['type']),
                    'updated_at' => $setting ? $setting->updated_at : null,
                ];
            }
        }

        return view('admin.api-keys.index', compact('apiKeys'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string',
            'value' => 'nullable|string',
        ]);

        $keyConfig = null;
        $groupKey = null;

        foreach ($this->apiKeyGroups as $gKey => $group) {
            if (isset($group['keys'][$validated['key']])) {
                $keyConfig = $group['keys'][$validated['key']];
                $groupKey = $gKey;
                break;
            }
        }

        if (!$keyConfig) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API key.',
            ], 400);
        }

        $value = $validated['value'];
        
        if ($keyConfig['type'] === 'secret' && $value) {
            $value = Crypt::encryptString($value);
        }

        AdminSetting::updateOrCreate(
            ['key' => $validated['key']],
            [
                'value' => $value,
                'type' => $keyConfig['type'] === 'secret' ? 'encrypted' : $keyConfig['type'],
                'group' => 'api',
                'description' => $keyConfig['label'],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'API key updated successfully.',
            'masked_value' => $this->maskValue($validated['value'], $keyConfig['type']),
        ]);
    }

    public function test(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string',
        ]);

        $setting = AdminSetting::where('key', $validated['key'])->first();
        
        if (!$setting || empty($setting->value)) {
            return response()->json([
                'success' => false,
                'message' => 'API key not configured.',
            ], 400);
        }

        $result = match ($validated['key']) {
            'STRIPE_SECRET_KEY' => $this->testStripe($setting->value),
            'FACEBOOK_APP_SECRET' => $this->testFacebook(),
            'SMTP_PASSWORD' => $this->testSmtp(),
            'N8N_WEBHOOK_URL' => $this->testN8n($setting->value),
            default => ['success' => false, 'message' => 'Test not available for this key.'],
        };

        return response()->json($result);
    }

    public function delete(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string',
        ]);

        AdminSetting::where('key', $validated['key'])->delete();

        return response()->json([
            'success' => true,
            'message' => 'API key deleted successfully.',
        ]);
    }

    private function maskValue(?string $value, string $type): string
    {
        if (empty($value)) {
            return 'Not configured';
        }

        if ($type === 'secret' || $type === 'encrypted') {
            $length = strlen($value);
            if ($length <= 8) {
                return str_repeat('•', $length);
            }
            return str_repeat('•', $length - 4) . substr($value, -4);
        }

        return $value;
    }

    private function testStripe(string $encryptedKey): array
    {
        try {
            $key = Crypt::decryptString($encryptedKey);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $key,
            ])->get('https://api.stripe.com/v1/balance');

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'Stripe connection successful! Balance available.',
                ];
            }

            return [
                'success' => false,
                'message' => 'Stripe API error: ' . ($response->json()['error']['message'] ?? 'Unknown error'),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage(),
            ];
        }
    }

    private function testFacebook(): array
    {
        $appId = AdminSetting::getValue('FACEBOOK_APP_ID');
        $appSecret = AdminSetting::where('key', 'FACEBOOK_APP_SECRET')->first();

        if (!$appId || !$appSecret) {
            return [
                'success' => false,
                'message' => 'Facebook App ID and Secret are required.',
            ];
        }

        try {
            $secret = Crypt::decryptString($appSecret->value);
            
            $response = Http::get("https://graph.facebook.com/oauth/access_token", [
                'client_id' => $appId,
                'client_secret' => $secret,
                'grant_type' => 'client_credentials',
            ]);

            if ($response->successful() && isset($response->json()['access_token'])) {
                return [
                    'success' => true,
                    'message' => 'Facebook API connection successful!',
                ];
            }

            return [
                'success' => false,
                'message' => 'Facebook API error: ' . ($response->json()['error']['message'] ?? 'Unknown error'),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage(),
            ];
        }
    }

    private function testSmtp(): array
    {
        try {
            $host = AdminSetting::getValue('SMTP_HOST');
            $port = AdminSetting::getValue('SMTP_PORT', 587);

            if (!$host) {
                return [
                    'success' => false,
                    'message' => 'SMTP host not configured.',
                ];
            }

            $connection = @fsockopen($host, $port, $errno, $errstr, 5);

            if ($connection) {
                fclose($connection);
                return [
                    'success' => true,
                    'message' => "SMTP server reachable at {$host}:{$port}",
                ];
            }

            return [
                'success' => false,
                'message' => "Cannot connect to SMTP server: {$errstr}",
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection test failed: ' . $e->getMessage(),
            ];
        }
    }

    private function testN8n(string $webhookUrl): array
    {
        try {
            $response = Http::timeout(10)->post($webhookUrl, [
                'test' => true,
                'timestamp' => now()->toIso8601String(),
                'source' => 'InSocialWise Admin Panel',
            ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message' => 'N8N webhook responded successfully!',
                ];
            }

            return [
                'success' => false,
                'message' => 'N8N webhook error: Status ' . $response->status(),
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Connection failed: ' . $e->getMessage(),
            ];
        }
    }
}
