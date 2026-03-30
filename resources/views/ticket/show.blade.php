Subject: {{ $ticket->title }}<br><br>
Body: {{ $ticket->body }}<br>
Priority: {{ $ticket->priority }}<br>
Status: {{ $ticket->state }}<br>
Department: {{ $ticket->department }}<br>
Sentiment: {{ $ticket->sentiment }}<br>

<form
  method="POST"
  action="{{ route("ticket.ai.triage", ["ticket" => $ticket->id]) }}"
>
  @csrf
  <button>
    Triage
  </button>
</form>
