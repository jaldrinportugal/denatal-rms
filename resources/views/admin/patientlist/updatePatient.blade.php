<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
</head>
<body class="min-h-screen bg-gray-200" style="margin: 0; padding: 0;">
    
    <div style="background-color: #4b9cd3; box-shadow: 0 2px 4px rgba(0,0,0,0.4);" class="header py-4 px-6 flex justify-between items-center text-white text-2xl font-semibold mb-10">
        <h4><i class="fa-solid fa-user-pen"></i> Update Patient</h4>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('admin.updatedPatient', $patient->id) }}"  class="w-1/2 mx-auto bg-white rounded-lg shadow-md p-10">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="font-semibold">Patient Name</label>
            <input type="text" class="w-full rounded-lg focus:ring-2 shadow-sm" id="name" name="name" value="{{ old('name', $patient->name) }}" required>
        </div>
        <div class="mb-4">
            <label for="gender" class="font-semibold">Gender</label>
            <select  class="w-full rounded-lg focus:ring-2 shadow-sm" style="width:30%;" id="gender" name="gender" value="{{ old('gender', $patient->gender) }}" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
                
            <label for="age" class="font-semibold age">Age</label>
            <input type="number" class="w-full rounded-lg focus:ring-2 shadow-sm" style="width:30%;" id="age" name="age" value="{{ old('age', $patient->age) }}" required>
        </div>
        <div class="mb-4">
            <label for="phone" class="font-semibold">Phone No.</label>
            <input type="number" class="w-full rounded-lg focus:ring-2 shadow-sm" id="phone" name="phone" value="{{  old('phone', $patient->phone) }}" required>
        </div>
        <div class="mb-4">
            <label for="address" class="font-semibold">Address</label>
            <input type="text" class="w-full rounded-lg focus:ring-2 shadow-sm" id="address" name="address" value="{{  old('address', $patient->address) }}" required>
        </div>
        <div class="text-right">
            <button type="submit" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white"><i class="fa-solid fa-user-pen"></i> Save</button>
            <a href="{{ route('admin.patientlist') }}" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800"><i class="fa-regular fa-rectangle-xmark"></i> Cancel</a>
        </div>
    </form>
</body>
</html>

@section('title')
    Update Patient
@endsection

</x-app-layout>