@extends('admin.layout.master')

@section('page-header')
   {{ (session()->get('google_book'))['title'] }} <small>Add Book into your Products?</small>
@endsection

@section('content')
 <div class="row">
   <div class="col-lg-12">

      <div class="card">
         <div class="card-action">
            <a href="{{ url()->previous() }}">
               <span class="material-icons">arrow_back</span>
            </a>            
         </div>

         <div class="card-content">
            <form method="POST" action="{{ route('admin.books.store') }}" class="col s12">

               @csrf
               
               {{-- First Row of 10 Fields generated from session() --}}
               <div class="row">
                  <div class="input-field col s2">
                     {{-- 1. image --}}
                     <input name="" id="image" type="hidden" value="{{ (session()->get('google_book'))['image'] }}" readonly>
                     <img src="{{ session('google_book')['image'] }}" class="img-thumbnail">
                  </div>

                  <div class="input-field col s9">
                     <div class="row">

                        {{-- 2. title --}}
                        <div class="input-field col s4">
                           <input name="" id="title" type="text" value="{{ (session()->get('google_book'))['title'] }}" readonly>
                           <label for="title" class="active" style="font-size: 80%">Title</label>
                        </div>
                        
                        {{-- 3. isbn_10 --}}
                        <div class="input-field col s4">
                           <input name="" id="isbn_10" type="text" value="{{ (session()->get('google_book'))['isbn_10'] }}" readonly>
                           <label for="isbn_10" class="active" style="font-size: 80%">ISBN 10</label>
                        </div>

                        {{-- 4. isbn_13 --}}
                        <div class="input-field col s4">
                           <input name="" id="isbn_13" type="text" value="{{ (session()->get('google_book'))['isbn_13'] }}" readonly>
                           <label for="isbn_13" class="active" style="font-size: 80%">ISBN 13</label>
                        </div>

                        {{-- 5. author --}}
                        <div class="input-field col s4">
                           <input name="" id="author" type="text" value="{{ (session()->get('google_book'))['author'] }}" readonly>
                           <label for="author" class="active" style="font-size: 80%">Author</label>
                        </div>

                        {{-- 6. publisher --}}
                        <div class="input-field col s4">
                           <input name="" id="publisher" type="text" value="{{ (session()->get('google_book'))['publisher'] }}" readonly>
                           <label for="publisher" class="active" style="font-size: 80%">Publisher</label>
                        </div>

                        {{-- 7. published_date --}}
                        <div class="input-field col s4">
                           <input name="" id="published_date" type="text" value="{{ (session()->get('google_book'))['published_date'] }}" readonly>
                           <label for="published_date" class="active" style="font-size: 80%">Published Date</label>
                        </div>

                        {{-- 8. page_count --}}
                        <div class="input-field col s4">
                           <input name="" id="published_date" type="text" value="{{ (session()->get('google_book'))['page_count'] }}" readonly>
                           <label for="page_count" class="active" style="font-size: 80%">Page Count</label>
                        </div>

                        {{-- 9. lang --}}
                        <div class="input-field col s4">
                           <input name="" id="published_date" type="text" value="{{ (session()->get('google_book'))['lang'] }}" readonly>
                           <label for="lang" class="active" style="font-size: 80%">Language</label>
                        </div>

                        {{-- 10. Description --}}
                        <div class="input-field col s4">
                           <input name="" id="description" type="text" 
                              value="{{ str_limit((session()->get('google_book'))['description'], 40, ' . . .') }}" readonly>
                           <label for="description" class="active" style="font-size: 80%">Description</label>
                        </div>

                        {{-- Space --}}
                        <div class="input-field col s12"></div>

                        {{-- A. Category --}}
                        <div class="input-field col s6">
                           <select id="category" name="category" class="form-control" onchange="categoryChange()">
                              @foreach ($categories as $category)
                                 <option value="{{ $category->id }}" {{ (old('category') == $category->id) ? "selected" : "" }}>
                                    {{ $category->title }}
                                 </option>
                              @endforeach
                           </select>
                           <p><label for="description" class="active" style="font-size: 80%">Catgeory</label></p>
                        </div>

                        {{-- B. SubCategory --}}
                        <div class="input-field col s6">
                           <select id="subcategory" name="subcategory" class="form-control"></select>
                           <p><label for="description" class="active" style="font-size: 80%">Subcategory</label></p>
                        </div>

                        <div class="input-field col s12"></div>
                        <div class="input-field col s12"></div>

                        {{-- C. New Book Price and Quantity --}}
                        <div class="input-field col s2">
                           <label for="new_price" style="font-size: 100%">
                              New Book
                           </label>
                        </div>
                        <div class="input-field col s5">
                           <input type="number" name="new_price" id="new_price" 
                              min="100" max="9999" step="50" value="1000" required>
                           <label for="new_price" class="active" style="font-size: 88%">Price</label>
                        </div>
                        <div class="input-field col s5">
                           <input type="number" name="new_quantity" id="new_quantity" 
                              min="5" max="50" step="1" value="5" required>
                           <label for="new_quantity" class="active" style="font-size: 88%">Quantity</label>
                        </div>

                        {{-- D. Used Book Price and Quantity --}}
                        <div class="input-field col s2">
                           <label for="" style="font-size: 100%">
                              Used Book
                           </label>
                        </div>
                        <div class="input-field col s5">
                           <input type="number" name="used_price" id="used_price" 
                              min="100" max="9999" step="50" value="500" required>
                           <label for="used_price" class="active" style="font-size: 88%">Price</label>
                        </div>
                        <div class="input-field col s5">
                           <input type="number" name="used_quantity" id="used_quantity" 
                              min="5" max="50" step="1" value="5" required>
                           <label for="used_quantity" class="active" style="font-size: 88%">Quantity</label>
                        </div>

                        {{-- E. Submit --}}
                        <div class="input-field col s12">
                           <button type="submit" class="btn btn-primary btn-block">
                              Add Book to Products List
                           </button>
                        </div>
                        
                     </div>
                  </div>
               </div>
            </form>
            
            <div class="clearBoth"></div>
         </div>
      </div>
   </div>
<div>


{{-- Errors For My Concerns --}}
<div class="row">
      @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      </div>
  @endif
   
</div>
@endsection

@section('javascript')
<script>

   let category = document.getElementById('category');
   let subcategory = document.getElementById('subcategory');
   let options;

   // Change On Load
   window.onload = function() {
      fetch();
   };

   // Change Category
   function categoryChange() {
      while(subcategory.options.length > 0) {
         subcategory.options.remove(0);
      }
      fetch();
   }

   // Fetch From Server 
   function fetch() {
      axios.get('/administrator/categories/' + category.value + '/fetch')
      .then(response => {
         response.data.data.forEach(element => {
         let option = new Option(element.title, element.id);
         subcategory.appendChild(option);
        });
      })
      .catch((error) => {
        console.dir(error.response.data.status);
      });
   }
</script>

@endsection
