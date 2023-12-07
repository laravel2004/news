@if (session('success'))
  @push('script')
      <script>
          Swal.fire({
              title: "Sukses!",
              text: "{{ session('success') }}",
              icon: "success"
          });
      </script>
  @endpush
@endif
@if (session('error'))
  @push('script')
      <script>
          Swal.fire({
              title: "Terjadi Kesalahan!",
              text: "{{ session('error') }}",
              icon: "error"
          });
      </script>
  @endpush
@endif
<x-app-layout>
  <x-slot name="header">
    <div class="flex gap-8 items-center">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Post Berita Anda') }}
      </h2>
      <a href="{{ route('posts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buat Berita </a>
    </div>
  </x-slot>
  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900 dark:text-gray-100">
                  @if ($posts->count() > 0)    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                      @foreach ($posts as $post)
                          <x-card-post title="{{ $post->title }}" slug="{{ $post->slug }}" image="{{ $post->image }}" url="{{ route('posts.show', $post) }}" />
                      @endforeach
                    </div>
                  @else
                      <div class="text-center">Anda tidak menggunggah berita apapun</div>
                  @endif
              </div>
          </div>
      </div>
  </div>
</x-app-layout>