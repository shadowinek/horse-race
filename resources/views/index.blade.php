@extends('layout')

@section('navbar')
    <div class="navbar-expand float-right">
        <form method="POST" action="{{ route('progress') }}" class="form-inline my-2 float-right ml-2">
            <button type="submit" class="btn btn-outline-success">Progress</button>
        </form>
        <form method="POST" action="{{ route('generate') }}" class="form-inline my-2 float-right ml-2">
            <button type="submit" class="btn btn-outline-primary">Create new race</button>
        </form>
    </div>
@endsection

@section('content')
<div class="row mt-5">
    <div class="col-8">
        <h4 class="text-primary">Races In Progress</h4>
        @foreach ($races as $race)
            <div class="card mb-3">
                <div class="card-header font-weight-bold bg-primary text-white">{{ $race->name }} on {{$race->length}}m (Running for {{ date('i:s', $race->current_step * config('default.progress_step_size')) }})</div>
                <table class="table table-striped mb-0 table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="400">Horse Name</th>
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
                                <td>{{ round($distances[$position]) }}m</td>
                                <td>@if($distances[$position] >= $race->length) @horse_time_format($horse->time) @else - @endif</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
    <div class="col-4">
        <h4 class="text-success">Fastest Horse Ever</h4>
        @if($fastestHorse)
            <div class="card">
                <div class="card-header font-weight-bold text-white bg-success">{{ $fastestHorse->name }}</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><span class="font-weight-bold">Speed: </span>{{ $fastestHorse->speed / 10 }}</li>
                    <li class="list-group-item"><span class="font-weight-bold">Strength: </span>{{ $fastestHorse->strength / 10 }}</li>
                    <li class="list-group-item"><span class="font-weight-bold">Endurance: </span>{{ $fastestHorse->endurance / 10 }}</li>
                    <li class="list-group-item"><span class="font-weight-bold">Race: </span>{{ $fastestHorse->race->name }}</li>
                    <li class="list-group-item"><span class="font-weight-bold">Race time: </span>@horse_time_format($fastestHorse->time)</li>
                </ul>
            </div>
        @endif
    </div>
</div>

<div class="row mt-5">
    <div class="col-8">
        <h4 class="text-info">Last {{ config('default.last_results_races') }} Results</h4>
        @foreach ($lastRaces as $race)
            <div class="card mb-3">
                <div class="card-header font-weight-bold bg-info text-white">{{ $race->name }} on {{$race->length}}m ({{ $race->updated_at->format('m.d.Y H:i:s') }})</div>
                <table class="table table-striped mb-0 table-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="500">Horse Name</th>
                            <th>Finish Time</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($race->horses()->orderBy('time')->limit(config('default.last_results_horses'))->get() as $position => $horse)
                        <tr>
                            <td>{{ $position+1 }}</td>
                            <td>{{ $horse->name }}</td>
                            <td>@horse_time_format($horse->time)</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach

    </div>
</div>


@endsection
