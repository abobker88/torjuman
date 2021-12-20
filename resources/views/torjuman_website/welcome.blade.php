<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="torjuman_public/css/bootstrap.min.css" rel="stylesheet">
        <link href="torjuman_public/css/style.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    </head>
    <body>
      @include('torjuman_homepage_sections.header')
      @include('torjuman_homepage_sections.hero')
      @include('torjuman_homepage_sections.aboutus')
      @include('torjuman_homepage_sections.services')
      @include('torjuman_homepage_sections.features')
      @include('torjuman_homepage_sections.everythingincluded')
      @include('torjuman_homepage_sections.footer')

      

<script src="torjuman_public/js/script.js"></script>
    </body>
</html>
