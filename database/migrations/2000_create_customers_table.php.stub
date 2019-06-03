<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('birthday')->nullable();
            $table->string('phone_number')->nullable();
            $table->enum('gender', [
                'agender',
                'androgyne',
                'androgynous',
                'bigender',
                'cis',
                'cisgender',
                'cis-female',
                'cis-male',
                'cis-man',
                'cis-woman',
                'cisgender-female',
                'cisgender-male',
                'cisgender-man',
                'cisgender-woman',
                'female-to-male',
                'ftm',
                'gender-fluid',
                'gender-nonconforming',
                'gender-questioning',
                'gender-variant',
                'genderqueer',
                'intersex',
                'male-to-female',
                'mtf',
                'neither',
                'neutrois',
                'non-binary',
                'other',
                'pangender',
                'trans',
                'trans-female',
                'trans-male',
                'trans-man',
                'trans-person',
                'trans-woman',
                'transfeminine',
                'transgender',
                'transgender-female',
                'transgender-male',
                'transgender-man',
                'transgender-person',
                'transgender-woman',
                'transmasculine',
                'transsexual',
                'transsexual-female',
                'transsexual-male',
                'transsexual-man',
                'transsexual-person',
                'transsexual-woman',
                'two-spirit',
            ])->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
