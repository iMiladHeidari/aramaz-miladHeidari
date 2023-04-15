@component('mail::message')
# Latest Data

Please find below the latest Currency prices [{{ $current_date }}]:

<table>
    <thead>
        <tr>
            <th>Currency</th>
            <th>Value</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($prices_data as $currency => $values)
        <tr>
            <td>{{ $currency }}</td>
            <td>{{ $values['value'] ?? 0 }}</td>
            <td>{{ $values['date'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

If you have any questions or concerns, please do not hesitate to reach out to us.

Thank you.

Regards,<br>
Folani Team
@endcomponent
