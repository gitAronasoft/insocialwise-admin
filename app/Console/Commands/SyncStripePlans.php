<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SubscriptionPlan;
use App\Services\StripeService;
use Illuminate\Support\Str;

class SyncStripePlans extends Command
{
    protected $signature = 'stripe:sync-plans';
    protected $description = 'Sync subscription plans from Stripe to the local database';

    public function handle()
    {
        $stripeService = app(StripeService::class);

        if (!$stripeService->isConfigured()) {
            $this->error('Stripe is not configured. Please add STRIPE_SECRET_KEY to your .env file.');
            return 1;
        }

        $this->info('Fetching products from Stripe...');
        $products = $stripeService->listProducts(true, 100);

        if (empty($products)) {
            $this->warn('No active products found in Stripe.');
            return 0;
        }

        $this->info('Found ' . count($products) . ' products in Stripe.');

        $syncedCount = 0;
        $createdCount = 0;
        $updatedCount = 0;

        foreach ($products as $product) {
            $this->line("Processing: {$product->name}");

            $prices = $stripeService->listPrices($product->id, true, 10);
            
            $monthlyPrice = null;
            $yearlyPrice = null;
            
            foreach ($prices as $price) {
                if (isset($price->recurring)) {
                    if ($price->recurring->interval === 'month') {
                        $monthlyPrice = $price;
                    } elseif ($price->recurring->interval === 'year') {
                        $yearlyPrice = $price;
                    }
                }
            }

            $existingPlan = SubscriptionPlan::where('stripe_product_id', $product->id)->first();

            $baseSlug = Str::slug($product->name);
            $slug = $baseSlug;
            
            if (!$existingPlan) {
                $counter = 1;
                while (SubscriptionPlan::where('slug', $slug)->where('stripe_product_id', '!=', $product->id)->exists()) {
                    $slug = $baseSlug . '-' . $counter;
                    $counter++;
                }
            } else {
                $slug = $existingPlan->slug;
            }

            $planData = [
                'name' => $product->name,
                'slug' => $slug,
                'description' => $product->description ?? '',
                'stripe_product_id' => $product->id,
                'active' => $product->active,
                'price' => 0,
                'monthly_price_usd' => 0,
                'yearly_price' => 0,
                'yearly_price_usd' => 0,
                'currency' => 'USD',
                'billing_cycle' => 'monthly',
            ];

            if ($monthlyPrice) {
                $planData['stripe_price_id'] = $monthlyPrice->id;
                $planData['price'] = $monthlyPrice->unit_amount / 100;
                $planData['monthly_price_usd'] = $monthlyPrice->unit_amount / 100;
                $planData['currency'] = strtoupper($monthlyPrice->currency);
                $planData['billing_cycle'] = 'monthly';
            }

            if ($yearlyPrice) {
                $planData['stripe_yearly_price_id'] = $yearlyPrice->id;
                $planData['yearly_price'] = $yearlyPrice->unit_amount / 100;
                $planData['yearly_price_usd'] = $yearlyPrice->unit_amount / 100;
            }

            $metadata = $product->metadata->toArray();
            if (!empty($metadata)) {
                if (isset($metadata['max_social_accounts'])) {
                    $planData['max_social_accounts'] = (int) $metadata['max_social_accounts'];
                }
                if (isset($metadata['max_team_members'])) {
                    $planData['max_team_members'] = (int) $metadata['max_team_members'];
                }
                if (isset($metadata['max_scheduled_posts'])) {
                    $planData['max_scheduled_posts'] = (int) $metadata['max_scheduled_posts'];
                }
                if (isset($metadata['trial_days'])) {
                    $planData['trial_period_days'] = (int) $metadata['trial_days'];
                    $planData['trial_enabled'] = (int) $metadata['trial_days'] > 0;
                }
                if (isset($metadata['features'])) {
                    $features = json_decode($metadata['features'], true);
                    if (is_array($features)) {
                        $planData['features'] = $features;
                    }
                }
            }

            if ($existingPlan) {
                $existingPlan->update($planData);
                $this->info("  Updated: {$product->name}");
                $updatedCount++;
            } else {
                $planData['show_on_landing'] = true;
                $planData['sort_order'] = $syncedCount + 1;
                SubscriptionPlan::create($planData);
                $this->info("  Created: {$product->name}");
                $createdCount++;
            }

            $syncedCount++;
        }

        $this->newLine();
        $this->info("Sync complete! Created: {$createdCount}, Updated: {$updatedCount}");
        
        return 0;
    }
}
