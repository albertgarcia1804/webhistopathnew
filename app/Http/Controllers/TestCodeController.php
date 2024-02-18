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
        $testCodes = TestCode::paginate(12);
        return response()->json([
            'testCodes' => $testCodes
        ]);
    }

    public function getTestCodeDetails($id){
        // Retrieve test code details by ID
        $testCode = TestCode::find($id);

        if (!$testCode) {
            return response()->json(['error' => 'Test code not found'], 404);
        }

        return response()->json(['testCode' => $testCode]);
    }

    public function addTestCode(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'admin_display_name' => 'required',
            'short_code' => 'required',
            'enabled' => 'required|boolean',
            'type' => 'required',
            'reference_range' =>'required',
            'unit' => 'required',
            'conventional_reference_range' => 'required',
            'conventional_unit' => 'required',
            'specimen_type_id' => 'required',
            'price' => 'required',
        ]);

        $testCode = TestCode::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'Test code added successfully',
            'testCode' => $testCode
        ], 201);
    }

    public function updateTestCodeDetails(Request $request, $id){
        $testCode = TestCode::find($id);

        if (!$testCode) {
            return response()->json(['error' => 'Test code not found'], 404);
        }
        $testCode->update($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Test code updated successfully',
            'testCode' => $testCode
        ]);
    
    }

    public function delete($id)
    {
        try {
            // Logic to delete the test code with the given ID from your database
            $testCode = TestCode::findOrFail($id);
            $testCode->delete();

            return response()->json(['status' => 'success', 'message' => 'Test code deleted successfully']);
        } catch (\Exception $e) {
            \Log::error('Error deleting test code: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Internal server error'], 500);
        }
    }
}
