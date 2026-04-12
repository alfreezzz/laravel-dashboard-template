@extends('layouts.app')

@section('title', 'Edit Contoh')

@section('content')
<x-form.form-card title="Edit Contoh Menu" :backUrl="route('examples.index')">
    <form action="{{ route('examples.update', $example->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6"
          x-data="{ 
              title: '{{ old('title', $example->title) }}', 
              slug: '{{ old('slug', $example->slug) }}',
              slugModifiedManually: false,
              generateSlug(text) {
                  return text
                      .toLowerCase()
                      .trim()
                      .replace(/[^\w\s-]/g, '')
                      .replace(/\s+/g, '-')
                      .replace(/-+/g, '-')
                      .replace(/^-+|-+$/g, '');
              },
              onTitleChange() {
                  // Hanya auto-generate jika user belum pernah edit slug
                  if (!this.slugModifiedManually) {
                      this.slug = this.generateSlug(this.title);
                  }
              },
              onSlugChange() {
                  this.slugModifiedManually = true;
              }
          }">
        @csrf
        @method('PUT')

        <!-- Text Input Component -->
        <x-form.input
            label="Judul"
            name="title"
            placeholder="Masukkan judul contoh menu"
            :value="old('title', $example->title)"
            required
            x-model="title"
            @input="onTitleChange()"
        />

        <!-- Text Input untuk Slug -->
        <x-form.input
            label="Slug (URL-friendly)"
            name="slug"
            placeholder="slug-contoh"
            :value="old('slug', $example->slug)"
            x-model="slug"
            @input="onSlugChange()"
        />

        <!-- Select Component untuk kategori -->
        <x-form.select
            label="Kategori"
            name="category_id"
            :options="$categories"
            option-value="id"
            option-label="name"
            placeholder="-- Pilih Kategori --"
            :value="old('category_id', $example->category_id)"
            required
        />

        <!-- Textarea Component untuk deskripsi -->
        <x-form.textarea
            label="Deskripsi Singkat"
            name="description"
            placeholder="Masukkan deskripsi singkat"
            :value="old('description', $example->description)"
            rows="4"
        />

        <!-- Editor Component untuk content -->
        <x-form.editor
            label="Isi Konten (Rich Text Editor)"
            name="content"
            placeholder="Masukkan konten utama dengan format rich text"
            :value="old('content', $example->content)"
        />

        <!-- Grid untuk input angka -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Number Input untuk harga -->
            <x-form.input
                label="Harga"
                name="price"
                type="number"
                placeholder="0"
                :value="old('price', $example->price)"
                required
                min="0"
            />

            <!-- Number Input untuk kuantitas -->
            <x-form.input
                label="Kuantitas"
                name="quantity"
                type="number"
                placeholder="0"
                :value="old('quantity', $example->quantity)"
                required
                min="0"
            />
        </div>

        <!-- Select Component untuk status -->
        <x-form.select
            label="Status"
            name="status"
            :options="[
                'draft' => 'Draft',
                'published' => 'Dipublikasikan'
            ]"
            placeholder="-- Pilih Status --"
            :value="old('status', $example->status)"
            required
        />

        <!-- Checkbox Component untuk is_active -->
        <x-form.checkbox
            label="Aktif"
            name="is_active"
            :checked="old('is_active', $example->is_active)"
        />

        <!-- Image Upload Component dengan preview -->
        @if($example->featured_image)
            <div class="mb-4">
                <p class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Gambar Saat Ini:</p>
                <img src="{{ asset('storage/' . $example->featured_image) }}" alt="Featured Image" class="w-48 h-auto rounded-lg">
            </div>
        @endif
        <x-form.image-upload
            label="Gambar Utama (Baru)"
            name="featured_image"
            accept="image/jpeg,image/png,image/jpg,image/gif"
            helpText="Format: JPEG, PNG, JPG, GIF - Maksimal 2MB"
        />

        <!-- File Upload Component dengan link -->
        @if($example->document)
            <div class="mb-4">
                <p class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Dokumen Saat Ini:</p>
                <a href="{{ asset('storage/' . $example->document) }}" download class="text-blue-600 hover:text-blue-700 underline">
                    Download dokumen
                </a>
            </div>
        @endif
        <x-form.file-upload
            label="Upload Dokumen (Baru)"
            name="document"
            accept=".pdf,.doc,.docx,.xls,.xlsx"
            helpText="Format: PDF, DOC, DOCX, XLS, XLSX - Maksimal 5MB"
        />

        <x-form.form-actions submitLabel="Simpan Perubahan" :cancelUrl="route('examples.index')" />
    </form>
</x-form.form-card>
@endsection
