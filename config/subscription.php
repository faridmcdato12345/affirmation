<?php 
return [
    /*
     |-------------------------------------------------------------------
     | Vendor Receipt Configuration
     |-------------------------------------------------------------------
     | The following configuration will be shown on the receipt as 
     | the vendor or seller of the product. This allows you to 
     | configure company information.
     |
     */
    'receipt_data' => [
        'vendor'   => 'Yourmind.fitness',
        'product'  => '',
        'street'   => '101 - 1860 Pandosy St',
        'location' => 'Kelowna, BC',
        'phone'    => '587-873-0533'
    ],
    
    /*
     |------------------------------------------------------------------
     | Subcription Plans Configuration
     |------------------------------------------------------------------
     | The following configuration allows you to configure your
     | subscription plans for your application. This includes a
     | name, description, features which is shown as bullet points.
     |
     */

    'plans' => [
      [
          'name'               => 'Premium Founder\'s Pricing',
          'description'        => 'Special Founder\'s Pricing. Get access to the premium features to help improve your mental wellness journey.',
          'monthly_id'         => env('APP_ENV', 'local') === 'production' ? env('PROD_FOUNDER_MONTHLY_PRICE') : env('FOUNDER_PREMIUM_MONTHLY_PRICE'),
          'yearly_id'          => env('APP_ENV', 'local') === 'production' ? env('PROD_FOUNDER_YEARLY_PRICE') : env('FOUNDER_PREMIUM_YEARLY_PRICE'),
          'monthly_incentive'  => 'Save 40%',
          'yearly_incentive'   => 'Save 50%',
          'features' => [
              'Premium at a discount price forever',
              'Focused Affirmation Categories',
              'Schedulable Notifications',
              'Your Welness Tracking Metrics (Coming Soon)',
              'Custom Backgrounds',
              'Custom Affirmations',
          ],
      ],
      [
          'name'               => 'Premium',
          'description'        => 'Get access to the premium features to help improve your mental wellness journey.',
          'monthly_id'         => env('APP_ENV', 'local') === 'production' ? env('PROD_PREMIUM_MONTHLY_PRICE') : env('PREMIUM_MONTHLY_PRICE'),
          'yearly_id'          => env('APP_ENV', 'local') === 'production' ? env('PROD_PREMIUM_YEARLY_PRICE') : env('PREMIUM_YEARLY_PRICE'),
          'monthly_incentive'  => '',
          'yearly_incentive'   => 'Save 20%',
          'features' => [
              'Premium at a discount price forever',
              'Focused Affirmation Categories',
              'Schedulable Notifications',
              'Your Welness Tracking Metrics (Coming Soon)',
              'Custom Backgrounds',
              'Custom Affirmations',
          ],
      ],
    ]

];