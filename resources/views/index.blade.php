<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Import Excel File</title>
</head>
<body class="text-center">
<div class="container py-5">
    <div class="row justify-content-md-center">
        <div class="table-responsive col-md-8">
            <div class="row">
                <div class="col">
                    <h3 class="mb-3 mt-3">Import file</h3>
                    <form enctype="multipart/form-data" action="/" method="post">
                        @csrf
                        @error('file')
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                        @enderror
                        @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                        @endif
                        @if(session()->has('error'))
                        <div class="alert alert-danger">
                            errors: {{ session()->get('error') }}
                        </div>
                        @endif
                        @if(session()->has('Inserted'))
                        <div class="alert alert-success">
                            Inserted : {{ session()->get('Inserted') }}
                        </div>
                        @endif
                        @if(session()->has('Duplicates'))
                        <div class="alert alert-danger">
                            Duplicates in file : {{ session()->get('Duplicates') }}
                        </div>
                        @endif
                        @if(session()->has('IncorrectRow'))
                        <div class="alert alert-danger">
                            IncorrectRows : {{ session()->get('IncorrectRow') }}
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" name="file" id="file">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            <div class="row justify-content-md-center mt-3">
                <a href="/example/catalog_for_test.xlsx">
                    Download file example
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>
