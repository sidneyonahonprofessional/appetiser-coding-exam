<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet"> -->
        <!-- <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet"> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@latest/css/materialdesignicons.min.css">
        <!-- <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet"> -->
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" />
    </head>
    <body>
    <?php  
        if(DB::connection()->getDatabaseName())
        {
          echo "conncted sucessfully to database ".DB::connection()->getDatabaseName();
        }
        ?>
        <div id="app">
 
        </div>
    </body>
    <script src="{{ asset('js/app.js') }}"></script>
</html>
