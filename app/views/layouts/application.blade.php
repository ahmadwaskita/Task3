<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ahmad's Images CRUD</title>

        <!-- Bootstrap -->
        <?= javascript_include_tag() ?>
        <?= stylesheet_link_tag() ?>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body style="padding-top:60px;"> 

        <!-- Put Navigation bar here  -->
        <!--bagian navigation-->
        @include('shared.head_nav')

        <!--Put Content website here -->
        <!-- Bagian Content -->
        <div class="container clearfix">

            {{--If there is an error flashdata in session (from form validation), show the first one--}}

            @if(Session::has('errors'))
            <h3 class="error">{{$errors->first()}}</h3>
            @endif

            {{--If there is an error flashdata in session which is set manually, then show it--}}

            @if(Session::has('error'))
            <h3 class="error">{{Session::get('error')}}</h3>
            @endif

            {{--If have a success message to show, print it--}}

            @if(Session::has('success'))
            <h3 class="error">{{Session::get('success')}}</h3>
            @endif

            <div class="row">
                @yield("content")
            </div>
            
        </div>

        </div>
    </body>
</html>
