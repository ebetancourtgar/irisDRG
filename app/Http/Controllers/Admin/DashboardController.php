<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Brand;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $branchesCount = Branch::orderBy('created_at', 'desc')->count();
        $brandsCount = Brand::orderBy('created_at', 'desc')->count();
        $categoriesCount = Category::orderBy('created_at', 'desc')->count();
        $stats = [
            'branches' => $branchesCount,
            'brands' => $brandsCount,
            'categories' => $categoriesCount,
        ];

        return view('admin/dashboard.index', compact('branchesCount', 'brandsCount', 'categoriesCount', 'stats'));
    }
}
