<?php
    namespace Database\Seeders;
    use Illuminate\Database\Seeder;
    use App\Models\User;
    Use DB;
    class UserSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {

            DB::table('users')->insert( [
                [
                        'name'=>'admin',
                        'email'=>'morescogianluca@gmail.com',
                        'password'=> bcrypt('Parsifal1973@'),
                        'isadmin'=> 1,
                ],
                [
                        'name'=>'marco',
                        'email'=>'marco.bertini@khtwaters.com',
                        'password'=> bcrypt('Moon1973@'),
                        'isadmin'=> 0,
                ]
            ]);
        }
    }
?>