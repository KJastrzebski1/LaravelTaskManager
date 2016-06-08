@extends ('layouts.app')

@section ('content')

<div class="container">
    <div class="page-header">
        <h1>About this project<br><small>Technologies used</small></h1>
    </div>
    <div class="about">
        <p>
            This is project which I've made while learning <strong>Laravel 5</strong>. I've begun with Task Manager from tutorial on 
            <a href="http://laravel.com">Laravel.com</a>. Back then it had only Task Controller and Model with some views. I added
            Project logic so we can group tasks. After that I went even further and create Organizations. Every single of them can define Roles
            with specific capabilities. CEO of organization can assign those roles to members which will give them certain abilities.
        </p>
        <p>
            As you can see I didn't invest much time in CSS. The only file I made for styling has 15 lines. Everything else here is 
            <a href="http://getbootstrap.com">Bootstrap's</a> job. Of course as I was using Laravel I created views with Blade templating engine.
            
        </p>
        
    </div>
</div>

@endsection