
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Record</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="container mt-3">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
        @endforeach
    @endif

    <h2>Edit Record</h2>
    <form method="POST" action="{{ route('students.update', $student->id) }}" enctype="multipart/form-data">
        @csrf
      
 @method('PUT')
        <div class="mb-3 mt-3">
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                   placeholder="Enter Book Name" value="{{ old('name', $student->name) }}" 
                   name="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="father_name">Father Name</label>
            <input type="text" class="form-control @error('father_name') is-invalid @enderror" 
                   placeholder="Enter Author Name" value="{{ old('father_name', $student->father_name) }}" 
                   name="father_name">
            @error('father_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="class">Class</label>
            <input type="text" class="form-control @error('class') is-invalid @enderror" 
                   placeholder="Enter Comment" value="{{ old('class', $student->class) }}" 
                   name="class">
            @error('class')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

  <div class="mb-3">
            <label for="roll_number">Roll number</label>
            <input type="text" class="form-control @error('roll_number') is-invalid @enderror" 
                   placeholder="Enter Comment" value="{{ old('roll_number', $student->roll_number) }}" 
                   name="roll_number">
            @error('roll_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

         <div class="mb-3">
            <label for="email">Email</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" 
                   placeholder="Enter Comment" value="{{ old('email', $student->email) }}" 
                   name="email">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
 <div class="mb-3">
            <label for="phone">Phone</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                   placeholder="Enter Comment" value="{{ old('phone', $student->phone) }}" 
                   name="phone">
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
       

        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            
            @if($student->image)
                <div class="mb-2">
                    <img src="{{ asset('images/' . $student->image) }}" alt="Current Image" class="img-fluid" style="max-width:50px;">
                </div>
            @else
                <p>No image available</p>
            @endif

            <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" accept="image/*">
            @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
           
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

</body>
</html>
