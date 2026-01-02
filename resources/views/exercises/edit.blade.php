<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Exercise</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h4 class="mb-0">Edit Exercise</h4>
                </div>
                <div class="card-body">
                    
                    <form action="{{ route('exercises.update', $exercise->exercise_id) }}" method="POST">
                        @csrf 
                        @method('PUT') <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" value="{{ $exercise->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Muscle Group</label>
                            <input type="text" name="muscle_group" class="form-control" value="{{ $exercise->muscle_group }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Level</label>
                            <select name="level" class="form-select">
                                <option value="Beginner" {{ $exercise->level == 'Beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="Intermediate" {{ $exercise->level == 'Intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="Advanced" {{ $exercise->level == 'Advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" required>{{ $exercise->description }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Update Exercise</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>