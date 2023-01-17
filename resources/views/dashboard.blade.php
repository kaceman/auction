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
    <section id="auction-listing" class="grid grid-cols-4 gap-4 p-4">
        @foreach ($articles as $article)
            <article class="bg-white rounded-lg shadow-md col-span-1" id="article-id-{{$article->id}}">
                @if (count($article->images) > 0)
                    <img src="{{Storage::url($article->images->get(0)->image_path)}}" class="w-full h-72 object-cover rounded-lg" alt="Auction Item">
                @else
                    <img src="https://via.placeholder.com/150" class="w-full rounded-lg" alt="Auction Item">
                @endif
                <div class="flex flex-col justify-between">
                    <div class="p-2 flex-1">
                        <h2 class="text-lg font-medium py-2">{{ $article->title }}</h2>
                        <p>{{ $article->body }}</p>
                    </div>
                    <label for="bid-value" class="p-2">Highest Bid:
                        <p class="bid-value">{{ $article->highestBid() }} DHs</p>
                    </label>
                    @auth()
                        <div class="p-2 flex justify-between items-center">
                            <x-time-component :time="$article->end_time" :article-id="$article->id"></x-time-component>
                            <button class="bg-blue-500 text-white px-4 py-2 rounded-lg ease-in-out open-modal" data-min-price="{{$article->highestBid()}}" data-article-id="{{$article->id}}">Bid</button>
                        </div>
                    @endauth

                </div>
            </article>
        @endforeach
    </section>

    <!-- Main modal -->
        <div id="bid-modal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!--
              Background backdrop, show/hide based on modal state.

              Entering: "ease-out duration-300"
                From: "opacity-0"
                To: "opacity-100"
              Leaving: "ease-in duration-200"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <!--
                      Modal panel, show/hide based on modal state.

                      Entering: "ease-out duration-300"
                        From: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        To: "opacity-100 translate-y-0 sm:scale-100"
                      Leaving: "ease-in duration-200"
                        From: "opacity-100 translate-y-0 sm:scale-100"
                        To: "opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    -->
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <!-- Heroicon name: outline/exclamation-triangle -->
                                    <svg class="h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ddd" aria-hidden="true">
                                        <path d="M12 8V8.5M12 12V16M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" stroke="rgb(59 130 246)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
{{--                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />--}}
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Please insert your bid</h3>
                                    <div class="mt-2">
                                        <input type="number" value="" data-article-id="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="button" class="inline-flex w-full justify-center rounded-md border border-transparent bg-blue-500 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm bid">Bid</button>
                            <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm cancelBid">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
