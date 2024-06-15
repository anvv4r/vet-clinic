<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Owner;
use App\Models\PetImage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
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
    }

    // /**
    //  * Get the validation rules that apply to the request.
    //  */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'species' => 'required|max:255',
            'breed' => 'required|max:255',
            'age' => 'required|numeric',
            'weight' => 'required|numeric',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
    public function store(Request $request, Pet $pet)
    {
        $request->validate($this->rules());

        // Create the owner
        $ownerData = $request->input('owner');
        $owner = Owner::create($ownerData);

        // Create the pet
        $petData = $request->except('owner', 'image');
        $petData['owner_id'] = $owner->id;
        $pet = Pet::create($petData);

        // Get the original file name without extension
        $imageName = pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME);

        // Generate a unique ID
        $uniqueSuffix = uniqid('_');

        // Get file extension
        $extension = $request->image->extension();

        // Create a unique file name
        $finalImageName = "{$imageName}{$uniqueSuffix}.{$extension}";

        // Move the image to the public/images/pets directory with the new unique name
        $request->image->move(public_path('images/pets'), $finalImageName);

        // Create the pet image
        $petImage = new PetImage;
        $petImage->path = $finalImageName;
        $petImage->pet_id = $pet->id;
        $petImage->save();

        return redirect()->route('pets.index')->with('success', 'Pet, owner, and image created successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pet $pet)
    {
        $request->validate($this->rules());

        // Update the owner
        $ownerData = $request->input('owner');
        $pet->owner->update($ownerData);

        // Update the pet
        $petData = $request->except('owner', 'image');
        $pet->update($petData);

        // Check if a new image was provided
        if ($request->hasFile('image')) {
            // Get the old image
            $oldImage = PetImage::where('pet_id', $pet->id)->first();

            // Delete the old image file
            if ($oldImage) {
                Storage::delete(public_path('images/pets/' . $oldImage->path));
                $oldImage->delete();
            }

            // Upload the new image
            $imageName = pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME); // Get original file name without extension
            $uniqueSuffix = uniqid('_'); // Generate a unique ID
            $extension = $request->image->extension(); // Get file extension

            $finalImageName = "{$imageName}{$uniqueSuffix}.{$extension}";

            $request->image->move(public_path('images/pets'), $finalImageName);

            // Create a new image record
            $petImage = new PetImage;
            $petImage->path = $finalImageName;
            $petImage->pet_id = $pet->id;
            $petImage->save(); // Save the PetImage model instance
        }

        // Add a success message to the session
        return redirect()->route('pets.index')->with('success', 'Pet updated successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet): View
    {
        $species = Pet::select('species')->distinct()->get();
        $breeds = Pet::select('breed')->distinct()->get();

        return view('pets.edit', compact('pet', 'species', 'breeds'));
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

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet): View
    {
        return view('pets.show', compact('pet'));
    }

}