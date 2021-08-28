<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Admin</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    {{ \App\Libraries\Layout::addCSSToView() }}

</head>

<body class="light">
        
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>
    
    {{ \App\Libraries\Layout::addJSToView() }}

</body>

</html>