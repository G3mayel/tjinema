@extends('layouts.app')

@section('title', 'Theaters Management')

@section('content')
<div class="min-h-screen">

  <div class="relative z-10 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 shadow-2xl mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
          <div class="mb-7 lg:mb-0">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-400 via-purple-400 to-pink-400 bg-clip-text text-transparent mb-2">
              Theater Management
            </h1>
            <p class="text-slate-300 text-lg">Configure and manage your cinema venues</p>
          </div>
          <a href="{{ route('admin.theaters.create') }}"
             class="group relative overflow-hidden bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
            <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center space-x-3">
              <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fas fa-plus text-sm"></i>
              </div>
              <span>Add Theater</span>
            </div>
          </a>
        </div>
      </div>

      <!-- Theater Stats Summary -->
      @if($theaters->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
          <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-6 text-center shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-building text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">{{ $theaters->count() }}</h3>
            <p class="text-slate-300">Total Theaters</p>
          </div>

          <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-6 text-center shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
            <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-users text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">{{ $theaters->sum('capacity') }}</h3>
            <p class="text-slate-300">Total Capacity</p>
          </div>

          <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-6 text-center shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
            <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-check-circle text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">{{ $theaters->where('is_active', true)->count() }}</h3>
            <p class="text-slate-300">Active Theaters</p>
          </div>

          <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-6 text-center shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
            <div class="w-16 h-16 bg-gradient-to-r from-red-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-pause-circle text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">{{ $theaters->where('is_active', false)->count() }}</h3>
            <p class="text-slate-300">Inactive Theaters</p>
          </div>
        </div>
      @endif

      <!-- Search and Filter Section -->
      <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-6 mb-8">
        <form method="GET" action="{{ route('admin.theaters.index') }}" class="flex flex-col md:flex-row gap-4">
          <div class="flex-1">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search theaters..."
                   class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
          </div>
          <div class="md:w-48">
            <select name="status" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
              <option value="">All Status</option>
              <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
          </div>
          <button type="submit" class="bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
            <i class="fas fa-search mr-2"></i>Search
          </button>
        </form>
      </div>

      <!-- Theater Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse($theaters as $theater)
          <div class="group relative">
            <!-- Hover Glow Effect -->
            <div class="absolute -inset-1 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-500 blur"></div>

            <div class="relative bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-6 shadow-xl hover:shadow-2xl transition-all duration-500 transform group-hover:scale-[1.02]">
              <!-- Theater Header -->
              <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                  <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-building text-white text-xl"></i>
                  </div>
                  <div>
                    <h3 class="text-xl font-bold text-white group-hover:text-purple-300 transition-colors">{{ $theater->name }}</h3>
                    <p class="text-slate-400 text-sm">Theater Hall</p>
                  </div>
                </div>

                <!-- Status Badge -->
                <div class="flex items-center space-x-1 px-3 py-1 rounded-full text-xs font-semibold
                  {{ $theater->is_active ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-red-500/20 text-red-400 border border-red-500/30' }}">
                  <div class="w-2 h-2 rounded-full {{ $theater->is_active ? 'bg-green-400 animate-pulse' : 'bg-red-400' }}"></div>
                  <span>{{ $theater->is_active ? 'Active' : 'Inactive' }}</span>
                </div>
              </div>

              <!-- Theater Info -->
              <div class="space-y-4 mb-6">
                <!-- Capacity -->
                <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/10">
                  <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center">
                      <i class="fas fa-users text-blue-400 text-sm"></i>
                    </div>
                    <span class="text-slate-300">Capacity</span>
                  </div>
                  <span class="text-white font-bold text-lg">{{ $theater->capacity }} seats</span>
                </div>

                <!-- Type -->
                <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/10">
                  <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center">
                      <i class="fas fa-theater-masks text-purple-400 text-sm"></i>
                    </div>
                    <span class="text-slate-300">Type</span>
                  </div>
                  <span class="px-3 py-1 bg-gradient-to-r from-purple-500/30 to-pink-500/30 text-white rounded-full text-sm font-semibold border border-purple-500/50">
                    {{ $theater->type }}
                  </span>
                </div>

                <!-- Location (if available) -->
                @if($theater->location ?? false)
                <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/10">
                  <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center">
                      <i class="fas fa-map-marker-alt text-orange-400 text-sm"></i>
                    </div>
                    <span class="text-slate-300">Location</span>
                  </div>
                  <span class="text-white text-sm">{{ $theater->location }}</span>
                </div>
                @endif
              </div>

              <!-- Action Buttons -->
              <div class="flex space-x-2">
                <a href="{{ route('admin.theaters.edit', $theater->id) }}"
                   class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white py-2 px-3 rounded-xl text-center font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-sm">
                  <i class="fas fa-edit mr-1"></i> Edit
                </a>
                <form action="{{ route('admin.theaters.destroy', $theater->id) }}" method="POST" class="flex-1">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="w-full bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white py-2 px-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-sm"
                          onclick="return confirm('Are you sure you want to delete this theater?')">
                    <i class="fas fa-trash mr-1"></i> Delete
                  </button>
                </form>
              </div>
            </div>
          </div>
        @empty
          <div class="col-span-full">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-16 text-center">
              <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-building text-4xl text-slate-400"></i>
              </div>
              <h3 class="text-2xl font-bold text-white mb-4">No Theaters Found</h3>
              <p class="text-slate-400 text-lg mb-8">Set up your first theater to get started</p>
              <a href="{{ route('admin.theaters.create') }}" class="inline-flex items-center space-x-3 bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
                <i class="fas fa-plus"></i>
                <span>Create First Theater</span>
              </a>
            </div>
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      @if($theaters->hasPages())
        <div class="flex justify-center">
          <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 px-6 py-4">
            {{ $theaters->links() }}
          </div>
        </div>
      @endif
    </div>
  </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
  <div class="fixed top-4 right-4 z-50 bg-green-500/90 backdrop-blur-lg text-white px-6 py-4 rounded-xl shadow-lg border border-green-400/50" id="success-message">
    <div class="flex items-center space-x-3">
      <i class="fas fa-check-circle text-xl"></i>
      <span>{{ session('success') }}</span>
    </div>
  </div>
@endif

@if(session('error'))
  <div class="fixed top-4 right-4 z-50 bg-red-500/90 backdrop-blur-lg text-white px-6 py-4 rounded-xl shadow-lg border border-red-400/50" id="error-message">
    <div class="flex items-center space-x-3">
      <i class="fas fa-exclamation-circle text-xl"></i>
      <span>{{ session('error') }}</span>
    </div>
  </div>
@endif

<style>
.animation-delay-2000 {
  animation-delay: 2s;
}
.animation-delay-4000 {
  animation-delay: 4s;
}

/* Custom pagination styles */
.pagination {
  @apply flex space-x-2;
}

.pagination .page-link {
  @apply px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white hover:bg-white/20 transition-all duration-300;
}

.pagination .page-item.active .page-link {
  @apply bg-gradient-to-r from-purple-500 to-pink-500 border-purple-500;
}

.pagination .page-item.disabled .page-link {
  @apply opacity-50 cursor-not-allowed;
}

/* Auto-hide messages */
@keyframes slideIn {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}

@keyframes slideOut {
  from {
    transform: translateX(0);
    opacity: 1;
  }
  to {
    transform: translateX(100%);
    opacity: 0;
  }
}

#success-message, #error-message {
  animation: slideIn 0.3s ease-out;
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
  .grid {
    grid-template-columns: 1fr;
  }

  .flex-1 {
    min-width: 0;
  }

  .text-4xl {
    font-size: 2rem;
  }
}

/* Loading animation for buttons */
.btn-loading {
  position: relative;
  color: transparent;
}

.btn-loading::after {
  content: '';
  position: absolute;
  top: 50%;
  left: 50%;
  width: 20px;
  height: 20px;
  margin: -10px 0 0 -10px;
  border: 2px solid transparent;
  border-top: 2px solid #ffffff;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Auto-hide success/error messages

  // Confirm delete with better UX
  const deleteButtons = document.querySelectorAll('button[onclick*="confirm"]');
  deleteButtons.forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      const form = this.closest('form');

      // Create custom confirm dialog
      const modal = document.createElement('div');
      modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm';
      modal.innerHTML = `
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-8 max-w-md w-full mx-4">
          <div class="text-center">
            <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-4">Delete Theater</h3>
            <p class="text-slate-300 mb-8">Are you sure you want to delete this theater? This action cannot be undone.</p>
            <div class="flex space-x-4">
              <button type="button" class="flex-1 bg-white/10 hover:bg-white/20 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-300" onclick="this.closest('.fixed').remove()">
                Cancel
              </button>
              <button type="button" class="flex-1 bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-300" onclick="document.querySelector('form[action*=\\'destroy\\']').submit(); this.closest('.fixed').remove();">
                Delete
              </button>
            </div>
          </div>
        </div>
      `;

      document.body.appendChild(modal);
    });
  });
});
</script>
@endsection
