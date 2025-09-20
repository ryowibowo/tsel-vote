<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Traction Day - Voting</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url('{{ asset('img/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh
        }

        @media (max-width: 1366px) {
            body {
                background-image: url('{{ asset('img/background-tablet.jpg') }}')
            }
        }

        @media (max-width: 767px) {
            body {
                background-image: url('{{ asset('img/background-mobile.jpg') }}')
            }
        }

        .glass-container {
            background: rgba(0, 0, 0, .25);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, .1)
        }

        .vote-card {
            transition: all .3s ease;
            cursor: pointer;
        }

        .vote-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, .2)
        }

        .vote-card.selected {
            transform: translateY(-5px);
            box-shadow: 0 0 20px 5px rgba(255, 255, 100, 0.7);
            border-color: rgba(255, 255, 100, 0.9);
        }

        .vote-card.maxed {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>

<body class="text-white">
    <header id="mainHeader" class="p-4 md:px-8 md:py-4 flex-shrink-0">
        <img src="{{ asset('img/main-logo.png') }}" alt="Traction Day" class="w-48 md:w-64 h-auto">
    </header>

    <main class="w-full px-4 pb-8">
        <section id="loginSection" class="w-full max-w-md mx-auto">
            <div class="glass-container p-8 rounded-2xl shadow-lg">
                <form id="loginForm" class="space-y-6">
                    <div>
                        <label for="fullName" class="block text-sm font-medium mb-1">Full Name:</label>
                        <input type="text" id="fullName" name="fullName" placeholder="Please enter your full name"
                            required
                            class="w-full bg-gray-900/50 border border-gray-600 rounded-lg px-4 py-2 text-white">
                    </div>
                    <div>
                        <label for="nik" class="block text-sm font-medium mb-1">Employee ID:</label>
                        <input type="number" id="nik" name="nik" placeholder="Please enter your employee ID"
                            required
                            class="w-full bg-gray-900/50 border border-gray-600 rounded-lg px-4 py-2 text-white">
                    </div>
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg">Enter</button>
                </form>
            </div>
        </section>

        <section id="votingSection" class="hidden w-full max-w-7xl mx-auto mt-8">
            <div class="flex flex-col md:flex-row md:space-x-6">

                <div class="flex-1 mb-8 md:mb-0">
                    <h2 class="text-xl font-bold text-center mb-4">FIXED</h2>
                    @if ($fixedCategory && $fixedCategory->products->isNotEmpty())
                        <div id="fixedGrid" class="grid grid-cols-3 grid-rows-4 gap-4">
                            @foreach ($fixedCategory->products as $product)
                                <div data-id="{{ $product->id }}" data-category="fixed"
                                    class="vote-card bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg text-white border border-white/20 flex flex-col p-3">
                                    {{-- UBAH DI SINI: ganti bg-cover jadi bg-contain bg-no-repeat --}}
                                    <div class="h-24 w-full rounded-lg shadow-inner mb-2 bg-white bg-contain bg-center bg-no-repeat"
                                        @if ($product->image) style="background-image: url('{{ asset($product->image) }}')" @endif>
                                    </div>
                                    <h3
                                        class="text-xs font-semibold flex-grow flex items-center justify-center leading-tight text-center">
                                        {{ $product->name }}</h3>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="hidden md:block border-l-2 border-white/30"></div>

                <div class="flex-1">
                    <h2 class="text-xl font-bold text-center mb-4">MOBILE</h2>
                    @if ($mobileCategory && $mobileCategory->products->isNotEmpty())
                        <div id="mobileGrid" class="grid grid-cols-3 grid-rows-4 gap-4">
                            @foreach ($mobileCategory->products as $product)
                                <div data-id="{{ $product->id }}" data-category="mobile"
                                    class="vote-card bg-white/10 backdrop-blur-lg rounded-2xl shadow-lg text-white border border-white/20 flex flex-col p-3">
                                    {{-- UBAH DI SINI JUGA --}}
                                    <div class="h-24 w-full rounded-lg shadow-inner mb-2 bg-white bg-contain bg-center bg-no-repeat"
                                        @if ($product->image) style="background-image: url('{{ asset($product->image) }}')" @endif>
                                    </div>
                                    <h3
                                        class="text-xs font-semibold flex-grow flex items-center justify-center leading-tight text-center">
                                        {{ $product->name }}</h3>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-12 text-center">
                <button id="finishVoteBtn"
                    class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-12 rounded-lg text-xl transition-all">
                    FINISH
                </button>
            </div>
        </section>

        <section id="thankYouSection"
            class="hidden fixed inset-0 bg-red-900/50 backdrop-blur-sm flex items-center justify-center p-4">
            {{-- Konten Thank You tidak berubah --}}
        </section>
    </main>

    <script>
        const loginSection = document.getElementById("loginSection"),
            votingSection = document.getElementById("votingSection"),
            thankYouSection = document.getElementById("thankYouSection"),
            mainHeader = document.getElementById("mainHeader"),
            loginForm = document.getElementById("loginForm"),
            finishVoteBtn = document.getElementById("finishVoteBtn"),
            fixedTokenCounter = document.getElementById("fixedTokenCounter"),
            mobileTokenCounter = document.getElementById("mobileTokenCounter");
        let selectedFixed = [],
            selectedMobile = [];
        async function checkNikAvailability(nik) {
            const t = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            try {
                const n = await fetch("{{ route('voting.checkNik') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': t
                    },
                    body: JSON.stringify({
                        nik: nik
                    })
                });
                return (await n.json()).exists
            } catch (o) {
                return console.error("Failed to check Employee ID:", o), !0
            }
        }
        document.addEventListener('DOMContentLoaded', async () => {
            const nikFromUrl = @json($nikFromUrl),
                nameFromUrl = @json($nameFromUrl);
            if (nikFromUrl && nameFromUrl) {
                Swal.fire({
                    title: 'Validating link...',
                    background: '#374151',
                    color: '#FFFFFF',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading()
                    }
                });
                const isNikUsed = await checkNikAvailability(nikFromUrl);
                Swal.close();
                if (isNikUsed) {
                    loginSection.classList.add("hidden");
                    Swal.fire({
                        icon: 'warning',
                        title: 'Link Already Used',
                        text: 'The Employee ID associated with this link has already been used to vote.',
                        background: '#374151',
                        color: '#FFFFFF'
                    })
                } else {
                    document.getElementById('nik').value = nikFromUrl;
                    document.getElementById('fullName').value = nameFromUrl;
                    loginSection.classList.add("hidden");
                    votingSection.classList.remove("hidden")
                }
            }
        });
        loginForm.addEventListener("submit", async e => {
            e.preventDefault();
            const t = document.getElementById('fullName').value,
                n = document.getElementById('nik').value;
            if (!t || !n) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Full Name and Employee ID are required!',
                    background: '#374151',
                    color: '#FFFFFF'
                });
                return
            }
            Swal.fire({
                title: 'Checking Employee ID...',
                background: '#374151',
                color: '#FFFFFF',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            const o = await checkNikAvailability(n);
            Swal.close();
            o ? Swal.fire({
                icon: 'error',
                title: 'Access Denied',
                text: 'This Employee ID has already been used to vote.',
                background: '#374151',
                color: '#FFFFFF'
            }) : (loginSection.classList.add("hidden"), votingSection.classList.remove("hidden"))
        });
        document.querySelectorAll('.vote-card').forEach(card => {
            card.addEventListener('click', () => {
                const id = card.dataset.id,
                    category = card.dataset.category;
                if (category === 'fixed') {
                    if (selectedFixed.includes(id)) {
                        selectedFixed = selectedFixed.filter(i => i !== id);
                        card.classList.remove('selected')
                    } else if (selectedFixed.length < 5) {
                        selectedFixed.push(id);
                        card.classList.add('selected')
                    }
                } else if (category === 'mobile') {
                    if (selectedMobile.includes(id)) {
                        selectedMobile = selectedMobile.filter(i => i !== id);
                        card.classList.remove('selected')
                    } else if (selectedMobile.length < 5) {
                        selectedMobile.push(id);
                        card.classList.add('selected')
                    }
                }
                updateUI()
            })
        });

        function updateUI() {
            if (document.getElementById("fixedTokenCounter")) {
                document.getElementById("fixedTokenCounter").textContent = 5 - selectedFixed.length
            }
            if (document.getElementById("mobileTokenCounter")) {
                document.getElementById("mobileTokenCounter").textContent = 5 - selectedMobile.length
            }
            document.querySelectorAll('#fixedGrid .vote-card').forEach(c => {
                if (selectedFixed.length >= 5 && !selectedFixed.includes(c.dataset.id)) c.classList.add('maxed');
                else c.classList.remove('maxed')
            });
            document.querySelectorAll('#mobileGrid .vote-card').forEach(c => {
                if (selectedMobile.length >= 5 && !selectedMobile.includes(c.dataset.id)) c.classList.add('maxed');
                else c.classList.remove('maxed')
            })
        }
        finishVoteBtn.addEventListener('click', async () => {
            const fixedNeeded = 5 - selectedFixed.length,
                mobileNeeded = 5 - selectedMobile.length;
            if (fixedNeeded > 0 || mobileNeeded > 0) {
                let errorMsg = 'Vote incomplete!\n\n';
                if (fixedNeeded > 0) errorMsg +=
                    `- You still need to cast ${fixedNeeded} vote(s) in the FIXED category.\n`;
                if (mobileNeeded > 0) errorMsg +=
                    `- You still need to cast ${mobileNeeded} vote(s) in the MOBILE category.`;
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMsg,
                    background: '#374151',
                    color: '#FFFFFF'
                });
                return
            }
            mainHeader.classList.add('hidden');
            votingSection.classList.add('hidden');
            Swal.fire({
                title: 'Submitting Votes...',
                text: 'Please wait.',
                background: '#374151',
                color: '#FFFFFF',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
            const fullName = document.getElementById('fullName').value,
                nik = document.getElementById('nik').value,
                csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            try {
                const response = await fetch("{{ route('voting.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        full_name: fullName,
                        nik: nik,
                        fixed_ids: selectedFixed,
                        mobile_ids: selectedMobile
                    })
                });
                const result = await response.json();
                Swal.close();
                if (result.success) {
                    thankYouSection.classList.remove('hidden')
                } else {
                    mainHeader.classList.remove('hidden');
                    votingSection.classList.remove('hidden');
                    Swal.fire({
                        icon: 'error',
                        title: 'Vote Failed',
                        text: result.message || 'An error occurred.',
                        background: '#374151',
                        color: '#FFFFFF'
                    });
                    if (result.message && result.message.includes('Employee ID')) {
                        setTimeout(() => window.location.reload(), 2000)
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                mainHeader.classList.remove('hidden');
                votingSection.classList.remove('hidden');
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Could not connect to the server.',
                    background: '#374151',
                    color: '#FFFFFF'
                })
            }
        });
    </script>
</body>

</html>
