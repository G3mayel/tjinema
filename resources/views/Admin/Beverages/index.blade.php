@extends('layouts.app')

@section('title', 'Beverages Management')

@section('content')
<div class="min-h-screen ">


  <div class="relative z-10 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header Section -->
      <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-8 border border-white/20 shadow-2xl mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
          <div class="mb-6 lg:mb-0">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-cyan-400 via-blue-400 to-indigo-400 bg-clip-text text-transparent mb-2">
              Beverage Management
            </h1>
            <p class="text-slate-300 text-lg">Manage your cinema's beverage menu and pricing</p>
          </div>
          <a href="{{ route('admin.beverages.create') }}"
             class="group relative overflow-hidden bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
            <div class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative flex items-center space-x-3">
              <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center">
                <i class="fas fa-plus text-sm"></i>
              </div>
              <span>Add Beverage</span>
            </div>
          </a>
        </div>
      </div>

      <!-- Search and Filter Section -->
      <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-6 mb-8">
        <form method="GET" action="{{ route('admin.beverages.index') }}" class="flex flex-col md:flex-row gap-4">
          <div class="flex-1">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search beverages..."
                   class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
          </div>
          <div class="md:w-48">
            <select name="sort" class="w-full bg-white/10 border border-white/20 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent">
              <option value="">Sort by</option>
              <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
              <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
              <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price Low-High</option>
              <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High-Low</option>
              <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
            </select>
          </div>
          <button type="submit" class="bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
            <i class="fas fa-search mr-2"></i>Search
          </button>
        </form>
      </div>

      <!-- Beverage Stats -->
      @if($beverages->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-6 text-center shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
            <div class="w-16 h-16 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-coffee text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">{{ $beverages->count() }}</h3>
            <p class="text-slate-300">Total Beverages</p>
          </div>

          <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-6 text-center shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
            <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-dollar-sign text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">IDR {{ number_format($beverages->avg('price'), 0, ',', '.') }}</h3>
            <p class="text-slate-300">Average Price</p>
          </div>

          <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-6 text-center shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
            <div class="w-16 h-16 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-chart-line text-white text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">IDR {{ number_format($beverages->max('price'), 0, ',', '.') }}</h3>
            <p class="text-slate-300">Highest Price</p>
          </div>
        </div>
      @endif

      <!-- Beverages Grid -->
      @if($beverages->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
          @foreach($beverages as $beverage)
            <div class="group relative">
              <!-- Hover Glow Effect -->
              <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-2xl opacity-0 group-hover:opacity-20 transition-opacity duration-500 blur"></div>

              <div class="relative bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-6 shadow-xl hover:shadow-2xl transition-all duration-500 transform group-hover:scale-[1.02]">
                <!-- Beverage Icon -->
                <div class="flex items-center justify-between mb-4">
                  <div class="w-16 h-16 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-glass-water text-white text-2xl"></i>
                  </div>

                  <!-- Price Badge -->
                  <div class="px-4 py-2 bg-gradient-to-r from-green-500/20 to-teal-500/20 text-green-400 rounded-full text-sm font-bold border border-green-500/30">
                    IDR {{ number_format($beverage->price, 0, ',', '.') }}
                  </div>
                </div>

                <!-- Beverage Info -->
                <div class="mb-6">
                  <h3 class="text-xl font-bold text-white group-hover:text-cyan-300 transition-colors mb-2">{{ $beverage->name }}</h3>

                  <!-- Category (if available) -->
                  @if($beverage->category ?? false)
                    <span class="inline-block px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-xs font-semibold border border-blue-500/30 mb-3">
                      {{ $beverage->category }}
                    </span>
                  @endif

                  <!-- Description (if available) -->
                  @if($beverage->description ?? false)
                    <p class="text-slate-400 text-sm mb-3 line-clamp-2">{{ $beverage->description }}</p>
                  @endif

                  <!-- Meta Info -->
                  <div class="flex items-center justify-between text-xs text-slate-400">
                    <span>Added {{ $beverage->created_at->format('M d, Y') }}</span>
                    @if($beverage->updated_at != $beverage->created_at)
                      <span>Updated {{ $beverage->updated_at->diffForHumans() }}</span>
                    @endif
                  </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-2">
                  <a href="{{ route('admin.beverages.edit', $beverage) }}"
                     class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white py-2 px-3 rounded-xl text-center font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-sm">
                    <i class="fas fa-edit mr-1"></i> Edit
                  </a>
                  <form action="{{ route('admin.beverages.destroy', $beverage) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white py-2 px-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg text-sm delete-btn"
                            data-beverage-name="{{ $beverage->name }}">
                      <i class="fas fa-trash mr-1"></i> Delete
                    </button>
                  </form>
                </div>

                <!-- Quick View Button -->
                <button class="absolute top-4 right-4 w-8 h-8 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition-all duration-300 quick-view-btn"
                        data-beverage='@json($beverage)'>
                  <i class="fas fa-eye text-sm"></i>
                </button>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Pagination -->
        @if($beverages->hasPages())
          <div class="flex justify-center">
            <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 px-6 py-4">
              {{ $beverages->links() }}
            </div>
          </div>
        @endif
      @else
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-16 text-center">
          <div class="w-24 h-24 bg-white/5 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fas fa-coffee text-4xl text-slate-400"></i>
          </div>
          <h3 class="text-2xl font-bold text-white mb-4">No Beverages Found</h3>
          <p class="text-slate-400 text-lg mb-8">Start building your beverage menu by adding your first drink</p>
          <a href="{{ route('admin.beverages.create') }}" class="inline-flex items-center space-x-3 bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-600 hover:to-blue-600 text-white px-8 py-4 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 shadow-lg">
            <i class="fas fa-plus"></i>
            <span>Add First Beverage</span>
          </a>
        </div>
      @endif
    </div>
  </div>
</div>

<!-- Quick View Modal -->
<div id="quickViewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
  <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-8 max-w-md w-full mx-4 transform transition-all duration-300 scale-95">
    <div class="flex items-center justify-between mb-6">
      <h3 class="text-xl font-bold text-white">Beverage Details</h3>
      <button id="closeModal" class="w-8 h-8 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-all duration-300">
        <i class="fas fa-times text-sm"></i>
      </button>
    </div>

    <div id="modalContent" class="space-y-4">
      <!-- Content will be populated by JavaScript -->
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

/* Line clamp for descriptions */
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Custom pagination styles */
.pagination {
  @apply flex space-x-2;
}

.pagination .page-link {
  @apply px-4 py-2 bg-white/10 border border-white/20 rounded-lg text-white hover:bg-white/20 transition-all duration-300;
}

.pagination .page-item.active .page-link {
  @apply bg-gradient-to-r from-cyan-500 to-blue-500 border-cyan-500;
}

.pagination .page-item.disabled .page-link {
  @apply opacity-50 cursor-not-allowed;
}

/* Modal animations */
.modal-enter {
  opacity: 0;
  transform: scale(0.95);
}

.modal-enter-active {
  opacity: 1;
  transform: scale(1);
  transition: opacity 300ms, transform 300ms;
}

.modal-exit {
  opacity: 1;
  transform: scale(1);
}

.modal-exit-active {
  opacity: 0;
  transform: scale(0.95);
  transition: opacity 300ms, transform 300ms;
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

  // Quick view modal functionality
  const modal = document.getElementById('quickViewModal');
  const modalContent = document.getElementById('modalContent');
  const closeModal = document.getElementById('closeModal');

  document.querySelectorAll('.quick-view-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const beverage = JSON.parse(this.dataset.beverage);
      showQuickView(beverage);
    });
  });

  function showQuickView(beverage) {
    modalContent.innerHTML = `
      <div class="text-center mb-6">
        <div class="w-20 h-20 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fas fa-glass-water text-white text-3xl"></i>
        </div>
        <h4 class="text-2xl font-bold text-white mb-2">${beverage.name}</h4>
        <div class="px-4 py-2 bg-gradient-to-r from-green-500/20 to-teal-500/20 text-green-400 rounded-full text-lg font-bold border border-green-500/30 inline-block">
          IDR ${new Intl.NumberFormat('id-ID').format(beverage.price)}
        </div>
      </div>

      <div class="space-y-4">
        ${beverage.category ? `
        <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/10">
          <span class="text-slate-300">Category</span>
          <span class="px-3 py-1 bg-blue-500/20 text-blue-400 rounded-full text-sm font-semibold border border-blue-500/30">${beverage.category}</span>
        </div>
        ` : ''}

        ${beverage.description ? `
        <div class="p-3 bg-white/5 rounded-xl border border-white/10">
          <span class="text-slate-300 text-sm block mb-2">Description</span>
          <p class="text-white">${beverage.description}</p>
        </div>
        ` : ''}

        <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl border border-white/10">
          <span class="text-slate-300">Added</span>
          <span class="text-white">${new Date(beverage.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })}</span>
        </div>
      </div>

      <div class="flex space-x-3 mt-6">
        <a href="/admin/beverages/${beverage.id}/edit" class="flex-1 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white py-3 px-4 rounded-xl text-center font-semibold transition-all duration-300">
          <i class="fas fa-edit mr-2"></i>Edit
        </a>
      </div>
    `;

    modal.classList.remove('hidden');
    modal.classList.add('flex');
    modal.querySelector('.bg-white\\/10').classList.add('modal-enter');

    setTimeout(() => {
      modal.querySelector('.bg-white\\/10').classList.remove('modal-enter');
      modal.querySelector('.bg-white\\/10').classList.add('modal-enter-active');
    }, 10);
  }

  function hideModal() {
    const modalBox = modal.querySelector('.bg-white\\/10');
    modalBox.classList.remove('modal-enter-active');
    modalBox.classList.add('modal-exit-active');

    setTimeout(() => {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      modalBox.classList.remove('modal-exit-active');
    }, 300);
  }

  closeModal.addEventListener('click', hideModal);
  modal.addEventListener('click', function(e) {
    if (e.target === modal) {
      hideModal();
    }
  });

  // Enhanced delete confirmation
  document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {
      e.preventDefault();
      const form = this.closest('form');
      const beverageName = this.dataset.beverageName;

      // Create custom confirm dialog
      const confirmModal = document.createElement('div');
      confirmModal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm';
      confirmModal.innerHTML = `
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl border border-white/20 p-8 max-w-md w-full mx-4">
          <div class="text-center">
            <div class="w-16 h-16 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-exclamation-triangle text-red-400 text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold text-white mb-4">Delete Beverage</h3>
            <p class="text-slate-300 mb-2">Are you sure you want to delete</p>
            <p class="text-white font-semibold mb-6">"${beverageName}"?</p>
            <p class="text-slate-400 text-sm mb-8">This action cannot be undone.</p>
            <div class="flex space-x-4">
              <button type="button" class="flex-1 bg-white/10 hover:bg-white/20 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-300" onclick="this.closest('.fixed').remove()">
                Cancel
              </button>
              <button type="button" class="flex-1 bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white py-3 px-4 rounded-xl font-semibold transition-all duration-300" onclick="submitDelete()">
                Delete
              </button>
            </div>
          </div>
        </div>
      `;

      confirmModal.querySelector('[onclick="submitDelete()"]').addEventListener('click', function() {
        form.submit();
      });

      document.body.appendChild(confirmModal);
    });
  });
});
</script>
@endsection
