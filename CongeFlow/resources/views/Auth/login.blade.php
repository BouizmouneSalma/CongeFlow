<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CongeFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .bg-gradient-animate {
            background: linear-gradient(-45deg, #f0f8ff, #e6f2ff, #dce9ff, #d4e5ff);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.25);
        }
        
        .login-card {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .btn-login {
            transition: all 0.3s ease;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-gradient-animate">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <div class="max-w-md w-full space-y-8 p-8 sm:p-10 bg-white rounded-2xl shadow-lg login-card backdrop-blur-sm bg-opacity-95">
            <div class="text-center">
                <div class="inline-block p-4 bg-blue-50 rounded-full mb-3">
                    <i class="fas fa-calendar-alt text-blue-600 text-4xl"></i>
                </div>
                <h2 class="mt-4 text-3xl font-extrabold text-gray-900">
                    CongeFlow
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Connectez-vous à votre compte
                </p>
            </div>
            
            @if ($errors->any())
            <div class="mt-4 bg-red-50 border border-red-200 rounded-lg p-4 text-red-700">
                <div class="flex items-center mb-1">
                    <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                    <span class="font-medium">Attention</span>
                </div>
                <ul class="pl-6 list-disc text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-blue-500 opacity-70"></i>
                            </div>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" required 
                                class="appearance-none block w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 input-focus" 
                                placeholder="Adresse email">
                        </div>
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Mot de passe</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-blue-500 opacity-70"></i>
                            </div>
                            <input id="password" name="password" type="password" required 
                                class="appearance-none block w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg placeholder-gray-400 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 input-focus" 
                                placeholder="Mot de passe">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" 
                            class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition duration-150 ease-in-out cursor-pointer">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-700 cursor-pointer hover:text-gray-900">
                            Se souvenir de moi
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-700 transition-colors duration-200">
                            Mot de passe oublié?
                        </a>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" 
                        class="btn-login group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md hover:shadow-lg transition-all duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-4">
                            <i class="fas fa-sign-in-alt text-blue-400 group-hover:text-blue-300 transition-colors"></i>
                        </span>
                        <span class="ml-2">Se connecter</span>
                    </button>
                </div>
            </form>
            
            <div class="mt-8">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-3 bg-white text-gray-500">
                            Besoin d'aide?
                        </span>
                    </div>
                </div>

                <div class="mt-6 text-center text-sm">
                    <p class="text-gray-600">
                        Contactez votre administrateur système ou le service RH
                    </p>
                </div>
            </div>
        </div>
        
        <div class="mt-6 text-center text-xs text-gray-600">
            &copy; {{ date('Y') }} CongeFlow - Tous droits réservés
        </div>
    </div>
</body>
</html>