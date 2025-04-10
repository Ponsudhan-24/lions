<?php

namespace App\Http\Controllers;

use App\Models\Popup;
use Illuminate\Http\Request;
use Storage;

class PopupController extends Controller
{

 // 🟢 Store a new banner
 public function store(Request $request)
 {
     $request->validate([
         'title'   => 'nullable|string|max:255',
         'content' => 'nullable|string',
         'link'    => 'nullable|url|max:255',
         'image'   => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
     ]);
 
     // Upload Image
     $imagePath = $request->file('image')->store('uploads', 'public');   
 
     // Store in Database
     Popup::create([
         'title'   => $request->title,
         'content' => $request->content,
         'link'    => $request->link,
         'image'   => $imagePath,
     ]);
 
     return redirect()->back()
         ->with('success', 'Popup banner added successfully!')
         ->with('activeTab', 'tab6');
 }
 

public function destroy($id)
{
    $banner = Popup::findOrFail($id);

    // Delete the image from storage
    Storage::delete('public/' . $banner->image);

    // Delete the record from the database
    $banner->delete();

    return redirect()->back()
        ->with('activeTab', 'tab6')
        ->with('sweetalert', 'Banner deleted successfully!');
}


}
