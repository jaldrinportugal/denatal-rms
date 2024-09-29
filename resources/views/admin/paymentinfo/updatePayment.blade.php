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
        <h4><i class="fa-solid fa-money-bill"></i> Update Payment</h4>
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
    <form method="post" action="{{ route('admin.updatedPayment', $payment->id) }}"  class="w-1/2 mx-auto bg-white rounded-lg shadow-md p-10">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="patient" class="font-semibold">Patient</label>
            <input type="text" class="w-full rounded-lg focus:ring-2 shadow-sm" id="patient" name="patient" value="{{ old('patient', $payment->patient) }}" required>
        </div>
        <div class="mb-4">
            <label for="description" class="font-semibold">Description</label>
            <input type="text" class="w-full rounded-lg focus:ring-2 shadow-sm" id="description" name="description" value="{{ old('description', $payment->description) }}" required>
        </div>
        <div class="mb-4 form-inline">
            <label for="amount" class="font-semibold">Amount</label>
            <input type="number" class="w-full rounded-lg focus:ring-2 shadow-sm" id="amount" name="amount" value="{{  old('amount', $payment->amount) }}" required>
        </div>
        <div class="mb-4 form-inline">
            <label for="balance" class="font-semibold balance">Balance</label>
            <input type="number" class="w-full rounded-lg focus:ring-2 shadow-sm" id="balance" name="balance" value="{{ old('balance', $payment->balance) }}" required>
        </div>
        <div class="mb-4">
            <label for="date" class="font-semibold">Date</label>
            <input type="date" class="w-full rounded-lg focus:ring-2 shadow-sm" id="date" name="date" value="{{  old('date', $payment->date) }}" required>
        </div>
        <div class="text-right">
            <button type="submit" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white"><i class="fa-solid fa-pen-to-square"></i> Save</button>
            <a href="{{ route('admin.paymentinfo') }}" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800"><i class="fa-regular fa-rectangle-xmark"></i> Cancel</a>
        </div>
    </form>
</body>
</html>

@section('title')
    Update Payment
@endsection

</x-app-layout>