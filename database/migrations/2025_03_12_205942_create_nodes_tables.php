<?php

use App\Models\Node;
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
        Schema::create('nodes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);

            $table->foreignIdFor(User::class);
            // consumers
            // providers
            // purchases
            
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('nodes_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Node::class);
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('nodes');
        Schema::drop('nodes_users');
    }
};
