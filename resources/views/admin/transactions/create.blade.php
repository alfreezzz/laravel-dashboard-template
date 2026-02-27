@extends('layouts.app')

@section('title', 'Tambah Penjualan')

@section('content')
<x-form.form-card title="Tambah Penjualan Baru" :backUrl="route('transactions.index')">
    <form action="{{ route('transactions.store') }}" method="POST" class="space-y-6">
        @csrf

        <x-form.input
            label="Nama Pembeli"
            name="consumer_name"
            placeholder="Masukkan nama pembeli"
            :value="old('consumer_name')"
            required
        />

        <div class="mb-4">
            <label for="item_code" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                Barang
                <span class="text-red-500">*</span>
            </label>
            
            <select 
                name="item_code"
                id="item_code"
                required
                onchange="updatePrice()"
                class="w-full px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition cursor-pointer"
            >
                <option value="">-- Pilih Barang --</option>
                @foreach($items as $item)
                    <option value="{{ $item->code }}" 
                            data-price="{{ $item->selling_price }}"
                            {{ old('item_code') == $item->code ? 'selected' : '' }}>
                        {{ $item->code }} - {{ $item->name }} (Rp {{ number_format($item->selling_price, 0, ',', '.') }})
                    </option>
                @endforeach
            </select>
            @error('item_code')
                <p class="mt-1 text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <x-form.input
                label="Jumlah"
                name="quantity"
                type="number"
                placeholder="0"
                :value="old('quantity')"
                required
                min="1"
                oninput="calculateTotal()"
            />

            <x-form.input
                label="Harga Satuan"
                name="unit_price"
                type="number"
                placeholder="0"
                :value="old('unit_price')"
                required
                min="0"
                oninput="calculateTotal()"
            />
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                Total Harga
            </label>
            <input type="text" 
                   id="total_price"
                   class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-white cursor-not-allowed font-semibold text-lg" 
                   disabled>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Otomatis dihitung dari jumlah × harga satuan</p>
        </div>

        <x-form.form-actions :cancelUrl="route('transactions.index')" />
    </form>
</x-form.form-card>

<script>
function updatePrice() {
    const select = document.getElementById('item_code');
    const unitPrice = document.getElementById('unit_price');
    const selectedOption = select.options[select.selectedIndex];
    const price = selectedOption.getAttribute('data-price');
    unitPrice.value = price || 0;
    calculateTotal();
}

function calculateTotal() {
    const quantity = parseInt(document.getElementById('quantity').value) || 0;
    const unitPrice = parseInt(document.getElementById('unit_price').value) || 0;
    const totalPrice = quantity * unitPrice;
    document.getElementById('total_price').value = 'Rp ' + totalPrice.toLocaleString('id-ID');
}

// Initialize total on page load if values are present
document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
});
</script>
@endsection
