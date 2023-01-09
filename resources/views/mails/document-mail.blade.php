<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to genex=== test</title>
    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{ asset('/assets/css/demo1/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles -->
</head>
<body>

<div id="" class="">
    <p><strong>Subject:&nbsp;</strong>Welcome to genex</p>
    <p>Dear {{ $mailData['name'] }}</p>
    <p>Dear {{ $mailData['employer_id'] }}</p>
    <p>It is my pleasure to welcome you to the accounting department at XYZ Company. I enjoyed talking with you last week, and am looking forward to seeing you on April 19.</p>
    <p>When you arrive, you’ll see Nick in the reception area. He’ll take you to get your ID, show you your workspace, and introduce you to the rest of the staff. We’re looking
        forward to working with you.</p>
    <p>Welcome to the team!</p>

    <p>
        @lang('Regards'),<br>
        Team HR <br>
        Genex Infosys Limited<br>
    </p>
</div>

</body>
</html>
