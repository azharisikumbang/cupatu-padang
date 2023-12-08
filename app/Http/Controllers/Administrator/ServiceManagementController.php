<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('administrator.service.index', [
            'services' => $request->has('cari') 
            ? Service::where('name', 'like', "%{$request->get('cari')}%")->orderBy('name', 'asc')->paginate(10)->toArray()
            : Service::orderBy('name', 'asc')->paginate(10)->toArray()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('administrator.service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $validated = $request->validated();

        Service::create($validated);

        return redirect()
            ->route('administrator.services.index')
            ->with('status', "Layanan: '{$validated['name']}' berhasil ditambahkan.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('administrator.service.edit', [
            'service' => $service->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreServiceRequest $request, Service $service)
    {
        $validated = $request->validated();
        $service->update($validated);

        return redirect()
            ->route('administrator.services.index')
            ->with('status', "Layanan: '{$service->name}' telah diperbaharui.")
            ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('administrator.services.index')
            ->with('status', "Layanan: '{$service->name}' telah dihapus.")
            ;
    }
}
