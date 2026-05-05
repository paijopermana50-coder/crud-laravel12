<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Mobil;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class MobilController extends Controller
{
    public function index(): View
    {
        $mobil = Mobil::latest()->paginate();
        return view('mobil.index', compact('mobil'));
    }
    public function create(): View
    {
        return view('mobil.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'gambar'      => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama'        => 'required|min:5',
            'deskripsi'   => 'required|min:10',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric'
        ]);

        $gambar = $request->file('gambar');
        $gambar->storeAs('mobil', $gambar->hashName());

        Mobil::create([
            'gambar'      => $gambar->hashName(),
            'nama'        => $request->nama,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'stok'        => $request->stok
        ]);

        //redirect to index
        return redirect()->route('mobil.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    public function show(string $id): View
    {
        $mobil = Mobil::find($id);
        return view('mobil.show', compact('mobil'));
    }
    public function edit(string $id): View
    {
        $mobil = Mobil::find($id);
        return view('mobil.edit', compact('mobil'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        //validate form
        $request->validate([
            'gambar'         => 'image|mimes:jpeg,jpg,png|max:2048',
            'nama'         => 'required|min:5',
            'deskripsi'   => 'required|min:10',
            'harga'         => 'required|numeric',
            'stok'         => 'required|numeric'
        ]);

        //get product by ID
        $mobil = Mobil::findOrFail($id);

        //check if image is uploaded
        if ($request->hasFile('gambar')) {

            //delete old image
            Storage::delete('mobil/' . $mobil->gambar);

            //upload new image
            $gambar = $request->file('gambar');
            $gambar->storeAs('mobil', $gambar->hashName());

            //update product with new image
            $mobil->update([
                'gambar'         => $gambar->hashName(),
                'nama'         => $request->nama,
                'deskripsi'   => $request->deskripsi,
                'harga'         => $request->harga,
                'stok'         => $request->stok
            ]);
        } else {

            //update product without image
            $mobil->update([
                'nama'         => $request->nama,
                'deskripsi'   => $request->deskripsi,
                'harga'         => $request->harga,
                'stok'         => $request->stok
            ]);
        }

        //redirect to index
        return redirect()->route('mobil.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id): RedirectResponse
    {
        $mobil = Mobil::findOrFail($id);
        Storage::delete('mobil/' . $mobil->gambar);
        $mobil->delete();
        return redirect()->route('mobil.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
