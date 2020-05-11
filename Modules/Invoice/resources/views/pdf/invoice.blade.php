<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
</head>
<body>

<h1>{{ trans('Invoice::invoice.invoice') }}</h1>

<p>
company: <strong>{{ $billingContact->company }}</strong><br>
name: <strong>{{ $billingContact->name }}</strong><br>
surname: <strong>{{ $billingContact->surname }}</strong><br>
street: <strong>{{ $billingContact->street }}</strong><br>
zip: <strong>{{ $billingContact->zip }}</strong><br>
city: <strong>{{ $billingContact->city }}</strong>
</p>

</body>
</html>
