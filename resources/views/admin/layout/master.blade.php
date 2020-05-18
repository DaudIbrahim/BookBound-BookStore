<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang="en">
<head>
    @include('admin.partials.head')
</head>
<body>
    <div id="wrapper">

        @include('admin.partials.navhorizontal')

        @include('admin.partials.navvertical')

        <div id="page-wrapper">

            @include('admin.partials.breadcrumb')

            @include('admin.partials.content')

        </div> <!-- /. PAGE WRAPPER  -->

    </div> <!-- /. WRAPPER  -->

    @include('admin.partials.scripts')
</body>
</html>
