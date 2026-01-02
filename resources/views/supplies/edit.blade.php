<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Supply</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow col-md-8 mx-auto">
        <div class="card-header bg-white"><h4>Edit Supplement</h4></div>
        <div class="card-body">
            <form action="{{ route('supplies.update', $supply->supply_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Product Name</label>
                    <input type="text" name="title" class="form-control" value="{{ $supply->title }}" required>
                </div>
                <div class="mb-3">
                    <label>Category</label>
                    <select name="category" class="form-select">
                        <option value="Protein" {{ $supply->category == 'Protein' ? 'selected' : '' }}>Protein</option>
                        <option value="Vitamins" {{ $supply->category == 'Vitamins' ? 'selected' : '' }}>Vitamins</option>
                        <option value="Pre-workout" {{ $supply->category == 'Pre-workout' ? 'selected' : '' }}>Pre-workout</option>
                        <option value="Gear" {{ $supply->category == 'Gear' ? 'selected' : '' }}>Gear/Equipment</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label>Source Link (Optional)</label>
                    <input type="text" name="source" class="form-control" value="{{ $supply->source }}">
                </div>
                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="3" required>{{ $supply->description }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>