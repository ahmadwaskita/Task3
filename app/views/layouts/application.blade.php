<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ahmad's Images CRUD</title>
        <style type="text/css">
            #demo{
                position:relative;
                max-width: 100%;
                z-index: 0;
            }

            img{
                width: 100%;
                max-width: 100%;
                height: auto;
            }

            .white-panel{
                position: absolute;
                background: white;
                box-shadow: 0px 1px 2px rgba(0,0,0,0.3);
                padding: 10px;
            }

            .white-panel h1{
                font-size: 1em;
            }

            .white-panel h1 a {
                color: #A92733;
            }

            .white-panel:hover{
                box-shadow: 1px 1px 10px rgba(0,0,0,0.5);
                margin-top: -5px;
                -webkit-transition:all 0.3s ease-in-out;
                -moz-transition:all 0.3s ease-in-out;
                -o-transition:all 0.3 ease-in-out;
                transition:all 0.3s ease-in-out;
            }
        </style>

        <!-- Bootstrap -->
        <?= javascript_include_tag() ?>
        <?= stylesheetLinkTag() ?>

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
            <div class="row row-offcanvas row-offcanvas-left ">
                <!--Bagian Kiri-->


                <!--Bagian Kanan-->
                <div id="main-content" class="col-xs-12 col-sm-9 main pull-right">
                    <div class="panel-body">

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

                        <section id="demo">
                            @yield("content")
                        </section>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                $('#demo').pinterest_grid({
                    no_columns: 4,
                    padding_x: 10,
                    padding_y: 10,
                    margin_bottom: 50,
                    single_column_breakpoint: 700
                });
            });
        </script>

    </body>
</html>
