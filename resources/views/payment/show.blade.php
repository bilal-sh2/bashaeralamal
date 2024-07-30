@extends('layouts.index')

@section('content')

<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="text-center mb-4">صفحة بيانات الدفعات المالية للطالب</h1>
            <div class="container">
        @if ($message = Session::get('success'))
            <div class="alert alert-primary" role="alert">
                {{$message}}

            </div>
        @endif
            <div class="card mb-3">
                <div class="card-header" style="font-size: 24px;">Student Information</div>
                <div class="card-body" style="font-size: 18px;">
                    <p><strong>اسم الطالب:</strong> {{ $payments->first()->student->name }}</p>
                    <p><strong>رقم الطالب:</strong> {{ $payments->first()->student->id }}</p>
                    <p><strong>المتبقي:</strong> {{ $remainingAmount }}</p>
                    <p><strong>المبلغ المدفوع الكلي:</strong> {{ $totalPaidAmount }}</p>
                </div>
            </div>

            @foreach ($payments as $payment)
                <div class="card mb-3">
                    <div class="card-header" style="font-size: 24px;">Payment Details</div>
                    <div class="card-body" style="font-size: 18px;">
                        <p><strong>المبلغ المدفوع:</strong> {{ $payment->amount }}</p>
                        <p><strong>تاريخ الدفع :</strong> {{ $payment->payment_date }}</p>
                        <p><strong>ملاحظات:</strong> {{ $payment->notes ?? 'N/A' }}</p>
                        <p><strong>اسم المستلم:</strong> {{ $payment->user ?? 'N/A' }}</p>
                        <p><strong>نوع الدفعة:</strong> {{ $payment->payment_type ?? 'N/A' }}</p>
                    </div>
                    <div class="card-footer">
                        <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="d-inline" id="deleteForm{{$payment->id}}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger deleteButton" data-payment-id="{{$payment->id}}">حذف</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.deleteButton').forEach(item => {
        item.addEventListener('click', event => {
            var paymentId = item.getAttribute('data-payment-id');
            if (confirm('هل أنت متأكد من رغبتك في حذف هذه الدفعة؟')) {
                document.getElementById('deleteForm'+paymentId).submit();
            }
        });
    });
</script>

@endsection
