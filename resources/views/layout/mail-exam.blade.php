<!DOCTYPE html>
<html>
    <head>
        <style>
            table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <table style="width:100%">
            <tr>
                <th>{{ trans('admins/exams/names.label_form.subject_exam') }}</th>
                <th>{{ trans('admins/exams/names.label_form.user_name') }}</th>
                <th>{{ trans('admins/exams/names.label_form.name_exam') }}</th>
                <th>{{ trans('admins/exams/names.label_form.result_exam') }}</th>
                <th>{{ trans('admins/names.label.label_created_at') }}</th>
            </tr>
            <tr>
                <td>{{ $subject }}</td>
                <td>{{ $user }}</td>
                <td>{!! $exam !!}</td>
                <td>{{ $result }}</td>
                <td>{{ $start }}</td>
            </tr>
        </table>
    </body>
</html>
