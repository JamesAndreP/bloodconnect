<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HospitalService;
use Illuminate\Support\Facades\Validator;

class HospitalController extends Controller
{
    protected $hospitalService;

    public function __construct(HospitalService $hospitalService)
    {
        $this->hospitalService = $hospitalService;
    }


    public function index()
    {
        return view('hospital-management')->with([
            "data" => $this->hospitalService->getAll()
        ]);
    }

    public function show($id)
    {
        return response()->json($this->hospitalService->findById($id));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
    'hospital_name' => 'required|string|max:255',
    'hospital_location' => 'required|string|max:255',

    'user_name' => 'required|string|max:255',
    'user_email' => 'required|email|unique:users,email',
    'user_password' => 'required|string|min:6',
    'user_phone' => 'required|string',
]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // passes error bag
                ->withInput(); // keeps old input
        }

        $this->hospitalService->createHospitalWithUser($validator->validated());

        return redirect()->back()->with('success', 'Hospital and User created successfully!');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'hospital_id' => 'required|string',
            'hospital_name' => 'required|string|max:255',
            'hospital_location' => 'required|string|max:255',

            'user_name' => 'required|string|max:255',
            'user_email' => 'required|email|unique:users,email,' . $request->user_id . ',id',
            'user_password' => 'nullable|string|min:6',
            'user_birth_date' => 'nullable|date',
'user_gender' => 'nullable|string',
            'user_phone' => 'required|string',
            'user_status' => 'required|string',
            'user_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // passes error bag
                ->withInput(); // keeps old input
        }

        $this->hospitalService->updateHospitalWithUser($validator->validated());

        return redirect()->back()->with('success', 'Hospital and User updated successfully!');
    }

    public function delete(int $id)
    {
        $this->hospitalService->delete($id);

        return redirect()->back()->with('success', 'Hospital and User deleted successfully!');
    }
}
