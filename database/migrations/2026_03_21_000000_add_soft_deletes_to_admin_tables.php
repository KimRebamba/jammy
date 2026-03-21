<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tables that did not previously have soft deletes
        Schema::table('positions', function (Blueprint $table) {
            if (!Schema::hasColumn('positions', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('salaries', function (Blueprint $table) {
            if (!Schema::hasColumn('salaries', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('brands', function (Blueprint $table) {
            if (!Schema::hasColumn('brands', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('order_return', function (Blueprint $table) {
            if (!Schema::hasColumn('order_return', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('expenses', function (Blueprint $table) {
            if (!Schema::hasColumn('expenses', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('product_review', function (Blueprint $table) {
            if (!Schema::hasColumn('product_review', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            if (Schema::hasColumn('positions', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('salaries', function (Blueprint $table) {
            if (Schema::hasColumn('salaries', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('brands', function (Blueprint $table) {
            if (Schema::hasColumn('brands', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('order_return', function (Blueprint $table) {
            if (Schema::hasColumn('order_return', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('expenses', function (Blueprint $table) {
            if (Schema::hasColumn('expenses', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('product_review', function (Blueprint $table) {
            if (Schema::hasColumn('product_review', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
