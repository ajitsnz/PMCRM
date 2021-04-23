@if ($errors->any())
    <div class="alert alert-danger p-0">
        <ul>
            <li>{{ $errors->first() }}</li>
        </ul>
    </div>
@endif
