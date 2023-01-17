<x-app-layout>
    @if (session('status'))
        <div class="bg-green-500 text-white py-2 px-4 rounded-lg p-4" id="status-message">
            {{ session('status') }}
        </div>
    @endif
    <div class="flex justify-end p-4">
        <a href="{{route('article.create')}}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full my-2">
            Add Article
        </a>
    </div>
        <div class="flex flex-col">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Body</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Highest  Bid (DHs)</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                        </tr>
                        </thead>

                        <tbody class="bg-white">
                        @foreach ($articles as $article)
                            <tr>
                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            @if (count($article->images) > 0)
                                                <img class="h-8 w-8 rounded-full" src="{{Storage::url($article->images->get(0)->image_path)}}" alt="" />
                                            @else
                                                <img class="h-8 w-8 rounded-full" src="https://via.placeholder.com/150" alt="" />
                                            @endif
                                        </div>

                                        <div class="ml-4">
                                            <a class="text-sm leading-5 font-medium text-gray-900hover:text-blue-700 hover:underline" href="{{route('article.show', ['article' => $article])}}">{{$article->title}}</a>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <div class="text-sm leading-5 text-gray-900">{{$article->body}}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $article->status == 'pending' ? 'orange' : 'green' }}-100 text-{{ $article->status == 'pending' ? 'orange' : 'green' }}-600">{{strtoupper($article->status)}}</span>
                                </td>

                                <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">{{$article->highestBid()}}</td>

                                <td class="px-6 py-4 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">
                                    <a href="{{route('article.edit', ['article' => $article->id])}}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</x-app-layout>
