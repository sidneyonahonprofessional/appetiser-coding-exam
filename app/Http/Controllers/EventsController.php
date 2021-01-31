<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Events;
use App\Http\Resources\Events as EventsResource;
use App\Http\Resources\EventsCollection;

class EventsController extends Controller
{
    public function index()
    {
        return new EventsCollection(Events::all());
    }

    public function store(Request $request)
    {
        
        $events = Events::insert($request->all());

        return  new EventsCollection(Events::all());
    }
}
