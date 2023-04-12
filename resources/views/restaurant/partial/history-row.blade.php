@foreach ($reservations as $reservation)
    <tr>
        <td>{{ $reservation->id }}</td>
        <td>{{ $reservation->user->full_name }}</td>
        <td>{{ $reservation->table->seats }}</td>
        <td>{{ $reservation->reservation_date_time }}</td>
        <td>{{ $reservation->created_at }}</td>
        <td>{{ (($reservation->trashed()) ? "Rejected" : "Accepted") }}</td>
    </tr>
@endforeach
