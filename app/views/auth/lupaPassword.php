<div class="flex justify-between">
    <div
        class="flex flex-col justify-center items-center w-[43%] h-screen -mt-32">
        <img src="<?= BASEURL; ?>/img/logo.png" alt="logo" class="w-[300px]" />
        <h1 class="text-[64px] uppercase font-bold">Bacain</h1>
    </div>
    <div class="flex flex-col justify-center items-center w-[45%]">
        <img
            src="<?= BASEURL; ?>/img/background.svg"
            alt=""
            class="h-screen fixed top-0 right-0 -z-20" />
        <a
            href="<?= BASEURL; ?>/auth"
            class="absolute top-5 right-5 text-2xl cursor-pointer bg-[#FFC857] text-[#a0522d] py-3 px-5 rounded-md font-mono font-bold select-none">
            X
        </a>
        <h1 class="text-[#FFC857] text-[64px] font-bold pt-24">
            Lupa Password
        </h1>
        <?php Flasher::flash('lupa_password_specific');
        ?>
        <form form action="<?= BASEURL; ?>/auth/proses_lupa_password" method="POST" class="flex flex-col gap-4 w-[400px]">
            <div class=" flex flex-col">
                <label for="email" class="text-[#FAFAFA]">Email</label>
                <input
                    type="email"
                    name="email"
                    class="bg-white py-3 px-5 text-lg font-semibold rounded-md placeholder:text-lg placeholder:text-gray-500 placeholder:font-semibold focus:outline-none"
                    placeholder="Masukkan Email"
                    id="email" />
            </div>

            <button
                type="submit"
                class="bg-[#FFC857] py-3 px-5 text-xl font-medium text-[#a0522d] rounded-md mt-2 cursor-pointer">
                Kirim Kode
            </button>
        </form>
    </div>
</div>