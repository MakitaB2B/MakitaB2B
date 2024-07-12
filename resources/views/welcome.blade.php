<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form method="GET" action="/" enctype="multipart/form-data">

<div class="row mb-3">
    <label for="avatar" class="col-md-4 col-form-label text-md-end">{{ __('Avatar') }}</label>

    <div class="col-md-6">
        <input id="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar" required autocomplete="avatar">

        @error('avatar')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

</form>
</body>
</html>