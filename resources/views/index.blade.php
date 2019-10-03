@extends('layout')

@section('content')
<div class="row mt-5">
    <div class="col-12">
        <form method="POST" action="{{ route('generate') }}">
            <button type="submit" class="btn btn-primary">Create new race</button>
        </form>
        <form method="POST" action="{{ route('progress') }}">
            <button type="submit" class="btn btn-success">Progress</button>
        </form>
    </div>
</div>


<div class="row mt-5">
    <div class="col-8">
        <h5>Actual Races</h5>
        @foreach ($races as $race)
            <h6>{{ $race->name }} on {{$race->length}}m (step: {{ $race->current_step }})</h6>
            <table class="table">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Name</th>
                        <th>Distance</th>
                        <th>Finish Time</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $distances = [];
                        $times = [];
                        $horses = [];

                        foreach ($race->horses as $horse) {
                           $horses[] = $horse;
                           $distances[] = $horse->calculateDistance($race->current_step);
                           $times[] = $horse->time;
                        }

                        array_multisort($distances, SORT_DESC, $times, SORT_ASC, $horses);
                    @endphp

                    @foreach($horses as $position => $horse)
                        <tr>
                            <td>{{ $position+1 }}</td>
                            <td>{{ $horse->name }}</td>
                            <td>{{ $distances[$position] }}m</td>
                            {{-- @todo Make better time formating and move it to helper --}}
                            <td>@if($distances[$position] >= $race->length) {{  date('i:s', $horse->time/100) }}.{{ $horse->time%100 }} @else - @endif</td>
                        </tr>
                        @php
                            $position++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
    <div class="col-4">
        <h3>Fastest Horse Ever</h3>
        <div class="card">
            <div class="card-header">{{ $fastestHorse->name }}</div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Speed: </strong>{{ $fastestHorse->speed / 10 }}</li>
                <li class="list-group-item"><strong>Strength: </strong>{{ $fastestHorse->strength / 10 }}</li>
                <li class="list-group-item"><strong>Endurance: </strong>{{ $fastestHorse->endurance / 10 }}</li>
                <li class="list-group-item"><strong>Race: </strong>{{ $fastestHorse->race->name }}</li>
                <li class="list-group-item"><strong>Race time: </strong>{{ date('i:s', $fastestHorse->time/100) }}.{{ $fastestHorse->time%100 }}</li>
            </ul>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        <h5>Last {{ config('default.last_results_races') }} Results</h5>
        @foreach ($lastRaces as $race)
            <h6>{{ $race->name }} on {{$race->length}}m</h6>
            <table class="table">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Name</th>
                        <th>Finish Time</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($race->horses()->orderBy('time')->limit(config('default.last_results_horses'))->get() as $position => $horse)
                    <tr>
                        <td>{{ $position+1 }}</td>
                        <td>{{ $horse->name }}</td>
                        <td>{{  date('i:s', $horse->time/100) }}.{{ $horse->time%100 }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endforeach

    </div>
</div>


@endsection
