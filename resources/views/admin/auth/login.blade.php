<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Login — AsproHubs</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'DM Sans', sans-serif; }

        .glass-card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .input-field {
            width: 100%;
            background: rgba(255, 255, 255, 0.07);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 11px 16px;
            font-size: 14px;
            color: #fff;
            outline: none;
            transition: border-color .2s, background .2s;
        }
        .input-field::placeholder { color: #3d5166; }
        .input-field:focus {
            border-color: #4f46e5;
            background: rgba(79, 70, 229, 0.08);
        }

        .glow-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4"
      style="background: #070d18">

    {{-- Ambient blobs --}}
    <div class="glow-blob w-96 h-96 opacity-20 -top-20 -left-20"
         style="background: #4f46e5; position: fixed;"></div>
    <div class="glow-blob w-80 h-80 opacity-10 bottom-0 right-0"
         style="background: #7c3aed; position: fixed;"></div>
    <div class="glow-blob w-64 h-64 opacity-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2"
         style="background: #06b6d4; position: fixed;"></div>

    <div class="relative w-full max-w-[400px]">

        {{-- Card --}}
        <div class="glass-card rounded-2xl px-8 py-10 shadow-2xl relative overflow-hidden">

            {{-- Top gradient line --}}
            <div class="absolute top-0 left-0 right-0 h-px"
                 style="background: linear-gradient(90deg, transparent, #4f46e5, #7c3aed, transparent)"></div>

            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="mx-auto mb-5 flex h-14 w-14 items-center justify-center rounded-2xl"
                     style="background: linear-gradient(135deg, #4f46e5, #7c3aed)">
                    <svg width="24" height="24" fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-extrabold text-white" style="font-family:'Syne',sans-serif;">
                    Admin Portal
                </h1>
                <p class="mt-1.5 text-sm" style="color: #4a6080;">
                    AsproHubs — Authorised Access Only
                </p>
            </div>

            {{-- Session status --}}
            @if(session('status'))
            <div class="mb-5 rounded-xl px-4 py-3 text-sm font-medium"
                 style="background: rgba(16,185,129,.15); border: 1px solid rgba(16,185,129,.3); color: #6ee7b7;">
                {{ session('status') }}
            </div>
            @endif

            {{-- Error --}}
            @if($errors->any())
            <div class="mb-5 rounded-xl px-4 py-3 text-sm font-medium"
                 style="background: rgba(239,68,68,.15); border: 1px solid rgba(239,68,68,.3); color: #fca5a5;">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold mb-2" style="color: #7c8fa6;">
                        EMAIL ADDRESS
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="email"
                           placeholder="admin@asprohubs.com"
                           class="input-field" />
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-xs font-semibold mb-2" style="color: #7c8fa6;">
                        PASSWORD
                    </label>
                    <input type="password" name="password"
                           required autocomplete="current-password"
                           placeholder="••••••••••••"
                           class="input-field" />
                </div>

                {{-- Remember --}}
                <div class="flex items-center gap-2.5">
                    <input id="remember" type="checkbox" name="remember"
                           class="h-4 w-4 rounded border-white/20 bg-white/10 text-indigo-600" />
                    <label for="remember" class="text-sm select-none" style="color: #4a6080;">
                        Keep me signed in for 30 days
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full rounded-xl py-3 text-sm font-bold text-white shadow-lg
                               transition hover:opacity-90 active:scale-[0.98]"
                        style="background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%)">
                    Sign In to Admin Panel
                </button>
            </form>

            {{-- Footer link --}}
            <div class="mt-7 pt-6 text-center"
                 style="border-top: 1px solid rgba(255,255,255,.06)">
                <a href="{{ route('home') }}"
                   class="text-xs transition hover:text-slate-300"
                   style="color: #2d4060;">
                    ← Back to AsproHubs website
                </a>
            </div>
        </div>

        <p class="mt-4 text-center text-xs" style="color: #1e2d3d;">
            Protected area — unauthorised access is prohibited
        </p>
    </div>

</body>
</html>