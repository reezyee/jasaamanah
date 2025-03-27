<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max') && $request->price_max > 0) {
            $query->where('price', '<=', $request->price_max);
        }

        $services = $query->latest()->paginate(12);
        $categories = Category::all();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('pages.partials.service-list', compact('services'))->render(),
                'pagination' => $services->links()->toHtml(),
                'total' => $services->total(),
                'debug' => [
                    'count' => $services->count(),
                    'filters' => $request->all()
                ]
            ]);
        }

        return view('pages.admin.services', compact('services', 'categories'))->with(['title' => 'Services Management']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
        ]);

        $service = Service::create($request->all());

        return response()->json(['message' => 'Layanan berhasil ditambahkan', 'service' => $service]);
    }

    public function show($id)
    {
        $service = Service::findOrFail($id);
        return response()->json($service);
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
        ]);

        $service->update($request->all());

        return response()->json(['message' => 'Layanan berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json(['message' => 'Layanan berhasil dihapus']);
    }

    public function bulkDestroy(Request $request)
    {
        try {
            Log::info('Bulk delete request received', ['data' => $request->all()]);
            $requestIds = $request->ids;

            if (is_string($requestIds) && strpos($requestIds, ',') !== false) {
                $ids = array_map('intval', explode(',', $requestIds));
            } else if (is_array($requestIds)) {
                $ids = array_map('intval', $requestIds);
            } else {
                $ids = [intval($requestIds)];
            }

            Log::info('Attempting to delete services', ['ids' => $ids]);
            $count = Service::whereIn('id', $ids)->delete();
            Log::info('Services deleted successfully', ['count' => $count]);

            return response()->json([
                'message' => $count . ' services successfully deleted',
                'count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error('Bulk delete error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['message' => 'An error occurred while deleting services. Please try again.'], 500);
        }
    }

    public function publicIndex(Request $request)
    {
        $query = Service::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $services = $query->latest()->paginate(12);
        $categories = Category::all();


        if ($request->ajax()) {
            return response()->json([
                'html' => view('pages.partials.service-list', compact('services'))->render(),
                'pagination' => $services->links()->toHtml(),
            ]);
        }

        return view('pages.services', compact('services', 'categories'))->with(['title' => 'Our Services']);
    }
}
