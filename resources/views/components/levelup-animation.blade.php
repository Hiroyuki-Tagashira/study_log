{{-- <script defer type="module">
    import { Fireworks } from 'https://cdn.skypack.dev/fireworks-js';

    const container = document.getElementById('container');
    const fireworks = new Fireworks(container);
    fireworks.start();
</script> --}}
<flux:modal class="w-[1000px] h-[600px] bg-animated-gradient" name="levelup" >
    <div class="relative w-full h-4/5 mt-10">
        {{-- <div class="absolute inset-0 z-0" id="container"></div> --}}
        <div class="absolute inset-0 z-10 flex flex-col justify-center items-center space-y-2">
            <p class="animate-elasticIn text-5xl text-rose-500 font-semibold">
                レベルアップ!
            </p>
            <x-icons.levelup-icon />
            <p class="animate-elasticIn text-8xl text-teal-500 font-bold">
                Lv.{{ $level }}
            </p>
            <p>レベルアップおめでとう！目標に向かって頑張れ！</p>
        </div>
    </div>

</flux:modal>
