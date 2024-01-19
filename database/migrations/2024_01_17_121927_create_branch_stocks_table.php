<?php

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
        Schema::create('branch_stocks', function (Blueprint $table) {
            $table->id();
            $table->string("item");
            $table->string("description");
            $table->string("category");
            $table->string("cb01");
            $table->string("cb02");
            $table->string("cb05");
            $table->string("dl01");
            $table->string("dl02");
            $table->string("dl03");
            $table->string("dl04");
            $table->string("dl05");
            $table->string("gh01");
            $table->string("gj01");
            $table->string("gj02");
            $table->string("gj03");
            $table->string("gj04");
            $table->string("gj05");
            $table->string("id01");
            $table->string("id02");
            $table->string("id04");
            $table->string("jm01");
            $table->string("jm02");
            $table->string("jm04");
            $table->string("ka01");
            $table->string("ka02");
            $table->string("ka03");
            $table->string("ka04");
            $table->string("ka05");
            $table->string("kl01");
            $table->string("kl02");
            $table->string("kl03");
            $table->string("kl04");
            $table->string("kl05");
            $table->string("mh01");
            $table->string("mh02");
            $table->string("mh04");
            $table->string("mh05");
            $table->string("pn01");
            $table->string("pn02");
            $table->string("pn03");
            $table->string("pn04");
            $table->string("py01");
            $table->string("py02");
            $table->string("py03");
            $table->string("py04");
            $table->string("rd01");
            $table->string("rd02");
            $table->string("rd04");
            $table->string("tn01");
            $table->string("tn02");
            $table->string("tn03");
            $table->string("tn04");
            $table->string("tn05");
            $table->string("vd01");
            $table->string("vd04");
            $table->string("wb01");
            $table->string("wb02");
            $table->string("wb03");
            $table->string("wb04");
            $table->string("wb05");
            $table->string("grandtotal");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_stocks');
    }
};
