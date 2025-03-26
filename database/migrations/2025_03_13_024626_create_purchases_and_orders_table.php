<?php

use App\Models\Node;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('state', 30);
            $table->date('deadline');
            
            $table->foreignIdFor(Node::class)
                ->constrained()
                ->onDelete('cascade');

            $table->foreignIdFor(Provider::class)
                ->constrained()
                ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            $table->foreignIdFor(Purchase::class)
                ->constrained()
                ->onDelete('cascade');
            $table->foreignIdFor(User::class);

            $table->integer('packages')->nullable();
            // In Kg
            $table->decimal('weight', 8, 3)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Product::class);
            $table->decimal('quantity', 7, 2);
            $table->decimal('price', 7, 2);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases_and_orders');
    }
};
