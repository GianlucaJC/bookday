<?php
    namespace Database\Seeders;
    use Illuminate\Database\Seeder;
    use App\Models\User;
    Use DB;
    class PreferSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {

            DB::table('preferiti')->insert( [
                [
                    'id_libro'=>2,
                    'id_utente'=>2,
                ],

            ]);
        }
    }
?>