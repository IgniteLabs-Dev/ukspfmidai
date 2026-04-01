

@extends('layouts.master')

@section('title', 'Manajemen Web')

@section('content')
    {{-- Section Atas: Full Width --}}
    <div class="space-y-4 mt-15">
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            @livewire('manajemen-approval-level-cuti')
        </div>

        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
            @livewire('manajemen-approval-level-izin')
        </div>

        {{-- Section Tengah: Izin & Cuti --}}
        {{-- grid-cols-1 pada mobile, md:grid-cols-2 pada desktop --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                @livewire('manajemen-izin')
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                @livewire('manajemen-cuti')
            </div>
        </div>

        {{-- Section Bawah: Pangkat & Jabatan --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                @livewire('manajemen-pangkat')
            </div>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100">
                @livewire('manajemen-jabatan')
            </div>
        </div>
    </div>
@endsection
