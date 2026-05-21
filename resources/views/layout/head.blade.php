<title>@yield('title') | Arsip Digital</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<link rel="icon" type="image/x-icon" href="{{ url('images/favicon.ico') }}">

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
<link rel="stylesheet" href="{{ asset('fonts/tabler-icons.min.css') }}">
<link rel="stylesheet" href="{{ asset('fonts/feather.css') }}">
<link rel="stylesheet" href="{{ asset('fonts/fontawesome.css') }}">
<link rel="stylesheet" href="{{ asset('fonts/material.css') }}">
<link rel="stylesheet" href="{{ asset('css/style.css') }}" id="main-style-link">
<link rel="stylesheet" href="{{ asset('css/style-preset.css') }}">

@stack('css')
