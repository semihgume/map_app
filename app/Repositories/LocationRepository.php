<?php

namespace App\Repositories;

use App\Models\Location;

class LocationRepository {

    public function getAll()
    {
        return Location::all();
    }

    public function getById($id)
    {
        return Location::find($id);
    }

    public function create(array $data)
    {
        return Location::create($data);
    }

    public function update()
    {

    }

    public function delete()
    {

    }
}