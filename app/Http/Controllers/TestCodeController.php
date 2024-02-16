<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\TestCode;
use Illuminate\Support\Facades\Hash;

class TestCodeController extends Controller
{  
    public function getTestCodes(){
        // $testCodes = TestCode::paginate(10);
        // $testCodes = TestCode::paginate(9);
        // return response()->json([
        //     'testCodes' => $testCodes
        // ]);
        $perPage = 9;
        $testCodes = TestCode::paginate($perPage);

        return response()->json([
            'testCodes' => $testCodes,
            'currentPage' => $testCodes->currentPage(),
            'lastPage' => $testCodes->lastPage(),
        ]);
    }
}
