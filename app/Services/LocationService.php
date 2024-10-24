<?php

namespace App\Services;

use App\Repositories\LocationRepository;
use App\Validators\LocationValidator;

class LocationService {

    protected $locationRepository;
    protected $locationValidator;

    public function __construct(LocationRepository $locationRepository, LocationValidator $locationValidator)
    {
        $this->locationRepository = $locationRepository;
        $this->locationValidator = $locationValidator;
    }

    public function getAllLocations()
    {
        return $this->locationRepository->getAll();
    }

    public function getLocationById($id)
    {
        return $this->locationRepository->getById($id);
    }

    public function createLocation(array $data) 
    {
        $this->locationValidator->validate($data);
        return $this->locationRepository->create($data);
    }

    public function updateLocation($id, array $data)
    {
        $this->locationValidator->validate($data);
        return $this->locationRepository->update($id, $data);
    }

}