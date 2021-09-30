<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Advertisements
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form class="row gx-3 gy-2 align-items-center">
                        <div class="col-sm-3">
                            <div class="input-group">
                                <div class="input-group-text">Category </div>
                                <select class="form-control" name="category" id="category">
                                    <option value="">[ALL]</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if(request()->query('category') == $category->id ) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <div class="input-group-text">Title</div>
                                <input type="text" class="form-control" name="title" id="titulo" placeholder="Title" value="{{request()->query('title')}}">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="visually-hidden" for="description">Description</label>
                            <div class="input-group">
                              <div class="input-group-text">Description</div>
                              <input type="text" class="form-control" name="description" id="description" placeholder="Description" value="{{request()->query('description')}}">
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="row">
                        @foreach ($products as $product)
                        <div class="col-md-4 my-2">
                            <div class="card">
                                <img src="{{ url('img/' . $product->image) }}" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text text-justify">{{ substr($product->description, 0, 150) }}</p>
                                    <span class="badge rounded-pill bg-success">PRICE $ {{  $product->price }}</span>
                                    <div class="d-grid gap-2 mt-4">
                                        <a href="{{ $product->slug }}"
                                            target="_blank"
                                            class="btn btn-primary btn-full">Show more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
