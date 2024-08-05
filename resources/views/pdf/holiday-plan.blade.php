@props(['title', 'description', 'location', 'date', 'participants'])

@use(Carbon\Carbon)

<body style="font-family: sans-serif; padding: 3rem;">
    <center>
        <h1 style="text-transform: uppercase;">Holiday Plan</h1>

        <hr />

        <h1>{{ $title }}</h1>
        <small>{{ $location }} - {{ Carbon::parse($date)->toFormattedDateString() }}</small>
        <p>{{ $description }}</p>

        @if (count($participants) > 0)
            <h2>Participants</h2>
            @foreach ($participants as $participant)
                <p>{{ $participant['name'] }}</p>
            @endforeach
        @endif
    </center>
</body>
