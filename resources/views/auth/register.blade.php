@extends('layouts.app')

@section('title', 'Create Client Account — AURELIA ATELIER')

@section('content')

    <div class="min-h-[70vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8 bg-[#FAFAF8]">
        <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 border border-zinc-200 shadow-md">
            <div class="text-center">
                <span class="text-[10px] uppercase tracking-[0.25em] text-zinc-400 font-bold block mb-1">Aurelia Membership</span>
                <h1 class="font-serif-luxury text-3xl text-zinc-950 font-normal">Create Client Account</h1>
                <p class="text-xs text-zinc-500 mt-2">Enjoy private runway previews and bespoke order history.</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div class="text-xs">
                    <label class="block font-semibold text-zinc-700 mb-1">Full Name *</label>
                    <input type="text" name="name" required value="{{ old('name') }}" placeholder="Sophia Laurent" class="w-full px-3.5 py-2.5 border border-zinc-300 text-xs focus:outline-none focus:border-zinc-900 font-medium">
                    @error('name')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-xs">
                    <label class="block font-semibold text-zinc-700 mb-1">Email Address *</label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="sophia@example.com" class="w-full px-3.5 py-2.5 border border-zinc-300 text-xs focus:outline-none focus:border-zinc-900 font-medium">
                    @error('email')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-xs">
                    <label class="block font-semibold text-zinc-700 mb-1">Password * (Min. 6 Characters)</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-3.5 py-2.5 border border-zinc-300 text-xs focus:outline-none focus:border-zinc-900 font-medium">
                    @error('password')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-xs">
                    <label class="block font-semibold text-zinc-700 mb-1">Confirm Password *</label>
                    <input type="password" name="password_confirmation" required placeholder="••••••••" class="w-full px-3.5 py-2.5 border border-zinc-300 text-xs focus:outline-none focus:border-zinc-900 font-medium">
                </div>

                <button type="submit" class="w-full py-3.5 bg-zinc-950 text-white text-xs uppercase tracking-[0.2em] font-bold hover:bg-zinc-800 transition shadow-md">
                    Create Account
                </button>
            </form>

            <div class="pt-4 border-t border-zinc-100 text-center text-xs text-zinc-500">
                <span>Already registered with us?</span>
                <a href="{{ route('login') }}" class="font-bold text-zinc-900 underline ml-1 hover:text-zinc-700">Sign In</a>
            </div>
        </div>
    </div>

@endsection
