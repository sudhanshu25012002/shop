<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin & Customer Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@aurelia.com'],
            [
                'name' => 'Eleanor Vance (Creative Director)',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '+1 (555) 234-5678',
                'address' => '740 Park Avenue, Penthouse B',
                'city' => 'New York',
                'postal_code' => '10021',
                'country' => 'United States',
            ]
        );

        $customer = User::firstOrCreate(
            ['email' => 'customer@aurelia.com'],
            [
                'name' => 'Sophia Laurent',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '+1 (555) 876-5432',
                'address' => '124 Mercer Street, Suite 4',
                'city' => 'New York',
                'postal_code' => '10012',
                'country' => 'United States',
            ]
        );

        // 2. Create Categories
        $categories = [
            [
                'name' => 'Outerwear & Coats',
                'slug' => 'outerwear-coats',
                'description' => 'Architectural silhouettes spun from double-faced cashmere and virgin merino wool.',
                'image' => '/images/products/cashmere_wool_coat.jpg',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Tailored Blazers',
                'slug' => 'tailored-blazers',
                'description' => 'Precision-cut blazers crafted in Biella, Italy with sculpted shoulders and hand-stitched lapels.',
                'image' => '/images/products/structured_wool_blazer.jpg',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Silk & Tops',
                'slug' => 'silk-tops',
                'description' => 'Fluid heavy mulberry silk blouses that drape effortlessly from day into evening.',
                'image' => '/images/products/silk_blouse.jpg',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Trousers & Tailoring',
                'slug' => 'trousers-tailoring',
                'description' => 'High-waisted pleated wide-leg trousers cut in breathable Italian linen and worsted wool.',
                'image' => '/images/products/linen_wide_trousers.jpg',
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'name' => 'Luxury Knitwear',
                'slug' => 'luxury-knitwear',
                'description' => 'Heirloom gauge cashmere and alpaca knits designed for enveloping softness.',
                'image' => '/images/products/ribbed_knit_sweater.jpg',
                'is_featured' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Dresses & Evening',
                'slug' => 'dresses-evening',
                'description' => 'Sensual bias-cut slip dresses and sculptural white evening silhouettes.',
                'image' => '/images/products/silk_slip_dress.jpg',
                'is_featured' => true,
                'sort_order' => 6,
            ],
            [
                'name' => 'Leather & Bags',
                'slug' => 'leather-bags',
                'description' => 'Handcrafted Tuscan calfskin bags finished with subtle brushed 24k-gold dipped brass.',
                'image' => '/images/products/leather_tote_bag.jpg',
                'is_featured' => true,
                'sort_order' => 7,
            ],
        ];

        $savedCategories = [];
        foreach ($categories as $cat) {
            $savedCategories[$cat['slug']] = Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        // 3. Products
        $productsData = [
            [
                'category_slug' => 'outerwear-coats',
                'name' => 'The Florence Cashmere Long Coat',
                'slug' => 'the-florence-cashmere-long-coat',
                'tagline' => '100% Mongolian Cashmere • Hand-finished in Tuscany',
                'sku' => 'AUR-COT-001',
                'price' => 890.00,
                'compare_at_price' => 1150.00,
                'stock' => 14,
                'description' => "Envelop yourself in supreme warmth with The Florence Coat. Spun from Grade-A Mongolian cashmere with a gossamer soft hand-feel, this double-faced overcoat features clean notched lapels, horn button closures, and an ankle-grazing fluid drape designed to be worn open or belted.",
                'material_care' => "100% Grade-A Mongolian Cashmere. Cupro lined sleeves. Professional dry clean only with hydrocarbon solvent. Press under protective cloth.",
                'available_sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'available_colors' => [
                    ['name' => 'Ivory Cream', 'hex' => '#FBF9F5'],
                    ['name' => 'Warm Taupe', 'hex' => '#D5C4B4'],
                    ['name' => 'Noir Obsidian', 'hex' => '#1A1A1A'],
                ],
                'image' => '/images/products/cashmere_wool_coat.jpg',
                'gallery' => [
                    '/images/products/cashmere_wool_coat.jpg',
                    '/images/products/structured_wool_blazer.jpg',
                ],
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => true,
                'status' => 'active',
            ],
            [
                'category_slug' => 'tailored-blazers',
                'name' => 'Atelier Double-Breasted Wool Blazer',
                'slug' => 'atelier-double-breasted-wool-blazer',
                'tagline' => 'Super 130s Virgin Wool • Sculpted Silhouette',
                'sku' => 'AUR-BLZ-002',
                'price' => 620.00,
                'compare_at_price' => 740.00,
                'stock' => 22,
                'description' => "A modern masterwork of tailoring. The Atelier Blazer is defined by broad peak lapels, a subtly nipped waist, and double-breasted tortoiseshell button fastenings. Cut from bespoke woven pearl-white virgin wool that holds its shape flawlessly from board meetings to galas.",
                'material_care' => "100% Super 130s Italian Virgin Wool. 100% Mulberry Silk interior lining. Dry clean only.",
                'available_sizes' => ['XS', 'S', 'M', 'L'],
                'available_colors' => [
                    ['name' => 'Pearl White', 'hex' => '#FFFFFF'],
                    ['name' => 'Chalk Ecru', 'hex' => '#F4EFE6'],
                ],
                'image' => '/images/products/structured_wool_blazer.jpg',
                'gallery' => [
                    '/images/products/structured_wool_blazer.jpg',
                    '/images/products/linen_wide_trousers.jpg',
                ],
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => false,
                'status' => 'active',
            ],
            [
                'category_slug' => 'silk-tops',
                'name' => 'Mulberry Silk Fluid Shirt',
                'slug' => 'mulberry-silk-fluid-shirt',
                'tagline' => '22mm Heavy Mulberry Silk • Mother-of-Pearl Buttons',
                'sku' => 'AUR-TOP-003',
                'price' => 320.00,
                'compare_at_price' => 380.00,
                'stock' => 35,
                'description' => "Crafted from lustrous 22-momme pure mulberry silk charmeuse, this fluid shirt balances relaxed ease with immaculate refinement. Features genuine mother-of-pearl buttons, classic collar stand, and softly elongated cuffs that look sublime worn buttoned or pushed up.",
                'material_care' => "100% Mulberry Silk. Hand wash cold with delicate silk detergent or dry clean.",
                'available_sizes' => ['XS', 'S', 'M', 'L', 'XL'],
                'available_colors' => [
                    ['name' => 'Pure Alabaster', 'hex' => '#FFFFFF'],
                    ['name' => 'Soft Vanilla', 'hex' => '#FAF5E8'],
                ],
                'image' => '/images/products/silk_blouse.jpg',
                'gallery' => [
                    '/images/products/silk_blouse.jpg',
                ],
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => true,
                'status' => 'active',
            ],
            [
                'category_slug' => 'trousers-tailoring',
                'name' => 'Como High-Waisted Pleated Trousers',
                'slug' => 'como-high-waisted-pleated-trousers',
                'tagline' => 'Pure Italian Linen-Blend • Deep Knife Pleats',
                'sku' => 'AUR-TRS-004',
                'price' => 380.00,
                'compare_at_price' => 450.00,
                'stock' => 18,
                'description' => "Epitomizing understated European resort luxury, the Como Trouser sits high on the natural waist with sharp double pleats that cascade into a wide, languid leg. Crafted in Como from a blend of crisp linen and breathable viscose that resists wrinkling.",
                'material_care' => "65% Italian Linen, 35% Viscose. Dry clean or cold machine wash gentle cycle. Hang dry in shade.",
                'available_sizes' => ['XS', 'S', 'M', 'L'],
                'available_colors' => [
                    ['name' => 'Crisp White', 'hex' => '#FFFFFF'],
                    ['name' => 'Natural Ecru', 'hex' => '#EFEBE2'],
                ],
                'image' => '/images/products/linen_wide_trousers.jpg',
                'gallery' => [
                    '/images/products/linen_wide_trousers.jpg',
                ],
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => true,
                'status' => 'active',
            ],
            [
                'category_slug' => 'luxury-knitwear',
                'name' => 'Alpine Chunky Ribbed Turtleneck',
                'slug' => 'alpine-chunky-ribbed-turtleneck',
                'tagline' => '4-Ply Scottish Cashmere • Architectural Collar',
                'sku' => 'AUR-KNT-005',
                'price' => 460.00,
                'compare_at_price' => 540.00,
                'stock' => 12,
                'description' => "Our most decadent knit to date. Spun from substantial 4-ply cashmere with a tactile English rib stitch. The generous turtleneck frames the face gracefully, while drop shoulders and elongated ribbing at the hem create effortless casual sophistication.",
                'material_care' => "100% Scottish Cashmere. Hand wash in tepid water with cashmere wash. Dry flat on a towel.",
                'available_sizes' => ['XS', 'S', 'M', 'L'],
                'available_colors' => [
                    ['name' => 'Warm Cream', 'hex' => '#F7F4EC'],
                    ['name' => 'Oatmeal Heather', 'hex' => '#ECE3D4'],
                ],
                'image' => '/images/products/ribbed_knit_sweater.jpg',
                'gallery' => [
                    '/images/products/ribbed_knit_sweater.jpg',
                ],
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => false,
                'status' => 'active',
            ],
            [
                'category_slug' => 'dresses-evening',
                'name' => 'Verona Bias-Cut Silk Slip Dress',
                'slug' => 'verona-bias-cut-silk-slip-dress',
                'tagline' => '100% Heavy Silk Satin • Liquid Cowl Neckline',
                'sku' => 'AUR-DRS-006',
                'price' => 490.00,
                'compare_at_price' => 590.00,
                'stock' => 16,
                'description' => "The epitome of 90s minimalism re-imagined. Cut diagonally on the grain from heavy silk satin to skim curves with sensual liquid drape. Features a flattering softly scooped cowl neckline and delicate adjustable rouleau straps.",
                'material_care' => "100% Silk Satin. Dry clean recommended. Steam lightly from reverse.",
                'available_sizes' => ['XS', 'S', 'M', 'L'],
                'available_colors' => [
                    ['name' => 'Champagne Pearl', 'hex' => '#F4EDE4'],
                    ['name' => 'Pure Chalk', 'hex' => '#FFFFFF'],
                ],
                'image' => '/images/products/silk_slip_dress.jpg',
                'gallery' => [
                    '/images/products/silk_slip_dress.jpg',
                ],
                'is_featured' => true,
                'is_new' => true,
                'is_bestseller' => true,
                'status' => 'active',
            ],
            [
                'category_slug' => 'leather-bags',
                'name' => 'The Minimalist Calfskin Studio Tote',
                'slug' => 'the-minimalist-calfskin-studio-tote',
                'tagline' => 'Full-Grain Tuscan Leather • Brushed 24K Hardware',
                'sku' => 'AUR-BAG-007',
                'price' => 750.00,
                'compare_at_price' => 920.00,
                'stock' => 9,
                'description' => "The quintessential everyday companion. Hand-assembled by master leather artisans outside Florence using vegetable-tanned, scratch-resistant pebble calfskin. Fits a 15-inch laptop with ease, completed by an interior suede zip compartment and subtle gold foil logo stamp.",
                'material_care' => "100% Italian Full-Grain Pebble Calfskin. Interior microsuede lining. Wipe clean with soft damp cloth; treat annually with leather balm.",
                'available_sizes' => ['One Size'],
                'available_colors' => [
                    ['name' => 'Chalk White', 'hex' => '#F9F8F6'],
                    ['name' => 'Warm Sand', 'hex' => '#E5DCB8'],
                ],
                'image' => '/images/products/leather_tote_bag.jpg',
                'gallery' => [
                    '/images/products/leather_tote_bag.jpg',
                ],
                'is_featured' => true,
                'is_new' => false,
                'is_bestseller' => true,
                'status' => 'active',
            ],
        ];

        $savedProducts = [];
        foreach ($productsData as $pData) {
            $catSlug = $pData['category_slug'];
            unset($pData['category_slug']);
            $pData['category_id'] = $savedCategories[$catSlug]->id;
            
            $prod = Product::updateOrCreate(['slug' => $pData['slug']], $pData);
            $savedProducts[] = $prod;

            // Add reviews
            Review::updateOrCreate(
                ['product_id' => $prod->id, 'user_name' => 'Camille Dumont'],
                [
                    'rating' => 5,
                    'title' => 'Exquisite craftsmanship & breathtaking drape',
                    'comment' => 'The fabric density and tailoring exceeded my expectations. Pure minimalist perfection that elevates everything in my wardrobe.',
                    'is_verified' => true,
                ]
            );
            Review::updateOrCreate(
                ['product_id' => $prod->id, 'user_name' => 'Isla Sterling'],
                [
                    'rating' => 5,
                    'title' => 'Worth every single penny',
                    'comment' => 'Received multiple compliments the first day I wore it out. The clean lines and white monochromatic hue look like bespoke Savile Row tailoring.',
                    'is_verified' => true,
                ]
            );
        }

        // 4. Sample Orders for Dashboard Metrics
        $sampleOrders = [
            [
                'order_number' => 'AUR-2026-9041',
                'user_id' => $customer->id,
                'customer_name' => 'Sophia Laurent',
                'customer_email' => 'customer@aurelia.com',
                'customer_phone' => '+1 (555) 876-5432',
                'shipping_address' => '124 Mercer Street, Suite 4',
                'shipping_city' => 'New York',
                'shipping_postal_code' => '10012',
                'shipping_country' => 'United States',
                'subtotal' => 1210.00,
                'discount' => 121.00,
                'shipping_fee' => 0.00,
                'tax' => 87.12,
                'total' => 1176.12,
                'payment_method' => 'card',
                'payment_status' => 'paid',
                'status' => 'processing',
                'notes' => 'Please leave with concierge.',
                'created_at' => now()->subHours(3),
                'items' => [
                    [
                        'product_id' => $savedProducts[0]->id,
                        'product_name' => $savedProducts[0]->name,
                        'product_image' => $savedProducts[0]->image,
                        'size' => 'M',
                        'color' => 'Ivory Cream',
                        'price' => $savedProducts[0]->price,
                        'quantity' => 1,
                        'total' => $savedProducts[0]->price,
                    ],
                    [
                        'product_id' => $savedProducts[2]->id,
                        'product_name' => $savedProducts[2]->name,
                        'product_image' => $savedProducts[2]->image,
                        'size' => 'S',
                        'color' => 'Pure Alabaster',
                        'price' => $savedProducts[2]->price,
                        'quantity' => 1,
                        'total' => $savedProducts[2]->price,
                    ],
                ]
            ],
            [
                'order_number' => 'AUR-2026-9038',
                'user_id' => null,
                'customer_name' => 'Charlotte Hayes',
                'customer_email' => 'charlotte.hayes@example.com',
                'customer_phone' => '+1 (555) 345-9876',
                'shipping_address' => '450 Sutter Street',
                'shipping_city' => 'San Francisco',
                'shipping_postal_code' => '94108',
                'shipping_country' => 'United States',
                'subtotal' => 750.00,
                'discount' => 0.00,
                'shipping_fee' => 0.00,
                'tax' => 61.88,
                'total' => 811.88,
                'payment_method' => 'card',
                'payment_status' => 'paid',
                'status' => 'shipped',
                'notes' => null,
                'created_at' => now()->subDays(1),
                'items' => [
                    [
                        'product_id' => $savedProducts[6]->id,
                        'product_name' => $savedProducts[6]->name,
                        'product_image' => $savedProducts[6]->image,
                        'size' => 'One Size',
                        'color' => 'Chalk White',
                        'price' => $savedProducts[6]->price,
                        'quantity' => 1,
                        'total' => $savedProducts[6]->price,
                    ],
                ]
            ],
            [
                'order_number' => 'AUR-2026-9025',
                'user_id' => null,
                'customer_name' => 'Alexander Wright',
                'customer_email' => 'alex.wright@example.co.uk',
                'customer_phone' => '+44 20 7946 0912',
                'shipping_address' => '14 Kensington Square',
                'shipping_city' => 'London',
                'shipping_postal_code' => 'W8 5HP',
                'shipping_country' => 'United Kingdom',
                'subtotal' => 1000.00,
                'discount' => 0.00,
                'shipping_fee' => 0.00,
                'tax' => 80.00,
                'total' => 1080.00,
                'payment_method' => 'card',
                'payment_status' => 'paid',
                'status' => 'delivered',
                'notes' => null,
                'created_at' => now()->subDays(3),
                'items' => [
                    [
                        'product_id' => $savedProducts[1]->id,
                        'product_name' => $savedProducts[1]->name,
                        'product_image' => $savedProducts[1]->image,
                        'size' => 'L',
                        'color' => 'Pearl White',
                        'price' => $savedProducts[1]->price,
                        'quantity' => 1,
                        'total' => $savedProducts[1]->price,
                    ],
                    [
                        'product_id' => $savedProducts[3]->id,
                        'product_name' => $savedProducts[3]->name,
                        'product_image' => $savedProducts[3]->image,
                        'size' => 'M',
                        'color' => 'Crisp White',
                        'price' => $savedProducts[3]->price,
                        'quantity' => 1,
                        'total' => $savedProducts[3]->price,
                    ],
                ]
            ],
            [
                'order_number' => 'AUR-2026-9012',
                'user_id' => null,
                'customer_name' => 'Elena Rostova',
                'customer_email' => 'elena.rostova@example.com',
                'customer_phone' => '+1 (555) 765-4321',
                'shipping_address' => '88 Ocean Drive',
                'shipping_city' => 'Miami',
                'shipping_postal_code' => '33139',
                'shipping_country' => 'United States',
                'subtotal' => 490.00,
                'discount' => 0.00,
                'shipping_fee' => 0.00,
                'tax' => 34.30,
                'total' => 524.30,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'status' => 'pending',
                'notes' => 'Call on delivery arrival.',
                'created_at' => now()->subHours(1),
                'items' => [
                    [
                        'product_id' => $savedProducts[5]->id,
                        'product_name' => $savedProducts[5]->name,
                        'product_image' => $savedProducts[5]->image,
                        'size' => 'S',
                        'color' => 'Champagne Pearl',
                        'price' => $savedProducts[5]->price,
                        'quantity' => 1,
                        'total' => $savedProducts[5]->price,
                    ],
                ]
            ],
        ];

        foreach ($sampleOrders as $oData) {
            $items = $oData['items'];
            unset($oData['items']);
            $order = Order::updateOrCreate(['order_number' => $oData['order_number']], $oData);
            
            foreach ($items as $item) {
                $item['order_id'] = $order->id;
                OrderItem::create($item);
            }
        }
    }
}
