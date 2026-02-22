<div class="rounded-[2.5rem] overflow-hidden border border-slate-100 bg-white shadow-sm" x-data="{ images: @js($gallery ?? []), active: 0 }">
    <div class="relative aspect-[16/11] bg-slate-100">
        <template x-if="images.length">
            <img :src="images[active]" class="w-full h-full object-cover" alt="{{ $title ?? 'Gallery' }}">
        </template>
        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/30 via-transparent to-transparent"></div>

        <button type="button" class="absolute left-5 top-1/2 -translate-y-1/2 w-11 h-11 rounded-2xl bg-white/90 backdrop-blur border border-white/50 text-slate-900 flex items-center justify-center hover:bg-white transition-all" @click="active = (active - 1 + images.length) % images.length" x-show="images.length > 1">
            <i class="ph ph-caret-left text-xl"></i>
        </button>
        <button type="button" class="absolute right-5 top-1/2 -translate-y-1/2 w-11 h-11 rounded-2xl bg-white/90 backdrop-blur border border-white/50 text-slate-900 flex items-center justify-center hover:bg-white transition-all" @click="active = (active + 1) % images.length" x-show="images.length > 1">
            <i class="ph ph-caret-right text-xl"></i>
        </button>

        <div class="absolute bottom-5 left-5 right-5 flex items-end justify-between gap-6">
            <div>
                @if(!empty($eyebrow))
                    <p class="text-[10px] font-black uppercase tracking-[0.35em] text-white/70">{{ $eyebrow }}</p>
                @endif
                @if(!empty($title))
                    <p class="text-white text-lg font-black">{{ $title }}</p>
                @endif
            </div>
            <div class="px-4 py-2 rounded-full bg-white/10 border border-white/20 text-white text-[10px] font-black uppercase tracking-[0.35em]" x-show="images.length">
                <span x-text="(active + 1) + ' / ' + images.length"></span>
            </div>
        </div>
    </div>

    <div class="p-6 bg-white" x-show="images.length > 1">
        <div class="flex gap-3 overflow-x-auto pb-2">
            <template x-for="(img, index) in images" :key="img + index">
                <button type="button" class="shrink-0 w-20 h-16 rounded-2xl overflow-hidden border transition-all" :class="active === index ? 'border-emerald-500 ring-2 ring-emerald-500/20' : 'border-slate-200 opacity-70 hover:opacity-100'" @click="active = index">
                    <img :src="img" class="w-full h-full object-cover" alt="">
                </button>
            </template>
        </div>
    </div>
</div>
