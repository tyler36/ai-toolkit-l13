<ul>
  @foreach ($tickets as $ticket)
    <li><a href="/ticket/{{$ticket->id}}">{{ $ticket->title }}</a></li>
  @endforeach
</ul>
