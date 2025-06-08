<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Gallary;

class ApplicationController extends Controller
{
    public function create()
    {
        $images = Gallary::where('status','Active')->get(); // Fetch all images from the gallery table
        return view('create', compact('images'));//blade file for create and store
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:application,name',// Check if the name is unique in the products table
            'description' => 'required',
        ]);//validation in each field
        $input = $request->all();

        $existingapplication = application::where('name', $request->name)
        ->where('description', $request->description)
        ->when($request->id, function ($query) use ($request) {
            $query->where('id', '!=', $request->id);
        })
        ->first();//for searching name nad description

    if ($existingapplication) {
        return redirect()->back()->withErrors(['error' => 'A application with the same name and size already exists.']);
    }

        Application::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status ?? 'Inactive',
            'gallery_id' => json_encode($request->gallery_id), // Store selected image IDs as JSON
        ]);//new record is created in database

        return redirect()->route('application.index')->with('success', 'Application saved successfully');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

$applications = Application::where('status', 'Active')// Query application with 'Active' status and apply search if provided
    ->when($search, function ($query, $search) {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('description', 'like', '%' . $search . '%');
        });
    })//searching of name and description
    ->orderBy('id', 'desc')// Order by latest records
    ->paginate(5);// Paginate with 5 records per page


        foreach ($applications as $application) {
            $galleryIds = json_decode($application->gallery_id, true) ?? [];
            $application->gallery_images = Gallary::whereIn('id', $galleryIds)->get();
        }

        return view('index', compact('applications'));//blade file of index and
    }

    public function edit($id)
    {
        //finds the record and edit
        $application = Application::findOrFail($id);
        //finds the record images and dis[;ayed in main table]
        $images = Gallary::where('status','Active')->get();
        //display selected images for updating
        $selectedImages = json_decode($application->gallery_id, true) ?? [];

        return view('edit', compact('application', 'images', 'selectedImages'));//blade file for updation
    }

    public function update(Request $request, $id)
    {
        $application = Application::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:application,name,' . $id,
        ]);
          // Find the application record or throw an exception if not found
        $input = $request->all();

        $application->update([
            'name' => $request->name,
            'description' => $request->description,
            'gallery_id' => json_encode($request->gallery_id),
            'status' => $request->status ?? 'Inactive',
        ]);
        // Redirect to the index page with a success message
        return redirect()->route('application.index')->with('success', 'Application updated successfully');
    }

    public function delete($id)
    {
          // Find the record by ID
        Application::findOrFail($id)->update(['status' => 'Deleted']);
          // Redirect with a success message
        return redirect()->route('application.index')->with('success', 'Item deleted successfully.');
    }
}
