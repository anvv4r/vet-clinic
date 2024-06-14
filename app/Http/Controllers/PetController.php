<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Owner;
use App\Models\PetImage;
use Illuminate\View\View;
use App\Http\Requests\PetStoreRequest;
use App\Http\Requests\PetUpdateRequest;
use Illuminate\Http\RedirectResponse;


class PetController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $pets = Pet::with('owner')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('owner', function ($query) use ($search) {
                        $query->where('first_name', 'like', "%{$search}%")
                            ->orWhere('surname', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('pets.index', compact('pets'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }    // /**
    //  * Get the validation rules that apply to the request.
    //  *
    //  * @return array
    //  */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'species' => 'required|max:255',
            'breed' => 'required|max:255',
            'age' => 'required|numeric',
            'weight' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'owner.first_name' => 'required|max:255',
            'owner.surname' => 'required|max:255',
            'owner.email' => 'required|email|max:255',
            'owner.phone' => 'required|numeric',
            'owner.address' => 'required',
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $species = Pet::select('species')->distinct()->get();
        $breeds = Pet::select('breed')->distinct()->get();
        return view('pets.create', compact('species', 'breeds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(PetStoreRequest $request): RedirectResponse
    // {
    //     Pet::create($request->validated());

    //     return redirect()->route('pets.index')
    //         ->with('success', 'Pet submit successfully.');
    // }
    public function store(Request $request, Pet $pet)
    {
        $request->validate(array_merge($this->rules(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]));

        // Create the owner
        $ownerData = $request->input('owner');
        $owner = Owner::create($ownerData);

        // Create the pet
        $petData = $request->except('owner', 'image');
        $petData['owner_id'] = $owner->id;
        $pet = Pet::create($petData);

        // Upload the image
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        // Create the pet image
        $petImage = new PetImage;
        $petImage->path = $imageName;
        $petImage->pet_id = $pet->id;
        $petImage->save();

        return redirect()->route('pets.index')->with('success', 'Pet, owner, and image created successfully');
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
    // public function update(PetUpdateRequest $request, Pet $pet): RedirectResponse
    // {
    //     $pet->update($request->validated());

    //     return redirect()->route('pets.index')
    //         ->with('success', 'Pet updated successfully');
    // }
    // public function update(PetUpdateRequest $request, Pet $pet)
    // {
    //     $validatedData = $request->validated();

    //     $pet->update($validatedData);

    //     // Add a success message to the session
    //     return redirect()->route('pets.index')->with('success', 'Pet updated successfully');
    // }

    public function update(Request $request, Pet $pet)
    {
        $request->validate($this->rules());

        // $pet->update($request->validated());

        // Add a success message to the session
        return redirect()->route('pets.index')->with('success', 'Pet updated successfully');
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