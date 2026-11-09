@extends('layout')

@section('title', 'Nevek - Magyar nevek')

@section('content')

@php
    $hasFilter = collect($filters)->except('pageToken')->contains(fn ($v) => $v !== null && $v !== '');
    $sexLabels = [1 => 'Férfi', 2 => 'Női', 3 => 'Uniszex'];
    $letters = ['A','Á','B','C','D','E','É','F','G','H','I','Í','J','K','L','M','N','O','Ó','Ö','Ő','P','R','S','T','U','Ú','Ü','Ű','V','Z'];
    $groups = [0, 1, 2, 3, 4, 100, 200];
@endphp

<h1>Nevek listája</h1>

<form action="{{ route('names.index') }}" method="GET" class="search-form">
    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Név keresése...">

    <select name="searchIn" onchange="this.form.submit()">
        <option value="name" {{ ($filters['searchIn'] ?? 'name') === 'name' ? 'selected' : '' }}>Csak névben</option>
        <option value="all" {{ ($filters['searchIn'] ?? '') === 'all' ? 'selected' : '' }}>Névben és leírásban</option>
    </select>

    <select name="firstLetter" onchange="this.form.submit()">
        <option value="">Minden kezdőbetű</option>
        @foreach($letters as $letter)
            <option value="{{ $letter }}" {{ ($filters['firstLetter'] ?? '') === $letter ? 'selected' : '' }}>{{ $letter }}</option>
        @endforeach
    </select>

    <select name="sex" onchange="this.form.submit()">
        <option value="">Minden nem</option>
        @foreach($sexLabels as $value => $label)
            <option value="{{ $value }}" {{ (string) ($filters['sex'] ?? '') === (string) $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
    </select>

    <select name="certificate" onchange="this.form.submit()">
        <option value="">Anyakönyvezhetőség</option>
        <option value="true" {{ ($filters['certificate'] ?? '') === 'true' ? 'selected' : '' }}>Anyakönyvezhető</option>
        <option value="false" {{ ($filters['certificate'] ?? '') === 'false' ? 'selected' : '' }}>Nem anyakönyvezhető</option>
    </select>

    <select name="group" onchange="this.form.submit()">
        <option value="">Minden csoport</option>
        @foreach($groups as $group)
            <option value="{{ $group }}" {{ (string) ($filters['group'] ?? '') === (string) $group ? 'selected' : '' }}>{{ $group }}. csoport</option>
        @endforeach
    </select>

    <button type="submit">🔍 Keresés</button>
    @if($hasFilter)
        <a href="{{ route('names.index') }}">✕ Törlés</a>
    @endif
</form>

<table class="table">
    <thead>
        <tr>
            <th>Név</th>
            <th>Nem</th>
            <th>Kiejtés</th>
            <th>Anyakönyvezhető</th>
            <th>Csoport</th>
            <th>Leírás</th>
        </tr>
    </thead>
    <tbody>
        @forelse($names as $name)
            <tr>
                <td><a href="{{ route('names.show', $name['name']) }}">{{ $name['name'] }}</a></td>
                <td>{{ $sexLabels[$name['sex'] ?? 0] ?? '-' }}</td>
                <td>{{ $name['phonetic'] ?? '-' }}</td>
                <td>{{ !empty($name['certificate']) ? '✔' : '✘' }}</td>
                <td>{{ $name['group'] ?? '-' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($name['description'] ?? '', 80) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Nincs találat.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<div id="paginator">
    @if($nextToken)
        <a href="{{ route('names.index', array_merge(request()->except('pageToken'), ['pageToken' => $nextToken])) }}">Következő ➡</a>
    @endif
</div>

@endsection