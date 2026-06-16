<x-app-layout>
    <div class="py-12 bg-gray-100 min-h-[calc(100vh-64px)] flex items-center justify-center p-4">
        <div class="bg-white shadow-xl rounded-[1.5rem] border border-gray-100 overflow-hidden"
             style="width: 100%; max-width: 420px; margin: 0 auto;">
            <div class="p-8 flex flex-col items-center text-center">
                <div class="flex justify-center mb-4">
                    <div class="p-3 bg-orange-50 rounded-xl">
                        <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.105.895-2 2-2s2 .895 2 2-.895 2-2 2-2-.895-2-2zm-8 2h5m6 0h5M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>

                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Security Setup</h2>
                <p style="font-size: 13px !important;" class="text-gray-500 mt-2 max-w-[320px]">
                    This portal no longer uses an additional security setup screen. You can continue managing your account from the dashboard.
                </p>

                <a href="{{ route('admin.dashboard') }}"
                   class="mt-6 inline-flex items-center justify-center rounded-full bg-orange-500 px-6 py-3 text-sm font-bold text-white hover:bg-slate-900 transition">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
