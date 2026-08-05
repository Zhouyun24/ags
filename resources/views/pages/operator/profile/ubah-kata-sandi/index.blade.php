@extends('layouts.index')

@section('layouts')
<div x-data="{
        showCurrent: false,
        showNew: false,
        showConfirm: false,
        currentPassword: '',
        newPassword: '',
        confirmPassword: '',
        get isValid() {
            return this.currentPassword.length > 0
                && this.newPassword.length >= 8
                && this.newPassword === this.confirmPassword;
        },
        get passwordMismatch() {
            return this.confirmPassword.length > 0 && this.newPassword !== this.confirmPassword;
        },
    }" class="pb-8">

    <div class="relative overflow-hidden rounded-b-[28px] bg-gradient-to-br from-[#8B5CF6] via-[#7C3AED] to-[#6D28D9] px-5 pb-16 pt-5 text-center">
        <h1 class="font-jakarta text-xl font-extrabold text-white">Ubah Kata Sandi</h1>
        <p class="mt-1 font-inter text-xs text-blue-100">Sesuaikan ulang kata sandi Anda</p>
    </div>

    <div class="relative px-7 z-10">

        <form action="" method="POST"
            @submit="if (!isValid) $event.preventDefault()"
            class="-mt-12 rounded-2xl bg-white p-6 shadow-[0px_4px_16px_0px_#0F172A14]">
            @csrf
            @method('PUT')

            <div class="mb-5">
                <label class="mb-2 block font-inter text-[13px] font-semibold text-black">Kata Sandi Saat Ini</label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="5" y="11" width="14" height="9" rx="2" />
                            <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                        </svg>
                    </span>
                    <input :type="showCurrent ? 'text' : 'password'" name="current_password"
                        x-model="currentPassword" placeholder="Masukkan kata sandi saat ini"
                        class="w-full rounded-lg border border-slate-200 bg-white py-3 pl-10 pr-10 font-inter text-sm text-black placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <button type="button" @click="showCurrent = !showCurrent"
                        class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600">
                        <svg x-show="!showCurrent" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        <svg x-show="showCurrent" x-cloak class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.6 21.6 0 0 1 5.06-5.94M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 7 11 7a21.6 21.6 0 0 1-2.61 3.61M14.12 14.12a3 3 0 1 1-4.24-4.24" />
                            <path d="M1 1l22 22" />
                        </svg>
                    </button>
                </div>
                @error('current_password')
                    <p class="mt-1.5 font-inter text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-5">
                <label class="mb-2 block font-inter text-[13px] font-semibold text-black">Kata Sandi Baru</label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="5" y="11" width="14" height="9" rx="2" />
                            <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                        </svg>
                    </span>
                    <input :type="showNew ? 'text' : 'password'" name="new_password"
                        x-model="newPassword" placeholder="Minimal 8 karakter"
                        class="w-full rounded-lg border border-slate-200 bg-white py-3 pl-10 pr-10 font-inter text-sm text-black placeholder:text-slate-400 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <button type="button" @click="showNew = !showNew"
                        class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600">
                        <svg x-show="!showNew" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        <svg x-show="showNew" x-cloak class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.6 21.6 0 0 1 5.06-5.94M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 7 11 7a21.6 21.6 0 0 1-2.61 3.61M14.12 14.12a3 3 0 1 1-4.24-4.24" />
                            <path d="M1 1l22 22" />
                        </svg>
                    </button>
                </div>
                <template x-if="newPassword.length > 0 && newPassword.length < 8">
                    <p class="mt-1.5 font-inter text-xs text-red-500">Kata sandi minimal 8 karakter</p>
                </template>
                @error('new_password')
                    <p class="mt-1.5 font-inter text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="mb-2 block font-inter text-[13px] font-semibold text-black">Konfirmasi Kata Sandi Baru</label>
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-slate-400">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <rect x="5" y="11" width="14" height="9" rx="2" />
                            <path d="M8 11V7a4 4 0 0 1 8 0v4" />
                        </svg>
                    </span>
                    <input :type="showConfirm ? 'text' : 'password'" name="new_password_confirmation"
                        x-model="confirmPassword" placeholder="Ulangi kata sandi baru"
                        class="w-full rounded-lg border py-3 pl-10 pr-10 font-inter text-sm text-black placeholder:text-slate-400 focus:outline-none focus:ring-1"
                        :class="passwordMismatch
                            ? 'border-red-300 focus:border-red-500 focus:ring-red-500'
                            : 'border-slate-200 focus:border-blue-500 focus:ring-blue-500'">
                    <button type="button" @click="showConfirm = !showConfirm"
                        class="absolute inset-y-0 right-3 flex items-center text-slate-400 hover:text-slate-600">
                        <svg x-show="!showConfirm" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                        <svg x-show="showConfirm" x-cloak class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 19c-7 0-11-7-11-7a21.6 21.6 0 0 1 5.06-5.94M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 7 11 7a21.6 21.6 0 0 1-2.61 3.61M14.12 14.12a3 3 0 1 1-4.24-4.24" />
                            <path d="M1 1l22 22" />
                        </svg>
                    </button>
                </div>
                <template x-if="passwordMismatch">
                    <p class="mt-1.5 font-inter text-xs text-red-500">Kata sandi tidak cocok</p>
                </template>
                @error('new_password_confirmation')
                    <p class="mt-1.5 font-inter text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('operator.profile.index') ?? url()->previous() }}"
                    class="flex items-center justify-center rounded-lg border border-blue-600 py-3 font-inter text-sm font-semibold text-blue-600 hover:bg-blue-50">
                    Batal
                </a>
                <button type="submit" :disabled="!isValid"
                    :class="isValid
                        ? 'bg-gradient-to-br from-[#2563ED] via-[#2251E3] to-[#1D4ED8] text-white hover:opacity-90 cursor-pointer'
                        : 'bg-slate-200 text-slate-400 cursor-not-allowed'"
                    class="flex items-center justify-center rounded-lg py-3 font-inter text-sm font-semibold transition-colors">
                    Konfirmasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection