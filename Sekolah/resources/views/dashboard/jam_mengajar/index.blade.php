@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
<div class="title-content">
    
</div>
<div class="card">
    <table id="tbl">
        <thead>
            <tr>
                <th>No</th>
                @foreach (array_slice($tableColumns, 1, -2) as $item)
                <th>{{str_replace('Jam Mengajar', '', ucwords(str_replace('_', ' ', $item)))}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <td></td>
        </tbody>
    </table>
</div>
@endsection