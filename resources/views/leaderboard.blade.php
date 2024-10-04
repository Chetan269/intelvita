<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard</title>
</head>

<body>
    <h1>Leaderboard</h1>

    <form method="POST" action="{{ route('recalculate') }}">
        @csrf
        <button type="submit">Recalculate Rankings</button>
    </form>

    <form method="GET" action="{{ route('leaderboard') }}">
        <label for="filter">Filter by:</label>
        <select name="filter" id="filter" onchange="this.form.submit()">
            <option value="all" {{  $filter == 'all' ? 'selected' : '' }}>All Time</option>
            <option value="day" {{  $filter == 'day' ? 'selected' : '' }}>Day</option>
            <option value="month" {{  $filter == 'month' ? 'selected' : '' }}>Month</option>
            <option value="year" {{  $filter == 'year' ? 'selected' : '' }}>Year</option>
        </select>
        <h2>Search User</h2>
        <input type="text" name="user_id" placeholder="Enter User ID" value="{{$priorityUserId}}">
        <button type="submit">Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Points</th>
                <th>Rank</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ $user->filtered_points }}</td>
                    <td>#{{ $user->rank }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
