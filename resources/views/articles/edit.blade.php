<x-app-layout>
    <div class="bg-white p-6 rounded-lg mt-6">
        <h2 class="text-2xl font-medium">Update the article</h2>

        <div class="carousel">
            @foreach($article->images as $key => $image)
                <img src="{{Storage::url($image->image_path)}}" alt="">
            @endforeach
        </div>

        <form method="POST" action="{{ route('article.update', ['article' => $article->id]) }}"
              enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="title">Title</label>
                <input class="border border-gray-400 p-2 w-full" id="title" type="text" name="title" required
                       value="{{$article->title}}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="body">Body</label>
                <textarea class="border border-gray-400 p-2 w-full" id="body" name="body" rows="3"
                          required>{{$article->body}}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="min_price">Min Price</label>
                <input class="border border-gray-400 p-2 w-full" id="min_price" type="number" name="min_price" required
                       value="{{$article->min_price}}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="end_time">End Auction</label>
                <input class="border border-gray-400 p-2 w-full" id="end_time" type="datetime-local" name="end_time"
                       required value="{{$article->end_time}}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2" for="images">Images</label>
                <input class="border border-gray-400 p-2 w-full" id="images" type="file" name="images[]" multiple>
            </div>
            <div class="text-center mt-4">
                <button class="bg-indigo-500 text-white py-2 px-4 rounded-lg hover:bg-indigo-600">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>

