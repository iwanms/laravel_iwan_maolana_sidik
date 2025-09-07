<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Patient::select(['id', 'name', 'address', 'no_hp']);
            return DataTables::of($data)->make(true);
        }
    }
}
