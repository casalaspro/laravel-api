<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkRequest;
use App\Http\Requests\UpdateWorkRequest;
use App\Models\Technology;
use App\Models\Type;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $works = Work::all();
        return view('admin.works.index', compact('works'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::orderBy('name', 'asc')->get();

        // dd($technologies);

        return view('admin.works.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkRequest $request)
    {
        // $request->validate([
        //     'title' => 'required|string|max:150',
        //     'description' => 'nullable|string',
        //     'github_link' => 'required|url'
        // ]);

        // dd($request->all());

        $form_data = $request->all();

        $base_slug = Str::slug($form_data['title']);

        $slug = $base_slug;

        $n = 0;

        do{

            $find = Work::where('slug', $slug)->first();

            if($find !== null){

                $n++;

                $slug = $base_slug . '-' . $n;
            }

        }while($find !== null);

        // i add the key 'slug' to $form_data before that it will be used to create a new Work instance
        $form_data['slug'] = $slug;

        $work = Work::create($form_data);

        // let's check if some technologies are sent
        if($request->has('technologies')){
            // it doesn't recall the key but the method
            $work->technologies()->attach($request->technologies);
        }



        return redirect()->route('admin.works.show', $work);




    }

    /**
     * Display the specified resource.
     */
    public function show(Work $work)
    {
        //eager loading
        $work->load(['type', 'type.works']);

        return view('admin.works.show', compact('work'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Work $work)
    {

        $work->load(['technologies']);
        $types = Type::orderBy('name', 'asc')->get();
        $technologies = Technology::orderBy('name', 'asc')->get();

        // dd($work);
        return view('admin.works.edit', compact('work', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkRequest $request, Work $work)
    {
        // $request->validate([
        //     'title' => 'required|string|max:150',
        //     'slug' => ['required', 'max:255', Rule::unique('works')->ignore($work->id)],
        //     'description' => 'nullable|string',
        //     'github_link' => 'required|string'
        // ]);

        $form_data = $request->validated();

        // dd($form_data);
        $work->fill($form_data);
        $work->update($form_data);

        if($request->has('technologies')){
            $work->technologies()->sync($request->technologies);
        } else {
            // the user hasn't selected anything so we delete the nounds with the technologies
            $work->technologies()->detach();
            // $work->technologies()->sync([]); did the same
        }

        return to_route('admin.works.show', compact('work'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Work $work)
    {
    
        $work->delete();
        return to_route('admin.works.index');
    }
}
