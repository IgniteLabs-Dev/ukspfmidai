<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;

class CrudService
{
    /**
     * Show dynamic Livewire alert
     */
    private function showAlert(string $type, string $message)
    {
        LivewireAlert::title($message)
            ->position('top-end')
            ->toast()
            ->{$type}()
            ->show();
    }

    /**
     * Create record (with alert)
     */
    public function create(string $modelClass, array $data, ?string $successMessage = null, ?string $errorMessage = null)
    {
        try {
            $model = DB::transaction(fn() => $modelClass::create($data));

            $this->showAlert('success', $successMessage ?? 'Data berhasil dibuat!');
            return $model;
        } catch (\Exception $e) {
            $this->showAlert('error', $errorMessage ?? 'Data gagal dibuat!');
            return null;
        }
    }
    /**
     * Show record (with alert)
     */

    public function find(string $modelClass, $id)
    {
        try {
            return $modelClass::findOrFail($id);
        } catch (\Exception $e) {
            LivewireAlert::title('Data tidak ditemukan!')
                ->position('top-end')
                ->toast()
                ->error()
                ->show();
            return null;
        }
    }


    /**
     * Update record (with alert)
     */
    public function update(string $modelClass, $id, array $data, ?string $successMessage = null, ?string $errorMessage = null)
    {
        try {
            $model = DB::transaction(function () use ($modelClass, $id, $data) {
                $record = $modelClass::findOrFail($id);
                $record->fill($data)->save();
                return $record;
            });

            $this->showAlert('success', $successMessage ?? 'Data berhasil diperbarui!');
            return $model;
        } catch (\Exception $e) {
            $this->showAlert('error', $errorMessage ?? 'Data gagal diperbarui!');
            return null;
        }
    }

    /**
     * Delete record (with alert)
     */
    public function delete(string $modelClass, $id, ?string $successMessage = null, ?string $errorMessage = null)
    {
        try {
            DB::transaction(function () use ($modelClass, $id) {
                $modelClass::findOrFail($id)->delete();
            });

            $this->showAlert('success', $successMessage ?? 'Data berhasil dihapus!');
            return true;
        } catch (\Exception $e) {
            $this->showAlert('error', $errorMessage ?? 'Data gagal dihapus!');
            return false;
        }
    }
}
