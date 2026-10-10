<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QRIS Gateway Merchant Simulator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #0f172a;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <!-- Card Container -->
    <div class="bg-slate-900 border border-slate-800 text-white rounded-[32px] w-full max-w-md overflow-hidden shadow-2xl relative">
        
        <!-- Glowing gradient accent -->
        <div class="absolute -right-16 -top-16 w-36 h-36 bg-indigo-500/10 rounded-full blur-2xl"></div>
        <div class="absolute -left-16 -bottom-16 w-36 h-36 bg-pink-500/10 rounded-full blur-2xl"></div>

        <!-- Header -->
        <div class="p-6 pb-4 border-b border-slate-800/80 bg-slate-950/40 relative z-10 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center font-black text-xs text-white">QR</div>
                <div>
                    <h1 class="text-sm font-black uppercase tracking-wider">QRIS Merchant Simulator</h1>
                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">Gateway Sandbox</p>
                </div>
            </div>
            <span class="bg-indigo-500/10 text-indigo-400 text-[9px] px-2.5 py-1 rounded-full font-black border border-indigo-500/20">LIVE DEMO</span>
        </div>

        <!-- Body -->
        <div class="p-6 space-y-6 relative z-10">
            <!-- Merchant & Price details -->
            <div class="text-center space-y-2">
                <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">Pembayaran Ke</p>
                <h2 class="text-lg font-black text-white">SMP MUHAMMADIYAH KALIWIRO</h2>
                <div class="text-2xl font-black text-indigo-400 mt-2 font-mono">
                    Rp {{ number_format($amount, 0, ',', '.') }}
                </div>
            </div>

            <!-- Fake Scanning Viewfinder -->
            <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 flex flex-col items-center justify-center relative overflow-hidden h-48 shadow-inner">
                <!-- Vertical scanning laser line -->
                <div class="absolute inset-x-0 h-1 bg-indigo-500 shadow-lg shadow-indigo-500/80 animate-[bounce_2s_infinite]" style="top: 25%"></div>
                
                <svg class="w-20 h-20 text-indigo-500/20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h3a1 1 0 010 2H5v2a1 1 0 01-2 0V4zm14 0a1 1 0 00-1-1h-3a1 1 0 110 2h2v2a1 1 0 112 0V4zM3 16a1 1 0 001 1h3a1 1 0 100-2H5v-2a1 1 0 10-2 0v3zm14 0a1 1 0 01-1 1h-3a1 1 0 110-2h2v-2a1 1 0 112 0v3z" clip-rule="evenodd"></path></svg>
                <span class="text-gray-400 font-mono text-[9px] mt-4 font-bold tracking-widest uppercase animate-pulse">MENUNGGU SCANNING...</span>
            </div>

            <!-- Pay Button -->
            <button type="button" 
                    id="pay_btn"
                    class="w-full bg-gradient-to-r from-indigo-600 to-pink-600 hover:from-indigo-700 hover:to-pink-700 text-white font-black text-xs uppercase tracking-widest py-4 px-6 rounded-2xl shadow-lg shadow-indigo-600/20 active:scale-95 transition-all flex items-center justify-center gap-2">
                <span>SIMULASIKAN BAYAR DENGAN HP 📱</span>
            </button>
        </div>
    </div>

    <!-- Success Modal Pop-up -->
    <div id="success_modal" 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm hidden">
        <div class="bg-slate-900 border border-slate-800 rounded-[32px] w-full max-w-md p-8 flex flex-col items-center justify-center text-center space-y-6 transform scale-95 transition-all">
            
            <!-- Success Icon -->
            <div class="w-20 h-20 rounded-full bg-emerald-500/10 border-4 border-emerald-500/20 flex items-center justify-center text-emerald-400 animate-bounce">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>

            <div class="space-y-2">
                <h3 class="text-xl font-black text-white">QRIS Scan Berhasil!</h3>
                <p class="text-xs text-gray-400 leading-relaxed font-bold">
                    Pembayaran PPDB SMP Muhammadiyah Kaliwiro telah sukses diselesaikan.
                </p>
            </div>

            <!-- Receipt Info -->
            <div class="w-full bg-slate-950 border border-slate-850 rounded-2xl p-4 text-left font-mono text-[10px] text-gray-400 space-y-2">
                <div class="flex justify-between">
                    <span>Merchant:</span>
                    <span class="font-bold text-white">SMP MUHAMMADIYAH KALIWIRO</span>
                </div>
                <div class="flex justify-between">
                    <span>Jumlah:</span>
                    <span class="font-bold text-indigo-400">Rp {{ number_format($amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Status:</span>
                    <span class="font-bold text-emerald-400">PAID (LUNAS)</span>
                </div>
            </div>

            <div class="w-full space-y-3 pt-2">
                @auth
                <a href="{{ route('siswa.payments.index') }}" 
                   class="block w-full bg-gradient-to-r from-indigo-600 to-pink-600 hover:from-indigo-700 hover:to-pink-700 text-white text-xs font-black uppercase tracking-widest py-3 px-6 rounded-xl shadow transition text-center">
                    KEMBALI KE PORTAL PPDB
                </a>
                @else
                <button type="button" onclick="window.close()" 
                   class="block w-full bg-gradient-to-r from-indigo-600 to-pink-600 hover:from-indigo-700 hover:to-pink-700 text-white text-xs font-black uppercase tracking-widest py-3 px-6 rounded-xl shadow transition">
                    CLOSE WINDOW
                </button>
                @endauth
            </div>
        </div>
    </div>

    <!-- Script to handle dynamic interactive API submission -->
    <script>
        const payBtn = document.getElementById('pay_btn');
        const successModal = document.getElementById('success_modal');

        payBtn.addEventListener('click', function() {
            payBtn.innerHTML = 'MEMPROSES TRANSAKSI...';
            payBtn.disabled = true;

            fetch('{{ route('simulator.qris.pay') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                payBtn.innerHTML = 'BAYAR SEKARANG';
                payBtn.disabled = false;

                if (data.success) {
                    successModal.classList.remove('hidden');
                } else {
                    alert('Simulation failed: ' + data.message);
                }
            })
            .catch(err => {
                payBtn.innerHTML = 'BAYAR SEKARANG';
                payBtn.disabled = false;
                console.error(err);
                alert('Connection error occurred while contacting simulator gateway.');
            });
        });
    </script>
</body>
</html>
