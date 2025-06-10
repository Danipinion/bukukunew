<div class="flex justify-between">
    <div class="flex flex-col justify-center items-center w-[43%] h-screen -mt-32">
        <img src="<?= BASEURL; ?>/img/logo.png" alt="logo" class="w-[300px]" />
        <h1 class="text-[64px] uppercase font-bold">Bacain</h1>
    </div>
    <div class="flex flex-col justify-center items-center w-[45%]">
        <img
            src="<?= BASEURL; ?>/img/background.svg"
            alt=""
            class="h-screen fixed top-0 right-0 -z-20" />
        <h1 class="text-[#FFC857] text-[64px] uppercase font-bold pt-24">
            Register
        </h1>
        <div>
            <?php Flasher::flash(); ?>
        </div>
        <form class="flex flex-col gap-4 w-[400px]" action="<?= BASEURL; ?>/auth/proses_daftar" method="post">
            <div class="flex flex-col">
                <label for="username" class="text-[#FAFAFA]">Username</label>
                <input
                    type="text"
                    name="username"
                    class="bg-white py-3 px-5 text-lg font-semibold rounded-md placeholder:text-lg placeholder:text-gray-500 placeholder:font-semibold focus:outline-none"
                    placeholder="Masukkan Username"
                    id="username" />
            </div>
            <div class="flex flex-col">
                <label for="email" class="text-[#FAFAFA]">Email</label>
                <input
                    type="email"
                    name="email"
                    class="bg-white py-3 px-5 text-lg font-semibold rounded-md placeholder:text-lg placeholder:text-gray-500 placeholder:font-semibold focus:outline-none"
                    placeholder="Masukkan Email"
                    id="email" />
            </div>
            <div class="flex flex-col">
                <label for="password" class="text-[#FAFAFA]">Password</label>
                <input
                    type="password"
                    name="password"
                    class="bg-white py-3 px-5 text-lg font-semibold rounded-md placeholder:text-lg placeholder:text-gray-500 placeholder:font-semibold focus:outline-none"
                    placeholder="********"
                    id="password" />
            </div>
            <div class="flex flex-col">
                <label for="cpassword" class="text-[#FAFAFA]">Confirm Password</label>
                <input
                    type="password"
                    name="cpassword"
                    class="bg-white py-3 px-5 text-lg font-semibold rounded-md placeholder:text-lg placeholder:text-gray-500 placeholder:font-semibold focus:outline-none"
                    placeholder="********"
                    id="cpassword" />
            </div>
            <div class="flex flex-col">
                <label for="captchaInput" class="text-[#FAFAFA]">Masukkan Kode</label>
                <div class="flex items-center relative">
                    <div
                        class="bg-[#FFC857] text-[#a0522d] py-3 px-5 rounded-l-md font-mono text-xl font-bold select-none"> <?= $data['captcha_text']; ?></div>
                    <button
                        type="button"
                        class="bg-none border-none cursor-pointer text-xl text-gray-500 absolute right-5 top-1/2 transform -translate-y-1/2"
                        onclick="generateCaptcha()">
                        &#x21bb;
                    </button>
                    <input
                        type="text"
                        name="captcha"
                        class="bg-white py-3 px-5 text-lg font-semibold rounded-r-md placeholder:text-lg placeholder:text-gray-500 placeholder:font-semibold focus:outline-none w-full"
                        placeholder="Masukkan Kode"
                        id="captchaInput" />
                </div>
                <p id="captchaError" class="text-red-500 text-sm mt-1 hidden">
                    Captcha tidak sesuai.
                </p>
            </div>

            <button
                type="submit"
                class="bg-[#FFC857] py-3 px-5 text-xl font-medium text-[#a0522d] rounded-md mt-10 cursor-pointer">
                Daftar
            </button>
            <p class="text-center mt-3 text-sm text-white font-medium">
                Sudah Punya Akun?
                <a
                    href="<?= BASEURL; ?>/auth/index"
                    class="text-[#FFC857] hover:underline font-bold">Masuk</a>
            </p>
        </form>
    </div>
</div>