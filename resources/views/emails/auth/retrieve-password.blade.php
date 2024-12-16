<html>
<head></head>
<body>
    <div class="">
        <p>Ciao {{ $user->name }} {{ $user->surname }} ,</p>
        <p>qui sotto puoi trovare la tua nuova password per accedere a {{ $adminOptions['web_application_name'] }} all’indirizzo web</p>
        <p><a href='{{ $adminOptions['web_application_url'] }}'>{{ $adminOptions['web_application_url'] }}</a></p>
        <p>
            username: {{ $user->username }}<br>
            password: {{ $password }}
        </p>
    </div>
    
    <div>
        <p>Il team di {{ isset($adminOptions['web_application_name']) ? $adminOptions['web_application_name'] : '' }}</p>
        {!! isset($adminOptions['email_footer_text']) ? $adminOptions['email_footer_text'] : '' !!}
        <p>
            <a href="{{URL::to('/')}}">
                {{ isset($adminOptions['web_application_name']) ? $adminOptions['web_application_name'] : '' }}
            </a>
        </p>
        <p>
            <img src="{{URL::to((isset($adminOptions['email_logo_url']) ? $adminOptions['email_logo_url'] : '' ))}}" alt="{{ isset($adminOptions['web_application_name']) ? $adminOptions['web_application_name'] : '' }}">
        </p>
    </div>

</body>
</html>