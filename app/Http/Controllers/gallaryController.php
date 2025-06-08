<?php

namespace App\Http\Controllers;
use App\Models\gallary;
use Illuminate\Http\Request;

class gallaryController extends Controller
{
    public function create()
    {
        return view('gallery/create');//blade file for create page
    }
    public function store(Request $request)
    {
        $input = $request->all();
        $imagePath = null;

        // Check if image is uploaded
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $logoImage = $request->file('image');

            // Define the destination path
            $destinationPath = public_path('app_images');

            // Create unique file name
            $imageName = time() . '_' . $logoImage->getClientOriginalName();

            // Move image to public/app_images
            $logoImage->move($destinationPath, $imageName);

            // Save image path for database
            $imagePath = $imageName;
        }

        // Store data in database (even if no image is uploaded)
        gallary::create([
            'image' => $imagePath,  // Store NULL if no image uploaded
            'status' => $request->status == 'Active' ? 'Active' : 'Inactive',
        ]);

        return redirect()->route('gallery.index')->with('success', 'Application saved successfully');
    }

    public function index(Request $request)
    {
        $search = $request->input('search', ''); // Default search is an empty string

        $galleries = gallary::where('status','Active')//display the active records
        ->latest()
        ->paginate(9);//pagination per page

        return view('gallery/index',compact('galleries'));//blade file for index page

    }

    public function edit($id)
    {
        $galleries = gallary::findOrFail($id);//find the record to edit

        return view('gallery/edit',compact('galleries'));//blade file for edit page
    }

    public function update(Request $request,$id)
    {
    $input = $request->all();
        // Find the gallery record or throw an exception if not found
    $galleries = gallary::findOrFail($id);

    $imagePath = $galleries->image;

    if ($request->hasFile('image') && !empty($request->file('image'))) {
        $logoImage = $request->file('image');
        $destinationPath = public_path() . '/app_images'; // Directory for storing images

        $originalName = pathinfo($logoImage->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $logoImage->getClientOriginalExtension();
        $imagePath = $originalName . '.' . $extension;

        $logoImage->move($destinationPath, $imagePath);
    }else{
        if (isset($input['hdnimage']) && !empty($input['hdnimage']))
        $imagePath = $input['hdnimage'];//display the image after update
    }

    // Set the status based on the request input
    $status = $request->status == 'Active' ? 'Active' : 'Inactive';

    $galleries->update([
        'image' => $imagePath,
        'status' => $status,
    ]);
    return redirect()->route('gallery.index')->with('success','Image saved successfully');

    }

    public function delete($id)
    {
        // Find the record by ID
    gallary::findOrFail($id)->update(['status' => 'Deleted']);
         // Redirect with a success message
    return redirect()->route('gallery.index')->with('success', 'Item deleted successfully.');

    }
}
