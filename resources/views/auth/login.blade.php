@extends('layouts.app')

@section('title', 'Client Sign In — AURELIA ATELIER')

@section('content')

    <div class="min-h-[70vh] flex items-center justify-center py-16 px-4 sm:px-6 lg:px-8 bg-[#FAFAF8]">
        <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 border border-zinc-200 shadow-md">
            <!-- Header -->
            <div class="text-center">
                <span class="text-[10px] uppercase tracking-[0.25em] text-zinc-400 font-bold block mb-1">Aurelia Client Access</span>
                <h1 class="font-serif-luxury text-3xl text-zinc-950 font-normal">Sign In to Your Account</h1>
                <p class="text-xs text-zinc-500 mt-2">Access your order archive, bespoke sizing, and wishlist.</p>
            </div>

            <!-- Demo 1-Click Login Box (Super helpful for review!) -->
            <div class="p-4 bg-amber-50/70 border border-amber-200/80 text-xs space-y-2.5">
                <div class="flex items-center gap-2 text-amber-900 font-bold uppercase tracking-wider text-[10px]">
                    <i class="fa-solid fa-wand-magic-sparkles"></i> One-Click Demo Access
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('demo.login', 'admin') }}" class="block text-center py-2 px-3 bg-zinc-950 text-white rounded text-[11px] font-semibold hover:bg-zinc-800 transition">
                        <i class="fa-solid fa-gauge-high mr-1 text-amber-400"></i> Admin Studio
                    </a>
                    <a href="{{ route('demo.login', 'customer') }}" class="block text-center py-2 px-3 bg-white border border-zinc-300 text-zinc-900 rounded text-[11px] font-semibold hover:border-zinc-900 transition">
                        <i class="fa-regular fa-user mr-1 text-zinc-500"></i> Client Demo
                    </a>
                </div>
                <p class="text-[10px] text-zinc-500 text-center">Instantly authenticate without entering passwords.</p>
            </div>

            <!-- Standard Form -->
            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div class="text-xs">
                    <label class="block font-semibold text-zinc-700 mb-1">Email Address</label>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="admin@aurelia.com" class="w-full px-3.5 py-2.5 border border-zinc-300 text-xs focus:outline-none focus:border-zinc-900 font-medium">
                    @error('email')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="text-xs">
                    <div class="flex justify-between items-center mb-1">
                        <label class="block font-semibold text-zinc-700">Password</label>
                    </div>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-3.5 py-2.5 border border-zinc-300 text-xs focus:outline-none focus:border-zinc-900 font-medium">
                    @error('password')
                        <p class="text-[11px] text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-zinc-300 text-zinc-900 focus:ring-0">
                        <span class="text-zinc-600 font-medium">Remember my session</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 bg-zinc-950 text-white text-xs uppercase tracking-[0.2em] font-bold hover:bg-zinc-800 transition shadow-md">
                    Sign In to Atelier
                </button>
            </form>

            <div class="pt-4 border-t border-zinc-100 text-center text-xs text-zinc-500">
                <span>New to Aurelia?</span>
                <a href="{{ route('register') }}" class="font-bold text-zinc-900 underline ml-1 hover:text-zinc-700">Create an Account</a>
            </div>
        </div>
    </div>

@endsection
