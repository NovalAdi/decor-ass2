<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Decor</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen w-full bg-[#F0E7E1]">

    <section class="flex justify-evenly items-center min-h-screen p-4">

        <form action="{{ route('register.post') }}" method="POST" class="w-full md:w-[40vw] lg:w-[30vw] flex flex-col gap-10">
            @csrf

            <img src="{{ asset('img/logo-decor.svg') }}" alt="Decor Logo" class="w-[200px] self-start">

            <div>
                <div class="flex flex-col gap-2">
                    <label for="name">Username</label>
                    <input type="text" id="name" name="name" placeholder="username"
                        class="p-2 border-[1.5px] border-gray-400 rounded-lg focus:ring-[#B5733A] focus:border-[#B5733A]">
                </div>

                <div class="flex flex-col mt-4 gap-2">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="email"
                        class="p-2 border-[1.5px] border-gray-400 rounded-lg focus:ring-[#B5733A] focus:border-[#B5733A]">
                </div>

                <div class="flex flex-col mt-4 gap-2">
                    <label for="password">Password</label>
                    <div class="flex flex-col relative">
                        <input id="input" type="password" name="password" placeholder="Password"
                            class="p-2 border-[1.5px] border-gray-400 rounded-lg focus:ring-[#B5733A] focus:border-[#B5733A]">

                        <a id="eye" class="h-full absolute right-3 flex items-center cursor-pointer">
                            <img id="eye-img" src="{{ asset('img/hide.png') }}" alt="Toggle Password Visibility"
                                width="25px">
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3">

                <button type="submit"
                    class="w-full text-white py-2 rounded-lg bg-[#B5733A] hover:bg-[#A36632] transition duration-200 shadow-md">
                    Register
                </button>

                <p class="self-center">
                    or
                    <a href="{{ route('login') }}"
                        class="text-[#B5733A] hover:text-[#A36632] font-semibold transition duration-200">
                        Login
                    </a>
                </p>
            </div>
        </form>

        <img src="{{ asset('img/Group_15.svg') }}" alt="Decor Illustration" class="hidden lg:block w-[430px]">
    </section>

    <script>
        let eye = document.getElementById('eye')
        let eyeImg = document.getElementById('eye-img')
        let input = document.getElementById('input')
        let isVisible = false
        eye.addEventListener('click', () => {
            isVisible = !isVisible
            if (isVisible) {
                eyeImg.setAttribute('src', "img/view.png")
                input.setAttribute('type', 'text')

            } else {
                eyeImg.setAttribute('src', "img/hide.png")
                input.setAttribute('type', 'password')
            }

        })
    </script>
</body>

</html>
