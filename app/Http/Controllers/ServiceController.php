<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Http\Requests\StoreServiceRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Service::class);
        $user = Auth::user();

        
        if ($user->hasRole('Tecnico')) {
            $services = Service::with(['branch', 'technician'])
                        ->where('technician_id', $user->id)
                        ->orderBy('scheduled_at', 'asc')
                        ->paginate(10);
        } else {
            $services = Service::with(['branch', 'technician'])
                        ->orderBy('scheduled_at', 'asc')
                        ->paginate(10);
        }

        return view('services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Service::class);
        $branches = Branch::where('is_active', true)->get();
        
        $technicians = User::role('Tecnico')->with('branch')->get();

        return view('services.create', compact('branches', 'technicians'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        Gate::authorize('create', Service::class);
        Service::create([
            'title' => $request->title,
            'description' => $request->description,
            'service_type' => $request->service_type,
            'scheduled_at' => $request->scheduled_at,
            'branch_id' => $request->branch_id,
            'technician_id' => $request->technician_id,
            'created_by' => Auth::id(), 
            'status' => 'pendiente'
        ]);
        return redirect()->route('services.index')->with('success', 'Servicio programado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        Gate::authorize('view', $service);
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        Gate::authorize('update', $service);
        $branches = Branch::where('is_active', true)->get();
        $technicians = User::role('Tecnico')->get();
        
        return view('services.edit', compact('service', 'branches', 'technicians'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        Gate::authorize('update', $service);
        $service->update($request->validated());
        return redirect()->route('services.index')->with('success', 'Servicio actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        Gate::authorize('delete', $service);
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Servicio eliminado/cancelado.');
    }

    public function startService(Service $service)
    {
        Gate::authorize('update', $service);

        $service->update([
            'status' => 'en_proceso',
            'started_at' => now(), // Captura fecha y hora actual
        ]);

        return redirect()->back()->with('success', 'Servicio iniciado. El reloj está corriendo.');
    }

    public function finishService(Service $service)
    {
        Gate::authorize('update', $service);

        $service->update([
            'status' => 'finalizado',
            'finished_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Servicio finalizado exitosamente.');
    }
}
