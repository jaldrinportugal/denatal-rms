<x-app-layout>
    <div class="container">
        <h4>Update Patient Record</h4>
        <form method="POST" action="{{ route('admin.record.update', [$patientlist->id, $record->id]) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="file" class="form-label">File</label>
                <input type="file" class="form-control" id="file" name="file">
                <!-- Remove the required attribute if the file is not mandatory -->
            </div>

            <button type="submit" class="btn btn-primary">Update Record</button>
        </form>

        <a href="{{ route('admin.showRecord', $patientlist->id) }}" class="btn btn-secondary mt-3">Back to View Record</a>
    </div>

    @section('title')
        Update Record
    @endsection
</x-app-layout>
