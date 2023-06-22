
Shorten URL
<div class="card-body">
    <form id="shorten-form" action="{{ url('/shorten') }}" method="POST">
        {{ csrf_field() }}

        <div class="form-group row">
            <label for="url" class="col-sm-3 col-form-label">URL:</label>
            <div class="col-sm-9">
                <input type="text" name="url" id="url" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" value="{{ old('url') }}" required autofocus>

                @if ($errors->has('url'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('url') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-3">
                <button type="submit" class="btn btn-primary btn-block">
                    Shorten
                </button>
            </div>
        </div>
    </form>

    <hr>

    <div class="latest-links">
        <h4>Latest Links:</h4>

        <ul>
            @foreach ($links as $link)
                <li><a href="{{ url($link->code) }}" target="_blank">{{ url($link->code) }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
</div>
</div>
</div>
</div>

<script>
$(function() {
$('#shorten-form').on('submit', function(event) {
event.preventDefault();

$.ajax({
type: $(this).attr('method'),
url: $(this).attr('action'),
data: $(this).serialize(),
dataType: 'json',
success: function(response) {
    $('.latest-links ul').prepend('<li><a href="' + response.shortened_url + '" target="_blank">' + response.shortened_url + '</a></li>');
    $('#url').val('');
},
error: function(response) {
    console.log(response);
}
});
});
});
</script>
