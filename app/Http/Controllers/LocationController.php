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
        return response()->json($locations);
    }

    public function show($id)
    { 
        $location = $this->locationService->getLocationById($id);
        return response()->json($location);
    }

    public function store(Request $request) 
    {
        $data = $request->only('name', 'latitude', 'longitude', 'hex_color');
        $location = $this->locationService->createLocation($data);
        return response()->json($location, 201);
    }

    public function create()
    {
        return view('welcome');
    }
}