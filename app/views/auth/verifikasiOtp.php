<div class="flex justify-between">
    <div class="flex flex-col justify-center items-center w-[43%] h-screen -mt-32">
        <img src="<?= BASEURL; ?>/img/logo.png" alt="logo" class="w-[300px]" />
        <h1 class="text-[64px] uppercase font-bold">Bacain</h1>
    </div>
    <div class="flex flex-col justify-center items-center w-[45%]">
        <img src="<?= BASEURL; ?>/img/background.svg" alt="" class="h-screen fixed top-0 right-0 -z-20" />
        <a href="<?= BASEURL; ?>/auth/lupa_password"
            class="absolute top-5 right-5 text-2xl cursor-pointer bg-[#FFC857] text-[#a0522d] py-3 px-5 rounded-md font-mono font-bold select-none">
            X
        </a>
        <h1 class="text-[#FFC857] text-[54px] font-bold pt-16">
            Verifikasi OTP
        </h1>
        <p class="text-gray-300 mb-6 text-center">
            Kode OTP telah dikirim ke <strong class="text-white"><?= htmlspecialchars($data['email'] ?? ''); ?></strong>.<br>
            Masukkan kode OTP dan password baru Anda.
        </p>

        <?php Flasher::flash(); ?>


        <form action="<?= BASEURL; ?>/auth/proses_verifikasi_otp" method="POST" class="flex flex-col gap-4 w-[400px]">
            <div class="flex flex-col">
                <label for="otp" class="text-[#FAFAFA]">Kode OTP</label>
                <input
                    type="text"
                    name="otp"
                    maxlength="6"
                    class="bg-white py-3 px-5 text-lg font-semibold rounded-md placeholder:text-lg placeholder:text-gray-500 placeholder:font-semibold focus:outline-none"
                    placeholder="Masukkan Kode OTP"
                    id="otp"
                    required />
            </div>

            <div class="flex flex-col">
                <label for="password" class="text-[#FAFAFA]">Password Baru</label>
                <input
                    type="password"
                    name="password"
                    class="bg-white py-3 px-5 text-lg font-semibold rounded-md placeholder:text-lg placeholder:text-gray-500 placeholder:font-semibold focus:outline-none"
                    placeholder="Masukkan Password Baru"
                    id="password"
                    required />
            </div>

            <div class="flex flex-col">
                <label for="cpassword" class="text-[#FAFAFA]">Konfirmasi Password Baru</label>
                <input
                    type="password"
                    name="cpassword"
                    class="bg-white py-3 px-5 text-lg font-semibold rounded-md placeholder:text-lg placeholder:text-gray-500 placeholder:font-semibold focus:outline-none"
                    placeholder="Konfirmasi Password Baru"
                    id="cpassword"
                    required />
            </div>

            <button
                type="submit"
                class="bg-[#FFC857] py-3 px-5 text-xl font-medium text-[#a0522d] rounded-md mt-2 cursor-pointer">
                Reset Password
            </button>
            <div class="text-center mt-3">
                <a href="<?= BASEURL; ?>/auth/lupa_password" class="text-[#FFC857] hover:underline">Kirim ulang OTP?</a>
            </div>
        </form>
    </div>
</div>