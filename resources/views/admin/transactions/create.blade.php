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

        <x-form.select
            label="Barang"
            name="item_code"
            id="item_code"
            :options="$items"
            optionValue="code"
            optionLabel="{name} (Rp{selling_price})"
            :searchKeys="['code', 'name']"
            :optionData="['selling_price']"
            :value="old('item_code')"
            placeholder="-- Pilih Barang --"
            :searchable="true"
            searchPlaceholder="Cari kode atau nama barang..."
            required
        />

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
    const input     = document.getElementById('item_code');
    const unitPrice = document.getElementById('unit_price');
    unitPrice.value = input.dataset.sellingPrice || 0;
    calculateTotal();
}

function calculateTotal() {
    const quantity  = parseInt(document.getElementById('quantity').value)   || 0;
    const unitPrice = parseInt(document.getElementById('unit_price').value) || 0;
    document.getElementById('total_price').value =
        'Rp ' + (quantity * unitPrice).toLocaleString('id-ID');
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('item_code').addEventListener('change', updatePrice);
    calculateTotal();
});
</script>
@endsection