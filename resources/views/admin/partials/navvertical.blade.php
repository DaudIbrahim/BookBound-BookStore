<!-- NAV-VERTICAL  -->
<nav class="navbar-default navbar-side" role="navigation">
   <div class="sidebar-collapse">
      <ul class="nav" id="main-menu">
         {{-- ReferenceWeb - https://laraveldaily.com/how-to-check-current-url-or-route/ --}}

         {{-- Categories --}}
         <li>
            <a href="" class="waves-effect waves-dark">
               <i class="fa fa-sitemap"></i>Categories<span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level {{ route::is('admin.categories.*') ? "collapse in" : "" }}">
               <li>
                  <a href="{{ route('admin.categories.index') }}" class="{{ route::is('admin.categories.index') ? "active-menu" : ""}}">
                     <i class="fa fa-file" aria-hidden="true"></i>All Categories
                  </a>
               </li>
               <li>
                  <a href="{{ route('admin.categories.create') }}" class="{{ route::is('admin.categories.create') ? "active-menu" : ""}}">
                     <i class="fa fa-plus" aria-hidden="true"></i>Create New Category
                  </a>
               </li>
            </ul>
         </li>

         {{-- Subcategories --}}
         <li>
            <a href="" class="waves-effect waves-dark">
               <i class="fa fa-sitemap"></i>Subcategories<span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level {{ route::is('admin.subcategories.*') ? "collapse in" : "" }}">
               <li>
                  <a href="{{ route('admin.subcategories.index') }}" class="{{ route::is('admin.subcategories.index') ? "active-menu" : ""}}">
                     <i class="fa fa-file" aria-hidden="true"></i>All Subcategories
                  </a>
               </li>
               <li>
                  <a href="{{ route('admin.subcategories.create') }}" class="{{ route::is('admin.subcategories.create') ? "active-menu" : ""}}">
                     <i class="fa fa-plus" aria-hidden="true"></i>Create New Subcategory
                  </a>
               </li>
            </ul>
         </li>

         {{-- Books --}}
         <li>
            <a href="" class="waves-effect waves-dark">
               <i class="fa fa-book"></i>Books<span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level {{ route::is('admin.books.*') ? "collapse in" : "" }}">
               <li>
                  <a href="{{ route('admin.books.index') }}" class="{{ route::is('admin.books.index') ? "active-menu" : ""}}">
                     <i class="fa fa-file" aria-hidden="true"></i>All Books
                  </a>
                  <a href="{{ route('admin.books.search') }}" class="{{ route::is('admin.books.search') ? "active-menu" : ""}}">
                     <i class="fa fa-search-plus" aria-hidden="true"></i>Search/Add Book
                  </a>
               </li>
            </ul>
         </li>


         {{-- Areas --}}
         <li>
            <a href="" class="waves-effect waves-dark">
               <i class="fa fa-sitemap"></i>Areas<span class="fa arrow"></span>
            </a>
            <ul class="nav nav-second-level {{ route::is('admin.areas.*') ? "collapse in" : "" }}">
               <li>
                  <a href="{{ route('admin.areas.index') }}" class="{{ route::is('admin.areas.index') ? "active-menu" : ""}}">
                     <i class="fa fa-file" aria-hidden="true"></i>All Areas
                  </a>
               </li>
               <li>
                  <a href="{{ route('admin.areas.create') }}" class="{{ route::is('admin.areas.create') ? "active-menu" : ""}}">
                     <i class="fa fa-plus" aria-hidden="true"></i>Add New Area
                  </a>
               </li>
            </ul>
         </li>


         <li>
            <a class= "{{ route::is('admin.') ? "active-menu" : ""}} waves-effect waves-dark" href="{{ route('admin.') }}">
             <i class="fa fa-fw fa-file"></i> Test
            </a>
          </li>

      </ul>
   </div>
</nav>
<!-- /. NAV-VERTICAL -->
