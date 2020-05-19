@extends('admin.layout.master')

@section('page-header')
    All Books
@endsection

@section('content')
<div class="row">
   <div class="col-md-6">
      <!--   Basic Table  -->
      <div class="card">
          <div class="card-action">
              Total Books: {{ $books->count() }}
          </div>
          <div class="card-content">
              <div class="table-responsive">
                  <table class="table">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Title</th>
                              <th>Subcategory</th>
                              <th>Category</th>
                          </tr>
                      </thead>
                      <tbody>
                           @foreach ($books as $book)
                              <tr>
                                 <td>{{ $book->id }}</td>
                                 <td>
                                    <a href="{{ route('admin.books.show', ["book" => $book->id]) }}">
                                       {{ $book->title }}
                                    </a>
                                 </td>
                                 <td>{{ $book->subcategory->title }}</td>
                                 <td>{{ $book->getCategory()->title }}</td>
                              </tr>
                           @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
      </div>
      <!-- End  Basic Table  -->
  </div>
 </div>
@endsection

@section('javascript')
  
@endsection
