<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateDailyBlogViews extends Migration
{
    public function up()
    {
        DB::statement("
            CREATE VIEW daily_blog_views AS
            SELECT
                ROW_NUMBER() OVER (ORDER BY blog_id, DATE(viewed_at)) AS id, -- Unique ID for each row
                blog_id,
                DATE(viewed_at) AS view_date,
                COUNT(*) AS view_count
            FROM
                blog_impressions
            GROUP BY
                blog_id,
                DATE(viewed_at);

        ");
    }

    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS daily_blog_views");
    }
}
