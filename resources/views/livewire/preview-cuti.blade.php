<div class="flex justify-between mb-3">
    <div class="w-3/4 pe-3 flex justify-start">
        <a href="{{ route('permohonan-cuti') }}" class="me-3">
            <x-button bg="[var(--primary)]" px="1.5" py="1.5" label='<i class="fa-solid fa-arrow-left"></i>' />

        </a>
        <div class=" rounded-xl w-full p-4 bg-white  max-w-4xl">


            @livewire('cuti-doc', ['id' => $id])

        </div>
    </div>
    <div class="w-1/4 ">
        <div class="bg-white rounded-xl w-full p-4">
            <h3 class="text-xl  text-center mb-3 font-bold">
                Tahapan Approval Cuti
            </h3>
            <div class="flex flex-col p-3 border border-gray-300 rounded-xl mb-3">
                @forelse ($cutiFlow as $item)
                    <div class="flex items-center  mb-3">
                        <div class="flex items-center gap-2">
                            @if ($item->status == 'success')
                                <i class="fa-solid fa-circle-check text-[var(--success)] "></i>
                            @elseif($item->status == 'failed')
                                <i class="fa-solid fa-circle-xmark text-[var(--danger)]"></i>
                            @else
                                <i class="fa-regular fa-circle "></i>
                            @endif
                            {{ $item->approvalLevel->jabatan->name }} @if ($item->approvalLevel->jabatan->id == $user->jabatan_id)
                                <span
                                    class="px-1 py-0.5 ms-1 text-[10px] leading-none rounded-full text-white font-medium bg-[var(--warning)]">
                                    Anda
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                @endforelse
            </div>

            <div class="flex">

                <div class="w-full flex justify-start gap-2">
                    @if ($cutiFlowNow->status === 'waiting')
                        <div class="w-50">
                            <button wire:click="approve({{ $id }})" type="button"
                                data-modal-target="default-modal" data-modal-toggle="default-modal"
                                class="text-white w-full bg-[var(--success)] hover:brightness-90 hover:cursor-pointer font-medium rounded-lg text-sm px-1.5 py-2 me-2 "><i
                                    class="fa-solid fa-check"></i> Terima</button>
                        </div>
                        <div class="w-50">
                            <button wire:click="reject({{ $id }})" type="button"
                                data-modal-target="default-modal" data-modal-toggle="default-modal"
                                class="text-white w-full bg-[var(--danger)] hover:brightness-90 hover:cursor-pointer font-medium rounded-lg text-sm px-1.5 py-2 me-2 "><i
                                    class="fa-solid fa-xmark"></i> Tolak</button>
                        </div>
                    @else
                        <button wire:click="backToWaiting({{ $id }})" type="button"
                            data-modal-target="default-modal" data-modal-toggle="default-modal"
                            class="text-white w-full bg-[var(--warning)] hover:brightness-90 hover:cursor-pointer font-medium rounded-lg text-sm px-1.5 py-2 me-2 "><i
                                class="fa-solid fa-clock"></i> Kembali ke Pending</button>
                    @endif
                </div>
            </div>
        </div>
