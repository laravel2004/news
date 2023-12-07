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
    <div class="flex gap-8 items-center justify-between">
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
          {{ __('Detail Berita') }}
      </h2>
      <a href="{{ route('dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Back </a>
    </div>
  </x-slot>

  <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900 dark:text-gray-100">
                  <h1 class="text-3xl text-center font-bold">{{ $post->title }}</h1>
                  <div class="flex justify-between">
                    <div class="flex flex-col gap-4 mt-10">
                      <span class="text-sm ">Author :{{ $post->user->name }}</span>
                      <span class="text-sm ml-4 text-slate-500 ">Created at :{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    @if (Auth::user()->id == $post->user_id)    
                      <div class="flex gap-2"> 
                        <a href="{{ route('posts.edit', $post) }}" class="bg-blue-500 h-10 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit </a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="bg-red-500 h-10 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete </button>
                        </form>
                      </div>
                    @endif
                  </div>
                  <div class="mt-5 flex flex-col items-center justify-center">
                    <img class="rounded-t-lg" src="{{ asset('/storage/post/'.$post->image) }}" alt="{{ asset('/storage/post/'.$post->image) }}" />
                    <div>
                      {!! $post->content !!}
                    </div>
                  </div>
              </div>
              <div class="p-6 text-gray-900 dark:text-gray-300">
                <form action="{{ route('comment') }}" method="POST" >
                  @csrf
                  <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                      <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                          <label for="comment" class="sr-only">Your comment</label>
                          <textarea id="comment" name="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Write a comment..." required></textarea>
                          <input type="hidden" name="post_id" value="{{ $post->id }}"/>
                          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"/>
                      </div>
                      <div class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600">
                          <button type="submit" class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                              Post comment
                          </button>
                      </div>
                  </div>
                </form>
                <p class="ms-auto text-xs text-gray-500 dark:text-gray-400">Remember, contributions to this topic should follow our <a href="#" class="text-blue-600 dark:text-blue-500 hover:underline">Community Guidelines</a>.</p>

                <h1 class="text-3xl text-center font-bold">Comments</h1>
                <div class="bg-white dark:bg-gray-800 flex flex-col gap-4 overflow-hidden shadow-sm sm:rounded-lg">
                  @foreach ($comments as $comment)
                      <div class="flex flex-col gap-4 p-2 shadow-sm mb-2 bg-slate-300">
                        <span class="text-sm ">{{ $comment->user->name }}</span>
                        <span class="text-sm ml-2 text-slate-500 ">Created at :{{ $comment->created_at->diffForHumans() }}</span>
                        <div class="mt-1">
                          {{ $comment->comment }}
                        </div>
                      </div>
                  @endforeach
                </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>