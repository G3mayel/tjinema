@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="min-h-screen ">
  <div class="relative z-10 space-y-8 p-6 lg:p-8">
    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 shadow-2xl">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-4xl lg:text-5xl font-bold bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">
            Admin panel
          </h1>
          <p class="text-lg text-slate-300 mt-2 font-light">Your entertainment empire at a glance</p>
        </div>
        <div class="hidden lg:flex items-center space-x-4">
          <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
            <i class="fas fa-crown text-white text-xl"></i>
          </div>
        </div>
      </div>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      @foreach ([
        ['label'=>'Total Movies','icon'=>'fa-film','value'=>$totalMovies,'color'=>'from-blue-500 to-cyan-500','bg'=>'bg-blue-500/20'],
        ['label'=>'Total Bookings','icon'=>'fa-ticket-alt','value'=>$totalBookings,'color'=>'from-green-500 to-emerald-500','bg'=>'bg-green-500/20'],
        ['label'=>'Total Revenue','icon'=>'fa-dollar-sign','value'=>"Rp ".number_format($totalRevenue,0,',','.'),'color'=>'from-purple-500 to-violet-500','bg'=>'bg-purple-500/20'],
        ['label'=>'Active Theaters','icon'=>'fa-building','value'=>$totalTheaters,'color'=>'from-orange-500 to-red-500','bg'=>'bg-orange-500/20'],
      ] as $card)
        <div class="group relative overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-r {{ $card['color'] }} opacity-0 group-hover:opacity-10 transition-opacity duration-500 rounded-2xl"></div>
          <div class="relative bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/20 hover:border-white/40 transition-all duration-300 hover:transform hover:scale-105 shadow-xl">
            <div class="flex items-start justify-between">
              <div class="space-y-2">
                <p class="text-sm font-medium text-slate-300 uppercase tracking-wider">{{ $card['label'] }}</p>
                <p class="text-3xl font-bold text-white">{{ $card['value'] }}</p>
                <div class="w-12 h-1 bg-gradient-to-r {{ $card['color'] }} rounded-full"></div>
              </div>
              <div class="w-14 h-14 rounded-xl {{ $card['bg'] }} flex items-center justify-center backdrop-blur-sm">
                <i class="fas {{ $card['icon'] }} text-2xl text-white"></i>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
      <div class="xl:col-span-2">
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 shadow-2xl">
          <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold text-white">Recent Activities</h3>
            <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
          </div>

          <div class="space-y-4 max-h-96 overflow-y-auto custom-scrollbar">
            @forelse($recentActivities as $act)
              <div class="group flex items-center space-x-4 p-4 bg-white/5 rounded-xl border border-white/10 hover:bg-white/10 hover:border-white/20 transition-all duration-300">
                <div class="relative">
                  <div class="w-12 h-12 bg-gradient-to-r {{ $loop->index % 3 == 0 ? 'from-blue-500 to-purple-500' : ($loop->index % 3 == 1 ? 'from-green-500 to-teal-500' : 'from-pink-500 to-rose-500') }} rounded-full flex items-center justify-center shadow-lg">
                    <i class="fas fa-user text-white"></i>
                  </div>
                  <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-slate-900"></div>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="font-semibold text-white group-hover:text-blue-300 transition-colors">{{ $act->user->name }}</p>
                  <p class="text-sm text-slate-300 truncate">{{ $act->description }}</p>
                  <p class="text-xs text-slate-400 mt-1">{{ $act->created_at->diffForHumans() }}</p>
                </div>
                <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                  <i class="fas fa-chevron-right text-slate-400"></i>
                </div>
              </div>
            @empty
              <div class="text-center py-12">
                <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-4">
                  <i class="fas fa-inbox text-3xl text-slate-400"></i>
                </div>
                <p class="text-slate-400 text-lg">No recent activities</p>
              </div>
            @endforelse
          </div>
        </div>
      </div>

      <div class="space-y-6">
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 shadow-2xl">
          <h3 class="text-2xl font-bold text-white mb-6">Quick Actions</h3>
          <div class="space-y-4">
            @foreach ([
              ['route'=>'admin.movies.create','icon'=>'fa-plus-circle','label'=>'Add Movie','desc'=>'Create new movie','color'=>'from-blue-500 to-purple-500'],
              ['route'=>'admin.theaters.create','icon'=>'fa-building','label'=>'Add Theater','desc'=>'Setup new venue','color'=>'from-green-500 to-teal-500'],
              ['route'=>'admin.beverages.create','icon'=>'fa-coffee','label'=>'Add Beverage','desc'=>'Expand menu','color'=>'from-orange-500 to-red-500'],
            ] as $action)
              <a href="{{ route($action['route']) }}" class="group block">
                <div class="relative overflow-hidden rounded-xl bg-white/5 border border-white/10 p-4 hover:bg-white/10 hover:border-white/20 transition-all duration-300">
                  <div class="absolute inset-0 bg-gradient-to-r {{ $action['color'] }} opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                  <div class="relative flex items-center space-x-4">
                    <div class="w-12 h-12 bg-gradient-to-r {{ $action['color'] }} rounded-lg flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                      <i class="fas {{ $action['icon'] }} text-white"></i>
                    </div>
                    <div class="flex-1">
                      <p class="font-semibold text-white group-hover:text-blue-300 transition-colors">{{ $action['label'] }}</p>
                      <p class="text-sm text-slate-300">{{ $action['desc'] }}</p>
                    </div>
                    <i class="fas fa-arrow-right text-slate-400 group-hover:text-white group-hover:translate-x-1 transition-all duration-300"></i>
                  </div>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 shadow-2xl overflow-hidden">
      <div class="p-8 border-b border-white/10">
        <div class="flex items-center justify-between">
          <h3 class="text-2xl font-bold text-white">Popular Movies This Week</h3>
          <div class="flex items-center space-x-2">
            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
            <span class="text-sm text-slate-300">Live Data</span>
          </div>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-white/10">
              <th class="text-left py-4 px-8 text-sm font-semibold text-slate-300 uppercase tracking-wider">Movie</th>
              <th class="text-left py-4 px-8 text-sm font-semibold text-slate-300 uppercase tracking-wider">Bookings</th>
              <th class="text-left py-4 px-8 text-sm font-semibold text-slate-300 uppercase tracking-wider">Revenue</th>
              <th class="text-left py-4 px-8 text-sm font-semibold text-slate-300 uppercase tracking-wider">Rating</th>
            </tr>
          </thead>
          <tbody>
            @forelse($popularMovies as $m)
              <tr class="border-b border-white/5 hover:bg-white/5 transition-colors duration-200 group">
                <td class="py-6 px-8">
                  <div class="flex items-center space-x-4">
                    <div class="relative group-hover:scale-105 transition-transform duration-300">
                      <img src="{{ $m->poster_url }}" class="w-16 h-20 object-cover rounded-lg shadow-lg" alt="{{ $m->title }}">
                      <div class="absolute inset-0 bg-black/20 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <i class="fas fa-play text-white text-sm"></i>
                      </div>
                    </div>
                    <div>
                      <p class="font-semibold text-white text-lg">{{ $m->title }}</p>
                      <p class="text-slate-300 capitalize">{{ $m->genre }}</p>
                    </div>
                  </div>
                </td>
                <td class="py-6 px-8">
                  <div class="flex items-center space-x-2">
                    <span class="text-xl font-bold text-white">{{ $m->bookings_count }}</span>
                    <i class="fas fa-ticket-alt text-blue-400"></i>
                  </div>
                </td>
                <td class="py-6 px-8">
                  <span class="text-xl font-bold text-green-400">Rp {{ number_format($m->revenue,0,',','.') }}</span>
                </td>
                <td class="py-6 px-8">
                  <div class="inline-flex items-center space-x-1 px-3 py-2 rounded-full bg-gradient-to-r from-yellow-400 to-orange-400 text-black font-semibold shadow-lg">
                    <i class="fas fa-star text-xs"></i>
                    <span>{{ $m->rating }}</span>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="py-12 text-center">
                  <div class="flex flex-col items-center space-y-4">
                    <div class="w-20 h-20 bg-white/5 rounded-full flex items-center justify-center">
                      <i class="fas fa-film text-3xl text-slate-400"></i>
                    </div>
                    <p class="text-slate-400 text-lg">No movie data available</p>
                  </div>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.3);
  border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.5);
}
.animation-delay-2000 {
  animation-delay: 2s;
}
.animation-delay-4000 {
  animation-delay: 4s;
}
</style>
@endsection
