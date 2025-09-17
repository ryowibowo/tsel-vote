    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            // Tabel ini cuma buat data orangnya
            Schema::create('voters', function (Blueprint $table) {
                $table->id();
                $table->string('full_name');
                $table->string('nik')->unique();
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('voters');
        }
    };
