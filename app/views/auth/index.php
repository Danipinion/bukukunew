<style>
    /* Basic styling for Google button, customize as needed */
    .google-login-button {
        display: inline-block;
        background: #DB4437;
        /* Google Red */
        color: white;
        border-radius: 4px;
        padding: 10px 20px;
        text-decoration: none;
        font-weight: 500;
        text-align: center;
        margin-top: 15px;
        /* Add some space */
        transition: background-color 0.3s;
    }

    .google-login-button:hover {
        background: #c33a2c;
    }
</style>
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
        <h1 class="text-[#FFC857] text-[64px] uppercase font-bold">LOGIN</h1>
        <div>
            <?php Flasher::flash(); ?>
        </div>
        <form class="flex flex-col gap-4 w-[400px]" action="<?= BASEURL; ?>/auth/proses_login" method="post">
            <div class="flex flex-col">
                <label for="username" class="text-[#FAFAFA]">Username</label>
                <input
                    type="text"
                    name="username"
                    class="bg-white py-3 px-5 text-lg font-semibold rounded-md placeholder:text-lg placeholder:text-gray-500 placeholder:font-semibold focus:outline-none"
                    placeholder="Masukkan Username"
                    id="username" required />
            </div>
            <div class="flex flex-col">
                <label for="password" class="text-[#FAFAFA]">Password</label>
                <input
                    type="password"
                    name="password"
                    class="bg-white py-3 px-5 text-lg font-semibold rounded-md placeholder:text-lg placeholder:text-gray-500 placeholder:font-semibold focus:outline-none"
                    placeholder="********"
                    id="password" required />
            </div>

            <div class="flex flex-col">
                <label for="captchaInput" class="text-[#FAFAFA]">Masukkan Kode</label>
                <div class="flex items-center relative">
                    <div
                        class="bg-[#FFC857] text-[#a0522d] py-3 px-5 rounded-l-md font-mono text-xl font-bold select-none">
                        <?= $data['captcha_text']; ?>
                    </div>
                    <input
                        type="text"
                        name="captcha"
                        class="bg-white py-3 px-5 text-lg font-semibold rounded-r-md placeholder:text-lg placeholder:text-gray-500 placeholder:font-semibold focus:outline-none w-full"
                        placeholder="Masukkan Kode"
                        id="captchaInput" required autocomplete="off" />
                </div>
                <p id="captchaError" class="text-red-500 text-sm mt-1 hidden">
                    Captcha tidak sesuai.
                </p>
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        class="mr-2" />
                    <label for="remember" class="text-[#FAFAFA]">Ingat saya</label>
                </div>
                <div>
                    <a
                        href="<?= BASEURL; ?>/auth/lupa_password"
                        class="text-[#FAFAFA] hover:underline">Lupa Password?</a>
                </div>
            </div>

            <button
                type="submit" class="bg-[#FFC857] py-3 px-5 text-xl font-medium text-[#a0522d] rounded-md mt-10 cursor-pointer">
                Masuk
            </button>

            <?php if (isset($data['google_login_url']) && $data['google_login_url']): ?>
                <a href="<?= htmlspecialchars($data['google_login_url']); ?>" class="google-login-button">
                    <svg class="inline-block mr-2 -mt-1" width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 488 512">
                        <path fill="currentColor" d="M488 261.8C488 403.3 381.5 512 244 512 110.3 512 0 398.8 0 256S110.3 0 244 0c70.9 0 132.3 30.5 176.3 78.8l-66.2 63.2C331.3 114.9 291.1 98.4 244 98.4c-85.2 0-154.3 68.8-154.3 153.4s69.1 153.4 154.3 153.4c57.3 0 100.7-24.4 125.2-47.9 19.7-19.1 31.9-46.9 36.5-79.4H244V251.6h239.8c2.5 13.6 3.7 28.1 3.7 43.2z"></path>
                    </svg>
                    Login dengan Google
                </a>
            <?php endif; ?>
            <p class="text-center mt-3 text-sm text-white font-medium">
                Belum Punya Akun?
                <a
                    href="<?= BASEURL; ?>/auth/daftar"
                    class="text-[#FFC857] hover:underline font-bold">Buat Akun</a>
            </p>
        </form>
    </div>
</div>