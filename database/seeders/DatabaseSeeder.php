<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Client Officine (Compte normal)
        User::create([
            'name' => 'Pharmacie Centrale',
            'email' => 'client@medico.com',
            'password' => Hash::make('password123'),
            'client_type' => 'officine',
            'credit_limit' => 10000.00,
            'current_encours' => 2500.00,
            'has_unpaid_bills' => false,
        ]);

        // 2. Client Bloqué (Dépassement d'encours)
        User::create([
            'name' => 'Pharmacie du Marché',
            'email' => 'bloque@medico.com',
            'password' => Hash::make('password123'),
            'client_type' => 'officine',
            'credit_limit' => 5000.00,
            'current_encours' => 6200.00,
            'has_unpaid_bills' => true,
        ]);

        // 3. Produit de test 1 avec ses images
        $p1 = Product::create([
            'sku' => 'MED-PAR-500',
            'name' => 'Paracétamol Medico 500mg',
            'active_molecule' => 'Paracétamol',
            'price_ttc' => 2.50,
            'backup_stock' => 150,
            'max_order_limit' => 50,
        ]);

        ProductImage::create([
            'product_id' => $p1->id,
            'url' => 'https://via.placeholder.com/600x600.png?text=Paracetamol+Boite',
            'is_main' => true,
            'sort_order' => 1,
        ]);

        ProductImage::create([
            'product_id' => $p1->id,
            'url' => 'https://via.placeholder.com/600x600.png?text=Paracetamol+Dos',
            'is_main' => false,
            'sort_order' => 2,
        ]);

        // 4. Produit de test 2
        $p2 = Product::create([
            'sku' => 'MED-IBU-400',
            'name' => 'Ibuprofène Medico 400mg',
            'active_molecule' => 'Ibuprofène',
            'price_ttc' => 4.20,
            'backup_stock' => 80,
            'max_order_limit' => 30,
        ]);

        ProductImage::create([
            'product_id' => $p2->id,
            'url' => 'https://via.placeholder.com/600x600.png?text=Ibuprofene+Boite',
            'is_main' => true,
            'sort_order' => 1,
        ]);
    }
}