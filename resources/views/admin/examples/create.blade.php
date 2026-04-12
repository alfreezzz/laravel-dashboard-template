@extends('layouts.app')

@section('title', 'Tambah Contoh')

@section('content')
<x-form.form-card title="Tambah Contoh Menu" :backUrl="route('examples.index')">
    <form action="{{ route('examples.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" 
          x-data="{ 
              title: '', 
              slug: '',
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
                  if (!this.slugModifiedManually) {
                      this.slug = this.generateSlug(this.title);
                  }
              },
              onSlugChange() {
                  this.slugModifiedManually = true;
              }
          }">
        @csrf

        <!-- Text Input Component -->
        <x-form.input
            label="Judul"
            name="title"
            placeholder="Masukkan judul contoh menu"
            :value="old('title')"
            required
            x-model="title"
            @input="onTitleChange()"
        />

        <!-- Text Input untuk Slug -->
        <x-form.input
            label="Slug (URL-friendly, auto-generate dari judul)"
            name="slug"
            placeholder="slug-otomatis-dibuat"
            :value="old('slug')"
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
            :value="old('category_id')"
            required
        />

        <!-- Textarea Component untuk deskripsi -->
        <x-form.textarea
            label="Deskripsi Singkat"
            name="description"
            placeholder="Masukkan deskripsi singkat"
            :value="old('description')"
            rows="4"
        />

        <!-- Editor Component untuk content -->
        <x-form.editor
            label="Isi Konten (Rich Text Editor)"
            name="content"
            placeholder="Masukkan konten utama dengan format rich text"
            :value="old('content')"
        />

        <!-- Grid untuk input angka -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Number Input untuk harga -->
            <x-form.input
                label="Harga"
                name="price"
                type="number"
                placeholder="0"
                :value="old('price')"
                required
                min="0"
            />

            <!-- Number Input untuk kuantitas -->
            <x-form.input
                label="Kuantitas"
                name="quantity"
                type="number"
                placeholder="0"
                :value="old('quantity')"
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
            :value="old('status', 'draft')"
            required
        />

        <!-- Checkbox Component untuk is_active -->
        <x-form.checkbox
            label="Aktif"
            name="is_active"
            :checked="old('is_active', true)"
        />

        <!-- Image Upload Component -->
        <x-form.image-upload
            label="Gambar Utama"
            name="featured_image"
            accept="image/jpeg,image/png,image/jpg,image/gif"
            helpText="Format: JPEG, PNG, JPG, GIF - Maksimal 2MB"
        />

        <!-- File Upload Component -->
        <x-form.file-upload
            label="Upload Dokumen"
            name="document"
            accept=".pdf,.doc,.docx,.xls,.xlsx"
            helpText="Format: PDF, DOC, DOCX, XLS, XLSX - Maksimal 5MB"
        />

        <x-form.form-actions :cancelUrl="route('examples.index')" />
    </form>
</x-form.form-card>
@endsection
