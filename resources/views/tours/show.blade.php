@extends('layouts.public')

@section('content')
<!-- Tour Header & Gallery -->
<section class="pt-32 pb-12 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="mb-10">
            <div class="flex items-center gap-2 text-emerald-600 font-bold text-sm uppercase mb-4 tracking-widest">
                <i class="ph ph-map-pin"></i> Serengeti National Park, Tanzania
            </div>
            <h1 class="text-4xl md:text-5xl font-serif font-bold text-slate-900 mb-6">Serengeti Classic Safari & Great Migration</h1>
            <div class="flex flex-wrap items-center gap-6 text-slate-500 font-medium">
                <span class="flex items-center gap-2"><i class="ph ph-clock text-xl text-emerald-500"></i> 5 Days / 4 Nights</span>
                <span class="flex items-center gap-2"><i class="ph ph-users text-xl text-emerald-500"></i> Up to 6 People</span>
                <span class="flex items-center gap-2"><i class="ph ph-translate text-xl text-emerald-500"></i> English, French</span>
                <div class="flex items-center gap-1 text-emerald-500">
                    <i class="ph-fill ph-star"></i>
                    <i class="ph-fill ph-star"></i>
                    <i class="ph-fill ph-star"></i>
                    <i class="ph-fill ph-star"></i>
                    <i class="ph-fill ph-star"></i>
                    <span class="ml-1 text-slate-900 font-bold">5.0</span>
                    <span class="text-slate-400 text-sm">(124 Reviews)</span>
                </div>
            </div>
        </div>
        
        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 grid-rows-2 gap-4 h-[600px] rounded-[2.5rem] overflow-hidden shadow-2xl">
            <div class="md:col-span-2 md:row-span-2 relative group cursor-pointer">
                <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80" alt="Serengeti" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            </div>
            <div class="relative group cursor-pointer">
                <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Wildlife" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            </div>
            <div class="relative group cursor-pointer">
                <img src="https://images.unsplash.com/photo-1523805081730-614449379e70?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Safari Jeep" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
            </div>
            <div class="md:col-span-2 relative group cursor-pointer">
                <img src="https://images.unsplash.com/photo-1493612276216-ee3925520721?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Lodge" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="text-white font-bold flex items-center gap-2"><i class="ph ph-images"></i> View All Photos</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content & Booking Form -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
            <!-- Left Column: Details -->
            <div class="lg:col-span-2">
                <div class="mb-12">
                    <h2 class="text-3xl font-serif font-bold text-slate-900 mb-6">Overview</h2>
                    <p class="text-slate-600 leading-relaxed mb-6">
                        Experience the raw beauty of the African savannah on this 5-day Serengeti Classic Safari. Witness the Great Migration, where millions of wildebeest and zebras traverse the plains in search of fresh grass. Our expert guides will lead you to the heart of the action, ensuring you don't miss a single moment of this natural spectacle.
                    </p>
                    <p class="text-slate-600 leading-relaxed">
                        Stay in hand-picked luxury lodges and boutique tented camps that offer the perfect blend of comfort and authenticity. Enjoy sundowners overlooking the plains and delicious bush meals prepared by our gourmet chefs.
                    </p>
                </div>
                
                <hr class="border-slate-100 mb-12">
                
                <!-- Itinerary -->
                <div class="mb-12">
                    <h2 class="text-3xl font-serif font-bold text-slate-900 mb-8">Itinerary</h2>
                    <div class="space-y-10">
                        <div class="relative pl-12">
                            <div class="absolute left-0 top-0 w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">1</div>
                            <div class="absolute left-4 top-8 bottom-0 w-px bg-slate-100 -mb-10"></div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3">Arusha to Central Serengeti</h3>
                            <p class="text-slate-600 leading-relaxed">Early morning pickup from your hotel in Arusha. Drive to the Serengeti with a picnic lunch. Afternoon game drive in the Seronera Valley.</p>
                            <div class="mt-4 flex flex-wrap gap-4">
                                <span class="bg-slate-50 px-3 py-1 rounded-lg text-xs font-bold text-slate-500 flex items-center gap-1"><i class="ph ph-bed"></i> Serengeti Luxury Tents</span>
                                <span class="bg-slate-50 px-3 py-1 rounded-lg text-xs font-bold text-slate-500 flex items-center gap-1"><i class="ph ph-bowl-food"></i> L, D</span>
                            </div>
                        </div>
                        
                        <div class="relative pl-12">
                            <div class="absolute left-0 top-0 w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">2</div>
                            <div class="absolute left-4 top-8 bottom-0 w-px bg-slate-100 -mb-10"></div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3">Full Day Game Drives</h3>
                            <p class="text-slate-600 leading-relaxed">Spend the entire day exploring the vast plains. Your guide will track the migration herds and look for predators like lions, leopards, and cheetahs.</p>
                        </div>
                        
                        <div class="relative pl-12">
                            <div class="absolute left-0 top-0 w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold">3</div>
                            <h3 class="text-xl font-bold text-slate-900 mb-3">Mara River Experience</h3>
                            <p class="text-slate-600 leading-relaxed">If in season, drive north to the Mara River to witness the dramatic crossings. A true spectacle of the wild.</p>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-100 mb-12">

                <!-- Inclusions / Exclusions -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-16">
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-6 font-serif">What's Included</h3>
                        <ul class="space-y-4">
                            <li class="flex items-center gap-3 text-slate-600 text-sm"><i class="ph-fill ph-check-circle text-emerald-500 text-lg"></i> All park entrance & conservation fees</li>
                            <li class="flex items-center gap-3 text-slate-600 text-sm"><i class="ph-fill ph-check-circle text-emerald-500 text-lg"></i> Expert Kili/Safari certified guide</li>
                            <li class="flex items-center gap-3 text-slate-600 text-sm"><i class="ph-fill ph-check-circle text-emerald-500 text-lg"></i> Custom 4x4 Land Cruiser with pop-up roof</li>
                            <li class="flex items-center gap-3 text-slate-600 text-sm"><i class="ph-fill ph-check-circle text-emerald-500 text-lg"></i> Bottled water, snacks & luxury hampers</li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900 mb-6 font-serif">What's Excluded</h3>
                        <ul class="space-y-4">
                            <li class="flex items-center gap-3 text-slate-600 text-sm"><i class="ph-fill ph-x-circle text-rose-400 text-lg"></i> International airfare & visa fees</li>
                            <li class="flex items-center gap-3 text-slate-600 text-sm"><i class="ph-fill ph-x-circle text-rose-400 text-lg"></i> Personal travel insurance (Required)</li>
                            <li class="flex items-center gap-3 text-slate-600 text-sm"><i class="ph-fill ph-x-circle text-rose-400 text-lg"></i> Gratuities for driver & camp staff</li>
                            <li class="flex items-center gap-3 text-slate-600 text-sm"><i class="ph-fill ph-x-circle text-rose-400 text-lg"></i> Personal items & laundry services</li>
                        </ul>
                    </div>
                </div>

                <!-- Advanced Details Tabs/Sections -->
                <div class="space-y-16">
                    <!-- Accommodation Section -->
                    <div class="bg-slate-50 rounded-[3rem] p-10 md:p-14 border border-slate-100">
                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-2xl text-emerald-600 shadow-sm">
                                <i class="ph ph-bed"></i>
                            </div>
                            <h3 class="text-2xl font-serif font-black text-slate-900">Luxury Sanctuary</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <p class="text-slate-600 text-sm leading-relaxed">
                                Our selected lodges are more than just a place to sleep; they are an extension of the safari. We prioritize properties with sustainable operations and breathtaking views of the natural migration corridors.
                            </p>
                            <ul class="space-y-2">
                                <li class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> 24/7 Solar Electricity
                                </li>
                                <li class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Ensuite Luxury Bathrooms
                                </li>
                                <li class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Gourmet Farm-to-Table Dining
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Safety & Prep -->
                    <div>
                        <h3 class="text-2xl font-serif font-black text-slate-900 mb-8">Preparation & Safety</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            @foreach([
                                ['title' => 'Vaccinations', 'desc' => 'Yellow fever & Malaria prophylaxis recommended.', 'icon' => 'first-aid-kit'],
                                ['title' => 'Packing', 'desc' => 'Neutral colors, layers, and high-SPF protection.', 'icon' => 'backpack'],
                                ['title' => 'Communications', 'desc' => 'Satellite phones in all vehicles for peak safety.', 'icon' => 'satellite-signal']
                            ] as $info)
                            <div class="p-8 bg-white border border-slate-100 rounded-[2rem] hover:shadow-xl transition-all group">
                                <i class="ph ph-{{ $info['icon'] }} text-3xl text-emerald-600 mb-4 transition-transform group-hover:scale-110"></i>
                                <h5 class="font-black text-slate-900 mb-2">{{ $info['title'] }}</h5>
                                <p class="text-[11px] text-slate-400 leading-relaxed font-bold">{{ $info['desc'] }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Booking Form -->
            <div>
                <div class="sticky top-32 glass border border-white/40 p-10 rounded-[2.5rem] shadow-2xl">
                    <div class="mb-8">
                        <span class="text-slate-500 text-sm font-bold uppercase tracking-widest block mb-2">Price from</span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-4xl font-bold text-slate-900">$1,250</span>
                            <span class="text-slate-400 font-medium">/ person</span>
                        </div>
                    </div>
                    
                    <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="tour_id" value="1"> {{-- Dummy ID for now --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-900 uppercase tracking-widest mb-3">Your Name</label>
                            <input type="text" name="customer_name" required class="w-full bg-white/50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all" placeholder="John Doe">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-900 uppercase tracking-widest mb-3">Email</label>
                                <input type="email" name="customer_email" required class="w-full bg-white/50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all" placeholder="john@example.com">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-900 uppercase tracking-widest mb-3">Phone</label>
                                <input type="text" name="customer_phone" required class="w-full bg-white/50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all" placeholder="+255...">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-900 uppercase tracking-widest mb-3">Preferred Date</label>
                            <input type="date" name="start_date" required class="w-full bg-white/50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-900 uppercase tracking-widest mb-3">Adults</label>
                                <select name="adults" class="w-full bg-white/50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4+</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-900 uppercase tracking-widest mb-3">Children</label>
                                <select name="children" class="w-full bg-white/50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-slate-900 uppercase tracking-widest mb-3">Special Requests</label>
                            <textarea name="special_requests" placeholder="Dietary needs, preferred lodge..." class="w-full bg-white/50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition-all h-24"></textarea>
                        </div>
                        
                        <div class="bg-emerald-50 p-6 rounded-2xl border border-emerald-100 flex items-center justify-between mb-8">
                            <span class="font-bold text-slate-900">Total Projection:</span>
                            <span class="text-xl font-bold text-emerald-600 group-hover:block">$2,500</span>
                        </div>
                        
                        <button type="submit" class="w-full py-5 bg-emerald-600 text-white font-bold rounded-2xl shadow-xl shadow-emerald-600/20 hover:bg-emerald-700 transition-all flex items-center justify-center gap-3">
                            <i class="ph ph-calendar-check text-xl"></i> Book This Tour
                        </button>
                    </form>
                    
                    <p class="text-center text-xs text-slate-400 mt-6 font-medium">No immediate payment required for booking request.</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
