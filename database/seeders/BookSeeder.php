<?php
    namespace Database\Seeders;
    use Illuminate\Database\Seeder;
    use App\Models\User;
    Use DB;
    class BookSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {

            DB::table('libri')->insert( [
                [
                    'nome_libro'=>'Things Fall Apart',
                    'descrizione_libro'=>'<a target="_blank" href="https://en.wikipedia.org/wiki/Things_Fall_Apart">https://en.wikipedia.org/wiki/Things_Fall_Apart</a>',
                    'url_foto'=> "https://www.liofilchemstore.it/test/images/things-fall-apart.jpg",
                    'prezzo'=> 120.80,
                ],
                [
                    'nome_libro'=>'Fairy tales',
                    'descrizione_libro'=>'<a target="_blank" href="https://en.wikipedia.org/wiki/Fairy_Tales_Told_for_Children._First_Collection">https://en.wikipedia.org/wiki/Fairy_Tales_Told_for_Children._First_Collection</a>',
                    'url_foto'=> "https://www.liofilchemstore.it/test/images/fairy-tales.jpg",
                    'prezzo'=> 99.50,
                 ],
                 [
                    'nome_libro'=>'The Divine Comedy',
                    'descrizione_libro'=>'<a target="_blank" href="https://en.wikipedia.org/wiki/Divine_Comedy">https://en.wikipedia.org/wiki/Divine_Comedy</a>',
                    'url_foto'=> "https://www.liofilchemstore.it/test/images/the-divine-comedy.jpg",
                    'prezzo'=> 33.40,
                 ],                 

            ]);
        }
    }
?>