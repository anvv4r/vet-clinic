<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;
use App\Models\Pet;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $visits = Visit::latest()->paginate(10);
        return view('visits.index', compact('visits'));
    }


    // /**
    //  * Get the validation rules that apply to the request.
    //  */
    public function rules()
    {
        return [
            'date' => 'required|date',
            'owner_id' => 'required|numeric',
            'pet_id' => 'required|numeric',
            'report' => 'required|max:255',
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($owner_id, $pet_id)
    {
        $pet_name = Pet::find($pet_id)->name;

        return view('visits.create', compact('owner_id', 'pet_id', 'pet_name'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, $this->rules());

        $visit = new Visit($request->all());
        $visit->date = $visit->date ?? now(); // If no date is provided, use the current date and time
        $pet_id = $request->input('pet_id');

        $visit->save();

        return redirect()->route('pets.show', $pet_id)->with('success', 'Visit Log created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($owner_id, $pet_id)
    {
        $pet = Pet::find($pet_id);
        $visit = Visit::where('owner_id', $owner_id)->where('pet_id', $pet_id)->first();

        if ($visit) {
            return view('visits.edit', [
                'owner_id' => $owner_id,
                'pet_id' => $pet_id,
                'pet_name' => $pet->name,
                'date' => $visit->date,
                'report' => $visit->report,
                'visit' => $visit
            ]);
        } else {
            return redirect()->route('pets.show', $pet_id)->with('error', 'No visit log found');
        }
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $visit_id)
    {
        $this->validate($request, $this->rules());

        // You'll need to find the pet_id from the visit
        $visit = Visit::find($visit_id);
        $pet_id = $visit->pet_id;

        return redirect()->route('pets.show', $pet_id)->with('success', 'Visit Log updated successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Visit $visit)
    {
        $pet_id = $visit->pet_id;
        $visit->delete();

        return redirect()->route('pets.show', ['pet' => $pet_id])->with('success', 'Visit Log Deleted successfully');
    }
}
