<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Product;
use Stripe\Price;
use Stripe\StripeClient;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class StripeService
{
    protected ?StripeClient $client = null;

    public function __construct()
    {
        $this->initializeClient();
    }

    protected function initializeClient(): void
    {
        $secretKey = config('services.stripe.secret');
        
        if ($secretKey) {
            try {
                $this->client = new StripeClient($secretKey);
                Stripe::setApiKey($secretKey);
            } catch (\Exception $e) {
                Log::warning('Stripe initialization failed: ' . $e->getMessage());
                $this->client = null;
            }
        }
    }

    public function isConfigured(): bool
    {
        return $this->client !== null;
    }

    public function getPublishableKey(): ?string
    {
        return config('services.stripe.publishable');
    }

    public function getClient(): ?StripeClient
    {
        return $this->client;
    }

    public function createProduct(string $name, string $description = null, array $metadata = []): ?Product
    {
        if (!$this->client) {
            return null;
        }

        try {
            $params = [
                'name' => $name,
                'metadata' => $metadata,
            ];
            
            if (!empty($description)) {
                $params['description'] = $description;
            }
            
            return $this->client->products->create($params);
        } catch (\Exception $e) {
            Log::error('Stripe create product failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateProduct(string $productId, array $params): ?Product
    {
        if (!$this->client) {
            return null;
        }

        try {
            return $this->client->products->update($productId, $params);
        } catch (\Exception $e) {
            Log::error('Stripe update product failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function archiveProduct(string $productId): ?Product
    {
        if (!$this->client) {
            return null;
        }

        try {
            return $this->client->products->update($productId, [
                'active' => false,
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe archive product failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteProduct(string $productId): bool
    {
        if (!$this->client) {
            return false;
        }

        try {
            $this->client->products->delete($productId);
            return true;
        } catch (\Exception $e) {
            Log::error('Stripe delete product failed: ' . $e->getMessage());
            return false;
        }
    }

    public function createPrice(
        string $productId,
        int $unitAmount,
        string $currency = 'usd',
        string $interval = null,
        array $metadata = []
    ): ?Price {
        if (!$this->client) {
            return null;
        }

        try {
            $params = [
                'product' => $productId,
                'unit_amount' => $unitAmount,
                'currency' => strtolower($currency),
                'metadata' => $metadata,
            ];

            if ($interval && $interval !== 'one_time') {
                $params['recurring'] = [
                    'interval' => $interval === 'yearly' ? 'year' : 'month',
                ];
            }

            return $this->client->prices->create($params);
        } catch (\Exception $e) {
            Log::error('Stripe create price failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updatePrice(string $priceId, array $params): ?Price
    {
        if (!$this->client) {
            return null;
        }

        try {
            return $this->client->prices->update($priceId, $params);
        } catch (\Exception $e) {
            Log::error('Stripe update price failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function archivePrice(string $priceId): ?Price
    {
        if (!$this->client) {
            return null;
        }

        try {
            return $this->client->prices->update($priceId, [
                'active' => false,
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe archive price failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getProduct(string $productId): ?Product
    {
        if (!$this->client) {
            return null;
        }

        try {
            return $this->client->products->retrieve($productId);
        } catch (\Exception $e) {
            Log::error('Stripe get product failed: ' . $e->getMessage());
            return null;
        }
    }

    public function getPrice(string $priceId): ?Price
    {
        if (!$this->client) {
            return null;
        }

        try {
            return $this->client->prices->retrieve($priceId);
        } catch (\Exception $e) {
            Log::error('Stripe get price failed: ' . $e->getMessage());
            return null;
        }
    }

    public function listProducts(bool $active = true, int $limit = 100): array
    {
        if (!$this->client) {
            return [];
        }

        try {
            $products = $this->client->products->all([
                'active' => $active,
                'limit' => $limit,
            ]);
            return $products->data;
        } catch (\Exception $e) {
            Log::error('Stripe list products failed: ' . $e->getMessage());
            return [];
        }
    }

    public function listPrices(string $productId = null, bool $active = true, int $limit = 100): array
    {
        if (!$this->client) {
            return [];
        }

        try {
            $params = [
                'active' => $active,
                'limit' => $limit,
            ];
            
            if ($productId) {
                $params['product'] = $productId;
            }

            $prices = $this->client->prices->all($params);
            return $prices->data;
        } catch (\Exception $e) {
            Log::error('Stripe list prices failed: ' . $e->getMessage());
            return [];
        }
    }

    public function syncPlanToStripe(\App\Models\SubscriptionPlan $plan): array
    {
        if (!$this->client) {
            return [
                'success' => false,
                'error' => 'Stripe not configured. Please add STRIPE_SECRET_KEY to your .env file.',
            ];
        }

        if ($plan->is_contact_only) {
            return [
                'success' => false,
                'error' => 'Contact-only plans cannot be synced to Stripe.',
            ];
        }

        try {
            $metadata = [
                'plan_id' => (string) $plan->id,
                'max_social_accounts' => (string) ($plan->max_social_accounts ?? 0),
                'max_team_members' => (string) ($plan->max_team_members ?? 0),
                'max_scheduled_posts' => (string) ($plan->max_scheduled_posts ?? 0),
                'trial_days' => (string) ($plan->trial_period_days ?? 0),
                'features' => json_encode($plan->features ?? []),
            ];

            if ($plan->stripe_product_id) {
                $updateParams = [
                    'name' => $plan->name,
                    'active' => $plan->active,
                    'metadata' => $metadata,
                ];
                if (!empty($plan->description)) {
                    $updateParams['description'] = $plan->description;
                }
                $product = $this->updateProduct($plan->stripe_product_id, $updateParams);
            } else {
                $product = $this->createProduct($plan->name, !empty($plan->description) ? $plan->description : null, $metadata);
                $plan->stripe_product_id = $product->id;
            }

            $monthlyPriceAmountCents = (int) ($plan->price * 100);
            $needsNewMonthlyPrice = true;

            if ($plan->stripe_price_id) {
                $existingPrice = $this->getPrice($plan->stripe_price_id);
                if ($existingPrice) {
                    if ($existingPrice->unit_amount === $monthlyPriceAmountCents &&
                        strtolower($existingPrice->currency) === strtolower($plan->currency)) {
                        $needsNewMonthlyPrice = false;
                        $this->updatePrice($plan->stripe_price_id, [
                            'active' => $plan->active,
                            'metadata' => array_merge($metadata, ['billing_cycle' => 'monthly']),
                        ]);
                    } else {
                        $this->archivePrice($plan->stripe_price_id);
                    }
                } else {
                    // Price doesn't exist in Stripe, clear the stored ID
                    $plan->stripe_price_id = null;
                }
            }

            if ($needsNewMonthlyPrice && $monthlyPriceAmountCents > 0) {
                $price = $this->createPrice(
                    $product->id,
                    $monthlyPriceAmountCents,
                    $plan->currency,
                    'monthly',
                    array_merge($metadata, ['billing_cycle' => 'monthly'])
                );
                $plan->stripe_price_id = $price->id;
            }

            if ($plan->yearly_price && $plan->yearly_price > 0) {
                $yearlyPriceAmountCents = (int) ($plan->yearly_price * 100);
                $needsNewYearlyPrice = true;

                if ($plan->stripe_yearly_price_id) {
                    $existingYearlyPrice = $this->getPrice($plan->stripe_yearly_price_id);
                    if ($existingYearlyPrice) {
                        if ($existingYearlyPrice->unit_amount === $yearlyPriceAmountCents &&
                            strtolower($existingYearlyPrice->currency) === strtolower($plan->currency)) {
                            $needsNewYearlyPrice = false;
                            $this->updatePrice($plan->stripe_yearly_price_id, [
                                'active' => $plan->active,
                                'metadata' => array_merge($metadata, ['billing_cycle' => 'yearly']),
                            ]);
                        } else {
                            $this->archivePrice($plan->stripe_yearly_price_id);
                        }
                    } else {
                        // Price doesn't exist in Stripe, clear the stored ID
                        $plan->stripe_yearly_price_id = null;
                    }
                }

                if ($needsNewYearlyPrice) {
                    $yearlyPrice = $this->createPrice(
                        $product->id,
                        $yearlyPriceAmountCents,
                        $plan->currency,
                        'yearly',
                        array_merge($metadata, ['billing_cycle' => 'yearly'])
                    );
                    $plan->stripe_yearly_price_id = $yearlyPrice->id;
                }
            } elseif ($plan->stripe_yearly_price_id) {
                $this->archivePrice($plan->stripe_yearly_price_id);
                $plan->stripe_yearly_price_id = null;
            }

            $plan->save();

            return [
                'success' => true,
                'product_id' => $plan->stripe_product_id,
                'price_id' => $plan->stripe_price_id,
                'yearly_price_id' => $plan->stripe_yearly_price_id,
            ];
        } catch (\Exception $e) {
            Log::error('Stripe sync failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function archivePlanFromStripe(\App\Models\SubscriptionPlan $plan): array
    {
        if (!$this->client) {
            return [
                'success' => false,
                'error' => 'Stripe not configured',
            ];
        }

        try {
            if ($plan->stripe_price_id) {
                $this->archivePrice($plan->stripe_price_id);
            }
            if ($plan->stripe_yearly_price_id) {
                $this->archivePrice($plan->stripe_yearly_price_id);
            }
            if ($plan->stripe_product_id) {
                $this->archiveProduct($plan->stripe_product_id);
            }

            return ['success' => true];
        } catch (\Exception $e) {
            Log::error('Stripe archive failed: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function createSubscriptionWithTrial(
        string $customerId,
        string $priceId,
        int $trialDays = 0,
        array $metadata = []
    ): ?\Stripe\Subscription {
        if (!$this->client) {
            return null;
        }

        try {
            $params = [
                'customer' => $customerId,
                'items' => [['price' => $priceId]],
                'metadata' => $metadata,
            ];

            if ($trialDays > 0) {
                $params['trial_period_days'] = $trialDays;
            }

            return $this->client->subscriptions->create($params);
        } catch (\Exception $e) {
            Log::error('Stripe create subscription failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
