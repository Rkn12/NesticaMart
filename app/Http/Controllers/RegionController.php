<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegionController extends Controller
{
    public function provinces(Request $request)
    {
        $search = $request->query('q');
        $query = DB::table('indonesia_regions')
            ->whereRaw('LENGTH(code) = 2')
            ->orderBy('name');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $provinces = $query->get(['code', 'name']);

        return response()->json($provinces);
    }

    public function regencies(Request $request, $provinceCode)
    {
        $search = $request->query('q');
        $query = DB::table('indonesia_regions')
            ->whereRaw('LENGTH(code) = 5')
            ->where('code', 'like', "{$provinceCode}.%")
            ->orderBy('name');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $regencies = $query->get(['code', 'name']);

        return response()->json($regencies);
    }

    public function districts(Request $request, $regencyCode)
    {
        $search = $request->query('q');
        $query = DB::table('indonesia_regions')
            ->whereRaw('LENGTH(code) = 8')
            ->where('code', 'like', "{$regencyCode}.%")
            ->orderBy('name');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $districts = $query->get(['code', 'name']);

        return response()->json($districts);
    }

    public function villages(Request $request, $districtCode)
    {
        $search = $request->query('q');
        $query = DB::table('indonesia_regions')
            ->whereRaw('LENGTH(code) = 13')
            ->where('code', 'like', "{$districtCode}.%")
            ->orderBy('name');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $villages = $query->get(['code', 'name']);

        return response()->json($villages);
    }
}
