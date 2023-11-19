<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]); 
        DB::table('pdps')->insert(['idpdps'=>1,'nompdp'=>'PDP Cochabamba']);
        DB::table('pdps')->insert(['idpdps'=>2,'nompdp'=>'PDP El alto']);
        DB::table('pdps')->insert(['idpdps'=>3,'nompdp'=>'PDP Ivirgarzama']);
        DB::table('pdps')->insert(['idpdps'=>4,'nompdp'=>'PDP Murillo']);

        DB::table('departamentos')->insert(['iddepartamento'=>1,'nomdepartamento'=>'La Paz','abrvdep'=>'LP']);
        DB::table('departamentos')->insert(['iddepartamento'=>2,'nomdepartamento'=>'Cochabamba','abrvdep'=>'CB']);
        DB::table('departamentos')->insert(['iddepartamento'=>3,'nomdepartamento'=>'Chuquisaca','abrvdep'=>'CH']); 
        DB::table('departamentos')->insert(['iddepartamento'=>4,'nomdepartamento'=>'Oruro','abrvdep'=>'OR']);
        DB::table('departamentos')->insert(['iddepartamento'=>5,'nomdepartamento'=>'Potosí','abrvdep'=>'PT']);
        DB::table('departamentos')->insert(['iddepartamento'=>6,'nomdepartamento'=>'Tarija','abrvdep'=>'TJ']);
        DB::table('departamentos')->insert(['iddepartamento'=>7,'nomdepartamento'=>'Santa Cruz','abrvdep'=>'SC']);
        DB::table('departamentos')->insert(['iddepartamento'=>8,'nomdepartamento'=>'Beni','abrvdep'=>'BN']);
        DB::table('departamentos')->insert(['iddepartamento'=>9,'nomdepartamento'=>'Pando','abrvdep'=>'PD']);

        $user = new \App\Models\User(); 
        $user->name = 'Administrador'; 
        $user->rol = 0; 
        $user->email = 'admin@hotmail.com';
        $user->password = bcrypt('admin');
        $user->save();
    }
}
