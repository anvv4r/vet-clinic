<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\View\View;
use App\Http\Requests\PetStoreRequest;
use App\Http\Requests\PetUpdateRequest;
use Illuminate\Http\RedirectResponse;


class PetController extends Controller
{
    public function index(): View
    {
        $pets = Pet::latest()->paginate(5);

        return view('pets.index', compact('pets'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PetStoreRequest $request): RedirectResponse
    {
        Pet::create($request->validated());

        return redirect()->route('pets.index')
            ->with('success', 'Pet submit successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet): View
    {
        return view('pets.show', compact('pet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet): View
    {
        return view('pets.edit', compact('pet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PetUpdateRequest $request, Pet $pet): RedirectResponse
    {
        $pet->update($request->validated());

        return redirect()->route('pets.index')
            ->with('success', 'Pet updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet): RedirectResponse
    {
        $pet->delete();

        return redirect()->route('pets.index')
            ->with('success', 'Pet deleted successfully');
    }

}