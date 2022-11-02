<?php

namespace App\Http\Controllers;


use App\Models\izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class izincontroller extends Controller
{
    public function index()
    {
        $izins = izin::latest()->paginate(5);

        return view('izins.index', compact('izins'));
    }

    public function create()
    {
        return view('izins.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama'     => 'required|min:1',
            'absen'   => 'required|min:1',
            'kelas'     => 'required|min:1',
            'keterangan'     => 'required|min:1'
        ]);

        $image = $request->file('image');
        $image->storeAs('public/izins', $image->hashName());

        izin::create([
            'image'     => $image->hashName(),
            'nama'     => $request->nama,
            'absen'   => $request->absen,
            'kelas'     => $request->kelas,
            'keterangan'     => $request->keterangan
        ]);

        return redirect()->route('izins.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function edit(izin $izin)
    {
        return view('izins.edit', compact('izin'));
    }

    public function update(Request $request, izin $izin)
    {
        //validate form
        $this->validate($request, [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama'     => 'required|min:1',
            'absen'   => 'required|min:1',
            'kelas'     => 'required|min:1',
            'keterangan'     => 'required|min:1'
        ]);

        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/izins', $image->hashName());

            //delete old image
            Storage::delete('public/izins/'.$izin->image);

            //update izin with new image
            $izin->update([
                'image'     => $image->hashName(),
                'nama'     => $request->nama,
                'absen'   => $request->absen,
                'kelas'     => $request->kelas,
                'keterangan'     => $request->keterangan
            ]);

        } else {

            //update izin without image
            $izin->update([
                'nama'     => $request->nama,
                'absen'   => $request->absen,
                'kelas'     => $request->kelas,
                'keterangan'     => $request->keterangan
            ]);
        }

        //redirect to index
        return redirect()->route('izins.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(izin $izin)
    {
        //delete image
        Storage::delete('public/izins/'. $izin->image);

        //delete izin
        $izin->delete();

        //redirect to index
        return redirect()->route('izins.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

}
