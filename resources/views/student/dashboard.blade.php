 <!DOCTYPE html>
    <html lang="en">
<head>
        <title>Student</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    </head>
<body>
        <div class="container mt-4">
           

<div class="container mt-5">
    <div class="card shadow-lg rounded-lg p-4">
        <h2 class="text-center text-primary">Welcome to the Student Dashboard!</h2>
      @if (session('success'))
    <div class="alert alert-success" id="successMessage">
        {{ session('success') }}
    </div>
@endif

@php
    $studentId = session('student_id');
@endphp



        <div class="text-center mt-4">
            <!-- Add Student Button -->
            <a href="{{ route('students.create') }}" class="btn btn-success btn-lg me-3">
                <i class="fas fa-user-plus"></i> Add Student
            </a>
 <div class="container mt-4">
           

            <!-- Search Form -->
            <form method="GET" action="{{ route('student.dashboard') }}" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search Record..." value="{{ request()->query('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>

            <!-- Buttons to Add New Book and Reset Search -->
           
            <a href="{{ route('student.dashboard') }}" class="btn btn-secondary mb-3">Reset</a>

            <!-- Books Table -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Class</th>
                        <th>Roll No</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->father_name }}</td>
                            <td>{{ $student->class }}</td>
                            <td>{{ $student->roll_number }}</td>
                            <td>{{ $student->phone }}</td>
                            <td>{{ $student->email }}</td>
                            

                           
                            <td>
                                <!-- Display the image if available -->
                                @if($student->image)
                                    <img src="{{ asset('images/' . $student->image) }}" alt="Book Image" style="width: 50px; height: auto;">
                                @else
                                    No Image
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('students.show', $student->id) }}" class="btn btn-info">View</a>
                                <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning">Edit</a>
                                <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this student?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            {{ $students->appends(request()->query())->links() }}
        </div>
           <a href="{{ route('student.logout') }}">Logout</a>
        </div>
    </div>
</div>
 </div>

    </body>
    </html>



<script>
       
        setTimeout(function() {
            let successMessage = document.getElementById('successMessage');
            let errorMessage = document.getElementById('errorMessage');
            
            if (successMessage) {
                successMessage.style.display = 'none';
            }
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 1000); 
    </script>

