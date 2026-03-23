@extends('layouts.master')

@section('title', 'Manajemen Web')

@section('content')
    <div class="bg-white rounded-xl p-4 mb-2">
         @livewire('manajemen-approval-level-cuti')
    </div>
    <div class="bg-white rounded-xl p-4 mb-2">
         @livewire('manajemen-approval-level-izin')
    </div>
    <div class="bg-white rounded-xl p-4 mb-2">
        @livewire('manajemen-cuti')
    </div>
    <div class="w-full grid gap-2 grid-cols-2">
        <div class="bg-white  rounded-xl p-4 mb-2">
            @livewire('manajemen-izin')
        </div>
        <div class="bg-white  rounded-xl p-4 mb-2">
            @livewire('manajemen-tahun')
        </div>
    </div>
    <div class="w-full grid gap-2 grid-cols-2">
        <div class="bg-white rounded-xl p-4 mb-2">
            @livewire('manajemen-jabatan')
        </div>
        <div class="bg-white rounded-xl p-4 mb-2">
            @livewire('manajemen-tanggal-merah')
        </div>
    </div>
    <div class="w-full ">
        <div class="bg-white rounded-xl p-4 mb-2">
            @livewire('manajemen-pangkat')
        </div>
    </div>
@endsection
