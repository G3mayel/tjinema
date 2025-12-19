@extends('layouts.app')

@section('title', 'Add New Movie - TJINEMA')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center space-x-4 mb-8">
            <a href="{{ route('admin.movies.index') }}" class="text-gray-400 hover:text-white transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-white mb-2">Add New Movie</h1>
                <p class="text-gray-400">Create a new movie for your cinema</p>
            </div>
        </div>

        <div class="bg-gray-800 rounded-lg p-8 animate-card">
            <form method="POST" action="{{ route('admin.movies.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-200 mb-2">Movie Title</label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}" required
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-gray-400">
                            @error('title')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-200 mb-2">Description</label>
                            <textarea id="description" name="description" rows="4" required
                                      class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-gray-400">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="genre" class="block text-sm font-medium text-gray-200 mb-2">Genre</label>
                                <select id="genre" name="genre" required
                                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white">
                                    <option value="">Select Genre</option>
                                    <option value="Action" {{ old('genre') == 'Action' ? 'selected' : '' }}>Action</option>
                                    <option value="Adventure" {{ old('genre') == 'Adventure' ? 'selected' : '' }}>Adventure</option>
                                    <option value="Comedy" {{ old('genre') == 'Comedy' ? 'selected' : '' }}>Comedy</option>
                                    <option value="Drama" {{ old('genre') == 'Drama' ? 'selected' : '' }}>Drama</option>
                                    <option value="Horror" {{ old('genre') == 'Horror' ? 'selected' : '' }}>Horror</option>
                                    <option value="Romance" {{ old('genre') == 'Romance' ? 'selected' : '' }}>Romance</option>
                                    <option value="Sci-Fi" {{ old('genre') == 'Sci-Fi' ? 'selected' : '' }}>Sci-Fi</option>
                                    <option value="Thriller" {{ old('genre') == 'Thriller' ? 'selected' : '' }}>Thriller</option>
                                </select>
                                @error('genre')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="rating" class="block text-sm font-medium text-gray-200 mb-2">Age Rating</label>
                                <select id="rating" name="rating" required
                                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white">
                                    <option value="">Select Rating</option>
                                    <option value="G" {{ old('rating') == 'G' ? 'selected' : '' }}>G (General)</option>
                                    <option value="PG" {{ old('rating') == 'PG' ? 'selected' : '' }}>PG (Parental Guidance)</option>
                                    <option value="13+" {{ old('rating') == '13+' ? 'selected' : '' }}>13+ (Teen)</option>
                                    <option value="17+" {{ old('rating') == '17+' ? 'selected' : '' }}>17+ (Mature)</option>
                                    <option value="21+" {{ old('rating') == '21+' ? 'selected' : '' }}>21+ (Adult)</option>
                                </select>
                                @error('rating')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="duration" class="block text-sm font-medium text-gray-200 mb-2">Duration (minutes)</label>
                                <input type="number" id="duration" name="duration" value="{{ old('duration') }}" min="1" required
                                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-gray-400">
                                @error('duration')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="showing_start" class="block text-sm font-medium text-gray-200 mb-2">Showing Start</label>
                                <input type="date" id="showing_start" name="showing_start" value="{{ old('showing_start') }}" required
                                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white">
                                @error('showing_start')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="showing_end" class="block text-sm font-medium text-gray-200 mb-2">Showing End</label>
                                <input type="date" id="showing_end" name="showing_end" value="{{ old('showing_end') }}" required
                                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white">
                                @error('showing_end')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-200 mb-2">Ticket Price (Rp)</label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" step="1000" required
                                   class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-white placeholder-gray-400">
                            @error('price')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label for="poster" class="block text-sm font-medium text-gray-200 mb-2">Movie Poster</label>
                            <div class="border-2 border-dashed border-gray-600 rounded-lg p-6 text-center hover:border-blue-500 transition-colors cursor-pointer" onclick="document.getElementById('poster').click()">
                                <div id="posterPreview" class="hidden">
                                    <img id="previewImage" src="" alt="Preview" class="w-full h-64 object-cover rounded-lg mb-4">
                                </div>
                                <div id="posterPlaceholder">
                                    <i class="fas fa-image text-4xl text-gray-500 mb-4"></i>
                                    <p class="text-gray-400 mb-2">Click to upload poster</p>
                                    <p class="text-gray-500 text-sm">JPG, PNG up to 5MB</p>
                                </div>
                                <input type="file" id="poster" name="poster" accept="image/*" class="hidden" required onchange="previewPoster(this)">
                            </div>
                            @error('poster')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-700 rounded-lg p-4">
                            <h3 class="text-white font-medium mb-3">Movie Preview</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Title:</span>
                                    <span class="text-white" id="previewTitle">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Genre:</span>
                                    <span class="text-white" id="previewGenre">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Duration:</span>
                                    <span class="text-white" id="previewDuration">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-400">Price:</span>
                                    <span class="text-green-400" id="previewPrice">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-700">
                    <a href="{{ route('admin.movies.index') }}" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                        Create Movie
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewPoster(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
                document.getElementById('posterPreview').classList.remove('hidden');
                document.getElementById('posterPlaceholder').classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('title').addEventListener('input', function() {
        document.getElementById('previewTitle').textContent = this.value || '-';
    });

    document.getElementById('genre').addEventListener('change', function() {
        document.getElementById('previewGenre').textContent = this.value || '-';
    });

    document.getElementById('duration').addEventListener('input', function() {
        const duration = this.value ? this.value + ' min' : '-';
        document.getElementById('previewDuration').textContent = duration;
    });

    document.getElementById('price').addEventListener('input', function() {
        const price = this.value ? 'Rp ' + parseInt(this.value).toLocaleString('id-ID') : '-';
        document.getElementById('previewPrice').textContent = price;
    });

    gsap.from(".animate-card", {
        duration: 1,
        y: 50,
        opacity: 0,
        ease: "power2.out"
    });
</script>
@endsection
