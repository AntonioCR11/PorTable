@foreach ($reservations as $reservation)
    {{-- An active reservation card, create a card with this template --}}
    <div id="reservation-{{ $reservation->id }}" class="reservation">
        <div class="card">
            <div class="card-body">
                {{-- The time of the supposed reservation --}}
                <h5 class="card-title">{{ $reservation->reservation_date_time }}</h5>
                <div class="card-text mb-3">
                    <p class="m-0">Reserver: {{ Str::substr($reservation->user->full_name, 0, 25) . ((Str::length($reservation->user->full_name) > 25) ? "..." : "") }}</p>
                    <p class="m-0">Table: {{ $reservation->table->seats }}</p>
                </div>
                {{-- The responds button to mark a reservation as filled or not --}}
                <div class="text-end">
                    <a href="{{ url("/restaurant/reject/$reservation->id") }}" class="btn btn-danger">Reject</a>
                    <a href="{{ url("/restaurant/confirm/$reservation->id") }}" class="btn btn-primary">Attended</a>
                </div>
            </div>
        </div>
    </div>
@endforeach
