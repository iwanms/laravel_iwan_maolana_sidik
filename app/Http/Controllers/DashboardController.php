<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Hospital;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::all();
        return view('dashboard', compact('hospitals'));
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Patient::with('hospital')->select('patients.*');

            return DataTables::of($data)
                ->addColumn('hospital_name', function ($row) {
                    return $row->hospital ? $row->hospital->name : '-';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-primary edit-btn"
                            data-id="'.$row->id.'"
                            data-name="'.$row->name.'"
                            data-address="'.$row->address.'"
                            data-no_hp="'.$row->no_hp.'"
                            data-hospital_id="'.$row->hospital_id.'"
                            data-bs-toggle="modal"
                            data-bs-target="#modalEditPasien">
                            Edit
                        </button>
                        <button class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">
                            Hapus
                        </button>
                    ';
                })
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'no_hp' => 'required',
            'hospital_id' => 'required|exists:hospitals,id',
        ]);

        Patient::create([
            'name' => $request->name,
            'address' => $request->address,
            'no_hp' => $request->no_hp,
            'hospital_id' => $request->hospital_id,
        ]);

        return redirect()->route('dashboard')->with('success', 'Data pasien berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'no_hp' => 'required',
            'hospital_id' => 'required|exists:hospitals,id',
        ]);

        $pasien = Patient::findOrFail($id);
        $pasien->update([
            'name' => $request->name,
            'address' => $request->address,
            'no_hp' => $request->no_hp,
            'hospital_id' => $request->hospital_id,
        ]);

        return response()->json(['success' => 'Data pasien berhasil diupdate']);
    }

    public function destroy($id)
    {
        $pasien = Patient::findOrFail($id);
        $pasien->delete();

        return response()->json(['success' => 'Data pasien berhasil dihapus']);
    }

}
