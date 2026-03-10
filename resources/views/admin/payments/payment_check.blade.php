<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Check</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

<div class="text-center mt-3">
    <select class="form-control-sm bg-transparent changeLang">
        <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>{{ __('lang.english') }}</option>
        <option value="uz" {{ session()->get('locale') == 'uz' ? 'selected' : '' }}>{{ __('lang.uzbek') }}</option>
        <option value="ru" {{ session()->get('locale') == 'ru' ? 'selected' : '' }}>{{ __('lang.russian') }}</option>
        <option value="qq" {{ session()->get('locale') == 'qq' ? 'selected' : '' }}>{{ __('lang.karakalpak') }}</option>
    </select>
</div>

<div style="display: flex;justify-content: center">
    <div style="font-family: Arial, sans-serif; width: 250px">
        <p>****************************************</p>
        <p style="
                                            text-align: center;
                                            ">
            <img
                src="{{ asset('storage/images/'.\App\Models\User::where('role','=',1)->first()->image) }}"
                style="height: 100px"
                alt="">
        </p>
        <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;line-height: 1px">
            <p>{{ __('lang.month') }} :</p>
            <p>{{ $payment->month }}</p>
        </div>
        <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;line-height: 1px">
            <p>{{ __('lang.amount') }}:</p>
            <p>{{ number_format($payment->amount , 0, ',', '.')  }} SUM</p>
        </div>
        <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;line-height: 1px">
            <p>{{ __('lang.discount') }} :</p>
            <p>{{ number_format($payment->discount , 0, ',', '.')  }} SUM</p>
        </div>
        <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;line-height: 1px">
            <p>{{ __('lang.date') }} :</p>
            <p>{{ $payment->date }}</p>
        </div>
        <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;">
            <p>{{ __('lang.student') }} :</p>
            <p>{{ $payment->student }}</p>
        </div>
        <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;">
            <p>{{ __('lang.teacher') }}:</p>
            <p style="text-align: right">{{ $payment->teacher }}</p>
        </div>
        <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;">
            <p>{{ __('lang.group') }}:</p>
            <p style="text-align: right">{{ $payment->group }}</p>
        </div>
        <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;line-height: 1px">
            <p>{{ __('lang.cashbox') }} :</p>
            <p>{{ $payment->kassa }}</p>
        </div>
        <div style="display: flex; justify-content: space-between;margin: 0;padding: 0;">
            <p>Kassir:</p>
            <p style="text-align: right">{{ \App\Models\User::find($payment->user_id)->name }}</p>
        </div>
        <div style="text-align: center">
            <img src="https://quickchart.io/qr?text={{
                                            route("payment_check",$payment->id)
                                            }}">
        </div>
        <p>****************************************</p>
    </div>
</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<script type="text/javascript">

    var url = "{{ route('changeLang') }}";

    $(".changeLang").change(function(){
        window.location.href = url + "?lang="+ $(this).val();
    });

</script>
</body>
</html>
