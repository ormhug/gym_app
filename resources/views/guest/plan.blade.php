<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Personal Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .navbar-brand { font-weight: bold; letter-spacing: 1px; }
    </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5 shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="{{ route('dashboard') }}">GYM HELPER</a> <div class="d-flex align-items-center">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm me-3">← Back to Dashboard</a>

        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                <i class="fa-solid fa-list"></i> Guest User 
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><span class="dropdown-item-text text-muted small">Your Code: <b>{{ $currentGuest->session_token }}</b></span></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="{{ route('guest.logout') }}">Logout</a></li>
            </ul>
        </div>
    </div>
  </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card shadow border-dark">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center bg-dark">
                    <h4 class="mb-0">My Personal Plan</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="text-primary border-bottom pb-2">My Exercises</h5>
                            @if($currentGuest->exercises->count() > 0)
                                <ul class="list-group mt-3">
                                    @foreach($currentGuest->exercises as $myEx)
                                        <li class="list-group-item d-flex align-items-center">
                                            <div style="width: 30%; min-width: 100px;">
                                                <strong>{{ $myEx->title }}</strong> <br>
                                                <small class="text-muted">{{ $myEx->muscle_group }}</small>
                                            </div>

                                            <div class="flex-grow-1 mx-3 text-muted small border-start ps-3" 
                                                 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $myEx->description ?? 'No description' }}
                                            </div>

                                            <div>
                                                <a href="{{ route('guest.toggle.exercise', $myEx->exercise_id) }}" class="btn btn-sm btn-outline-danger">Remove</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="alert alert-light mt-3">
                                    Your exercise plan is empty. <a href="{{ route('dashboard') }}">add some</a>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-6 mt-4 mt-md-0">
                            <h5 class="text-success border-bottom pb-2">My Supplements</h5>
                            @if($currentGuest->supplies->count() > 0)
                                <ul class="list-group mt-3">
                                    @foreach($currentGuest->supplies as $mySup)
                                        <li class="list-group-item d-flex align-items-center">
                                            <div style="width: 30%; min-width: 100px;">
                                                <strong>{{ $mySup->title }}</strong> <br>
                                                <small class="text-muted">{{ $mySup->category }}</small>
                                            </div>

                                            <div class="flex-grow-1 mx-3 text-muted small border-start ps-3" 
                                                 style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                {{ $mySup->description ?? 'No description' }}
                                            </div>

                                            <div>
                                                <a href="{{ route('guest.toggle.supply', $mySup->supply_id) }}" class="btn btn-sm btn-outline-danger">Remove</a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="alert alert-light mt-3">
                                    Empty. <a href="{{ route('dashboard') }}">add products</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>