<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ShowcaseDemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('=== Starting MiniMart Complete Showcase Seeder ===');

        // 1. Import Permissions from JSON & Setup Spatie Roles
        $this->setupPermissionsAndRoles();

        // 2. Languages & Stores
        $this->setupLanguagesAndStores();

        // 3. Product Types
        $this->setupProductTypes();

        // 4. Categories & Subcategories
        $this->setupCategories();

        // 5. Products & Product Images
        $this->setupProducts();

        // 6. Customers & Addresses
        $this->setupCustomers();

        // 7. Orders & Items (for Dashboard Charts & Stats)
        $this->setupOrders();

        // 8. Banners, Shipping & Payment Methods
        $this->setupBannersAndMethods();

        $this->command->info('=== MiniMart Showcase Seeder Completed Successfully! ===');
    }

    protected function setupPermissionsAndRoles(): void
    {
        $this->command->info('1. Setting up Permissions and Roles...');

        // Run permission:import command if available
        try {
            if (File::exists(base_path('public/permission_acl.json'))) {
                Artisan::call('permissions:import');
                $this->command->info('Artisan permissions:import finished.');
            }
        } catch (\Throwable $e) {
            $this->command->warn('Permissions import notice: ' . $e->getMessage());
        }

        // Setup Roles
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('roles')) {
                $superAdminRole = \Spatie\Permission\Models\Role::firstOrCreate(
                    ['name' => 'Super Admin', 'guard_name' => 'web'],
                    ['label' => 'Super Administrator']
                );

                $managerRole = \Spatie\Permission\Models\Role::firstOrCreate(
                    ['name' => 'Store Manager', 'guard_name' => 'web'],
                    ['label' => 'Store Operations Manager']
                );

                // Give Super Admin all permissions
                if (\Illuminate\Support\Facades\Schema::hasTable('permissions')) {
                    $allPermissions = \Spatie\Permission\Models\Permission::all();
                    if ($allPermissions->count() > 0) {
                        $superAdminRole->syncPermissions($allPermissions);

                        // Give Manager operational permissions
                        $managerPermissions = $allPermissions->filter(function ($p) {
                            $name = strtolower($p->name);
                            return str_contains($name, 'product') ||
                                   str_contains($name, 'order') ||
                                   str_contains($name, 'category') ||
                                   str_contains($name, 'customer') ||
                                   str_contains($name, 'dashboard');
                        });
                        $managerRole->syncPermissions($managerPermissions);
                    }
                }

                // Users
                $superAdmin = \App\Models\User::updateOrCreate(
                    ['email' => 'admin@gmail.com'],
                    [
                        'name' => 'Supreme Admin',
                        'is_super_admin' => 1,
                        'password' => Hash::make('Admin@123'),
                        'email_verified_at' => now(),
                    ]
                );

                $manager = \App\Models\User::updateOrCreate(
                    ['email' => 'manager@gmail.com'],
                    [
                        'name' => 'Store Manager',
                        'is_super_admin' => 0,
                        'password' => Hash::make('Manager@123'),
                        'email_verified_at' => now(),
                    ]
                );

                if (method_exists($superAdmin, 'assignRole')) {
                    $superAdmin->syncRoles([$superAdminRole]);
                    $manager->syncRoles([$managerRole]);
                }
            }
        } catch (\Throwable $e) {
            $this->command->warn('Roles notice: ' . $e->getMessage());
        }
    }

    protected function setupLanguagesAndStores(): void
    {
        $this->command->info('2. Setting up Languages and Stores...');

        // Languages
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('languages')) {
                DB::table('languages')->updateOrInsert(
                    ['code' => 'en'],
                    ['name' => 'English', 'status' => 1, 'is_default' => 1, 'created_at' => now(), 'updated_at' => now()]
                );
                DB::table('languages')->updateOrInsert(
                    ['code' => 'ar'],
                    ['name' => 'Arabic', 'status' => 1, 'is_default' => 0, 'created_at' => now(), 'updated_at' => now()]
                );
            }
        } catch (\Throwable $e) {}

        // Stores
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('stores')) {
                $stores = [
                    [
                        'name' => 'MiniMart Flagship Store',
                        'code' => 'MM_FLAGSHIP',
                        'url_key' => 'main-store',
                        'website' => 'https://minimart.local',
                        'status' => 1,
                        'is_default' => 1,
                    ],
                    [
                        'name' => 'MiniMart Downtown Express',
                        'code' => 'MM_EXPRESS',
                        'url_key' => 'downtown-express',
                        'website' => 'https://express.minimart.local',
                        'status' => 1,
                        'is_default' => 0,
                    ],
                    [
                        'name' => 'MiniMart Online Superstore',
                        'code' => 'MM_ONLINE',
                        'url_key' => 'online-store',
                        'website' => 'https://online.minimart.local',
                        'status' => 1,
                        'is_default' => 0,
                    ],
                ];

                foreach ($stores as $s) {
                    DB::table('stores')->updateOrInsert(['code' => $s['code']], array_merge($s, [
                        'language_id' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]));
                }
            }
        } catch (\Throwable $e) {}
    }

    protected function setupProductTypes(): void
    {
        $this->command->info('3. Setting up Product Types & Image Types...');
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('product_types')) {
                $types = [
                    ['name' => 'simple', 'description' => 'Simple Physical Product'],
                    ['name' => 'configurable', 'description' => 'Configurable Product with Variants'],
                    ['name' => 'virtual', 'description' => 'Digital / Virtual Product'],
                    ['name' => 'bundle', 'description' => 'Product Bundle Set'],
                ];
                foreach ($types as $t) {
                    $hasType = DB::table('product_types')->where('name', $t['name'])->first();
                    if (!$hasType) {
                        DB::table('product_types')->insert([
                            'name' => $t['name'],
                            'description' => $t['description'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            if (\Illuminate\Support\Facades\Schema::hasTable('product_image_types')) {
                $imgTypes = [
                    ['name' => 'primary', 'description' => 'Primary showcase product image'],
                    ['name' => 'thumbnail', 'description' => 'Product thumbnail image'],
                    ['name' => 'gallery', 'description' => 'Product gallery image'],
                ];
                foreach ($imgTypes as $it) {
                    $hasIt = DB::table('product_image_types')->where('name', $it['name'])->first();
                    if (!$hasIt) {
                        DB::table('product_image_types')->insert([
                            'name' => $it['name'],
                            'description' => $it['description'],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        } catch (\Throwable $e) {
            $this->command->warn('Product types notice: ' . $e->getMessage());
        }
    }

    protected function setupCategories(): void
    {
        $this->command->info('4. Setting up Categories & Subcategories...');
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('categories')) {
                return;
            }

            $categories = [
                [
                    'name' => 'Electronics & Gadgets',
                    'slug' => 'electronics',
                    'banner' => 'categories/electronics.svg',
                    'subs' => ['Smartphones', 'Laptops & Computers', 'Audio & Headphones', 'Smart Wearables']
                ],
                [
                    'name' => 'Fashion & Apparel',
                    'slug' => 'fashion',
                    'banner' => 'categories/fashion.svg',
                    'subs' => ["Men's Wear", "Women's Collection", "Premium Footwear", "Watches & Accessories"]
                ],
                [
                    'name' => 'Fresh Groceries',
                    'slug' => 'groceries',
                    'banner' => 'categories/groceries.svg',
                    'subs' => ['Organic Fruits & Vegetables', 'Artisan Coffee & Tea', 'Dairy & Pantry Essentials']
                ],
                [
                    'name' => 'Home & Living',
                    'slug' => 'home-living',
                    'banner' => 'categories/home.svg',
                    'subs' => ['Ergonomic Furniture', 'Modern Kitchenware', 'Home Decor & Lighting']
                ],
                [
                    'name' => 'Health & Beauty',
                    'slug' => 'health-beauty',
                    'banner' => 'categories/beauty.svg',
                    'subs' => ['Premium Skincare', 'Wellness & Supplements', 'Personal Care']
                ],
            ];

            foreach ($categories as $cat) {
                $parentId = DB::table('categories')->where('url_key', $cat['slug'])->value('id');
                if (!$parentId) {
                    $parentId = DB::table('categories')->insertGetId([
                        'name' => $cat['name'],
                        'url_key' => $cat['slug'],
                        'description' => 'Browse premier ' . $cat['name'] . ' curated by MiniMart.',
                        'parent_id' => null,
                        'path' => $cat['slug'],
                        'position' => 1,
                        'level' => 0,
                        'is_enabled' => 1,
                        'included_in_menu' => 1,
                        'banner_image' => $cat['banner'],
                        'category_image' => $cat['banner'],
                        'meta_title' => $cat['name'] . ' - Best Deals at MiniMart',
                        'meta_keywords' => strtolower($cat['name']),
                        'meta_description' => 'Shop ' . $cat['name'] . ' with fast shipping and warranty.',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                foreach ($cat['subs'] as $idx => $subName) {
                    $subSlug = Str::slug($subName);
                    $existingSub = DB::table('categories')->where('url_key', $subSlug)->first();
                    if (!$existingSub) {
                        DB::table('categories')->insert([
                            'name' => $subName,
                            'url_key' => $subSlug,
                            'description' => 'Explore top quality ' . $subName . ' collection.',
                            'parent_id' => $parentId,
                            'path' => $cat['slug'] . '/' . $subSlug,
                            'position' => $idx + 1,
                            'level' => 1,
                            'is_enabled' => 1,
                            'included_in_menu' => 1,
                            'banner_image' => $cat['banner'],
                            'category_image' => $cat['banner'],
                            'meta_title' => $subName . ' - MiniMart Showcase',
                            'meta_keywords' => strtolower($subName),
                            'meta_description' => 'Top rated ' . $subName . ' available now.',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        } catch (\Throwable $e) {
            $this->command->warn('Category seeder notice: ' . $e->getMessage());
        }
    }

    protected function setupProducts(): void
    {
        $this->command->info('5. Setting up Products & Showcase Images...');
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('products')) {
                return;
            }

            $productTypeId = DB::table('product_types')->value('id') ?? 1;

            $items = [
                [
                    'sku' => 'MM-IP15PM-BLK',
                    'name' => 'Apple iPhone 15 Pro Max 256GB',
                    'price' => 1199.00,
                    'special_price' => 1099.00,
                    'qty' => 45,
                    'cat_slug' => 'smartphones',
                    'img' => 'images/product_images/iphone15.svg',
                    'desc' => 'Titanium design with A17 Pro chip, 48MP main camera, and USB-C.'
                ],
                [
                    'sku' => 'MM-MBP16-M3',
                    'name' => 'Apple MacBook Pro 16" M3 Max',
                    'price' => 2499.00,
                    'special_price' => 2349.00,
                    'qty' => 20,
                    'cat_slug' => 'laptops-computers',
                    'img' => 'images/product_images/macbook.svg',
                    'desc' => 'Ultimate workstation with 36GB unified memory and Liquid Retina XDR.'
                ],
                [
                    'sku' => 'MM-SONY-WH5',
                    'name' => 'Sony WH-1000XM5 Wireless Headphones',
                    'price' => 399.00,
                    'special_price' => 349.00,
                    'qty' => 80,
                    'cat_slug' => 'audio-headphones',
                    'img' => 'images/product_images/headphones.svg',
                    'desc' => 'Industry-leading noise cancellation with 30-hour battery life.'
                ],
                [
                    'sku' => 'MM-AW-ULTRA2',
                    'name' => 'Apple Watch Ultra 2 GPS + Cellular',
                    'price' => 799.00,
                    'special_price' => 749.00,
                    'qty' => 35,
                    'cat_slug' => 'smart-wearables',
                    'img' => 'images/product_images/smartwatch.svg',
                    'desc' => 'Rugged titanium case with precision dual-frequency GPS.'
                ],
                [
                    'sku' => 'MM-CLOTH-SHIRT',
                    'name' => 'Slim Fit Oxford Cotton Shirt',
                    'price' => 59.00,
                    'special_price' => 49.00,
                    'qty' => 120,
                    'cat_slug' => 'mens-wear',
                    'img' => 'images/product_images/shirt.svg',
                    'desc' => '100% breathable Egyptian cotton with tailored modern slim fit.'
                ],
                [
                    'sku' => 'MM-CLOTH-DRESS',
                    'name' => 'Floral Elegance Summer Silk Dress',
                    'price' => 89.00,
                    'special_price' => 75.00,
                    'qty' => 65,
                    'cat_slug' => 'womens-collection',
                    'img' => 'images/product_images/dress.svg',
                    'desc' => 'Handcrafted lightweight floral print dress for casual & evening outings.'
                ],
                [
                    'sku' => 'MM-SHOE-AM270',
                    'name' => 'Nike Air Max 270 React Running Shoes',
                    'price' => 159.00,
                    'special_price' => 139.00,
                    'qty' => 90,
                    'cat_slug' => 'premium-footwear',
                    'img' => 'images/product_images/sneakers.svg',
                    'desc' => 'Iconic Air unit cushioning with responsive lightweight foam sole.'
                ],
                [
                    'sku' => 'MM-GROC-COFFEE',
                    'name' => 'Organic Arabica Dark Roast Coffee 1kg',
                    'price' => 24.50,
                    'special_price' => 21.00,
                    'qty' => 200,
                    'cat_slug' => 'artisan-coffee-tea',
                    'img' => 'images/product_images/coffee.svg',
                    'desc' => 'Ethically sourced single-origin coffee beans with rich chocolate notes.'
                ],
                [
                    'sku' => 'MM-GROC-OIL',
                    'name' => 'Extra Virgin Cold-Pressed Olive Oil 750ml',
                    'price' => 19.99,
                    'special_price' => 17.50,
                    'qty' => 150,
                    'cat_slug' => 'dairy-pantry-essentials',
                    'img' => 'images/product_images/olive_oil.svg',
                    'desc' => 'Mediterranean first cold-pressed extra virgin olive oil.'
                ],
                [
                    'sku' => 'MM-HOME-CHAIR',
                    'name' => 'Velvet Ergonomic Executive Chair',
                    'price' => 349.00,
                    'special_price' => 299.00,
                    'qty' => 25,
                    'cat_slug' => 'ergonomic-furniture',
                    'img' => 'images/product_images/chair.svg',
                    'desc' => 'Luxury velvet upholstery with high-density memory foam lumbar support.'
                ],
                [
                    'sku' => 'MM-HOME-COOK',
                    'name' => '10-Piece Stainless Steel Cookware Set',
                    'price' => 289.00,
                    'special_price' => 249.00,
                    'qty' => 30,
                    'cat_slug' => 'modern-kitchenware',
                    'img' => 'images/product_images/cookware.svg',
                    'desc' => 'Triple-ply professional induction pots and pans with tempered glass lids.'
                ],
                [
                    'sku' => 'MM-BEAU-SERUM',
                    'name' => 'Vitamin C + Hyaluronic Radiance Serum 50ml',
                    'price' => 38.00,
                    'special_price' => 32.00,
                    'qty' => 110,
                    'cat_slug' => 'premium-skincare',
                    'img' => 'images/product_images/serum.svg',
                    'desc' => 'Dermatologist tested anti-aging brightening serum with pure botanical extracts.'
                ],
            ];

            $productTypeId = DB::table('product_types')->where('name', 'simple')->value('id')
                          ?? DB::table('product_types')->value('id')
                          ?? 1;
            $imageTypeId = DB::table('product_image_types')->value('id') ?? 1;

            foreach ($items as $item) {
                try {
                    $existingId = DB::table('products')->where('sku', $item['sku'])->value('id');

                    $productData = [
                        'product_type_id' => $productTypeId,
                        'name' => $item['name'],
                        'sku' => $item['sku'],
                        'price' => $item['price'],
                        'quantity' => $item['qty'],
                        'status' => 'active',
                        'is_in_stock' => 1,
                        'url_key' => Str::slug($item['name']),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    if (\Illuminate\Support\Facades\Schema::hasColumn('products', 'special_price')) {
                        $productData['special_price'] = $item['special_price'];
                    }
                    if (\Illuminate\Support\Facades\Schema::hasColumn('products', 'special_price_from')) {
                        $productData['special_price_from'] = now()->subDays(10);
                        $productData['special_price_to'] = now()->addDays(30);
                    }

                    if ($existingId) {
                        DB::table('products')->where('id', $existingId)->update($productData);
                        $productId = $existingId;
                    } else {
                        $productId = DB::table('products')->insertGetId($productData);
                    }

                    // Product Images
                    if (\Illuminate\Support\Facades\Schema::hasTable('product_images')) {
                        try {
                            $hasImg = DB::table('product_images')->where('product_id', $productId)->first();
                            if (!$hasImg) {
                                DB::table('product_images')->insert([
                                    'product_id' => $productId,
                                    'image_type_id' => $imageTypeId,
                                    'image_url' => $item['img'],
                                    'is_default' => 1,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            }
                        } catch (\Throwable $e) {}
                    }

                    // Products Meta
                    if (\Illuminate\Support\Facades\Schema::hasTable('products_meta')) {
                        try {
                            DB::table('products_meta')->updateOrInsert(
                                ['product_id' => $productId, 'language_id' => 1],
                                [
                                    'description' => $item['desc'],
                                    'short_description' => $item['name'] . ' - MiniMart Guaranteed Quality.',
                                    'meta_title' => $item['name'] . ' - Buy Online',
                                    'meta_keyword' => strtolower(str_replace(' ', ',', $item['name'])),
                                    'meta_description' => $item['desc'],
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]
                            );
                        } catch (\Throwable $e) {}
                    }

                    // Link to category in category_products
                    if (\Illuminate\Support\Facades\Schema::hasTable('category_products') && \Illuminate\Support\Facades\Schema::hasTable('categories')) {
                        try {
                            $catId = DB::table('categories')->where('url_key', $item['cat_slug'])->value('id');
                            if (!$catId) {
                                $catId = DB::table('categories')->first()->id ?? 1;
                            }
                            DB::table('category_products')->updateOrInsert(
                                ['product_id' => $productId, 'category_id' => $catId],
                                ['created_at' => now(), 'updated_at' => now()]
                            );
                        } catch (\Throwable $e) {}
                    }
                } catch (\Throwable $e) {
                    $this->command->warn("Product seeder item error: " . $e->getMessage());
                }
            }
        } catch (\Throwable $e) {
            $this->command->warn('Products seeder notice: ' . $e->getMessage());
        }
    }

    protected function setupCustomers(): void
    {
        $this->command->info('6. Setting up Customers & Addresses...');
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('customers')) {
                return;
            }

            $customers = [
                ['first' => 'Alex', 'last' => 'Johnson', 'email' => 'alex.johnson@example.com', 'phone' => '+1 555-0192', 'city' => 'New York', 'state' => 'NY'],
                ['first' => 'Sarah', 'last' => 'Williams', 'email' => 'sarah.w@example.com', 'phone' => '+1 555-0143', 'city' => 'Los Angeles', 'state' => 'CA'],
                ['first' => 'Michael', 'last' => 'Brown', 'email' => 'mbrown@example.com', 'phone' => '+1 555-0187', 'city' => 'Chicago', 'state' => 'IL'],
                ['first' => 'Emily', 'last' => 'Davis', 'email' => 'emily.davis@example.com', 'phone' => '+1 555-0122', 'city' => 'Houston', 'state' => 'TX'],
                ['first' => 'David', 'last' => 'Martinez', 'email' => 'david.m@example.com', 'phone' => '+1 555-0165', 'city' => 'Phoenix', 'state' => 'AZ'],
                ['first' => 'Jessica', 'last' => 'Taylor', 'email' => 'jessica.t@example.com', 'phone' => '+1 555-0178', 'city' => 'Philadelphia', 'state' => 'PA'],
                ['first' => 'Daniel', 'last' => 'Anderson', 'email' => 'd.anderson@example.com', 'phone' => '+1 555-0134', 'city' => 'San Antonio', 'state' => 'TX'],
                ['first' => 'Sophia', 'last' => 'Thomas', 'email' => 'sophia.thomas@example.com', 'phone' => '+1 555-0199', 'city' => 'San Diego', 'state' => 'CA'],
                ['first' => 'James', 'last' => 'Jackson', 'email' => 'j.jackson@example.com', 'phone' => '+1 555-0111', 'city' => 'Dallas', 'state' => 'TX'],
                ['first' => 'Olivia', 'last' => 'White', 'email' => 'olivia.white@example.com', 'phone' => '+1 555-0155', 'city' => 'Austin', 'state' => 'TX'],
                ['first' => 'Liam', 'last' => 'Harris', 'email' => 'liam.h@example.com', 'phone' => '+1 555-0177', 'city' => 'Seattle', 'state' => 'WA'],
                ['first' => 'Emma', 'last' => 'Martin', 'email' => 'emma.martin@example.com', 'phone' => '+1 555-0188', 'city' => 'Denver', 'state' => 'CO'],
                ['first' => 'Noah', 'last' => 'Clark', 'email' => 'noah.clark@example.com', 'phone' => '+1 555-0166', 'city' => 'Boston', 'state' => 'MA'],
                ['first' => 'Ava', 'last' => 'Rodriguez', 'email' => 'ava.r@example.com', 'phone' => '+1 555-0144', 'city' => 'Miami', 'state' => 'FL'],
                ['first' => 'Lucas', 'last' => 'Lewis', 'email' => 'lucas.lewis@example.com', 'phone' => '+1 555-0123', 'city' => 'Atlanta', 'state' => 'GA'],
            ];

            foreach ($customers as $idx => $c) {
                try {
                    $code = 'CUST-' . str_pad($idx + 1, 4, '0', STR_PAD_LEFT);
                    $existing = DB::table('customers')->where('email', $c['email'])->first();

                    $custData = [
                        'customer_code' => $code,
                        'first_name' => $c['first'],
                        'last_name' => $c['last'],
                        'email' => $c['email'],
                        'phone' => $c['phone'],
                        'password' => Hash::make('password123'),
                        'is_active' => 1,
                        'created_at' => now()->subDays(rand(1, 120)),
                        'updated_at' => now(),
                    ];

                    if ($existing) {
                        DB::table('customers')->where('id', $existing->id)->update($custData);
                        $custId = $existing->id;
                    } else {
                        $custId = DB::table('customers')->insertGetId($custData);
                    }

                    // Address
                    if (\Illuminate\Support\Facades\Schema::hasTable('customer_addresses')) {
                        try {
                            DB::table('customer_addresses')->updateOrInsert(
                                ['customer_id' => $custId, 'type' => 'shipping'],
                                [
                                    'address_line1' => (100 + $idx * 15) . ' Commerce Avenue',
                                    'city' => $c['city'],
                                    'state' => $c['state'],
                                    'postal_code' => '90' . rand(100, 999),
                                    'country' => 'USA',
                                    'is_default' => 1,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]
                            );
                        } catch (\Throwable $e) {}
                    }
                } catch (\Throwable $e) {
                    $this->command->warn("Customer seeder item error: " . $e->getMessage());
                }
            }
        } catch (\Throwable $e) {
            $this->command->warn('Customer seeder notice: ' . $e->getMessage());
        }
    }

    protected function setupOrders(): void
    {
        $this->command->info('7. Setting up Orders (for Charts & Recent Activity)...');
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('orders')) {
                return;
            }

            $customerList = DB::table('customers')->get();
            if ($customerList->isEmpty()) {
                return;
            }

            $orderTemplates = [
                ['num' => 'ORD-2026-1001', 'total' => 1199.00, 'status' => 'completed', 'pay' => 'paid', 'ship' => 'Express Courier', 'days_ago' => 1],
                ['num' => 'ORD-2026-1002', 'total' => 399.00,  'status' => 'completed', 'pay' => 'paid', 'ship' => 'Standard Delivery', 'days_ago' => 2],
                ['num' => 'ORD-2026-1003', 'total' => 89.00,   'status' => 'processing', 'pay' => 'paid', 'ship' => 'Express Courier', 'days_ago' => 3],
                ['num' => 'ORD-2026-1004', 'total' => 2499.00, 'status' => 'completed', 'pay' => 'paid', 'ship' => 'White Glove Delivery', 'days_ago' => 5],
                ['num' => 'ORD-2026-1005', 'total' => 59.00,   'status' => 'pending', 'pay' => 'pending', 'ship' => 'Standard Delivery', 'days_ago' => 6],
                ['num' => 'ORD-2026-1006', 'total' => 799.00,  'status' => 'completed', 'pay' => 'paid', 'ship' => 'Express Courier', 'days_ago' => 8],
                ['num' => 'ORD-2026-1007', 'total' => 159.00,  'status' => 'completed', 'pay' => 'paid', 'ship' => 'Standard Delivery', 'days_ago' => 10],
                ['num' => 'ORD-2026-1008', 'total' => 38.00,   'status' => 'processing', 'pay' => 'paid', 'ship' => 'Standard Delivery', 'days_ago' => 12],
                ['num' => 'ORD-2026-1009', 'total' => 349.00,  'status' => 'completed', 'pay' => 'paid', 'ship' => 'Freight Delivery', 'days_ago' => 15],
                ['num' => 'ORD-2026-1010', 'total' => 44.50,   'status' => 'completed', 'pay' => 'paid', 'ship' => 'Express Courier', 'days_ago' => 20],
                ['num' => 'ORD-2026-1011', 'total' => 1299.00, 'status' => 'completed', 'pay' => 'paid', 'ship' => 'Express Courier', 'days_ago' => 35],
                ['num' => 'ORD-2026-1012', 'total' => 289.00,  'status' => 'completed', 'pay' => 'paid', 'ship' => 'Standard Delivery', 'days_ago' => 45],
                ['num' => 'ORD-2026-1013', 'total' => 179.00,  'status' => 'completed', 'pay' => 'paid', 'ship' => 'Standard Delivery', 'days_ago' => 60],
                ['num' => 'ORD-2026-1014', 'total' => 599.00,  'status' => 'completed', 'pay' => 'paid', 'ship' => 'Express Courier', 'days_ago' => 75],
                ['num' => 'ORD-2026-1015', 'total' => 95.00,   'status' => 'cancelled', 'pay' => 'refunded', 'ship' => 'Standard Delivery', 'days_ago' => 90],
                ['num' => 'ORD-2026-1016', 'total' => 849.00,  'status' => 'completed', 'pay' => 'paid', 'ship' => 'Express Courier', 'days_ago' => 105],
                ['num' => 'ORD-2026-1017', 'total' => 110.00,  'status' => 'completed', 'pay' => 'paid', 'ship' => 'Standard Delivery', 'days_ago' => 120],
                ['num' => 'ORD-2026-1018', 'total' => 420.00,  'status' => 'completed', 'pay' => 'paid', 'ship' => 'Express Courier', 'days_ago' => 140],
            ];

            foreach ($orderTemplates as $idx => $tmpl) {
                try {
                    $cust = $customerList[$idx % $customerList->count()];
                    $orderDate = now()->subDays($tmpl['days_ago']);

                    $orderData = [
                        'customer_id' => $cust->id,
                        'customer_code' => $cust->customer_code ?? ('CUST-' . $cust->id),
                        'first_name' => $cust->first_name ?? 'Showcase',
                        'last_name' => $cust->last_name ?? 'Customer',
                        'email' => $cust->email,
                        'phone' => $cust->phone ?? '+1 555-0100',
                        'order_status' => $tmpl['status'],
                        'payment_status' => $tmpl['pay'],
                        'shipping_method_name' => $tmpl['ship'],
                        'shipping_cost' => 15.00,
                        'is_active' => 1,
                        'guest_is_active' => 1,
                        'created_at' => $orderDate,
                        'updated_at' => $orderDate,
                    ];

                    if (\Illuminate\Support\Facades\Schema::hasColumn('orders', 'total')) {
                        $orderData['total'] = $tmpl['total'];
                    }

                    $existingOrder = DB::table('orders')->where('order_number', $tmpl['num'])->first();
                    if ($existingOrder) {
                        DB::table('orders')->where('id', $existingOrder->id)->update($orderData);
                        $orderId = $existingOrder->id;
                    } else {
                        $orderData['order_number'] = $tmpl['num'];
                        $orderId = DB::table('orders')->insertGetId($orderData);
                    }

                    // Order Items
                    if (\Illuminate\Support\Facades\Schema::hasTable('order_items')) {
                        try {
                            $hasItem = DB::table('order_items')->where('order_id', $orderId)->first();
                            if (!$hasItem) {
                                DB::table('order_items')->insert([
                                    'order_id' => $orderId,
                                    'product_sku' => 'MM-ITEM-' . ($idx + 1),
                                    'product_name' => 'Demo Order Item #' . ($idx + 1),
                                    'price' => $tmpl['total'],
                                    'quantity' => 1,
                                    'total' => $tmpl['total'],
                                    'product_status' => 'active',
                                    'created_at' => $orderDate,
                                    'updated_at' => $orderDate,
                                ]);
                            }
                        } catch (\Throwable $e) {}
                    }
                } catch (\Throwable $e) {
                    $this->command->warn("Order seeder item error: " . $e->getMessage());
                }
            }
        } catch (\Throwable $e) {
            $this->command->warn('Orders seeder notice: ' . $e->getMessage());
        }
    }

    protected function setupBannersAndMethods(): void
    {
        $this->command->info('8. Setting up Banners, Shipping & Payment Methods...');

        // Hero Banners
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('hero_banners')) {
                $banners = [
                    [
                        'title' => 'MiniMart Spring Mega Festival',
                        'subtitle' => 'Up to 50% Off Electronics & Home',
                        'description' => 'Discover flagship smartphones, high-end audio, and smart living essentials.',
                        'position' => 1,
                        'status' => 1,
                    ],
                    [
                        'title' => 'Fresh Groceries Delivered in 30 Mins',
                        'subtitle' => 'Farm Fresh Produce Guaranteed',
                        'description' => 'Handpicked organic fruits, artisan coffee, and daily dairy supplies.',
                        'position' => 2,
                        'status' => 1,
                    ],
                ];

                foreach ($banners as $b) {
                    DB::table('hero_banners')->updateOrInsert(['title' => $b['title']], array_merge($b, [
                        'created_at' => now(),
                        'updated_at' => now()
                    ]));
                }
            }
        } catch (\Throwable $e) {}

        // Shipping Methods
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('shipping_methods')) {
                $methods = [
                    ['code' => 'standard', 'name' => 'Standard Ground Shipping', 'cost' => 5.00],
                    ['code' => 'express', 'name' => 'Express Priority Courier', 'cost' => 15.00],
                    ['code' => 'same_day', 'name' => 'Same-Day Fast Delivery', 'cost' => 25.00],
                    ['code' => 'pickup', 'name' => 'Free In-Store Pickup', 'cost' => 0.00],
                ];
                foreach ($methods as $m) {
                    DB::table('shipping_methods')->updateOrInsert(['code' => $m['code']], [
                        'name' => $m['name'],
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        } catch (\Throwable $e) {}

        // Payment Methods
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('payment_methods')) {
                $payments = [
                    ['code' => 'stripe', 'name' => 'Credit / Debit Card (Stripe)'],
                    ['code' => 'paypal', 'name' => 'PayPal Express Checkout'],
                    ['code' => 'cod', 'name' => 'Cash on Delivery (COD)'],
                    ['code' => 'apple_pay', 'name' => 'Apple Pay / Google Pay'],
                ];
                foreach ($payments as $p) {
                    DB::table('payment_methods')->updateOrInsert(['code' => $p['code']], [
                        'name' => $p['name'],
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        } catch (\Throwable $e) {}
    }
}
