<html>
<head>

    <link href="{{ asset('assets/css/@fortawesome/fontawesome-free/css/all.css') }}" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/password-reset.css')}}">
</head>
<body>

<div class="account-verification">
    <table class="account-verification__table">
        <tr>
            <td class="text-center">
                <img src="{{ asset('assets/img/infyom-logo.png') }}" alt="Canvas Logo">
            </td>
        </tr>
        <tr>
            <td>
                <hr class="divider"/>
            </td>
        </tr>
        <tr>
            <td class="text-center">
                <a href="{{$link}}" class="verification-btn">
                    <strong>Reset Password</strong>
                </a>
            </td>
        </tr>
        <tr>
            <td>
                <p>If you did not request a password reset, no further action is required.</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="regards-mb-4">Regards,</p>
                <p class="regards-mt-4">InfyCRM</p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="bottom-text">
                    If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into
                    your web browser: <a href="{{$link}}">{{$link}}</a>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <hr class="divider"/>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
