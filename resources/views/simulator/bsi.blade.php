<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Syariah Indonesia VA Simulator - DOKU Sandbox</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fa;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <!-- Top DOKU-like Grey Header Banner -->
    <header class="bg-[#3e3e3f] text-white py-8 px-6 md:px-12 shadow-sm">
        <div class="max-w-6xl mx-auto space-y-1">
            <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-white">Bank Syariah Indonesia VA Simulator</h1>
            <p class="text-xs md:text-sm text-gray-300 font-medium">You can simulate the payment with Bank Syariah Indonesia Virtual Account</p>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-1 max-w-6xl w-full mx-auto p-4 md:p-8 flex flex-col md:flex-row gap-8 justify-center items-start mt-4">
        
        <!-- Left Side: Interactive Checkout Card (DOKU Styled) -->
        <div class="w-full md:w-3/5 bg-white rounded-lg border border-gray-200 shadow-sm p-6 md:p-8 space-y-6">
            
            <!-- BSI Logo & Description -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-gray-100 pb-4 gap-4">
                <div class="flex items-center gap-3">
                    <!-- Clean Mock BSI Logo -->
                    <div class="w-12 h-12 bg-teal-600 rounded-xl flex items-center justify-center text-white font-black text-xs shadow-sm">
                        BSI
                    </div>
                    <div>
                        <h2 class="text-base font-bold text-gray-800">Bank Syariah Indonesia</h2>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Payment Simulator</p>
                    </div>
                </div>
                <div class="bg-gray-100 text-gray-600 text-[10px] px-3 py-1.5 rounded-full font-bold uppercase tracking-wide">
                    Sandbox Mode
                </div>
            </div>

            <p class="text-sm font-semibold text-gray-600">Please confirm the transaction below.</p>

            <!-- Simulator Input Form -->
            <div class="space-y-4 pt-2">
                <!-- Customer Name (Read-only or dynamic) -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Customer Name</label>
                    <input type="text" 
                           value="{{ $student ? $student->nama_lengkap : 'CALON PENDAFTAR PPDB' }}" 
                           class="w-full bg-gray-50 border border-gray-200 text-gray-800 font-bold rounded-lg px-4 py-3 text-sm focus:outline-none"
                           readonly>
                </div>

                <!-- Virtual Account Input -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Virtual Account Number</label>
                    <input type="text" 
                           id="va_input"
                           value="{{ $va }}" 
                           placeholder="Enter 10-digit BSI VA Number"
                           class="w-full bg-white border-2 border-gray-200 text-gray-900 font-mono font-bold rounded-lg px-4 py-3 text-sm focus:border-teal-500 focus:outline-none transition">
                </div>

                <!-- Amount Input -->
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Amount</label>
                    <div class="relative rounded-lg shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-gray-400 font-bold text-sm">IDR</span>
                        </div>
                        <input type="number" 
                               id="amount_input"
                               value="{{ $amount }}" 
                               class="w-full bg-white border-2 border-gray-200 text-gray-900 font-mono font-bold rounded-lg pl-14 pr-4 py-3 text-sm focus:border-teal-500 focus:outline-none transition">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="button" 
                            id="pay_btn"
                            class="w-full bg-[#c31f26] hover:bg-[#a6171d] text-white font-bold text-sm uppercase tracking-widest py-4 px-6 rounded-lg shadow-md transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                        <span>PAY NOW</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Side: Instructions sidebar (DOKU Styled) -->
        <div class="w-full md:w-2/5 bg-gray-50 border border-gray-100 rounded-lg p-6 space-y-4">
            <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider">ATM/M-Banking Guide</h3>
            <p class="text-xs text-gray-600 leading-relaxed">
                This is the sandbox screen that mimics the ATM / Mobile banking network when you are paying a Virtual Account. 
            </p>
            <div class="text-xs text-gray-500 space-y-2 pt-2 border-t border-gray-200/60 font-medium">
                <p>1. Enter the Virtual Account Number correctly from the Student Payment portal.</p>
                <p>2. Ensure the Amount matches the registration fee (Rp {{ number_format($amount, 0, ',', '.') }}).</p>
                <p>3. Click <b>PAY NOW</b> to dispatch the instant simulated webhook callback to the PPDB system.</p>
            </div>
        </div>
    </main>

    <!-- Success Modal Pop-up (Looks like DOKU's design but SUCCESS checkmark!) -->
    <div id="success_modal" 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-950/75 backdrop-blur-sm hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 p-8 flex flex-col items-center justify-center text-center space-y-6 transform scale-95 transition-all duration-300">
            
            <!-- Success Green Circle Check -->
            <div class="w-24 h-24 rounded-full bg-emerald-50 border-4 border-emerald-100 flex items-center justify-center text-emerald-500 animate-[bounce_1s_infinite]">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>

            <div class="space-y-2">
                <h3 class="text-xl font-bold text-gray-800">Transaction Success!</h3>
                <p class="text-xs text-gray-500 leading-relaxed font-medium">
                    Thank you for using DOKU as your payment service. It's our pleasure to help your payment.
                </p>
            </div>

            <!-- Transaction Details receipt -->
            <div class="w-full bg-gray-50 border border-gray-100 rounded-xl p-4 text-left font-mono text-[10px] text-gray-600 space-y-2">
                <div class="flex justify-between">
                    <span>Virtual Account:</span>
                    <span class="font-bold text-gray-800" id="receipt_va">-</span>
                </div>
                <div class="flex justify-between">
                    <span>Amount Paid:</span>
                    <span class="font-bold text-gray-800" id="receipt_amount">-</span>
                </div>
                <div class="flex justify-between">
                    <span>Status:</span>
                    <span class="font-bold text-emerald-600">SUCCESS (LUNAS)</span>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="w-full space-y-3 pt-2">
                @auth
                <a href="{{ route('siswa.payments.index') }}" 
                   class="block w-full bg-[#c31f26] hover:bg-[#a6171d] text-white text-xs font-bold uppercase tracking-widest py-3 px-6 rounded-lg shadow transition text-center">
                    RETURN TO PPDB PORTAL
                </a>
                @else
                <button type="button" onclick="window.close()" 
                   class="block w-full bg-[#c31f26] hover:bg-[#a6171d] text-white text-xs font-bold uppercase tracking-widest py-3 px-6 rounded-lg shadow transition">
                    CLOSE WINDOW
                </button>
                @endauth
            </div>
        </div>
    </div>

    <!-- Error Modal Pop-up (DOKU Style for Invalid VA) -->
    <div id="error_modal" 
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-gray-950/75 backdrop-blur-sm hidden">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 p-8 flex flex-col items-center justify-center text-center space-y-6">
            
            <!-- Red X mark -->
            <div class="w-24 h-24 rounded-full bg-red-50 border-4 border-red-100 flex items-center justify-center text-red-500 animate-pulse">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>

            <div class="space-y-2">
                <h3 class="text-xl font-bold text-gray-800">Transaction Not Found!</h3>
                <p class="text-xs text-gray-500 leading-relaxed font-medium">
                    Thank you for using DOKU as your payment service. It's our pleasure to help your payment.
                </p>
            </div>

            <!-- Action buttons -->
            <div class="w-full space-y-3 pt-2">
                <button type="button" 
                        onclick="closeErrorModal()"
                        class="block w-full bg-[#c31f26] hover:bg-[#a6171d] text-white text-xs font-bold uppercase tracking-widest py-3 px-6 rounded-lg shadow transition">
                    NEW TRANSACTION
                </button>
            </div>
        </div>
    </div>

    <!-- Script to handle dynamic interactive API submission -->
    <script>
        const payBtn = document.getElementById('pay_btn');
        const vaInput = document.getElementById('va_input');
        const amountInput = document.getElementById('amount_input');
        const successModal = document.getElementById('success_modal');
        const errorModal = document.getElementById('error_modal');

        const officialVa = '{{ $va }}';

        payBtn.addEventListener('click', function() {
            const enteredVa = vaInput.value.trim();
            const enteredAmount = amountInput.value.trim();

            if (!enteredVa || !enteredAmount) {
                alert('Please enter both Virtual Account and Amount.');
                return;
            }

            // DOKU Sandbox validation: if the VA doesn't match the configured official VA in PPDB settings, fail!
            if (enteredVa !== officialVa) {
                errorModal.classList.remove('hidden');
                return;
            }

            // Send ajax request back to the system to mark lunas
            payBtn.innerHTML = 'PROCESSING...';
            payBtn.disabled = true;

            fetch('{{ route('simulator.bsi.pay') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    va_number: enteredVa,
                    amount: enteredAmount
                })
            })
            .then(res => res.json())
            .then(data => {
                payBtn.innerHTML = 'PAY NOW';
                payBtn.disabled = false;

                if (data.success) {
                    // Populate Receipt details
                    document.getElementById('receipt_va').innerText = enteredVa;
                    document.getElementById('receipt_amount').innerText = 'IDR ' + parseInt(enteredAmount).toLocaleString('id-ID');
                    
                    // Show success modal
                    successModal.classList.remove('hidden');
                } else {
                    alert('Simulation failed: ' + data.message);
                }
            })
            .catch(err => {
                payBtn.innerHTML = 'PAY NOW';
                payBtn.disabled = false;
                console.error(err);
                alert('Connection error occurred while contacting simulator gateway.');
            });
        });

        function closeErrorModal() {
            errorModal.classList.add('hidden');
        }
    </script>
</body>
</html>
