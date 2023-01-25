@extends('layouts.mobile')

@section('content')
	<!--start of page content, add your stuff here-->
	<div class="page-content header-clear-medium" >
		<div class="card card-style">
			<div class="content mb-3">
				<h1>
					Categories
				</h1>
			</div>
		</div>

        @foreach($categories as $category)
        <div data-menu="menu-change-category" class='card card-style' @click="$dispatch('setcategory', {'category': {{Js::from($category)}} })">
            <div class="content mb-3">
                <div class="row">
                    <div class="col">
                        <h1>
                            {{$category->text}}
                        </h1>
                    </div>
                    @if ($category->id === $activeCategory)
                        <div class="col-1 float-end align-self-end">
                            <i class="fa fa-check-circle color-green-dark fa-2x"></i>
                        </div>
                        <div class="col-3 float-end align-self-end">
                            <h1>
                                Active
                            </h1>
                        </div>
                    @else
                        <div class="col-3 float-end align-self-end">
                            <h1>
                                {{($category->price === 0) ? "Free" : $category->price}}
                            </h1>
                        </div>
                    @endif
                        
                </div>
            </div>
		</div>
        @endforeach
	</div>

@endsection

@section('popups')
<!-- menu-delete -->
	<div id="menu-change-category" class="menu menu-box-bottom menu-box-detached rounded-m" data-menu-effect="menu-over" data-menu-height="300" x-data="{'category': {'text': '', 'price': 0}}" @setcategory.window="category = $event.detail.category" >
        <div class="menu-title mt-n1">
            <h1 x-text="category.text">x-data title</h1>
			<p class="color-theme opacity-50" x-text="category.blurb">x-data blurb</p>
			<a href="#" class="close-menu"><i class="fa fa-times"></i></a>
		</div>
		<div class="content mb-0 mt-2">
            <form action="{{route('setCategory')}}" method="POST">
                @csrf
                <div class="divider mb-3"></div>
                <p class="mb-3">
                    Start using the <p x-text="category.text"></p> package?
                </p>
                <input type="hidden" id="category_id" name="category_id" x-model="category.id">
                <button type="submit" class="btn btn-l mx-auto rounded-sm btn-full bg-green-dark text-uppercase font-800">Change Category</button>
            </form>
		</div>
	</div>
@endsection