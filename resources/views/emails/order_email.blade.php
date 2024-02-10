<!DOCTYPE html>
<html>
<head>
    <title>Order Placed Successfully</title>
</head>
<body>
    <p>Hello {{$name}},</p>
    
    <p>YOur order has been placed successfully. Please find attached the invoice for your order.</p>
    
    <p>Thank you for choosing our services.</p>
    
    <p>Best regards,<br> {{config('Site.title') ?? ''}}</p>
</body>
</html>
