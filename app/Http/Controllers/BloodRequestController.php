<?php

namespace App\Http\Controllers;

use App\Services\BloodRequestService;
use Illuminate\Http\Request;

class BloodRequestController extends Controller
{
    protected $service;

    public function __construct(BloodRequestService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
{
    $data = $this->service->getAll();

    if ($request->sort == 'newest') {
        $data = collect($data)->sortByDesc(function ($item) {
            return $item->request_date;
        })->values();
    }

    if ($request->sort == 'oldest') {
        $data = collect($data)->sortBy(function ($item) {
            return $item->request_date;
        })->values();
    }

    return view('blood-requests')->with([
        "data" => $data
    ]);
}

    public function show($id)
    {
        $request = $this->service->getById($id);
        return response()->json($request);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'blood_type'    => 'required|string',
            'quantity'      => 'required|string',
            'urgency_lvl'   => 'required|string',
        ]);
        $this->service->create($validated);
        return redirect()->back()->with('success', 'Request Created Successfully!');
    }

    public function fulfill($id)
    {
        $this->service->fulfill($id);
        return redirect()->back()->with('success', 'Fulfilled Blood Request Successfully!');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'date' => 'sometimes|date',
            'location' => 'sometimes|string',
            'notes' => 'nullable|string',
            'status' => 'sometimes|string',
            'scheduled_date' => 'nullable|date',
        ]);

        $request = $this->service->update($id, $data);
        return response()->json($request);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
