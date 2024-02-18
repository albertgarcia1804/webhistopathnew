<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TestCodeController;
use App\Http\Controllers\TestGroupController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Authentication
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->get('/user/role', [AuthController::class, 'getUserRole']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// Test Codes
Route::middleware('auth:sanctum')->get('/get_test_codes', [TestCodeController::class, 'getTestCodes']);
Route::middleware('auth:sanctum')->get('/get_test_code_details/{id}', [TestCodeController::class, 'getTestCodeDetails']);
Route::middleware('auth:sanctum')->put('/update_test_code_details/{id}', [TestCodeController::class, 'updateTestCodeDetails']);
Route::middleware('auth:sanctum')->post('/add_test_code', [TestCodeController::class, 'addTestCode']);
Route::middleware('auth:sanctum')->delete('/delete_test_code/{id}', [TestCodeController::class, 'delete']);

// Test Groups
// Route::middleware('auth:sanctum')->get('/get_test_groups', [TestGroupController::class, 'getTestGroups']);
// Route::middleware('auth:sanctum')->get('/get_test_group_details/{id}', [TestGroupController::class, 'getTestGroupDetails']);
// Route::middleware('auth:sanctum')->put('/update_test_group_details/{id}', [TestGroupController::class, 'updateTestGroupDetails']);
// Route::middleware('auth:sanctum')->post('/add_test_group', [TestGroupController::class, 'addTestGroup']);
// Route::middleware('auth:sanctum')->delete('/delete_test_group/{id}', [TestGroupController::class, 'delete']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
