<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    
 
    public function select2(Request $request)
    {
        $q = $request->q;

        $users = Driver::select('id', DB::raw('concat(first_name, " ", last_name, " - ", phone) as text'))
            ->where('id', 'like', "%$q%")
            ->orWhere('email', 'like', "%$q%")
            ->orWhere('first_name', 'like', "%$q%")
            ->orWhere('last_name', 'like', "%$q%")
            ->orWhere('phone', 'like', "%$q%")
            ->paginate();

        return $users;
    }
}
