<?php
use Laravel\Cart;
use Laravel\Category;
use Laravel\CategoryProduct;
use Laravel\Order;
use Laravel\OrderProduct;
use Laravel\Product;
use Laravel\User;
use Laravel\PaymentKey;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	// Clear table
        Schema::disableForeignKeyConstraints();
        OrderProduct::truncate();
        CategoryProduct::truncate();
        Order::truncate();
        Cart::truncate();
        Product::truncate();
        Category::truncate();
        User::truncate();
        PaymentKey::truncate();
        Schema::enableForeignKeyConstraints();

        // User
    	$guest = User::create([
    		'name' => 'guest',
    		'email' => 'guest@kopiqu.com',
    		'password' => bcrypt('password')
    	]);
    	$admin = User::create([
    		'name' => 'admin',
    		'role' => 'ORDER_PROCESSOR',
    		'email' => 'order@kopiqu.com',
    		'password' => bcrypt('password')
    	]);
    	$inventory = User::create([
    		'name' => 'admin',
    		'role' => 'INVENTORY_MANAGER',
    		'email' => 'inventory@kopiqu.com',
    		'password' => bcrypt('password')
    	]);
    	$operation = User::create([
    		'name' => 'admin',
    		'role' => 'OPERATION_MANAGER',
    		'email' => 'operation@kopiqu.com',
    		'password' => bcrypt('password')
    	]);

    	//Category
		$arabica = Category::create(['name' => 'arabica']);
		$robusta = Category::create(['name' => 'robusta']);
		$bean = Category::create(['name' => 'bean']);
		$powder = Category::create(['name' => 'powder']);
		$toraja = Category::create(['name' => 'toraja']);
		$java = Category::create(['name' => 'java', 'parent_id' => $arabica->id]);
		$aceh = Category::create(['name' => 'aceh', 'parent_id' => $arabica->id]);
		$vietnam = Category::create(['name' => 'vietnam', 'parent_id' => $robusta->id]);
		$luwak =  Category::create(['name' => 'luwak', 'parent_id' => $robusta->id]);

    	// Products
		$torajabean1 = Product::create([
            'name' => 'Toraja Bean Small',
            'description' => 'Toraja Bean Desc',
            'stock' => 100,
            'price' => 30000,
            'weight' => 0.5,
            'filepath' => 'toraja_bean_small.jpg'
        ]);
		$torajabean2 = Product::create([
            'name' => 'Toraja Bean Big',
            'description' => 'Toraja Bean Desc',
            'stock' => 100,
            'price' => 60000,
            'weight' => 1,
            'filepath' => 'toraja_bean_big.jpg'
        ]);
		$torajapowder1 = Product::create([
            'name' => 'Toraja Powder Small',
            'description' => 'Toraja Powder Desc',
            'stock' => 100,
            'price' => 25000,
            'weight' => 0.5,
            'filepath' => 'toraja_powder_small.jpg'
        ]);
		$luwakpowder1 = Product::create([
            'name' => 'Luwak Powder Small',
            'description' => 'Luwak Powder Desc',
            'stock' => 100,
            'price' => 40000,
            'weight' => 0.25,
            'filepath' => 'luwak_powder_small.jpg'
        ]);

        //CategoryProduct
        $cp11 = CategoryProduct::create(['category_id' => $toraja->id, 'product_id' => $torajabean1->id]);
        $cp12 = CategoryProduct::create(['category_id' => $bean->id, 'product_id' => $torajabean1->id]);
        $cp21 = CategoryProduct::create(['category_id' => $toraja->id, 'product_id' => $torajabean2->id]);
         $cp22 = CategoryProduct::create(['category_id' => $bean->id, 'product_id' => $torajabean2->id]);
        $cp31 = CategoryProduct::create(['category_id' => $toraja->id, 'product_id' => $torajapowder1->id]);
        $cp32 = CategoryProduct::create(['category_id' => $powder->id, 'product_id' => $torajapowder1->id]);
        $cp41 = CategoryProduct::create(['category_id' => $luwak->id, 'product_id' => $luwakpowder1->id]);
        $cp42 = CategoryProduct::create(['category_id' => $powder->id, 'product_id' => $luwakpowder1->id]);

        // Cart
        $cart1 = Cart::create(['user_id' => $guest->id, 'product_id' => $luwakpowder1->id, 'quantity' => 2]);
        $cart2 = Cart::create(['user_id' => $guest->id, 'product_id' => $torajabean2->id, 'quantity' => 3]);

        // Order
	    $order1 = Order::create(['status' => 'PENDING', 'user_id' => $guest->id, 'address' => 'Jl. Dago no 22', 'payment_key'=>111]);
        
        //PaymentKey 
        for ($i = 0; $i < 1000; $i++) {
            PaymentKey::create(['key'=>$i,'used'=>0]);
        } 

        //OrderProduct
        $op11 = OrderProduct::create(['order_id' => $order1->id, 'product_id' => $torajapowder1->id, 'quantity' => 4, 'total_price' => $torajapowder1->price * 4, 'total_weight' => $torajapowder1->weight * 4]);
        $op12 = OrderProduct::create(['order_id' => $order1->id, 'product_id' => $luwakpowder1->id, 'quantity' => 3, 'total_price' => $luwakpowder1->price * 3, 'total_weight' => $luwakpowder1->weight * 3]);

        $ops = $order1->order_products();
        $total_price = 0;
        $total_weight = 0;
		foreach ($ops as $op){
            $total_price += $op->total_price;
            $total_weight += $op->total_weight;
        }
        $shipping_fee = $total_weight*5000;
        $order1->update([
            'total_price' => $total_price,
            'total_weight' => $total_weight,
            'shipping_fee' => $shipping_fee,
            'total_payment' => $total_price + $shipping_fee - $order1->payment_key,
        ]);

    }
}
