<?php

namespace App\Http\Controllers;

use App\Services\BloodInventoryService;
use Illuminate\Http\Request;

class BloodInventoryController extends Controller
{
    protected $service;

    public function __construct(BloodInventoryService $service)
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

        return view('blood-inventory')->with([
            "data" => $data
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'blood_type'    => 'required|string',
            'quantity'      => 'required|string',
        ]);
        $this->service->create($validated);
        return redirect()->back()->with('success', 'Inventory Added Successfully!');
    }

    public function deduct(Request $request)
    {
        try {
            $validated = $request->validate([
                'blood_type'    => 'required|string',
                'quantity'      => 'required|string',
            ]);
            $this->service->deduct($validated);
            return redirect()->back()->with('success', 'Inventory Added Successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function showPerType(string $type, Request $request)
    {
        $data = $this->service->showPerType($type);
        if ($request->sort == 'newest') {
            $data = collect($data)->sortByDesc(function ($item) {
                return $item->created_at;
            })->values();
        }

        if ($request->sort == 'oldest') {
            $data = collect($data)->sortBy(function ($item) {
                return $item->created_at;
            })->values();
        }

        return view('blood-inventory-per-type')->with([
            "data" => $data
        ]);
    }
}
