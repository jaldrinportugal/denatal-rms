<x-app-layout>

    <div class="container">
        <h4>Add Record</h4>

        @if(session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('admin.record.store') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="patientlist_id" value="{{ $patientlist->id }}">

    
    <div class="mb-3">
        <label for="file" class="form-label">File</label>
        <input type="file" class="form-control" id="file" name="file" required>
    </div>

    <button type="submit" class="btn btn-primary">Upload File</button>
</form>

    </div>

@section('title')
    Add Record
@endsection

</x-app-layout>