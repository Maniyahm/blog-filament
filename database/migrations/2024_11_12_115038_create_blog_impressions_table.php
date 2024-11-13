<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogImpressionsTable extends Migration
{
    public function up()
    {
        Schema::create('blog_impressions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); 
            $table->ipAddress('ip_address'); 
            $table->timestamp('viewed_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_impressions');
    }
}
