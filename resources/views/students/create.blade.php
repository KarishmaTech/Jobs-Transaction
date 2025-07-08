
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Record</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
</head>
<body>

<div class="container mt-3">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h2>Add New Record</h2>
    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Personal Information -->
                            <h5 class="text-primary">Personal Information</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Father's Name</label>
                                        <input type="text" name="father_name" class="form-control" placeholder="Enter father's name" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Class</label>
                                        <input type="text" name="class" class="form-control" placeholder="Enter class" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Roll Number</label>
                                        <input type="text" name="roll_number" class="form-control" placeholder="Enter roll number" required>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <h5 class="text-primary mt-3">Contact Information</h5>
                             <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email" required value="{{ old('email') }}">
                                    @error('email')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter phone number" required value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                            <!-- Upload Image -->
                            <div class="mb-3">
                                <label class="form-label">Upload Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-success w-100">Submit</button>
                        </form>

</div>

</body>
</html>
