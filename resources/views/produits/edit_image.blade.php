@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-2xl shadow p-6 max-w-4xl mx-auto">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Modifier le produit</h2>

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom du produit</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Prix</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Image actuelle</label>
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-24 rounded">
                    </div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mt-4">Changer l'image</label>
                    <input type="file" name="image" id="image" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('products.index') }}" class="mr-4 text-sm text-gray-600 hover:text-gray-900">Annuler</a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700 transition">Mettre à jour</button>
            </div>
        </form>
    </div>
</div>
@endsection
