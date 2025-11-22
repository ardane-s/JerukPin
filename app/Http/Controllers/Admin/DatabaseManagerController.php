<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class DatabaseManagerController extends Controller
{
    /**
     * Show the database manager dashboard
     */
    public function index()
    {
        // Get current database statistics
        $userCount = User::count();
        $productCount = Product::count();
        $categoryCount = Category::count();

        return view('admin.database.manager', compact('userCount', 'productCount', 'categoryCount'));
    }

    /**
     * Run the database seeder
     */
    public function seed(Request $request)
    {
        try {
            // Run the seeder
            Artisan::call('db:seed', [
                '--class' => 'RealJerukPinSeeder',
                '--force' => true
            ]);

            $output = Artisan::output();

            return redirect()
                ->route('admin.database.manager')
                ->with('success', 'Database seeded successfully! ' . $output);

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.database.manager')
                ->with('error', 'Error seeding database: ' . $e->getMessage());
        }
    }
}
