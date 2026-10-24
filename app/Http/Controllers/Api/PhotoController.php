<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PhotoResource;
use App\Models\Category;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     * Sesuai Bab 3.4.5 Modul: Mendapatkan daftar foto lengkap dengan relasi kategorinya.
     */
    public function index(Request $request)
    {
        $query = Photo::with('category');

        // Filter berdasarkan kategori (nama atau ID)
        if ($request->filled('category')) {
            $catName = $request->query('category');
            $query->whereHas('category', function ($q) use ($catName) {
                $q->where('category', $catName);
            });
        } elseif ($request->filled('category_id')) {
            $query->where('category_id', $request->query('category_id'));
        }

        // Pencarian (judul, fotografer, tags)
        if ($request->filled('search')) {
            $search = '%' . $request->query('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search)
                  ->orWhere('photographer', 'like', $search)
                  ->orWhere('description', 'like', $search)
                  ->orWhere('tags', 'like', $search);
            });
        }

        // Opsi pagination (default 12 foto per halaman, atau ambil semua jika per_page=all)
        if ($request->query('per_page') === 'all') {
            $photos = $query->latest('photo_id')->get();
            return PhotoResource::collection($photos);
        }

        $perPage = (int) $request->query('per_page', 12);
        $photos = $query->latest('photo_id')->paginate($perPage);

        return PhotoResource::collection($photos);
    }

    /**
     * Store a newly created resource in storage.
     * Sesuai Bab 3.4.5 & 3.4.6 Modul: Validasi, pembuatan slug, dan unggah file gambar.
     */
    public function store(Request $request)
    {
        // Mendukung category_id langsung atau resolve nama kategori jika dikirim dalam bentuk teks
        $categoryId = $request->category_id;
        if (!$categoryId && $request->filled('category')) {
            $cat = Category::where('category', $request->category)->first();
            if ($cat) {
                $categoryId = $cat->category_id;
            }
        }

        $request->merge(['category_id' => $categoryId]);

        // Validasi input
        $validated = $request->validate([
            'title'        => 'required|string|min:3|max:150',
            'category_id'  => 'required|exists:categories,category_id',
            'photographer' => 'nullable|string|max:150',
            'tags'         => 'nullable',
            'w'            => 'nullable|integer|min:1',
            'h'            => 'nullable|integer|min:1',
            'price'        => 'nullable|numeric|min:0',
            'description'  => 'nullable|string',
            'img'          => 'nullable', // bisa berupa file gambar (multipart) atau string URL
        ]);

        // Inisialisasi path gambar
        $path = null;

        // Mengambil file image dari request jika diunggah via multipart (Bab 3.4.6)
        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('photos', 'public');
        } elseif ($request->hasFile('image')) {
            $path = $request->file('image')->store('photos', 'public');
        } elseif (is_string($request->input('img')) && !empty($request->input('img'))) {
            $path = $request->input('img');
        } elseif (is_string($request->input('image')) && !empty($request->input('image'))) {
            $path = $request->input('image');
        }

        // Normalisasi format tags jika dikirim sebagai string dipisah koma
        $tags = $request->input('tags');
        if (is_string($tags)) {
            $tags = array_values(array_filter(array_map('trim', explode(',', $tags))));
        }

        // Generate slug unik
        $baseSlug = Str::slug($request->title);
        $slug = $baseSlug . '-' . time();

        // Buat data produk / foto
        $photo = Photo::create([
            'title'        => $validated['title'],
            'slug'         => $slug,
            'category_id'  => $validated['category_id'],
            'photographer' => $validated['photographer'] ?? 'I Made Arya Dipa',
            'tags'         => $tags ?? [],
            'w'            => $validated['w'] ?? 1600,
            'h'            => $validated['h'] ?? 1067,
            'price'        => $validated['price'] ?? 85000,
            'description'  => $validated['description'] ?? null,
            'img'          => $path,
            'downloads'    => 0,
        ]);

        return (new PhotoResource($photo->load('category')))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     * Dapat dicari melalui photo_id atau slug URL unik.
     */
    public function show(string $id)
    {
        $photo = is_numeric($id)
            ? Photo::with('category')->find($id)
            : Photo::with('category')->where('slug', $id)->first();

        if (!$photo) {
            return response()->json(['message' => 'Foto tidak ditemukan'], 404);
        }

        return new PhotoResource($photo);
    }

    /**
     * Update the specified resource in storage.
     * Sesuai Bab 3.4.5 & 3.4.6 Modul: Memperbarui data foto dan file gambar jika diganti.
     */
    public function update(Request $request, string $id)
    {
        $photo = is_numeric($id)
            ? Photo::find($id)
            : Photo::where('slug', $id)->first();

        if (!$photo) {
            return response()->json(['message' => 'Foto tidak ditemukan'], 404);
        }

        $categoryId = $request->category_id;
        if (!$categoryId && $request->filled('category')) {
            $cat = Category::where('category', $request->category)->first();
            if ($cat) {
                $categoryId = $cat->category_id;
            }
        }

        if ($categoryId) {
            $request->merge(['category_id' => $categoryId]);
        }

        $validated = $request->validate([
            'title'        => 'sometimes|required|string|min:3|max:150',
            'category_id'  => 'sometimes|required|exists:categories,category_id',
            'photographer' => 'nullable|string|max:150',
            'tags'         => 'nullable',
            'w'            => 'nullable|integer|min:1',
            'h'            => 'nullable|integer|min:1',
            'price'        => 'nullable|numeric|min:0',
            'description'  => 'nullable|string',
            'img'          => 'nullable',
        ]);

        $updateData = [];
        if (isset($validated['title'])) {
            $updateData['title'] = $validated['title'];
            $updateData['slug']  = Str::slug($validated['title']) . '-' . $photo->photo_id;
        }
        if (isset($validated['category_id'])) {
            $updateData['category_id'] = $validated['category_id'];
        }
        if (array_key_exists('photographer', $validated)) {
            $updateData['photographer'] = $validated['photographer'];
        }
        if (array_key_exists('w', $validated)) {
            $updateData['w'] = $validated['w'];
        }
        if (array_key_exists('h', $validated)) {
            $updateData['h'] = $validated['h'];
        }
        if (array_key_exists('price', $validated)) {
            $updateData['price'] = $validated['price'];
        }
        if (array_key_exists('description', $validated)) {
            $updateData['description'] = $validated['description'];
        }

        if ($request->has('tags')) {
            $tags = $request->input('tags');
            if (is_string($tags)) {
                $tags = array_values(array_filter(array_map('trim', explode(',', $tags))));
            }
            $updateData['tags'] = $tags;
        }

        // Handle upload foto baru (jika ada)
        if ($request->hasFile('img')) {
            // Hapus berkas foto lama jika ada di local public disk
            if ($photo->img && Storage::disk('public')->exists($photo->img)) {
                Storage::disk('public')->delete($photo->img);
            }
            $updateData['img'] = $request->file('img')->store('photos', 'public');
        } elseif ($request->hasFile('image')) {
            if ($photo->img && Storage::disk('public')->exists($photo->img)) {
                Storage::disk('public')->delete($photo->img);
            }
            $updateData['img'] = $request->file('image')->store('photos', 'public');
        } elseif (is_string($request->input('img')) && !empty($request->input('img'))) {
            $updateData['img'] = $request->input('img');
        } elseif (is_string($request->input('image')) && !empty($request->input('image'))) {
            $updateData['img'] = $request->input('image');
        }

        $photo->update($updateData);

        return new PhotoResource($photo->load('category'));
    }

    /**
     * Remove the specified resource from storage.
     * Sesuai Bab 3.4.5 Modul: Menghapus data dan berkas terkait.
     */
    public function destroy(string $id)
    {
        $photo = is_numeric($id) ? Photo::find($id) : Photo::where('slug', $id)->first();

        if (!$photo) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        // Hapus file fisik dari storage jika ada
        if ($photo->img && Storage::disk('public')->exists($photo->img)) {
            Storage::disk('public')->delete($photo->img);
        }

        $photo->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
