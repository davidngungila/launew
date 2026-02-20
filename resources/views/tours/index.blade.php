@extends('layouts.public')

@section('content')
<!-- Page Header -->
<section class="relative pt-40 pb-20 bg-slate-900 overflow-hidden">
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1549366021-9f761d450615?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" alt="Tours" class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900/40 to-slate-900"></div>
    </div>
    
    <div class="relative z-10 max-w-7xl mx-auto px-6 text-center">
        <h1 class="text-5xl md:text-6xl font-serif text-white mb-6 font-bold">Discover Our Safaris</h1>
        <p class="text-slate-300 max-w-2xl mx-auto">Explore a range of safari packages designed to bring you closer to nature. From luxury lodges to camping under the stars.</p>
    </div>
</section>

<!-- Tours Section -->
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <!-- Filters -->
        <div class="flex flex-col lg:flex-row items-center justify-between mb-16 gap-8 bg-slate-50 p-6 rounded-3xl border border-slate-100">
            <div class="flex flex-wrap items-center gap-4">
                <div class="relative">
                    <select id="filter-destination" class="appearance-none bg-white border border-slate-200 rounded-2xl px-6 py-3 pr-12 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                        <option value="All">Destination: All</option>
                        <option value="Serengeti">Serengeti</option>
                        <option value="Ngorongoro">Ngorongoro</option>
                        <option value="Kilimanjaro">Kilimanjaro</option>
                        <option value="Tarangire">Tarangire</option>
                    </select>
                    <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                </div>
                
                <div class="relative">
                    <select id="filter-sort" class="appearance-none bg-white border border-slate-200 rounded-2xl px-6 py-3 pr-12 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                        <option value="Low to High">Price: Low to High</option>
                        <option value="High to Low">Price: High to Low</option>
                    </select>
                    <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                </div>
                
                <div class="relative">
                    <select id="filter-duration" class="appearance-none bg-white border border-slate-200 rounded-2xl px-6 py-3 pr-12 text-sm font-medium focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all">
                        <option value="Any">Duration: Any</option>
                        <option value="1-3 Days">1-3 Days</option>
                        <option value="4-7 Days">4-7 Days</option>
                        <option value="8+ Days">8+ Days</option>
                    </select>
                    <i class="ph ph-caret-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                </div>
                
                <div id="filter-loader" class="hidden">
                    <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-emerald-600"></div>
                </div>
            </div>
        </div>
        
        <div id="tour-grid-wrapper">
            @include('tours.partials.tour_grid')
        </div>
    </div>
</section>

<style>
    .pagination-premium .pagination {
        display: flex;
        gap: 0.75rem;
        list-style: none;
        align-items: center;
        padding: 0;
    }
    .pagination-premium .page-item .page-link {
        width: 3.5rem;
        height: 3.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 1.25rem;
        background: white;
        border: 1px solid #f1f5f9;
        color: #64748b;
        font-weight: 700;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        font-size: 0.9rem;
    }
    .pagination-premium .page-item.active .page-link {
        background: #059669;
        border-color: #059669;
        color: white;
        box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.3);
    }
    .pagination-premium .page-item .page-link:hover:not(.active) {
        border-color: #10b981;
        color: #10b981;
        transform: translateY(-3px);
        background: #f0fdf4;
    }
    .pagination-premium .page-item.disabled .page-link {
        opacity: 0.4;
        cursor: not-allowed;
        background: #f8fafc;
    }
    /* Hide default laravel pagination junk */
    .pagination-premium nav div:first-child { display: none; }
    .pagination-premium nav div:last-child { display: block !important; }
    
    #tour-grid-wrapper.loading {
        opacity: 0.5;
        pointer-events: none;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const destinationFilter = document.getElementById('filter-destination');
    const sortFilter = document.getElementById('filter-sort');
    const durationFilter = document.getElementById('filter-duration');
    const gridWrapper = document.getElementById('tour-grid-wrapper');
    const loader = document.getElementById('filter-loader');

    function fetchTours(url = null) {
        if (!url) {
            const params = new URLSearchParams({
                destination: destinationFilter.value,
                sort: sortFilter.value,
                duration: durationFilter.value
            });
            url = `{{ route('tours.index') }}?${params.toString()}`;
        }

        gridWrapper.classList.add('loading');
        loader.classList.remove('hidden');

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            gridWrapper.innerHTML = html;
            gridWrapper.classList.remove('loading');
            loader.classList.add('hidden');
            
            // Re-bind pagination clicks
            bindPaginationLinks();
            
            // Smooth scroll to results
            if (url.includes('page=')) {
                gridWrapper.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        })
        .catch(error => {
            console.error('Error fetching tours:', error);
            gridWrapper.classList.remove('loading');
            loader.classList.add('hidden');
        });
    }

    function bindPaginationLinks() {
        const pageLinks = gridWrapper.querySelectorAll('.pagination-premium a');
        pageLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                fetchTours(this.getAttribute('href'));
            });
        });
    }

    [destinationFilter, sortFilter, durationFilter].forEach(filter => {
        filter.addEventListener('change', () => fetchTours());
    });

    bindPaginationLinks();
});
</script>
    </div>
</section>
@endsection
