<?php

namespace App\Http\Controllers;

use App\Models\Berita; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function show($id) 
    {
        $event = Berita::find($id);
        if ($event) {

            return response()->json($event);
        }
        return response()->json(['error' => 'Event tidak ditemukan'], 404);
    }


    public function latest()
    {
        $events = Berita::orderBy('created_at', 'desc')->take(5)->get();
        
        foreach ($events as $event) {

        }

        return response()->json($events);
    }

    public function getEvents() 
    {
        $events = Berita::all();

        foreach ($events as $event) {
        }

        return response()->json($events);
    }
    
    public function store(Request $request)
{
    try {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'status' => 'required|in:Berlangsung,Coming Soon',
            'image' => 'required|image',
            'is_news' => 'required|boolean',
            'is_event' => 'required|boolean',
            'date' => 'required|date', // Validasi tanggal
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Menangani file gambar
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $imageName);

        // Menentukan apakah ini event atau berita
        $event = Berita::create([
            'judul' => $request->title,
            'isi' => $request->description,
            'lokasi' => $request->location,
            'status_event' => $request->status,
            'gambar' => url('public/uploads/' . $imageName),
            'is_event' => $request->is_event,
            'is_news' => $request->is_news,
            'tanggal' => $request->date,  // Menyimpan tanggal
        ]);

        return response()->json(['message' => 'Event berhasil ditambahkan', 'event' => $event], 201);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

}
