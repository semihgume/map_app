<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LocationService;

class LocationController extends Controller {
    
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function index()
    {
        $locations = $this->locationService->getAllLocations();
        return view('locations.index', compact('locations'));
    }

    public function show($id)
    { 
        $location = $this->locationService->getLocationById($id);
        return view('locations.show', compact('location'));
    }

    public function store(Request $request) 
    {
        $data = $request->only('name', 'latitude', 'longitude', 'hex_color');
        $location = $this->locationService->createLocation($data);
        return redirect()->route('locations.index')->with('success', 'Location created successfully!');
    }

    public function update(Request $request, $id)
    { 
        $data = $request->only('name', 'latitude', 'longitude', 'hex_color');
        $location = $this->locationService->updateLocation($id, $data);
        return view('locations.show', compact('location'));
    }

    public function create()
    {
        return view('locations.create');
    }

    public function edit($id)
    {
        $location = $this->locationService->getLocationById($id);
        return view('locations.edit', compact('location'));
    }
}