@extends('admin.layout')

@section('body')

    <div class="flex items-center justify-end">
        <span>PENDING</span>
        <label class="relative inline-block p-2 hover:cursor-pointer">
            <input type="checkbox" class="hidden" id="status-checkbox" data-article-id="{{$article->id}}" value="{{$article->status == 'pending' ? '0' : '1'}}" {{$article->status == 'pending' ? '' : 'checked'}}>
            <span class="relative block w-10 h-6 rounded-full bg-gray-300 shadow-inner">
                <span class="absolute inset-1 flex items-center justify-center w-4 h-4
                rounded-full bg-orange-600 shadow-md transition-all
                duration-200 {{$article->status == 'pending' ? '' : 'active'}} ease-in-out" id="status-button"></span>
            </span>
        </label>
        <span>LIVE</span>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-medium mb-4">{{$article->title}}</h3>

        <div class="carousel">
            @foreach($article->images as $key => $image)
                <img src="{{Storage::url($image->image_path)}}" alt="">
            @endforeach
        </div>

        <p class="text-gray-700 mb-4">{{$article->body}}</p>
        <div class="flex items-center mb-4">
            <div class="text-gray-700 mr-2">Starting Price:</div>
            <div class="text-lg font-medium">{{$article->min_price}}</div>
        </div>
        <div class="flex items-center mb-4">
            <div class="text-gray-700 mr-2">Highest Price:</div>
            <div class="text-lg font-medium">{{$article->highestBid()}}</div>
        </div>
        <div class="flex items-center">
            <div class="text-gray-700 mr-2">Ends:</div>
            <div class="text-lg font-medium">{{$article->end_time}}</div>
        </div>
    </div>
    <div class="bg-white mt-6 p-6 rounded-lg shadow-md">
        <h4 class="text-lg font-medium mb-4">Bid History</h4>
        <table class="w-full text-left table-collapse">
            <thead>
            <tr>
                <th class="text-sm font-medium text-gray-700 p-2 bg-gray-100">Bidder</th>
                <th class="text-sm font-medium text-gray-700 p-2 bg-gray-100">Amount</th>
                <th class="text-sm font-medium text-gray-700 p-2 bg-gray-100">Time</th>
            </tr>
            </thead>
            <tbody>
                @foreach($article->bids as $bid)
                    <tr class="odd:bg-gray-100">
                        <td class="p-2 border-t border-gray-300">{{$bid->user->name}}</td>
                        <td class="p-2 border-t border-gray-300">{{$bid->bid_price}}</td>
                        <td class="p-2 border-t border-gray-300">{{$bid->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
