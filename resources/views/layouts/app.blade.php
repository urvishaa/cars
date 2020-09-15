<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
   <head>
    @include('partials.head')
</head>
</head>
<body class="hold-transition skin-blue sidebar-mini">

<div id="wrapper">

@include('partials.headeradm')
@include('partials.sidebaradm')
@include('partials.javascripts')


   <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            @if(isset($siteTitle))
                <h3 class="page-title">
                    {{ $siteTitle }}
                </h3>
            @endif

            <div class="row">
                <div class="col-md-12">

                    @if (Session::has('message'))
                        <div class="alert alert-info">
                            <p>{{ Session::get('message') }}</p>
                        </div>
                    @endif
                    
                    @if (Session::has('errormessage'))
                        <div class="alert alert-danger">
                            <p>{{ Session::get('errormessage') }}</p>
                        </div>
                    @endif

                    @if ($errors->count() > 0)
                        <div class="alert alert-danger">
                            <ul class="list-unstyled">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')

                </div>
            </div>
        </section>
    </div>
</div>



</body>
</html>