<?php

use App\Models\Book;
use App\Models\BookIndex;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_indices', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Book::class, 'book_id')->constrained()->onDelete('Cascade');
            $table->foreignIdFor(BookIndex::class, 'index_id')->nullable()->constrained('book_indices')->onDelete('cascade');
            $table->string('title', 255);
            $table->integer('page', false, true)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_indices');
    }
};
